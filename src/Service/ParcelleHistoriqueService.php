<?php
namespace App\Service;

use App\Entity\ParcelleHistorique;
use Doctrine\ORM\EntityManagerInterface;

class ParcelleHistoriqueService
{
    public function __construct(private EntityManagerInterface $em) {}

    /**
     * Log a new historique action.
     */
    public function logAction(ParcelleHistorique $h): void
    {
        $this->em->persist($h);
        $this->em->flush();
    }

    /**
     * Get all history for a parcelle, newest first.
     */
    public function getHistoriqueByParcelle(int $parcelleId): array
    {
        return $this->em->getRepository(ParcelleHistorique::class)
            ->createQueryBuilder('h')
            ->where('h.parcelleId = :pid')
            ->setParameter('pid', $parcelleId)
            ->orderBy('h.dateAction', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Get history filtered by action type.
     */
    public function getHistoriqueByType(int $parcelleId, string $typeAction): array
    {
        return $this->em->getRepository(ParcelleHistorique::class)
            ->createQueryBuilder('h')
            ->where('h.parcelleId = :pid AND h.typeAction = :type')
            ->setParameter('pid', $parcelleId)
            ->setParameter('type', $typeAction)
            ->orderBy('h.dateAction', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Get counts by action type for a parcelle (used for stats bar).
     * Returns ['CULTURE_AJOUTEE'=>N, 'CULTURE_MODIFIEE'=>N, ...]
     */
    public function getStatsByParcelle(int $parcelleId): array
    {
        $rows = $this->em->getRepository(ParcelleHistorique::class)
            ->createQueryBuilder('h')
            ->select('h.typeAction, COUNT(h.id) as cnt')
            ->where('h.parcelleId = :pid')
            ->setParameter('pid', $parcelleId)
            ->groupBy('h.typeAction')
            ->getQuery()
            ->getResult();

        $stats = [
            'CULTURE_AJOUTEE'   => 0,
            'CULTURE_MODIFIEE'  => 0,
            'CULTURE_SUPPRIMEE' => 0,
            'RECOLTE'           => 0,
        ];
        foreach ($rows as $row) {
            $stats[$row['typeAction']] = (int)$row['cnt'];
        }
        return $stats;
    }

    /**
     * Convenience factory — mirrors Java Parcellehistorique constructor.
     */
    public static function makeLog(
        int $parcelleId,
        string $typeAction,
        ?int $cultureId,
        ?string $cultureNom,
        ?string $typeCulture,
        ?float $surface,
        ?string $etatAvant,
        ?string $etatApres,
        ?string $description,
        ?float $quantiteRecolte = null
    ): ParcelleHistorique {
        $h = new ParcelleHistorique();
        $h->setParcelleId($parcelleId)
          ->setTypeAction($typeAction)
          ->setCultureId($cultureId)
          ->setCultureNom($cultureNom)
          ->setTypeCulture($typeCulture)
          ->setSurface($surface)
          ->setEtatAvant($etatAvant)
          ->setEtatApres($etatApres)
          ->setDescription($description)
          ->setQuantiteRecolte($quantiteRecolte);
        return $h;
    }
}
