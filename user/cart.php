<?php
session_start();
// 1. Perbaikan Path Database: keluar satu folder
include "../config/database.php"; 

// Logika Tambah ke Keranjang
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
    
    if (!in_array($id, $_SESSION['cart'])) {
        array_push($_SESSION['cart'], $id);
    }
    // Tetap di folder yang sama
    header("Location: cart.php");
    exit();
}

// Logika Hapus Item
if (isset($_GET['remove'])) {
    $id = $_GET['remove'];
    if (($key = array_search($id, $_SESSION['cart'])) !== false) {
        unset($_SESSION['cart'][$key]);
    }
    header("Location: cart.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Keranjang Belanja - Mining Market</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <ul id="gen-menu">
    <li><a href="index.php">Home</a></li>
    <li><a href="products.php">Products</a></li> 
    <li><a href="about.php">About</a></li>
    <li><a href="contact.php">Contact Us</a></li>
    <li><a href="cart.php">Cart</a></li>
</ul>
    <nav class="gen-nav">
        <ul id="gen-menu">
            <li><a href="../products.php">Lanjut Belanja</a></li>
        </ul>
    </nav>

    <div class="container">
        <h1 class="main-title">Keranjang Belanja Anda</h1>
        <div class="checkout-container" style="max-width: 800px;">
            <?php if (empty($_SESSION['cart'])): ?>
                <p style="text-align:center;">Keranjang kosong. <a href="../products.php">Belanja sekarang?</a></p>
            <?php else: ?>
                <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
                    <tr style="border-bottom: 2px solid #3d2b1f; text-align: left;">
                        <th style="padding: 10px;">Produk</th>
                        <th>Harga</th>
                        <th>Aksi</th>
                    </tr>
                    <?php
                    $total = 0;
                    $ids = implode(',', $_SESSION['cart']);
                    // Pastikan koneksi $conn aman karena path include sudah benar
                    $query = mysqli_query($conn, "SELECT * FROM products WHERE id IN ($ids)");
                    while ($row = mysqli_fetch_assoc($query)):
                        $total += $row['price'];
                    ?>
                    <tr style="border-bottom: 1px solid #ddd;">
                        <td style="padding: 10px;"><?php echo $row['name']; ?></td>
                        <td>Rp <?php echo number_format($row['price'], 0, ',', '.'); ?></td>
                        <td><a href="cart.php?remove=<?php echo $row['id']; ?>" style="color: red; text-decoration: none;">Hapus</a></td>
                    </tr>
                    <?php endwhile; ?>
                    <tr style="font-weight: bold; background: #fcfaf7; color: #3d2b1f;">
                        <td style="padding: 10px;">Total Bayar</td>
                        <td colspan="2">Rp <?php echo number_format($total, 0, ',', '.'); ?></td>
                    </tr>
                </table>
                <a href="checkout.php" class="btn-confirm" style="display:block; text-align:center; text-decoration:none; background: #3d2b1f; color: white; padding: 10px; border-radius: 5px;">Lanjut Ke Pembayaran</a>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>