<?php
session_start();
include "../koneksi.php";
$id = $_GET['id'];
$result = mysqli_query($koneksi, "SELECT * FROM buku WHERE id = '$id'");
$data = mysqli_fetch_assoc($result);



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Ulasan Buku</title>
    <link href="../sbadmin/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <link href="../sbadmin/css/sb-admin-2.min.css" rel="stylesheet">
    <style>
    .book-info {
        display: flex;
        align-items: center;
        margin-bottom: 20px;
    }

    .book-info img {
        max-width: 290px;
        margin-right: 50px;
    }

    .book-details {
        flex: 1;
    }
    </style>
</head>

<body id="page-top">
    <div id="wrapper">
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4">Tambah Ulasan dan Rating</h1>
                                </div>
                                <div class="book-info">
                                    <img src="../buku/<?= $data['cover'] ?>" alt="Book Cover">
                                    <div class="book-details">
                                        <h5><?= $data['judul'] ?></h5>
                                        <p>Penulis: <?= $data['penulis'] ?></p>
                                        <p>Penerbit: <?= $data['penerbit'] ?></p>
                                        <p>Tahun Terbit: <?= $data['tahun_terbit'] ?></p>
                                        <p>Deskripsi: <?= $data['deskripsi'] ?></p>
                                    </div>
                                </div>
                                <form class="user" action="proses_pengiriman_ulasan.php" method="post">
                                    <input type="hidden" name="id_buku" value="<?php echo $_GET['id'] ?>">
                                    <input type="hidden" name="id_user" value="<?php echo $_SESSION['user_id'] ?>">
                                    <div class="form-group">
                                        <label for="inputRating">Rating 1-5:</label>
                                        <input type="number" class="form-control" id="inputRating" name="rating" min="1"
                                            max="5" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputUlasan">Ulasan:</label>
                                        <textarea class="form-control" id="inputUlasan" name="ulasan" rows="3"
                                            required></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-user btn-block">Kirim
                                        Ulasan</button>
                                    <a href="lihat_ulasan.php?id=<?php echo $_GET['id']; ?>"
                                        class="btn btn-success btn-user btn-block">Lihat Ulasan</a>
                                    <hr>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
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
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>
    <script src="../sbadmin/vendor/jquery/jquery.min.js"></script>
    <script src="../sbadmin/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../sbadmin/vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="../sbadmin/js/sb-admin-2.min.js"></script>
</body>

</html>