<?php
session_start();

include '../koneksi.php';
if (!isset($_SESSION['username'])) {
    header("Location: ../login.php");
    exit();
}

$username = $_SESSION['username'];

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['id']) && isset($_GET['action'])) {
        $bookId = $_GET['id'];
        $action = $_GET['action'];
        if ($action !== 'add' && $action !== 'delete') {
            echo "Aksi tidak valid.";
            exit();
        }
        $checkBookQuery = "SELECT * FROM buku WHERE id = $bookId";
        $checkBookResult = mysqli_query($koneksi, $checkBookQuery);
        if (mysqli_num_rows($checkBookResult) > 0) {
            if ($action == 'add') {
                $insertQuery = "INSERT INTO koleksi_pribadi (user, buku) VALUES ((SELECT id FROM user WHERE username = '$username'), $bookId)";
                mysqli_query($koneksi, $insertQuery);
                $_SESSION['notification'] = "Buku sudah ditambahkan ke bookmark.";

                // Simpan status peminjaman dalam session
                $_SESSION['status_peminjaman'] = "Buku telah dipinjam";

                header("Location: index.php");
                exit();
            } elseif ($action == 'delete') {
                $deleteQuery = "DELETE FROM koleksi_pribadi WHERE user = (SELECT id FROM user WHERE username = '$username') AND buku = $bookId";
                mysqli_query($koneksi, $deleteQuery);
                $_SESSION['notification'] = "Buku berhasil dihapus dari bookmark.";

                // Simpan status peminjaman dalam session
                $_SESSION['status_peminjaman'] = "Buku telah dikembalikan";

                header("Location: index.php");
                exit();
            }
        } else {
            echo "Buku dengan ID $bookId tidak ditemukan.";
            exit();
        }
    } else {
    }
} else {
    echo "Metode yang diterima hanya GET.";
    exit();
}


$query = "SELECT * FROM buku";
$result = mysqli_query($koneksi, $query);
?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Beranda</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"
        integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <link href="../sbadmin/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <link href="../sbadmin/css/sb-admin-2.min.css" rel="stylesheet">
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <style>
    .card-img-container {
        position: relative;
        overflow: hidden;
    }

    .card-img-container::before {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        border: 5px solid #e9ecef;
        pointer-events: none;
        z-index: 1;
    }
    </style>
</head>

<body id="page-top">
    <div id="wrapper">
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>
                    <form
                        class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <input type="text" id="searchInput" class="form-control bg-light border-0 small"
                                placeholder="Cari..." aria-label="Search" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                    <ul class="navbar-nav ml-auto">
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
                                <a class="dropdown-item" href="peminjaman.php">
                                    <i class="fas fa-handshake fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Peminjaman
                                </a>
                                <a class="dropdown-item" href="bookmark.php">
                                    <i class="far fa-bookmark fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Bookmark
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
                <div class="container-fluid">
                    <div id="noResultsMessage" class="mt-5 text-center" style="display: none;">
                        <i class="fas fa-book fa-3x mb-3"></i>
                        <p>Buku yang Anda cari tidak ditemukan.</p>
                    </div>
                    <div class="row">
                        <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                        <div class="col-lg-3 mb-3 searchable">
                            <div class="card search-result">
                                <div class="card-img-container">
                                    <img src="../buku/<?php echo $row['cover']; ?>" class="card-img-top img-fluid"
                                        alt="Cover Buku">
                                </div>
                                <div class="card-body">
                                    <h5 class="font-weight-bold card-title"><?php echo $row['judul']; ?></h5>
                                    <p class="card-text"><?php echo $row['penulis']; ?></p>
                                    <p class="card-text"><?php echo $row['penerbit']; ?></p>
                                    <p class="card-text">Tahun Terbit: <?php echo $row['tahun_terbit']; ?></p>
                                    <?php
                                        $id = $row['id'];
                                        $querypinjam = "SELECT * FROM peminjaman WHERE buku = $id AND user = '" . $_SESSION['user_id'] . "' AND status_peminjaman = 'Dipinjam'";
                                        $resultpinjam = mysqli_query($koneksi, $querypinjam);
                                        $datapinjam = mysqli_fetch_assoc($resultpinjam);
                                        ?>
                                    <?php if (mysqli_num_rows($resultpinjam) > 0 && $datapinjam['status_peminjaman'] == "Dipinjam") : ?>
                                    <a href="kembalikan.php?id=<?= $row['id'] ?>" class="btn btn-danger"
                                        id="pinjamButton<?php echo $row['id']; ?>">Kembalikan</a>
                                    <?php else : ?>
                                    <a href="pinjam.php?id=<?= $row['id']; ?>" class="btn btn-primary"
                                        id="pinjamButton<?php echo $row['id']; ?>">Pinjam</a>
                                    <?php endif ?>
                                    <?php if (mysqli_num_rows($resultpinjam) > 0 && $datapinjam['status_peminjaman'] == "Dipinjam") : ?>
                                    <!-- Tombol Ulasan -->
                                    <!-- Tampilkan tombol ulasan hanya jika buku dipinjam -->
                                    <a href="tambah_ulasan.php?id=<?= $row['id']; ?>" class="btn btn-success">Ulasan</a>
                                    <?php endif ?>

                                    <?php
                                        $checkQuery = "SELECT * FROM koleksi_pribadi WHERE user = (SELECT id FROM user WHERE username = '$username') AND buku = {$row['id']}";
                                        $checkResult = mysqli_query($koneksi, $checkQuery);
                                        if (mysqli_num_rows($checkResult) > 0) : ?>
                                    <a href="index.php?id=<?= $row['id']; ?>&action=delete" class="btn btn-secondary"
                                        onclick="return confirmDelete()">
                                        <i class="fas fa-heart"></i>
                                    </a>
                                    <?php else : ?>
                                    <a href="index.php?id=<?= $row['id']; ?>&action=add" class="btn btn-secondary">
                                        <i class="far fa-heart"></i>
                                    </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <?php endwhile; ?>
                    </div>
                </div>
                <footer class="sticky-footer bg-white">
                    <div class="container my-auto">
                        <div class="copyright text-center my-auto">
                            <span>Hak Cipta &copy; Situs Web Anda 2021</span>
                        </div>
                    </div>
                </footer>
            </div>
        </div>

        <a class="scroll-to-top rounded" href="#page-top">
            <i class="fas fa-angle-up"></i>
        </a>
        <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Anda Siap untuk Keluar?</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">Pilih "Logout" di bawah jika Anda ingin mengakhiri sesi Anda saat ini.</div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
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
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
        <script>
        $(document).ready(function() {
            $("#searchInput").on("input", function() {
                let searchTerm = $(this).val().toLowerCase();
                let resultsFound = false;
                $(".searchable").each(function() {
                    let cardText = $(this).text().toLowerCase();
                    if (cardText.includes(searchTerm)) {
                        $(this).show();
                        resultsFound = true;
                    } else {
                        $(this).hide();
                    }
                });
                if (resultsFound) {
                    $("#noResultsMessage").hide();
                } else {
                    $("#noResultsMessage").show();
                }
            });

            <?php if (isset($_SESSION['notification'])) : ?>
            <?php if ($_SESSION['notification'] == 'Buku sudah ditambahkan ke bookmark.') : ?>
            toastr.success('<?php echo $_SESSION['notification']; ?>');
            <?php elseif ($_SESSION['notification'] == 'Buku berhasil dihapus dari bookmark.') : ?>
            toastr.success('<?php echo $_SESSION['notification']; ?>');
            <?php endif; ?>
            <?php unset($_SESSION['notification']); ?>
            <?php endif; ?>
        });

        function confirmDelete() {
            return confirm('Apakah Anda yakin ingin menghapus buku dari bookmark?');
        }
        </script>
</body>

</html>