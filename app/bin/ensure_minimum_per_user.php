<?php

declare(strict_types=1);

$projectDir = dirname(__DIR__);
$dbPath = $projectDir . '/var/agrisense_dev.db';

if (!is_file($dbPath)) {
    fwrite(STDERR, "Database file not found: {$dbPath}" . PHP_EOL);
    exit(1);
}

$minimum = isset($argv[1]) ? max(1, (int) $argv[1]) : 3;

$pdo = new PDO('sqlite:' . $dbPath);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->exec('PRAGMA foreign_keys = ON');

// Ensure WORKERS table exists for environments that do not have it yet.
$pdo->exec('CREATE TABLE IF NOT EXISTS WORKERS (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    user_id INTEGER NOT NULL,
    first_name TEXT NOT NULL,
    last_name TEXT NOT NULL,
    role TEXT NOT NULL,
    salary REAL NOT NULL DEFAULT 0,
    availability TEXT NOT NULL DEFAULT "Available",
    FOREIGN KEY (user_id) REFERENCES USERS(id) ON DELETE CASCADE
)');

$users = $pdo->query('SELECT id, email FROM USERS ORDER BY id')->fetchAll(PDO::FETCH_ASSOC);

$countEquipments = $pdo->prepare('SELECT COUNT(*) FROM EQUIPMENTS WHERE user_id = :uid');
$countMaintenances = $pdo->prepare('SELECT COUNT(*) FROM MAINTENANCE WHERE user_id = :uid');
$countWorkers = $pdo->prepare('SELECT COUNT(*) FROM WORKERS WHERE user_id = :uid');

$insertEquipment = $pdo->prepare('INSERT INTO EQUIPMENTS (user_id, name, type, status, purchase_date) VALUES (:uid, :name, :type, :status, :purchase_date)');
$insertMaintenance = $pdo->prepare('INSERT INTO MAINTENANCE (user_id, equipment_id, maintenance_date, maintenance_type, cost) VALUES (:uid, :eid, :maintenance_date, :maintenance_type, :cost)');
$insertWorker = $pdo->prepare('INSERT INTO WORKERS (user_id, first_name, last_name, role, salary, availability) VALUES (:uid, :first_name, :last_name, :role, :salary, :availability)');

$equipmentByUser = $pdo->prepare('SELECT id FROM EQUIPMENTS WHERE user_id = :uid ORDER BY id');

$types = ['Tractor', 'Sprayer', 'Sensor', 'Seeder', 'Pump', 'Drone'];
$statuses = ['Ready', 'Service', 'Offline'];
$maintTypes = ['Inspection', 'Repair', 'Calibration', 'Oil Change', 'Safety Check'];
$workerRoles = ['Field Lead', 'Technician', 'Irrigation', 'Operator', 'Supervisor'];
$availabilities = ['Available', 'Busy', 'On leave'];

$added = [
    'equipments' => 0,
    'maintenances' => 0,
    'workers' => 0,
];

foreach ($users as $user) {
    $uid = (int) ($user['id'] ?? 0);
    if ($uid <= 0) {
        continue;
    }

    $countEquipments->execute([':uid' => $uid]);
    $eqCount = (int) $countEquipments->fetchColumn();

    while ($eqCount < $minimum) {
        $index = $eqCount + 1;
        $insertEquipment->execute([
            ':uid' => $uid,
            ':name' => sprintf('Equipment U%d-%d', $uid, $index),
            ':type' => $types[($uid + $index) % count($types)],
            ':status' => $statuses[($uid + $index) % count($statuses)],
            ':purchase_date' => sprintf('2026-03-%02d', (($uid + $index) % 27) + 1),
        ]);
        $eqCount++;
        $added['equipments']++;
    }

    $countWorkers->execute([':uid' => $uid]);
    $workerCount = (int) $countWorkers->fetchColumn();

    while ($workerCount < $minimum) {
        $index = $workerCount + 1;
        $insertWorker->execute([
            ':uid' => $uid,
            ':first_name' => sprintf('Worker%d', $index),
            ':last_name' => sprintf('User%d', $uid),
            ':role' => $workerRoles[($uid + $index) % count($workerRoles)],
            ':salary' => 850 + (($uid + $index) * 17),
            ':availability' => $availabilities[($uid + $index) % count($availabilities)],
        ]);
        $workerCount++;
        $added['workers']++;
    }

    $countMaintenances->execute([':uid' => $uid]);
    $mntCount = (int) $countMaintenances->fetchColumn();

    $equipmentByUser->execute([':uid' => $uid]);
    $equipmentIds = array_map(static fn(array $r): int => (int) $r['id'], $equipmentByUser->fetchAll(PDO::FETCH_ASSOC));

    if ($equipmentIds === []) {
        continue;
    }

    while ($mntCount < $minimum) {
        $index = $mntCount + 1;
        $equipmentId = $equipmentIds[($index - 1) % count($equipmentIds)];
        $insertMaintenance->execute([
            ':uid' => $uid,
            ':eid' => $equipmentId,
            ':maintenance_date' => sprintf('2026-04-%02d', (($uid + $index) % 27) + 1),
            ':maintenance_type' => $maintTypes[($uid + $index) % count($maintTypes)],
            ':cost' => 120 + (($uid + $index) * 9.5),
        ]);
        $mntCount++;
        $added['maintenances']++;
    }
}

echo sprintf(
    'Done. Added equipments=%d, maintenances=%d, workers=%d (minimum=%d)%s',
    $added['equipments'],
    $added['maintenances'],
    $added['workers'],
    $minimum,
    PHP_EOL
);
