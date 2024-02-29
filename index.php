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
            background-image: url('https://mysch.id/cms_web/upload/picture/84900989aplikasi-perpustakaan-digital.jpg');
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
        }

        .navbar a {
            color: #fff;
            text-decoration: none;
            margin: 0 22px;
            transition: background-color 0.3s;

        }

        .navbar a.right {
            float: right;
        }

        .navbar a:hover {
            background-color: #387ADF;

        }

        h1 {
            color: #333;
        }

        p {
            color: #666;
            font-size: 18px;
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
        <p>Temukan ribuan buku dan materi bacaan digital dengan mudah.</p>
        <a href="login.php" class="btn">Get Started</a>
    </div>
    <div class="rekomendasi">
        <h2>Rekomendasi Buku</h2>
    </div>
</body>

</html>