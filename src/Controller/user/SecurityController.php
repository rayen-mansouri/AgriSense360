<?php

namespace App\Controller\user;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route('/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->getUser()) {
            return $this->redirectToUserHome($this->getUser());
        }

        $error        = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('user/login.html.twig', [
            'last_username' => $lastUsername,
            'error'         => $error,
        ]);
    }

    #[Route('/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method should not be reached.');
    }

    private function redirectToUserHome($user): Response
    {
        if ($this->isGranted('ROLE_ADMIN'))   return $this->redirectToRoute('admin_dashboard');
        if ($this->isGranted('ROLE_OWNER'))   return $this->redirectToRoute('farm_dashboard');
        if ($this->isGranted('ROLE_GERANT'))  return $this->redirectToRoute('app_home');
        if ($this->isGranted('ROLE_OUVRIER')) return $this->redirectToRoute('ouvrier_home');

        // ROLE_PENDING → farm browser
        return $this->redirectToRoute('ouvrier_farms');
    }
}