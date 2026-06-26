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

// Info kontak
$company_email = "sales@miningmarket.id";
$company_wa    = "6281234567890";
$wa_msg = urlencode("Halo, saya tertarik dengan produk:\n📦 *{$item['name']}*\nMohon informasi lebih lanjut. Terima kasih.");
$email_subject = urlencode("Inquiry Produk: {$item['name']}");
$email_body    = urlencode("Halo Tim PT Marlin Jaya Mesin,\n\nSaya tertarik dengan produk:\nNama Produk : {$item['name']}\n\nMohon info ketersediaan stok & spesifikasi.\n\nTerima kasih.");
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title><?php echo htmlspecialchars($item['name']); ?> — Mining Market</title>
  <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../css/navbar.css">
  <style>
    :root { --brown: #2c1a0e; --brown-mid: #3d2b1f; --gold: #c9973a; --bg: #f5ede2; --muted: #8a7060; }
    body { font-family: 'DM Sans', sans-serif; background: var(--bg); color: var(--brown); }
    .detail-wrap { max-width: 1100px; margin: 40px auto; padding: 0 40px; display: grid; grid-template-columns: 1fr 1fr; gap: 48px; }
    .img-main { border-radius: 20px; overflow: hidden; background: #fff; aspect-ratio: 4/3; }
    .img-main img { width: 100%; height: 100%; object-fit: cover; }
    .product-title { font-family: 'Bebas Neue', sans-serif; font-size: 3rem; margin-bottom: 20px; }
    .desc-text { line-height: 1.8; color: var(--brown-mid); margin-bottom: 30px; }
    .btn-back { 
        display: inline-flex; align-items: center; padding: 10px 20px; 
        background: var(--brown); color: #fff; text-decoration: none; 
        border-radius: 8px; font-weight: 500; transition: 0.3s;
    }
    .btn-back:hover { background: #4a3728; }
    .btn-wa { display: block; padding: 15px; background: #25D366; color: #fff; text-align: center; border-radius: 12px; text-decoration: none; font-weight: 700; margin-bottom: 10px;}
    @media (max-width: 860px) { .detail-wrap { grid-template-columns: 1fr; padding: 0 20px; } }
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
    <li><a href="../logout.php" class="logout-btn">Logout</a></li>
  </ul>
</nav>

<div style="max-width: 1100px; margin: 100px auto 0; padding: 0 40px;">
    <a href="products.php" class="btn-back">← Kembali ke Katalog</a>
</div>

<div class="detail-wrap">
  <div class="img-panel">
    <div class="img-main">
      <img src="../images/products/<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>">
    </div>
  </div>

  <div class="info-panel">
    <h1 class="product-title"><?php echo htmlspecialchars($item['name']); ?></h1>
    <p class="desc-text"><?php echo nl2br(htmlspecialchars($item['description'])); ?></p>
    
    <div class="cta-box" style="background:var(--brown); padding:20px; border-radius:15px; color:#fff;">
      <h3>Tertarik dengan produk ini?</h3>
      <a href="https://wa.me/6281234567890<?php echo $company_wa; ?>?text=<?php echo $wa_msg; ?>" target="_blank" class="btn-wa">Chat via WhatsApp</a>
      <a href="mailto:<?php echo $company_email; ?>?subject=<?php echo $email_subject; ?>&body=<?php echo $email_body; ?>" style="color:#fff; text-align:center; display:block;">Atau kirim Email</a>
    </div>
  </div>
</div>

</body>
</html>