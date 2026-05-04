<?php
namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * Fetches current weather from OpenWeatherMap FREE tier.
 * The 5-day/3-hour forecast is also free — we catch errors gracefully
 * so current weather still shows if the key is brand-new (takes ~10 min to activate).
 */
class WeatherService
{
    private const GOUVERNORAT_COORDS = [
        'Ariana'      => ['lat' => 36.8625, 'lon' => 10.1956],
        'Béja'        => ['lat' => 36.7256, 'lon' => 9.1817],
        'Ben Arous'   => ['lat' => 36.7530, 'lon' => 10.2383],
        'Bizerte'     => ['lat' => 37.2744, 'lon' => 9.8739],
        'Gabès'       => ['lat' => 33.8815, 'lon' => 10.0982],
        'Gafsa'       => ['lat' => 34.4250, 'lon' => 8.7842],
        'Jendouba'    => ['lat' => 36.5011, 'lon' => 8.7803],
        'Kairouan'    => ['lat' => 35.6781, 'lon' => 10.0994],
        'Kasserine'   => ['lat' => 35.1676, 'lon' => 8.8365],
        'Kébili'      => ['lat' => 33.7050, 'lon' => 8.9650],
        'Le Kef'      => ['lat' => 36.1820, 'lon' => 8.7147],
        'Mahdia'      => ['lat' => 35.5047, 'lon' => 11.0622],
        'Manouba'     => ['lat' => 36.8090, 'lon' => 10.0972],
        'Médenine'    => ['lat' => 33.3549, 'lon' => 10.5055],
        'Monastir'    => ['lat' => 35.7643, 'lon' => 10.8113],
        'Nabeul'      => ['lat' => 36.4561, 'lon' => 10.7376],
        'Sfax'        => ['lat' => 34.7400, 'lon' => 10.7600],
        'Sidi Bouzid' => ['lat' => 35.0382, 'lon' => 9.4858],
        'Siliana'     => ['lat' => 36.0850, 'lon' => 9.3708],
        'Sousse'      => ['lat' => 35.8256, 'lon' => 10.6369],
        'Tataouine'   => ['lat' => 32.9297, 'lon' => 10.4518],
        'Tozeur'      => ['lat' => 33.9197, 'lon' => 8.1335],
        'Tunis'       => ['lat' => 36.8190, 'lon' => 10.1658],
        'Zaghouan'    => ['lat' => 36.4029, 'lon' => 10.1429],
    ];

    public function __construct(
        private HttpClientInterface $httpClient,
        private string $apiKey
    ) {}

    public function getWeatherForLocation(string $localisation): ?array
    {
        $coords = self::GOUVERNORAT_COORDS[$localisation] ?? null;
        if (!$coords || !$this->apiKey) {
            return null;
        }

        try {
            // ── Current weather (always free) ──────────────────────────
            $currentResp = $this->httpClient->request('GET',
                'https://api.openweathermap.org/data/2.5/weather', [
                    'query' => [
                        'lat'   => $coords['lat'],
                        'lon'   => $coords['lon'],
                        'appid' => $this->apiKey,
                        'units' => 'metric',
                        'lang'  => 'fr',
                    ]
                ]
            );

            // Force-read status (throws on 4xx/5xx)
            if ($currentResp->getStatusCode() !== 200) {
                return null;
            }
            $current = $currentResp->toArray();

        } catch (\Throwable $e) {
            return null; // API key invalid or network error
        }

        // ── 5-day / 3-hour forecast (also free, but key needs ~10 min to activate) ──
        $daily = [];
        try {
            $forecastResp = $this->httpClient->request('GET',
                'https://api.openweathermap.org/data/2.5/forecast', [
                    'query' => [
                        'lat'   => $coords['lat'],
                        'lon'   => $coords['lon'],
                        'appid' => $this->apiKey,
                        'units' => 'metric',
                        'lang'  => 'fr',
                        'cnt'   => 40,
                    ]
                ]
            );

            if ($forecastResp->getStatusCode() === 200) {
                $forecastData = $forecastResp->toArray();
                $daily = $this->buildDailyForecast($forecastData['list'] ?? []);
            }
            // Discard non-200 silently — current weather still renders
        } catch (\Throwable) {
            $daily = []; // Forecast unavailable, page still works
        }

        return $this->formatCurrent($current, $daily, $localisation);
    }

    private function buildDailyForecast(array $list): array
    {
        // Group by calendar day; prefer reading closest to noon
        $dailyMap = [];
        foreach ($list as $item) {
            $day  = date('Y-m-d', $item['dt']);
            $hour = (int) date('H', $item['dt']);
            if (!isset($dailyMap[$day]) ||
                abs($hour - 12) < abs((int) date('H', $dailyMap[$day]['dt']) - 12)) {
                $dailyMap[$day] = $item;
            }
        }

        $today  = date('Y-m-d');
        $result = [];
        foreach (array_slice($dailyMap, 0, 5) as $day => $item) {
            $result[] = [
                'date'        => $day,
                'label'       => $day === $today ? "Aujourd'hui" : $this->frenchDay($item['dt']),
                'temp_min'    => round($item['main']['temp_min']),
                'temp_max'    => round($item['main']['temp_max']),
                'description' => ucfirst($item['weather'][0]['description']),
                'icon'        => $item['weather'][0]['icon'],
                'humidity'    => $item['main']['humidity'],
                'wind'        => round($item['wind']['speed'] * 3.6, 1),
            ];
        }
        return $result;
    }

    private function formatCurrent(array $c, array $daily, string $location): array
    {
        $weatherId = $c['weather'][0]['id'];

        return [
            'location'    => $location,
            'temp'        => round($c['main']['temp']),
            'feels_like'  => round($c['main']['feels_like']),
            'temp_min'    => round($c['main']['temp_min']),
            'temp_max'    => round($c['main']['temp_max']),
            'humidity'    => $c['main']['humidity'],
            'pressure'    => $c['main']['pressure'],
            'wind_speed'  => round($c['wind']['speed'] * 3.6, 1),
            'visibility'  => isset($c['visibility']) ? round($c['visibility'] / 1000, 1) : null,
            'description' => ucfirst($c['weather'][0]['description']),
            'icon'        => $c['weather'][0]['icon'],
            'weather_id'  => $weatherId,
            'emoji'       => $this->weatherEmoji($weatherId),
            'sunrise'     => date('H:i', $c['sys']['sunrise']),
            'sunset'      => date('H:i', $c['sys']['sunset']),
            'clouds'      => $c['clouds']['all'],
            'daily'       => $daily,
            'updated_at'  => date('H:i'),
            'agri_advice' => $this->agriAdvice(
                $weatherId,
                $c['main']['temp'],
                $c['main']['humidity'],
                $c['wind']['speed']
            ),
        ];
    }

    private function frenchDay(int $ts): string
    {
        return ['Dimanche','Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi'][(int)date('w', $ts)];
    }

    private function weatherEmoji(int $id): string
    {
        return match(true) {
            $id >= 200 && $id < 300 => '⛈️',
            $id >= 300 && $id < 400 => '🌦️',
            $id >= 500 && $id < 600 => '🌧️',
            $id >= 600 && $id < 700 => '❄️',
            $id >= 700 && $id < 800 => '🌫️',
            $id === 800             => '☀️',
            $id === 801             => '🌤️',
            $id >= 802              => '☁️',
            default                 => '🌡️',
        };
    }

    private function agriAdvice(int $id, float $temp, int $humidity, float $windMs): array
    {
        $tips = [];

        if ($id >= 200 && $id < 300) {
            $tips[] = ['icon'=>'⚠️','text'=>'Orage prévu — Évitez toute intervention sur les cultures.','type'=>'danger'];
        } elseif ($id >= 500 && $id < 600) {
            $tips[] = ['icon'=>'💧','text'=>'Pluie en cours — Suspension de l\'irrigation recommandée.','type'=>'info'];
        }

        if ($humidity > 80) {
            $tips[] = ['icon'=>'🍄','text'=>'Humidité élevée — Risque de maladies fongiques, surveillez vos cultures.','type'=>'warning'];
        }

        if ($temp > 35) {
            $tips[] = ['icon'=>'🌡️','text'=>'Chaleur intense — Irriguer tôt le matin ou en soirée.','type'=>'warning'];
        } elseif ($temp < 5) {
            $tips[] = ['icon'=>'🥶','text'=>'Risque de gel — Protégez les cultures sensibles.','type'=>'danger'];
        }

        if ($windMs > 10) {
            $tips[] = ['icon'=>'💨','text'=>'Vents forts ('.round($windMs*3.6).' km/h) — Évitez les traitements phytosanitaires.','type'=>'warning'];
        }

        if (empty($tips)) {
            $tips[] = ['icon'=>'✅','text'=>'Conditions favorables pour les travaux agricoles aujourd\'hui.','type'=>'success'];
        }

        return $tips;
    }
}