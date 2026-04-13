<?php
namespace App\Controller;

use App\Entity\Culture;
use App\Service\CultureService;
use App\Service\ParcelleService;
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
        private CultureService  $cultureService,
        private ParcelleService $parcelleService
    ) {}

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

        // Auto-calculate date récolte if not provided (like Java CultureDurations.calculateHarvestDate)
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
        if ($requestedParcelleId === 0) {
            $requestedParcelleId = $oldParcelle->getId();
        }

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

        // Auto-calculate date récolte if not provided
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

    #[Route('/{id}/harvest', name: 'culture_harvest', methods: ['POST'], requirements: ['id'=>'\d+'])]
    public function harvest(int $id, Request $request): Response
    {
        $culture = $this->cultureService->getCultureById($id);
        if (!$culture) throw $this->createNotFoundException();

        if ($this->isCsrfTokenValid('harvest-culture-'.$id, $request->request->get('_token'))) {
            $culture->setEtat('Récolte');
            $this->cultureService->updateCulture($culture);
            $this->addFlash('success', '🌾 Culture "'.$culture->getNom().'" marquée comme récoltée!');
        }
        return $this->redirectToRoute('culture_index');
    }

    #[Route('/{id}/details', name: 'culture_details', methods: ['GET'], requirements: ['id'=>'\d+'])]
    public function details(int $id): Response
    {
        $culture = $this->cultureService->getCultureById($id);
        if (!$culture) throw $this->createNotFoundException();

        $parcelle = $this->parcelleService->getParcelleById($culture->getParcelleId());

        return $this->render('culture/details.html.twig', [
            'culture' => $culture,
            'parcelle' => $parcelle,
        ]);
    }

    // ── AJAX: auto-calculate harvest date — Java: CultureDurations.calculateHarvestDate ──
    // Called by JS when user picks a culture name + plantation date in the form
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