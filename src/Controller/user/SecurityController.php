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
        $roles = $user->getRoles();

        if (in_array('ROLE_ADMIN', $roles))   return $this->redirectToRoute('admin_dashboard');
        if (in_array('ROLE_OWNER', $roles))   return $this->redirectToRoute('farm_dashboard');
        if (in_array('ROLE_GERANT', $roles))  return $this->redirectToRoute('gerant_home');
        if (in_array('ROLE_OUVRIER', $roles)) return $this->redirectToRoute('ouvrier_home');

        // ROLE_PENDING → farm browser
        return $this->redirectToRoute('ouvrier_farms');
    }
}