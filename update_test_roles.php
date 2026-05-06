<?php
// Simple script to update user roles using the database connection string from .env
require_once __DIR__ . '/vendor/autoload.php';

// Load environment variables
$envFile = __DIR__ . '/.env';
if (file_exists($envFile)) {
    $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos($line, '=') !== false && strpos($line, '#') !== 0) {
            [,$key, $value] = array_pad(explode('=', $line, 2), 3, null);
            if ($key && $value) {
                $_ENV[trim($key)] = trim($value, '"\'');
                putenv(trim($key) . '=' . trim($value, '"\''));
            }
        }
    }
}

// Parse DATABASE_URL - format: mysql://user:password@host:port/dbname?params
$dbUrl = $_ENV['DATABASE_URL'] ?? 'mysql://root:@127.0.0.1:3306/agrisense-360';
echo "DATABASE_URL: $dbUrl\n";

// Parse manually
$dbUrl = preg_replace('/\?.*$/', '', $dbUrl); // Remove query string
$url = parse_url($dbUrl);
$user = $url['user'] ?? 'root';
$pass = $url['pass'] ?? '';
$host = $url['host'] ?? '127.0.0.1';
$port = $url['port'] ?? 3306;
$dbname = ltrim($url['path'] ?? '', '/');

echo "Parsed: user=$user, pass=$pass, host=$host, port=$port, dbname=$dbname\n";

// Connect and update
$pdo = new PDO(
    "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4",
    $user,
    $pass ?: null,
    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
);

$updates = [
    'ahmedhabouba@gmail.com' => '["ROLE_ADMIN"]',
    'ahmedhabouba.com@gmail.com' => '["ROLE_GERANT"]',
    'kiko@gmail.com' => '["ROLE_OUVRIER"]',
    'aa@mail.com' => '["ROLE_OWNER"]',
];

echo "Updating user roles...\n\n";

$stmt = $pdo->prepare("UPDATE user SET roles = ? WHERE email = ?");
foreach ($updates as $email => $roles) {
    $stmt->execute([$roles, $email]);
    echo "✓ Updated $email with roles $roles\n";
}

// Verify
echo "\nVerifying updates:\n\n";
$select = $pdo->query("SELECT email, roles FROM user WHERE email IN ('ahmedhabouba@gmail.com', 'ahmedhabouba.com@gmail.com', 'kiko@gmail.com', 'aa@mail.com') ORDER BY email");
foreach ($select->fetchAll(PDO::FETCH_ASSOC) as $row) {
    echo $row['email'] . " => " . $row['roles'] . "\n";
}

echo "\nDone!\n";
