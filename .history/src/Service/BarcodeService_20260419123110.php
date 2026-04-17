<?php
// src/Service/BarcodeService.php

namespace App\Service;

use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Color\Color;
use Picqer\Barcode\BarcodeGeneratorPNG;

#[AsCommand] // Si service Symfony
class BarcodeService
{
    public function __construct()
    {
    }

    public function generateSKU(int $id, ?string $categorie = null): string
    {
        $prefix = $categorie ? strtoupper(substr($categorie, 0, 3)) : 'PRO';
        return $prefix . str_pad($id, 6, '0', STR_PAD_LEFT);
    }

    public function generateCode128(string $sku): string
    {
        $generator = new BarcodeGeneratorPNG();
        $image = $generator->getBarcode($sku, $generator::TYPE_CODE_128);
        return 'data:image/png;base64,' . base64_encode($image);
    }

     public function generateQRCode(int $id, string $nom): string
{
    $data = "produit:{$id}:{$nom}";
    
    $renderer = new ImageRenderer(
        new RendererStyle(400),
        new ImagickImageBackEnd()
    );
    $writer = new Writer($renderer);
    
    ob_start();
    $writer->writeString($data);
    $imageData = ob_get_clean();
    
    return 'data:image/png;base64,' . base64_encode($imageData);
}
}