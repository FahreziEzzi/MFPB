<?php
session_start();

// Include necessary configuration and function files
include '../koneksi.php';

// Ensure user has logged in
if (!isset($_SESSION['username'])) {
    header("Location: ../login.php"); 
    exit();
}

$bookId = $_GET['id'];
$username = $_SESSION['username'];


$query = "SELECT id FROM user WHERE username = '$username'";
$result = mysqli_query($koneksi, $query);

$row = mysqli_fetch_assoc($result);
$userId = $row['id'];



// Query untuk memeriksa apakah pengguna sudah meminjam buku tersebut
$query_check_borrowed = "SELECT * FROM peminjaman WHERE user = '$userId' AND buku = '$bookId' AND status_peminjaman = 'Dipinjam'";
$result_check_borrowed = mysqli_query($koneksi, $query_check_borrowed);

// Jika pengguna belum meminjam buku, redirect kembali ke halaman index
if (!$result_check_borrowed || mysqli_num_rows($result_check_borrowed) == 0) {
    echo "<script>alert('Anda belum meminjam buku ini.'); window.location.href = 'index.php';</script>";
    exit();
}

// Check if the request method is GET
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['id'])) {
        $bookId = $_GET['id'];


        // Query to get book information
        $bookQuery = "SELECT * FROM buku WHERE id = $bookId";
        $bookResult = mysqli_query($koneksi, $bookQuery);
        // Ensure the book is found
        if (mysqli_num_rows($bookResult) > 0) {
            $bookData = mysqli_fetch_assoc($bookResult);
            $pdfPath = '../buku/' . $bookData['pdf']; // Adjust the path to the PDF file
            // Ensure the PDF file exists
            if (file_exists($pdfPath)) {
                // Set headers to display the PDF inline
                header('Content-Type: text/html'); // Set content type to HTML

                // Output HTML and JavaScript to embed PDF
                include 'readbook.php';
                exit();
            } else {
                // If the PDF file is not found, show an error message
                echo "File PDF tidak ditemukan.";
                exit();
            }
        } else {
            // If the book is not found, show an error message
            echo "Buku tidak ditemukan.";
            exit();
        }
    } else {
        // If the id parameter is missing, show an error message
        echo "Parameter id tidak ditemukan.";
        exit();
    }
} else {
    // If the request method is not GET, show an error message
    echo "Metode yang diterima hanya GET.";
    exit();
}
?>


?>