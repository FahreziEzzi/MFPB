<?php
include "../koneksi.php";
session_start();
$id = $_GET['id'];
$result = mysqli_query($koneksi, "SELECT * FROM buku WHERE id = '$id'");
$data = mysqli_fetch_assoc($result);
$role = $_SESSION['role'];
$username = $_SESSION['username'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $judul = $_POST['judul'];
    $penulis = $_POST['penulis'];
    $penerbit = $_POST['penerbit'];
    $deskripsi = $_POST['deskripsi'];
    $tahun_terbit = $_POST['tahun_terbit'];
    $kategori_id = $_POST['kategori_id'];

    // Handle file upload
    if (!empty($_FILES["cover"]["name"])) {
        $targetDir = "uploads/";
        $coverFileName = basename($_FILES["cover"]["name"]);
        $targetFilePath = $targetDir . $coverFileName;
        $coverFileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

        move_uploaded_file($_FILES["cover"]["tmp_name"], $targetFilePath);


        $query = "UPDATE buku SET judul = '$judul', penulis = '$penulis', penerbit = '$penerbit', deskripsi = '$deskripsi', tahun_terbit = '$tahun_terbit', kategori_id = '$kategori_id', cover = '$targetFilePath' WHERE id = '$id'";
    } else {

        $query = "UPDATE buku SET judul = '$judul', penulis = '$penulis', penerbit = '$penerbit', deskripsi = '$deskripsi', tahun_terbit = '$tahun_terbit', kategori_id = '$kategori_id' WHERE id = '$id'";
    }

    // Eksekusi query
    if (mysqli_query($koneksi, $query)) {
        header("location: index.php");
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($koneksi);
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

    <title>Edit Buku</title>

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

                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4">Edit Buku</h1>
                                </div>
                                <form class="user" action="" method="post" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <input type="text" class="form-control form-control-user" id="inputJudul"
                                            placeholder="Judul Buku" name="judul" required
                                            value='<?= $data['judul'] ?>'>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control form-control-user" id="inputPenulis"
                                            placeholder="Penulis" name="penulis" required
                                            value='<?= $data['penulis'] ?>'>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control form-control-user" id="inputPenerbit"
                                            placeholder="Penerbit" name="penerbit" required
                                            value="<?= $data['penerbit'] ?>">
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control form-control-user" id="inputDeskripsi"
                                            placeholder="Deskripsi" name="deskripsi" required
                                            value="<?= $data['deskripsi'] ?>">
                                    </div>
                                    <div class="form-group">
                                        <input type="number" class="form-control form-control-user"
                                            id="inputTahunTerbit" placeholder="Tahun Terbit" name="tahun_terbit"
                                            required value="<?= $data['tahun_terbit'] ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="inputKategori">Kategori:</label>
                                        <select class="form-control" id="inputKategori" name="kategori_id" required>
                                            <option value="comedy">comedy</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputCover">Cover:</label>
                                        <input type="file" class="form-control-file" id="inputCover" name="cover">
                                    </div>

                                    <div class="text-center">
                                        <img src="<?= $data['cover'] ?>" alt="Cover Buku"
                                            style="max-width: 200px; max-height: 200px;">
                                    </div>
                                    <hr>
                                    <button type="submit" class="btn btn-primary btn-user btn-block">Edit Buku</button>
                                    <hr>
                                </form>
                            </div>
                        </div>
                    </div>
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