<?php

// Simple password hashing
$password = 'admin1234';
$hashed = password_hash($password, PASSWORD_BCRYPT);

echo "Password: " . $password . "\n";
echo "Hashed: " . $hashed . "\n";

// Save to file for MySQL command
file_put_contents('c:\\xampp\\htdocs\\hash.txt', $hashed);

?>
