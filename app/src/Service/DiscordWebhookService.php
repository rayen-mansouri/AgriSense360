<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class DiscordWebhookService
{
    public function __construct(
        private HttpClientInterface $httpClient,
        private string $webhookUrl,
    ) {
    }

    public function sendNotification(string $title, string $description, string $color = '3498db'): bool
    {
        try {
            $payload = [
                'embeds' => [
                    [
                        'title' => $title,
                        'description' => $description,
                        'color' => (int) hexdec($color),
                        'timestamp' => (new \DateTime())->format('c'),
                        'footer' => [
                            'text' => 'AgriSense 360',
                            'icon_url' => 'https://agrisense.local/logo.png',
                        ],
                    ],
                ],
            ];

            $this->httpClient->request('POST', $this->webhookUrl, [
                'json' => $payload,
            ]);

            return true;
        } catch (\Throwable $e) {
            error_log('Discord notification failed: ' . $e->getMessage());

            return false;
        }
    }

    public function notifyNewAffectation(array $affectation, array $worker, array $task): bool
    {
        $title = sprintf(
            'New Task Assignment: %s',
            $task['typeTravail'] ?? 'New Task'
        );

        $description = sprintf(
            "**Worker:** %s\n**Zone:** %s\n**Start:** %s\n**End:** %s\n**Status:** %s",
            $worker['firstName'] . ' ' . $worker['lastName'] ?? 'Unknown',
            $affectation['zoneTravail'] ?? 'N/A',
            $affectation['dateDebut'] ?? 'TBD',
            $affectation['dateFin'] ?? 'TBD',
            $affectation['statut'] ?? 'Pending'
        );

        return $this->sendNotification($title, $description, '2ecc71');
    }

    public function notifyTaskCompletion(array $affectation, array $worker): bool
    {
        $title = 'Task Completed';

        $description = sprintf(
            "**Worker:** %s\n**Task Type:** %s\n**Zone:** %s\n**Completed At:** %s",
            $worker['firstName'] . ' ' . $worker['lastName'] ?? 'Unknown',
            $affectation['typeTravail'] ?? 'N/A',
            $affectation['zoneTravail'] ?? 'N/A',
            (new \DateTime())->format('Y-m-d H:i:s')
        );

        return $this->sendNotification($title, $description, '27ae60');
    }

    public function notifyEvaluationCreated(array $evaluation, array $worker): bool
    {
        $title = 'New Performance Evaluation';

        $description = sprintf(
            "**Worker:** %s\n**Note:** %s/20\n**Quality:** %s\n**Date:** %s",
            $worker['firstName'] . ' ' . $worker['lastName'] ?? 'Unknown',
            $evaluation['note'] ?? 'N/A',
            $evaluation['qualite'] ?? 'N/A',
            $evaluation['dateEvaluation'] ?? 'N/A'
        );

        return $this->sendNotification($title, $description, '3498db');
    }

    public function notifyWeatherWarning(string $location, array $weatherData): bool
    {
        $title = 'Weather Alert';

        $description = sprintf(
            "**Location:** %s\n**Condition:** %s\n**Temperature:** %.1f°C\n**Humidity:** %s%%\n**Wind Speed:** %.1f m/s",
            $location,
            $weatherData['weather'][0]['main'] ?? 'Unknown',
            $weatherData['main']['temp'] ?? 0,
            $weatherData['main']['humidity'] ?? 0,
            $weatherData['wind']['speed'] ?? 0
        );

        $color = $this->getWeatherColor($weatherData);

        return $this->sendNotification($title, $description, $color);
    }

    public function notifyAIRecommendation(string $title, string $recommendation): bool
    {
        return $this->sendNotification(
            'AI Recommendation: ' . $title,
            $recommendation,
            '9b59b6'
        );
    }

    private function getWeatherColor(array $weatherData): string
    {
        $condition = strtolower($weatherData['weather'][0]['main'] ?? '');

        return match (true) {
            str_contains($condition, 'rain') => 'e74c3c',
            str_contains($condition, 'storm') => 'c0392b',
            str_contains($condition, 'cloud') => '95a5a6',
            str_contains($condition, 'clear') => 'f39c12',
            default => '3498db',
        };
    }
}
