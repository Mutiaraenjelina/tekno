<?php

require 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

$app->make(\Illuminate\Contracts\Http\Kernel::class)->bootstrap();

// Update password for Anna Avante
$targetUsername = 'Anna Avante';
$newPassword = Hash::make('admin1234');
DB::table('users')->where('username', $targetUsername)->update(['password' => $newPassword]);

echo "Password updated successfully for user: {$targetUsername}\n";
echo "New password hash: " . substr($newPassword, 0, 20) . "...\n";

// Verify
$user = DB::table('users')->where('username', $targetUsername)->first();
if ($user) {
    echo "Verify - User found with username: " . $user->username . "\n";
    echo "Email: " . $user->email . "\n";
} else {
    echo "ERROR: User not found!\n";
}

?>
