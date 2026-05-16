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
    $nama   = mysqli_real_escape_string($conn, trim($_POST['nama']));
    $email  = mysqli_real_escape_string($conn, trim($_POST['email']));
    $subjek = mysqli_real_escape_string($conn, trim($_POST['subjek'] ?? ''));
    $pesan  = mysqli_real_escape_string($conn, trim($_POST['pesan']));

    if (!empty($nama) && !empty($email) && !empty($pesan)) {
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
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../css/contact.css">
  <link rel="stylesheet" href="../css/navbar.css">
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar">
  <a href="index.php" class="nav-logo">
    <img src="../logo/companies.png" alt="Logo">
    <span class="nav-brand">Mining Market</span>
  </a>
  <ul class="nav-links">
    <li><a href="index.php">Home</a></li>
    <li><a href="products.php">Products</a></li>
    <li><a href="about.php">About</a></li>
    <li><a href="contact.php" class="active">Contact</a></li>
    <li><a href="cart.php">🛒 Keranjang</a></li>
    <li><a href="../logout.php" class="logout-btn">Logout</a></li>
  </ul>
  <div class="hamburger" id="hamburger" onclick="toggleMenu()">
    <span></span><span></span><span></span>
  </div>
</nav>

<!-- MOBILE MENU -->
<div class="mobile-menu" id="mobileMenu">
  <a href="index.php">Home</a>
  <a href="products.php">Products</a>
  <a href="about.php">About</a>
  <a href="contact.php">Contact Us</a>
  <a href="cart.php">🛒 Keranjang</a>
  <a href="../logout.php" class="m-logout">Logout</a>
</div>

<!-- PAGE HERO -->
<div class="page-hero">
  <span class="eyebrow">Hubungi Kami</span>
  <h1>CONTACT US</h1>
  <p>Tim kami siap membantu pertanyaan, konsultasi, dan kebutuhan pesanan Anda</p>
</div>

<!-- MAIN -->
<div class="contact-wrap">

  <!-- INFO PANEL -->
  <div class="info-panel">
    <h2>Informasi Kontak</h2>
    <p>Punya pertanyaan mengenai alat tambang atau status pesanan? Tim kami siap membantu Anda.</p>

    <div class="info-item">
      <div class="info-icon">📍</div>
      <div class="info-text">
        <strong>Alamat Kantor</strong>
        <span>Universitas Pamulang,<br>Tangerang Selatan</span>
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

    <a href="https://wa.me/6281234567890" target="_blank" rel="noopener" class="wa-btn">
      💬 Chat di WhatsApp Sekarang
    </a>
  </div>

  <!-- FORM CARD -->
  <div class="form-card">
    <h2>Kirim Pesan</h2>

    <?php if ($success): ?>
    <div class="alert alert-success">✅ Pesan berhasil dikirim! Tim kami akan menghubungi Anda segera.</div>
    <?php endif; ?>

    <?php if (!empty($error)): ?>
    <div class="alert alert-error">⚠️ <?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <form method="POST" action="">
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
        <input type="text" name="subjek" placeholder="Produk / Pesanan / Konsultasi / Lainnya"
               value="<?php echo htmlspecialchars($_POST['subjek'] ?? ''); ?>">
      </div>

      <div class="form-group">
        <label>Pesan</label>
        <textarea name="pesan" placeholder="Tulis pesan Anda di sini..." required><?php echo htmlspecialchars($_POST['pesan'] ?? ''); ?></textarea>
      </div>

      <button type="submit" name="kirim" class="btn-send">Kirim Pesan</button>
    </form>

    <div class="form-footer">
      <a href="index.php" class="back-link">← Kembali ke Beranda</a>
    </div>
  </div>

</div>

<!-- FOOTER -->
<footer>
  <span>© <?php echo date('Y'); ?></span>
  <a href="index.php">PT Marlinjaya Mesin</a>
  <span class="dot">·</span>
  <span>Mining Market</span>
  <span class="dot">·</span>
  <span>All rights reserved</span>
</footer>

<script src="../js/navbar.js"></script>
<script>
function toggleMenu() {
  document.getElementById('hamburger').classList.toggle('open');
  document.getElementById('mobileMenu').classList.toggle('open');
}
</script>

</body>
</html>
