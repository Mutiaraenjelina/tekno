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
        CURLOPT_FOLLOWLOCATION => false,
        CURLOPT_TIMEOUT => 10,
        CURLOPT_SSL_VERIFYPEER => false,
    ]);

    curl_exec($ch);
    $redirect_url = curl_getinfo($ch, CURLINFO_REDIRECT_URL);
    curl_close($ch);

    echo "[Super Admin Login]\n";
    echo "Redirects to: $redirect_url\n\n";

    // Now follow the redirect
    echo "[Following redirect...]\n";
    $ch = curl_init($redirect_url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_COOKIEFILE => $cookie_file,
        CURLOPT_FOLLOWLOCATION => false,
        CURLOPT_TIMEOUT => 10,
        CURLOPT_SSL_VERIFYPEER => false,
    ]);
    
    $response = curl_exec($ch);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $next_redirect = curl_getinfo($ch, CURLINFO_REDIRECT_URL);
    curl_close($ch);

    echo "Status: $code\n";
    if ($next_redirect) {
        echo "Redirects again to: $next_redirect\n";
    }
    
    if ($code == 200) {
        echo "Content length: " . strlen($response) . " bytes\n";
        if (strpos($response, 'Dashboard') !== false) {
            echo "✓ Dashboard page found\n";
        }
    }

} finally {
    if (file_exists($cookie_file)) {
        unlink($cookie_file);
    }
}
?>
