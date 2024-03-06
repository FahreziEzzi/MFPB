<?php
    include "../koneksi.php";
    
    $id = $_GET["id"];
    $result = mysqli_query($koneksi,"DELETE FROM buku WHERE id = '$id'");

    if($result){
        echo "<script>
            alert('Data berhasil dihapus');
            window.location.href = 'index.php'
        </script>";
    }else{
        echo "<script>alert('Error saat menghapus data')</script>";
    }
    
?>