<?php
  require "koneksi.php";
  $queryProduk = mysqli_query($con, "SELECT id, nama, harga, foto, detail FROM produk LIMIT 3");
?> 

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>TechZone Store | Home</title>
  <link href="image/tz logo.png" rel="icon">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="fontawesome/css/fontawesome.min.css">
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
</head>
<body>
  <?php require "navbar.php"; ?>

  <!-- carousel slider -->
  <div class="carousel-slide">
    <div id="carouselExampleIndicators" class="carousel slide">
    <div class="carousel-indicators ">
      <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
      <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
      <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
      <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="3" aria-label="Slide 4"></button>
      <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="4" aria-label="Slide 5"></button>
      <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="5" aria-label="Slide 6"></button>
      <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="6" aria-label="Slide 7"></button>
      <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="7" aria-label="Slide 8"></button>
    </div>
    <div class="carousel-inner">
      <div class="carousel-item active ">
        <img src="image/banner_rainbow2.jpg" class="d-block w-100" alt="...">
      </div>
      <div class="carousel-item ">
        <img src="image/banner_blue.jpg" class="d-block w-100" alt="...">
      </div>
      <div class="carousel-item">
        <img src="image/bgsamsung.jpg" class="d-block w-100" alt="...">
      </div>
      <div class="carousel-item">
        <img src="image/bgblueip.png" class="d-block w-100" alt="...">
      </div>
      <div class="carousel-item">
        <img src="image/bgbluehp.png" class="d-block w-100" alt="...">
      </div>
      <div class="carousel-item">
        <img src="image/bgbluetab.jpg" class="d-block w-100" alt="...">
      </div>
      <div class="carousel-item">
        <img src="image/bgwhitetab.png" class="d-block w-100" alt="...">
      </div>
      <div class="carousel-item">
        <img src="image/bgblackip.jpg" class="d-block w-100" alt="...">
      </div>
      </div>
      <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
        <span class="carousel-control-prev-icon " aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
      </button>
      <button class="carousel-control-next " type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden ">Next</span>
      </button>
    </div>
  </div>   

  <!-- highlight category -->
  <div class="container-fluid py-5 kategori-produk">
    <div class="container text-center">
      <h3>Kategori Populer</h3>

      <div class="row mt-5" >
        <div class="col-md-3" data-aos="zoom-in" data-aos-delay="50" data-aos-duration="800" data-aos-anchor-placement="center-bottom">
          <div class="highlighted-kategori kategori-android d-flex justify-content-center ">
            <h4 class="teks-kategori"><a href="produk.php?kategori=Android">Android</a></h4>
          </div>
        </div>
        <div class="col-md-3" data-aos="zoom-in" data-aos-delay="150" data-aos-duration="800" data-aos-anchor-placement="center-bottom">
          <div class="highlighted-kategori kategori-android3 d-flex justify-content-center">
            <h4 class="teks-kategori"><a href="produk.php?kategori=IPhone">Iphone</a></h4>
          </div>
        </div>
        <div class="col-md-3" data-aos="zoom-in" data-aos-delay="250" data-aos-duration="800" data-aos-anchor-placement="center-bottom">
          <div class="highlighted-kategori kategori-android4 d-flex justify-content-center">
            <h4 class="teks-kategori"><a href="produk.php?kategori=Tablet">Tablet</a></h4>
          </div>
        </div>
        <div class="col-md-3" data-aos="zoom-in" data-aos-delay="350" data-aos-duration="800" data-aos-anchor-placement="center-bottom">
          <div class="highlighted-kategori kategori-android2 d-flex justify-content-center">
            <h4 class="teks-kategori"><a href="produk.php?kategori=Android">Android</a></h4>
          </div>
        </div>
      </div>
    </div>
  </div>

<!-- tentang kami -->
<div class="container-fluid about-us py-5" style="background-color: #f8f9fa;">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6" data-aos="fade-right" data-aos-duration="1000">
                <div class="about-image-container position-relative">
                    <img src="image/about.jpg" alt="TechZone Store" class="img-fluid rounded-4 shadow-lg">
                    <div class="image-overlay"></div>
                </div>
            </div>
            <div class="col-md-6" data-aos="fade-left" data-aos-duration="1000">
                <div class="about-content ps-md-5">
                    <div class="section-header mb-4">
                        <h2 class="section-title fw-bold">Tentang TechZone Store</h2>
                        <div class="section-line"></div>
                    </div>
                    <p class="lead text-muted mb-4">
                        TechZone Store adalah destinasi terdepan untuk para pecinta teknologi. 
                        Kami berkomitmen menyediakan produk-produk elektronik terkini dengan kualitas terbaik 
                        dan harga yang kompetitif.
                    </p>
                    <div class="about-features">
                        <div class="feature mb-3">
                            <i class="fas icon-about fa-check-circle me-3"></i>
                            <span >Produk Berkualitas Tinggi</span>
                        </div>
                        <div class="feature mb-3">
                            <i class="fas icon-about fa-shipping-fast  me-3"></i>
                            <span>Pengiriman Cepat dan Aman</span>
                        </div>
                        <div class="feature mb-3">
                            <i class="fas icon-about fa-headset  me-3"></i>
                            <span>Layanan Pelanggan Profesional</span>
                        </div>
                    </div>
                    <a href="tentang-kami.php" class="btn btn-learn-more mt-4 px-4 py-2 rounded-pill">
                        More
                        <i class="fas fa-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
  
  <!-- produk -->
  <div class="container container-product mt-5">
   <div class="title-product" data-aos="fade-in" data-aos-duration="800">
    New Products
   </div>
    <div class="products">
        <?php
        $delay = 0;
        while ($data = mysqli_fetch_array($queryProduk)) { ?>
        <div class="product" data-aos="zoom-in"  data-aos-delay="<?php echo $delay; ?>" data-aos-duration="1000">
            <a href="produk-detail.php?nama=<?php echo $data['nama']; ?>">
                <div class="product-image-container">
                    <img alt="<?php echo $data['nama']; ?>" src="image/<?php echo $data['foto'] ?>" />
                </div>
            </a>
            <div class="label">New Product</div>
            <div class="favorite">
                <i class="fas fa-heart"></i>
            </div>
            <div class="product-info">
                <h3><?php echo $data['nama'] ?></h3>
                <p class="text-truncate"><?php echo $data['detail'] ?></p>
                <div class="price">Rp <?php echo $data['harga'] ?></div>
            </div>
        </div>
        <?php
            $delay += 200;
        } ?>
    </div>
  </div> 
  

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="fontawesome/js/all.min.js"></script>
  <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
  <script>
    AOS.init({once: true});
  </script>
</body>

<footer>
<?php require "footer.php"; ?>
</footer>

</html>