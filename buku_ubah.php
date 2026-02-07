<h1 class="mt-4">Ubah Buku</h1>
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <?php
                $id = $_GET['id'];
                $data = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM buku WHERE id_buku='$id'"));

                // Ambil kategori yang sudah dipilih
                $kategori_terpilih = [];
                $result = mysqli_query($conn, "SELECT id_kategori FROM buku_kategori WHERE id_buku='$id'");
                while ($row = mysqli_fetch_assoc($result)) {
                    $kategori_terpilih[] = $row['id_kategori'];
                }

                if (isset($_POST['submit'])) {
                    $judul = $_POST['judul'];
                    $penulis = $_POST['penulis'];
                    $penerbit = $_POST['penerbit'];
                    $tahun_terbit = $_POST['tahun_terbit'];
                    $deskripsi = $_POST['deskripsi'];
                    $stok = $_POST['stok'];
                    $gambar = $data['gambar']; // Default gambar tetap yang lama

                    // Proses upload gambar
                    if (!empty($_FILES['gambar']['name'])) {
                        $gambar = time() . '_' . $_FILES['gambar']['name']; // Tambahkan timestamp agar unik
                        $file_tmp = $_FILES['gambar']['tmp_name'];
                        $upload_dir = 'assets/upload/';

                        if (move_uploaded_file($file_tmp, $upload_dir . $gambar)) {
                            // Hapus gambar lama jika ada
                            if ($data['gambar'] && file_exists($upload_dir . $data['gambar'])) {
                                unlink($upload_dir . $data['gambar']);
                            }
                        } else {
                            $gambar = $data['gambar']; // Jika gagal upload, gunakan gambar lama
                        }
                    }

                    // Update data buku
                    mysqli_query($conn, "UPDATE buku SET 
                        judul='$judul', 
                        penulis='$penulis', 
                        penerbit='$penerbit', 
                        tahun_terbit='$tahun_terbit', 
                        deskripsi='$deskripsi', 
                        stok='$stok',
                        gambar='$gambar' WHERE id_buku='$id'");

                    // Update kategori buku
                    mysqli_query($conn, "DELETE FROM buku_kategori WHERE id_buku='$id'"); // Hapus semua kategori lama
                    if (!empty($_POST['id_kategori'])) {
                        foreach ($_POST['id_kategori'] as $id_kategori) {
                            mysqli_query($conn, "INSERT INTO buku_kategori (id_buku, id_kategori) VALUES ('$id', '$id_kategori')");
                        }
                    }

                    echo '<script>alert("Ubah Data Berhasil"); window.location="?page=buku";</script>';
                }
                ?>
                <form method="post" enctype="multipart/form-data">
                    <div class="row mb-3">
                        <div class="col-md-2">Kategori</div>
                        <div class="col-md-8">
                            <select class="selectpicker w-100" name="id_kategori[]" multiple aria-label="Default select example" data-live-search="true">
    <?php
    // Ambil kategori yang telah dipilih sebelumnya
    $kategori_terpilih = [];
    $result = mysqli_query($conn, "SELECT id_kategori FROM buku_kategori WHERE id_buku='$id'");
    while ($row = mysqli_fetch_assoc($result)) {
        $kategori_terpilih[] = $row['id_kategori'];
    }

    // Ambil semua kategori
    $kat = mysqli_query($conn, "SELECT * FROM kategori");
    while ($kategori = mysqli_fetch_array($kat)) {
        // Cek apakah kategori ini termasuk dalam kategori yang dipilih
        $selected = in_array($kategori['id_kategori'], $kategori_terpilih) ? 'selected' : '';
        echo "<option value='{$kategori['id_kategori']}' $selected>{$kategori['kategori']}</option>";
    }
    ?>
</select>

                        </div>
                    </div>
                    <div class="mb-3"><label>Judul</label><input type="text" name="judul" value="<?= $data['judul'] ?>" class="form-control"></div>
                    <div class="mb-3"><label>Penulis</label><input type="text" name="penulis" value="<?= $data['penulis'] ?>" class="form-control"></div>
                    <div class="mb-3"><label>Penerbit</label><input type="text" name="penerbit" value="<?= $data['penerbit'] ?>" class="form-control"></div>
                    <div class="mb-3"><label>Tahun Terbit</label><input type="number" name="tahun_terbit" value="<?= $data['tahun_terbit'] ?>" class="form-control"></div>
                    <div class="mb-3"><label>Deskripsi</label><textarea name="deskripsi" class="form-control"><?= $data['deskripsi'] ?></textarea></div>
                    <div class="mb-3"><label>Stok</label><input type="number" name="stok" value="<?= $data['stok'] ?>" class="form-control"></div>
                    <div class="mb-3">
                        <label>Gambar</label>
                        <input type="file" name="gambar" class="form-control">
                        <?php if ($data['gambar']) { ?>
                            <br>
                            <img src="assets/upload/<?= $data['gambar'] ?>" width="100">
                        <?php } ?>
                    </div>
                    <button type="submit" name="submit" class="btn btn-primary">Simpan</button>
                    <a href="?page=buku" class="btn btn-danger">Kembali</a>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .kategori-badge {
        display: inline-block;
        padding: 10px 15px;
        margin: 5px;
        font-size: 14px;
        cursor: pointer;
        background-color: #f8f9fa;
        border: 1px solid #ddd;
        color: #333;
        border-radius: 20px;
        transition: background-color 0.3s, color 0.3s;
    }

    .kategori-badge.selected {
        background-color: #007bff;
        color: white;
        border-color: #007bff;
    }
</style>

<script>
    document.querySelectorAll('.kategori-badge').forEach(badge => {
        badge.addEventListener('click', function () {
            this.classList.toggle('selected');
            let checkbox = this.querySelector('.kategori-checkbox');
            checkbox.checked = !checkbox.checked;
        });
    });

    // Menandai kategori yang sudah dipilih saat halaman dimuat
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('.kategori-checkbox:checked').forEach(checkbox => {
            checkbox.closest('.kategori-badge').classList.add('selected');
        });
    });
</script>

<!-- Tambahkan jQuery dan Select2 -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>