<?php
session_start();
include "../config/database.php";
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>PT.MARLIN JAYA MESIN</title>
<link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Sans:ital,wght@0,300;0,400;0,500;0,600;1,300&display=swap" rel="stylesheet">
<link rel="stylesheet" href="../css/home.css">
<link rel="stylesheet" href="../css/navbar.css"
<style>

</style>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar">
  <a href="index.php" class="nav-logo">
    <img src="../logo/companies.png" alt="Logo">
    <span class="nav-brand">Mining Market</span>
  </a>

  <ul class="nav-links">
    <li><a href="index.php" class="active">Home</a></li>
    <li><a href="products.php">Products</a></li>
    <li><a href="about.php">About</a></li>
    <li><a href="contact.php">Contact</a></li>
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

<!-- HERO -->
<section class="hero">
  <div class="hero-bg"></div>
  <div class="hero-glow"></div>
  <div class="hero-content">
    <div class="hero-badge">Platform Alat Tambang #1</div>
    <h1>PT MARLIN<br><span class="gold">JAYA</span><br>MESIN</h1>
    <div class="hero-sub">Industrial Equipment</div>
    <p class="hero-desc">
      Halo, <strong><?php echo htmlspecialchars($_SESSION['username']); ?></strong>. 
      Tingkatkan efisiensi operasional tambang Anda dengan armada mesin tangguh, bersertifikat, dan teknologi terkini.
    </p>
    <div class="hero-actions">
      <a href="products.php" class="btn-primary">Lihat Katalog →</a>
      <a href="about.php" class="btn-secondary">Tentang Kami</a>
    </div>
  </div>
</section>

<!-- STATS -->
<div class="stats-strip">
  <div class="stat-item">
    <div class="stat-num">200+</div>
    <div class="stat-label">Unit Tersedia</div>
  </div>
  <div class="stat-item">
    <div class="stat-num">15+</div>
    <div class="stat-label">Tahun Pengalaman</div>
  </div>
  <div class="stat-item">
    <div class="stat-num">500+</div>
    <div class="stat-label">Pelanggan Puas</div>
  </div>
  <div class="stat-item">
    <div class="stat-num">24/7</div>
    <div class="stat-label">Dukungan Teknis</div>
  </div>
</div>

<!-- FEATURES -->
<section class="section">
  <div class="section-label">Keunggulan Kami</div>
  <h2 class="section-title">Kenapa Memilih<br>Mining Market?</h2>
  <p class="section-sub">Kami memberikan standar baru dalam industri alat berat tambang Indonesia.</p>

  <div class="features-grid">
    <div class="feature-card">
      <div class="feature-icon">🏆</div>
      <h3>Mesin Bersertifikat</h3>
      <p>Semua unit kami telah melalui inspeksi ketat dan memiliki sertifikasi internasional yang terjamin kualitasnya.</p>
    </div>
    <div class="feature-card">
      <div class="feature-icon">⚡</div>
      <h3>Dukungan 24/7</h3>
      <p>Tim teknisi ahli kami siap membantu Anda kapan saja, di mana saja di lokasi pertambangan Anda.</p>
    </div>
    <div class="feature-card">
      <div class="feature-icon">🔧</div>
      <h3>Suku Cadang Asli</h3>
      <p>Ketersediaan suku cadang original untuk memastikan mesin tetap beroperasi secara maksimal dan efisien.</p>
    </div>
    <div class="feature-card">
      <div class="feature-icon">🚚</div>
      <h3>Pengiriman Terjadwal</h3>
      <p>Layanan pengiriman profesional ke seluruh Indonesia dengan jadwal yang dapat disesuaikan kebutuhan operasional.</p>
    </div>
    <div class="feature-card">
      <div class="feature-icon">💼</div>
      <h3>Garansi Resmi</h3>
      <p>Setiap produk dilengkapi garansi resmi pabrikan sehingga investasi Anda terlindungi dengan baik.</p>
    </div>
    <div class="feature-card">
      <div class="feature-icon">📋</div>
      <h3>Konsultasi Gratis</h3>
      <p>Tim ahli kami siap memberikan rekomendasi mesin yang paling tepat untuk kebutuhan tambang Anda.</p>
    </div>
  </div>
</section>

<!-- CTA BANNER -->
<div class="cta-banner">
  <div class="cta-text">
    <h2>Siap Tingkatkan Operasional?</h2>
    <p>Jelajahi ratusan unit mesin tambang pilihan kami sekarang juga.</p>
  </div>
  <a href="products.php" class="btn-primary" style="white-space: nowrap;">Lihat Semua Produk →</a>
</div>

<footer>
  &copy; 2025 <span>PT Marlinjaya Mesin</span> · Mining Market · All rights reserved
</footer>

<script src="../js/navbar.js">
function toggleMenu() {
  document.getElementById('hamburger').classList.toggle('open');
  document.getElementById('mobileMenu').classList.toggle('open');
}

</script>

</body>
</html>