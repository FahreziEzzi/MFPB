<?php
$localhost = "localhost";
$username = "root";
$password = "";
$database  = "db_perpustakaan";

$koneksi = mysqli_connect($localhost, $username, $password, $database);
ob_start();
session_start();

if (!$koneksi) {
    die("Connection failed: " . mysqli_connect_error());
}

function checkCredentials($email, $password)
{
    global $koneksi;
    $email = mysqli_real_escape_string($koneksi, $email);
    $password = mysqli_real_escape_string($koneksi, $password);
    $query = "SELECT * FROM user WHERE email = '$email'";
    $result = mysqli_query($koneksi, $query);

    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            $user = mysqli_fetch_assoc($result);
            if (password_verify($password, $user['password'])) {
                return $user;
            }
        }
    }
    return false;
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];
    $userRole = checkCredentials($email, $password);
    if ($userRole) {
        $_SESSION['user_id'] = $userRole['id'];
        $_SESSION['role'] = $userRole['role'];
        $_SESSION['username'] = $userRole['username']; 
    
        if ($userRole['role'] === 'admin') {
            header("Location: dashboard.php");
            exit();
        } elseif ($userRole['role'] === 'peminjam') {
            header("Location: user/index.php");
            exit();
        } elseif ($userRole['role'] === 'petugas') {
            header("Location: dashboard.php");
            exit();
        }
    } else {
        header("Location: login.php");
        exit();
    }
}
