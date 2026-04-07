<?php

namespace App\Controller;

use App\Service\OracleSqlPlusCrudService;
use App\Service\PdoCrudService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class HomeController extends AbstractController
{
    #[Route('/home', name: 'home')]
    public function index(Request $request): Response
    {
        $session = $request->getSession();
        $authTransition = (bool) $session->get('auth_transition', false);
        $session->remove('auth_transition');

        return $this->render('home/index.html.twig', [
            'authTransition' => $authTransition,
        ]);
    }

    #[Route('/admin/home', name: 'admin_home')]
    public function admin(Request $request, OracleSqlPlusCrudService $oracleCrud): Response
    {
        $session = $request->getSession();
        $authTransition = (bool) $session->get('auth_transition', false);
        $session->remove('auth_transition');

        try {
            $equipments = $crudService->listEquipments();
            $maintenances = $crudService->listMaintenances();
        } catch (\Throwable) {
            $equipments = [];
            $maintenances = [];
        }

        $statusCounts = [
            'Ready' => 0,
            'Service' => 0,
            'Offline' => 0,
        ];
        $typeCounts = [];

        foreach ($equipments as $equipment) {
            $status = (string) ($equipment['status'] ?? 'Offline');
            if (!array_key_exists($status, $statusCounts)) {
                $statusCounts[$status] = 0;
            }
            $statusCounts[$status]++;

            $type = trim((string) ($equipment['type'] ?? 'Unknown'));
            if ($type === '') {
                $type = 'Unknown';
            }
            $typeCounts[$type] = ($typeCounts[$type] ?? 0) + 1;
        }

        arsort($typeCounts);
        $topTypes = array_slice($typeCounts, 0, 6, true);

        $maintenanceTypeCounts = [];
        $monthlyCostMap = [];
        $totalMaintenanceCost = 0.0;

        foreach ($maintenances as $maintenance) {
            $maintenanceType = trim((string) ($maintenance['maintenanceType'] ?? 'Unknown'));
            if ($maintenanceType === '') {
                $maintenanceType = 'Unknown';
            }
            $maintenanceTypeCounts[$maintenanceType] = ($maintenanceTypeCounts[$maintenanceType] ?? 0) + 1;

            $cost = (float) ((string) ($maintenance['cost'] ?? '0'));
            $totalMaintenanceCost += $cost;

            $maintenanceDate = $maintenance['maintenanceDate'] ?? null;
            if ($maintenanceDate instanceof \DateTimeInterface) {
                $monthKey = $maintenanceDate->format('Y-m');
                $monthlyCostMap[$monthKey] = ($monthlyCostMap[$monthKey] ?? 0.0) + $cost;
            }
        }

        ksort($monthlyCostMap);
        $monthlyCostMap = array_slice($monthlyCostMap, -6, null, true);
        $costLabels = array_keys($monthlyCostMap);
        $costValues = array_values($monthlyCostMap);

        arsort($maintenanceTypeCounts);
        $topMaintenanceTypes = array_slice($maintenanceTypeCounts, 0, 6, true);

        $readyRate = count($equipments) > 0
            ? round(($statusCounts['Ready'] / count($equipments)) * 100, 1)
            : 0.0;

        return $this->render('admin/home.html.twig', [
            'active' => 'home',
            'authTransition' => $authTransition,
            'kpis' => [
                'totalEquipments' => count($equipments),
                'totalMaintenances' => count($maintenances),
                'readyRate' => $readyRate,
                'avgMaintenanceCost' => count($maintenances) > 0 ? $totalMaintenanceCost / count($maintenances) : 0,
                'totalMaintenanceCost' => $totalMaintenanceCost,
            ],
            'statusCounts' => $statusCounts,
            'topTypes' => $topTypes,
            'topMaintenanceTypes' => $topMaintenanceTypes,
            'costLabels' => $costLabels,
            'costValues' => $costValues,
        ]);
    }
}
