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
  <title>PT.MARLIN JAYA MESIN — Mining Market</title>
  <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Sans:ital,wght@0,300;0,400;0,500;0,600;1,300&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../css/navbar.css">
  <link rel="stylesheet" href="../css/home.css">
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

<div class="mobile-menu" id="mobileMenu">
  <a href="index.php">Home</a>
  <a href="products.php">Products</a>
  <a href="about.php">About</a>
  <a href="contact.php">Contact Us</a>
  <a href="cart.php">🛒 Keranjang</a>
  <a href="../logout.php" class="m-logout">Logout</a>
</div>

<section class="hero">
  <canvas id="hero-canvas"></canvas>
  <div class="hero-bg"></div>
  <div class="hero-glow"></div>
  <div class="hero-content">
    <div class="hero-badge">Platform Alat Tambang #1</div>
    <h1>PT MARLIN<br><span class="gold">JAYA</span><br>MESIN</h1>
    <div class="hero-sub">
      <span id="typed-text" data-words="Industrial Equipment|Alat Berat Tambang|Mesin Bersertifikat"></span>
    </div>
    <p class="hero-desc">
      Halo, <strong><?php echo htmlspecialchars($_SESSION['username']); ?></strong>.
      Tingkatkan efisiensi operasional tambang Anda dengan armada mesin tangguh, bersertifikat, dan teknologi terkini.
    </p>
    <div class="hero-actions">
      <a href="products.php" class="btn-primary">Lihat Katalog →</a>
      <a href="about.php" class="btn-secondary">Tentang Kami</a>
    </div>
  </div>
  <div class="scroll-down">
    <p>Scroll</p>
    <span></span>
  </div>
</section>

<div class="stats-strip reveal reveal-group">
  <div class="stat-item">
    <div class="stat-num count-up" data-target="200" data-suffix="+">200+</div>
    <div class="stat-label">Unit Tersedia</div>
  </div>
  <div class="stat-item">
    <div class="stat-num count-up" data-target="15" data-suffix="+">15+</div>
    <div class="stat-label">Tahun Pengalaman</div>
  </div>
  <div class="stat-item">
    <div class="stat-num count-up" data-target="500" data-suffix="+">500+</div>
    <div class="stat-label">Pelanggan Puas</div>
  </div>
  <div class="stat-item">
    <div class="stat-num">24/7</div>
    <div class="stat-label">Dukungan Teknis</div>
  </div>
</div>

<section class="section">
  <div class="section-label reveal">Keunggulan Kami</div>
  <h2 class="section-title reveal">Kenapa Memilih<br>Mining Market?</h2>
  <p class="section-sub reveal">Kami memberikan standar baru dalam industri alat berat tambang Indonesia.</p>

  <div class="features-grid reveal-group reveal">
    <div class="feature-card">
      <div class="feature-icon"><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#1f1f1f"><path d="M395-475q-35-35-35-85t35-85q35-35 85-35t85 35q35 35 35 85t-35 85q-35 35-85 35t-85-35ZM240-40v-309q-38-42-59-96t-21-115q0-134 93-227t227-93q134 0 227 93t93 227q0 61-21 115t-59 96v309l-240-80-240 80Zm410-350q70-70 70-170t-70-170q-70-70-170-70t-170 70q-70 70-70 170t70 170q70 70 170 70t170-70ZM320-159l160-41 160 41v-124q-35 20-75.5 31.5T480-240q-44 0-84.5-11.5T320-283v124Zm160-62Z"/></svg></div>
      <h3>Mesin Bersertifikat</h3>
      <p>Semua unit telah melalui inspeksi ketat dan memiliki sertifikasi internasional yang terjamin kualitasnya.</p>
    </div>
    <div class="feature-card">
      <div class="feature-icon"><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#1f1f1f"><path d="M440-120v-80h320v-284q0-117-81.5-198.5T480-764q-117 0-198.5 81.5T200-484v244h-40q-33 0-56.5-23.5T80-320v-80q0-21 10.5-39.5T120-469l3-53q8-68 39.5-126t79-101q47.5-43 109-67T480-840q68 0 129 24t109 66.5Q766-707 797-649t40 126l3 52q19 9 29.5 27t10.5 38v92q0 20-10.5 38T840-249v49q0 33-23.5 56.5T760-120H440ZM331.5-411.5Q320-423 320-440t11.5-28.5Q343-480 360-480t28.5 11.5Q400-457 400-440t-11.5 28.5Q377-400 360-400t-28.5-11.5Zm240 0Q560-423 560-440t11.5-28.5Q583-480 600-480t28.5 11.5Q640-457 640-440t-11.5 28.5Q617-400 600-400t-28.5-11.5ZM241-462q-7-106 64-182t177-76q89 0 156.5 56.5T720-519q-91-1-167.5-49T435-698q-16 80-67.5 142.5T241-462Z"/></svg></div>
      <h3>Dukungan 24/7</h3>
      <p>Tim teknisi ahli kami siap membantu kapan saja, di mana saja di lokasi pertambangan Anda.</p>
    </div>
    <div class="feature-card">
      <div class="feature-icon">🔧</div>
      <h3>Suku Cadang Asli</h3>
      <p>Ketersediaan suku cadang original untuk memastikan mesin tetap beroperasi secara maksimal.</p>
    </div>
    <div class="feature-card">
      <div class="feature-icon"><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#1f1f1f"><path d="M195-195q-35-35-35-85H60l18-80h113q17-19 40-29.5t49-10.5q26 0 49 10.5t40 29.5h167l84-360H262l17-80h441l-37 160h117l120 160-40 200h-80q0 50-35 85t-85 35q-50 0-85-35t-35-85H400q0 50-35 85t-85 35q-50 0-85-35Zm442-245h193l4-21-74-99h-95l-28 120Zm-17-280-84 360 2-7 82-353ZM140-440v-120H40l140-200v120h100L140-440Zm140 200q17 0 28.5-11.5T320-280q0-17-11.5-28.5T280-320q-17 0-28.5 11.5T240-280q0 17 11.5 28.5T280-240Zm400 0q17 0 28.5-11.5T720-280q0-17-11.5-28.5T680-320q-17 0-28.5 11.5T640-280q0 17 11.5 28.5T680-240Z"/></svg></div>
      <h3>Pengiriman Terjadwal</h3>
      <p>Layanan pengiriman profesional ke seluruh Indonesia dengan jadwal yang dapat disesuaikan.</p>
    </div>
    <div class="feature-card">
      <div class="feature-icon"><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#1f1f1f"><path d="M160-80q-33 0-56.5-23.5T80-160v-440q0-33 23.5-56.5T160-680h200v-120q0-33 23.5-56.5T440-880h80q33 0 56.5 23.5T600-800v120h200q33 0 56.5 23.5T880-600v440q0 33-23.5 56.5T800-80H160Zm0-80h640v-440H600q0 33-23.5 56.5T520-520h-80q-33 0-56.5-23.5T360-600H160v440Zm80-80h240v-18q0-17-9.5-31.5T444-312q-20-9-40.5-13.5T360-330q-23 0-43.5 4.5T276-312q-17 8-26.5 22.5T240-258v18Zm320-60h160v-60H560v60Zm-157.5-77.5Q420-395 420-420t-17.5-42.5Q385-480 360-480t-42.5 17.5Q300-445 300-420t17.5 42.5Q335-360 360-360t42.5-17.5ZM560-420h160v-60H560v60ZM440-600h80v-200h-80v200Zm40 220Z"/></svg></div>
      <h3>Garansi Resmi</h3>
      <p>Setiap produk dilengkapi garansi resmi pabrikan sehingga investasi Anda terlindungi.</p>
    </div>
    <div class="feature-card">
      <div class="feature-icon">💡</div>
      <h3>Konsultasi Gratis</h3>
      <p>Tim ahli kami siap memberikan rekomendasi mesin yang paling tepat untuk kebutuhan tambang Anda.</p>
    </div>
  </div>
</section>

<div class="cta-banner reveal">
  <div class="cta-text">
    <h2>Siap Tingkatkan Operasional?</h2>
    <p>Jelajahi ratusan unit mesin tambang pilihan kami sekarang juga.</p>
  </div>
  <a href="products.php" class="btn-primary" style="white-space: nowrap;">Lihat Semua Produk →</a>
</div>

<footer>
  &copy; 2025 <span>PT Marlinjaya Mesin</span> · Mining Market · All rights reserved
</footer>

<script src="../js/navbar.js"></script>
<script src="../js/user.js"></script>
<script>
function toggleMenu() {
  document.getElementById('hamburger').classList.toggle('open');
  document.getElementById('mobileMenu').classList.toggle('open');
}
</script>
</body>
</html>