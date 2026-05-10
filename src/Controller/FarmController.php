<?php

namespace App\Controller;

use App\Entity\Farm;
use App\Repository\FarmRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/farm')]
#[IsGranted('ROLE_OWNER')]
class FarmController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $em,
        private FarmRepository $farmRepository,
        private UserRepository $userRepository,
    ) {}

    // ── Create / Setup ─────────────────────────────────────────────────────
    #[Route('/create', name: 'farm_create', methods: ['GET', 'POST'])]
    public function create(Request $request): Response
    {
        $error = null;

        if ($request->isMethod('POST')) {
            $name        = trim($request->request->get('name', ''));
            $location    = trim($request->request->get('location', ''));
            $surface     = $request->request->get('surface', '');
            $description = trim($request->request->get('description', ''));

            if (empty($name)) {
                $error = 'Le nom de la ferme est obligatoire.';
            } else {
                $owner = $this->getUser();
                $farm  = new Farm();
                $farm->setFarmId($this->generateFarmId());
                $farm->setName($name);
                $farm->setLocation($location ?: null);
                $farm->setSurface($surface !== '' ? (float) $surface : null);
                $farm->setDescription($description ?: null);
                $farm->setOwner($owner);
                $farm->setCreatedAt(new \DateTime());

                // Handle image upload
                $imageFile = $request->files->get('image');
                if ($imageFile) {
                    $uploadDir = $this->getParameter('kernel.project_dir') . '/public/uploads/farms/';
                    if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
                    $filename = 'farm_' . uniqid() . '.' . $imageFile->guessExtension();
                    $imageFile->move($uploadDir, $filename);
                    $farm->setImage($filename);
                }

                $this->em->persist($farm);
                $this->em->flush();

                $this->addFlash('success', "Ferme \"{$name}\" créée avec succès !");
                return $this->redirectToRoute('farm_dashboard');
            }
        }

        return $this->render('farm/setup.html.twig', ['error' => $error]);
    }

    // ── Edit Farm ──────────────────────────────────────────────────────────
    #[Route('/{id}/edit', name: 'farm_edit', methods: ['GET', 'POST'])]
    public function edit(int $id, Request $request): Response
    {
        $farm = $this->farmRepository->find($id);
        if (!$farm || $farm->getOwner()?->getId() !== $this->getUser()->getId()) {
            $this->addFlash('error', 'Ferme introuvable ou accès non autorisé.');
            return $this->redirectToRoute('farm_dashboard');
        }

        if ($request->isMethod('POST')) {
            $name        = trim($request->request->get('name', ''));
            $location    = trim($request->request->get('location', ''));
            $surface     = $request->request->get('surface', '');
            $description = trim($request->request->get('description', ''));

            if (!empty($name)) $farm->setName($name);
            $farm->setLocation($location ?: null);
            $farm->setSurface($surface !== '' ? (float) $surface : null);
            $farm->setDescription($description ?: null);

            $imageFile = $request->files->get('image');
            if ($imageFile) {
                $uploadDir = $this->getParameter('kernel.project_dir') . '/public/uploads/farms/';
                if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
                // Remove old image
                $old = $farm->getImage();
                if ($old && file_exists($uploadDir . $old)) unlink($uploadDir . $old);
                $filename = 'farm_' . uniqid() . '.' . $imageFile->guessExtension();
                $imageFile->move($uploadDir, $filename);
                $farm->setImage($filename);
            }

            $this->em->flush();
            $this->addFlash('success', "Ferme « {$farm->getName()} » mise à jour.");
            return $this->redirectToRoute('farm_dashboard');
        }

        return $this->render('farm/edit.html.twig', ['farm' => $farm]);
    }

    // ── Legacy /setup alias ─────────────────────────────────────────────────
    #[Route('/setup', name: 'farm_setup', methods: ['GET', 'POST'])]
    public function setup(Request $request): Response
    {
        return $this->forward('App\Controller\FarmController::create');
    }

    // ── Owner Dashboard ─────────────────────────────────────────────────────
    #[Route('/dashboard', name: 'farm_dashboard', methods: ['GET'])]
    public function dashboard(): Response
    {
        $owner = $this->getUser();
        $farms = $this->farmRepository->findBy(['owner' => $owner], ['createdAt' => 'DESC']);

        $farmData = [];
        foreach ($farms as $farm) {
            $farmData[] = [
                'farm'            => $farm,
                'pendingWorkers'  => $this->userRepository->findBy(['farm' => $farm, 'status' => 'pending']),
                'approvedWorkers' => $this->userRepository->findBy(['farm' => $farm, 'status' => 'active']),
            ];
        }

        return $this->render('farm/dashboard.html.twig', [
            'farmData' => $farmData,
            'owner'    => $owner,
        ]);
    }

    // ── Assign Role to Worker (approve) ────────────────────────────────────
    #[Route('/workers/{id}/assign', name: 'farm_worker_assign', methods: ['POST'])]
    public function assignRole(int $id, Request $request): Response
    {
        $worker = $this->userRepository->find($id);
        if (!$worker) {
            $this->addFlash('error', 'Travailleur introuvable.');
            return $this->redirectToRoute('farm_dashboard');
        }

        $workerFarm = $worker->getFarm();
        if (!$workerFarm || $workerFarm->getOwner()?->getId() !== $this->getUser()->getId()) {
            $this->addFlash('error', 'Action non autorisée.');
            return $this->redirectToRoute('farm_dashboard');
        }

        $role = $request->request->get('role', 'ROLE_OUVRIER');
        if (!in_array($role, ['ROLE_GERANT', 'ROLE_OUVRIER'])) {
            $role = 'ROLE_OUVRIER';
        }

        $label = $role === 'ROLE_GERANT' ? 'Gérant' : 'Ouvrier';

        $worker->setRoles([$role]);
        $worker->setStatus('active');
        $worker->setApprovedBy($this->getUser()->getId());
        $worker->setUpdatedAt(new \DateTime());

        // 🔔 Set a one-time notification for the worker
        $worker->setPendingNotification(
            "🎉 Félicitations ! Votre candidature à la ferme <strong>{$workerFarm->getName()}</strong> a été acceptée. Vous êtes maintenant <strong>{$label}</strong>."
        );

        $this->em->flush();

        $this->addFlash('success', "{$worker->getName()} a été assigné comme {$label}.");
        return $this->redirectToRoute('farm_dashboard');
    }

    // ── Reject Applicant ────────────────────────────────────────────────────
    #[Route('/workers/{id}/reject', name: 'farm_worker_reject', methods: ['POST'])]
    public function rejectWorker(int $id): Response
    {
        $worker = $this->userRepository->find($id);
        if (!$worker) {
            $this->addFlash('error', 'Travailleur introuvable.');
            return $this->redirectToRoute('farm_dashboard');
        }

        $workerFarm = $worker->getFarm();
        if (!$workerFarm || $workerFarm->getOwner()?->getId() !== $this->getUser()->getId()) {
            $this->addFlash('error', 'Action non autorisée.');
            return $this->redirectToRoute('farm_dashboard');
        }

        // 🔔 Notify the worker of rejection
        $worker->setPendingNotification(
            "❌ Votre candidature à la ferme <strong>{$workerFarm->getName()}</strong> a été refusée. Vous pouvez postuler à une autre ferme."
        );

        $worker->setFarm(null);
        $worker->setStatus('pending');
        $worker->setRoles(['ROLE_PENDING']);
        $worker->setUpdatedAt(new \DateTime());
        $this->em->flush();

        $this->addFlash('info', "Candidature de {$worker->getName()} refusée.");
        return $this->redirectToRoute('farm_dashboard');
    }

    // ── Remove Active Worker ────────────────────────────────────────────────
    #[Route('/workers/{id}/remove', name: 'farm_worker_remove', methods: ['POST'])]
    public function removeWorker(int $id): Response
    {
        $worker = $this->userRepository->find($id);
        if (!$worker) {
            $this->addFlash('error', 'Travailleur introuvable.');
            return $this->redirectToRoute('farm_dashboard');
        }

        $workerFarm = $worker->getFarm();
        if (!$workerFarm || $workerFarm->getOwner()?->getId() !== $this->getUser()->getId()) {
            $this->addFlash('error', 'Action non autorisée.');
            return $this->redirectToRoute('farm_dashboard');
        }

        $name = $worker->getName();
        $farmName = $workerFarm->getName();

        $worker->setPendingNotification(
            "ℹ️ Vous avez été retiré de la ferme <strong>{$farmName}</strong>. Vous pouvez postuler à une autre ferme."
        );
        $worker->setFarm(null);
        $worker->setRoles(['ROLE_PENDING']);
        $worker->setStatus('pending');
        $worker->setApprovedBy(null);
        $worker->setUpdatedAt(new \DateTime());
        $this->em->flush();

        $this->addFlash('info', "{$name} a été retiré de la ferme.");
        return $this->redirectToRoute('farm_dashboard');
    }

    // ── Generate unique FARM-XXXXXX ID ─────────────────────────────────────
    private function generateFarmId(): string
    {
        do {
            $id = 'FARM-' . strtoupper(substr(md5(uniqid('', true)), 0, 6));
        } while ($this->farmRepository->findOneBy(['farmId' => $id]));
        return $id;
    }
}
