<?php
// src/Service/AdvancedSimilarProductsService.php

namespace App\Service;

use App\Entity\Produit;
use App\Repository\ProduitRepository;

class AdvancedSimilarProductsService
{
    public function __construct(private ProduitRepository $produitRepo)
    {
    }
    
    private function calculateSimilarity(Produit $a, Produit $b): float
    {
        $score = 0;
        
        if ($a->getCategorie() === $b->getCategorie()) {
            $score += 40;
        }
        
        $prixA = $a->getPrixUnitaire();
        $prixB = $b->getPrixUnitaire();
        if ($prixA > 0 && $prixB > 0) {
            $ratio = min((float)$prixA, (float)$prixB) / max((float)$prixA, (float)$prixB);
            if ($ratio > 0.7) {
                $score += 20 * $ratio;
            }
        }
        
        $motsA = explode(' ', strtolower($a->getNom()));
        $motsB = explode(' ', strtolower($b->getNom()));
        $communs = array_intersect($motsA, $motsB);
        $score += min(20, count($communs) * 5);
        
        if ($a->getPhotoUrl() && $b->getPhotoUrl()) {
            $score += 10;
        }
        
        return min(100, $score);
    }
    
    public function recommend(Produit $produit, int $limit = 4): array
    {
        $allProducts = $this->produitRepo->findAll();
        $scores = [];
        
        foreach ($allProducts as $candidate) {
            if ($candidate->getId() === $produit->getId()) {
                continue;
            }
            
            $score = $this->calculateSimilarity($produit, $candidate);
            if ($score > 20) {
                $scores[] = [
                    'produit' => $candidate,
                    'score' => round($score, 2),
                    'raison' => $this->getReason($produit, $candidate)
                ];
            }
        }
        
        usort($scores, fn($a, $b) => $b['score'] <=> $a['score']);
        return array_slice($scores, 0, $limit);
    }
    
    private function getReason(Produit $a, Produit $b): string
    {
        if ($a->getCategorie() === $b->getCategorie()) {
            return 'Même catégorie';
        }
        return 'Produit complémentaire';
    }
}