<?php
// Initialize test users with known passwords
$dbFile = __DIR__ . '/var/data.db';

try {
    $pdo = new PDO('sqlite:' . $dbFile);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Create admin user with password "admin123"
    $adminHash = password_hash('admin123', PASSWORD_BCRYPT);
    $pdo->exec("UPDATE users SET password_hash = '$adminHash' WHERE email = 'admin@test.com'");

    // Create regular user with password "user123"
    $userHash = password_hash('user123', PASSWORD_BCRYPT);
    $pdo->exec("UPDATE users SET password_hash = '$userHash' WHERE email = 'user@test.com'");

    echo "✅ Test users initialized:\n";
    echo "  Admin: admin@test.com / admin123\n";
    echo "  User:  user@test.com / user123\n";

} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    exit(1);
}
