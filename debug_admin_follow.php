<?php
define('APP_URL', 'http://127.0.0.1:8000');

$test_user = ['username' => 'super admin', 'password' => 'password'];
$cookie_file = tempnam(sys_get_temp_dir(), 'curl_');

try {
    // Get login page
    $ch = curl_init(APP_URL . '/login');
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_COOKIEJAR => $cookie_file,
        CURLOPT_COOKIEFILE => $cookie_file,
        CURLOPT_TIMEOUT => 10,
        CURLOPT_SSL_VERIFYPEER => false,
    ]);
    
    $response = curl_exec($ch);
    curl_close($ch);

    preg_match('/name="_token"\s+value="([^"]+)"/', $response, $matches);
    $csrf_token = $matches[1];
    
    // Login
    $ch = curl_init(APP_URL . '/proses_login');
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => http_build_query([
            '_token' => $csrf_token,
            'username' => $test_user['username'],
            'password' => $test_user['password']
        ]),
        CURLOPT_COOKIEFILE => $cookie_file,
        CURLOPT_COOKIEJAR => $cookie_file,
        CURLOPT_FOLLOWLOCATION => true,  // FOLLOW REDIRECTS NOW
        CURLOPT_MAXREDIRS => 5,           // Follow up to 5 redirects
        CURLOPT_TIMEOUT => 10,
        CURLOPT_SSL_VERIFYPEER => false,
    ]);

    $response = curl_exec($ch);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $final_url = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
    curl_close($ch);

    echo "[Super Admin Login - Following Redirects]\n";
    echo "Final Status: $code\n";
    echo "Final URL: $final_url\n";
    
    if ($code == 200) {
        echo "\n✓ Admin dashboard accessible!\n";
        echo "Response size: " . strlen($response) . " bytes\n";
        
        if (strpos($response, 'Dashboard') !== false || strpos($response, 'dashboard') !== false) {
            echo "✓ Dashboard page found\n";
        }
    } else {
        echo "\n✗ Error: Got $code instead of 200\n";
        // Print first 300 chars of response
        echo "Response preview:\n" . substr($response, 0, 300) . "\n";
    }

} finally {
    if (file_exists($cookie_file)) {
        unlink($cookie_file);
    }
}
?>
