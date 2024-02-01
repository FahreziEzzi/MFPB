<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (empty($_SESSION['role'])) {
    header("Location: login.php"); // Redirect setelah menambah buku
}


// Sertakan file functions.php yang berisi definisi fungsi
include('functions.php');

// Panggil fungsi untuk mendapatkan semua buku
$books = getAllBooks();

// Tambahkan data buku jika form tambah buku disubmit
if (isset($_POST['add_book'])) {
    $judul = $_POST['judul'];
    $penulis = $_POST['penulis'];
    $penerbit = $_POST['penerbit'];
    $tahun_terbit = $_POST['tahun_terbit'];
    $gambar = $_FILES['gambar'];

    // Panggil fungsi untuk menambah buku
    $result = addBook($judul, $penulis, $penerbit, $tahun_terbit, $gambar);

    if ($result) {
        header("Location: index.php"); // Redirect setelah menambah buku
    } else {
        echo "Gagal menambah buku.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Head section -->
</head>

<body>
    <!-- Content section -->
    <h1>Data Buku</h1>

    <!-- Tampilkan buku-buku -->
    <?php foreach ($books as $book) : ?>
        <div>
            <img src="<?= $book['gambar']; ?>" alt="<?= $book['judul']; ?>" style="max-width: 150px;">
            <h2><?= $book['judul']; ?></h2>
            <p>Penulis: <?= $book['penulis']; ?></p>
            <p>Penerbit: <?= $book['penerbit']; ?></p>
            <p>Tahun Terbit: <?= $book['tahun_terbit']; ?></p>
            <a href="edit.php?id=<?= $book['id']; ?>">Edit</a>
            <a href="delete.php?id=<?= $book['id']; ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus buku ini?')">Delete</a>
        </div>
    <?php endforeach; ?>

    <!-- Form tambah buku -->
    <form action="index.php" method="post" enctype="multipart/form-data">
        <label for="judul">Judul:</label>
        <input type="text" name="judul" required><br>
        <label for="penulis">Penulis:</label>
        <input type="text" name="penulis" required><br>
        <label for="penerbit">Penerbit:</label>
        <input type="text" name="penerbit" required><br>
        <label for="tahun_terbit">Tahun Terbit:</label>
        <input type="text" name="tahun_terbit" required><br>
        <label for="gambar">Gambar:</label>
        <input type="file" name="gambar" accept="image/*" required><br>
        <button type="submit" name="add_book">Tambah Buku</button>
    </form>
</body>

</html>