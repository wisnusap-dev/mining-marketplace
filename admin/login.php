<?php
session_start();
include "../config/database.php";

$error = '';

if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];
    $query    = mysqli_query($conn, "SELECT * FROM admin WHERE username='$username'");

    if (mysqli_num_rows($query) > 0) {
        $data = mysqli_fetch_assoc($query);
        if (password_verify($password, $data['password'])) {
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['username']        = $data['username'];
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
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Admin — Mining Market</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    :root {
      --brown:      #2c1a0e;
      --brown-mid:  #3d2b1f;
      --gold:       #d4aa61;
      --gold-light: #e8c98a;
      --cream:      #fdf6ec;
      --bg:         #f7f3ee;
      --border:     #ede8e2;
      --red:        #e53935;
    }

    html, body {
      height: 100%;
      font-family: 'Inter', sans-serif;
    }

    /* PAGE LOADER */
    #page-loader {
      position: fixed;
      inset: 0;
      background: var(--brown);
      z-index: 9999;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      gap: 18px;
      transition: opacity 0.4s ease, visibility 0.4s ease;
    }

    #page-loader.hidden { opacity: 0; visibility: hidden; }

    .loader-logo {
      font-size: 1.2rem;
      font-weight: 700;
      color: var(--gold);
      letter-spacing: 3px;
      text-transform: uppercase;
    }

    .loader-bar {
      width: 160px;
      height: 3px;
      background: rgba(255,255,255,0.1);
      border-radius: 99px;
      overflow: hidden;
    }

    .loader-bar-fill {
      height: 100%;
      background: var(--gold);
      border-radius: 99px;
      animation: fill 0.8s ease forwards;
    }

    @keyframes fill { from { width: 0; } to { width: 100%; } }

    body {
      background: var(--bg);
      display: flex;
      align-items: center;
      justify-content: center;
      min-height: 100vh;
      padding: 20px;
      position: relative;
    }

    /* Background pattern */
    body::before {
      content: '';
      position: fixed;
      inset: 0;
      background-image:
        radial-gradient(circle at 20% 20%, rgba(212,170,97,0.08) 0%, transparent 50%),
        radial-gradient(circle at 80% 80%, rgba(44,26,14,0.06) 0%, transparent 50%);
      pointer-events: none;
    }

    .login-wrap {
      width: 100%;
      max-width: 420px;
      animation: slideUp 0.5s ease forwards;
      opacity: 0;
    }

    @keyframes slideUp {
      from { opacity: 0; transform: translateY(24px); }
      to   { opacity: 1; transform: translateY(0); }
    }

    .brand-header {
      text-align: center;
      margin-bottom: 32px;
    }

    .brand-icon {
      font-size: 2.5rem;
      margin-bottom: 12px;
    }

    .brand-header h1 {
      font-size: 1.5rem;
      font-weight: 700;
      color: var(--brown);
      letter-spacing: 1px;
    }

    .brand-header p {
      font-size: 0.82rem;
      color: #999;
      margin-top: 4px;
    }

    .login-card {
      background: #fff;
      border-radius: 18px;
      border: 1px solid var(--border);
      padding: 36px;
      box-shadow: 0 8px 40px rgba(44,26,14,0.10);
    }

    .form-group { margin-bottom: 18px; }

    .form-group label {
      display: block;
      font-size: 0.72rem;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 1.5px;
      color: #777;
      margin-bottom: 8px;
    }

    .form-group input {
      width: 100%;
      padding: 13px 16px;
      border: 1.5px solid var(--border);
      border-radius: 10px;
      font-family: 'Inter', sans-serif;
      font-size: 0.92rem;
      color: var(--brown);
      background: var(--bg);
      outline: none;
      transition: border-color 0.2s, box-shadow 0.2s;
    }

    .form-group input:focus {
      border-color: var(--gold);
      box-shadow: 0 0 0 3px rgba(212,170,97,0.15);
      background: #fff;
    }

    .error-box {
      background: #fff0f0;
      border: 1px solid #ffcccc;
      color: var(--red);
      padding: 11px 14px;
      border-radius: 9px;
      font-size: 0.82rem;
      font-weight: 500;
      margin-bottom: 18px;
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .btn-login {
      width: 100%;
      padding: 14px;
      background: var(--brown);
      color: #fff;
      border: none;
      border-radius: 10px;
      font-family: 'Inter', sans-serif;
      font-size: 0.95rem;
      font-weight: 600;
      cursor: pointer;
      transition: background 0.2s, transform 0.1s;
      margin-top: 4px;
      letter-spacing: 0.5px;
    }

    .btn-login:hover  { background: var(--gold); color: var(--brown); }
    .btn-login:active { transform: scale(0.99); }

    .login-footer {
      text-align: center;
      margin-top: 22px;
      font-size: 0.8rem;
      color: #aaa;
    }

    .login-footer a {
      color: var(--brown-mid);
      text-decoration: none;
      font-weight: 500;
    }

    .login-footer a:hover { color: var(--gold); }

    /* SVG animated text */
    @import url("https://fonts.googleapis.com/css2?family=Russo+One&display=swap");

    .animated-brand svg {
      font-family: 'Russo One', sans-serif;
      width: 100%;
      height: 50px;
      display: block;
      margin-bottom: 8px;
    }

    .animated-brand svg text {
      animation: stroke-anim 4s infinite alternate;
      stroke-width: 2;
      stroke: var(--gold);
      font-size: 36px;
      fill: rgba(44,26,14,0);
    }

    @keyframes stroke-anim {
      0%   { fill: rgba(44,26,14,0); stroke: var(--gold); stroke-dashoffset: 25%; stroke-dasharray: 0 50%; stroke-width: 2; }
      100% { fill: rgba(44,26,14,1); stroke: transparent; stroke-dashoffset: -25%; stroke-dasharray: 50% 0; stroke-width: 0; }
    }
  </style>
</head>
<body>

<!-- PAGE LOADER -->
<div id="page-loader">
  <div class="loader-logo">Mining Market</div>
  <div class="loader-bar"><div class="loader-bar-fill"></div></div>
</div>

<div class="login-wrap">
  <div class="brand-header animated-brand">
    <svg viewBox="0 0 300 50">
      <text x="50%" y="70%" text-anchor="middle">ADMIN PANEL</text>
    </svg>
    <p>PT Marlinjaya Mesin · Mining Market</p>
  </div>

  <div class="login-card">
    <?php if ($error !== ''): ?>
    <div class="error-box">⚠️ <?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <form method="POST">
      <div class="form-group">
        <label>Username</label>
        <input type="text" name="username" placeholder="Username admin" required autofocus>
      </div>
      <div class="form-group">
        <label>Password</label>
        <input type="password" name="password" placeholder="••••••••" required>
      </div>
      <button type="submit" name="login" class="btn-login">Masuk ke Dashboard →</button>
    </form>

    <div class="login-footer">
      <a href="forgot.php">Lupa password?</a>
      &nbsp;·&nbsp;
      <a href="../login.php">← Halaman User</a>
    </div>
  </div>
</div>

<script>
  window.addEventListener('load', function () {
    const loader = document.getElementById('page-loader');
    if (loader) setTimeout(() => loader.classList.add('hidden'), 700);
  });
</script>
</body>
</html>
