<?php
session_start();
include "../config/database.php";

$error = '';

if(isset($_POST['reset'])){
    $username = mysqli_real_escape_string($conn, trim($_POST['username']));
    $newpass = $_POST['password'];

    // VALIDASI PASSWORD
    if(!preg_match('/^(?=.*[A-Z])(?=.*[0-9]).{8,}$/', $newpass)){
        $error = "Password min 8 karakter, harus ada huruf besar & angka!";
    } else {
        $hash = password_hash($newpass, PASSWORD_DEFAULT);
        
        $cek = mysqli_query($conn, "SELECT * FROM admin WHERE username='$username'");
        if(mysqli_num_rows($cek) > 0){
            mysqli_query($conn, "UPDATE admin SET password='$hash' WHERE username='$username'");
            echo "<script>alert('Password berhasil diubah!'); window.location='login.php';</script>";
        } else {
            $error = "Username tidak ditemukan!";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Reset Password Admin</title>
    <link rel="stylesheet" href="../css/admin_layout.css"> 
    <style>
        /* CSS Tambahan agar box reset password lu rapi */
        .reset-box { width: 100%; max-width: 400px; background: #fff; padding: 40px; border-radius: 18px; border: 1px solid #ede8e2; box-shadow: 0 8px 40px rgba(44,26,14,0.10); margin: 100px auto; text-align: center; }
        .reset-box h2 { font-family: 'Bebas Neue', sans-serif; color: #2c1a0e; margin-bottom: 20px; }
        input { width: 100%; padding: 12px; margin-bottom: 15px; border: 1px solid #ede8e2; border-radius: 8px; }
        button { width: 100%; padding: 12px; background: #2c1a0e; color: #fff; border: none; border-radius: 8px; cursor: pointer; }
        button:hover { background: #d4aa61; }
    </style>
</head>
<body>
    <div class="reset-box">
        <h2>Reset Password</h2>
        <?php if($error): ?>
            <p style="color:red; font-size: 0.85rem; margin-bottom: 15px;"><?php echo $error; ?></p>
        <?php endif; ?>

        <form method="POST">
            <input type="text" name="username" placeholder="Masukkan Username Admin" required>
            <input type="password" name="password" placeholder="Masukkan Password Baru" required>
            <button type="submit" name="reset">Ubah Password</button>
        </form>

        <p style="margin-top: 20px; font-size: 0.8rem;"><a href="login.php" style="color:#d4aa61;">← Kembali ke login</a></p>
    </div>
</body>
</html>