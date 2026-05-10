<?php

namespace App\Service;

use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Renderer\SvgRenderer;
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
    
    // ✅ BaconQR 3.x CORRECT
    $renderer = new \BaconQrCode\Renderer\SvgRenderer(
        new \BaconQrCode\Renderer\RendererStyle\RendererStyle(400, 0)
    );
    $writer = new \BaconQrCode\Writer($renderer);
    
    ob_start();
    $writer->writeString($data);
    $svgData = ob_get_clean();
    
    return 'data:image/svg+xml;base64,' . base64_encode($svgData);
}
}