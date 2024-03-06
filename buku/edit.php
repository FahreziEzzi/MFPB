<?php
include "../koneksi.php";
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../login.php"); 
    exit();
}

$id = $_GET['id'];
$result = mysqli_query($koneksi, "SELECT * FROM buku WHERE id = '$id'");
$data = mysqli_fetch_assoc($result);
$role = $_SESSION['role'];
$username = $_SESSION['username'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_GET['id'];
    $judul = $_POST['judul'];
    $penulis = $_POST['penulis'];
    $penerbit = $_POST['penerbit'];
    $deskripsi = $_POST['deskripsi'];
    $tahun_terbit = $_POST['tahun_terbit'];
    $kategori_id = $_POST['kategori_id'];

    // Handle file uploads
    if (!empty($_FILES["cover"]["name"])) {
        $coverFileName = $_FILES["cover"]["name"];
        $coverTempName = $_FILES["cover"]["tmp_name"];
        $coverTargetDir = "uploads/";
        $coverTargetFile = $coverTargetDir . basename($coverFileName);
        move_uploaded_file($coverTempName, $coverTargetFile);
    } else {
        $coverTargetFile = $data['cover'];
    }

    if (!empty($_FILES["pdf"]["name"])) {
        $pdfFileName = $_FILES["pdf"]["name"];
        $pdfTempName = $_FILES["pdf"]["tmp_name"];
        $pdfTargetDir = "uploads/";
        $pdfTargetFile = $pdfTargetDir . basename($pdfFileName);
        move_uploaded_file($pdfTempName, $pdfTargetFile);
    } else {
        $pdfTargetFile = $data['pdf'];
    }

    $sql = "UPDATE buku SET judul='$judul',penulis='$penulis',penerbit='$penerbit',deskripsi='$deskripsi',tahun_terbit='$tahun_terbit', kategori_id='$kategori_id', cover='$coverTargetFile', pdf='$pdfTargetFile' WHERE id='$id'";
    $result = mysqli_query($koneksi,$sql);

    if($result){
        echo "<script>
            alert('Data berhasil diedit');
            window.location.href = 'index.php';
        </script>";
    }
    else{
        echo "<script>alert('Error: Data gagal diedit')</script>";
    }
}

$id = $_GET['id'];
$result = mysqli_query($koneksi, "SELECT * FROM buku WHERE id = '$id'");
$data = mysqli_fetch_assoc($result);

$get_kategori_query = "SELECT * FROM kategori_buku";
$result_kategori = mysqli_query($koneksi, $get_kategori_query);

$options_kategori = '';
if (mysqli_num_rows($result_kategori) > 0) {
    while ($row_kategori = mysqli_fetch_assoc($result_kategori)) {
        $selected = ($row_kategori['id'] == $data['kategori_id']) ? 'selected' : '';
        $options_kategori .= '<option value="' . $row_kategori['id'] . '" ' . $selected . '>' . $row_kategori['nama_kategori'] . '</option>';
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

    .badge-danger:hover {
        cursor: pointer;
    }
    </style>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Edit Buku</title>
    <link href="../sbadmin/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
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
            <?php
            if ($role === 'petugas') :
            ?>
            <li class="nav-item side">
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
                    <span>Peminjam</span></a>
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
                <!-- Topbar -->
                <!-- Topbar content -->
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4">Edit Buku</h1>
                                </div>
                                <form class="user" action="" method="post" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <input type="text" class="form-control form-control-user" id="inputJudul" placeholder="Judul Buku" name="judul" required value="<?= $data['judul'] ?>">
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control form-control-user" id="inputPenulis" placeholder="Penulis" name="penulis" required value="<?= $data['penulis'] ?>">
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control form-control-user" id="inputPenerbit" placeholder="Penerbit" name="penerbit" required value="<?= $data['penerbit'] ?>">
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control form-control-user" id="inputDeskripsi" placeholder="Deskripsi" name="deskripsi" required value="<?= $data['deskripsi'] ?>">
                                    </div>
                                    <div class="form-group">
                                        <input type="number" class="form-control form-control-user" id="inputTahunTerbit" placeholder="Tahun Terbit" name="tahun_terbit" required value="<?= $data['tahun_terbit'] ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="kategori_id">Kategori:</label>
                                        <select class="form-control" id="kategori_id" name="kategori_id">
                                            <?= $options_kategori ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputPdf">File PDF:</label>
                                        <input type="file" class="form-control-file" id="inputPdf" name="pdf"
                                            accept="pdf/">
                                    </div>
                                    <div class="form-group">
                                        <label for="inputCover">Cover:</label>
                                        <input type="file" class="form-control-file" id="inputCover" name="cover">
                                    </div>

                                    <div class="text-center">
                                        <img src="<?= $data['cover'] ?>" alt="Cover Buku"
                                            style="max-width: 200px; max-height: 200px;">
                                    </div>
                                    
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary btn-user btn-block">Edit Buku</button>
                                    </div>
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
    <script>
            function confirmLogout() {
                if (confirm("Are you sure you want to logout?")) {
                    window.location.href = "../logout.php"; // Redirect ke logout.php jika user menekan OK
                }
            }
            </script>
</body>

</html>
