<?php
session_start();
include "../config/database.php";

if (!isset($_GET['id'])) {
    header("Location: products.php");
    exit();
}

$id    = (int) $_GET['id'];
$query = mysqli_query($conn, "SELECT * FROM products WHERE id='$id'");
$item  = mysqli_fetch_assoc($query);

if (!$item) {
    header("Location: products.php");
    exit();
}

// Info kontak perusahaan — sesuaikan di sini
$company_email = "sales@miningmarket.id";
$company_wa    = "6281234567890"; // format internasional tanpa +
$company_wa_display = "+62 812-3456-7890";

// Pesan template untuk WA & Email
$wa_msg = urlencode(
    "Halo, saya tertarik dengan produk:\n" .
    "📦 *{$item['name']}*\n" .
    "💰 Harga: Rp " . number_format($item['price'], 0, ',', '.') . "\n\n" .
    "Mohon informasi lebih lanjut mengenai ketersediaan, spesifikasi, dan pengiriman. Terima kasih."
);

$email_subject = urlencode("Inquiry Produk: {$item['name']}");
$email_body    = urlencode(
    "Halo Tim PT Marlin Jaya Mesin,\n\n" .
    "Saya tertarik dengan produk berikut:\n" .
    "Nama Produk : {$item['name']}\n" .
    "Harga       : Rp " . number_format($item['price'], 0, ',', '.') . "\n\n" .
    "Mohon berikan informasi lebih lanjut mengenai:\n" .
    "- Ketersediaan stok\n" .
    "- Spesifikasi teknis lengkap\n" .
    "- Estimasi pengiriman\n" .
    "- Negosiasi harga (jika ada)\n\n" .
    "Terima kasih,\n" .
    ($_SESSION['username'] ?? 'Calon Pembeli')
);
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo htmlspecialchars($item['name']); ?> — Mining Market</title>
  <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../css/navbar.css">
  <link rel="stylesheet" href="../css/user_fx.css">
  <style>
    :root {
      --brown:     #2c1a0e;
      --brown-mid: #3d2b1f;
      --gold:      #c9973a;
      --gold-lt:   #e8c070;
      --cream:     #fdf6ec;
      --bg:        #f5ede2;
      --muted:     #8a7060;
      --border:    rgba(201,151,58,0.15);
      --nav-h:     72px;
    }

    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    body { font-family: 'DM Sans', sans-serif; background: var(--bg); color: var(--brown); }

    /* ── BREADCRUMB ── */
    .breadcrumb {
      padding: calc(var(--nav-h) + 28px) 40px 0;
      display: flex; align-items: center; gap: 8px;
      font-size: 0.8rem; color: var(--muted);
    }
    .breadcrumb a { color: var(--muted); text-decoration: none; transition: color .2s; }
    .breadcrumb a:hover { color: var(--gold); }
    .breadcrumb span { color: var(--brown); font-weight: 500; }

    /* ── DETAIL LAYOUT ── */
    .detail-wrap {
      max-width: 1100px;
      margin: 28px auto 80px;
      padding: 0 40px;
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 48px;
      align-items: start;
    }

    /* ── IMAGE PANEL ── */
    .img-panel {
      position: sticky;
      top: calc(var(--nav-h) + 24px);
    }

    .img-main {
      border-radius: 20px;
      overflow: hidden;
      background: #fff;
      border: 1px solid var(--border);
      box-shadow: 0 8px 40px rgba(44,26,14,0.10);
      aspect-ratio: 4/3;
      display: flex; align-items: center; justify-content: center;
    }

    .img-main img {
      width: 100%; height: 100%;
      object-fit: cover;
      transition: transform 0.5s ease;
    }

    .img-main:hover img { transform: scale(1.04); }

    .img-badge-wrap {
      display: flex; gap: 10px; margin-top: 14px; flex-wrap: wrap;
    }

    .img-badge {
      display: inline-flex; align-items: center; gap: 6px;
      background: #fff; border: 1px solid var(--border);
      border-radius: 8px; padding: 8px 14px;
      font-size: 0.78rem; font-weight: 500; color: var(--muted);
      box-shadow: 0 2px 8px rgba(44,26,14,0.05);
    }

    /* ── INFO PANEL ── */
    .info-panel { display: flex; flex-direction: column; gap: 0; }

    .product-tag {
      display: inline-flex; align-items: center; gap: 6px;
      background: rgba(201,151,58,0.12);
      border: 1px solid rgba(201,151,58,0.25);
      color: var(--gold);
      font-size: 0.7rem; font-weight: 700;
      letter-spacing: 2px; text-transform: uppercase;
      padding: 5px 14px; border-radius: 99px;
      width: fit-content; margin-bottom: 16px;
    }

    .product-title {
      font-family: 'Bebas Neue', sans-serif;
      font-size: clamp(2rem, 4vw, 3rem);
      color: var(--brown);
      letter-spacing: 1px;
      line-height: 1.05;
      margin-bottom: 16px;
    }

    .product-price-big {
      font-family: 'Bebas Neue', sans-serif;
      font-size: 2.2rem;
      color: var(--brown);
      letter-spacing: 1px;
      margin-bottom: 8px;
    }

    .price-note {
      font-size: 0.78rem; color: var(--muted);
      margin-bottom: 24px;
      display: flex; align-items: center; gap: 6px;
    }

    .divider-line {
      height: 1px;
      background: var(--border);
      margin: 24px 0;
    }

    /* Description */
    .desc-label {
      font-size: 0.7rem; font-weight: 700;
      letter-spacing: 2px; text-transform: uppercase;
      color: var(--muted); margin-bottom: 10px;
    }

    .desc-text {
      font-size: 0.95rem; color: var(--brown-mid);
      line-height: 1.8; margin-bottom: 28px;
    }

    /* Specs */
    .specs-grid {
      display: grid; grid-template-columns: 1fr 1fr;
      gap: 10px; margin-bottom: 28px;
    }

    .spec-item {
      background: #fff;
      border: 1px solid var(--border);
      border-radius: 10px;
      padding: 12px 16px;
    }

    .spec-key {
      font-size: 0.68rem; font-weight: 600;
      letter-spacing: 1.5px; text-transform: uppercase;
      color: var(--muted); margin-bottom: 4px;
    }

    .spec-val {
      font-size: 0.88rem; font-weight: 600;
      color: var(--brown);
    }

    /* ── CTA BOX ── */
    .cta-box {
      background: var(--brown);
      border-radius: 18px;
      padding: 28px;
      margin-top: 4px;
    }

    .cta-box h3 {
      font-family: 'Bebas Neue', sans-serif;
      font-size: 1.4rem; letter-spacing: 2px;
      color: var(--cream); margin-bottom: 6px;
    }

    .cta-box p {
      font-size: 0.82rem; color: rgba(253,246,236,0.55);
      margin-bottom: 20px; line-height: 1.6;
    }

    .cta-buttons {
      display: flex; flex-direction: column; gap: 12px;
    }

    /* WhatsApp button */
    .btn-wa {
      display: flex; align-items: center; justify-content: center; gap: 12px;
      padding: 15px 24px;
      background: #25D366;
      color: #fff;
      border-radius: 12px;
      text-decoration: none;
      font-weight: 700; font-size: 0.95rem;
      transition: background .2s, transform .15s, box-shadow .2s;
      box-shadow: 0 4px 16px rgba(37,211,102,0.3);
    }

    .btn-wa:hover {
      background: #1ebe5d;
      transform: translateY(-2px);
      box-shadow: 0 8px 24px rgba(37,211,102,0.4);
    }

    .btn-wa:active { transform: scale(0.98); }

    .btn-wa svg { flex-shrink: 0; }

    /* Email button */
    .btn-email {
      display: flex; align-items: center; justify-content: center; gap: 12px;
      padding: 15px 24px;
      background: transparent;
      color: var(--cream);
      border: 1.5px solid rgba(253,246,236,0.2);
      border-radius: 12px;
      text-decoration: none;
      font-weight: 600; font-size: 0.95rem;
      transition: background .2s, border-color .2s, transform .15s;
    }

    .btn-email:hover {
      background: rgba(253,246,236,0.08);
      border-color: var(--gold);
      color: var(--gold-lt);
      transform: translateY(-2px);
    }

    /* Contact page link */
    .btn-contact-page {
      display: flex; align-items: center; justify-content: center; gap: 8px;
      padding: 12px 24px;
      color: rgba(253,246,236,0.45);
      text-decoration: none;
      font-size: 0.82rem;
      transition: color .2s;
      border-top: 1px solid rgba(255,255,255,0.07);
      margin-top: 4px;
      padding-top: 16px;
    }

    .btn-contact-page:hover { color: var(--gold-lt); }

    /* Info note */
    .info-note {
      display: flex; align-items: flex-start; gap: 10px;
      background: rgba(201,151,58,0.08);
      border: 1px solid rgba(201,151,58,0.2);
      border-radius: 10px;
      padding: 14px 16px;
      margin-top: 16px;
      font-size: 0.8rem;
      color: rgba(253,246,236,0.55);
      line-height: 1.6;
    }

    .info-note-icon { font-size: 1rem; flex-shrink: 0; margin-top: 1px; }

    /* ── BACK LINK ── */
    .back-link {
      display: inline-flex; align-items: center; gap: 6px;
      margin: 0 40px 32px;
      color: var(--muted); text-decoration: none;
      font-size: 0.85rem; font-weight: 500;
      transition: color .2s;
    }

    .back-link:hover { color: var(--brown); }

    /* FOOTER */
    footer {
      text-align: center;
      padding: 28px;
      font-size: 0.82rem;
      color: var(--muted);
      border-top: 1px solid var(--border);
    }
    footer span { color: var(--gold); font-weight: 600; }

    /* ── RESPONSIVE ── */
    @media (max-width: 860px) {
      .detail-wrap { grid-template-columns: 1fr; gap: 32px; padding: 0 20px; }
      .img-panel { position: static; }
      .breadcrumb { padding: calc(var(--nav-h) + 20px) 20px 0; }
      .back-link { margin: 0 20px 24px; }
    }

    @media (max-width: 480px) {
      .specs-grid { grid-template-columns: 1fr; }
      .cta-box { padding: 22px; }
    }
  </style>
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
    <img src="../logo/companies.png" alt="Logo">
    <span class="nav-brand">Mining Market</span>
  </a>
  <ul class="nav-links">
    <li><a href="index.php">Home</a></li>
    <li><a href="products.php" class="active">Products</a></li>
    <li><a href="about.php">About</a></li>
    <li><a href="contact.php">Contact</a></li>
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
  <a href="../logout.php" class="m-logout">Logout</a>
</div>

<!-- BREADCRUMB -->
<div class="breadcrumb reveal">
  <a href="index.php">Home</a> /
  <a href="products.php">Produk</a> /
  <span><?php echo htmlspecialchars($item['name']); ?></span>
</div>

<!-- BACK -->
<a href="products.php" class="back-link reveal">← Kembali ke Katalog</a>

<!-- DETAIL -->
<div class="detail-wrap">

  <!-- GAMBAR -->
  <div class="img-panel reveal reveal-left">
    <div class="img-main">
      <img src="../images/products/<?php echo htmlspecialchars($item['image']); ?>"
           alt="<?php echo htmlspecialchars($item['name']); ?>"
           onerror="this.style.display='none'">
    </div>
    <div class="img-badge-wrap">
      <div class="img-badge">✅ Bersertifikat</div>
      <div class="img-badge">🚚 Siap Kirim</div>
      <div class="img-badge">🔧 Garansi Resmi</div>
    </div>
  </div>

  <!-- INFO -->
  <div class="info-panel reveal reveal-right">
    <div class="product-tag">⛏ Alat Tambang</div>

    <h1 class="product-title"><?php echo htmlspecialchars($item['name']); ?></h1>

    <div class="product-price-big">
      Rp <?php echo number_format($item['price'], 0, ',', '.'); ?>
    </div>
    <div class="price-note">
      💬 Harga dapat dinegosiasikan — hubungi tim kami
    </div>

    <div class="divider-line"></div>

    <div class="desc-label">Deskripsi Produk</div>
    <p class="desc-text"><?php echo nl2br(htmlspecialchars($item['description'])); ?></p>

    <!-- SPECS -->
    <div class="specs-grid">
      <div class="spec-item">
        <div class="spec-key">Kategori</div>
        <div class="spec-val">Alat Berat Tambang</div>
      </div>
      <div class="spec-item">
        <div class="spec-key">Kondisi</div>
        <div class="spec-val">Baru / Bersertifikat</div>
      </div>
      <div class="spec-item">
        <div class="spec-key">Garansi</div>
        <div class="spec-val">Garansi Resmi</div>
      </div>
      <div class="spec-item">
        <div class="spec-key">Pengiriman</div>
        <div class="spec-val">Seluruh Indonesia</div>
      </div>
    </div>

    <!-- CTA BOX -->
    <div class="cta-box">
      <h3>Tertarik dengan produk ini?</h3>
      <p>Hubungi tim kami langsung untuk informasi stok, spesifikasi teknis, dan negosiasi harga terbaik.</p>

      <div class="cta-buttons">

        <!-- WhatsApp -->
        <a href="https://wa.me/<?php echo $company_wa; ?>?text=<?php echo $wa_msg; ?>"
           target="_blank" rel="noopener" class="btn-wa">
          <svg width="22" height="22" viewBox="0 0 32 32" fill="none">
            <path fill="#fff" d="M16 3C9.37 3 4 8.37 4 15a11.93 11.93 0 0 0 1.67 6.1L3 29l8.1-2.6A11.94 11.94 0 0 0 16 27c6.63 0 12-5.37 12-12S22.63 3 16 3zm5.8 16.5c-.25.7-1.47 1.33-2.02 1.37-.53.04-1.03.22-3.4-.7-2.83-1.1-4.67-3.97-4.8-4.15-.14-.18-1.13-1.5-1.13-2.87 0-1.36.7-2.04 1-2.33.27-.28.6-.35.8-.35h.57c.17 0 .43-.06.67.5.25.6.86 2.1.93 2.25.08.15.13.33.03.53-.1.2-.15.33-.3.5-.14.18-.3.4-.43.54-.15.15-.3.3-.13.6.18.3.8 1.3 1.7 2.1 1.17 1.05 2.17 1.38 2.47 1.52.3.14.5.12.7-.08.2-.2.85-.97 1.07-1.3.22-.33.43-.28.72-.17.3.1 1.86.88 2.17 1.04.3.16.52.24.6.37.08.14.08.82-.17 1.52z"/>
          </svg>
          Chat via WhatsApp
        </a>

        <!-- Email -->
        <a href="mailto:<?php echo $company_email; ?>?subject=<?php echo $email_subject; ?>&body=<?php echo $email_body; ?>"
           class="btn-email">
          ✉️ Kirim Email Inquiry
        </a>

        <!-- Contact Page -->
        <a href="contact.php" class="btn-contact-page">
          📋 Atau isi form kontak kami →
        </a>
      </div>

      <div class="info-note">
        <span class="info-note-icon">ℹ️</span>
        <span>Tidak ada pembayaran online. Semua transaksi dilakukan langsung antara pembeli dan tim kami setelah deal harga disepakati.</span>
      </div>
    </div>

  </div>
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
</script>
</body>
</html>
