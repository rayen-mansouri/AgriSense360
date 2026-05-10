<?php
$pdo = new PDO('mysql:host=127.0.0.1;port=3306;dbname=agrisense-360', 'root', '');
$rows = $pdo->query('SELECT id, email, roles, status FROM user ORDER BY id')->fetchAll(PDO::FETCH_ASSOC);
foreach ($rows as $r) {
    $rawRoles = $r['roles'];
    $decoded = json_decode($rawRoles, true);
    $rolesStr = is_array($decoded) ? implode(', ', $decoded) : ('RAW:' . $rawRoles);
    if (empty($decoded)) $rolesStr = '(empty array — ROLE_USER only)';
    echo $r['id'] . ' | ' . $r['email'] . ' | ' . $r['status'] . ' | ' . $rolesStr . PHP_EOL;
}
