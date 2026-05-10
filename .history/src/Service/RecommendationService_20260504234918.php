<?php
namespace App\Service;

use App\Entity\Produit;
use App\Repository\ProduitRepository;
use App\Repository\StockRepository;

class RecommendationService
{
    private const COMPLEMENTARY = [
        'Semences'               => ['Engrais', 'Irrigation', 'Pesticides'],
        'Engrais'                => ['Semences', 'Pesticides', 'Produits phytosanitaires'],
        'Pesticides'             => ['Engrais', 'Produits phytosanitaires', 'Semences'],
        'Irrigation'             => ['Semences', 'Outils & Matériel', 'Engrais'],
        'Outils & Matériel'     => ['Irrigation', 'Alimentation animale'],
        'Alimentation animale'  => ['Outils & Matériel', 'Semences'],
        'Produits phytosanitaires' => ['Pesticides', 'Engrais', 'Semences'],
        'Autre'                 => ['Engrais', 'Semences'],
    ];

    public function __construct(
        private ProduitRepository $produitRepo,
        //private StockRepository $stockRepo,
    ) {}

    public function recommend(Produit $source, int $limit = 3): array
    {
        $scored = [];
        foreach ($this->produitRepo->findAll() as $candidate) {
            if ($candidate->getId() === $source->getId()) continue;
            $score = 0; $reason = '';

            if ($candidate->getCategorie() === $source->getCategorie()) {
                $score += 40; $reason = 'Même catégorie : '.$source->getCategorie();
            }
            $comp = self::COMPLEMENTARY[$source->getCategorie()] ?? [];
            if (in_array($candidate->getCategorie(), $comp)) {
                $score += 30;
                $reason = $reason ?: 'Complément idéal pour votre '.$source->getCategorie();
            }
            $s = $candidate->getStockActuel();
            if ($s && (float)$s->getQuantiteActuelle() > 0) {
                $score += $s->isEnAlerte() ? 5 : 15;
            }
            $srcP = (float)$source->getPrixUnitaire();
            $candP = (float)$candidate->getPrixUnitaire();
            if ($srcP > 0 && $candP / $srcP >= 0.7 && $candP / $srcP <= 1.3) $score += 10;

            if ($score > 0) $scored[] = ['produit' => $candidate, 'score' => $score,
                'reason' => $reason ?: 'Produit populaire dans notre catalogue', 'stock' => $s];
        }
        
        // CORRECTION LIGNE 53 : Ajouter l'annotation de type
        /** @var array<array{produit: Produit, score: int, reason: string, stock: mixed}> $scored */
        usort($scored, function($a, $b) {
            return $b['score'] <=> $a['score'];
        });
        
        return array_slice($scored, 0, $limit);
    }

    public function recommendGeneral(int $limit = 6): array
    {
        $produits = $this->produitRepo->createQueryBuilder('p')
        ->leftJoin('p.stocks', 's')
        ->addSelect('s')  // ← Charge les stocks immédiatement
        ->setMaxResults($limit * 2)  // Un peu plus pour avoir de la marge
        ->getQuery()
        ->getResult();

        $scored = []; 
        $cats = [];
        
        foreach ($this->produitRepo->findAll() as $p) {
            $score = 0; $reason = 'Produit recommandé';
            $s = $p->getStockActuel();
            if ($s && (float)$s->getQuantiteActuelle() > 0) {
                $score += $s->isEnAlerte() ? 5 : 30;
                $reason = $s->isEnAlerte() ? 'Dernières unités disponibles' : 'Stock disponible immédiatement';
            }
            $days = $p->getCreatedAt() ? (new \DateTime())->diff($p->getCreatedAt())->days : 999;
            if ($days <= 7) { $score += 20; $reason = 'Nouveau produit !'; }
            elseif ($days <= 30) $score += 10;
            $score += rand(0, 5);
            if ($score > 0) $scored[] = ['produit' => $p, 'score' => $score, 'reason' => $reason, 'stock' => $s];
        }
        
        // CORRECTION LIGNE 73 : Ajouter l'annotation de type
        /** @var array<array{produit: Produit, score: int, reason: string, stock: mixed}> $scored */
        usort($scored, function($a, $b) {
            return $b['score'] <=> $a['score'];
        });
        
        $result = [];
        foreach ($scored as $item) {
            $cat = $item['produit']->getCategorie();
            if (($cats[$cat] ?? 0) < 2) {
                $result[] = $item; 
                $cats[$cat] = ($cats[$cat] ?? 0) + 1;
                if (count($result) >= $limit) break;
            }
        }
        return $result;
    }
}