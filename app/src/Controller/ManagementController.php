<?php

namespace App\Controller;

use App\Entity\Equipment;
use App\Entity\Maintenance;
use App\Repository\EquipmentRepository;
use App\Repository\MaintenanceRepository;
use Doctrine\ORM\EntityManagerInterface;
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
    public function equipments(Request $request, EquipmentRepository $equipmentRepository, MaintenanceRepository $maintenanceRepository, EntityManagerInterface $entityManager): Response
    {
        $this->configureOracleSession($entityManager);
        $equipment = new Equipment();
        $maintenance = new Maintenance();

        if ($request->isMethod('POST')) {
            $formType = (string) $request->request->get('form_type', 'equipment');

            if ($formType === 'maintenance') {
                $this->hydrateMaintenanceFromRequest($maintenance, $request, $equipmentRepository);
                $entityManager->persist($maintenance);
                $entityManager->flush();
            } else {
                $this->hydrateEquipmentFromRequest($equipment, $request);
                $entityManager->persist($equipment);
                $entityManager->flush();
            }

            return $this->redirectToRoute('management_equipments');
        }

        $equipments = $equipmentRepository->findBy([], ['id' => 'DESC']);
        $maintenances = $maintenanceRepository->findBy([], ['id' => 'DESC']);

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
    public function editEquipment(int $id, Request $request, EquipmentRepository $equipmentRepository, MaintenanceRepository $maintenanceRepository, EntityManagerInterface $entityManager): Response
    {
        $this->configureOracleSession($entityManager);
        $equipment = $equipmentRepository->find($id);

        if (!$equipment) {
            throw $this->createNotFoundException('Equipment not found.');
        }

        if ($request->isMethod('POST')) {
            $this->hydrateEquipmentFromRequest($equipment, $request);
            $entityManager->flush();

            return $this->redirectToRoute('management_equipments');
        }

        $equipments = $equipmentRepository->findBy([], ['id' => 'DESC']);
        $maintenance = new Maintenance();
        $maintenances = $maintenanceRepository->findBy([], ['id' => 'DESC']);

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
    public function deleteEquipment(int $id, EquipmentRepository $equipmentRepository, EntityManagerInterface $entityManager): Response
    {
        $equipment = $equipmentRepository->find($id);

        if ($equipment) {
            $entityManager->remove($equipment);
            $entityManager->flush();
        }

        return $this->redirectToRoute('management_equipments');
    }

    #[Route('/management/equipments/maintenance/{id}/edit', name: 'management_maintenance_edit', methods: ['GET', 'POST'])]
    public function editMaintenance(int $id, Request $request, MaintenanceRepository $maintenanceRepository, EquipmentRepository $equipmentRepository, EntityManagerInterface $entityManager): Response
    {
        $this->configureOracleSession($entityManager);
        $maintenance = $maintenanceRepository->find($id);

        if (!$maintenance) {
            throw $this->createNotFoundException('Maintenance not found.');
        }

        if ($request->isMethod('POST')) {
            $this->hydrateMaintenanceFromRequest($maintenance, $request, $equipmentRepository);
            $entityManager->flush();

            return $this->redirectToRoute('management_equipments');
        }

        $equipments = $equipmentRepository->findBy([], ['id' => 'DESC']);
        $maintenances = $maintenanceRepository->findBy([], ['id' => 'DESC']);
        $equipment = new Equipment();

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
    public function deleteMaintenance(int $id, MaintenanceRepository $maintenanceRepository, EntityManagerInterface $entityManager): Response
    {
        $maintenance = $maintenanceRepository->find($id);

        if ($maintenance) {
            $entityManager->remove($maintenance);
            $entityManager->flush();
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

    private function hydrateEquipmentFromRequest(Equipment $equipment, Request $request): void
    {
        $name = trim((string) $request->request->get('name'));
        $type = trim((string) $request->request->get('type'));
        $status = trim((string) $request->request->get('status'));
        $purchaseDate = $request->request->get('purchase_date');

        $equipment->setName($name !== '' ? $name : null);
        $equipment->setType($type !== '' ? $type : null);
        $equipment->setStatus($status !== '' ? $status : 'Ready');

        $date = null;
        if (is_string($purchaseDate) && $purchaseDate !== '') {
            $date = \DateTime::createFromFormat('Y-m-d', $purchaseDate) ?: null;
        }

        $equipment->setPurchaseDate($date);
    }

    private function hydrateMaintenanceFromRequest(Maintenance $maintenance, Request $request, EquipmentRepository $equipmentRepository): void
    {
        $equipmentId = $request->request->get('equipment_id');
        $maintenanceDate = $request->request->get('maintenance_date');
        $maintenanceType = trim((string) $request->request->get('maintenance_type'));
        $cost = trim((string) $request->request->get('cost'));

        $equipment = null;
        if (is_string($equipmentId) && $equipmentId !== '') {
            $equipment = $equipmentRepository->find((int) $equipmentId);
        }

        if (!$equipment) {
            throw $this->createNotFoundException('Equipment not found for maintenance.');
        }

        $date = null;
        if (is_string($maintenanceDate) && $maintenanceDate !== '') {
            $date = \DateTime::createFromFormat('Y-m-d', $maintenanceDate) ?: null;
        }

        $maintenance->setEquipment($equipment);
        $maintenance->setMaintenanceDate($date);
        $maintenance->setMaintenanceType($maintenanceType !== '' ? $maintenanceType : 'Inspection');
        $maintenance->setCost($cost !== '' ? $cost : '0');
    }

    private function configureOracleSession(EntityManagerInterface $entityManager): void
    {
        $sql = "ALTER SESSION SET NLS_DATE_FORMAT = 'YYYY-MM-DD HH24:MI:SS' NLS_TIMESTAMP_FORMAT = 'YYYY-MM-DD HH24:MI:SS'";
        $entityManager->getConnection()->executeStatement($sql);
    }
}
