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
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body {
            background-color: #3d2b1f; /* Cokelat khas tambang */
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .contact-container {
            background: #fff;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.4);
            max-width: 900px;
            width: 100%;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
        }
        .contact-info h2 {
            color: #3d2b1f;
            margin-bottom: 20px;
        }
        .contact-info p {
            color: #666;
            font-size: 14px;
            line-height: 1.6;
        }
        .info-item {
            margin-top: 20px;
        }
        .info-item strong {
            display: block;
            color: #d4aa61;
            font-size: 12px;
            text-transform: uppercase;
        }
        .contact-form input, .contact-form textarea {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-family: 'Poppins', sans-serif;
        }
        .btn-send {
            background: #3d2b1f;
            color: #fff;
            border: none;
            padding: 12px 30px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            width: 100%;
            transition: 0.3s;
        }
        .btn-send:hover {
            background: #d4aa61;
        }
        .btn-back {
            display: block;
            text-align: center;
            margin-top: 15px;
            text-decoration: none;
            color: #888;
            font-size: 13px;
        }

        /* Responsif untuk HP */
        @media (max-width: 768px) {
            .contact-container { grid-template-columns: 1fr; }
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

</body>
</html>