<?php

namespace App\Repository;

use App\Entity\AffectationTravail;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AffectationTravail>
 */
class AffectationTravailRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AffectationTravail::class);
    }

    public function findByWorkType(string $type): array
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.type_travail LIKE :type')
            ->setParameter('type', '%' . $type . '%')
            ->orderBy('a.date_debut', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function findUpcomingAssignments(\DateTimeInterface $fromDate): array
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.date_debut >= :fromDate')
            ->setParameter('fromDate', $fromDate)
            ->orderBy('a.date_debut', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
