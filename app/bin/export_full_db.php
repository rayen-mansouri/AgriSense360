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
    fwrite(STDERR, "Usage: php bin/export_full_db.php <output-dir>" . PHP_EOL);
    exit(1);
}

$outputDir = rtrim($outputDir, "\\/");
if (!is_dir($outputDir) && !mkdir($outputDir, 0777, true) && !is_dir($outputDir)) {
    fwrite(STDERR, "Unable to create output directory: {$outputDir}" . PHP_EOL);
    exit(1);
}

$dbCopyPath = $outputDir . DIRECTORY_SEPARATOR . 'db_export.db';
if (!copy($dbPath, $dbCopyPath)) {
    fwrite(STDERR, "Unable to copy database file to: {$dbCopyPath}" . PHP_EOL);
    exit(1);
}

$pdo = new PDO('sqlite:' . $dbPath);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$tablesStmt = $pdo->query("SELECT name, sql FROM sqlite_master WHERE type = 'table' AND name NOT LIKE 'sqlite_%' ORDER BY name");
$tables = $tablesStmt->fetchAll(PDO::FETCH_ASSOC);

$dump = [];
$dump[] = '-- Full SQLite export generated on ' . date('Y-m-d H:i:s');
$dump[] = 'PRAGMA foreign_keys = OFF;';
$dump[] = 'BEGIN TRANSACTION;';
$dump[] = '';

foreach ($tables as $table) {
    $tableName = (string) $table['name'];
    $createSql = (string) $table['sql'];

    $dump[] = '-- Table structure for ' . $tableName;
    $dump[] = $createSql . ';';
    $dump[] = '';

    $rowsStmt = $pdo->query(sprintf('SELECT * FROM "%s"', str_replace('"', '""', $tableName)));
    $rows = $rowsStmt->fetchAll(PDO::FETCH_ASSOC);

    if ($rows === []) {
        $dump[] = '-- No rows in ' . $tableName;
        $dump[] = '';
        continue;
    }

    $columns = array_keys($rows[0]);
    $columnsSql = implode(', ', array_map(static fn(string $c): string => '"' . $c . '"', $columns));

    $dump[] = '-- Data for ' . $tableName;
    foreach ($rows as $row) {
        $valuesSql = implode(', ', array_map(static function ($v) use ($pdo): string {
            if ($v === null) {
                return 'NULL';
            }

            return $pdo->quote((string) $v);
        }, array_values($row)));

        $dump[] = sprintf('INSERT INTO "%s" (%s) VALUES (%s);', $tableName, $columnsSql, $valuesSql);
    }
    $dump[] = '';
}

$dump[] = 'COMMIT;';

$sqlPath = $outputDir . DIRECTORY_SEPARATOR . 'db_export.sql';
if (file_put_contents($sqlPath, implode(PHP_EOL, $dump) . PHP_EOL) === false) {
    fwrite(STDERR, "Unable to write SQL dump: {$sqlPath}" . PHP_EOL);
    exit(1);
}

echo 'Full export complete:' . PHP_EOL;
echo '- ' . $dbCopyPath . PHP_EOL;
echo '- ' . $sqlPath . PHP_EOL;
