<?php
// Create pelanggan records for all users with idPersonal
$pdo = new PDO('mysql:host=127.0.0.1;dbname=db_tapatupa_13032026', 'root', '');

// Get unique idPersonal values from users
$users = $pdo->query("SELECT DISTINCT idPersonal FROM users WHERE idPersonal IS NOT NULL ORDER BY idPersonal")->fetchAll(PDO::FETCH_ASSOC);

echo "Creating pelanggan records...\n";
$count = 0;

foreach ($users as $user) {
    $id = $user['idPersonal'];
    
    // Check if this pelanggan id already exists
    $exists = $pdo->query("SELECT id FROM pelanggan WHERE id = $id")->fetch();
    
    if (!$exists) {
        // Get the user that has this idPersonal to get their name
        $userData = $pdo->query("SELECT username FROM users WHERE idPersonal = $id LIMIT 1")->fetch(PDO::FETCH_ASSOC);
        $nama = $userData['username'] ?? "Pelanggan $id";
        
        $stmt = $pdo->prepare("INSERT INTO pelanggan (id, nama, no_wa, created_at, updated_at) VALUES (?, ?, ?, NOW(), NOW())");
        $stmt->execute([$id, $nama, '']);
        echo "Created pelanggan ID $id (Nama: $nama)\n";
        $count++;
    } else {
        echo "Pelanggan ID $id already exists\n";
    }
}

echo "\nDone! Created $count new pelanggan records\n";

echo "\n=== VERIFICATION ===\n";
$validUsers = $pdo->query("SELECT u.id, u.username, u.idPersonal, p.nama 
                           FROM users u 
                           LEFT JOIN pelanggan p ON p.id = u.idPersonal 
                           ORDER BY u.id")->fetchAll(PDO::FETCH_ASSOC);
foreach ($validUsers as $user) {
    echo sprintf("User ID %d (%s) -> Pelanggan: %s\n", 
        $user['id'], 
        $user['username'], 
        $user['nama'] ?? 'NOT LINKED'
    );
}
?>
