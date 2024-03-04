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