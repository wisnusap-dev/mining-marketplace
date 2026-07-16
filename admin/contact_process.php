<?php
session_start();

// Cek apakah user SUDAH login (misalnya ditandai dengan adanya session 'user_id')
if (!isset($_SESSION['user_id'])) {
    // Simpan URL saat ini beserta parameternya ke dalam session
    $_SESSION['intended_url'] = $_SERVER['REQUEST_URI']; 
    
    // Lempar ke halaman login
    header("Location: login.php");
    exit;
}

// JIKA SUDAH LOGIN: Lakukan proses selanjutnya
// Misalnya, ambil data nomor admin dari MySQL berdasarkan product_id
$product_id = $_GET['product_id'];
// ... (Logika Query ke MySQL) ...

$nomor_wa = "6281234567890"; // Contoh hasil query
$pesan = "Halo, saya tertarik dengan produk ID: " . $product_id;

// Redirect langsung ke WhatsApp
header("Location: https://wa.me/{$nomor_wa}?text=" . urlencode($pesan));
exit;
?>