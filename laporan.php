<h1 class="mt-4">Cetak Laporan Peminjaman Buku</h1>
<div class="row">
    <div class="col-md-12">
        <a id="cetak-btn" class="mb-3 btn btn-primary" href="#" target="_blank">
            <i class="fa fa-print"></i> Cetak Data
        </a>

        <div class="m-4 d-flex gap-2">
            <div>
                <label for="searchStartDate">Tanggal Peminjaman</label>
                <input type="date" class="form-control" id="searchStartDate">
            </div>
            <div>
                <label for="searchEndDate">Tanggal Pengembalian</label>
                <input type="date" class="form-control" id="searchEndDate">
            </div>
            <div>
                <label for="searchStatus">Status Pengembalian</label>
                <select name="status" id="searchStatus" class="form-control">
                    <option value="">Semua status</option>
                    <option value="dipinjam">Dipinjam</option>
                    <option value="dikembalikan">Dikembalikan</option>
                </select>
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
                    <th>Status Pengembalian</th>
                </tr>
                </thead>
                <tbody id="table-body">
                <?php
                $s = 1;
                $query = mysqli_query($conn, "SELECT * FROM peminjaman 
                                              LEFT JOIN user ON user.id_user = peminjaman.id_user 
                                              LEFT JOIN buku ON buku.id_buku = peminjaman.id_buku");
                while ($data = mysqli_fetch_array($query)) {
                ?>
                    <tr class="table-primary border-2">
                        <td><?php echo $s++; ?></td>
                        <td><?php echo $data['nama']; ?></td>
                        <td><?php echo $data['judul']; ?></td>
                        <td class="tanggal-peminjaman"><?php echo $data['tanggal_peminjaman']; ?></td>
                        <td class="tanggal-pengembalian"><?php echo $data['tanggal_pengembalian']; ?></td>
                        <td class="status-peminjaman"><?php echo $data['status_peminjaman']; ?></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const searchStartDate = document.getElementById("searchStartDate");
    const searchEndDate = document.getElementById("searchEndDate");
    const searchStatus = document.getElementById("searchStatus");
    const rows = document.querySelectorAll("#table-body tr");

    function filterData() {
        let startDate = searchStartDate.value;
        let endDate = searchEndDate.value;
        let statusValue = searchStatus.value.toLowerCase();

        rows.forEach(row => {
            let tanggalPeminjaman = row.querySelector(".tanggal-peminjaman").textContent;
            let tanggalPengembalian = row.querySelector(".tanggal-pengembalian").textContent;
            let status = row.querySelector(".status-peminjaman").textContent.toLowerCase();

            let matchStartDate = startDate === "" || tanggalPeminjaman === startDate;
            let matchEndDate = endDate === "" || tanggalPengembalian === endDate;
            let matchStatus = statusValue === "" || status === statusValue;

            if (matchStartDate && matchEndDate && matchStatus) {
                row.style.display = "";
            } else {
                row.style.display = "none";
            }
        });
    }

    searchStartDate.addEventListener("change", filterData);
    searchEndDate.addEventListener("change", filterData);
    searchStatus.addEventListener("change", filterData);

    document.getElementById("cetak-btn").addEventListener("click", function () {
        let startDate = searchStartDate.value;
        let endDate = searchEndDate.value;
        let statusValue = searchStatus.value;

        let url = `cetak.php?startDate=${encodeURIComponent(startDate)}&endDate=${encodeURIComponent(endDate)}&status=${encodeURIComponent(statusValue)}`;
        window.open(url, "_blank");
    });
});
</script>
