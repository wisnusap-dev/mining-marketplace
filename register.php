<?php
ob_start();
session_start();
include "config/database.php";

$error   = '';
$success = '';

if (isset($_POST['register'])) {
    $username     = mysqli_real_escape_string($conn, trim($_POST['username']));
    $email        = mysqli_real_escape_string($conn, trim($_POST['email']));
    $password     = $_POST['password'];
    $confirm      = $_POST['confirm_password'];
    $nama_lengkap = mysqli_real_escape_string($conn, trim($_POST['nama_lengkap'] ?? ''));
    $no_telepon   = mysqli_real_escape_string($conn, trim($_POST['no_telepon'] ?? ''));

    // Validasi — nama_lengkap tidak wajib (menyesuaikan struktur DB)
    if (empty($username) || empty($email) || empty($password)) {
        $error = "Username, email, dan password wajib diisi.";
    } elseif (strlen($username) < 4) {
        $error = "Username minimal 4 karakter.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Format email tidak valid.";
    } elseif (strlen($password) < 6) {
        $error = "Password minimal 6 karakter.";
    } elseif ($password !== $confirm) {
        $error = "Password dan konfirmasi tidak cocok.";
    } else {
        // Cek duplikat
        $cek = mysqli_query($conn, "SELECT id_user FROM users WHERE username='$username' OR email='$email'");
        if (mysqli_num_rows($cek) > 0) {
            $error = "Username atau email sudah digunakan.";
        } else {
            $hashed = password_hash($password, PASSWORD_DEFAULT);

            // Coba INSERT lengkap dulu (dengan semua kolom yang ada di DB kamu)
            $q = mysqli_query($conn,
                "INSERT INTO users (username, email, password, nama_lengkap, no_telepon)
                 VALUES ('$username', '$email', '$hashed', '$nama_lengkap', '$no_telepon')"
            );

            // Fallback 1: tanpa no_telepon
            if (!$q) {
                $q = mysqli_query($conn,
                    "INSERT INTO users (username, email, password, nama_lengkap)
                     VALUES ('$username', '$email', '$hashed', '$nama_lengkap')"
                );
            }

            // Fallback 2: hanya 3 kolom utama
            if (!$q) {
                $q = mysqli_query($conn,
                    "INSERT INTO users (username, email, password)
                     VALUES ('$username', '$email', '$hashed')"
                );
            }

            if ($q) {
                $new_id = mysqli_insert_id($conn);
                $_SESSION['user_id']  = $new_id;
                $_SESSION['username'] = $username;
                header("Location: user/index.php");
                ob_end_flush();
                exit();
            } else {
                // Tampilkan error MySQL yang sebenarnya agar mudah debug
                $error = "Gagal daftar: " . mysqli_error($conn);
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Daftar Akun — Mining Market</title>
  <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    :root {
      --brown:     #2c1a0e;
      --brown-mid: #3d2b1f;
      --gold:      #c9973a;
      --gold-lt:   #e8c070;
      --cream:     #fdf6ec;
      --bg:        #f5ede2;
      --muted:     #8a7060;
      --border:    #e0d4c8;
      --red:       #c0392b;
      --green:     #1e7e34;
    }

    html, body { height: 100%; }

    body {
      font-family: 'DM Sans', sans-serif;
      background: var(--brown);
      display: flex; min-height: 100vh;
    }

    /* ── PAGE LOADER ── */
    #loader {
      position: fixed; inset: 0; z-index: 9999;
      background: var(--brown);
      display: flex; flex-direction: column;
      align-items: center; justify-content: center; gap: 18px;
      transition: opacity .45s ease, visibility .45s ease;
    }
    #loader.out { opacity: 0; visibility: hidden; }
    .ld-gear  { font-size: 2.6rem; animation: spin 1.3s linear infinite; }
    .ld-brand { font-family: 'Bebas Neue',sans-serif; font-size: 1.4rem; letter-spacing: 4px; color: var(--gold); }
    .ld-bar   { width: 140px; height: 2px; background: rgba(255,255,255,.1); border-radius: 99px; overflow: hidden; }
    .ld-fill  { height: 100%; background: var(--gold); animation: fill .8s ease forwards; }
    @keyframes spin { to { transform: rotate(360deg); } }
    @keyframes fill { from { width: 0; } to { width: 100%; } }

    /* ── LEFT PANEL ── */
    .panel-left {
      flex: 1; position: relative;
      display: flex; flex-direction: column; justify-content: center;
      padding: 60px; overflow: hidden;
    }
    .panel-left::before {
      content: ''; position: absolute; inset: 0;
      background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23c9973a' fill-opacity='0.06'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
      pointer-events: none;
    }
    .deco-ring { position: absolute; border-radius: 50%; border: 1px solid rgba(201,151,58,.1); pointer-events: none; }
    .deco-ring.r1 { width: 320px; height: 320px; top: -100px; right: -100px; }
    .deco-ring.r2 { width: 500px; height: 500px; bottom: -200px; right: -220px; border-color: rgba(201,151,58,.05); }
    .deco-corner {
      position: absolute; bottom: 0; right: 0;
      width: 180px; height: 180px;
      border-top: 1px solid rgba(201,151,58,.2);
      border-left: 1px solid rgba(201,151,58,.2);
      border-radius: 8px 0 0 0; pointer-events: none;
    }

    .brand-pill {
      display: inline-flex; align-items: center; gap: 8px;
      background: var(--gold); color: var(--brown);
      font-family: 'Bebas Neue',sans-serif; font-size: .72rem;
      letter-spacing: 4px; padding: 6px 16px; border-radius: 2px;
      margin-bottom: 32px; width: fit-content;
      position: relative; z-index: 1;
    }
    .panel-left h1 {
      font-family: 'Bebas Neue',sans-serif;
      font-size: clamp(3rem,5vw,5.5rem);
      color: var(--cream); line-height: .95;
      letter-spacing: 2px; margin-bottom: 22px;
      position: relative; z-index: 1;
    }
    .panel-left h1 span { display: block; color: var(--gold); }
    .panel-left p {
      color: var(--muted); font-size: .95rem; line-height: 1.75;
      max-width: 360px; position: relative; z-index: 1;
    }

    .steps {
      margin-top: 38px; display: flex; flex-direction: column; gap: 18px;
      position: relative; z-index: 1;
    }
    .step { display: flex; align-items: flex-start; gap: 14px; }
    .step-num {
      width: 30px; height: 30px; border-radius: 50%;
      border: 1px solid rgba(201,151,58,.4);
      display: flex; align-items: center; justify-content: center;
      font-family: 'Bebas Neue',sans-serif; font-size: .85rem;
      color: var(--gold); flex-shrink: 0; margin-top: 1px;
    }
    .step-body strong { display: block; color: rgba(253,246,236,.8); font-size: .88rem; font-weight: 500; margin-bottom: 2px; }
    .step-body span   { font-size: .8rem; color: rgba(253,246,236,.45); }

    /* ── RIGHT PANEL ── */
    .panel-right {
      width: 520px; background: var(--cream);
      display: flex; align-items: flex-start; justify-content: center;
      padding: 48px 50px 60px;
      position: relative; overflow-y: auto;
    }

    .auth-box {
      width: 100%;
      animation: slideIn .5s ease both;
    }
    @keyframes slideIn {
      from { opacity: 0; transform: translateY(20px); }
      to   { opacity: 1; transform: translateY(0); }
    }

    .eyebrow {
      font-size: .68rem; letter-spacing: 4px; text-transform: uppercase;
      color: var(--gold); font-weight: 600; margin-bottom: 10px;
    }
    .auth-box h2 {
      font-family: 'Bebas Neue',sans-serif; font-size: 2.8rem;
      color: var(--brown); letter-spacing: 2px; margin-bottom: 6px;
    }
    .subtitle {
      color: var(--muted); font-size: .87rem; margin-bottom: 26px; line-height: 1.6;
    }

    /* SUCCESS STATE */
    .success-state {
      text-align: center; padding: 32px 0;
    }
    .success-icon { font-size: 3.5rem; margin-bottom: 16px; animation: pop .4s cubic-bezier(.17,.67,.48,1.4) both; }
    @keyframes pop { from { transform: scale(0); } to { transform: scale(1); } }
    .success-state h3 { font-family:'Bebas Neue',sans-serif; font-size: 2rem; color: var(--brown); letter-spacing: 2px; margin-bottom: 8px; }
    .success-state p  { color: var(--muted); font-size: .9rem; margin-bottom: 24px; line-height: 1.6; }
    .btn-to-login {
      display: inline-block; padding: 14px 36px;
      background: var(--brown); color: var(--cream);
      border-radius: 9px; text-decoration: none;
      font-family: 'Bebas Neue',sans-serif; font-size: 1.1rem;
      letter-spacing: 3px; transition: background .2s;
    }
    .btn-to-login:hover { background: var(--gold); color: var(--brown); }

    /* Google button */
    .btn-google {
      width: 100%;
      display: flex; align-items: center; justify-content: center; gap: 12px;
      padding: 13px 20px; background: #fff;
      border: 1.5px solid var(--border); border-radius: 9px;
      font-family: 'DM Sans',sans-serif; font-size: .9rem;
      font-weight: 600; color: #3c4043; cursor: pointer;
      transition: border-color .2s, box-shadow .2s, background .2s;
      text-decoration: none; margin-bottom: 20px;
    }
    .btn-google:hover { border-color: #4285f4; box-shadow: 0 3px 14px rgba(66,133,244,.15); background: #fafcff; }

    /* OR divider */
    .or-div {
      display: flex; align-items: center; gap: 12px; margin-bottom: 20px;
    }
    .or-div::before, .or-div::after { content:''; flex:1; height:1px; background:var(--border); }
    .or-div span { font-size: .68rem; letter-spacing: 2px; text-transform: uppercase; color: #c5b8ac; white-space: nowrap; }

    /* Alert */
    .alert {
      display: flex; align-items: flex-start; gap: 9px;
      padding: 11px 14px; border-radius: 8px;
      font-size: .84rem; margin-bottom: 18px; line-height: 1.5;
    }
    .alert-error   { background: #fff0f0; border: 1px solid #ffcccc; color: var(--red); }
    .alert-success { background: #f0fff4; border: 1px solid #b2dfdb; color: var(--green); }

    /* Form layout */
    .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
    .form-group { margin-bottom: 16px; }
    .form-group label {
      display: flex; align-items: center; gap: 4px;
      font-size: .68rem; font-weight: 600;
      letter-spacing: 2px; text-transform: uppercase;
      color: var(--brown-mid); margin-bottom: 7px;
    }
    .req { color: var(--gold); font-size: .85rem; font-weight: 700; }

    .input-wrap { position: relative; }
    .ico { position: absolute; left: 13px; top: 50%; transform: translateY(-50%); font-size: .88rem; opacity: .38; pointer-events: none; }
    .eye { position: absolute; right: 13px; top: 50%; transform: translateY(-50%); font-size: .9rem; cursor: pointer; opacity: .4; transition: opacity .2s; }
    .eye:hover { opacity: .8; }

    .form-group input {
      width: 100%; padding: 12px 38px 12px 38px;
      background: #fff; border: 1.5px solid var(--border);
      border-radius: 9px;
      font-family: 'DM Sans',sans-serif; font-size: .9rem;
      color: var(--brown); outline: none;
      transition: border-color .2s, box-shadow .2s;
    }
    .form-group input:focus { border-color: var(--gold); box-shadow: 0 0 0 3px rgba(201,151,58,.12); }
    .form-group input.ok  { border-color: #27ae60; }
    .form-group input.bad { border-color: var(--red); }
    .form-group input::placeholder { color: #c5b8ac; }

    .hint { font-size: .7rem; color: #b5a090; margin-top: 4px; padding-left: 2px; }

    /* Strength bar */
    .pw-bar { height: 3px; background: var(--border); border-radius: 99px; margin-top: 6px; overflow: hidden; }
    .pw-fill { height: 100%; border-radius: 99px; width: 0; transition: width .3s, background .3s; }
    .pw-txt { font-size: .68rem; color: #b5a090; margin-top: 3px; transition: color .3s; }

    /* Terms */
    .terms-check {
      display: flex; align-items: flex-start; gap: 10px;
      margin-bottom: 20px; margin-top: 4px;
    }
    .terms-check input { width: 15px; height: 15px; accent-color: var(--gold); margin-top: 2px; cursor: pointer; flex-shrink: 0; }
    .terms-check label { font-size: .8rem; color: var(--muted); line-height: 1.5; cursor: pointer; }
    .terms-check a { color: var(--brown); font-weight: 600; text-decoration: none; }
    .terms-check a:hover { color: var(--gold); }

    /* Submit */
    .btn-submit {
      width: 100%; padding: 14px;
      background: var(--brown); color: var(--cream);
      border: none; border-radius: 9px;
      font-family: 'Bebas Neue',sans-serif; font-size: 1.15rem;
      letter-spacing: 3px; cursor: pointer;
      transition: background .2s, transform .1s, box-shadow .2s;
      position: relative; overflow: hidden;
    }
    .btn-submit::after {
      content:''; position:absolute; inset:0;
      background: linear-gradient(90deg,transparent,rgba(255,255,255,.08),transparent);
      transform: translateX(-100%); transition: transform .4s ease;
    }
    .btn-submit:hover { background: var(--gold); color: var(--brown); box-shadow: 0 6px 20px rgba(201,151,58,.3); }
    .btn-submit:hover::after { transform: translateX(100%); }
    .btn-submit:active { transform: scale(.99); }
    .btn-submit:disabled { opacity: .65; cursor: not-allowed; }

    /* Divider section */
    .section-divider {
      display: flex; align-items: center; gap: 12px; margin: 4px 0 16px;
    }
    .section-divider::before, .section-divider::after { content:''; flex:1; height:1px; background: var(--border); }
    .section-divider span { font-size: .67rem; letter-spacing: 2px; text-transform: uppercase; color: #c5b8ac; white-space: nowrap; }

    /* Bottom */
    .bottom-link {
      text-align: center; margin-top: 22px;
      font-size: .85rem; color: var(--muted);
    }
    .bottom-link a { color: var(--brown); font-weight: 600; text-decoration: none; transition: color .2s; }
    .bottom-link a:hover { color: var(--gold); }

    /* Responsive */
    @media (max-width: 900px) {
      body { flex-direction: column; overflow-y: auto; }
      .panel-left { flex: none; padding: 48px 28px 32px; }
      .steps { display: none; }
      .panel-right { width: 100%; padding: 40px 28px 60px; }
    }
    @media (max-width: 480px) {
      .form-row { grid-template-columns: 1fr; }
      .panel-right { padding: 32px 18px 50px; }
    }
  </style>
</head>
<body>

<!-- LOADER -->
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
  <p>Bergabunglah dan dapatkan akses ke ratusan mesin tambang bersertifikat untuk mendukung operasional Anda.</p>

  <div class="steps">
    <div class="step">
      <div class="step-num">1</div>
      <div class="step-body">
        <strong>Buat Akun</strong>
        <span>Isi form dengan data valid, atau gunakan akun Google.</span>
      </div>
    </div>
    <div class="step">
      <div class="step-num">2</div>
      <div class="step-body">
        <strong>Masuk ke Platform</strong>
        <span>Login dengan username & password atau Google.</span>
      </div>
    </div>
    <div class="step">
      <div class="step-num">3</div>
      <div class="step-body">
        <strong>Mulai Berbelanja</strong>
        <span>Jelajahi katalog & pesan langsung ke kami.</span>
      </div>
    </div>
  </div>
</div>

<!-- RIGHT -->
<div class="panel-right">
  <div class="auth-box">

    <?php if ($success): ?>
    <!-- ══ SUCCESS STATE ══ -->
    <div class="success-state">
      <div class="success-icon">🎉</div>
      <h3>Pendaftaran Berhasil!</h3>
      <p>Akun <strong><?php echo htmlspecialchars($_POST['username']); ?></strong> telah dibuat.<br>Silakan masuk untuk mulai berbelanja.</p>
      <a href="login.php" class="btn-to-login">Masuk Sekarang →</a>
    </div>

    <?php else: ?>
    <!-- ══ REGISTER FORM ══ -->
    <div class="eyebrow">Bergabung Gratis</div>
    <h2>Buat Akun</h2>
    <p class="subtitle">Daftar dalam hitungan detik. Kolom <span style="color:var(--gold);font-weight:700;">*</span> wajib diisi.</p>

    <?php if ($error): ?>
    <div class="alert alert-error">⚠️ <span><?php echo htmlspecialchars($error); ?></span></div>
    <?php endif; ?>

    <!-- GOOGLE REGISTER -->
    <a href="auth/google.php?mode=register" class="btn-google">
      <svg width="18" height="18" viewBox="0 0 18 18">
        <path fill="#4285F4" d="M17.64 9.2c0-.637-.057-1.251-.164-1.84H9v3.481h4.844a4.14 4.14 0 0 1-1.796 2.716v2.259h2.908c1.702-1.567 2.684-3.875 2.684-6.615z"/>
        <path fill="#34A853" d="M9 18c2.43 0 4.467-.806 5.956-2.18l-2.908-2.259c-.806.54-1.837.86-3.048.86-2.344 0-4.328-1.584-5.036-3.711H.957v2.332A8.997 8.997 0 0 0 9 18z"/>
        <path fill="#FBBC05" d="M3.964 10.71A5.41 5.41 0 0 1 3.682 9c0-.593.102-1.17.282-1.71V4.958H.957A8.996 8.996 0 0 0 0 9c0 1.452.348 2.827.957 4.042l3.007-2.332z"/>
        <path fill="#EA4335" d="M9 3.58c1.321 0 2.508.454 3.44 1.345l2.582-2.58C13.463.891 11.426 0 9 0A8.997 8.997 0 0 0 .957 4.958L3.964 7.29C4.672 5.163 6.656 3.58 9 3.58z"/>
      </svg>
      Daftar dengan Google
    </a>

    <div class="or-div"><span>atau daftar manual</span></div>

    <form method="POST" id="regForm" novalidate>

      <!-- Nama & Telepon -->
      <div class="form-row">
        <div class="form-group">
          <label>Nama Lengkap <span class="req">*</span></label>
          <div class="input-wrap">
            <span class="ico">👤</span>
            <input type="text" name="nama_lengkap" id="f_nama"
                   placeholder="Nama lengkap"
                   value="<?php echo htmlspecialchars($_POST['nama_lengkap'] ?? ''); ?>" required>
          </div>
        </div>
        <div class="form-group">
          <label>No. Telepon</label>
          <div class="input-wrap">
            <span class="ico">📱</span>
            <input type="tel" name="no_telepon"
                   placeholder="08xx-xxxx-xxxx"
                   value="<?php echo htmlspecialchars($_POST['no_telepon'] ?? ''); ?>">
          </div>
        </div>
      </div>

      <!-- Email -->
      <div class="form-group">
        <label>Email <span class="req">*</span></label>
        <div class="input-wrap">
          <span class="ico">✉️</span>
          <input type="email" name="email" id="f_email"
                 placeholder="email@contoh.com"
                 value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>" required>
        </div>
        <div class="hint">Untuk komunikasi & notifikasi pesanan.</div>
      </div>

      <div class="section-divider"><span>Info Akun</span></div>

      <!-- Username -->
      <div class="form-group">
        <label>Username <span class="req">*</span></label>
        <div class="input-wrap">
          <span class="ico">🔖</span>
          <input type="text" name="username" id="f_user"
                 placeholder="Minimal 4 karakter"
                 value="<?php echo htmlspecialchars($_POST['username'] ?? ''); ?>"
                 minlength="4" required>
        </div>
        <div class="hint" id="userHint">Huruf kecil, angka, underscore. Tidak bisa diubah.</div>
      </div>

      <!-- Password & Konfirmasi -->
      <div class="form-row">
        <div class="form-group">
          <label>Password <span class="req">*</span></label>
          <div class="input-wrap">
            <span class="ico">🔒</span>
            <input type="password" name="password" id="f_pw" placeholder="Min. 6 karakter" required>
            <span class="eye" id="eye1" onclick="tog('f_pw','eye1')">👁</span>
          </div>
          <div class="pw-bar"><div class="pw-fill" id="pwFill"></div></div>
          <div class="pw-txt" id="pwTxt">Masukkan password</div>
        </div>
        <div class="form-group">
          <label>Konfirmasi <span class="req">*</span></label>
          <div class="input-wrap">
            <span class="ico">🔒</span>
            <input type="password" name="confirm_password" id="f_cpw" placeholder="Ulangi password" required>
            <span class="eye" id="eye2" onclick="tog('f_cpw','eye2')">👁</span>
          </div>
          <div class="hint" id="matchHint" style="color:#b5a090;">—</div>
        </div>
      </div>

      <!-- Terms -->
      <div class="terms-check">
        <input type="checkbox" id="terms" name="terms" required>
        <label for="terms">
          Saya menyetujui <a href="#">Syarat & Ketentuan</a> dan
          <a href="#">Kebijakan Privasi</a> PT Marlin Jaya Mesin.
        </label>
      </div>

      <button type="submit" name="register" class="btn-submit" id="subBtn">
        Buat Akun Sekarang →
      </button>
    </form>
    <?php endif; ?>

    <div class="bottom-link">
      Sudah punya akun? <a href="login.php">Masuk di sini →</a>
    </div>

  </div>
</div>

<script>
// ── Loader ─────────────────────────────────────────────
window.addEventListener('load', () => {
  setTimeout(() => document.getElementById('loader').classList.add('out'), 600);
});

// ── Eye toggle ─────────────────────────────────────────
function tog(id, btnId) {
  const inp = document.getElementById(id);
  const btn = document.getElementById(btnId);
  if (inp.type === 'password') { inp.type = 'text'; btn.textContent = '🙈'; }
  else { inp.type = 'password'; btn.textContent = '👁'; }
}

// ── Password strength ──────────────────────────────────
const pwInp  = document.getElementById('f_pw');
const cpwInp = document.getElementById('f_cpw');
const pwFill = document.getElementById('pwFill');
const pwTxt  = document.getElementById('pwTxt');
const mHint  = document.getElementById('matchHint');

const lvls = [
  { max:0,  w:'0',    bg:'transparent', t:'Masukkan password',  c:'#b5a090' },
  { max:2,  w:'25%',  bg:'#e53935',     t:'Terlalu lemah',       c:'#e53935' },
  { max:3,  w:'50%',  bg:'#ef6c00',     t:'Sedang',              c:'#ef6c00' },
  { max:4,  w:'75%',  bg:'#f9a825',     t:'Cukup kuat',          c:'#f9a825' },
  { max:99, w:'100%', bg:'#27ae60',     t:'Kuat 💪',             c:'#27ae60' },
];

function strength(v) {
  let s = 0;
  if (v.length>=6)  s++;
  if (v.length>=10) s++;
  if (/[A-Z]/.test(v)) s++;
  if (/[0-9]/.test(v)) s++;
  if (/[^A-Za-z0-9]/.test(v)) s++;
  return s;
}

pwInp.addEventListener('input', () => {
  const l = lvls.find(x => strength(pwInp.value) <= x.max);
  pwFill.style.width      = l.w;
  pwFill.style.background = l.bg;
  pwTxt.textContent       = l.t;
  pwTxt.style.color       = l.c;
  checkMatch();
});

cpwInp.addEventListener('input', checkMatch);

function checkMatch() {
  if (!cpwInp.value) { mHint.textContent='—'; mHint.style.color='#b5a090'; return; }
  const ok = pwInp.value === cpwInp.value;
  mHint.textContent = ok ? '✓ Password cocok' : '✗ Belum cocok';
  mHint.style.color = ok ? '#27ae60' : '#e53935';
  cpwInp.classList.toggle('ok',  ok);
  cpwInp.classList.toggle('bad', !ok);
}

// ── Username: huruf kecil saja ─────────────────────────
const uInp = document.getElementById('f_user');
if (uInp) {
  uInp.addEventListener('input', () => {
    uInp.value = uInp.value.toLowerCase().replace(/[^a-z0-9_]/g,'');
  });
}

// ── Client-side submit validation ─────────────────────
document.getElementById('regForm')?.addEventListener('submit', function(e) {
  const un  = uInp.value;
  const pw  = pwInp.value;
  const cpw = cpwInp.value;
  const chk = document.getElementById('terms');

  if (un.length < 4)     { e.preventDefault(); flashErr('Username minimal 4 karakter.'); return; }
  if (pw.length < 6)     { e.preventDefault(); flashErr('Password minimal 6 karakter.'); return; }
  if (pw !== cpw)        { e.preventDefault(); flashErr('Password dan konfirmasi tidak cocok.'); return; }
  if (!chk.checked)      { e.preventDefault(); flashErr('Anda harus menyetujui Syarat & Ketentuan.'); return; }

  const btn = document.getElementById('subBtn');
  btn.textContent = 'Memproses...';
  btn.disabled = true;
  setTimeout(() => {
    btn.disabled = false;
    btn.style.opacity = '1';
    btn.textContent = 'Buat Akun Sekarang →';
  }, 5000);
});

function flashErr(msg) {
  document.querySelector('.alert-inline')?.remove();
  const d = document.createElement('div');
  d.className = 'alert alert-error alert-inline';
  d.innerHTML = '⚠️ <span>' + msg + '</span>';
  const form = document.getElementById('regForm');
  form.insertBefore(d, form.firstChild);
  d.scrollIntoView({ behavior:'smooth', block:'nearest' });
}

// ── Input focus micro-animation ────────────────────────
document.querySelectorAll('.input-wrap input').forEach(inp => {
  inp.addEventListener('focus',  () => { inp.closest('.input-wrap').style.transform='scale(1.008)'; inp.closest('.input-wrap').style.transition='.15s ease'; });
  inp.addEventListener('blur',   () => { inp.closest('.input-wrap').style.transform=''; });
});
</script>
</body>
</html>
