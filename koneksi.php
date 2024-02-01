<?php
$localhost = "localhost";
$username = "root";
$password = "";
$database  = "db_perpustakaan";

$koneksi = mysqli_connect($localhost, $username, $password, $database);

if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Kode selanjutnya di sini


// Tutup pernyataan dan koneksi di luar dari blok kondisional
