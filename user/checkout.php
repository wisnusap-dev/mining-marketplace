<?php
session_start();
include "../config/database.php";

// Proteksi halaman: pastikan user sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

$items       = [];
$total_bayar = 0;

// Skenario Checkout dari Keranjang Belanja
if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    $cart_ids = array_map(function($val) use ($conn) {
        return "'" . mysqli_real_escape_string($conn, $val) . "'";
    }, array_keys($_SESSION['cart']));
    $ids = implode(',', $cart_ids);
    
    $query = mysqli_query($conn, "SELECT * FROM products WHERE id IN ($ids)");
    while ($row = mysqli_fetch_assoc($query)) {
        $qty = $_SESSION['cart'][$row['id']];
        $row['qty'] = $qty; 
        $items[] = $row;
        $total_bayar += ($row['price'] * $qty);
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
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Checkout - Konfirmasi Pembayaran</title>
  <link rel="stylesheet" href="../css/style.css">
  <link rel="stylesheet" href="../css/navbar.css">
</head>
<body>

<nav class="navbar">
  <a href="index.php" class="nav-logo">
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

<div class="mobile-menu" id="mobileMenu">
  <a href="index.php">Home</a>
  <a href="products.php">Products</a>
  <a href="about.php">About</a>
  <a href="contact.php">Contact Us</a>
  <a href="cart.php">🛒 Keranjang</a>
  <a href="../logout.php" class="m-logout">Logout</a>
</div>

<div class="container" style="margin-top: 30px; padding-bottom: 50px;">
  <h1 class="main-title" style="text-align: center; color: #3d2b1f; margin-bottom: 20px;">Form Checkout</h1>
  
  <div class="checkout-container" style="max-width: 600px; margin: auto; background: #fff; padding: 25px; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">

    <div class="order-summary">
      <strong style="color: #3d2b1f; font-size: 1.1rem;">Ringkasan Pesanan:</strong>
      <ul style="list-style: none; padding: 10px 0; margin: 0;">
        <?php foreach ($items as $item): ?>
        <li style="display: flex; justify-content: space-between; margin-bottom: 8px; color: #555;">
          <span>• <?php echo htmlspecialchars($item['name']); ?> <span style="color: #888; font-size: 0.9rem;">(<?php echo $item['qty']; ?>x)</span></span>
          <span>Rp <?php echo number_format($item['price'] * $item['qty'], 0, ',', '.'); ?></span>
        </li>
        <?php endforeach; ?>
      </ul>
      <hr style="border: 0; border-top: 1px solid #eee; margin: 15px 0;">
      <div style="display: flex; justify-content: space-between; font-weight: bold; font-size: 1.2rem; color: #3d2b1f;">
        <span>Total Bayar:</span>
        <span>Rp <?php echo number_format($total_bayar, 0, ',', '.'); ?></span>
      </div>
    </div>

    <form action="proses_checkout.php" method="POST" style="margin-top: 25px;">
      
      <div class="form-group" style="margin-bottom: 15px;">
        <label style="font-weight: bold; color: #3d2b1f;">Nama Lengkap</label>
        <input type="text" name="nama_pembeli" placeholder="Nama Penerima" required 
               style="width: 100%; padding: 10px; margin-top: 5px; border: 1px solid #ddd; border-radius: 5px; box-sizing: border-box;">
      </div>
      
      <div class="form-group" style="margin-bottom: 15px;">
        <label style="font-weight: bold; color: #3d2b1f;">Alamat Pengiriman</label>
        <textarea name="alamat" rows="3" placeholder="Tulis alamat pengiriman lengkap..." required 
                  style="width: 100%; padding: 10px; margin-top: 5px; border: 1px solid #ddd; border-radius: 5px; resize: none; box-sizing: border-box;"></textarea>
      </div>
      
      <div class="form-group" style="margin-bottom: 20px;">
        <label style="font-weight: bold; color: #3d2b1f;">Metode Pembayaran</label>
        <select name="metode_bayar" required 
                style="width: 100%; padding: 10px; margin-top: 5px; border: 1px solid #ddd; border-radius: 5px; background-color: #fff; box-sizing: border-box; cursor: pointer;">
          <option value="va">Virtual Account (Via Midtrans)</option>
          <option value="transfer">Transfer Bank (Via Midtrans)</option>
        </select>
      </div>
      
      <input type="hidden" name="total_harga" value="<?php echo $total_bayar; ?>">
      
      <div style="display: flex; flex-direction: column; gap: 10px; margin-top: 25px;">
        <button type="submit" class="btn-confirm" 
                style="background: #3d2b1f; color: #ffffff; width: 100%; padding: 12px; border: none; cursor: pointer; border-radius: 5px; font-weight: bold; font-size: 1rem; text-align: center; transition: background 0.2s;">
          Konfirmasi & Bayar
        </button>
        <a href="cart.php" 
           style="display: block; text-align: center; background: #d9534f; color: #ffffff; width: 100%; padding: 12px; border-radius: 5px; font-weight: bold; font-size: 1rem; text-decoration: none; box-sizing: border-box; transition: background 0.2s;">
          Batalkan Pembayaran
        </a>
      </div>

    </form>
  </div>
</div>

<script src="../js/navbar.js"></script>
<script>
function toggleMenu() {
  document.getElementById('hamburger').classList.toggle('open');
  document.getElementById('mobileMenu').classList.toggle('open');
}
</script>
</body>
</html>