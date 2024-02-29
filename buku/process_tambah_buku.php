<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_perpustakaan";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$judul = $_POST['judul'];
$penulis = $_POST['penulis'];
$penerbit = $_POST['penerbit'];
$tahun_terbit = $_POST['tahun_terbit'];
$stok = $_POST['stok'];
$kategori_id = $_POST['kategori_id'];
$deskripsi = $_POST['deskripsi'];

// Menambahkan kolom baru untuk menyimpan link e-book
$link_ebook = $_POST['link_ebook'];

$targetDir = "uploads/";
$coverFileName = basename($_FILES["cover"]["name"]);
$targetFilePath = $targetDir . $coverFileName;
$coverFileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

move_uploaded_file($_FILES["cover"]["tmp_name"], $targetFilePath);

$query = "INSERT INTO buku (perpus_id, judul, penulis, penerbit, tahun_terbit, stok, kategori_id, cover, deskripsi, link_ebook) 
          VALUES (1, '$judul', '$penulis', '$penerbit', '$tahun_terbit', '$stok', '$kategori_id', '$targetFilePath', '$deskripsi', '$link_ebook')";

if ($conn->query($query) === TRUE) {
    header("location: index.php");
} else {
    echo "Error: " . $query . "<br>" . $conn->error;
}
$conn->close();
?>