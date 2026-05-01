<?php
// src/Service/CommodityComparisonService.php

namespace App\Service;
use App\Entity\Produit;
use App\Repository\ProduitRepository;

class CommodityComparisonService
{
    private array $commodityPrices = [
        'Blé' => ['price' => 245.50, 'unit' => 'USD/tonne', 'categorie' => 'Semences'],
        'Maïs' => ['price' => 198.30, 'unit' => 'USD/tonne', 'categorie' => 'Semences'],
        'Soja' => ['price' => 425.80, 'unit' => 'USD/tonne', 'categorie' => 'Semences'],
        'Engrais' => ['price' => 450.00, 'unit' => 'USD/tonne', 'categorie' => 'Engrais']
    ];
    
    public function __construct(private ProduitRepository $produitRepo, private ExchangeRateService $exchangeService)
    {
    }
    
    /**
     * Compare un produit avec le prix du marché
     */
    public function compareProduct(Produit $produit): array
    {
        $tauxChange = $this->exchangeService->getRate('USD');
        $prixUSD = $produit->getPrixUnitaire() / $tauxChange;
        
        $commodity = $this->findMatchingCommodity($produit);
        
        if (!$commodity) {
            return [
                'produit' => $produit->getNom(),
                'comparable' => false,
                'message' => 'Aucune matière première correspondante'
            ];
        }
        
        $prixMarche = $this->commodityPrices[$commodity]['price'];
        $ecart = $prixUSD - $prixMarche;
        $ecartPercent = round(($ecart / $prixMarche) * 100, 1);
        
        return [
            'produit' => $produit->getNom(),
            'comparable' => true,
            'prix_marche' => $prixMarche,
            'prix_produit_usd' => round($prixUSD, 2),
            'prix_produit_tnd' => $produit->getPrixUnitaire(),
            'ecart' => $ecartPercent,
            'competitivite' => $this->getCompetitivite($ecartPercent),
            'recommandation' => $this->getRecommendation($ecartPercent)
        ];
    }
    
    private function findMatchingCommodity(Produit $produit): ?string
    {
        $nom = strtolower($produit->getNom());
        $categorie = $produit->getCategorie();
        
        foreach ($this->commodityPrices as $commodity => $data) {
            if (strpos($nom, strtolower($commodity)) !== false) {
                return $commodity;
            }
            if ($data['categorie'] === $categorie) {
                return $commodity;
            }
        }
        
        return null;
    }
    
    private function getCompetitivite(float $ecartPercent): string
    {
        if ($ecartPercent <= -20) return 'Très compétitif';
        if ($ecartPercent <= -5) return 'Compétitif';
        if ($ecartPercent <= 10) return 'Moyen';
        if ($ecartPercent <= 25) return 'Peu compétitif';
        return 'Non compétitif';
    }
    
    private function getRecommendation(float $ecartPercent): string
    {
        if ($ecartPercent <= -20) return 'Prix excellent, gardez cette stratégie';
        if ($ecartPercent <= -5) return 'Bon positionnement, léger ajustement possible';
        if ($ecartPercent <= 10) return 'Prix dans la moyenne, surveillez le marché';
        if ($ecartPercent <= 25) return 'Prix élevé, envisagez une baisse';
        return 'Prix trop élevé, révisez votre tarification';
    }
    
    /**
     * Statistiques de compétitivité
     */
    public function getCompetitivityStats(): array
    {
        $produits = $this->produitRepo->findAll();
        $results = [];
        
        foreach ($produits as $produit) {
            $comparison = $this->compareProduct($produit);
            if ($comparison['comparable']) {
                $results[] = $comparison;
            }
        }
        
        $tauxChange = $this->exchangeService->getRate('USD');
        $prixMoyenMarche = array_sum(array_column($this->commodityPrices, 'price')) / count($this->commodityPrices);
        
        return [
            'produits_comparables' => count($results),
            'produits_competitifs' => count(array_filter($results, fn($r) => strpos($r['competitivite'], 'compétitif') !== false)),
            'prix_moyen_marche' => round($prixMoyenMarche, 2),
            'details' => $results
        ];
    }
}