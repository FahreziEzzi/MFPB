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
            echo "Action tidak valid.";
            exit();
        }

        $checkBookQuery = "SELECT * FROM buku WHERE id = $bookId";
        $checkBookResult = mysqli_query($koneksi, $checkBookQuery);

        if (mysqli_num_rows($checkBookResult) > 0) {

            if ($action == 'add') {
                $insertQuery = "INSERT INTO koleksi_pribadi (user, buku) VALUES ((SELECT id FROM user WHERE username = '$username'), $bookId)";
                mysqli_query($koneksi, $insertQuery);
            } elseif ($action == 'delete') {
                $deleteQuery = "DELETE FROM koleksi_pribadi WHERE user = (SELECT id FROM user WHERE username = '$username') AND buku = $bookId";
                mysqli_query($koneksi, $deleteQuery);
                $_SESSION['notification'] = 'Buku berhasil dihapus dari bookmark.';
            }

            header("Location: bookmark.php");
            exit();
        } else {
            echo "Buku dengan ID $bookId tidak ditemukan.";
            exit();
        }
    }
} else {
    echo "Metode yang diterima hanya GET.";
    exit();
}


$query = "SELECT buku.* FROM buku
          INNER JOIN koleksi_pribadi ON buku.id = koleksi_pribadi.buku
          INNER JOIN user ON koleksi_pribadi.user = user.id
          WHERE user.username = '$username'";

$result = mysqli_query($koneksi, $query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
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
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Home</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"
        integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <link href="../sbadmin/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <link href="../sbadmin/css/sb-admin-2.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
</head>

<body id="page-top">
    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
            <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
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
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item dropdown no-arrow d-sm-none">
                        <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-search fa-fw"></i>
                        </a>
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
            <div class="container-fluid">
                <div id="noResultsMessage" class="mt-5 text-center" style="display: none;">
                    <i class="fas fa-book fa-3x mb-3"></i>
                    <p>Buku yang Anda cari tidak ditemukan.</p>
                </div>
                <div class="row">
                    <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                    <div class="col-lg-4 mb-4 searchable">
                        <div class="card search-result">
                            <img src="../buku/<?php echo $row['cover']; ?>"
                                style="width: 100%; height: 300px; object-fit: cover;" class="card-img-top img-fluid"
                                alt="Cover Buku">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $row['judul']; ?></h5>
                                <p class="card-text"><?php echo $row['penulis']; ?></p>
                                <p class="card-text"><?php echo $row['penerbit']; ?></p>
                                <p class="card-text">Tahun Terbit: <?php echo $row['tahun_terbit']; ?></p>
                                <a href="pinjam.php?id=<?= $row['id']; ?>" class="btn btn-primary"
                                    id="pinjamButton<?php echo $row['id']; ?>">Pinjam</a>
                                <a href="bookmark.php?id=<?= $row['id']; ?>&action=delete" class="btn btn-secondary"
                                    onclick="return confirmDelete()">
                                    <i class="fas fa-heart"></i> Hapus Bookmark</a>
                            </div>
                        </div>
                    </div>
                    <?php endwhile; ?>
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
    </div>
    </div>
    <script>
    function showNotification(message, type) {
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": true,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };
        toastr[type](message);
    }
    </script>
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
    });

    function confirmDelete() {
        return confirm('Apakah Anda yakin ingin menghapus buku dari bookmark?');
    }
    </script>

    <?php if (isset($_SESSION['notification'])) : ?>
    <script>
    showNotification('<?php echo $_SESSION['notification']; ?>', 'success');
    </script>
    <?php unset($_SESSION['notification']); ?>
    <?php endif; ?>
</body>

</html>