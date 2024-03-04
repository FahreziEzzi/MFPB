<?php
session_start();
include '../koneksi.php';

// Check if the user is not logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php"); // Redirect to the login page if not logged in
    exit();
}

// Fetch user role from the database based on the username in the session
$username = $_SESSION['username'];
$queryRole = "SELECT role FROM user WHERE username = '$username'";
$resultRole = mysqli_query($koneksi, $queryRole);

// Check if the query was successful
if ($resultRole) {
    // Fetch the role from the query result
    $rowRole = mysqli_fetch_assoc($resultRole);
    $role = $rowRole['role'];
} else {
    // Handle the case when the query fails
    // You can set a default role or redirect the user to an error page
    $role = 'role'; // For example, setting a default role to guest
}
// Check if a book ID is provided
if (!isset($_GET['id'])) {
    // Redirect or handle the case when no book ID is provided
    header("Location: ulasan.php");
    exit();
}

$bookId = $_GET['id'];
$query = "SELECT * FROM buku WHERE id = '$bookId'";

$result = mysqli_query($koneksi, $query);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <style>
    .nav-item.active .nav-link span {
        font-size: 17px !important;
    }

    .nav-item.side .nav-link span {
        font-size: 17px !important;


    }
    </style>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Buku</title>

    <!-- Custom fonts for this template-->
    <!-- SweetAlert CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10">
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
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-angry"></i>
                </div>
                <div class="sidebar-brand-text mx-3">
                    <?php
                    echo $role === 'admin' ? 'Admin' : 'Petugas';
                    ?>
                </div>
            </a>
            <hr class="sidebar-divider my-0">
            <li class="nav-item side">
                <a class="nav-link" href="../dashboard.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>
            <hr class="sidebar-divider">
            <?php
            if ($role === 'admin') :
            ?>
            <li class="nav-item active">
                <a class="nav-link" href="index.php">
                    <i class="fas fa-fw fa-book"></i>
                    <span>Data Buku</span></a>
            </li>
            <li class="nav-item side">
                <a class="nav-link" href="../pengembalian.php">
                    <i class="fas fa-fw fa-book"></i>
                    <span>Pengembalian Buku</span></a>
            </li>
            <li class="nav-item side">
                <a class="nav-link" href="../datapengguna/data_pengguna.php">
                    <i class="fas fa-fw fa-users"></i>
                    <span>Data Pengguna</span></a>
            </li>
            <li class="nav-item side">
                <a class="nav-link" href="../peminjaman/peminjaman.php">
                    <i class="fas fa-fw fa-user"></i>
                    <span>Peminjam</span></a>
            </li>
            <hr class="sidebar-divider">
            <li class="nav-item side">
                <a class="nav-link" href="../ulasan/index.php">
                    <i class="fas fa-fw fa-book"></i>
                    <span>Ulasan</span></a>
            </li>
            <li class="nav-item side">
                <a class="nav-link" href="../laporan/laporan.php">
                    <i class="fas fa-fw fa-print"></i>
                    <span>Laporan</span></a>
            </li>
            <hr class="sidebar-divider">
            <li class="nav-item side">
                <a class="nav-link" href="registrasi_anggota.php">
                    <i class="fas fa-fw fa-user-check"></i>
                    <span>Registrasi</span></a>
            </li>
            <li class="nav-item side">
                <a class="nav-link" href="../logout.php">
                    <i class="fas fa-fw fa-user"></i>
                    <span>Logout</span></a>
            </li>

            <?php endif ?>
            <?php
            if ($role === 'petugas') :
            ?>
            <li class="nav-item side">
                <a class="nav-link" href="../buku/index.php">
                    <i class="fas fa-fw fa-book"></i>
                    <span>Data Buku</span></a>
            </li>
            <li class="nav-item side">
                <a class="nav-link" href="../pengembalian.php">
                    <i class="fas fa-fw fa-book"></i>
                    <span>Pengembalian Buku</span></a>
            </li>
            <li class="nav-item side">
                <a class="nav-link" href="../peminjaman/peminjaman.php">
                    <i class="fas fa-fw fa-users"></i>
                    <span>Peminjam</span></a>
            </li>
            <li class="nav-item side">
                <a class="nav-link" href="../laporan/laporan.php">
                    <i class="fas fa-print"></i>
                    <span>Laporan</span></a>
            </li>
            <li class="nav-item side">
                <a class="nav-link" href="../logout.php" onclick="confirmLogout();">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span>
                </a>
            </li>

            <?php endif ?>
            <hr class="sidebar-divider d-none d-md-block">
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>
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




                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                                    <?= $_SESSION['username']; ?>
                                    <i class="fas fa-caret-down"></i>
                                </span>
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>
                    </ul>
                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <!-- Page Heading -->
                    <h1 class="h3 mb-4 text-gray-800 text-center">Detail Buku</h1>
                    <div class="row justify-content-center">
                        <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                        <div class="card mb-3" style="max-width: 800px;box-shadow: 0 4px 20px 0 rgba(0,0,0,0.4);">
                            <div class="row no-gutters">
                                <div class="col-md-4">
                                    <img src="<?= $row['cover']; ?>" class="card-img" alt="...">
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body">
                                        <h5 class="card-title font-weight-bold">Judul : <?= $row['judul']; ?></h5>
                                        <p class="card-text">Penulis : <?= $row['penulis']; ?></p>
                                        <p class="card-text">Tahun Terbit : <?= $row['tahun_terbit']; ?></p>
                                        <p class="card-text">Deskripsi : <br><?= $row['deskripsi']; ?></p>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endwhile; ?>
                    </div>

                </div>
                <!-- Footer -->
                <footer class="sticky-footer bg-white">
                    <div class="container my-auto">
                        <div class="copyright text-center my-auto">
                            <span>Copyright &copy; Your Website 2021</span>
                        </div>
                    </div>
                </footer>
                <!-- End of Footer -->
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
                        <div class="modal-body">Select "Logout" below if you are ready to end your current session.
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                            <a class="btn btn-primary" href="../logout.php">Logout</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- SweetAlert JS -->
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

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



            </script>
            <script>
            function confirmLogout() {
                if (confirm("Are you sure you want to logout?")) {
                    window.location.href = "logout.php"; // Redirect ke logout.php jika user menekan OK
                }
            }
            </script>

</body>

</html>