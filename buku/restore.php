<?php
// Memulai sesi
session_start();

// Memeriksa apakah pengguna telah login
if (!isset($_SESSION['username'])) {
    // Jika tidak, redirect ke halaman login
    header("Location: ../login.php");
    exit();
}

// Memeriksa peran pengguna
$role = $_SESSION['role'];
if ($role !== 'admin') {
    // Jika peran bukan admin, redirect ke halaman lain atau tampilkan pesan kesalahan
    echo "Anda tidak memiliki izin untuk mengakses halaman ini.";
    exit();
}

// Memeriksa apakah ada ID buku yang dikirimkan melalui parameter GET
if (isset($_GET['id'])) {
    // Mengambil ID buku dari parameter GET
    $book_id = $_GET['id'];

    // Menghubungkan ke database (sesuaikan dengan koneksi Anda)
    include "../koneksi.php";

    // Query untuk mengubah status_hapus buku menjadi 0 (belum dihapus)
    $query = mysqli_query($koneksi, "UPDATE buku SET status_hapus = '0' WHERE id = '$book_id'");

    // Memeriksa apakah query berhasil dieksekusi
    if ($query) {
        // Jika berhasil, redirect kembali ke halaman sebelumnya atau halaman lain yang diinginkan
        header("Location: index.php");
        exit();
    } else {
        // Jika gagal, tampilkan pesan kesalahan atau lakukan penanganan yang sesuai
        echo "Gagal mengembalikan buku. Silakan coba lagi.";
        exit();
    }
} else {
    // Jika tidak ada ID buku yang dikirimkan melalui parameter GET, tampilkan pesan kesalahan atau redirect ke halaman lain yang diinginkan
    echo "ID buku tidak ditemukan.";
    exit();
}
?>
