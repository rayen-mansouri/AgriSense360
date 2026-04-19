<?php

namespace App\Controller;

use App\Entity\ParcelleHistorique;
use App\Service\CultureService;
use App\Service\ParcelleService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    public function __construct(
        private ParcelleService        $parcelleService,
        private CultureService         $cultureService,
        private EntityManagerInterface $em,              // NEW — injected for IA harvest queries
    ) {}

    #[Route('/', name: 'home')]
    public function index(): Response
    {
        $this->cultureService->refreshAllEtats();

        $parcelles = $this->parcelleService->getAllParcelles();
        $cultures  = $this->cultureService->getAllCultures();
        $stats     = $this->cultureService->getStats();

        // ── Surface stats ─────────────────────────────────────────────────────
        $totalSurface    = array_sum(array_map(fn($p) => $p->getSurface(), $parcelles));
        $surfaceRestante = array_sum(array_map(fn($p) => $p->getSurfaceRestant(), $parcelles));
        $surfaceUtilisee = $totalSurface - $surfaceRestante;
        $taux = $totalSurface > 0 ? round(($surfaceUtilisee / $totalSurface) * 100, 1) : 0;

        // ── État counts for chart ─────────────────────────────────────────────
        $etatCounts = [
            'Semis'              => 0,
            'Croissance'         => 0,
            'Maturité'           => 0,
            'Récolte Prévue'     => 0,
            'Récolte en Retard'  => 0,
        ];
        foreach ($cultures as $c) {
            $e = $c->getEtat() ?? 'Semis';
            if (array_key_exists($e, $etatCounts)) $etatCounts[$e]++;
        }

        // ── Type counts for chart ─────────────────────────────────────────────
        $typeCounts = [];
        foreach ($cultures as $c) {
            $t = $c->getTypeCulture() ?? 'Autre';
            $typeCounts[$t] = ($typeCounts[$t] ?? 0) + 1;
        }
        arsort($typeCounts);

        // ── Top parcelles ─────────────────────────────────────────────────────
        $parcelleStats = [];
        foreach ($parcelles as $p) {
            $parcelleStats[] = [
                'nom'            => $p->getNom(),
                'cultures'       => count($p->getCultures()),
                'surface'        => $p->getSurface(),
                'surfaceRestant' => $p->getSurfaceRestant(),
                'taux'           => $p->getTauxOccupation(),
                'statut'         => $p->getStatut(),
            ];
        }
        usort($parcelleStats, fn($a,$b) => $b['cultures'] <=> $a['cultures']);
        $topParcelles = array_slice($parcelleStats, 0, 6);

        // ── Cultures ready to harvest ─────────────────────────────────────────
        $culturesRecolte = array_values(array_filter($cultures, fn($c) => in_array($c->getEtat(), [
            'Maturité', 'Récolte Prévue', 'Récolte en Retard'
        ])));
        $etatOrder = ['Récolte en Retard'=>0, 'Récolte Prévue'=>1, 'Maturité'=>2];
        usort($culturesRecolte, fn($a,$b) =>
            ($etatOrder[$a->getEtat()]??9) <=> ($etatOrder[$b->getEtat()]??9)
        );

        // ── Parcelle map ──────────────────────────────────────────────────────
        $parcelleMap = [];
        foreach ($parcelles as $p) $parcelleMap[$p->getId()] = $p->getNom();

        // ── NEW: IA Harvest stats from parcelle_historique ────────────────────
        $recolteRepo = $this->em->getRepository(ParcelleHistorique::class);

        // All RECOLTE entries — for KPI totals
        $allRecoltes = $recolteRepo->createQueryBuilder('h')
            ->where('h.typeAction = :type')
            ->setParameter('type', 'RECOLTE')
            ->getQuery()
            ->getResult();

        $totalRecoltes  = count($allRecoltes);
        $totalKgRecolte = array_sum(
            array_map(fn($h) => $h->getQuantiteRecolte() ?? 0, $allRecoltes)
        );

        // Last 12 harvests for the dashboard cards section (newest first)
        $recentRecoltes = $recolteRepo->createQueryBuilder('h')
            ->where('h.typeAction = :type')
            ->setParameter('type', 'RECOLTE')
            ->orderBy('h.dateAction', 'DESC')
            ->setMaxResults(12)
            ->getQuery()
            ->getResult();
        // ── END NEW ───────────────────────────────────────────────────────────

        return $this->render('home/index.html.twig', [
            // Existing variables (unchanged)
            'totalParcelles'  => count($parcelles),
            'totalCultures'   => $stats['total'],
            'tauxOccupation'  => $taux,
            'culturesRetard'  => $stats['retard'],
            'culturesPretes'  => $stats['pretes'],
            'surfaceTotal'    => $totalSurface,
            'surfaceUtilisee' => $surfaceUtilisee,
            'surfaceRestante' => $surfaceRestante,
            'etatCounts'      => $etatCounts,
            'typeCounts'      => $typeCounts,
            'topParcelles'    => $topParcelles,
            'culturesRecolte' => $culturesRecolte,
            'parcelleMap'     => $parcelleMap,

            // NEW: IA harvest data for dashboard
            'totalRecoltes'   => $totalRecoltes,
            'totalKgRecolte'  => round($totalKgRecolte, 1),
            'recentRecoltes'  => $recentRecoltes,
        ]);
    }
}