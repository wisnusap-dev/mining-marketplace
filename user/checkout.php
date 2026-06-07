<?php
session_start();
include "../config/database.php";

$items       = [];
$total_bayar = 0;

<<<<<<< HEAD
if (isset($_GET['id'])) {
    $id    = mysqli_real_escape_string($conn, $_GET['id']);
    $query = mysqli_query($conn, "SELECT * FROM products WHERE id = '$id'");
    if ($row = mysqli_fetch_assoc($query)) {
        $items[]     = $row;
        $total_bayar = $row['price'];
    }
} elseif (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    $ids   = implode(',', $_SESSION['cart']);
    $query = mysqli_query($conn, "SELECT * FROM products WHERE id IN ($ids)");
    while ($row = mysqli_fetch_assoc($query)) {
        $items[]     = $row;
        $total_bayar += $row['price'];
=======
// Skenario Checkout dari Keranjang Belanja
if(isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    $cart_ids = array_map(function($val) use ($conn) {
        return "'" . mysqli_real_escape_string($conn, $val) . "'";
    }, array_keys($_SESSION['cart']));
    $ids = implode(',', $cart_ids);
    
    $query = mysqli_query($conn, "SELECT * FROM products WHERE id IN ($ids)");
    while($row = mysqli_fetch_assoc($query)) {
        $qty = $_SESSION['cart'][$row['id']];
        $row['qty'] = $qty; 
        $items[] = $row;
        $total_bayar += ($row['price'] * $qty);
>>>>>>> 3d454b37c846b98aa976a3391e664398497703fc
    }
} else {
    echo "<script>alert('Pilih produk terlebih dahulu!'); window.location.href='products.php';</script>";
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<<<<<<< HEAD
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
      <strong>Ringkasan Pesanan:</strong>
      <ul style="list-style: none; padding: 10px 0;">
        <?php foreach ($items as $item): ?>
        <li style="display: flex; justify-content: space-between; margin-bottom: 5px;">
          <span>• <?php echo htmlspecialchars($item['name']); ?></span>
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
      <input type="hidden" name="total_harga" value="<?php echo $total_bayar; ?>">
      <div class="checkout-actions">
        <button type="submit" class="btn-confirm">Konfirmasi & Bayar</button>
        <a href="../user/products.php" class="btn-cancel">Batalkan Pembayaran</a>
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

=======
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
  </nav>

  <div class="container" style="margin-top: 30px;">
        <h1 class="main-title" style="text-align: center;">Form Checkout</h1>
        <div class="checkout-container" style="max-width: 600px; margin: auto; background: #fff; padding: 20px; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
            <div class="order-summary">
                <strong>Ringkasan Pesanan:</strong><br>
                <ul style="list-style: none; padding: 10px 0;">
                    <?php foreach($items as $item): ?>
                        <li style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                            <span>• <?php echo htmlspecialchars($item['name']); ?> (<?php echo $item['qty']; ?>x)</span>
                            <span>Rp <?php echo number_format($item['price'] * $item['qty'], 0, ',', '.'); ?></span>
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
                    <label style="font-weight: bold; color: #3d2b1f;">Nama Lengkap</label><br>
                    <input type="text" name="nama_pembeli" placeholder="Nama Anda" required style="width: 100%; padding: 10px; margin-top: 5px; border: 1px solid #ddd; border-radius: 5px;">
                </div>
                <div class="form-group" style="margin-bottom: 15px;">
                    <label style="font-weight: bold; color: #3d2b1f;">Alamat Pengiriman</label><br>
                    <textarea name="alamat" rows="3" placeholder="Alamat Lengkap..." required style="width: 100%; padding: 10px; margin-top: 5px; border: 1px solid #ddd; border-radius: 5px; resize: none;"></textarea>
                </div>
                
                <input type="hidden" name="total_harga" value="<?php echo $total_bayar; ?>">
                
                <div style="display: flex; flex-direction: column; gap: 10px; margin-top: 20px;">
                     <button type="submit" class="btn-confirm" style="background: #3d2b1f; color: #ffffff; width: 100%; padding: 12px; border: none; cursor: pointer; border-radius: 5px; font-weight: bold; font-size: 1rem; text-align: center;">
                         Konfirmasi & Bayar
                     </button>
                     <a href="cart.php" style="display: block; text-align: center; background: #4e3624; color: #ffffff; width: 100%; padding: 12px; border-radius: 5px; font-weight: bold; font-size: 1rem; text-decoration: none;">
                         Batalkan Pembayaran
                     </a>
                </div>
            </form>
        </div>
    </div>
>>>>>>> 3d454b37c846b98aa976a3391e664398497703fc
</body>
</html>
