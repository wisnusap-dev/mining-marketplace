<?php
session_start();
include "../config/database.php";

// Proteksi halaman: jika user belum login, lempar ke login.php
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

// Mengambil data produk dari database
$products = mysqli_query($conn, "SELECT * FROM products");
$count    = mysqli_num_rows($products);
$rows     = [];
while ($r = mysqli_fetch_assoc($products)) {
    $rows[] = $r;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Produk — Mining Market</title>
  <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../css/navbar.css">
  <link rel="stylesheet" href="../css/product.css">
  <link rel="stylesheet" href="../css/user_fx.css">
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
    <span class="nav-brand">Mining Market</span>
  </a>
  <ul class="nav-links">
    <li><a href="index.php">Home</a></li>
    <li><a href="products.php" class="active">Products</a></li>
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

<div class="page-header">
  <div class="label reveal">Katalog Kami</div>
  <h1 class="reveal">Produk<br>Tambang</h1>
  <p class="reveal">Mesin &amp; peralatan berat bersertifikat untuk operasional pertambangan.</p>
</div>

<div class="filter-bar">
  <span class="filter-label">Cari:</span>
  <input type="text" class="search-input" id="searchInput"
         placeholder="Cari nama produk..." oninput="filterProducts()">
</div>

<div class="products-section">
  <div class="results-info">
    Menampilkan <span id="countDisplay"><?php echo $count; ?></span> produk
  </div>

  <div class="product-grid" id="skeletonGrid" aria-hidden="true">
    <?php for ($i = 0; $i < min(6, $count ?: 6); $i++): ?>
    <div class="skeleton-card">
      <div class="sk-img"></div>
      <div class="sk-body">
        <div class="sk-line sm"></div>
        <div class="sk-line lg"></div>
        <div class="sk-line"></div>
        <div class="sk-line sm"></div>
        <div class="sk-line btn"></div>
      </div>
    </div>
    <?php endfor; ?>
  </div>

  <div class="product-grid" id="productGrid" style="display:none;">
    <?php foreach ($rows as $row): ?>
    <div class="product-card" data-name="<?php echo strtolower(htmlspecialchars($row['name'])); ?>">
      <div class="product-img-wrap" id="wrap-<?php echo $row['id']; ?>">
        <img class="product-img"
             src="../images/products/<?php echo $row['image']; ?>"
             alt="<?php echo htmlspecialchars($row['name']); ?>"
             onload="this.closest('.product-img-wrap').classList.add('loaded')">
      </div>
      <div class="product-body">
        <div class="product-badge">Alat Tambang</div>
        <div class="product-name"><?php echo htmlspecialchars($row['name']); ?></div>
        <p class="product-desc"><?php echo htmlspecialchars($row['description']); ?></p>
        <div class="product-price">Rp <?php echo number_format($row['price'], 0, ',', '.'); ?></div>
        <div class="product-actions">
          <a href="cart.php?id=<?php echo $row['id']; ?>" class="btn-cart">🛒 + Keranjang</a>
          <a href="cart.php?buy_now=<?php echo $row['id']; ?>" class="btn-buy">Beli Langsung</a>
        </div>
      </div>
    </div>
    <?php endforeach; ?>
  </div>

  <div class="empty-state" id="emptyState" style="display:none;">
    <div class="icon">🔍</div>
    <h3>Produk Tidak Ditemukan</h3>
    <p>Coba kata kunci yang berbeda.</p>
  </div>
</div>

<footer>&copy; 2025 <span>PT Marlinjaya Mesin</span> · Mining Market</footer>

<script src="../js/navbar.js"></script>
<script src="../js/user.js"></script>
<script>
function toggleMenu() {
  document.getElementById('hamburger').classList.toggle('open');
  document.getElementById('mobileMenu').classList.toggle('open');
}

// Efek transisi dari Skeleton Loader ke Grid Produk Asli
window.addEventListener('load', () => {
  setTimeout(() => {
    const skeleton = document.getElementById('skeletonGrid');
    if (skeleton) skeleton.style.display = 'none';
    document.getElementById('productGrid').style.display = 'grid';
  }, 600);
});

// Fungsi pencarian produk (Live Filter)
function filterProducts() {
  const q     = document.getElementById('searchInput').value.toLowerCase();
  const cards = document.querySelectorAll('#productGrid .product-card');
  let vis = 0;
  cards.forEach(c => {
    const match = c.getAttribute('data-name').includes(q);
    c.style.display = match ? '' : 'none';
    if (match) vis++;
  });
  document.getElementById('countDisplay').textContent = vis;
  document.getElementById('emptyState').style.display = vis === 0 ? 'block' : 'none';
}
</script>

</body>
</html>