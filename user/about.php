<?php
session_start();
include "../config/database.php"; 
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Mining Market</title>
    <link rel="stylesheet" href="../css/global.css">
    <link rel="stylesheet" href="../css/navbar.css">
    <link rel="stylesheet" href="../css/about.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
       
    </style>
   
</script>
</head>
<body>

    <!-- NAVBAR DIPERBAIKI (Sudah ada bungkus nav dan tombol hamburger) -->
    <nav class="gen-nav">
        <div class="menu-toggle" id="mobile-menu">
            <span class="bar"></span>
            <span class="bar"></span>
            <span class="bar"></span>
        </div>
        <ul id="gen-menu">
            <li><a href="index.php">Home</a></li>
            <li><a href="products.php">Products</a></li> 
            <li><a href="about.php">About</a></li>
            <li><a href="contact.php">Contact Us</a></li>
            <li><a href="cart.php">Keranjang</a></li>
            <li><a href="../logout.php" style="color: #ff4d4d;">Logout</a></li>
        </ul>
    </nav>

    <!-- WRAPPER UNTUK KARTU ABOUT -->
    <div class="about-wrapper">
        <div class="about-card">
            <h1>Tentang Mining Market</h1>
            <p>
                Selamat datang di <strong>Mining Market</strong>, platform marketplace terpercaya 
                khusus untuk kebutuhan industri pertambangan. Kami menyediakan berbagai macam 
                komoditas dan peralatan tambang berkualitas tinggi dengan sistem transaksi yang aman dan transparan.
            </p>
            <p>
                Proyek ini dikembangkan oleh <strong>Muhammad Fahmi</strong> sebagai bagian dari tugas 
                akademik di Universitas Pamulang, Teknik Informatika.
            </p>
            <a href="index.php" class="btn-back">Kembali ke Beranda</a>
        </div>
    </div>

    <!-- Script untuk menjalankan Hamburger Menu di HP -->
   <script src="../js/navbar.js"></script>
</body>
</html>