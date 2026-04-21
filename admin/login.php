<?php
session_start();
include "../config/database.php";

$error = ""; 

if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];

    $query = mysqli_query($conn, "SELECT * FROM admin WHERE username='$username'");
    
    if (mysqli_num_rows($query) > 0) {
        $data = mysqli_fetch_assoc($query);
        
        if (password_verify($password, $data['password'])) {
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['username'] = $data['username'];
            header("Location: dashboard.php");
            exit();
        } else {
            $error = "Password salah!";
        }
    } else {
        $error = "Username tidak ditemukan!";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login Admin</title>
    <link rel="stylesheet" href="../css/admin.css">
</head>
<body>

    <div class="main-container">
        
        <div class="wrapper">
            <svg viewBox="0 0 300 70">
                <text x="50%" y="50%" dy=".35em" text-anchor="middle">
                    LOGIN NOW
                </text>
            </svg>
        </div>

        <div class="login-box">
            <h2 class="login-title">Login Admin</h2>

            <?php if ($error != ""): ?>
                <div style="color: #ff4d4d; background: #ffe6e6; padding: 10px; border-radius: 8px; margin-bottom: 20px; font-size: 14px; border: 1px solid #ffcccc;">
                    ⚠️ <?php echo $error; ?>
                </div>
            <?php endif; ?>

            <form method="POST" class="login-form">
                <div class="input-group">
                    <input type="text" name="username" placeholder="Username" required>
                </div>
                <div class="input-group">
                    <input type="password" name="password" placeholder="Password" required>
                </div>
                <button type="submit" name="login">Masuk Sekarang</button>
            </form>

            <div style="margin-top: 20px; font-size: 14px;">
                <p><a href="forgot.php" style="text-decoration: none; color: #800000;">Lupa Password?</a></p>
                <p style="margin-top: 10px; color: #666;">
                    Belum punya akun? <a href="register.php" style="text-decoration: none; color: #800000; font-weight: bold;">Daftar</a>
                </p>
            </div>
        </div>
    </div>

</body>
</html>