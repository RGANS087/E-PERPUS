<h1 class="mt-4">Daftar Pengguna</h1>
<div class="row">
    <div class="col-md-12">

        <div class="table-responsive">
            <div class="bg-light d-flex justify-content-center align-items-center m-4">
    <div class="position-relative">
        <?php if ($_SESSION['user']['level'] != 'peminjam') {
            $srch = "username";
        } else {
            $srch = "nama lengkap";
        } ?>
        <input type="text"
               class="form-control rounded-pill search-bar pe-5"
               placeholder="Search <?php echo $srch; ?>..."
               id="searchInput" 
               aria-label="Search">
        <button class="btn position-absolute top-50 end-0 translate-middle-y" type="button">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
            </svg>
        </button>
    </div>
</div>

        <style>
        .search-bar {
            transition: width 0.3s ease-in-out;
            width: 160px;
        }
        .search-bar:focus {
            width: 300px;
        }
        .modal-backdrop {
            z-index: -1;
        }
        .disabled-link {
            pointer-events: none;
            cursor: not-allowed;
            opacity: 0.6;
        }
    </style>
            <table class="table table-bordered border-2 shadow-lg table-hover rounded-3 overflow-hidden" id="dataTable" width="100%">
                <thead class="bg-primary text-white">
                    <tr>
                        <th>No</th>
                        <th>Nama Lengkap</th>
                        <?php if ($_SESSION['user']['level'] != 'peminjam') { ?>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Alamat</th>
                            <th>No Telepon</th>
                            <th>Level</th>
                            <th>Status</th>
                            <th>Created at</th>
                        <?php } ?>
                        <?php if ($_SESSION['user']['level'] == 'admin') { ?>
                            <th>Aksi</th>
                        <?php } ?>
                    </tr>
                </thead>
                <tbody id="tableBody">
                    <?php
                    $s = 1;
                    $query = mysqli_query($conn, "SELECT * FROM user");
                    while ($data = mysqli_fetch_array($query)) {
                    ?>
                    <tr class="table-primary border-2">
                        <td><?php echo $s++; ?></td>
                        <td class="nama"><?php echo $data['nama']; ?></td>
                        <?php if ($_SESSION['user']['level'] != 'peminjam') { ?>
                            <td class="username"><?php echo $data['username']; ?></td>
                            <td><?php echo $data['email']; ?></td>
                            <td><?php echo $data['alamat']; ?></td>
                            <td><?php echo $data['no_telepon']; ?></td>
                            <td><?php echo $data['level']; ?></td>
                            <td>
                                <?php if ($data['status'] == 'aktif') { ?>
                                    <span class="badge bg-success">Aktif</span>
                                <?php } else { ?>
                                    <span class="badge bg-danger">Banned</span>
                                <?php } ?>
                            </td>

                            <td><?php echo $data['created_at'] ?></td>
                        <?php } ?>
                        <?php
                        if ($_SESSION['user']['level'] == 'admin') { ?>
                            <td>
                                <?php if ($data['id_user'] != $_SESSION['user']['id_user']) { ?>
                                <div class="d-flex gap-2">
                                    <a href="?page=user_ubah&&id=<?php echo $data['id_user']; ?>" class="btn btn-info shadow"><i class="fa fa-pencil"></i></a>
                                    <!-- <a onclick="return confirm('Apakah anda yakin menghapus pengguna ini?');" href="?page=user_hapus&&id=<?php echo $data['id_user']; ?>" class="btn btn-danger shadow"><i class="fa fa-trash"></i></a> -->
                                    <?php if ($data['status'] == 'aktif') { ?>
                                        <a onclick="return confirm('Apakah anda yakin ingin membanned pengguna ini?');" href="?page=user_banned&&id=<?php echo $data['id_user']; ?>" class="btn btn-warning shadow"><i class="fa fa-ban"></i></a>
                                    <?php } else { ?>
                                        <a onclick="return confirm('Apakah anda ingin mengaktifkan pengguna ini kembali?');" href="?page=user_aktif&&id=<?php echo $data['id_user']; ?>" class="btn btn-success shadow"><i class="fa fa-check"></i></a>
                                    <?php } ?>
                                </div>
                            <?php } ?>
                            </td>
                        <?php } ?>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php if ($_SESSION['user']['level'] != 'peminjam') { ?>
<script>
    document.getElementById('searchInput').addEventListener('keyup', function () {
        let filter = this.value.toLowerCase();
        let rows = document.querySelectorAll('#tableBody tr');

        rows.forEach(row => {
            let title = row.querySelector('.username').textContent.toLowerCase();
            if (title.includes(filter)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
</script>
<?php } ?>

<script>
    document.getElementById('searchInput').addEventListener('keyup', function () {
        let filter = this.value.toLowerCase();
        let rows = document.querySelectorAll('#tableBody tr');

        rows.forEach(row => {
            let title = row.querySelector('.nama').textContent.toLowerCase();
            if (title.includes(filter)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
</script>