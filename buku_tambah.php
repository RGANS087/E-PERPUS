<?php
if (isset($_POST['submit'])) {
    $judul = $_POST['judul'];
    $penulis = $_POST['penulis'];
    $penerbit = $_POST['penerbit'];
    $tahun_terbit = $_POST['tahun_terbit'];
    $deskripsi = $_POST['deskripsi'];
    $stok = $_POST['stok'];
    $gambar = $_FILES['gambar']['name'];
    $file_tmp = $_FILES['gambar']['tmp_name'];

    if (!empty($gambar)) {
        move_uploaded_file($file_tmp, 'assets/upload/' . $gambar);
    }

    // Insert ke tabel buku
    $query = mysqli_query($conn, "INSERT INTO buku (judul, penulis, penerbit, tahun_terbit, deskripsi, stok, gambar) 
                                  VALUES ('$judul', '$penulis', '$penerbit', '$tahun_terbit', '$deskripsi', $stok, '$gambar')");
    
    if ($query) {
        $id_buku = mysqli_insert_id($conn); // Ambil ID buku yang baru ditambahkan

        if (!empty($_POST['id_kategori'])) {
            foreach ($_POST['id_kategori'] as $id_kategori) {
                mysqli_query($conn, "INSERT INTO buku_kategori (id_buku, id_kategori) VALUES ('$id_buku', '$id_kategori')");
            }
        }
        echo '<script>alert("Tambah Data Berhasil");</script>';
    } else {
        echo '<script>alert("Tambah Data Gagal");</script>';
    }
}
?>

<h1 class="mt-4">Buku</h1>
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <form method="post" enctype="multipart/form-data">
                    <div class="row mb-3">
                        <div class="col-md-2">Kategori</div>
                        <div class="col-md-8">
                            <select class="selectpicker w-100" name="id_kategori[]" multiple aria-label="Default select example" data-live-search="true">
                                <?php
                            $kat = mysqli_query($conn, "SELECT * FROM kategori");
                            while ($kategori = mysqli_fetch_array($kat)) {
                            ?>
                                <option value="<?php echo $kategori['id_kategori']; ?>"><?php echo $kategori['kategori']; ?></option>
                            <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-2">Judul</div>
                        <div class="col-md-8"><input type="text" class="form-control" name="judul" required></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-2">Penulis</div>
                        <div class="col-md-8"><input type="text" class="form-control" name="penulis" required></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-2">Penerbit</div>
                        <div class="col-md-8"><input type="text" class="form-control" name="penerbit" required></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-2">Tahun Terbit</div>
                        <div class="col-md-8"><input type="number" class="form-control" name="tahun_terbit" required></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-2">Deskripsi</div>
                        <div class="col-md-8"><textarea name="deskripsi" rows="5" class="form-control" required></textarea></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-2">Stok</div>
                        <div class="col-md-8"><input type="number" class="form-control" name="stok" required></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-2">Gambar</div>
                        <div class="col-md-8"><input type="file" name="gambar"></div>
                    </div>
                    <div class="row">
                        <div class="col-md-2"></div>
                        <div class="col-md-8">
                            <button type="submit" class="btn btn-primary" name="submit">Simpan</button>
                            <button type="reset" class="btn btn-secondary">Reset</button>
                            <a href="?page=buku" class="btn btn-danger">Kembali</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Tambahkan jQuery dan Select2 -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>