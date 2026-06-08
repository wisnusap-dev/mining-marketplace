<?php
session_start();
include "../config/database.php";

if (!isset($_SESSION['admin_logged_in'])) {
  header("Location: login.php");
  exit();
}

$total_produk  = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as t FROM products"))['t'] ?? 0;
$total_pesanan = 0;
$total_revenue = 0;
$json_labels   = json_encode(['No Data']);
$json_data     = json_encode([0]);

$check = mysqli_query($conn, "SHOW TABLES LIKE 'orders'");
if (mysqli_num_rows($check) > 0) {
  $total_pesanan = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as t FROM orders"))['t'] ?? 0;
  $rev = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(total_harga) as r FROM orders WHERE status='success'"));
  $total_revenue = $rev['r'] ?? 0;

  $q = mysqli_query($conn, "SELECT DATE(tanggal_order) as tgl, COUNT(*) as jml
                               FROM orders GROUP BY DATE(tanggal_order)
                               ORDER BY tgl ASC LIMIT 7");
  $labels = [];
  $data_jml = [];
  while ($r = mysqli_fetch_assoc($q)) {
    $labels[]   = date('d M', strtotime($r['tgl']));
    $data_jml[] = (int)$r['jml'];
  }
  if (!empty($labels)) {
    $json_labels = json_encode($labels);
    $json_data   = json_encode($data_jml);
  }
}

$username_initial = strtoupper(substr($_SESSION['username'], 0, 1));
?>
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard — Admin Mining Market</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../css/admin_layout.css">
  <link rel="stylesheet" href="../css/admin_dashboard.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>

  <div id="page-loader">
    <div class="loader-logo">Mining Market</div>
    <div class="loader-bar">
      <div class="loader-bar-fill"></div>
    </div>
  </div>

  <div class="sidebar-overlay" id="sidebar-overlay"></div>

  <aside class="sidebar" id="sidebar">
    <div class="sidebar-logo">
      <img src="../logo/companies.png" alt="Logo">
      <div class="sidebar-logo-text">
        <span class="brand">Mining Market</span>
        <span class="sub">Admin Panel</span>
      </div>
    </div>

    <nav class="sidebar-nav">
      <div class="nav-section-label">Menu</div>
      <a href="dashboard.php" class="nav-item active">
        <i class="bi bi-columns-gap"></i> Dashboard
      </a>
      <a href="products.php" class="nav-item">
        <i class="bi bi-box-fill"></i> Kelola Produk
      </a>
      <a href="orders.php" class="nav-item">
        <i class="bi bi-flag-fill"></i> Laporan Order
      </a>

      <div class="nav-section-label" style="margin-top: 12px;">Akun</div>
      <a href="../logout.php" class="nav-item logout" data-confirm="Yakin ingin logout?">
        <i class="bi bi-box-arrow-left"></i> Logout
      </a>
    </nav>

    <div class="sidebar-footer">© 2025 PT Marlinjaya Mesin</div>
  </aside>

  <header class="topbar">
    <div style="display:flex; align-items:center; gap:16px;">
      <button class="hamburger-admin" onclick="toggleSidebar()">
        <span></span><span></span><span></span>
      </button>
      <div class="topbar-left">
        <h2>Dashboard</h2>
        <p>Ringkasan operasional sistem</p>
      </div>
    </div>
    <div class="topbar-right">
      <span style="font-size:0.8rem; color:var(--text-muted);"><?php echo strtoupper($_SESSION['username']); ?></span>
      <div class="avatar"><?php echo $username_initial; ?></div>
    </div>
  </header>

  <div class="page-body">
    <main class="page-content">

      <div class="skeleton-screen">
        <div class="stats-grid">
          <?php for ($i = 0; $i < 3; $i++): ?>
            <div class="card skeleton-block skeleton-stat"></div>
          <?php endfor; ?>
        </div>
        <div class="card" style="height: 340px; border-radius: var(--radius);" class="skeleton-block skeleton"></div>
      </div>

      <div class="real-content" style="display:none;">

        <div class="stats-grid">
          <div class="stat-card fade-up">
            <i class="bi bi-box-fill"></i>
            <div class="stat-label">Total Produk</div>
            <div class="stat-value" data-target="<?php echo $total_produk; ?>">0</div>
            <div class="stat-sub">Aktif di katalog</div>
          </div>
          <div class="stat-card fade-up">
            <i class="bi bi-card-text"></i>
            <div class="stat-label">Total Pesanan</div>
            <div class="stat-value" data-target="<?php echo $total_pesanan; ?>">0</div>
            <div class="stat-sub">Transaksi masuk</div>
          </div>
          <div class="stat-card fade-up">
            <i class="bi bi-database"></i>
            <div class="stat-label">Status Database</div>
            <div class="stat-value" style="font-size:1.4rem; color:var(--green);">Online</div>
            <div class="stat-sub">Terhubung aman</div>
          </div>
          <div class="stat-card fade-up">
            <i class="bi bi-person-circle"></i>
            <div class="stat-label">karyawan Aktif</div>
            <div class="stat-value" style="font-size:1.4rem; color:var(--green);">Online</div>
            <div class="stat-sub">Terhubung aman</div>
          </div>
        </div>

        <div class="card chart-card fade-up">
          <div class="chart-card-header">
            <h3>Pesanan 7 Hari Terakhir</h3>
            <span class="badge-live">Live</span>
          </div>
          <div class="chart-wrapper">
            <canvas id="canvasChart"></canvas>
          </div>
        </div>

        <div class="actions-grid fade-up">
          <a href="products.php" class="action-btn">
            <i class="bi bi-box-fill"></i>
            Kelola Produk
          </a>
          <a href="orders.php" class="action-btn">
            <i class="bi bi-check2-square"></i>
            Laporan Order
          </a>
          <a href="../user/index.php" class="action-btn" target="_blank">
            <i class="bi bi-shop"></i>
            Lihat Toko
          </a>
          <a href="../logout.php" class="action-btn danger" data-confirm="Yakin ingin logout?">
            <i class="bi bi-box-arrow-left"></i>
            Logout
          </a>
        </div>

      </div>
    </main>
  </div>

  <script>
    const chartLabels = <?php echo $json_labels; ?>;
    const chartData = <?php echo $json_data; ?>;
  </script>
  <script src="../js/dashboard_chart.js"></script>
  <script src="../js/admin.js"></script>
</body>

</html>