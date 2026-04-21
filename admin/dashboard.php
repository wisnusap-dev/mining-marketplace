<?php
session_start();
include "../config/database.php";

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}

// AMBIL DATA STATISTIK
$total_produk = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as t FROM products"))['t'] ?? 0;

// Cek tabel orders & ambil data
$total_pesanan = 0;
$check_table = mysqli_query($conn, "SHOW TABLES LIKE 'orders'");
if(mysqli_num_rows($check_table) > 0) {
    $total_pesanan = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as t FROM orders"))['t'] ?? 0;
    
    // Data Grafik 7 Hari Terakhir
    $query_chart = mysqli_query($conn, "SELECT DATE(tanggal_order) as tgl, COUNT(*) as jml FROM orders GROUP BY DATE(tanggal_order) ORDER BY tgl ASC LIMIT 7");
    $labels = []; $data_jml = [];
    while($r = mysqli_fetch_assoc($query_chart)){
        $labels[] = date('d M', strtotime($r['tgl']));
        $data_jml[] = $r['jml'];
    }
}

// Default jika data grafik kosong
$json_labels = json_encode(!empty($labels) ? $labels : ['No Data']);
$json_data = json_encode(!empty($data_jml) ? $data_jml : [0]);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard Premium</title>
    <link rel="stylesheet" href="../css/admin_dashboard.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="main-content">
        <div class="header">
            <div class="welcome">
                <p>Ringkasan Sistem</p>
                <h1>Dashboard Admin</h1>
            </div>
            <div class="user-info">
                <span><?php echo strtoupper($_SESSION['username']); ?></span>
            </div>
        </div>

        <div class="stats-container">
            <div class="stat-card">
                <h3>Total Produk</h3>
                <p class="value"><?php echo $total_produk; ?></p>
                <span class="trend">Aktif di Katalog</span>
            </div>
            <div class="stat-card">
                <h3>Total Pesanan</h3>
                <p class="value"><?php echo $total_pesanan; ?></p>
                <span class="trend">Transaksi Masuk</span>
            </div>
            <div class="stat-card">
                <h3>Status Database</h3>
                <p class="value" style="color: #4caf50;">Online</p>
                <span class="trend">Terhubung Aman</span>
            </div>
        </div>

        <div class="chart-section">
            <div class="chart-header">
                <h3>Analisis Penjualan Mingguan</h3>
            </div>
            <div class="chart-wrapper">
                <canvas id="canvasChart"></canvas>
            </div>
        </div>

        <div class="menu-grid">
            <a href="products.php" class="menu-btn">📦 Kelola Produk</a>
            <a href="orders.php" class="menu-btn">📜 Laporan Order</a>
            <a href="logout.php" class="menu-btn logout" onclick="return confirm('Logout?')">⏻ Logout</a>
        </div>
    </div>

    <script>
        const chartLabels = <?php echo $json_labels; ?>;
        const chartData = <?php echo $json_data; ?>;
    </script>
    <script src="js/dashboard_chart.js"></script>
</body>
</html>