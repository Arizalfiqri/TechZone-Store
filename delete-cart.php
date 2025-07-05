<?php
require "koneksi.php";
session_start();

if (isset($_SESSION['customer_id']) && isset($_POST['cart_id'])) {
    $customer_id = $_SESSION['customer_id'];
    $cart_id = $_POST['cart_id'];

    mysqli_query($con, "DELETE FROM keranjang 
                        WHERE id = '$cart_id' AND customer_id = '$customer_id'");
    echo "success";
}
?>
