<?php
namespace App\Controller;

use App\Service\CultureService;
use App\Service\ParcelleService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Serves the embedded HTML pages (Agenda + Map) as Twig wrappers
 * so we can inject real DB data into them via a <script> block.
 */
class EmbedController extends AbstractController
{
    public function __construct(
        private CultureService  $cultureService,
        private ParcelleService $parcelleService
    ) {}

    // ── /agenda ──────────────────────────────────────────────────────────────
    // Renders AgendaCulture.html (in public/agenda/) wrapped in a tiny Twig
    // that injects cultures from the DB via loadFromJava().
    #[Route('/agenda', name: 'agenda_view', methods: ['GET'])]
    public function agenda(): Response
    {
        $this->cultureService->refreshAllEtats();
        $cultures = $this->cultureService->getAllCultures();

        // Build the same JSON structure AgendaController.java used
        $data = array_map(fn($c) => [
            'nom'        => $c->getNom(),
            'type'       => $c->getTypeCulture(),
            'plantation' => $c->getDatePlantation()?->format('Y-m-d') ?? date('Y-m-d'),
        ], $cultures);

        return $this->render('embed/agenda.html.twig', [
            'culturesJson' => json_encode($data, JSON_UNESCAPED_UNICODE),
        ]);
    }

    // ── /carte-parcelles ─────────────────────────────────────────────────────
    // Renders map.html (in public/map/) wrapped in a tiny Twig
    // that injects parcelles from the DB via setParcelles().
    #[Route('/carte-parcelles', name: 'carte_parcelles', methods: ['GET'])]
    public function carte(): Response
    {
        $parcelles = $this->parcelleService->getAllParcelles();

        $data = array_map(fn($p) => [
            'nom'          => $p->getNom(),
            'localisation' => $p->getLocalisation(),
            'surface'      => $p->getSurface(),
            'statut'       => $p->getStatut(),
            'typeSol'      => $p->getTypeSol(),
            'taux'         => $p->getTauxOccupation(),
        ], $parcelles);

        return $this->render('embed/carte.html.twig', [
            'parcellesJson' => json_encode($data, JSON_UNESCAPED_UNICODE),
        ]);
    }
}