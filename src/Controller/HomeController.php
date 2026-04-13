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
     * ADMIN DASHBOARD (IMPORTANT if you use admin)
     */
    #[Route('/admin', name: 'admin_home')]
    public function adminHome(): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        return $this->render('admin/dashboard.html.twig');
    }

    /**
     * ROLE REDIRECTION LOGIC
     */
    private function redirectBasedOnRole(): Response
    {
        if ($this->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('admin_home');
        }

        if ($this->isGranted('ROLE_GERANT')) {
            return $this->redirectToRoute('gerant_home');
        }

        if ($this->isGranted('ROLE_OUVRIER')) {
            return $this->redirectToRoute('ouvrier_home');
        }

        // fallback (user normal)
        return $this->redirectToRoute('app_index');
    }
}