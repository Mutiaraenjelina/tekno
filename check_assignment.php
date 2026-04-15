<?php
// Check tagihan_user data
$pdo = new PDO('mysql:host=127.0.0.1;dbname=db_tapatupa_13032026', 'root', '');

echo "=== TAGIHAN DATA ===\n";
$tagihs = $pdo->query("SELECT id, nama_tagihan, nominal FROM tagihan ORDER BY id")->fetchAll(PDO::FETCH_ASSOC);
if (empty($tagihs)) {
    echo "Tidak ada tagihan\n";
} else {
    foreach ($tagihs as $tagih) {
        echo sprintf("Tagihan ID %d: %s (Nominal: %s)\n", $tagih['id'], $tagih['nama_tagihan'], $tagih['nominal']);
    }
}

echo "\n=== TAGIHAN_USER DATA ===\n";
$assignments = $pdo->query("SELECT * FROM tagihan_user ORDER BY id")->fetchAll(PDO::FETCH_ASSOC);
if (empty($assignments)) {
    echo "Tidak ada assignments\n";
} else {
    foreach ($assignments as $assign) {
        echo sprintf("Assignment ID %d: Tagihan %d -> User %d (Status: %s)\n", 
            $assign['id'],
            $assign['tagihan_id'], 
            $assign['user_id'],
            $assign['status']
        );
    }
}
?>
