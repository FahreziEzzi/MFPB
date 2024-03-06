<?php
include "../koneksi.php";

$id = $_GET["id"];

// Ambil status_hapus saat ini
$query = mysqli_query($koneksi, "SELECT status_hapus FROM buku WHERE id = '$id'");
$row = mysqli_fetch_assoc($query);
$status_hapus = $row['status_hapus'];

// Tentukan nilai yang akan diubah
$new_status = ($status_hapus == '1') ? '0' : '1';

// Lakukan update status_hapus
$result = mysqli_query($koneksi, "UPDATE buku SET status_hapus = '$new_status' WHERE id = '$id'");

if ($result) {
    $message = ($new_status == '1') ? "Data berhasil dipindahkan ke kolom status_hapus" : "Data berhasil dikembalikan dari status_hapus";
    echo "<script>
            alert('$message');
            window.location.href = 'index.php'
          </script>";
} else {
    echo "<script>alert('Error saat mengubah status data')</script>";
}
?>
