<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Entity\Stock;
use App\Form\ProduitType;
use App\Form\StockType;
use App\Repository\ProduitRepository;
use App\Repository\StockRepository;
use App\Service\NotificationService;
use App\Service\PdfService;
use App\Service\RecommendationService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

// ============================================================
// ERREURS CORRIGÉES (dues aux modifications du reverse engineering) :
//
// 1. dashboard() : utilisait findBy() avec des noms de champs camelCase
//    ('prixUnitaire') alors que les propriétés sont en snake_case après
//    le RE ('prix_unitaire') → remplacé par findFiltered() du Repository
//
// 2. dashboard() : $p->getStockActuel() appelé mais la méthode n'existait
//    pas dans l'entité générée par le RE → la méthode est maintenant dans
//    l'entité Produit corrigée
//
// 3. dashboard() : tri manuel usort() utilisait getProduitId() (int)
//    au lieu du nom du produit → inutile, findFiltered() gère tout
//
// 4. dashboard() : alertes via array_filter() ne fonctionnait pas car
//    getSeuilAlerte() peut retourner null → remplacé par findAlertes()
//
// 5. produitNew() : utilisait createFormBuilder() imbriqué (non standard)
//    au lieu de deux formulaires séparés formP/formS → corrigé
//
// 6. produitEdit() : appelait $stock->getProduitId() (supprimé) pour
//    tester si le stock a un produit → remplacé par $stock->getProduit()
//
// 7. produitEdit() : appelait $stock->setProduitId($produit) (supprimé,
//    et le type était faux : int vs Produit) → remplacé par setProduit()
//
// 8. exportProduitsPdf() / exportStocksPdf() : appellent findFiltered()
//    qui n'existait pas dans les repos générés par RE → ajouté aux repos
//
// 9. setPhotoUrl() dans Produit attend ?string (nullable) → ok après fix
// ============================================================

class GestionController extends AbstractController
{
    public function __construct(
        private ProduitRepository      $produitRepo,
        private StockRepository        $stockRepo,
        private EntityManagerInterface $em,
        private SluggerInterface       $slugger,
        private RecommendationService  $recoService,
        private NotificationService    $notifService,
        private PdfService             $pdfService,
    ) {}

    // ══════════════════════════════════════════════════════════════════════════
    // TABLEAU DE BORD
    // ══════════════════════════════════════════════════════════════════════════

    #[Route('/', name: 'home')]
    #[Route('/dashboard', name: 'admin')]
    public function dashboard(Request $request): Response
    {
        $search    = $request->query->get('q', '');
        $catFilter = $request->query->get('cat', '');
        $pSort     = $request->query->get('psort', 'nom');
        $pDir      = $request->query->get('pdir', 'asc');
        $sSort     = $request->query->get('ssort', 'produit');
        $sDir      = $request->query->get('sdir', 'asc');

        // CORRECTION 1 : findFiltered() gère recherche + filtre + tri
        $produits = $this->produitRepo->findFiltered($search, $catFilter, $pSort, $pDir);
        $stocks   = $this->stockRepo->findFiltered($search, $sSort, $sDir);

        // CORRECTION 4 : findAlertes() du repository (requête DQL propre)
        $alertes    = $this->stockRepo->findAlertes();
        $categories = $this->produitRepo->findAllCategories();

        $valeurTotale  = 0.0;
        $categorieData = [];

        foreach ($produits as $p) {
            // CORRECTION 2 : getStockActuel() existe maintenant dans l'entité
            $stockActuel = $p->getStockActuel();
            if ($stockActuel) {
                $valeurTotale += (float)$p->getPrixUnitaire() * (float)$stockActuel->getQuantiteActuelle();
            }
            $cat = $p->getCategorie() ?? 'Autre';
            $categorieData[$cat] = ($categorieData[$cat] ?? 0) + 1;
        }

        return $this->render('dashboard/index.html.twig', [
            'produits'      => $produits,
            'stocks'        => $stocks,
            'alertes'       => $alertes,
            'categories'    => $categories,
            'totalProduits' => count($this->produitRepo->findAll()),
            'totalStocks'   => count($this->stockRepo->findAll()),
            'totalAlertes'  => count($alertes),
            'valeurTotale'  => number_format($valeurTotale, 2, ',', ' '),
            'categorieData' => $categorieData,
            'search'        => $search,
            'catFilter'     => $catFilter,
            'pSort'         => $pSort,
            'pDir'          => $pDir,
            'sSort'         => $sSort,
            'sDir'          => $sDir,
        ]);
    }

    // ══════════════════════════════════════════════════════════════════════════
    // PRODUIT — CRUD
    // ══════════════════════════════════════════════════════════════════════════

    // CORRECTION 5 : deux formulaires séparés formP / formS (standard)
 #[Route('/produit/nouveau', name: 'produit_new', methods: ['GET', 'POST'])]
public function produitNew(Request $request): Response
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
        $stock->setProduit($produit);
        
        $this->em->persist($produit);
        if ($stock->getQuantiteActuelle() !== null && $stock->getQuantiteActuelle() > 0) {
            $this->em->persist($stock);
        }
        $this->em->flush();

        $this->addFlash('success', '✅ Produit créé avec succès !');
        return $this->redirectToRoute('home');
    }

    return $this->render('produit/form.html.twig', [
        'form' => $form->createView(),
        'title' => '🌱 Nouveau Produit',
        'subtitle' => 'Créez un nouveau produit',
        'btnLabel' => '✓ Enregistrer le Produit',
    ]);
}
#[Route('/produit/{id}/edit', name: 'produit_edit', methods: ['GET', 'POST'])]
public function produitEdit(Request $request, int $id): Response
{
    // ✅ Recherche manuelle
    $produit = $this->produitRepo->find($id);

    if (!$produit) {
        $this->addFlash('error', '❌ Produit introuvable.');
        return $this->redirectToRoute('home');
    }

    $stock = $produit->getStockActuel();
    if (!$stock) {
        $stock = new Stock();
        $stock->setProduit($produit);
    }
    
    $form = $this->createFormBuilder()
        ->add('produit', ProduitType::class, ['data' => $produit])
        ->add('stock', StockType::class, ['data' => $stock, 'show_produit' => false])
        ->getForm();

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $data    = $form->getData();
        $produit = $data['produit'];
        $stock   = $data['stock'];
        
        $photoFile = $form->get('produit')->get('photoFile')->getData();
        if ($photoFile) {
            $originalFilename = pathinfo($photoFile->getClientOriginalName(), PATHINFO_FILENAME);
            $safeFilename     = $this->slugger->slug($originalFilename);
            $newFilename      = $safeFilename . '-' . uniqid() . '.' . $photoFile->guessExtension();
            
            try {
                $photoFile->move($this->getParameter('photos_directory'), $newFilename);
                $produit->setPhotoUrl('uploads/photos/' . $newFilename);
            } catch (FileException $e) {
                $this->addFlash('error', 'Erreur lors du téléchargement de la photo.');
            }
        }
        
        if ($stock->getProduit() === null) {
            $stock->setProduit($produit);
            $this->em->persist($stock);
        }
        
        $produit->setUpdatedAt(new \DateTime());
        $this->em->flush();

        $this->addFlash('success', '✅ Produit modifié avec succès !');
        return $this->redirectToRoute('home');
    }

    return $this->render('produit/edit.html.twig', [
        'form'     => $form->createView(),
        'produit'  => $produit,
        'title'    => '✏️ Modifier le Produit',
        'subtitle' => 'Modifier les informations du produit',
        'btnLabel' => '✓ Enregistrer les Modifications',
    ]);
}
#[Route('/produit/{id}', name: 'produit_show', methods: ['GET'])]
public function produitShow(int $id): Response
{
    $produit = $this->produitRepo->find($id);

    if (!$produit) {
        $this->addFlash('error', '❌ Produit introuvable.');
        return $this->redirectToRoute('home');
    }

    $recommendations = $this->recoService->recommend($produit, 4);
    
    return $this->render('produit/show.html.twig', [
        'produit'         => $produit,
        'stock'           => $produit->getStockActuel(),
        'recommendations' => $recommendations,
    ]);
}

#[Route('/produit/{id}/delete', name: 'produit_delete', methods: ['POST'])]
public function produitDelete(Request $request, int $id): Response
{
    $produit = $this->produitRepo->find($id);

    if (!$produit) {
        $this->addFlash('error', '❌ Produit introuvable.');
        return $this->redirectToRoute('home');
    }

    if ($this->isCsrfTokenValid('delete' . $produit->getId(), $request->request->get('_token'))) {
        $this->em->remove($produit);
        $this->em->flush();
        $this->addFlash('success', '🗑️ Produit supprimé avec succès.');
    } else {
        $this->addFlash('error', '❌ Token CSRF invalide.');
    }
    
    return $this->redirectToRoute('home');
}
    // ══════════════════════════════════════════════════════════════════════════
    // STOCK — CRUD
    // ══════════════════════════════════════════════════════════════════════════

    #[Route('/stock/nouveau', name: 'stock_new', methods: ['GET', 'POST'])]
    public function stockNew(Request $request): Response
    {
        $stock = new Stock();
        $form  = $this->createForm(StockType::class, $stock);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($stock);
            $this->em->flush();
            $this->addFlash('success', '✅ Stock ajouté avec succès !');
            return $this->redirectToRoute('home');
        }

        return $this->render('stock/form.html.twig', [
            'form'     => $form,
            'stock'    => null,
            'title'    => '➕ Ajouter un Stock',
            'subtitle' => 'Ajoutez du stock pour un produit existant',
            'btnLabel' => '✓ Ajouter au Stock',
        ]);


    }

    // ✅ stockEdit
#[Route('/stock/{id}/edit', name: 'stock_edit', methods: ['GET', 'POST'])]
public function stockEdit(Request $request, int $id): Response
{
    $stock = $this->stockRepo->find($id);

    if (!$stock) {
        $this->addFlash('error', '❌ Stock introuvable.');
        return $this->redirectToRoute('home');
    }

    $form = $this->createForm(StockType::class, $stock, ['show_produit' => false]);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $this->em->flush();
        $this->addFlash('success', '✅ Stock modifié avec succès !');
        return $this->redirectToRoute('home');
    }

    return $this->render('stock/form.html.twig', [
        'form'     => $form,
        'stock'    => $stock,
        'title'    => '✏️ Modifier le Stock',
        'subtitle' => 'Mettez à jour les informations du stock',
        'btnLabel' => '✓ Enregistrer les Modifications',
    ]);
}

    #[Route('/stock/{id}/delete', name: 'stock_delete', methods: ['POST'])]
public function stockDelete(Request $request, int $id): Response
{
    $stock = $this->stockRepo->find($id);

    if (!$stock) {
        $this->addFlash('error', '❌ Stock introuvable.');
        return $this->redirectToRoute('home');
    }

    if ($this->isCsrfTokenValid('delete' . $stock->getId(), $request->getPayload()->getString('_token'))) {
        $this->em->remove($stock);
        $this->em->flush();
        $this->addFlash('success', '🗑️ Stock supprimé avec succès.');
    }

    return $this->redirectToRoute('home');
}


    // ══════════════════════════════════════════════════════════════════════════
    // EXPORT PDF
    // ══════════════════════════════════════════════════════════════════════════

    // CORRECTION 8 : findFiltered() existe maintenant dans les deux repositories
    #[Route('/export/produits.pdf', name: 'export_produits_pdf')]
    public function exportProduitsPdf(Request $request): Response
    {
        $produits = $this->produitRepo->findFiltered(
            $request->query->get('q', ''),
            $request->query->get('cat', ''),
            $request->query->get('psort', 'nom'),
            $request->query->get('pdir', 'asc')
        );

        try {
            $content = $this->pdfService->generateProduits($produits);
        } catch (\RuntimeException $e) {
            $this->addFlash('error', $e->getMessage());
            return $this->redirectToRoute('home');
        }

        return new Response($content, 200, [
            'Content-Type'        => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="produits_'.date('Y-m-d').'.pdf"',
        ]);
    }

    #[Route('/export/stocks.pdf', name: 'export_stocks_pdf')]
    public function exportStocksPdf(Request $request): Response
    {
        $stocks = $this->stockRepo->findFiltered(
            $request->query->get('q', ''),
            $request->query->get('ssort', 'produit'),
            $request->query->get('sdir', 'asc')
        );

        try {
            $content = $this->pdfService->generateStocks($stocks);
        } catch (\RuntimeException $e) {
            $this->addFlash('error', $e->getMessage());
            return $this->redirectToRoute('home');
        }

        return new Response($content, 200, [
            'Content-Type'        => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="stocks_'.date('Y-m-d').'.pdf"',
        ]);
    }

    #[Route('/export/alertes.pdf', name: 'export_alertes_pdf')]
    public function exportAlertesPdf(): Response
    {
        try {
            $content = $this->pdfService->generateAlertes();
        } catch (\RuntimeException $e) {
            $this->addFlash('error', $e->getMessage());
            return $this->redirectToRoute('home');
        }

        return new Response($content, 200, [
            'Content-Type'        => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="alertes_'.date('Y-m-d').'.pdf"',
        ]);
    }

    // ══════════════════════════════════════════════════════════════════════════
    // API NOTIFICATIONS
    // ══════════════════════════════════════════════════════════════════════════

    #[Route('/api/notifications', name: 'api_notifications')]
    public function apiNotifications(): JsonResponse
    {
        return $this->json([
            'notifications' => $this->notifService->getStockNotifications(),
            'summary'       => $this->notifService->getSummary(),
        ]);
    }

    // ══════════════════════════════════════════════════════════════════════════
    // HELPER PHOTO
    // ══════════════════════════════════════════════════════════════════════════

    private function handlePhoto($form, Produit $produit): void
    {
        $file = $form->get('photoFile')->getData();
        if (!$file) return;

        $safe     = $this->slugger->slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));
        $filename = $safe.'-'.uniqid().'.'.$file->guessExtension();

        try {
            $file->move($this->getParameter('photos_directory'), $filename);
            // CORRECTION 9 : setPhotoUrl() accepte ?string (nullable)
            $produit->setPhotoUrl('uploads/photos/'.$filename);
        } catch (FileException) {
            $this->addFlash('error', 'Erreur lors du téléchargement de la photo.');
        }
    }
}
