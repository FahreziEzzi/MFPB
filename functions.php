<?php
$localhost = "localhost";
$username = "root";
$password = "";
$database  = "db_perpustakaan";
$koneksi = mysqli_connect($localhost, $username, $password, $database);
if (!$koneksi) {
    die("Connection failed: " . mysqli_connect_error());
}
function getAllBooks()
{
    global $koneksi;
    $query = "SELECT * FROM buku";
    $result = mysqli_query($koneksi, $query);
    $books = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $books[] = $row;
    }
    return $books;
}
function addBook($judul, $penulis, $penerbit, $tahun_terbit, $gambar)
{
    global $koneksi;
    $judul = mysqli_real_escape_string($koneksi, $judul);
    $penulis = mysqli_real_escape_string($koneksi, $penulis);
    $penerbit = mysqli_real_escape_string($koneksi, $penerbit);
    $gambarPath = uploadImage($gambar);
    $query = "INSERT INTO buku (judul, penulis, penerbit, tahun_terbit, gambar) VALUES ('$judul', '$penulis', '$penerbit', '$tahun_terbit', '$gambarPath')";
    $result = mysqli_query($koneksi, $query);

    return $result;
}
function getBookById($bookId)
{
    global $koneksi;
    $query = "SELECT * FROM buku WHERE id = '$bookId'";
    $result = mysqli_query($koneksi, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        return mysqli_fetch_assoc($result);
    }
    return null;
}
function updateBook($bookId, $judul, $penulis, $penerbit, $tahun_terbit, $gambar)
{
    global $koneksi;
    $judul = mysqli_real_escape_string($koneksi, $judul);
    $penulis = mysqli_real_escape_string($koneksi, $penulis);
    $penerbit = mysqli_real_escape_string($koneksi, $penerbit);
    $gambarPath = uploadImage($gambar);
    $query = "UPDATE buku SET judul = '$judul', penulis = '$penulis', penerbit = '$penerbit', tahun_terbit = '$tahun_terbit', gambar = '$gambarPath' WHERE id = '$bookId'";
    $result = mysqli_query($koneksi, $query);
    return $result;
}
function deleteBook($bookId)
{
    global $koneksi;
    $book = getBookById($bookId);
    if ($book && !empty($book['gambar'])) {
        unlink($book['gambar']);
    }
    $query = "DELETE FROM buku WHERE id = '$bookId'";
    $result = mysqli_query($koneksi, $query);
    return $result;
}
function uploadImage($image)
{
    $targetDir = "uploads/";
    $targetFile = $targetDir . basename($image['name']);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
    $check = getimagesize($image["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        $uploadOk = 0;
    }
    if ($image["size"] > 500000) {
        $uploadOk = 0;
    }
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        $uploadOk = 0;
    }
    if ($uploadOk == 0) {
        return null;
    } else {
        if (move_uploaded_file($image["tmp_name"], $targetFile)) {
            return $targetFile;
        } else {
            return null;
        }
    }
}
?>
