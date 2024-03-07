<?php
session_start();

include 'koneksi.php';
$role = $_SESSION['role'];
$username = $_SESSION['username'];
// Check if the user is not logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php"); // Redirect to the login page if not logged in
    exit();
}

// Fetch user role from the database based on the username in the session
$username = $_SESSION['username'];

// Handle jika tombol kembalikan diklik
if (isset($_POST['return'])) {
    // Ambil tanggal hari ini
    $today = date('Y-m-d');

    // Query untuk mengambil jumlah buku yang harus dikembalikan hari ini
    $queryBooksToReturn = "SELECT COUNT(id) AS total_books_to_return FROM peminjaman WHERE tanggal_pengembalian = '$today' AND status_peminjaman = 'dipinjam'";
    $resultBooksToReturn = mysqli_query($koneksi, $queryBooksToReturn);
    $rowBooksToReturn = mysqli_fetch_assoc($resultBooksToReturn);
    $totalBooksToReturn = $rowBooksToReturn['total_books_to_return'];

    // Jika tidak ada buku yang harus dikembalikan, tampilkan notifikasi
    if ($totalBooksToReturn == 0) {
        $error_message = "Tidak ada buku yang harus dikembalikan.";
    } else {
        // Ubah status peminjaman menjadi "dikembalikan"
        $sql = "UPDATE peminjaman SET status_peminjaman = 'dikembalikan' WHERE tanggal_pengembalian = '$today' AND status_peminjaman = 'dipinjam'";
        if (mysqli_query($koneksi, $sql)) {
            // Berhasil mengembalikan
            $success_message = "Buku berhasil dikembalikan!";

            // Tambah stok buku yang telah dikembalikan
            $updateStockQuery = "UPDATE buku SET stok = stok + 1 WHERE id IN (SELECT buku FROM peminjaman WHERE tanggal_pengembalian = '$today' AND status_peminjaman = 'dikembalikan')";
            mysqli_query($koneksi, $updateStockQuery);
        } else {
            // Gagal mengembalikan
            $error_message = "Buku Gagal Dikembalikan!";
        }
    }
}

$current_date = date('Y-m-d');

// Query untuk mengambil jumlah buku yang harus dikembalikan hari ini
$queryBooksToReturn = "SELECT COUNT(id) AS total_books_to_return FROM peminjaman WHERE tanggal_pengembalian = '$current_date' AND status_peminjaman = 'dipinjam'";
$resultBooksToReturn = mysqli_query($koneksi, $queryBooksToReturn);
$rowBooksToReturn = mysqli_fetch_assoc($resultBooksToReturn);
$totalBooksToReturn = $rowBooksToReturn['total_books_to_return'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <style>
    #searchDropdown {
        display: none;
    }

    .nav-item.active .nav-link span {
        font-size: 17px !important;
    }

    .nav-item.side .nav-link span {
        font-size: 17px !important;
    }

    .error-message {
        font-size: 14px;
    }
    </style>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Pengembalian Buku</title>
    <link href="sbadmin/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <link href="sbadmin/css/sb-admin-2.min.css" rel="stylesheet">
</head>

<body id="page-top">
    <div id="wrapper">
        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
            <a class="sidebar-brand d-flex align-items-center justify-content-center">
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
                <a class="nav-link" href="dashboard.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>
            <hr class="sidebar-divider">
            <?php
            if ($role === 'admin') :
            ?>
            <li class="nav-item side">
                <a class="nav-link" href="buku/index.php">
                    <i class="fas fa-fw fa-book"></i>
                    <span>Data Buku</span></a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="pengembalian.php">
                    <i class="fas fa-fw fa-book"></i>
                    <span>Pengembalian Buku</span></a>
            </li>
            <li class="nav-item side">
                <a class="nav-link" href="datapengguna/data_pengguna.php">
                    <i class="fas fa-fw fa-users"></i>
                    <span>Data Pengguna</span></a>
            </li>
            <li class="nav-item side">
                <a class="nav-link" href="peminjaman/peminjaman.php">
                    <i class="fas fa-fw fa-users"></i>
                    <span>Peminjaman</span></a>
            </li>
            <hr class="sidebar-divider">
            <li class="nav-item side">
                <a class="nav-link" href="ulasan/index.php">
                    <i class="fas fa-fw fa-book"></i>
                    <span>Ulasan</span></a>
            </li>
            <li class="nav-item side">
                <a class="nav-link" href="laporan/laporan.php">
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
                <a class="nav-link" href="#" onclick="confirmLogout();">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span>
                </a>
            </li>

            <?php endif ?>
            <?php
            if ($role === 'petugas') :
            ?>
            <li class="nav-item side">
                <a class="nav-link" href="buku/index.php">
                    <i class="fas fa-fw fa-book"></i>
                    <span>Data Buku</span></a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="pengembalian.php">
                    <i class="fas fa-fw fa-book"></i>
                    <span>Pengembalian Buku</span></a>
            </li>
            <li class="nav-item side">
                <a class="nav-link" href="peminjaman/peminjaman.php">
                    <i class="fas fa-fw fa-users"></i>
                    <span>Peminjaman</span></a>
            </li>
            <li class="nav-item side">
                <a class="nav-link" href="laporan/laporan.php">
                    <i class="fas fa-print"></i>
                    <span>Laporan</span></a>
            </li>
            <li class="nav-item side">
                <a class="nav-link" href="#" onclick="confirmLogout();">
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
                                <a id="logout" class="dropdown-item" href="#" data-toggle="modal"
                                    data-target="#logoutModal">
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
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Pengembalian Buku</h1>
                    </div>
                    <!-- Content Row -->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="container">
                                <div class="message">
                                    <?php
                                    if (isset($error_message)) {
                                        echo '<p class="error-message">' . $error_message . '</p>';
                                    } elseif (isset($success_message)) {
                                        echo '<p class="success">' . $success_message . '</p>';
                                    }
                                    ?>
                                </div>
                                <table class="table">
                                    <tr>
                                        <th>Jumlah Buku yang Harus Dikembalikan Hari Ini</th>
                                        <td><?php echo $totalBooksToReturn; ?></td>
                                    </tr>
                                </table>
                                <form method="post">
                                    <button type="submit" name="return" class="btn btn-primary">Kembalikan Buku</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- End of Main Content -->
            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="text-center my-auto">
                        <span>Copyright &copy; Your Website <?= date('Y'); ?></span>
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
                    <a class="btn btn-primary" href="logout.php">Logout</a>
                </div>
            </div>
        </div>
    </div>
    <script src="sbadmin/vendor/jquery/jquery.min.js"></script>
    <script src="sbadmin/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="sbadmin/vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="sbadmin/js/sb-admin-2.min.js"></script>
    <script src="sbadmin/vendor/chart.js/Chart.min.js"></script>
    <script src="sbadmin/js/demo/chart-area-demo.js"></script>
    <script src="sbadmin/js/demo/chart-pie-demo.js"></script>

    <script>
    $(document).ready(function() {
        // Mengatur tindakan logout saat tombol logout ditekan
        $('#logout').click(function() {
            // Redirect ke halaman logout.php atau sesuai halaman logout Anda
            window.location.href = 'login.php';
        });
    });

    function confirmLogout() {
        if (confirm("Apakah kamu yakin ingin logout?")) {
            window.location.href = "logout.php"; // Redirect ke logout.php jika user menekan OK
        }
    }
    </script>

</body>

</html>