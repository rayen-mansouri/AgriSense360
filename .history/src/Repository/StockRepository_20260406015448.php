<?php

namespace App\Repository;

use App\Entity\Stock;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

// ============================================================
// ERREURS CORRIGÉES :
//
// 1. Repository vide généré par le reverse engineering → méthodes
//    findFiltered(), findAllWithProduit(), findAlertes(),
//    findRuptures(), findExpiringSoon(), searchByProduit()
//    ajoutées (requises par GestionController, NotificationService, PdfService)
// 2. Les jointures utilisent désormais 's.produit' (objet) au lieu
//    de 's.produit_id' (scalaire supprimé) → cohérent avec l'entité corrigée
// ============================================================

class StockRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Stock::class);
    }

    /**
     * Recherche + tri multi-critères sur les stocks.
     * Utilisé par le dashboard et les exports PDF.
     *
     * @param string $search Terme de recherche (nom produit, emplacement, unité)
     * @param string $sort   Champ de tri
     * @param string $dir    'asc' | 'desc'
     */
    public function findFiltered(
        string $search = '',
        string $sort   = 'produit',
        string $dir    = 'asc'
    ): array {
        $dir = strtolower($dir) === 'desc' ? 'DESC' : 'ASC';

        $qb = $this->createQueryBuilder('s')
            ->leftJoin('s.produit', 'p')
            ->addSelect('p');

        if ($search !== '') {
            $qb->where('p.nom LIKE :q OR s.emplacement LIKE :q OR s.unite_mesure LIKE :q OR p.categorie LIKE :q')
               ->setParameter('q', '%'.$search.'%');
        }

        match ($sort) {
            'produit'           => $qb->orderBy('p.nom', $dir),
            'quantiteActuelle',
            'quantite_actuelle' => $qb->orderBy('s.quantite_actuelle', $dir),
            'seuilAlerte',
            'seuil_alerte'      => $qb->orderBy('s.seuil_alerte', $dir),
            'uniteMesure',
            'unite_mesure'      => $qb->orderBy('s.unite_mesure', $dir),
            'dateExpiration',
            'date_expiration'   => $qb->orderBy('s.date_expiration', $dir),
            'emplacement'       => $qb->orderBy('s.emplacement', $dir),
            default             => $qb->orderBy('p.nom', $dir),
        };

        return $qb->getQuery()->getResult();
    }

    /**
     * Tous les stocks avec leur produit chargé (évite les requêtes N+1).
     */
    public function findAllWithProduit(): array
    {
        return $this->createQueryBuilder('s')
            ->leftJoin('s.produit', 'p')
            ->addSelect('p')
            ->orderBy('p.nom', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Stocks dont quantite_actuelle ≤ seuil_alerte (inclut les ruptures).
     */
    public function findAlertes(): array
    {
        return $this->createQueryBuilder('s')
            ->leftJoin('s.produit', 'p')
            ->addSelect('p')
            ->where('s.seuil_alerte IS NOT NULL')
            ->andWhere('s.quantite_actuelle <= s.seuil_alerte')
            ->orderBy('s.quantite_actuelle', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Stocks à zéro (ruptures totales).
     */
    public function findRuptures(): array
    {
        return $this->createQueryBuilder('s')
            ->leftJoin('s.produit', 'p')
            ->addSelect('p')
            ->where('s.quantite_actuelle = 0')
            ->getQuery()
            ->getResult();
    }

    /**
     * Stocks dont la date d'expiration est dans les $days prochains jours.
     */
    public function findExpiringSoon(int $days = 30): array
    {
        $limit = new \DateTime("+{$days} days");

        return $this->createQueryBuilder('s')
            ->leftJoin('s.produit', 'p')
            ->addSelect('p')
            ->where('s.date_expiration IS NOT NULL')
            ->andWhere('s.date_expiration <= :limit')
            ->andWhere('s.date_expiration >= :today')
            ->setParameter('limit', $limit)
            ->setParameter('today', new \DateTime())
            ->orderBy('s.date_expiration', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Recherche par nom de produit, emplacement ou unité.
     */
    public function searchByProduit(string $query): array
    {
        return $this->findFiltered($query);
    }
}
