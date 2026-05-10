<?php
// src/Service/AdvancedProductQualityService.php

namespace App\Service;

use App\Repository\ProduitRepository;

class AdvancedProductQualityService
{
    public function __construct(private ProduitRepository $produitRepo)
    {
    }
    
    /**
     * Analyse la qualité d'un produit
     */
    public function analyzeQuality(Produit $produit): array
    {
        $checks = [
            'nom' => $this->checkNom($produit),
            'prix' => $this->checkPrix($produit),
            'categorie' => $this->checkCategorie($produit),
            'description' => $this->checkDescription($produit),
            'photo' => $this->checkPhoto($produit),
            'barcode' => $this->checkBarcode($produit)
        ];
        
        $score = array_sum(array_column($checks, 'score'));
        $missing = array_filter($checks, fn($c) => !$c['passed']);
        
        return [
            'produit' => $produit->getNom(),
            'score_global' => $score,
            'niveau' => $this->getLevel($score),
            'controles' => $checks,
            'champs_manquants' => array_keys($missing),
            'recommandations' => $this->getRecommendations($missing)
        ];
    }
    
    private function checkNom(Produit $produit): array
    {
        $nom = $produit->getNom();
        if (!$nom) {
            return ['passed' => false, 'score' => 0, 'message' => 'Nom manquant'];
        }
        if (strlen($nom) < 3) {
            return ['passed' => false, 'score' => 5, 'message' => 'Nom trop court'];
        }
        return ['passed' => true, 'score' => 15, 'message' => 'OK'];
    }
    
    private function checkPrix(Produit $produit): array
    {
        $prix = $produit->getPrixUnitaire();
        if (!$prix || $prix <= 0) {
            return ['passed' => false, 'score' => 0, 'message' => 'Prix manquant'];
        }
        return ['passed' => true, 'score' => 15, 'message' => sprintf('%.2f DT', $prix)];
    }
    
    private function checkCategorie(Produit $produit): array
    {
        $cat = $produit->getCategorie();
        if (!$cat || $cat === 'Autre') {
            return ['passed' => false, 'score' => 0, 'message' => 'Catégorie non définie'];
        }
        return ['passed' => true, 'score' => 15, 'message' => $cat];
    }
    
    private function checkDescription(Produit $produit): array
    {
        $desc = $produit->getDescription();
        if (!$desc) {
            return ['passed' => false, 'score' => 0, 'message' => 'Description manquante'];
        }
        if (strlen($desc) < 50) {
            return ['passed' => false, 'score' => 10, 'message' => 'Description trop courte'];
        }
        return ['passed' => true, 'score' => 20, 'message' => sprintf('%d caractères', strlen($desc))];
    }
    
    private function checkPhoto(Produit $produit): array
    {
        if (!$produit->getPhotoUrl()) {
            return ['passed' => false, 'score' => 0, 'message' => 'Photo manquante'];
        }
        return ['passed' => true, 'score' => 20, 'message' => 'Photo présente'];
    }
    
    private function checkBarcode(Produit $produit): array
    {
        if (!$produit->getSku()) {
            return ['passed' => false, 'score' => 0, 'message' => 'Code-barres manquant'];
        }
        return ['passed' => true, 'score' => 15, 'message' => 'Code-barres généré'];
    }
    
    private function getLevel(int $score): string
    {
        if ($score >= 80) return '🌟 Qualité excellente';
        if ($score >= 60) return '✅ Bonne qualité';
        if ($score >= 40) return '⚠️ Qualité moyenne';
        return '🔴 À améliorer';
    }
    
    private function getRecommendations(array $missing): array
    {
        $recs = [];
        if (isset($missing['description'])) $recs[] = 'Ajoutez une description détaillée';
        if (isset($missing['photo'])) $recs[] = 'Ajoutez une photo du produit';
        if (isset($missing['categorie'])) $recs[] = 'Définissez une catégorie';
        if (isset($missing['barcode'])) $recs[] = 'Générez un code-barres';
        if (isset($missing['nom'])) $recs[] = 'Complétez le nom du produit';
        return $recs;
    }
    
    /**
     * Liste des produits à améliorer
     */
    public function getProductsToImprove(): array
    {
        $produits = $this->produitRepo->findAll();
        $results = [];
        
        foreach ($produits as $produit) {
            $analysis = $this->analyzeQuality($produit);
            if ($analysis['score_global'] < 60) {
                $results[] = $analysis;
            }
        }
        
        usort($results, fn($a, $b) => $a['score_global'] <=> $b['score_global']);
        return $results;
    }
}