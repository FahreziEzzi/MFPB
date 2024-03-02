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
$pdf = $_POST['pdf'];
$deskripsi = $_POST['deskripsi'];

$targetDir = "uploads/";
$targetpdf = "pdf/";
$coverFileName = basename($_FILES["cover"]["name"]);
$targetFilePath = $targetDir . $coverFileName;
$coverFileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

// Memindahkan file sampul yang diunggah ke direktori yang ditentukan
move_uploaded_file($_FILES["cover"]["tmp_name"], $targetFilePath);

// Perbarui variabel-variabel terkait file PDF
$pdfFileName = basename($_FILES["pdf"]["name"]);
$pdfFilePath = $targetpdf . $pdfFileName;
$pdfFileType = pathinfo($pdfFilePath, PATHINFO_EXTENSION);

// Memindahkan file PDF yang diunggah ke direktori yang ditentukan
move_uploaded_file($_FILES["pdf"]["tmp_name"], $pdfFilePath);

$query = "INSERT INTO buku (perpus_id, judul, penulis, penerbit, tahun_terbit, stok, kategori_id, cover, deskripsi, pdf) 
          VALUES (1, '$judul', '$penulis', '$penerbit', '$tahun_terbit', '$stok', '$kategori_id', '$targetFilePath', '$deskripsi', '$pdfFilePath')";

if ($conn->query($query) === TRUE) {
    header("location: index.php");
} else {
    echo "Error: " . $query . "<br>" . $conn->error;
}
$conn->close();
?>