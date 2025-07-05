<?php
// Load file koneksi.php
include "koneksi.php";
// 

$nama = $_POST['nama'];
$alamat = $_POST['alamat'];
$email = $_POST['email'];
$biaya = $_POST['total_checkout']; // Ambil total harga dari form
$order_id = rand();
$transaction_status = 1;
$transaction_id = "";

// Simpan data ke database
mysqli_query($con, "INSERT INTO pembayaran (nama, alamat, biaya, order_id, transaction_status, transaction_id, email) 
VALUES ('$nama', '$alamat', '$biaya', '$order_id', '$transaction_status', '$transaction_id', '$email')");

// Redirect ke halaman pembayaran
header("location: midtrans/examples/snap/checkout-process-simple-version.php?order_id=$order_id");

?>


