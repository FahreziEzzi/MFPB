<?php
include "../koneksi.php";
$sql = "SELECT * FROM buku";
$resultBooks = mysqli_query($koneksi, $sql);
$query = "SELECT buku.id AS buku_id, buku.judul, ulasan_buku.ulasan, ulasan_buku.rating,
                  COUNT(ulasan_buku.id) AS jumlah_ulasan,
                  AVG(ulasan_buku.rating) AS rating
           FROM buku
           LEFT JOIN ulasan_buku ON buku.id = ulasan_buku.buku
           GROUP BY buku.id";

$resultUlasan = mysqli_query($koneksi, $query);
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css">

</head>
<style>
    .ulasan-sidebar {
        position: fixed;
        top: 80px;
        right: 20px;
        width: 300px;
        background-color: #ffffff;
        border: 1px solid #dddddd;
        padding: 15px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .ulasan-title {
        font-size: 18px;
        font-weight: bold;
        margin-bottom: 10px;
    }

    .ulasan-item {
        margin-bottom: 15px;
    }

    .ulasan-item p {
        margin-bottom: 5px;
    }
</style>


<body id="page-top">
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
                <a class="nav-link" href="../buku/">
                    <i class="fas fa-fw fa-book"></i>
                    <span>Data Buku</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../buku/">
                    <i class="fas fa-fw fa-user"></i>
                    <span>Data Pengguna</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../peminjaman/peminjaman.php">
                    <i class="fas fa-fw fa-handshake"></i>
                    <span>Peminjam</span></a>
            </li>
            <hr class="sidebar-divider">
            <li class="nav-item">
                <a class="nav-link" href="">
                    <i class="fas fa-fw fa-book"></i>
                    <span>Ulasan</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../laporan/laporan.php">
                    <i class="fas fa-fw fa-book"></i>
                    <span>Laporan</span></a>
            </li>
            <hr class="sidebar-divider">
            <li class="nav-item">
                <a class="nav-link" href="../registrasi_anggota.php">
                    <i class="fas fa-fw fa-user"></i>
                    <span>Registrasi</span></a>
            </li>
            <hr class="sidebar-divider d-none d-md-block">
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <div id="content-wrapper" class="d-flex flex-column">

            <div id="content">
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
                            </div>
                        </li>
                        <div class="topbar-divider d-none d-sm-block">
                        </div>
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">Admin</span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>
                    </ul>
                </nav>
                <div class="container-fluid">
                    <h1 class="h3 mb-3 text-gray-800">Ulasan Buku</h1>
                    <div class="row">
                        <div class="col-lg-8">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">Judul</th>
                                        <th scope="col">Jumlah Ulasan</th>
                                        <th scope="col">Rating</th>
                                        <th style="text-align: center;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($data = mysqli_fetch_assoc($resultUlasan)) : ?>
                                        <tr>
                                            <td><?= $data['buku_id'] ?></td>
                                            <td><?= $data['judul'] ?></td>
                                            <td><?= $data['jumlah_ulasan'] ?></td>
                                            <td><?= number_format($data['rating'], 2); ?></td>
                                            <td class="text-center">
                                                <a class="badge badge-danger" onclick="" href="tambah_ulasan.php?id=<?= $data['buku_id'] ?>">Tambah Ulasan</a>
                                                <a class="badge badge-success" href="lihat_ulasan.php?id=<?= $data['buku_id'] ?>">Lihat Ulasan</a>
                                            </td>
                                        </tr>
                                    <?php endwhile ?>
                                </tbody>
                            </table>
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
        </div>
        <a class="scroll-to-top rounded" href="#page-top">
            <i class="fas fa-angle-up"></i>
        </a>
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
                        <a class="btn btn-primary" href="login.php">Logout</a>
                    </div>
                </div>
            </div>
        </div>
        <script src="../sbadmin/vendor/jquery/jquery.min.js"></script>
        <script src="../sbadmin/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="../sbadmin/vendor/jquery-easing/jquery.easing.min.js"></script>
        <script src="../sbadmin/js/sb-admin-2.min.js"></script>
        <script src="../sbadmin/vendor/chart.js/Chart.min.js"></script>
        <script src="../sbadmin/js/demo/chart-area-demo.js"></script>
        <script src="../sbadmin/js/demo/chart-pie-demo.js"></script>
</body>

</html>