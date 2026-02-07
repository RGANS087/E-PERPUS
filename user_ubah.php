<h1 class="mt-4">Pengguna</h1>
<div class="card">
	<div class="card-body">
		<div class="row">
			<div class="col-md-12">
				<form method="post">
					<?php

					if (!isset($_GET['id']) || empty($_GET['id'])) {
						echo "<script>alert('ID tidak ditemukan!'); window.location.href='?page=anggota';</script>";
						exit();
					}

					$id = $_GET['id'];

					// Ambil data pengguna berdasarkan ID
					$query = $conn->prepare("SELECT * FROM user WHERE id_user=?");
					$query->bind_param("i", $id);
					$query->execute();
					$result = $query->get_result();
					$data = $result->fetch_assoc();

					if (!$data) {
						echo "<script>alert('Data tidak ditemukan!'); window.location.href='?page=anggota';</script>";
						exit();
					}

					// Proses update
					if (isset($_POST['submit'])) {
						$level = $_POST['level'];

						$update = $conn->prepare("UPDATE user SET level=? WHERE id_user=?");
						$update->bind_param("si", $level, $id);
						if ($update->execute()) {
							echo '<script>alert("Ubah Data Berhasil"); window.location.href="?page=anggota";</script>';
						} else {
							echo '<script>alert("Ubah Data Gagal");</script>';
						}
					}
					?>

					<div class="row mb-3">
						<div class="col-md-2">Level</div>
						<div class="col-md-8">
							<select class="form-control" name="level" required>
								<option value="Admin" <?php echo ($data['level'] == 'Admin') ? 'selected' : ''; ?>>Admin</option>
								<option value="Petugas" <?php echo ($data['level'] == 'Petugas') ? 'selected' : ''; ?>>Petugas</option>
								<option value="Peminjam" <?php echo ($data['level'] == 'Peminjam') ? 'selected' : ''; ?>>Peminjam</option>
							</select>
						</div>
					</div>
					<div class="row">
						<div class="col-md-2"></div>
						<div class="col-md-8">
							<button type="submit" class="btn btn-primary" name="submit" value="submit">Simpan</button>
							<a href="?page=anggota" class="btn btn-danger">Kembali</a>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
