<?php
  require "session.php";
  require "../koneksi.php";

  $queryKategori = mysqli_query($con,"SELECT * FROM kategori");
  $jumlahKategori = mysqli_num_rows($queryKategori);

  $queryProduk= mysqli_query($con,"SELECT * FROM produk");
  $jumlahProduk = mysqli_num_rows($queryProduk);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
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
        .dashboard-card {
            transition: all 0.3s ease;
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
            border: none;
            border-radius: 15px;
            overflow: hidden;
        }
        .dashboard-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.15);
        }
        .dashboard-card-icon {
            background-color: rgba(255,255,255,0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .dashboard-card-icon i {
            color: white;
            font-size: 4rem;
            opacity: 0.7;
        }
        .gradient-kategori {
            background: linear-gradient(135deg, #11998e, #38ef7d);
        }
        .gradient-produk {
            background: linear-gradient(135deg, #2c3e50, #3498db);
        }
        .welcome-section {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            padding: 30px;
            border-radius: 15px;
            margin-bottom: 30px;
        }
        .breadcrumb {
            background-color: transparent;
            padding: 0;
        }
        .no-decoration {
            text-decoration: none;
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
            }
            .sidebar-menu {
                display: flex;
                flex-wrap: wrap;
                justify-content: space-around;
            }
            .sidebar-menu li {
                margin-bottom: 10px;
            }
        }
    </style>
</head>
<body>
    <?php require "navbar.php"; ?>

    <div class="main-content">
        <div class="container-fluid mt-4">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active" aria-current="page">
                        <i class="fas fa-home me-2"></i>Dashboard
                    </li>
                </ol>
            </nav>

            <div class="welcome-section mb-4">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-center">
                    <div>
                        <h2 class="mb-3">Selamat Datang, <?php echo $_SESSION['username'] ?>!</h2>
                        <p class="mb-0">Dashboard Manajemen Sistem</p>
                    </div>
                    <div class="mt-3 mt-md-0">
                        <i class="fas fa-user-circle fa-3x"></i>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12 col-md-6 mb-4">
                    <div class="card dashboard-card gradient-kategori text-white">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-4 dashboard-card-icon">
                                    <i class="fas fa-list"></i>
                                </div>
                                <div class="col-8">
                                    <h3 class="card-title">Kategori</h3>
                                    <p class="card-text display-6"><?php echo $jumlahKategori ?></p>
                                    <a href="kategori.php" class="text-white no-decoration">
                                        Lihat Detail <i class="fas fa-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-6 mb-4">
                    <div class="card dashboard-card gradient-produk text-white">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-4 dashboard-card-icon">
                                    <i class="fas fa-box"></i>
                                </div>
                                <div class="col-8">
                                    <h3 class="card-title">Produk</h3>
                                    <p class="card-text display-6"><?php echo $jumlahProduk ?></p>
                                    <a href="produk.php" class="text-white no-decoration">
                                        Lihat Detail <i class="fas fa-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Responsive Sidebar Toggle
        function toggleSidebar() {
            const sidebar = document.querySelector('.sidebar');
            const mainContent = document.querySelector('.main-content');
            
            sidebar.classList.toggle('show');
            mainContent.classList.toggle('shifted');
        }
    </script>
</body>
</html>