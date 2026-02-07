<?php
session_start();

$hostName = "localhost";
$username = "root";
$password = "rafliwahyu1";
$dbName = "ukk_perpus";

$conn = mysqli_connect($hostName, $username, $password, $dbName);
if (!$conn) {
	echo "koneksi gagal: " . mysqli_connect_error();
}
?>