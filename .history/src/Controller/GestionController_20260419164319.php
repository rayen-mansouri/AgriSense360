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
use App\Service\BarcodeService;


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

    #[Route('/home', name: 'home')]
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
            $newFilename = uniqid() . '.' . $photoFile->guessExtension();
            $photoFile->move($this->getParameter('photos_directory'), $newFilename);
            $produit->setPhotoUrl('uploads/photos/' . $newFilename);
        }
        
        $produit->setAgriculteurId(1);
        
        // Persister d'abord pour obtenir l'ID
        $this->em->persist($produit);
        $this->em->flush();
        
        // ⭐ Génération du code-barres uniquement ⭐
        $sku = $barcodeService->generateSKU($produit->getId(), $produit->getCategorie());
        $barcodeImage = $barcodeService->generateCode128($sku);
        
        $produit->setSku($sku);
        $produit->setBarcodeUrl($barcodeImage);
        
        // Stock optionnel
        if ($stock->getQuantiteActuelle() !== null && $stock->getQuantiteActuelle() > 0) {
            $stock->setProduit($produit);
            $this->em->persist($stock);
        }
        
        $this->em->flush();

        $this->addFlash('success', '✅ Produit créé avec code-barres !');
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
// src/Controller/ProduitController.php

#[Route('/api/produit/recherche', name: 'api_produit_search', methods: ['GET'])]
public function searchByBarcode(Request $request, ProduitRepository $produitRepo): JsonResponse
{
    $code = $request->query->get('code');
    
    // 1. Recherche par SKU
    $produit = $produitRepo->findOneBy(['sku' => $code]);
    
    // 2. Si non trouvé, rechercher par ID
    if (!$produit && is_numeric($code)) {
        $produit = $produitRepo->find($code);
    }
    
    // 3. Si non trouvé, rechercher par nom (contient)
    if (!$produit) {
        $produit = $produitRepo->findOneBy(['nom' => $code]);
    }
    
    if (!$produit) {
        return $this->json(['error' => 'Produit non trouvé'], 404);
    }
    
    return $this->json([
        'id' => $produit->getId(),
        'nom' => $produit->getNom(),
        'sku' => $produit->getSku(),
        'prix' => $produit->getPrixUnitaire(),
        'categorie' => $produit->getCategorie(),
        'url' => '/produit/' . $produit->getId()
    ]);
}
#[Route('/scanner', name: 'produit_scanner', methods: ['GET'])]
public function scanner(): Response
{
    return $this->render('produit/scanner.html.twig');
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
    #[Route('/export/excel/produits', name: 'export_excel_produits')]
public function exportExcel(ExcelExportService $excelService): Response
{
    return $excelService->exportProducts();
}
#[Route('/exchange', name: 'api_exchange_view')]
public function exchangeView(ProduitRepository $produitRepo): Response
{
    return $this->render('api/exchange.html.twig', [
        'produits' => $produitRepo->findAll()
    ]);
}
// src/Controller/GestionController.php (ou ApiController)

#[Route('/commodity', name: 'api_commodity_view')]
public function commodityView(ProduitRepository $produitRepo): Response
{
    // Récupérer TOUS les produits
    $produits = $produitRepo->findAll();
    
    // Filtrer les produits comparables (ceux qui ont une catégorie pertinente)
    $categoriesComparables = ['Semences', 'Engrais', 'Alimentation animale', 'Céréales'];
    $produitsCompatibles = $produitRepo->findBy(['categorie' => $categoriesComparables]);
    
    // Calcul des statistiques
    $totalProduits = count($produits);
    $totalCompatibles = count($produitsCompatibles);
    $prixMoyenMarche = 290; // Valeur approximative
    
    // Compter les produits compétitifs (à ajuster selon votre logique)
    $produitsCompetitifs = 0;
    foreach ($produitsCompatibles as $produit) {
        // Exemple: un produit est compétitif si son prix est < 100 DT
        if ($produit->getPrixUnitaire() < 100) {
            $produitsCompetitifs++;
        }
    }
    $pourcentageCompetitifs = $totalCompatibles > 0 ? round($produitsCompetitifs / $totalCompatibles * 100) : 0;
    
    return $this->render('api/commodity.html.twig', [
        'produits' => $produits,
        'produitsCompatibles' => $produitsCompatibles,
        'prixMoyenMarche' => $prixMoyenMarche,
        'produitsCompetitifs' => $pourcentageCompetitifs
    ]);
}
#[Route('/analyse', name: 'analyse_complete')]
public function completeAnalysis(ProduitRepository $produitRepo): Response
{
    $produits = $produitRepo->findAll();
    
    // Calcul simple de la qualité
    $qualites = [];
    foreach ($produits as $produit) {
        $score = 50; // score de base
        if ($produit->getDescription()) $score += 20;
        if ($produit->getPhotoUrl()) $score += 20;
        if ($produit->getSku()) $score += 10;
        
        $qualites[] = [
            'produit' => $produit->getNom(),
            'score_global' => min(100, $score),
            'niveau' => $score >= 70 ? '✅ Bonne qualité' : ($score >= 50 ? '⚠️ Qualité moyenne' : '🔴 À améliorer'),
            'champs_manquants' => []
        ];
    }
    
    // Calcul simple de la rentabilité
    $rentabilite = [];
    foreach ($produits as $produit) {
        $prix = $produit->getPrixUnitaire();
        $marge = round($prix * 0.3, 2); // marge estimée à 30%
        
        $rentabilite[] = [
            'produit' => $produit->getNom(),
            'prix_vente' => $prix,
            'marge_brute' => $marge,
            'taux_marge' => 30,
            'performance' => $prix > 50 ? '🚀 Très rentable' : '✅ Rentable'
        ];
    }
    
    $prixMoyen = array_sum(array_map(fn($p) => $p->getPrixUnitaire(), $produits)) / max(1, count($produits));
    
    return $this->render('ai/complete_analysis.html.twig', [
        'produits' => $produits,
        'categories' => $produitRepo->findAllCategories(),
        'qualites' => $qualites,
        'rentabilite' => $rentabilite,
        'prixMoyen' => round($prixMoyen, 2)
    ]);
}

#[Route('/api/ai/anomalies', name: 'api_ai_anomalies')]
public function anomalies(ProduitRepository $produitRepo): JsonResponse
{
    $produits = $produitRepo->findAll();
    $categories = $produitRepo->findAllCategories();
    
    $anomalies = [];
    
    foreach ($categories as $categorie) {
        $produitsCat = $produitRepo->findBy(['categorie' => $categorie]);
        $prices = array_map(fn($p) => $p->getPrixUnitaire(), $produitsCat);
        
        if (count($prices) < 2) continue;
        
        $mean = array_sum($prices) / count($prices);
        
        foreach ($produitsCat as $produit) {
            $price = $produit->getPrixUnitaire();
            $ecart = $price - $mean;
            $ecartPercent = $mean > 0 ? ($ecart / $mean * 100) : 0;
            
            if (abs($ecartPercent) > 30) {
                $anomalies[] = [
                    'produit' => $produit->getNom(),
                    'categorie' => $categorie,
                    'prix' => $price,
                    'prix_moyen' => round($mean, 2),
                    'ecart' => round($ecart, 2),
                    'type' => $ecart > 0 ? 'Prix élevé' : 'Prix bas',
                    'recommandation' => $ecart > 0 ? 'Peut-être surévalué' : 'Bon rapport qualité-prix'
                ];
            }
        }
    }
    
    return $this->json([
        'anomalies' => $anomalies,
        'total_anomalies' => count($anomalies)
    ]);
}
// src/Controller/GestionController.php

// Ajoutez cette méthode
#[Route('/api/ai/classify', name: 'api_ai_classify', methods: ['POST'])]
public function classify(Request $request, ProduitRepository $produitRepo): JsonResponse
{
    $data = json_decode($request->getContent(), true);
    $nom = $data['nom'] ?? '';
    $prix = $data['prix'] ?? 50;
    
    // Récupérer tous les produits existants pour l'apprentissage
    $produits = $produitRepo->findAll();
    
    if (count($produits) === 0) {
        return $this->json([
            'categorie_predite' => 'Autre',
            'confiance' => 0,
            'votes' => ['Autre' => 1]
        ]);
    }
    
    // Calculer les caractéristiques du nouveau produit
    $prixMax = max(array_map(fn($p) => $p->getPrixUnitaire(), $produits));
    $prixNormalise = $prixMax > 0 ? $prix / $prixMax : 0;
    
    $nouveauFeatures = [
        strlen($nom),
        $prixNormalise,
        1, // suppose qu'il a une photo (peut être ajusté)
        1, // suppose qu'il a une description
        0  // suppose pas de code-barres
    ];
    
    // Calculer les distances avec tous les produits existants
    $distances = [];
    foreach ($produits as $produit) {
        $features = [
            strlen($produit->getNom()),
            $prixMax > 0 ? $produit->getPrixUnitaire() / $prixMax : 0,
            $produit->getPhotoUrl() ? 1 : 0,
            $produit->getDescription() ? 1 : 0,
            $produit->getSku() ? 1 : 0
        ];
        
        // Distance euclidienne
        $distance = 0;
        for ($i = 0; $i < count($nouveauFeatures); $i++) {
            $distance += pow($nouveauFeatures[$i] - $features[$i], 2);
        }
        $distance = sqrt($distance);
        
        $distances[] = [
            'distance' => $distance,
            'categorie' => $produit->getCategorie() ?? 'Autre'
        ];
    }
    
    // Trier par distance (plus proche d'abord)
    usort($distances, fn($a, $b) => $a['distance'] <=> $b['distance']);
    
    // Prendre les 3 plus proches voisins (K=3)
    $k = min(3, count($distances));
    $voisins = array_slice($distances, 0, $k);
    
    // Compter les votes par catégorie
    $votes = [];
    foreach ($voisins as $voisin) {
        $votes[$voisin['categorie']] = ($votes[$voisin['categorie']] ?? 0) + 1;
    }
    
    // Trouver la catégorie avec le plus de votes
    arsort($votes);
    $categoriePredite = key($votes);
    $confiance = round(current($votes) / $k * 100, 2);
    
    return $this->json([
        'categorie_predite' => $categoriePredite,
        'confiance' => $confiance,
        'votes' => $votes
    ]);
}
}
