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

    public function __construct(
        private \App\Repository\UserRepository $userRepository,
        private \App\Service\ParcelleService $parcelleService,
        private \App\Service\CultureService  $cultureService,
        private \Doctrine\ORM\EntityManagerInterface $em
    ) {}

    // ── Accueil admin ──────────────────────────────────────────
    #[Route('', name: 'admin_home')]
    #[Route('/accueil', name: 'admin_home_alt')]
    public function home(): Response
    {
        $users = $this->userRepository->findAll();
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
    public function users(): Response
    {
        return $this->render('admin/dashboard.html.twig', [
            'users' => $this->userRepository->findAll(),
        ]);
    }

    // ── Dashboard Culture (Admin) ──────────────────────────────
    #[Route('/culture-dashboard', name: 'admin_culture_dashboard')]
    public function cultureDashboard(): Response
    {
        $this->cultureService->refreshAllEtats();

        $parcelles = $this->parcelleService->getAllParcelles();
        $cultures  = $this->cultureService->getAllCultures();

        $surfaceTotal   = $this->parcelleService->getTotalSurface();
        $surfaceOccupee = 0;
        foreach ($cultures as $c) $surfaceOccupee += $c->getSurface();

        $tauxOccupation = $surfaceTotal > 0 ? round(($surfaceOccupee / $surfaceTotal) * 100, 1) : 0;

        $stats = $this->cultureService->getStats();

        // Top parcelles (by occupancy rate)
        $topParcellesData = [];
        foreach ($parcelles as $p) {
            $topParcellesData[] = [
                'nom'            => $p->getNom(),
                'statut'         => $p->getStatut(),
                'cultures'       => $p->getCultures()->count(),
                'surface'        => $p->getSurface(),
                'surfaceRestant' => $p->getSurfaceRestant(),
                'taux'           => $p->getTauxOccupation(),
            ];
        }
        usort($topParcellesData, fn($a, $b) => $b['taux'] <=> $a['taux']);
        $topParcelles = array_slice($topParcellesData, 0, 6);

        // Cultures à récolter
        $culturesRecolte = array_filter($cultures, fn($c) => 
            in_array($c->getEtat(), ['Récolte Prévue', 'Récolte en Retard', 'Maturité'])
        );

        // Récoltes IA (last 12)
        $recentRecoltes = $this->em->getRepository(\App\Entity\ParcelleHistorique::class)
            ->createQueryBuilder('h')
            ->where('h.typeAction = :type')
            ->setParameter('type', 'RECOLTE')
            ->orderBy('h.dateAction', 'DESC')
            ->setMaxResults(12)
            ->getQuery()
            ->getResult();

        $totalKgRecolte = 0;
        foreach ($recentRecoltes as $r) $totalKgRecolte += $r->getQuantiteRecolte() ?? 0;

        $parcelleMap = [];
        foreach ($parcelles as $p) $parcelleMap[$p->getId()] = $p->getNom();

        // Chart data
        $etatCounts = [];
        foreach ($cultures as $c) {
            $e = $c->getEtat();
            $etatCounts[$e] = ($etatCounts[$e] ?? 0) + 1;
        }
        $typeCounts = [];
        foreach ($cultures as $c) {
            $t = $c->getTypeCulture();
            $typeCounts[$t] = ($typeCounts[$t] ?? 0) + 1;
        }

        return $this->render('home/index.html.twig', [
            'activePage'      => 'cultures_admin',
            'totalParcelles'  => count($parcelles),
            'totalCultures'   => count($cultures),
            'surfaceTotal'    => $surfaceTotal,
            'tauxOccupation'  => $tauxOccupation,
            'culturesPretes'  => $stats['pretes'],
            'culturesRetard'  => $stats['retard'],
            'totalRecoltes'   => count($recentRecoltes),
            'totalKgRecolte'  => $totalKgRecolte,
            'topParcelles'    => $topParcelles,
            'culturesRecolte' => $culturesRecolte,
            'recentRecoltes'  => $recentRecoltes,
            'parcelleMap'     => $parcelleMap,
            'etatCounts'      => $etatCounts,
            'typeCounts'      => $typeCounts,
            'surfaceUtilisee' => $surfaceOccupee,
            'surfaceRestante' => max(0, $surfaceTotal - $surfaceOccupee),
        ]);
    }

    // ── Ajouter un utilisateur ─────────────────────────────────
    #[Route('/utilisateurs/ajouter', name: 'admin_user_add', methods: ['GET', 'POST'])]
    public function add(
        Request $request,
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
                $userRepository = $this->userRepository;
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
    public function edit(User $user, Request $request): Response
    {
        $userRepository = $this->userRepository;
        $name   = trim($request->request->get('name', ''));
        $phone  = trim($request->request->get('phone', ''));
        $role   = $request->request->get('role', 'ROLE_GERANT');
        $status = $request->request->get('status', 'active');

        if (!in_array($role, self::ALLOWED_ROLES)) $role = 'ROLE_GERANT';
        if (!in_array($status, ['active', 'blocked'])) $status = 'active';

        if (!empty($name))  $user->setName($name);
        $user->setPhone($phone ?: null);
        $user->setRoles([$role]);
        $user->setStatus($status);
        $user->setUpdatedAt(new \DateTime());
        $userRepository->save($user, true);

        $this->addFlash('success', 'Utilisateur mis à jour avec succès.');
        return $this->redirectToRoute('admin_user_show', ['id' => $user->getId()]);
    }

    // ── Supprimer un utilisateur ───────────────────────────────
    #[Route('/utilisateurs/{id}/supprimer', name: 'admin_user_delete', methods: ['POST'])]
    public function delete(User $user, Request $request): Response
    {
        $userRepository = $this->userRepository;
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $userRepository->remove($user, true);
            $this->addFlash('success', 'Utilisateur supprimé avec succès.');
        }
        return $this->redirectToRoute('admin_dashboard');
    }
}