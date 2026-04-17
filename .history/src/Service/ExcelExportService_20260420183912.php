<?php
// src/Service/ExcelExportService.php

namespace App\Service;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use App\Repository\ProduitRepository;
use App\Repository\StockRepository;
use Symfony\Component\HttpFoundation\Response;

class ExcelExportService
{
    public function __construct(
        private ProduitRepository $produitRepo,
        private StockRepository $stockRepo
    ) {
    }
    
    /**
     * Exporte les produits en Excel
     */
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
            $row++;
        }
        
        $writer = new Xlsx($spreadsheet);
        $tempFile = tempnam(sys_get_temp_dir(), 'export_produits_');
        $writer->save($tempFile);
        
        return new Response(file_get_contents($tempFile), 200, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => 'attachment; filename="produits_' . date('Y-m-d') . '.xlsx"',
        ]);
    }
    
    /**
     * Exporte les stocks en Excel
     */
    public function exportStocks(): Response
    {
        $stocks = $this->stockRepo->findAll();
        
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        // En-têtes
        $sheet->setCellValue('A1', 'Produit');
        $sheet->setCellValue('B1', 'Quantité');
        $sheet->setCellValue('C1', 'Unité');
        $sheet->setCellValue('D1', 'Seuil');
        $sheet->setCellValue('E1', 'Emplacement');
        $sheet->setCellValue('F1', 'Expiration');
        
        // Données
        $row = 2;
        foreach ($stocks as $stock) {
            $produit = $stock->getProduit();
            $sheet->setCellValue('A' . $row, $produit ? $produit->getNom() : 'N/A');
            $sheet->setCellValue('B' . $row, $stock->getQuantiteActuelle());
            $sheet->setCellValue('C' . $row, $stock->getUniteMesure());
            $sheet->setCellValue('D' . $row, $stock->getSeuilAlerte() ?: '—');
            $sheet->setCellValue('E' . $row, $stock->getEmplacement() ?: '—');
            $sheet->setCellValue('F' . $row, $stock->getDateExpiration() ? $stock->getDateExpiration()->format('d/m/Y') : '—');
            $row++;
        }
        
        $writer = new Xlsx($spreadsheet);
        $tempFile = tempnam(sys_get_temp_dir(), 'export_stocks_');
        $writer->save($tempFile);
        
        return new Response(file_get_contents($tempFile), 200, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => 'attachment; filename="stocks_' . date('Y-m-d') . '.xlsx"',
        ]);
    }
}