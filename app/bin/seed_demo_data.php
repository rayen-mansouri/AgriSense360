<?php

declare(strict_types=1);

$dbPath = __DIR__ . '/../var/agrisense_dev.db';

if (!is_file($dbPath)) {
    fwrite(STDERR, "Database file not found: {$dbPath}" . PHP_EOL);
    exit(1);
}

$pdo = new PDO('sqlite:' . $dbPath);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$pdo->exec('PRAGMA foreign_keys = ON');

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

$pdo->exec('CREATE TABLE IF NOT EXISTS WORKER_ASSIGNMENTS (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    user_id INTEGER NOT NULL,
    worker_id INTEGER NOT NULL,
    task_name TEXT NOT NULL,
    start_date TEXT,
    end_date TEXT,
    FOREIGN KEY (user_id) REFERENCES USERS(id) ON DELETE CASCADE,
    FOREIGN KEY (worker_id) REFERENCES WORKERS(id) ON DELETE CASCADE
)');

$pdo->exec('CREATE TABLE IF NOT EXISTS WORKER_PAYMENTS (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    user_id INTEGER NOT NULL,
    worker_id INTEGER NOT NULL,
    amount REAL NOT NULL DEFAULT 0,
    payment_date TEXT,
    payment_status TEXT NOT NULL DEFAULT "Pending",
    FOREIGN KEY (user_id) REFERENCES USERS(id) ON DELETE CASCADE,
    FOREIGN KEY (worker_id) REFERENCES WORKERS(id) ON DELETE CASCADE
)');

$users = [
    [
        'first_name' => 'Lina',
        'last_name' => 'Green',
        'email' => 'lina.green@agrisense.local',
        'password' => 'User123!',
        'role' => 'USER',
    ],
    [
        'first_name' => 'Youssef',
        'last_name' => 'Benz',
        'email' => 'youssef.benz@agrisense.local',
        'password' => 'Grow123!',
        'role' => 'USER',
    ],
    [
        'first_name' => 'Nour',
        'last_name' => 'Rami',
        'email' => 'nour.rami@agrisense.local',
        'password' => 'Farm123!',
        'role' => 'USER',
    ],
    [
        'first_name' => 'Sara',
        'last_name' => 'Control',
        'email' => 'sara.control@agrisense.local',
        'password' => 'Admin123!',
        'role' => 'ADMIN',
    ],
];

$insertUser = $pdo->prepare('INSERT OR IGNORE INTO USERS (last_name, first_name, email, password_hash, status, role_name, created_at) VALUES (:last_name, :first_name, :email, :password_hash, :status, :role_name, :created_at)');
$findUserId = $pdo->prepare('SELECT id FROM USERS WHERE LOWER(email) = LOWER(:email) LIMIT 1');

$userIds = [];
foreach ($users as $user) {
    $insertUser->execute([
        ':last_name' => $user['last_name'],
        ':first_name' => $user['first_name'],
        ':email' => $user['email'],
        ':password_hash' => password_hash($user['password'], PASSWORD_BCRYPT),
        ':status' => 'Active',
        ':role_name' => $user['role'],
        ':created_at' => '2026-04-06',
    ]);

    $findUserId->execute([':email' => $user['email']]);
    $userId = (int) $findUserId->fetchColumn();
    if ($userId > 0) {
        $userIds[$user['email']] = $userId;
    }
}

$equipmentRows = [
    ['lina.green@agrisense.local', 'Field Tractor X1', 'Tractor', 'Ready', '2025-11-14'],
    ['lina.green@agrisense.local', 'Precision Sprayer S2', 'Sprayer', 'Service', '2026-01-22'],
    ['youssef.benz@agrisense.local', 'Irrigation Pump P9', 'Pump', 'Ready', '2025-08-03'],
    ['youssef.benz@agrisense.local', 'Harvest Drone D4', 'Drone', 'Offline', '2024-12-18'],
    ['nour.rami@agrisense.local', 'Seeder Unit U7', 'Seeder', 'Ready', '2026-02-10'],
    ['nour.rami@agrisense.local', 'Climate Sensor C3', 'Sensor', 'Service', '2025-10-27'],
];

$insertEquipment = $pdo->prepare('INSERT OR IGNORE INTO EQUIPMENTS (user_id, name, type, status, purchase_date) VALUES (:user_id, :name, :type, :status, :purchase_date)');
$findEquipmentByUniqueFields = $pdo->prepare('SELECT id FROM EQUIPMENTS WHERE user_id = :user_id AND name = :name AND type = :type AND status = :status AND COALESCE(purchase_date, "") = COALESCE(:purchase_date, "") LIMIT 1');
foreach ($equipmentRows as [$email, $name, $type, $status, $purchaseDate]) {
    $userId = $userIds[$email] ?? 0;
    if ($userId <= 0) {
        continue;
    }

    $findEquipmentByUniqueFields->execute([
        ':user_id' => $userId,
        ':name' => $name,
        ':type' => $type,
        ':status' => $status,
        ':purchase_date' => $purchaseDate,
    ]);

    if ($findEquipmentByUniqueFields->fetchColumn() !== false) {
        continue;
    }

    $insertEquipment->execute([
        ':user_id' => $userId,
        ':name' => $name,
        ':type' => $type,
        ':status' => $status,
        ':purchase_date' => $purchaseDate,
    ]);
}

$findEquipmentId = $pdo->prepare('SELECT id, user_id FROM EQUIPMENTS WHERE user_id = :user_id AND name = :name LIMIT 1');
$insertMaintenance = $pdo->prepare('INSERT OR IGNORE INTO MAINTENANCE (user_id, equipment_id, maintenance_date, maintenance_type, cost) VALUES (:user_id, :equipment_id, :maintenance_date, :maintenance_type, :cost)');
$findMaintenanceByUniqueFields = $pdo->prepare('SELECT id FROM MAINTENANCE WHERE user_id = :user_id AND equipment_id = :equipment_id AND maintenance_date = :maintenance_date AND maintenance_type = :maintenance_type AND cost = :cost LIMIT 1');

$maintenanceRows = [
    ['lina.green@agrisense.local', 'Field Tractor X1', '2026-03-12', 'Inspection', 210.50],
    ['youssef.benz@agrisense.local', 'Harvest Drone D4', '2026-03-28', 'Calibration', 145.00],
    ['nour.rami@agrisense.local', 'Climate Sensor C3', '2026-04-01', 'Repair', 389.99],
];

foreach ($maintenanceRows as [$email, $equipmentName, $date, $type, $cost]) {
    $userId = $userIds[$email] ?? 0;
    if ($userId <= 0) {
        continue;
    }

    $findEquipmentId->execute([':user_id' => $userId, ':name' => $equipmentName]);
    $equipment = $findEquipmentId->fetch(PDO::FETCH_ASSOC);
    if (!$equipment) {
        continue;
    }

    $findMaintenanceByUniqueFields->execute([
        ':user_id' => (int) $equipment['user_id'],
        ':equipment_id' => (int) $equipment['id'],
        ':maintenance_date' => $date,
        ':maintenance_type' => $type,
        ':cost' => $cost,
    ]);

    if ($findMaintenanceByUniqueFields->fetchColumn() !== false) {
        continue;
    }

    $insertMaintenance->execute([
        ':user_id' => (int) $equipment['user_id'],
        ':equipment_id' => (int) $equipment['id'],
        ':maintenance_date' => $date,
        ':maintenance_type' => $type,
        ':cost' => $cost,
    ]);
}

$workersRows = [
    ['lina.green@agrisense.local', 'Rim', 'Ben Ali', 'Field Lead', 1200.00, 'Available'],
    ['lina.green@agrisense.local', 'Sami', 'Kefi', 'Tractor Operator', 980.00, 'Busy'],
    ['youssef.benz@agrisense.local', 'Omar', 'Jradi', 'Irrigation', 920.00, 'Available'],
    ['youssef.benz@agrisense.local', 'Maha', 'Sassi', 'Drone Operator', 1100.00, 'On leave'],
    ['nour.rami@agrisense.local', 'Amine', 'Gharbi', 'Seeder Specialist', 1040.00, 'Available'],
    ['nour.rami@agrisense.local', 'Aya', 'Trabelsi', 'Sensor Technician', 1150.00, 'Busy'],
];

$insertWorker = $pdo->prepare('INSERT OR IGNORE INTO WORKERS (user_id, first_name, last_name, role, salary, availability) VALUES (:user_id, :first_name, :last_name, :role, :salary, :availability)');
$findWorkerId = $pdo->prepare('SELECT id, user_id FROM WORKERS WHERE user_id = :user_id AND first_name = :first_name AND last_name = :last_name LIMIT 1');
$findWorkerByUniqueFields = $pdo->prepare('SELECT id FROM WORKERS WHERE user_id = :user_id AND first_name = :first_name AND last_name = :last_name AND role = :role AND salary = :salary AND availability = :availability LIMIT 1');

foreach ($workersRows as [$email, $firstName, $lastName, $role, $salary, $availability]) {
    $userId = $userIds[$email] ?? 0;
    if ($userId <= 0) {
        continue;
    }

    $findWorkerByUniqueFields->execute([
        ':user_id' => $userId,
        ':first_name' => $firstName,
        ':last_name' => $lastName,
        ':role' => $role,
        ':salary' => $salary,
        ':availability' => $availability,
    ]);

    if ($findWorkerByUniqueFields->fetchColumn() !== false) {
        continue;
    }

    $insertWorker->execute([
        ':user_id' => $userId,
        ':first_name' => $firstName,
        ':last_name' => $lastName,
        ':role' => $role,
        ':salary' => $salary,
        ':availability' => $availability,
    ]);
}

$assignmentRows = [
    ['lina.green@agrisense.local', 'Rim', 'Ben Ali', 'Soil prep', '2026-02-01', '2026-02-08'],
    ['youssef.benz@agrisense.local', 'Omar', 'Jradi', 'Irrigation rotation', '2026-03-11', '2026-03-19'],
    ['nour.rami@agrisense.local', 'Aya', 'Trabelsi', 'Sensor audit', '2026-03-20', '2026-03-27'],
];

$insertAssignment = $pdo->prepare('INSERT OR IGNORE INTO WORKER_ASSIGNMENTS (user_id, worker_id, task_name, start_date, end_date) VALUES (:user_id, :worker_id, :task_name, :start_date, :end_date)');
$findAssignmentByUniqueFields = $pdo->prepare('SELECT id FROM WORKER_ASSIGNMENTS WHERE user_id = :user_id AND worker_id = :worker_id AND task_name = :task_name AND COALESCE(start_date, "") = COALESCE(:start_date, "") AND COALESCE(end_date, "") = COALESCE(:end_date, "") LIMIT 1');

foreach ($assignmentRows as [$email, $firstName, $lastName, $taskName, $startDate, $endDate]) {
    $userId = $userIds[$email] ?? 0;
    if ($userId <= 0) {
        continue;
    }

    $findWorkerId->execute([
        ':user_id' => $userId,
        ':first_name' => $firstName,
        ':last_name' => $lastName,
    ]);

    $worker = $findWorkerId->fetch(PDO::FETCH_ASSOC);
    if (!$worker) {
        continue;
    }

    $findAssignmentByUniqueFields->execute([
        ':user_id' => (int) $worker['user_id'],
        ':worker_id' => (int) $worker['id'],
        ':task_name' => $taskName,
        ':start_date' => $startDate,
        ':end_date' => $endDate,
    ]);

    if ($findAssignmentByUniqueFields->fetchColumn() !== false) {
        continue;
    }

    $insertAssignment->execute([
        ':user_id' => (int) $worker['user_id'],
        ':worker_id' => (int) $worker['id'],
        ':task_name' => $taskName,
        ':start_date' => $startDate,
        ':end_date' => $endDate,
    ]);
}

$paymentRows = [
    ['lina.green@agrisense.local', 'Rim', 'Ben Ali', 420.00, '2026-01-28', 'Paid'],
    ['youssef.benz@agrisense.local', 'Maha', 'Sassi', 380.00, '2026-02-05', 'Pending'],
    ['nour.rami@agrisense.local', 'Amine', 'Gharbi', 460.00, '2026-03-02', 'Paid'],
];

$insertPayment = $pdo->prepare('INSERT OR IGNORE INTO WORKER_PAYMENTS (user_id, worker_id, amount, payment_date, payment_status) VALUES (:user_id, :worker_id, :amount, :payment_date, :payment_status)');
$findPaymentByUniqueFields = $pdo->prepare('SELECT id FROM WORKER_PAYMENTS WHERE user_id = :user_id AND worker_id = :worker_id AND amount = :amount AND COALESCE(payment_date, "") = COALESCE(:payment_date, "") AND payment_status = :payment_status LIMIT 1');

foreach ($paymentRows as [$email, $firstName, $lastName, $amount, $paymentDate, $paymentStatus]) {
    $userId = $userIds[$email] ?? 0;
    if ($userId <= 0) {
        continue;
    }

    $findWorkerId->execute([
        ':user_id' => $userId,
        ':first_name' => $firstName,
        ':last_name' => $lastName,
    ]);

    $worker = $findWorkerId->fetch(PDO::FETCH_ASSOC);
    if (!$worker) {
        continue;
    }

    $findPaymentByUniqueFields->execute([
        ':user_id' => (int) $worker['user_id'],
        ':worker_id' => (int) $worker['id'],
        ':amount' => $amount,
        ':payment_date' => $paymentDate,
        ':payment_status' => $paymentStatus,
    ]);

    if ($findPaymentByUniqueFields->fetchColumn() !== false) {
        continue;
    }

    $insertPayment->execute([
        ':user_id' => (int) $worker['user_id'],
        ':worker_id' => (int) $worker['id'],
        ':amount' => $amount,
        ':payment_date' => $paymentDate,
        ':payment_status' => $paymentStatus,
    ]);
}

echo 'Demo seed completed.' . PHP_EOL;
echo 'Users (agrisense.local):' . PHP_EOL;
foreach ($pdo->query("SELECT id, first_name, last_name, email, role_name FROM USERS WHERE email LIKE '%@agrisense.local' ORDER BY id") as $row) {
    echo sprintf("- #%d %s %s <%s> [%s]", $row['id'], $row['first_name'], $row['last_name'], $row['email'], $row['role_name']) . PHP_EOL;
}

echo PHP_EOL . 'Equipment counts:' . PHP_EOL;
foreach ($pdo->query("SELECT u.email, COUNT(e.id) AS equipment_count FROM USERS u LEFT JOIN EQUIPMENTS e ON e.user_id=u.id WHERE u.email LIKE '%@agrisense.local' GROUP BY u.id, u.email ORDER BY u.id") as $row) {
    echo sprintf('- %s: %d', $row['email'], $row['equipment_count']) . PHP_EOL;
}

echo PHP_EOL . 'Workers counts:' . PHP_EOL;
foreach ($pdo->query("SELECT u.email, COUNT(w.id) AS workers_count FROM USERS u LEFT JOIN WORKERS w ON w.user_id=u.id WHERE u.email LIKE '%@agrisense.local' GROUP BY u.id, u.email ORDER BY u.id") as $row) {
    echo sprintf('- %s: %d', $row['email'], $row['workers_count']) . PHP_EOL;
}
