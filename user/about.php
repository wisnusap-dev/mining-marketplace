<?php
session_start();
include "../config/database.php";
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
<<<<<<< HEAD
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
    <li><a href="cart.php">🛒 Keranjang</a></li>
    <li><a href="../logout.php" class="logout-btn">Logout</a></li>
  </ul>
  <div class="hamburger" id="hamburger" onclick="toggleMenu()">
    <span></span><span></span><span></span>
  </div>
</nav>

=======
  <title>About Us - Mining Market</title>
  <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Sans:wght@400;500;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../css/navbar.css">
  <link rel="stylesheet" href="../css/about.css">
</head>
<body>

<nav class="navbar">
  <a href="index.php" class="nav-logo">
    <span class="nav-brand">Mining Market</span>
  </a>
  <ul class="nav-links">
    <li><a href="index.php">Home</a></li>
    <li><a href="products.php">Products</a></li>
    <li><a href="about.php" class="active">About</a></li>
    <li><a href="contact.php">Contact</a></li>
    <li><a href="cart.php">🛒 Keranjang</a></li>
    <li><a href="../logout.php" class="logout-btn">Logout</a></li>
  </ul>
  <div class="hamburger" id="hamburger" onclick="toggleMenu()">
    <span></span><span></span><span></span>
  </div>
</nav>

>>>>>>> 3d454b37c846b98aa976a3391e664398497703fc
<div class="mobile-menu" id="mobileMenu">
  <a href="index.php">Home</a>
  <a href="products.php">Products</a>
  <a href="about.php">About</a>
  <a href="contact.php">Contact Us</a>
  <a href="cart.php">🛒 Keranjang</a>
  <a href="../logout.php" class="m-logout">Logout</a>
</div>

<div class="about-wrapper">
<<<<<<< HEAD
  <div class="about-card reveal">
    <h1>TENTANG <br>KAMI</h1>
    <p>
      PT Marlin Jaya Mesin adalah perusahaan terbatas Indonesia yang berfokus sebagai importir
      dan penyedia mesin industri, berlokasi strategis di Tangerang. Kami melayani impor mesin
      industri/umum dari kawasan bisnis Ruko Mutiara Kosambi II, Benda.
    </p>
    <div style="margin-top: 20px; display:flex; gap:12px; flex-wrap:wrap;">
      <a href="index.php" class="button">Kembali ke Beranda</a>
      <a href="https://www.google.com/maps?q=pt+marlin+jaya+mesin" target="_blank" rel="noopener" class="button">📍 Lihat di Maps</a>
=======
  <div class="about-card">
    <h1>TENTANG <br> KAMI</h1>
    <p>
      PT Marlin Jaya Mesin adalah perusahaan terbatas (Limited Liability Company) Indonesia yang berfokus sebagai importir dan penyedia mesin, berlokasi di Tangerang. Perusahaan ini bergerak dalam impor mesin industri/umum dan berlokasi strategis di kawasan bisnis Ruko Mutiara Kosambi II, Benda, dekat Tangerang.
    </p>
    <div style="margin-top: 20px;">
      <a href="index.php" class="button">Kembali ke Beranda</a>
      <a href="https://www.google.com/maps?sca_esv=6ce64e4e4d3a8d9d&biw=1280&bih=585&output=search&q=pt+marlin+jaya+mesin&source=lnms&fbs=ADc_l-ba_IWEPjukbPZWINwpkSLLXFPhcDxAZg033ba6Q9JRwwUFPTUEf-i6_AIubiJSgMt7AS9ouE11Ze89O2tVy3WnlaVRFBtGWzNKSMhEne0HqU_ojiBtb0vjzE_qsaAEWO96L4Gt0AzMhkSQ4twSlFjf0G4PNMTOCVzKn4o8n3X_BtfgML9dkP1_Yd6X3lvDmK_6lK37zMqwfPTAnYA62jxuxseBVA&entry=mc&ved=1t:200715&ictx=111" class="button">Link maps</a>
>>>>>>> 3d454b37c846b98aa976a3391e664398497703fc
    </div>
  </div>

  <div class="scroll-gallery-container">
<<<<<<< HEAD
    <div class="gallery-item reveal">
      <img data-src="../images/Team/saham.jpg"
           src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7"
           alt="Pemegang Saham">
=======
    <div class="gallery-item">
      <img src="../images/Team/saham.jpg" alt="Team 1">
>>>>>>> 3d454b37c846b98aa976a3391e664398497703fc
      <div class="gallery-overlay">
        <h3>Pemegang Saham</h3>
        <p>Informasi struktur pemegang saham dan modal perusahaan yang terverifikasi.</p>
      </div>
    </div>
<<<<<<< HEAD
    <div class="gallery-item reveal">
      <img data-src="../images/Team/team2.jpg"
           src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7"
           alt="Perusahaan Aktif">
=======
    <div class="gallery-item">
      <img src="../images/Team/team2.jpg" alt="Team 2">
>>>>>>> 3d454b37c846b98aa976a3391e664398497703fc
      <div class="gallery-overlay">
        <h3>Perusahaan Aktif</h3>
        <p>Terdaftar sebagai entitas aktif menurut catatan Companies House Indonesia.</p>
      </div>
    </div>
<<<<<<< HEAD
    <div class="gallery-item reveal">
      <img data-src="../images/Team/lokas.jpg"
           src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7"
           alt="Lokasi">
=======
    <div class="gallery-item">
      <img src="../images/Team/lokas.jpg" alt="Team 3">
>>>>>>> 3d454b37c846b98aa976a3391e664398497703fc
      <div class="gallery-overlay">
        <h3>Lokasi</h3>
        <p>Jl. Raya Perancis, Komp. Ruko Mutiara Kosambi 2 Blok A No.42, TANGERANG.</p>
      </div>
    </div>
<<<<<<< HEAD
    <div class="gallery-item reveal">
      <img data-src="../images/Team/badanhukum.jpg"
           src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7"
           alt="Badan Hukum">
=======
    <div class="gallery-item">
      <img src="../images/Team/badanhukum.jpg" alt="Team 4">
>>>>>>> 3d454b37c846b98aa976a3391e664398497703fc
      <div class="gallery-overlay">
        <h3>Badan Hukum</h3>
        <p>PT. Marlin Jaya Mesin terdaftar resmi sebagai Perseroan Terbatas.</p>
      </div>
    </div>
<<<<<<< HEAD
    <div class="gallery-item reveal">
      <img data-src="../images/Team/fakta.jpg"
           src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7"
           alt="Import & Eksport">
      <div class="gallery-overlay">
        <h3>Import &amp; Eksport</h3>
        <p>Merangkum kinerja impor-ekspor global, volume pengiriman, dan mitra dagang utama.</p>
=======
    <div class="gallery-item">
      <img src="../images/Team/fakta.jpg" alt="Team 5">
      <div class="gallery-overlay">
        <h3>Import & Eksport</h3>
        <p>Pt. Marlin Jaya Mesin, merangkum kinerja impor-ekspor globalnya, volume pengiriman, mitra dagang utama, dan tolok ukur pesaing.</p>
>>>>>>> 3d454b37c846b98aa976a3391e664398497703fc
      </div>
    </div>
  </div>
</div>
<<<<<<< HEAD

<footer>© 2025 <span>PT Marlinjaya Mesin</span> · Mining Market · All rights reserved</footer>

<script src="../js/navbar.js"></script>
<script src="../js/user.js"></script>
<script>
function toggleMenu() {
  document.getElementById('hamburger').classList.toggle('open');
  document.getElementById('mobileMenu').classList.toggle('open');
}
</script>
=======

<footer>
  © 2025 <span>PT Marlinjaya Mesin</span> · Mining Market · All rights reserved
</footer>

<script src="../js/navbar.js"></script>
<script>
function toggleMenu() {
  document.getElementById('hamburger').classList.toggle('open');
  document.getElementById('mobileMenu').classList.toggle('open');
}
</script>

>>>>>>> 3d454b37c846b98aa976a3391e664398497703fc
</body>
</html>
