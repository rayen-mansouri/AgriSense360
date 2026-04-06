<?php

namespace App\Controller;

use App\Service\OracleSqlPlusCrudService;
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
    public function equipments(Request $request, OracleSqlPlusCrudService $oracleCrud): Response
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
                    $oracleCrud->createMaintenance($this->maintenanceDataFromRequest($request), $currentUserId);
                } else {
                    $oracleCrud->createEquipment($this->equipmentDataFromRequest($request), $currentUserId);
                }
            } catch (\Throwable $e) {
                $this->addFlash('error', 'Unable to save data: ' . $e->getMessage());
            }

            return $this->redirectToRoute('management_equipments');
        }

        $equipments = $oracleCrud->listEquipments($currentUserId);
        $maintenances = $oracleCrud->listMaintenances($currentUserId);

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
    public function editEquipment(int $id, Request $request, OracleSqlPlusCrudService $oracleCrud): Response
    {
        $currentUserId = (int) $request->getSession()->get('auth_user_id', 0);
        if ($currentUserId <= 0) {
            return $this->redirectToRoute('auth_login', ['mode' => 'user']);
        }

        $equipment = $oracleCrud->findEquipment($id, $currentUserId);

        if (!$equipment) {
            throw $this->createNotFoundException('Equipment not found.');
        }

        if ($request->isMethod('POST')) {
            try {
                $oracleCrud->updateEquipment($id, $this->equipmentDataFromRequest($request), $currentUserId);
            } catch (\Throwable $e) {
                $this->addFlash('error', 'Unable to update equipment: ' . $e->getMessage());
            }

            return $this->redirectToRoute('management_equipments');
        }

        $equipments = $oracleCrud->listEquipments($currentUserId);
        $maintenance = [
            'equipment' => null,
            'maintenanceDate' => null,
            'maintenanceType' => null,
            'cost' => null,
        ];
        $maintenances = $oracleCrud->listMaintenances($currentUserId);

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
    public function deleteEquipment(int $id, Request $request, OracleSqlPlusCrudService $oracleCrud): Response
    {
        $currentUserId = (int) $request->getSession()->get('auth_user_id', 0);
        if ($currentUserId <= 0) {
            return $this->redirectToRoute('auth_login', ['mode' => 'user']);
        }

        if (!$this->isCsrfTokenValid('delete_equipment_' . $id, (string) $request->request->get('_token'))) {
            throw $this->createAccessDeniedException('Invalid CSRF token.');
        }

        try {
            $oracleCrud->deleteEquipment($id, $currentUserId);
        } catch (\Throwable $e) {
            $this->addFlash('error', 'Unable to delete equipment: ' . $e->getMessage());
        }

        return $this->redirectToRoute('management_equipments');
    }

    #[Route('/management/equipments/maintenance/{id}/edit', name: 'management_maintenance_edit', methods: ['GET', 'POST'])]
    public function editMaintenance(int $id, Request $request, OracleSqlPlusCrudService $oracleCrud): Response
    {
        $currentUserId = (int) $request->getSession()->get('auth_user_id', 0);
        if ($currentUserId <= 0) {
            return $this->redirectToRoute('auth_login', ['mode' => 'user']);
        }

        $maintenance = $oracleCrud->findMaintenance($id, $currentUserId);

        if (!$maintenance) {
            throw $this->createNotFoundException('Maintenance not found.');
        }

        if ($request->isMethod('POST')) {
            try {
                $oracleCrud->updateMaintenance($id, $this->maintenanceDataFromRequest($request), $currentUserId);
            } catch (\Throwable $e) {
                $this->addFlash('error', 'Unable to update maintenance: ' . $e->getMessage());
            }

            return $this->redirectToRoute('management_equipments');
        }

        $equipments = $oracleCrud->listEquipments($currentUserId);
        $maintenances = $oracleCrud->listMaintenances($currentUserId);
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
    public function deleteMaintenance(int $id, Request $request, OracleSqlPlusCrudService $oracleCrud): Response
    {
        $currentUserId = (int) $request->getSession()->get('auth_user_id', 0);
        if ($currentUserId <= 0) {
            return $this->redirectToRoute('auth_login', ['mode' => 'user']);
        }

        if (!$this->isCsrfTokenValid('delete_maintenance_' . $id, (string) $request->request->get('_token'))) {
            throw $this->createAccessDeniedException('Invalid CSRF token.');
        }

        try {
            $oracleCrud->deleteMaintenance($id, $currentUserId);
        } catch (\Throwable $e) {
            $this->addFlash('error', 'Unable to delete maintenance: ' . $e->getMessage());
        }

        return $this->redirectToRoute('management_equipments');
    }

    #[Route('/admin/management/equipments', name: 'admin_management_equipments')]
    public function adminEquipments(Request $request, OracleSqlPlusCrudService $oracleCrud): Response
    {
        $currentAdminId = (int) $request->getSession()->get('auth_user_id', 0);
        if ($currentAdminId <= 0) {
            return $this->redirectToRoute('auth_login', ['mode' => 'admin']);
        }

        $allUsers = $oracleCrud->listUsers();
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
                    $oracleCrud->createMaintenance($this->maintenanceDataFromRequest($request), $selectedUserId);
                } else {
                    $oracleCrud->createEquipment($this->equipmentDataFromRequest($request), $selectedUserId);
                }
            } catch (\Throwable $e) {
                $this->addFlash('error', 'Unable to save data: ' . $e->getMessage());
            }

            return $this->redirectToRoute('admin_management_equipments', ['user_id' => $selectedUserId]);
        }

        $equipments = $oracleCrud->listEquipments($selectedUserId);
        $maintenances = $oracleCrud->listMaintenances($selectedUserId);

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
    public function adminEditEquipment(int $id, Request $request, OracleSqlPlusCrudService $oracleCrud): Response
    {
        $selectedUserId = (int) $request->query->get('user_id', 0);
        if ($selectedUserId <= 0) {
            return $this->redirectToRoute('admin_management_equipments');
        }

        $equipment = $oracleCrud->findEquipment($id, $selectedUserId);

        if (!$equipment) {
            throw $this->createNotFoundException('Equipment not found.');
        }

        if ($request->isMethod('POST')) {
            try {
                $oracleCrud->updateEquipment($id, $this->equipmentDataFromRequest($request), $selectedUserId);
            } catch (\Throwable $e) {
                $this->addFlash('error', 'Unable to update equipment: ' . $e->getMessage());
            }

            return $this->redirectToRoute('admin_management_equipments', ['user_id' => $selectedUserId]);
        }

        $equipments = $oracleCrud->listEquipments($selectedUserId);
        $maintenances = $oracleCrud->listMaintenances($selectedUserId);
        $allUsers = $oracleCrud->listUsers();
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
    public function adminDeleteEquipment(int $id, Request $request, OracleSqlPlusCrudService $oracleCrud): Response
    {
        $selectedUserId = (int) $request->query->get('user_id', 0);
        if ($selectedUserId <= 0) {
            return $this->redirectToRoute('admin_management_equipments');
        }

        if (!$this->isCsrfTokenValid('delete_equipment_' . $id, (string) $request->request->get('_token'))) {
            throw $this->createAccessDeniedException('Invalid CSRF token.');
        }

        try {
            $oracleCrud->deleteEquipment($id, $selectedUserId);
        } catch (\Throwable $e) {
            $this->addFlash('error', 'Unable to delete equipment: ' . $e->getMessage());
        }

        return $this->redirectToRoute('admin_management_equipments', ['user_id' => $selectedUserId]);
    }

    #[Route('/admin/management/equipments/maintenance/{id}/edit', name: 'admin_management_maintenance_edit', methods: ['GET', 'POST'])]
    public function adminEditMaintenance(int $id, Request $request, OracleSqlPlusCrudService $oracleCrud): Response
    {
        $selectedUserId = (int) $request->query->get('user_id', 0);
        if ($selectedUserId <= 0) {
            return $this->redirectToRoute('admin_management_equipments');
        }

        $maintenance = $oracleCrud->findMaintenance($id, $selectedUserId);

        if (!$maintenance) {
            throw $this->createNotFoundException('Maintenance not found.');
        }

        if ($request->isMethod('POST')) {
            try {
                $oracleCrud->updateMaintenance($id, $this->maintenanceDataFromRequest($request), $selectedUserId);
            } catch (\Throwable $e) {
                $this->addFlash('error', 'Unable to update maintenance: ' . $e->getMessage());
            }

            return $this->redirectToRoute('admin_management_equipments', ['user_id' => $selectedUserId]);
        }

        $equipments = $oracleCrud->listEquipments($selectedUserId);
        $maintenances = $oracleCrud->listMaintenances($selectedUserId);
        $allUsers = $oracleCrud->listUsers();
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
    public function adminDeleteMaintenance(int $id, Request $request, OracleSqlPlusCrudService $oracleCrud): Response
    {
        $selectedUserId = (int) $request->query->get('user_id', 0);
        if ($selectedUserId <= 0) {
            return $this->redirectToRoute('admin_management_equipments');
        }

        if (!$this->isCsrfTokenValid('delete_maintenance_' . $id, (string) $request->request->get('_token'))) {
            throw $this->createAccessDeniedException('Invalid CSRF token.');
        }

        try {
            $oracleCrud->deleteMaintenance($id, $selectedUserId);
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
    public function users(Request $request, OracleSqlPlusCrudService $oracleCrud): Response
    {
        $session = $request->getSession();
        $currentUserId = (int) $session->get('auth_user_id', 0);

        if ($currentUserId <= 0) {
            return $this->redirectToRoute('auth_login', ['mode' => 'user']);
        }

        try {
            $currentUser = $oracleCrud->findUser($currentUserId);
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

                $oracleCrud->updateUser($currentUserId, $payload);
                $this->addFlash('success', 'Profile updated.');
            } catch (\Throwable $e) {
                $this->addFlash('error', 'Unable to update profile: ' . $e->getMessage());
            }

            return $this->redirectToRoute('management_users');
        }

        return $this->render('management/users.html.twig', [
            'active' => 'profile',
            'currentUser' => $currentUser,
        ]);
    }

    #[Route('/admin/profile', name: 'admin_profile', methods: ['GET', 'POST'])]
    public function adminProfile(Request $request, OracleSqlPlusCrudService $oracleCrud): Response
    {
        $session = $request->getSession();
        $currentUserId = (int) $session->get('auth_user_id', 0);

        if ($currentUserId <= 0) {
            return $this->redirectToRoute('auth_login', ['mode' => 'admin']);
        }

        try {
            $currentUser = $oracleCrud->findUser($currentUserId);
            $allUsers = $oracleCrud->listUsers();
            $equipments = $oracleCrud->listEquipments();
            $maintenances = $oracleCrud->listMaintenances();
        } catch (\Throwable $e) {
            $this->addFlash('error', 'Unable to load admin profile: ' . $e->getMessage());
            $currentUser = null;
            $allUsers = [];
            $equipments = [];
            $maintenances = [];
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
                    'roleName' => (string) ($currentUser['roleName'] ?? 'ADMIN'),
                ];

                $newPassword = trim((string) $request->request->get('password'));
                if ($newPassword !== '') {
                    $payload['passwordHash'] = password_hash($newPassword, PASSWORD_BCRYPT);
                }

                $oracleCrud->updateUser($currentUserId, $payload);
                $this->addFlash('success', 'Admin profile updated.');
            } catch (\Throwable $e) {
                $this->addFlash('error', 'Unable to update admin profile: ' . $e->getMessage());
            }

            return $this->redirectToRoute('admin_profile');
        }

        $roleLabel = strtoupper((string) ($currentUser['roleName'] ?? 'ADMIN'));

        return $this->render('admin/profile.html.twig', [
            'active' => 'profile',
            'currentUser' => $currentUser,
            'technicalInfo' => [
                'roleLabel' => $roleLabel,
                'userCount' => count($allUsers),
                'equipmentCount' => count($equipments),
                'maintenanceCount' => count($maintenances),
                'sessionRole' => (string) $session->get('auth_role', 'admin'),
                'sessionUserId' => $currentUserId,
                'profileAge' => $currentUser['createdAt'] instanceof \DateTimeInterface ? $currentUser['createdAt']->format('Y-m-d') : '-',
            ],
        ]);
    }

    #[Route('/admin/management/users', name: 'admin_management_users', methods: ['GET', 'POST'])]
    public function adminUsers(Request $request, OracleSqlPlusCrudService $oracleCrud): Response
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
                        $oracleCrud->deleteUser($id);
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
                        $oracleCrud->updateUser($id, $payload);
                        $this->addFlash('success', 'User updated.');
                    }

                    if ($action === 'create') {
                        if (($payload['passwordHash'] ?? null) === null) {
                            $payload['passwordHash'] = password_hash('changeme123', PASSWORD_BCRYPT);
                        }

                        $oracleCrud->createUser($payload);
                        $this->addFlash('success', 'User created.');
                    }
                }
            } catch (\Throwable $e) {
                $this->addFlash('error', 'User operation failed: ' . $e->getMessage());
            }

            return $this->redirectToRoute('admin_management_users');
        }

        try {
            $users = $oracleCrud->listUsers();
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

    #[Route('/management/workers', name: 'management_workers')]
    public function workers(): Response
    {
        return $this->render('management/workers.html.twig', [
            'active' => 'workers',
        ]);
    }

    #[Route('/admin/management/workers', name: 'admin_management_workers')]
    public function adminWorkers(): Response
    {
        return $this->render('management/workers.html.twig', [
            'active' => 'workers',
            'adminMode' => true,
        ]);
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

    private function isAdminRole(string $roleName): bool
    {
        return str_contains(strtoupper($roleName), 'ADMIN');
    }
}
