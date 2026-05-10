<?php
// src/Service/BarcodeService.php

namespace App\Service;

use Picqer\Barcode\BarcodeGeneratorPNG;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;

class BarcodeService
{
    private BarcodeGeneratorPNG $generator;
    
    public function __construct()
    {
        $this->generator = new BarcodeGeneratorPNG();
    }
    
    /**
     * Génère un code-barres Code128
     */
    public function generateCode128(string $code): string
    {
        $barcode = $this->generator->getBarcode($code, BarcodeGeneratorPNG::TYPE_CODE_128);
        return 'data:image/png;base64,' . base64_encode($barcode);
    }
    
    /**
     * Génère un QR code pour un produit
     */
    public function generateQRCode(int $productId, string $productName): string
    {
        $result = Builder::create()
            ->writer(new PngWriter())
            ->data(json_encode([
                'id' => $productId,
                'nom' => $productName,
                'url' => '/produit/' . $productId
            ]))
            ->encoding(new Encoding('UTF-8'))
            ->errorCorrectionLevel(ErrorCorrectionLevel::High)
            ->size(200)
            ->margin(10)
            ->build();
        
        return 'data:image/png;base64,' . base64_encode($result->getString());
    }
    
    /**
     * Génère un SKU unique pour un produit
     */
    public function generateSKU(int $productId, string $categorie): string
    {
        $prefix = substr(strtoupper(preg_replace('/[^A-Za-z0-9]/', '', $categorie)), 0, 3);
        if (empty($prefix)) {
            $prefix = 'PRD';
        }
        return $prefix . str_pad($productId, 6, '0', STR_PAD_LEFT);
    }
}