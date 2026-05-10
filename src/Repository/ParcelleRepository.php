<?php

namespace App\Repository;

use App\Entity\Parcelle;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Replaces your Java ParcelleService DB queries.
 * Doctrine handles the SQL — you call methods like findAll(), find($id), etc.
 */
class ParcelleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Parcelle::class);
    }

    /**
     * Find parcelles by statut (Libre / Occupée)
     */
    public function findByStatut(string $statut): array
    {
        return $this->createQueryBuilder('p')
            ->where('p.statut = :statut')
            ->setParameter('statut', $statut)
            ->orderBy('p.nom', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Search parcelles by name or location
     */
    public function search(string $term): array
    {
        return $this->createQueryBuilder('p')
            ->where('p.nom LIKE :term OR p.localisation LIKE :term')
            ->setParameter('term', '%' . $term . '%')
            ->orderBy('p.nom', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
