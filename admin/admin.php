<?php
session_start();
// Proteksi: Jika belum login, dialihkan ke login.php
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Mining Marketplace</title>
    <link rel="stylesheet" href="../css/admin_dashboard.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
</head>
<body>

    <div class="dashboard-container">
        <div class="header-card">
            <p class="welcome-text">Selamat Datang</p>
            <h1 class="user-name"><?php echo strtoupper($_SESSION['username']); ?>!</h1>
            <div class="gold-divider"></div>
        </div>

        <div class="nav-grid">
            <a href="products.php" class="nav-card">
                <div class="icon">📦</div>
                <span>Kelola Produk</span>
                <p class="card-desc">Tambah, Edit, & Hapus Barang</p>
            </a>

            <a href="orders.php" class="nav-card">
                <div class="icon">📜</div>
                <span>Lihat Pesanan</span>
                <p class="card-desc">Cek Riwayat Transaksi</p>
            </a>

            <a href="logout.php" class="nav-card logout-card" onclick="return confirm('Yakin ingin keluar?')">
                <div class="icon">⏻</div>
                <span>Logout</span>
                <p class="card-desc">Keluar dari Sistem</p>
            </a>
        </div>
    </div>

</body>
</html>