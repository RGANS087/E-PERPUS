<?php
$id = intval($_GET['id']);

// Cek apakah buku masih dipinjam
$cekPeminjaman = mysqli_query($conn, "SELECT * FROM peminjaman WHERE id_buku=$id");
if (mysqli_num_rows($cekPeminjaman) > 0) {
    echo "<script>alert('Hapus gagal, buku masih dipinjam'); location.href='index.php?page=buku';</script>";
    exit();
}

// Hapus ulasan terkait dengan buku
mysqli_query($conn, "DELETE FROM ulasan WHERE id_buku=$id");

// Hapus buku setelah data terkait dihapus
$query = mysqli_query($conn, "DELETE FROM buku WHERE id_buku=$id");

if ($query) {
    echo "<script>alert('Hapus data berhasil'); location.href='index.php?page=buku';</script>";
} else {
    echo "<script>alert('Hapus gagal: " . mysqli_error($conn) . "');</script>";
}
?>
