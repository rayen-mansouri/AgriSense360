<?php
// src/Service/AIPriceAnomalyService.php

namespace App\Service;

use App\Repository\ProduitRepository;

class AIPriceAnomalyService
{
    public function __construct(private ProduitRepository $produitRepo)
    {
    }
    
    /**
     * Détecte les anomalies de prix par catégorie
     */
    public function detectAnomalies(): array
    {
        $produits = $this->produitRepo->findAll();
        $categories = $this->produitRepo->findAllCategories();
        
        $anomalies = [];
        
        foreach ($categories as $categorie) {
            $produitsCat = $this->produitRepo->findBy(['categorie' => $categorie]);
            $prices = array_map(fn($p) => $p->getPrixUnitaire(), $produitsCat);
            
            if (count($prices) < 2) continue;
            
            $mean = array_sum($prices) / count($prices);
            $variance = array_sum(array_map(fn($p) => pow($p - $mean, 2), $prices)) / count($prices);
            $stdDev = sqrt($variance);
            
            foreach ($produitsCat as $produit) {
                $price = $produit->getPrixUnitaire();
                $zScore = $stdDev > 0 ? ($price - $mean) / $stdDev : 0;
                
                if (abs($zScore) > 1.5) {
                    $anomalies[] = [
                        'produit' => $produit->getNom(),
                        'categorie' => $categorie,
                        'prix' => $price,
                        'prix_moyen' => round($mean, 2),
                        'ecart' => round($price - $mean, 2),
                        'z_score' => round($zScore, 2),
                        'type' => $zScore > 0 ? 'Prix élevé' : 'Prix bas',
                        'recommandation' => $zScore > 0 ? 'Peut-être surévalué' : 'Bon rapport qualité-prix'
                    ];
                }
            }
        }
        
        return [
            'anomalies' => $anomalies,
            'total_anomalies' => count($anomalies)
        ];
    }
}
