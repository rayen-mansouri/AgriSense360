<?php

namespace App\Controller\admin;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/admin')]
#[IsGranted('ROLE_ADMIN')]
class AdminController extends AbstractController
{
    private const ALLOWED_ROLES = ['ROLE_ADMIN', 'ROLE_GERANT', 'ROLE_OUVRIER'];

    // ── Accueil admin ──────────────────────────────────────────
    #[Route('', name: 'admin_home')]
    #[Route('/accueil', name: 'admin_home_alt')]
    public function home(UserRepository $userRepository): Response
    {
        $users = $userRepository->findAll();
        $total  = count($users);
        $admins = count(array_filter($users, fn($u) => in_array('ROLE_ADMIN',   $u->getRoles())));
        $gerants = count(array_filter($users, fn($u) => in_array('ROLE_GERANT', $u->getRoles())));
        $ouvriers = count(array_filter($users, fn($u) => in_array('ROLE_OUVRIER',$u->getRoles())));
        $actifs = count(array_filter($users, fn($u) => $u->getStatus() === 'active'));

        return $this->render('admin/home.html.twig', [
            'total'    => $total,
            'admins'   => $admins,
            'gerants'  => $gerants,
            'ouvriers' => $ouvriers,
            'actifs'   => $actifs,
            'recent'   => array_slice(array_reverse($users), 0, 5),
        ]);
    }

    // ── Liste utilisateurs ─────────────────────────────────────
    #[Route('/utilisateurs', name: 'admin_dashboard')]
    public function users(UserRepository $userRepository): Response
    {
        return $this->render('admin/dashboard.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    // ── Ajouter un utilisateur ─────────────────────────────────
    #[Route('/utilisateurs/ajouter', name: 'admin_user_add', methods: ['GET', 'POST'])]
    public function add(
        Request $request,
        UserRepository $userRepository,
        UserPasswordHasherInterface $passwordHasher
    ): Response {
        $error = null;

        if ($request->isMethod('POST')) {
            $name     = trim($request->request->get('name', ''));
            $email    = trim($request->request->get('email', ''));
            $phone    = trim($request->request->get('phone', ''));
            $password = $request->request->get('password', '');
            $confirm  = $request->request->get('confirm_password', '');
            $role     = $request->request->get('role', 'ROLE_GERANT');
            $status   = $request->request->get('status', 'active');

            if (!in_array($role, self::ALLOWED_ROLES)) $role = 'ROLE_GERANT';

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
                $cvFile = $request->files->get('cv');

if ($role === 'ROLE_ADMIN') {

    $user->setRoles(['ROLE_ADMIN']);
    $user->setStatus('approved');

} else {

    if (!$cvFile) {
        $error = "CV obligatoire";
    } else {

        $result = $onboardingService->process($user, $cvFile);

        $user->setCvFile($result['filename']);
        $user->setAiSuggestedRole($result['role']);
        $user->setDecisionReason($result['reason']);

        $user->setRoles(['ROLE_PENDING']);

        if ($result['decision'] === 'reject') {
            $user->setStatus('rejected');
        } else {
            $user->setStatus('pending');
        }
    }
}
                $user->setAuthProvider('local');
                $user->setFirstLogin(true);
                $user->setPassword($passwordHasher->hashPassword($user, $password));
                $user->setCreatedAt(new \DateTime());
                $user->setUpdatedAt(new \DateTime());
                $userRepository->save($user, true);

                $this->addFlash('success', "Utilisateur « {$name} » créé avec succès !");
                return $this->redirectToRoute('admin_dashboard');
            }
        }

        return $this->render('admin/user_add.html.twig', ['error' => $error]);
    }

    // ── Voir un utilisateur ────────────────────────────────────
    #[Route('/utilisateurs/{id}', name: 'admin_user_show', methods: ['GET'])]
    public function show(User $user): Response
    {
        return $this->render('admin/user_show.html.twig', ['user' => $user]);
    }

    // ── Modifier un utilisateur ────────────────────────────────
    #[Route('/utilisateurs/{id}/modifier', name: 'admin_user_edit', methods: ['POST'])]
    public function edit(User $user, UserRepository $userRepository, Request $request): Response
    {
        $name   = trim($request->request->get('name', ''));
        $phone  = trim($request->request->get('phone', ''));
        $role   = $request->request->get('role', 'ROLE_GERANT');
        $status = $request->request->get('status', 'active');

        if (!in_array($role, self::ALLOWED_ROLES)) $role = 'ROLE_GERANT';
        if (!in_array($status, ['active', 'blocked'])) $status = 'active';

        if (!empty($name))  $user->setName($name);
        $user->setPhone($phone ?: null);
        $user->setRoles($role);
        $user->setStatus($status);
        $user->setUpdatedAt(new \DateTime());
        $userRepository->save($user, true);

        $this->addFlash('success', 'Utilisateur mis à jour avec succès.');
        return $this->redirectToRoute('admin_user_show', ['id' => $user->getId()]);
    }

    // ── Supprimer un utilisateur ───────────────────────────────
    #[Route('/utilisateurs/{id}/supprimer', name: 'admin_user_delete', methods: ['POST'])]
    public function delete(User $user, UserRepository $userRepository, Request $request): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $userRepository->remove($user, true);
            $this->addFlash('success', 'Utilisateur supprimé avec succès.');
        }
        return $this->redirectToRoute('admin_dashboard');
    }
}