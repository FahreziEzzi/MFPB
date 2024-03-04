<?php
session_start();

include '../koneksi.php';

if (!isset($_SESSION['username'])) {
    echo "<script>alert('Tolong login terlebih dahulu'); window.location.href = '../login.php';</script>";
    exit();
}


$username = $_SESSION['username'];

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['id']) && isset($_GET['action'])) {
        $bookId = $_GET['id'];
        $action = $_GET['action'];

        // Validasi action
        if ($action !== 'add' && $action !== 'delete') {
            // Jika action tidak valid, bisa ditangani sesuai kebutuhan (contoh: berikan pesan)
            echo "Action tidak valid.";
            exit();
        }

        // Validasi apakah buku dengan ID tertentu ada di database
        $checkBookQuery = "SELECT * FROM buku WHERE id = $bookId";
        $checkBookResult = mysqli_query($koneksi, $checkBookQuery);

        if (mysqli_num_rows($checkBookResult) > 0) {
            // Buku ditemukan, lanjutkan proses bookmark
            if ($action == 'add') {
                // Jika action=add, tambahkan buku ke koleksi pribadi
                $insertQuery = "INSERT INTO koleksi_pribadi (user, buku) VALUES ((SELECT id FROM user WHERE username = '$username'), $bookId)";
                mysqli_query($koneksi, $insertQuery);
            } elseif ($action == 'delete') {
                // Jika action=delete, hapus buku dari koleksi pribadi
                $deleteQuery = "DELETE FROM koleksi_pribadi WHERE user = (SELECT id FROM user WHERE username = '$username') AND buku = $bookId";
                mysqli_query($koneksi, $deleteQuery);
            }

            // Redirect kembali ke halaman utama setelah bookmark berhasil ditambahkan atau dihapus
            header("Location: peminjaman.php");
            exit();
        } else {
            // Jika buku dengan ID tertentu tidak ditemukan, bisa ditangani sesuai kebutuhan (contoh: berikan pesan)
            echo "Buku dengan ID $bookId tidak ditemukan.";
            exit();
        }
    } else {
        // Jika parameter id atau action tidak valid, bisa ditangani sesuai kebutuhan (contoh: berikan pesan)

    }
} else {
    // Jika bukan metode GET, bisa ditangani sesuai kebutuhan (contoh: berikan pesan)
    echo "Metode yang diterima hanya GET.";
    exit();
}

// Query untuk mengambil data buku yang dipinjam oleh pengguna dengan tanggal pengembalian yang masih 0
$query = "SELECT b.* 
          FROM buku b
          JOIN peminjaman p ON b.id = p.buku
          JOIN user u ON p.user = u.id
          WHERE u.username = '$username'
          AND status_peminjaman = 'Dipinjam'"; // Menambahkan kondisi tanggal pengembalian
$result = mysqli_query($koneksi, $query);

$checkPeminjamanQuery = "SELECT * FROM peminjaman WHERE user = (SELECT id FROM user WHERE username = '$username')";
$checkPeminjamanResult = mysqli_query($koneksi, $checkPeminjamanQuery);
$peminjaman = [];
while ($row = mysqli_fetch_assoc($checkPeminjamanResult)) {
    $peminjaman[$row['buku']] = $row;
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

    <title>Home</title>

    <!-- Custom fonts for this template-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"
        integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <link href="../sbadmin/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="../sbadmin/css/sb-admin-2.min.css" rel="stylesheet">
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <style>
    body {
        position: relative;
        min-height: 100vh;
    }

    .footer {
        position: absolute;
        bottom: 0;
        width: 100%;
        /* Optional: adjust padding or margin as needed */
        padding: 20px 0;
        margin-top: 20px;
    }
    </style>


</head>

<body id="page-top">





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

                <!-- Topbar Search -->
                <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                    <div class="input-group">
                        <input type="text" id="searchInput" class="form-control bg-light border-0 small"
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
                                        placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
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

                            <a class="dropdown-item" href="#">
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
                <div id="noResultsMessage" class="mt-5 text-center" style="display: none;">
                    <i class="fas fa-book fa-3x mb-3"></i>
                    <p>Buku yang Anda cari tidak ditemukan.</p>
                </div>
                <div class="row">
                    <!-- Message for no search results -->
                    <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                    <div style="margin-bottom: 300px;" class="col-lg-3 searchable">
                        <div style="box-shadow: 0 4px 17px 0 rgba(0,0,0,0.4);" class="card search-result">
                            <img src="../buku/<?php echo $row['cover']; ?>"
                                style="width: 100%; height: 410px; object-fit: cover;" class="card-img-top"
                                alt="Cover Buku">
                            <div class="card-body">
                                <h5 class="font-weight-bold card-title"><?php echo $row['judul']; ?></h5>
                                <p class="card-text"><?php echo $row['penulis']; ?></p>
                                <p class="card-text"><?php echo $row['penerbit']; ?></p>
                                <p class="card-text">Tahun Terbit: <?php echo $row['tahun_terbit']; ?></p>
                                <?php if (isset($peminjaman[$row['id']])) :
                                if ($peminjaman[$row['id']]['status_peminjaman'] == 'Dipinjam') : ?>
                                <a href="balikin.php?id=<?= $row['id']; ?>&action=return"
                                    class="btn btn-danger">Kembalikan</a>
                                <?php else : ?>
                                <a href="pinjam.php?id=<?= $row['id']; ?>" class="btn btn-primary">Pinjam</a>
                                <?php endif;
                            else : ?>
                                <a href="pinjam.php?id=<?= $row['id']; ?>" class="btn btn-primary">Pinjam</a>
                                <?php endif; ?>
                                <a href="ulasan.php?id=<?= $row['id']; ?>" class="btn btn-success">Ulasan</a>
                                <?php
                            // Cek apakah buku sudah ada di koleksi pribadi user
                            $checkQuery = "SELECT * FROM koleksi_pribadi WHERE user = (SELECT id FROM user WHERE username = '$username') AND buku = {$row['id']}";
                            $checkResult = mysqli_query($koneksi, $checkQuery);

                            if (mysqli_num_rows($checkResult) > 0) : ?>
                                <a href="index.php?id=<?= $row['id']; ?>&action=delete" class="btn btn-secondary"
                                    onclick="return confirmDelete()">
                                    <i class="fas fa-solid fa-heart"></i></a>
                                <?php else : ?>
                                <a href="index.php?id=<?= $row['id']; ?>&action=add" class="btn btn-secondary">
                                    <i class="far fa-regular fa-heart"></i></a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <?php endwhile; ?>
                </div>


            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->


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








</body>

</html>