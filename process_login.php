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


// Function to check credentials and get user role
function checkCredentials($email, $password)
{
    global $koneksi;

    // Protect against SQL Injection attacks
    $email = mysqli_real_escape_string($koneksi, $email);
    $password = mysqli_real_escape_string($koneksi, $password);

    // Query to get user data based on email
    $query = "SELECT * FROM user WHERE email = '$email'";
    $result = mysqli_query($koneksi, $query);

    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            $user = mysqli_fetch_assoc($result);

            // Verify password
            if (password_verify($password, $user['password'])) {
                // Valid credentials
                // return $user['role']; 
                 return $user; 
            }
        }
    }

    return false;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Capture data from login form
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Perform authentication and get user role
    $userRole = checkCredentials($email, $password);

    if ($userRole) {
        // Authentication successful

        if ($userRole['role'] === 'admin') {
            // If user is admin, redirect to admin dashboard
            $_SESSION['user_id'] = $userRole['id'];
            header("Location: dashboard.php");
            exit();
        } elseif ($userRole === 'peminjam' || $userRole === 'petugas') {
            // If user is peminjam or petugas, redirect to their respective dashboards
            $_SESSION['user_id'] = $userRole['id'];
            header("Location: dashboard_user.php");
            exit();
        }
    } else {
        // Authentication failed
        // Redirect back to the login page
        header("Location: login.php");
        exit();
    }
}
