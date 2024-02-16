<?php
include('koneksi.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); 
    $full_name = $_POST['full_name'];
    $address = $_POST['address'];
    $role = $_POST['role'];

    $query = "INSERT INTO `user` (`perpus_id`, `username`, `password`, `email`, `nama_lengkap`, `alamat`, `role`, `created_at`) 
              VALUES (1, '$username', '$password', '$email', '$full_name', '$address', '$role', current_timestamp())";

    $result = mysqli_query($koneksi, $query);
    if ($result) {
        echo "<alert>Akun Berhasil Ditambahkan</alert>";
        if($_POST['page'] == "admin_page"){
            header('Location: registrasi_anggota.php');
        }
        else{
            header('Location: login.php');
        }
        exit();
    } else {
        echo "Error: " . mysqli_error($connection);
    }

   
}