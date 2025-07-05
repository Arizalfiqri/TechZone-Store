<?php
  require "session.php";
  require "../koneksi.php";

  $id = $_GET["p"];

  $query = mysqli_query($con,"SELECT * FROM kategori WHERE id = '$id'");
  $data = mysqli_fetch_array($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Kategori</title>
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
        .btn-action {
            margin-right: 10px;
            transition: all 0.3s ease;
        }
        .btn-action:hover {
            transform: scale(1.05);
        }
        .alert-custom {
            border-radius: 10px;
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
                        <a href="kategori.php" class="text-muted text-decoration-none">
                            Kategori
                        </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Detail Kategori
                    </li>
                </ol>
            </nav>

            <div class="row justify-content-center">
                <div class="col-12 col-md-6">
                    <div class="card card-custom">
                        <div class="card-body">
                            <h2 class="card-title text-center mb-4">
                                <i class="fas fa-list-alt me-2"></i>Detail Kategori
                            </h2>
                            <form action="" method="post">
                                <div class="mb-3">
                                    <label for="kategori" class="form-label">Nama Kategori</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-tag"></i></span>
                                        <input type="text" 
                                               name="kategori" 
                                               id="kategori" 
                                               class="form-control" 
                                               value="<?php echo $data['nama']; ?>" 
                                               required>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-between mt-4">
                                    <button class="btn btn-primary btn-action" type="submit" name="editBtn">
                                        <i class="fas fa-edit me-2"></i>Edit
                                    </button>
                                    <button class="btn btn-danger btn-action" type="submit" name="deleteBtn">
                                        <i class="fas fa-trash me-2"></i>Delete
                                    </button>
                                </div>
                            </form>

                            <?php
                            if(isset($_POST['editBtn'])){
                                $kategori = htmlspecialchars($_POST['kategori']);
                                if($data['nama'] == $kategori){
                                    ?>
                                    <meta http-equiv="refresh" content="1; url=kategori.php" />
                                    <?php
                                } else {
                                    $query = mysqli_query($con,"SELECT nama FROM kategori WHERE nama='$kategori'");
                                    $jumlahData = mysqli_num_rows($query);
                                    
                                    if($jumlahData > 0){
                                        ?>
                                        <div class="alert alert-warning mt-3 alert-custom" role="alert">
                                            <i class="fas fa-exclamation-triangle me-2"></i>
                                            Kategori sudah ada!
                                        </div>
                                        <?php
                                    } else {
                                        $querySimpan = mysqli_query($con,"UPDATE kategori SET nama='$kategori' WHERE id='$id'");
                                        if($querySimpan){
                                            ?>
                                            <div class="alert alert-success mt-3 alert-custom" role="alert">
                                                <i class="fas fa-check-circle me-2"></i>
                                                Kategori Berhasil Diupdate!
                                            </div>
                                            <meta http-equiv="refresh" content="1; url=kategori.php" />
                                            <?php
                                        } else {
                                            echo mysqli_error($con);
                                        }
                                    }
                                }
                            }

                            if(isset($_POST["deleteBtn"])){
                                $queryCheck = mysqli_query($con,"SELECT * FROM produk WHERE kategori_id='$id'");
                                $dataCount = mysqli_num_rows($queryCheck);
                                if($dataCount > 0){
                                    ?>
                                    <div class="alert alert-warning mt-3 alert-custom" role="alert">
                                        <i class="fas fa-exclamation-circle me-2"></i>
                                        Kategori tidak bisa dihapus karena masih ada produk yang menggunakan kategori ini!
                                    </div>
                                    <?php
                                    die();
                                }

                                $queryDelete = mysqli_query($con,"DELETE FROM kategori WHERE id='$id'");
                                if($queryDelete){
                                    ?>
                                    <div class="alert alert-success mt-3 alert-custom" role="alert">
                                        <i class="fas fa-check-circle me-2"></i>
                                        Kategori Berhasil Dihapus!
                                    </div>
                                    <meta http-equiv="refresh" content=" 1; url=kategori.php" />
                                    <?php
                                } else {
                                    echo mysqli_error($con);
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