<?php
require "koneksi.php";
session_start();

if (!isset($_SESSION['customer_id'])) {
    // Tambahkan DOCTYPE dan head untuk memastikan script bisa dijalankan
    echo "<!DOCTYPE html>
    <html>
    <head>
        <meta charset='UTF-8'>
        <title>Login Diperlukan</title>
        <link href='https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css' rel='stylesheet'>
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js'></script>
    </head>
    <body>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'warning',
                title: 'Login Diperlukan',
                text: 'Silakan login terlebih dahulu!',
                confirmButtonText: 'Login Sekarang',
                confirmButtonColor: '#3085d6',
                willClose: () => {
                    window.location.href = 'login.php';
                }
            });
        });
    </script>
    </body>
    </html>";
    exit();
}

$customer_id = $_SESSION['customer_id'];

$query = mysqli_query($con, "SELECT p.*, k.jumlah, k.id as cart_id 
                            FROM keranjang k 
                            JOIN produk p ON k.produk_id = p.id 
                            WHERE k.customer_id = '$customer_id'");
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Keranjang Belanja</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php require "navbar.php"; ?>
    
    <div class="container cart-container">
        <div class="row">
            <div class="col-12">
                <h2 class="mb-4 text-center">
                    <i class="fas fa-shopping-cart me-2"></i>Keranjang Belanja
                </h2>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="table-responsive-mobile">
                    <?php 
                    $total = 0;
                    while($row = mysqli_fetch_array($query)): 
                        $subtotal = $row['harga'] * $row['jumlah'];
                    ?>
                    <div class="cart-item-mobile" data-cart-id="<?= $row['cart_id'] ?>" data-subtotal="<?= $subtotal ?>">
                        <div class="cart-item-header">
                            <input type="checkbox" class="form-check-input product-checkbox me-2">
                            <span class="product-name"><?= $row['nama'] ?></span>
                            <button class="btn btn-danger btn-sm delete-item float-end" 
                                    data-cart-id="<?= $row['cart_id'] ?>">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                        <div class="cart-item-body">
                            <div class="cart-item-image">
                                <img src="image/<?= $row['foto'] ?>" class="img-fluid">
                            </div>
                            <div class="cart-item-details">
                                <div class="detail-row">
                                    <span>Harga</span>
                                    <strong>Rp <?= number_format($row['harga']) ?></strong>
                                </div>
                                <div class="detail-row">
                                    <span>Jumlah</span>
                                    <input type="number" 
                                        class="form-control quantity-input" 
                                        min="1" 
                                        value="<?= $row['jumlah'] ?>" 
                                        data-cart-id="<?= $row['cart_id'] ?>">
                                </div>
                                <div class="detail-row">
                                    <span>Total</span>
                                    <strong>Rp <?= number_format($subtotal) ?></strong>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endwhile; ?>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-12">
                <div class="cart-summary-mobile">
                    <div class="summary-header">
                        <input type="checkbox" id="select-all" class="form-check-input me-2">
                        <span>Pilih Semua</span>
                    </div>
                    <div class="summary-body">
                        <div class="summary-detail">
                            <span>Total Produk Dipilih:</span>
                            <strong id="selected-count">0</strong>
                        </div>
                        <div class="summary-detail">
                            <span>Total Harga:</span>
                            <strong id="total-price">Rp 0</strong>
                        </div>
                    </div>
                    <div class="summary-actions">
                        <a href="produk.php" class="btn btn-next me-2">
                            <i class="fa-solid fa-arrow-left me-2"></i>Lanjut Belanja
                        </a>
                        <button class="btn btn-checkout1" id="checkout-btn">
                            <i class="fas fa-money-check-alt me-2"></i>Checkout
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
            document.addEventListener('DOMContentLoaded', function() {
            const selectAllCheckbox = document.getElementById('select-all');
            const productCheckboxes = document.querySelectorAll('.product-checkbox');
            const selectedCountElement = document.getElementById('selected-count');
            const totalPriceElement = document.getElementById('total-price');
            const checkoutBtn = document.getElementById('checkout-btn');

            // Select All Checkbox
            selectAllCheckbox.addEventListener('change', function() {
                productCheckboxes.forEach(checkbox => {
                    checkbox.checked = this.checked;
                    checkbox.closest('.cart-item-mobile').classList.toggle('selected', this.checked);
                });
                updateSummary();
            });

            // Individual Product Checkbox
            productCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    this.closest('.cart-item-mobile').classList.toggle('selected', this.checked);
                    updateSummary();
                });
            });

            // Update Summary
            function updateSummary() {
                let selectedCount = 0;
                let totalPrice = 0;

                productCheckboxes.forEach(checkbox => {
                    if (checkbox.checked) {
                        selectedCount++;
                        const row = checkbox.closest('.cart-item-mobile');
                        totalPrice += parseFloat(row.dataset.subtotal);
                    }
                });

                selectedCountElement.textContent = selectedCount;
                totalPriceElement.textContent = 'Rp ' + totalPrice.toLocaleString();
            }

            // Checkout Button
            checkoutBtn.addEventListener('click', function() {
                const selectedItems = Array.from(productCheckboxes)
                    .filter(checkbox => checkbox.checked)
                    .map(checkbox => checkbox.closest('.cart-item-mobile').dataset.cartId);

                if (selectedItems.length > 0) {
                    window.location.href = 'checkout.php?items=' + selectedItems.join(',');
                } else {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Opps...',
                        text: 'Silakan pilih produk yang ingin di-checkout!',
                        confirmButtonText: 'Mengerti',
                        confirmButtonColor: '#3085d6'
                    });
                }
            });

            // Delete Item
            document.querySelectorAll('.delete-item').forEach(button => {
                button.addEventListener('click', function() {
                    const cartId = this.dataset.cartId;
                    Swal.fire({
                        icon: 'warning',
                        title: 'Konfirmasi Hapus',
                        text: 'Apakah Anda yakin ingin menghapus item ini dari keranjang?',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Ya, Hapus',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            fetch('delete-cart.php', {
                                method: 'POST',
                                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                                body: `cart_id=${cartId}`
                            }).then(() => {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Item Dihapus',
                                    text: 'Item berhasil dihapus dari keranjang.',
                                    confirmButtonText: 'OK'
                                }).then(() => {
                                    location.reload();
                                });
                            });
                        }
                    });
                });
            });

            // Quantity Change
            document.querySelectorAll('.quantity-input').forEach(input => {
                input.addEventListener('change', function() {
                    const cartId = this.dataset.cartId;
                    const newQuantity = this.value;
                    fetch('update-cart.php', {
                        method: 'POST',
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                        body: `cart_id=${cartId}&jumlah=${newQuantity}`
                    }).then(() => location.reload());
                });
            });
        });
    </script>
</body>
<footer>
    <?php require "footer.php"; ?>
</footer>
</html>