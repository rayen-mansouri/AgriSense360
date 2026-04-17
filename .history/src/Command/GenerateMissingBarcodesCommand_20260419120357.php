<?php

namespace App\Command;

use App\Repository\ProduitRepository;
use App\Service\BarcodeService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:generate-missing-barcodes')]
class GenerateMissingBarcodesCommand extends Command
{
    public function __construct(
        private ProduitRepository $produitRepo,
        private EntityManagerInterface $em,
        private BarcodeService $barcodeService
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $produits = $this->produitRepo->findAll();
        $count = 0;

        foreach ($produits as $produit) {
            if (!$produit->getSku()) {
                $sku = $this->barcodeService->generateSKU($produit->getId(), $produit->getCategorie());
                $barcodeImage = $this->barcodeService->generateCode128($sku);
                $qrCodeImage = $this->barcodeService->generateQRCode($produit->getId(), $produit->getNom());
                
                $produit->setSku($sku);
                $produit->setBarcodeUrl($barcodeImage);
                $produit->setQrCodeUrl($qrCodeImage);
                
                $count++;
                $output->writeln("✅ Produit #{$produit->getId()} : {$produit->getNom()} - SKU: {$sku}");
            }
        }
        
        $this->em->flush();
        $output->writeln("\n🎉 {$count} produit(s) mis à jour !");
        
        return Command::SUCCESS;
    }
}