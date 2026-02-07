<?php
include('koneksi.php');

if (isset($_SESSION['user'])) {
    header("location: index.php");
    exit();
}

if (isset($_POST['login'])) {
    $nama = $_POST['nama'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $alamat = $_POST['alamat'];
    $no_telepon = $_POST['no_telepon'];

    // Validasi nomor telepon (harus angka dan panjang 10-15 digit)
    if (!preg_match('/^[0-9]{10,15}$/', $no_telepon)) {
        echo "<script>alert('Nomor telepon harus berupa angka dan panjangnya antara 10 hingga 15 digit');</script>";
    }
    // Validasi format email
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Format email tidak valid');</script>";
    }
    // Validasi password (minimal 8 karakter)
    elseif (strlen($password) < 8) {
        echo "<script>alert('Password harus minimal 8 karakter');</script>";
    } else {
        // Cek apakah username atau email sudah ada
        $checkUsername = $conn->prepare("SELECT * FROM user WHERE username=?");
        $checkUsername->bind_param("s", $username);
        $checkUsername->execute();
        $resultUsername = $checkUsername->get_result();

        $checkEmail = $conn->prepare("SELECT * FROM user WHERE email=?");
        $checkEmail->bind_param("s", $email);
        $checkEmail->execute();
        $resultEmail = $checkEmail->get_result();

        if ($resultUsername->num_rows > 0) {
            echo "<script>alert('Username sudah digunakan');</script>";
        } elseif ($resultEmail->num_rows > 0) {
            echo "<script>alert('Email sudah digunakan');</script>";
        } else {
            $insert = mysqli_query($conn, "INSERT INTO user (nama, username, password, email, alamat, no_telepon, level, created_at, status) VALUES ('$nama', '$username', '$password', '$email', '$alamat', '$no_telepon', 'peminjam', DATE_FORMAT(NOW(), '%d-%m-%Y'), 'aktif')");
            if ($insert) {
                echo "<script>alert('Register berhasil, silahkan login'); location.href='login.php';</script>";
            } else {
                echo "<script>alert('Register gagal');</script>";
            }
        }
        $checkUsername->close();
        $checkEmail->close();
    }
}

?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="./css/logreg/style.css">
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="css/tail.css">
    <title>Register</title>
    <style>
              /*#message {
  display:none;
  background: #f1f1f1;
  color: #000;
  position: relative;
  padding: 20px;
  margin-top: 10px;
}*/

#message p {
  padding: 10px 13px;
  font-size: 18px;
}

/* Add a green text color and a checkmark when the requirements are right */
.valid {
  color: lightgreen;
}

.valid:before {
  position: relative;
  left: -35px;
  content: "";
}

/* Add a red text color and an "x" icon when the requirements are wrong */
.invalid {
  color: red;
}

.invalid:before {
  position: relative;
  left: -35px;
  content: "";
}
            </style>
</head>
<body style="background-image: url(assets/img/bglog.png); backdrop-filter: brightness(80%); background-repeat: no-repeat; background-size: cover;">
    <div class="container" style="background-color: rgba(0,0,0,0,0.20); backdrop-filter: blur(5px);">
      <center><img src="assets/img/logo.png" alt="Logo" class="w-45 rounded-full"></center><br>
        <form action="" method="POST" class="login-email">
            <p class="login-text" style="font-size: 2rem; font-weight: 800;">Register</p>
            <div class="input-group">
                <input type="text" placeholder="Nama Lengkap" name="nama" required>
            </div>
            <div class="input-group">
                <input type="text" placeholder="Username" name="username" required>
            </div>
            <div class="input-group">
                <input type="password" placeholder="Password" name="password" id="password" required>
                <i class="fa fa-eye" id="eye" style="cursor: pointer;"></i>
                <div id="message">
                  <p id="length" class="invalid">Minimum <b>8 characters</b></p>
                </div>
            </div>
            

            <script>
var myInput = document.getElementById("password");
// var letter = document.getElementById("letter");
// var capital = document.getElementById("capital");
// var number = document.getElementById("number");
var length = document.getElementById("length");

// When the user clicks on the password field, show the message box
// myInput.onfocus = function() {
//   document.getElementById("message").style.display = "block";
// }

// // When the user clicks outside of the password field, hide the message box
// myInput.onblur = function() {
//   document.getElementById("message").style.display = "none";
// }

// When the user starts to type something inside the password field
myInput.onkeyup = function() {
  // Validate lowercase letters
//   var lowerCaseLetters = /[a-z]/g;
//   if(myInput.value.match(lowerCaseLetters)) {
//     letter.classList.remove("invalid");
//     letter.classList.add("valid");
//   } else {
//     letter.classList.remove("valid");
//     letter.classList.add("invalid");
// }

//   // Validate capital letters
//   var upperCaseLetters = /[A-Z]/g;
//   if(myInput.value.match(upperCaseLetters)) {
//     capital.classList.remove("invalid");
//     capital.classList.add("valid");
//   } else {
//     capital.classList.remove("valid");
//     capital.classList.add("invalid");
//   }

//   // Validate numbers
//   var numbers = /[0-9]/g;
//   if(myInput.value.match(numbers)) {
//     number.classList.remove("invalid");
//     number.classList.add("valid");
//   } else {
//     number.classList.remove("valid");
//     number.classList.add("invalid");
//   }

  // Validate length
  if(myInput.value.length >= 8) {
    length.classList.remove("invalid");
    length.classList.add("valid");
  } else {
    length.classList.remove("valid");
    length.classList.add("invalid");
  }
}
</script>
            <div class="input-group">
                <input type="email" placeholder="Email" name="email" required>
            </div>
            <div class="input-group">
                <textarea type="text" placeholder="Alamat" name="alamat" required></textarea>
            </div>
            <div class="input-group">
                <input type="number" placeholder="Nomor Telepon" id="nomer" name="no_telepon" required>
                <div class="message"><br>
                    <center><p id="nlength" class="invalid">Harus 10 -15 angka</p></center>
                </div>
            </div>
            <script>
                var nomer = document.getElementById('nomer');
                var nlength = document.getElementById('nlength');

                nomer.onkeyup = function() {
                    if (nomer.value.length >= 10 && nomer.value.length <= 15 && /^\d+$/.test(nomer.value)) {
                        nlength.classList.remove('invalid');
                        nlength.classList.add('valid');
                    } else {
                        nlength.classList.remove('valid');
                        nlength.classList.add('invalid');
                    }
                }
            </script>
            <div class="input-group">
                <button name="login" class="btn">Register</button>
            </div>
            <p class="login-register-text">Anda sudah punya akun? <a href="login.php">Login</a></p>
        </form>
    </div>

    <!-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script> -->
    <!-- Your custom script -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
    const eyeIcon = document.getElementById('eye');
    const passwordInput = document.getElementById('password');

    eyeIcon.addEventListener('click', function () {
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        this.classList.toggle('fa-eye');
        this.classList.toggle('fa-eye-slash');
    });
});

    </script>

    <script src="https://cdn.rawgit.com/bungfrangki/efeksalju/2a7805c7/efek-salju.js" type="text/javascript"></script>
</body>
</html>