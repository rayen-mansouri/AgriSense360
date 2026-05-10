<?php
// src/Service/AIKNNClassifierService.php

namespace App\Service;

use App\Entity\Produit;
use App\Repository\ProduitRepository;

class AIKNNClassifierService
{
    private array $trainingData = [];
    private array $trainingLabels = [];
    
    public function __construct(private ProduitRepository $produitRepo)
    {
        $this->train();
    }
    
    /**
     * Entraînement du modèle
     */
    public function train(): void
    {
        $produits = $this->produitRepo->findAll();
        $allPrices = array_map(fn($p) => $p->getPrixUnitaire(), $produits);
        $maxPrice = max($allPrices);
        
        foreach ($produits as $produit) {
            $features = [
                strlen($produit->getNom()),                                    // Longueur nom
                $maxPrice > 0 ? $produit->getPrixUnitaire() / $maxPrice : 0,   // Prix normalisé
                $produit->getPhotoUrl() ? 1 : 0,                               // A photo
                $produit->getDescription() ? 1 : 0,                            // A description
                $produit->getSku() ? 1 : 0                                      // A code-barres
            ];
            $this->trainingData[] = $features;
            $this->trainingLabels[] = $produit->getCategorie() ?? 'Autre';
        }
    }
    
    /**
     * Distance euclidienne
     */
    private function distance(array $a, array $b): float
    {
        $sum = 0;
        for ($i = 0; $i < count($a); $i++) {
            $sum += pow($a[$i] - $b[$i], 2);
        }
        return sqrt($sum);
    }
    
    /**
     * Prédit la catégorie d'un produit
     */
    public function predict(Produit $produit, int $k = 3): array
    {
        $allPrices = array_map(fn($p) => $p->getPrixUnitaire(), $this->produitRepo->findAll());
        $maxPrice = max($allPrices);
        
        $features = [
            strlen($produit->getNom()),
            $maxPrice > 0 ? $produit->getPrixUnitaire() / $maxPrice : 0,
            $produit->getPhotoUrl() ? 1 : 0,
            $produit->getDescription() ? 1 : 0,
            $produit->getSku() ? 1 : 0
        ];
        
        // Calcul des distances
        $distances = [];
        for ($i = 0; $i < count($this->trainingData); $i++) {
            $distances[] = [
                'distance' => $this->distance($features, $this->trainingData[$i]),
                'label' => $this->trainingLabels[$i]
            ];
        }
        
        usort($distances, fn($a, $b) => $a['distance'] <=> $b['distance']);
        $neighbors = array_slice($distances, 0, $k);
        
        // Vote
        $votes = [];
        foreach ($neighbors as $neighbor) {
            $votes[$neighbor['label']] = ($votes[$neighbor['label']] ?? 0) + 1;
        }
        
        arsort($votes);
        $predicted = key($votes);
        $confidence = round(current($votes) / $k * 100, 2);
        
        return [
            'categorie_predite' => $predicted,
            'confiance' => $confidence,
            'votes' => $votes
        ];
    }
}