<h1 class="mt-4">Ulasan</h1>
<div class="card">
	<div class="card-body">
		<div class="row">
			<div class="col-md-12">
				<form method="post">
					<?php
					if (isset($_POST['submit'])) {
						$id_buku = $_POST['id_buku'];
						$id_user = $_SESSION['user']['id_user'];
						$ulasan = $_POST['ulasan'];
						$rating = $_POST['rating'];
						$query = mysqli_query($conn, "INSERT INTO ulasan (id_buku, id_user, ulasan, rating) VALUES ('$id_buku', '$id_user', '$ulasan', '$rating')");
						if ($query) {
							echo '<script>alert("Tambah Data Berhasil");</script>';
						} else {
							echo '<script>alert("Tambah Data Gagal");</script>';
						}
					}
					?>
					<div class="row mb-3">
						<div class="col-md-2">Buku</div>
						<div class="col-md-8">
							<select name="id_buku" class="form-control">
							<?php
							$buk = mysqli_query($conn, "SELECT * FROM buku");
							while ($buku = mysqli_fetch_array($buk)) {
							?>
							<option value="<?php echo $buku['id_buku']; ?>"><?php echo $buku['judul']; ?></option>
						<?php } ?>
						</select>
					</div>
					</div>
					<div class="row mb-3">
						<div class="col-md-2">Ulasan</div>
						<div class="col-md-8"><textarea type="text" class="form-control" name="ulasan"></textarea></div>
					</div>
					<div class="row mb-3">
						<div class="col-md-2">Rating</div>
						<div class="col-md-8">
							<select name="rating" class="form-control">
								<option value="1">1</option>
								<option value="2">2</option>
								<option value="3">3</option>
								<option value="4">4</option>
								<option value="5">5</option>
								<option value="6">6</option>
								<option value="7">7</option>
								<option value="8">8</option>
								<option value="9">9</option>
								<option value="10">10</option>
							</select>
						</div>
					</div>
					<div class="row">
						<div class="col-md-2"></div>
						<div class="col-md-8">
							<button type="submit" class="btn btn-primary" name="submit" value="submit">Simpan</button>
							<button type="submit" class="btn btn-secondary">Reset</button>
							<a href="?page=ulasan" class="btn btn-danger">Kembali</a>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>