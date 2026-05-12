<?php
session_start();
// Tetap include database jika ingin menyimpan pesan saran ke tabel khusus nantinya
include "../config/database.php";
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - Mining Market</title>
    <link rel="stylesheet" href="../css/navbar.css">
    <link rel="stylesheet" href="../css/contact.css">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Sans:ital,wght@0,300;0,400;0,500;0,600;1,300&display=swap" rel="stylesheet">
</head>

<body>
    <nav class="navbar">
  <a href="index.php" class="nav-logo">
    <img src="../logo/companies.png" alt="Logo">
    <span class="nav-brand">Mining Market</span>
  </a>

  <ul class="nav-links">
    <li><a href="index.php">Home</a></li>
    <li><a href="products.php">Products</a></li>
    <li><a href="about.php" class="active">About</a></li> <li><a href="contact.php">Contact</a></li>
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



    <div class="contact-container">
        <div class="contact-info">
            <h2>Hubungi Kami</h2>
            <p>Punya pertanyaan mengenai alat tambang atau status pesanan? Tim kami siap membantu Anda.</p>

            <div class="info-item">
                <strong>Alamat Kantor</strong>
                <span>Universitas Pamulang, Tangerang Selatan</span>
            </div>
            <div class="info-item">
                <strong>Email Support</strong>
                <span>support@miningmarket.id</span>
            </div>
            <div class="info-item">
                <strong>WhatsApp</strong>
                <span>+62 812-3456-7890</span>
            </div>
        </div>

        <div class="contact-form">
            <form action="#" method="POST">
                <input type="text" name="nama" placeholder="Nama Lengkap" required>
                <input type="email" name="email" placeholder="Email Aktif" required>
                <textarea name="pesan" rows="5" placeholder="Tulis pesan Anda di sini..." required></textarea>
                <button type="submit" class="btn-send">Kirim Pesan</button>
                <a href="../index.php" class="btn-back">← Kembali ke Beranda</a>
            </form>
        </div>
    </div>
     <footer>
        &copy; 2025 <span>PT Marlinjaya Mesin</span> · Mining Market · All rights reserved
    </footer>

    <script src="../js/navbar.js"></script>
</body>

</html>