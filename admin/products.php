<?php
session_start();
include "../config/database.php";

// Logika Tambah Produk Baru
if (isset($_POST['simpan'])) {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    
    // Logika Upload Gambar
    $image = $_FILES['image']['name'];
    $source = $_FILES['image']['tmp_name'];
    $folder = '../images/products/';

    move_uploaded_file($source, $folder.$image);

    $query = mysqli_query($conn, "INSERT INTO products (name, description, price, image) VALUES ('$name', '$description', '$price', '$image')");
    header("Location: products.php");
}

// Logika Hapus Produk
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    mysqli_query($conn, "DELETE FROM products WHERE id='$id'");
    header("Location: products.php");
}

// Ambil Data untuk Edit (Jika tombol edit ditekan)
$edit_data = null;
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $res = mysqli_query($conn, "SELECT * FROM products WHERE id='$id'");
    $edit_data = mysqli_fetch_assoc($res);
}

// Logika Update Produk
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    
    if ($_FILES['image']['name'] != "") {
        $image = $_FILES['image']['name'];
        $source = $_FILES['image']['tmp_name'];
        move_uploaded_file($source, '../images/products/'.$image);
        mysqli_query($conn, "UPDATE products SET name='$name', price='$price', description='$description', image='$image' WHERE id='$id'");
    } else {
        mysqli_query($conn, "UPDATE products SET name='$name', price='$price', description='$description' WHERE id='$id'");
    }
    header("Location: products.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Kelola Produk - Admin</title>
    <link rel="stylesheet" href="../css/admin.css">
    <style>
        .form-container { background: white; padding: 20px; border-radius: 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); margin-bottom: 30px; }
        table { width: 100%; border-collapse: collapse; background: white; }
        th, td { padding: 12px; border: 1px solid #ddd; text-align: left; }
        th { background: #8800ff; color: white; }
        .btn-edit { color: orange; text-decoration: none; font-weight: bold; margin-right: 10px; }
        .btn-hapus { color: red; text-decoration: none; font-weight: bold; }
    </style>
</head>
<body>
    <div class="main-container" style="display: block; max-width: 900px; margin: auto;">
        <h2 style="text-align: center; color: white; margin-bottom: 20px;">
            <?php echo $edit_data ? "Edit Produk" : "Tambah Produk Baru"; ?>
        </h2>

        <div class="form-container">
            <form method="POST" enctype="multipart/form-data" class="login-form">
                <?php if($edit_data): ?>
                    <input type="hidden" name="id" value="<?php echo $edit_data['id']; ?>">
                <?php endif; ?>

                <div class="input-group">
                    <label>Nama Produk</label>
                    <input type="text" name="name" value="<?php echo $edit_data ? $edit_data['name'] : ''; ?>" required>
                </div>
                <div class="input-group">
                    <label>Harga (Angka saja)</label>
                    <input type="number" name="price" value="<?php echo $edit_data ? $edit_data['price'] : ''; ?>" required>
                </div>
                <div class="input-group">
                    <label>Deskripsi</label>
                    <textarea name="description" rows="3" style="width:100%; border-radius:10px; padding:10px; border:1px solid #ddd;"><?php echo $edit_data ? $edit_data['description'] : ''; ?></textarea>
                </div>
                <div class="input-group" style="margin-top: 15px;">
                    <label>Foto Produk</label>
                    <input type="file" name="image" <?php echo $edit_data ? '' : 'required'; ?>>
                    <?php if($edit_data): ?>
                        <small>Kosongkan jika tidak ingin mengubah gambar. Gambar saat ini: <b><?php echo $edit_data['image']; ?></b></small>
                    <?php endif; ?>
                </div>

                <?php if($edit_data): ?>
                    <button type="submit" name="update" style="background: orange;">Update Produk</button>
                    <a href="products.php" style="display:block; text-align:center; margin-top:10px;">Batal Edit</a>
                <?php else: ?>
                    <button type="submit" name="simpan">Simpan Produk</button>
                <?php endif; ?>
            </form>
        </div>

        <h3 style="color: white; margin-bottom: 15px;">Daftar Produk Saat Ini</h3>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Harga</th>
                    <th>Gambar</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $products = mysqli_query($conn, "SELECT * FROM products");
                while ($row = mysqli_fetch_assoc($products)):
                ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['name']; ?></td>
                    <td>Rp <?php echo number_format($row['price'], 0, ',', '.'); ?></td>
                    <td><img src="../images/products/<?php echo $row['image']; ?>" width="50"></td>
                    <td>
                        <a href="products.php?edit=<?php echo $row['id']; ?>" class="btn-edit">Edit</a>
                        <a href="products.php?hapus=<?php echo $row['id']; ?>" class="btn-hapus" onclick="return confirm('Yakin hapus?')">Hapus</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>