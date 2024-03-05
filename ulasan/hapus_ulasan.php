<?php
session_start();
include "../koneksi.php";
if (!isset($_SESSION['username'])) {
    header("Location: ../login.php"); 
    exit();
}
// Pastikan hanya admin yang dapat mengakses halaman ini
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    // Jika bukan admin, redirect ke halaman lain atau tampilkan pesan error
    echo "Anda tidak memiliki izin untuk mengakses halaman ini";
    exit();
}

// Pastikan id ulasan dikirim melalui parameter GET
if (!isset($_GET['id'])) {
    // Jika tidak ada id ulasan, redirect ke halaman lain atau tampilkan pesan error
    echo "ID ulasan tidak ditemukan";
    exit();
}

$ulasan_id = $_GET['id'];

// Lakukan penghapusan ulasan dari database
$deleteQuery = "DELETE FROM ulasan_buku WHERE id = $ulasan_id";
$result = mysqli_query($koneksi, $deleteQuery);

if ($result) {
    // Redirect ke halaman sebelumnya atau halaman lain jika berhasil menghapus ulasan
    header("Location: index.php?id=$buku_id");
    exit();
} else {
    // Tampilkan pesan error jika gagal menghapus ulasan
    echo "Gagal menghapus ulasan.";
}
?>