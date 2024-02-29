<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Buku - Perpustakaan Digital</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f4f4f4;
    }

    .container {
        width: 80%;
        margin: 50px auto;
        background-color: #fff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    h1 {
        text-align: center;
        color: #333;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    table,
    th,
    td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: left;
    }

    th {
        background-color: #f2f2f2;
    }
    </style>
</head>

<body>
    <div class="container">
        <h1>Daftar Buku</h1>
        <table>
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Judul</th>
                    <th>Penulis</th>
                    <th>Penerbit</th>
                    <th>Tahun Terbit</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Koneksi ke database
                $koneksi = mysqli_connect("localhost", "root", "", "db_perpustakaan");

                // Periksa koneksi
                if (!$koneksi) {
                    die("Koneksi gagal: " . mysqli_connect_error());
                }

                // Query untuk mengambil data buku
                $sql = "SELECT * FROM buku";
                $result = mysqli_query($koneksi, $sql);

                // Periksa apakah ada data
                if (mysqli_num_rows($result) > 0) {
                    $no = 1;
                    // Tampilkan data setiap baris sebagai row dalam tabel
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . $no . "</td>";
                        echo "<td>" . $row['judul'] . "</td>";
                        echo "<td>" . $row['penulis'] . "</td>";
                        echo "<td>" . $row['penerbit'] . "</td>";
                        echo "<td>" . $row['tahun_terbit'] . "</td>";
                        echo "</tr>";
                        $no++;
                    }
                } else {
                    echo "<tr><td colspan='5'>Tidak ada data buku.</td></tr>";
                }

                // Tutup koneksi
                mysqli_close($koneksi);
                ?>
            </tbody>
        </table>
    </div>
</body>

</html>