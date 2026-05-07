<?php 
session_start();
include "../config/database.php"; 
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog Produk Tambang</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/navbar.css">
    <style>
        .product-image img { width: 100%; height: 200px; object-fit: cover; border-radius: 10px; }
        .btn-cart { background: #d4aa61; color: white; padding: 8px 15px; text-decoration: none; border-radius: 5px; font-size: 0.9rem; }
        .btn-buy { background: #3d2b1f; color: white; padding: 8px 15px; text-decoration: none; border-radius: 5px; font-size: 0.9rem; }
    </style>

</head>
<body>

<nav class="gen-nav">
    <a href="index.php" class="nav-logo">
        <img src="../logo/companies.png" alt="Mining Market Logo">
    </a>

    <div class="menu-toggle" id="mobile-menu">
        <span class="bar"></span>
        <span class="bar"></span>
        <span class="bar"></span>
    </div>

    <ul id="gen-menu">
        <li><a href="index.php">Home</a></li>
        <li><a href="products.php">Products</a></li> 
        <li><a href="about.php">About</a></li>
        <li><a href="contact.php">Contact Us</a></li>
        <li><a href="cart.php">Keranjang</a></li>
        <li><a href="../logout.php" class="logout-btn">Logout</a></li>
    </ul>
</nav>


    <div class="container">
        <h1 class="main-title" style="color: #3d2b1f; text-align: center; margin-top: 30px;">Produk Tambang Unggulan</h1>
        <div class="product-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 25px; padding: 20px;">
            <?php
            $query = mysqli_query($conn, "SELECT * FROM products");
            while($row = mysqli_fetch_assoc($query)){
            ?>
            <div class="product-card" style="background: #fff; padding: 15px; border-radius: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
                <div class="product-image">
                    <img src="../images/products/<?php echo $row['image']; ?>" alt="<?php echo $row['name']; ?>">
                </div>
                <div class="product-info" style="margin-top: 15px;">
                    <h3 style="margin: 0; color: #3d2b1f;"><?php echo $row['name']; ?></h3>
                    <p class="desc" style="font-size: 13px; color: #777; height: 40px; overflow: hidden;"><?php echo $row['description']; ?></p>
                    <p class="price" style="font-weight: bold; color: #d4aa61; font-size: 1.1rem;">Rp <?php echo number_format($row['price'], 0, ',', '.'); ?></p>
                    <div class="action-buttons" style="display: flex; gap: 10px; margin-top: 15px;">
                        <a href="cart.php?id=<?php echo $row['id']; ?>" class="btn-cart">🛒 + Keranjang</a>
                        <a href="checkout.php?id=<?php echo $row['id']; ?>" class="btn-buy">Beli Langsung</a>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
    <script src="../js/navbar.js"></script>
</body>
</html>