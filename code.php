<?php
include('koneksi.php');
session_start();

// Ambil buku-buku populer berdasarkan rating tertinggi
$queryPopuler = "SELECT b.*, AVG(u.rating) AS rating_rata FROM buku b LEFT JOIN ulasan_buku u ON b.id = u.buku GROUP BY b.id ORDER BY rating_rata DESC LIMIT 3";


$resultPopuler = mysqli_query($koneksi, $queryPopuler);

if (!$resultPopuler) {
    die("Error: " . mysqli_error($koneksi));
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perpustakaan Digital</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #fff;
        background-size: cover;
        background-position: center;
    }

    .container {
        width: 80%;
        margin: 50px auto;
        text-align: center;
        background-color: rgba(255, 255, 255, 0.8);
        padding: 20px;
        border-radius: 10px;
    }

    .navbar {
        color: #fff;
        padding: 10px 0;
        overflow: hidden;
        background-color: #333;
        /* Menambahkan warna latar belakang navbar */
    }

    .navbar a {
        color: #fff;
        /* Mengubah warna teks navbar menjadi putih */
        text-decoration: none;
        margin: 0 22px;
        transition: background-color 0.3s;
    }

    .navbar a.right {
        float: right;
    }

    h1 {
        color: #333;
        text-align: left;
        /* Mengubah posisi teks "Selamat Datang" menjadi kiri */
        margin-left: 10%;
        /* Memberi jarak dari tepi kiri */
    }

    p {
        color: #666;
        font-size: 18px;
        text-align: left;
        /* Mengubah posisi teks deskripsi menjadi kiri */
        margin-left: 10%;
        /* Memberi jarak dari tepi kiri */
    }

    .btn {
        display: inline-block;
        padding: 10px 20px;
        background-color: #007bff;
        color: #fff;
        text-decoration: none;
        border-radius: 5px;
        margin-top: 20px;
    }

    .rekomendasi {
        text-align: center;
        margin-top: 50px;
    }

    footer {
        background-color: #333;
        /* Mengubah warna latar belakang footer */
        color: #333;
        /* Mengubah warna teks footer menjadi putih */
        padding: 48px 0;
        /* Memberi ruang di atas dan bawah teks footer */
    }

    .card-text {
        font-size: 18px;
        /* Ukuran font yang diperkecil */
        text-align: center;
        /* Posisikan teks di tengah */
        /* Posisioning absolute agar bisa ditempatkan tepat di bawah gambar */
        bottom: 0;
        /* Menempatkan teks di bagian bawah */
        left: 0;
        /* Menempatkan teks di bagian kiri */
        width: 250px;
        /* Lebar sesuai dengan parent (card-body) */
        padding: 2px 0;
        /* Padding di atas dan bawah untuk memberi jarak */
    }

    footer {
        background-color: #333;
        color: #fff;
        padding: 20px 0;
    }

    footer a {
        color: #fff;
    }

    footer a:hover {
        color: #ccc;
    }
    </style>
</head>

<body>
    <div class="navbar">
        <a href="index.php">Beranda</a>
        <a href="buku.php">Daftar Buku</a>
        <a href="login.php" class="right">Login</a>
        <a href="registrasi.php" class="right">Registrasi</a>
    </div>
    <div class="container">
        <h1>Selamat Datang di Perpustakaan Digital</h1>
        <p>Temukan dunia pengetahuan di ujung jari Anda dengan koleksi buku elektronik kami yang kaya dan beragam. Dari
            fiksi hingga non-fiksi, dari sejarah hingga sastra, kami menyediakan akses mudah dan cepat ke ribuan judul
            terbaik.</p>
    </div>
    <div class="rekomendasi">
        <h2>Buku-buku Populer</h2>
        <div class="container" style="display: flex; flex-wrap: wrap; justify-content: space-between;">
            <?php while ($row = mysqli_fetch_assoc($resultPopuler)) : ?>
            <div class="col-lg-3 mb-3 searchable" style="flex-basis: 30%;">
                <div class="card search-result">
                    <div class="card-img-container">
                        <h5 class="font-weight-bold card-title"><?php echo $row['judul']; ?></h5>
                        <img src="buku/<?php echo $row['cover']; ?>" class="card-img-top img-fluid" alt="Cover Buku"
                            style="max-width: 290px; height: 290px;">
                    </div>
                    <div class="card-body">
                        <p class="card-text"><?php echo $row['penulis']; ?></p>
                        <p class="card-text"><?php echo $row['penerbit']; ?></p>
                        <p class="card-text">Tahun Terbit: <?php echo $row['tahun_terbit']; ?></p>
                        <!-- Tombol Pinjam, Kembalikan, Ulasan, dan Tambah/Hapus dari Bookmark -->
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
    </div>

    <footer>
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h4>Tentang Kami</h4>
                    <p>Perpustakaan Digital menyediakan akses mudah dan cepat ke ribuan judul buku elektronik terbaik.
                    </p>
                </div>
                <div class="col-md-4">
                    <h4>Kontak Kami</h4>
                    <p>Email: Fahrezireziw1054@gmail.com</p>
                    <p>Telepon: 083109627088</p>
                </div>
            </div>
        </div>
        <div class="copy text-center">
            <p>&copy; 2024 Perpustakaan Digital. All rights reserved.</p>
        </div>
    </footer>
</body>

</html>

//kode baru//
<?php
include '../koneksi.php';

session_start();

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
                $_SESSION['status_peminjaman'] = "Buku telah ditambahkan ke bookmark.";

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

if (isset($_SESSION['notification'])) {
    // Tampilkan pesan notifikasi
    echo "<script>alert('" . $_SESSION['notification'] . "');</script>";
    // Hapus pesan notifikasi dari session
    unset($_SESSION['notification']);
}
$categoryQuery = "SELECT id, nama_kategori FROM kategori_buku";
$categoryResult = mysqli_query($koneksi, $categoryQuery);
$query = "SELECT * FROM buku";
$result = mysqli_query($koneksi, $query);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <style>

    </style>
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

    .card-img-container {
        position: relative;
        overflow: hidden;
        height: 430px;
        /* Ubah sesuai dengan keinginan Anda */
    }

    px .card-img-container img {
        width: 550px;
        height: 550px;
        object-fit: cover;
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

                        <div data-category-id="<?php echo $row['kategori_id']; ?>" class="col-lg-3 mb-3 searchable">
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
                                    <p class="card-text">Stok: <?php echo $row['stok']; ?></p>
                                    <?php
                // Hitung selisih hari antara tanggal pengembalian dengan tanggal sekarang
                $id = $row['id'];
                $querypinjam = "SELECT * FROM peminjaman WHERE buku = $id AND user = '" . $_SESSION['user_id'] . "' AND status_peminjaman = 'Dipinjam'";
                $resultpinjam = mysqli_query($koneksi, $querypinjam);
                $datapinjam = mysqli_fetch_assoc($resultpinjam);

                if (mysqli_num_rows($resultpinjam) > 0 && $datapinjam['status_peminjaman'] == "Dipinjam") {
                    $tanggalPeminjaman = $datapinjam['tanggal_peminjaman'];
                    $tanggalPengembalian = date('Y-m-d', strtotime($tanggalPeminjaman . ' + 3 days'));
                    $selisihHari = ceil((strtotime($tanggalPengembalian) - strtotime(date('Y-m-d'))) / (60 * 60 * 24));
                    if ($selisihHari > 0) {
                        echo "<p class='card-text text-danger'>Batas hari peminjaman: $selisihHari hari</p>";
                    }
                }
                ?>
                                    <?php
                // Periksa apakah pengguna telah meminjam buku ini
                $id = $row['id'];
                $querypinjam = "SELECT * FROM peminjaman WHERE buku = $id AND user = '" . $_SESSION['user_id'] . "' AND status_peminjaman = 'Dipinjam'";
                $resultpinjam = mysqli_query($koneksi, $querypinjam);
                $datapinjam = mysqli_fetch_assoc($resultpinjam);
                $hasBorrowed = mysqli_num_rows($resultpinjam) > 0 && $datapinjam['status_peminjaman'] == "Dipinjam";
                ?>

                                    <?php if (mysqli_num_rows($resultpinjam) > 0 && $datapinjam['status_peminjaman'] == "Dipinjam") : ?>
                                    <!-- Tombol "Kembalikan" -->
                                    <a href="kembalikan.php?id=<?= $row['id'] ?>" class="btn btn-danger"
                                        id="pinjamButton<?php echo $row['id']; ?>">Kembalikan</a>
                                    <?php else : ?>
                                    <!-- Tombol "Pinjam" -->
                                    <a href="pinjam.php?id=<?= $row['id']; ?>" class="btn btn-primary"
                                        id="pinjamButton<?php echo $row['id']; ?>">Pinjam</a>
                                    <?php endif ?>
                                    <?php if ($hasBorrowed) : ?>
                                    <!-- Tombol "Baca" akan muncul jika pengguna telah meminjam buku -->
                                    <a href="tambah_ulasan.php?id=<?= $row['id']; ?>" class="btn btn-success">Ulasan</a>
                                    <?php endif ?>



                                    <?php if ($hasBorrowed) : ?>
                                    <!-- Tombol "Baca" akan muncul jika pengguna telah meminjam buku -->
                                    <a href="baca.php?id=<?= $row['id']; ?>" class="btn btn-info"
                                        target="_blank">Baca</a>
                                    <?php endif ?>

                                    <!-- Tombol "Bookmark" -->
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
                    <div class="modal-body">Pilih "Logout" di bawah jika Anda ingin mengakhiri sesi Anda saat
                        ini.</div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                        <a class="btn btn-primary" href="../logout.php">Logout</a>
                    </div>
                </div>
            </div>
        </div>
        <script src="../sbadmin/vendor/jquery/jquery.min.js"></script>
        <script src="../sbadmin/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="../sbadmin/vendor/jquery-easing/jquery.easing.min.js"></script>
        <script src="../sbadmin/js/sb-admin-2.min.js"></script>
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
        <script>
        function filterBooks(categoryId) {
            $(".searchable").each(function() {
                if (categoryId === null || $(this).data('category-id') === categoryId) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        }
        </script>
</body>

</html>