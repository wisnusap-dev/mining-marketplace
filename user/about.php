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
    <link rel="stylesheet" href="../css/navbar.css">
    <link rel="stylesheet" href="../css/about.css">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Sans:wght@400;500;700&display=swap" rel="stylesheet">
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
            <li><a href="about.php" class="active">About</a></li>
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

    <div class="about-wrapper">
        <div class="about-card">
            <h1>TENTANG <br> KAMI</h1>
            <p>
                PT Marlin Jaya Mesin adalah perusahaan terbatas (Limited Liability Company) Indonesia yang berfokus sebagai importir dan penyedia mesin, berlokasi di Tangerang. Perusahaan ini bergerak dalam impor mesin industri/umum dan berlokasi strategis di kawasan bisnis Ruko Mutiara Kosambi II, Benda, dekat Tangerang.
            </p>
            <div style="margin-top: 20px;">
                <a href="index.php" class="button">Kembali ke Beranda</a>
                <a href="https://www.google.com/maps?sca_esv=6ce64e4e4d3a8d9d&biw=1280&bih=585&output=search&q=pt+marlin+jaya+mesin&source=lnms&fbs=ADc_l-ba_IWEPjukbPZWINwpkSLLXFPhcDxAZg033ba6Q9JRwwUFPTUEf-i6_AIubiJSgMt7AS9ouE11Ze89O2tVy3WnlaVRFBtGWzNKSMhEne0HqU_ojiBtb0vjzE_qsaAEWO96L4Gt0AzMhkSQ4twSlFjf0G4PNMTOCVzKn4o8n3X_BtfgML9dkP1_Yd6X3lvDmK_6lK37zMqwfPTAnYA62jxuxseBVA&entry=mc&ved=1t:200715&ictx=111" class="button">Link maps</a>
            </div>
        </div>

        <div class="scroll-gallery-container">
            <div class="gallery-item">
                <img src="../images/Team/saham.jpg" alt="Team 1">
                <div class="gallery-overlay">
                    <h3>Pemegang Saham</h3>
                    <p>Informasi struktur pemegang saham dan modal perusahaan yang terverifikasi.</p>
                </div>
            </div>

            <div class="gallery-item">
                <img src="../images/Team/team2.jpg" alt="Team 2">
                <div class="gallery-overlay">
                    <h3>Peerusahaan Aktif</h3>
                    <p>Terdaftar sebagai entitas aktif menurut catatan Companies House Indonesia.</p>
                </div>
            </div>

            <div class="gallery-item">
                <img src="../images/Team/lokas.jpg" alt="Team 3">
                <div class="gallery-overlay">
                    <h3>Lokasi</h3>
                    <p>Jl. Raya Perancis, Komp. Ruko Mutiara Kosambi 2 Blok A No.42, TANGERANG.</p>
                </div>
            </div>

            <div class="gallery-item">
                <img src="../images/Team/badanhukum.jpg" alt="Team 4">
                <div class="gallery-overlay">
                    <h3>Badan Hukum</h3>
                    <p>PT. Marlin Jaya Mesin terdaftar resmi sebagai Perseroan Terbatas.</p>
                </div>
            </div>

            <div class="gallery-item">
                <img src="../images/Team/fakta.jpg" alt="Team 4">
                <div class="gallery-overlay">
                    <h3>Import & Eksport</h3>
                    <p>Pt. Marlin Jaya Mesin, merangkum kinerja impor-ekspor globalnya, volume pengiriman, mitra dagang utama, dan tolok ukur pesaing. Dengan menggunakan alat Matchmaker, Importir dan Eksportir dapat menilai apakah Pt. Marlin Jaya Mesin adalah mitra yang tepat untuk bisnis Anda, sementara alat Intelijen Kompetitif membantu Anda memantau aktivitas pesaing, melihat pola yang muncul, dan mengidentifikasi peluang strategis untuk posisi pasar yang lebih kuat.</p>
                </div>
            </div>
        </div>
    </div>
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
</body>

</html>