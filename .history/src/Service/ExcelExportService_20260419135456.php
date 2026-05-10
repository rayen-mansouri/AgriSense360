<?php
// src/Service/ExcelExportService.php

namespace App\Service;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use App\Repository\ProduitRepository;
use Symfony\Component\HttpFoundation\Response;

class ExcelExportService
{
    public function __construct(private ProduitRepository $produitRepo)
    {
    }
    
    public function exportProducts(): Response
    {
        $produits = $this->produitRepo->findAll();
        
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        // En-têtes
        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'Nom');
        $sheet->setCellValue('C1', 'Catégorie');
        $sheet->setCellValue('D1', 'Prix (DT)');
        $sheet->setCellValue('E1', 'SKU');
        $sheet->setCellValue('F1', 'Stock');
        $sheet->setCellValue('G1', 'Unité');
        
        // Style en-têtes
        $headerStyle = $sheet->getStyle('A1:G1');
        $headerStyle->getFont()->setBold(true);
        $headerStyle->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFE0E0E0');
        
        // Données
        $row = 2;
        foreach ($produits as $produit) {
            $stock = $produit->getStockActuel();
            $sheet->setCellValue('A' . $row, $produit->getId());
            $sheet->setCellValue('B' . $row, $produit->getNom());
            $sheet->setCellValue('C' . $row, $produit->getCategorie());
            $sheet->setCellValue('D' . $row, $produit->getPrixUnitaire());
            $sheet->setCellValue('E' . $row, $produit->getSku());
            $sheet->setCellValue('F' . $row, $stock ? $stock->getQuantiteActuelle() : '0');
            $sheet->setCellValue('G' . $row, $stock ? $stock->getUniteMesure() : '');
            
            // Alerte rouge pour stocks bas
            if ($stock && $stock->isEnAlerte()) {
                $sheet->getStyle('F' . $row)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFFF0000');
            }
            $row++;
        }
        
        foreach(range('A','G') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
        
        $writer = new Xlsx($spreadsheet);
        $tempFile = tempnam(sys_get_temp_dir(), 'export_');
        $writer->save($tempFile);
        
        return new Response(file_get_contents($tempFile), 200, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => 'attachment; filename="produits_' . date('Y-m-d') . '.xlsx"',
        ]);
    }
}