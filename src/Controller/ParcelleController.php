<?php
namespace App\Controller;

use App\Entity\Parcelle;
use App\Service\ParcelleService;
use App\Service\CultureService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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

    public function __construct(
        private ParcelleService $parcelleService,
        private CultureService  $cultureService
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

    #[Route('/{id}', name: 'parcelle_show', methods: ['GET'], requirements: ['id'=>'\d+'])]
    public function show(int $id): Response
    {
        $parcelle = $this->parcelleService->getParcelleById($id);
        if (!$parcelle) throw $this->createNotFoundException();

        $cultures = $this->cultureService->getCulturesByParcelle($id);

        return $this->render('parcelle/show.html.twig', [
            'parcelle' => $parcelle,
            'cultures' => $cultures,
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