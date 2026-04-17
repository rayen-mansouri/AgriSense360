<?php
// src/Service/OpenFoodFactsService.php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class OpenFoodFactsService
{
    public function __construct(private HttpClientInterface $httpClient)
    {
    }
    
    public function getProductByBarcode(string $barcode): ?array
    {
        $response = $this->httpClient->request('GET', 
            "https://world.openfoodfacts.org/api/v0/product/{$barcode}.json"
        );
        
        $data = $response->toArray();
        
        if ($data['status'] === 1) {
            $product = $data['product'];
            return [
                'nom' => $product['product_name'] ?? null,
                'categorie' => $product['categories'] ?? null,
                'description' => $product['generic_name'] ?? null,
                'marque' => $product['brands'] ?? null,
                'image_url' => $product['image_url'] ?? null,
            ];
        }
        
        return null;
    }
}