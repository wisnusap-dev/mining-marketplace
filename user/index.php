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
    <title>Dashboard User - PT MARLINJAYA MESIN</title>
    
    <link rel="stylesheet" href="../css/global.css">
    <link rel="stylesheet" href="../css/navbar.css">
    <link rel="stylesheet" href="../css/home.css"> <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;800&display=swap" rel="stylesheet">
</head>
<body>

<nav class="gen-nav">
    <a href="index.php" class="nav-logo">
        <img src="../logo/companies.png" alt="Logo">
    </a>

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
        <li><a href="../logout.php" class="logout-btn">Logout</a></li>
    </ul>
</nav>

<section class="hero-wrapper">
    <div class="hero-content">
        <h1>PT MARLINJAYA MESIN</h1>
        <p>Halo, <strong><?php echo $_SESSION['username']; ?></strong>. Tingkatkan efisiensi operasional tambang Anda dengan armada mesin tangguh dan teknologi terkini.</p>
        <a href="products.php" class="btn-modern">Lihat Katalog Produk</a>
    </div>
</section>

<section class="container" style="padding: 100px 20px;">
    <h2 style="text-align: center; font-size: 2.5rem; color: #1a1a1a; margin-bottom: 10px;">Kenapa Memilih Kami?</h2>
    <p style="text-align: center; color: #777; margin-bottom: 40px;">Kami memberikan standar baru dalam industri alat berat.</p>
    
    <div class="features-grid">
        <div class="feature-card">
            <h3>Mesin Bersertifikat</h3>
            <p>Semua unit kami telah melalui inspeksi ketat dan memiliki sertifikasi internasional.</p>
        </div>
        <div class="feature-card">
            <h3>Dukungan 24/7</h3>
            <p>Tim teknisi ahli kami siap membantu Anda kapan saja di lokasi pertambangan.</p>
        </div>
        <div class="feature-card">
            <h3>Suku Cadang Asli</h3>
            <p>Ketersediaan suku cadang original untuk memastikan mesin tetap beroperasi maksimal.</p>
        </div>
    </div>
</section>

<script src="../js/navbar.js"></script>
</body>
</html>