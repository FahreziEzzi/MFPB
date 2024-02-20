<?php
// Include file konfigurasi database
include '../koneksi.php';

// Inisialisasi variabel untuk menyimpan pesan kesalahan atau kesuksesan
$message = '';

// Jika metode request adalah POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil kode reset dari form
    $reset_code = $_POST['reset_code'];

    // Ambil email yang terkait dengan kode reset
    $email = $_POST['email'];

    // Cek apakah kode reset yang dimasukkan oleh pengguna sesuai dengan yang tersimpan di database
    $sql = "SELECT * FROM reset_password WHERE email='$email' AND reset_code='$reset_code'";
    $result = $koneksi->query($sql);

    if ($result->num_rows > 0) {
        // Jika kode reset cocok, arahkan pengguna ke halaman untuk mengatur password baru
        header('location: set_new_password.php?email=' . $email);
    } else {
        // Jika kode reset tidak cocok, tampilkan pesan kesalahan
        $message = 'Invalid reset code. Please try again.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Include bagian head sesuai kebutuhan Anda -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Reset Password</title>

    <!-- Custom fonts for this template-->
    <link href="../sbadmin/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="../sbadmin/css/sb-admin-2.min.css" rel="stylesheet">

    <style>
        body {
            background: blue;
        }

        .container {
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .card {
            border: 0;
            border-radius: 10px;
            overflow: hidden;
        }
    </style>

</head>

<body>

    <div class="container">

        <div class="col-xl-10 col-lg-12 col-md-9">

            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-10">
                    <div class="row">
                        <div class="col-lg-10 mx-auto">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4">Reset Password</h1>
                                    <?php if (!empty($message)) { ?>
                                        <div class="alert alert-danger" role="alert">
                                            <?php echo $message; ?>
                                        </div>
                                    <?php } ?>
                                </div>
                                <form class="user" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                    <input type="hidden" name="email" value="<?php echo $_GET['email']; ?>">
                                    <div class="form-group">
                                        <input type="text" class="form-control form-control-user"
                                            id="reset_code" name="reset_code" aria-describedby="resetCodeHelp"
                                            placeholder="Enter Reset Code..." required>
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-user btn-block">
                                        Submit
                                    </button>
                                    <hr>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="../sbadmin/vendor/jquery/jquery.min.js"></script>
    <script src="../sbadmin/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="../sbadmin/vendor/jquery-easing/jquery.easing.min.js"></script>
    <!-- Custom scripts for all pages-->
    <script src="../sbadmin/js/sb-admin-2.min.js"></script>

</body>

</html>