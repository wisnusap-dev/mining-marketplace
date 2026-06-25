<?php
session_start();
include "../config/database.php";
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>About Us — Mining Market</title>
  <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Sans:wght@400;500;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../css/navbar.css">
  <link rel="stylesheet" href="../css/about.css">
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
    <img src="../logo/companies.png" alt="Logo">
    <span class="nav-brand">Mining Market</span>
  </a>
  <ul class="nav-links">
    <li><a href="index.php">Home</a></li>
    <li><a href="products.php">Products</a></li>
    <li><a href="about.php" class="active">About</a></li>
    <li><a href="contact.php">Contact</a></li>
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

<div class="about-wrapper">
  <div class="about-card reveal">
    <h1>TENTANG <br>KAMI</h1>
    <p>
      PT Marlin Jaya Mesin adalah perusahaan terbatas Indonesia yang berfokus sebagai importir
      dan penyedia mesin industri, berlokasi strategis di Tangerang. Kami melayani impor mesin
      industri/umum dari kawasan bisnis Ruko Mutiara Kosambi II, Benda.
    </p>
    <div style="margin-top: 20px; display:flex; gap:12px; flex-wrap:wrap;">
      <a href="index.php" class="button">Kembali ke Beranda</a>
      <a href="https://maps.google.com" target="_blank" rel="noopener" class="button">📍 Lihat di Maps</a>
    </div>
  </div>

  <div class="scroll-gallery-container">
    <div class="gallery-item reveal">
      <img data-src="../images/Team/saham.jpg"
           src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7"
           alt="Pemegang Saham">
      <div class="gallery-overlay">
        <h3>Pemegang Saham</h3>
        <p>Informasi struktur pemegang saham dan modal perusahaan yang terverifikasi.</p>
      </div>
    </div>

    <div class="gallery-item reveal">
      <img data-src="../images/Team/team2.jpg"
           src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7"
           alt="Perusahaan Aktif">
      <div class="gallery-overlay">
        <h3>Perusahaan Aktif</h3>
        <p>Terdaftar sebagai entitas aktif menurut catatan Companies House Indonesia.</p>
      </div>
    </div>

    <div class="gallery-item reveal">
      <img data-src="../images/Team/lokas.jpg"
           src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7"
           alt="Lokasi">
      <div class="gallery-overlay">
        <h3>Lokasi</h3>
        <p>Jl. Raya Perancis, Komp. Ruko Mutiara Kosambi 2 Blok A No.42, TANGERANG.</p>
      </div>
    </div>

    <div class="gallery-item reveal">
      <img data-src="../images/Team/badanhukum.jpg"
           src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7"
           alt="Badan Hukum">
      <div class="gallery-overlay">
        <h3>Badan Hukum</h3>
        <p>PT. Marlin Jaya Mesin terdaftar resmi sebagai Perseroan Terbatas.</p>
      </div>
    </div>

    <div class="gallery-item reveal">
      <img data-src="../images/Team/fakta.jpg"
           src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7"
           alt="Import & Eksport">
      <div class="gallery-overlay">
        <h3>Import & Eksport</h3>
        <p>Merangkum kinerja impor-ekspor global, volume pengiriman, dan mitra dagang utama PT Marlin Jaya Mesin.</p>
      </div>
    </div>
  </div>
</div>

<footer>
  © <?php echo date('Y'); ?> <span>PT Marlin Jaya Mesin</span> · Mining Market · All rights reserved
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