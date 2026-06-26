<?php
// admin/logout.php
session_start();

// 1. Hapus semua data session
$_SESSION = array();

// 2. Hancurkan cookie session jika ada
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// 3. Hancurkan session
session_destroy();

// 4. Paksa arahkan ke login admin secara absolut
header("Location: login.php?status=logout"); 
exit();
?>