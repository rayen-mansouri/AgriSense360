// src/Controller/GestionController.php

// Ajoutez l'use en haut
use src\Service\BarcodeService;

// Modifiez la méthode produitNew
#[Route('/produit/nouveau', name: 'produit_new', methods: ['GET', 'POST'])]
public function produitNew(Request $request, BarcodeService $barcodeService): Response
{
    $produit = new Produit();
    $stock = new Stock();
    
    $form = $this->createFormBuilder()
        ->add('produit', ProduitType::class, ['data' => $produit])
        ->add('stock', StockType::class, ['data' => $stock, 'show_produit' => false])
        ->getForm();

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $data = $form->getData();
        $produit = $data['produit'];
        $stock = $data['stock'];
        
        // Gérer la photo
        $photoFile = $form->get('produit')->get('photoFile')->getData();
        if ($photoFile) {
            $originalFilename = pathinfo($photoFile->getClientOriginalName(), PATHINFO_FILENAME);
            $safeFilename = $this->slugger->slug($originalFilename);
            $newFilename = $safeFilename . '-' . uniqid() . '.' . $photoFile->guessExtension();
            
            try {
                $photoFile->move($this->getParameter('photos_directory'), $newFilename);
                $produit->setPhotoUrl('uploads/photos/' . $newFilename);
            } catch (FileException $e) {
                $this->addFlash('error', 'Erreur lors du téléchargement de la photo.');
            }
        }
        
        $produit->setAgriculteurId(1);
        
        // Persister d'abord pour obtenir l'ID
        $this->em->persist($produit);
        $this->em->flush();
        
        // ⭐⭐⭐ GÉNÉRATION DES CODES-BARRES ET QR CODE ⭐⭐⭐
        $sku = $barcodeService->generateSKU($produit->getId(), $produit->getCategorie());
        $barcodeImage = $barcodeService->generateCode128($sku);
        $qrCodeImage = $barcodeService->generateQRCode($produit->getId(), $produit->getNom());
        
        $produit->setSku($sku);
        $produit->setBarcodeUrl($barcodeImage);
        $produit->setQrCodeUrl($qrCodeImage);
        
        // Stock optionnel
        if ($stock->getQuantiteActuelle() !== null && $stock->getQuantiteActuelle() > 0) {
            $stock->setProduit($produit);
            $this->em->persist($stock);
        }
        
        $this->em->flush();

        $this->addFlash('success', '✅ Produit créé avec codes-barres et QR code !');
        return $this->redirectToRoute('home');
    }

    return $this->render('produit/form.html.twig', [
        'form' => $form->createView(),
        'title' => '🌱 Nouveau Produit',
        'subtitle' => 'Créez un nouveau produit',
        'btnLabel' => '✓ Enregistrer le Produit',
    ]);
}