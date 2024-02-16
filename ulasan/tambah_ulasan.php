<?php
session_start();
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
    <link href="../sbadmin/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="../sbadmin/css/sb-admin-2.min.css" rel="stylesheet">
</head>
<body id="page-top">
    <div id="wrapper">
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <div id="wrapper">
                    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
                        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
                            <div class="sidebar-brand-icon rotate-n-15">
                                <i class="fas fa-angry"></i>
                            </div>
                            <div class="sidebar-brand-text mx-3">Admin</div>
                        </a>

                        <hr class="sidebar-divider my-0">
                        <li class="nav-item active">
                            <a class="nav-link" href="../dashboard.php">
                                <i class="fas fa-fw fa-tachometer-alt"></i>
                                <span>Dashboard</span></a>
                        </li>
                        <hr class="sidebar-divider">
                        <li class="nav-item">
                            <a class="nav-link" href="../buku">
                                <i class="fas fa-fw fa-book"></i>
                                <span>Data Buku</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="">
                                <i class="fas fa-fw fa-handshake"></i>
                                <span>Peminjam</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="tables.html">
                                <i class="fas fa-fw fa-file-alt"></i>
                                <span>Laporan</span></a>
                        </li>
                        <hr class="sidebar-divider">
                        <li class="nav-item">
                            <a class="nav-link" href="../ulasan">
                                <i class="fas fa-fw fa-file-alt"></i>
                                <span>Ulasan</span></a>
                        </li>
                        <hr class="sidebar-divider">
                        <li class="nav-item">
                            <a class="nav-link" href="sbadmin/vendor/registrasi.php">
                                <i class="fas fa-fw fa-user"></i>
                                <span>Registrasi</span></a>
                        </li>
                        <hr class="sidebar-divider d-none d-md-block">
                        <div class="text-center d-none d-md-inline">
                            <button class="rounded-circle border-0" id="sidebarToggle"></button>
                        </div>
                    </ul>
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Tambah Ulasan dan Rating</h1>
                                    </div>
                                    <form class="user" action="proses_pengiriman_ulasan.php" method="post">
                                        <input type="hidden" name="id_buku" value="<?php echo $_GET['id'] ?>">
                                        <input type="hidden" name="id_user" value="<?php echo $_SESSION['user_id'] ?>">
                                        <div class="form-group">
                                            <label for="inputRating">Rating 1-5:</label>
                                            <input type="number" class="form-control" id="inputRating" name="rating" min="1" max="5" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputUlasan">Ulasan:</label>
                                            <textarea class="form-control" id="inputUlasan" name="ulasan" rows="3" required></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-user btn-block">Kirim Ulasan</button>
                                        <hr>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <footer class="sticky-footer bg-white">
        <div class="container my-auto">
            <div class="copyright text-center my-auto">
                <span>Copyright &copy; Your Website 2021</span>
            </div>
        </div>
    </footer>
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>
    <script src="../sbadmin/vendor/jquery/jquery.min.js"></script>
    <script src="../sbadmin/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../sbadmin/vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="../sbadmin/js/sb-admin-2.min.js"></script>
    <script src="../sbadmin/vendor/chart.js/Chart.min.js"></script>
    <script src="../sbadmin/js/demo/chart-area-demo.js"></script>
    <script src="../sbadmin/js/demo/chart-pie-demo.js"></script>
</body>
</html>