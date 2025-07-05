<?php
    require "session.php";
    require "../koneksi.php";

    $id = $_GET["p"];

    $query = mysqli_query($con,"SELECT a.*, b.nama AS nama_kategori FROM produk a JOIN kategori b ON a.kategori_id = b.id WHERE a.id='$id' ");
    $data = mysqli_fetch_array($query);

    $queryKategori = mysqli_query($con,"SELECT * FROM kategori WHERE id != '$data[kategori_id]'");
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
    <title>Produk Detail</title>
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
        .form-control, .btn {
            border-radius: 10px;
        }
        .product-image {
            max-width: 100%;
            height: auto;
            border-radius: 15px;
            transition: transform 0.3s ease;
        }
        .btn-action {
            margin-right: 10px;
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
                        <a href="../adminpanel" class="text-muted text-decoration-none">
                            <i class="fas fa-home"></i> Home
                        </a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="produk.php" class="text-muted text-decoration-none">
                            Produk
                        </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Detail Produk
                    </li>
                </ol>
            </nav>

            <div class="row">
                <div class="col-12 col-md-8 offset-md-2">
                    <div class="card card-custom">
                        <div class="card-body">
                            <h2 class="card-title mb-4 text-center">
                                <i class="fas fa-box-open me-2"></i>Detail Produk
                            </h2>
                            <form action="" method="post" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-12 col-md-6 mb-3">
                                        <label for="nama" class="form-label">Nama Produk</label>
                                        <input type="text" id="nama" name="nama" 
                                               value="<?php echo $data['nama']; ?>" 
                                               class="form-control" 
                                               autocomplete="off" required>
                                    </div>

                                    <div class="col-12 col-md-6 mb-3">
                                        <label for="kategori" class="form-label">Kategori</label>
                                        <select name="kategori" id="kategori" class="form-control" required>
                                            <option value="<?php echo $data['kategori_id']; ?>">
                                                <?php echo $data['nama_kategori'] ?>
                                            </option>
                                            <?php
                                            while($dataKategori = mysqli_fetch_array($queryKategori)){
                                                ?>
                                                <option value="<?php echo $dataKategori['id'] ?>">
                                                    <?php echo $dataKategori['nama'] ?>
                                                </option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="col-12 col-md-6 mb-3">
                                        <label for="harga" class="form-label">Harga</label>
                                        <div class="input-group">
                                            <span class="input-group-text">Rp</span>
                                            <input type="number" id="harga" name="harga" 
                                                   value="<?php echo $data['harga']; ?>" 
                                                   class="form-control" 
                                                   autocomplete="off" required>
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-6 mb-3">
                                        <label for="ketersedian_stok" class="form-label">Stok</label>
                                        <select name="ketersedian_stok" id="ketersedian_stok" class="form-control">
                                            <option value="<?php echo $data['ketersedian_stok'] ?>">
                                                <?php echo ucfirst($data['ketersedian_stok']) ?>
                                            </option>
                                            <?php
                                            if($data['ketersedian_stok'] == 'tersedia'){
                                                ?>
                                                <option value="habis">Habis</option>
                                                <?php
                                            }
                                            else{
                                                ?>
                                                <option value="tersedia">Tersedia</option>
                 <?php
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="col-12 mb-3">
                                        <label for="currentFoto" class="form-label">Foto Produk Saat Ini</label>
                                        <img src="../image/<?php echo $data['foto']; ?>" alt="Foto Produk" class="product-image">
                                    </div>

                                    <div class="col-12 mb-3">
                                        <label for="foto" class="form-label">Foto Baru</label>
                                        <input type="file" name="foto" id="foto" class="form-control">
                                    </div>

                                    <div class="col-12 mb-3">
                                        <label for="detail" class="form-label">Detail Produk</label>
                                        <textarea name="detail" id="detail" cols="30" rows="5" class="form-control">
                                            <?php echo $data['detail']; ?>
                                        </textarea>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-between mt-3">
                                    <button class="btn btn-primary" type="submit" name="simpan">Update</button>
                                    <button class="btn btn-danger" type="submit" name="hapus">Hapus</button>
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
                                $imageFileType = strtolower(pathinfo($nama_file, PATHINFO_EXTENSION));
                                $image_size = $_FILES['foto']['size'];
                                $random_name = generateRandomString(20);
                                $new_name = $random_name . '.' . $imageFileType;

                                if($nama == '' || $kategori == '' || $harga == ''){
                                    ?>
                                    <div class="alert alert-warning mt-3" role="alert">
                                        Silahkan isi Nama, Kategori, dan Harga
                                    </div>
                                    <?php
                                } else {
                                    $queryUpdate = mysqli_query($con, "UPDATE produk SET kategori_id='$kategori', nama='$nama', harga='$harga', detail='$detail', ketersedian_stok='$ketersedian_stok' WHERE id='$id'");

                                    if($nama_file != ''){
                                        if($image_size > 1000000){
                                            ?>
                                            <div class="alert alert-warning mt-3" role="alert">
                                                Ukuran File Tidak Boleh Lebih Dari 1MB
                                            </div>
                                            <?php
                                        } else {
                                            if($imageFileType != 'jpg' && $imageFileType != 'png' && $imageFileType != 'jpeg' && $imageFileType != 'gif'){
                                                ?>
                                                <div class="alert alert-warning mt-3" role="alert">
                                                    Format File Harus jpg, png, jpeg, atau gif
                                                </div>
                                                <?php
                                            } else {
                                                move_uploaded_file($_FILES['foto']['tmp_name'], $target_dir . $new_name);
                                                $queryUpdate = mysqli_query($con, 'UPDATE produk SET foto="'.$new_name.'" WHERE id="'.$id.'"');

                                                if($queryUpdate){
                                                    ?>
                                                    <div class="alert alert-primary mt-3" role="alert">
                                                        Produk Berhasil DiUpdate
                                                    </div>
                                                    <meta http-equiv="refresh" content="1;url=produk.php" />
                                                    <?php
                                                } else {
                                                    echo mysqli_error($con);
                                                }
                                            }
                                        }
                                    }
                                }
                            }

                            if(isset($_POST["hapus"])){
                                $queryHapus = mysqli_query($con, "DELETE FROM produk WHERE id='$id'");

                                if($queryHapus){
                                    ?>
                                    <div class="alert alert-primary mt-3" role="alert">
                                        Produk Berhasil Dihapus!
                                    </div>
                                    <meta http-equiv="refresh" content="1; url=produk.php" />
                                    <?php
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../fontawesome/js/all.min.js"></script>
</body>
</html>