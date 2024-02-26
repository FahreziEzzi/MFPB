<?php
session_start();
include "../koneksi.php";

$role = $_SESSION['role'];
$filter_condition = '';
if ($role !== 'admin') {
    $filter_condition = "WHERE role = '$role'";
}

// Inisialisasi variabel filter berdasarkan nilai yang dikirimkan melalui AJAX
if (isset($_GET['role_filter']) && !empty($_GET['role_filter'])) {
    $selected_role = $_GET['role_filter'];
    if ($selected_role !== 'all') {
        $filter_condition = "WHERE role = '$selected_role'";
    }
}

$sql = "SELECT * FROM user $filter_condition";
$result = mysqli_query($koneksi, $sql);

$totalRows = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM user $filter_condition"));

// Batasan baris per halaman
$rowsPerPage = 5;

// Menghitung total halaman
$totalPages = ceil($totalRows / $rowsPerPage);

// Mendapatkan nomor halaman dari permintaan GET, atau menggunakan halaman pertama sebagai default
$currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;

// Menghitung offset untuk kueri SQL berdasarkan halaman saat ini
$offset = ($currentPage - 1) * $rowsPerPage;

// Mengambil data pengguna untuk halaman saat ini
$sql = "SELECT * FROM user $filter_condition LIMIT $offset, $rowsPerPage";
$result = mysqli_query($koneksi, $sql);

// Tombol "Previous"
$prevPage = $currentPage - 1;
$prevDisabled = ($currentPage == 1) ? "disabled" : "";

// Tombol "Next"
$nextPage = $currentPage + 1;
$nextDisabled = ($currentPage == $totalPages) ? "disabled" : "";
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
    </style>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Dashboard</title>
    <link href="../sbadmin/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <link href="../sbadmin/css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">
    <div id="wrapper">
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
            <li class="nav-item side">
                <a class="nav-link" href="../buku/index.php">
                    <i class="fas fa-fw fa-book"></i>
                    <span>Data Buku</span></a>
            </li>
            <li class="nav-item side active">
                <a class="nav-link" href="">
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
                <a class="nav-link" href="../buku/index.php">
                    <i class="fas fa-fw fa-book"></i>
                    <span>Data Buku</span></a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="../peminjaman/peminjaman.php">
                    <i class="fas fa-fw fa-user"></i>
                    <span>Peminjam</span></a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="../laporan/laporan.php">
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

            <!-- Divider -->
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
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                                aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small"
                                            placeholder="Search for..." aria-label="Search"
                                            aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>
                        <div class="topbar-divider d-none d-sm-block">
                        </div>
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                                    <?= $_SESSION['username']; ?>
                                    <i class="fas fa-caret-down"></i>
                                </span>
                            </a>
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
                <div id="content-wrapper" class="d-flex flex-column">
                    <div id="content">
                        <div class="container-fluid">
                            <h1 class="h3 mb-3 text-gray-800">Data Pengguna</h1>
                            <h6>Filter Berdasarkan Role :</h6>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <select class="form-control" id="roleFilter">
                                        <option value="all">Semua Peran</option>
                                        <option value="admin" <?php echo ($role === 'admin') ? 'selected' : ''; ?>>Admin
                                        </option>
                                        <option value="petugas" <?php echo ($role === 'petugas') ? 'selected' : ''; ?>>
                                            Petugas</option>
                                        <option value="peminjam"
                                            <?php echo ($role === 'peminjam') ? 'selected' : ''; ?>>Peminjam</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Table section -->
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="table-responsive">
                                        <table class="table table-hover w-100">
                                            <thead>
                                                <tr>
                                                    <th scope="col">ID</th>
                                                    <th scope="col">Username</th>
                                                    <th scope="col">Email</th>
                                                    <th scope="col">Nama Lengkap</th>
                                                    <th scope="col">Alamat</th>
                                                    <th scope="col">Role</th>
                                                </tr>
                                            </thead>
                                            <tbody id="dataPengguna">
                                                <?php while ($data = mysqli_fetch_assoc($result)) : ?>
                                                <tr>
                                                    <td><?= $data['id'] ?></td>
                                                    <td><?= $data['username'] ?></td>
                                                    <td><?= $data['email'] ?></td>
                                                    <td><?= $data['nama_lengkap'] ?></td>
                                                    <td><?= $data['alamat'] ?></td>
                                                    <td><?= $data['role'] ?></td>
                                                </tr>
                                                <?php endwhile ?>
                                            </tbody>
                                        </table>
                                        <nav aria-label="Page navigation example">
                                            <ul class="pagination justify-content-center">
                                                <li class="page-item <?php echo $prevDisabled; ?>">
                                                    <a class="page-link" href="?page=<?php echo $prevPage; ?>"
                                                        tabindex="-1" aria-disabled="true">Previous</a>
                                                </li>
                                                <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                                                <li
                                                    class="page-item <?php echo ($currentPage == $i) ? "active" : ""; ?>">
                                                    <a class="page-link"
                                                        href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                                                </li>
                                                <?php endfor; ?>
                                                <li class="page-item <?php echo $nextDisabled; ?>">
                                                    <a class="page-link" href="?page=<?php echo $nextPage; ?>">Next</a>
                                                </li>
                                            </ul>
                                        </nav>
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
                        <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog"
                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">Select "Logout" below if you are ready to end your current
                                        session.</div>
                                    <div class="modal-footer">
                                        <button class="btn btn-secondary" type="button"
                                            data-dismiss="modal">Cancel</button>
                                        <a class="btn btn-primary" href="../login.php">Logout</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <script src="../sbadmin/vendor/jquery/jquery.min.js"></script>
                        <script src="../sbadmin/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
                        <script src="../sbadmin/vendor/jquery-easing/jquery.easing.min.js"></script>
                        <script src="../sbadmin/js/sb-admin-2.min.js"></script>
                        <script src="../sbadmin/vendor/chart.js/Chart.min.js"></script>
                        <script src="../sbadmin/vendor/jquery/jquery.min.js"></script>
                        <script src="../sbadmin/js/demo/chart-area-demo.js"></script>
                        <script src="../sbadmin/js/demo/chart-pie-demo.js"></script>
                        <script>
                        $(document).ready(function() {
                            // Handle filter change event
                            $('#roleFilter').change(function() {
                                var selectedRole = $(this).val();
                                // Send AJAX request to fetch filtered data
                                $.ajax({
                                    type: 'GET',
                                    url: 'fetch_data.php', // Change this to your PHP script for fetching data
                                    data: {
                                        role_filter: selectedRole
                                    },
                                    success: function(response) {
                                        // Update table content with filtered data
                                        $('#dataPengguna').html(response);
                                    }
                                });
                            });
                        });
                        </script>
                        <script>
                        $.ajax({
                            type: 'GET',
                            url: 'fetch_data.php',
                            data: {
                                role_filter: selectedRole,
                                page: 1 // Ubah nomor halaman sesuai kebutuhan
                            },
                            success: function(response) {
                                $('#dataPengguna').html(response);
                            }
                        });
                        </script>
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