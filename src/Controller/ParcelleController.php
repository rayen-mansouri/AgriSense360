<?php
namespace App\Controller;

use App\Entity\Parcelle;
use App\Service\CultureService;
use App\Service\CultureWeatherLogService;
use App\Service\HarvestIaService;
use App\Service\ParcelleService;
use App\Service\WeatherService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/parcelle')]
class ParcelleController extends AbstractController
{
    private const GOUVERNORATS = [
        'Ariana','Béja','Ben Arous','Bizerte','Gabès','Gafsa','Jendouba',
        'Kairouan','Kasserine','Kébili','Le Kef','Mahdia','Manouba',
        'Médenine','Monastir','Nabeul','Sfax','Sidi Bouzid','Siliana',
        'Sousse','Tataouine','Tozeur','Tunis','Zaghouan',
    ];
    private const TYPES_SOL = ['Sol Limoneux','Sol Argileux','Sol Sablonneux'];

    // États that mean the culture is still actively growing (log weather for these)
    private const GROWING_ETATS = ['Semis', 'Croissance', 'Maturité', 'Récolte Prévue', 'Récolte en Retard'];

    public function __construct(
        private ParcelleService          $parcelleService,
        private CultureService           $cultureService,
        private WeatherService           $weatherService,
        private CultureWeatherLogService $weatherLogService,
        private HarvestIaService         $harvestIaService,   // ADDED
    ) {}

    #[Route('', name: 'parcelle_index', methods: ['GET'])]
    public function index(Request $request): Response
    {
        $search = $request->query->get('search', '');
        $sort   = $request->query->get('sort', '');

        $parcelles = $search
            ? $this->parcelleService->searchParcelles($search)
            : $this->parcelleService->getAllParcelles();

        usort($parcelles, match($sort) {
            'statut'  => fn($a,$b) => strcmp($a->getStatut()??'',$b->getStatut()??''),
            'surface' => fn($a,$b) => $b->getSurface() <=> $a->getSurface(),
            default   => fn($a,$b) => $a->getId() <=> $b->getId(),
        });

        return $this->render('parcelle/parcelle_index.html.twig', [
            'parcelles'    => $parcelles,
            'search'       => $search,
            'sort'         => $sort,
            'gouvernorats' => self::GOUVERNORATS,
            'typesSol'     => self::TYPES_SOL,
        ]);
    }

    /**
     * MODIFIED: now also logs today's weather for every active culture on this parcelle.
     * This is the passive logging path — fires silently on every page visit.
     */
    #[Route('/{id}', name: 'parcelle_show', methods: ['GET'], requirements: ['id'=>'\d+'])]
    public function show(int $id): Response
    {
        $parcelle = $this->parcelleService->getParcelleById($id);
        if (!$parcelle) throw $this->createNotFoundException();

        $cultures = $this->cultureService->getCulturesByParcelle($id);

        // Fetch weather for this parcelle's gouvernorat
        $weather = $parcelle->getLocalisation()
            ? $this->weatherService->getWeatherForLocation($parcelle->getLocalisation())
            : null;

        // ── NEW: passive weather logging ──────────────────────────────────────
        // For every GROWING culture on this parcelle, save today's weather snapshot.
        // Idempotent — safe to call on every page visit.
        if ($weather !== null) {
            foreach ($cultures as $culture) {
                if (in_array($culture->getEtat(), self::GROWING_ETATS, true)) {
                    try {
                        $this->weatherLogService->logTodayIfMissing($culture, $weather);
                    } catch (\Throwable) {
                        // Silent — never crash the page due to a logging failure
                    }
                }
            }
        }
        // ── END NEW ───────────────────────────────────────────────────────────

        return $this->render('parcelle/show.html.twig', [
            'parcelle' => $parcelle,
            'cultures' => $cultures,
            'weather'  => $weather,
        ]);
    }

    /**
     * GET /parcelle/culture/{id}/harvest-rapport
     *
     * READ-ONLY — computes and returns the IA harvest rapport as JSON.
     * Does NOT save anything. Called by the JS popup before the user confirms.
     *
     * Returns: { quantite, iaScore, latenessScore, weatherScore, rapport, confidence }
     */
    #[Route('/culture/{id}/harvest-rapport', name: 'culture_harvest_rapport', methods: ['GET'], requirements: ['id' => '\d+'])]
    public function harvestRapport(int $id): JsonResponse
    {
        $culture = $this->cultureService->getCultureById($id);
        if (!$culture) {
            return $this->json(['error' => 'Culture introuvable'], 404);
        }

        // Load weather logs accumulated for this culture
        $logs         = $this->weatherLogService->getLogsForCulture($id);
        $logsCount    = count($logs);
        $weatherSummary = $this->weatherLogService->buildWeatherSummary($logs);

        // Compute IA estimation (read-only, no DB write)
        $result = $this->harvestIaService->compute($culture, $weatherSummary, $logsCount);

        return $this->json([
            'quantite'      => $result['quantite'],
            'iaScore'       => $result['iaScore'],
            'latenessScore' => $result['latenessScore'],
            'weatherScore'  => $result['weatherScore'],
            'rapport'       => $result['rapport'],
            'confidence'    => $result['confidence'],
            'source'        => $result['source'],
        ]);
    }

    #[Route('/new', name: 'parcelle_new', methods: ['POST'])]
    public function new(Request $request): Response
    {
        $nom          = trim($request->request->get('nom', ''));
        $surfaceTxt   = $request->request->get('surface', '');
        $localisation = $request->request->get('localisation', '');
        $typeSol      = $request->request->get('type_sol', '');
        $statut       = $request->request->get('statut', 'Libre');

        $error = null;
        if (!$nom || strlen($nom) < 3)   $error = '❌ Nom invalide (minimum 3 caractères)';
        elseif (!is_numeric($surfaceTxt)) $error = '❌ Surface doit être un nombre';
        elseif ((float)$surfaceTxt <= 0)  $error = '❌ Surface doit être positive';
        elseif (!$localisation)           $error = '❌ Veuillez sélectionner un gouvernorat';
        elseif (!$typeSol)                $error = '❌ Veuillez sélectionner le type de sol';

        if ($error) {
            $this->addFlash('error', $error);
            return $this->redirectToRoute('parcelle_index', ['modal'=>'add']);
        }

        $p = new Parcelle();
        $p->setNom($nom)->setSurface((float)$surfaceTxt)
          ->setLocalisation($localisation)->setTypeSol($typeSol)->setStatut($statut);
        $this->parcelleService->createParcelle($p);

        $this->addFlash('success', '✅ Parcelle "'.$nom.'" ajoutée avec succès!');
        return $this->redirectToRoute('parcelle_index');
    }

    #[Route('/{id}/edit', name: 'parcelle_edit', methods: ['POST'], requirements: ['id'=>'\d+'])]
    public function edit(int $id, Request $request): Response
    {
        $parcelle = $this->parcelleService->getParcelleById($id);
        if (!$parcelle) throw $this->createNotFoundException();

        $nom          = trim($request->request->get('nom', ''));
        $surfaceTxt   = $request->request->get('surface', '');
        $localisation = $request->request->get('localisation', '');
        $typeSol      = $request->request->get('type_sol', '');
        $statut       = $request->request->get('statut', 'Libre');

        $error = null;
        if (!$nom || strlen($nom) < 3)   $error = '❌ Nom invalide (minimum 3 caractères)';
        elseif (!is_numeric($surfaceTxt)) $error = '❌ Surface doit être un nombre';
        elseif ((float)$surfaceTxt <= 0)  $error = '❌ Surface doit être positive';
        elseif (!$localisation)           $error = '❌ Veuillez sélectionner un gouvernorat';
        elseif (!$typeSol)                $error = '❌ Veuillez sélectionner le type de sol';
        elseif ($statut === 'Libre' && $this->parcelleService->getRemainingParcelleSize($id) <= 0.01)
            $error = '❌ Impossible! Surface complètement occupée (0 m² restant)';

        if ($error) {
            $this->addFlash('error', $error);
            return $this->redirectToRoute('parcelle_index', ['edit_id'=>$id, 'edit_error'=>1]);
        }

        $parcelle->setNom($nom)->setSurface((float)$surfaceTxt)
                 ->setLocalisation($localisation)->setTypeSol($typeSol)->setStatut($statut);
        $this->parcelleService->updateParcelle($parcelle);

        $this->addFlash('success', '✅ Parcelle modifiée avec succès!');
        return $this->redirectToRoute('parcelle_index');
    }

    #[Route('/{id}/delete', name: 'parcelle_delete', methods: ['POST'], requirements: ['id'=>'\d+'])]
    public function delete(int $id, Request $request): Response
    {
        $parcelle = $this->parcelleService->getParcelleById($id);
        if (!$parcelle) throw $this->createNotFoundException();

        if ($this->isCsrfTokenValid('del-parcelle-'.$id, $request->request->get('_token'))) {
            $nom = $parcelle->getNom();
            $this->parcelleService->deleteParcelle($parcelle);
            $this->addFlash('success', '✅ Parcelle "'.$nom.'" supprimée avec succès!');
        }
        return $this->redirectToRoute('parcelle_index');
    }
}