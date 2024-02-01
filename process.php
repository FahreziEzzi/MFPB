<?php
include('functions.php');

// Tambah Buku
if (isset($_POST['add_book'])) {
    $judul = $_POST['judul'];
    $penulis = $_POST['penulis'];
    $penerbit = $_POST['penerbit'];
    $tahun_terbit = $_POST['tahun_terbit'];
    $gambar = uploadImage('gambar'); // Fungsi untuk mengunggah gambar, lihat di bawah

    $result = addBook($judul, $penulis, $penerbit, $tahun_terbit, $gambar);

    if ($result) {
        header('Location: data_buku.php');
        exit();
    } else {
        echo 'Gagal menambahkan buku';
    }
}

// Update Buku
if (isset($_POST['update_book'])) {
    $bookId = $_POST['edit_book_id'];
    $judul = $_POST['edit_judul'];
    $penulis = $_POST['edit_penulis'];
    $penerbit = $_POST['edit_penerbit'];
    $tahun_terbit = $_POST['edit_tahun_terbit'];
    $gambar = uploadImage('edit_gambar'); // Fungsi untuk mengunggah gambar, lihat di bawah

    $result = updateBook($bookId, $judul, $penulis, $penerbit, $tahun_terbit, $gambar);

    if ($result) {
        header('Location: data_buku.php');
        exit();
    } else {
        echo 'Gagal update buku';
    }
}

// Hapus Buku
if (isset($_GET['delete_book'])) {
    $bookId = $_GET['delete_book'];

    $result = deleteBook($bookId);

    if ($result) {
        header('Location: data_buku.php');
        exit();
    } else {
        echo 'Gagal menghapus buku';
    }
}

// Fungsi untuk mengunggah gambar
function uploadImage($inputName)
{
    $targetDir = 'uploads/';
    $targetFile = $targetDir . basename($_FILES[$inputName]['name']);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES[$inputName]['tmp_name']);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        $uploadOk = 0;
    }

    // Check if file already exists
    if (file_exists($targetFile)) {
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES[$inputName]['size'] > 500000) {
        $uploadOk = 0;
    }

    // Allow certain file formats
    if ($imageFileType != 'jpg' && $imageFileType != 'png' && $imageFileType != 'jpeg') {
        $uploadOk = 0;
    }

    if ($uploadOk == 0) {
        return null;
    } else {
        if (move_uploaded_file($_FILES[$inputName]['tmp_name'], $targetFile)) {
            return basename($_FILES[$inputName]['name']);
        } else {
            return null;
        }
    }
}
