<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Entity\Stock;
use App\Form\ProduitType;
use App\Form\StockType;
use App\Repository\ProduitRepository;
use App\Repository\StockRepository;
use App\Service\RecommendationService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;


class FrontController extends AbstractController
{
    #[Route('/', name: 'front_accueil')]
    public function home(
        ProduitRepository $produitRepo,
        StockRepository $stockRepo,
        RecommendationService $recoService
    ): Response {
        $produits = $produitRepo->findBy([], ['id' => 'DESC'], 6);
        $recommendations = $recoService->recommendGeneral(4);
        $categories = $produitRepo->findAllCategories();

        return $this->render('front/home.html.twig', [
            'produits'        => $produits,
            'recommendations' => $recommendations,
            'totalProduits'   => count($produitRepo->findAll()),
            'totalStocks'     => count($stockRepo->findAll()),
            'totalCategories' => count($categories),
        ]);
    }

    #[Route('/catalogue', name: 'front_catalogue')]
    public function catalogue(
        Request $request,
        ProduitRepository $produitRepo
    ): Response {
        $search      = $request->query->get('q', '');
        $selectedCat = $request->query->get('cat', '');

        $produits   = $produitRepo->findFiltered($search, $selectedCat, 'nom', 'asc');
        $categories = $produitRepo->findAllCategories();

        return $this->render('front/catalogue.html.twig', [
            'produits'    => $produits,
            'categories'  => $categories,
            'search'      => $search,
            'selectedCat' => $selectedCat,
        ]);
    }

    #[Route('/fiche-produit/{id}', name: 'front_produit_show', methods: ['GET'])]
    public function showProduit(Produit $produit): Response
    {
        $stock = $produit->getStockActuel();

        return $this->render('front/produit/show.html.twig', [
            'produit' => $produit,
            'stock'   => $stock,
        ]);
    }

    #[Route('/ajouter-produit', name: 'front_produit_new', methods: ['GET', 'POST'])]
    public function newProduit(
        Request $request,
        EntityManagerInterface $em,
        SluggerInterface $slugger
    ): Response {
        $produit = new Produit();
        $produit->setAgriculteurId(1);

        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $photoFile = $form->get('photoFile')->getData();

            if ($photoFile) {
                $newFilename = uniqid() . '.' . $photoFile->guessExtension();
                $photoFile->move($this->getParameter('photos_directory'), $newFilename);
                $produit->setPhotoUrl('uploads/photos/' . $newFilename);
            }

            $em->persist($produit);
            $em->flush();

            $this->addFlash('success', '✅ Produit ajouté avec succès !');
            return $this->redirectToRoute('front_catalogue');
        }

        return $this->render('front/produit/form.html.twig', [
            'form'     => $form->createView(),
            'title'    => '🌱 Nouveau produit',
            'subtitle' => 'Ajoutez un produit à votre catalogue',
            'btnLabel' => 'Publier le produit',
        ]);
    }

   
    #[Route('/supprimer-produit/{id}', name: 'front_produit_delete', methods: ['POST'])]
    public function deleteProduit(
        Produit $produit,
        Request $request,
        EntityManagerInterface $em
    ): Response {
        // Vérification du token CSRF
        if ($this->isCsrfTokenValid('delete_produit_' . $produit->getId(), $request->request->get('_token'))) {
            // Supprimer la photo si elle existe
            if ($produit->getPhotoUrl()) {
                $photoPath = $this->getParameter('kernel.project_dir') . '/public/' . $produit->getPhotoUrl();
                if (file_exists($photoPath)) {
                    unlink($photoPath);
                }
            }

            $em->remove($produit);
            $em->flush();

            $this->addFlash('success', '✅ Produit supprimé avec succès !');
        } else {
            $this->addFlash('error', '❌ Token invalide, suppression annulée.');
        }

        return $this->redirectToRoute('front_catalogue');
    }

    // =============================================
    // STOCK
    // =============================================

    #[Route('/stock/ajouter/{id}', name: 'front_stock_new', methods: ['GET', 'POST'])]
    public function newStock(
        Produit $produit,
        Request $request,
        EntityManagerInterface $em
    ): Response {
        $stock = new Stock();
        $stock->setProduit($produit);

        $form = $this->createForm(StockType::class, $stock, [
            'show_produit' => false,
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($stock);
            $em->flush();

            $this->addFlash('success', '✅ Stock ajouté avec succès !');
            return $this->redirectToRoute('front_produit_show', ['id' => $produit->getId()]);
        }

        return $this->render('front/stock/form.html.twig', [
            'form'     => $form->createView(),
            'produit'  => $produit,
            'title'    => '📦 Ajouter un stock',
            'subtitle' => 'Pour le produit : ' . $produit->getNom(),
            'btnLabel' => 'Ajouter le stock',
        ]);
    }

    // src/Controller/Front/ProduitController.php

// Dans src/Controller/Front/ProduitController.php

    #[Route('/modifier-produit/{id}', name: 'front_produit_edit', methods: ['GET', 'POST'])]
    public function editProduit(
        Produit $produit,
        Request $request,
        EntityManagerInterface $em,
        SluggerInterface $slugger
    ): Response {
        $stock = $produit->getStockActuel();
        
        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $photoFile = $form->get('photoFile')->getData();

            if ($photoFile) {
                if ($produit->getPhotoUrl()) {
                    $oldPath = $this->getParameter('photos_directory') . '/' . basename($produit->getPhotoUrl());
                    if (file_exists($oldPath)) {
                        @unlink($oldPath);
                    }
                }
                $newFilename = uniqid() . '.' . $photoFile->guessExtension();
                $photoFile->move($this->getParameter('photos_directory'), $newFilename);
                $produit->setPhotoUrl('uploads/photos/' . $newFilename);
            }

            // Gestion du stock
            $stockQuantite = $request->request->get('stock_quantite');
            $stockUnite = $request->request->get('stock_unite');
            
            if ($stockQuantite && (float)$stockQuantite > 0 && $stockUnite) {
                if (!$stock) {
                    $stock = new Stock();
                    $stock->setProduit($produit);
                }
                
                $stock->setQuantiteActuelle((string) $stockQuantite);
                $stock->setUniteMesure($stockUnite);
                
                if ($seuil = $request->request->get('stock_seuil')) {
                    $stock->setSeuilAlerte((string) $seuil);
                }
                if ($emplacement = $request->request->get('stock_emplacement')) {
                    $stock->setEmplacement($emplacement);
                }
                if ($dateReception = $request->request->get('stock_date_reception')) {
                    try {
                        $stock->setDateReception(new \DateTime($dateReception));
                    } catch (\Exception $e) {}
                }
                if ($dateExpiration = $request->request->get('stock_date_expiration')) {
                    try {
                        $stock->setDateExpiration(new \DateTime($dateExpiration));
                    } catch (\Exception $e) {}
                }
                
                $em->persist($stock);
            }

            $em->flush();

            $this->addFlash('success', '✅ Produit modifié avec succès !');
            return $this->redirectToRoute('front_produit_show', ['id' => $produit->getId()]);
        }

        return $this->render('front/produit/front_edit.html.twig', [
            'form'     => $form->createView(),
            'produit'  => $produit,
            'stock'    => $stock,
            'title'    => '✏️ Modifier le produit',
            'subtitle' => 'Modifiez les informations du produit',
            'btnLabel' => 'Enregistrer les modifications',
        ]);
    }

    #[Route('/modifier-stock/{id}', name: 'front_stock_edit', methods: ['GET', 'POST'])]
public function editStock(
    Stock $stock,
    Request $request,
    EntityManagerInterface $em
): Response {
    $produit = $stock->getProduit();
    
    $form = $this->createForm(StockType::class, $stock, [
        'show_produit' => false,
    ]);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $em->flush();
        $this->addFlash('success', '✅ Stock modifié avec succès !');
        return $this->redirectToRoute('front_stock_list');
    }

    return $this->render('front/stock/form.html.twig', [
        'form'     => $form->createView(),
        'produit'  => $produit,
        'title'    => '✏️ Modifier le stock',
        'subtitle' => 'Pour le produit : ' . $produit->getNom(),
        'btnLabel' => 'Enregistrer les modifications',
    ]);
}
/*private function handleStockData(Request $request, Produit $produit, EntityManagerInterface $em): void
{
    $stockQuantite = $request->request->get('stock_quantite');
    $stockUnite = $request->request->get('stock_unite');
    
    if ($stockQuantite && $stockQuantite > 0 && $stockUnite) {
        $stock = $produit->getStock() ?? new Stock();
        $stock->setProduit($produit);
        $stock->setQuantite((float) $stockQuantite);
        $stock->setUnite($stockUnite);
        
        if ($seuil = $request->request->get('stock_seuil')) {
            $stock->setSeuilAlerte((float) $seuil);
        }
        
        if ($emplacement = $request->request->get('stock_emplacement')) {
            $stock->setEmplacement($emplacement);
        }
        
        if ($dateReception = $request->request->get('stock_date_reception')) {
            try {
                $stock->setDateReception(new \DateTime($dateReception));
            } catch (\Exception $e) {}
        }
        
        if ($dateExpiration = $request->request->get('stock_date_expiration')) {
            try {
                $stock->setDateExpiration(new \DateTime($dateExpiration));
            } catch (\Exception $e) {}
        }
        
        $em->persist($stock);
    }
}*/
    #[Route('/stock/supprimer/{id}', name: 'front_stock_delete', methods: ['POST'])]
    public function deleteStock(
        Stock $stock,
        Request $request,
        EntityManagerInterface $em
    ): Response {
        $produitId = $stock->getProduit()->getId();

        if ($this->isCsrfTokenValid('delete_stock_' . $stock->getId(), $request->request->get('_token'))) {
            $em->remove($stock);
            $em->flush();

            $this->addFlash('success', '✅ Stock supprimé avec succès !');
        } else {
            $this->addFlash('error', '❌ Token invalide, suppression annulée.');
        }

        return $this->redirectToRoute('front_produit_show', ['id' => $produitId]);
    }

    #[Route('/mes-stocks', name: 'front_stock_list', methods: ['GET'])]
public function listStocks(
    StockRepository $stockRepo,
    ProduitRepository $produitRepo
): Response {
    $stocks = $stockRepo->findAll();
    
    // Récupérer tous les produits
    $tousLesProduits = $produitRepo->findAll();
    
    // Garder uniquement les produits qui n'ont PAS de stock
    $produitsSansStock = [];
    foreach ($tousLesProduits as $produit) {
        if ($produit->getStockActuel() === null) {
            $produitsSansStock[] = $produit;
        }
    }

    return $this->render('front/stock/list.html.twig', [
        'stocks'           => $stocks,
        'produitsSansStock'=> $produitsSansStock,
    ]);
}
#[Route('/scanner', name: 'front_scanner')]
public function scanner(): Response
{
    return $this->render('front/scanner.html.twig');
}

#[Route('/api/produit/recherche', name: 'api_produit_search')]
public function searchByBarcode(Request $request, ProduitRepository $produitRepo): JsonResponse
{
    $code = $request->query->get('code');
    
    // Recherche par SKU (code-barres généré)
    $produit = $produitRepo->findOneBy(['sku' => $code]);
    
    // Si non trouvé, recherche par ID
    if (!$produit && is_numeric($code)) {
        $produit = $produitRepo->find($code);
    }
    
    if (!$produit) {
        return $this->json(['error' => 'Produit non trouvé'], 404);
    }
    
    return $this->json([
        'id' => $produit->getId(),
        'nom' => $produit->getNom(),
        'url' => $this->generateUrl('front_produit_show', ['id' => $produit->getId()])
    ]);
}
#[Route('/exchange', name: 'front_exchange')]
public function exchange(ProduitRepository $produitRepo): Response
{
    return $this->render('front/exchange.html.twig', [
        $produits = $this->produitRepo->createQueryBuilder('p')
        ->setMaxResults(100)  // Limite à 100 produits
        ->getQuery()
    ->getResult();
    ]);
}

#[Route('/commodity', name: 'front_commodity')]
public function commodity(ProduitRepository $produitRepo): Response
{
    $categoriesComparables = ['Semences', 'Engrais', 'Alimentation animale'];
    $produitsCompatibles = $produitRepo->findBy(['categorie' => $categoriesComparables]);
    
    return $this->render('front/commodity.html.twig', [
        'produits' => $produitRepo->findAll(),
        'produitsCompatibles' => $produitsCompatibles
    ]);
}
}