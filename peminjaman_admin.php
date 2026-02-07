<?php
// Ambil parameter status dari URL
$statusFilter = isset($_GET['status']) ? $_GET['status'] : "";

// Buat query dasar
$queryStr = "SELECT * FROM peminjaman 
             LEFT JOIN user ON user.id_user = peminjaman.id_user 
             LEFT JOIN buku ON buku.id_buku = peminjaman.id_buku";

// Tambahkan filter berdasarkan status jika ada parameter di URL
if ($statusFilter == "dikembalikan" || $statusFilter == "dipinjam") {
    $queryStr .= " WHERE status_peminjaman = '$statusFilter'";
}

$query = mysqli_query($conn, $queryStr);
?>

<h1 class="mt-4">Laporan Peminjaman Buku</h1>
<div class="row">
    <div class="col-md-12">
        <div class="m-4 d-flex gap-2">
            <input type="date" class="form-control" id="searchDate" placeholder="Cari berdasarkan tanggal">
            <select name="status" id="searchStatus" class="form-control">
                <option value="">Semua status</option>
                <option value="dipinjam" <?= ($statusFilter == "dipinjam") ? "selected" : "" ?>>Dipinjam</option>
                <option value="dikembalikan" <?= ($statusFilter == "dikembalikan") ? "selected" : "" ?>>Dikembalikan</option>
            </select>
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
                        <th>Aksi</th>
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
                        <td><?php echo $data['tanggal_peminjaman']; ?></td>
                        <td class="tanggal-pengembalian"><?php echo $data['tanggal_pengembalian']; ?></td>
                        <td class="status-peminjaman"><?php echo $data['status_peminjaman']; ?></td>
                        <td>
                            <?php if ($data['status_peminjaman'] != 'dikembalikan') { ?>
                                <div class="gap-0 row-gap-3">
                                    <div class="p-2 g-col-6">
                                        <a href="?page=peminjaman_ubah&&id=<?php echo $data['id_peminjaman']; ?>" class="btn btn-info"><i class="fa fa-pencil"></i></a>
                                    </div>
                                    <?php if($_SESSION['user']['level'] == 'admin') { ?>
                                    <div class="p-2 g-col-6">
                                        <a onclick="return confirm('Apakah anda yakin menghapus data ini?');" href="?page=peminjaman_hapus&&id=<?php echo $data['id_peminjaman']; ?>" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                                    </div>
                                    <?php } ?>
                                </div>
                            <?php } ?>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
