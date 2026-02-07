<?php
if ($_SESSION['user']['level'] != 'peminjam') {
    $page_pinjam = '?page=peminjaman_admin';
} else {
    $page_pinjam = '?page=peminjaman';
}

$id = $_GET['id'] ?? null;
if (!$id) {
    echo '<script>alert("ID peminjaman tidak ditemukan"); window.location="' . $page_pinjam . '";</script>';
    exit;
}

$query = mysqli_query($conn, "SELECT * FROM peminjaman JOIN buku ON peminjaman.id_buku = buku.id_buku WHERE id_peminjaman='$id'");
$data = mysqli_fetch_array($query);

if (!$data) {
    echo '<script>alert("Data peminjaman tidak ditemukan"); window.location="' . $page_pinjam . '";</script>';
    exit;
}

if (isset($_POST['submit'])) {
    $id_buku = $_POST['id_buku'];
    $tanggal_peminjaman = $_POST['tanggal_peminjaman'];
    $tanggal_pengembalian = $_POST['tanggal_pengembalian'];
    $status_peminjaman = $_POST['status_peminjaman'];

    $query = mysqli_query($conn, "UPDATE peminjaman SET tanggal_peminjaman='$tanggal_peminjaman', tanggal_pengembalian='$tanggal_pengembalian', status_peminjaman='$status_peminjaman' WHERE id_peminjaman='$id'");

    if ($query) {
        if ($status_peminjaman == 'dikembalikan') {
            $update_stok = mysqli_query($conn, "UPDATE buku SET stok = stok + 1 WHERE id_buku = '$id_buku'");
            $message = $update_stok ? "Ubah Data Berhasil dan Stok Ditambah" : "Gagal menambah stok buku";
        } else {
            $message = "Ubah Data Berhasil";
        }
        echo '<script>alert("' . $message . '"); window.location="' . $page_pinjam . '";</script>';
    } else {
        echo '<script>alert("Ubah Data Gagal");</script>';
    }
}
?>

<h1 class="mt-4">Edit Peminjaman Buku</h1>
<div class="card">
    <div class="card-body">
        <form method="post">
            <div class="row mb-3">
                <div class="col-md-2">Buku</div>
                <div class="col-md-8">
                    <input type="text" class="form-control" value="<?php echo $data['judul']; ?>" readonly>
                    <input type="hidden" name="id_buku" value="<?php echo $data['id_buku']; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-2">Tanggal Peminjaman</div>
                <div class="col-md-8">
                    <input type="date" class="form-control" name="tanggal_peminjaman" id="tanggal_peminjaman" value="<?php echo $data['tanggal_peminjaman']; ?>" readonly>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-2">Tanggal Pengembalian</div>
                <div class="col-md-8">
                    <input type="date" class="form-control" name="tanggal_pengembalian" id="tanggal_pengembalian" value="<?php echo $data['tanggal_pengembalian']; ?>" required>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-2">Status Peminjaman</div>
                <div class="col-md-8">
                    <select name="status_peminjaman" class="form-control" required>
                        <option value="dipinjam" <?php if($data['status_peminjaman'] == 'dipinjam') echo "selected"; ?>>Dipinjam</option>
                        <option value="dikembalikan" <?php if($data['status_peminjaman'] == 'dikembalikan') echo "selected"; ?>>Dikembalikan</option>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-8">
                    <button type="submit" class="btn btn-primary" name="submit" id="submitBtn">Simpan</button>
                    <a href="<?php echo $page_pinjam; ?>" class="btn btn-danger">Kembali</a>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const tanggalPeminjaman = document.getElementById('tanggal_peminjaman');
        const tanggalPengembalian = document.getElementById('tanggal_pengembalian');
        const submitBtn = document.getElementById('submitBtn');

        function validateDates() {
            const tglPeminjaman = new Date(tanggalPeminjaman.value);
            const tglPengembalian = new Date(tanggalPengembalian.value);
            const now = new Date();
            let isValid = true;

            // Validasi tanggal pengembalian
            if (tglPengembalian < tglPeminjaman) {
                alert("Tanggal pengembalian harus setelah tanggal peminjaman!");
                isValid = false;
            } 
            
            if ((tglPengembalian - tglPeminjaman) / (1000 * 60 * 60 * 24) > 7) {
                alert("Buku hanya dapat dipinjam maksimal selama 7 hari!");
                isValid = false;
            }

            // Nonaktifkan tombol submit jika tidak valid
            submitBtn.disabled = !isValid;
        }

        tanggalPengembalian.addEventListener('change', validateDates);
    });
</script>
