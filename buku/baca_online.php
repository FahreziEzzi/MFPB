<?php
// Sesuaikan dengan informasi koneksi database Anda
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_perpustakaan";

// Buat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Periksa koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ambil ID buku dari parameter GET
$book_id = $_GET['id'];

// Query untuk mendapatkan informasi buku
$sql = "SELECT * FROM buku WHERE id = $book_id";
$result = $conn->query($sql);

// Periksa apakah ada hasil
if ($result->num_rows > 0) {
    // Output data dari setiap baris
    while ($row = $result->fetch_assoc()) {
        echo "<h2>" . $row["judul"] . "</h2>";
        echo "<p><strong>Penulis:</strong> " . $row["penulis"] . "</p>";
        echo "<p><strong>Penerbit:</strong> " . $row["penerbit"] . "</p>";
        echo "<p><strong>Tahun Terbit:</strong> " . $row["tahun_terbit"] . "</p>";
        echo "<p><strong>Deskripsi:</strong> " . $row["deskripsi"] . "</p>";

        // Periksa apakah ada link e-book yang tersedia
        if (!empty($row["link_ebook"])) {
            echo "<p><a href='" . $row["link_ebook"] . "' target='_blank'>Baca E-book</a></p>";
        } else {
            echo "<p>E-book tidak tersedia untuk buku ini.</p>";
        }
    }
} else {
    echo "Buku tidak ditemukan.";
}

// Tutup koneksi
$conn->close();
