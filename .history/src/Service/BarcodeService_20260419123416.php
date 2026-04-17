<?php

namespace App\Service;

use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\PngImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;
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
        return 'data:image/png;base64,' . base64_encode($generator->getBarcode($sku, $generator::TYPE_CODE_128));
    }

    public function generateQRCode(int $id, string $nom): string
    {
        $data = "produit:{$id}:{$nom}";
        
        $renderer = new ImageRenderer(
            new RendererStyle(400),
            new PngImageBackEnd()
        );
        $writer = new Writer($renderer);
        
        ob_start();
        $writer->writeString($data);
        $imageData = ob_get_clean();
        
        return 'data:image/png;base64,' . base64_encode($imageData);
    }
}