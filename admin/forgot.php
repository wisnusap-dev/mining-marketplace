<?php
include "../config/database.php";

if(isset($_POST['reset'])){
    $username = $_POST['username'];
    $newpass = $_POST['password'];

    // VALIDASI PASSWORD
    if(!preg_match('/^(?=.*[A-Z])(?=.*[0-9]).{8,}$/', $newpass)){
        $error = "Password minimal 8 karakter, harus ada huruf besar & angka!";
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
<html>
<head>
<title>Reset Password</title>
<link rel="stylesheet" href="../css/admin.css">
</head>

<body>

<div class="login-box">
    <h2>Reset Password</h2>

    <?php if(isset($error)){ ?>
        <p style="color:red;"><?php echo $error; ?></p>
    <?php } ?>

    <form method="POST">
        <input type="text" name="username" placeholder="Username" required><br><br>
        <input type="password" name="password" placeholder="Password Baru" required><br><br>
        <button type="submit" name="reset">Reset</button>
    </form>

    <p><a href="login.php">Kembali ke login</a></p>
</div>

</body>
</html>