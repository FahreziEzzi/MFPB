<?php
// Sesuaikan koneksi database sesuai kebutuhan Anda
include "../koneksi.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari formulir
    $id_buku = $_POST["id_buku"];
    $id_user = $_POST["id_user"];
    $rating = $_POST["rating"];
    $ulasan = $_POST["ulasan"];

    // Validasi rating agar tidak melebihi 5
    if ($rating > 5) {
        // Redirect ke halaman sebelumnya dengan pesan error
        header("Location: tambah_ulasan.php?error=Rating tidak boleh melebihi 5");
        exit();
    }

    // Query untuk menyimpan ulasan dan rating ke database
    $query = "INSERT INTO ulasan_buku (buku, user, rating, ulasan) VALUES ('$id_buku', '$id_user', '$rating', '$ulasan')";
    $result = mysqli_query($koneksi, $query);

    if ($result) {
        // Jika berhasil disimpan, redirect ke halaman sebelumnya dengan pesan sukses
        header("Location: index.php?success=Ulasan berhasil dikirim");
        exit();
    } else {
        // Jika gagal disimpan, redirect ke halaman sebelumnya dengan pesan error
        header("Location: index.php?error=Gagal menyimpan ulasan");
        exit();
    }
} else {
    // Jika bukan metode POST, redirect ke halaman sebelumnya
    header("Location: index.php");
    exit();
}
