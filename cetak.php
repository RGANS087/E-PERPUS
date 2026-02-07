<?php
include('koneksi.php');

$startDate = isset($_GET['startDate']) ? $_GET['startDate'] : "";
$endDate = isset($_GET['endDate']) ? $_GET['endDate'] : "";
$status = isset($_GET['status']) ? $_GET['status'] : "";

$query = "SELECT * FROM peminjaman 
          LEFT JOIN user ON user.id_user = peminjaman.id_user 
          LEFT JOIN buku ON buku.id_buku = peminjaman.id_buku 
          WHERE 1=1";

if (!empty($startDate)) {
    $query .= " AND tanggal_peminjaman = '$startDate'";
}

if (!empty($endDate)) {
    $query .= " AND tanggal_pengembalian = '$endDate'";
}

if (!empty($status)) {
    $query .= " AND status_peminjaman = '$status'";
}

$result = mysqli_query($conn, $query);
?>

<h2 align="center">Laporan Peminjaman Buku</h2>
<table border="1" cellspacing="0" cellpadding="5" width="100%">
    <tr>
        <th>No</th>
        <th>User</th>
        <th>Buku</th>
        <th>Tanggal Peminjaman</th>
        <th>Tanggal Pengembalian</th>
        <th>Status Pengembalian</th>
    </tr>
    <?php
    $s = 1;
    while ($data = mysqli_fetch_array($result)) {
    ?>
    <tr>
        <td><?php echo $s++; ?></td>
        <td><?php echo $data['nama']; ?></td>
        <td><?php echo $data['judul']; ?></td>
        <td><?php echo $data['tanggal_peminjaman']; ?></td>
        <td><?php echo $data['tanggal_pengembalian']; ?></td>
        <td><?php echo $data['status_peminjaman']; ?></td>
    </tr>
    <?php } ?>
</table>

<script type="text/javascript">
    window.print();
    setTimeout(function () {
        window.close();
    }, 100);
</script>
