<?php
require "koneksi.php";
session_start();

if (!isset($_SESSION['customer_id'])) {
    echo "<script>alert('Silakan login terlebih dahulu!'); window.location.href='login.php';</script>";
    exit();
}

$customer_id = $_SESSION['customer_id'];

// Ambil item yang dipilih dari parameter URL
if (!isset($_GET['items'])) {
    echo "<script>alert('Tidak ada item yang dipilih'); window.location.href='view-keranjang.php';</script>";
    exit();
}

$selected_items = explode(',', $_GET['items']);
$items_list = implode(',', array_map('intval', $selected_items));

// Query untuk mendapatkan detail produk yang dipilih
$query = mysqli_query($con, "SELECT p.*, k.jumlah, k.id as cart_id, 
                             (p.harga * k.jumlah) AS total_harga 
                             FROM keranjang k 
                             JOIN produk p ON k.produk_id = p.id 
                             WHERE k.id IN ($items_list) AND k.customer_id = '$customer_id'");

$total_checkout = 0;
$items = [];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #34495e;
            --accent-color: #3498db;
        }

        body {
            background-color: #f4f6f9;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        .checkout-container {
            background-color: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            padding: 2.5rem;
            margin-top: 2rem;
        }

        .checkout-header {
            border-bottom: 2px solid var(--accent-color);
            padding-bottom: 1rem;
            margin-bottom: 2rem;
        }

        .cart-checkout {
            color: var(--primary-color);
            font-weight: 700;
        }

        .product-card {
            display: flex;
            align-items: center;
            background-color: #f8f9fa;
            border-radius: 10px;
            padding: 1rem;
            margin-bottom: 1rem;
        }

        .product-card img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 10px;
            margin-right: 1rem;
        }

        .form-checkout {
            background-color: #f8f9fa;
            border-radius: 15px;
            padding: 2rem;
            height: 100%;
        }

        .checkout-form .form-label {
            font-weight: 600;
            color: var(--secondary-color);
        }

        .checkout-form .form-control {
            border-radius: 8px;
            padding: 0.75rem;
        }

        .form-actions {
            display: flex;
            justify-content: space-between;
            margin-top: 1.5rem;
        }

        .btn-checkout {
            border-radius: 8px;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-batal {
            background-color: #6c757d;
            color: white;
        }

        .btn-lanjutkan {
            background-color: var(--accent-color);
            color: white;
        }

        .btn-checkout:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        @media (max-width: 768px) {
            .checkout-container {
                padding: 1rem;
            }

            .form-actions {
                flex-direction: column;
            }

            .btn-checkout {
                width: 100%;
                margin-bottom: 0.75rem;
            }
        }
    </style>
</head>
<body>
    <div class="container checkout-container">
        <div class="row checkout-header">
            <div class="col">
                <h2 class="cart-checkout">
                    <i class="fas fa-shopping-cart me-2"></i>Checkout
                </h2>
            </div>
        </div>

        <div class="row">
            <div class="col-md-7">
                <h4 class="mb-4">Detail Produk</h4>
                <?php while($row = mysqli_fetch_assoc($query)): 
                    $total_checkout += $row['total_harga'];
                    $items[] = $row['cart_id'];
                ?>
                <div class="product-card">
                    <img src="image/<?= $row['foto'] ?>" alt="<?= $row['nama'] ?>">
                    <div>
                        <h5><?= $row['nama'] ?></h5>
                        <p>Jumlah: <?= $row['jumlah'] ?> | Harga: Rp <?= number_format($row['total_harga']) ?></p>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>

            <div class="col-md-5">
                <div class="form-checkout h-100">
                    <h4 class="mb-4">Informasi Pengiriman</h4>
                    <form action="proses-pembayaran.php" method="post" class="checkout-form">
                        <input type="hidden" name="total_checkout" value="<?= $total_checkout ?>">
                        <input type="hidden" name="items" value="<?= implode(',', $items) ?>">

                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" name="nama" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Alamat</label>
                            <textarea class="form-control" name="alamat" required></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">No. Telepon</label>
                            <input type="number" class="form-control" name="telepon" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Total Pembayaran</label>
                            <input type="text" class="form-control" value="Rp <?= number_format($total_checkout) ?>" readonly>
                        </div>

                        <div class="form-actions">
                            <a href="view-keranjang.php" class="btn btn-checkout btn-batal">
                                Kembali
                            </a>
                            <button type="submit" class="btn btn-checkout btn-lanjutkan">
                                Bayar 
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>