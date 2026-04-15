<?php
// Check users and pelanggan relationship
$pdo = new PDO('mysql:host=127.0.0.1;dbname=db_tapatupa_13032026', 'root', '');

echo "=== USERS DATA ===\n";
$users = $pdo->query("SELECT id, username, email, idPersonal FROM users ORDER BY id")->fetchAll(PDO::FETCH_ASSOC);
foreach ($users as $user) {
    echo sprintf("User ID %d: %s (Email: %s, idPersonal: %s)\n", 
        $user['id'], 
        $user['username'], 
        $user['email'], 
        $user['idPersonal'] ?? 'NULL'
    );
}

echo "\n=== PELANGGAN DATA ===\n";
$pelanggans = $pdo->query("SELECT id, nama FROM pelanggan ORDER BY id")->fetchAll(PDO::FETCH_ASSOC);
foreach ($pelanggans as $pelanggan) {
    echo sprintf("Pelanggan ID %d: %s\n", $pelanggan['id'], $pelanggan['nama']);
}

echo "\n=== USERS WITH VALID PELANGGAN LINK ===\n";
$query = "SELECT u.id, u.username, u.idPersonal, p.nama 
          FROM users u 
          LEFT JOIN pelanggan p ON p.id = u.idPersonal 
          ORDER BY u.id";
$validUsers = $pdo->query($query)->fetchAll(PDO::FETCH_ASSOC);
foreach ($validUsers as $user) {
    echo sprintf("User ID %d (%s) -> Pelanggan: %s\n", 
        $user['id'], 
        $user['username'], 
        $user['nama'] ?? 'NOT LINKED'
    );
}
?>
