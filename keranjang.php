<?php
require "koneksi.php";
session_start();

if (isset($_SESSION['customer_id']) && isset($_GET['nama'])) {
    $customer_id = $_SESSION['customer_id'];
    $nama_produk = $_GET['nama'];

    // Get product ID
    $query = mysqli_query($con, "SELECT id FROM produk WHERE nama='$nama_produk'");
    $produk = mysqli_fetch_array($query);

    // Add to cart
    mysqli_query($con, "INSERT INTO keranjang (produk_id, customer_id, jumlah) VALUES ('$produk[id]', '$customer_id', 1)");

    header("Location: view-keranjang.php");
    exit();
} else {
    echo "<script>alert('Silakan login terlebih dahulu!'); window.location.href='login.php';</script>";
}
?>
