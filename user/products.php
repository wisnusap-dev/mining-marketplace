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
<style>
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
:root {
  --brown: #2c1a0e; --brown-mid: #3d2b1f; --gold: #c9973a;
  --gold-light: #e8c070; --cream: #fdf6ec; --bg: #f5ede2;
  --text-muted: #8a7060; --white: #ffffff;
}
body { font-family: 'DM Sans', sans-serif; background: var(--bg); color: var(--brown); }

/* NAVBAR (same as index) */
.navbar {
  position: fixed; top: 0; left: 0; right: 0; z-index: 1000;
  display: flex; align-items: center; justify-content: space-between;
  padding: 0 40px; height: 72px;
  background: rgba(44,26,14,0.97); backdrop-filter: blur(10px);
  border-bottom: 1px solid rgba(201,151,58,0.15);
}
.nav-logo { display: flex; align-items: center; gap: 12px; text-decoration: none; }
.nav-logo img { height: 36px; filter: brightness(10); }
.nav-brand { font-family: 'Bebas Neue', sans-serif; font-size: 1.3rem; letter-spacing: 2px; color: var(--cream); }
.nav-links { display: flex; align-items: center; gap: 0; list-style: none; }
.nav-links a {
  display: block; padding: 8px 18px; color: rgba(253,246,236,0.6); text-decoration: none;
  font-size: 0.82rem; font-weight: 500; letter-spacing: 1px; text-transform: uppercase; transition: color 0.2s;
}
.nav-links a:hover, .nav-links a.active { color: var(--gold-light); }
.logout-btn {
  margin-left: 8px; background: transparent !important;
  border: 1px solid rgba(201,151,58,0.4) !important; border-radius: 4px;
  color: var(--gold) !important; padding: 6px 18px !important; transition: background 0.2s, color 0.2s !important;
}
.logout-btn:hover { background: var(--gold) !important; color: var(--brown) !important; }
.hamburger { display: none; flex-direction: column; gap: 5px; cursor: pointer; padding: 5px; }
.hamburger span { display: block; width: 24px; height: 2px; background: var(--cream); border-radius: 2px; }
.hamburger.open span:nth-child(1) { transform: rotate(45deg) translate(5px,5px); }
.hamburger.open span:nth-child(2) { opacity: 0; }
.hamburger.open span:nth-child(3) { transform: rotate(-45deg) translate(5px,-5px); }
.mobile-menu { display: none; position: fixed; top: 72px; left: 0; right: 0; background: var(--brown); padding: 20px; z-index: 999; border-bottom: 1px solid rgba(201,151,58,0.15); }
.mobile-menu.open { display: block; }
.mobile-menu a { display: block; padding: 14px 0; color: rgba(253,246,236,0.7); text-decoration: none; font-size: 1rem; border-bottom: 1px solid rgba(255,255,255,0.06); }
.mobile-menu a:hover { color: var(--gold-light); }
.mobile-menu .m-logout { color: var(--gold); border: none; margin-top: 10px; }

/* PAGE HEADER */
.page-header {
  padding: 130px 40px 60px;
  background: var(--brown);
  position: relative;
  overflow: hidden;
}
.page-header::after {
  content: 'PRODUK';
  position: absolute; right: -20px; bottom: -30px;
  font-family: 'Bebas Neue', sans-serif; font-size: 8rem;
  color: rgba(255,255,255,0.03); letter-spacing: 10px; pointer-events: none;
}
.page-header .label {
  font-size: 0.7rem; font-weight: 600; letter-spacing: 4px; text-transform: uppercase;
  color: var(--gold); margin-bottom: 12px;
}
.page-header h1 {
  font-family: 'Bebas Neue', sans-serif; font-size: clamp(3rem, 6vw, 5.5rem);
  color: var(--cream); letter-spacing: 3px; line-height: 1;
}
.page-header p { color: rgba(253,246,236,0.5); font-size: 0.95rem; margin-top: 16px; }

/* FILTER BAR */
.filter-bar {
  background: var(--white); border-bottom: 1px solid rgba(201,151,58,0.15);
  padding: 16px 40px; display: flex; align-items: center; gap: 16px; flex-wrap: wrap;
}
.filter-label { font-size: 0.75rem; font-weight: 600; letter-spacing: 2px; text-transform: uppercase; color: var(--text-muted); }
.search-input {
  padding: 10px 16px; border: 1.5px solid #e0d4c8; border-radius: 8px;
  font-family: 'DM Sans', sans-serif; font-size: 0.9rem; color: var(--brown);
  outline: none; transition: border-color 0.2s; flex: 1; min-width: 200px;
}
.search-input:focus { border-color: var(--gold); }

/* PRODUCT GRID */
.products-section { padding: 50px 40px; max-width: 1300px; margin: 0 auto; }

.results-info {
  font-size: 0.82rem; color: var(--text-muted); letter-spacing: 1px;
  text-transform: uppercase; margin-bottom: 28px;
}
.results-info span { color: var(--gold); font-weight: 600; }

.product-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(290px, 1fr));
  gap: 28px;
}

.product-card {
  background: var(--white); border-radius: 16px; overflow: hidden;
  border: 1px solid rgba(201,151,58,0.1);
  transition: transform 0.25s, box-shadow 0.25s, border-color 0.25s;
  position: relative;
}
.product-card:hover {
  transform: translateY(-6px);
  box-shadow: 0 16px 50px rgba(44,26,14,0.12);
  border-color: rgba(201,151,58,0.3);
}

.product-img {
  width: 100%; height: 220px; object-fit: cover;
  display: block; background: #e8ddd4;
  transition: transform 0.4s;
}
.product-card:hover .product-img { transform: scale(1.04); }
.product-img-wrap { overflow: hidden; }

.product-body { padding: 24px; }

.product-badge {
  display: inline-block;
  background: rgba(201,151,58,0.12); color: var(--gold);
  font-size: 0.65rem; font-weight: 600; letter-spacing: 2px; text-transform: uppercase;
  padding: 4px 10px; border-radius: 100px; margin-bottom: 10px;
}

.product-name {
  font-family: 'Bebas Neue', sans-serif; font-size: 1.4rem;
  color: var(--brown); letter-spacing: 1px; margin-bottom: 8px; line-height: 1.2;
}

.product-desc {
  font-size: 0.85rem; color: var(--text-muted); line-height: 1.6;
  height: 52px; overflow: hidden; margin-bottom: 18px;
}

.product-price {
  font-family: 'Bebas Neue', sans-serif; font-size: 1.8rem;
  color: var(--gold); letter-spacing: 1px; margin-bottom: 20px;
}

.product-actions { display: flex; gap: 10px; }

.btn-cart {
  flex: 1; padding: 11px 10px; background: rgba(201,151,58,0.1);
  color: var(--gold); border: 1.5px solid var(--gold); border-radius: 8px;
  text-decoration: none; font-size: 0.82rem; font-weight: 600; letter-spacing: 1px;
  text-align: center; transition: background 0.2s, color 0.2s;
}
.btn-cart:hover { background: var(--gold); color: var(--brown); }

.btn-buy {
  flex: 1; padding: 11px 10px; background: var(--brown);
  color: var(--cream); border: 1.5px solid var(--brown); border-radius: 8px;
  text-decoration: none; font-size: 0.82rem; font-weight: 600; letter-spacing: 1px;
  text-align: center; transition: background 0.2s;
}
.btn-buy:hover { background: var(--brown-mid); }

/* Empty state */
.empty-state {
  text-align: center; padding: 80px 20px; color: var(--text-muted);
}
.empty-state .icon { font-size: 4rem; margin-bottom: 20px; }
.empty-state h3 { font-family: 'Bebas Neue', sans-serif; font-size: 2rem; color: var(--brown); margin-bottom: 10px; }

footer {
  background: var(--brown); color: rgba(253,246,236,0.4);
  text-align: center; padding: 30px 40px; font-size: 0.82rem;
  border-top: 1px solid rgba(201,151,58,0.1); letter-spacing: 1px; margin-top: 60px;
}
footer span { color: var(--gold); }

@media (max-width: 768px) {
  .navbar { padding: 0 20px; }
  .nav-links { display: none; }
  .hamburger { display: flex; }
  .page-header { padding: 100px 20px 40px; }
  .filter-bar { padding: 16px 20px; }
  .products-section { padding: 30px 20px; }
}
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

<script>
const totalCount = <?php echo $count; ?>;
document.getElementById('countDisplay').textContent = totalCount;

function filterProducts() {
  const q = document.getElementById('searchInput').value.toLowerCase();
  const cards = document.querySelectorAll('.product-card');
  let visible = 0;
  cards.forEach(card => {
    const name = card.getAttribute('data-name');
    if (name.includes(q)) { card.style.display = ''; visible++; }
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