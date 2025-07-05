<?php
session_start();
require "../koneksi.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<style>
@import url("https://fonts.googleapis.com/css2?family=Open+Sans:wght@200;300;400;500;600;700&display=swap");

* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: "Open Sans", sans-serif;
}

body {
  display: flex;
  align-items: center;
  justify-content: center;
  min-height: 100vh;
  width: 100%;
  padding: 0 10px;
  background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('../image/bgloginstore.jpg') no-repeat center center;
  background-size: cover;
}

.wrapper {
  width: 400px;
  padding: 30px;
  text-align: center;
  border-radius: 8px;
  border: 1px solid rgba(255, 255, 255, 0.5);
  backdrop-filter: blur(8px);
  -webkit-backdrop-filter: blur(8px);
}

form {
  display: flex;
  flex-direction: column;
}

h2 {
  font-size: 2rem;
  margin-bottom: 20px;
  color: #fff;
}

.input-field {
  position: relative;
  border-bottom: 2px solid #ccc;
  margin: 20px 0;
  display: flex;
  align-items: center;
}

.input-field i {
  color: #fff;
  margin-right: 10px;
}

.input-field input {
  width: 100%;
  height: 40px;
  background: transparent;
  border: none;
  outline: none;
  font-size: 16px;
  color: #fff;
}

.input-field label {
  position: absolute;
  top: 50%;
  left: 40px;
  transform: translateY(-50%);
  color: #fff;
  font-size: 16px;
  pointer-events: none;
  transition: 0.2s ease;
}

.input-field input:focus~label,
.input-field input:valid~label {
  font-size: 0.8rem;
  top: 10px;
  left: 40px;
  transform: translateY(-120%);
}

button {
  background: #fff;
  color: #000;
  font-weight: 600;
  border: none;
  padding: 12px 20px;
  cursor: pointer;
  border-radius: 3px;
  font-size: 16px;
  border: 2px solid transparent;
  transition: 0.3s ease;
}

button:hover {
  color: #fff;
  border-color: #fff;
  background: rgba(255, 255, 255, 0.15);
}

.wrapper a {
  color: #efefef;
  text-decoration: none;
  margin-top: 10px;
}

.wrapper a:hover {
  text-decoration: underline;
}
</style>

<body>
  <div>
    <div class="wrapper">
      <form action="" method="post">
        <h2>Login</h2>
          <div class="input-field">
            <i class="fas fa-envelope"></i>
            <input type="text" name="username" autocomplete="off" required>
            <label>Enter your email</label>
          </div>
          <div class="input-field">
            <i class="fas fa-lock"></i>
            <input type="password" name="password" required>
            <label>Enter your password</label>
          </div>
          <button type="submit" name="loginbtn">Log In</button>
      </form>
    </div>

    <div class="mt-5">
      <?php
        if (isset($_POST['loginbtn'])) {
          $username = htmlspecialchars($_POST['username']);
          $password = htmlspecialchars($_POST['password']);

          $query = mysqli_query($con, "SELECT * FROM users WHERE username='$username'");
          $countdata = mysqli_num_rows($query);
          $data = mysqli_fetch_array($query);

          if ($countdata > 0) {
            if (password_verify($password, $data['password'])) {
              $_SESSION['username'] = $data['username'];
              $_SESSION['login'] = true;
              header('location: index.php');
            } else {
              echo '<div class="alert alert-warning" role="alert">Password Salah!</div>';
            }
          } else {
            echo '<div class="alert alert-warning" role="alert">Sorry Akun Gak Ada!</div>';
          }
        }
      ?>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
