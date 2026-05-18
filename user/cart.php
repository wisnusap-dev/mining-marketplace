<?php
session_start();
include "../config/database.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
    if (!in_array($id, $_SESSION['cart'])) {
        array_push($_SESSION['cart'], $id);
    }
    header("Location: cart.php");
    exit();
}

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
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Keranjang Belanja - Mining Market</title>
  <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Sans:ital,wght@0,300;0,400;0,500;0,600;1,300&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../css/cart.css">
  <link rel="stylesheet" href="../css/navbar.css">
</head>
<body>

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
    <li><a href="cart.php" class="active">🛒 Keranjang</a></li>
    <li><a href="../logout.php" class="logout-btn">Logout</a></li>
  </ul>
  <div class="hamburger" id="hamburger" onclick="toggleMenu()">
    <span></span><span></span><span></span>
  </div>
</nav> <div class="mobile-menu" id="mobileMenu">
  <a href="index.php">Home</a>
  <a href="products.php">Products</a>
  <a href="about.php">About</a>
  <a href="contact.php">Contact Us</a>
  <a href="cart.php">🛒 Keranjang</a>
  <a href="../logout.php" class="m-logout">Logout</a>
</div>

<div class="container" style="margin-top: 30px;">
  <h1 class="main-title" style="text-align: center;">Keranjang Belanja Anda</h1>
  <div class="checkout-container" style="max-width: 800px; margin: auto; background: #fff; padding: 20px; border-radius: 10px;">
    <?php if (empty($_SESSION['cart'])): ?>
      <p style="text-align:center;">Keranjang kosong. <a href="products.php">Belanja sekarang?</a></p>
    <?php else: ?>
      <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
        <tr style="border-bottom: 2px solid #3d2b1f; text-align: left;">
          <th style="padding: 10px;">Produk</th>
          <th>Harga</th>
          <th>Aksi</th>
        </tr>
        <?php
        $total = 0;
        
        // Proteksi klausa IN () untuk menghindari error SQL bila data bermasalah
        $cart_ids = array_map(function($val) use ($conn) {
            return "'" . mysqli_real_escape_string($conn, $val) . "'";
        }, $_SESSION['cart']);
        $ids   = implode(',', $cart_ids);
        
        $query = mysqli_query($conn, "SELECT * FROM products WHERE id IN ($ids)");
        while ($row = mysqli_fetch_assoc($query)):
          $total += $row['price'];
        ?>
        <tr style="border-bottom: 1px solid #ddd;">
          <td style="padding: 10px;"><?php echo htmlspecialchars($row['name']); ?></td>
          <td>Rp <?php echo number_format($row['price'], 0, ',', '.'); ?></td>
          <td>
            <a href="cart.php?remove=<?php echo $row['id']; ?>" style="color: red; text-decoration: none;">Hapus</a>
          </td>
        </tr>
        <?php endwhile; ?>
        <tr style="font-weight: bold; background: #fcfaf7; color: #3d2b1f;">
          <td style="padding: 10px;">Total Bayar</td>
          <td colspan="2">Rp <?php echo number_format($total, 0, ',', '.'); ?></td>
        </tr>
      </table>
      <div style="display: flex; justify-content: space-between;">
        <a href="products.php" style="padding: 10px; text-decoration: none; color: #3d2b1f; border: 1px solid #3d2b1f; border-radius: 5px;">
          Lanjut Belanja
        </a>
        <a href="checkout.php" class="btn-confirm" style="text-decoration: none; background: #3d2b1f; color: white; padding: 10px 20px; border-radius: 5px;">
          Lanjut Pembayaran
        </a>
      </div>
    <?php endif; ?>
  </div>
</div>

<footer>
  <span>© <?php echo date('Y'); ?></span>
  <a href="index.php">PT Marlinjaya Mesin</a>
  <span class="dot">·</span>
  <span>Mining Market</span>
  <span class="dot">·</span>
  <span>All rights reserved</span>
</footer>

<script src="../js/navbar.js"></script>
<script>
function toggleMenu() {
  document.getElementById('hamburger').classList.toggle('open');
  document.getElementById('mobileMenu').classList.toggle('open');
}
</script>

</body>
</html>