<?php 
session_start();
include "../config/database.php"; 

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); 
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard User - PT MARLINJAYA MESIN</title>
    <link rel="stylesheet" href="../css/style.css">
    <script src="../js/loader.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
</head>
<body>

<nav class="gen-nav" id="gen-nav">
  <button class="gen-hamburger" id="gen-ham" aria-label="Toggle menu">
    <span></span><span></span><span></span><span></span>
  </button>
  
  <ul id="gen-menu">
      <li><a href="index.php">Home</a></li>
      <li><a href="products.php">Products</a></li> 
      <li><a href="about.php">About</a></li>
      <li><a href="contact.php">Contact Us</a></li>
      <li><a href="cart.php">Keranjang</a></li>
      <li style="margin-left: 20px;"><a href="../logout.php" style="color: #ff4d4d;">Logout</a></li>
  </ul>
</nav>

<div class="container-1" style="background-image: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('../assets/mining-bg.jpg'); height: 80vh; display: flex; flex-direction: column; justify-content: center; align-items: center; text-align: center; color: white;">
    <h1 style="font-size: 3rem; margin-bottom: 10px;">PT MARLINJAYA MESIN</h1>
    <p style="font-size: 1.2rem; max-width: 700px;">
        Halo, <strong><?php echo $_SESSION['username']; ?></strong>! Selamat datang di platform penyedia mesin dan peralatan tambang berkualitas tinggi.
    </p>
    <div style="margin-top: 30px;">
        <a href="products.php" style="padding: 12px 30px; background: #d4aa61; color: white; text-decoration: none; border-radius: 50px; font-weight: 600; transition: 0.3s;">Mulai Belanja</a>
    </div>
</div>

<div class="container" style="padding: 50px 20px; text-align: center;">
    <h2 style="color: #3d2b1f;">Kenapa Memilih Kami?</h2>
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-top: 30px;">
        <!-- Card Features Tetap Sama -->
    </div>
</div>
</body>
</html>