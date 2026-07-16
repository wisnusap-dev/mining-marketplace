<?php
$host = "localhost"; // Untuk local komputer wajib localhost
$user = "root";      // Username default Laragon/XAMPP adalah root
$pass = "";          // Password default Laragon/XAMPP itu kosong/tanpa spasi
$db   = "mining_market"; // Ganti dengan nama database yang lu buat di phpMyAdmin lokal lu

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>