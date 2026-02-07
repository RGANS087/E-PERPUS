<?php
include('koneksi.php');

if (isset($_SESSION['user'])) {
    header("location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reset'])) {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (empty($email) || empty($password)) {
        echo "<script>alert('Email dan password tidak boleh kosong!'); window.history.back();</script>";
        exit();
    }

    // Cek apakah email ada dalam database
    $query = $conn->prepare("SELECT * FROM user WHERE email = ?");
$query->bind_param("s", $email);
$query->execute();
$result = $query->get_result();
$user = $result->fetch_assoc();


    if ($user) {
        // Update password tanpa hashing
        $update = $conn->prepare("UPDATE user SET password = ? WHERE email = ?");
        $update->execute([$password, $email]);
        echo "<script>alert('Password berhasil direset!'); window.location='login.php';</script>";
    } else {
        echo "<script>alert('Email tidak ditemukan!'); window.history.back();</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Reset Password - Perpustakaan Digital</title>
    <link rel="stylesheet" href="css/tail.css">
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <style>
        .glass {
            background: rgba(255, 255, 255, 0.15);
            border-radius: 16px;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(7px);
            -webkit-backdrop-filter: blur(7px);
        }
        #eye {
            position: absolute;
            right: 20px;
            top: 70%;
            transform: translateY(-50%);
            cursor: pointer;
            color: white;
        }
    </style>
</head>
<body>
<div class="min-h-screen flex items-center bg-[url('./assets/img/bglog.png')] bg-no-repeat bg-cover justify-center bg-gray-100 p-4">
    <div class="max-w-md w-full bg-white rounded-xl shadow-lg p-8 glass">
        <h2 class="text-2xl font-bold text-white text-center mb-6">Reset Password</h2>
        <form method="post" class="space-y-4" onsubmit="return validateForm()">
            <div>
                <label class="block text-lg font-medium text-white mb-1">Email</label>
                <input type="email" id="email" name="email" class="w-full px-4 py-2 border rounded-lg" placeholder="your@email.com" required />
            </div>
            <div class="relative">
                <label class="block text-lg font-medium text-white mb-1">Password</label>
                <input type="password" id="password" name="password" class="w-full px-4 py-2 border rounded-lg" placeholder="••••••••" required />
                <i class="fa fa-eye" id="eye" onclick="togglePassword()"></i>
            </div>
            <button type="submit" name="reset" class="w-full bg-indigo-600 text-white py-2.5 rounded-lg hover:cursor-pointer">Reset</button>
        </form>
    </div>
</div>

<script>
    function togglePassword() {
        let input = document.getElementById("password");
        let eyeIcon = document.getElementById("eye");
        if (input.type === "password") {
            input.type = "text";
            eyeIcon.classList.replace("fa-eye", "fa-eye-slash");
        } else {
            input.type = "password";
            eyeIcon.classList.replace("fa-eye-slash", "fa-eye");
        }
    }

    function validateForm() {
        let email = document.getElementById("email").value.trim();
        let password = document.getElementById("password").value.trim();

        if (email === "" || password === "") {
            alert("Email dan password tidak boleh kosong!");
            return false;
        }

        return true;
    }
</script>
</body>
</html>
