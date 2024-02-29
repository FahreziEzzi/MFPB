<?php
include '../koneksi.php';
session_start();
$role = isset($_SESSION['role']) ? $_SESSION['role'] : '';
$username = isset($_SESSION['username']) ? $_SESSION['username'] : '';

// Check apakah pengguna sudah login
if (!isset($_SESSION['username'])) {
    header("Location: ../login.php"); // Redirect ke halaman login jika belum login
    exit();
}

$username = $_SESSION['username'];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data yang dikirimkan dari form
    $judul = htmlspecialchars($_POST["judul"]);
    $penulis = htmlspecialchars($_POST["penulis"]);
    $penerbit = htmlspecialchars($_POST["penerbit"]);
    $tahun_terbit = htmlspecialchars($_POST["tahun_terbit"]);
    $kategori_id = htmlspecialchars($_POST["kategori_id"]);
    $deskripsi = mysqli_real_escape_string($koneksi, $_POST["deskripsi"]);
    $stok = htmlspecialchars($_POST["stok"]); // Menambahkan penanganan untuk stok

    // Lakukan validasi dan penambahan buku
    if (!empty($judul) && !empty($penulis) && !empty($penerbit) && !empty($tahun_terbit) && !empty($kategori_id) && !empty($stok) && !empty($deskripsi)) {
        // Query untuk memeriksa apakah buku sudah ada
        $check_book_query = "SELECT * FROM `buku` WHERE `judul` = '$judul' AND `penulis` = '$penulis' AND `penerbit` = '$penerbit' AND `tahun_terbit` = '$tahun_terbit' AND `kategori_id` = '$kategori_id'";
        $result_check_book = mysqli_query($koneksi, $check_book_query);

        if (mysqli_num_rows($result_check_book) > 0) {
            // Buku sudah ada, tampilkan pesan error
            $error_message = "Buku ini sudah ada.";
        } else {
            $perpus_id = 0;
            $cover = $_FILES['cover'];
            $cover_path = 'cover/';

            if (move_uploaded_file($cover['tmp_name'], $cover_path . $cover['name'])) {
                // File cover berhasil diunggah, simpan data buku ke database
                $cover_filename = $cover['name'];

                $add_book_query = "INSERT INTO `buku` (`perpus_id`, `judul`, `deskripsi`, `cover`, `penulis`, `penerbit`, `tahun_terbit`, `stok`, `kategori_id`, `created_at`)
                VALUES ('$perpus_id', '$judul', '$deskripsi', '$cover_filename', '$penulis', '$penerbit', '$tahun_terbit', '$stok', '$kategori_id', current_timestamp())";

                // Eksekusi query dan tampilkan pesan sukses atau error
                if (mysqli_query($koneksi, $add_book_query)) {
                    $success_message = "Buku berhasil ditambahkan.";
                } else {
                    $error_message = "Error: " . mysqli_error($koneksi);
                }
            } else {
                $error_message = "Error uploading cover file.";
            }
        }
    } else {
        $error_message = "Semua kolom harus diisi.";
    }
}

// Query untuk mengambil data kategori buku dari database
$get_kategori_query = "SELECT * FROM kategori_buku";
$result_kategori = mysqli_query($koneksi, $get_kategori_query);

// Inisialisasi variabel untuk menyimpan opsi kategori buku
$options_kategori = '';

// Memproses hasil query kategori buku menjadi opsi HTML
if (mysqli_num_rows($result_kategori) > 0) {
    while ($row_kategori = mysqli_fetch_assoc($result_kategori)) {
        $options_kategori .= '<option value="' . $row_kategori['id'] . '">' . $row_kategori['nama_kategori'] . '</option>';
    }
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
    <title>Tambah Buku</title>
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
            <li class="nav-item active">
                <a class="nav-link" href="../dashboard.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>
            <hr class="sidebar-divider">
            <?php
            if ($role === 'admin') :
            ?>
            <li class="nav-item side">
                <a class="nav-link" href="">
                    <i class="fas fa-fw fa-book"></i>
                    <span>Data Buku</span></a>
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
                    <i class="fas fa-fw fa-book"></i>
                    <span>Laporan</span></a>
            </li>
            <hr class="sidebar-divider">
            <li class="nav-item side">
                <a class="nav-link" href="registrasi_anggota.php">
                    <i class="fas fa-fw fa-user-check"></i>
                    <span>Registrasi</span></a>
            </li>
            <li class="nav-item side">
                <a class="nav-link" href="../logout.php">
                    <i class="fas fa-fw fa-user"></i>
                    <span>Logout</span></a>
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
                </nav>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4">Tambah Buku</h1>
                                </div>
                                <form class="user" action="process_tambah_buku.php" method="post"
                                    enctype="multipart/form-data">
                                    <div class="form-group">
                                        <input type="text" class="form-control form-control-user" id="inputJudul"
                                            placeholder="Judul Buku" name="judul" required>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control form-control-user" id="inputPenulis"
                                            placeholder="Penulis" name="penulis" required>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control form-control-user" id="inputPenerbit"
                                            placeholder="Penerbit" name="penerbit" required>
                                    </div>
                                    <div class="form-group">
                                        <input type="number" class="form-control form-control-user"
                                            id="inputTahunTerbit" placeholder="Tahun Terbit" name="tahun_terbit"
                                            required>
                                    </div>
                                    <div class="form-group">
                                        <input type="number" class="form-control form-control-user" id="inputStok"
                                            placeholder="Stok" name="stok" required>
                                    </div>
                                    <div class="form-group">
                                        <textarea class="form-control form-control-user" id="inputDeskripsi"
                                            placeholder="Deskripsi" name="deskripsi" required></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="kategori_id">Kategori:</label>
                                        <select class="form-control" id="kategori_id" name="kategori_id">
                                            <?php echo $options_kategori; ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputGambar">cover Buku:</label>
                                        <input type="file" class="form-control-file" id="inputGambar" name="cover"
                                            accept="image/*">
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-user btn-block">Tambah
                                        Buku</button>
                                    <hr>
                                </form>
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