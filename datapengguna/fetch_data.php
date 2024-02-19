<?php
session_start();
include "../koneksi.php";

// Inisialisasi kondisi filter
$filter_condition = '';
$selected_role = '';

// Periksa apakah role_filter telah diberikan
if (isset($_GET['role_filter']) && !empty($_GET['role_filter'])) {
    $selected_role = $_GET['role_filter'];
    if ($selected_role !== 'all') {
        $filter_condition = "WHERE role = ?";
    }
}

// Persiapkan pernyataan SQL
$sql = "SELECT * FROM user $filter_condition";
$stmt = mysqli_prepare($koneksi, $sql);

// Bind parameter jika diperlukan
if ($selected_role !== 'all') {
    mysqli_stmt_bind_param($stmt, "s", $selected_role);
}

// Jalankan pernyataan SQL
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

// Cek apakah ada baris hasil
if (mysqli_num_rows($result) > 0) {
    // Tampilkan data
    while ($data = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>{$data['id']}</td>";
        echo "<td>{$data['username']}</td>";
        echo "<td>{$data['email']}</td>";
        echo "<td>{$data['nama_lengkap']}</td>";
        echo "<td>{$data['alamat']}</td>";
        echo "<td>{$data['role']}</td>";
        echo "</tr>";
    }
} else {
    // Tampilkan pesan jika tidak ada data yang ditemukan
    echo "<tr><td colspan='6'>Tidak ada data yang ditemukan</td></tr>";
}

// Tutup pernyataan dan koneksi
mysqli_stmt_close($stmt);
mysqli_close($koneksi);
?>
