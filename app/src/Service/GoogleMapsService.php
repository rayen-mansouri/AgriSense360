<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class GoogleMapsService
{
    public function __construct(
        private HttpClientInterface $httpClient,
        private string $apiKey,
    ) {
    }

    public function getGeocode(string $address): array
    {
        try {
            $response = $this->httpClient->request('GET', 'https://maps.googleapis.com/maps/api/geocode/json', [
                'query' => [
                    'address' => $address,
                    'key' => $this->apiKey,
                ],
            ]);

            return $response->toArray();
        } catch (\Throwable $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function getReverseGeocode(float $latitude, float $longitude): array
    {
        try {
            $response = $this->httpClient->request('GET', 'https://maps.googleapis.com/maps/api/geocode/json', [
                'query' => [
                    'latlng' => "$latitude,$longitude",
                    'key' => $this->apiKey,
                ],
            ]);

            return $response->toArray();
        } catch (\Throwable $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function getDistance(float $originLat, float $originLng, float $destLat, float $destLng): array
    {
        try {
            $response = $this->httpClient->request('GET', 'https://maps.googleapis.com/maps/api/distancematrix/json', [
                'query' => [
                    'origins' => "$originLat,$originLng",
                    'destinations' => "$destLat,$destLng",
                    'key' => $this->apiKey,
                ],
            ]);

            return $response->toArray();
        } catch (\Throwable $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function generateMapEmbedUrl(float $latitude, float $longitude, int $zoom = 15): string
    {
        return sprintf(
            'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3000!2d%f!3d%f!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0:0x0!2zLocation!5e0!3m2!1sen!2s!4v1234567890',
            $longitude,
            $latitude
        );
    }
}
