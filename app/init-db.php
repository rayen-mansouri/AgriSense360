<?php
// Create SQLite database and initialize schema
$dbFile = __DIR__ . '/var/data.db';

// Create var directory if it doesn't exist
if (!is_dir(__DIR__ . '/var')) {
    mkdir(__DIR__ . '/var', 0755, true);
}

try {
    // Create/connect to database
    $pdo = new PDO('sqlite:' . $dbFile);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Read and execute schema
    $schema = file_get_contents(__DIR__ . '/sql/create_sqlite_database.sql');

    // Split into individual statements (SQLite requires one statement at a time)
    $statements = array_filter(array_map('trim', preg_split('/;/', $schema)));

    foreach ($statements as $sql) {
        if (!empty($sql)) {
            try {
                $pdo->exec($sql);
                echo "✓ Executed: " . substr($sql, 0, 50) . "...\n";
            } catch (Exception $e) {
                echo "⚠ Warning: " . $e->getMessage() . "\n";
            }
        }
    }

    echo "\n✅ SQLite database initialized successfully at: $dbFile\n";
    echo "Database size: " . filesize($dbFile) . " bytes\n";

} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    exit(1);
}
