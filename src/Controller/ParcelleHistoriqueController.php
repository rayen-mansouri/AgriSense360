<?php
namespace App\Controller;

use App\Service\ParcelleHistoriqueService;
use App\Service\ParcelleService;
use Mpdf\Mpdf;
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
     * Full page or AJAX panel.
     */
    #[Route('/{id}', name: 'parcelle_historique', methods: ['GET'], requirements: ['id' => '\d+'])]
    public function show(int $id, Request $request): Response
    {
        $parcelle = $this->parcelleService->getParcelleById($id);
        if (!$parcelle) {
            throw $this->createNotFoundException('Parcelle introuvable.');
        }

        /** @var \App\Entity\User $user */
        $user = $this->getUser();
        if ($user && $user->getFarm() && $parcelle->getFarm() !== $user->getFarm() && !$this->isGranted('ROLE_ADMIN')) {
            throw $this->createAccessDeniedException('Vous n\'avez pas accès à cette parcelle.');
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

        if ($request->headers->get('X-Requested-With') === 'XMLHttpRequest') {
            return $this->render('parcelle/historique_panel.html.twig', $params);
        }

        return $this->render('parcelle/historique_page.html.twig', $params);
    }

    /**
     * GET /parcelle/historique/{id}/export
     * Downloads a professional PDF of the parcelle's historique.
     */
    #[Route('/{id}/export', name: 'parcelle_historique_export', methods: ['GET'], requirements: ['id' => '\d+'])]
    public function export(int $id, Request $request): Response
    {
        $parcelle = $this->parcelleService->getParcelleById($id);
        if (!$parcelle) {
            throw $this->createNotFoundException('Parcelle introuvable.');
        }

        /** @var \App\Entity\User $user */
        $user = $this->getUser();
        if ($user && $user->getFarm() && $parcelle->getFarm() !== $user->getFarm() && !$this->isGranted('ROLE_ADMIN')) {
            throw $this->createAccessDeniedException('Vous n\'avez pas accès à cette parcelle.');
        }

        $typeFilter = $request->query->get('type', '');
        $historique = $typeFilter
            ? $this->historiqueService->getHistoriqueByType($id, $typeFilter)
            : $this->historiqueService->getHistoriqueByParcelle($id);

        // Render PDF content via Twig
        $html = $this->renderView('parcelle/historique_pdf.html.twig', [
            'parcelle'   => $parcelle,
            'historique' => $historique,
            'typeFilter' => $typeFilter,
        ]);

        // Initialize Mpdf
        $mpdf = new Mpdf([
            'margin_left'   => 15,
            'margin_right'  => 15,
            'margin_top'    => 15,
            'margin_bottom' => 20,
            'format'        => 'A4',
        ]);

        $mpdf->SetTitle('Historique — ' . $parcelle->getNom());
        $mpdf->WriteHTML($html);

        $filename = sprintf(
            'historique_%s_%s.pdf',
            preg_replace('/[^a-z0-9]/i', '_', $parcelle->getNom()),
            (new \DateTime())->format('Ymd_His')
        );

        return new Response($mpdf->Output($filename, 'D'), 200, [
            'Content-Type'        => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }
}