<?php

namespace App\Repository;

use App\Entity\Animalhealthrecord;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class AnimalhealthrecordRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Animalhealthrecord::class);
    }

    // Add custom methods as needed
}