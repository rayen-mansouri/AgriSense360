<?php
$db = new PDO('sqlite:var/agrisense_dev.db');

$queries = [
    "CREATE TABLE IF NOT EXISTS users (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        last_name TEXT NOT NULL,
        first_name TEXT NOT NULL,
        email TEXT NOT NULL UNIQUE,
        password_hash TEXT NOT NULL,
        status TEXT NOT NULL,
        role_name TEXT NOT NULL,
        created_at DATE DEFAULT CURRENT_DATE
    )",
    "CREATE TABLE IF NOT EXISTS equipments (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        user_id INTEGER NOT NULL,
        name TEXT NOT NULL,
        type TEXT NOT NULL,
        status TEXT NOT NULL,
        purchase_date DATE,
        FOREIGN KEY (user_id) REFERENCES users(id)
    )",
    "CREATE TABLE IF NOT EXISTS maintenance (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        user_id INTEGER NOT NULL,
        equipment_id INTEGER NOT NULL,
        maintenance_date DATE NOT NULL,
        maintenance_type TEXT NOT NULL,
        cost REAL NOT NULL,
        FOREIGN KEY (equipment_id) REFERENCES equipments(id),
        FOREIGN KEY (user_id) REFERENCES users(id)
    )",
    "CREATE TABLE IF NOT EXISTS affectation_travail (
        id_affectation INTEGER PRIMARY KEY AUTOINCREMENT,
        type_travail TEXT NOT NULL,
        date_debut DATE NOT NULL,
        date_fin DATE NOT NULL,
        zone_travail TEXT NOT NULL,
        statut TEXT NOT NULL
    )",
    "CREATE TABLE IF NOT EXISTS evaluation_performance (
        id_evaluation INTEGER PRIMARY KEY AUTOINCREMENT,
        id_affectation INTEGER NOT NULL,
        note INTEGER NOT NULL,
        qualite TEXT NOT NULL,
        commentaire TEXT NOT NULL,
        date_evaluation DATE NOT NULL,
        FOREIGN KEY (id_affectation) REFERENCES affectation_travail(id_affectation)
    )",
    "INSERT OR IGNORE INTO users (id, last_name, first_name, email, password_hash, status, role_name, created_at) VALUES
    (1, 'Admin', 'Test', 'admin@test.com', '\$2y\$10\$GxPvJKLqz7Hm8.I8jk5Q.eJ4rJ2z4V7zY5z5z5z5z5z5z5z5z5z5z', 'Active', 'ADMIN', datetime('now')),
    (2, 'User', 'Test', 'user@test.com', '\$2y\$10\$GxPvJKLqz7Hm8.I8jk5Q.eJ4rJ2z4V7zY5z5z5z5z5z5z5z5z5z5z', 'Active', 'USER', datetime('now'))",
];

foreach ($queries as $query) {
    try {
        $db->exec($query);
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
}

echo "✓ Database initialized\n";
?>
