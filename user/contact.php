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
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/navbar.css">
    <link rel="stylesheet" href="../css/contact.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
</head>
<body>
<nav class="gen-nav">
    <!-- Tombol Hamburger -->
    <div class="menu-toggle" id="mobile-menu">
        <span class="bar"></span>
        <span class="bar"></span>
        <span class="bar"></span>
    </div>
    
    <!-- Menu Navigasi -->
    <ul id="gen-menu">
        <li><a href="index.php">Home</a></li>
        <li><a href="products.php">Products</a></li> 
        <li><a href="about.php">About</a></li>
        <li><a href="contact.php">Contact Us</a></li>
        <li><a href="cart.php">Keranjang</a></li>
        <li><a href="../logout.php" style="color: #ff4d4d;">Logout</a></li>
    </ul>
</nav>

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
<script src="../js/navbar.js"></script>
</body>
</html>