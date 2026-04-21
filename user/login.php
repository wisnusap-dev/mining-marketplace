<?php
session_start();
// Tetap gunakan ../ karena file ini di dalam folder 'user'
include "../config/database.php"; 

if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Pastikan tabel 'users' sudah kamu buat di phpMyAdmin
    $query = mysqli_query($conn, "SELECT * FROM users WHERE username='$username' AND password='$password'");
    
    if (mysqli_num_rows($query) > 0) {
        $data = mysqli_fetch_assoc($query);
        $_SESSION['user_id'] = $data['id_user'];
        $_SESSION['username'] = $data['username'];
        
        // REVISI: Arahkan ke index.php yang ada di DALAM folder user
        echo "<script>
                alert('Login Berhasil! Selamat Datang, " . $data['username'] . "'); 
                window.location='index.php'; 
              </script>";
    } else {
        echo "<script>alert('Username atau Password Salah!');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login - Mining Market</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        body { background-color: #3d2b1f; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; font-family: sans-serif; }
        .login-card { background: #fff; padding: 40px; border-radius: 15px; box-shadow: 0 10px 25px rgba(0,0,0,0.3); width: 100%; max-width: 350px; text-align: center; }
        .login-card h2 { color: #3d2b1f; margin-bottom: 25px; }
        .login-card input { width: 100%; padding: 12px; margin-bottom: 15px; border: 1px solid #ddd; border-radius: 8px; box-sizing: border-box; }
        .login-card button { width: 100%; padding: 12px; background: #3d2b1f; color: white; border: none; border-radius: 8px; cursor: pointer; font-weight: bold; }
        .login-card button:hover { background: #d4aa61; }
        .back-link { display: block; margin-top: 15px; color: #888; text-decoration: none; font-size: 0.9rem; }
    </style>
</head>
<body>

<div class="login-card">
    <h2>Login Pembeli</h2>
    <form method="POST">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit" name="login">Masuk</button>
    </form>
    <a href="../index.php" class="back-link">Kembali ke Beranda Utama</a>
</div>

</body>
</html>