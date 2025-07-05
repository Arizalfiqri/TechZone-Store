<?php
  require "session.php";
  require "../koneksi.php";

  $queryKategori = mysqli_query($con, "SELECT * FROM kategori");
  $jumlahKategori = mysqli_num_rows($queryKategori);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Kategori</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f4f6f9;
      font-family: 'Arial', sans-serif;
    }
    .sidebar {
      width: 250px;
      position: fixed;
      top: 0;
      left: 0;
      height: 100vh;
      z-index: 1000;
      transition: all 0.3s;
    }
    .main-content {
      margin-left: 250px;
      padding: 20px;
      transition: all 0.3s;
    }
    .no-decoration {
      text-decoration: none;
    }
    .card-custom {
      border-radius: 15px;
      box-shadow: 0 4px 6px rgba(0,0,0,0.1);
      margin-bottom: 20px;
    }
    .table-responsive {
      border-radius: 15px;
      overflow: hidden;
    }
    .table {
      margin-bottom: 0;
    }
    .table thead {
      background-color: #f1f3f6;
    }
    .btn-action {
      margin-right: 5px;
    }

    /* Responsive Adjustments */
    @media (max-width: 768px) {
      .sidebar {
        width: 100%;
        height: auto;
        position: relative;
        z-index: 1;
      }
      .main-content {
        margin-left: 0;
        padding: 10px;
      }
      .table-responsive {
        font-size: 0.9rem;
      }
      .form-control, .btn {
        font-size: 0.9rem;
      }
    }
  </style>
</head>
<body>
  <?php require "navbar.php"; ?>

  <div class="main-content">
    <div class="container-fluid">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="../adminpanel" class="no-decoration text-muted">
              <i class="fas fa-home"></i> Home
            </a>
          </li>
          <li class="breadcrumb-item active" aria-current="page">
            Kategori
          </li>
        </ol>
      </nav>

      <div class="row">
        <div class="col-12 col-md-6">
          <div class="card card-custom">
            <div class="card-body">
              <h3 class="card-title mb-4">Tambah Kategori</h3>
              <form action="" method="post">
                <div class="mb-3">
                  <label for="kategori" class="form-label">Kategori</label>
                  <input type="text" id="kategori" name="kategori" 
                         placeholder="Input nama kategori" 
                         class="form-control" 
                         autocomplete="off" required>
                </div>
                <div>
                  <button class="btn btn-primary" type="submit" name="simpan_kategori">
                    <i class="fas fa-save me-2"></i>Simpan
                  </button>
                </div>
              </form>

              <?php
                if(isset($_POST["simpan_kategori"])){
                  $kategori = htmlspecialchars($_POST["kategori"]);

                  $queryExist = mysqli_query($con,"SELECT nama FROM kategori WHERE nama='$kategori'");
                  $jumlahDataKategoriBaru = mysqli_num_rows($queryExist);

                  if($jumlahDataKategoriBaru > 0){
              ?>
                  <div class="alert alert-warning mt-3" role="alert">
                    Kategori sudah ada!
                  </div>    
              <?php
                  }
                  else{
                    $querySimpan = mysqli_query($con,"INSERT INTO kategori (nama) VALUES ('$kategori')");
                    if($querySimpan){
              ?>
                      <div class="alert alert-success mt-3" role="alert">
                        Kategori Berhasil Tersimpan!
                      </div>
                      <meta http-equiv="refresh" content="1; url=kategori.php" />
              <?php
                    }
                    else{
                      echo mysqli_error($con);
                    }
                  }
                }
              ?>
            </div>
          </div>
        </div>
      </div>

      <div class="mt-4">
        <div class="card card-custom">
          <div class="card-body">
            <h2 class="card-title mb-4">List Kategori</h2>
            <div class="table-responsive">
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th>No.</th>
                    <th>Nama</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php 
                    if ($jumlahKategori == 0) {
                  ?>
                    <tr>
                      <td colspan="3" class="text-center">Data Kategori Tidak Tersedia</td>
                    </tr>
                  <?php
                    }
                    else{
                      $jumlah = 1;
                      while($data = mysqli_fetch_array($queryKategori)){
                  ?>
                    <tr>
                      <td><?php echo $jumlah ?></td>
                      <td><?php echo $data['nama'] ?></td>
                      <td>
                        <a href="kategori-detail.php?p=<?php echo $data['id']; ?>" 
                           class="btn btn-info btn-sm btn-action">
                          <i class="fas fa-search"></i>
                        </a>
                      </td>
                    </tr>
                  <?php
                    $jumlah++;
                      }
                    }
                  ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>