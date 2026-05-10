// src/Service/OpenFoodFactsService.php

<?php
namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class OpenFoodFactsService
{
    public function __construct(private HttpClientInterface $httpClient)
    {
    }
    
    public function getProductByBarcode(string $barcode): ?array
    {
        try {
            // API gratuite, pas de clé requise
            $response = $this->httpClient->request('GET', 
                "https://world.openfoodfacts.org/api/v0/product/{$barcode}.json",
                ['timeout' => 10]
            );
            
            $data = $response->toArray();
            
            if ($data['status'] === 1 && isset($data['product'])) {
                $product = $data['product'];
                return [
                    'success' => true,
                    'nom' => $product['product_name'] ?? 'Nom non trouvé',
                    'categorie' => $product['categories'] ?? 'Non catégorisé',
                    'marque' => $product['brands'] ?? 'Marque inconnue',
                    'description' => $product['generic_name'] ?? 'Aucune description',
                    'image_url' => $product['image_url'] ?? null,
                    'ingredients' => $product['ingredients_text'] ?? null,
                    'nutriments' => $product['nutriments'] ?? null
                ];
            }
            
            return ['success' => false, 'error' => 'Produit non trouvé'];
        } catch (\Exception $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }
}