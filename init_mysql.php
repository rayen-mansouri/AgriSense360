<?php
$pdo = new PDO('mysql:host=localhost;dbname=agrisense-360', 'root', '');

$queries = [
    "CREATE TABLE IF NOT EXISTS users (
        id INT PRIMARY KEY AUTO_INCREMENT,
        last_name VARCHAR(255) NOT NULL,
        first_name VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL UNIQUE,
        password_hash VARCHAR(255) NOT NULL,
        status VARCHAR(50) NOT NULL,
        role_name VARCHAR(50) NOT NULL,
        created_at DATE DEFAULT CURRENT_DATE
    )",
    "CREATE TABLE IF NOT EXISTS equipments (
        id INT PRIMARY KEY AUTO_INCREMENT,
        user_id INT NOT NULL,
        name VARCHAR(255) NOT NULL,
        type VARCHAR(255) NOT NULL,
        status VARCHAR(50) NOT NULL,
        purchase_date DATE,
        FOREIGN KEY (user_id) REFERENCES users(id)
    )",
    "CREATE TABLE IF NOT EXISTS maintenance (
        id INT PRIMARY KEY AUTO_INCREMENT,
        user_id INT NOT NULL,
        equipment_id INT NOT NULL,
        maintenance_date DATE NOT NULL,
        maintenance_type VARCHAR(255) NOT NULL,
        cost DECIMAL(10,2) NOT NULL,
        FOREIGN KEY (equipment_id) REFERENCES equipments(id),
        FOREIGN KEY (user_id) REFERENCES users(id)
    )",
    "INSERT IGNORE INTO users (id, last_name, first_name, email, password_hash, status, role_name, created_at) VALUES
    (1, 'Admin', 'Test', 'admin@test.com', '\$2y\$10\$GxPvJKLqz7Hm8.I8jk5Q.eJ4rJ2z4V7zY5z5z5z5z5z5z5z5z5z5z', 'Active', 'ADMIN', CURDATE()),
    (2, 'User', 'Test', 'user@test.com', '\$2y\$10\$GxPvJKLqz7Hm8.I8jk5Q.eJ4rJ2z4V7zY5z5z5z5z5z5z5z5z5z5z', 'Active', 'USER', CURDATE())",
];

foreach ($queries as $query) {
    try {
        $pdo->exec($query);
        echo "✓ Query executed\n";
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
}

echo "✓ Database initialized\n";
?>
