<?php
require "koneksi.php";
session_start();

if (isset($_SESSION['customer_id']) && isset($_POST['cart_id']) && isset($_POST['jumlah'])) {
    $customer_id = $_SESSION['customer_id'];
    $cart_id = $_POST['cart_id'];
    $jumlah = $_POST['jumlah'];

    mysqli_query($con, "UPDATE keranjang SET jumlah = '$jumlah' 
                        WHERE id = '$cart_id' AND customer_id = '$customer_id'");
    echo "success";
}
?>
