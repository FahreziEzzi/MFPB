<?php
session_start();

include '../koneksi.php';

function getLoggedInUserID($koneksi, $username) {
    $query = "SELECT id FROM user WHERE username = '$username'";
    $result = mysqli_query($koneksi, $query);

    $row = mysqli_fetch_assoc($result);
    $userId = $row['id'];

    return $userId;
}


if (!isset($_SESSION['username'])) {
    header("Location: ../login.php"); 
    exit();
}

$username = $_SESSION['username'];


$userId = getLoggedInUserID($koneksi, $username);

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])) {
    $bookId = $_GET['id'];
    $userId = $userId;

    // Periksa apakah buku sudah dipinjam sebelumnya
    $checkPeminjamanQuery = "SELECT * FROM peminjaman WHERE user = $userId AND buku = $bookId AND status_peminjaman = 'Dipinjam'";
    $checkPeminjamanResult = mysqli_query($koneksi, $checkPeminjamanQuery);

    if (mysqli_num_rows($checkPeminjamanResult) > 0) {
        // Jika buku sudah dipinjam, tambahkan tanggal_pengembalian hari ini
        $tanggalPengembalian = date('Y-m-d');

        // Perbarui status peminjaman menjadi 'Dikembalikan' dan tambahkan tanggal pengembalian
        $updatePeminjamanQuery = "UPDATE peminjaman SET tanggal_pengembalian = '$tanggalPengembalian', status_peminjaman = 'Dikembalikan' WHERE user = $userId AND buku = $bookId AND status_peminjaman = 'Dipinjam'";
        
        if (mysqli_query($koneksi, $updatePeminjamanQuery)) {
            // Pengembalian berhasil, alihkan kembali pengguna ke halaman utama atau berikan pesan konfirmasi
            header("Location: index.php");
            exit();
        } else {
            // Jika terjadi kesalahan saat melakukan pengembalian, berikan pesan kesalahan atau tangani sesuai kebutuhan
            echo "Error: " . $updatePeminjamanQuery . "<br>" . mysqli_error($koneksi);
        }
    } else {
        // Jika buku belum dipinjam, berikan pesan kepada pengguna atau tangani sesuai kebutuhan
        echo "Buku belum dipinjam.";
        exit();
    }
} else {
    // Jika tidak ada parameter ID buku yang diberikan, alihkan pengguna kembali ke halaman utama atau berikan pesan kesalahan
    header("Location: index.php");
    exit();
}
?>
