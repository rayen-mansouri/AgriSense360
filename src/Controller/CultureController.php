<?php
namespace App\Controller;

use App\Entity\Culture;
use App\Service\CultureService;
use App\Service\CultureWeatherLogService;
use App\Service\HarvestIaService;
use App\Service\ParcelleHistoriqueService;
use App\Service\ParcelleService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/culture')]
class CultureController extends AbstractController
{
    private const CULTURE_MAP = [
        'Céréales'     => ['Blé','Maïs','Riz','Avoine'],
        'Légumes'      => ['Tomates','Salades','Pomme de terre','Carottes','Oignon','Lentille'],
        'Fruits'       => ['Pomme','Pêche','Orange','Fraise','Framboise','Banane'],
        'Ornementales' => ['Rosier','Tulipe','Jasmin','Laurier-rose'],
    ];

    public function __construct(
        private CultureService            $cultureService,
        private ParcelleService           $parcelleService,
        private CultureWeatherLogService  $weatherLogService,
        private HarvestIaService          $harvestIaService,
        private ParcelleHistoriqueService $historiqueService,
        private EntityManagerInterface    $em,
    ) {}

    // ── INDEX ─────────────────────────────────────────────────────────────────

    #[Route('', name: 'culture_index', methods: ['GET'])]
    public function index(Request $request): Response
    {
        $this->cultureService->refreshAllEtats();

        $search = $request->query->get('search', '');
        $sort   = $request->query->get('sort', '');

        $cultures = $search
            ? $this->cultureService->searchCultures($search)
            : $this->cultureService->getAllCultures();

        usort($cultures, match($sort) {
            'type'    => fn($a,$b) => strcmp($a->getTypeCulture()??'',$b->getTypeCulture()??''),
            'etat'    => fn($a,$b) => strcmp($a->getEtat()??'',$b->getEtat()??''),
            'surface' => fn($a,$b) => $b->getSurface() <=> $a->getSurface(),
            default   => fn($a,$b) => $a->getId() <=> $b->getId(),
        });

        $parcelles   = $this->parcelleService->getAllParcelles();
        $parcelleMap = [];
        foreach ($parcelles as $p) $parcelleMap[$p->getId()] = $p->getNom();

        return $this->render('culture/culture_index.html.twig', [
            'cultures'    => $cultures,
            'parcelles'   => $parcelles,
            'parcelleMap' => $parcelleMap,
            'search'      => $search,
            'sort'        => $sort,
            'cultureMap'  => self::CULTURE_MAP,
        ]);
    }

    // ── ANALYTICS ─────────────────────────────────────────────────────────────

    #[Route('/analytics', name: 'culture_analytics', methods: ['GET'])]
    public function analytics(): Response
    {
        $harvests = $this->em->getRepository(\App\Entity\ParcelleHistorique::class)
            ->createQueryBuilder('h')
            ->where('h.typeAction = :type')
            ->setParameter('type', 'RECOLTE')
            ->orderBy('h.dateAction', 'DESC')
            ->getQuery()
            ->getResult();

        return $this->render('culture/analytics.html.twig', [
            'harvests' => $harvests,
        ]);
    }

    // ── IA PREVIEW (AJAX) ─────────────────────────────────────────────────────
    //
    // Called by JS openHarvestModal() via fetch('/culture/{id}/ia-preview').
    // NEVER returns qty=0 — the PHP fallback always computes from surface + lateness.
    // ─────────────────────────────────────────────────────────────────────────

    #[Route('/{id}/ia-preview', name: 'culture_ia_preview', methods: ['GET'], requirements: ['id' => '\d+'])]
    public function iaPreview(int $id): Response
    {
        $culture = $this->cultureService->getCultureById($id);
        if (!$culture) {
            return $this->json(['error' => 'Culture introuvable'], 404);
        }

        try {
            $logs           = $this->weatherLogService->getLogsForCulture($id);
            $logsCount      = count($logs);
            $weatherSummary = $this->weatherLogService->buildWeatherSummary($logs);
            $result         = $this->harvestIaService->compute($culture, $weatherSummary, $logsCount);
        } catch (\Throwable $e) {
            // Absolute safety net — if IA completely crashes, use the surface-only estimate
            // so the quantity is NEVER 0 from a crash
            $surface   = $culture->getSurface() ?? 1.0;
            $daysLate  = $culture->getDaysLate();
            $baseYield = 2.0 * $surface; // conservative default
            $lateness  = $daysLate > 0 ? max(0.40, 1.0 - $daysLate * 0.02) : 1.0;
            $qty       = round($baseYield * $lateness * 0.85, 2);
            $result    = [
                'quantite'      => $qty,
                'iaScore'       => round($lateness * 85, 1),
                'baseYield'     => round($baseYield, 2),
                'latenessScore' => round($lateness * 100, 1),
                'weatherScore'  => 85.0,
                'latenessDays'  => $daysLate,
                'logsCount'     => 0,
                'confidence'    => 'Estimation basique (erreur interne)',
                'source'        => 'emergency_fallback',
                'breakdown'     => [
                    ['icon'=>'⚠️','label'=>'Erreur IA : '.$e->getMessage(),'impact'=>'Estimation basée sur la surface uniquement','type'=>'warning'],
                ],
            ];
        }

        return $this->json($result);
    }

    // ── IA HARVEST CONFIRM ────────────────────────────────────────────────────
    //
    // CRITICAL: We do NOT call cultureService.updateCulture() here.
    // That method recalculates etat (overwriting Récolte) and validates dates.
    // Instead we:
    //   1. Log RECOLTE to parcelle_historique BEFORE deleting
    //   2. Delete the culture from DB (it lives on in historique)
    //   3. Recalculate surfaceRestant on the parcelle
    // ─────────────────────────────────────────────────────────────────────────

    #[Route('/{id}/harvest', name: 'culture_harvest', methods: ['POST'], requirements: ['id' => '\d+'])]
    public function harvest(int $id, Request $request): Response
    {
        $culture = $this->cultureService->getCultureById($id);
        if (!$culture) throw $this->createNotFoundException();

        if (!$this->isCsrfTokenValid('harvest-culture-'.$id, $request->request->get('_token'))) {
            $this->addFlash('error', '❌ Token CSRF invalide. Veuillez réessayer.');
            return $this->redirectToRoute('culture_index');
        }

        $qty     = (float) $request->request->get('quantite_recolte', 0);
        $iaScore = (float) $request->request->get('ia_score', 0);
        $source  = $request->request->get('ia_source', 'php_fallback');

        // Safety: if qty or score are 0 (modal wasn't filled properly), recompute now
        if ($qty <= 0 || $iaScore <= 0) {
            try {
                $logs           = $this->weatherLogService->getLogsForCulture($id);
                $logsCount      = count($logs);
                $weatherSummary = $this->weatherLogService->buildWeatherSummary($logs);
                $computed       = $this->harvestIaService->compute($culture, $weatherSummary, $logsCount);
                $qty     = $computed['quantite'];
                $iaScore = $computed['iaScore'];
                $source  = $computed['source'];
            } catch (\Throwable) {
                // Absolute fallback: surface × 2 kg/m² × lateness
                $surface  = $culture->getSurface() ?? 1.0;
                $daysLate = $culture->getDaysLate();
                $lateness = $daysLate > 0 ? max(0.40, 1.0 - $daysLate * 0.02) : 1.0;
                $qty      = round(2.0 * $surface * $lateness * 0.85, 2);
                $iaScore  = round($lateness * 85, 1);
                $source   = 'emergency_fallback';
            }
        }

        $sourceLabel = match($source) {
            'ml'               => 'ML Python',
            'php_fallback'     => 'Formule PHP',
            'formula'          => 'Formule PHP',
            'formula_fallback' => 'Formule PHP (ML en panne)',
            default            => 'Formule PHP',
        };

        // Snapshot everything BEFORE the delete
        $parcelleId  = $culture->getParcelle()->getId();
        $cultureNom  = $culture->getNom();
        $typeCulture = $culture->getTypeCulture();
        $surface     = $culture->getSurface() ?? 0;
        $etatAvant   = $culture->getEtat();

        // 1. Log RECOLTE in historique FIRST (before delete so IDs are still valid)
        $this->historiqueService->logAction(
            ParcelleHistoriqueService::makeLog(
                $parcelleId,
                'RECOLTE',
                $culture->getId(),
                $cultureNom,
                $typeCulture,
                $surface,
                $etatAvant,
                'Récolté',
                "Récolte IA ({$sourceLabel}) · Quantité : {$qty} kg · Score qualité : {$iaScore}%",
                $qty
            )
        );

        // 2. Delete culture from DB (only lives in historique now)
        $this->em->remove($culture);
        $this->em->flush();

        // 3. Recalculate surfaceRestant
        $this->parcelleService->recalculateSurfaceRestant($parcelleId);

        $this->addFlash(
            'success',
            "🌾 \"{$cultureNom}\" récoltée ! Quantité IA : {$qty} kg · Score : {$iaScore}%"
        );

        return $this->redirectToRoute('culture_index');
    }

    // ── Standard CRUD routes (unchanged) ─────────────────────────────────────

    #[Route('/new', name: 'culture_new', methods: ['POST'])]
    public function new(Request $request): Response
    {
        $type       = $request->request->get('type_culture', '');
        $nom        = trim($request->request->get('nom', ''));
        $dpStr      = $request->request->get('date_plantation', '');
        $drStr      = $request->request->get('date_recolte', '');
        $surfaceTxt = $request->request->get('surface', '');
        $parcelleId = (int)$request->request->get('parcelle_id', 0);

        $parcelle = $this->parcelleService->getParcelleById($parcelleId);
        if (!$parcelle) {
            $this->addFlash('error', '❌ Veuillez sélectionner une parcelle valide');
            return $this->redirectToRoute('culture_index', ['modal'=>'add']);
        }

        $c = new Culture();
        $c->setNom($nom)->setTypeCulture($type);
        if ($dpStr) $c->setDatePlantation(new \DateTime($dpStr));

        if ($drStr) {
            $c->setDateRecolte(new \DateTime($drStr));
        } elseif ($dpStr && $nom) {
            $c->setDateRecolte(CultureService::calculateHarvestDate(new \DateTime($dpStr), $nom));
        }

        if (is_numeric($surfaceTxt)) $c->setSurface((float)$surfaceTxt);

        $result = $this->cultureService->createCulture($c, $parcelle);
        if ($result['ok']) {
            $this->addFlash('success', '✅ Culture "'.$nom.'" ajoutée avec succès!');
            return $this->redirectToRoute('culture_index');
        }

        $this->addFlash('error', $result['error']);
        return $this->redirectToRoute('culture_index', ['modal'=>'add']);
    }

    #[Route('/{id}/edit', name: 'culture_edit', methods: ['POST'], requirements: ['id'=>'\d+'])]
    public function edit(int $id, Request $request): Response
    {
        $culture = $this->cultureService->getCultureById($id);
        if (!$culture) throw $this->createNotFoundException();

        $oldParcelle = $culture->getParcelle();
        $oldSurface  = $culture->getSurface() ?? 0;

        $requestedParcelleId = (int)$request->request->get('parcelle_id', 0);
        if ($requestedParcelleId === 0) $requestedParcelleId = $oldParcelle->getId();

        $newParcelle = $this->parcelleService->getParcelleById($requestedParcelleId);
        if (!$newParcelle) {
            $this->addFlash('error', '❌ Parcelle invalide');
            return $this->redirectToRoute('culture_index', ['edit_id'=>$id]);
        }

        $dpStr      = $request->request->get('date_plantation', '');
        $drStr      = $request->request->get('date_recolte', '');
        $surfaceTxt = $request->request->get('surface', '');
        $nom        = trim($request->request->get('nom', ''));

        $culture->setNom($nom)->setTypeCulture($request->request->get('type_culture', ''));
        if ($dpStr) $culture->setDatePlantation(new \DateTime($dpStr));

        if ($drStr) {
            $culture->setDateRecolte(new \DateTime($drStr));
        } elseif ($dpStr && $nom) {
            $culture->setDateRecolte(CultureService::calculateHarvestDate(new \DateTime($dpStr), $nom));
        }

        if (is_numeric($surfaceTxt)) $culture->setSurface((float)$surfaceTxt);

        $result = $this->cultureService->updateCulture($culture, $newParcelle, $oldParcelle, $oldSurface);
        if ($result['ok']) {
            $this->addFlash('success', '✅ Culture modifiée avec succès!');
            return $this->redirectToRoute('culture_index');
        }

        $this->addFlash('error', $result['error']);
        return $this->redirectToRoute('culture_index', ['edit_id'=>$id, 'edit_error'=>1]);
    }

    #[Route('/{id}/delete', name: 'culture_delete', methods: ['POST'], requirements: ['id'=>'\d+'])]
    public function delete(int $id, Request $request): Response
    {
        $culture = $this->cultureService->getCultureById($id);
        if (!$culture) throw $this->createNotFoundException();

        if ($this->isCsrfTokenValid('del-culture-'.$id, $request->request->get('_token'))) {
            $nom = $culture->getNom();
            $this->cultureService->deleteCulture($culture);
            $this->addFlash('success', '✅ Culture "'.$nom.'" supprimée avec succès!');
        }
        return $this->redirectToRoute('culture_index');
    }

    #[Route('/{id}/details', name: 'culture_details', methods: ['GET'], requirements: ['id'=>'\d+'])]
    public function details(int $id): Response
    {
        $culture = $this->cultureService->getCultureById($id);
        if (!$culture) throw $this->createNotFoundException();

        $parcelle = $this->parcelleService->getParcelleById($culture->getParcelle()->getId());

        return $this->render('culture/details.html.twig', [
            'culture'  => $culture,
            'parcelle' => $parcelle,
        ]);
    }

    #[Route('/harvest-date', name: 'culture_harvest_date', methods: ['GET'])]
    public function harvestDate(Request $request): Response
    {
        $nom = $request->query->get('nom', '');
        $dp  = $request->query->get('date', '');

        if ($nom && $dp) {
            $harvest  = CultureService::calculateHarvestDate(new \DateTime($dp), $nom);
            $duration = CultureService::getDuration($nom);
            $phases   = CultureService::getPhases($nom);
            return $this->json([
                'date'     => $harvest->format('Y-m-d'),
                'duration' => $duration,
                'phases'   => ['semis'=>$phases[0],'croissance'=>$phases[1],'maturite'=>$phases[2]],
            ]);
        }
        return $this->json(['date'=>null]);
    }
}