<h1 class="mt-4">Kategori Buku</h1>
<div class="row">
    <div class="col-md-12">
        <?php if ($_SESSION['user']['level'] == 'admin') { ?>
            <a href="?page=kategori_tambah" class="mb-3 btn btn-primary">+ Tambah Data</a>
        <?php } ?>
        
        <div class="table-responsive">
            <table class="table table-bordered border-2 shadow-lg table-hover rounded-3 overflow-hidden" id="dataTable" width="100%">
                <thead class="bg-primary text-white">
                    <tr>
                        <th>No</th>
                        <th>Nama Kategori</th>
                        <?php if ($_SESSION['user']['level'] != 'peminjam') { ?>
                            <th>Aksi</th>
                        <?php } ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $s = 1;
                    $query = mysqli_query($conn, "SELECT * FROM kategori");
                    while ($data = mysqli_fetch_array($query)) {
                    ?>
                    <tr class="table-primary border-2">
                        <td><?php echo $s++; ?></td>
                        <td><?php echo $data['kategori']; ?></td>
                        <?php if ($_SESSION['user']['level'] != 'peminjam') { ?>
                            <td>
                                <div class="d-flex gap-2">
                                    <a href="?page=kategori_ubah&&id=<?php echo $data['id_kategori']; ?>" class="btn btn-info shadow"><i class="fa fa-pencil"></i></a>
                                    <?php if ($_SESSION['user']['level'] == 'admin') { ?>
                                        <a onclick="return confirm('Apakah anda yakin menghapus data ini?');" href="?page=kategori_hapus&&id=<?php echo $data['id_kategori']; ?>" class="btn btn-danger shadow"><i class="fa fa-trash"></i></a>
                                    <?php } ?>
                                </div>
                            </td>
                        <?php } ?>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
