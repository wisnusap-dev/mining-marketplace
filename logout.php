<?php
session_start(); // Memulai session agar bisa dihapus

// Menghapus semua variabel session
session_unset(); 

// Menghancurkan session secara total
session_destroy(); 

// Mengarahkan user kembali ke halaman login yang ada di folder root
header("Location: login.php"); 
exit();
?>