<?php
session_start();
include '../koneksi.php';
// Check if the user is not logged in
if (!isset($_SESSION['username'])) {
    header("Location: ../login.php");
    exit();
}
$username = $_SESSION['username'];
$filter_date = isset($_POST['filter_date']) ? $_POST['filter_date'] : '';
$filter_end_date = isset($_POST['filter_end_date']) ? $_POST['filter_end_date'] : '';
$filter_status = isset($_POST['status_peminjaman']) ? $_POST['status_peminjaman'] : '';

// Tentukan kolom untuk filter berdasarkan tanggal
$filter_column = '';
// Menentukan kolom yang akan digunakan untuk filter
if (!empty($filter_date) && !empty($filter_end_date)) {
    $filter_column = "tanggal_peminjaman BETWEEN '$filter_date' AND '$filter_end_date'";
} elseif (!empty($filter_date)) {
    $filter_column = "tanggal_peminjaman = '$filter_date'";
} elseif (!empty($filter_end_date)) {
    $filter_column = "tanggal_pengembalian = '$filter_end_date'";
}

// Menentukan filter berdasarkan status peminjaman
$status_filter = '';
if (!empty($filter_status)) {
    $status_filter = " AND status_peminjaman = '$filter_status'";
}

// Query to fetch peminjaman data joined with buku and user data
$query = "SELECT p.*, b.judul AS judul_buku, u.nama_lengkap AS nama_peminjam, b.cover 
          FROM peminjaman p
          JOIN buku b ON p.buku = b.id
          JOIN user u ON p.user = u.id";
// Menambahkan filter berdasarkan tanggal jika ada
if (!empty($filter_column)) {
    $query .= " WHERE $filter_column";
}

// Menambahkan filter berdasarkan status peminjaman
$query .= $status_filter;

$result = mysqli_query($koneksi, $query);

// Buat objek Spreadsheet
require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
// Tulis header untuk kolom
$sheet->setCellValue('A1', 'ID');
$sheet->setCellValue('B1', 'Nama Buku');
$sheet->setCellValue('C1', 'Nama Peminjam');
$sheet->setCellValue('D1', 'Tanggal Peminjaman');
$sheet->setCellValue('E1', 'Tanggal Pengembalian');
$sheet->setCellValue('F1', 'Status');
// Tambahkan data dari database ke Excel
$row = 2; // Mulai dari baris ke-2
while ($row_data = mysqli_fetch_assoc($result)) {
    $sheet->setCellValue('A' . $row, $row_data['id']);
    $sheet->setCellValue('B' . $row, $row_data['judul_buku']);
    $sheet->setCellValue('C' . $row, $row_data['nama_peminjam']);
    $sheet->setCellValue('D' . $row, $row_data['tanggal_peminjaman']);
    $sheet->setCellValue('E' . $row, $row_data['tanggal_pengembalian']);
    $sheet->setCellValue('F' . $row, $row_data['status_peminjaman']);
    $row++;
}
// Set nama file Excel
$filename = 'laporan_peminjaman.xlsx';
// Output Excel
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' . $filename . '"');
header('Cache-Control: max-age=0');
$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;
