<?php
session_start();
include "config/database.php";

if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $query = mysqli_query($conn, "SELECT * FROM users WHERE username='$username' AND password='$password'");
    if (mysqli_num_rows($query) > 0) {
        $data = mysqli_fetch_assoc($query);
        $_SESSION['user_id'] = $data['id_user'];
        $_SESSION['username'] = $data['username'];
        echo "<script>alert('Selamat Datang, " . $data['username'] . "!'); window.location='user/index.php';</script>";
    } else {
        echo "<script>document.addEventListener('DOMContentLoaded',function(){ showError('Username atau Password salah.'); });</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login — Mining Market</title>
<link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
<style>
  *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

  :root {
    --brown: #2c1a0e;
    --brown-mid: #3d2b1f;
    --gold: #c9973a;
    --gold-light: #e8c070;
    --cream: #fdf6ec;
    --text-muted: #8a7060;
    --white: #ffffff;
  }

  body {
    min-height: 100vh;
    display: flex;
    font-family: 'DM Sans', sans-serif;
    background: var(--brown);
    overflow: hidden;
  }

  /* LEFT PANEL */
  .panel-left {
    flex: 1;
    position: relative;
    display: flex;
    flex-direction: column;
    justify-content: center;
    padding: 60px;
    overflow: hidden;
  }

  .panel-left::before {
    content: '';
    position: absolute;
    inset: 0;
    background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23c9973a' fill-opacity='0.06'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
  }

  .brand-tag {
    display: inline-block;
    background: var(--gold);
    color: var(--brown);
    font-family: 'Bebas Neue', sans-serif;
    font-size: 0.75rem;
    letter-spacing: 4px;
    padding: 6px 16px;
    border-radius: 2px;
    margin-bottom: 32px;
    width: fit-content;
  }

  .panel-left h1 {
    font-family: 'Bebas Neue', sans-serif;
    font-size: clamp(3rem, 5vw, 5.5rem);
    color: var(--cream);
    line-height: 0.95;
    letter-spacing: 2px;
    margin-bottom: 24px;
  }

  .panel-left h1 span {
    display: block;
    color: var(--gold);
  }

  .panel-left p {
    color: var(--text-muted);
    font-size: 1rem;
    line-height: 1.7;
    max-width: 380px;
  }

  .deco-line {
    position: absolute;
    bottom: 0;
    right: 0;
    width: 200px;
    height: 200px;
    border-top: 1px solid rgba(201,151,58,0.2);
    border-left: 1px solid rgba(201,151,58,0.2);
    border-radius: 8px 0 0 0;
  }

  .deco-circle {
    position: absolute;
    top: -80px;
    right: -80px;
    width: 300px;
    height: 300px;
    border-radius: 50%;
    border: 1px solid rgba(201,151,58,0.12);
  }

  /* RIGHT PANEL */
  .panel-right {
    width: 460px;
    background: var(--cream);
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 60px 50px;
    position: relative;
  }

  .login-box { width: 100%; }

  .login-box .eyebrow {
    font-size: 0.7rem;
    letter-spacing: 4px;
    text-transform: uppercase;
    color: var(--gold);
    font-weight: 600;
    margin-bottom: 12px;
  }

  .login-box h2 {
    font-family: 'Bebas Neue', sans-serif;
    font-size: 2.8rem;
    color: var(--brown);
    letter-spacing: 2px;
    margin-bottom: 8px;
  }

  .login-box .subtitle {
    color: var(--text-muted);
    font-size: 0.9rem;
    margin-bottom: 40px;
  }

  .form-group {
    margin-bottom: 20px;
    position: relative;
  }

  .form-group label {
    display: block;
    font-size: 0.75rem;
    font-weight: 600;
    letter-spacing: 2px;
    text-transform: uppercase;
    color: var(--brown-mid);
    margin-bottom: 8px;
  }

  .form-group input {
    width: 100%;
    padding: 14px 16px;
    background: white;
    border: 1.5px solid #e0d4c8;
    border-radius: 8px;
    font-family: 'DM Sans', sans-serif;
    font-size: 0.95rem;
    color: var(--brown);
    transition: border-color 0.2s, box-shadow 0.2s;
    outline: none;
  }

  .form-group input:focus {
    border-color: var(--gold);
    box-shadow: 0 0 0 3px rgba(201,151,58,0.12);
  }

  .form-group input::placeholder { color: #bbb; }

  .error-msg {
    display: none;
    background: #fff0f0;
    border: 1px solid #ffcccc;
    color: #c0392b;
    padding: 10px 14px;
    border-radius: 6px;
    font-size: 0.85rem;
    margin-bottom: 18px;
  }

  .btn-login {
    width: 100%;
    padding: 15px;
    background: var(--brown);
    color: var(--cream);
    border: none;
    border-radius: 8px;
    font-family: 'Bebas Neue', sans-serif;
    font-size: 1.2rem;
    letter-spacing: 3px;
    cursor: pointer;
    transition: background 0.2s, transform 0.1s;
    margin-top: 8px;
  }

  .btn-login:hover { background: var(--gold); color: var(--brown); }
  .btn-login:active { transform: scale(0.99); }

  .back-link {
    display: block;
    text-align: center;
    margin-top: 20px;
    color: var(--text-muted);
    text-decoration: none;
    font-size: 0.85rem;
    transition: color 0.2s;
  }
  .back-link:hover { color: var(--brown); }

  /* Responsive */
  @media (max-width: 768px) {
    body { flex-direction: column; overflow: auto; }
    .panel-left { padding: 50px 30px 30px; flex: none; }
    .panel-left h1 { font-size: 3.5rem; }
    .panel-right { width: 100%; padding: 40px 30px 60px; }
  }
</style>
</head>
<body>

<div class="panel-left">
  <div class="deco-circle"></div>
  <div class="deco-line"></div>
  <div class="brand-tag">Mining Market</div>
  <h1>PT MARLIN<span>JAYA MESIN</span></h1>
  <p>Platform pemesanan alat berat dan mesin tambang terpercaya. Temukan mesin bersertifikasi untuk operasional pertambangan Anda.</p>
</div>

<div class="panel-right">
  <div class="login-box">
    <div class="eyebrow">Akses Platform</div>
    <h2>Masuk</h2>
    <p class="subtitle">Masukkan kredensial Anda untuk melanjutkan.</p>

    <div class="error-msg" id="errorMsg"></div>

    <form method="POST">
      <div class="form-group">
        <label>Username</label>
        <input type="text" name="username" placeholder="username Anda" required>
      </div>
      <div class="form-group">
        <label>Password</label>
        <input type="password" name="password" placeholder="••••••••" required>
      </div>
      <button type="submit" name="login" class="btn-login">Masuk →</button>
    </form>
    <a href="index.php" class="back-link">← Kembali ke Beranda</a>
  </div>
</div>

<script>
function showError(msg) {
  const el = document.getElementById('errorMsg');
  el.textContent = msg;
  el.style.display = 'block';
}
</script>
</body>
</html>