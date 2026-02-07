<?php
// Cek apakah ada parameter 'status' pada URL
$status_filter = '';
if (isset($_GET['status'])) {
    $status_filter = $_GET['status'];
}

// Query untuk mendapatkan peminjaman berdasarkan status (jika ada filter)
$query = mysqli_query($conn, "SELECT * FROM peminjaman 
                            LEFT JOIN user ON user.id_user = peminjaman.id_user 
                            LEFT JOIN buku ON buku.id_buku = peminjaman.id_buku 
                            WHERE peminjaman.id_user=" . $_SESSION['user']['id_user'] . 
                            ($status_filter ? " AND peminjaman.status_peminjaman='$status_filter'" : ''));

// Lanjutkan dengan bagian HTML...
?>

<h1 class="mt-4">Laporan Peminjaman Buku</h1>
<div class="row">
    <div class="col-md-12">
        <div class="d-flex justify-content-center align-items-center m-4">
            <div class="position-relative">
                <input type="text" id="search" 
                       class="form-control rounded-pill search-bar pe-5" 
                       placeholder="Search by Tanggal Dipinjam...">
                <button class="btn position-absolute top-50 end-0 translate-middle-y" type="button" id="search-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                    </svg>
                </button>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered border-2 shadow-lg table-hover rounded-3 overflow-hidden" id="dataTable" width="100%">
                <thead class="bg-primary text-white">
            <tr>
                <th>No</th>
                <th>User</th>
                <th>Buku</th>
                <th>Tanggal Peminjaman</th>
                <th>Tanggal Pengembalian</th>
                <th>Status Peminjaman</th>
                <!-- <th>Aksi</th> -->
            </tr>
        </thead>
            <tbody id="table-body">
            <?php
            $s = 1;
            while ($data = mysqli_fetch_array($query)) {
            ?>
            <tr class="table-primary border-2">
                <td><?php echo $s++; ?></td>
                <td><?php echo $data['nama']; ?></td>
                <td><?php echo $data['judul']; ?></td>
                <td class="tanggal_peminjaman"><?php echo $data['tanggal_peminjaman']; ?></td>
                <td><?php echo $data['tanggal_pengembalian']; ?></td>
                <td><?php echo $data['status_peminjaman']; ?></td>
                <!-- <td>
                    <?php if ($data['status_peminjaman'] != 'dikembalikan') { ?>
                        <div class="gap-0 row-gap-3">
                         <div class="p-2 g-col-6">
                            <?php if($_SESSION['user']['level'] != 'peminjam') { ?>
                            <a href="?page=peminjaman_ubah&&id=<?php echo $data['id_peminjaman']; ?>" class="btn btn-info"><i class="fa fa-pencil"></i></a></div>
                        <?php } ?>
                         <div class="p-2 g-col-6"><a onclick="return confirm('Apakah anda yakin menghapus data ini?');" href="?page=peminjaman_hapus&&id=<?php echo $data['id_peminjaman']; ?>" class="btn btn-danger"><i class="fa fa-trash"></i></a></div>
                    </div>
                    <?php } ?>
                </td> -->
            </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
    </div>
</div>

<script>
    document.getElementById('search').addEventListener('keyup', function () {
        let filter = this.value.toLowerCase();
        let rows = document.querySelectorAll('#table-body tr');

        rows.forEach(row => {
            let date = row.querySelector('.tanggal_peminjaman').textContent.toLowerCase();
            if (date.includes(filter)) {
                row.style.display = ''; // Menampilkan baris jika ditemukan
            } else {
                row.style.display = 'none'; // Menyembunyikan baris jika tidak ditemukan
            }
        });
    });
</script>

<style>
    .search-bar {
        transition: width 0.3s ease-in-out;
        width: 110px;
    }
    .search-bar:focus {
        width: 280px;
    }
</style>
