<?php

declare(strict_types=1);

$projectDir = dirname(__DIR__);
$dbPath = $projectDir . '/var/agrisense_dev.db';

if (!is_file($dbPath)) {
    fwrite(STDERR, "Database file not found: {$dbPath}" . PHP_EOL);
    exit(1);
}

$outputDir = $argv[1] ?? null;
if ($outputDir === null || trim($outputDir) === '') {
    fwrite(STDERR, "Usage: php bin/export_equipment_maintenance.php <output-dir>" . PHP_EOL);
    exit(1);
}

$outputDir = rtrim($outputDir, "\\/");
if (!is_dir($outputDir) && !mkdir($outputDir, 0777, true) && !is_dir($outputDir)) {
    fwrite(STDERR, "Unable to create output directory: {$outputDir}" . PHP_EOL);
    exit(1);
}

$pdo = new PDO('sqlite:' . $dbPath);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$tables = ['EQUIPMENTS', 'MAINTENANCE'];

foreach ($tables as $table) {
    $stmt = $pdo->query("SELECT * FROM {$table} ORDER BY id");
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $csvPath = $outputDir . DIRECTORY_SEPARATOR . strtolower($table) . '.csv';
    $fp = fopen($csvPath, 'wb');
    if ($fp === false) {
        fwrite(STDERR, "Unable to write CSV file: {$csvPath}" . PHP_EOL);
        exit(1);
    }

    if ($rows !== []) {
        fputcsv($fp, array_keys($rows[0]));
        foreach ($rows as $row) {
            fputcsv($fp, array_values($row));
        }
    }
    fclose($fp);
}

$sqlPath = $outputDir . DIRECTORY_SEPARATOR . 'equipment_maintenance_dump.sql';
$sql = "-- Export generated on " . date('Y-m-d H:i:s') . PHP_EOL . PHP_EOL;

foreach ($tables as $table) {
    $stmt = $pdo->query("SELECT * FROM {$table} ORDER BY id");
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $sql .= "-- Table: {$table}" . PHP_EOL;
    if ($rows === []) {
        $sql .= "-- No rows" . PHP_EOL . PHP_EOL;
        continue;
    }

    foreach ($rows as $row) {
        $columns = array_keys($row);
        $escapedColumns = implode(', ', array_map(static fn(string $c): string => '"' . $c . '"', $columns));
        $values = implode(', ', array_map(static function ($v) use ($pdo): string {
            if ($v === null) {
                return 'NULL';
            }

            return $pdo->quote((string) $v);
        }, array_values($row)));

        $sql .= sprintf('INSERT INTO %s (%s) VALUES (%s);', $table, $escapedColumns, $values) . PHP_EOL;
    }

    $sql .= PHP_EOL;
}

if (file_put_contents($sqlPath, $sql) === false) {
    fwrite(STDERR, "Unable to write SQL dump: {$sqlPath}" . PHP_EOL);
    exit(1);
}

echo "Export complete:" . PHP_EOL;
echo "- {$outputDir}" . DIRECTORY_SEPARATOR . "equipments.csv" . PHP_EOL;
echo "- {$outputDir}" . DIRECTORY_SEPARATOR . "maintenance.csv" . PHP_EOL;
echo "- {$outputDir}" . DIRECTORY_SEPARATOR . "equipment_maintenance_dump.sql" . PHP_EOL;
