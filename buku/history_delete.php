<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../login.php");
    exit();
}

// Check if notification exists in session
$notification = isset($_SESSION['notification']) ? $_SESSION['notification'] : "";

// Clear notification from session
unset($_SESSION['notification']);

include "../koneksi.php";
$sql = "SELECT * FROM buku WHERE status_hapus = 0"; // Hanya ambil buku yang belum dihapus
$result = mysqli_query($koneksi, $sql);
$role = $_SESSION['role'];
$username = $_SESSION['username'];

// Pagination setup
$limit = 3; // Jumlah entri per halaman
$current_page = isset($_GET['page']) ? $_GET['page'] : 1; // Halaman saat ini

// Hitung total entri
$sql_count = "SELECT COUNT(*) AS total FROM buku WHERE status_hapus = 0"; // Hitung total buku yang belum dihapus
$count_result = mysqli_query($koneksi, $sql_count);
$count_data = mysqli_fetch_assoc($count_result);
$total_records = $count_data['total'];

// Hitung total halaman
$total_pages = ceil($total_records / $limit);

// Tentukan OFFSET untuk query
$offset = ($current_page - 1) * $limit;

// Query data buku dengan LIMIT dan OFFSET
$sql = "SELECT * FROM buku WHERE status_hapus = 0 LIMIT $limit OFFSET $offset"; // Hanya ambil buku yang belum dihapus
$result = mysqli_query($koneksi, $sql);


// ...
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $id_buku = $_GET['id'];

    // Update nilai status_hapus menjadi 1
    $sql_update = "UPDATE buku SET status_hapus = 1 WHERE id = $id_buku";
    mysqli_query($koneksi, $sql_update);

    // Set notifikasi ke dalam session
    $_SESSION['notification'] = "Buku berhasil dikembalikan.";

    // Redirect ke halaman history_delete.php
    header("Location: history_delete.php");
    exit();
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

        .badge-danger:hover {
            cursor: pointer;
        }

        /* CSS untuk tabel */
        .table-container table {
            width: 100%;
            border-collapse: collapse;
        }

        .table-container th,
        .table-container td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .table-container th {
            background-color: #f2f2f2;
            color: #333;
        }

        .table-container tbody tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .table-container tbody tr:hover {
            background-color: #ddd;
        }
    </style>
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
                <a class="nav-link" href="../dashboard.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>
            <hr class="sidebar-divider">
            <?php
            if ($role === 'admin') :
            ?>
                <li class="nav-item side active">
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
                        <i class="fas fa-fw fa-users"></i>
                        <span>Peminjaman</span></a>
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
                <li class="nav-item active">
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
                        <span>Peminjaman</span></a>
                </li>
                <li class="nav-item side">
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
            <hr class="sidebar-divider d-none d-md-block">
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>
        </ul>
        <div id="content-wrapper" class="d-flex flex-column">


            <div id="content">

                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Search -->
                    

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input id="searchInput" type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>



                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                                    <?= $_SESSION['username']; ?>
                                    <i class="fas fa-caret-down"></i>
                                </span>
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="../logout.php" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>

                <div class="container">
                    <?php if (!empty($notification)) : ?>
                        <div class="alert alert-success" role="alert">
                            <?php echo $notification; ?>
                        </div>
                    <?php endif; ?>
                    <div class="table-container">
                        <h1 class="h3 mb-3 text-gray-800">Data Buku Yang Dihapus</h1>
                        <table>
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Judul</th>
                                    <th>Penulis</th>
                                    <th>Tahun Terbit</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                include "../koneksi.php";
                                $query = mysqli_query($koneksi, "SELECT * FROM buku WHERE status_hapus = '1'");
                                if (mysqli_num_rows($query) > 0) {
                                    while ($row = mysqli_fetch_assoc($query)) {
                                        echo "<tr>
                                    <td>{$row['id']}</td>
                                    <td>{$row['judul']}</td>
                                    <td>{$row['penulis']}</td>
                                    <td>{$row['tahun_terbit']}</td>
                                    <td><a href='restore.php?id={$row['id']}'>Kembalikan</a></td>
                                  </tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='5'>Tidak ada buku yang dihapus.</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>

                        <!-- Tabel untuk menampilkan data buku yang dihapus -->
                        <!-- Judul halaman -->
                    </div>
                </div>


            </div>
            <a class="scroll-to-top rounded" href="#page-top">
                <i class="fas fa-angle-up"></i>
            </a>
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Your Website 2021</span>
                    </div>
                </div>
            </footer>
        </div>

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
        <script src="../sbadmin/js/demo/chart-area-demo.js"></script>
        <script src="../sbadmin/js/demo/chart-pie-demo.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>

            function confirmLogout() {
                if (confirm("Are you sure you want to logout?")) {
                    window.location.href = "../logout.php"
                }
            }
        </script>

        <script>
            function confirmDelete(bookId) {
                Swal.fire({
                    title: 'Apakah anda yakin menghapus buku ini?',
                    text: "Tindakan ini tidak dapat dibatalkan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Jika pengguna mengonfirmasi penghapusan, arahkan ke delete.php dengan id buku yang ingin dihapus
                        window.location.href = 'delete.php?id=' + bookId;
                    }
                });
            }
        </script>
</body>

</html>
