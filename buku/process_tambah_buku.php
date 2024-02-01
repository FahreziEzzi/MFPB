<?php
// Sambungkan ke database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_perpustakaan";

$conn = mysqli_connect($servername, $username, $password, $dbname);

// Periksa koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ambil data dari form
// Ambil data dari form
$judul = $_POST['judul'];
$penulis = $_POST['penulis'];
$penerbit = $_POST['penerbit'];
$tahun_terbit = $_POST['tahun_terbit'];
$kategori_id = $_POST['kategori_id'];

// Pastikan $kategori_id diapit dengan tanda kutip jika tipenya string
$query = "INSERT INTO buku (perpus_id, judul, penulis, penerbit, tahun_terbit, kategori_id) VALUES (1, '$judul', '$penulis', '$penerbit', $tahun_terbit, '$kategori_id')";

// ...

if ($conn->query($query) === TRUE) {
    header("location: index.php");
} else {
    echo "Error: " . $query . "<br>" . $conn->error;
}

// Tutup koneksi ke database
$conn->close();
?>
