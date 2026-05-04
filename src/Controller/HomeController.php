<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * PUBLIC LANDING PAGE (homepage)
     */
    #[Route('/', name: 'app_index')]
    public function index(): Response
    {
        // If user is logged → redirect to dashboard
        if ($this->getUser()) {
            return $this->redirectToRoute('app_home');
        }

        // If NOT logged → show homepage (video page)
        return $this->render('home.html.twig');
    }

    /**
     * MAIN ENTRY AFTER LOGIN
     */
    #[Route('/home', name: 'app_home')]
    public function home(): Response
    {
        // Not logged → go login
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }

        // First login → force profile setup
        if ($this->getUser()->isFirstLogin()) {
            return $this->redirectToRoute('profile_first_login');
        }

        // GÉRANT LANDING PAGE (Landing page with Management Nav)
        if ($this->isGranted('ROLE_GERANT') && !$this->isGranted('ROLE_ADMIN')) {
            return $this->render('home.html.twig');
        }

        // Redirect based on role
        return $this->redirectBasedOnRole();
    }

    /**
     * GERANT DASHBOARD
     */
    #[Route('/gerant', name: 'gerant_home')]
    public function gerantHome(): Response
    {
        $this->denyAccessUnlessGranted('ROLE_GERANT');

        if ($this->getUser()->isFirstLogin()) {
            return $this->redirectToRoute('profile_first_login');
        }

        return $this->render('gerant/home.html.twig', [
            'user' => $this->getUser()
        ]);
    }

    /**
     * OUVRIER DASHBOARD
     */
    #[Route('/ouvrier', name: 'ouvrier_home')]
    public function ouvrierHome(): Response
    {
        $this->denyAccessUnlessGranted('ROLE_OUVRIER');

        if ($this->getUser()->isFirstLogin()) {
            return $this->redirectToRoute('profile_first_login');
        }

        return $this->render('ouvrier/home.html.twig', [
            'user' => $this->getUser()
        ]);
    }


    /**
     * ROLE REDIRECTION LOGIC
     */
    private function redirectBasedOnRole(): Response
    {
        if ($this->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('admin_dashboard');
        }

        if ($this->isGranted('ROLE_OWNER')) {
            return $this->redirectToRoute('farm_dashboard');
        }

        if ($this->isGranted('ROLE_GERANT')) {
            return $this->redirectToRoute('app_home');
        }

        if ($this->isGranted('ROLE_OUVRIER')) {
            return $this->redirectToRoute('ouvrier_home');
        }

        // ROLE_PENDING → farm browser to apply
        return $this->redirectToRoute('ouvrier_farms');
    }
}