<?php

include '../koneksi.php';

// Check if the user is not logged in
if (!isset($_SESSION['username'])) {
    echo "<script>alert('Tolong login terlebih dahulu'); window.location.href = '../login.php';</script>";
    exit();
}

// Fetch user role from the database based on the username in the session
$username = $_SESSION['username'];

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Lihat Ulasan</title>
    <!-- SweetAlert CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10">
    <!-- Custom fonts for this template-->
    <link href="../sbadmin/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="../sbadmin/css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Custom styles for PDF display -->
    <style>
    /* Custom styles for PDF display */
    .pdf-container-wrapper {
        display: flex;
        align-items: center;
        /* Mengatur konten ke tengah secara vertikal */
        justify-content: space-between;
        /* Menempatkan tombol navigasi di kedua sisi konten */
        margin-bottom: 20px;
    }

    #pdf-container {
        max-width: 100%;
        flex-grow: 1;
        /* Konten PDF akan memanjang sepanjang sisa ruang yang tersedia */
    }

    .page-navigation-button {
        background-color: transparent;
        border: none;
        cursor: pointer;
        font-size: 20px;
    }

    .page-navigation {
        display: flex;
        justify-content: space-between;
        margin-bottom: 20px;
    }

    .page-navigation button {
        background-color: transparent;
        border: none;
        cursor: pointer;
        font-size: 20px;
    }
    </style>

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <a href="index.php" class="btn btn-primary btn-icon-split back-button">
                        <span class="icon text-white-50">
                            <i class="fas fa-arrow-left"></i>
                        </span>

                    </a>
                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                                    <?= $_SESSION['username']; ?>
                                </span>
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>
                    </ul>

                </nav>

                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container">
                    <div class="pdf-container-wrapper">
                        <button id="prev-page" class="page-navigation-button"><i
                                class="fas fa-chevron-left"></i></button>
                        <div class="text-center" id="pdf-container"></div>
                        <button id="next-page" class="page-navigation-button"><i
                                class="fas fa-chevron-right"></i></button>
                    </div>
                </div>


                <!-- Tombol untuk kembali ke halaman index.php -->


            </div>
            <!-- End of Main Content -->

            <!-- Footer -->

            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="../logout.php">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="../sdbadmin/vendor/jquery/jquery.min.js"></script>
    <script src="../sdbadmin/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="../sdbadmin/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../sdbadmin/js/sb-admin-2.min.js"></script>

    <!-- Custom scripts for PDF display -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.11.338/pdf.min.js"></script>
    <script>
    // PDF file URL
    const pdfUrl = "<?= $pdfPath; ?>";

    // Initialize PDF.js
    const pdfjsLib = window["pdfjs-dist/build/pdf"];

    // Disable workers to avoid issues with cross-origin PDFs
    pdfjsLib.GlobalWorkerOptions.workerSrc = "https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.11.338/pdf.worker.min.js";

    // PDF.js rendering options
    const options = {
        cMapUrl: "https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.11.338/cmaps/",
        cMapPacked: true
    };

    // Global variables
    let pdf = null;
    let currentPage = 1;

    // Fetch PDF document
    pdfjsLib.getDocument(pdfUrl, options).promise.then(pdfDocument => {
        pdf = pdfDocument;
        displayPage(currentPage);
    });

    // Function to display a specific page
    function displayPage(pageNumber) {
        pdf.getPage(pageNumber).then(page => {
            // Set up the canvas
            const canvas = document.createElement("canvas");
            const context = canvas.getContext("2d");
            const viewport = page.getViewport({
                scale: 1
            }); // Adjust scale here if needed

            canvas.height = viewport.height;
            canvas.width = viewport.width;

            // Render PDF page into canvas context
            const renderContext = {
                canvasContext: context,
                viewport: viewport
            };
            page.render(renderContext);

            // Display canvas in the HTML
            const pdfContainer = document.getElementById("pdf-container");
            pdfContainer.innerHTML = "";
            pdfContainer.appendChild(canvas);
        });
    }

    // Function to display next page
    document.getElementById("next-page").addEventListener("click", function() {
        if (currentPage < pdf.numPages) {
            currentPage++;
            displayPage(currentPage);
        }
    });

    // Function to display previous page
    document.getElementById("prev-page").addEventListener("click", function() {
        if (currentPage > 1) {
            currentPage--;
            displayPage(currentPage);
        }
    });
    </script>
</body>

</html>