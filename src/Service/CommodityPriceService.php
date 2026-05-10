<?php
// src/Service/CommodityPriceService.php
namespace App\Service;

class CommodityPriceService
{
    // Données simulées mais réalistes
    private array $commodityPrices = [
        'WHEAT' => ['price' => 245.50, 'unit' => 'USD/tonne', 'change' => '+2.3%', 'icon' => 'fa-wheat-awn'],
        'CORN' => ['price' => 198.30, 'unit' => 'USD/tonne', 'change' => '+1.2%', 'icon' => 'fa-corn'],
        'SOYBEAN' => ['price' => 425.80, 'unit' => 'USD/tonne', 'change' => '-0.5%', 'icon' => 'fa-seedling'],
        'SUGAR' => ['price' => 0.22, 'unit' => 'USD/livre', 'change' => '+0.8%', 'icon' => 'fa-cube'],
        'COFFEE' => ['price' => 1.85, 'unit' => 'USD/livre', 'change' => '-1.2%', 'icon' => 'fa-mug-hot'],
        'OIL' => ['price' => 78.50, 'unit' => 'USD/baril', 'change' => '+3.1%', 'icon' => 'fa-oil-can'],
        'RICE' => ['price' => 520.00, 'unit' => 'USD/tonne', 'change' => '-0.3%', 'icon' => 'fa-bowl-food'],
        'COTTON' => ['price' => 0.85, 'unit' => 'USD/livre', 'change' => '+1.5%', 'icon' => 'fa-tshirt']
    ];
    
    public function getPrice(string $commodity): array
    {
        $commodity = strtoupper($commodity);
        
        if (isset($this->commodityPrices[$commodity])) {
            return array_merge(
                ['success' => true, 'commodity' => $commodity],
                $this->commodityPrices[$commodity]
            );
        }
        
        return ['success' => false, 'error' => 'Matière première non trouvée'];
    }
    
    public function getAllPrices(): array
    {
        $result = [];
        foreach ($this->commodityPrices as $commodity => $data) {
            $result[] = array_merge(
                ['success' => true, 'commodity' => $commodity],
                $data
            );
        }
        return $result;
    }
}