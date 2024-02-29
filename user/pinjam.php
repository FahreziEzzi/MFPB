<?php
session_start();

include '../koneksi.php';

// Fungsi untuk mendapatkan ID pengguna yang sudah login
function getLoggedInUserID($koneksi, $username) {
    $query = "SELECT id FROM user WHERE username = '$username'";
    $result = mysqli_query($koneksi, $query);

    $row = mysqli_fetch_assoc($result);
    $userId = $row['id'];

    return $userId;
}

// Fungsi untuk menghitung jumlah buku yang telah dipinjam oleh pengguna
function countUserBorrowedBooks($koneksi, $userId) {
    $query = "SELECT COUNT(*) AS total FROM peminjaman WHERE user = $userId AND tanggal_pengembalian = '0000-00-00'";
    $result = mysqli_query($koneksi, $query);
    $row = mysqli_fetch_assoc($result);
    return $row['total'];
}

if (!isset($_SESSION['username'])) {
    header("Location: ../login.php"); 
    exit();
}

$username = $_SESSION['username'];
$userId = getLoggedInUserID($koneksi, $username);

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])) {
    $bookId = $_GET['id'];
    
    // Memeriksa jumlah buku yang telah dipinjam oleh pengguna
    $borrowedBooksCount = countUserBorrowedBooks($koneksi, $userId);

    // Jika jumlah buku yang dipinjam masih kurang dari batas maksimum (3 buku), lanjutkan proses peminjaman
    if ($borrowedBooksCount < 3) {
        // Masukkan tanggal peminjaman (hari ini)
        $tanggalPeminjaman = date('Y-m-d');

        // Set tanggal pengembalian default menjadi 0
        $tanggalPengembalian = '0000-00-00';

        // Masukkan entri baru ke dalam tabel peminjaman tanpa memeriksa stok buku
        $insertPeminjamanQuery = "INSERT INTO peminjaman (user, buku, tanggal_peminjaman, tanggal_pengembalian, status_peminjaman, created_at) VALUES ($userId, $bookId, '$tanggalPeminjaman', '$tanggalPengembalian', 'Dipinjam', current_timestamp())";

        if (mysqli_query($koneksi, $insertPeminjamanQuery)) {
            // Peminjaman berhasil, alihkan kembali pengguna ke halaman utama atau berikan pesan konfirmasi
            header("Location: index.php");
            exit();
        } else {
            // Jika terjadi kesalahan saat melakukan peminjaman, berikan pesan kesalahan atau tangani sesuai kebutuhan
            echo "Error: " . $insertPeminjamanQuery . "<br>" . mysqli_error($koneksi);
        }
    } else {
        // Jika jumlah buku yang dipinjam sudah mencapai batas maksimum, simpan pesan notifikasi ke dalam session
        $_SESSION['notification'] = "Anda sudah meminjam 3 buku, tidak bisa meminjam buku lain lagi";
        // Redirect user ke halaman utama atau halaman lain jika diperlukan
        header("Location: index.php");
        exit();
    }
}

// Dapatkan stok buku dari database
$getStockQuery = "SELECT stok FROM buku WHERE id = $bookId";
$stockResult = mysqli_query($koneksi, $getStockQuery);
$row = mysqli_fetch_assoc($stockResult);
$currentStock = $row['stok'];

// Kurangi stok buku yang telah dipinjam
$newStock = $currentStock - 1;

// Perbarui stok buku di database
$updateStockQuery = "UPDATE buku SET stok = $newStock WHERE id = $bookId";
mysqli_query($koneksi, $updateStockQuery);

?>