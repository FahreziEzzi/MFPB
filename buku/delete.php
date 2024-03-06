<?php
include "../koneksi.php";

$id = $_GET["id"];

if (isset($id)) {
    // Update nilai status_hapus menjadi 1
    $sql_update = "UPDATE buku SET status_hapus = 1 WHERE id = $id";
    if (mysqli_query($koneksi, $sql_update)) {
        // Jika penghapusan berhasil, redirect kembali ke halaman sebelumnya
        header("Location: index.php");
        exit();
    } else {
        // Jika terjadi kesalahan, tampilkan pesan kesalahan
        echo "Error: " . mysqli_error($koneksi);
    }
} else {
    // Jika parameter id tidak diterima, tampilkan pesan kesalahan
    echo "ID buku tidak ditemukan";
}
?>