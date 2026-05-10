<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class AgromonitoringAdviceService
{
    private const AGROMONITORING_API_URL = 'https://api.agromonitoring.com/agro/1.0';

    public function __construct(
        private HttpClientInterface $httpClient,
        private string $apiKey,
    ) {
    }

    /**
     * Fetches weather data from Agromonitoring API
     */
    public function getWeather(float $latitude, float $longitude): array
    {
        try {
            $url = sprintf('%s/weather?lat=%f&lon=%f&appid=%s', self::AGROMONITORING_API_URL, $latitude, $longitude, $this->apiKey);

            $response = $this->httpClient->request('GET', $url);

            return $response->toArray();
        } catch (\Throwable $e) {
            error_log('Agromonitoring Weather Error: ' . $e->getMessage());

            return ['error' => 'Unable to fetch weather data'];
        }
    }

    /**
     * Fetches soil data from Agromonitoring API
     */
    public function getSoil(float $latitude, float $longitude): array
    {
        try {
            $url = sprintf('%s/soil?lat=%f&lon=%f&appid=%s', self::AGROMONITORING_API_URL, $latitude, $longitude, $this->apiKey);

            $response = $this->httpClient->request('GET', $url);

            return $response->toArray();
        } catch (\Throwable $e) {
            error_log('Agromonitoring Soil Error: ' . $e->getMessage());

            return ['error' => 'Unable to fetch soil data'];
        }
    }

    /**
     * Gets agricultural advice based on weather and soil conditions
     */
    public function getAdvice(float $latitude, float $longitude): string
    {
        $weather = $this->getWeather($latitude, $longitude);
        $soil = $this->getSoil($latitude, $longitude);

        return $this->buildAdvice($weather, $soil);
    }

    private function buildAdvice(array $weather, array $soil): string
    {
        $advice = "**Agricultural Recommendations:**\n\n";

        // Check for weather conditions
        if (!isset($weather['error']) && isset($weather['main'])) {
            $temp = $weather['main']['temp'] ?? null;
            $humidity = $weather['main']['humidity'] ?? null;
            $pressure = $weather['main']['pressure'] ?? null;

            $advice .= "**Weather Conditions:**\n";
            if ($temp !== null) {
                $advice .= sprintf("- Temperature: %.1f°C\n", $temp);
                if ($temp < 10) {
                    $advice .= "  ⚠️ Cold conditions - Consider protecting sensitive crops\n";
                } elseif ($temp > 30) {
                    $advice .= "  ⚠️ High temperature - Ensure adequate irrigation\n";
                }
            }
            if ($humidity !== null) {
                $advice .= sprintf("- Humidity: %d%%\n", $humidity);
                if ($humidity > 80) {
                    $advice .= "  ⚠️ High humidity - Monitor for fungal diseases\n";
                }
            }
            $advice .= "\n";
        }

        // Check for soil conditions
        if (!isset($soil['error']) && isset($soil['properties'])) {
            $advice .= "**Soil Conditions:**\n";
            $properties = $soil['properties'];

            if (isset($properties['moisture'])) {
                $advice .= sprintf("- Soil Moisture: %s\n", $properties['moisture']);
            }
            if (isset($properties['temperature'])) {
                $advice .= sprintf("- Soil Temperature: %s\n", $properties['temperature']);
            }
            $advice .= "\n";
        }

        // General recommendations
        $advice .= "**General Recommendations:**\n";
        $advice .= "1. Monitor weather forecasts regularly\n";
        $advice .= "2. Adjust irrigation based on soil moisture\n";
        $advice .= "3. Apply fertilizers during optimal weather conditions\n";
        $advice .= "4. Watch for pest activity during humid periods\n";
        $advice .= "5. Plan harvesting when weather is favorable\n";

        return $advice;
    }
}
