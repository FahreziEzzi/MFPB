<?php
include "../koneksi.php";

$id = $_GET['id'];
$judul = $_POST['judul'];
$penulis = $_POST['penulis'];
$penerbit = $_POST['penerbit'];
$tahun_terbit = $_POST['tahun_terbit'];
$kategori_id = $_POST['kategori_id'];

$sql = "UPDATE buku SET judul='$judul',penulis='$penulis',penerbit='$penerbit',tahun_terbit='$tahun_terbit' WHERE id='$id'";
$result = mysqli_query($koneksi,$sql);

if($result){
    echo "<script>
        alert('Data berhasil diedit');
        window.location.href = 'index.php';
    </script>";
}
else{
    echo "<script>alert('error goblok')</script>";
}

?>
