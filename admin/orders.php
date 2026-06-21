<?php
session_start();
include "../config/database.php";

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['aksi']) && isset($_GET['id'])) {
    $id_order    = (int) $_GET['id'];
    $status_baru = ($_GET['aksi'] === 'terima') ? 'success' : 'cancelled';
    if (mysqli_query($conn, "UPDATE orders SET status='$status_baru' WHERE id_order='$id_order'")) {
        header("Location: orders.php?updated=1");
        exit();
    }
}

$query = mysqli_query($conn, "SELECT * FROM orders ORDER BY tanggal_order DESC");
$username_initial = strtoupper(substr($_SESSION['username'], 0, 1));
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Laporan Order — Admin Mining Market</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../css/admin_layout.css">
  <link rel="stylesheet" href="../css/admin_orders.css">
</head>
<body>

<div id="page-loader">
  <div class="loader-logo">Mining Market</div>
  <div class="loader-bar"><div class="loader-bar-fill"></div></div>
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
    <a href="dashboard.php" class="nav-item"><span class="nav-icon">📊</span> Dashboard</a>
    <a href="products.php"  class="nav-item"><span class="nav-icon">📦</span> Kelola Produk</a>
    <a href="orders.php"    class="nav-item active"><span class="nav-icon">📋</span> Laporan Order</a>
    <div class="nav-section-label" style="margin-top:12px;">Akun</div>
    <a href="../logout.php" class="nav-item logout" data-confirm="Yakin ingin logout?"><span class="nav-icon">⏻</span> Logout</a>
  </nav>
  <div class="sidebar-footer">© 2025 PT Marlinjaya Mesin</div>
</aside>

<header class="topbar">
  <div style="display:flex;align-items:center;gap:16px;">
    <button class="hamburger-admin" onclick="toggleSidebar()"><span></span><span></span><span></span></button>
    <div class="topbar-left">
      <h2>Laporan Order</h2>
      <p>Kelola semua pesanan masuk</p>
    </div>
  </div>
  <div class="topbar-right">
    <span style="font-size:0.8rem;color:var(--text-muted);"><?php echo strtoupper($_SESSION['username']); ?></span>
    <div class="avatar"><?php echo $username_initial; ?></div>
  </div>
</header>

<div class="page-body">
  <main class="page-content">

    <?php if (isset($_GET['updated'])): ?>
    <div class="fade-up" style="background:var(--green-bg);color:var(--green);padding:12px 18px;border-radius:10px;margin-bottom:20px;font-size:0.85rem;font-weight:600;border:1px solid rgba(46,125,50,0.2);">
      ✅ Status pesanan berhasil diperbarui.
    </div>
    <?php endif; ?>

    <!-- SKELETON -->
    <div class="skeleton-screen">
      <div class="card" style="padding:20px;margin-bottom:20px;">
        <div class="skeleton skeleton-h lg" style="width:200px;margin-bottom:4px;"></div>
        <div class="skeleton skeleton-h sm"></div>
      </div>
      <div class="card table-card">
        <?php for ($i = 0; $i < 5; $i++): ?>
        <div style="padding:16px 20px;border-bottom:1px solid var(--border);display:flex;gap:16px;">
          <div class="skeleton skeleton-h" style="width:60px;"></div>
          <div class="skeleton skeleton-h" style="width:80px;"></div>
          <div class="skeleton skeleton-h" style="width:120px;"></div>
          <div class="skeleton skeleton-h" style="width:100px;margin-left:auto;"></div>
        </div>
        <?php endfor; ?>
      </div>
    </div>

    <!-- REAL CONTENT -->
    <div class="real-content" style="display:none;">
      <div class="page-toolbar fade-up">
        <h1>Semua Pesanan</h1>
        <div class="toolbar-actions">
          <button onclick="window.print()" class="btn-outline">⎙ Cetak</button>
          <a href="dashboard.php" class="btn-primary-admin">← Dashboard</a>
        </div>
      </div>

      <div class="card table-card fade-up">
        <div class="table-scroll">
          <table class="modern-table">
            <thead>
              <tr>
                <th>ID</th>
                <th>User</th>
                <th>Nama Pembeli</th>
                <th>Total</th>
                <th>Metode</th>
                <th>Tanggal</th>
                <th>Status</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php if (mysqli_num_rows($query) > 0): ?>
                <?php while ($row = mysqli_fetch_assoc($query)): ?>
                <tr>
                  <td><strong>#<?php echo $row['id_order']; ?></strong></td>
                  <td>ID-<?php echo $row['id_user']; ?></td>
                  <td><?php echo htmlspecialchars($row['nama_pembeli'] ?? '-'); ?></td>
                  <td class="price-cell">Rp <?php echo number_format($row['total_harga'], 0, ',', '.'); ?></td>
                  <td><?php echo strtoupper($row['metode_pembayaran'] ?? '-'); ?></td>
                  <td><?php echo date('d M Y', strtotime($row['tanggal_order'])); ?></td>
                  <td>
                    <span class="badge <?php echo strtolower($row['status']); ?>">
                      <?php echo strtoupper($row['status']); ?>
                    </span>
                  </td>
                  <td>
                    <?php if ($row['status'] === 'pending'): ?>
                    <div class="action-group">
                      <a href="orders.php?aksi=terima&id=<?php echo $row['id_order']; ?>" class="btn-xs accept"
                         data-confirm="Terima pesanan #<?php echo $row['id_order']; ?>?">✔ Terima</a>
                      <a href="orders.php?aksi=tolak&id=<?php echo $row['id_order']; ?>"  class="btn-xs reject"
                         data-confirm="Tolak pesanan #<?php echo $row['id_order']; ?>?">✖ Tolak</a>
                    </div>
                    <?php else: ?>
                    <span class="text-muted-sm">Selesai</span>
                    <?php endif; ?>
                  </td>
                </tr>
                <?php endwhile; ?>
              <?php else: ?>
              <tr class="empty-row">
                <td colspan="8">
                  <span class="empty-icon">📭</span>
                  Belum ada pesanan yang masuk.
                </td>
              </tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>

  </main>
</div>

<script src="../js/admin.js"></script>
</body>
</html>
