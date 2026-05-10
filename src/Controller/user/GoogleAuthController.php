<?php

namespace App\Controller\user;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\String\Slugger\SluggerInterface;
class GoogleAuthController extends AbstractController
{
    public function __construct(
        private string $googleClientId,
        private string $googleClientSecret,
        private UserRepository $userRepository,
        private TokenStorageInterface $tokenStorage,
    ) {}

    // ── Step 1: Redirect to Google ────────────────────────────────────────────
    #[Route('/connect/google', name: 'connect_google')]
    public function connect(): RedirectResponse
    {
        $redirectUri = $this->generateUrl(
            'connect_google_check',
            [],
            UrlGeneratorInterface::ABSOLUTE_URL
        );

        $params = http_build_query([
            'client_id'     => $this->googleClientId,
            'redirect_uri'  => $redirectUri,
            'response_type' => 'code',
            'scope'         => 'openid email profile',
            'access_type'   => 'online',
            'prompt'        => 'select_account',
        ]);

        return $this->redirect('https://accounts.google.com/o/oauth2/v2/auth?' . $params);
    }

    // ── Step 2: Google redirects back here ───────────────────────────────────
    #[Route('/connect/google/check', name: 'connect_google_check')]
    public function check(Request $request): Response
    {
        if ($request->query->has('error')) {
            $this->addFlash('error', 'Connexion Google annulée.');
            return $this->redirectToRoute('app_login');
        }

        $code = $request->query->get('code');
        if (!$code) {
            $this->addFlash('error', 'Code Google manquant.');
            return $this->redirectToRoute('app_login');
        }

        $redirectUri = $this->generateUrl(
            'connect_google_check',
            [],
            UrlGeneratorInterface::ABSOLUTE_URL
        );

        // Exchange code → access_token
        $tokenResponse = $this->httpPost('https://oauth2.googleapis.com/token', [
            'code'          => $code,
            'client_id'     => $this->googleClientId,
            'client_secret' => $this->googleClientSecret,
            'redirect_uri'  => $redirectUri,
            'grant_type'    => 'authorization_code',
        ]);

        if (empty($tokenResponse['access_token'])) {
            $this->addFlash('error', 'Impossible d\'obtenir le token Google.');
            return $this->redirectToRoute('app_login');
        }

        // Fetch Google user info
        $googleUser = $this->httpGet(
            'https://www.googleapis.com/oauth2/v3/userinfo',
            $tokenResponse['access_token']
        );

        if (empty($googleUser['email'])) {
            $this->addFlash('error', 'Impossible de récupérer les données Google.');
            return $this->redirectToRoute('app_login');
        }

        // ── Does this user already exist in DB? ───────────────────────────────
        $existingUser = $this->userRepository->findOneBy(['email' => $googleUser['email']]);

        if ($existingUser) {
            // EXISTING USER → log in directly, no form needed
            if ($existingUser->getStatus() === 'blocked') {
                $this->addFlash('error', 'Votre compte est bloqué. Contactez un administrateur.');
                return $this->redirectToRoute('app_login');
            }

            // Update Google fields if missing
            if (!$existingUser->getGoogleId()) {
                $existingUser->setGoogleId($googleUser['sub'] ?? null);
                $existingUser->setAuthProvider('google');
            }
            if (!$existingUser->getProfilePicture() && !empty($googleUser['picture'])) {
                $existingUser->setProfilePicture($googleUser['picture']);
            }
            $existingUser->setUpdatedAt(new \DateTime());
            $this->userRepository->save($existingUser, true);

            $this->loginUser($existingUser, $request);
            return $this->redirectToUserHome($existingUser);

        } else {
            // NEW USER → store Google data in session → go to complete-profile page
            $request->getSession()->set('google_pending', [
                'email'   => $googleUser['email'],
                'name'    => $googleUser['name']    ?? '',
                'picture' => $googleUser['picture'] ?? '',
                'sub'     => $googleUser['sub']     ?? '',
            ]);

            return $this->redirectToRoute('google_complete_profile');
        }
    }

// ════════════════════════════════════════════════════════════════════════════
// REPLACE only completeProfile() and completeProfileSave() in GoogleAuthController
// The rest of the file stays IDENTICAL.
// ════════════════════════════════════════════════════════════════════════════

    // ── Step 3: Show unified onboarding form ─────────────────────────────────
    #[Route('/connect/google/complete', name: 'google_complete_profile')]
    public function completeProfile(Request $request): Response
    {
        $pending = $request->getSession()->get('google_pending');

        if (!$pending) {
            return $this->redirectToRoute('app_login');
        }
        if ($this->getUser()) {
            return $this->redirectToUserHome($this->getUser());
        }

        return $this->render('user/onboarding.html.twig', [
            'is_google'    => true,                  // tells template to show Google blocks
            'google_name'  => $pending['name'],
            'google_email' => $pending['email'],
            'google_pic'   => $pending['picture'],
        ]);
    }

    // ── Step 4: Save completed profile ───────────────────────────────────────
    #[Route('/connect/google/complete/save', name: 'google_complete_profile_save', methods: ['POST'])]
public function completeProfileSave(Request $request, SluggerInterface $slugger): Response    {
        $pending = $request->getSession()->get('google_pending');
        if (!$pending) return $this->redirectToRoute('app_login');

        // Edge case: already registered
        $existing = $this->userRepository->findOneBy(['email' => $pending['email']]);
        if ($existing) {
            $request->getSession()->remove('google_pending');
            $this->loginUser($existing, $request);
            return $this->redirectToUserHome($existing);
        }

        // Read form values
        $avatarSource = $request->request->get('avatar_source', 'skip');

        // New Google users are always workers (ROLE_PENDING)
        // They choose a farm and upload CV in the farm browser
        $role = 'ROLE_PENDING';

        // ── Determine profile picture ─────────────────────────────────────────
        $profilePicture = null;

        if ($avatarSource === 'upload') {
            // User uploaded a custom photo
            $pictureFile = $request->files->get('profile_picture');
            if ($pictureFile) {
                $safeFilename = $slugger->slug(pathinfo($pictureFile->getClientOriginalName(), PATHINFO_FILENAME));                $safeFilename = $slugger->slug(pathinfo($pictureFile->getClientOriginalName(), PATHINFO_FILENAME));
                $newFilename  = $safeFilename . '-' . uniqid() . '.' . $pictureFile->guessExtension();
                $uploadDir    = $this->getParameter('kernel.project_dir') . '/public/uploads/profiles/';
                if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
                $pictureFile->move($uploadDir, $newFilename);
                $profilePicture = $newFilename;
            } else {
                // Upload failed / empty — fall back to Google picture
                $profilePicture = $pending['picture'] ?: null;
            }

        } elseif ($avatarSource === 'dicebear') {
            $dicebearUrl = trim($request->request->get('avatar_dicebear_url', ''));
            if ($dicebearUrl && str_starts_with($dicebearUrl, 'https://api.dicebear.com/')) {
                $profilePicture = $dicebearUrl;
            }

        } elseif ($avatarSource === 'skip') {
            // Use Google profile picture if available, else null (DiceBear initials in templates)
            $profilePicture = $pending['picture'] ?: null;
        }

        // Create user
        $user = new User();
        $user->setEmail($pending['email']);
        $user->setName($pending['name'] ?: $pending['email']);
        $user->setPassword('GOOGLE_OAUTH_NO_PWD_' . uniqid());
        $user->setRoles([$role]);   // always an array
        $user->setStatus($role === 'ROLE_PENDING' ? 'pending' : 'active');
        $user->setAuthProvider('google');
        $user->setGoogleId($pending['sub']);
        $user->setProfilePicture($profilePicture);
        $user->setFirstLogin(false);  // Google users skip onboarding — profile already set
        $user->setCreatedAt(new \DateTime());
        $user->setUpdatedAt(new \DateTime());

        $this->userRepository->save($user, true);
        $request->getSession()->remove('google_pending');
        $this->loginUser($user, $request);

        $this->addFlash('success', 'Bienvenue sur AgriSense 360 ! Votre compte a été créé avec succès.');
        return $this->redirectToUserHome($user);
    }


    // ─────────────────────────────────────────────────────────────────────────
    // Private helpers
    // ─────────────────────────────────────────────────────────────────────────

    private function loginUser(User $user, Request $request): void
    {
        $token = new UsernamePasswordToken($user, 'main', $user->getRoles());
        $this->tokenStorage->setToken($token);
        $request->getSession()->set('_security_main', serialize($token));
    }

    private function redirectToUserHome(mixed $user): Response
    {
        $roles = $user->getRoles();
        if (in_array('ROLE_ADMIN',   $roles)) return $this->redirectToRoute('admin_dashboard');
        if (in_array('ROLE_OWNER',   $roles)) return $this->redirectToRoute('farm_dashboard');
        if (in_array('ROLE_GERANT',  $roles)) return $this->redirectToRoute('gerant_home');
        if (in_array('ROLE_OUVRIER', $roles)) return $this->redirectToRoute('ouvrier_home');
        // ROLE_PENDING → farm browser
        return $this->redirectToRoute('ouvrier_farms');
    }

    private function httpPost(string $url, array $data): array
    {
        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => http_build_query($data),
            CURLOPT_HTTPHEADER     => ['Content-Type: application/x-www-form-urlencoded'],
            CURLOPT_TIMEOUT        => 10,
            CURLOPT_SSL_VERIFYPEER => false, // local XAMPP — remove in production
        ]);
        $response = curl_exec($ch);
        curl_close($ch);
        return json_decode($response ?: '{}', true) ?? [];
    }

    private function httpGet(string $url, string $accessToken): array
    {
        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER     => ['Authorization: Bearer ' . $accessToken],
            CURLOPT_TIMEOUT        => 10,
            CURLOPT_SSL_VERIFYPEER => false, // local XAMPP — remove in production
        ]);
        $response = curl_exec($ch);
        curl_close($ch);
        return json_decode($response ?: '{}', true) ?? [];
    }
}