<h1 class="mt-4">Daftar Buku</h1>
<div class="row">
    <div class="col-md-12">
        <?php if ($_SESSION['user']['level'] != 'peminjam') { ?>
            <a href="?page=buku_tambah" class="mb-3 btn btn-primary">+ Tambah Data</a>
        <?php } ?>

        <div class="bg-light d-flex justify-content-center align-items-center m-4">
    <div class="position-relative">
        <input type="text"
               class="form-control rounded-pill search-bar pe-5"
               placeholder="Search judul..."
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

        <div class="table-responsive">
            <table class="table table-bordered border-2 shadow-lg table-hover rounded-3 overflow-hidden" id="dataTable" width="100%">
                <thead class="bg-primary text-white">
                    <tr>
                        <th>No</th>
                        <th class="col-kategori">Kategori</th>
                        <th class="col-judul">Judul</th>
                        <th class="col-penulis">Penulis</th>
                        <th class="col-penerbit">Penerbit</th>
                        <th class="col-tahun">Tahun Terbit</th>
                        <th class="col-deskripsi">Deskripsi</th>
                        <th>Stok</th>
                        <th>Gambar</th>
                        <?php if ($_SESSION['user']['level'] != 'peminjam') { ?>
                            <th>Aksi</th>
                        <?php } ?>
                    </tr>
                </thead>
                <tbody id="tableBody">
                    <?php
                    $s = 1;
                    $query = mysqli_query($conn, "SELECT buku.*, GROUP_CONCAT(kategori.kategori SEPARATOR ', ') AS kategori 
                                                  FROM buku 
                                                  LEFT JOIN buku_kategori ON buku.id_buku = buku_kategori.id_buku 
                                                  LEFT JOIN kategori ON buku_kategori.id_kategori = kategori.id_kategori 
                                                  GROUP BY buku.id_buku ORDER BY buku.id_buku DESC");
                    while ($data = mysqli_fetch_array($query)) {
                        $gambar = !empty($data['gambar']) ? $data['gambar'] : "noImage.jpg";
                    ?>
                    <tr class="table-primary border-2">
                        <td><?php echo $s++; ?></td>
                        <td class="col-kategori"><?php echo $data['kategori']; ?></td>
                        <td class="col-judul judul"><?php echo $data['judul']; ?></td>
                        <td class="col-penulis"><?php echo $data['penulis']; ?></td>
                        <td class="col-penerbit"><?php echo $data['penerbit']; ?></td>
                        <td class="col-tahun"><?php echo $data['tahun_terbit']; ?></td>
                        <td class="col-deskripsi"><?php echo $data['deskripsi']; ?></td>
                        <td><?php echo $data['stok']; ?></td>
                        <td><img src="assets/upload/<?php echo $gambar; ?>" alt="gambar" width="100"></td>
                        <?php if ($_SESSION['user']['level'] != 'peminjam') { ?>
                            <td>
                                <a href="?page=buku_ubah&&id=<?php echo $data['id_buku']; ?>" class="btn btn-info"><i class="fa fa-pencil"></i></a>
                                <?php if ($_SESSION['user']['level'] == 'admin') {?>
                                    <a onclick="return confirm('Apakah anda yakin menghapus data ini?');" href="?page=buku_hapus&&id=<?php echo $data['id_buku']; ?>" class="btn btn-danger"><i class="fa fa-trash"></i></a>
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

<style>
    /* Membuat teks panjang turun ke bawah */
    .col-kategori, .col-judul, .col-penulis, .col-penerbit, .col-deskripsi {
        max-width: 150px; /* Atur lebar maksimum */
        word-wrap: break-word;
        white-space: normal; /* Pastikan teks turun ke bawah */
    }
    
    .col-judul {
        font-weight: bold;
    }

    /* Agar tabel tidak melebar */
    td, th {
        vertical-align: middle;
        text-align: center;
    }

    /* Agar gambar tidak terlalu besar */
    img {
        display: block;
        margin: auto;
        border-radius: 5px;
    }
</style>

<script>
    document.getElementById('searchInput').addEventListener('keyup', function () {
        let filter = this.value.toLowerCase();
        let rows = document.querySelectorAll('#tableBody tr');

        rows.forEach(row => {
            let title = row.querySelector('.judul').textContent.toLowerCase();
            if (title.includes(filter)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
</script>
