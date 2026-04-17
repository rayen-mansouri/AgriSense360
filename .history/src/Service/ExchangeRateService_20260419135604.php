<?php
// src/Service/ExchangeRateService.php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class ExchangeRateService
{
    private array $rates = [];
    
    public function __construct(private HttpClientInterface $httpClient)
    {
    }
    
    public function getRates(): array
    {
        // API gratuite (pas de clé requise)
        $response = $this->httpClient->request('GET', 'https://api.exchangerate-api.com/v4/latest/TND');
        $data = $response->toArray();
        $this->rates = $data['rates'] ?? [];
        return $this->rates;
    }
    
    public function convert(float $amountTND, string $currency): float
    {
        $rates = $this->getRates();
        $rate = $rates[strtoupper($currency)] ?? 1;
        return round($amountTND / $rate, 2);
    }
}