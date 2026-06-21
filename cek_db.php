<?php
/*
 * FILE DEBUG — HAPUS SETELAH SELESAI DEBUGGING
 * Buka di browser: http://localhost/mining-marketplace/cek_db.php
 */
include "config/database.php";

echo "<h2>Struktur tabel USERS:</h2><pre>";
$res = mysqli_query($conn, "DESCRIBE users");
if ($res) {
    while ($r = mysqli_fetch_assoc($res)) {
        echo $r['Field'] . " | " . $r['Type'] . " | " . $r['Key'] . "\n";
    }
} else {
    echo "ERROR: " . mysqli_error($conn);
}
echo "</pre>";

echo "<h2>Isi tabel USERS (5 baris terakhir):</h2><pre>";
$res2 = mysqli_query($conn, "SELECT * FROM users ORDER BY 1 DESC LIMIT 5");
if ($res2) {
    while ($r = mysqli_fetch_assoc($res2)) {
        // Sembunyikan password tapi tampilkan panjangnya
        if (isset($r['password'])) $r['password'] = '[' . strlen($r['password']) . ' chars] ' . substr($r['password'], 0, 7) . '...';
        if (isset($r['pass']))     $r['pass']     = '[' . strlen($r['pass']) . ' chars]';
        print_r($r);
        echo "\n";
    }
} else {
    echo "ERROR: " . mysqli_error($conn);
}
echo "</pre>";
?>
