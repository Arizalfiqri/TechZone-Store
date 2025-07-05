<?php
require 'koneksi.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = mysqli_query($con, "SELECT * FROM customer WHERE email = '$email'");
    $user = mysqli_fetch_assoc($query);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['customer_id'] = $user['id'];
        $_SESSION['customer_name'] = $user['nama'];
        header("Location: produk.php");
    } else {
        echo "<script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Email atau Password salah!.'
            });
        });
    </script>";
    }
}
?>

<html lang="en">
 <head>
  <meta charset="utf-8"/>
  <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
  <title>
   Login an Account
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
    <div class="logo">

  <a href="index.php" text-decoration="none">
    <button>
          Back to website
        <i class="fas fa-arrow-right">
        </i>
    </button>
  </a>  
    </div>
    <img alt="Desert landscape with a purple sky" height="500" src="https://storage.googleapis.com/a1aa/image/aM8hUt9AXD4yL1wy0f2RIF6fvyepKWAy10zBH4anxRUkK1BoA.jpg" width="500"/>
    <div class="caption">
     <p>
      Capturing Moments, Creating Memories
      </p>
      </div>
    </div>
    <div class="right">
        <h2>
            Login account
        </h2>
        <form method="POST">
            <input placeholder="Email" type="email" name="email" required />
            <input placeholder="Enter your password" type="password" name="password" required />
            <label>
                <input type="checkbox" required />
                I agree to the
                <a href="#" style="color: #6a5acd;">
                    Terms &amp; Conditions
                </a>
            </label>
            <button type="submit" name="login" class="btn btn-primary">Login</button>
        </form>
        <p>
            Don't have an account?
        </p>
        <a href="register.php" style="text-decoration: none;">
            <button class="btn btn-secondary" style="background-color: #4a4a6a; border: none; padding: 15px; border-radius: 5px; color: white; cursor: pointer; width: 100%;">Daftar</button>
        </a>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>


 </body>
</html>
