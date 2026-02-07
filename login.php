<?php
include('koneksi.php');

if (isset($_SESSION['user'])) {
    header("location: index.php");
    exit();
}

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = mysqli_query($conn, "SELECT * FROM user WHERE email='$email' AND password='$password'");
    $user = mysqli_fetch_assoc($query);

    if ($user) {
        if ($user['status'] != 'aktif') {
            echo '<script>alert("Akun Anda sedang diblokir, silakan hubungi admin."); location.href="login.php";</script>';
            exit();
        }

        $_SESSION['user'] = $user;
        echo '<script>alert("Selamat datang"); location.href="index.php";</script>';
    } else {
        echo '<script>alert("Maaf, email atau password salah");</script>';
    }
}
?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Login - Perpustakaan Digital</title>
        <!-- <link href="css/styles.css" rel="stylesheet" /> -->
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="css/tail.css">
        <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
        <style type="text/css">
            .glass {
                background: rgba(255, 255, 255, 0.15);
                border-radius: 16px;
                box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
                backdrop-filter: blur(7px);
                -webkit-backdrop-filter: blur(7px);
/*                border: 1px solid rgba(255, 255, 255, 0.3);*/
            }
        </style>
    </head>
    <body>
        <!-- component -->
<div class="min-h-screen bg-[url('./assets/img/bglog.png')] bg-no-repeat bg-cover bg-gray-100 flex items-center justify-center p-4">
  <div class="max-w-md w-full bg-white rounded-xl shadow-lg p-8 glass drop-shadow-xl">
    <center><img src="assets/img/logo.png" class="rounded-full mb-8 w-50" alt="logo"></center>
    <h2 class="text-2xl font-bold text-white drop-shadow-lg mb-6 text-center">Sign In</h2>
    
    <form class="space-y-4" method="post">
      <div>
        <label class="block text-lg font-medium text-white drop-shadow-lg mb-1">Email</label>
        <input 
          type="email" 
          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all placeholder:text-white focus:text-white text-gray-400"
          placeholder="your@email.com"
          name="email" 
          required
        />
      </div>

      <div>
        <label class="block text-lg font-medium text-white drop-shadow-lg mb-1">Password</label>
        <input 
          type="password" 
          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all placeholder:text-white focus:text-white text-indigo-100"
          placeholder="••••••••"
          id="myInput" 
          name="password"
          required
        />
        <i class="fa fa-eye" id="eye" onclick="passFunc()"></i>
      </div>

      <style>
          #eye {
    position: absolute;
    right: 48px;
    top: 75%;
    transform: translateY(-50%);
    color: white; /* Ubah warna sesuai kebutuhan */
}

#eye:active, #eye:hover {
    color: #a29bfe;
}
      </style>

      <script>
          function passFunc() {
  var x = document.getElementById("myInput");
  var eye = document.getElementById("eye");
  if (x.type === "password") {
    x.type = "text";
    eye.classList.add("fa-eye-slash");
  } else {
    x.type = "password";
    eye.classList.add("fa-eye");
  }
} 
      </script>

      <button class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2.5 rounded-lg transition-colors hover:cursor-pointer" name="login">
        Sign In
      </button>
    </form>

    <div class="mt-6 text-sm text-white flex justify-between">
      <p>Don't have an account? 
      <a href="register.php" class="text-indigo-300 hover:text-indigo-200 font-medium">Sign up</a></p>
      <a href="forgot.php" class="text-indigo-300 hover:text-indigo-200">Forgot password?</a>
    </div>
  </div>
</div>
    </body>
</html>
