<?php
require "koneksi.php";

// Aktifkan error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

$queryKategori = mysqli_query($con, "SELECT * FROM kategori");
if (!$queryKategori) {
    die("Error query kategori: " . mysqli_error($con));
}

// get produk by search/keyword
if(isset($_GET['keyword'])){
  $queryProduk = mysqli_query($con, "SELECT * FROM produk WHERE nama LIKE '%{$_GET['keyword']}%'");
}

// get produk by kategori
else if(isset($_GET['kategori'])){
  $queryGetKategoriId = mysqli_query($con, "SELECT id FROM kategori WHERE nama = '{$_GET['kategori']}'");
  $kategoriID = mysqli_fetch_array($queryGetKategoriId);

  $queryProduk = mysqli_query($con, "SELECT * FROM produk WHERE kategori_id = '{$kategoriID['id']}'");
}

// get produk default
else{
  $queryProduk = mysqli_query($con, "SELECT * FROM produk");
}

if (!$queryProduk) {
    die("Error query produk: " . mysqli_error($con));
}

$countData = mysqli_num_rows($queryProduk);

// sesi login
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

// Variabel untuk mengecek apakah user sudah login
$is_logged_in = isset($_SESSION['customer_id']);
?>

<!Doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TechZone Store | Produk</title>
    
    <link href="image/tz logo.png" rel="icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="fontawesome/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    
    <!-- SweetAlert2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    
    <!-- Alpine JS -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="js/app.js"></script>

    <style>
        /* Custom SweetAlert Styles */
        .swal2-popup {
            font-family: 'Arial', sans-serif;
            border-radius: 15px;
        }
        .swal2-title {
            font-weight: 700;
        }
        .swal2-confirm {
            background-color: #3085d6 !important;
            transition: all 0.3s ease;
        }
        .swal2-confirm:hover {
            transform: scale(1.05);
        }
    </style>
</head>
<body>
  <?php require "navbar.php"; ?>

  <!-- banner -->
  <div class="container-fluid banner-produk d-flex text-produk ">
    <div class="container">
      <h1 class="text-center ">Produk</h1>
    </div>
  </div>

  <!-- body -->
  <div class="container py-5" x-data="products">
    <div class="row">
      <!-- list kategori -->
      <div class="col-lg-3 mb-5" >
        <h3 class="text-center mb-3">Kategori</h3>
        <ul class="list-group">
          <?php while($kategori = mysqli_fetch_array($queryKategori)){ ?>
          <a href="produk.php?kategori=<?php echo htmlspecialchars($kategori['nama']); ?>">
          <li class="list-group-item"><?php echo htmlspecialchars($kategori['nama']); ?></li>
          </a>  
          <?php } ?>
        </ul>
      </div>

      <!-- list produk -->
      <div class="col-lg-9" >
        <h3 class="text-center mb-3" >Produk</h3>
        <div class="row">
          <?php 
            if($countData<1){
          ?>
              <h4 class="text-center my-5">Produk yang anda cari tidak tersedia</h4>
          <?php
            } 
          ?>

          <?php $delay = 0;
          while($produk = mysqli_fetch_array($queryProduk)){ ?>
          <div class="col-md-4 mb-4 " data-aos="fade-up" data-aos-delay="<?php echo $delay; ?>" data-aos-duration="800">
            <div class="card w-100 h-100">
              <div class="image-box">
                <img src="image/<?php echo htmlspecialchars($produk['foto']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($produk['nama']); ?>">
              </div>
              <div class="card-body ">
                <h4 class="card-title text-truncate text-nama"><?php echo htmlspecialchars($produk['nama']); ?></h4>
                <p class="card-text text-truncate text-detail"><?php echo htmlspecialchars($produk['detail']); ?></p>
                <p class="card-text text-harga">Rp <?php echo number_format($produk['harga'], 0, ',', '.'); ?></p>
                <div class="d-flex justify-content-center align-items-center">
                  <a href="produk-detail.php?nama=<?php echo urlencode($produk['nama']); ?>" class="btn btn-outline-secondary me-4"><i class="fa-regular fa-eye"></i></a>
                  
                  <!-- Tambahkan pengecekan login untuk keranjang -->
                  <?php if($is_logged_in): ?>
                    <a href="#" 
                      onclick="tambahKeKeranjang('<?php echo htmlspecialchars($produk['nama']); ?>')" 
                      class="btn btn-outline-secondary">
                      <i class="fas fa-shopping-cart"></i>
                    </a>
                  <?php else: ?>
                    <a href="#" 
                      onclick="showLoginPrompt()" 
                      class="btn btn-outline-secondary">
                      <i class="fas fa-shopping-cart"></i>
                    </a>
                  <?php endif; ?>
                </div>
              </div>
            </div> 
          </div>

          <?php $delay += 100;
          } ?>
        </div>
      </div>
    </div>
  </div>

  <!-- Script Section -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="fontawesome/js/all.min.js"></script>
  <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
  
  <!-- SweetAlert2 JS -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

  <script>
    // Initialize AOS
    AOS.init({once: true});

    // Login Prompt Function
    function showLoginPrompt() {
        Swal.fire({ title: 'Login Diperlukan',
            text: 'Anda harus login terlebih dahulu untuk menambahkan produk ke keranjang. Ingin login sekarang?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Login',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = 'login.php';
            }
        });
    }

    // Function to confirm adding to cart
    function tambahKeKeranjang(nama) {
        Swal.fire({
            title: 'Konfirmasi Tambah Keranjang',
            text: 'Anda yakin ingin menambahkan produk ini ke keranjang?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Tambahkan',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Redirect to cart page with product name
                window.location.href = 'keranjang.php?nama=' + encodeURIComponent(nama);
            }
        });
    }
  </script>
</body>
<footer>
<?php require "footer.php"; ?>
</footer>
</html>