<?php
// Include your database connection file if not already included
include('koneksi.php');



?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Registrasi</title>

    <!-- Custom fonts for this template-->
    <link href="sbadmin/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="sbadmin/css/sb-admin-2.min.css" rel="stylesheet">

    <style>
    body {
        background-color: #4e73df
    }

    .container {

        /* Set the container height to fill the viewport */
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .card.o-hidden.border-0.shadow-lg.my-5 {
        border: none;
        -webkit-box-shadow: none;
        box-shadow: none;
    }

    .card-body {
        padding: 2rem;
    }

    .bg-gradient-primary {
        background: linear-gradient(180deg, #4e73df 10%, #224abe 100%);
    }
    </style>

</head>

<body class="bg-gradient-primary">

    <div class="container">

        <div class="col-lg-6">

            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4">Registrasi</h1>
                                </div>
                                <form class="user" action="process_registration.php" method="post">
                                    <div class="form-group">
                                        <input type="text" class="form-control form-control-user" id="inputUsername"
                                            placeholder="Username" name="username" required>
                                    </div>
                                    <div class="form-group">
                                        <input type="email" class="form-control form-control-user" id="inputEmail"
                                            placeholder="Email Address" name="email" required>
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control form-control-user" id="inputPassword"
                                            placeholder="Password" name="password" required>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control form-control-user" id="inputFullName"
                                            placeholder="Full Name" name="full_name" required>
                                    </div>
                                    <div class="form-group">
                                        <textarea class="form-control form-control-user" id="inputAddress"
                                            placeholder="Address" name="address" required></textarea>
                                    </div>
                                    <input type="hidden" name="role" value="peminjam">
                                    <button type="submit" class="btn btn-primary btn-user btn-block">Register</button>
                                    <hr>
                                </form>
                                <hr>
                                <div class="text-center">
                                    <a class="small" href="login.php">Already have an account? Login!</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

    <!-- Bootstrap core JavaScript -->
    <script src="sbadmin/vendor/jquery/jquery.min.js"></script>
    <script src="sbadmin/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Core plugin JavaScript -->
    <script src="sbadmin/vendor/jquery-easing/jquery.easing.min.js"></script>
    <!-- Custom scripts for all pages -->
    <script src="sbadmin/js/sb-admin-2.min.js"></script>

</body>

</html>