<?php
namespace App\Service;

use App\Entity\Parcelle;
use Doctrine\ORM\EntityManagerInterface;

class ParcelleService
{
    public function __construct(private EntityManagerInterface $em) {}

    public function createParcelle(Parcelle $p): void
    {
        $p->setSurfaceRestant($p->getSurface());
        $p->setStatut('Libre');
        $this->em->persist($p);
        $this->em->flush();
    }

    public function getAllParcelles(): array
    {
        return $this->em->getRepository(Parcelle::class)->findAll();
    }

    public function getParcelleById(int $id): ?Parcelle
    {
        return $this->em->getRepository(Parcelle::class)->find($id);
    }

    public function getRemainingParcelleSize(int $id): float
    {
        $p = $this->getParcelleById($id);
        return $p ? $p->getSurfaceRestant() : 0;
    }

    public function searchParcelles(string $term): array
    {
        return $this->em->getRepository(Parcelle::class)
            ->createQueryBuilder('p')
            ->where('p.nom LIKE :t OR p.localisation LIKE :t')
            ->setParameter('t', '%' . $term . '%')
            ->getQuery()->getResult();
    }

    public function updateParcelle(Parcelle $p): void
    {
        $this->recalculateSurfaceRestant($p->getId());
        $this->em->flush();
    }

    public function deleteParcelle(Parcelle $p): void
    {
        $this->em->remove($p);
        $this->em->flush();
    }

    public function recalculateSurfaceRestant(int $parcelleId): void
    {
        $p = $this->getParcelleById($parcelleId);
        if (!$p) return;

        $used = $this->em->createQuery(
            'SELECT COALESCE(SUM(c.surface), 0) FROM App\Entity\Culture c WHERE c.parcelle = :p'
        )->setParameter('p', $p)->getSingleScalarResult();

        $restant = max(0, $p->getSurface() - (float)$used);
        $p->setSurfaceRestant($restant);
        $p->setStatut($restant <= 0.01 ? 'Occupée' : 'Libre');
        $this->em->flush();
    }

    public function getTotalSurface(): float
    {
        return (float)$this->em->createQuery(
            'SELECT COALESCE(SUM(p.surface), 0) FROM App\Entity\Parcelle p'
        )->getSingleScalarResult();
    }
}