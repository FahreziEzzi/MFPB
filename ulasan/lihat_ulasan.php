<?php
session_start();
include "../koneksi.php";
$infoBuku = [];
$resultUlasan = [];
$buku_id = isset($_GET['id']) ? $_GET['id'] : 0;
$infoBukuQuery = "SELECT buku.id AS buku_id, buku.judul, buku.penulis, buku.penerbit, buku.cover
                  FROM buku
                  WHERE buku.id = $buku_id";
$resultInfoBuku = mysqli_query($koneksi, $infoBukuQuery);

if ($resultInfoBuku) {
    $infoBuku = mysqli_fetch_assoc($resultInfoBuku);
}

$ulasanQuery = "SELECT ulasan_buku.id AS ulasan_id, user.nama_lengkap, ulasan_buku.ulasan, ulasan_buku.rating, ulasan_buku.user
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
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <link href="../sbadmin/css/sb-admin-2.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <style>
    /* Tambahkan gaya CSS kustom di sini */
    body {
        background-color: #f8f9fc;
    }

    .card {
        margin-bottom: 20px;
    }

    .card-header {
        background-color: #ffffff;
        border-bottom: 1px solid #e3e6f0;
    }

    .card-title {
        color: #4e73df;
        font-weight: bold;
    }

    .card-body {
        background-color: #ffffff;
    }

    #ulasanTable_wrapper {
        padding: 20px;
    }

    #ulasanTable_length,
    #ulasanTable_filter {
        margin-bottom: 10px;
    }

    .cover-image {
        max-width: 140px;
        height: 390px;
        margin-bottom: 20px;
    }

    @media (min-width: 768px) {
        .cover-image {
            max-width: 410%;
            float: left;
            margin-right: 20px;
            margin-bottom: 0;
        }

        .book-info {
            overflow: hidden;
        }
    }
    </style>
</head>

<body id="page-top">
    <div id="wrapper">
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <div class="container-fluid">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">
                                <?= isset($infoBuku['judul']) ? $infoBuku['judul'] : "Informasi Buku Tidak Ditemukan" ?>
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">

                                    <img src="<?= isset($infoBuku['cover']) ? '../buku/' . $infoBuku['cover'] : '../buku/uploads/' ?>"
                                        class="card-img-top cover-image" alt="Cover Image">
                                </div>
                                <div class="col-md-9">
                                    <div class="book-info">
                                        <p class="card-text"><strong>Pengarang:</strong>
                                            <?= isset($infoBuku['penulis']) ? $infoBuku['penulis'] : "Informasi Tidak Tersedia" ?>
                                        </p>
                                        <p class="card-text"><strong>Penerbit:</strong>
                                            <?= isset($infoBuku['penerbit']) ? $infoBuku['penerbit'] : "Informasi Tidak Tersedia" ?>
                                        </p>
                                        <p class="card-text"><strong>Deskripsi:</strong>
                                            <?= isset($infoBuku['deskripsi']) ? $infoBuku['deskripsi'] : "Informasi Tidak Tersedia" ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Ulasan</h5>
                        </div>
                        <div class="card-body">
                            <div id="ulasanTable_wrapper" class="dataTables_wrapper dt-bootstrap4">
                                <div class="row">
                                    <div class="col-sm-12 col-md-6">
                                        <div id="ulasanTable_length" class="dataTables_length">
                                            <label for="ulasanTable_length">Tampilkan
                                                <select name="ulasanTable_length" aria-controls="ulasanTable"
                                                    class="custom-select custom-select-sm form-control form-control-sm">
                                                    <option value="5">5</option>
                                                    <option value="10">10</option>
                                                    <option value="25">25</option>
                                                    <option value="50">50</option>
                                                </select>
                                                Entri
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <div id="ulasanTable_filter" class="dataTables_filter">
                                            <label for="ulasanTable_filter">Cari:
                                                <input type="search" class="form-control form-control-sm" placeholder=""
                                                    aria-controls="ulasanTable">
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <table id="ulasanTable" class="table table-striped table-bordered" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Nama Lengkap</th>
                                            <th>Ulasan</th>
                                            <th>Rating</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if ($resultUlasan && mysqli_num_rows($resultUlasan) > 0) : ?>
                                        <?php while ($ulasan = mysqli_fetch_assoc($resultUlasan)) : ?>
                                        <tr>
                                            <td><?= $ulasan['nama_lengkap'] ?></td>
                                            <td><?= $ulasan['ulasan'] ?></td>
                                            <td><?= $ulasan['rating'] ?></td>
                                            <td>
                                                <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') : ?>
                                                <a href="hapus_ulasan.php?id=<?= $ulasan['ulasan_id'] ?>"
                                                    class="btn btn-sm btn-danger"
                                                    onclick="return confirm('Yakin ingin menghapus ulasan ini?')">Hapus</a>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <?php endwhile ?>
                                        <?php else : ?>
                                        <tr>
                                            <td colspan="4">Belum ada ulasan untuk buku ini.</td>
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