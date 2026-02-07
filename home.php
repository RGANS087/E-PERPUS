<?php
if ($_SESSION['user']['level'] != 'peminjam') {
    $page_pinjam = '?page=peminjaman_admin';
} else {
    $page_pinjam = '?page=peminjaman';
}

if ($_SESSION['user']['level'] != 'peminjam') {
    $page = "?page=buku";
} else {
    $page = "?page=list_buku";
}
?>

<h1 class="mt-4">Dashboard</h1>
                        <div class="row">

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <a href="?page=kategori">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Total Kategori</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php
                                        echo mysqli_num_rows(mysqli_query($conn, "SELECT * FROM kategori"));
                                        ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-table fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            </div>
                        </div>

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <a href="<?php echo $page; ?>">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Total Buku</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php
                                        echo mysqli_num_rows(mysqli_query($conn, "SELECT * FROM buku"));
                                        ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-book fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-danger shadow h-100 py-2">
                                <a href="?page=anggota">
                                <div class="card-body cursor">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                                Total User</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php
                                        echo mysqli_num_rows(mysqli_query($conn, "SELECT * FROM user"));
                                        ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-user fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            </div>
                        </div>

                        <!-- Pending Requests Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                            <a href="?page=ulasan">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                Total Ulasan</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php
                                        echo mysqli_num_rows(mysqli_query($conn, "SELECT * FROM ulasan"));
                                        ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-comments fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            </div>
                        </div>
                        <?php if ($_SESSION['user']['level'] == 'peminjam') { ?>
                        <!-- Total Dipinjam -->
<div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-primary shadow h-100 py-2">
        <a href="<?php echo $page_pinjam; ?>&status=dipinjam">
        <div class="card-body notuser">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                        Total Dipinjam</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?php
                    $id_user = $_SESSION['user']['id_user'];
                        echo mysqli_num_rows(mysqli_query($conn, "SELECT * FROM peminjaman WHERE status_peminjaman='dipinjam' AND id_user='$id_user'"));
                    ?></div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-book-bookmark fa-2x text-gray-300"></i>
                </div>
            </div>
        </div>
    </a>
    </div>
</div>

<!-- Total Dikembalikan -->
<div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-success shadow h-100 py-2">
        <a href="<?php echo $page_pinjam; ?>&status=dikembalikan">
        <div class="card-body notuser">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                        Total Dikembalikan</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?php
                    $id_user = $_SESSION['user']['id_user'];
                        echo mysqli_num_rows(mysqli_query($conn, "SELECT * FROM peminjaman WHERE status_peminjaman='dikembalikan' AND id_user='$id_user'"));
                    ?></div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-swatchbook fa-2x text-gray-300"></i>
                </div>
            </div>
        </div>
    </a>
    </div>
</div>
<?php } ?>

<?php if ($_SESSION['user']['level'] != 'peminjam') { ?>
    <div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-primary shadow h-100 py-2">
        <a href="<?php echo $page_pinjam; ?>&status=dipinjam">
        <div class="card-body notuser">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                        Total Dipinjam</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?php
                        echo mysqli_num_rows(mysqli_query($conn, "SELECT * FROM peminjaman WHERE status_peminjaman='dipinjam'"));
                    ?></div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-book-bookmark fa-2x text-gray-300"></i>
                </div>
            </div>
        </div>
    </a>
    </div>
</div>

<!-- Total Dikembalikan -->
<div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-success shadow h-100 py-2">
        <a href="<?php echo $page_pinjam; ?>&status=dikembalikan">
        <div class="card-body notuser">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                        Total Dikembalikan</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?php
                        echo mysqli_num_rows(mysqli_query($conn, "SELECT * FROM peminjaman WHERE status_peminjaman='dikembalikan'"));
                    ?></div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-swatchbook fa-2x text-gray-300"></i>
                </div>
            </div>
        </div>
    </a>
    </div>
</div>
<?php } ?>

                        <div class="card">
                            <div class="card-body">
                                <table class="table table-bordered">
                                    <tr>
                                        <td width="200">Nama</td>
                                        <td width="1">:</td>
                                        <td><?php echo $_SESSION['user']['nama']; ?></td>
                                    </tr>
                                    <tr>
                                        <td width="200">Level User</td>
                                        <td width="1">:</td>
                                        <td><?php echo $_SESSION['user']['level']; ?></td>
                                    </tr>
                                    <tr>
                                        <td width="200">Tanggal Login</td>
                                        <td width="1">:</td>
                                        <td><?php echo date('d-m-Y'); ?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>