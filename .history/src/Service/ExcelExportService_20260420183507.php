<?php
// src/Service/ExcelExportService.php

namespace App\Service;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
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
     * Exporte la liste des produits en Excel
     */
    public function exportProducts(): Response
    {
        $produits = $this->produitRepo->findAll();
        
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        // Titre
        $sheet->setCellValue('A1', 'LISTE DES PRODUITS');
        $sheet->mergeCells('A1:G1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        
        // En-têtes
        $headers = ['ID', 'Nom', 'Catégorie', 'Prix (DT)', 'SKU', 'Stock', 'Unité'];
        $col = 'A';
        foreach ($headers as $header) {
            $sheet->setCellValue($col . '3', $header);
            $col++;
        }
        
        // Style des en-têtes
        $headerStyle = $sheet->getStyle('A3:G3');
        $headerStyle->getFont()->setBold(true);
        $headerStyle->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FF5A9814');
        $headerStyle->getFont()->getColor()->setARGB('FFFFFFFF');
        $headerStyle->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        
        // Données
        $row = 4;
        foreach ($produits as $produit) {
            $stock = $produit->getStockActuel();
            
            $sheet->setCellValue('A' . $row, $produit->getId());
            $sheet->setCellValue('B' . $row, $produit->getNom());
            $sheet->setCellValue('C' . $row, $produit->getCategorie() ?: 'Non catégorisé');
            $sheet->setCellValue('D' . $row, $produit->getPrixUnitaire());
            $sheet->setCellValue('E' . $row, $produit->getSku() ?: 'Non généré');
            $sheet->setCellValue('F' . $row, $stock ? $stock->getQuantiteActuelle() : '0');
            $sheet->setCellValue('G' . $row, $stock ? $stock->getUniteMesure() : '');
            
            // Alerte rouge pour stocks bas
            if ($stock && $stock->isEnAlerte()) {
                $sheet->getStyle('F' . $row)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFFF0000');
                $sheet->getStyle('F' . $row)->getFont()->getColor()->setARGB('FFFFFFFF');
            }
            
            $row++;
        }
        
        // Auto-size des colonnes
        foreach(range('A','G') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
        
        // Bordures
        $borderStyle = $sheet->getStyle('A3:G' . ($row-1));
        $borderStyle->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
        
        $writer = new Xlsx($spreadsheet);
        $tempFile = tempnam(sys_get_temp_dir(), 'export_produits_');
        $writer->save($tempFile);
        
        return new Response(file_get_contents($tempFile), 200, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => 'attachment; filename="produits_' . date('Y-m-d_H-i-s') . '.xlsx"',
        ]);
    }
    
    /**
     * Exporte la liste des stocks en Excel
     */
    public function exportStocks(): Response
    {
        $stocks = $this->stockRepo->findAll();
        
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        // Titre
        $sheet->setCellValue('A1', 'LISTE DES STOCKS');
        $sheet->mergeCells('A1:H1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        
        // En-têtes
        $headers = ['ID', 'Produit', 'Catégorie', 'Quantité', 'Unité', 'Seuil', 'Statut', 'Expiration'];
        $col = 'A';
        foreach ($headers as $header) {
            $sheet->setCellValue($col . '3', $header);
            $col++;
        }
        
        // Style des en-têtes
        $headerStyle = $sheet->getStyle('A3:H3');
        $headerStyle->getFont()->setBold(true);
        $headerStyle->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FF2196F3');
        $headerStyle->getFont()->getColor()->setARGB('FFFFFFFF');
        $headerStyle->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        
        // Données
        $row = 4;
        foreach ($stocks as $stock) {
            $produit = $stock->getProduit();
            
            $sheet->setCellValue('A' . $row, $stock->getId());
            $sheet->setCellValue('B' . $row, $produit ? $produit->getNom() : 'Produit supprimé');
            $sheet->setCellValue('C' . $row, $produit ? $produit->getCategorie() : '-');
            $sheet->setCellValue('D' . $row, $stock->getQuantiteActuelle());
            $sheet->setCellValue('E' . $row, $stock->getUniteMesure());
            $sheet->setCellValue('F' . $row, $stock->getSeuilAlerte() ?: '-');
            $sheet->setCellValue('G' . $row, $stock->getStatut());
            $sheet->setCellValue('H' . $row, $stock->getDateExpiration() ? $stock->getDateExpiration()->format('d/m/Y') : '-');
            
            // Couleur selon statut
            $statut = $stock->getStatut();
            if ($statut === 'Rupture') {
                $sheet->getStyle('G' . $row)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFFF0000');
            } elseif ($statut === 'Critique') {
                $sheet->getStyle('G' . $row)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFFF9800');
            } else {
                $sheet->getStyle('G' . $row)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FF4CAF50');
            }
            
            $row++;
        }
        
        // Auto-size des colonnes
        foreach(range('A','H') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
        
        $writer = new Xlsx($spreadsheet);
        $tempFile = tempnam(sys_get_temp_dir(), 'export_stocks_');
        $writer->save($tempFile);
        
        return new Response(file_get_contents($tempFile), 200, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => 'attachment; filename="stocks_' . date('Y-m-d_H-i-s') . '.xlsx"',
        ]);
    }
    
    /**
     * Exporte les alertes de stock en Excel
     */
    public function exportAlertes(): Response
    {
        $alertes = $this->stockRepo->findAlertes();
        
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        // Titre
        $sheet->setCellValue('A1', 'ALERTES DE STOCK');
        $sheet->mergeCells('A1:G1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        
        // En-têtes
        $headers = ['ID', 'Produit', 'Catégorie', 'Quantité', 'Seuil', 'Unité', 'Recommandation'];
        $col = 'A';
        foreach ($headers as $header) {
            $sheet->setCellValue($col . '3', $header);
            $col++;
        }
        
        // Style des en-têtes
        $headerStyle = $sheet->getStyle('A3:G3');
        $headerStyle->getFont()->setBold(true);
        $headerStyle->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFFF5722');
        $headerStyle->getFont()->getColor()->setARGB('FFFFFFFF');
        
        // Données
        $row = 4;
        foreach ($alertes as $stock) {
            $produit = $stock->getProduit();
            
            $sheet->setCellValue('A' . $row, $stock->getId());
            $sheet->setCellValue('B' . $row, $produit ? $produit->getNom() : 'Produit supprimé');
            $sheet->setCellValue('C' . $row, $produit ? $produit->getCategorie() : '-');
            $sheet->setCellValue('D' . $row, $stock->getQuantiteActuelle());
            $sheet->setCellValue('E' . $row, $stock->getSeuilAlerte());
            $sheet->setCellValue('F' . $row, $stock->getUniteMesure());
            
            $recommandation = $stock->getQuantiteActuelle() == 0 ? 'Commander urgent' : 'Réapprovisionner';
            $sheet->setCellValue('G' . $row, $recommandation);
            
            // Style alerte
            $sheet->getStyle('A' . $row . ':G' . $row)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('30FF5722');
            
            $row++;
        }
        
        foreach(range('A','G') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
        
        $writer = new Xlsx($spreadsheet);
        $tempFile = tempnam(sys_get_temp_dir(), 'export_alertes_');
        $writer->save($tempFile);
        
        return new Response(file_get_contents($tempFile), 200, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => 'attachment; filename="alertes_' . date('Y-m-d_H-i-s') . '.xlsx"',
        ]);
    }
}