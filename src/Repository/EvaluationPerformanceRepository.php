<?php

namespace App\Repository;

use App\Entity\EvaluationPerformance;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<EvaluationPerformance>
 */
class EvaluationPerformanceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EvaluationPerformance::class);
    }

    public function findByNote(int $minNote): array
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.note >= :minNote')
            ->setParameter('minNote', $minNote)
            ->orderBy('e.note', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function findByQuality(string $quality): array
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.qualite = :quality')
            ->setParameter('quality', $quality)
            ->orderBy('e.date_evaluation', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function findRecentEvaluations(\DateTimeInterface $sinceDate): array
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.date_evaluation >= :sinceDate')
            ->setParameter('sinceDate', $sinceDate)
            ->orderBy('e.date_evaluation', 'DESC')
            ->getQuery()
            ->getResult();
    }
}
