<?php
namespace App\Controller;

use App\Service\ParcelleHistoriqueService;
use App\Service\ParcelleService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/parcelle/historique')]
class ParcelleHistoriqueController extends AbstractController
{
    public function __construct(
        private ParcelleHistoriqueService $historiqueService,
        private ParcelleService           $parcelleService,
    ) {}

    /**
     * GET /parcelle/historique/{id}
     *
     * - Regular browser visit  → renders the full historique_page.html.twig
     * - AJAX (X-Requested-With) → renders only the panel partial (historique_panel.html.twig)
     *   (kept for future use, but the button now navigates directly)
     */
    #[Route('/{id}', name: 'parcelle_historique', methods: ['GET'], requirements: ['id' => '\d+'])]
    public function show(int $id, Request $request): Response
    {
        $parcelle = $this->parcelleService->getParcelleById($id);
        if (!$parcelle) {
            throw $this->createNotFoundException('Parcelle introuvable.');
        }

        $typeFilter = $request->query->get('type', '');

        $historique = $typeFilter
            ? $this->historiqueService->getHistoriqueByType($id, $typeFilter)
            : $this->historiqueService->getHistoriqueByParcelle($id);

        $stats = $this->historiqueService->getStatsByParcelle($id);

        $params = [
            'parcelle'   => $parcelle,
            'historique' => $historique,
            'stats'      => $stats,
            'typeFilter' => $typeFilter,
        ];

        // AJAX call → return only the panel partial
        if ($request->headers->get('X-Requested-With') === 'XMLHttpRequest') {
            return $this->render('parcelle/historique_panel.html.twig', $params);
        }

        // Full page navigation (button click)
        return $this->render('parcelle/historique_page.html.twig', $params);
    }
}