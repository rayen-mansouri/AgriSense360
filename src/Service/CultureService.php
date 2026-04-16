<?php
namespace App\Service;

use App\Entity\Culture;
use App\Entity\Parcelle;
use Doctrine\ORM\EntityManagerInterface;

class CultureService
{
    private const IMAGE_MAP = [
        'Blé'=>'ble.png','Maïs'=>'mais.png','Riz'=>'riz.png','Avoine'=>'avoine.png',
        'Tomates'=>'tomates.png','Salades'=>'salades.png','Pomme de terre'=>'pomme_de_terre.png',
        'Carottes'=>'carottes.png','Oignon'=>'oignon.png','Lentille'=>'lentille.png',
        'Pomme'=>'pomme.png','Pêche'=>'peche.png','Orange'=>'orange.png',
        'Fraise'=>'fraise.png','Framboise'=>'framboise.png','Banane'=>'banane.png',
        'Rosier'=>'rosier.png','Tulipe'=>'tulipe.png','Jasmin'=>'jasmin.png',
        'Laurier-rose'=>'laurier_rose.png',
    ];

    private const DURATIONS = [
        'Maïs'          => [30,  60,  30],
        'Riz'           => [25,  90,  30],
        'Blé'           => [20,  80,  30],
        'Avoine'        => [20,  70,  25],
        'Tomates'       => [20,  60,  20],
        'Salades'       => [10,  40,  15],
        'Pomme de terre'=> [20,  70,  25],
        'Carottes'      => [15,  60,  20],
        'Oignon'        => [15,  70,  20],
        'Lentille'      => [15,  55,  20],
        'Pomme'         => [30, 100,  50],
        'Pêche'         => [30,  90,  40],
        'Orange'        => [30, 120,  60],
        'Fraise'        => [15,  50,  25],
        'Framboise'     => [15,  50,  25],
        'Banane'        => [30, 150,  60],
        'Rosier'        => [20,  60,  40],
        'Tulipe'        => [15,  45,  30],
        'Jasmin'        => [20,  55,  35],
        'Laurier-rose'  => [20,  65,  40],
    ];

    public function __construct(
        private EntityManagerInterface $em,
        private ParcelleService $parcelleService,
        private MailService $mailService,          // ← injected automatically
    ) {}

    public static function getImageForNom(string $nom): string
    {
        return self::IMAGE_MAP[$nom] ?? 'default.png';
    }

    public static function getDuration(string $nom): int
    {
        $phases = self::DURATIONS[$nom] ?? [20, 50, 20];
        return array_sum($phases);
    }

    public static function getPhases(string $nom): array
    {
        return self::DURATIONS[$nom] ?? [20, 50, 20];
    }

    public static function calculateHarvestDate(\DateTimeInterface $dp, string $nom): \DateTime
    {
        $days = self::getDuration($nom);
        $date = \DateTime::createFromInterface($dp);
        $date->modify("+{$days} days");
        return $date;
    }

    public static function calculateEtat(\DateTimeInterface $dp, \DateTimeInterface $dr, string $nom = ''): string
    {
        $today   = new \DateTime('today');
        $start   = \DateTime::createFromInterface($dp);
        $end     = \DateTime::createFromInterface($dr);

        $daysUntilHarvest    = (int)$today->diff($end)->days * ($today <= $end ? 1 : -1);
        $daysSincePlantation = (int)$start->diff($today)->days;

        if ($daysUntilHarvest < 0)  return 'Récolte en Retard';
        if ($daysUntilHarvest <= 7) return 'Récolte Prévue';

        $phases = self::DURATIONS[$nom] ?? [20, 50, 20];
        if ($daysSincePlantation < $phases[0])              return 'Semis';
        if ($daysSincePlantation < $phases[0] + $phases[1]) return 'Croissance';
        return 'Maturité';
    }

    public static function getEtatClass(string $etat): string
    {
        $l = mb_strtolower($etat);
        if (str_contains($l, 'retard'))                                return 'etat-recolte-en-retard';
        if (str_contains($l, 'prévue') || str_contains($l, 'prevue')) return 'etat-recolte-prevue';
        if (str_contains($l, 'maturit'))                               return 'etat-maturite';
        if (str_contains($l, 'croiss'))                                return 'etat-croissance';
        return 'etat-semis';
    }

    // ── CREATE ────────────────────────────────────────────────────────
    public function createCulture(Culture $c, Parcelle $parcelle): array
    {
        if (!trim($c->getNom()))
            return ['ok'=>false,'error'=>'❌ Veuillez sélectionner un nom de culture'];
        if (!$c->getTypeCulture())
            return ['ok'=>false,'error'=>'❌ Veuillez sélectionner un type de culture'];
        if (!$c->getDatePlantation())
            return ['ok'=>false,'error'=>'❌ Date de plantation requise'];
        if (!$c->getDateRecolte())
            return ['ok'=>false,'error'=>'❌ Date de récolte requise'];
        if ($c->getDateRecolte() <= $c->getDatePlantation())
            return ['ok'=>false,'error'=>'❌ Date récolte doit être après plantation'];
        if (!$c->getSurface() || $c->getSurface() <= 0)
            return ['ok'=>false,'error'=>'❌ Surface doit être positive'];

        $remaining = $parcelle->getSurfaceRestant();
        if ($c->getSurface() > $remaining + 0.01)
            return ['ok'=>false,'error'=>sprintf('❌ Surface trop grande! Restant: %.2f m²', $remaining)];

        $c->setEtat(self::calculateEtat($c->getDatePlantation(), $c->getDateRecolte(), $c->getNom()));
        if (!$c->getImg()) $c->setImg(self::getImageForNom($c->getNom()));
        $c->setParcelle($parcelle);

        $this->em->persist($c);
        $this->em->flush();
        $this->parcelleService->recalculateSurfaceRestant($parcelle->getId());

        // ── Auto-alert if harvest is today or already alerting ────────
        $this->checkAndSendAlert($c);

        return ['ok'=>true];
    }

    // ── READ ──────────────────────────────────────────────────────────
    public function getAllCultures(): array
    {
        return $this->em->getRepository(Culture::class)->findAll();
    }

    public function getCulturesHarvestingToday(): array
    {
        $today = new \DateTime('today');

        return $this->em->getRepository(Culture::class)
            ->createQueryBuilder('c')
            ->where('c.dateRecolte = :today')
            ->setParameter('today', $today->format('Y-m-d'))
            ->orderBy('c.nom', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function getCultureById(int $id): ?Culture
    {
        return $this->em->getRepository(Culture::class)->find($id);
    }

    public function getCulturesByParcelle(int $parcelleId): array
    {
        return $this->em->getRepository(Culture::class)->findBy(['parcelle' => $parcelleId]);
    }

    public function searchCultures(string $term): array
    {
        return $this->em->getRepository(Culture::class)
            ->createQueryBuilder('c')
            ->where('c.nom LIKE :t')
            ->setParameter('t', '%'.$term.'%')
            ->getQuery()->getResult();
    }

    // ── UPDATE ────────────────────────────────────────────────────────
    public function updateCulture(Culture $c, Parcelle $newParcelle, Parcelle $oldParcelle, float $oldSurface): array
    {
        if (!trim($c->getNom()))
            return ['ok'=>false,'error'=>'❌ Nom de culture requis'];
        if (!$c->getSurface() || $c->getSurface() <= 0)
            return ['ok'=>false,'error'=>'❌ Surface doit être positive'];
        if (!$c->getDatePlantation() || !$c->getDateRecolte())
            return ['ok'=>false,'error'=>'❌ Les deux dates sont requises'];
        if ($c->getDateRecolte() <= $c->getDatePlantation())
            return ['ok'=>false,'error'=>'❌ Date récolte doit être après plantation'];

        $sameParcelle = $oldParcelle->getId() === $newParcelle->getId();
        $available = $sameParcelle
            ? $newParcelle->getSurfaceRestant() + $oldSurface
            : $newParcelle->getSurfaceRestant();

        if ($c->getSurface() > $available + 0.01)
            return ['ok'=>false,'error'=>sprintf('❌ Surface trop grande! Disponible: %.2f m²', $available)];

        $c->setEtat(self::calculateEtat($c->getDatePlantation(), $c->getDateRecolte(), $c->getNom()));
        $c->setImg(self::getImageForNom($c->getNom()));
        $c->setParcelle($newParcelle);

        $this->em->flush();

        if (!$sameParcelle)
            $this->parcelleService->recalculateSurfaceRestant($oldParcelle->getId());
        $this->parcelleService->recalculateSurfaceRestant($newParcelle->getId());

        // ── Auto-alert after update too ───────────────────────────────
        $this->checkAndSendAlert($c);

        return ['ok'=>true];
    }

    // ── DELETE ────────────────────────────────────────────────────────
    public function deleteCulture(Culture $c): void
    {
        $parcelleId = $c->getParcelle()->getId();
        $this->em->remove($c);
        $this->em->flush();
        $this->parcelleService->recalculateSurfaceRestant($parcelleId);
    }

    // ── Refresh ALL états on page load ────────────────────────────────
    /**
     * Call this from your controller on every page load.
     * It recalculates états AND fires alerts for any culture
     * whose dateRecolte is today or already passed.
     */
    public function refreshAllEtats(): void
    {
        foreach ($this->getAllCultures() as $c) {
            if ($c->getDatePlantation() && $c->getDateRecolte()) {
                $c->setEtat(self::calculateEtat(
                    $c->getDatePlantation(),
                    $c->getDateRecolte(),
                    $c->getNom()
                ));
                // ── Fire alert if harvest is today ────────────────────
                $this->checkAndSendAlert($c);
            }
        }
        $this->em->flush();
    }

    // ── Stats ─────────────────────────────────────────────────────────
    public function getStats(): array
    {
        $all = $this->getAllCultures();
        return [
            'total'  => count($all),
            'retard' => count(array_filter($all, fn($c) => $c->getEtat() === 'Récolte en Retard')),
            'pretes' => count(array_filter($all, fn($c) => in_array($c->getEtat(), ['Maturité','Récolte Prévue']))),
        ];
    }

    // ═════════════════════════════════════════════════════════════════
    //  PRIVATE — Alert logic
    // ═════════════════════════════════════════════════════════════════

    /**
     * Sends a culture alert email when:
     *  - dateRecolte is TODAY  → "Récolte Prévue"  (harvest day)
     *  - dateRecolte is PAST   → "Récolte en Retard"
     *
     * Silent — never throws, never blocks the request.
     */
    private function checkAndSendAlert(Culture $c): void
    {
        $dr = $c->getDateRecolte();
        if (!$dr) return;

        $today = new \DateTime('today');
        $harvestDay = \DateTime::createFromInterface($dr)->setTime(0, 0, 0);

        // Only alert on harvest day or if overdue
        if ($harvestDay > $today) return;

        try {
            $this->mailService->sendCultureAlert($c);
        } catch (\Throwable) {
            // silent — mail failure must never crash the app
        }
    }
}