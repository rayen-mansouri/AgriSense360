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

    #[Route('/management/equipments', name: 'management_equipments')]
    public function equipments(Request $request, OracleSqlPlusCrudService $oracleCrud): Response
    {
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
                    $oracleCrud->createMaintenance($this->maintenanceDataFromRequest($request));
                } else {
                    $oracleCrud->createEquipment($this->equipmentDataFromRequest($request));
                }
            } catch (\Throwable $e) {
                $this->addFlash('error', 'Unable to save data: ' . $e->getMessage());
            }

            return $this->redirectToRoute('management_equipments');
        }

        $equipments = $oracleCrud->listEquipments();
        $maintenances = $oracleCrud->listMaintenances();

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
        $equipment = $oracleCrud->findEquipment($id);

        if (!$equipment) {
            throw $this->createNotFoundException('Equipment not found.');
        }

        if ($request->isMethod('POST')) {
            try {
                $oracleCrud->updateEquipment($id, $this->equipmentDataFromRequest($request));
            } catch (\Throwable $e) {
                $this->addFlash('error', 'Unable to update equipment: ' . $e->getMessage());
            }

            return $this->redirectToRoute('management_equipments');
        }

        $equipments = $oracleCrud->listEquipments();
        $maintenance = [
            'equipment' => null,
            'maintenanceDate' => null,
            'maintenanceType' => null,
            'cost' => null,
        ];
        $maintenances = $oracleCrud->listMaintenances();

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
        if (!$this->isCsrfTokenValid('delete_equipment_' . $id, (string) $request->request->get('_token'))) {
            throw $this->createAccessDeniedException('Invalid CSRF token.');
        }

        try {
            $oracleCrud->deleteEquipment($id);
        } catch (\Throwable $e) {
            $this->addFlash('error', 'Unable to delete equipment: ' . $e->getMessage());
        }

        return $this->redirectToRoute('management_equipments');
    }

    #[Route('/management/equipments/maintenance/{id}/edit', name: 'management_maintenance_edit', methods: ['GET', 'POST'])]
    public function editMaintenance(int $id, Request $request, OracleSqlPlusCrudService $oracleCrud): Response
    {
        $maintenance = $oracleCrud->findMaintenance($id);

        if (!$maintenance) {
            throw $this->createNotFoundException('Maintenance not found.');
        }

        if ($request->isMethod('POST')) {
            try {
                $oracleCrud->updateMaintenance($id, $this->maintenanceDataFromRequest($request));
            } catch (\Throwable $e) {
                $this->addFlash('error', 'Unable to update maintenance: ' . $e->getMessage());
            }

            return $this->redirectToRoute('management_equipments');
        }

        $equipments = $oracleCrud->listEquipments();
        $maintenances = $oracleCrud->listMaintenances();
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
        if (!$this->isCsrfTokenValid('delete_maintenance_' . $id, (string) $request->request->get('_token'))) {
            throw $this->createAccessDeniedException('Invalid CSRF token.');
        }

        try {
            $oracleCrud->deleteMaintenance($id);
        } catch (\Throwable $e) {
            $this->addFlash('error', 'Unable to delete maintenance: ' . $e->getMessage());
        }

        return $this->redirectToRoute('management_equipments');
    }

    #[Route('/management/stock', name: 'management_stock')]
    public function stock(): Response
    {
        return $this->render('management/stock.html.twig', [
            'active' => 'stock',
        ]);
    }

    #[Route('/management/culture', name: 'management_culture')]
    public function culture(): Response
    {
        return $this->render('management/culture.html.twig', [
            'active' => 'culture',
        ]);
    }

    #[Route('/management/users', name: 'management_users')]
    public function users(): Response
    {
        return $this->render('management/users.html.twig', [
            'active' => 'users',
        ]);
    }

    #[Route('/management/workers', name: 'management_workers')]
    public function workers(): Response
    {
        return $this->render('management/workers.html.twig', [
            'active' => 'workers',
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
}
