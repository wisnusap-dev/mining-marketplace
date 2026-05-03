<?php
session_start();
// Hapus ../ karena sekarang login.php sejajar dengan folder config
include "config/database.php"; 

if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Mencari user di database
    $query = mysqli_query($conn, "SELECT * FROM users WHERE username='$username' AND password='$password'");
    
    if (mysqli_num_rows($query) > 0) {
        $data = mysqli_fetch_assoc($query);
        $_SESSION['user_id'] = $data['id_user'];
        $_SESSION['username'] = $data['username'];
        
        // Arahkan masuk ke DALAM folder user setelah login berhasil
        echo "<script>
                alert('Login Berhasil! Selamat Datang, " . $data['username'] . "'); 
                window.location='user/index.php'; 
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Mining Market</title>
    <!-- Path CSS disesuaikan (tanpa ../) -->
    <link rel="stylesheet" href="css/style.css">
    <style>
        body { 
            background-color: #3d2b1f; 
            display: flex; 
            justify-content: center; 
            align-items: center; 
            height: 100vh; 
            margin: 0; 
            font-family: 'Segoe UI', Tahoma, sans-serif; 
        }
        .login-card { 
            background: #fff; 
            padding: 40px; 
            border-radius: 15px; 
            box-shadow: 0 10px 25px rgba(0,0,0,0.3); 
            width: 100%; 
            max-width: 350px; 
            text-align: center; 
        }
        .login-card h2 { color: #3d2b1f; margin-bottom: 25px; }
        .login-card input { 
            width: 100%; 
            padding: 12px; 
            margin-bottom: 15px; 
            border: 1px solid #ddd; 
            border-radius: 8px; 
            box-sizing: border-box; 
        }
        .login-card button { 
            width: 100%; 
            padding: 12px; 
            background: #3d2b1f; 
            color: white; 
            border: none; 
            border-radius: 8px; 
            cursor: pointer; 
            font-weight: bold; 
            transition: 0.3s;
        }
        .login-card button:hover { background: #d4aa61; }
        .back-link { 
            display: block; 
            margin-top: 15px; 
            color: #888; 
            text-decoration: none; 
            font-size: 0.9rem; 
        }
        .back-link:hover { color: #3d2b1f; }
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
    <!-- Mengarah ke index utama jika ada, atau sesuaikan path-nya -->
    <a href="index.php" class="back-link">Kembali ke Beranda Utama</a>
</div>

</body>
</html>