<?php
/*
 * Google OAuth Callback
 * File ini dipanggil otomatis oleh Google setelah user login
 */

define('GOOGLE_CLIENT_ID',     'ISI_CLIENT_ID_ANDA_DI_SINI');
define('GOOGLE_CLIENT_SECRET', 'ISI_CLIENT_SECRET_ANDA_DI_SINI');
define('GOOGLE_REDIRECT_URI',  'http://localhost/mining-marketplace/auth/google_callback.php');

session_start();
include "../config/database.php";

// Validasi state (keamanan CSRF)
if (!isset($_GET['state']) || $_GET['state'] !== ($_SESSION['google_state'] ?? '')) {
    die("State tidak valid. <a href='../login.php'>Kembali</a>");
}

if (isset($_GET['error'])) {
    header("Location: ../login.php?err=google_cancelled");
    exit();
}

$code = $_GET['code'] ?? '';

// ── 1. Tukar code dengan access token ──────────────────────
$token_res = file_get_contents('https://oauth2.googleapis.com/token', false,
    stream_context_create(['http' => [
        'method'  => 'POST',
        'header'  => "Content-Type: application/x-www-form-urlencoded\r\n",
        'content' => http_build_query([
            'code'          => $code,
            'client_id'     => GOOGLE_CLIENT_ID,
            'client_secret' => GOOGLE_CLIENT_SECRET,
            'redirect_uri'  => GOOGLE_REDIRECT_URI,
            'grant_type'    => 'authorization_code',
        ]),
    ]])
);

$token_data = json_decode($token_res, true);

if (empty($token_data['access_token'])) {
    header("Location: ../login.php?err=google_token_failed");
    exit();
}

// ── 2. Ambil profil user dari Google ───────────────────────
$profile_res = file_get_contents('https://www.googleapis.com/oauth2/v3/userinfo', false,
    stream_context_create(['http' => [
        'header' => "Authorization: Bearer " . $token_data['access_token'] . "\r\n",
    ]])
);

$profile = json_decode($profile_res, true);

if (empty($profile['email'])) {
    header("Location: ../login.php?err=google_profile_failed");
    exit();
}

$google_id    = mysqli_real_escape_string($conn, $profile['sub']);
$email        = mysqli_real_escape_string($conn, $profile['email']);
$nama         = mysqli_real_escape_string($conn, $profile['name'] ?? $profile['email']);
$google_photo = $profile['picture'] ?? '';
$mode         = $_SESSION['google_mode'] ?? 'login';

// ── 3. Cek apakah user sudah terdaftar ─────────────────────
$existing = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");

if (mysqli_num_rows($existing) > 0) {
    // User sudah ada → langsung login
    $user = mysqli_fetch_assoc($existing);
    $_SESSION['user_id']  = $user['id_user'];
    $_SESSION['username'] = $user['username'];
    unset($_SESSION['google_state'], $_SESSION['google_mode']);
    header("Location: ../user/index.php");
    exit();
}

// ── 4. User belum ada → daftar otomatis ────────────────────
// Generate username dari nama Google
$base_user = strtolower(preg_replace('/[^a-z0-9]/i', '', explode(' ', $profile['name'] ?? 'user')[0]));
$username  = $base_user ?: 'user';

// Pastikan username unik
$i = 0;
while (true) {
    $try  = $i === 0 ? $username : $username . $i;
    $try  = mysqli_real_escape_string($conn, $try);
    $chk  = mysqli_query($conn, "SELECT id_user FROM users WHERE username='$try'");
    if (mysqli_num_rows($chk) === 0) { $username = $try; break; }
    $i++;
}

$rand_pw = password_hash(bin2hex(random_bytes(16)), PASSWORD_DEFAULT);

$ins = mysqli_query($conn,
    "INSERT INTO users (username, email, password, nama_lengkap, google_id, created_at)
     VALUES ('$username', '$email', '$rand_pw', '$nama', '$google_id', NOW())"
);

if (!$ins) {
    // Fallback tanpa kolom google_id / nama_lengkap
    $ins = mysqli_query($conn,
        "INSERT INTO users (username, email, password)
         VALUES ('$username', '$email', '$rand_pw')"
    );
}

if ($ins) {
    $new_id = mysqli_insert_id($conn);
    $_SESSION['user_id']  = $new_id;
    $_SESSION['username'] = $username;
    unset($_SESSION['google_state'], $_SESSION['google_mode']);
    header("Location: ../user/index.php");
    exit();
}

// Gagal insert
header("Location: ../register.php?err=google_register_failed");
exit();
?>
