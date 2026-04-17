<?php
// src/Service/BarcodeService.php

namespace App\Service;

use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Color\Color;
use Picqer\Barcode\BarcodeGeneratorPNG;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\ImagickImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;

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
    
    $result = Builder::create()
        ->writer(new SvgWriter())  // ← SVG au lieu de PNG
        ->data($data)
        ->size(300)
        ->margin(10)
        ->build();

    return 'data:image/svg+xml;base64,' . base64_encode($result->getString());
}return 'data:image/png;base64,' . base64_encode($imageData);
}
}