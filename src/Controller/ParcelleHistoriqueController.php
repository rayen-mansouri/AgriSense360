<?php
namespace App\Controller;

use App\Service\ParcelleHistoriqueService;
use App\Service\ParcelleService;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;
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
     * Downloads a formatted Excel file of the parcelle's historique.
     * Respects the ?type= filter (same as the show page).
     */
    #[Route('/{id}/export', name: 'parcelle_historique_export', methods: ['GET'], requirements: ['id' => '\d+'])]
    public function export(int $id, Request $request): StreamedResponse
    {
        $parcelle = $this->parcelleService->getParcelleById($id);
        if (!$parcelle) {
            throw $this->createNotFoundException('Parcelle introuvable.');
        }

        $typeFilter = $request->query->get('type', '');

        $historique = $typeFilter
            ? $this->historiqueService->getHistoriqueByType($id, $typeFilter)
            : $this->historiqueService->getHistoriqueByParcelle($id);

        // ── Build spreadsheet ─────────────────────────────────────────────────
        $spreadsheet = new Spreadsheet();
        $sheet       = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Historique');

        // ── Title row ─────────────────────────────────────────────────────────
        $sheet->mergeCells('A1:H1');
        $sheet->setCellValue('A1', 'Historique — ' . $parcelle->getNom());
        $sheet->getStyle('A1')->applyFromArray([
            'font'      => ['bold' => true, 'size' => 14, 'color' => ['rgb' => 'FFFFFF']],
            'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '3B6D11']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        ]);
        $sheet->getRowDimension(1)->setRowHeight(28);

        // ── Sub-title row ─────────────────────────────────────────────────────
        $sheet->mergeCells('A2:H2');
        $filterLabel = $typeFilter ?: 'Tous les événements';
        $sheet->setCellValue('A2', 'Exporté le ' . (new \DateTime())->format('d/m/Y à H:i') . '   |   Filtre : ' . $filterLabel . '   |   ' . count($historique) . ' événement(s)');
        $sheet->getStyle('A2')->applyFromArray([
            'font'      => ['italic' => true, 'size' => 10, 'color' => ['rgb' => '555555']],
            'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'F0FDF4']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_LEFT],
        ]);
        $sheet->getRowDimension(2)->setRowHeight(18);

        // ── Header row ────────────────────────────────────────────────────────
        $headers    = ['Date', 'Heure', 'Type', 'Culture', 'Type culture', 'Surface (m²)', 'Qté récoltée (kg)', 'Description'];
        $headerCols = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H'];

        foreach ($headers as $i => $header) {
            $col = $headerCols[$i];
            $sheet->setCellValue($col . '3', $header);
            $sheet->getStyle($col . '3')->applyFromArray([
                'font'      => ['bold' => true, 'size' => 10, 'color' => ['rgb' => 'FFFFFF']],
                'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '1D9E75']],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
                'borders'   => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => 'AAAAAA']]],
            ]);
        }
        $sheet->getRowDimension(3)->setRowHeight(20);

        // ── Data rows ─────────────────────────────────────────────────────────
        $rowNum = 4;
        foreach ($historique as $h) {
            $isRecolte = $h->getTypeAction() === 'RECOLTE';
            $bgColor   = match ($h->getTypeAction()) {
                'RECOLTE'           => 'E1F5EE',
                'CULTURE_AJOUTEE'   => 'F0FDF4',
                'CULTURE_SUPPRIMEE' => 'FFF1F2',
                'CULTURE_MODIFIEE'  => 'FFFBEB',
                default             => 'FFFFFF',
            };

            $sheet->setCellValue('A' . $rowNum, $h->getDateAction()?->format('d/m/Y') ?? '');
            $sheet->setCellValue('B' . $rowNum, $h->getDateAction()?->format('H:i') ?? '');
            $sheet->setCellValue('C' . $rowNum, $h->getTypeAction() ?? '');
            $sheet->setCellValue('D' . $rowNum, $h->getCultureNom() ?? '');
            $sheet->setCellValue('E' . $rowNum, $h->getTypeCulture() ?? '');

            if ($h->getSurface() !== null) {
                $sheet->setCellValue('F' . $rowNum, $h->getSurface());
                $sheet->getStyle('F' . $rowNum)->getNumberFormat()->setFormatCode('#,##0.0');
            }

            if ($isRecolte && $h->getQuantiteRecolte() !== null) {
                $sheet->setCellValue('G' . $rowNum, $h->getQuantiteRecolte());
                $sheet->getStyle('G' . $rowNum)->applyFromArray([
                    'font'         => ['bold' => true, 'color' => ['rgb' => '3B6D11']],
                    'numberFormat' => ['formatCode' => '#,##0.00'],
                ]);
            }

            $sheet->setCellValue('H' . $rowNum, $h->getDescription() ?? '');

            $sheet->getStyle('A' . $rowNum . ':H' . $rowNum)->applyFromArray([
                'fill'    => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => $bgColor]],
                'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => 'DDDDDD']]],
                'font'    => ['size' => 10],
            ]);
            $sheet->getStyle('H' . $rowNum)->getAlignment()->setWrapText(true);

            $rowNum++;
        }

        // ── Totals row ────────────────────────────────────────────────────────
        $hasHarvests = array_filter((array) $historique, fn($h) => $h->getTypeAction() === 'RECOLTE');
        if (!empty($hasHarvests) && ($typeFilter === '' || $typeFilter === 'RECOLTE')) {
            $lastData = $rowNum - 1;
            $sheet->mergeCells('A' . $rowNum . ':E' . $rowNum);
            $sheet->setCellValue('A' . $rowNum, 'TOTAUX RÉCOLTES');
            $sheet->setCellValue('F' . $rowNum, '=SUMIF(C4:C' . $lastData . ',"RECOLTE",F4:F' . $lastData . ')');
            $sheet->setCellValue('G' . $rowNum, '=SUM(G4:G' . $lastData . ')');
            $sheet->getStyle('F' . $rowNum)->getNumberFormat()->setFormatCode('#,##0.0');
            $sheet->getStyle('G' . $rowNum)->getNumberFormat()->setFormatCode('#,##0.00');
            $sheet->getStyle('A' . $rowNum . ':H' . $rowNum)->applyFromArray([
                'font'    => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill'    => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '0F6E56']],
                'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => '888888']]],
            ]);
            $sheet->getRowDimension($rowNum)->setRowHeight(20);
        }

        // ── Column widths + freeze ────────────────────────────────────────────
        $sheet->getColumnDimension('A')->setWidth(14);
        $sheet->getColumnDimension('B')->setWidth(8);
        $sheet->getColumnDimension('C')->setWidth(20);
        $sheet->getColumnDimension('D')->setWidth(20);
        $sheet->getColumnDimension('E')->setWidth(16);
        $sheet->getColumnDimension('F')->setWidth(14);
        $sheet->getColumnDimension('G')->setWidth(18);
        $sheet->getColumnDimension('H')->setWidth(50);
        $sheet->freezePane('A4');

        // ── Stream to browser ─────────────────────────────────────────────────
        $filename = sprintf(
            'historique_%s_%s.xlsx',
            preg_replace('/[^a-z0-9]/i', '_', $parcelle->getNom()),
            (new \DateTime())->format('Ymd_His')
        );

        $writer   = new Xlsx($spreadsheet);
        $response = new StreamedResponse(function () use ($writer) {
            $writer->save('php://output');
        });

        $response->headers->set('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        $response->headers->set('Content-Disposition', 'attachment; filename="' . $filename . '"');
        $response->headers->set('Cache-Control', 'max-age=0');

        return $response;
    }
}