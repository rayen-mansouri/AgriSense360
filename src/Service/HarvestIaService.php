<?php
namespace App\Service;

use App\Entity\Culture;
use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * IA Harvest Estimation Service
 *
 * PRIMARY path  → calls the Python Flask ML microservice (Random Forest model).
 * FALLBACK path → pure PHP agronomic formula (used if Flask is down OR not configured).
 *
 * The PHP fallback works with ANY number of weather days (even 0).
 * - 0 weather days  → assumes 85% weather factor (decent conditions)
 * - on-time harvest → 100% lateness factor
 * - late harvest    → -2% per day late, floor at 40%
 */
class HarvestIaService
{
    /**
     * Base yield in kg per m² per culture name.
     * Tuned for Tunisian climate and typical yields.
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
        private string $flaskUrl = '',   // optional — empty string = Flask disabled
    ) {}

    /**
     * Main entry point. Always returns a valid result — never throws.
     *
     * Logic:
     *   1. If $flaskUrl is configured and Flask is reachable → ML prediction
     *   2. Otherwise → PHP formula:
     *        - 0 weather days  → weatherFactor = 0.85 (decent assumed)
     *        - harvest on time → latenessFactor = 1.0  (100%)
     *        - late harvest    → -2%/day, floor 40%
     */
    public function compute(Culture $culture, array $weatherSummary, int $logsCount): array
    {
        // Try Python ML microservice first (only if URL is configured)
        if (!empty($this->flaskUrl)) {
            $mlResult = $this->callFlaskService($culture, $weatherSummary);
            if ($mlResult !== null) {
                return $this->enrichMlResult($mlResult, $culture, $weatherSummary, $logsCount);
            }
        }

        // Always-available PHP fallback
        return $this->phpFallback($culture, $weatherSummary, $logsCount);
    }

    // ═════════════════════════════════════════════════════════════════════════
    //  ML microservice call
    // ═════════════════════════════════════════════════════════════════════════

    private function callFlaskService(Culture $culture, array $ws): ?array
    {
        try {
            $payload = [
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
            ];

            $response = $this->httpClient->request('POST', $this->flaskUrl . '/predict', [
                'json'    => $payload,
                'timeout' => 5.0,
            ]);

            if ($response->getStatusCode() !== 200) {
                return null;
            }

            return $response->toArray();

        } catch (\Throwable) {
            return null; // Flask down or not configured — fall through to PHP
        }
    }

    // ═════════════════════════════════════════════════════════════════════════
    //  Enrich ML result with breakdown text
    // ═════════════════════════════════════════════════════════════════════════

    private function enrichMlResult(array $ml, Culture $culture, array $ws, int $logsCount): array
    {
        return [
            'quantite'      => round($ml['quantite_kg'], 2),
            'iaScore'       => round($ml['ia_score'], 1),
            'baseYield'     => round($ml['base_yield'] ?? ((self::BASE_YIELD_KG_M2[$culture->getNom()] ?? 2.0) * ($culture->getSurface() ?? 1)), 2),
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
    //  Pure PHP fallback — works with ANY number of weather days (even 0)
    // ═════════════════════════════════════════════════════════════════════════

    private function phpFallback(Culture $culture, array $ws, int $logsCount): array
    {
        $nom      = $culture->getNom();
        $surface  = $culture->getSurface() ?? 1.0;
        $baseKgM2 = self::BASE_YIELD_KG_M2[$nom] ?? 2.0;
        $baseYield = $baseKgM2 * $surface;

        // ── 1. Lateness factor ────────────────────────────────────────────────
        // On time (daysLate = 0) → 100%
        // Late                   → -2% per day, minimum 40%
        $daysLate       = $culture->getDaysLate();
        $latenessFactor = $daysLate > 0
            ? max(0.40, 1.0 - ($daysLate * 0.02))
            : 1.0;

        // ── 2. Weather factor ─────────────────────────────────────────────────
        // No weather data at all → assume 85% (decent conditions, slight uncertainty)
        // Any weather data       → calculate from logged bad-weather days
        if ($ws['total_days'] === 0) {
            $weatherFactor = 0.85;
        } else {
            $n = $ws['total_days'];
            $weatherFactor = 1.0;
            $weatherFactor -= ($ws['storm_days']     / $n) * 0.30; // storms: severe
            $weatherFactor -= ($ws['heat_days']      / $n) * 0.20; // heat stress
            $weatherFactor -= ($ws['frost_days']     / $n) * 0.25; // frost: very severe
            $weatherFactor -= ($ws['high_hum_days']  / $n) * 0.10; // fungal risk
            $weatherFactor -= ($ws['rain_days']      / $n) * 0.05; // rain: minor
            $weatherFactor -= ($ws['high_wind_days'] / $n) * 0.08; // wind: moderate
            $weatherFactor = max(0.30, min(1.0, $weatherFactor));
        }

        $quantity = round($baseYield * $latenessFactor * $weatherFactor, 2);
        $iaScore  = round($latenessFactor * $weatherFactor * 100, 1);

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
                'impact' => 'Calcul basé sur la surface et la date de récolte (conditions moyennes assumées)',
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
                'impact' => 'Conditions idéales pendant toute la croissance',
                'type'   => 'success',
            ];
        }

        return $lines;
    }

    private function confidenceLabel(int $logsCount): string
    {
        if ($logsCount === 0)  return 'Estimation basique — surface + date récolte';
        if ($logsCount < 7)   return 'Faible — peu de données météo';
        if ($logsCount < 20)  return 'Modérée';
        if ($logsCount < 50)  return 'Bonne';
        return 'Élevée';
    }
}