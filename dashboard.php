<?php
include "koneksi.php";
session_start();
$role = $_SESSION['role'];
$username = $_SESSION['username'];
$sql = "SELECT * FROM buku";
$result = mysqli_query($koneksi, $sql);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <style>
    #searchDropdown {
      display: none;
    }

    .nav-item.active .nav-link span {
      font-size: 17px !important;
    }

    .nav-item.side .nav-link span {
      font-size: 17px !important;
    }
  </style>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>Dashboard</title>
  <link href="sbadmin/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
  <link href="sbadmin/css/sb-admin-2.min.css" rel="stylesheet">
</head>

<body id="page-top">
  <div id="wrapper">

    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon rotate-n-15">
          <i class="fas fa-angry"></i>
        </div>
        <div class="sidebar-brand-text mx-3">
          <?php
          echo $role === 'admin' ? 'Admin' : 'Petugas';
          ?>
        </div>
      </a>
      <hr class="sidebar-divider my-0">
      <li class="nav-item active">
        <a class="nav-link" href="dashboard.php">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Dashboard</span></a>
      </li>
      <hr class="sidebar-divider">
      <?php
      if ($role === 'admin') :
      ?>
        <li class="nav-item side">
          <a class="nav-link" href="buku/index.php">
            <i class="fas fa-fw fa-book"></i>
            <span>Data Buku</span></a>
        </li>
        <li class="nav-item side">
          <a class="nav-link" href="datapengguna/data_pengguna.php">
            <i class="fas fa-fw fa-user"></i>
            <span>Data Pengguna</span></a>
        </li>
        <li class="nav-item side">
          <a class="nav-link" href="peminjaman/peminjaman.php">
            <i class="fas fa-fw fa-handshake"></i>
            <span>Peminjam</span></a>
        </li>
        <hr class="sidebar-divider">
        <li class="nav-item side">
          <a class="nav-link" href="ulasan/index.php">
            <i class="fas fa-fw fa-book"></i>
            <span>Ulasan</span></a>
        </li>
        <li class="nav-item side">
          <a class="nav-link" href="laporan/laporan.php">
            <i class="fas fa-fw fa-book"></i>
            <span>Laporan</span></a>
        </li>
        <hr class="sidebar-divider">
        <li class="nav-item side">
          <a class="nav-link" href="registrasi_anggota.php">
            <i class="fas fa-fw fa-user"></i>
            <span>Registrasi</span></a>
        </li>
        <li class="nav-item side">
          <a class="nav-link" href="logout.php">
            <i class="fas fa-fw fa-user"></i>
            <span>Logout</span></a>
        </li>

      <?php endif ?>
      <?php
      if ($role === 'petugas') :
      ?>
        <li class="nav-item side">
          <a class="nav-link" href="buku/index.php">
            <i class="fas fa-fw fa-book"></i>
            <span>Data Buku</span></a>
        </li>
        <li class="nav-item active">
          <a class="nav-link" href="peminjaman/peminjaman.php">
            <i class="fas fa-fw fa-file-alt"></i>
            <span>Peminjam</span></a>
        </li>
        <li class="nav-item active">
          <a class="nav-link" href="laporan/laporan.php">
            <i class="fas fa-print"></i>
            <span>Laporan</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="logout.php">
            <i class="fas fa-sign-out-alt"></i>
            <span>Logout</span></a>
        </li>
      <?php endif ?>
      <hr class="sidebar-divider d-none d-md-block">
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>
    </ul>
    <div id="content-wrapper" class="d-flex flex-column">
      <div id="content">
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">


          <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>
          <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown no-arrow d-sm-none">
              <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
                <form class="form-inline mr-auto w-100 navbar-search">
                  <div class="input-group">
                    <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                    <div class="input-group-append">
                      <button class="btn btn-primary" type="button">
                        <i class="fas fa-search fa-sm"></i>
                      </button>
                    </div>
                  </div>
                </form>
              </div>
            </li>
            <div class="topbar-divider d-none d-sm-block">
            </div>
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                  <?= $_SESSION['username']; ?>
                </span>
              </a>

              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">

                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                  Logout
                </a>
              </div>
            </li>

          </ul>

        </nav>
        <div class="container-fluid">
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
          </div>
          <div class="row">
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-primary shadow h-100 py-2" style="background-color: #4e73df;">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-white text-uppercase mb-1">
                        daftar pengunjung</div>
                      <div class="h5 mb-0 font-weight-bold text-white">7</div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-user fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-success shadow h-100 py-2" style="background-color: #1cc88a;">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-white text-uppercase mb-1">
                        buku Di Pinjam</div>
                      <div class="h5 mb-0 font-weight-bold text-white">19</div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-book fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card  shadow h-100 py-2" style="background-color: #ffb000;">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-white text-uppercase mb-1">Buku Tersedia
                      </div>
                      <div class="row no-gutters align-items-center">
                        <div class="col-auto">
                          <div class="h5 mb-0 mr-3 font-weight-bold text-white">50</div>
                        </div>
                      </div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-book fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <table class="table table-hover" id="bookTable">
            <thead>
              <tr>
                <th scope="col">ID</th>
                <th scope="col">cover</th>
                <th scope="col">Judul</th>
                <th scope="col">Pengarang</th>
                <th scope="col">Tahun Terbit</th>
                <th style="text-align: center;">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php while ($data = mysqli_fetch_assoc($result)) : ?>
                <tr>
                  <td><?= $data['id'] ?></td>
                  <td><img src="buku/<?= $data['cover'] ?>" alt="Cover Buku" style="max-width: 100px; max-height: 100px;"></td>
                  <td><?= $data['judul'] ?></td>
                  <td><?= $data['penulis'] ?></td>
                  <td><?= $data['tahun_terbit'] ?></td>
                  <td class="text-center">
                    <a class="badge badge-danger" onclick="return confirm('Yakin Mau Hapus buku?')" href="buku/delete.php?id=<?= $data['id'] ?>">Delete</a>
                    <a class="badge badge-success" href="buku/edit.php?id=<?= $data['id'] ?>">Edit</a>
                  </td>
                </tr>
              <?php endwhile ?>
            </tbody>
          </table>
        </div>
      </div>

    </div>
  </div>
  </div>
  <footer class="sticky-footer bg-white">
    <div class="container my-auto">
      <div class="copyright text-center my-auto">
        <span>Copyright &copy; Your Website 2021</span>
      </div>
    </div>
  </footer>
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
          <a class="btn btn-primary" href="login.php">Logout</a>
        </div>
      </div>
    </div>
  </div>
  <script src="sbadmin/vendor/jquery/jquery.min.js"></script>
  <script src="sbadmin/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="sbadmin/vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="sbadmin/js/sb-admin-2.min.js"></script>
  <script src="sbadmin/vendor/chart.js/Chart.min.js"></script>
  <script src="sbadmin/js/demo/chart-area-demo.js"></script>
  <script src="sbadmin/js/demo/chart-pie-demo.js"></script>

  <script>
    $(document).ready(function() {
      // Mengatur tindakan logout saat tombol logout ditekan
      $('#logout').click(function() {
        // Redirect ke halaman logout.php atau sesuai halaman logout Anda
        window.location.href = 'login.php';
      });
    });
  </script>

</body>

</html>