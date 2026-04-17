// src/Service/CommodityPriceService.php

<?php
namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class CommodityPriceService
{
    public function __construct(private HttpClientInterface $httpClient)
    {
    }
    
    // Données de secours en cas d'erreur API
    private array $fallbackPrices = [
        'WHEAT' => ['price' => 245.50, 'year' => 2024, 'unit' => 'USD/tonne'],
        'CORN' => ['price' => 198.30, 'year' => 2024, 'unit' => 'USD/tonne'],
        'SOYBEAN' => ['price' => 425.80, 'year' => 2024, 'unit' => 'USD/tonne'],
        'SUGAR' => ['price' => 0.22, 'year' => 2024, 'unit' => 'USD/livre'],
        'COFFEE' => ['price' => 1.85, 'year' => 2024, 'unit' => 'USD/livre'],
        'OIL' => ['price' => 78.50, 'year' => 2024, 'unit' => 'USD/baril']
    ];
    
    public function getPrice(string $commodity): array
    {
        // Données simulées (car l'API Banque Mondiale est limitée)
        // Dans un projet réel, vous utiliseriez une API comme Commodities API
        $commodity = strtoupper($commodity);
        
        if (isset($this->fallbackPrices[$commodity])) {
            return array_merge(
                ['success' => true, 'commodity' => $commodity],
                $this->fallbackPrices[$commodity]
            );
        }
        
        return ['success' => false, 'error' => 'Matière première non trouvée'];
    }
    
    public function getAllPrices(): array
    {
        $result = [];
        foreach (array_keys($this->fallbackPrices) as $commodity) {
            $result[] = $this->getPrice($commodity);
        }
        return $result;
    }
}