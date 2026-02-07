<?php

if (!isset($_SESSION['user'])) {
    echo '<script>alert("Silakan login terlebih dahulu!"); window.location="login.php";</script>';
    exit();
}

$user_id = $_SESSION['user']['id_user']; // Ambil user ID dari session

if (isset($_GET['id_buku'])) {
    $id_buku = $_GET['id_buku'];
    $query_buku = mysqli_query($conn, "SELECT * FROM buku WHERE id_buku = '$id_buku'");
    $buku = mysqli_fetch_array($query_buku);
}

if (isset($_POST['submit'])) {
    $id_buku = $_POST['id_buku'];
    $tanggal_peminjaman = $_POST['tanggal_peminjaman'];
    $tanggal_pengembalian = $_POST['tanggal_pengembalian'];
    $status_peminjaman = $_POST['status_peminjaman'];

    // Cek stok buku
    $stok_query = mysqli_query($conn, "SELECT stok FROM buku WHERE id_buku = '$id_buku'");
    $stok_data = mysqli_fetch_assoc($stok_query);
    $stok_sekarang = $stok_data['stok'];

    if ($stok_sekarang > 0) {
        $query = mysqli_query($conn, "INSERT INTO peminjaman(id_buku, id_user, tanggal_peminjaman, tanggal_pengembalian, status_peminjaman) 
            VALUES ('$id_buku', '$user_id', '$tanggal_peminjaman', '$tanggal_pengembalian', '$status_peminjaman')");

        if ($query) {
            mysqli_query($conn, "UPDATE buku SET stok = stok - 1 WHERE id_buku = '$id_buku'");
            echo '<script>alert("Peminjaman berhasil!"); window.location="?page=peminjaman";</script>';
        } else {
            echo '<script>alert("Peminjaman gagal!");</script>';
        }
    } else {
        echo '<script>alert("Stok Buku Habis!");</script>';
    }
}
?>

<h1 class="mt-4">Peminjaman Buku</h1>
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <form method="post" id="peminjamanForm">
                    <div class="row mb-3">
                        <div class="col-md-2">Buku</div>
                        <div class="col-md-8">
                            <input type="text" class="form-control" value="<?php echo $buku['judul']; ?>" disabled>
                            <input type="hidden" name="id_buku" value="<?php echo $buku['id_buku']; ?>">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-2">Tanggal Peminjaman</div>
                        <div class="col-md-8">
                            <input type="date" class="form-control" name="tanggal_peminjaman" id="tanggal_peminjaman" required>
                            <small id="peminjamanValidation" class="validation-message"></small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-2">Tanggal Pengembalian</div>
                        <div class="col-md-8">
                            <input type="date" class="form-control" name="tanggal_pengembalian" id="tanggal_pengembalian" readonly required>
                            <small id="pengembalianValidation" class="validation-message"></small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-2">Status Peminjaman</div>
                        <div class="col-md-8">
                            <select name="status_peminjaman" class="form-control">
                                <option value="dipinjam">Dipinjam</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2"></div>
                        <div class="col-md-8">
                            <button type="submit" class="btn btn-primary" name="submit" id="submitBtn" disabled>Simpan</button>
                            <button type="reset" class="btn btn-secondary">Reset</button>
                            <a href="?page=list_buku" class="btn btn-danger">Kembali</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const tanggalPeminjaman = document.getElementById('tanggal_peminjaman');
        const tanggalPengembalian = document.getElementById('tanggal_pengembalian');
        const peminjamanValidation = document.getElementById('peminjamanValidation');
        const pengembalianValidation = document.getElementById('pengembalianValidation');
        const submitBtn = document.getElementById('submitBtn');

        function formatDate(date) {
            let d = new Date(date),
                month = '' + (d.getMonth() + 1),
                day = '' + d.getDate(),
                year = d.getFullYear();

            if (month.length < 2) month = '0' + month;
            if (day.length < 2) day = '0' + day;

            return [year, month, day].join('-');
        }

        function validateDates() {
            const tglPeminjaman = new Date(tanggalPeminjaman.value);
            const now = new Date();
            let isValid = true;

            // Validasi tanggal peminjaman tidak boleh sebelum hari ini
            if (tanggalPeminjaman.value && tglPeminjaman < now.setHours(0, 0, 0, 0)) {
                peminjamanValidation.textContent = "Tanggal peminjaman tidak boleh sebelum hari ini.";
                peminjamanValidation.style.color = "red";
                isValid = false;
            } else {
                peminjamanValidation.textContent = "";
            }

            // Jika tanggal peminjaman valid, atur tanggal pengembalian otomatis (+7 hari)
            if (isValid) {
                let tglPengembalian = new Date(tglPeminjaman);
                tglPengembalian.setDate(tglPengembalian.getDate() + 7);
                tanggalPengembalian.value = formatDate(tglPengembalian);
                pengembalianValidation.textContent = "";
            }

            // Aktifkan tombol submit jika valid
            submitBtn.disabled = !isValid;
        }

        tanggalPeminjaman.addEventListener('input', validateDates);
    });
</script>

<style>
    .validation-message {
        font-size: 14px;
        margin-top: 5px;
        display: block;
        color: red;
    }
</style>
