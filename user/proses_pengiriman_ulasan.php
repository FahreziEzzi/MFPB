<?php
include "../koneksi.php";
if (!isset($_SESSION['username'])) {
    header("Location: ../login.php"); 
    exit();
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_buku = $_POST["id_buku"];
    $id_user = $_POST["id_user"];
    $rating = $_POST["rating"];
    $ulasan = $_POST["ulasan"];
    // $sinopsis = $_POST["sinopsis"];
    if ($rating > 5) {
        header("Location: tambah_ulasan.php?error=Rating tidak boleh melebihi 5");
        exit();
    }
    $query = "INSERT INTO ulasan_buku (buku, user, rating, ulasan) VALUES ('$id_buku', '$id_user', '$rating', '$ulasan')";
    $result = mysqli_query($koneksi, $query);
    if ($result) {
        header("Location: index.php?success=Ulasan berhasil dikirim");
        exit();
    } else {
        header("Location: index.php?error=Gagal menyimpan ulasan");
        exit();
    }
} else {
    header("Location: lihat_ulasan.php");
    exit();
}