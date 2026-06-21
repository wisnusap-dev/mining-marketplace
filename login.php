<?php
ob_start();
session_start();
include "config/database.php";

$login_error = '';

if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($conn, trim($_POST['username']));
    $password = trim($_POST['password']);

    // ── Cari user (username atau email) ──────────────────────────
    $query = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");

    // Jika tidak ketemu by username, coba by email (kalau kolom email ada)
    if (!$query || mysqli_num_rows($query) === 0) {
        $query = mysqli_query($conn, "SELECT * FROM users WHERE email='$username'");
    }

    if ($query && mysqli_num_rows($query) > 0) {
        $data  = mysqli_fetch_assoc($query);

        // ── Deteksi nama kolom ID yang dipakai di database ───────
        // Bisa: id_user, id, user_id — cek ketiganya
        // Kolom ID — dari screenshot DB pakai id_user
        $user_id_val = $data['id_user'] ?? $data['id'] ?? $data['user_id'] ?? null;

        // ── Deteksi nama kolom password ───────────────────────────
        $db_pw = $data['password'] ?? $data['pass'] ?? $data['passwd'] ?? '';

        // ── Deteksi kolom username ────────────────────────────────
        $uname = $data['username'] ?? $data['user'] ?? $data['nama'] ?? $username;

        // ── Cek password: hash, plain text, md5 ──────────────────
        $ok = !empty($db_pw) && (
            password_verify($password, $db_pw)
            || ($db_pw === $password)
            || ($db_pw === md5($password))
            || ($db_pw === sha1($password))
        );

        if ($ok) {
            // Upgrade plain/md5 ke hash
            if ($db_pw !== password_hash($password, PASSWORD_DEFAULT)
                && !password_verify($password, $db_pw)) {
                $new_hash = password_hash($password, PASSWORD_DEFAULT);
                $uid = (int) $user_id_val;
                // Coba update dengan nama kolom id yang benar
                foreach (['id_user','id','user_id'] as $col) {
                    if (isset($data[$col])) {
                        mysqli_query($conn, "UPDATE users SET password='$new_hash' WHERE $col='$uid'");
                        break;
                    }
                }
            }

            $_SESSION['user_id']  = $user_id_val;
            $_SESSION['username'] = $uname;

            // Redirect ke halaman user
            header("Location: user/index.php");
            ob_end_flush();
            exit();
        } else {
            $login_error = "Password salah.";
        }
    } else {
        // Tampilkan error MySQL jika ada (membantu debug)
        $mysql_err = mysqli_error($conn);
        $login_error = "Akun tidak ditemukan."
            . ($mysql_err ? " [DB: $mysql_err]" : "");
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
      --brown:      #2c1a0e;
      --brown-mid:  #3d2b1f;
      --gold:       #c9973a;
      --gold-light: #e8c070;
      --cream:      #fdf6ec;
      --bg:         #f5ede2;
      --muted:      #8a7060;
      --red:        #c0392b;
      --border:     #e0d4c8;
    }
    html, body { height: 100%; }
    body { font-family: 'DM Sans', sans-serif; background: var(--brown); display: flex; min-height: 100vh; }

    /* LOADER */
    #loader { position:fixed;inset:0;z-index:9999;background:var(--brown);display:flex;flex-direction:column;align-items:center;justify-content:center;gap:18px;transition:opacity .45s ease,visibility .45s ease; }
    #loader.out { opacity:0;visibility:hidden; }
    .ld-gear  { font-size:2.6rem;animation:spin 1.3s linear infinite; }
    .ld-brand { font-family:'Bebas Neue',sans-serif;font-size:1.4rem;letter-spacing:4px;color:var(--gold); }
    .ld-bar   { width:140px;height:2px;background:rgba(255,255,255,.1);border-radius:99px;overflow:hidden; }
    .ld-fill  { height:100%;background:var(--gold);animation:fill .8s ease forwards; }
    @keyframes spin { to { transform:rotate(360deg); } }
    @keyframes fill { from { width:0; } to { width:100%; } }

    /* LEFT */
    .panel-left { flex:1;position:relative;display:flex;flex-direction:column;justify-content:center;padding:60px;overflow:hidden; }
    .panel-left::before { content:'';position:absolute;inset:0;background:url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23c9973a' fill-opacity='0.06'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");pointer-events:none; }
    .deco-ring { position:absolute;border-radius:50%;border:1px solid rgba(201,151,58,.1);pointer-events:none; }
    .deco-ring.r1 { width:320px;height:320px;top:-100px;right:-100px; }
    .deco-ring.r2 { width:500px;height:500px;bottom:-200px;right:-220px;border-color:rgba(201,151,58,.05); }
    .deco-corner { position:absolute;bottom:0;right:0;width:180px;height:180px;border-top:1px solid rgba(201,151,58,.2);border-left:1px solid rgba(201,151,58,.2);border-radius:8px 0 0 0;pointer-events:none; }
    .brand-pill { display:inline-flex;align-items:center;gap:8px;background:var(--gold);color:var(--brown);font-family:'Bebas Neue',sans-serif;font-size:.72rem;letter-spacing:4px;padding:6px 16px;border-radius:2px;margin-bottom:32px;width:fit-content;position:relative;z-index:1; }
    .panel-left h1 { font-family:'Bebas Neue',sans-serif;font-size:clamp(3rem,5vw,5.5rem);color:var(--cream);line-height:.95;letter-spacing:2px;margin-bottom:22px;position:relative;z-index:1; }
    .panel-left h1 span { display:block;color:var(--gold); }
    .panel-left p { color:var(--muted);font-size:.95rem;line-height:1.75;max-width:360px;position:relative;z-index:1; }
    .feature-list { margin-top:36px;display:flex;flex-direction:column;gap:14px;position:relative;z-index:1; }
    .feat { display:flex;align-items:center;gap:12px; }
    .feat-dot { width:7px;height:7px;border-radius:50%;background:var(--gold);flex-shrink:0;box-shadow:0 0 8px rgba(201,151,58,.5); }
    .feat span { font-size:.85rem;color:rgba(253,246,236,.6); }

    /* RIGHT */
    .panel-right { width:480px;background:var(--cream);display:flex;align-items:center;justify-content:center;padding:60px 50px;position:relative; }
    .auth-box { width:100%;animation:slideIn .5s ease both; }
    @keyframes slideIn { from{opacity:0;transform:translateY(20px);}to{opacity:1;transform:translateY(0);} }
    .eyebrow { font-size:.68rem;letter-spacing:4px;text-transform:uppercase;color:var(--gold);font-weight:600;margin-bottom:10px; }
    .auth-box h2 { font-family:'Bebas Neue',sans-serif;font-size:2.8rem;color:var(--brown);letter-spacing:2px;margin-bottom:6px; }
    .subtitle { color:var(--muted);font-size:.88rem;margin-bottom:28px;line-height:1.6; }

    /* Google */
    .btn-google { width:100%;display:flex;align-items:center;justify-content:center;gap:12px;padding:13px 20px;background:#fff;border:1.5px solid var(--border);border-radius:9px;font-family:'DM Sans',sans-serif;font-size:.9rem;font-weight:600;color:#3c4043;cursor:pointer;transition:border-color .2s,box-shadow .2s,background .2s;text-decoration:none;margin-bottom:22px; }
    .btn-google:hover { border-color:#4285f4;box-shadow:0 3px 14px rgba(66,133,244,.15);background:#fafcff; }

    /* Divider */
    .or-divider { display:flex;align-items:center;gap:12px;margin-bottom:22px; }
    .or-divider::before,.or-divider::after { content:'';flex:1;height:1px;background:var(--border); }
    .or-divider span { font-size:.7rem;letter-spacing:2px;text-transform:uppercase;color:#c5b8ac;white-space:nowrap; }

    /* Form */
    .form-group { margin-bottom:18px; }
    .form-group label { display:block;font-size:.7rem;font-weight:600;letter-spacing:2px;text-transform:uppercase;color:var(--brown-mid);margin-bottom:8px; }
    .input-wrap { position:relative; }
    .input-ico { position:absolute;left:14px;top:50%;transform:translateY(-50%);font-size:.9rem;opacity:.4;pointer-events:none; }
    .eye { position:absolute;right:14px;top:50%;transform:translateY(-50%);font-size:.95rem;cursor:pointer;opacity:.4;transition:opacity .2s;user-select:none; }
    .eye:hover { opacity:.8; }
    .form-group input { width:100%;padding:13px 42px 13px 40px;background:#fff;border:1.5px solid var(--border);border-radius:9px;font-family:'DM Sans',sans-serif;font-size:.93rem;color:var(--brown);outline:none;transition:border-color .2s,box-shadow .2s; }
    .form-group input:focus { border-color:var(--gold);box-shadow:0 0 0 3px rgba(201,151,58,.12); }
    .form-group input::placeholder { color:#c5b8ac; }

    /* Error */
    .alert-err { display:flex;align-items:flex-start;gap:9px;background:#fff0f0;border:1px solid #ffcccc;color:var(--red);padding:12px 14px;border-radius:8px;font-size:.84rem;margin-bottom:18px;line-height:1.5; }

    /* Meta */
    .form-meta { display:flex;justify-content:space-between;align-items:center;margin-bottom:22px; }
    .remember { display:flex;align-items:center;gap:7px;font-size:.82rem;color:var(--muted);cursor:pointer; }
    .remember input[type=checkbox] { width:15px;height:15px;accent-color:var(--gold);cursor:pointer; }
    .forgot { font-size:.82rem;color:var(--muted);text-decoration:none;transition:color .2s; }
    .forgot:hover { color:var(--brown); }

    /* Submit */
    .btn-submit { width:100%;padding:14px;background:var(--brown);color:var(--cream);border:none;border-radius:9px;font-family:'Bebas Neue',sans-serif;font-size:1.15rem;letter-spacing:3px;cursor:pointer;transition:background .2s,transform .1s,box-shadow .2s;position:relative;overflow:hidden; }
    .btn-submit:hover { background:var(--gold);color:var(--brown);box-shadow:0 6px 20px rgba(201,151,58,.3); }
    .btn-submit:active { transform:scale(.99); }
    .btn-submit:disabled { opacity:.65;cursor:not-allowed; }

    /* Bottom */
    .bottom-link { text-align:center;margin-top:22px;font-size:.85rem;color:var(--muted); }
    .bottom-link a { color:var(--brown);font-weight:600;text-decoration:none;transition:color .2s; }
    .bottom-link a:hover { color:var(--gold); }

    @media (max-width:820px) { body{flex-direction:column;overflow-y:auto;} .panel-left{flex:none;padding:48px 28px 32px;} .feature-list{display:none;} .panel-right{width:100%;padding:40px 28px 60px;} }
    @media (max-width:420px) { .panel-right{padding:32px 18px 50px;} }
  </style>
</head>
<body>

<div id="loader">
  <div class="ld-gear">⚙️</div>
  <div class="ld-brand">Mining Market</div>
  <div class="ld-bar"><div class="ld-fill"></div></div>
</div>

<!-- LEFT -->
<div class="panel-left">
  <div class="deco-ring r1"></div>
  <div class="deco-ring r2"></div>
  <div class="deco-corner"></div>
  <div class="brand-pill">⛏ Mining Market</div>
  <h1>PT MARLIN<span>JAYA MESIN</span></h1>
  <p>Platform pemesanan alat berat & mesin tambang terpercaya. Beroperasi lebih efisien dengan mesin bersertifikat kami.</p>
  <div class="feature-list">
    <div class="feat"><div class="feat-dot"></div><span>200+ unit mesin siap kirim</span></div>
    <div class="feat"><div class="feat-dot"></div><span>Garansi resmi & suku cadang asli</span></div>
    <div class="feat"><div class="feat-dot"></div><span>Dukungan teknis 24/7</span></div>
    <div class="feat"><div class="feat-dot"></div><span>Pengiriman ke seluruh Indonesia</span></div>
  </div>
</div>

<!-- RIGHT -->
<div class="panel-right">
  <div class="auth-box">
    <div class="eyebrow">Akses Platform</div>
    <h2>Masuk</h2>
    <p class="subtitle">Selamat datang kembali. Masuk untuk melanjutkan.</p>

    <?php if ($login_error): ?>
    <div class="alert-err">⚠️ <span><?php echo htmlspecialchars($login_error); ?></span></div>
    <?php endif; ?>

    <!-- Google -->
    <a href="auth/google.php" class="btn-google">
      <svg width="18" height="18" viewBox="0 0 18 18">
        <path fill="#4285F4" d="M17.64 9.2c0-.637-.057-1.251-.164-1.84H9v3.481h4.844a4.14 4.14 0 0 1-1.796 2.716v2.259h2.908c1.702-1.567 2.684-3.875 2.684-6.615z"/>
        <path fill="#34A853" d="M9 18c2.43 0 4.467-.806 5.956-2.18l-2.908-2.259c-.806.54-1.837.86-3.048.86-2.344 0-4.328-1.584-5.036-3.711H.957v2.332A8.997 8.997 0 0 0 9 18z"/>
        <path fill="#FBBC05" d="M3.964 10.71A5.41 5.41 0 0 1 3.682 9c0-.593.102-1.17.282-1.71V4.958H.957A8.996 8.996 0 0 0 0 9c0 1.452.348 2.827.957 4.042l3.007-2.332z"/>
        <path fill="#EA4335" d="M9 3.58c1.321 0 2.508.454 3.44 1.345l2.582-2.58C13.463.891 11.426 0 9 0A8.997 8.997 0 0 0 .957 4.958L3.964 7.29C4.672 5.163 6.656 3.58 9 3.58z"/>
      </svg>
      Lanjutkan dengan Google
    </a>

    <div class="or-divider"><span>atau masuk dengan username</span></div>

    <form method="POST" action="login.php" id="loginForm">
      <div class="form-group">
        <label>Username / Email</label>
        <div class="input-wrap">
          <span class="input-ico">👤</span>
          <input type="text" name="username" placeholder="Username atau email"
                 autocomplete="username" required
                 value="<?php echo htmlspecialchars($_POST['username'] ?? ''); ?>">
        </div>
      </div>
      <div class="form-group">
        <label>Password</label>
        <div class="input-wrap">
          <span class="input-ico">🔒</span>
          <input type="password" name="password" id="pwField"
                 placeholder="••••••••" autocomplete="current-password" required>
          <span class="eye" id="eyeBtn" onclick="toggleEye()">👁</span>
        </div>
      </div>

      <div class="form-meta">
        <label class="remember">
          <input type="checkbox" name="remember"> Ingat saya
        </label>
        <a href="#" class="forgot">Lupa password?</a>
      </div>

      <button type="submit" name="login" class="btn-submit" id="loginBtn">Masuk →</button>
    </form>

    <div class="bottom-link">
      Belum punya akun? <a href="register.php">Daftar di sini →</a>
    </div>
  </div>
</div>

<script>
// Loader
window.addEventListener('load', () => {
  setTimeout(() => document.getElementById('loader').classList.add('out'), 500);
});

// Show/hide password
function toggleEye() {
  const inp = document.getElementById('pwField');
  const btn = document.getElementById('eyeBtn');
  inp.type  = inp.type === 'password' ? 'text' : 'password';
  btn.textContent = inp.type === 'password' ? '👁' : '🙈';
}

// Submit button — loading state tapi TIDAK disable permanen
document.getElementById('loginForm').addEventListener('submit', function(e) {
  const btn = document.getElementById('loginBtn');
  btn.textContent = 'Memproses...';
  // Re-enable setelah 4 detik (fallback jika error dari server)
  setTimeout(() => {
    btn.textContent = 'Masuk →';
    btn.disabled    = false;
    btn.style.opacity = '1';
  }, 4000);
});
</script>
</body>
</html>
