<?php

namespace App\Controller\user;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends AbstractController
{
    private const ALLOWED_PUBLIC_ROLES = ['ROLE_GERANT', 'ROLE_OUVRIER'];

    #[Route('/register', name: 'app_register')]
    public function register(
        Request $request,
        UserRepository $userRepository,
        UserPasswordHasherInterface $passwordHasher
    ): Response {
        if ($this->getUser()) {
            return $this->redirectToRoute('app_home');
        }

        $error = null;
        $success = null;

        if ($request->isMethod('POST')) {
            $name     = trim($request->request->get('name', ''));
            $email    = trim($request->request->get('email', ''));
            $phone    = trim($request->request->get('phone', ''));
            $password = $request->request->get('password', '');
            $confirm  = $request->request->get('confirm_password', '');
            $role     = $request->request->get('role', 'ROLE_GERANT');

            // Only allow gerant/ouvrier from public registration
            if (!in_array($role, self::ALLOWED_PUBLIC_ROLES)) {
                $role = 'ROLE_GERANT';
            }

            if (empty($name) || empty($email) || empty($password)) {
                $error = 'Veuillez remplir tous les champs obligatoires.';
            } elseif ($password !== $confirm) {
                $error = 'Les mots de passe ne correspondent pas.';
            } elseif (strlen($password) < 6) {
                $error = 'Le mot de passe doit contenir au moins 6 caractères.';
            } elseif ($userRepository->findOneBy(['email' => $email])) {
                $error = 'Un compte avec cet email existe déjà.';
            } else {
                $user = new User();
                $user->setName($name);
                $user->setEmail($email);
                $user->setPhone($phone ?: null);
                $user->setRoles($role);
                $user->setStatus('active');
                $user->setAuthProvider('local');
                $user->setPassword($passwordHasher->hashPassword($user, $password));
                $user->setCreatedAt(new \DateTime());
                $user->setUpdatedAt(new \DateTime());

                $userRepository->save($user, true);

                $success = 'Compte créé avec succès ! Vous pouvez maintenant vous connecter.';
            }
        }

        return $this->render('user/register.html.twig', [
            'error'   => $error,
            'success' => $success,
        ]);
    }
}