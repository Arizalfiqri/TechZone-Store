<?php
  require "session.php";
  require "../koneksi.php";

  $query = mysqli_query($con,"SELECT a.*, b.nama AS nama_kategori FROM produk a JOIN kategori b ON a.kategori_id = b.id");
  $jumlahProduk = mysqli_num_rows($query);

  $queryKategori = mysqli_query($con,"SELECT * FROM kategori");

  function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
  }
?>  

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
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
        .card-custom {
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            margin-bottom: 20px;
            transition: all 0.3s ease;
        }
        .card-custom:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0,0,0,0.15);
        }
        .form-control, .btn {
            border-radius: 10px;
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
        .no-decoration {
            text-decoration: none;
        }
        .file-upload {
            position: relative;
            overflow: hidden;
        }
        .file-upload input[type=file] {
            position: absolute;
            top: 0;
            right: 0;
            min-width: 100%;
            min-height: 100%;
            text-align: right;
            filter: alpha(opacity=0);
            opacity: 0;
            outline: none;
            background: white;
            cursor: inherit;
            display: block;
        }
        .badge-stock-available {
            background-color: #28a745;
        }
        .badge-stock-empty {
            background-color: #dc3545;
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
                        Produk
                    </li>
                </ol>
            </nav>

            <div class="row">
                <div class="col-12 col-md-6">
                    <div class="card card-custom">
                        <div class="card-body">
                            <h3 class="card-title mb-4">
                                <i class="fas fa-plus-circle me-2"></i>Tambah Produk
                            </h3>
                            <form action="" method="post" enctype="multipart/form-data">
                                <div class="mb-3">
                                    <label for="nama" class="form-label">Nama Produk</label>
                                    <input type="text" id="nama" name="nama" 
                                           placeholder="Masukkan nama produk" 
                                           class="form-control" 
                                           autocomplete="off" required>
                                </div>

                                <div class="mb-3">
                                    <label for="kategori" class="form-label">Kategori</label>
                                    <select name="kategori" id="kategori" class="form-control" required>
                                        <option value="">Pilih Kategori</option>
                                        <?php
                                        while($data = mysqli_fetch_array($queryKategori)){
                                            ?>
                                            <option value="<?php echo $data['id'] ?>">
                                                <?php echo $data['nama'] ?>
                                            </option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="harga" class="form-label">Harga</label>
                                    <div class="input-group">
                                        <span class="input-group-text">Rp</span>
                                        <input type="number" id="harga" name="harga" 
                                               placeholder="Masukkan harga produk" 
                                               class="form-control" 
                                               autocomplete="off" required>
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="foto" class="form-label">Foto Produk</label>
                                    <div class="file-upload form-control">
                                        <input type="file" name="foto" id="foto" 
                                               accept="image/*" 
                                               class="file-input">
                                        <span class="file-input-text">
                                            <i class="fas fa-upload me-2"></i>Pilih Foto
                                        </span>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="detail" class="form-label">Detail Produk</label>
                                    <textarea name="detail" id="detail" 
                                              cols="30" rows="5" 
                                              class="form-control" 
                                              placeholder="Masukkan detail produk"></textarea>
                                </div>

                                <div class="mb-3">
                                    <label for="ketersedian_st ok" class="form-label">Stok</label>
                                    <select name="ketersedian_stok" id="ketersedian_stok" class="form-control">
                                        <option value="tersedia">Tersedia</option>
                                        <option value="habis">Habis</option>
                                    </select>
                                </div>  

                                <div class="mt-3">
                                    <button class="btn btn-primary" type="submit" name="simpan">Simpan</button>
                                </div>
                            </form>

                            <?php 
                            if(isset($_POST['simpan'])){
                                $nama = htmlspecialchars($_POST['nama']);
                                $kategori = htmlspecialchars($_POST['kategori']);
                                $harga = htmlspecialchars($_POST['harga']);
                                $detail = htmlspecialchars($_POST['detail']);
                                $ketersedian_stok = htmlspecialchars($_POST['ketersedian_stok']);

                                $target_dir = "../image/";
                                $nama_file = basename($_FILES['foto']['name']);
                                $target_file = $target_dir . $nama_file;
                                $imageFileType = strtolower(pathinfo($nama_file,PATHINFO_EXTENSION));
                                $image_size = $_FILES['foto']['size'];
                                $random_name = generateRandomString(20);
                                $new_name = $random_name . '.' . $imageFileType;
                                
                                if($nama == '' || $kategori == '' || $harga == ''){
                                    ?>
                                    <div class="alert alert-warning mt-3" role="alert">
                                        Silahkan isi Nama, Kategori, dan Harga
                                    </div>
                                    <?php
                                }
                                else{
                                    if($nama_file !== ''){
                                        if($image_size > 1000000){
                                            ?>
                                            <div class="alert alert-warning mt-3" role="alert">
                                                Ukuran File Tidak Boleh Lebih Dari 1MB
                                            </div>
                                            <?php
                                        }
                                        else{
                                            if($imageFileType != 'jpg' && $imageFileType != 'png' && $imageFileType != 'jpeg' && $imageFileType != 'gif'){
                                                ?>
                                                <div class="alert alert-warning mt-3" role="alert">
                                                    Format File Harus jpg, png, jpeg, atau gif
                                                </div>
                                                <?php
                                            }
                                            else{
                                                move_uploaded_file($_FILES['foto']['tmp_name'], $target_dir . $new_name);
                                            }
                                        }
                                    }
                                    // query insert to table produk
                                    $queryTambah = mysqli_query($con,"INSERT INTO produk(kategori_id,nama, harga, foto, detail, ketersedian_stok) VALUES($kategori,'$nama',$harga,'$new_name','$detail','$ketersedian_stok')");

                                    if($queryTambah){
                                        ?>
                                        <div class="alert alert-success mt-3" role="alert">
                                            Data Berhasil Disimpan
                                        </div>

                                        <meta http-equiv="refresh" content="1;url=produk.php" />
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

                <div class="col-12">
                    <h2>List Produk</h2>
                    <div class="table-responsive mt-5">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nama</th>
                                    <th>Kategori</th>
                                    <th>Harga</th>
                                    <th>Stok</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if($jumlahProduk == 0){
                                    ?>
                                    <tr>
                                        <td colspan=6 class="text-center">Data Produk Tidak Tersedia</td>
                                    </tr>
                                    <?php
                                }
                                else{
                                    $jumlah = 1;
                                    while($data = mysqli_fetch_array($query)){
                                ?>
                                    <tr>
                                        <td><?php echo $jumlah++ ?></td>
                                        <td><?php echo $data['nama'] ?></td>
                                        <td><?php echo $data['nama_kategori'] ?></td>
                                        <td><?php echo $data['harga'] ?></td>
                                        <td>
                                            <span class="badge <?php echo $data['ketersedian_stok'] == 'tersedia' ? 'badge-stock-available' : 'badge-stock-empty'; ?>">
                                                <?php echo ucfirst($data['ketersedian_stok']); ?>
                                            </span>
                                        </td>
                                        <td>
                                            <a href="produk-detail.php?p=<?php echo $data['id']; ?>" class="btn btn-info">
                                                <i class="fas fa-search"></i>
                                            </a </td>
                                    </tr>
                                <?php
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../fontawesome/js/all.min.js"></script>
</body>
</html>