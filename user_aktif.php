<?php
if ($_SESSION['user']['level'] != 'admin') {
    echo "<script>alert('Anda tidak memiliki akses!'); window.location.href='index.php';</script>";
    exit();
}

if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "<script>alert('ID tidak ditemukan!'); window.location.href='?page=anggota';</script>";
    exit();
}

$id = $_GET['id'];

// Update status menjadi aktif
$query = $conn->prepare("UPDATE user SET status='aktif' WHERE id_user=?");
$query->bind_param("i", $id);

if ($query->execute()) {
    echo "<script>alert('Pengguna berhasil diaktifkan kembali!'); window.location.href='?page=anggota';</script>";
} else {
    echo "<script>alert('Gagal mengaktifkan pengguna!'); window.location.href='?page=anggota';</script>";
}
?>
