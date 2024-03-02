<?php
// Pastikan session sudah dimulai
include('../koneksi.php');
session_start();

// Periksa apakah parameter ID buku ada dalam URL
if (isset($_GET['id'])) {
    $bookId = $_GET['id'];

    // Periksa apakah pengguna sudah login
    if (isset($_SESSION['user_id'])) {
        $userId = $_SESSION['user_id'];

        // Periksa apakah pengguna telah meminjam buku
        $checkQuery = "SELECT * FROM peminjaman WHERE buku = ? AND user = ?";
        $stmt = mysqli_prepare($koneksi, $checkQuery);
        mysqli_stmt_bind_param($stmt, "ii", $bookId, $userId);
        mysqli_stmt_execute($stmt);
        $checkResult = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($checkResult) > 0) {
            // Pengguna telah meminjam buku, maka berikan akses
            $query = "SELECT * FROM buku WHERE id = $bookId";
            $result = mysqli_query($koneksi, $query);
            $book = mysqli_fetch_assoc($result);

            // HTML untuk menampilkan PDF
            ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PDF Viewer</title>
</head>

<body>
    <iframe src="../buku/<?php echo $book['pdf']; ?>" width="100%" height="600px"></iframe>
</body>

</html>
<?php
        } else {
            echo "Anda belum meminjam buku ini.";
        }
    } else {
        echo "Anda harus login untuk mengakses buku ini.";
    }
} else {
    echo "Parameter ID buku tidak ditemukan.";
}
?>