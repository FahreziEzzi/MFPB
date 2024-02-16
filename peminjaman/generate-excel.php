<?php
// Load Composer's autoloader
require '../vendor/autoload.php';

// Create new PhpSpreadsheet object
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Include database connection
include "../koneksi.php";

// Create new Spreadsheet object
$spreadsheet = new Spreadsheet();

// Add worksheet
$sheet = $spreadsheet->getActiveSheet();

// Set headers
$sheet->setCellValue('A1', 'No');
$sheet->setCellValue('B1', 'User');
$sheet->setCellValue('C1', 'Buku');
$sheet->setCellValue('D1', 'Tanggal Peminjaman');
$sheet->setCellValue('E1', 'Tanggal Pengembalian');
$sheet->setCellValue('F1', 'Status Peminjaman');

// Prepare query to get data from database with optional date filters
$sql = "SELECT p.id, u.nama_lengkap AS user, b.judul AS buku, p.tanggal_peminjaman, p.tanggal_pengembalian, p.status_peminjaman
        FROM peminjaman p
        INNER JOIN user u ON p.user = u.id
        INNER JOIN buku b ON p.buku = b.id";
if (isset($_POST['tanggal_peminjaman']) && !empty($_POST['tanggal_peminjaman'])) {
    $tanggal_peminjaman = $_POST['tanggal_peminjaman'];
    $sql .= " WHERE p.tanggal_peminjaman >= '$tanggal_peminjaman'";
}
if (isset($_POST['tanggal_pengembalian']) && !empty($_POST['tanggal_pengembalian'])) {
    $tanggal_pengembalian = $_POST['tanggal_pengembalian'];
    $sql .= isset($_POST['tanggal_peminjaman']) && !empty($_POST['tanggal_peminjaman']) ? " AND" : " WHERE";
    $sql .= " p.tanggal_pengembalian <= '$tanggal_pengembalian'";
}

$result = mysqli_query($koneksi, $sql);

// Set row counter
$row = 2;

// Loop through query results
if (mysqli_num_rows($result) > 0) {
    $no = 1;
    while ($data = mysqli_fetch_assoc($result)) {
        // Add data to spreadsheet
        $sheet->setCellValue('A' . $row, $no);
        $sheet->setCellValue('B' . $row, $data['user']);
        $sheet->setCellValue('C' . $row, $data['buku']);
        $sheet->setCellValue('D' . $row, $data['tanggal_peminjaman']);
        $sheet->setCellValue('E' . $row, $data['tanggal_pengembalian']);
        $sheet->setCellValue('F' . $row, $data['status_peminjaman']);

        // Increment row counter and data counter
        $row++;
        $no++;
    }
}

// Set Excel format
$writer = new Xlsx($spreadsheet);
$filename = 'Daftar_Peminjaman.xlsx';

// Save Excel to a file
$writer->save($filename);

// Set header to force download the Excel file
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' . $filename . '"');
header('Cache-Control: max-age=0');

// Send Excel file to browser
$writer->save('php://output');
