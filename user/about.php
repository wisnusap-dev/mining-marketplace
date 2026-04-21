<?php
session_start();
// Tetap sertakan database jika ingin menampilkan data dinamis, 
// tapi gunakan ../ karena file ini di dalam folder 'user'
include "../config/database.php"; 
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Mining Market</title>
    <link rel="stylesheet" href="../css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body {
            background-color: #3d2b1f; /* Warna cokelat tambang khas kamu */
            font-family: 'Poppins', sans-serif;
            color: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }
        .about-card {
            background: #fff;
            color: #333;
            padding: 40px;
            border-radius: 20px;
            max-width: 600px;
            text-align: center;
            box-shadow: 0 15px 35px rgba(0,0,0,0.5);
            margin: 20px;
        }
        .about-card h1 {
            color: #3d2b1f;
            margin-bottom: 20px;
        }
        .about-card p {
            line-height: 1.8;
            color: #666;
        }
        .btn-back {
            display: inline-block;
            margin-top: 25px;
            padding: 10px 25px;
            background: #d4aa61;
            color: #fff;
            text-decoration: none;
            border-radius: 50px;
            font-weight: 600;
            transition: 0.3s;
        }
        .btn-back:hover {
            background: #3d2b1f;
            transform: translateY(-3px);
        }
    </style>
</head>
<body>
  <ul id="gen-menu">
    <li><a href="index.php">Home</a></li>
    <li><a href="products.php">Products</a></li> 
    <li><a href="about.php">About</a></li>
    <li><a href="contact.php">Contact Us</a></li>
    <li><a href="cart.php">Cart</a></li>
</ul>
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
        
        <a href="../index.php" class="btn-back">Kembali ke Beranda</a>
    </div>

</body>
</html>