<?php

namespace App\Controller;

use App\Service\OracleSqlPlusCrudService;
use App\Service\PdoCrudService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class ManagementController extends AbstractController
{
    #[Route('/management/animals', name: 'management_animals')]
    public function animals(): Response
    {
        return $this->render('management/animals.html.twig', [
            'active' => 'animals',
        ]);
    }

    #[Route('/admin/management/animals', name: 'admin_management_animals')]
    public function adminAnimals(): Response
    {
        return $this->render('management/animals.html.twig', [
            'active' => 'animals',
            'adminMode' => true,
        ]);
    }

    #[Route('/management/equipments', name: 'management_equipments')]
    public function equipments(Request $request, PdoCrudService $crudService): Response
    {
        $currentUserId = (int) $request->getSession()->get('auth_user_id', 0);
        if ($currentUserId <= 0) {
            return $this->redirectToRoute('auth_login', ['mode' => 'user']);
        }

        $equipment = [
            'name' => null,
            'type' => null,
            'status' => 'Ready',
            'purchaseDate' => null,
        ];
        $maintenance = [
            'equipment' => null,
            'maintenanceDate' => null,
            'maintenanceType' => null,
            'cost' => null,
        ];

        if ($request->isMethod('POST')) {
            $formType = (string) $request->request->get('form_type', 'equipment');

            try {
                if ($formType === 'maintenance') {
                    $crudService->createMaintenance($this->maintenanceDataFromRequest($request), $currentUserId);
                } else {
                    $crudService->createEquipment($this->equipmentDataFromRequest($request), $currentUserId);
                }
            } catch (\Throwable $e) {
                $this->addFlash('error', 'Unable to save data: ' . $e->getMessage());
            }

            return $this->redirectToRoute('management_equipments');
        }

        $equipments = $crudService->listEquipments($currentUserId);
        $maintenances = $crudService->listMaintenances($currentUserId);

        return $this->render('management/equipments.html.twig', [
            'active' => 'equipments',
            'equipments' => $equipments,
            'equipment' => $equipment,
            'editing' => false,
            'maintenances' => $maintenances,
            'maintenance' => $maintenance,
            'maintenanceEditing' => false,
        ]);
    }

    #[Route('/management/equipments/{id}/edit', name: 'management_equipments_edit', methods: ['GET', 'POST'])]
    public function editEquipment(int $id, Request $request, PdoCrudService $crudService): Response
    {
        $currentUserId = (int) $request->getSession()->get('auth_user_id', 0);
        if ($currentUserId <= 0) {
            return $this->redirectToRoute('auth_login', ['mode' => 'user']);
        }

        $equipment = $crudService->findEquipment($id, $currentUserId);

        if (!$equipment) {
            throw $this->createNotFoundException('Equipment not found.');
        }

        if ($request->isMethod('POST')) {
            try {
                $crudService->updateEquipment($id, $this->equipmentDataFromRequest($request), $currentUserId);
            } catch (\Throwable $e) {
                $this->addFlash('error', 'Unable to update equipment: ' . $e->getMessage());
            }

            return $this->redirectToRoute('management_equipments');
        }

        $equipments = $crudService->listEquipments($currentUserId);
        $maintenance = [
            'equipment' => null,
            'maintenanceDate' => null,
            'maintenanceType' => null,
            'cost' => null,
        ];
        $maintenances = $crudService->listMaintenances($currentUserId);

        return $this->render('management/equipments.html.twig', [
            'active' => 'equipments',
            'equipments' => $equipments,
            'equipment' => $equipment,
            'editing' => true,
            'maintenances' => $maintenances,
            'maintenance' => $maintenance,
            'maintenanceEditing' => false,
        ]);
    }

    #[Route('/management/equipments/{id}/delete', name: 'management_equipments_delete', methods: ['POST'])]
    public function deleteEquipment(int $id, Request $request, PdoCrudService $crudService): Response
    {
        $currentUserId = (int) $request->getSession()->get('auth_user_id', 0);
        if ($currentUserId <= 0) {
            return $this->redirectToRoute('auth_login', ['mode' => 'user']);
        }

        if (!$this->isCsrfTokenValid('delete_equipment_' . $id, (string) $request->request->get('_token'))) {
            throw $this->createAccessDeniedException('Invalid CSRF token.');
        }

        try {
            $crudService->deleteEquipment($id, $currentUserId);
        } catch (\Throwable $e) {
            $this->addFlash('error', 'Unable to delete equipment: ' . $e->getMessage());
        }

        return $this->redirectToRoute('management_equipments');
    }

    #[Route('/management/equipments/maintenance/{id}/edit', name: 'management_maintenance_edit', methods: ['GET', 'POST'])]
    public function editMaintenance(int $id, Request $request, PdoCrudService $crudService): Response
    {
        $currentUserId = (int) $request->getSession()->get('auth_user_id', 0);
        if ($currentUserId <= 0) {
            return $this->redirectToRoute('auth_login', ['mode' => 'user']);
        }

        $maintenance = $crudService->findMaintenance($id, $currentUserId);

        if (!$maintenance) {
            throw $this->createNotFoundException('Maintenance not found.');
        }

        if ($request->isMethod('POST')) {
            try {
                $crudService->updateMaintenance($id, $this->maintenanceDataFromRequest($request), $currentUserId);
            } catch (\Throwable $e) {
                $this->addFlash('error', 'Unable to update maintenance: ' . $e->getMessage());
            }

            return $this->redirectToRoute('management_equipments');
        }

        $equipments = $crudService->listEquipments($currentUserId);
        $maintenances = $crudService->listMaintenances($currentUserId);
        $equipment = [
            'name' => null,
            'type' => null,
            'status' => 'Ready',
            'purchaseDate' => null,
        ];

        return $this->render('management/equipments.html.twig', [
            'active' => 'equipments',
            'equipments' => $equipments,
            'equipment' => $equipment,
            'editing' => false,
            'maintenances' => $maintenances,
            'maintenance' => $maintenance,
            'maintenanceEditing' => true,
        ]);
    }

    #[Route('/management/equipments/maintenance/{id}/delete', name: 'management_maintenance_delete', methods: ['POST'])]
    public function deleteMaintenance(int $id, Request $request, PdoCrudService $crudService): Response
    {
        $currentUserId = (int) $request->getSession()->get('auth_user_id', 0);
        if ($currentUserId <= 0) {
            return $this->redirectToRoute('auth_login', ['mode' => 'user']);
        }

        if (!$this->isCsrfTokenValid('delete_maintenance_' . $id, (string) $request->request->get('_token'))) {
            throw $this->createAccessDeniedException('Invalid CSRF token.');
        }

        try {
            $crudService->deleteMaintenance($id, $currentUserId);
        } catch (\Throwable $e) {
            $this->addFlash('error', 'Unable to delete maintenance: ' . $e->getMessage());
        }

        return $this->redirectToRoute('management_equipments');
    }

    #[Route('/admin/management/equipments', name: 'admin_management_equipments')]
    public function adminEquipments(Request $request, PdoCrudService $crudService): Response
    {
        $currentAdminId = (int) $request->getSession()->get('auth_user_id', 0);
        if ($currentAdminId <= 0) {
            return $this->redirectToRoute('auth_login', ['mode' => 'admin']);
        }

        $allUsers = $crudService->listUsers();
        $selectedUserId = (int) $request->query->get('user_id', 0);
        if ($selectedUserId <= 0 && $allUsers !== []) {
            $selectedUserId = (int) ($allUsers[0]['id'] ?? $currentAdminId);
            foreach ($allUsers as $userRow) {
                if (!$this->isAdminRole((string) ($userRow['roleName'] ?? ''))) {
                    $selectedUserId = (int) ($userRow['id'] ?? $selectedUserId);
                    break;
                }
            }
        }

        $equipment = [
            'name' => null,
            'type' => null,
            'status' => 'Ready',
            'purchaseDate' => null,
        ];
        $maintenance = [
            'equipment' => null,
            'maintenanceDate' => null,
            'maintenanceType' => null,
            'cost' => null,
        ];

        if ($request->isMethod('POST')) {
            $postedTargetUserId = (int) $request->request->get('target_user_id', $selectedUserId);
            if ($postedTargetUserId > 0) {
                $selectedUserId = $postedTargetUserId;
            }

            $formType = (string) $request->request->get('form_type', 'equipment');

            try {
                if ($formType === 'maintenance') {
                    $crudService->createMaintenance($this->maintenanceDataFromRequest($request), $selectedUserId);
                } else {
                    $crudService->createEquipment($this->equipmentDataFromRequest($request), $selectedUserId);
                }
            } catch (\Throwable $e) {
                $this->addFlash('error', 'Unable to save data: ' . $e->getMessage());
            }

            return $this->redirectToRoute('admin_management_equipments', ['user_id' => $selectedUserId]);
        }

        $equipments = $crudService->listEquipments($selectedUserId);
        $maintenances = $crudService->listMaintenances($selectedUserId);

        return $this->renderAdminEquipmentsTemplate(
            $equipments,
            $maintenances,
            $equipment,
            false,
            $maintenance,
            false,
            $allUsers,
            $selectedUserId
        );
    }

    #[Route('/admin/management/equipments/{id}/edit', name: 'admin_management_equipments_edit', methods: ['GET', 'POST'])]
    public function adminEditEquipment(int $id, Request $request, PdoCrudService $crudService): Response
    {
        $selectedUserId = (int) $request->query->get('user_id', 0);
        if ($selectedUserId <= 0) {
            return $this->redirectToRoute('admin_management_equipments');
        }

        $equipment = $crudService->findEquipment($id, $selectedUserId);

        if (!$equipment) {
            throw $this->createNotFoundException('Equipment not found.');
        }

        if ($request->isMethod('POST')) {
            try {
                $crudService->updateEquipment($id, $this->equipmentDataFromRequest($request), $selectedUserId);
            } catch (\Throwable $e) {
                $this->addFlash('error', 'Unable to update equipment: ' . $e->getMessage());
            }

            return $this->redirectToRoute('admin_management_equipments', ['user_id' => $selectedUserId]);
        }

        $equipments = $crudService->listEquipments($selectedUserId);
        $maintenances = $crudService->listMaintenances($selectedUserId);
        $allUsers = $crudService->listUsers();
        $maintenance = [
            'equipment' => null,
            'maintenanceDate' => null,
            'maintenanceType' => null,
            'cost' => null,
        ];

        return $this->renderAdminEquipmentsTemplate(
            $equipments,
            $maintenances,
            $equipment,
            true,
            $maintenance,
            false,
            $allUsers,
            $selectedUserId
        );
    }

    #[Route('/admin/management/equipments/{id}/delete', name: 'admin_management_equipments_delete', methods: ['POST'])]
    public function adminDeleteEquipment(int $id, Request $request, PdoCrudService $crudService): Response
    {
        $selectedUserId = (int) $request->query->get('user_id', 0);
        if ($selectedUserId <= 0) {
            return $this->redirectToRoute('admin_management_equipments');
        }

        if (!$this->isCsrfTokenValid('delete_equipment_' . $id, (string) $request->request->get('_token'))) {
            throw $this->createAccessDeniedException('Invalid CSRF token.');
        }

        try {
            $crudService->deleteEquipment($id, $selectedUserId);
        } catch (\Throwable $e) {
            $this->addFlash('error', 'Unable to delete equipment: ' . $e->getMessage());
        }

        return $this->redirectToRoute('admin_management_equipments', ['user_id' => $selectedUserId]);
    }

    #[Route('/admin/management/equipments/maintenance/{id}/edit', name: 'admin_management_maintenance_edit', methods: ['GET', 'POST'])]
    public function adminEditMaintenance(int $id, Request $request, PdoCrudService $crudService): Response
    {
        $selectedUserId = (int) $request->query->get('user_id', 0);
        if ($selectedUserId <= 0) {
            return $this->redirectToRoute('admin_management_equipments');
        }

        $maintenance = $crudService->findMaintenance($id, $selectedUserId);

        if (!$maintenance) {
            throw $this->createNotFoundException('Maintenance not found.');
        }

        if ($request->isMethod('POST')) {
            try {
                $crudService->updateMaintenance($id, $this->maintenanceDataFromRequest($request), $selectedUserId);
            } catch (\Throwable $e) {
                $this->addFlash('error', 'Unable to update maintenance: ' . $e->getMessage());
            }

            return $this->redirectToRoute('admin_management_equipments', ['user_id' => $selectedUserId]);
        }

        $equipments = $crudService->listEquipments($selectedUserId);
        $maintenances = $crudService->listMaintenances($selectedUserId);
        $allUsers = $crudService->listUsers();
        $equipment = [
            'name' => null,
            'type' => null,
            'status' => 'Ready',
            'purchaseDate' => null,
        ];

        return $this->renderAdminEquipmentsTemplate(
            $equipments,
            $maintenances,
            $equipment,
            false,
            $maintenance,
            true,
            $allUsers,
            $selectedUserId
        );
    }

    #[Route('/admin/management/equipments/maintenance/{id}/delete', name: 'admin_management_maintenance_delete', methods: ['POST'])]
    public function adminDeleteMaintenance(int $id, Request $request, PdoCrudService $crudService): Response
    {
        $selectedUserId = (int) $request->query->get('user_id', 0);
        if ($selectedUserId <= 0) {
            return $this->redirectToRoute('admin_management_equipments');
        }

        if (!$this->isCsrfTokenValid('delete_maintenance_' . $id, (string) $request->request->get('_token'))) {
            throw $this->createAccessDeniedException('Invalid CSRF token.');
        }

        try {
            $crudService->deleteMaintenance($id, $selectedUserId);
        } catch (\Throwable $e) {
            $this->addFlash('error', 'Unable to delete maintenance: ' . $e->getMessage());
        }

        return $this->redirectToRoute('admin_management_equipments', ['user_id' => $selectedUserId]);
    }

    #[Route('/management/stock', name: 'management_stock')]
    public function stock(): Response
    {
        return $this->render('management/stock.html.twig', [
            'active' => 'stock',
        ]);
    }

    #[Route('/admin/management/stock', name: 'admin_management_stock')]
    public function adminStock(): Response
    {
        return $this->render('management/stock.html.twig', [
            'active' => 'stock',
            'adminMode' => true,
        ]);
    }

    #[Route('/management/culture', name: 'management_culture')]
    public function culture(): Response
    {
        return $this->render('management/culture.html.twig', [
            'active' => 'culture',
        ]);
    }

    #[Route('/admin/management/culture', name: 'admin_management_culture')]
    public function adminCulture(): Response
    {
        return $this->render('management/culture.html.twig', [
            'active' => 'culture',
            'adminMode' => true,
        ]);
    }

    #[Route('/management/users', name: 'management_users', methods: ['GET', 'POST'])]
    public function users(Request $request, PdoCrudService $crudService): Response
    {
        $session = $request->getSession();
        $currentUserId = (int) $session->get('auth_user_id', 0);

        if ($currentUserId <= 0) {
            return $this->redirectToRoute('auth_login', ['mode' => 'user']);
        }

        try {
            $currentUser = $crudService->findUser($currentUserId);
        } catch (\Throwable $e) {
            $this->addFlash('error', 'Unable to load profile: ' . $e->getMessage());
            $currentUser = null;
        }

        if (!$currentUser) {
            return $this->redirectToRoute('auth_logout');
        }

        if ($request->isMethod('POST')) {
            try {
                $payload = [
                    'lastName' => trim((string) $request->request->get('last_name')),
                    'firstName' => trim((string) $request->request->get('first_name')),
                    'email' => trim((string) $request->request->get('email')),
                    'passwordHash' => null,
                    'status' => (string) ($currentUser['status'] ?? 'Active'),
                    'roleName' => (string) ($currentUser['roleName'] ?? 'USER'),
                ];

                $newPassword = trim((string) $request->request->get('password'));
                if ($newPassword !== '') {
                    $payload['passwordHash'] = password_hash($newPassword, PASSWORD_BCRYPT);
                }

                $crudService->updateUser($currentUserId, $payload);
                $this->addFlash('success', 'Profile updated.');
            } catch (\Throwable $e) {
                $this->addFlash('error', 'Unable to update profile: ' . $e->getMessage());
            }

            return $this->redirectToRoute('management_users');
        }

        return $this->render('management/users.html.twig', [
            'active' => 'users',
            'currentUser' => $currentUser,
        ]);
    }

    #[Route('/admin/management/users', name: 'admin_management_users', methods: ['GET', 'POST'])]
    public function adminUsers(Request $request, PdoCrudService $crudService): Response
    {
        $session = $request->getSession();
        $currentUserId = (int) $session->get('auth_user_id', 0);

        if ($currentUserId <= 0) {
            return $this->redirectToRoute('auth_login', ['mode' => 'admin']);
        }

        if ($request->isMethod('POST')) {
            $action = (string) $request->request->get('user_action', 'create');
            try {
                if ($action === 'delete') {
                    $id = (int) $request->request->get('id');
                    if ($id > 0 && $id !== $currentUserId) {
                        $crudService->deleteUser($id);
                        $this->addFlash('success', 'User deleted.');
                    }
                } else {
                    $id = (int) $request->request->get('id');
                    $payload = [
                        'lastName' => trim((string) $request->request->get('last_name')),
                        'firstName' => trim((string) $request->request->get('first_name')),
                        'email' => trim((string) $request->request->get('email')),
                        'passwordHash' => null,
                        'status' => trim((string) $request->request->get('status')) ?: 'Active',
                        'roleName' => trim((string) $request->request->get('role_name')) ?: 'USER',
                    ];

                    $password = trim((string) $request->request->get('password'));
                    if ($password !== '') {
                        $payload['passwordHash'] = password_hash($password, PASSWORD_BCRYPT);
                    }

                    if ($action === 'update' && $id > 0) {
                        $crudService->updateUser($id, $payload);
                        $this->addFlash('success', 'User updated.');
                    }

                    if ($action === 'create') {
                        if (($payload['passwordHash'] ?? null) === null) {
                            $payload['passwordHash'] = password_hash('changeme123', PASSWORD_BCRYPT);
                        }

                        $crudService->createUser($payload);
                        $this->addFlash('success', 'User created.');
                    }
                }
            } catch (\Throwable $e) {
                $this->addFlash('error', 'User operation failed: ' . $e->getMessage());
            }

            return $this->redirectToRoute('admin_management_users');
        }

        try {
            $users = $crudService->listUsers();
        } catch (\Throwable $e) {
            $this->addFlash('error', 'Unable to load users: ' . $e->getMessage());
            $users = [];
        }

        $currentUser = null;
        $adminCount = 0;
        $activeCount = 0;
        $pendingCount = 0;
        $suspendedCount = 0;
        foreach ($users as $user) {
            $isAdmin = $this->isAdminRole((string) ($user['roleName'] ?? ''));
            $status = strtolower((string) ($user['status'] ?? ''));

            if ((int) ($user['id'] ?? 0) === $currentUserId) {
                $currentUser = $user;
            }

            if ($isAdmin) {
                $adminCount++;
            }

            if ($status === 'active') {
                $activeCount++;
            } elseif ($status === 'pending') {
                $pendingCount++;
            } elseif ($status === 'suspended') {
                $suspendedCount++;
            }
        }

        return $this->render('management/users.html.twig', [
            'active' => 'users',
            'adminMode' => true,
            'currentUser' => $currentUser,
            'users' => $users,
            'userStats' => [
                'total' => count($users),
                'admins' => $adminCount,
                'normal' => max(count($users) - $adminCount, 0),
                'active' => $activeCount,
                'pending' => $pendingCount,
                'suspended' => $suspendedCount,
            ],
        ]);
    }

    #[Route('/management/workers', name: 'management_workers', methods: ['GET', 'POST'])]
    public function workers(Request $request, PdoCrudService $crudService): Response
    {
        $currentUserId = (int) $request->getSession()->get('auth_user_id', 0);
        if ($currentUserId <= 0) {
            return $this->redirectToRoute('auth_login', ['mode' => 'user']);
        }

        $affectation = [
            'typeTravail' => null,
            'dateDebut' => null,
            'dateFin' => null,
            'zoneTravail' => null,
            'statut' => 'En attente',
        ];
        $evaluation = [
            'affectationId' => null,
            'note' => null,
            'qualite' => null,
            'commentaire' => null,
            'dateEvaluation' => null,
        ];

        if ($request->isMethod('POST')) {
            $formType = (string) $request->request->get('form_type', 'affectation');

            try {
                // Server-side validation: Verify CSRF token
                $tokenName = $formType === 'evaluation' ? 'create_evaluation' : 'create_affectation';
                if (!$this->isCsrfTokenValid($tokenName, (string) $request->request->get('_token'))) {
                    throw new \InvalidArgumentException('Invalid CSRF token.');
                }

                if ($formType === 'evaluation') {
                    // Server-side validation: Validate evaluation data
                    $evaluationData = $this->evaluationDataFromRequest($request);
                    $this->validateEvaluationData($evaluationData);
                    $crudService->createEvaluation($evaluationData);
                } else {
                    // Server-side validation: Validate affectation data
                    $affectationData = $this->affectationDataFromRequest($request);
                    $this->validateAffectationData($affectationData);
                    $crudService->createAffectation($affectationData);
                }
                $this->addFlash('success', 'Entry created successfully.');
            } catch (\InvalidArgumentException $e) {
                $this->addFlash('error', 'Validation error: ' . $e->getMessage());
            } catch (\Throwable $e) {
                $this->addFlash('error', 'Unable to save data: ' . $e->getMessage());
            }

            return $this->redirectToRoute('management_workers');
        }

        $affectations = $crudService->listAffectations();
        $evaluations = $crudService->listEvaluations();

        return $this->render('management/workers.html.twig', [
            'active' => 'workers',
            'adminMode' => false,
            'affectations' => $affectations,
            'affectation' => $affectation,
            'affectationEditing' => false,
            'evaluations' => $evaluations,
            'evaluation' => $evaluation,
            'evaluationEditing' => false,
        ]);
    }

    #[Route('/management/workers/{id}/edit', name: 'management_workers_edit', methods: ['GET', 'POST'])]
    public function editWorker(int $id, Request $request, PdoCrudService $crudService): Response
    {
        $currentUserId = (int) $request->getSession()->get('auth_user_id', 0);
        if ($currentUserId <= 0) {
            return $this->redirectToRoute('auth_login', ['mode' => 'user']);
        }

        // Server-side validation: Verify record exists and is accessible
        try {
            $this->validateAffectationAccess($id, $currentUserId, $crudService);
        } catch (\InvalidArgumentException | \RuntimeException $e) {
            $this->addFlash('error', 'Unable to access affectation: ' . $e->getMessage());
            return $this->redirectToRoute('management_workers');
        }

        $affectation = $crudService->findAffectation($id);
        if (!$affectation) {
            throw $this->createNotFoundException('Affectation not found.');
        }

        if ($request->isMethod('POST')) {
            try {
                // Server-side validation: Verify CSRF token
                if (!$this->isCsrfTokenValid('edit_affectation_' . $id, (string) $request->request->get('_token'))) {
                    throw new \InvalidArgumentException('Invalid CSRF token.');
                }

                // Server-side validation: Validate affectation data
                $affectationData = $this->affectationDataFromRequest($request);
                $this->validateAffectationData($affectationData);

                $crudService->updateAffectation($id, $affectationData);
                $this->addFlash('success', 'Affectation updated successfully.');
            } catch (\InvalidArgumentException $e) {
                $this->addFlash('error', 'Validation error: ' . $e->getMessage());
            } catch (\Throwable $e) {
                $this->addFlash('error', 'Unable to update affectation: ' . $e->getMessage());
            }

            return $this->redirectToRoute('management_workers');
        }

        $affectations = $crudService->listAffectations();
        $evaluation = [
            'affectationId' => null,
            'note' => null,
            'qualite' => null,
            'commentaire' => null,
            'dateEvaluation' => null,
        ];
        $evaluations = $crudService->listEvaluations();

        return $this->render('management/workers.html.twig', [
            'active' => 'workers',
            'adminMode' => false,
            'affectations' => $affectations,
            'affectation' => $affectation,
            'affectationEditing' => true,
            'evaluations' => $evaluations,
            'evaluation' => $evaluation,
            'evaluationEditing' => false,
        ]);
    }

    #[Route('/management/workers/{id}/delete', name: 'management_workers_delete', methods: ['POST'])]
    public function deleteWorker(int $id, Request $request, PdoCrudService $crudService): Response
    {
        $currentUserId = (int) $request->getSession()->get('auth_user_id', 0);
        if ($currentUserId <= 0) {
            return $this->redirectToRoute('auth_login', ['mode' => 'user']);
        }

        // Server-side validation: Verify CSRF token
        if (!$this->isCsrfTokenValid('delete_affectation_' . $id, (string) $request->request->get('_token'))) {
            throw $this->createAccessDeniedException('Invalid CSRF token.');
        }

        // Server-side validation: Verify record exists and is accessible
        try {
            $this->validateAffectationAccess($id, $currentUserId, $crudService);
        } catch (\InvalidArgumentException | \RuntimeException $e) {
            $this->addFlash('error', 'Unable to delete affectation: ' . $e->getMessage());
            return $this->redirectToRoute('management_workers');
        }

        try {
            $crudService->deleteAffectation($id);
            $this->addFlash('success', 'Affectation deleted successfully.');
        } catch (\Throwable $e) {
            $this->addFlash('error', 'Unable to delete affectation: ' . $e->getMessage());
        }

        return $this->redirectToRoute('management_workers');
    }

    #[Route('/management/workers/evaluation/{id}/edit', name: 'management_evaluation_edit', methods: ['GET', 'POST'])]
    public function editEvaluation(int $id, Request $request, PdoCrudService $crudService): Response
    {
        $currentUserId = (int) $request->getSession()->get('auth_user_id', 0);
        if ($currentUserId <= 0) {
            return $this->redirectToRoute('auth_login', ['mode' => 'user']);
        }

        // Server-side validation: Verify record exists and is accessible
        try {
            $this->validateEvaluationAccess($id, $currentUserId, $crudService);
        } catch (\InvalidArgumentException | \RuntimeException $e) {
            $this->addFlash('error', 'Unable to access evaluation: ' . $e->getMessage());
            return $this->redirectToRoute('management_workers');
        }

        $evaluation = $crudService->findEvaluation($id);
        if (!$evaluation) {
            throw $this->createNotFoundException('Evaluation not found.');
        }

        if ($request->isMethod('POST')) {
            try {
                // Server-side validation: Verify CSRF token
                if (!$this->isCsrfTokenValid('edit_evaluation_' . $id, (string) $request->request->get('_token'))) {
                    throw new \InvalidArgumentException('Invalid CSRF token.');
                }

                // Server-side validation: Validate evaluation data
                $evaluationData = $this->evaluationDataFromRequest($request);
                $this->validateEvaluationData($evaluationData);

                $crudService->updateEvaluation($id, $evaluationData);
                $this->addFlash('success', 'Evaluation updated successfully.');
            } catch (\InvalidArgumentException $e) {
                $this->addFlash('error', 'Validation error: ' . $e->getMessage());
            } catch (\Throwable $e) {
                $this->addFlash('error', 'Unable to update evaluation: ' . $e->getMessage());
            }

            return $this->redirectToRoute('management_workers');
        }

        $affectations = $crudService->listAffectations();
        $evaluations = $crudService->listEvaluations();
        $affectation = [
            'typeTravail' => null,
            'dateDebut' => null,
            'dateFin' => null,
            'zoneTravail' => null,
            'statut' => 'En attente',
        ];

        return $this->render('management/workers.html.twig', [
            'active' => 'workers',
            'adminMode' => false,
            'affectations' => $affectations,
            'affectation' => $affectation,
            'affectationEditing' => false,
            'evaluations' => $evaluations,
            'evaluation' => $evaluation,
            'evaluationEditing' => true,
        ]);
    }

    #[Route('/management/workers/evaluation/{id}/delete', name: 'management_evaluation_delete', methods: ['POST'])]
    public function deleteEvaluation(int $id, Request $request, PdoCrudService $crudService): Response
    {
        $currentUserId = (int) $request->getSession()->get('auth_user_id', 0);
        if ($currentUserId <= 0) {
            return $this->redirectToRoute('auth_login', ['mode' => 'user']);
        }

        // Server-side validation: Verify CSRF token
        if (!$this->isCsrfTokenValid('delete_evaluation_' . $id, (string) $request->request->get('_token'))) {
            throw $this->createAccessDeniedException('Invalid CSRF token.');
        }

        // Server-side validation: Verify record exists and is accessible
        try {
            $this->validateEvaluationAccess($id, $currentUserId, $crudService);
        } catch (\InvalidArgumentException | \RuntimeException $e) {
            $this->addFlash('error', 'Unable to delete evaluation: ' . $e->getMessage());
            return $this->redirectToRoute('management_workers');
        }

        try {
            $crudService->deleteEvaluation($id);
            $this->addFlash('success', 'Evaluation deleted successfully.');
        } catch (\Throwable $e) {
            $this->addFlash('error', 'Unable to delete evaluation: ' . $e->getMessage());
        }

        return $this->redirectToRoute('management_workers');
    }

    #[Route('/admin/management/workers', name: 'admin_management_workers', methods: ['GET', 'POST'])]
    public function adminWorkers(Request $request, PdoCrudService $crudService): Response
    {
        $currentAdminId = (int) $request->getSession()->get('auth_user_id', 0);
        if ($currentAdminId <= 0) {
            return $this->redirectToRoute('auth_login', ['mode' => 'admin']);
        }

        // Get available users for scope selection
        $availableUsers = $crudService->listUsers();
        $selectedUserId = (int) $request->query->get('user_id', $currentAdminId);

        $affectation = [
            'typeTravail' => null,
            'dateDebut' => null,
            'dateFin' => null,
            'zoneTravail' => null,
            'statut' => 'En attente',
        ];
        $evaluation = [
            'affectationId' => null,
            'note' => null,
            'qualite' => null,
            'commentaire' => null,
            'dateEvaluation' => null,
        ];

        if ($request->isMethod('POST')) {
            $formType = (string) $request->request->get('form_type', 'affectation');

            try {
                if ($formType === 'evaluation') {
                    $crudService->createEvaluation($this->evaluationDataFromRequest($request));
                } else {
                    $crudService->createAffectation($this->affectationDataFromRequest($request));
                }
                $this->addFlash('success', 'Entry created successfully.');
            } catch (\Throwable $e) {
                $this->addFlash('error', 'Unable to save data: ' . $e->getMessage());
            }

            return $this->redirectToRoute('admin_management_workers', ['user_id' => $selectedUserId]);
        }

        $affectations = $crudService->listAffectations();
        $evaluations = $crudService->listEvaluations();

        // Calculate statistics for admin dashboard
        $stats = $this->calculateWorkerStats($affectations, $evaluations);

        return $this->render('management/workers.html.twig', [
            'active' => 'workers',
            'adminMode' => true,
            'affectations' => $affectations,
            'affectation' => $affectation,
            'affectationEditing' => false,
            'evaluations' => $evaluations,
            'evaluation' => $evaluation,
            'evaluationEditing' => false,
            'stats' => $stats,
            'availableUsers' => $availableUsers,
            'selectedUserId' => $selectedUserId,
        ]);
    }

    #[Route('/admin/management/workers/{id}/edit', name: 'admin_management_workers_edit', methods: ['GET', 'POST'])]
    public function adminEditWorker(int $id, Request $request, PdoCrudService $crudService): Response
    {
        $currentAdminId = (int) $request->getSession()->get('auth_user_id', 0);
        if ($currentAdminId <= 0) {
            return $this->redirectToRoute('auth_login', ['mode' => 'admin']);
        }

        $affectation = $crudService->findAffectation($id);
        if (!$affectation) {
            throw $this->createNotFoundException('Affectation not found.');
        }

        if ($request->isMethod('POST')) {
            try {
                $crudService->updateAffectation($id, $this->affectationDataFromRequest($request));
                $this->addFlash('success', 'Affectation updated successfully.');
            } catch (\Throwable $e) {
                $this->addFlash('error', 'Unable to update affectation: ' . $e->getMessage());
            }

            return $this->redirectToRoute('admin_management_workers');
        }

        $affectations = $crudService->listAffectations();
        $evaluation = [
            'affectationId' => null,
            'note' => null,
            'qualite' => null,
            'commentaire' => null,
            'dateEvaluation' => null,
        ];
        $evaluations = $crudService->listEvaluations();

        return $this->render('management/workers.html.twig', [
            'active' => 'workers',
            'adminMode' => true,
            'affectations' => $affectations,
            'affectation' => $affectation,
            'affectationEditing' => true,
            'evaluations' => $evaluations,
            'evaluation' => $evaluation,
            'evaluationEditing' => false,
        ]);
    }

    #[Route('/admin/management/workers/{id}/delete', name: 'admin_management_workers_delete', methods: ['POST'])]
    public function adminDeleteWorker(int $id, Request $request, PdoCrudService $crudService): Response
    {
        $currentAdminId = (int) $request->getSession()->get('auth_user_id', 0);
        if ($currentAdminId <= 0) {
            return $this->redirectToRoute('auth_login', ['mode' => 'admin']);
        }

        if (!$this->isCsrfTokenValid('delete_affectation_' . $id, (string) $request->request->get('_token'))) {
            throw $this->createAccessDeniedException('Invalid CSRF token.');
        }

        try {
            $crudService->deleteAffectation($id);
            $this->addFlash('success', 'Affectation deleted successfully.');
        } catch (\Throwable $e) {
            $this->addFlash('error', 'Unable to delete affectation: ' . $e->getMessage());
        }

        return $this->redirectToRoute('admin_management_workers');
    }

    #[Route('/admin/management/workers/evaluation/{id}/edit', name: 'admin_management_evaluation_edit', methods: ['GET', 'POST'])]
    public function adminEditEvaluation(int $id, Request $request, PdoCrudService $crudService): Response
    {
        $currentAdminId = (int) $request->getSession()->get('auth_user_id', 0);
        if ($currentAdminId <= 0) {
            return $this->redirectToRoute('auth_login', ['mode' => 'admin']);
        }

        $evaluation = $crudService->findEvaluation($id);
        if (!$evaluation) {
            throw $this->createNotFoundException('Evaluation not found.');
        }

        if ($request->isMethod('POST')) {
            try {
                $crudService->updateEvaluation($id, $this->evaluationDataFromRequest($request));
                $this->addFlash('success', 'Evaluation updated successfully.');
            } catch (\Throwable $e) {
                $this->addFlash('error', 'Unable to update evaluation: ' . $e->getMessage());
            }

            return $this->redirectToRoute('admin_management_workers');
        }

        $affectations = $crudService->listAffectations();
        $evaluations = $crudService->listEvaluations();
        $affectation = [
            'typeTravail' => null,
            'dateDebut' => null,
            'dateFin' => null,
            'zoneTravail' => null,
            'statut' => 'En attente',
        ];

        return $this->render('management/workers.html.twig', [
            'active' => 'workers',
            'adminMode' => true,
            'affectations' => $affectations,
            'affectation' => $affectation,
            'affectationEditing' => false,
            'evaluations' => $evaluations,
            'evaluation' => $evaluation,
            'evaluationEditing' => true,
        ]);
    }

    #[Route('/admin/management/workers/evaluation/{id}/delete', name: 'admin_management_evaluation_delete', methods: ['POST'])]
    public function adminDeleteEvaluation(int $id, Request $request, PdoCrudService $crudService): Response
    {
        $currentAdminId = (int) $request->getSession()->get('auth_user_id', 0);
        if ($currentAdminId <= 0) {
            return $this->redirectToRoute('auth_login', ['mode' => 'admin']);
        }

        if (!$this->isCsrfTokenValid('delete_evaluation_' . $id, (string) $request->request->get('_token'))) {
            throw $this->createAccessDeniedException('Invalid CSRF token.');
        }

        try {
            $crudService->deleteEvaluation($id);
            $this->addFlash('success', 'Evaluation deleted successfully.');
        } catch (\Throwable $e) {
            $this->addFlash('error', 'Unable to delete evaluation: ' . $e->getMessage());
        }

        return $this->redirectToRoute('admin_management_workers');
    }

    /**
     * @return array{name:?string,type:?string,status:?string,purchaseDate:?string}
     */
    private function equipmentDataFromRequest(Request $request): array
    {
        $name = trim((string) $request->request->get('name'));
        $type = trim((string) $request->request->get('type'));
        $status = trim((string) $request->request->get('status'));
        $purchaseDate = trim((string) $request->request->get('purchase_date'));

        return [
            'name' => $name !== '' ? $name : null,
            'type' => $type !== '' ? $type : null,
            'status' => $status !== '' ? $status : 'Ready',
            'purchaseDate' => $purchaseDate !== '' ? $purchaseDate : null,
        ];
    }

    /**
     * @return array{equipmentId:int,maintenanceDate:?string,maintenanceType:?string,cost:?string}
     */
    private function maintenanceDataFromRequest(Request $request): array
    {
        $equipmentId = (int) $request->request->get('equipment_id');
        $maintenanceDate = trim((string) $request->request->get('maintenance_date'));
        $maintenanceType = trim((string) $request->request->get('maintenance_type'));
        $cost = trim((string) $request->request->get('cost'));

        return [
            'equipmentId' => $equipmentId,
            'maintenanceDate' => $maintenanceDate !== '' ? $maintenanceDate : null,
            'maintenanceType' => $maintenanceType !== '' ? $maintenanceType : 'Inspection',
            'cost' => $cost !== '' ? $cost : '0',
        ];
    }

    /**
     * @param array<int, array<string, mixed>> $equipments
     * @param array<int, array<string, mixed>> $maintenances
     * @param array<string, mixed> $equipment
     * @param array<string, mixed> $maintenance
     * @param array<int, array<string, mixed>> $availableUsers
     */
    private function renderAdminEquipmentsTemplate(
        array $equipments,
        array $maintenances,
        array $equipment,
        bool $editing,
        array $maintenance,
        bool $maintenanceEditing,
        array $availableUsers = [],
        int $selectedUserId = 0
    ): Response {
        $normalizedEquipments = array_map(static function (array $row): array {
            $purchaseDate = $row['purchaseDate'] ?? null;
            $purchaseDateValue = $purchaseDate instanceof \DateTimeInterface ? $purchaseDate->format('Y-m-d') : null;

            return [
                'id' => (int) ($row['id'] ?? 0),
                'name' => (string) ($row['name'] ?? ''),
                'type' => (string) ($row['type'] ?? ''),
                'status' => (string) ($row['status'] ?? ''),
                'purchaseDate' => $purchaseDateValue,
            ];
        }, $equipments);

        $normalizedMaintenances = array_map(static function (array $row): array {
            $maintenanceDate = $row['maintenanceDate'] ?? null;
            $maintenanceDateValue = $maintenanceDate instanceof \DateTimeInterface ? $maintenanceDate->format('Y-m-d') : null;
            $equipmentValue = $row['equipment'] ?? [];

            return [
                'id' => (int) ($row['id'] ?? 0),
                'equipmentId' => (int) ($equipmentValue['id'] ?? 0),
                'equipmentName' => (string) ($equipmentValue['name'] ?? ''),
                'maintenanceDate' => $maintenanceDateValue,
                'maintenanceType' => (string) ($row['maintenanceType'] ?? ''),
                'cost' => (string) ($row['cost'] ?? '0'),
            ];
        }, $maintenances);

        $readyCount = count(array_filter($normalizedEquipments, static fn(array $row): bool => ($row['status'] ?? null) === 'Ready'));
        $offlineCount = count(array_filter($normalizedEquipments, static fn(array $row): bool => ($row['status'] ?? null) === 'Offline'));
        $serviceCount = count(array_filter($normalizedEquipments, static fn(array $row): bool => ($row['status'] ?? null) === 'Service'));

        $totalCost = 0.0;
        $statusDistribution = [];
        $equipmentTypeDistribution = [];
        foreach ($normalizedEquipments as $row) {
            $statusKey = trim((string) ($row['status'] ?? 'Unknown'));
            $statusDistribution[$statusKey] = ($statusDistribution[$statusKey] ?? 0) + 1;

            $typeKey = trim((string) ($row['type'] ?? 'Unknown'));
            $equipmentTypeDistribution[$typeKey] = ($equipmentTypeDistribution[$typeKey] ?? 0) + 1;
        }

        $maintenanceTypeDistribution = [];
        foreach ($normalizedMaintenances as $row) {
            $totalCost += (float) ($row['cost'] ?? 0);
            $maintenanceTypeKey = trim((string) ($row['maintenanceType'] ?? 'Unknown'));
            $maintenanceTypeDistribution[$maintenanceTypeKey] = ($maintenanceTypeDistribution[$maintenanceTypeKey] ?? 0) + 1;
        }

        $latestEquipmentId = 0;
        foreach ($normalizedEquipments as $row) {
            $latestEquipmentId = max($latestEquipmentId, (int) ($row['id'] ?? 0));
        }

        $latestMaintenanceId = 0;
        foreach ($normalizedMaintenances as $row) {
            $latestMaintenanceId = max($latestMaintenanceId, (int) ($row['id'] ?? 0));
        }

        $latestEquipmentDate = null;
        foreach ($normalizedEquipments as $row) {
            $date = $row['purchaseDate'] ?? null;
            if ($date && ($latestEquipmentDate === null || $date > $latestEquipmentDate)) {
                $latestEquipmentDate = $date;
            }
        }

        $latestMaintenanceDate = null;
        foreach ($normalizedMaintenances as $row) {
            $date = $row['maintenanceDate'] ?? null;
            if ($date && ($latestMaintenanceDate === null || $date > $latestMaintenanceDate)) {
                $latestMaintenanceDate = $date;
            }
        }

        $lastDataChangeDate = $latestEquipmentDate;
        if ($latestMaintenanceDate !== null && ($lastDataChangeDate === null || $latestMaintenanceDate > $lastDataChangeDate)) {
            $lastDataChangeDate = $latestMaintenanceDate;
        }

        $missingPurchaseDateCount = count(array_filter(
            $normalizedEquipments,
            static fn(array $row): bool => empty($row['purchaseDate'])
        ));

        $costTrendRows = array_values(array_filter(
            $normalizedMaintenances,
            static fn(array $row): bool => !empty($row['maintenanceDate'])
        ));
        usort(
            $costTrendRows,
            static fn(array $a, array $b): int => strcmp((string) ($a['maintenanceDate'] ?? ''), (string) ($b['maintenanceDate'] ?? ''))
        );
        $costTrendRows = array_slice($costTrendRows, -7);

        $costTrendLabels = array_map(
            static fn(array $row): string => (string) ($row['maintenanceDate'] ?? ''),
            $costTrendRows
        );
        $costTrendValues = array_map(
            static fn(array $row): float => (float) ($row['cost'] ?? 0),
            $costTrendRows
        );

        $statusPalette = ['#89b66b', '#f0b75f', '#d86a5b', '#7b8e9f', '#8f7cc7', '#58b8b3'];
        $statusLegend = [];
        $statusTotal = max(count($normalizedEquipments), 1);
        $statusIndex = 0;
        foreach ($statusDistribution as $label => $value) {
            $statusLegend[] = [
                'label' => $label,
                'value' => $value,
                'percent' => round(($value / $statusTotal) * 100, 1),
                'color' => $statusPalette[$statusIndex % count($statusPalette)],
            ];
            ++$statusIndex;
        }

        $maintenancePalette = ['#7fc6ff', '#f5cc7c', '#f28d8d', '#98d7b8', '#9ca9ff', '#d7a5ec'];
        $maintenanceLegend = [];
        $maintenanceTotal = max(count($normalizedMaintenances), 1);
        $maintenanceIndex = 0;
        foreach ($maintenanceTypeDistribution as $label => $value) {
            $maintenanceLegend[] = [
                'label' => $label,
                'value' => $value,
                'percent' => round(($value / $maintenanceTotal) * 100, 1),
                'color' => $maintenancePalette[$maintenanceIndex % count($maintenancePalette)],
            ];
            ++$maintenanceIndex;
        }

        $buildPieGradient = static function (array $legend): string {
            if ($legend === []) {
                return '#3b4740 0% 100%';
            }

            $start = 0.0;
            $segments = [];
            foreach ($legend as $entry) {
                $percent = (float) ($entry['percent'] ?? 0.0);
                $end = min($start + $percent, 100.0);
                $segments[] = sprintf('%s %.2f%% %.2f%%', (string) ($entry['color'] ?? '#999'), $start, $end);
                $start = $end;
            }

            if ($start < 100.0) {
                $segments[] = sprintf('#3b4740 %.2f%% 100%%', $start);
            }

            return implode(', ', $segments);
        };

        $recentLogs = [];
        foreach (array_slice($normalizedEquipments, 0, 4) as $row) {
            $recentLogs[] = [
                'table' => 'EQUIPMENTS',
                'entry' => sprintf('#%d %s (%s)', (int) $row['id'], (string) $row['name'], (string) $row['status']),
                'timestamp' => $row['purchaseDate'] ?: 'date not set',
                'sortDate' => $row['purchaseDate'] ?: '0000-00-00',
                'sortId' => (int) $row['id'],
            ];
        }
        foreach (array_slice($normalizedMaintenances, 0, 4) as $row) {
            $recentLogs[] = [
                'table' => 'MAINTENANCE',
                'entry' => sprintf(
                    '#%d E#%d %s $%s',
                    (int) $row['id'],
                    (int) $row['equipmentId'],
                    (string) $row['maintenanceType'],
                    (string) $row['cost']
                ),
                'timestamp' => $row['maintenanceDate'] ?: 'date not set',
                'sortDate' => $row['maintenanceDate'] ?: '0000-00-00',
                'sortId' => (int) $row['id'],
            ];
        }

        usort($recentLogs, static function (array $a, array $b): int {
            $dateCompare = strcmp((string) ($b['sortDate'] ?? ''), (string) ($a['sortDate'] ?? ''));
            if ($dateCompare !== 0) {
                return $dateCompare;
            }

            return (int) ($b['sortId'] ?? 0) <=> (int) ($a['sortId'] ?? 0);
        });

        $recentLogs = array_map(static function (array $row): array {
            unset($row['sortDate'], $row['sortId']);
            return $row;
        }, array_slice($recentLogs, 0, 4));

        return $this->render('admin/equipments.html.twig', [
            'active' => 'equipments',
            'availableUsers' => $availableUsers,
            'selectedUserId' => $selectedUserId,
            'equipments' => $normalizedEquipments,
            'equipment' => $equipment,
            'editing' => $editing,
            'maintenances' => $normalizedMaintenances,
            'maintenance' => $maintenance,
            'maintenanceEditing' => $maintenanceEditing,
            'adminStats' => [
                'equipmentCount' => count($normalizedEquipments),
                'maintenanceCount' => count($normalizedMaintenances),
                'readyCount' => $readyCount,
                'serviceCount' => $serviceCount,
                'offlineCount' => $offlineCount,
                'maintenanceCost' => $totalCost,
                'averageCost' => count($normalizedMaintenances) > 0 ? $totalCost / count($normalizedMaintenances) : 0,
            ],
            'dbTelemetry' => [
                'equipmentRows' => count($normalizedEquipments),
                'maintenanceRows' => count($normalizedMaintenances),
                'latestEquipmentId' => $latestEquipmentId,
                'latestMaintenanceId' => $latestMaintenanceId,
                'nextEquipmentIdEstimate' => $latestEquipmentId + 1,
                'nextMaintenanceIdEstimate' => $latestMaintenanceId + 1,
                'lastEquipmentChange' => $latestEquipmentDate,
                'lastMaintenanceChange' => $latestMaintenanceDate,
                'lastDataChange' => $lastDataChangeDate,
                'missingPurchaseDateCount' => $missingPurchaseDateCount,
                'equipmentTypeCount' => count($equipmentTypeDistribution),
            ],
            'statusLegend' => $statusLegend,
            'maintenanceLegend' => $maintenanceLegend,
            'statusPieGradient' => $buildPieGradient($statusLegend),
            'maintenancePieGradient' => $buildPieGradient($maintenanceLegend),
            'costTrendLabels' => $costTrendLabels,
            'costTrendValues' => $costTrendValues,
            'recentLogs' => $recentLogs,
        ]);
    }

    /**
     * @return array{typeTravail:?string,dateDebut:?string,dateFin:?string,zoneTravail:?string,statut:?string}
     */
    /**
     * Validate ownership and existence of affectation for user access
     */
    private function validateAffectationAccess(int $affectationId, int $userId, PdoCrudService $crudService): void
    {
        $affectation = $crudService->findAffectation($affectationId);
        if (!$affectation) {
            throw $this->createAccessDeniedException('Access denied: Affectation not found or not accessible.');
        }
    }

    /**
     * Validate ownership and existence of evaluation for user access
     */
    private function validateEvaluationAccess(int $evaluationId, int $userId, PdoCrudService $crudService): void
    {
        $evaluation = $crudService->findEvaluation($evaluationId);
        if (!$evaluation) {
            throw $this->createAccessDeniedException('Access denied: Evaluation not found or not accessible.');
        }
    }

    /**
     * Validate affectation data from request
     */
    private function validateAffectationData(array $data): void
    {
        $requiredFields = ['typeTravail', 'zoneTravail', 'dateDebut', 'dateFin', 'statut'];
        foreach ($requiredFields as $field) {
            if (empty($data[$field])) {
                throw new \InvalidArgumentException("Missing required field: $field");
            }
        }

        // Validate minimum character length
        $typeTravail = trim($data['typeTravail'] ?? '');
        if (strlen($typeTravail) < 3) {
            throw new \InvalidArgumentException('Type de travail must be at least 3 characters');
        }

        $zoneTravail = trim($data['zoneTravail'] ?? '');
        if (strlen($zoneTravail) < 3) {
            throw new \InvalidArgumentException('Zone de travail must be at least 3 characters');
        }

        // Validate dates
        try {
            $startDate = new \DateTime($data['dateDebut']);
            $endDate = new \DateTime($data['dateFin']);
            if ($endDate < $startDate) {
                throw new \InvalidArgumentException('End date must be after or equal to start date');
            }
        } catch (\Exception $e) {
            throw new \InvalidArgumentException('Invalid date format: ' . $e->getMessage());
        }

        // Validate status
        $validStatuses = ['En attente', 'En cours', 'Complété', 'Suspendu', 'Annulé'];
        if (!in_array($data['statut'], $validStatuses, true)) {
            throw new \InvalidArgumentException('Invalid status value');
        }
    }

    /**
     * Validate evaluation data from request
     */
    private function validateEvaluationData(array $data): void
    {
        $requiredFields = ['affectationId', 'note', 'qualite', 'commentaire', 'dateEvaluation'];
        foreach ($requiredFields as $field) {
            if (empty($data[$field])) {
                throw new \InvalidArgumentException("Missing required field: $field");
            }
        }

        // Validate affectation ID
        if ((int) $data['affectationId'] <= 0) {
            throw new \InvalidArgumentException('Valid affectation must be selected');
        }

        // Validate note is numeric and in range
        $note = (int) $data['note'];
        if ($note < 0 || $note > 20) {
            throw new \InvalidArgumentException('Note must be between 0 and 20');
        }

        // Validate quality
        $validQualities = ['Excellent', 'Très bon', 'Bon', 'Acceptable', 'Insuffisant'];
        if (!in_array($data['qualite'], $validQualities, true)) {
            throw new \InvalidArgumentException('Invalid quality value');
        }

        // Validate comment minimum length
        $commentaire = trim($data['commentaire'] ?? '');
        if (strlen($commentaire) < 5) {
            throw new \InvalidArgumentException('Comment must be at least 5 characters');
        }

        // Validate evaluation date
        try {
            $evaluationDate = new \DateTime($data['dateEvaluation']);
            $today = new \DateTime('today');

            if ($evaluationDate > $today) {
                throw new \InvalidArgumentException('Evaluation date cannot be in the future (must be today or earlier)');
            }
        } catch (\InvalidArgumentException $e) {
            throw $e;
        } catch (\Exception $e) {
            throw new \InvalidArgumentException('Invalid date format: ' . $e->getMessage());
        }
    }

    private function affectationDataFromRequest(Request $request): array
    {
        $typeTravail = trim((string) $request->request->get('type_travail'));
        $dateDebut = trim((string) $request->request->get('date_debut'));
        $dateFin = trim((string) $request->request->get('date_fin'));
        $zoneTravail = trim((string) $request->request->get('zone_travail'));
        $statut = trim((string) $request->request->get('statut'));

        return [
            'typeTravail' => $typeTravail !== '' ? $typeTravail : null,
            'dateDebut' => $dateDebut !== '' ? $dateDebut : null,
            'dateFin' => $dateFin !== '' ? $dateFin : null,
            'zoneTravail' => $zoneTravail !== '' ? $zoneTravail : null,
            'statut' => $statut !== '' ? $statut : 'En attente',
        ];
    }

    /**
     * @return array{affectationId:int,note:?string,qualite:?string,commentaire:?string,dateEvaluation:?string}
     */
    private function evaluationDataFromRequest(Request $request): array
    {
        $affectationId = (int) $request->request->get('affectation_id');
        $note = trim((string) $request->request->get('note'));
        $qualite = trim((string) $request->request->get('qualite'));
        $commentaire = trim((string) $request->request->get('commentaire'));
        $dateEvaluation = trim((string) $request->request->get('date_evaluation'));

        return [
            'affectationId' => $affectationId,
            'note' => $note !== '' ? $note : null,
            'qualite' => $qualite !== '' ? $qualite : null,
            'commentaire' => $commentaire !== '' ? $commentaire : null,
            'dateEvaluation' => $dateEvaluation !== '' ? $dateEvaluation : null,
        ];
    }

    private function isAdminRole(string $roleName): bool
    {
        return str_contains(strtoupper($roleName), 'ADMIN');
    }

    /**
     * Calculate comprehensive statistics for worker management dashboard
     */
    private function calculateWorkerStats(array $affectations, array $evaluations): array
    {
        // Status breakdown
        $statusCounts = [
            'En attente' => 0,
            'En cours' => 0,
            'Complété' => 0,
            'Suspendu' => 0,
            'Annulé' => 0,
        ];

        $typeCounts = [];
        $zoneCounts = [];
        $totalAffectations = 0;

        foreach ($affectations as $aff) {
            $totalAffectations++;
            $status = $aff['statut'] ?? 'En attente';
            if (isset($statusCounts[$status])) {
                $statusCounts[$status]++;
            }

            $type = $aff['typeTravail'] ?? 'Unknown';
            $typeCounts[$type] = ($typeCounts[$type] ?? 0) + 1;

            $zone = $aff['zoneTravail'] ?? 'Unknown';
            $zoneCounts[$zone] = ($zoneCounts[$zone] ?? 0) + 1;
        }

        // Performance evaluation statistics
        $totalEvaluations = count($evaluations);
        $avgNote = 0;
        $qualityCounts = [
            'Excellent' => 0,
            'Très bon' => 0,
            'Bon' => 0,
            'Acceptable' => 0,
            'Insuffisant' => 0,
        ];
        $notesSum = 0;

        foreach ($evaluations as $eval) {
            $note = (int) ($eval['note'] ?? 0);
            $notesSum += $note;

            $quality = $eval['qualite'] ?? 'Unknown';
            if (isset($qualityCounts[$quality])) {
                $qualityCounts[$quality]++;
            }
        }

        $avgNote = $totalEvaluations > 0 ? round($notesSum / $totalEvaluations, 2) : 0;

        // Date statistics
        $dateStats = $this->calculateDateStats($affectations);

        // Completion rate
        $completedCount = $statusCounts['Complété'] ?? 0;
        $completionRate = $totalAffectations > 0 ? round(($completedCount / $totalAffectations) * 100, 1) : 0;

        return [
            'totalAffectations' => $totalAffectations,
            'totalEvaluations' => $totalEvaluations,
            'completionRate' => $completionRate,
            'averageNote' => $avgNote,
            'statusCounts' => $statusCounts,
            'typeCounts' => $typeCounts,
            'zoneCounts' => $zoneCounts,
            'qualityCounts' => $qualityCounts,
            'dateStats' => $dateStats,
        ];
    }

    /**
     * Calculate date-based statistics
     */
    private function calculateDateStats(array $affectations): array
    {
        $earliestDate = null;
        $latestDate = null;
        $ongoingCount = 0;

        foreach ($affectations as $aff) {
            $startDate = $aff['dateDebut'] instanceof \DateTimeInterface
                ? $aff['dateDebut']
                : (\DateTime::createFromFormat('Y-m-d', (string) ($aff['dateDebut'] ?? '')) ?: null);

            $endDate = $aff['dateFin'] instanceof \DateTimeInterface
                ? $aff['dateFin']
                : (\DateTime::createFromFormat('Y-m-d', (string) ($aff['dateFin'] ?? '')) ?: null);

            if ($startDate) {
                if (!$earliestDate || $startDate < $earliestDate) {
                    $earliestDate = $startDate;
                }
            }

            if ($endDate) {
                if (!$latestDate || $endDate > $latestDate) {
                    $latestDate = $endDate;
                }

                // Check if ongoing (end date >= today)
                $today = new \DateTime();
                if ($endDate >= $today) {
                    $ongoingCount++;
                }
            }
        }

        return [
            'earliestDate' => $earliestDate?->format('Y-m-d'),
            'latestDate' => $latestDate?->format('Y-m-d'),
            'ongoingCount' => $ongoingCount,
            'daysSpan' => $earliestDate && $latestDate
                ? $latestDate->diff($earliestDate)->days
                : 0,
        ];
    }
}
