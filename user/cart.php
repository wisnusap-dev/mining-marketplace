<?php
session_start();
include "../config/database.php";

if (isset($_GET['id'])) {
    if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];
    if (!in_array($_GET['id'], $_SESSION['cart'])) array_push($_SESSION['cart'], $_GET['id']);
    header("Location: cart.php?added=1");
    exit();
}

if (isset($_GET['remove'])) {
    $key = array_search($_GET['remove'], $_SESSION['cart'] ?? []);
    if ($key !== false) unset($_SESSION['cart'][$key]);
    header("Location: cart.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Keranjang — Mining Market</title>
  <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../css/navbar.css">
  <link rel="stylesheet" href="../css/cart.css">
  <link rel="stylesheet" href="../css/user_fx.css">
  <style>
    .cart-wrap { max-width: 860px; margin: calc(var(--nav-h) + 40px) auto 80px; padding: 0 24px; }
    .cart-title { font-family:'Bebas Neue',sans-serif; font-size:2.5rem; color:var(--brown); letter-spacing:2px; margin-bottom:28px; }
    .cart-card { background:#fff; border-radius:16px; border:1px solid rgba(201,151,58,0.12); box-shadow:0 4px 24px rgba(44,26,14,0.08); overflow:hidden; }
    .cart-table { width:100%; border-collapse:collapse; }
    .cart-table th { padding:14px 20px; font-size:0.7rem; font-weight:600; text-transform:uppercase; letter-spacing:1.5px; color:#9a8070; background:#faf7f2; border-bottom:1px solid #ede8e2; text-align:left; }
    .cart-table td { padding:16px 20px; border-bottom:1px solid #ede8e2; font-size:0.9rem; color:var(--brown); vertical-align:middle; }
    .cart-table tr:last-child td { border-bottom:none; }
    .cart-table tr:hover td { background:#fdf9f4; }
    .cart-item-name { font-weight:600; }
    .cart-price { font-family:'Bebas Neue',sans-serif; font-size:1.2rem; color:var(--gold); letter-spacing:1px; }
    .cart-remove { color:#e53935; text-decoration:none; font-size:0.8rem; font-weight:600; transition:opacity 0.2s; }
    .cart-remove:hover { opacity:0.7; }
    .cart-total-row td { background:#fcfaf7; font-weight:700; font-size:1rem; }
    .cart-total-row .cart-price { font-size:1.5rem; color:var(--brown); }
    .cart-actions { display:flex; justify-content:space-between; align-items:center; padding:20px 24px; border-top:1px solid #ede8e2; flex-wrap:wrap; gap:12px; }
    .cart-empty { text-align:center; padding:60px 20px; color:var(--text-muted); }
    .cart-empty .icon { font-size:3rem; margin-bottom:16px; }
    .cart-empty h3 { font-family:'Bebas Neue',sans-serif; font-size:1.8rem; color:var(--brown); margin-bottom:8px; }
    .btn-continue { padding:11px 22px; border:1.5px solid var(--brown); border-radius:8px; color:var(--brown); text-decoration:none; font-size:0.85rem; font-weight:600; transition:background 0.2s,color 0.2s; }
    .btn-continue:hover { background:var(--brown); color:var(--cream); }
    .btn-checkout { padding:11px 28px; background:var(--brown); border-radius:8px; color:var(--cream); text-decoration:none; font-size:0.85rem; font-weight:600; transition:background 0.2s; }
    .btn-checkout:hover { background:var(--gold); color:var(--brown); }
  </style>
</head>
<body>

<div id="user-loader">
  <div class="loader-gear">⚙️</div>
  <div class="loader-brand">Mining Market</div>
  <div class="loader-line"><div class="loader-line-fill"></div></div>
</div>

<div id="scroll-progress"></div>

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
</nav>

<div class="mobile-menu" id="mobileMenu">
  <a href="index.php">Home</a>
  <a href="products.php">Products</a>
  <a href="about.php">About</a>
  <a href="contact.php">Contact Us</a>
  <a href="cart.php">🛒 Keranjang</a>
  <a href="../logout.php" class="m-logout">Logout</a>
</div>

<div class="cart-wrap">
  <h1 class="cart-title reveal">🛒 Keranjang Belanja</h1>

  <?php if (empty($_SESSION['cart'])): ?>
  <div class="cart-card cart-empty reveal">
    <div class="icon">🛒</div>
    <h3>Keranjang Kosong</h3>
    <p style="margin-bottom:20px;">Yuk, tambahkan produk ke keranjang kamu!</p>
    <a href="products.php" class="btn-checkout">Lihat Produk →</a>
  </div>

  <?php else:
    $total = 0;
    $ids   = implode(',', array_map('intval', $_SESSION['cart']));
    $query = mysqli_query($conn, "SELECT * FROM products WHERE id IN ($ids)");
  ?>
  <div class="cart-card reveal">
    <div style="overflow-x:auto;">
      <table class="cart-table">
        <thead>
          <tr>
            <th>Produk</th>
            <th>Harga</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($row = mysqli_fetch_assoc($query)):
            $total += $row['price'];
          ?>
          <tr>
            <td class="cart-item-name"><?php echo htmlspecialchars($row['name']); ?></td>
            <td class="cart-price">Rp <?php echo number_format($row['price'], 0, ',', '.'); ?></td>
            <td>
              <a href="cart.php?remove=<?php echo $row['id']; ?>" class="cart-remove">✕ Hapus</a>
            </td>
          </tr>
          <?php endwhile; ?>
          <tr class="cart-total-row">
            <td><strong>Total Bayar</strong></td>
            <td class="cart-price">Rp <?php echo number_format($total, 0, ',', '.'); ?></td>
            <td></td>
          </tr>
        </tbody>
      </table>
    </div>
    <div class="cart-actions">
      <a href="products.php" class="btn-continue">← Lanjut Belanja</a>
      <a href="checkout.php" class="btn-checkout">Lanjut Pembayaran →</a>
    </div>
  </div>
  <?php endif; ?>
</div>

<footer>
  &copy; 2025 <span>PT Marlinjaya Mesin</span> · Mining Market · All rights reserved
</footer>

<script src="../js/navbar.js"></script>
<script src="../js/user.js"></script>
<script>
function toggleMenu() {
  document.getElementById('hamburger').classList.toggle('open');
  document.getElementById('mobileMenu').classList.toggle('open');
}
<?php if (isset($_GET['added'])): ?>
window.addEventListener('load', () => showToast('Produk ditambahkan ke keranjang! 🛒'));
<?php endif; ?>
</script>
</body>
</html>
