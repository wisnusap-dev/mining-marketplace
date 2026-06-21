<?php
/*
 * ============================================================
 *  GOOGLE OAUTH 2.0 HANDLER
 *  Cara setup:
 *  1. Buka https://console.cloud.google.com/
 *  2. Buat project → APIs & Services → Credentials
 *  3. Buat "OAuth 2.0 Client ID" (Web application)
 *  4. Authorized redirect URIs: http://localhost/mining-marketplace/auth/google_callback.php
 *  5. Isi CLIENT_ID dan CLIENT_SECRET di bawah
 * ============================================================
 */

define('GOOGLE_CLIENT_ID',     'ISI_CLIENT_ID_ANDA_DI_SINI');
define('GOOGLE_CLIENT_SECRET', 'ISI_CLIENT_SECRET_ANDA_DI_SINI');
define('GOOGLE_REDIRECT_URI',  'http://localhost/mining-marketplace/auth/google_callback.php');

session_start();

$mode = $_GET['mode'] ?? 'login';
$_SESSION['google_mode'] = $mode;

$state = bin2hex(random_bytes(16));
$_SESSION['google_state'] = $state;

$params = http_build_query([
    'client_id'     => GOOGLE_CLIENT_ID,
    'redirect_uri'  => GOOGLE_REDIRECT_URI,
    'response_type' => 'code',
    'scope'         => 'openid email profile',
    'state'         => $state,
    'prompt'        => 'select_account',
]);

header("Location: https://accounts.google.com/o/oauth2/v2/auth?" . $params);
exit();
?>
