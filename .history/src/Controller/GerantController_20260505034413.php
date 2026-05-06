<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/gerant')]
#[IsGranted('ROLE_GERANT')]
class GerantController extends AbstractController
{
    #[Route('/ouvriers', name: 'gerant_ouvriers')]
    public function ouvriers(UserRepository $userRepository): Response
    {
        /** @var User $gerant */
        $gerant = $this->getUser();
        $farm = $gerant->getFarm();

        if (!$farm) {
            return $this->render('gerant/ouvriers.html.twig', [
                'ouvriers' => [],
            ]);
        }

        $all = $userRepository->findBy(['farm' => $farm]);
        $ouvriers = array_filter($all, fn($u) => in_array('ROLE_OUVRIER', $u->getRoles()));

        return $this->render('gerant/ouvriers.html.twig', [
            'ouvriers' => array_values($ouvriers),
        ]);
    }

    #[Route('/ouvriers/{id}', name: 'gerant_ouvrier_show', methods: ['GET'])]
    public function ouvrierShow(User $user): Response
    {
        // Only allow viewing ouvriers
        if (!in_array('ROLE_OUVRIER', $user->getRoles())) {
            return $this->redirectToRoute('gerant_ouvriers');
        }
        return $this->render('gerant/ouvrier_show.html.twig', ['user' => $user]);
    }

    #[Route('/ouvriers/{id}/supprimer', name: 'gerant_ouvrier_delete', methods: ['POST'])]
    public function ouvrierDelete(User $user, UserRepository $userRepository, Request $request): Response
    {
        if (!in_array('ROLE_OUVRIER', $user->getRoles())) {
            return $this->redirectToRoute('gerant_ouvriers');
        }
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $userRepository->remove($user, true);
            $this->addFlash('success', 'Ouvrier supprimé avec succès.');
        }
        return $this->redirectToRoute('gerant_ouvriers');
    }

    #[Route('/cultures', name: 'gerant_cultures')]
    public function cultures(): Response
    {
        return $this->redirectToRoute('culture_index');
    }

    #[Route('/stockes', name: 'gerant_stockes')]
    public function stockes(
        \App\Repository\ProduitRepository $produitRepo,
        \App\Repository\StockRepository $stockRepo,
        \App\Service\RecommendationService $recoService
    ): Response {
        $produits = $produitRepo->findBy([], ['id' => 'DESC'], 6);
        $recommendations = $recoService->recommendGeneral(4);
        $categories = $produitRepo->findAllCategories();

        return $this->render('front/_home_content.html.twig', [
            'produits'        => $produits,
            'recommendations' => $recommendations,
            'totalProduits'   => count($produitRepo->findAll()),
            'totalStocks'     => count($stockRepo->findAll()),
            'totalCategories' => count($categories),
        ]);
    }

    #[Route('/equipements', name: 'gerant_equipements')]
    public function equipements(): Response
    {
        return $this->render('gerant/equipements.html.twig');
    }

    #[Route('/affectations', name: 'gerant_affectations')]
    public function affectations(): Response
    {
        return $this->render('gerant/affectations.html.twig');
    }

    #[Route('/animaux', name: 'gerant_animaux')]
    public function animaux(): Response
    {
        return $this->render('gerant/animaux.html.twig');
    }
}
