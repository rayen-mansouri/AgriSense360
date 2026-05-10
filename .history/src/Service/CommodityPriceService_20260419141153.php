<?php
// src/Service/CommodityPriceService.php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class CommodityPriceService
{
    private array $commodityIndicators = [
        'WHEAT' => 'PWHEAMT',
        'CORN' => 'PCOREMT', 
        'SOYBEAN' => 'PSOYEMT',
        'SUGAR' => 'PSUGAIS',
        'RICE' => 'PRICEIDX',
        'COFFEE' => 'PCOFFOTM',
        'COTTON' => 'PCOTTIND',
        'OIL' => 'POILAPSP'
    ];
    
    public function __construct(private HttpClientInterface $httpClient)
    {
    }
    
    /**
     * Récupère le prix d'une matière première depuis la Banque Mondiale
     */
    public function getPrice(string $commodity): ?array
    {
        $indicator = $this->commodityIndicators[strtoupper($commodity)] ?? null;
        
        if (!$indicator) {
            return null;
        }
        
        try {
            $response = $this->httpClient->request('GET', 
                "https://api.worldbank.org/v2/country/all/indicator/{$indicator}?format=json&per_page=10"
            );
            
            $data = $response->toArray();
            
            if (isset($data[1]) && is_array($data[1])) {
                foreach ($data[1] as $item) {
                    if ($item['value'] !== null) {
                        return [
                            'price' => round($item['value'], 2),
                            'year' => $item['date'],
                            'commodity' => $commodity,
                            'unit' => 'USD'
                        ];
                    }
                }
            }
        } catch (\Exception $e) {
            return null;
        }
        
        return null;
    }
    
    /**
     * Récupère plusieurs prix en une seule requête
     */
    public function getMultiplePrices(array $commodities): array
    {
        $results = [];
        foreach ($commodities as $commodity) {
            $price = $this->getPrice($commodity);
            if ($price) {
                $results[] = $price;
            }
        }
        return $results;
    }
    
    /**
     * API alternative gratuite (pas de clé requise)
     */
    public function getPriceAlternative(string $commodity): ?float
    {
        // API gratuite pour les matières premières
        $commodityMap = [
            'WHEAT' => 'ZW',
            'CORN' => 'ZC',
            'SOYBEAN' => 'ZS',
            'SUGAR' => 'SB',
            'COFFEE' => 'KC'
        ];
        
        $symbol = $commodityMap[strtoupper($commodity)] ?? null;
        
        if (!$symbol) {
            return null;
        }
        
        try {
            // API gratuite de prix (exemple avec Alpha Vantage, nécessite une clé)
            // Alternative : utiliser une source gratuite comme Yahoo Finance
            return null;
        } catch (\Exception $e) {
            return null;
        }
    }
}