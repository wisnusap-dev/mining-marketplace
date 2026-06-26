<?php
session_start();
include "../config/database.php";

$error = '';

if (isset($_POST['register'])) {
    $username = mysqli_real_escape_string($conn, trim($_POST['username']));
    $password = $_POST['password'];

    // Validasi Password (minimal 8 karakter, ada huruf besar & angka)
    if (!preg_match('/^(?=.*[A-Z])(?=.*[0-9]).{8,}$/', $password)) {
        $error = "Password min 8 karakter, harus ada huruf besar & angka!";
    } else {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        
        // Cek apakah username sudah ada
        $cek = mysqli_query($conn, "SELECT * FROM admin WHERE username='$username'");
        if (mysqli_num_rows($cek) > 0) {
            $error = "Username sudah dipakai!";
        } else {
            $query = "INSERT INTO admin (username, password) VALUES ('$username', '$hash')";
            if (mysqli_query($conn, $query)) {
                echo "<script>alert('Registrasi Admin Berhasil!'); window.location='login.php';</script>";
            } else {
                $error = "Gagal registrasi: " . mysqli_error($conn);
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Register Admin — Mining Market</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <style>
    /* Gunakan CSS yang persis dengan login.php lu agar tampilannya sama */
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    :root { --brown: #2c1a0e; --gold: #d4aa61; --bg: #f7f3ee; --border: #ede8e2; --red: #e53935; }
    body { font-family: 'Inter', sans-serif; background: var(--bg); display: flex; align-items: center; justify-content: center; min-height: 100vh; padding: 20px; }
    .login-wrap { width: 100%; max-width: 420px; }
    .brand-header { text-align: center; margin-bottom: 32px; }
    .login-card { background: #fff; border-radius: 18px; border: 1px solid var(--border); padding: 36px; box-shadow: 0 8px 40px rgba(44,26,14,0.10); }
    .form-group { margin-bottom: 18px; }
    .form-group label { display: block; font-size: 0.72rem; font-weight: 600; text-transform: uppercase; color: #777; margin-bottom: 8px; }
    .form-group input { width: 100%; padding: 13px 16px; border: 1.5px solid var(--border); border-radius: 10px; background: var(--bg); outline: none; }
    .form-group input:focus { border-color: var(--gold); }
    .btn-login { width: 100%; padding: 14px; background: var(--brown); color: #fff; border: none; border-radius: 10px; cursor: pointer; font-weight: 600; }
    .btn-login:hover { background: var(--gold); color: var(--brown); }
    .error-box { background: #fff0f0; border: 1px solid #ffcccc; color: var(--red); padding: 11px; border-radius: 9px; font-size: 0.8rem; margin-bottom: 15px; }
  </style>
</head>
<body>

<div class="login-wrap">
  <div class="brand-header">
    <h1>REGISTER ADMIN</h1>
    <p>PT Marlinjaya Mesin · Mining Market</p>
  </div>

  <div class="login-card">
    <?php if ($error !== ''): ?>
    <div class="error-box">⚠️ <?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <form method="POST">
      <div class="form-group">
        <label>Username</label>
        <input type="text" name="username" placeholder="Buat username baru" required autofocus>
      </div>
      <div class="form-group">
        <label>Password</label>
        <input type="password" name="password" placeholder="••••••••" required>
      </div>
      <button type="submit" name="register" class="btn-login">Daftar Sekarang →</button>
    </form>

    <div style="margin-top: 20px; text-align: center; font-size: 0.85rem;">
        <a href="login.php" style="color: var(--brown); font-weight: 600; text-decoration: none;">Sudah punya akun? Login</a>
    </div>
  </div>
</div>

</body>
</html>