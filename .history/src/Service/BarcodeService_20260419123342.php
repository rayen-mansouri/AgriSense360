<?php

namespace App\Service;

use Endroid\QrCode\Writer\SvgWriter;
use Endroid\QrCode\Builder\Builder as QrBuilder;  // ← Alias unique
use Picqer\Barcode\BarcodeGeneratorPNG;

class BarcodeService
{
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
        
        $result = QrBuilder::create()  // ← Utilise l'alias
            ->writer(new SvgWriter())
            ->data($data)
            ->size(300)
            ->margin(10)
            ->build();

        return 'data:image/svg+xml;base64,' . base64_encode($result->getString());
    }
}