<?php
include "../koneksi.php";
$infoBuku = [];
$resultUlasan = [];
$buku_id = isset($_GET['id']) ? $_GET['id'] : 0;
$infoBukuQuery = "SELECT buku.id AS buku_id, buku.judul, buku.penulis, buku.penerbit
                  FROM buku
                  WHERE buku.id = $buku_id";
$resultInfoBuku = mysqli_query($koneksi, $infoBukuQuery);

if ($resultInfoBuku) {
    $infoBuku = mysqli_fetch_assoc($resultInfoBuku);
}
$ulasanQuery = "SELECT ulasan_buku.id AS ulasan_id, user.nama_lengkap, ulasan_buku.ulasan, ulasan_buku.rating
                FROM ulasan_buku
                INNER JOIN user ON ulasan_buku.user = user.id
                WHERE ulasan_buku.buku = $buku_id";
$resultUlasan = mysqli_query($koneksi, $ulasanQuery);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Ulasan</title>
    <link href="../sbadmin/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="../sbadmin/css/sb-admin-2.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css">
</head>

<body id="page-top">
    <div id="wrapper">
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <div class="container-fluid">
                    <!-- Page Heading -->
                    <h1 class="h3 mb-4 text-gray-800"><?= isset($infoBuku['judul']) ? $infoBuku['judul'] : "Informasi Buku Tidak Ditemukan" ?></h1>
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="card-title"><?= isset($infoBuku['judul']) ? $infoBuku['judul'] : "Informasi Buku Tidak Ditemukan" ?></h5>
                        </div>
                        <div class="card-body">
                            <p class="card-text"><strong>Pengarang:</strong> <?= isset($infoBuku['penulis']) ? $infoBuku['penulis'] : "Informasi Tidak Tersedia" ?></p>
                            <p class="card-text"><strong>Penerbit:</strong> <?= isset($infoBuku['penerbit']) ? $infoBuku['penerbit'] : "Informasi Tidak Tersedia" ?></p>
                        </div>
                    </div>
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="card-title">Ulasan</h5>
                        </div>
                        <div class="card-body">
                            <table id="ulasanTable" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Nama Lengkap</th>
                                        <th>Ulasan</th>
                                        <th>Rating</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($resultUlasan && mysqli_num_rows($resultUlasan) > 0) : ?>
                                        <?php while ($ulasan = mysqli_fetch_assoc($resultUlasan)) : ?>
                                            <tr>
                                                <td><?= $ulasan['nama_lengkap'] ?></td>
                                                <td><?= $ulasan['ulasan'] ?></td>
                                                <td><?= $ulasan['rating'] ?></td>
                                            </tr>
                                        <?php endwhile ?>
                                    <?php else : ?>
                                        <tr>
                                            <td colspan="3">Belum ada ulasan untuk buku ini.</td>
                                        </tr>
                                    <?php endif ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="../sbadmin/vendor/jquery/jquery.min.js"></script>
    <script src="../sbadmin/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../sbadmin/vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js"></script>
    <script src="../sbadmin/js/sb-admin-2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#ulasanTable').DataTable({
                "paging": true,
                "pageLength": 5,
                "lengthMenu": [5, 10, 25, 50], 
                "language": {
                    "paginate": {
                        "previous": "<",
                        "next": ">"
                    }
                }
            });
        });
    </script>
</body>
</html>