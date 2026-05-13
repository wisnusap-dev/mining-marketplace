<?php
session_start();
include "../config/database.php";
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Produk — Mining Market</title>
<link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="../css/product.css">
<link rel="stylesheet" href="../css/navbar.css"
<style>
</style>
</head>
<body>

<nav class="navbar">
  <a href="index.php" class="nav-logo">
    <img src="../logo/companies.png" alt="Logo">
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
  <div class="label">Katalog Kami</div>
  <h1>Produk<br>Tambang</h1>
  <p>Mesin & peralatan berat bersertifikat untuk operasional pertambangan.</p>
</div>

<div class="filter-bar">
  <span class="filter-label">Cari:</span>
  <input type="text" class="search-input" id="searchInput" placeholder="Cari nama produk..." oninput="filterProducts()">
</div>

<div class="products-section">
  <div class="results-info">
    Menampilkan <span id="countDisplay">0</span> produk
  </div>

  <div class="product-grid" id="productGrid">
    <?php
    $query = mysqli_query($conn, "SELECT * FROM products");
    $count = mysqli_num_rows($query);
    while($row = mysqli_fetch_assoc($query)):
    ?>
    <div class="product-card" data-name="<?php echo strtolower($row['name']); ?>">
      <div class="product-img-wrap">
        <img class="product-img" src="../images/products/<?php echo $row['image']; ?>" 
             alt="<?php echo htmlspecialchars($row['name']); ?>"
             onerror="this.style.background='#e8ddd4'; this.src='';">
      </div>
      <div class="product-body">
        <div class="product-badge">Alat Tambang</div>
        <div class="product-name"><?php echo htmlspecialchars($row['name']); ?></div>
        <p class="product-desc"><?php echo htmlspecialchars($row['description']); ?></p>
        <div class="product-price">Rp <?php echo number_format($row['price'], 0, ',', '.'); ?></div>
        <div class="product-actions">
          <a href="cart.php?id=<?php echo $row['id']; ?>" class="btn-cart">🛒 + Keranjang</a>
          <a href="checkout.php?id=<?php echo $row['id']; ?>" class="btn-buy">Beli Langsung</a>
        </div>
      </div>
    </div>
    <?php endwhile; ?>
  </div>

  <div class="empty-state" id="emptyState" style="display:none;">
    <div class="icon">🔍</div>
    <h3>Produk Tidak Ditemukan</h3>
    <p>Coba kata kunci yang berbeda.</p>
  </div>
</div>

<footer>&copy; 2025 <span>PT Marlinjaya Mesin</span> · Mining Market</footer>

<script  src="../js/navbar.js">
const totalCount = <?php echo $count; ?>;
document.getElementById('countDisplay').textContent = totalCount;

function filterProducts() {
  const q = document.getElementById('searchInput').value.toLowerCase();
  const cards = document.querySelectorAll('.product-card');
  let visible = 0;
  cards.forEach(card => {
    const name = card.getAttribute('data-name');
    if (name.includes(q)) { card.style.display  = ''; visible++; }
    else card.style.display = 'none';
  });
  document.getElementById('countDisplay').textContent = visible;
  document.getElementById('emptyState').style.display = visible === 0 ? 'block' : 'none';
}

function toggleMenu() {
  document.getElementById('hamburger').classList.toggle('open');
  document.getElementById('mobileMenu').classList.toggle('open');
}
</script>
</body>
</html>