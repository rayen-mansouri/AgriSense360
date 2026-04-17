<?php
// update_barcodes.php
require_once 'vendor/autoload.php';

use App\Kernel;
use App\Service\BarcodeService;

$kernel = new Kernel('dev', true);
$kernel->boot();

$container = $kernel->getContainer();
$em = $container->get('doctrine')->getManager();
$produitRepo = $em->getRepository(\App\Entity\Produit::class);
$barcodeService = new BarcodeService();

$produits = $produitRepo->findAll();
$count = 0;

foreach ($produits as $produit) {
    if (!$produit->getSku()) {
        $sku = $barcodeService->generateSKU($produit->getId(), $produit->getCategorie());
        $barcodeImage = $barcodeService->generateCode128($sku);
        
        $produit->setSku($sku);
        $produit->setBarcodeUrl($barcodeImage);
        
        $count++;
        echo "✅ Produit #{$produit->getId()} : {$produit->getNom()} - SKU: {$sku}\n";
    }
}

$em->flush();
echo "\n🎉 {$count} produit(s) mis à jour !\n";