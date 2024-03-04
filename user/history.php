<?php
session_start();

include '../koneksi.php';


if (!isset($_SESSION['username'])) {
    header("Location: ../login.php");
    exit();
}
function getLoggedInUserID($koneksi, $username)
{
    // Query untuk mendapatkan ID pengguna berdasarkan nama pengguna
    $query = "SELECT id FROM user WHERE username = '$username'";
    $result = mysqli_query($koneksi, $query);
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        return $row['id'];
    } else {
        // Pengguna tidak ditemukan atau terjadi kesalahan lain
        return null;
    }
}

$username = $_SESSION['username'];
$userId = getLoggedInUserID($koneksi, $username);


// Query untuk mengambil data peminjaman berdasarkan user
$peminjamanQuery = "SELECT buku.id, buku.kategori_id, buku.judul, buku.cover, buku.penulis, buku.penerbit, buku.tahun_terbit, peminjaman.tanggal_peminjaman, peminjaman.tanggal_pengembalian, peminjaman.status_peminjaman
                    FROM peminjaman
                    INNER JOIN buku ON peminjaman.buku = buku.id
                    WHERE peminjaman.user = $userId AND peminjaman.status_peminjaman = 'Dipinjam'";


// Eksekusi query
$peminjamanResult = mysqli_query($koneksi, $peminjamanQuery);

// Query to fetch book categories
$categoryQuery = "SELECT id, nama_kategori FROM kategori_buku";
$categoryResult = mysqli_query($koneksi, $categoryQuery);

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Home</title>
    <!-- SweetAlert CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10">
    <!-- Custom fonts for this template-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"
        integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <link href="../sbadmin/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"> -->

    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="../sbadmin/css/sb-admin-2.min.css" rel="stylesheet">
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>


</head>

<body id="page-top">



    <!-- Page Wrapper -->
    <div id="wrapper">



        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav style="position: fixed; width: 100%; z-index: 1000; "
                    class=" navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Search -->
                    <form
                        class=" d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <input type="text" id="searchInput" class=" form-control bg-light border small"
                                placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <!-- Dropdown - Messages -->
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
                                <a class="dropdown-item" href="peminjaman.php">
                                    <i class="fas fa-handshake fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Peminjaman
                                </a>
                                <a class="dropdown-item" href="bookmark.php">
                                    <i class="far fa-solid fa-heart fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Bookmark
                                </a>
                                <a class="dropdown-item" href="history.php">
                                    <i class="fas fa-history fa-sm fa-fw mr-2 text-gray-400"></i>
                                    History
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="" data-toggle="modal" data-target="#logoutModal">
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

                    <h1 style="margin-top: 90px;" class="h3 mb-4 text-gray-800 text-center">History Buku</h1>
                    <div class="row justify-content-center">
                        <div class=" mb-4">
                            <div class="dropdown">
                                <button class="btn btn-info dropdown-toggle" type="button" id="kategoriDropdown"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Filter Kategori
                                </button>
                                <div class="dropdown-menu" aria-labelledby="kategoriDropdown">
                                    <?php while ($category = mysqli_fetch_assoc($categoryResult)) : ?>
                                    <button class="dropdown-item" onclick="filterBooks(<?php echo $category['id']; ?>)">
                                        <?php echo $category['nama_kategori']; ?>
                                    </button>
                                    <?php endwhile; ?>
                                    <button class="dropdown-item" onclick="filterBooks(null)">Semua Kategori</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <?php while ($row = mysqli_fetch_assoc($peminjamanResult)) : ?>
                        <div class="searchable card mb-3" data-kategori-id="<?php echo $row['kategori_id']; ?>"
                            style="max-width: 800px;box-shadow: 0 4px 20px 0 rgba(0,0,0,0.4);">
                            <div class="row no-gutters">
                                <div class="col-md-4">
                                    <img src="../buku/<?= $row['cover']; ?>" class="card-img" alt="...">
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body mt-5">
                                        <h5 class="card-title font-weight-bold">Judul : <?= $row['judul']; ?></h5>
                                        <p class="card-text">Penulis : <?= $row['penulis']; ?></p>
                                        <p class="card-text">Tahun Terbit : <?= $row['tahun_terbit']; ?></p>
                                        <p class="card-text">Tanggal Peminjaman : <?= $row['tanggal_peminjaman']; ?></p>
                                        <p class="card-text">Tanggal Pengembalian : <?= $row['tanggal_pengembalian']; ?>
                                        </p>
                                        <p class="card-text">Status Peminjaman : <?= $row['status_peminjaman']; ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endwhile; ?>
                    </div>
                </div>


            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->


    </div>
    <!-- End of Content Wrapper -->
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
    <!-- SweetAlert JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <!-- Custom script for automatic search -->
    <script>
    $(document).ready(function() {
        // Add an input event listener to the search input
        $("#searchInput").on("input", function() {
            let searchTerm = $(this).val()
                .toLowerCase(); // Get the value of the input and convert to lowercase

            // Keep track if any results are found
            let resultsFound = false;

            // Loop through each searchable card
            $(".searchable").each(function() {
                let cardText = $(this).text()
                    .toLowerCase(); // Get the text content of the card and convert to lowercase

                // Check if the card text contains the search term
                if (cardText.includes(searchTerm)) {
                    $(this).show(); // If yes, show the card
                    resultsFound = true; // Mark that results are found
                } else {
                    $(this).hide(); // If no, hide the card
                }
            });

            // Show/hide the no results message based on resultsFound
            if (resultsFound) {
                $("#noResultsMessage").hide();
            } else {
                $("#noResultsMessage").show();
            }
        });
    });
    </script>



    <script>
    function filterBooks(categoryId) {
        $(".searchable").each(function() {
            if (categoryId === null || $(this).data('kategori-id') == categoryId) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    }
    </script>

</body>

</html>