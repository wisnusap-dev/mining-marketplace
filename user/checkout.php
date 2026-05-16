<?php
session_start();
include "../config/database.php";

$items = [];
$total_bayar = 0;

if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    $query = mysqli_query($conn, "SELECT * FROM products WHERE id = '$id'");
    if ($row = mysqli_fetch_assoc($query)) {
        $items[] = $row;
        $total_bayar = $row['price'];
    }
} elseif (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    $ids = implode(',', $_SESSION['cart']);
    $query = mysqli_query($conn, "SELECT * FROM products WHERE id IN ($ids)");
    while ($row = mysqli_fetch_assoc($query)) {
        $items[] = $row;
        $total_bayar += $row['price'];
    }
} else {
    echo "<script>alert('Pilih produk terlebih dahulu!'); window.location.href='products.php';</script>";
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Checkout - Konfirmasi Pembayaran</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/navbar.css">
</head>

<body>
    <!-- NAVBAR -->
    <nav class="navbar">
        <a href="index.php" class="nav-logo">
            <img src="../logo/companies.png" alt="Logo">
            <span class="nav-brand">Mining Market</span>
        </a>

        <ul class="nav-links">
            <li><a href="index.php">Home</a></li>
            <li><a href="products.php">Products</a></li>
            <li><a href="about.php">About</a></li>
            <li><a href="contact.php">Contact</a></li>
            <li><a href="cart.php">🛒 Keranjang</a></li>
            <li><a href="../logout.php" class="logout-btn">Logout</a></li>
        </ul>

        <div class="hamburger" id="hamburger" onclick="toggleMenu()">
            <span></span><span></span><span></span>
        </div>
    </nav>

    <!-- MOBILE MENU -->
    <div class="mobile-menu" id="mobileMenu">
        <a href="index.php">Home</a>
        <a href="products.php">Products</a>
        <a href="about.php">About</a>
        <a href="contact.php">Contact Us</a>
        <a href="cart.php">🛒 Keranjang</a>
        <a href="../logout.php" class="m-logout">Logout</a>
    </div>

    <div class="container" style="margin-top: 30px;">
        <h1 class="main-title" style="text-align: center;">Form Checkout</h1>
        <div class="checkout-container" style="max-width: 600px; margin: auto; background: #fff; padding: 20px; border-radius: 10px;">
            <div class="order-summary">
                <strong>Ringkasan Pesanan:</strong><br>
                <ul style="list-style: none; padding: 10px 0;">
                    <?php foreach ($items as $item): ?>
                        <li style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                            <span>• <?php echo $item['name']; ?></span>
                            <span>Rp <?php echo number_format($item['price'], 0, ',', '.'); ?></span>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <hr style="border: 0; border-top: 1px solid #ddd; margin: 10px 0;">
                <div style="display: flex; justify-content: space-between; font-weight: bold; font-size: 1.2rem; color: #3d2b1f;">
                    <span>Total Bayar:</span>
                    <span>Rp <?php echo number_format($total_bayar, 0, ',', '.'); ?></span>
                </div>
            </div>

            <form action="proses_checkout.php" method="POST" style="margin-top: 20px;">
                <div class="form-group" style="margin-bottom: 15px;">
                    <label>Nama Lengkap</label><br>
                    <input type="text" name="nama_pembeli" placeholder="Nama Anda" required style="width: 100%; padding: 8px;">
                </div>
                <div class="form-group" style="margin-bottom: 15px;">
                    <label>Alamat Pengiriman</label><br>
                    <textarea name="alamat" rows="3" placeholder="Alamat Lengkap..." required style="width: 100%; padding: 8px;"></textarea>
                </div>
                <div class="form-group" style="margin-bottom: 15px;">
                    <label>Metode Pembayaran</label><br>
                    <select name="metode_bayar" required style="width: 100%; padding: 8px;">
                        <option value="va">Virtual Account</option>
                        <option value="transfer">Transfer Bank</option>
                    </select>
                </div>
                <!-- INI PENTING UNTUK PROSES_CHECKOUT -->
                <input type="hidden" name="total_harga" value="<?php echo $total_bayar; ?>">

                <div class="checkout-actions">
                    <button type="submit" class="btn-confirm">Konfirmasi & Bayar</button>
                    <a href="../user/products.php" class="btn-cancel">Batalkan Pembayaran</a>
                </div>
            </form>
        </div>
    </div>
    <script src="../js/navbar.js"></script>
</body>

</html>