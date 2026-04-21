<?php 
session_start();
// 1. Keluar satu folder untuk ambil database
include "../config/database.php"; 

$items = [];
$total_bayar = 0;

// Logika 1: Jika beli langsung (hanya 1 ID dari URL)
if(isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    $query = mysqli_query($conn, "SELECT * FROM products WHERE id = '$id'");
    if($row = mysqli_fetch_assoc($query)) {
        $items[] = $row;
        $total_bayar = $row['price'];
    }
} 
// Logika 2: Jika beli dari keranjang (banyak ID dari Session)
elseif(isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    $ids = implode(',', $_SESSION['cart']);
    $query = mysqli_query($conn, "SELECT * FROM products WHERE id IN ($ids)");
    while($row = mysqli_fetch_assoc($query)) {
        $items[] = $row;
        $total_bayar += $row['price'];
    }
} else {
    // 2. Redirect ke products.php yang ada di folder luar
    echo "<script>alert('Pilih produk terlebih dahulu!'); window.location.href='../products.php';</script>";
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Checkout - Konfirmasi Pembayaran</title>
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
    <div class="container">
        <h1 class="main-title">Form Checkout</h1>
        
        <div class="checkout-container">
            <div class="order-summary">
                <strong>Ringkasan Pesanan:</strong><br>
                <ul style="list-style: none; padding: 10px 0;">
                    <?php foreach($items as $item): ?>
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

            <form action="proses_checkout.php" method="POST">
                <div class="form-group">
                    <label>Nama Lengkap</label>
                    <input type="text" name="nama_pembeli" placeholder="Nama Anda" required>
                </div>
                <div class="form-group">
                    <label>Alamat Pengiriman</label>
                    <textarea name="alamat" rows="3" placeholder="Alamat Lengkap..." required></textarea>
                </div>
                <div class="form-group">
                    <label>Metode Pembayaran</label>
                    <select name="metode_bayar" required>
                        <option value="va">Virtual Account</option>
                        <option value="transfer">Transfer Bank</option>
                    </select>
                </div>
                <input type="hidden" name="total_harga" value="<?php echo $total_bayar; ?>">
                
                <button type="submit" class="btn-confirm" style="background: #3d2b1f;">Konfirmasi & Bayar</button>
            </form>
        </div>
    </div>
</body>
</html>