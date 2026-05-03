<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/profile')]
class ProfileController extends AbstractController
{
    // ── DiceBear styles available to the user ─────────────────────────────────
    private const AVATAR_STYLES = [
        'initials'    => 'Initiales',
        'adventurer'  => 'Aventurier',
        'bottts'      => 'Robot',
        'pixel-art'   => 'Pixel Art',
        'fun-emoji'   => 'Emoji',
        'lorelei'     => 'Lorelei',
    ];

    // ── Helpers ───────────────────────────────────────────────────────────────

    /**
     * Returns the DiceBear URL for a given name and style.
     * If the user has a real uploaded/Google picture that is a full URL or a
     * local filename, this method is NOT used — the template handles that case.
     */
    public static function dicebearUrl(string $name, string $style = 'initials'): string
    {
        // backgroundColor matches the AgriSense green palette
        return sprintf(
            'https://api.dicebear.com/9.x/%s/svg?seed=%s&backgroundColor=3e8e3e,2d6a2d',
            $style,
            urlencode($name)
        );
    }

    // ─────────────────────────────────────────────────────────────────────────
    // Routes
    // ─────────────────────────────────────────────────────────────────────────

    #[Route('', name: 'profile_show')]
    public function show(): Response
    {
        if (!$this->getUser()) return $this->redirectToRoute('app_login');

        return $this->render('profile/show.html.twig', [
            'avatar_styles' => self::AVATAR_STYLES,
            'dicebear_base' => 'https://api.dicebear.com/9.x/',
        ]);
    }

    // ── Update profile info & password ────────────────────────────────────────
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

        // Password — skip if user signed in via Google (no local password)
        if (!empty($password)) {
            if ($user->getAuthProvider() === 'google') {
                $this->addFlash('error', 'Les comptes Google ne peuvent pas modifier le mot de passe ici.');
                return $this->redirectToRoute('profile_show');
            }
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

        // Profile picture — uploaded file
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

            $safeFilename = $slugger->slug(pathinfo($pictureFile->getClientOriginalName(), PATHINFO_FILENAME));
            $newFilename  = $safeFilename . '-' . uniqid() . '.' . $pictureFile->guessExtension();
            $uploadDir    = __DIR__ . '/../../public/uploads/profiles/';

            if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

            // Delete old LOCAL picture (not Google URLs)
            $old = $user->getProfilePicture();
            if ($old && !str_starts_with($old, 'http')) {
                $oldFile = $uploadDir . $old;
                if (file_exists($oldFile)) unlink($oldFile);
            }

            $pictureFile->move($uploadDir, $newFilename);
            $user->setProfilePicture($newFilename);
        }

        if (!empty($name))  $user->setName($name);
        $user->setPhone($phone ?: null);
        $user->setUpdatedAt(new \DateTime());

        $userRepository->save($user, true);
        $this->addFlash('success', 'Votre profil a été mis à jour avec succès.');

        return $this->redirectToRoute('profile_show');
    }

    // ── Quick-update via AJAX (navbar dropdown modal) ──────────────────────
    #[Route('/quick-update', name: 'profile_quick_update', methods: ['POST'])]
    public function quickUpdate(
        Request $request,
        UserRepository $userRepository,
        UserPasswordHasherInterface $passwordHasher,
        SluggerInterface $slugger
    ): JsonResponse {
        $user = $this->getUser();
        if (!$user) return new JsonResponse(['success' => false, 'message' => 'Non authentifié.'], 401);

        $name        = trim($request->request->get('name', ''));
        $newPassword = $request->request->get('new_password', '');
        $confirm     = $request->request->get('confirm_password', '');
        $currentPwd  = $request->request->get('current_password', '');

        // Verify current password (skip for Google accounts that have no local pwd)
        if ($user->getAuthProvider() !== 'google') {
            if (!$passwordHasher->isPasswordValid($user, $currentPwd)) {
                return new JsonResponse(['success' => false, 'message' => 'Mot de passe actuel incorrect.']);
            }
        }

        if (!empty($name)) $user->setName($name);

        if (!empty($newPassword)) {
            if ($newPassword !== $confirm) {
                return new JsonResponse(['success' => false, 'message' => 'Les mots de passe ne correspondent pas.']);
            }
            if (strlen($newPassword) < 6) {
                return new JsonResponse(['success' => false, 'message' => 'Minimum 6 caractères.']);
            }
            $user->setPassword($passwordHasher->hashPassword($user, $newPassword));
        }

        // Optional photo upload
        $photo = $request->files->get('photo');
        if ($photo) {
            $uploadDir = $this->getParameter('kernel.project_dir') . '/public/uploads/profiles/';
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
            $old = $user->getProfilePicture();
            if ($old && !str_starts_with($old, 'http') && file_exists($uploadDir . $old)) unlink($uploadDir . $old);
            $filename = $slugger->slug(pathinfo($photo->getClientOriginalName(), PATHINFO_FILENAME)) . '-' . uniqid() . '.' . $photo->guessExtension();
            $photo->move($uploadDir, $filename);
            $user->setProfilePicture($filename);
        }

        $user->setUpdatedAt(new \DateTime());
        $userRepository->save($user, true);

        $pic    = $user->getProfilePicture();
        $picUrl = $pic ? (str_starts_with($pic, 'http') ? $pic : '/uploads/profiles/' . $pic) : null;

        return new JsonResponse([
            'success'  => true,
            'message'  => 'Profil mis à jour.',
            'name'     => $user->getName(),
            'photoUrl' => $picUrl,
        ]);
    }

// ════════════════════════════════════════════════════════════════════════════
// REPLACE the firstLogin() and firstLoginSave() methods in ProfileController
// Also replace the chooseAvatar() and removeAvatar() methods.
// The rest of ProfileController stays IDENTICAL.
// ════════════════════════════════════════════════════════════════════════════

    // ── First login page — now uses unified onboarding template ──────────────
    #[Route('/first-login', name: 'profile_first_login')]
    public function firstLogin(): Response
    {
        if (!$this->getUser()) return $this->redirectToRoute('app_login');
        if (!$this->getUser()->isFirstLogin()) return $this->redirectToUserHome();

        return $this->render('user/onboarding.html.twig', [
            // is_google is NOT set here — template will hide Google-specific blocks
        ]);
    }

    // ── Save first-login data ─────────────────────────────────────────────────
    #[Route('/first-login/save', name: 'profile_first_login_save', methods: ['POST'])]
    public function firstLoginSave(
        Request $request,
        UserRepository $userRepository,
        SluggerInterface $slugger
    ): Response {
        $user = $this->getUser();
        if (!$user) return $this->redirectToRoute('app_login');

        $avatarSource = $request->request->get('avatar_source', 'skip');

        if ($avatarSource === 'upload') {
            $pictureFile = $request->files->get('profile_picture');
            if ($pictureFile) {
                $safeFilename = $slugger->slug(pathinfo($pictureFile->getClientOriginalName(), PATHINFO_FILENAME));
                $newFilename  = $safeFilename . '-' . uniqid() . '.' . $pictureFile->guessExtension();
                $uploadDir    = __DIR__ . '/../../public/uploads/profiles/';
                if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
                $pictureFile->move($uploadDir, $newFilename);
                $user->setProfilePicture($newFilename);
            }
        } elseif ($avatarSource === 'dicebear') {
            $dicebearUrl = trim($request->request->get('avatar_dicebear_url', ''));
            if ($dicebearUrl && str_starts_with($dicebearUrl, 'https://api.dicebear.com/')) {
                $user->setProfilePicture($dicebearUrl);
            }
        }

        $user->setFirstLogin(false);
        $user->setUpdatedAt(new \DateTime());
        $userRepository->save($user, true);

        return $this->redirectToUserHome();
    }

    // ── Choose DiceBear avatar via AJAX (from profile show page) ─────────────
    #[Route('/avatar/choose', name: 'profile_avatar_choose', methods: ['POST'])]
    public function chooseAvatar(Request $request, UserRepository $userRepository): JsonResponse
    {
        $user = $this->getUser();
        if (!$user) return $this->json(['error' => 'Not authenticated'], 401);

        $style = $request->request->get('style', 'initials');
        $allowedStyles = ['initials','adventurer','bottts','pixel-art','fun-emoji','lorelei'];

        if (!in_array($style, $allowedStyles, true)) {
            return $this->json(['error' => 'Invalid style'], 400);
        }

        // Delete old LOCAL file if present
        $old = $user->getProfilePicture();
        if ($old && !str_starts_with($old, 'http')) {
            $uploadDir = __DIR__ . '/../../public/uploads/profiles/';
            if (file_exists($uploadDir . $old)) unlink($uploadDir . $old);
        }

        $avatarUrl = sprintf(
            'https://api.dicebear.com/9.x/%s/svg?seed=%s&backgroundColor=3e8e3e,2d6a2d',
            $style,
            urlencode($user->getName())
        );

        $user->setProfilePicture($avatarUrl);
        $user->setUpdatedAt(new \DateTime());
        $userRepository->save($user, true);

        return $this->json(['url' => $avatarUrl]);
    }

    // ── Remove avatar → back to DiceBear initials fallback ───────────────────
    #[Route('/avatar/remove', name: 'profile_avatar_remove', methods: ['POST'])]
    public function removeAvatar(Request $request, UserRepository $userRepository): Response
    {
        $user = $this->getUser();
        if (!$user) return $this->redirectToRoute('app_login');

        $old = $user->getProfilePicture();
        if ($old && !str_starts_with($old, 'http')) {
            $uploadDir = __DIR__ . '/../../public/uploads/profiles/';
            if (file_exists($uploadDir . $old)) unlink($uploadDir . $old);
        }

        $user->setProfilePicture(null); // will fall back to DiceBear initials in templates
        $user->setUpdatedAt(new \DateTime());
        $userRepository->save($user, true);

        $this->addFlash('success', 'Photo de profil supprimée.');
        return $this->redirectToRoute('profile_show');
    }

    // ── Other pages ──────────────────────────────────────────────────────────
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

    // ── Internal helper ──────────────────────────────────────────────────────
    private function redirectToUserHome(): Response
    {
        $roles = $this->getUser()->getRoles();

        if (in_array('ROLE_ADMIN', $roles))   return $this->redirectToRoute('admin_dashboard');
        if (in_array('ROLE_OWNER', $roles))   return $this->redirectToRoute('farm_dashboard');
        if (in_array('ROLE_GERANT', $roles))  return $this->redirectToRoute('gerant_home');
        if (in_array('ROLE_OUVRIER', $roles)) return $this->redirectToRoute('ouvrier_home');

        // ROLE_PENDING — go to farm browser to apply
        return $this->redirectToRoute('ouvrier_farms');
    }
}