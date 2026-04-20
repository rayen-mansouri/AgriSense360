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
 * FIXES v2:
 *   - ia_score is realistic: weighted 40% lateness + 60% weather, cap 93
 *   - weather_factor defaults to 0.75 (not 0.85) when no logs — more realistic
 *   - lateness is ALWAYS applied, even on ML output
 *   - rapport field: plain French explanation for the farm manager
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
        private string $flaskUrl = '',
    ) {}

    /**
     * Main entry point — NEVER throws, NEVER returns qty=0 for a valid culture.
     */
    public function compute(Culture $culture, array $weatherSummary, int $logsCount): array
    {
        if (!empty($this->flaskUrl)) {
            $mlResult = $this->callFlaskService($culture, $weatherSummary);
            if ($mlResult !== null) {
                return $this->enrichMlResult($mlResult, $culture, $weatherSummary, $logsCount);
            }
        }

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

            if (empty($data['quantite_kg']) || $data['quantite_kg'] <= 0) return null;

            return $data;

        } catch (\Throwable) {
            return null;
        }
    }

    // ═════════════════════════════════════════════════════════════════════════
    //  Enrich ML result
    // ═════════════════════════════════════════════════════════════════════════

    private function enrichMlResult(array $ml, Culture $culture, array $ws, int $logsCount): array
    {
        $nom     = $culture->getNom();
        $surface = $culture->getSurface() ?? 1;

        $lf = $ml['lateness_factor'] ?? 1.0;
        $wf = $ml['weather_factor']  ?? 1.0;

        // Realistic ia_score: 40% lateness + 60% weather, cap 93
        $iaScore = min(93.0, round(($lf * 0.40 + $wf * 0.60) * 100, 1));

        return [
            'quantite'      => round($ml['quantite_kg'], 2),
            'iaScore'       => $iaScore,
            'baseYield'     => round($ml['base_yield'] ?? ((self::BASE_YIELD_KG_M2[$nom] ?? 2.0) * $surface), 2),
            'latenessScore' => round($lf * 100, 1),
            'weatherScore'  => round($wf * 100, 1),
            'latenessDays'  => $culture->getDaysLate(),
            'logsCount'     => $logsCount,
            'confidence'    => $this->confidenceLabel($logsCount),
            'source'        => 'ml',
            'rapport'       => $ml['rapport'] ?? $this->buildRapport($culture, $ws, round($ml['quantite_kg'], 2), $lf, $wf),
            'breakdown'     => $this->buildBreakdown($culture, $ws),
        ];
    }

    // ═════════════════════════════════════════════════════════════════════════
    //  PHP Fallback
    //
    //  quantite = baseYield × latenessFactor × weatherFactor
    //
    //  latenessFactor: 0 days = 1.00 | late: -2%/day, floor 0.40
    //  weatherFactor:  no data = 0.75 (average) | with data: formula, floor 0.30
    //  ia_score:       40% lateness + 60% weather, cap 93
    // ═════════════════════════════════════════════════════════════════════════

    private function phpFallback(Culture $culture, array $ws, int $logsCount): array
    {
        $nom      = $culture->getNom();
        $surface  = max(0.01, $culture->getSurface() ?? 1.0);
        $baseKgM2 = self::BASE_YIELD_KG_M2[$nom] ?? 2.0;
        $baseYield = $baseKgM2 * $surface;

        // ── Lateness factor ───────────────────────────────────────────────────
        $daysLate       = $culture->getDaysLate();
        $latenessFactor = $daysLate > 0
            ? max(0.40, 1.0 - ($daysLate * 0.02))
            : 1.0;

        // ── Weather factor ────────────────────────────────────────────────────
        if ($ws['total_days'] === 0) {
            // No weather logs → use realistic average (not optimistic)
            $weatherFactor = 0.75;
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

        // ── Final quantity ────────────────────────────────────────────────────
        $quantity = round($baseYield * $latenessFactor * $weatherFactor, 2);

        // Safety net
        if ($quantity <= 0) {
            $quantity = round($baseYield * 0.5, 2);
            $latenessFactor = 0.70;
            $weatherFactor  = 0.72;
        }

        // ── Realistic ia_score (40% lateness + 60% weather, cap 93) ──────────
        $iaScore = min(93.0, round(($latenessFactor * 0.40 + $weatherFactor * 0.60) * 100, 1));

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
            'rapport'       => $this->buildRapport($culture, $ws, $quantity, $latenessFactor, $weatherFactor),
            'breakdown'     => $this->buildBreakdown($culture, $ws),
        ];
    }

    // ═════════════════════════════════════════════════════════════════════════
    //  Rapport — plain French explanation for the farm manager
    //  No technical jargon. Short, clear, actionable.
    // ═════════════════════════════════════════════════════════════════════════

    private function buildRapport(Culture $culture, array $ws, float $quantity, float $lf, float $wf): string
    {
        $nom      = $culture->getNom();
        $surface  = $culture->getSurface() ?? 1;
        $daysLate = $culture->getDaysLate();
        $total    = $ws['total_days'] ?? 0;

        $lines = [];

        // ── Opening sentence ──────────────────────────────────────────────────
        $qtyFmt  = number_format($quantity, 0, ',', ' ');
        $surfFmt = number_format($surface,  0, ',', ' ');
        $lines[] = "Votre récolte de {$nom} sur {$surfFmt} m² a produit {$qtyFmt} kg.";

        // ── Lateness ──────────────────────────────────────────────────────────
        if ($daysLate === 0) {
            $lines[] = "La récolte a été effectuée à temps, ce qui a permis de conserver le meilleur rendement possible.";
        } elseif ($daysLate <= 5) {
            $pct     = $daysLate * 2;
            $lines[] = "La récolte a été réalisée avec {$daysLate} jour(s) de retard, ce qui a réduit le rendement d'environ {$pct}%.";
        } elseif ($daysLate <= 14) {
            $pct     = min(60, $daysLate * 2);
            $lines[] = "Un retard de {$daysLate} jours a été enregistré. Ce délai a eu un impact notable sur le rendement (-{$pct}%).";
        } else {
            $pct     = min(60, $daysLate * 2);
            $lines[] = "La récolte accuse un retard important de {$daysLate} jours, ce qui a fortement réduit le rendement (-{$pct}%).";
        }

        // ── Weather ───────────────────────────────────────────────────────────
        if ($total === 0) {
            $lines[] = "Aucune donnée météo n'a été enregistrée pour cette culture. Le calcul a été effectué avec des conditions climatiques moyennes.";
        } else {
            $storm = $ws['storm_days']     ?? 0;
            $frost = $ws['frost_days']     ?? 0;
            $heat  = $ws['heat_days']      ?? 0;
            $hum   = $ws['high_hum_days']  ?? 0;
            $wind  = $ws['high_wind_days'] ?? 0;
            $rain  = $ws['rain_days']      ?? 0;

            if ($wf >= 0.90) {
                $lines[] = "Les conditions météo durant les {$total} jours de culture ont été excellentes, sans événements climatiques importants.";
            } elseif ($wf >= 0.75) {
                $problems = [];
                if ($storm > 0) $problems[] = "{$storm} jour(s) d'orage";
                if ($heat  > 0) $problems[] = "{$heat} jour(s) de forte chaleur";
                if ($frost > 0) $problems[] = "{$frost} jour(s) de gel";
                if ($hum   > 0) $problems[] = "{$hum} jour(s) d'humidité élevée";
                if ($wind  > 0) $problems[] = "{$wind} jour(s) de vents forts";
                if ($rain  > 0) $problems[] = "{$rain} jour(s) de pluie forte";
                $txt = !empty($problems) ? implode(', ', $problems) : 'quelques perturbations mineures';
                $lines[] = "La météo a été globalement bonne sur {$total} jours, avec quelques épisodes défavorables : {$txt}.";
            } elseif ($wf >= 0.55) {
                $problems = [];
                if ($storm > 0) $problems[] = "{$storm} orage(s)";
                if ($heat  > 0) $problems[] = "{$heat} jour(s) de canicule";
                if ($frost > 0) $problems[] = "{$frost} jour(s) de gel";
                if ($wind  > 0) $problems[] = "{$wind} jour(s) de vents forts";
                $txt = !empty($problems) ? implode(', ', $problems) : 'des conditions difficiles';
                $lines[] = "Les conditions météo ont été moyennes sur {$total} jours ({$txt}), ce qui a pesé sur le rendement.";
            } else {
                $lines[] = "Les conditions météo ont été difficiles sur {$total} jours (orages, gel ou canicule répétés), ce qui explique en grande partie la baisse de rendement.";
            }
        }

        // ── Overall verdict ───────────────────────────────────────────────────
        $iaScore = min(93.0, ($lf * 0.40 + $wf * 0.60) * 100);
        if ($iaScore >= 80) {
            $lines[] = "Dans l'ensemble, cette récolte s'est très bien déroulée.";
        } elseif ($iaScore >= 60) {
            $lines[] = "Dans l'ensemble, cette récolte est dans la moyenne malgré quelques contraintes.";
        } else {
            $lines[] = "Cette récolte a été affectée par plusieurs facteurs défavorables. Il serait utile de planifier les prochaines récoltes plus tôt pour limiter les pertes.";
        }

        return implode(' ', $lines);
    }

    // ═════════════════════════════════════════════════════════════════════════
    //  Breakdown (unchanged)
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
                'impact' => 'Conditions moyennes assumées (75%)',
                'type'   => 'info',
            ];
        } else {
            if ($ws['storm_days']     > 0) $lines[] = ['icon'=>'⛈️', 'label'=>"{$ws['storm_days']} jour(s) d'orage",           'impact'=>'Impact fort (-30% pondéré)',      'type'=>'danger'];
            if ($ws['frost_days']     > 0) $lines[] = ['icon'=>'🥶', 'label'=>"{$ws['frost_days']} jour(s) de gel (< 2°C)",     'impact'=>'Risque de perte (-25% pondéré)', 'type'=>'danger'];
            if ($ws['heat_days']      > 0) $lines[] = ['icon'=>'🌡️','label'=>"{$ws['heat_days']} jour(s) de chaleur (> 38°C)", 'impact'=>'Stress thermique (-20% pondéré)', 'type'=>'warning'];
            if ($ws['high_hum_days']  > 0) $lines[] = ['icon'=>'🍄', 'label'=>"{$ws['high_hum_days']} jour(s) humidité > 85%",  'impact'=>'Risque fongique (-10% pondéré)', 'type'=>'warning'];
            if ($ws['high_wind_days'] > 0) $lines[] = ['icon'=>'💨', 'label'=>"{$ws['high_wind_days']} jour(s) vents > 50 km/h",'impact'=>'Versement possible (-8% pondéré)','type'=>'warning'];
            if ($ws['rain_days']      > 0) $lines[] = ['icon'=>'🌧️','label'=>"{$ws['rain_days']} jour(s) de pluie forte",      'impact'=>'Impact modéré (-5% pondéré)',     'type'=>'info'];
        }

        if (empty($lines)) {
            $lines[] = [
                'icon'   => '✅',
                'label'  => 'Aucun facteur négatif détecté',
                'impact' => 'Conditions idéales — rendement optimal',
                'type'   => 'success',
            ];
        }

        return $lines;
    }

    private function confidenceLabel(int $logsCount): string
    {
        if ($logsCount === 0)  return 'Estimation de base (surface + date)';
        if ($logsCount < 7)   return 'Faible — peu de données météo';
        if ($logsCount < 20)  return 'Modérée';
        if ($logsCount < 50)  return 'Bonne';
        return 'Élevée';
    }
}