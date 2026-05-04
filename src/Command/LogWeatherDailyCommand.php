<?php
namespace App\Command;

use App\Service\CultureService;
use App\Service\CultureWeatherLogService;
use App\Service\WeatherService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * Daily cron command — run once a day at 13:00 via crontab.
 *
 * Crontab entry (add with: crontab -e):
 *   0 13 * * * /usr/bin/php /var/www/html/bin/console app:log-weather-daily >> /var/log/weather_log.log 2>&1
 *
 * What it does:
 *   For every ACTIVE culture (not yet harvested), fetches today's weather
 *   from OpenWeatherMap using the parcelle's gouvernorat, then saves a
 *   CultureWeatherLog row if one doesn't exist for today.
 *
 * This ensures weather history is captured even when no one visits the parcelle page.
 */
#[AsCommand(
    name: 'app:log-weather-daily',
    description: 'Logs today\'s weather snapshot for all active cultures (run via daily cron)',
)]
class LogWeatherDailyCommand extends Command
{
    // Etats that indicate the culture is still growing
    private const GROWING_ETATS = ['Semis', 'Croissance', 'Maturité', 'Récolte Prévue', 'Récolte en Retard'];

    public function __construct(
        private CultureService           $cultureService,
        private WeatherService           $weatherService,
        private CultureWeatherLogService $weatherLogService,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $io->title('IA Harvest — Daily Weather Logger');

        $cultures = $this->cultureService->getAllCultures();
        $active   = array_filter($cultures, fn($c) => in_array($c->getEtat(), self::GROWING_ETATS, true));

        $io->progressStart(count($active));

        $logged  = 0;
        $skipped = 0;
        $errors  = 0;

        // Group by gouvernorat to avoid duplicate API calls for cultures on the same parcelle
        $weatherCache = [];

        foreach ($active as $culture) {
            $io->progressAdvance();

            try {
                $parcelle     = $culture->getParcelle();
                $localisation = $parcelle->getLocalisation();

                if (!$localisation) {
                    $skipped++;
                    continue;
                }

                // Use cached weather if we already fetched for this gouvernorat today
                if (!isset($weatherCache[$localisation])) {
                    $weatherCache[$localisation] = $this->weatherService->getWeatherForLocation($localisation);
                }

                $weather = $weatherCache[$localisation];

                if (!$weather) {
                    $io->warning("No weather data for gouvernorat: {$localisation}");
                    $skipped++;
                    continue;
                }

                $this->weatherLogService->logTodayIfMissing($culture, $weather);
                $logged++;

            } catch (\Throwable $e) {
                $io->error("Error for culture ID {$culture->getId()}: " . $e->getMessage());
                $errors++;
            }
        }

        $io->progressFinish();

        $io->success([
            "Logged: {$logged} culture(s)",
            "Skipped (no gouvernorat): {$skipped}",
            "Errors: {$errors}",
        ]);

        return $errors > 0 ? Command::FAILURE : Command::SUCCESS;
    }
}
