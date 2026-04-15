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
    echo "[1] Logging in as Super Admin\n";
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
    curl_close($ch);
    echo "✓ Login completed\n\n";

    // Now try to access admin/dashboard directly with curl
    echo "[2] Accessing /admin/dashboard\n";
    $ch = curl_init(APP_URL . '/admin/dashboard');
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_COOKIEFILE => $cookie_file,
        CURLOPT_VERBOSE => false,
        CURLOPT_TIMEOUT => 10,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_FOLLOWLOCATION => false, // Don't follow redirects automatically
    ]);
    
    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $redirect_url = curl_getinfo($ch, CURLINFO_REDIRECT_URL);
    curl_getinfo($ch);
    curl_close($ch);

    echo "Status code: $http_code\n";
    if ($redirect_url) {
        echo "Redirects to: $redirect_url\n";
    }
    
    echo "Response size: " . strlen($response) . " bytes\n";
    
    if ($http_code == 302 && $redirect_url === 'http://127.0.0.1:8000/admin/dashboard') {
        echo "\n✗ INFINITE REDIRECT LOOP DETECTED!\n";
        echo "The middleware is causing a redirect loop.\n";
        echo "\nDiagnosing...\n";
        
        // Check if the super admin user is correctly authenticated
        echo "[3] Checking authentication\n";
        $ch = curl_init(APP_URL . '/dashboard');
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_COOKIEFILE => $cookie_file,
            CURLOPT_TIMEOUT => 10,
            CURLOPT_SSL_VERIFYPEER => false,
        ]);
        
        $user_dash = curl_exec($ch);
        $user_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        echo "User dashboard (/dashboard) status: $user_code\n";
        
        if ($user_code == 200) {
            echo "✓ User can access /dashboard (correct behavior - Super Admin should be redirected)\n";
        }
        
    } elseif ($http_code == 200) {
        echo "\n✓ Admin dashboard is accessible!\n";
        if (strlen($response) > 1000) {
            echo "✓ Page content loaded (" . strlen($response) . " bytes)\n";
        }
    } else {
        echo "\n✗ Unexpected status: $http_code\n";
    }

} finally {
    if (file_exists($cookie_file)) {
        unlink($cookie_file);
    }
}
?>
