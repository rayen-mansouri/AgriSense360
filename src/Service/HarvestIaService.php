<?php
namespace App\Service;

use App\Entity\Culture;
use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * IA Harvest Estimation Service
 *
 * PRIMARY  → Python Flask ML microservice (Random Forest)
 * FALLBACK → Pure PHP agronomic formula
 *
 * The fallback ALWAYS produces a real non-zero result:
 *   - 0 weather days  → weatherFactor = 0.85 (decent conditions assumed)
 *   - On-time harvest → latenessFactor = 1.00 (100%)
 *   - Late harvest    → -2% per day, floor 40%
 *   - Early harvest   → bonus +1% per day early, cap 105% (encourages on-time)
 *
 * The IA NEVER returns 0 for a culture with a valid surface.
 */
class HarvestIaService
{
    /**
     * Base yield kg/m² — tuned for Tunisian climate.
     */
    private const BASE_YIELD_KG_M2 = [
        'Blé'            => 0.35,
        'Maïs'           => 0.90,
        'Riz'            => 0.55,
        'Avoine'         => 0.30,
        'Tomates'        => 8.00,
        'Salades'        => 3.50,
        'Pomme de terre' => 4.00,
        'Carottes'       => 3.50,
        'Oignon'         => 3.00,
        'Lentille'       => 0.25,
        'Pomme'          => 15.00,
        'Pêche'          => 12.00,
        'Orange'         => 18.00,
        'Fraise'         => 4.00,
        'Framboise'      => 2.50,
        'Banane'         => 20.00,
        'Rosier'         => 5.00,
        'Tulipe'         => 8.00,
        'Jasmin'         => 2.00,
        'Laurier-rose'   => 3.00,
    ];

    public function __construct(
        private HttpClientInterface $httpClient,
        private string $flaskUrl = '',   // empty string = Flask disabled (still works via PHP)
    ) {}

    /**
     * Main entry point — NEVER throws, NEVER returns qty=0 for a valid culture.
     *
     * @param Culture $culture
     * @param array   $weatherSummary  from CultureWeatherLogService::buildWeatherSummary()
     * @param int     $logsCount       number of weather logs
     */
    public function compute(Culture $culture, array $weatherSummary, int $logsCount): array
    {
        // Try Flask ML first (only if configured and running)
        if (!empty($this->flaskUrl)) {
            $mlResult = $this->callFlaskService($culture, $weatherSummary);
            if ($mlResult !== null) {
                return $this->enrichMlResult($mlResult, $culture, $weatherSummary, $logsCount);
            }
        }

        // PHP fallback — always works, always non-zero
        return $this->phpFallback($culture, $weatherSummary, $logsCount);
    }

    // ═════════════════════════════════════════════════════════════════════════
    //  ML microservice
    // ═════════════════════════════════════════════════════════════════════════

    private function callFlaskService(Culture $culture, array $ws): ?array
    {
        try {
            $response = $this->httpClient->request('POST', $this->flaskUrl . '/predict', [
                'json' => [
                    'culture_nom'    => $culture->getNom(),
                    'type_culture'   => $culture->getTypeCulture() ?? '',
                    'surface'        => $culture->getSurface() ?? 1,
                    'days_late'      => $culture->getDaysLate(),
                    'total_days'     => $ws['total_days'],
                    'storm_days'     => $ws['storm_days'],
                    'rain_days'      => $ws['rain_days'],
                    'heat_days'      => $ws['heat_days'],
                    'frost_days'     => $ws['frost_days'],
                    'high_hum_days'  => $ws['high_hum_days'],
                    'high_wind_days' => $ws['high_wind_days'],
                    'avg_temp'       => $ws['avg_temp'],
                    'avg_humidity'   => $ws['avg_humidity'],
                    'avg_wind'       => $ws['avg_wind'],
                ],
                'timeout' => 5.0,
            ]);

            if ($response->getStatusCode() !== 200) return null;

            $data = $response->toArray();

            // Sanity check — reject ML result if it gives 0 quantity
            if (empty($data['quantite_kg']) || $data['quantite_kg'] <= 0) return null;

            return $data;

        } catch (\Throwable) {
            return null;
        }
    }

    // ═════════════════════════════════════════════════════════════════════════
    //  Enrich ML result with breakdown
    // ═════════════════════════════════════════════════════════════════════════

    private function enrichMlResult(array $ml, Culture $culture, array $ws, int $logsCount): array
    {
        $nom     = $culture->getNom();
        $surface = $culture->getSurface() ?? 1;

        return [
            'quantite'      => round($ml['quantite_kg'], 2),
            'iaScore'       => round($ml['ia_score'], 1),
            'baseYield'     => round($ml['base_yield'] ?? ((self::BASE_YIELD_KG_M2[$nom] ?? 2.0) * $surface), 2),
            'latenessScore' => round(($ml['lateness_factor'] ?? 1.0) * 100, 1),
            'weatherScore'  => round(($ml['weather_factor'] ?? 1.0) * 100, 1),
            'latenessDays'  => $culture->getDaysLate(),
            'logsCount'     => $logsCount,
            'confidence'    => $this->confidenceLabel($logsCount),
            'source'        => 'ml',
            'breakdown'     => $this->buildBreakdown($culture, $ws),
        ];
    }

    // ═════════════════════════════════════════════════════════════════════════
    //  PHP Fallback — works with ANY situation, NEVER returns 0
    //
    //  Formula:
    //    quantite = baseYield × latenessFactor × weatherFactor
    //
    //    baseYield      = BASE_YIELD_KG_M2[culture_nom] × surface
    //                     (defaults to 2.0 kg/m² for unknown crops)
    //
    //    latenessFactor = on-time     → 1.00
    //                     early (before dateRecolte) → 1.00 (never penalised for being early)
    //                     late 1 day  → 0.98, 2 days → 0.96, ... floor 0.40
    //
    //    weatherFactor  = no data     → 0.85 (decent assumed)
    //                     with data   → 1.0 minus weighted bad-weather proportions
    //                                   floor 0.30
    // ═════════════════════════════════════════════════════════════════════════

    private function phpFallback(Culture $culture, array $ws, int $logsCount): array
    {
        $nom      = $culture->getNom();
        $surface  = max(0.01, $culture->getSurface() ?? 1.0); // never zero
        $baseKgM2 = self::BASE_YIELD_KG_M2[$nom] ?? 2.0;
        $baseYield = $baseKgM2 * $surface;

        // ── Lateness factor ───────────────────────────────────────────────────
        $daysLate       = $culture->getDaysLate();
        $latenessFactor = $daysLate > 0
            ? max(0.40, 1.0 - ($daysLate * 0.02))
            : 1.0;

        // ── Weather factor ────────────────────────────────────────────────────
        if ($ws['total_days'] === 0) {
            // No weather history at all → assume decent conditions (85%)
            $weatherFactor = 0.85;
        } else {
            $n = max(1, $ws['total_days']);
            $weatherFactor = 1.0
                - ($ws['storm_days']     / $n) * 0.30
                - ($ws['heat_days']      / $n) * 0.20
                - ($ws['frost_days']     / $n) * 0.25
                - ($ws['high_hum_days']  / $n) * 0.10
                - ($ws['rain_days']      / $n) * 0.05
                - ($ws['high_wind_days'] / $n) * 0.08;
            $weatherFactor = max(0.30, min(1.0, $weatherFactor));
        }

        // Final quantity — guaranteed > 0 for any surface > 0
        $quantity = round($baseYield * $latenessFactor * $weatherFactor, 2);
        $iaScore  = round($latenessFactor * $weatherFactor * 100, 1);

        // Extra safety: if somehow quantity is 0, use base × 0.5
        if ($quantity <= 0) {
            $quantity = round($baseYield * 0.5, 2);
            $iaScore  = 50.0;
        }

        return [
            'quantite'      => $quantity,
            'iaScore'       => $iaScore,
            'baseYield'     => round($baseYield, 2),
            'latenessScore' => round($latenessFactor * 100, 1),
            'weatherScore'  => round($weatherFactor * 100, 1),
            'latenessDays'  => $daysLate,
            'logsCount'     => $logsCount,
            'confidence'    => $this->confidenceLabel($logsCount),
            'source'        => 'php_fallback',
            'breakdown'     => $this->buildBreakdown($culture, $ws),
        ];
    }

    // ═════════════════════════════════════════════════════════════════════════
    //  Helpers
    // ═════════════════════════════════════════════════════════════════════════

    private function buildBreakdown(Culture $culture, array $ws): array
    {
        $lines    = [];
        $daysLate = $culture->getDaysLate();

        if ($daysLate > 0) {
            $pct     = min(60, $daysLate * 2);
            $lines[] = [
                'icon'   => '⏰',
                'label'  => "Retard de récolte : {$daysLate} jour(s)",
                'impact' => "-{$pct}% sur le rendement",
                'type'   => 'danger',
            ];
        }

        if ($ws['total_days'] === 0) {
            $lines[] = [
                'icon'   => '📊',
                'label'  => 'Aucune donnée météo enregistrée',
                'impact' => 'Calcul basé sur la surface et la date de récolte (conditions moyennes assumées à 85%)',
                'type'   => 'info',
            ];
        } else {
            if ($ws['storm_days'] > 0) {
                $lines[] = ['icon'=>'⛈️','label'=>"{$ws['storm_days']} jour(s) d'orage",'impact'=>'Impact fort (-30% pondéré)','type'=>'danger'];
            }
            if ($ws['frost_days'] > 0) {
                $lines[] = ['icon'=>'🥶','label'=>"{$ws['frost_days']} jour(s) de gel (< 2°C)",'impact'=>'Risque de perte (-25% pondéré)','type'=>'danger'];
            }
            if ($ws['heat_days'] > 0) {
                $lines[] = ['icon'=>'🌡️','label'=>"{$ws['heat_days']} jour(s) de chaleur intense (> 38°C)",'impact'=>'Stress thermique (-20% pondéré)','type'=>'warning'];
            }
            if ($ws['high_hum_days'] > 0) {
                $lines[] = ['icon'=>'🍄','label'=>"{$ws['high_hum_days']} jour(s) d'humidité élevée (> 85%)",'impact'=>'Risque fongique (-10% pondéré)','type'=>'warning'];
            }
            if ($ws['high_wind_days'] > 0) {
                $lines[] = ['icon'=>'💨','label'=>"{$ws['high_wind_days']} jour(s) de vents forts (> 50 km/h)",'impact'=>'Versement possible (-8% pondéré)','type'=>'warning'];
            }
            if ($ws['rain_days'] > 0) {
                $lines[] = ['icon'=>'🌧️','label'=>"{$ws['rain_days']} jour(s) de pluie forte",'impact'=>'Impact modéré (-5% pondéré)','type'=>'info'];
            }
        }

        if (empty($lines)) {
            $lines[] = [
                'icon'   => '✅',
                'label'  => 'Aucun facteur négatif détecté',
                'impact' => 'Conditions idéales — rendement à 100%',
                'type'   => 'success',
            ];
        }

        return $lines;
    }

    private function confidenceLabel(int $logsCount): string
    {
        if ($logsCount === 0)  return 'Estimation de base (surface + lateness)';
        if ($logsCount < 7)   return 'Faible — peu de données météo';
        if ($logsCount < 20)  return 'Modérée';
        if ($logsCount < 50)  return 'Bonne';
        return 'Élevée';
    }
}