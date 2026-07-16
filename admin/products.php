<?php
session_start();
include "../config/database.php";

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}

// SIMPAN PRODUK BARU
if (isset($_POST['simpan'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $desc = mysqli_real_escape_string($conn, $_POST['description']);
    $image = $_FILES['image']['name'];
    if($image) move_uploaded_file($_FILES['image']['tmp_name'], '../images/products/' . $image);
    mysqli_query($conn, "INSERT INTO products (name, description, image) VALUES ('$name', '$desc', '$image')");
    header("Location: products.php?msg=added");
    exit();
}

// UPDATE PRODUK
if (isset($_POST['update'])) {
    $id = (int) $_POST['id'];
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $desc = mysqli_real_escape_string($conn, $_POST['description']);
    if (!empty($_FILES['image']['name'])) {
        $image = $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], '../images/products/' . $image);
        mysqli_query($conn, "UPDATE products SET name='$name', description='$desc', image='$image' WHERE id='$id'");
    } else {
        mysqli_query($conn, "UPDATE products SET name='$name', description='$desc' WHERE id='$id'");
    }
    header("Location: products.php?msg=updated");
    exit();
}

// HAPUS PRODUK
// --- PROSES HAPUS ---
if (isset($_GET['hapus'])) {
    $id_hapus = (int)$_GET['hapus'];
    mysqli_query($conn, "DELETE FROM products WHERE id = '$id_hapus'");
    // Redirect supaya URL bersih kembali
    header("Location: products.php"); 
    exit();
}

// --- PROSES AMBIL DATA EDIT ---
$edit_data = null;
if (isset($_GET['edit'])) {
    $id_edit = (int)$_GET['edit'];
    $res = mysqli_query($conn, "SELECT * FROM products WHERE id = '$id_edit'");
    $edit_data = mysqli_fetch_assoc($res);
}

// AMBIL SEMUA PRODUK
$products = mysqli_query($conn, "SELECT * FROM products ORDER BY id DESC");
$prod_count = mysqli_num_rows($products); // <-- INI YANG TADI BIKIN WARNING

// ... (kode di atasnya tetap sama)
$products = mysqli_query($conn, "SELECT * FROM products ORDER BY id DESC");
$prod_count = mysqli_num_rows($products);

// TAMBAHKAN BARIS INI UNTUK MEMPERBAIKI WARNING
$username = $_SESSION['username'] ?? 'Admin'; 
$username_initial = strtoupper(substr($username, 0, 1));
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Kelola Produk — Admin Mining Market</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../css/admin_layout.css">
  <link rel="stylesheet" href="../css/admin_products.css">
</head>
<body>

<div id="page-loader">
  <div class="loader-logo">Mining Market</div>
  <div class="loader-bar"><div class="loader-bar-fill"></div></div>
</div>

<div class="sidebar-overlay" id="sidebar-overlay"></div>

<aside class="sidebar" id="sidebar">
  <div class="sidebar-logo">
    <!-- <img src="../logo/companies.png" alt="Logo"> -->
    <div class="sidebar-logo-text">
      <span class="brand">Mining Market</span>
      <span class="sub">Admin Panel</span>
    </div>
  </div>
  <nav class="sidebar-nav">
    <div class="nav-section-label">Menu</div>
    <a href="dashboard.php" class="nav-item"><span class="nav-icon">📊</span> Dashboard</a>
    <a href="products.php"  class="nav-item active"><span class="nav-icon">📦</span> Kelola Produk</a>
    <!-- <a href="orders.php"    class="nav-item"><span class="nav-icon">📋</span> Laporan Order</a> -->
    <div class="nav-section-label" style="margin-top:12px;">Akun</div>
    <a href="../logout.php" class="nav-item logout" data-confirm="Yakin ingin logout?"><span class="nav-icon">⏻</span> Logout</a>
  </nav>
  <div class="sidebar-footer">© 2025 PT Marlinjaya Mesin</div>
</aside>

<header class="topbar">
  <div style="display:flex;align-items:center;gap:16px;">
    <button class="hamburger-admin" onclick="toggleSidebar()"><span></span><span></span><span></span></button>
    <div class="topbar-left">
      <h2>Kelola Produk</h2>
      <p><?php echo $edit_data ? 'Mode edit produk' : 'Tambah & kelola produk'; ?></p>
    </div>
  </div>
  <div class="topbar-right">
    <span style="font-size:0.8rem;color:var(--text-muted);"><?php echo strtoupper($_SESSION['username']); ?></span>
    <div class="avatar"><?php echo $username_initial; ?></div>
  </div>
</header>

<div class="page-body">
  <main class="page-content">

    <?php if (isset($_GET['msg'])): ?>
    <?php $msgs = ['added' => '✅ Produk berhasil ditambahkan.', 'updated' => '✅ Produk berhasil diperbarui.', 'deleted' => '🗑️ Produk berhasil dihapus.']; ?>
    <div class="fade-up" style="background:var(--green-bg);color:var(--green);padding:12px 18px;border-radius:10px;margin-bottom:20px;font-size:0.85rem;font-weight:600;border:1px solid rgba(46,125,50,0.2);">
      <?php echo $msgs[$_GET['msg']] ?? ''; ?>
    </div>
    <?php endif; ?>

    <div class="real-content">
      <div class="two-col">

        <div class="card form-card fade-up">
          <h3><?php echo $edit_data ? '✏️ Edit Produk' : '➕ Tambah Produk'; ?></h3>
          <form method="POST" enctype="multipart/form-data">
            <?php if ($edit_data): ?>
              <input type="hidden" name="id" value="<?php echo $edit_data['id']; ?>">
            <?php endif; ?>

            <div class="form-group">
              <label>Nama Produk</label>
              <input type="text" name="name" placeholder="Nama mesin/alat..." required
                     value="<?php echo $edit_data ? htmlspecialchars($edit_data['name']) : ''; ?>">
            </div>
            
            <div class="form-group">
              <label>Deskripsi Detail</label>
              <textarea name="description" placeholder="Masukkan deskripsi singkat/detail..." required><?php echo $edit_data ? htmlspecialchars($edit_data['description']) : ''; ?></textarea>
            </div>

            <div class="form-group">
              <label>Foto Produk <?php echo $edit_data ? '(opsional)' : ''; ?></label>
              <div class="upload-area" onclick="document.getElementById('imgInput').click()">
                <div class="upload-icon">📷</div>
                <div class="upload-label">Klik untuk pilih gambar</div>
                <div class="upload-name" id="uploadName"><?php echo $edit_data ? htmlspecialchars($edit_data['image']) : ''; ?></div>
              </div>
              <input type="file" name="image" id="imgInput" accept="image/*" style="display:none"
                     <?php echo $edit_data ? '' : 'required'; ?>>
            </div>

            <?php if ($edit_data): ?>
              <button type="submit" name="update" class="btn-submit edit-mode">Simpan Perubahan</button>
              <a href="products.php" class="btn-cancel-edit">✕ Batal Edit</a>
            <?php else: ?>
              <button type="submit" name="simpan" class="btn-submit">Tambah Produk</button>
            <?php endif; ?>
          </form>
        </div>

        <div class="card products-card fade-up">
          <div class="products-card-header">
            <h3>Daftar Produk</h3>
            <span class="product-count"><?php echo $prod_count; ?> produk</span>
          </div>
          <div style="overflow-x:auto;">
            <table class="products-table">
              <thead>
                <tr>
                  <th>Foto</th>
                  <th>Nama Produk</th>
                  <th>Deskripsi Singkat</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php while ($row = mysqli_fetch_assoc($products)): ?>
                <tr>
                  <td>
                    <?php if ($row['image']): ?>
                    <img src="../images/products/<?php echo $row['image']; ?>" class="product-thumb" alt="...">
                    <?php else: ?>
                    <div class="thumb-placeholder">📦</div>
                    <?php endif; ?>
                  </td>
                  <td class="product-name-cell"><?php echo htmlspecialchars($row['name']); ?></td>
                  <td class="product-desc-cell" style="max-width: 200px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; font-size: 0.85rem; color: #666;">
                    <?php echo htmlspecialchars($row['description']); ?>
                  </td>
                  <td>
                    <div class="row-actions">
                      <a href="products.php?edit=<?php echo $row['id']; ?>" class="btn-row edit">✏️ Edit</a>
                      <a href="products.php?hapus=<?php echo $row['id']; ?>" class="btn-row delete"
                         data-confirm="Hapus produk ini?">🗑 Hapus</a>
                    </div>
                  </td>
                </tr>
                <?php endwhile; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </main>
</div>

<script src="../js/admin.js"></script>
</body>
</html>