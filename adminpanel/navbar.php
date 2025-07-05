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
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background: linear-gradient(135deg, #2c3e50, #3498db);
            color: white;
            padding-top: 30px;
            transition: all 0.3s;
        }
        .sidebar-logo {
            font-size: 24px;
            font-weight: bold;
            text-align: center;
            margin-bottom: 30px;
            color: white;
        }
        .sidebar-menu {
            list-style: none;
            padding: 0;
        }
        .sidebar-menu li {
            margin-bottom: 10px;
        }
        .sidebar-menu li a {
            color: rgba(255,255,255,0.7);
            text-decoration: none;
            display: block;
            padding: 10px 20px;
            border-radius: 5px;
            transition: all 0.3s;
        }
        .sidebar-menu li a:hover {
            background-color: rgba(255,255,255,0.1);
            color: white;
        }
        .sidebar-menu li a.active {
            background-color: rgba(255,255,255,0.2);
            color: white;
        }
        .sidebar-menu li a i {
            margin-right: 10px;
        }
        .main-content {
            margin-left: 250px;
            padding: 20px;
            transition: all 0.3s;
        }
        .welcome-section {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            padding: 30px;
            border-radius: 15px;
            margin-bottom: 30px;
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
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-logo">
            TechZone Store
        </div>
        <ul class="sidebar-menu">
            <li>
                <a href="../adminpanel" class="active">
                    <i class="fas fa-home"></i> Dashboard
                </a>
            </li>
            <li>
                <a href="kategori.php">
                    <i class="fas fa-list"></i> Kategori
                </a>
            </li>
            <li>
                <a href="produk.php">
                    <i class="fas fa-box"></i> Produk
                </a>
            </li>
            <li>
                <a href="logout.php">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </li>
        </ul>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>