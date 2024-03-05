<?php
session_start();

include '../koneksi.php';

// Check if the user is not logged in
if (!isset($_SESSION['username'])) {
    header("Location: ../login.php"); // Redirect to the login page if not logged in
    exit();
}

// Check if the kategori ID is provided in the URL
if (!isset($_GET['id'])) {
    $_SESSION['error'] = "Kategori ID tidak ditemukan";
    header("Location: index.php");
    exit();
}

// Get the kategori ID from the URL
$kategori_id = $_GET['id'];

// Delete the kategori from the database
$delete_query = "DELETE FROM kategori_buku WHERE id = $kategori_id";
if (mysqli_query($koneksi, $delete_query)) {
    header("Location: kategori.php");
    $_SESSION['success'] = "Kategori berhasil dihapus";
    exit();
} else {
    $_SESSION['error'] = "Gagal menghapus kategori: " . mysqli_error($koneksi);
}