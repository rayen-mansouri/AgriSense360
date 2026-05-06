<?php

namespace App\Repository;

use App\Entity\Culture;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class CultureRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Culture::class);
    }

    /**
     * Find cultures by parcelle ID
     */
    public function findByParcelle(int $parcelleId): array
    {
        return $this->createQueryBuilder('c')
            ->where('c.parcelle = :pid')
            ->setParameter('pid', $parcelleId)
            ->getQuery()
            ->getResult();
    }

    /**
     * Search cultures by name
     */
    public function search(string $term): array
    {
        return $this->createQueryBuilder('c')
            ->where('c.nom LIKE :term OR c.typeCulture LIKE :term')
            ->setParameter('term', '%' . $term . '%')
            ->getQuery()
            ->getResult();
    }

    /**
     * Find cultures with état "Récolte en Retard"
     */
    public function findRetard(): array
    {
        return $this->createQueryBuilder('c')
            ->where('c.etat = :etat')
            ->setParameter('etat', 'Récolte en Retard')
            ->getQuery()
            ->getResult();
    }
}
