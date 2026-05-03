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

        if ($request->isMethod('POST')) {
            $name     = trim($request->request->get('name', ''));
            $email    = trim($request->request->get('email', ''));
            $password = $request->request->get('password', '');
            $confirm  = $request->request->get('confirm_password', '');
            $type     = $request->request->get('type', 'worker'); // 'owner' | 'worker'

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
                $user->setAuthProvider('local');
                $user->setPassword($passwordHasher->hashPassword($user, $password));
                $user->setCreatedAt(new \DateTime());
                $user->setUpdatedAt(new \DateTime());
                $user->setFirstLogin(true);

                if ($type === 'owner') {
                    // Owner — active immediately, sets up farm after onboarding
                    $user->setRoles(['ROLE_OWNER']);
                    $user->setStatus('active');
                    $userRepository->save($user, true);

                    $this->addFlash('success', 'Compte propriétaire créé ! Connectez-vous pour configurer votre profil et votre ferme.');
                    return $this->redirectToRoute('app_login');
                } else {
                    // Worker — pending until they apply to a farm and get approved
                    // NO CV at registration — it is uploaded when applying to a specific farm
                    $user->setRoles(['ROLE_PENDING']);
                    $user->setStatus('pending');
                    $userRepository->save($user, true);

                    $this->addFlash('success', 'Compte créé ! Connectez-vous, complétez votre profil, puis postulez à une ferme avec votre CV.');
                    return $this->redirectToRoute('app_login');
                }
            }
        }

        return $this->render('user/register.html.twig', [
            'error' => $error,
        ]);
    }
}