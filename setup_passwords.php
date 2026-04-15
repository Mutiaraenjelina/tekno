<?php
$adminPassword = password_hash('admin1234', PASSWORD_BCRYPT);
$superAdminPassword = password_hash('password', PASSWORD_BCRYPT);

echo "Hash for 'admin1234': $adminPassword\n";
echo "Hash for 'password': $superAdminPassword\n";

// Update all users to these passwords
$pdo = new PDO('mysql:host=127.0.0.1;dbname=db_tapatupa_13032026', 'root', '');

$users = [
    ['id' => 1, 'password' => $superAdminPassword],  // super admin
    ['id' => 2, 'password' => $adminPassword], // Anna Avante (Admin)
];

foreach ($users as $user) {
    $stmt = $pdo->prepare("UPDATE users SET password = ? WHERE id = ?");
    $stmt->execute([$user['password'], $user['id']]);
    echo "Updated user ID {$user['id']}\n";
}
?>
