<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/profile')]
class ProfileController extends AbstractController
{
    #[Route('', name: 'profile_show')]
    public function show(): Response
    {
        if (!$this->getUser()) return $this->redirectToRoute('app_login');
        return $this->render('profile/show.html.twig');
    }

    #[Route('/update', name: 'profile_update', methods: ['POST'])]
    public function update(
        Request $request,
        UserRepository $userRepository,
        UserPasswordHasherInterface $passwordHasher,
        SluggerInterface $slugger
    ): Response {
        $user = $this->getUser();
        if (!$user) return $this->redirectToRoute('app_login');

        $name     = trim($request->request->get('name', ''));
        $phone    = trim($request->request->get('phone', ''));
        $password = $request->request->get('password', '');
        $confirm  = $request->request->get('confirm_password', '');

        // Password change
        if (!empty($password)) {
            if ($password !== $confirm) {
                $this->addFlash('error', 'Les mots de passe ne correspondent pas.');
                return $this->redirectToRoute('profile_show');
            }
            if (strlen($password) < 6) {
                $this->addFlash('error', 'Le mot de passe doit contenir au moins 6 caractères.');
                return $this->redirectToRoute('profile_show');
            }
            $user->setPassword($passwordHasher->hashPassword($user, $password));
        }

        // Profile picture upload
        $pictureFile = $request->files->get('profile_picture');
        if ($pictureFile) {
            $allowed = ['image/jpeg', 'image/png', 'image/webp', 'image/gif'];
            if (!in_array($pictureFile->getMimeType(), $allowed)) {
                $this->addFlash('error', 'Format d\'image non supporté. Utilisez JPG, PNG ou WebP.');
                return $this->redirectToRoute('profile_show');
            }
            if ($pictureFile->getSize() > 3 * 1024 * 1024) {
                $this->addFlash('error', 'L\'image ne doit pas dépasser 3 Mo.');
                return $this->redirectToRoute('profile_show');
            }
            $originalFilename = pathinfo($pictureFile->getClientOriginalName(), PATHINFO_FILENAME);
            $safeFilename = $slugger->slug($originalFilename);
            $newFilename  = $safeFilename . '-' . uniqid() . '.' . $pictureFile->guessExtension();
            $uploadDir = __DIR__ . '/../../public/uploads/profiles/';
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
            $pictureFile->move($uploadDir, $newFilename);
            // Delete old picture
            if ($user->getProfilePicture()) {
                $oldFile = $uploadDir . $user->getProfilePicture();
                if (file_exists($oldFile)) unlink($oldFile);
            }
            $user->setProfilePicture($newFilename);
        }

        if (!empty($name))  $user->setName($name);
        $user->setPhone($phone ?: null);
        $user->setUpdatedAt(new \DateTime());

        $userRepository->save($user, true);
        $this->addFlash('success', 'Votre profil a été mis à jour avec succès.');

        return $this->redirectToRoute('profile_show');
    }

    #[Route('/first-login', name: 'profile_first_login')]
    public function firstLogin(): Response
    {
        if (!$this->getUser()) return $this->redirectToRoute('app_login');
        if (!$this->getUser()->isFirstLogin()) return $this->redirectToUserHome();
        return $this->render('profile/first_login.html.twig');
    }

    #[Route('/first-login/save', name: 'profile_first_login_save', methods: ['POST'])]
    public function firstLoginSave(
        Request $request,
        UserRepository $userRepository,
        SluggerInterface $slugger
    ): Response {
        $user = $this->getUser();
        if (!$user) return $this->redirectToRoute('app_login');

        $pictureFile = $request->files->get('profile_picture');
        if ($pictureFile) {
            $safeFilename = $slugger->slug(pathinfo($pictureFile->getClientOriginalName(), PATHINFO_FILENAME));
            $newFilename  = $safeFilename . '-' . uniqid() . '.' . $pictureFile->guessExtension();
            $uploadDir = __DIR__ . '/../../public/uploads/profiles/';
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
            $pictureFile->move($uploadDir, $newFilename);
            $user->setProfilePicture($newFilename);
        }

        $user->setFirstLogin(false);
        $userRepository->save($user, true);

        return $this->redirectToUserHome();
    }

    #[Route('/notifications', name: 'profile_notifications')]
    public function notifications(): Response
    {
        if (!$this->getUser()) return $this->redirectToRoute('app_login');
        return $this->render('profile/notifications.html.twig');
    }

    #[Route('/rapports', name: 'profile_rapports')]
    public function rapports(): Response
    {
        if (!$this->getUser()) return $this->redirectToRoute('app_login');
        return $this->render('profile/rapports.html.twig');
    }

    #[Route('/aide', name: 'profile_help')]
    public function help(): Response
    {
        if (!$this->getUser()) return $this->redirectToRoute('app_login');
        return $this->render('profile/help.html.twig');
    }

    private function redirectToUserHome(): Response
    {
        $roles = $this->getUser()->getRoles();
        if (in_array('ROLE_ADMIN', $roles))   return $this->redirectToRoute('admin_dashboard');
        if (in_array('ROLE_GERANT', $roles))  return $this->redirectToRoute('gerant_home');
        return $this->redirectToRoute('ouvrier_home');
    }
}