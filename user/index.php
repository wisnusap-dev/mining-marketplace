<?php
session_start();
include "../config/database.php";
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Home — Mining Market</title>
<link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Sans:ital,wght@0,300;0,400;0,500;0,600;1,300&display=swap" rel="stylesheet">
<style>
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
:root {
  --brown: #2c1a0e;
  --brown-mid: #3d2b1f;
  --gold: #c9973a;
  --gold-light: #e8c070;
  --cream: #fdf6ec;
  --bg: #f5ede2;
  --text-muted: #8a7060;
  --white: #ffffff;
}

html { scroll-behavior: smooth; }

body {
  font-family: 'DM Sans', sans-serif;
  background: var(--bg);
  color: var(--brown);
  overflow-x: hidden;
}

/* ===== NAVBAR ===== */
.navbar {
  position: fixed;
  top: 0; left: 0; right: 0;
  z-index: 1000;
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 0 40px;
  height: 72px;
  background: rgba(44,26,14,0.97);
  backdrop-filter: blur(10px);
  border-bottom: 1px solid rgba(201,151,58,0.15);
}

.nav-logo {
  display: flex;
  align-items: center;
  gap: 12px;
  text-decoration: none;
}
.nav-logo img { height: 36px; width: auto; filter: brightness(10); }
.nav-brand {
  font-family: 'Bebas Neue', sans-serif;
  font-size: 1.3rem;
  letter-spacing: 2px;
  color: var(--cream);
}

.nav-links {
  display: flex;
  align-items: center;
  gap: 0;
  list-style: none;
}
.nav-links a {
  display: block;
  padding: 8px 18px;
  color: rgba(253,246,236,0.6);
  text-decoration: none;
  font-size: 0.82rem;
  font-weight: 500;
  letter-spacing: 1px;
  text-transform: uppercase;
  transition: color 0.2s;
  position: relative;
}
.nav-links a:hover, .nav-links a.active { color: var(--gold-light); }
.nav-links a.active::after {
  content: '';
  position: absolute;
  bottom: -1px; left: 18px; right: 18px;
  height: 1px;
  background: var(--gold);
}
.nav-links .cart-link {
  position: relative;
  color: var(--cream);
  font-size: 1.1rem;
  padding: 8px 14px;
}
.logout-btn {
  margin-left: 8px;
  background: transparent !important;
  border: 1px solid rgba(201,151,58,0.4) !important;
  border-radius: 4px;
  color: var(--gold) !important;
  padding: 6px 18px !important;
  transition: background 0.2s, color 0.2s !important;
}
.logout-btn:hover {
  background: var(--gold) !important;
  color: var(--brown) !important;
}

/* Hamburger */
.hamburger {
  display: none;
  flex-direction: column;
  gap: 5px;
  cursor: pointer;
  padding: 5px;
}
.hamburger span {
  display: block;
  width: 24px;
  height: 2px;
  background: var(--cream);
  transition: all 0.3s;
  border-radius: 2px;
}
.hamburger.open span:nth-child(1) { transform: rotate(45deg) translate(5px,5px); }
.hamburger.open span:nth-child(2) { opacity: 0; }
.hamburger.open span:nth-child(3) { transform: rotate(-45deg) translate(5px,-5px); }

/* Mobile menu */
.mobile-menu {
  display: none;
  position: fixed;
  top: 72px; left: 0; right: 0;
  background: var(--brown);
  padding: 20px;
  z-index: 999;
  border-bottom: 1px solid rgba(201,151,58,0.15);
}
.mobile-menu.open { display: block; }
.mobile-menu a {
  display: block;
  padding: 14px 0;
  color: rgba(253,246,236,0.7);
  text-decoration: none;
  font-size: 1rem;
  font-weight: 500;
  border-bottom: 1px solid rgba(255,255,255,0.06);
  letter-spacing: 1px;
}
.mobile-menu a:hover { color: var(--gold-light); }
.mobile-menu .m-logout {
  color: var(--gold);
  border: none;
  margin-top: 10px;
}

/* ===== HERO ===== */
.hero {
  min-height: 100vh;
  display: flex;
  align-items: center;
  position: relative;
  padding: 120px 40px 80px;
  overflow: hidden;
}

.hero-bg {
  position: absolute;
  inset: 0;
  background: linear-gradient(135deg, var(--brown) 0%, #1a0c04 60%, #2a1a0a 100%);
}

.hero-bg::before {
  content: '';
  position: absolute;
  inset: 0;
  background: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 60c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z' fill='%23c9973a' fill-opacity='0.04' fill-rule='evenodd'/%3E%3C/svg%3E");
}

.hero-glow {
  position: absolute;
  width: 600px; height: 600px;
  background: radial-gradient(circle, rgba(201,151,58,0.12) 0%, transparent 70%);
  right: -100px; top: 50%;
  transform: translateY(-50%);
  pointer-events: none;
}

.hero-content {
  position: relative;
  z-index: 1;
  max-width: 700px;
}

.hero-badge {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  background: rgba(201,151,58,0.15);
  border: 1px solid rgba(201,151,58,0.3);
  color: var(--gold-light);
  font-size: 0.75rem;
  font-weight: 600;
  letter-spacing: 3px;
  text-transform: uppercase;
  padding: 8px 16px;
  border-radius: 100px;
  margin-bottom: 32px;
  animation: fadeUp 0.6s ease both;
}

.hero-badge::before {
  content: '';
  width: 6px; height: 6px;
  background: var(--gold);
  border-radius: 50%;
  animation: pulse 2s infinite;
}

@keyframes pulse {
  0%, 100% { opacity: 1; transform: scale(1); }
  50% { opacity: 0.5; transform: scale(1.5); }
}

.hero-content h1 {
  font-family: 'Bebas Neue', sans-serif;
  font-size: clamp(4rem, 8vw, 8rem);
  color: var(--cream);
  line-height: 0.92;
  letter-spacing: 3px;
  margin-bottom: 8px;
  animation: fadeUp 0.7s 0.1s ease both;
}

.hero-content h1 .gold { color: var(--gold); }

.hero-sub {
  font-size: clamp(1rem, 2vw, 1.4rem);
  color: rgba(253,246,236,0.5);
  font-weight: 300;
  font-style: italic;
  letter-spacing: 4px;
  text-transform: uppercase;
  margin-bottom: 28px;
  animation: fadeUp 0.7s 0.15s ease both;
}

.hero-desc {
  color: rgba(253,246,236,0.6);
  font-size: 1rem;
  line-height: 1.7;
  max-width: 500px;
  margin-bottom: 44px;
  animation: fadeUp 0.7s 0.2s ease both;
}

.hero-desc strong { color: var(--gold-light); font-weight: 600; }

.hero-actions {
  display: flex;
  gap: 16px;
  flex-wrap: wrap;
  animation: fadeUp 0.7s 0.25s ease both;
}

.btn-primary {
  display: inline-flex;
  align-items: center;
  gap: 10px;
  background: var(--gold);
  color: var(--brown);
  text-decoration: none;
  font-family: 'Bebas Neue', sans-serif;
  font-size: 1rem;
  letter-spacing: 3px;
  padding: 16px 36px;
  border-radius: 4px;
  transition: background 0.2s, transform 0.1s, box-shadow 0.2s;
  box-shadow: 0 4px 20px rgba(201,151,58,0.25);
}
.btn-primary:hover {
  background: var(--gold-light);
  transform: translateY(-2px);
  box-shadow: 0 8px 30px rgba(201,151,58,0.35);
}

.btn-secondary {
  display: inline-flex;
  align-items: center;
  gap: 10px;
  background: transparent;
  color: var(--cream);
  text-decoration: none;
  font-family: 'Bebas Neue', sans-serif;
  font-size: 1rem;
  letter-spacing: 3px;
  padding: 16px 36px;
  border-radius: 4px;
  border: 1px solid rgba(253,246,236,0.25);
  transition: border-color 0.2s, color 0.2s, transform 0.1s;
}
.btn-secondary:hover {
  border-color: var(--gold);
  color: var(--gold);
  transform: translateY(-2px);
}

@keyframes fadeUp {
  from { opacity: 0; transform: translateY(20px); }
  to { opacity: 1; transform: translateY(0); }
}

/* ===== STATS STRIP ===== */
.stats-strip {
  background: var(--brown-mid);
  border-top: 1px solid rgba(201,151,58,0.2);
  border-bottom: 1px solid rgba(201,151,58,0.2);
  padding: 36px 40px;
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
  gap: 0;
}
.stat-item {
  text-align: center;
  padding: 20px;
  border-right: 1px solid rgba(253,246,236,0.08);
}
.stat-item:last-child { border-right: none; }
.stat-num {
  font-family: 'Bebas Neue', sans-serif;
  font-size: 3rem;
  color: var(--gold);
  letter-spacing: 2px;
  line-height: 1;
}
.stat-label {
  font-size: 0.75rem;
  color: rgba(253,246,236,0.4);
  letter-spacing: 2px;
  text-transform: uppercase;
  margin-top: 6px;
}

/* ===== FEATURES SECTION ===== */
.section {
  padding: 100px 40px;
  max-width: 1200px;
  margin: 0 auto;
}

.section-label {
  font-size: 0.7rem;
  font-weight: 600;
  letter-spacing: 4px;
  text-transform: uppercase;
  color: var(--gold);
  margin-bottom: 16px;
}

.section-title {
  font-family: 'Bebas Neue', sans-serif;
  font-size: clamp(2.5rem, 5vw, 4rem);
  color: var(--brown);
  line-height: 1;
  letter-spacing: 2px;
  margin-bottom: 16px;
}

.section-sub {
  color: var(--text-muted);
  font-size: 1rem;
  max-width: 500px;
  line-height: 1.7;
  margin-bottom: 60px;
}

.features-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
  gap: 24px;
}

.feature-card {
  background: var(--white);
  border-radius: 16px;
  padding: 36px;
  border: 1px solid rgba(201,151,58,0.1);
  transition: transform 0.2s, box-shadow 0.2s, border-color 0.2s;
  position: relative;
  overflow: hidden;
}

.feature-card::before {
  content: '';
  position: absolute;
  top: 0; left: 0; right: 0;
  height: 3px;
  background: linear-gradient(90deg, var(--gold), var(--gold-light));
  transform: scaleX(0);
  transform-origin: left;
  transition: transform 0.3s;
}

.feature-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 12px 40px rgba(44,26,14,0.1);
  border-color: rgba(201,151,58,0.3);
}

.feature-card:hover::before { transform: scaleX(1); }

.feature-icon {
  font-size: 2rem;
  margin-bottom: 20px;
}

.feature-card h3 {
  font-family: 'Bebas Neue', sans-serif;
  font-size: 1.5rem;
  color: var(--brown);
  letter-spacing: 1px;
  margin-bottom: 12px;
}

.feature-card p {
  color: var(--text-muted);
  font-size: 0.9rem;
  line-height: 1.7;
}

/* ===== CTA BANNER ===== */
.cta-banner {
  background: var(--brown);
  margin: 0 40px 80px;
  border-radius: 20px;
  padding: 60px 60px;
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 40px;
  position: relative;
  overflow: hidden;
}

.cta-banner::before {
  content: 'MESIN';
  position: absolute;
  right: -20px;
  bottom: -40px;
  font-family: 'Bebas Neue', sans-serif;
  font-size: 10rem;
  color: rgba(255,255,255,0.03);
  letter-spacing: 10px;
  pointer-events: none;
}

.cta-text h2 {
  font-family: 'Bebas Neue', sans-serif;
  font-size: 2.5rem;
  color: var(--cream);
  letter-spacing: 2px;
  margin-bottom: 10px;
}
.cta-text p { color: rgba(253,246,236,0.5); font-size: 0.95rem; }

/* ===== FOOTER ===== */
footer {
  background: var(--brown);
  color: rgba(253,246,236,0.4);
  text-align: center;
  padding: 30px 40px;
  font-size: 0.82rem;
  border-top: 1px solid rgba(201,151,58,0.1);
  letter-spacing: 1px;
}

footer span { color: var(--gold); }

/* ===== RESPONSIVE ===== */
@media (max-width: 768px) {
  .navbar { padding: 0 20px; }
  .nav-links { display: none; }
  .hamburger { display: flex; }
  .hero { padding: 100px 20px 60px; }
  .stats-strip { padding: 20px; }
  .section { padding: 60px 20px; }
  .cta-banner { margin: 0 20px 60px; padding: 40px 30px; flex-direction: column; }
}
</style>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar">
  <a href="index.php" class="nav-logo">
    <img src="../logo/companies.png" alt="Logo">
    <span class="nav-brand">Mining Market</span>
  </a>

  <ul class="nav-links">
    <li><a href="index.php" class="active">Home</a></li>
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

<!-- HERO -->
<section class="hero">
  <div class="hero-bg"></div>
  <div class="hero-glow"></div>
  <div class="hero-content">
    <div class="hero-badge">Platform Alat Tambang #1</div>
    <h1>PT MARLIN<br><span class="gold">JAYA</span><br>MESIN</h1>
    <div class="hero-sub">Industrial Equipment</div>
    <p class="hero-desc">
      Halo, <strong><?php echo htmlspecialchars($_SESSION['username']); ?></strong>. 
      Tingkatkan efisiensi operasional tambang Anda dengan armada mesin tangguh, bersertifikat, dan teknologi terkini.
    </p>
    <div class="hero-actions">
      <a href="products.php" class="btn-primary">Lihat Katalog →</a>
      <a href="about.php" class="btn-secondary">Tentang Kami</a>
    </div>
  </div>
</section>

<!-- STATS -->
<div class="stats-strip">
  <div class="stat-item">
    <div class="stat-num">200+</div>
    <div class="stat-label">Unit Tersedia</div>
  </div>
  <div class="stat-item">
    <div class="stat-num">15+</div>
    <div class="stat-label">Tahun Pengalaman</div>
  </div>
  <div class="stat-item">
    <div class="stat-num">500+</div>
    <div class="stat-label">Pelanggan Puas</div>
  </div>
  <div class="stat-item">
    <div class="stat-num">24/7</div>
    <div class="stat-label">Dukungan Teknis</div>
  </div>
</div>

<!-- FEATURES -->
<section class="section">
  <div class="section-label">Keunggulan Kami</div>
  <h2 class="section-title">Kenapa Memilih<br>Mining Market?</h2>
  <p class="section-sub">Kami memberikan standar baru dalam industri alat berat tambang Indonesia.</p>

  <div class="features-grid">
    <div class="feature-card">
      <div class="feature-icon">🏆</div>
      <h3>Mesin Bersertifikat</h3>
      <p>Semua unit kami telah melalui inspeksi ketat dan memiliki sertifikasi internasional yang terjamin kualitasnya.</p>
    </div>
    <div class="feature-card">
      <div class="feature-icon">⚡</div>
      <h3>Dukungan 24/7</h3>
      <p>Tim teknisi ahli kami siap membantu Anda kapan saja, di mana saja di lokasi pertambangan Anda.</p>
    </div>
    <div class="feature-card">
      <div class="feature-icon">🔧</div>
      <h3>Suku Cadang Asli</h3>
      <p>Ketersediaan suku cadang original untuk memastikan mesin tetap beroperasi secara maksimal dan efisien.</p>
    </div>
    <div class="feature-card">
      <div class="feature-icon">🚚</div>
      <h3>Pengiriman Terjadwal</h3>
      <p>Layanan pengiriman profesional ke seluruh Indonesia dengan jadwal yang dapat disesuaikan kebutuhan operasional.</p>
    </div>
    <div class="feature-card">
      <div class="feature-icon">💼</div>
      <h3>Garansi Resmi</h3>
      <p>Setiap produk dilengkapi garansi resmi pabrikan sehingga investasi Anda terlindungi dengan baik.</p>
    </div>
    <div class="feature-card">
      <div class="feature-icon">📋</div>
      <h3>Konsultasi Gratis</h3>
      <p>Tim ahli kami siap memberikan rekomendasi mesin yang paling tepat untuk kebutuhan tambang Anda.</p>
    </div>
  </div>
</section>

<!-- CTA BANNER -->
<div class="cta-banner">
  <div class="cta-text">
    <h2>Siap Tingkatkan Operasional?</h2>
    <p>Jelajahi ratusan unit mesin tambang pilihan kami sekarang juga.</p>
  </div>
  <a href="products.php" class="btn-primary" style="white-space: nowrap;">Lihat Semua Produk →</a>
</div>

<footer>
  &copy; 2025 <span>PT Marlinjaya Mesin</span> · Mining Market · All rights reserved
</footer>

<script>
function toggleMenu() {
  document.getElementById('hamburger').classList.toggle('open');
  document.getElementById('mobileMenu').classList.toggle('open');
}
</script>
</body>
</html>