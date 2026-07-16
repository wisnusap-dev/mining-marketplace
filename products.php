<?php
include "config/database.php";

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
  <link rel="stylesheet" href="css/navbar.css">
  <link rel="stylesheet" href="css/product.css">
  <link rel="stylesheet" href="css/user_fx.css">
</head>
<body>

<div id="user-loader">
  <div class="loader-gear">⚙️</div>
  <div class="loader-brand">Mining Market</div>
  <div class="loader-line"><div class="loader-line-fill"></div></div>
</div>

<div id="scroll-progress"></div>

<!-- NAVBAR -->
<nav class="navbar">
  <a href="index.php" class="nav-logo">
    <span class="nav-brand">Mining Market</span>
  </a>
  <ul class="nav-links">
    <li><a href="index.php">Home</a></li>
    <li><a href="products.php" class="active">Products</a></li>
    <li><a href="about.php">About</a></li>
    <li><a href="contact.php">Contact</a></li>
    <!-- Tombol Login/Logout dihapus -->
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
  <!-- Tombol Login/Logout Mobile dihapus -->
</div>

<!-- PAGE HEADER -->
<div class="page-header">
  <div class="label reveal">Katalog Kami</div>
  <h1 class="reveal">Produk<br>Tambang</h1>
  <p class="reveal">Mesin & peralatan berat bersertifikat untuk operasional pertambangan. Tersedia pengiriman ke seluruh Indonesia.</p>
</div>

<!-- FILTER -->
<div class="filter-bar">
  <span class="filter-label">Cari:</span>
  <input type="text" class="search-input" id="searchInput"
         placeholder="Cari nama produk..." oninput="filterProducts()">
</div>

<!-- PRODUCTS -->
<div class="products-section">
  <div class="results-info">
    Menampilkan <span id="countDisplay"><?php echo $count; ?></span> produk
  </div>

  <!-- SKELETON LOADER -->
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

  <!-- PRODUCT GRID -->
  <div class="product-grid" id="productGrid" style="display:none;">
    <?php foreach ($rows as $row): ?>
    <div class="product-card" data-name="<?php echo strtolower(htmlspecialchars($row['name'])); ?>">
      <div class="product-img-wrap" id="wrap-<?php echo $row['id']; ?>">
        <img class="product-img"
             src="images/products/<?php echo $row['image']; ?>"
             alt="<?php echo htmlspecialchars($row['name']); ?>"
             onload="this.closest('.product-img-wrap').classList.add('loaded')">
      </div>
      <div class="product-body">
        <div class="product-badge">Alat Tambang</div>
        <div class="product-name" style="margin-bottom: 8px;"><?php echo htmlspecialchars($row['name']); ?></div>
        
        <?php 
          // Membuat deskripsi singkat (maksimal 90 karakter)
          $desc = $row['description'];
          $short_desc = strlen($desc) > 90 ? substr($desc, 0, 90) . '...' : $desc;
        ?>
        <p class="product-desc" style="font-size: 0.9rem; color: #8a7060; margin-bottom: 20px; line-height: 1.5; min-height: 40px;">
          <?php echo htmlspecialchars($short_desc); ?>
        </p>
        
        <!-- TOMBOL DIUBAH MENJADI DETAIL SAJA -->
        <div class="product-actions" style="display: flex; justify-content: center;">
          <a href="detail.php?id=<?php echo $row['id']; ?>" class="btn-buy" style="width: 100%; text-align: center; justify-content: center;">Lihat Detail</a>
        </div>

      </div>
    </div>
    <?php endforeach; ?>
  </div>

  <div class="empty-state" id="emptyState" style="display:none;">
    <div class="icon">🔍</div>
    <h3>Produk Tidak Ditemukan</h3>
    <p>Coba kata kunci pencarian yang berbeda.</p>
  </div>
</div>

<footer>&copy; <?php echo date('Y'); ?> <span>PT Marlin Jaya Mesin</span> · Mining Market</footer>

<!-- PERBAIKAN: Hapus tanda ../ pada script JS -->
<script src="js/navbar.js"></script>
<script src="js/user.js"></script>
<script>
function toggleMenu() {
  document.getElementById('hamburger').classList.toggle('open');
  document.getElementById('mobileMenu').classList.toggle('open');
}

// Efek transisi dan menghilangkan layar loading
window.addEventListener('load', () => {
  // 1. Menghilangkan layar loading utama (user-loader)
  const mainLoader = document.getElementById('user-loader');
  if (mainLoader) {
      mainLoader.style.transition = 'opacity 0.4s ease';
      mainLoader.style.opacity = '0';
      setTimeout(() => mainLoader.style.display = 'none', 400);
  }

  // 2. Transisi dari Skeleton Loader ke Grid Produk Asli
  setTimeout(() => {
    const skeleton = document.getElementById('skeletonGrid');
    if (skeleton) skeleton.style.display = 'none';
    
    const productGrid = document.getElementById('productGrid');
    if (productGrid) productGrid.style.display = 'grid';
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