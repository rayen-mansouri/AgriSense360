<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Entity\Stock;
use App\Form\ProduitType;
use App\Repository\ProduitRepository;
use App\Repository\StockRepository;
use App\Service\RecommendationService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class FrontController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(
        ProduitRepository $produitRepo,
        StockRepository $stockRepo,
        RecommendationService $recoService
    ): Response {
        $produits = $produitRepo->findBy([], ['id' => 'DESC'], 6);
        $recommendations = $recoService->recommendGeneral(4);
        $categories = $produitRepo->findAllCategories();
        
        return $this->render('front/index.html.twig', [
            'produits' => $produits,
            'recommendations' => $recommendations,
            'totalProduits' => count($produitRepo->findAll()),
            'totalStocks' => count($stockRepo->findAll()),
            'totalCategories' => count($categories),
        ]);
    }
    
    #[Route('/catalogue', name: 'catalogue')]
    public function catalogue(
        Request $request,
        ProduitRepository $produitRepo
    ): Response {
        $search = $request->query->get('q', '');
        $selectedCat = $request->query->get('cat', '');
        
        $produits = $produitRepo->findFiltered($search, $selectedCat, 'nom', 'asc');
        $categories = $produitRepo->findAllCategories();
        
        return $this->render('front/catalogue.html.twig', [
            'produits' => $produits,
            'categories' => $categories,
            'search' => $search,
            'selectedCat' => $selectedCat,
        ]);
    }
    
    #[Route('/produit/nouveau', name: 'front_produit_new', methods: ['GET', 'POST'])]
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
            try {
                $photoFile->move($this->getParameter('photos_directory'), $newFilename);
                $produit->setPhotoUrl('uploads/photos/' . $newFilename);
            } catch (FileException $e) {
                $this->addFlash('error', 'Erreur photo');
            }
        }
        
        $em->persist($produit);
        $em->flush();
        
        $this->addFlash('success', 'Produit ajouté !');
        return $this->redirectToRoute('catalogue');
    }
    
    return $this->render('front/produit/form.html.twig', [
        'form' => $form->createView(),
    ]);
}
    
    #[Route('/produit/{id}', name: 'front_produit_show', methods: ['GET'])]
    public function showProduit(Produit $produit): Response
    {
        $stock = $produit->getStockActuel();
        
        return $this->render('front/produit/show.html.twig', [
            'produit' => $produit,
            'stock' => $stock,
        ]);
    }
    #[Route('/produits', name: 'produit_index')]
public function produitIndex(
    Request $request,
    ProduitRepository $produitRepo
): Response {
    $search = $request->query->get('q', '');
    $selectedCat = $request->query->get('cat', '');
    
    $produits = $produitRepo->findFiltered($search, $selectedCat, 'nom', 'asc');
    $categories = $produitRepo->findAllCategories();
    
    return $this->render('front/catalogue.html.twig', [
        'produits' => $produits,
        'categories' => $categories,
        'search' => $search,
        'selectedCat' => $selectedCat,
    ]);
}
    
}