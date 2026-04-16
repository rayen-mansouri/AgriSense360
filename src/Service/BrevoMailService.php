<?php

namespace App\Service;

use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class BrevoMailService
{
    private const BREVO_SMTP_URL = 'https://api.brevo.com/v3/smtp/email';

    public function __construct(
        private HttpClientInterface $httpClient,
        #[Autowire('%env(BREVO_API_KEY)%')] private string $apiKey,
        #[Autowire('%env(BREVO_FROM_EMAIL)%')] private string $fromEmail,
    ) {
    }

    public function sendTransactionalEmail(string $toEmail, string $subject, string $textContent): void
    {
        if ($this->apiKey === '' || $this->fromEmail === '') {
            throw new \RuntimeException('Configure BREVO_API_KEY and BREVO_FROM_EMAIL in .env.local');
        }
        $payload = [
            'sender' => [
                'name' => 'AgriSense 360',
                'email' => $this->fromEmail,
            ],
            'to' => [['email' => $toEmail]],
            'subject' => $subject,
            'textContent' => $textContent,
        ];
        $response = $this->httpClient->request('POST', self::BREVO_SMTP_URL, [
            'headers' => [
                'api-key' => $this->apiKey,
                'Content-Type' => 'application/json',
            ],
            'json' => $payload,
        ]);
        $status = $response->getStatusCode();
        if ($status < 200 || $status >= 300) {
            throw new \RuntimeException('HTTP ' . $status . ' — ' . $response->getContent(false));
        }
    }
}
