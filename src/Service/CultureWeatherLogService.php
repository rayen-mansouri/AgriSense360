<?php
namespace App\Service;

use App\Entity\Culture;
use App\Entity\CultureWeatherLog;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Manages daily weather snapshots for cultures.
 *
 * Called from:
 *   - ParcelleController::show()  — passive logging on page visit
 *   - LogWeatherDailyCommand      — active cron at 13:00 every day
 */
class CultureWeatherLogService
{
    public function __construct(private EntityManagerInterface $em) {}

    /**
     * Save today's weather for a given culture — idempotent (skips if already logged today).
     *
     * @param Culture $culture  The culture to log for
     * @param array   $weather  Array returned by WeatherService::getWeatherForLocation()
     */
    public function logTodayIfMissing(Culture $culture, array $weather): void
    {
        $today = new \DateTime('today');

        // Unique constraint on (culture_id, log_date) protects us, but we check first
        // to avoid a needless INSERT + exception on every page load.
        $exists = $this->em->getRepository(CultureWeatherLog::class)
            ->findOneBy([
                'cultureId' => $culture->getId(),
                'logDate'   => $today,
            ]);

        if ($exists !== null) {
            return; // already logged today — nothing to do
        }

        $log = new CultureWeatherLog();
        $log->setCultureId($culture->getId())
            ->setLogDate($today)
            ->setTempMin((float)($weather['temp_min'] ?? $weather['temp'] ?? 0))
            ->setTempMax((float)($weather['temp_max'] ?? $weather['temp'] ?? 0))
            ->setTempMoy((float)($weather['temp'] ?? 0))
            ->setHumidity((int)($weather['humidity'] ?? 0))
            ->setWindKmh((float)($weather['wind_speed'] ?? 0))
            ->setWeatherId((int)($weather['weather_id'] ?? 800))
            ->setDescription($weather['description'] ?? null);

        // Rainfall — OWM free tier includes rain.1h in some responses
        if (isset($weather['rain_1h'])) {
            $log->setRainfall((float)$weather['rain_1h']);
        }

        $this->em->persist($log);
        $this->em->flush();
    }

    /**
     * Return all weather logs for a culture, ordered by date ascending.
     * Used by HarvestIaService to compute the weather impact score.
     *
     * @return CultureWeatherLog[]
     */
    public function getLogsForCulture(int $cultureId): array
    {
        return $this->em->getRepository(CultureWeatherLog::class)
            ->createQueryBuilder('l')
            ->where('l.cultureId = :cid')
            ->setParameter('cid', $cultureId)
            ->orderBy('l.logDate', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Count how many days were logged for a given culture.
     * Useful to display data confidence in the UI.
     */
    public function countLogsForCulture(int $cultureId): int
    {
        return (int) $this->em->getRepository(CultureWeatherLog::class)
            ->createQueryBuilder('l')
            ->select('COUNT(l.id)')
            ->where('l.cultureId = :cid')
            ->setParameter('cid', $cultureId)
            ->getQuery()
            ->getSingleScalarResult();
    }

    /**
     * Build a summary array of weather stats across all logs.
     * Sent to the Python ML service and displayed in the harvest modal.
     *
     * @param CultureWeatherLog[] $logs
     */
    public function buildWeatherSummary(array $logs): array
    {
        if (empty($logs)) {
            return [
                'total_days'    => 0,
                'storm_days'    => 0,
                'rain_days'     => 0,
                'heat_days'     => 0,
                'frost_days'    => 0,
                'high_hum_days' => 0,
                'high_wind_days'=> 0,
                'avg_temp'      => 20.0,
                'avg_humidity'  => 50,
                'avg_wind'      => 10.0,
            ];
        }

        $stormDays    = 0;
        $rainDays     = 0;
        $heatDays     = 0;
        $frostDays    = 0;
        $highHumDays  = 0;
        $highWindDays = 0;
        $tempSum      = 0.0;
        $humSum       = 0;
        $windSum      = 0.0;

        foreach ($logs as $log) {
            if ($log->isStormDay())       $stormDays++;
            if ($log->isHeavyRainDay())   $rainDays++;
            if ($log->isHeatStressDay())  $heatDays++;
            if ($log->isFrostDay())       $frostDays++;
            if ($log->isHighHumidityDay())$highHumDays++;
            if ($log->isHighWindDay())    $highWindDays++;
            $tempSum += $log->getTempMoy();
            $humSum  += $log->getHumidity();
            $windSum += $log->getWindKmh();
        }

        $n = count($logs);

        return [
            'total_days'    => $n,
            'storm_days'    => $stormDays,
            'rain_days'     => $rainDays,
            'heat_days'     => $heatDays,
            'frost_days'    => $frostDays,
            'high_hum_days' => $highHumDays,
            'high_wind_days'=> $highWindDays,
            'avg_temp'      => round($tempSum / $n, 1),
            'avg_humidity'  => round($humSum  / $n),
            'avg_wind'      => round($windSum / $n, 1),
        ];
    }
}
