<?php
namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class ExchangeRateService
{
    public function __construct(private HttpClientInterface $httpClient)
    {
    }
    
    public function getRates(): array
    {
        try {
            // API gratuite, pas de clé requise
            $response = $this->httpClient->request('GET', 
                'https://api.exchangerate-api.com/v4/latest/TND',
                ['timeout' => 10]
            );
            
            $data = $response->toArray();
            
            return [
                'success' => true,
                'rates' => $data['rates'] ?? [],
                'base' => 'TND',
                'date' => $data['date'] ?? date('Y-m-d')
            ];
        } catch (\Exception $e) {
            // Taux de secours en cas d'erreur
            return [
                'success' => false,
                'rates' => ['EUR' => 0.30, 'USD' => 0.32, 'GBP' => 0.26, 'CAD' => 0.43, 'JPY' => 48.5],
                'base' => 'TND',
                'date' => date('Y-m-d')
            ];
        }
    }
    
    public function convert(float $amountTND, string $currency): float
    {
        $data = $this->getRates();
        $rates = $data['rates'] ?? [];
        $rate = $rates[strtoupper($currency)] ?? 1;
        return round($amountTND / $rate, 2);
    }
}