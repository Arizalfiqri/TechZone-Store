<?php
require "koneksi.php";
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}


// Periksa apakah user sudah login
$is_logged_in = isset($_SESSION['customer_id']);

// Ambil jumlah total produk di keranjang berdasarkan customer_id jika sudah login
$total_produk = 0;
if ($is_logged_in) {
    $customer_id = $_SESSION['customer_id'];
    $queryKeranjang = mysqli_query($con, "SELECT SUM(jumlah) AS total_produk FROM keranjang WHERE customer_id = $customer_id");
    $dataKeranjang = mysqli_fetch_array($queryKeranjang);
    $total_produk = $dataKeranjang['total_produk'] ?? 0; // Jika keranjang kosong, default 0
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>TechZone Store</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="fontawesome/css/all.min.css">
  <link rel="stylesheet" href="css/style.css">
</head>

<body>
  <nav class="navbar navbar-expand-lg col-md-12 sticky-top shadow-sm" data-bs-theme="dark">
    <div class="container-fluid navbar-container">
      <img src="image/tz logo.png" alt="TechZone Logo">
      <a class="navbar-brand" href="#">TechZone</a>

      <!-- Hamburger Button -->
      <div class="dropdown">
        <button class="navbar-toggler" type="button">
          <i class="fa-solid fa-list tombol-toggle"></i>
        </button>
        <ul class="dropdown-menu dropdown-menu-end">
          <button class="close-button" aria-label="Close">&times;</button>
          <li><a class="dropdown-item" href="index.php">Home</a></li>
          <li><a class="dropdown-item" href="tentang-kami.php">Tentang</a></li>
          <li><a class="dropdown-item" href="produk.php">Produk</a></li>
          <li>
            <?php if ($is_logged_in): ?>
              <a class="dropdown-item" href="logout.php">Logout</a>
            <?php else: ?>
              <a class="dropdown-item" href="login.php">Login</a>
            <?php endif; ?>
          </li>

        </ul>
      </div>

      <!-- Search bar -->
      <form action="produk.php" method="get" class="search-bar me-auto">
        <input type="text" placeholder="cari gadget impian" name="keyword" autocomplete="off">
        <button type="submit"><i class="fa-solid fa-magnifying-glass" style="color: #D8C4B6;"></i></button>
      </form>

      <!-- Ikon keranjang belanja dan media sosial -->
      <div class="d-flex align-items-center cart-icon">
        <!-- Ikon Keranjang Belanja -->
        <!-- Ikon Keranjang Belanja -->
        <a href="view-keranjang.php" class="position-relative" title="Keranjang Belanja">
          <i class="fa-solid fa-cart-shopping cart-shop text-white"></i>
          <span class="top-0 start-100 translate-middle badge rounded-pill bg-danger">
            <?php echo $is_logged_in ? $total_produk : 0; ?>
          </span>
        </a>


        <!-- Ikon media sosial -->
        <div class="social-icons ms-auto">
          <a href="https://www.linkedin.com" target="_blank" title="Linkedin"><i class="fab fa-linkedin-in"></i></a>
          <a href="https://www.facebook.com" target="_blank" title="Facebook"><i class="fab fa-facebook-f"></i></a>
          <a href="https://www.instagram.com" target="_blank" title="Instagram"><i class="fab fa-instagram"></i></a>
          <a href="https://wa.me/62895606185527" target="_blank" title="WhatsApp"><i class="fab fa-whatsapp"></i></a>
        </div>
      </div>
    </div>
  </nav>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="fontawesome/js/all.min.js"></script>
  <script src="js/main.js"></script>
</body>
</html>
