<?php
require '../vendor/autoload.php'; // Sesuaikan dengan path PHPMailer Anda
include '../koneksi.php';
// Include library PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil email dari form
    $email = $_POST['email'];
    // Generate reset code
    $reset_code = '';
    // Menghasilkan 6 karakter acak
    for ($i = 0; $i < 6; $i++) {
        $reset_code .= rand(0, 9); // Menghasilkan angka acak dari 0 hingga 9
    }
    // Simpan reset code ke database
    $sql = "INSERT INTO reset_password (email, reset_code) VALUES ('$email', '$reset_code')";
    if ($koneksi->query($sql) === TRUE) {
        // Kirim email menggunakan PHPMailer
        $mail = new PHPMailer(true);
        try {
            // Konfigurasi SMTP
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; // Ganti dengan host SMTP Anda
            $mail->SMTPAuth = true;
            $mail->Username = 'fahrezireziw1054@gmail.com'; // Ganti dengan email Anda
            $mail->Password = 'kpppwmwcpcnvuwiu'; // Ganti dengan password email Anda
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            // Siapkan email
            $mail->setFrom('fahrezireziw1054@gmail.com', 'admin'); // Ganti dengan email dan nama Anda
            $mail->addAddress($email); // Tambahkan penerima
            $mail->isHTML(true);
            $mail->Subject = 'Reset Your Password';
            $mail->Body = 'Code Verifikasi Password : ' . $reset_code;
            // Kirim email
            $mail->send();
            header('location: reset_password.php?email=' . urlencode($email));
        } catch (Exception $e) {
            // Redirect atau tampilkan pesan error
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        // Redirect atau tampilkan pesan error
        echo "Error: " . $sql . "<br>" . $koneksi->error;
    }
    $koneksi->close();
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
    <title>Login</title>
    <!-- Custom fonts for this template-->
    <link href="../sbadmin/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
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
                                </div>
                                <form class="user" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                    <!-- Tambahkan pesan error jika ada -->
                                    <?php if (isset($error_message)) { ?>
                                        <div class="alert alert-danger" role="alert">
                                            <?php echo $error_message; ?>
                                        </div>
                                    <?php } ?>
                                    <div class="form-group">
                                        <input type="email" class="form-control form-control-user" id="exampleInputEmail" name="email" aria-describedby="emailHelp" placeholder="Enter Email Address..." required>
                                    </div>
                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox small">
                                            <a href="../Registrasi.php" class="" for="customCheck">Daftar akun peminjam?</a>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-user btn-block">
                                        Kirim
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