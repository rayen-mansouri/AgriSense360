<?php
// src/Service/AdvancedProfitabilityService.php

namespace App\Service;

use App\Entity\Produit;
use App\Repository\ProduitRepository;

class AdvancedProfitabilityService
{
    private array $categoryMargins = [
        'Engrais' => 0.25,
        'Semences' => 0.30,
        'Pesticides' => 0.35,
        'Irrigation' => 0.20,
        'Outils & Matériel' => 0.15,
        'Alimentation animale' => 0.10,
        'Autre' => 0.20
    ];
    
    public function __construct(private ProduitRepository $produitRepo)
    {
    }
    
    /**
     * Calcule la rentabilité d'un produit
     */
    public function calculateProfitability(Produit $produit): array
    {
        $prixVente = $produit->getPrixUnitaire();
        $margeCategory = $this->categoryMargins[$produit->getCategorie()] ?? 0.20;
        
        // Estimation du prix d'achat
        $prixAchat = round($prixVente * (1 - $margeCategory), 2);
        $margeBrute = round($prixVente - $prixAchat, 2);
        $tauxMarge = round(($margeBrute / $prixVente) * 100, 2);
        
        // Coûts estimés
        $fraisStockage = round($prixVente * 0.05, 2);
        $fraisTransport = round($prixVente * 0.03, 2);
        $coutTotal = round($prixAchat + $fraisStockage + $fraisTransport, 2);
        $beneficeNet = round($prixVente - $coutTotal, 2);
        
        return [
            'produit' => $produit->getNom(),
            'prix_vente' => $prixVente,
            'prix_achat_estime' => $prixAchat,
            'marge_brute' => $margeBrute,
            'taux_marge' => $tauxMarge,
            'frais_stockage' => $fraisStockage,
            'frais_transport' => $fraisTransport,
            'cout_total' => $coutTotal,
            'benefice_net' => $beneficeNet,
            'performance' => $this->getPerformance($tauxMarge)
        ];
    }
    
    private function getPerformance(float $tauxMarge): string
    {
        if ($tauxMarge >= 30) return '🚀 Très rentable';
        if ($tauxMarge >= 20) return '✅ Rentable';
        if ($tauxMarge >= 10) return '⚠️ Peu rentable';
        return '🔴 Non rentable';
    }
    
    /**
     * Classement des produits par rentabilité
     */
    public function getRanking(): array
    {
        $produits = $this->produitRepo->findAll();
        $ranking = [];
        
        foreach ($produits as $produit) {
            $profit = $this->calculateProfitability($produit);
            $ranking[] = [
                'produit' => $produit->getNom(),
                'categorie' => $produit->getCategorie(),
                'benefice' => $profit['benefice_net'],
                'marge' => $profit['taux_marge']
            ];
        }
        
        usort($ranking, fn($a, $b) => $b['benefice'] <=> $a['benefice']);
        return $ranking;
    }
}