<?php

namespace App\Controller;

use App\Service\AnimalManagementService;
use App\Service\AnimalValidationService;
use App\Service\OracleSqlPlusCrudService;
use App\Service\WorkerManagementService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class ManagementController extends AbstractController
{
    #[Route('/management/animals', name: 'management_animals', methods: ['GET'])]
    public function animals(Request $request, OracleSqlPlusCrudService $oracleCrud, AnimalManagementService $animalService): Response
    {
        return $this->renderAnimalManagementPage($request, $oracleCrud, $animalService, false);
    }

    #[Route('/admin/management/animals', name: 'admin_management_animals', methods: ['GET'])]
    public function adminAnimals(Request $request, OracleSqlPlusCrudService $oracleCrud, AnimalManagementService $animalService): Response
    {
        return $this->renderAnimalManagementPage($request, $oracleCrud, $animalService, true);
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
            $equipmentData = $this->equipmentDataFromRequest($request);
            $maintenanceData = $this->maintenanceDataFromRequest($request);

            if ($formType === 'maintenance') {
                $errors = $this->validateMaintenanceData($maintenanceData);
            } else {
                $errors = $this->validateEquipmentData($equipmentData);
            }

            if ($errors !== []) {
                $this->addFlash('errors', $errors);
                return $this->redirectToRoute('management_equipments');
            }

            try {
                if ($formType === 'maintenance') {
                    $oracleCrud->createMaintenance($maintenanceData, $currentUserId);
                } else {
                    $oracleCrud->createEquipment($equipmentData, $currentUserId);
                }
            } catch (\Throwable $e) {
                $this->addFlash('error', 'Unable to save data: ' . $e->getMessage());
            }

            return $this->redirectToRoute('management_equipments');
        }

        $equipments = $oracleCrud->listEquipments($currentUserId);
        $maintenances = $oracleCrud->listMaintenances($currentUserId);
        $insights = $this->buildUserEquipmentInsights($equipments, $maintenances);

        return $this->render('management/equipments.html.twig', [
            'active' => 'equipments',
            'equipments' => $equipments,
            'equipment' => $equipment,
            'editing' => false,
            'maintenances' => $maintenances,
            'maintenance' => $maintenance,
            'maintenanceEditing' => false,
            'equipmentStats' => $insights['stats'],
            'equipmentStatusLegend' => $insights['statusLegend'],
            'maintenanceTypeLegend' => $insights['maintenanceLegend'],
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
            $equipmentData = $this->equipmentDataFromRequest($request);
            $errors = $this->validateEquipmentData($equipmentData);
            if ($errors !== []) {
                $this->addFlash('errors', $errors);
                return $this->redirectToRoute('management_equipments_edit', ['id' => $id]);
            }

            try {
                $oracleCrud->updateEquipment($id, $equipmentData, $currentUserId);
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
        $insights = $this->buildUserEquipmentInsights($equipments, $maintenances);

        return $this->render('management/equipments.html.twig', [
            'active' => 'equipments',
            'equipments' => $equipments,
            'equipment' => $equipment,
            'editing' => true,
            'maintenances' => $maintenances,
            'maintenance' => $maintenance,
            'maintenanceEditing' => false,
            'equipmentStats' => $insights['stats'],
            'equipmentStatusLegend' => $insights['statusLegend'],
            'maintenanceTypeLegend' => $insights['maintenanceLegend'],
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
            $maintenanceData = $this->maintenanceDataFromRequest($request);
            $errors = $this->validateMaintenanceData($maintenanceData);
            if ($errors !== []) {
                $this->addFlash('errors', $errors);
                return $this->redirectToRoute('management_maintenance_edit', ['id' => $id]);
            }

            try {
                $oracleCrud->updateMaintenance($id, $maintenanceData, $currentUserId);
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
        $insights = $this->buildUserEquipmentInsights($equipments, $maintenances);

        return $this->render('management/equipments.html.twig', [
            'active' => 'equipments',
            'equipments' => $equipments,
            'equipment' => $equipment,
            'editing' => false,
            'maintenances' => $maintenances,
            'maintenance' => $maintenance,
            'maintenanceEditing' => true,
            'equipmentStats' => $insights['stats'],
            'equipmentStatusLegend' => $insights['statusLegend'],
            'maintenanceTypeLegend' => $insights['maintenanceLegend'],
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
            $equipmentData = $this->equipmentDataFromRequest($request);
            $maintenanceData = $this->maintenanceDataFromRequest($request);
            if ($formType === 'maintenance') {
                $errors = $this->validateMaintenanceData($maintenanceData);
            } else {
                $errors = $this->validateEquipmentData($equipmentData);
            }

            if ($errors !== []) {
                $this->addFlash('errors', $errors);
                return $this->redirectToRoute('admin_management_equipments', ['user_id' => $selectedUserId]);
            }

            try {
                if ($formType === 'maintenance') {
                    $oracleCrud->createMaintenance($maintenanceData, $selectedUserId);
                } else {
                    $oracleCrud->createEquipment($equipmentData, $selectedUserId);
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
            $equipmentData = $this->equipmentDataFromRequest($request);
            $errors = $this->validateEquipmentData($equipmentData);
            if ($errors !== []) {
                $this->addFlash('errors', $errors);
                return $this->redirectToRoute('admin_management_equipments_edit', ['id' => $id, 'user_id' => $selectedUserId]);
            }

            try {
                $oracleCrud->updateEquipment($id, $equipmentData, $selectedUserId);
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
            $maintenanceData = $this->maintenanceDataFromRequest($request);
            $errors = $this->validateMaintenanceData($maintenanceData);
            if ($errors !== []) {
                $this->addFlash('errors', $errors);
                return $this->redirectToRoute('admin_management_maintenance_edit', ['id' => $id, 'user_id' => $selectedUserId]);
            }

            try {
                $oracleCrud->updateMaintenance($id, $maintenanceData, $selectedUserId);
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

                $errors = $this->validateProfileData(
                    $payload['firstName'],
                    $payload['lastName'],
                    $payload['email'],
                    $newPassword
                );
                if ($errors !== []) {
                    $this->addFlash('errors', $errors);
                    return $this->redirectToRoute('management_users');
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

                $errors = $this->validateProfileData(
                    $payload['firstName'],
                    $payload['lastName'],
                    $payload['email'],
                    $newPassword
                );
                if ($errors !== []) {
                    $this->addFlash('errors', $errors);
                    return $this->redirectToRoute('admin_profile');
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

                    $errors = $this->validateAdminUserData(
                        $payload['firstName'],
                        $payload['lastName'],
                        $payload['email'],
                        $payload['status'],
                        $payload['roleName'],
                        $password,
                        $action === 'create'
                    );
                    if ($errors !== []) {
                        $this->addFlash('errors', $errors);
                        return $this->redirectToRoute('admin_management_users');
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

    #[Route('/management/workers', name: 'management_workers', methods: ['GET'])]
    public function workers(Request $request, WorkerManagementService $workerService): Response
    {
        return $this->renderWorkersManagementPage($request, $workerService, null, false);
    }

    #[Route('/admin/management/workers', name: 'admin_management_workers', methods: ['GET'])]
    public function adminWorkers(Request $request, WorkerManagementService $workerService, OracleSqlPlusCrudService $oracleCrud): Response
    {
        return $this->renderWorkersManagementPage($request, $workerService, $oracleCrud, true);
    }

    #[Route('/management/workers/save-worker', name: 'management_workers_save_worker', methods: ['POST'])]
    public function saveWorker(Request $request, WorkerManagementService $workerService): Response
    {
        return $this->handleWorkerSave($request, $workerService, null, false);
    }

    #[Route('/admin/management/workers/save-worker', name: 'admin_management_workers_save_worker', methods: ['POST'])]
    public function adminSaveWorker(Request $request, WorkerManagementService $workerService, OracleSqlPlusCrudService $oracleCrud): Response
    {
        return $this->handleWorkerSave($request, $workerService, $oracleCrud, true);
    }

    #[Route('/management/workers/{id}/delete-worker', name: 'management_workers_delete_worker', methods: ['POST'])]
    public function deleteWorker(int $id, Request $request, WorkerManagementService $workerService): Response
    {
        return $this->handleWorkerDelete($id, $request, $workerService, null, false);
    }

    #[Route('/admin/management/workers/{id}/delete-worker', name: 'admin_management_workers_delete_worker', methods: ['POST'])]
    public function adminDeleteWorker(int $id, Request $request, WorkerManagementService $workerService, OracleSqlPlusCrudService $oracleCrud): Response
    {
        return $this->handleWorkerDelete($id, $request, $workerService, $oracleCrud, true);
    }

    #[Route('/management/workers/save-assignment', name: 'management_workers_save_assignment', methods: ['POST'])]
    public function saveAssignment(Request $request, WorkerManagementService $workerService): Response
    {
        return $this->handleAssignmentSave($request, $workerService, null, false);
    }

    #[Route('/admin/management/workers/save-assignment', name: 'admin_management_workers_save_assignment', methods: ['POST'])]
    public function adminSaveAssignment(Request $request, WorkerManagementService $workerService, OracleSqlPlusCrudService $oracleCrud): Response
    {
        return $this->handleAssignmentSave($request, $workerService, $oracleCrud, true);
    }

    #[Route('/management/workers/{id}/delete-assignment', name: 'management_workers_delete_assignment', methods: ['POST'])]
    public function deleteAssignment(int $id, Request $request, WorkerManagementService $workerService): Response
    {
        return $this->handleAssignmentDelete($id, $request, $workerService, null, false);
    }

    #[Route('/admin/management/workers/{id}/delete-assignment', name: 'admin_management_workers_delete_assignment', methods: ['POST'])]
    public function adminDeleteAssignment(int $id, Request $request, WorkerManagementService $workerService, OracleSqlPlusCrudService $oracleCrud): Response
    {
        return $this->handleAssignmentDelete($id, $request, $workerService, $oracleCrud, true);
    }

    #[Route('/management/workers/save-payment', name: 'management_workers_save_payment', methods: ['POST'])]
    public function savePayment(Request $request, WorkerManagementService $workerService): Response
    {
        return $this->handlePaymentSave($request, $workerService, null, false);
    }

    #[Route('/admin/management/workers/save-payment', name: 'admin_management_workers_save_payment', methods: ['POST'])]
    public function adminSavePayment(Request $request, WorkerManagementService $workerService, OracleSqlPlusCrudService $oracleCrud): Response
    {
        return $this->handlePaymentSave($request, $workerService, $oracleCrud, true);
    }

    #[Route('/management/workers/{id}/delete-payment', name: 'management_workers_delete_payment', methods: ['POST'])]
    public function deletePayment(int $id, Request $request, WorkerManagementService $workerService): Response
    {
        return $this->handlePaymentDelete($id, $request, $workerService, null, false);
    }

    #[Route('/admin/management/workers/{id}/delete-payment', name: 'admin_management_workers_delete_payment', methods: ['POST'])]
    public function adminDeletePayment(int $id, Request $request, WorkerManagementService $workerService, OracleSqlPlusCrudService $oracleCrud): Response
    {
        return $this->handlePaymentDelete($id, $request, $workerService, $oracleCrud, true);
    }

    #[Route('/management/animals/save', name: 'management_animals_save', methods: ['POST'])]
    public function saveAnimal(Request $request, AnimalManagementService $animalService, AnimalValidationService $validationService): Response
    {
        $animalService->ensureSchema();

        $currentUserId = (int) $request->getSession()->get('auth_user_id', 0);
        if ($currentUserId <= 0) {
            return $this->redirectToRoute('auth_login', ['mode' => 'user']);
        }

        $data = $this->buildAnimalDataFromRequest($request);
        $errors = $validationService->validateAnimal($data, $animalService->getTypeOptions(), $animalService->getLocationOptions());
        $animalId = (int) $request->request->get('id', 0);

        if ($errors !== []) {
            $this->addFlash('errors', $errors);
            return $this->redirectToRoute('management_animals', [
                'animalId' => (int) ($request->request->get('animal_id', $animalId) ?: $animalId),
                'editAnimalId' => $animalId,
            ]);
        }

        try {
            if ($animalId > 0) {
                if ($animalService->findAnimal($animalId, $currentUserId) === null) {
                    throw new \RuntimeException('Animal not found.');
                }

                $animalService->updateAnimal($animalId, $data, $currentUserId);
                $this->addFlash('success', 'Animal updated.');
            } else {
                $animalId = $animalService->createAnimal($data, $currentUserId);
                $this->addFlash('success', 'Animal added successfully.');
            }
        } catch (\Throwable $e) {
            $this->addFlash('error', 'Unable to save animal: ' . $e->getMessage());
        }

        return $this->redirectToRoute('management_animals', [
            'animalId' => (int) ($request->request->get('animal_id', $animalId) ?: $animalId),
        ]);
    }

    #[Route('/admin/management/animals/save', name: 'admin_management_animals_save', methods: ['POST'])]
    public function adminSaveAnimal(Request $request, OracleSqlPlusCrudService $oracleCrud, AnimalManagementService $animalService, AnimalValidationService $validationService): Response
    {
        $animalService->ensureSchema();

        $currentAdminId = (int) $request->getSession()->get('auth_user_id', 0);
        if ($currentAdminId <= 0) {
            return $this->redirectToRoute('auth_login', ['mode' => 'admin']);
        }

        $selectedUserId = $this->resolveAdminSelectedUserId($request, $oracleCrud, $currentAdminId);
        $data = $this->buildAnimalDataFromRequest($request);
        $errors = $validationService->validateAnimal($data, $animalService->getTypeOptions(), $animalService->getLocationOptions());
        $animalId = (int) $request->request->get('id', 0);

        if ($errors !== []) {
            $this->addFlash('errors', $errors);
            return $this->redirectToRoute('admin_management_animals', [
                'user_id' => $selectedUserId,
                'animalId' => (int) ($request->request->get('animal_id', $animalId) ?: $animalId),
                'editAnimalId' => $animalId,
            ]);
        }

        try {
            if ($animalId > 0) {
                if ($animalService->findAnimal($animalId, $selectedUserId) === null) {
                    throw new \RuntimeException('Animal not found.');
                }

                $animalService->updateAnimal($animalId, $data, $selectedUserId);
                $this->addFlash('success', 'Animal updated.');
            } else {
                $animalId = $animalService->createAnimal($data, $selectedUserId);
                $this->addFlash('success', 'Animal added successfully.');
            }
        } catch (\Throwable $e) {
            $this->addFlash('error', 'Unable to save animal: ' . $e->getMessage());
        }

        return $this->redirectToRoute('admin_management_animals', [
            'user_id' => $selectedUserId,
            'animalId' => (int) ($request->request->get('animal_id', $animalId) ?: $animalId),
        ]);
    }

    #[Route('/management/animals/{id}/delete', name: 'management_animals_delete', methods: ['POST'])]
    public function deleteAnimal(int $id, Request $request, AnimalManagementService $animalService): Response
    {
        $animalService->ensureSchema();

        $currentUserId = (int) $request->getSession()->get('auth_user_id', 0);
        if ($currentUserId <= 0) {
            return $this->redirectToRoute('auth_login', ['mode' => 'user']);
        }

        try {
            $animalService->deleteAnimal($id, $currentUserId);
            $this->addFlash('success', 'Animal deleted.');
        } catch (\Throwable $e) {
            $this->addFlash('error', 'Unable to delete animal: ' . $e->getMessage());
        }

        return $this->redirectToRoute('management_animals', [
            'animalId' => (int) $request->request->get('animal_id', 0),
        ]);
    }

    #[Route('/admin/management/animals/{id}/delete', name: 'admin_management_animals_delete', methods: ['POST'])]
    public function adminDeleteAnimal(int $id, Request $request, OracleSqlPlusCrudService $oracleCrud, AnimalManagementService $animalService): Response
    {
        $animalService->ensureSchema();

        $currentAdminId = (int) $request->getSession()->get('auth_user_id', 0);
        if ($currentAdminId <= 0) {
            return $this->redirectToRoute('auth_login', ['mode' => 'admin']);
        }

        $selectedUserId = $this->resolveAdminSelectedUserId($request, $oracleCrud, $currentAdminId);

        try {
            $animalService->deleteAnimal($id, $selectedUserId);
            $this->addFlash('success', 'Animal deleted.');
        } catch (\Throwable $e) {
            $this->addFlash('error', 'Unable to delete animal: ' . $e->getMessage());
        }

        return $this->redirectToRoute('admin_management_animals', [
            'user_id' => $selectedUserId,
            'animalId' => (int) $request->request->get('animal_id', 0),
        ]);
    }

    #[Route('/management/animals/records/save', name: 'management_animal_record_save', methods: ['POST'])]
    public function saveAnimalRecord(Request $request, AnimalManagementService $animalService, AnimalValidationService $validationService): Response
    {
        $animalService->ensureSchema();

        $currentUserId = (int) $request->getSession()->get('auth_user_id', 0);
        if ($currentUserId <= 0) {
            return $this->redirectToRoute('auth_login', ['mode' => 'user']);
        }

        $data = $this->buildRecordDataFromRequest($request);
        $errors = $validationService->validateRecord($data, ['HEALTHY', 'SICK', 'INJURED', 'CRITICAL']);
        $recordId = (int) $request->request->get('id', 0);

        if ($errors !== []) {
            $this->addFlash('errors', $errors);
            return $this->redirectToRoute('management_animals', [
                'animalId' => (int) ($data['animalId'] ?? 0),
                'editRecordId' => $recordId,
            ]);
        }

        try {
            if ($recordId > 0) {
                $animalService->updateRecord($recordId, $data, $currentUserId);
                $this->addFlash('success', 'Health record updated.');
            } else {
                $recordId = $animalService->createRecord($data, $currentUserId);
                $this->addFlash('success', 'Health record added.');
            }
        } catch (\Throwable $e) {
            $this->addFlash('error', 'Unable to save health record: ' . $e->getMessage());
        }

        return $this->redirectToRoute('management_animals', [
            'animalId' => (int) ($data['animalId'] ?? 0),
        ]);
    }

    #[Route('/admin/management/animals/records/save', name: 'admin_management_animal_record_save', methods: ['POST'])]
    public function adminSaveAnimalRecord(Request $request, OracleSqlPlusCrudService $oracleCrud, AnimalManagementService $animalService, AnimalValidationService $validationService): Response
    {
        $animalService->ensureSchema();

        $currentAdminId = (int) $request->getSession()->get('auth_user_id', 0);
        if ($currentAdminId <= 0) {
            return $this->redirectToRoute('auth_login', ['mode' => 'admin']);
        }

        $selectedUserId = $this->resolveAdminSelectedUserId($request, $oracleCrud, $currentAdminId);
        $data = $this->buildRecordDataFromRequest($request);
        $errors = $validationService->validateRecord($data, ['HEALTHY', 'SICK', 'INJURED', 'CRITICAL']);
        $recordId = (int) $request->request->get('id', 0);

        if ($errors !== []) {
            $this->addFlash('errors', $errors);
            return $this->redirectToRoute('admin_management_animals', [
                'user_id' => $selectedUserId,
                'animalId' => (int) ($data['animalId'] ?? 0),
                'editRecordId' => $recordId,
            ]);
        }

        try {
            if ($recordId > 0) {
                $animalService->updateRecord($recordId, $data, $selectedUserId);
                $this->addFlash('success', 'Health record updated.');
            } else {
                $recordId = $animalService->createRecord($data, $selectedUserId);
                $this->addFlash('success', 'Health record added.');
            }
        } catch (\Throwable $e) {
            $this->addFlash('error', 'Unable to save health record: ' . $e->getMessage());
        }

        return $this->redirectToRoute('admin_management_animals', [
            'user_id' => $selectedUserId,
            'animalId' => (int) ($data['animalId'] ?? 0),
        ]);
    }

    #[Route('/management/animals/records/{id}/delete', name: 'management_animal_record_delete', methods: ['POST'])]
    public function deleteAnimalRecord(int $id, Request $request, AnimalManagementService $animalService): Response
    {
        $animalService->ensureSchema();

        $currentUserId = (int) $request->getSession()->get('auth_user_id', 0);
        if ($currentUserId <= 0) {
            return $this->redirectToRoute('auth_login', ['mode' => 'user']);
        }

        $animalId = (int) $request->request->get('animal_id', 0);

        try {
            $animalService->deleteRecord($id, $currentUserId);
            $this->addFlash('success', 'Health record deleted.');
        } catch (\Throwable $e) {
            $this->addFlash('error', 'Unable to delete health record: ' . $e->getMessage());
        }

        return $this->redirectToRoute('management_animals', [
            'animalId' => $animalId,
        ]);
    }

    #[Route('/admin/management/animals/records/{id}/delete', name: 'admin_management_animal_record_delete', methods: ['POST'])]
    public function adminDeleteAnimalRecord(int $id, Request $request, OracleSqlPlusCrudService $oracleCrud, AnimalManagementService $animalService): Response
    {
        $animalService->ensureSchema();

        $currentAdminId = (int) $request->getSession()->get('auth_user_id', 0);
        if ($currentAdminId <= 0) {
            return $this->redirectToRoute('auth_login', ['mode' => 'admin']);
        }

        $selectedUserId = $this->resolveAdminSelectedUserId($request, $oracleCrud, $currentAdminId);
        $animalId = (int) $request->request->get('animal_id', 0);

        try {
            $animalService->deleteRecord($id, $selectedUserId);
            $this->addFlash('success', 'Health record deleted.');
        } catch (\Throwable $e) {
            $this->addFlash('error', 'Unable to delete health record: ' . $e->getMessage());
        }

        return $this->redirectToRoute('admin_management_animals', [
            'user_id' => $selectedUserId,
            'animalId' => $animalId,
        ]);
    }

    #[Route('/admin/management/animals/types/add', name: 'admin_management_animal_type_add', methods: ['POST'])]
    public function adminAddAnimalType(Request $request, AnimalManagementService $animalService): Response
    {
        $animalService->ensureSchema();

        $currentAdminId = (int) $request->getSession()->get('auth_user_id', 0);
        if ($currentAdminId <= 0) {
            return $this->redirectToRoute('auth_login', ['mode' => 'admin']);
        }

        try {
            $animalService->addType((string) $request->request->get('value'));
            $this->addFlash('success', 'Type added.');
        } catch (\Throwable $e) {
            $this->addFlash('error', $e->getMessage());
        }

        return $this->redirectToRoute('admin_management_animals', [
            'user_id' => (int) $request->request->get('user_id', 0),
        ]);
    }

    #[Route('/admin/management/animals/types/delete', name: 'admin_management_animal_type_delete', methods: ['POST'])]
    public function adminDeleteAnimalType(Request $request, AnimalManagementService $animalService): Response
    {
        $animalService->ensureSchema();

        $currentAdminId = (int) $request->getSession()->get('auth_user_id', 0);
        if ($currentAdminId <= 0) {
            return $this->redirectToRoute('auth_login', ['mode' => 'admin']);
        }

        try {
            $animalService->deleteType((string) $request->request->get('value'));
            $this->addFlash('success', 'Type removed.');
        } catch (\Throwable $e) {
            $this->addFlash('error', $e->getMessage());
        }

        return $this->redirectToRoute('admin_management_animals', [
            'user_id' => (int) $request->request->get('user_id', 0),
        ]);
    }

    #[Route('/admin/management/animals/locations/add', name: 'admin_management_animal_location_add', methods: ['POST'])]
    public function adminAddAnimalLocation(Request $request, AnimalManagementService $animalService): Response
    {
        $animalService->ensureSchema();

        $currentAdminId = (int) $request->getSession()->get('auth_user_id', 0);
        if ($currentAdminId <= 0) {
            return $this->redirectToRoute('auth_login', ['mode' => 'admin']);
        }

        try {
            $animalService->addLocation((string) $request->request->get('value'));
            $this->addFlash('success', 'Location added.');
        } catch (\Throwable $e) {
            $this->addFlash('error', $e->getMessage());
        }

        return $this->redirectToRoute('admin_management_animals', [
            'user_id' => (int) $request->request->get('user_id', 0),
        ]);
    }

    #[Route('/admin/management/animals/locations/delete', name: 'admin_management_animal_location_delete', methods: ['POST'])]
    public function adminDeleteAnimalLocation(Request $request, AnimalManagementService $animalService): Response
    {
        $animalService->ensureSchema();

        $currentAdminId = (int) $request->getSession()->get('auth_user_id', 0);
        if ($currentAdminId <= 0) {
            return $this->redirectToRoute('auth_login', ['mode' => 'admin']);
        }

        try {
            $animalService->deleteLocation((string) $request->request->get('value'));
            $this->addFlash('success', 'Location removed.');
        } catch (\Throwable $e) {
            $this->addFlash('error', $e->getMessage());
        }

        return $this->redirectToRoute('admin_management_animals', [
            'user_id' => (int) $request->request->get('user_id', 0),
        ]);
    }

    /**
     * @return array{earTag:?string,type:?string,weight:?string,birthDate:?string,entryDate:?string,origin:?string,vaccinated:bool,location:?string}
     */
    private function buildAnimalDataFromRequest(Request $request): array
    {
        return [
            'earTag' => trim((string) $request->request->get('ear_tag')),
            'type' => trim((string) $request->request->get('type')),
            'weight' => trim((string) $request->request->get('weight')),
            'birthDate' => trim((string) $request->request->get('birth_date')),
            'entryDate' => trim((string) $request->request->get('entry_date')),
            'origin' => trim((string) $request->request->get('origin')),
            'vaccinated' => $request->request->getBoolean('vaccinated'),
            'location' => trim((string) $request->request->get('location')),
        ];
    }

    /**
     * @return array{animalId:int,recordDate:?string,weight:?string,appetite:?string,conditionStatus:?string,production:?string,notes:?string}
     */
    private function buildRecordDataFromRequest(Request $request): array
    {
        return [
            'animalId' => (int) $request->request->get('animal_id', 0),
            'recordDate' => trim((string) $request->request->get('record_date')),
            'weight' => trim((string) $request->request->get('weight')),
            'appetite' => trim((string) $request->request->get('appetite')),
            'conditionStatus' => trim((string) $request->request->get('condition_status')),
            'production' => trim((string) $request->request->get('production')),
            'notes' => trim((string) $request->request->get('notes')),
        ];
    }

    private function resolveAdminSelectedUserId(Request $request, OracleSqlPlusCrudService $oracleCrud, int $fallbackUserId): int
    {
        $selectedUserId = (int) $request->request->get('user_id', $request->query->get('user_id', 0));
        if ($selectedUserId > 0) {
            return $selectedUserId;
        }

        try {
            $users = $oracleCrud->listUsers();
        } catch (\Throwable) {
            return $fallbackUserId;
        }

        foreach ($users as $user) {
            if (!$this->isAdminRole((string) ($user['roleName'] ?? ''))) {
                return (int) ($user['id'] ?? $fallbackUserId);
            }
        }

        return (int) ($users[0]['id'] ?? $fallbackUserId);
    }

    private function renderAnimalManagementPage(Request $request, OracleSqlPlusCrudService $oracleCrud, AnimalManagementService $animalService, bool $adminMode): Response
    {
        $animalService->ensureSchema();

        $session = $request->getSession();
        $currentUserId = (int) $session->get('auth_user_id', 0);
        if ($currentUserId <= 0) {
            return $this->redirectToRoute('auth_login', ['mode' => $adminMode ? 'admin' : 'user']);
        }

        $availableUsers = [];
        $selectedUserId = $currentUserId;
        $selectedUser = null;

        if ($adminMode) {
            try {
                $availableUsers = $oracleCrud->listUsers();
            } catch (\Throwable $e) {
                $this->addFlash('error', 'Unable to load users: ' . $e->getMessage());
                $availableUsers = [];
            }

            $selectedUserId = $this->resolveAdminSelectedUserId($request, $oracleCrud, $currentUserId);
            foreach ($availableUsers as $user) {
                if ((int) ($user['id'] ?? 0) === $selectedUserId) {
                    $selectedUser = $user;
                    break;
                }
            }
        }

        $animals = $animalService->listAnimals($selectedUserId);
        $selectedAnimalId = (int) $request->query->get('animalId', $request->query->get('animal_id', 0));
        if ($selectedAnimalId <= 0 && $animals !== []) {
            $selectedAnimalId = (int) ($animals[0]['id'] ?? 0);
        }

        $selectedAnimal = $selectedAnimalId > 0 ? $animalService->findAnimal($selectedAnimalId, $selectedUserId) : null;
        if ($selectedAnimal === null && $animals !== []) {
            $selectedAnimal = $animals[0];
            $selectedAnimalId = (int) ($selectedAnimal['id'] ?? 0);
        }

        $records = $selectedAnimalId > 0 ? $animalService->listRecords($selectedAnimalId, $selectedUserId) : [];
        $animalInsights = $this->buildAnimalInsights($animals, $records);

        $editingAnimal = null;
        $editAnimalId = (int) $request->query->get('editAnimalId', 0);
        foreach ($animals as $animal) {
            if ((int) ($animal['id'] ?? 0) === $editAnimalId) {
                $editingAnimal = $animal;
                break;
            }
        }

        $editingRecord = null;
        $editRecordId = (int) $request->query->get('editRecordId', 0);
        foreach ($records as $record) {
            if ((int) ($record['id'] ?? 0) === $editRecordId) {
                $editingRecord = $record;
                break;
            }
        }

        return $this->render('management/animals.html.twig', [
            'active' => 'animals',
            'adminMode' => $adminMode,
            'availableUsers' => $availableUsers,
            'selectedUserId' => $selectedUserId,
            'selectedUser' => $selectedUser,
            'animals' => $animals,
            'selectedAnimal' => $selectedAnimal,
            'records' => $records,
            'editingAnimal' => $editingAnimal,
            'editingRecord' => $editingRecord,
            'types' => $animalService->getTypeOptions(),
            'locations' => $animalService->getLocationOptions(),
            'origins' => ['BORN_IN_FARM', 'OUTSIDE'],
            'appetites' => ['LOW', 'NORMAL', 'HIGH', 'NONE'],
            'conditions' => ['HEALTHY', 'SICK', 'INJURED', 'CRITICAL'],
            'animalCount' => $animalService->countAnimals($selectedUserId),
            'recordCount' => $animalService->countRecords($selectedUserId),
            'animalInsights' => $animalInsights,
        ]);
    }

    /**
     * @param array<int, array<string, mixed>> $equipments
     * @param array<int, array<string, mixed>> $maintenances
     * @return array{stats:array<string, mixed>,statusLegend:array<int, array<string, mixed>>,maintenanceLegend:array<int, array<string, mixed>>}
     */
    private function buildUserEquipmentInsights(array $equipments, array $maintenances): array
    {
        $statusDistribution = [];
        foreach ($equipments as $row) {
            $statusKey = trim((string) ($row['status'] ?? 'Unknown'));
            $statusDistribution[$statusKey] = ($statusDistribution[$statusKey] ?? 0) + 1;
        }

        $maintenanceTypeDistribution = [];
        $totalCost = 0.0;
        foreach ($maintenances as $row) {
            $maintenanceTypeKey = trim((string) ($row['maintenanceType'] ?? 'Unknown'));
            $maintenanceTypeDistribution[$maintenanceTypeKey] = ($maintenanceTypeDistribution[$maintenanceTypeKey] ?? 0) + 1;
            $totalCost += (float) ($row['cost'] ?? 0);
        }

        $paletteA = ['#4f9866', '#d6a74c', '#c76767', '#6c7ba8', '#7f8b62'];
        $paletteB = ['#5fb48a', '#7a9fd8', '#d39f63', '#bf7bd3', '#9f7e66'];
        $statusTotal = max(count($equipments), 1);
        $maintenanceTotal = max(count($maintenances), 1);

        $statusLegend = [];
        $idx = 0;
        foreach ($statusDistribution as $label => $value) {
            $statusLegend[] = [
                'label' => $label,
                'value' => $value,
                'percent' => round(($value / $statusTotal) * 100, 1),
                'color' => $paletteA[$idx % count($paletteA)],
            ];
            ++$idx;
        }

        $maintenanceLegend = [];
        $idx = 0;
        foreach ($maintenanceTypeDistribution as $label => $value) {
            $maintenanceLegend[] = [
                'label' => $label,
                'value' => $value,
                'percent' => round(($value / $maintenanceTotal) * 100, 1),
                'color' => $paletteB[$idx % count($paletteB)],
            ];
            ++$idx;
        }

        return [
            'stats' => [
                'equipmentCount' => count($equipments),
                'maintenanceCount' => count($maintenances),
                'readyCount' => (int) ($statusDistribution['Ready'] ?? 0),
                'serviceCount' => (int) ($statusDistribution['Service'] ?? 0),
                'offlineCount' => (int) ($statusDistribution['Offline'] ?? 0),
                'totalCost' => $totalCost,
                'averageCost' => count($maintenances) > 0 ? $totalCost / count($maintenances) : 0.0,
            ],
            'statusLegend' => $statusLegend,
            'maintenanceLegend' => $maintenanceLegend,
        ];
    }

    /**
     * @param array<int, array<string, mixed>> $animals
     * @param array<int, array<string, mixed>> $records
     * @return array{animalTypeLegend:array<int, array<string, mixed>>,conditionLegend:array<int, array<string, mixed>>,stats:array<string, mixed>}
     */
    private function buildAnimalInsights(array $animals, array $records): array
    {
        $typeDistribution = [];
        foreach ($animals as $row) {
            $key = trim((string) ($row['type'] ?? 'Unknown'));
            $typeDistribution[$key] = ($typeDistribution[$key] ?? 0) + 1;
        }

        $conditionDistribution = [];
        foreach ($records as $row) {
            $key = trim((string) ($row['conditionStatus'] ?? 'Unknown'));
            $conditionDistribution[$key] = ($conditionDistribution[$key] ?? 0) + 1;
        }

        $paletteA = ['#5ea075', '#7a8fc4', '#d29c5d', '#be6971', '#6d9cab'];
        $paletteB = ['#69b879', '#d77f66', '#f0bc5d', '#8f83d2', '#69a4c0'];
        $animalTotal = max(count($animals), 1);
        $recordTotal = max(count($records), 1);

        $animalTypeLegend = [];
        $idx = 0;
        foreach ($typeDistribution as $label => $value) {
            $animalTypeLegend[] = [
                'label' => $label,
                'value' => $value,
                'percent' => round(($value / $animalTotal) * 100, 1),
                'color' => $paletteA[$idx % count($paletteA)],
            ];
            ++$idx;
        }

        $conditionLegend = [];
        $idx = 0;
        foreach ($conditionDistribution as $label => $value) {
            $conditionLegend[] = [
                'label' => $label,
                'value' => $value,
                'percent' => round(($value / $recordTotal) * 100, 1),
                'color' => $paletteB[$idx % count($paletteB)],
            ];
            ++$idx;
        }

        return [
            'animalTypeLegend' => $animalTypeLegend,
            'conditionLegend' => $conditionLegend,
            'stats' => [
                'animalCount' => count($animals),
                'recordCount' => count($records),
                'vaccinatedCount' => count(array_filter($animals, static fn(array $row): bool => (bool) ($row['vaccinated'] ?? false))),
                'criticalCount' => (int) ($conditionDistribution['CRITICAL'] ?? 0),
            ],
        ];
    }

    private function handleWorkerSave(Request $request, WorkerManagementService $workerService, ?OracleSqlPlusCrudService $oracleCrud, bool $adminMode): Response
    {
        $ownerUserId = $this->resolveWorkersOwnerUserId($request, $oracleCrud, $adminMode);
        if ($ownerUserId <= 0) {
            return $this->redirectToRoute('auth_login', ['mode' => $adminMode ? 'admin' : 'user']);
        }

        $data = $this->workerDataFromRequest($request);
        $workerId = (int) $request->request->get('id', 0);
        $errors = $this->validateWorkerData($data);

        if ($errors !== []) {
            $this->addFlash('errors', $errors);
            return $this->redirectToRoute($adminMode ? 'admin_management_workers' : 'management_workers', $adminMode ? ['user_id' => $ownerUserId] : []);
        }

        try {
            $workerService->ensureSchema();
            if ($workerId > 0) {
                $workerService->updateWorker($workerId, $data, $ownerUserId);
                $this->addFlash('success', 'Worker updated.');
            } else {
                $workerService->createWorker($data, $ownerUserId);
                $this->addFlash('success', 'Worker created.');
            }
        } catch (\Throwable $e) {
            $this->addFlash('error', 'Worker operation failed: ' . $e->getMessage());
        }

        return $this->redirectToRoute($adminMode ? 'admin_management_workers' : 'management_workers', $adminMode ? ['user_id' => $ownerUserId] : []);
    }

    private function handleWorkerDelete(int $id, Request $request, WorkerManagementService $workerService, ?OracleSqlPlusCrudService $oracleCrud, bool $adminMode): Response
    {
        $ownerUserId = $this->resolveWorkersOwnerUserId($request, $oracleCrud, $adminMode);
        if ($ownerUserId <= 0) {
            return $this->redirectToRoute('auth_login', ['mode' => $adminMode ? 'admin' : 'user']);
        }

        try {
            $workerService->ensureSchema();
            $workerService->deleteWorker($id, $ownerUserId);
            $this->addFlash('success', 'Worker deleted.');
        } catch (\Throwable $e) {
            $this->addFlash('error', 'Unable to delete worker: ' . $e->getMessage());
        }

        return $this->redirectToRoute($adminMode ? 'admin_management_workers' : 'management_workers', $adminMode ? ['user_id' => $ownerUserId] : []);
    }

    private function handleAssignmentSave(Request $request, WorkerManagementService $workerService, ?OracleSqlPlusCrudService $oracleCrud, bool $adminMode): Response
    {
        $ownerUserId = $this->resolveWorkersOwnerUserId($request, $oracleCrud, $adminMode);
        if ($ownerUserId <= 0) {
            return $this->redirectToRoute('auth_login', ['mode' => $adminMode ? 'admin' : 'user']);
        }

        $data = $this->assignmentDataFromRequest($request);
        $assignmentId = (int) $request->request->get('id', 0);
        $errors = $this->validateAssignmentData($data);

        if ($errors !== []) {
            $this->addFlash('errors', $errors);
            return $this->redirectToRoute($adminMode ? 'admin_management_workers' : 'management_workers', $adminMode ? ['user_id' => $ownerUserId] : []);
        }

        try {
            $workerService->ensureSchema();
            if ($assignmentId > 0) {
                $workerService->updateAssignment($assignmentId, $data, $ownerUserId);
                $this->addFlash('success', 'Assignment updated.');
            } else {
                $workerService->createAssignment($data, $ownerUserId);
                $this->addFlash('success', 'Assignment created.');
            }
        } catch (\Throwable $e) {
            $this->addFlash('error', 'Assignment operation failed: ' . $e->getMessage());
        }

        return $this->redirectToRoute($adminMode ? 'admin_management_workers' : 'management_workers', $adminMode ? ['user_id' => $ownerUserId] : []);
    }

    private function handleAssignmentDelete(int $id, Request $request, WorkerManagementService $workerService, ?OracleSqlPlusCrudService $oracleCrud, bool $adminMode): Response
    {
        $ownerUserId = $this->resolveWorkersOwnerUserId($request, $oracleCrud, $adminMode);
        if ($ownerUserId <= 0) {
            return $this->redirectToRoute('auth_login', ['mode' => $adminMode ? 'admin' : 'user']);
        }

        try {
            $workerService->ensureSchema();
            $workerService->deleteAssignment($id, $ownerUserId);
            $this->addFlash('success', 'Assignment deleted.');
        } catch (\Throwable $e) {
            $this->addFlash('error', 'Unable to delete assignment: ' . $e->getMessage());
        }

        return $this->redirectToRoute($adminMode ? 'admin_management_workers' : 'management_workers', $adminMode ? ['user_id' => $ownerUserId] : []);
    }

    private function handlePaymentSave(Request $request, WorkerManagementService $workerService, ?OracleSqlPlusCrudService $oracleCrud, bool $adminMode): Response
    {
        $ownerUserId = $this->resolveWorkersOwnerUserId($request, $oracleCrud, $adminMode);
        if ($ownerUserId <= 0) {
            return $this->redirectToRoute('auth_login', ['mode' => $adminMode ? 'admin' : 'user']);
        }

        $data = $this->paymentDataFromRequest($request);
        $paymentId = (int) $request->request->get('id', 0);
        $errors = $this->validatePaymentData($data);

        if ($errors !== []) {
            $this->addFlash('errors', $errors);
            return $this->redirectToRoute($adminMode ? 'admin_management_workers' : 'management_workers', $adminMode ? ['user_id' => $ownerUserId] : []);
        }

        try {
            $workerService->ensureSchema();
            if ($paymentId > 0) {
                $workerService->updatePayment($paymentId, $data, $ownerUserId);
                $this->addFlash('success', 'Payment updated.');
            } else {
                $workerService->createPayment($data, $ownerUserId);
                $this->addFlash('success', 'Payment created.');
            }
        } catch (\Throwable $e) {
            $this->addFlash('error', 'Payment operation failed: ' . $e->getMessage());
        }

        return $this->redirectToRoute($adminMode ? 'admin_management_workers' : 'management_workers', $adminMode ? ['user_id' => $ownerUserId] : []);
    }

    private function handlePaymentDelete(int $id, Request $request, WorkerManagementService $workerService, ?OracleSqlPlusCrudService $oracleCrud, bool $adminMode): Response
    {
        $ownerUserId = $this->resolveWorkersOwnerUserId($request, $oracleCrud, $adminMode);
        if ($ownerUserId <= 0) {
            return $this->redirectToRoute('auth_login', ['mode' => $adminMode ? 'admin' : 'user']);
        }

        try {
            $workerService->ensureSchema();
            $workerService->deletePayment($id, $ownerUserId);
            $this->addFlash('success', 'Payment deleted.');
        } catch (\Throwable $e) {
            $this->addFlash('error', 'Unable to delete payment: ' . $e->getMessage());
        }

        return $this->redirectToRoute($adminMode ? 'admin_management_workers' : 'management_workers', $adminMode ? ['user_id' => $ownerUserId] : []);
    }

    private function renderWorkersManagementPage(Request $request, WorkerManagementService $workerService, ?OracleSqlPlusCrudService $oracleCrud, bool $adminMode): Response
    {
        $ownerUserId = $this->resolveWorkersOwnerUserId($request, $oracleCrud, $adminMode);
        if ($ownerUserId <= 0) {
            return $this->redirectToRoute('auth_login', ['mode' => $adminMode ? 'admin' : 'user']);
        }

        $workerService->ensureSchema();
        $workers = $workerService->listWorkers($ownerUserId);
        $assignments = $workerService->listAssignments($ownerUserId);
        $payments = $workerService->listPayments($ownerUserId);

        $editWorkerId = (int) $request->query->get('editWorkerId', 0);
        $editingWorker = $editWorkerId > 0 ? $workerService->findWorker($editWorkerId, $ownerUserId) : null;

        $editAssignmentId = (int) $request->query->get('editAssignmentId', 0);
        $editingAssignment = $editAssignmentId > 0 ? $workerService->findAssignment($editAssignmentId, $ownerUserId) : null;

        $editPaymentId = (int) $request->query->get('editPaymentId', 0);
        $editingPayment = $editPaymentId > 0 ? $workerService->findPayment($editPaymentId, $ownerUserId) : null;

        $availableUsers = [];
        if ($adminMode && $oracleCrud !== null) {
            try {
                $availableUsers = $oracleCrud->listUsers();
            } catch (\Throwable $e) {
                $this->addFlash('error', 'Unable to load users: ' . $e->getMessage());
            }
        }

        return $this->render('management/workers.html.twig', [
            'active' => 'workers',
            'adminMode' => $adminMode,
            'selectedUserId' => $ownerUserId,
            'availableUsers' => $availableUsers,
            'workers' => $workers,
            'assignments' => $assignments,
            'payments' => $payments,
            'editingWorker' => $editingWorker,
            'editingAssignment' => $editingAssignment,
            'editingPayment' => $editingPayment,
        ]);
    }

    private function resolveWorkersOwnerUserId(Request $request, ?OracleSqlPlusCrudService $oracleCrud, bool $adminMode): int
    {
        $currentUserId = (int) $request->getSession()->get('auth_user_id', 0);
        if ($currentUserId <= 0) {
            return 0;
        }

        if (!$adminMode) {
            return $currentUserId;
        }

        $selectedUserId = (int) $request->request->get('user_id', $request->query->get('user_id', 0));
        if ($selectedUserId > 0) {
            return $selectedUserId;
        }

        if ($oracleCrud === null) {
            return $currentUserId;
        }

        return $this->resolveAdminSelectedUserId($request, $oracleCrud, $currentUserId);
    }

    /**
     * @return array{lastName:?string,firstName:?string,position:?string,salary:?string,availability:?string}
     */
    private function workerDataFromRequest(Request $request): array
    {
        $lastName = trim((string) $request->request->get('last_name'));
        $firstName = trim((string) $request->request->get('first_name'));
        $position = trim((string) $request->request->get('position'));
        $salary = trim((string) $request->request->get('salary'));
        $availability = trim((string) $request->request->get('availability'));

        return [
            'lastName' => $lastName !== '' ? $lastName : null,
            'firstName' => $firstName !== '' ? $firstName : null,
            'position' => $position !== '' ? $position : null,
            'salary' => $salary !== '' ? $salary : null,
            'availability' => $availability !== '' ? $availability : 'Available',
        ];
    }

    /**
     * @return array{workerId:int,task:?string,startDate:?string,endDate:?string}
     */
    private function assignmentDataFromRequest(Request $request): array
    {
        $task = trim((string) $request->request->get('task'));
        $startDate = trim((string) $request->request->get('start_date'));
        $endDate = trim((string) $request->request->get('end_date'));

        return [
            'workerId' => (int) $request->request->get('worker_id', 0),
            'task' => $task !== '' ? $task : null,
            'startDate' => $startDate !== '' ? $startDate : null,
            'endDate' => $endDate !== '' ? $endDate : null,
        ];
    }

    /**
     * @return array{workerId:int,amount:?string,paymentDate:?string,status:?string}
     */
    private function paymentDataFromRequest(Request $request): array
    {
        $amount = trim((string) $request->request->get('amount'));
        $paymentDate = trim((string) $request->request->get('payment_date'));
        $status = trim((string) $request->request->get('status'));

        return [
            'workerId' => (int) $request->request->get('worker_id', 0),
            'amount' => $amount !== '' ? $amount : null,
            'paymentDate' => $paymentDate !== '' ? $paymentDate : null,
            'status' => $status !== '' ? $status : 'Pending',
        ];
    }

    /**
     * @param array{name:?string,type:?string,status:?string,purchaseDate:?string} $data
     * @return array<int, string>
     */
    private function validateEquipmentData(array $data): array
    {
        $errors = [];

        if (($data['name'] ?? null) === null || strlen((string) $data['name']) < 2) {
            $errors[] = 'Equipment name must be at least 2 characters.';
        }

        if (($data['type'] ?? null) === null || strlen((string) $data['type']) < 2) {
            $errors[] = 'Equipment type must be at least 2 characters.';
        }

        $status = (string) ($data['status'] ?? '');
        if (!in_array($status, ['Ready', 'Service', 'Offline'], true)) {
            $errors[] = 'Equipment status must be Ready, Service, or Offline.';
        }

        $date = (string) ($data['purchaseDate'] ?? '');
        if ($date !== '' && !preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
            $errors[] = 'Purchase date must be in YYYY-MM-DD format.';
        }

        return $errors;
    }

    /**
     * @param array{equipmentId:int,maintenanceDate:?string,maintenanceType:?string,cost:?string} $data
     * @return array<int, string>
     */
    private function validateMaintenanceData(array $data): array
    {
        $errors = [];

        if (($data['equipmentId'] ?? 0) <= 0) {
            $errors[] = 'Select a valid equipment for maintenance.';
        }

        if (($data['maintenanceType'] ?? null) === null || strlen((string) $data['maintenanceType']) < 2) {
            $errors[] = 'Maintenance type must be at least 2 characters.';
        }

        $costValue = (string) ($data['cost'] ?? '0');
        if (!is_numeric(str_replace(',', '.', $costValue)) || (float) str_replace(',', '.', $costValue) < 0) {
            $errors[] = 'Maintenance cost must be a positive number.';
        }

        $date = (string) ($data['maintenanceDate'] ?? '');
        if ($date !== '' && !preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
            $errors[] = 'Maintenance date must be in YYYY-MM-DD format.';
        }

        return $errors;
    }

    /**
     * @return array<int, string>
     */
    private function validateProfileData(string $firstName, string $lastName, string $email, string $password): array
    {
        $errors = [];
        $namePattern = '/^[a-zA-Z][a-zA-Z\s\-\']{1,59}$/';

        if (!preg_match($namePattern, $firstName)) {
            $errors[] = 'First name must be 2-60 letters and may include spaces or hyphens.';
        }

        if (!preg_match($namePattern, $lastName)) {
            $errors[] = 'Last name must be 2-60 letters and may include spaces or hyphens.';
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($email) > 180) {
            $errors[] = 'Email must be valid and under 180 characters.';
        }

        if ($password !== '' && (strlen($password) < 8 || !preg_match('/[A-Z]/', $password) || !preg_match('/[a-z]/', $password) || !preg_match('/\d/', $password) || !preg_match('/[^a-zA-Z\d]/', $password))) {
            $errors[] = 'If provided, password must be 8+ chars with upper, lower, number, and symbol.';
        }

        return $errors;
    }

    /**
     * @return array<int, string>
     */
    private function validateAdminUserData(string $firstName, string $lastName, string $email, string $status, string $roleName, string $password, bool $isCreate): array
    {
        $errors = $this->validateProfileData($firstName, $lastName, $email, $password);

        if (!in_array($status, ['Active', 'Pending', 'Suspended'], true)) {
            $errors[] = 'User status must be Active, Pending, or Suspended.';
        }

        if (!in_array(strtoupper($roleName), ['USER', 'ADMIN'], true)) {
            $errors[] = 'User role must be USER or ADMIN.';
        }

        if ($isCreate && $password === '') {
            $errors[] = 'Password is required when creating a user.';
        }

        return $errors;
    }

    /**
     * @param array{lastName:?string,firstName:?string,position:?string,salary:?string,availability:?string} $data
     * @return array<int, string>
     */
    private function validateWorkerData(array $data): array
    {
        $errors = [];
        if (($data['firstName'] ?? null) === null || strlen((string) $data['firstName']) < 2) {
            $errors[] = 'Worker first name must be at least 2 characters.';
        }
        if (($data['lastName'] ?? null) === null || strlen((string) $data['lastName']) < 2) {
            $errors[] = 'Worker last name must be at least 2 characters.';
        }
        if (($data['position'] ?? null) === null || strlen((string) $data['position']) < 2) {
            $errors[] = 'Worker position must be at least 2 characters.';
        }
        $salary = (string) ($data['salary'] ?? '0');
        if (!is_numeric(str_replace(',', '.', $salary)) || (float) str_replace(',', '.', $salary) < 0) {
            $errors[] = 'Worker salary must be a positive number.';
        }
        if (!in_array((string) ($data['availability'] ?? ''), ['Available', 'Busy', 'On leave'], true)) {
            $errors[] = 'Availability must be Available, Busy, or On leave.';
        }

        return $errors;
    }

    /**
     * @param array{workerId:int,task:?string,startDate:?string,endDate:?string} $data
     * @return array<int, string>
     */
    private function validateAssignmentData(array $data): array
    {
        $errors = [];
        if (($data['workerId'] ?? 0) <= 0) {
            $errors[] = 'Select a valid worker for assignment.';
        }
        if (($data['task'] ?? null) === null || strlen((string) $data['task']) < 2) {
            $errors[] = 'Assignment task must be at least 2 characters.';
        }

        $startDate = (string) ($data['startDate'] ?? '');
        $endDate = (string) ($data['endDate'] ?? '');
        if ($startDate !== '' && !preg_match('/^\d{4}-\d{2}-\d{2}$/', $startDate)) {
            $errors[] = 'Assignment start date must be in YYYY-MM-DD format.';
        }
        if ($endDate !== '' && !preg_match('/^\d{4}-\d{2}-\d{2}$/', $endDate)) {
            $errors[] = 'Assignment end date must be in YYYY-MM-DD format.';
        }
        if ($startDate !== '' && $endDate !== '' && $endDate < $startDate) {
            $errors[] = 'Assignment end date cannot be before start date.';
        }

        return $errors;
    }

    /**
     * @param array{workerId:int,amount:?string,paymentDate:?string,status:?string} $data
     * @return array<int, string>
     */
    private function validatePaymentData(array $data): array
    {
        $errors = [];
        if (($data['workerId'] ?? 0) <= 0) {
            $errors[] = 'Select a valid worker for payment.';
        }

        $amount = (string) ($data['amount'] ?? '0');
        if (!is_numeric(str_replace(',', '.', $amount)) || (float) str_replace(',', '.', $amount) < 0) {
            $errors[] = 'Payment amount must be a positive number.';
        }

        $paymentDate = (string) ($data['paymentDate'] ?? '');
        if ($paymentDate !== '' && !preg_match('/^\d{4}-\d{2}-\d{2}$/', $paymentDate)) {
            $errors[] = 'Payment date must be in YYYY-MM-DD format.';
        }

        if (!in_array((string) ($data['status'] ?? ''), ['Paid', 'Pending', 'Failed'], true)) {
            $errors[] = 'Payment status must be Paid, Pending, or Failed.';
        }

        return $errors;
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
