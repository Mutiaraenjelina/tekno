<?php
// Create test assignment
$pdo = new PDO('mysql:host=127.0.0.1;dbname=db_tapatupa_13032026', 'root', '');

$tagihanId = 1;  // Smoke Test Tagihan
$userId = 3;      // user
$status = 'belum';

echo "Creating test assignment...\n";
echo "Tagihan ID: $tagihanId\n";
echo "User ID: $userId\n";
echo "Status: $status\n\n";

try {
    $stmt = $pdo->prepare("INSERT INTO tagihan_user (tagihan_id, user_id, status, created_at, updated_at) VALUES (?, ?, ?, NOW(), NOW())");
    $stmt->execute([$tagihanId, $userId, $status]);
    
    echo "✅ Assignment created successfully!\n\n";
    
    echo "=== VERIFICATION ===\n";
    $assignments = $pdo->query("SELECT tu.id, tu.tagihan_id, tu.user_id, tu.status, t.nama_tagihan, u.username 
                                FROM tagihan_user tu
                                LEFT JOIN tagihan t ON t.id = tu.tagihan_id
                                LEFT JOIN users u ON u.id = tu.user_id
                                ORDER BY tu.id")->fetchAll(PDO::FETCH_ASSOC);
    foreach ($assignments as $assign) {
        echo sprintf("Assignment %d: %s -> %s (Status: %s)\n",
            $assign['id'],
            $assign['nama_tagihan'],
            $assign['username'],
            $assign['status']
        );
    }
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
?>
