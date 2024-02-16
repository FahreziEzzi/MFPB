<?php
include('functions.php');
if (isset($_POST['add_book'])) {
    $judul = $_POST['judul'];
    $penulis = $_POST['penulis'];
    $penerbit = $_POST['penerbit'];
    $tahun_terbit = $_POST['tahun_terbit'];
    $gambar = uploadImage('gambar');

    $result = addBook($judul, $penulis, $penerbit, $tahun_terbit, $gambar);

    if ($result) {
        header('Location: data_buku.php');
        exit();
    } else {
        echo 'Gagal menambahkan buku';
    }
}
if (isset($_POST['update_book'])) {
    $bookId = $_POST['edit_book_id'];
    $judul = $_POST['edit_judul'];
    $penulis = $_POST['edit_penulis'];
    $penerbit = $_POST['edit_penerbit'];
    $tahun_terbit = $_POST['edit_tahun_terbit'];
    $gambar = uploadImage('edit_gambar');

    $result = updateBook($bookId, $judul, $penulis, $penerbit, $tahun_terbit, $gambar);

    if ($result) {
        header('Location: data_buku.php');
        exit();
    } else {
        echo 'Gagal update buku';
    }
}
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
function uploadImage($inputName)
{
    $targetDir = 'uploads/';
    $targetFile = $targetDir . basename($_FILES[$inputName]['name']);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
    $check = getimagesize($_FILES[$inputName]['tmp_name']);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        $uploadOk = 0;
    }
    if (file_exists($targetFile)) {
        $uploadOk = 0;
    }
    if ($_FILES[$inputName]['size'] > 500000) {
        $uploadOk = 0;
    }
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
