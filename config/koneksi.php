<?php
$server = "localhost";
$username = "root";
$password = "";
$database = "perpustakaan";

// Koneksi dan memilih database di server
$koneksi = mysqli_connect($server,$username,$password) or die("Koneksi gagal");
mysqli_select_db($database) or die("Database tidak bisa dibuka");
?>
