<?php
include "../config/database.php";

if(isset($_POST['register'])){
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validasi Password (min 8 karakter, ada huruf besar & angka)
    if(!preg_match('/^(?=.*[A-Z])(?=.*[0-9]).{8,}$/', $password)){
        $error = "Password minimal 8 karakter, harus ada huruf besar & angka!";
    } else {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        
        // Simpan ke tabel admin
        $query = "INSERT INTO admin (username, password) VALUES ('$username', '$hash')";
        if(mysqli_query($conn, $query)){
            echo "<script>alert('Registrasi Berhasil!'); window.location='admin.php';</script>";
        } else {
            $error = "Gagal registrasi: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register Admin</title>
    <link rel="stylesheet" href="../css/admin.css">
</head>
<body>
    <div class="login-box">
        <h2>Register Admin</h2>
        <?php if(isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
        <form method="POST">
            <input type="text" name="username" placeholder="Username" required><br><br>
            <input type="password" name="password" placeholder="Password" required><br><br>
            <button type="submit" name="register">Daftar Sekarang</button>
        </form>
        <p><a href="admin.php">Sudah punya akun? Login</a></p>
    </div>
</body>
</html>