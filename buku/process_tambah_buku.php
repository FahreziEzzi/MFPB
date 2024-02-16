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
$kategori_id = $_POST['kategori_id'];

$targetDir = "uploads/"; 
$coverFileName = basename($_FILES["cover"]["name"]);
$targetFilePath = $targetDir . $coverFileName;
$coverFileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

move_uploaded_file($_FILES["cover"]["tmp_name"], $targetFilePath);

$query = "INSERT INTO buku (perpus_id, judul, penulis, penerbit, tahun_terbit, kategori_id, cover) VALUES (1, '$judul', '$penulis', '$penerbit', $tahun_terbit, '$kategori_id', '$targetFilePath')";



if ($conn->query($query) === TRUE) {
    header("location: index.php");
} else {
    echo "Error: " . $query . "<br>" . $conn->error;
}
$conn->close();
?>
