<?php
session_start();

include '../koneksi.php';


if (!isset($_SESSION['username'])) {
    header("Location: ../login.php"); 
    exit();
}
function getLoggedInUserID($koneksi, $username) {
    $query = "SELECT id FROM user WHERE username = '$username'";
    $result = mysqli_query($koneksi, $query);

    $row = mysqli_fetch_assoc($result);
    $userId = $row['id'];

    return $userId;
}
$username = $_SESSION['username'];
$userId = getLoggedInUserID($koneksi, $username);

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])) {
    $bookId = $_GET['id'];
    $userId = $userId;
    
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
}
?>