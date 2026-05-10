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
    public function gerantHome(\App\Repository\UserRepository $userRepository, \App\Service\CultureService $cultureService): Response
    {
        $this->denyAccessUnlessGranted('ROLE_GERANT');

        /** @var \App\Entity\User $user */
        $user = $this->getUser();
        if ($user->isFirstLogin()) {
            return $this->redirectToRoute('profile_first_login');
        }

        $farm = $user->getFarm();
        $pending_applications = [];
        $approved_team = [];
        $stats = ['total' => 0, 'retard' => 0, 'pretes' => 0];

        if ($farm) {
            $allMembers = $userRepository->findBy(['farm' => $farm]);
            foreach ($allMembers as $m) {
                if ($m->getStatus() === 'pending') {
                    $pending_applications[] = $m;
                } elseif ($m->getStatus() === 'active' || $m->getStatus() === 'ACTIVE') {
                    $approved_team[] = $m;
                }
            }
            $stats = $cultureService->getStats($farm);
        }

        return $this->render('gerant/home.html.twig', [
            'user' => $user,
            'pending_applications' => $pending_applications,
            'approved_team' => $approved_team,
            'pending_count' => count($pending_applications),
            'team_count' => count($approved_team),
            'culture_stats' => $stats,
            'farms_count' => $farm ? 1 : 0,
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