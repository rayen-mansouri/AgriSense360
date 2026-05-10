<?php
// One-time script: create admin account + fix any issues
$pdo = new PDO('mysql:host=localhost;dbname=agrisense;charset=utf8mb4', 'root', '');

$email    = 'admin@agrisense.com';
$name     = 'Admin AgriSense';
$password = password_hash('Admin@2024!', PASSWORD_BCRYPT, ['cost' => 13]);
$roles    = json_encode(['ROLE_ADMIN']);
$now      = date('Y-m-d H:i:s');

// Check if exists
$stmt = $pdo->prepare("SELECT id FROM `user` WHERE email = ?");
$stmt->execute([$email]);
if ($stmt->fetch()) {
    // Update password + role
    $pdo->prepare("UPDATE `user` SET roles=?, password=?, status='active', first_login=0 WHERE email=?")
        ->execute([$roles, $password, $email]);
    echo "Admin account UPDATED.\n";
} else {
    $pdo->prepare("INSERT INTO `user` (name, email, password, roles, status, auth_provider, first_login, created_at, updated_at)
                   VALUES (?, ?, ?, ?, 'active', 'local', 0, ?, ?)")
        ->execute([$name, $email, $password, $roles, $now, $now]);
    echo "Admin account CREATED.\n";
}
echo "Email:    admin@agrisense.com\n";
echo "Password: Admin@2024!\n";
echo "URL:      http://localhost/agrisense/public/login\n";
