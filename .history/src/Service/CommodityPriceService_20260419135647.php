// src/Service/CommodityPriceService.php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class CommodityPriceService
{
    public function __construct(private HttpClientInterface $httpClient)
    {
    }
    
    // World Bank Commodity Price API (gratuite)
    public function getPrice(string $commodity): ?float
    {
        // Ex: commodity = 'WHEAT', 'CORN', 'SOYBEAN', 'SUGAR'
        $response = $this->httpClient->request('GET', 
            "https://api.worldbank.org/v2/country/all/indicator/PM.AAPL.CRUDE?format=json"
        );
        
        $data = $response->toArray();
        // Traitement des données...
        
        return $data[1][0]['value'] ?? null;
    }
}