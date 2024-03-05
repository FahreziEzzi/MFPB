<?php
session_start();
include "../koneksi.php";
if (!isset($_SESSION['username'])) {
    header("Location: ../login.php"); 
    exit();
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ulasan_id = $_POST['ulasan_id'];
    $ulasan_baru = $_POST['ulasan_baru'];

    // Update ulasan di database
    $updateQuery = "UPDATE ulasan_buku SET ulasan = '$ulasan_baru' WHERE id = $ulasan_id";
    $result = mysqli_query($koneksi, $updateQuery);

    if ($result) {
        // Redirect ke halaman ulasan
        header("Location: index.php?id=$buku_id");
        exit();
    } else {
        echo "Gagal mengupdate ulasan.";
    }
} else {
    // Mendapatkan ulasan yang akan diedit
    $ulasan_id = $_GET['id'];
    $query = "SELECT * FROM ulasan_buku WHERE id = $ulasan_id";
    $result = mysqli_query($koneksi, $query);

    if ($result) {
        $ulasan = mysqli_fetch_assoc($result);
    } else {
        echo "Ulasan tidak ditemukan.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit Ulasan</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container">
        <h2 class="mt-4">Edit Ulasan</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <input type="hidden" name="ulasan_id" value="<?= $ulasan_id ?>">
            <div class="form-group">
                <label for="ulasan">Ulasan:</label>
                <textarea class="form-control" id="ulasan" name="ulasan_baru"
                    rows="4"><?= $ulasan['ulasan'] ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>