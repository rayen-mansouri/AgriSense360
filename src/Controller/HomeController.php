<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_index')]
    public function index(): Response
    {
        if ($this->getUser()) {
            return $this->redirectBasedOnRole();
        }
        return $this->render('home.html.twig');
    }

    #[Route('/home', name: 'app_home')]
    public function home(): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }
        // Check first login
        if ($this->getUser()->isFirstLogin()) {
            return $this->redirectToRoute('profile_first_login');
        }
        return $this->redirectBasedOnRole();
    }

    #[Route('/gerant', name: 'gerant_home')]
    public function gerantHome(): Response
    {
        if (!$this->getUser()) return $this->redirectToRoute('app_login');
        if ($this->getUser()->isFirstLogin()) return $this->redirectToRoute('profile_first_login');
        return $this->render('gerant/home.html.twig', ['user' => $this->getUser()]);
    }

    #[Route('/ouvrier', name: 'ouvrier_home')]
    public function ouvrierHome(): Response
    {
        if (!$this->getUser()) return $this->redirectToRoute('app_login');
        if ($this->getUser()->isFirstLogin()) return $this->redirectToRoute('profile_first_login');
        return $this->render('ouvrier/home.html.twig', ['user' => $this->getUser()]);
    }

    private function redirectBasedOnRole(): Response
    {
        $user  = $this->getUser();
        $roles = $user->getRoles();
        if ($user->isFirstLogin()) return $this->redirectToRoute('profile_first_login');
        if (in_array('ROLE_ADMIN',   $roles)) return $this->redirectToRoute('admin_home');
        if (in_array('ROLE_GERANT',  $roles)) return $this->redirectToRoute('gerant_home');
        if (in_array('ROLE_OUVRIER', $roles)) return $this->redirectToRoute('ouvrier_home');
        return $this->redirectToRoute('app_index');
    }
}