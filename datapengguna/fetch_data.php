<?php
session_start();
include "../koneksi.php";
if (isset($_GET['role_filter']) && !empty($_GET['role_filter'])) {
    $selected_role = $_GET['role_filter'];
    $filter_condition = '';
    if ($selected_role !== 'all') {
        $filter_condition = "WHERE role = '$selected_role'";
    }
    $sql = "SELECT * FROM user $filter_condition";
    $result = mysqli_query($koneksi, $sql);
    if (mysqli_num_rows($result) > 0) {
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
        echo "<tr><td colspan='6'>Tidak ada data yang ditemukan</td></tr>";
    }
} else {

    $sql = "SELECT * FROM user";
    $result = mysqli_query($koneksi, $sql);
    if (mysqli_num_rows($result) > 0) {
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
        echo "<tr><td colspan='6'>Tidak ada data yang ditemukan</td></tr>";
    }
}
mysqli_close($koneksi);
