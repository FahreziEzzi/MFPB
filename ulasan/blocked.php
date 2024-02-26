<?php
include '../koneksi.php';

session_start();

// Check apakah pengguna sudah login
if (!isset($_SESSION['username'])) {
    header("Location: ../login.php"); // Redirect ke halaman login jika belum login
    exit();
}

$username = $_SESSION['username'];



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data yang dikirimkan dari form
    $username = htmlspecialchars($_POST["username"]);
    $email = htmlspecialchars($_POST["email"]);
    $password = password_hash(htmlspecialchars($_POST["password"]), PASSWORD_DEFAULT); // Hash password
    $nama_lengkap = htmlspecialchars($_POST["nama_lengkap"]);
    $alamat = htmlspecialchars($_POST["alamat"]);
    $role = htmlspecialchars($_POST["role"]); // Tambahkan baris ini untuk mengambil data role

    // Lakukan validasi dan pendaftaran
    if (!empty($username) && !empty($email) && !empty($password) && !empty($nama_lengkap) && !empty($alamat) && !empty($role)) {
        // Query untuk memeriksa apakah email sudah terdaftar
        $check_email_query = "SELECT * FROM `user` WHERE `email` = '$email'";
        $check_email_result = mysqli_query($koneksi, $check_email_query);

        if (mysqli_num_rows($check_email_result) == 0) {
            // Jika email belum terdaftar, lakukan pendaftaran
            $perpus_id = 0; // Sesuai dengan logika Anda

            // Query untuk memasukkan data user baru ke dalam database
            $register_query = "INSERT INTO `user` (`perpus_id`, `username`, `password`, `email`, `nama_lengkap`, `alamat`, `role`, `created_at`)
                              VALUES ('$perpus_id', '$username', '$password', '$email', '$nama_lengkap', '$alamat', '$role', current_timestamp())";

            $register_result = mysqli_query($koneksi, $register_query);

            if ($register_result) {
                // Pendaftaran berhasil
                $success_message = "Registrasi berhasil. Silakan login.";
            } else {
                // Terdapat kesalahan saat query
                $error_message = "Terjadi kesalahan. Silakan coba lagi.";
            }
        } else {
            // Email sudah terdaftar
            $error_message = "Email sudah terdaftar. Silakan gunakan email lain.";
        }
    } else {
        // Form tidak lengkap
        $error_message = "Semua field harus diisi.";
    }
}
$username = $_SESSION['username'];
$userRole = '';

// Anda perlu mendapatkan peran pengguna dari database atau sesuai logika bisnis Anda

// Contoh sederhana: Jika nama pengguna adalah 'petugas', maka peran adalah 'petugas'
if ($username == 'petugas') {
    $userRole = 'petugas';
} elseif ($username == 'admin') { // Jika nama pengguna adalah 'admin', maka peran adalah 'admin'
    $userRole = 'admin';
}

?>






<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Dashboard</title>

    <!-- Custom fonts for this template-->
    <link href="../sbadmin/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="../sbadmin/css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
            <?php if ($userRole == "petugas") : ?>
            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
                <div class="sidebar-brand-text mx-3">Petugas</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="../index.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Pendataan
            </div>

            <!-- Nav Item - Pendataan Barang atau Buku -->
            <li class="nav-item">
                <a class="nav-link" href="../buku/">
                    <i class="fas fa-fw fa-book"></i>
                    <span>Pendataan Barang/Buku</span>
                </a>
            </li>

            <!-- Nav Item - Peminjaman -->
            <li class="nav-item">
                <a class="nav-link" href="../peminjaman/">
                    <i class="fas fa-fw fa-handshake"></i>
                    <span>Peminjaman</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="../peminjaman/laporan.php">
                    <i class="fas fa-print"></i>
                    <span>Laporan</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="../logout.php">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span>
                </a>
            </li>


            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

            <?php elseif ($userRole == "admin") : ?>

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
                <div class="sidebar-brand-text mx-3">Admin</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="index.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Pendataan
            </div>

            <!-- Nav Item - Pendataan Barang atau Buku -->
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="fas fa-fw fa-book"></i>
                    <span>Pendataan Barang/Buku</span>
                </a>
            </li>

            <!-- Nav Item - Peminjaman -->
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="fas fa-fw fa-handshake"></i>
                    <span>Peminjaman</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="../peminjaman/laporan.php">
                    <i class="fas fa-print"></i>
                    <span>Laporan</span>
                </a>
            </li>

            <!-- Nav Item - Laporan -->
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="fas fa-fw fa-file-alt"></i>
                    <span>Laporan</span>
                </a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                List Buku
            </div>

            <!-- Nav Item - List Buku -->
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="fas fa-fw fa-list"></i>
                    <span>List Buku</span>
                </a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">
            <!-- Heading -->
            <div class="sidebar-heading">
                Account
            </div>

            <!-- Nav Item - List Buku -->
            <li class="nav-item">
                <a class="nav-link" href="registrasi.php">
                    <i class="fas fa-fw fa-user"></i>
                    <span>Registrasi</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="../user.php">
                    <i class="fas fa-fw fa-users"></i>
                    <span>Data Pengguna</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="../logout.php">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span>
                </a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>


            <?php endif; ?>

        </ul>
        <!-- End of Sidebar -->


        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                                    <?= $_SESSION['username']; ?>
                                </span>
                                <img class="img-profile rounded-circle" src="img/undraw_profile.svg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>
                    </ul>

                </nav>


                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container col-lg-6">

                    <!-- Begin Page Content -->
                    <div class="container-fluid">

                        <!-- 404 Error Text -->
                        <div class="text-center">
                            <div class="error mx-auto" data-text="404">404</div>
                            <p class="lead text-gray-800 mb-5">Page Not Found</p>
                            <p class="text-gray-500 mb-0">It looks like you found a glitch in the matrix...</p>
                            <a href="../dashboard.php">&larr; Back to Dashboard</a>
                        </div>

                    </div>
                    <!-- /.container-fluid -->
                </div>
                <!-- End Page Content -->




                <!-- Footer -->
                <footer class="sticky-footer bg-white">
                    <div class="container my-auto">
                        <div class="copyright text-center my-auto">
                            <span>Copyright &copy; Your Website 2021</span>
                        </div>
                    </div>
                </footer>
                <!-- End of Footer -->

            </div>
            <!-- End of Content Wrapper -->

        </div>
        <!-- End of Page Wrapper -->

        <!-- Scroll to Top Button-->
        <a class="scroll-to-top rounded" href="#page-top">
            <i class="fas fa-angle-up"></i>
        </a>

        <!-- Logout Modal-->
        <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                        <a class="btn btn-primary" href="../logout.php">Logout</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bootstrap core JavaScript-->
        <script src="../sbadmin/vendor/jquery/jquery.min.js"></script>
        <script src="../sbadmin/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

        <!-- Core plugin JavaScript-->
        <script src="../sbadmin/vendor/jquery-easing/jquery.easing.min.js"></script>

        <!-- Custom scripts for all pages-->
        <script src="../sbadmin/js/sb-admin-2.min.js"></script>

        <!-- Page level plugins -->
        <script src="../sbadmin/vendor/chart.js/Chart.min.js"></script>

        <!-- Page level custom scripts -->
        <script src="../sbadmin/js/demo/chart-area-demo.js"></script>
        <script src="../sbadmin/js/demo/chart-pie-demo.js"></script>

</body>

</html>