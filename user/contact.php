<?php
session_start();
include "../config/database.php";

if (!isset($_SESSION['user_id'])) { 
    header("Location: ../login.php"); 
    exit(); 
}

$success = false;
$error   = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['kirim'])) {
    $nama   = trim($_POST['nama'] ?? '');
    $email  = trim($_POST['email'] ?? '');
    $pesan  = trim($_POST['pesan'] ?? '');
    if ($nama && $email && $pesan) {
        $success = true;
    } else {
        $error = "Semua kolom wajib diisi.";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Contact Us — Mining Market</title>
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../css/navbar.css">
  <link rel="stylesheet" href="../css/contact.css">
  <link rel="stylesheet" href="../css/user_fx.css">
</head>
<body>

<div id="user-loader">
  <div class="loader-gear">⚙️</div>
  <div class="loader-brand">Mining Market</div>
  <div class="loader-line"><div class="loader-line-fill"></div></div>
</div>

<div id="scroll-progress"></div>

<nav class="navbar">
  <a href="index.php" class="nav-logo">
    <span class="nav-brand">Mining Market</span>
  </a>
  <ul class="nav-links">
    <li><a href="index.php">Home</a></li>
    <li><a href="products.php">Products</a></li>
    <li><a href="about.php">About</a></li>
    <li><a href="contact.php" class="active">Contact</a></li>
    <!-- <li><a href="cart.php">🛒 Keranjang</a></li> -->
    <li><a href="../logout.php" class="logout-btn">Logout</a></li>
  </ul>
  <div class="hamburger" id="hamburger" onclick="toggleMenu()">
    <span></span><span></span><span></span>
  </div>
</nav>

<div class="mobile-menu" id="mobileMenu">
  <a href="index.php">Home</a>
  <a href="products.php">Products</a>
  <a href="about.php">About</a>
  <a href="contact.php">Contact Us</a>
  <a href="cart.php">🛒 Keranjang</a>
  <a href="../logout.php" class="m-logout">Logout</a>
</div>

<div class="page-hero reveal">
  <span class="eyebrow">Hubungi Kami</span>
  <h1>CONTACT US</h1>
  <p>Tim kami siap membantu pertanyaan, konsultasi, dan kebutuhan pesanan Anda</p>
</div>

<div class="contact-wrap">
  <div class="info-panel reveal reveal-left">
    <h2>Informasi Kontak</h2>
    <p>Punya pertanyaan mengenai alat tambang atau status pesanan? Tim kami siap membantu.</p>

    <div class="info-item">
      <div class="info-icon">📍</div>
      <div class="info-text">
        <strong>Alamat Kantor</strong>
        <span>Jl. Raya Perancis, Komp. Ruko Mutiara Kosambi 2 Blok A No. 42,<br>Tangerang</span>
      </div>
    </div>
    <div class="info-item">
      <div class="info-icon">✉️</div>
      <div class="info-text">
        <strong>Email Support</strong>
        <span>support@miningmarket.id</span>
      </div>
    </div>
    <div class="info-item">
      <div class="info-icon">📱</div>
      <div class="info-text">
        <strong>WhatsApp</strong>
        <span>+62 812-3456-7890</span>
      </div>
    </div>

    <div class="sep-line"></div>

    <p class="hours-label">Jam Operasional</p>
    <div class="hours-row"><span>Senin – Jumat</span><span>08.00 – 17.00 WIB</span></div>
    <div class="hours-row"><span>Sabtu</span><span>08.00 – 13.00 WIB</span></div>
    <div class="hours-row"><span>Minggu</span><span style="color:#e07a7a;">Tutup</span></div>

    <a href="https://wa.me/6288213717459" target="_blank" rel="noopener" class="wa-btn">
      💬 Chat di WhatsApp Sekarang
    </a>
  </div>

  <div class="form-card reveal reveal-right">
    <h2>Kirim Pesan</h2>

    <?php if ($success): ?>
    <div class="alert alert-success">✅ Pesan berhasil dikirim! Kami akan menghubungi Anda segera.</div>
    <?php endif; ?>
    <?php if ($error): ?>
    <div class="alert alert-error">⚠️ <?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <form method="POST">
      <div class="form-row">
        <div class="form-group">
          <label>Nama Lengkap</label>
          <input type="text" name="nama" placeholder="Nama Anda" required
                 value="<?php echo htmlspecialchars($_POST['nama'] ?? ''); ?>">
        </div>
        <div class="form-group">
          <label>Email Aktif</label>
          <input type="email" name="email" placeholder="email@contoh.com" required
                 value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>">
        </div>
      </div>
      <div class="form-group">
        <label>Subjek</label>
        <input type="text" name="subjek" placeholder="Produk / Pesanan / Konsultasi"
               value="<?php echo htmlspecialchars($_POST['subjek'] ?? ''); ?>">
      </div>
      <div class="form-group">
        <label>Pesan</label>
        <textarea name="pesan" placeholder="Tulis pesan Anda di sini..." required><?php echo htmlspecialchars($_POST['pesan'] ?? ''); ?></textarea>
      </div>
      <button type="submit" name="kirim" class="btn-send">Kirim Pesan →</button>
    </form>

    <div class="form-footer">
      <a href="index.php" class="back-link">← Kembali ke Beranda</a>
    </div>
  </div>
</div>

<footer>
  <span>© <?php echo date('Y'); ?></span>
  <a href="index.php">PT Marlin Jaya Mesin</a>
  <span class="dot">·</span>
  <span>Mining Market</span>
  <span class="dot">·</span>
  <span>All rights reserved</span>
</footer>

<script src="../js/navbar.js"></script>
<script src="../js/user.js"></script>
<script>
function toggleMenu() {
  document.getElementById('hamburger').classList.toggle('open');
  document.getElementById('mobileMenu').classList.toggle('open');
}

<?php if ($success): ?>
window.addEventListener('load', () => {
  if (typeof showToast === 'function') {
    showToast('Pesan berhasil terkirim! 📨');
  }
});
<?php endif; ?>
</script>

</body>
</html>