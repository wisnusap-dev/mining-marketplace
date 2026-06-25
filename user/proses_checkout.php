<?php
session_start();
include "../config/database.php";

// 1. PROTEKSI HALAMAN: Pastikan user sudah login
if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Silahkan login terlebih dahulu!'); window.location='login.php';</script>";
    exit();
}

// Pastikan request adalah POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: products.php");
    exit();
}

$id_user      = $_SESSION['user_id'];
$nama_pembeli = mysqli_real_escape_string($conn, $_POST['nama_pembeli']);
$alamat       = mysqli_real_escape_string($conn, $_POST['alamat']);
$metode_bayar = mysqli_real_escape_string($conn, $_POST['metode_bayar']);
$total_harga  = (int) $_POST['total_harga'];

// Validasi nominal harga untuk mencegah kecurangan/eror angka minus
if ($total_harga <= 0) {
    header("Location: products.php");
    exit();
}

// 2. SIMPAN TRANSAKSI KE DATABASE LOKAL TERLEBIH DAHULU (Status: pending)
$query = "INSERT INTO orders (id_user, nama_pembeli, alamat_pengiriman, jumlah_beli, total_harga, metode_pembayaran, status, tanggal_order)
          VALUES ('$id_user', '$nama_pembeli', '$alamat', 1, '$total_harga', '$metode_bayar', 'pending', NOW())";

if (mysqli_query($conn, $query)) {
    
    // Mengambil ID order terakhir dari database agar sinkron sempurna dengan Midtrans
    $inserted_id = mysqli_insert_id($conn);
    $order_id    = "MINE-" . $inserted_id . "-" . time(); 

    // ==========================================
    // CONFIGURATION MIDTRANS SANDBOX (AKTIF)
    // ==========================================
    $server_key = "SB-Mid-server-ToZ_s67Z2Z9-fK8fScl6fXun"; 
    $url = "https://app.sandbox.midtrans.com/snap/v1/transactions";

    $transaction_details = [
        'order_id'     => $order_id,
        'gross_amount' => $total_harga,
    ];

    $customer_details = [
        'first_name' => $nama_pembeli,
        'address'    => $alamat,
    ];

    $params = [
        'transaction_details' => $transaction_details,
        'customer_details'    => $customer_details,
    ];

    $json_payload = json_encode($params);

    // Proses Hit API Midtrans menggunakan cURL Native PHP
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $json_payload);
    
    // Melewati validasi SSL khusus lingkungan localhost/laragon agar tidak eror blank
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Accept: application/json',
        'Authorization: Basic ' . base64_encode($server_key . ':')
    ]);

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        echo 'Koneksi Eror ke Midtrans: ' . curl_error($ch);
        curl_close($ch);
        exit();
    }
    
    curl_close($ch);
    $result = json_decode($response, true);

    // Jika Token didapatkan, hapus isi keranjang belanja
    if (isset($result['token'])) {
        $snap_token = $result['token'];
        unset($_SESSION['cart']); 
    } else {
        echo "Gagal menghubungkan ke server Payment Gateway. Respons: " . htmlspecialchars($response);
        exit();
    }

} else {
    echo "Gagal menyimpan data pesanan ke database: " . mysqli_error($conn);
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selesaikan Pembayaran - Mining Market</title>
    <link rel="stylesheet" href="../css/style.css">
    <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="SB-Mid-client-IdW_VwAtW9H_XvGf"></script>
    <style>
        body { font-family: 'DM Sans', sans-serif; background-color: #f5ede2; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .pay-box { background: white; padding: 40px; border-radius: 10px; text-align: center; box-shadow: 0 4px 15px rgba(0,0,0,0.05); max-width: 450px; width: 100%; }
        .btn-pay { background: #3d2b1f; color: white; border: none; padding: 12px 25px; font-size: 1rem; font-weight: bold; border-radius: 5px; cursor: pointer; margin-top: 20px; width: 100%; transition: background 0.2s; }
        .btn-pay:hover { background: #5c4033; }
    </style>
</head>
<body>

<div class="pay-box">
    <h2 style="color: #3d2b1f; margin-bottom: 5px;">Transaksi Berhasil Dibuat!</h2>
    <p style="margin-top: 10px; color: #555; font-size: 0.95rem;">Klik tombol di bawah ini untuk membuka halaman pembayaran resmi dan menyelesaikan order Anda.</p>
    
    <table style="width:100%; margin: 25px 0; border-top: 1px solid #eee; border-bottom: 1px solid #eee; padding: 12px 0; text-align: left; font-size: 0.95rem; color: #3d2b1f;">
        <tr>
            <td style="padding: 4px 0;">ID Transaksi</td>
            <td>: <b><?php echo $order_id; ?></b></td>
        </tr>
        <tr>
            <td style="padding: 4px 0;">Total Bayar</td>
            <td>: <b style="color: #c9973a;">Rp <?php echo number_format($total_harga, 0, ',', '.'); ?></b></td>
        </tr>
    </table>
    
    <button id="pay-button" class="btn-pay">Bayar Sekarang</button>
</div>

<script type="text/javascript">
    var payButton = document.getElementById('pay-button');
    
    payButton.onclick = function () {
        window.snap.pay('<?php echo $snap_token; ?>', {
            onSuccess: function(result){
                alert("Pembayaran Sukses! Terima kasih.");
                window.location.href = 'products.php';
            },
            onPending: function(result){
                alert("Menunggu Pembayaran Anda.");
                window.location.href = 'products.php';
            },
            onError: function(result){
                alert("Pembayaran Gagal, Silakan Coba Lagi.");
                window.location.href = 'cart.php';
            },
            onClose: function(){
                alert('Anda menutup halaman pembayaran sebelum selesai.');
            }
        });
    };
    
    // Otomatis menembak popup pembayaran instan ketika halaman selesai dimuat
    window.onload = function() {
        payButton.click();
    };
</script>
</body>
</html>