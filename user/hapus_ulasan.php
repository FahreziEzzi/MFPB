<?php
session_start();
include "../koneksi.php";

$ulasan_id = $_GET['id'];

// Hapus ulasan dari database
$deleteQuery = "DELETE FROM ulasan_buku WHERE id = $ulasan_id";
$result = mysqli_query($koneksi, $deleteQuery);

if ($result) {
    // Redirect ke halaman ulasan
    header("Location: index.php?id=$buku_id");
    exit();
} else {
    echo "Gagal menghapus ulasan.";
}
?>