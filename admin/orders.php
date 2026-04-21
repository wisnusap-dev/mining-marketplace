<?php
session_start();
include "../config/database.php";

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}

// --- LOGIKA UPDATE STATUS PESANAN ---
if (isset($_GET['aksi']) && isset($_GET['id'])) {
    $id_order = $_GET['id'];
    $aksi = $_GET['aksi'];
    
    // Tentukan status baru berdasarkan tombol yang diklik
    $status_baru = ($aksi == 'terima') ? 'success' : 'cancelled';
    
    // Update ke database
    $update_query = "UPDATE orders SET status='$status_baru' WHERE id_order='$id_order'";
    if (mysqli_query($conn, $update_query)) {
        echo "<script>
                alert('Status pesanan berhasil diperbarui!');
                window.location.href = 'orders.php';
              </script>";
    } else {
        echo "<script>alert('Gagal memperbarui status!');</script>";
    }
}

// Ambil semua data order
$query = mysqli_query($conn, "SELECT * FROM orders ORDER BY tanggal_order DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Order - Admin Mining Market</title>
    <link rel="stylesheet" href="../css/admin_orders.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
</head>
<body>

    <div class="container">
        <div class="page-header">
            <div class="header-content">
                <a href="dashboard.php" class="btn-back">← Kembali ke Dashboard</a>
                <h1>Kelola Pesanan Masuk</h1>
            </div>
            <div class="header-action">
                <button onclick="window.print()" class="btn-print">⎙ Cetak Laporan</button>
            </div>
        </div>

        <div class="table-card">
            <table class="modern-table">
                <thead>
                    <tr>
                        <th>ID Order</th>
                        <th>User ID</th>
                        <th>ID Produk</th>
                        <th>Jumlah</th>
                        <th>Total Harga</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th>Aksi</th> </tr>
                </thead>
                <tbody>
                    <?php if(mysqli_num_rows($query) > 0): ?>
                        <?php while($row = mysqli_fetch_assoc($query)): ?>
                        <tr>
                            <td><strong>#<?php echo $row['id_order']; ?></strong></td>
                            <td>ID-<?php echo $row['id_user']; ?></td>
                            <td>PROD-<?php echo $row['id_produk']; ?></td>
                            <td><?php echo $row['jumlah_beli']; ?> Pcs</td>
                            <td class="price">Rp <?php echo number_format($row['total_harga'], 0, ',', '.'); ?></td>
                            <td><?php echo date('d M Y, H:i', strtotime($row['tanggal_order'])); ?></td>
                            <td>
                                <span class="badge <?php echo strtolower($row['status']); ?>">
                                    <?php echo strtoupper($row['status']); ?>
                                </span>
                            </td>
                            <td>
                                <?php if($row['status'] == 'pending'): ?>
                                    <div class="action-buttons">
                                        <a href="orders.php?aksi=terima&id=<?php echo $row['id_order']; ?>" class="btn-action btn-accept" onclick="return confirm('Terima pesanan ini?')">✔️ Terima</a>
                                        <a href="orders.php?aksi=tolak&id=<?php echo $row['id_order']; ?>" class="btn-action btn-reject" onclick="return confirm('Tolak pesanan ini?')">❌ Tolak</a>
                                    </div>
                                <?php else: ?>
                                    <span class="text-muted">Selesai Diproses</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" class="empty-state">Belum ada pesanan yang masuk.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>