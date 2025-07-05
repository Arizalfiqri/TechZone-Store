<?php
require 'koneksi.php'; // Pastikan koneksi ke database

// Proses registrasi
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register'])) {
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $no_hp = $_POST['no_hp'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Periksa apakah email sudah terdaftar
    $checkEmail = mysqli_query($con, "SELECT * FROM customer WHERE email = '$email'");
    if (mysqli_num_rows($checkEmail) > 0) {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Email sudah terdaftar! Silakan gunakan email lain.'
                });
            });
        </script>";
    } else {
        // Simpan data ke database
        $query = mysqli_query($con, "INSERT INTO customer (nama, email, no_hp, password) VALUES ('$nama', '$email', '$no_hp', '$password')");
        if ($query) {
            echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'success',
                        title: 'Registrasi Berhasil!',
                        text: 'Silakan login untuk melanjutkan.',
                        showConfirmButton: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = 'login.php';
                        }
                    });
                });
            </script>";
        } else {
            echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Registrasi gagal! Silakan coba lagi.'
                    });
                });
            </script>";
        }
    }
}
?>

<html lang="en">
 <head>
  <meta charset="utf-8"/>
  <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
  <title>
   Create an Account
  </title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&amp;display=swap" rel="stylesheet"/>
  <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">

  <style>
    /* Reset dan Layout Dasar */
    body, html {
        margin: 0;
        padding: 0;
        font-family: 'Roboto', sans-serif;
        background-color: #3b3b58;
        color: #fff;
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        width: 100%;
    }

    /* Container Utama */
    .container {
        display: flex;
        width: 90%;
        max-width: 1200px;
        background-color: #2c2c3e;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.4);
        perspective: 1000px;
        flex-direction: column;
    }

    @media (min-width: 768px) {
        .container {
            flex-direction: row;
            width: 80%;
        }
    }

    /* Bagian Kiri */
    .left {
        flex: 1;
        background-color: #1e1e2e;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        padding: 15px;
        transform: translateZ(-50px);
    }

    .left img {
        width: 100%;
        height: auto;
        max-height: 300px;
        object-fit: cover;
        border-radius: 10px;
    }

    @media (min-width: 768px) {
        .left img {
            max-height: 500px;
        }
    }

    .left .logo {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
    }

    .left .logo button {
        background-color: #4a4a6a;
        border: none;
        color: #fff;
        padding: 8px 16px;
        border-radius: 5px;
        cursor: pointer;
        transition: all 0.3s ease;
        font-size: 14px;
    }

    @media (min-width: 768px) {
        .left .logo button {
            padding: 10px 20px;
            font-size: 16px;
        }
    }

    .left .logo button:hover {
        background-color: #6a5acd;
        transform: translateX(5px);
    }

    .left .caption {
        text-align: center;
        margin-top: 15px;
        opacity: 0.7;
        font-size: 14px;
    }

    /* Bagian Kanan */
    .right {
        flex: 1;
        padding: 20px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        background-color: #2c2c3e;
        transform: translateZ(50px);
    }

    @media (min-width: 768px) {
        .right {
            padding: 40px;
        }
    }

    .right h2 {
        font-size: 1.5em;
        margin-bottom: 20px;
        color: #6a5acd;
    }

    @media (min-width: 768px) {
        .right h2 {
            font-size: 2em;
        }
    }

    .right form {
        display: flex;
        flex-direction: column;
        width: 100%;
    }

    .right form input {
        background-color: #3b3b58;
        border: 2px solid transparent;
        padding: 12px;
        margin-bottom: 12px;
        border-radius: 8px;
        color: #fff;
        transition: all 0.3s ease;
        font-size: 14px;
    }

    @media (min-width: 768px) {
        .right form input {
            padding: 15px;
            margin-bottom: 15px;
            font-size: 16px;
        }
    }

    .right form input:focus {
        outline: none;
        border-color: #6a5acd;
        box-shadow: 0 0 15px rgba(106, 90, 205, 0.3);
    }

    .right form label {
        display: flex;
        align-items: center;
        margin-bottom: 15px;
        font-size: 14px;
    }

    .right form input[type="checkbox"] {
        width: auto;
        margin-right: 8px;
    }

    /* Tombol */
    .right form button,
    .right .btn-secondary {
        position: relative;
        overflow: hidden;
        transition: all 0.4s ease;
        font-size: 14px;
    }

    @media (min-width: 768px) {
        .right form button,
        .right .btn-secondary {
            font-size: 16px;
        }
    }

    .right form button {
        background-color: #6a5acd;
        border: none;
        padding: 12px;
        border-radius: 8px;
        color: #fff;
        cursor: pointer;
        margin-bottom: 15px;
    }

    .right .btn-secondary {
        background-color: #4a4a6a;
        border: none;
        padding: 12px;
        border-radius: 8px;
        color: white;
        cursor: pointer;
        width: 100%;
    }

    .right form button:hover,
    .right .btn-secondary:hover {
        background-color: #5a4acd;
    }

    /* Animasi */
    @keyframes fadeInRight {
        from {
            opacity: 0;
            transform: translateX(-20px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    .right {
        animation: fadeInRight 0.7s ease forwards;
        opacity: 0;
        animation-delay: 0.2s;
    }

    /* Additional Mobile Optimizations */
    @media (max-width: 480px) {
        .container {
            width: 95%;
            margin: 10px;
        }
        
        .right {
            padding: 15px;
        }
        
        .left .caption {
            display: none;
        }
        
        .right h2 {
            font-size: 1.3em;
            margin-bottom: 15px;
        }
        
        .right form input,
        .right form button,
        .right .btn-secondary {
            padding: 10px;
            font-size: 14px;
        }
    }
    </style>
 </head>
 <body>
  <div class="container">
   <div class="left">
    <img alt="Desert landscape with a purple sky" height="500" src="https://storage.googleapis.com/a1aa/image/aM8hUt9AXD4yL1wy0f2RIF6fvyepKWAy10zBH4anxRUkK1BoA.jpg" width="500"/>
    <div class="caption">
     <p>
      Capturing Moments, Creating Memories
     </p>
    </div>
   </div>
   <div class="right">
            <h2>Create an Account</h2>
            <p>Already have an account? <a href="login.php" style="color: #6a5acd;">Log in</a></p>
            <form method="POST">
                <input placeholder="Your Name" type="text" name="nama" required />
                <input placeholder="Your Phone" type="number" name="no_hp" required />
                <input placeholder="Email" type="email" name="email" required />
                <input placeholder="Enter Your Password" type="password" name="password" required />
                <label>
                    <input type="checkbox" required />
                    I agree to the <a href="#" style="color: #6a5acd;">Terms &amp; Conditions</a>
                </label>
                <button type="submit" name="register">Register</button>
            </form>
   </div>
  </div>

      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>


 </body>
</html>
