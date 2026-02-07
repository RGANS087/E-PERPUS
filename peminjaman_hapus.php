<?php
if ($_SESSION['user']['level'] != 'peminjam') {
    $page_pinjam = 'peminjaman_admin';
} else {
    $page_pinjam = 'peminjaman';
}
$id = $_GET['id'];

// Ambil id_buku dari peminjaman sebelum dihapus
$query_buku = mysqli_query($conn, "SELECT id_buku FROM peminjaman WHERE id_peminjaman='$id'");
$data_buku = mysqli_fetch_assoc($query_buku);

if ($data_buku) {
    $id_buku = $data_buku['id_buku'];

    // Tambahkan stok buku
    mysqli_query($conn, "UPDATE buku SET stok = stok + 1 WHERE id_buku='$id_buku'");

    // Hapus data peminjaman
    $query = mysqli_query($conn, "DELETE FROM peminjaman WHERE id_peminjaman='$id'");

    if ($query) {
        echo "<script>
            alert('Hapus data berhasil');
            location.href='index.php?page=$page_pinjam';
        </script>";
    } else {
        echo "<script>
            alert('Gagal menghapus data');
            location.href='index.php?page=$page_pinjam';
        </script>";
    }
} else {
    echo "<script>
        alert('Data peminjaman tidak ditemukan');
        location.href='index.php?page=$page_pinjam';
    </script>";
}
?>
