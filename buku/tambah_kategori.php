<?php
include '../koneksi.php';

session_start();

// Check apakah pengguna sudah login
if (!isset($_SESSION['username'])) {
    header("Location: ../login.php"); // Redirect ke halaman login jika belum login
    exit();
}

$username = $_SESSION['username'];

$query = "SELECT id, role FROM user WHERE username = '$username'";
$result = mysqli_query($koneksi, $query);

if (!$result) {
    // Handle error saat menjalankan query
    die("Query error: " . mysqli_error($koneksi));
}

$userData = mysqli_fetch_assoc($result);
$userRole = $userData['role'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $kategori = htmlspecialchars($_POST["kategori"]);

    // Lakukan penyimpanan ulasan dan rating ke database
    $insert_kategori_query = "INSERT INTO kategori_buku (nama_kategori, created_at) 
                            VALUES ('$kategori', current_timestamp())";

    $insert_kategori_result = mysqli_query($koneksi, $insert_kategori_query);

    if ($insert_kategori_result) {
        // Setelah penyimpanan berhasil
        header('location: index.php');
    } else {
        // Terdapat kesalahan saat query
        $error_message = "Terjadi kesalahan. Ulasan dan rating tidak dapat disimpan.";
    }
}
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

    <title>Tambah Ulasan</title>

    <!-- Custom fonts for this template-->
    <link href="../sbadmin/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

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
                    echo $userRole === 'admin' ? 'Admin' : 'Petugas';
                    ?>
                </div>
            </a>
            <hr class="sidebar-divider my-0">
            <li class="nav-item active">
                <a class="nav-link" href="../dashboard.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>
            <hr class="sidebar-divider">
            <?php
            if ($userRole === 'admin') :
            ?>
                <li class="nav-item side">
                    <a class="nav-link" href="../buku/index.php">
                        <i class="fas fa-fw fa-book"></i>
                        <span>Data Buku</span></a>
                </li>
                <li class="nav-item side">
                    <a class="nav-link" href="../datapengguna/data_pengguna.php">
                        <i class="fas fa-fw fa-user"></i>
                        <span>Data Pengguna</span></a>
                </li>
                <li class="nav-item side">
                    <a class="nav-link" href="../peminjaman/peminjaman.php">
                        <i class="fas fa-fw fa-handshake"></i>
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
                        <i class="fas fa-fw fa-book"></i>
                        <span>Laporan</span></a>
                </li>
                <hr class="sidebar-divider">
                <li class="nav-item side">
                    <a class="nav-link" href="../registrasi_anggota.php">
                        <i class="fas fa-fw fa-user"></i>
                        <span>Registrasi</span></a>
                </li>
                <li class="nav-item side">
                    <a class="nav-link" href="../logout.php">
                        <i class="fas fa-fw fa-user"></i>
                        <span>Logout</span></a>
                </li>

            <?php endif ?>
            <?php
            if ($userRole === 'petugas') :
            ?>
                <li class="nav-item side">
                    <a class="nav-link" href="../buku/index.php">
                        <i class="fas fa-fw fa-book"></i>
                        <span>Data Buku</span></a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="../peminjaman/peminjaman.php">
                        <i class="fas fa-fw fa-file-alt"></i>
                        <span>Peminjam</span></a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="../laporan/laporan.php">
                        <i class="fas fa-print"></i>
                        <span>Laporan</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../logout.php">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Logout</span></a>
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
                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                                    <?= $_SESSION['username']; ?>
                                </span>
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
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
                <div class="container-fluid col-lg-6">
                    <div class="d-sm-flex justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Kategori</h1>
                    </div>

                    <form class="user" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                        <!-- Tambahkan pesan sukses jika ada -->
                        <?php if (isset($success_message)) { ?>
                            <div class="alert alert-success" role="alert">
                                <?php echo $success_message; ?>
                            </div>
                        <?php } ?>
                        <!-- Tambahkan pesan error jika ada -->
                        <?php if (isset($error_message)) { ?>
                            <div class="alert alert-danger" role="alert">
                                <?php echo $error_message; ?>
                            </div>
                        <?php } ?>


                        <div class="form-group">
                            <label for="kategori">Nama Kategori</label>
                            <textarea class="form-control rounded" id="Kategori" name="kategori" placeholder="Kategori" required></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary btn-user btn-block">
                            Tambah Kategori
                        </button>
                        <hr>
                    </form>
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
        <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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