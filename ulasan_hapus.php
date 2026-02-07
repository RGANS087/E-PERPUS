<?php
$id = $_GET['id'];
$query = mysqli_query($conn, "DELETE FROM ulasan WHERE id_ulasan='$id'");
?>
<script>
	alert("Hapus data berhasil");
	location.href="index.php?page=ulasan"
</script>