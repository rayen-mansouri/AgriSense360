<?php
// src/Service/BarcodeService.php

namespace App\Service;

use Picqer\Barcode\BarcodeGeneratorPNG;

class BarcodeService
{
    private BarcodeGeneratorPNG $generator;
    
    public function __construct()
    {
        $this->generator = new BarcodeGeneratorPNG();
    }
    
    /**
     * Génère un code-barres EAN-13
     */
    public function generateEAN13(string $code): string
    {
        // Format EAN-13 : 13 chiffres
        $code = str_pad($code, 12, '0', STR_PAD_LEFT);
        $code .= $this->calculateEAN13Checksum($code);
        
        return base64_encode($this->generator->getBarcode($code, $generator::TYPE_EAN_13));
    }
    
    /**
     * Génère un code-barres Code128 (pour les ID produits)
     */
    public function generateCode128(string $code): string
    {
        return base64_encode($this->generator->getBarcode($code, $generator::TYPE_CODE_128));
    }
    
    /**
     * Calcule la clé de contrôle EAN-13
     */
    private function calculateEAN13Checksum(string $code): int
    {
        $sum = 0;
        for ($i = 0; $i < 12; $i++) {
            $sum += ($i % 2 === 0) ? (int)$code[$i] : (int)$code[$i] * 3;
        }
        $checksum = (10 - ($sum % 10)) % 10;
        return $checksum;
    }
    
    /**
     * Génère un code unique pour un produit
     */
    public function generateUniqueProductCode(Produit $produit): string
    {
        // Format : CAT + ID + RANDOM
        $categoryCode = substr(strtoupper($produit->getCategorie() ?? 'PRD'), 0, 3);
        return $categoryCode . str_pad($produit->getId(), 6, '0', STR_PAD_LEFT) . rand(10, 99);
    }
}