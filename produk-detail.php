<?php
    require "koneksi.php";

    $nama = htmlspecialchars($_GET['nama']);
    $queryProduk = mysqli_query($con, "SELECT * FROM produk WHERE nama = '$nama'");
    $produk = mysqli_fetch_array($queryProduk);
    
    $queryProdukTerkait = mysqli_query($con, "SELECT * FROM produk WHERE kategori_id = '$produk[kategori_id]' AND id!='$produk[id]' LIMIT 4");
?>

<!Doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TechZone Store | Detail Produk</title>
    <!-- Style Bootstrap -->
    <link href="image/tz logo.png" rel="icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="fontawesome/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
    <!-- My Style -->
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
</head>

<body>
    <?php require "navbar.php"; ?>
    <!-- Detail Produk -->
    <div class="container py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-5 mb-3" data-aos="fade-in" data-aos-duration="600">
                    <img src="image/<?php echo $produk['foto']; ?>" class="w-100" alt="">
                </div>
                <div class="col-lg-6 offset-lg-1" data-aos="fade-left" data-aos-duration="600">
                    <h1 class="text-nama"><?php echo $produk['nama']; ?></h1>
                    <p class="py-3 text-detail">
                        <?php echo $produk['detail']; ?>
                    </p>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <p>Status Ketersediaan: <strong><?php echo $produk['ketersedian_stok']; ?></strong></p>                   
                    </div>

                    <div class="d-flex flex-wrap gap-2">
                        <!-- Tombol Beli Produk -->
                        <a 
                            class="btn btn-success d-flex align-items-center gap-2 tombol-beli" 
                            href="keranjang.php?nama=<?php echo $produk['nama']; ?>">
                            <i class="fas fa-shopping-cart"></i> Beli Produk
                        </a>
                        <!-- Tombol Kembali -->
                        <button class="btn btn-secondary d-flex align-items-center gap-2 tombol-kembali" onclick="history.back()">
                            <i class="fa-solid fa-backward"></i> Kembali
                        </button>
                    </div>
 
                </div>
            </div>
        </div>
    </div>

    <!-- Produk terkait -->
    <div class="container-fluid py-5 container-produk-terkait">
        <div class="container">
            <h2 class="text-center text-produk-terkait mb-5" data-aos="fade-in" data-aos-duration="800">Produk Terkait</h2>

            <div class="row align-items-center justify-content-center" data-aos="fade-in" data-aos-duration="800">
                <?php while($data = mysqli_fetch_array($queryProdukTerkait)){ ?>
                <div class="col-md-6 col-lg-3 mb-3 ">
                    <a href="produk-detail.php?nama=<?php echo $data['nama']; ?>" >
                        <img src="image/<?php echo $data['foto']; ?>" class="img-fluid img-thumbnail produk-terkait-img" alt="">
                    </a>
                </div>
                <?php } ?>
                
            </div>
        </div>
    </div>

    <!-- Script Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="fontawesome/js/all.min.js"></script>
    <script src="js/main.js"></script>
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
        AOS.init({once: true});
    </script>
</body>
<footer>
<?php require "footer.php"; ?>
</footer>
</html>
