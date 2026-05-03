<?php
session_start();
include "../config/database.php";

if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Silahkan login terlebih dahulu!'); window.location='login.php';</script>";
    exit();
}

// Pastikan request datang dari form POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_user        = $_SESSION['user_id'];
    $nama_pembeli   = mysqli_real_escape_string($conn, $_POST['nama_pembeli']);
    $alamat         = mysqli_real_escape_string($conn, $_POST['alamat']);
    $metode_bayar   = mysqli_real_escape_string($conn, $_POST['metode_bayar']);
    
    // MENGAMBIL HARGA DARI FORM, BUKAN HARDCODE
    $total_harga    = (int) $_POST['total_harga']; 

    $query = "INSERT INTO orders (id_user, nama_pembeli, alamat_pengiriman, jumlah_beli, total_harga, metode_pembayaran, status, tanggal_order) 
              VALUES ('$id_user', '$nama_pembeli', '$alamat', 1, '$total_harga', '$metode_bayar', 'pending', NOW())";

    if (mysqli_query($conn, $query)) {
        unset($_SESSION['cart']); // Kosongkan keranjang setelah sukses
        echo "<script>alert('Pesanan Berhasil dikirim!'); window.location.href='index.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
} else {
    // Jika ada yang akses langsung url proses_checkout.php
    header("Location: products.php");
    exit();
}
?>