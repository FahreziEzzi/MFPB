<?php
session_start();

include '../koneksi.php';

if (!isset($_SESSION['username'])) {
    header("Location: ../login.php"); 
    exit();
}
if (!isset($_SESSION['username'])) {
    echo "<script>alert('Tolong login terlebih dahulu'); window.location.href = '../login.php';</script>";
    exit();
}
function countUserBorrowedBooks($koneksi, $userId) {
    $countQuery = "SELECT COUNT(*) AS total FROM peminjaman WHERE user = $userId AND status_peminjaman = 'Dipinjam'";
    $result = mysqli_query($koneksi, $countQuery);
    $data = mysqli_fetch_assoc($result);
    return $data['total'];
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
    
    // Periksa apakah pengguna telah mencapai batas maksimal peminjaman (3)
    $borrowedBooksCount = countUserBorrowedBooks($koneksi, $userId);
    if ($borrowedBooksCount >= 3) {
        echo "<script>alert('Anda telah mencapai batas maksimal peminjaman'); window.location.href = 'index.php';</script>";
        exit();
    }
    
    // Masukkan tanggal peminjaman (hari ini)
    $tanggalPeminjaman = date('Y-m-d');

    // Set tanggal pengembalian default menjadi 0
    $tanggalPengembalian = date('Y-m-d', strtotime('+5 days'));;

    // Cek stok buku sebelum melakukan peminjaman
    $getBookQuery = "SELECT stok FROM buku WHERE id = $bookId";
    $getBookResult = mysqli_query($koneksi, $getBookQuery);

    if ($getBookResult) {
        $bookData = mysqli_fetch_assoc($getBookResult);
        $stok = $bookData['stok'];

        // Pastikan stok mencukupi sebelum melakukan peminjaman
        if ($stok > 0) {
            // Kurangi stok buku
            $updateStokQuery = "UPDATE buku SET stok = stok - 1 WHERE id = $bookId";
            mysqli_query($koneksi, $updateStokQuery);

            // Masukkan entri baru ke dalam tabel peminjaman
            $insertPeminjamanQuery = "INSERT INTO `peminjaman` (`user`, `buku`, `tanggal_peminjaman`, `tanggal_pengembalian`, `status_peminjaman`, `created_at`) VALUES ($userId, $bookId, '$tanggalPeminjaman', '$tanggalPengembalian', 'Dipinjam', current_timestamp())";

            if (mysqli_query($koneksi, $insertPeminjamanQuery)) {
                // Peminjaman berhasil, alihkan kembali pengguna ke halaman utama atau berikan pesan konfirmasi
                header("Location: index.php");
                exit();
            } else {
                // Jika terjadi kesalahan saat melakukan peminjaman, berikan pesan kesalahan atau tangani sesuai kebutuhan
                echo "Error: " . $insertPeminjamanQuery . "<br>" . mysqli_error($koneksi);
            }
        } else {
            // Jika stok buku tidak mencukupi
            echo "Stok buku tidak mencukupi.";
        }
    } else {
        // Jika gagal mengambil data buku
        echo "Gagal mengambil data buku.";
    }
}

?>