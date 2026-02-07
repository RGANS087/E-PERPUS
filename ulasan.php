<h1 class="mt-4">Ulasan Buku</h1>
<div class="row">
	<div class="col-md-12">
		<?php if ($_SESSION['user']['level'] == 'peminjam') { ?>
		<a href="?page=ulasan_tambah" class="mb-3 btn btn-primary">+ Tambah Data</a>
	<?php } ?>

	<div class="table-responsive">
		<table class="table table-bordered border-2 shadow-lg table-hover rounded-3 overflow-hidden" id="dataTable" width="100%">
                <thead class="bg-primary text-white">
			<tr>
				<th>No</th>
				<th>User</th>
				<th>Buku</th>
				<th>Ulasan</th>
				<th>Rating</th>
				<?php if ($_SESSION['user']['level'] == 'peminjam') { ?>
				<th>Aksi</th>
			<?php } ?>
			</tr>
		</thead>
			<?php
			$s = 1;
			$id_user = $_SESSION['user']['id_user'];
			$query = mysqli_query($conn, "SELECT * FROM ulasan LEFT JOIN user ON user.id_user = ulasan.id_user LEFT JOIN buku ON buku.id_buku = ulasan.id_buku ORDER BY ulasan.id_ulasan DESC");
			while ($data = mysqli_fetch_array($query)) {
			?>

			<tr class="table-primary border-2">
				<td><?php echo $s++; ?></td>
				<td><?php echo $data['nama']; ?></td>
				<td><?php echo $data['judul']; ?></td>
				<td><?php echo $data['ulasan']; ?></td>
				<td><?php echo $data['rating']; ?></td>
				<?php if ($_SESSION['user']['level'] == 'peminjam') { ?>
				<td>
					<div class="d-flex gap-0 row-gap-3">
						<?php if ($data['id_user'] == $id_user) { ?>
 						 <div class="p-2 g-col-6">
							<a href="?page=ulasan_ubah&&id=<?php echo $data['id_ulasan']; ?>" class="btn btn-info"><i class="fa fa-pencil"></i></a></div>
  						 <div class="p-2 g-col-6"><a onclick="return confirm('Apakah anda yakin menghapus data ini?');" href="?page=ulasan_hapus&&id=<?php echo $data['id_ulasan']; ?>" class="btn btn-danger"><i class="fa fa-trash"></i></a></div>
				<?php } ?>
					</div>

					
				</td>
			<?php } ?>
			</tr>

		<?php } ?>
		</table>
	</div>
	</div>
</div>