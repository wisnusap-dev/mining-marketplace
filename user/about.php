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

    <div class="about-wrapper" style="margin-top: 100px;">
    </div>

    <!-- WRAPPER UNTUK KARTU ABOUT -->
    <div class="about-wrapper">
        <div class="about-card">
            <h1>TENTANG <br> KAMI</h1>
            <p>
                PT Marlin Jaya Mesin bergerak di bidang industri manufaktur atau pengolahan, khususnya yang berkaitan dengan pengoperasian mesin-mesin industri.
                <br>
                Nama Perusahaan : <strong>PT. Marlin Jaya Mesin</strong>
                <br>
                Alamat : Jl. Raya Perancis, Komp. Ruko Mutiara Kosambi 2 Blok A No. 42
                <br>
                Kota : TANGERANG
                <br>
                <a href="https://www.google.com/maps/place/PT.marlin+jaya+mesin/@-6.0986256,106.6843811,17z/data=!3m1!4b1!4m6!3m5!1s0x2e6a039b9a1eadd3:0x6f3c0db1d74aec3d!8m2!3d-6.0986256!4d106.686956!16s%2Fg%2F11vhr3yp3d?entry=ttu&g_ep=EgoyMDI2MDUwNi4wIKXMDSoASAFQAw%3D%3D">Link maps</a>
            </p>
            <div>
                <a href="index.php" class="button">Kembali ke Beranda</a>
            </div>
        </div>
    </div>


    <div class="about-grid">
        <div class="about-profile">

            <div class="about-profile">
                <h3></h3>
                <p></p>
            </div>
            <div class="about-profile">
                <h3></h3>
                <p></p>
            </div>
            <div class="about-profile">

            </div>
        </div>
        <div class="scroll-gallery-container">
            <div class="gallery-item">
                <img src="../images/Team/team1.jpg" alt="Foto Tambang 1">
                <div class="gallery-overlay">
                    <div class="overlay-content">
                        <span class="category">OPERASIONAL</span>
                        <h3>Siapa saja pemegang saham PT. Marlin Jaya Mesin?</h3>
                        <p>Pemegang saham PT. Marlin Jaya Mesin dapat diidentifikasi melalui laporan perusahaan yang tersedia di companieshouse.id. Laporan ini berisi informasi registrasi perusahaan Indonesia yang telah diverifikasi, termasuk struktur pemegang saham, modal saham, direksi, dan detail pemilik manfaat.</p>
                    </div>
                </div>
            </div>

            <div class="scroll-gallery-container">
                <div class="gallery-item">
                    <img src="../images/Team/team2.jpg" alt="Foto Tambang 1">
                    <div class="gallery-overlay">
                        <div class="overlay-content">
                            <span class="category">OPERASIONAL</span>
                            <h3>Apakah PT. Marlin Jaya Mesin merupakan perusahaan aktif?</h3>
                            <p>Ya. PT. Marlin Jaya Mesin terdaftar sebagai perusahaan yang aktif menurut catatan Companies House Indonesia.</p>
                        </div>
                    </div>
                </div>

                <div class="scroll-gallery-container">
                    <div class="gallery-item">
                        <img src="../images/Team/team3.jpg" alt="Foto Tambang 1">
                        <div class="gallery-overlay">
                            <div class="overlay-content">
                                <span class="category">OPERASIONAL</span>
                                <h3>Dimana PT. Marlin Jaya berlokasi?</h3>
                                <p>Alamat terdaftar PT. Marlin Jaya Mesin berada Jl. Raya Perancis, Komp. Ruko Mutiara Kosambi 2 Blok A No.42, TANGERANG, Indonesia.</p>
                            </div>
                        </div>
                    </div>


                    <div class="scroll-gallery-container">
                        <div class="gallery-item">
                            <img src="../images/Team/team4.jpg" alt="Foto Tambang 1">
                            <div class="gallery-overlay">
                                <div class="overlay-content">
                                    <span class="category">OPERASIONAL</span>
                                    <h3>PT. Marlin Jaya Mesin berbadan hukum jenis apa?</h3>
                                    <p>PT. Marlin Jaya Mesin terdaftar sebagai Perseroan Terbatas.</p>
                                </div>
                            </div>
                        </div>
                        <!-- Script untuk menjalankan Hamburger Menu di HP -->
                        <script src="../js/navbar.js"></script>
                        <script></script>
</body>

</html>

<footer>
    &copy; 2025 <span>PT Marlinjaya Mesin</span> · Mining Market · All rights reserved
</footer>

<script src="../js/navbar.js">
    function toggleMenu() {
        document.getElementById('hamburger').classList.toggle('open');
        document.getElementById('mobileMenu').classList.toggle('open');
    }
</script>
</body>

</html>