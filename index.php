<?php
session_start();
require 'function.php';
if ($_SESSION['status'] != "login") {
  header("location:authentication/login.php");
}

$login = $_SESSION['id'];
$result = mysqli_query($db, "SELECT * FROM `admin` WHERE id ='$login'");
$admin = mysqli_fetch_array($result);

$total = mysqli_query($db, "SELECT COUNT(*) AS total FROM ruangan");
$data = mysqli_fetch_array($total);
$totalData1 = $data['total'];

$total2 = mysqli_query($db, "SELECT COUNT(*) AS total FROM pengajuan2 WHERE status = 'Menunggu Persetujuan'");
$data2 = mysqli_fetch_array($total2);
$totalData2 = $data2['total'];

$total3 = mysqli_query($db, "SELECT COUNT(*) AS total FROM pengajuan2 WHERE status = 'Disetujui'");
$data3 = mysqli_fetch_array($total3);
$totalData3 = $data3['total'];

$total4 = mysqli_query($db, "SELECT COUNT(*) AS total FROM pengajuan2 WHERE status = 'Terverifikasi'");
$data4 = mysqli_fetch_array($total4);
$totalData4 = $data4['total'];

$total5 = mysqli_query($db, "SELECT COUNT(*) AS total FROM pengajuan2 WHERE status = 'Ditolak'");
$data5 = mysqli_fetch_array($total5);
$totalData5 = $data5['total'];

// $cr1 = mysqli_query($db, "SELECT * FROM carousel_admin WHERE id = '1'");
// $carousel1 = mysqli_fetch_array($cr1);
// $cr2 = mysqli_query($db, "SELECT * FROM carousel_admin WHERE id = '2'");
// $carousel2 = mysqli_fetch_array($cr2);
// $cr3 = mysqli_query($db, "SELECT * FROM carousel_admin WHERE id = '3'");
// $carousel3 = mysqli_fetch_array($cr3);


// $total = mysqli_query($db, "SELECT COUNT(*) AS total FROM peserta");
// $data = mysqli_fetch_array($total);
// $totalData1 = $data['total'];

// $total2 = mysqli_query($db, "SELECT COUNT(*) AS total FROM peserta WHERE verifikasi_pembayaran = 'Terverifikasi'");
// $data2 = mysqli_fetch_array($total2);
// $totalData2 = $data2['total'];

// $total3 = mysqli_query($db, "SELECT COUNT(*) AS total FROM store");
// $data3 = mysqli_fetch_array($total3);
// $totalData3 = $data3['total'];

// Tanggal target
// $targetDate = "2023-09-02";

// Menghitung sisa hari
// $today = date("Y-m-d");
// $diff = strtotime($targetDate) - strtotime($today);
// $sisaHari = floor($diff / (60 * 60 * 24));

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin | SKPB-Facility</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="plugins/summernote/summernote-bs4.min.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Maven+Pro:wght@400;600;800&display=swap" rel="stylesheet">

  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;400;600;700;800;900&display=swap" rel="stylesheet">
  <link rel="apple-touch-icon" sizes="57x57" href="../public/img/favicon/apple-icon-57x57.png">
  <link rel="apple-touch-icon" sizes="60x60" href="../public/img/favicon/apple-icon-60x60.png">
  <link rel="apple-touch-icon" sizes="72x72" href="../public/img/favicon/apple-icon-72x72.png">
  <link rel="apple-touch-icon" sizes="76x76" href="../public/img/favicon/apple-icon-76x76.png">
  <link rel="apple-touch-icon" sizes="114x114" href="../public/img/favicon/apple-icon-114x114.png">
  <link rel="apple-touch-icon" sizes="120x120" href="../public/img/favicon/apple-icon-120x120.png">
  <link rel="apple-touch-icon" sizes="144x144" href="../public/img/favicon/apple-icon-144x144.png">
  <link rel="apple-touch-icon" sizes="152x152" href="../public/img/favicon/apple-icon-152x152.png">
  <link rel="apple-touch-icon" sizes="180x180" href="../public/img/favicon/apple-icon-180x180.png">
  <link rel="icon" type="image/png" sizes="192x192" href="../public/img/favicon/android-icon-192x192.png">
  <link rel="icon" type="image/png" sizes="32x32" href="../public/img/favicon/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="96x96" href="../public/img/favicon/favicon-96x96.png">
  <link rel="icon" type="image/png" sizes="16x16" href="../public/img/favicon/favicon-16x16.png">
  <link rel="manifest" href="/manifest.json">
  <meta name="msapplication-TileColor" content="#ffffff">
  <meta name="msapplication-TileImage" content="../public/img/favicon/ms-icon-144x144.png">
  <meta name="theme-color" content="#ffffff">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous" />
  <link href="https://fonts.googleapis.com/css2?family=Maven+Pro:wght@400;600;800&display=swap" rel="stylesheet">
  <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200;400;500;700;800&display=swap" rel="stylesheet">
</head>

<style>
  body {
    font-family: "Manrope", sans-serif !important;
  }
</style>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">

    <!-- Preloader -->
    <div class="preloader flex-column justify-content-center align-items-center">
      <img class="animation__shake" src="dist/img/Logo_SKPB-biru.png" height="180" width="180">
    </div>

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
      </ul>

      <!-- Right navbar links -->
      <!-- <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown">
          <a class="nav-link" data-toggle="dropdown" href="#">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
              <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
              <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z" />
            </svg>

          </a>
          <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <a href="authentication/logout.php" class="dropdown-item">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-left" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M6 12.5a.5.5 0 0 0 .5.5h8a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5h-8a.5.5 0 0 0-.5.5v2a.5.5 0 0 1-1 0v-2A1.5 1.5 0 0 1 6.5 2h8A1.5 1.5 0 0 1 16 3.5v9a1.5 1.5 0 0 1-1.5 1.5h-8A1.5 1.5 0 0 1 5 12.5v-2a.5.5 0 0 1 1 0v2z" />
                <path fill-rule="evenodd" d="M.146 8.354a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L1.707 7.5H10.5a.5.5 0 0 1 0 1H1.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3z" />
              </svg> Logout
            </a>
        </li>
      </ul> -->
    </nav>
    <!-- /.navbar -->

    <?php
    require 'components/aside.php';
    ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0">Dashboard Pengelola <b>Fasilitas SKPB</b></h1>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->

      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">

          <!-- Small boxes (Stat box) -->
          <div class="row">

          
            <div class="col-lg-3 col-6">
              <!-- small box -->
              <a href="menunggu-persetujuan.php" class="small-box bg-danger">
                <div class="inner">
                  <h3><?= $totalData2 ?></h3> 

                  <p>Pengajuan<b><br>Belum Disetujui</b></p>
                </div>
                <div class="icon">
                  <i class="fas fa-clock"></i>
                </div>
                <!--<a href="#" class="small-box-footer">Selengkapnya <i class="fas fa-arrow-circle-right"></i></a>-->
              </a>
            </div>
            <!-- ./col -->


            <div class="col-lg-3 col-6">
              <!-- small box -->
              <a href="menunggu-verifikasi.php" class="small-box bg-warning">
                <div class="inner">
                  <h3><?= $totalData3 ?></h3>

                  <p>Pengajuan<b><br>Menunggu Verifikasi Surat</b></p>
                </div>
                <div class="icon">
                  <i class="fas fa-file"></i>
                </div>
                <!--<a href="#" class="small-box-footer">Selengkapnya <i class="fas fa-arrow-circle-right"></i></a>-->
              </a>
            </div>
            <!-- ./col -->

            <div class="col-lg-3 col-6">
              <!-- small box -->
              <a href="terverifikasi.php" class="small-box bg-success">
                <div class="inner">
                  <h3><?= $totalData4 ?></h3>

                  <p>Pengajuan<b><br>Terverifikasi</b></p>
                </div>
                <div class="icon">
                  <i class="fas fa-check"></i>
                </div>
                <!--<a href="#" class="small-box-footer">Selengkapnya <i class="fas fa-arrow-circle-right"></i></a>-->
              </a>
            </div>
            <!-- ./col -->


            <div class="col-lg-3 col-6">
              <!-- small box -->
              <a href="pengajuan-ditolak.php" class="small-box bg-dark">
                <div class="inner">
                  <h3><?= $totalData5 ?></h3>

                  <p>Pengajuan <br><b>Ditolak</p>
                </div>
                <div class="icon">
                  <i class="fas fa-ban"></i>
                </div>
                <!--<a href="#" class="small-box-footer">Selengkapnya <i class="fas fa-arrow-circle-right"></i></a>-->
              </div>
            </a>
            <!-- ./col -->


            
          </div>
          <!-- /.row -->




          <!-- Main row -->
          <div class="row">
            <!-- Left col -->
            <!--  -->
            <!-- /.Left col -->
            <!-- right col (We are only adding the ID to make the widgets sortable)-->
            <section class="col-lg-6 connectedSortable">
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">
                    <i class="fas fa-text-width"></i>
                    Pengumuman
                  </h3>
                </div>

                <div class="card-body">
                  <dl>
                      <!-- <dd>Jika Terjadi Error Karena Bug diharapkan Admin / Data Center <b>Solve Problem Secara Manual Terlebih dahulu</b>, menggunakan fitur edit, atau fitur lainnya</dd><br><br>
                   
                    <dt>Halo Panitia OMITS 16!</dt>
                    <dd>Semangat menyelesaikan jobdescnya ya!</dd>
                    <dd>Diaharapkan, seluruh panitia dapat menjaga <b>kerahasiaan akun maupun link url</b> dari dashboard admin</dd>
                    <dd>untuk meminimalisir kemungkinan terburuk yang dapat terjadi pada website</dd>
                     <dd>Terima Kasih! Selamat Bertugas!</dd> -->
                  </dl>
                </div>
            </section>
            <!-- right col -->
          </div>
          <!-- /.row (main row) -->
        </div><!-- /.container-fluid -->
      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <footer class="main-footer">
      <strong>Copyright &copy; 2024 <a href="#">SKPB ITS</a>.</strong>
      All rights reserved.

    </footer>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
  </div>
  <!-- ./wrapper -->

  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js"></script>

  <!-- jQuery -->
  <script src="plugins/jquery/jquery.min.js"></script>
  <!-- jQuery UI 1.11.4 -->
  <script src="plugins/jquery-ui/jquery-ui.min.js"></script>
  <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
  <script>
    $.widget.bridge('uibutton', $.ui.button)
  </script>
  <!-- Bootstrap 4 -->
  <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- ChartJS -->
  <script src="plugins/chart.js/Chart.min.js"></script>
  <!-- Sparkline -->
  <script src="plugins/sparklines/sparkline.js"></script>
  <!-- JQVMap -->
  <script src="plugins/jqvmap/jquery.vmap.min.js"></script>
  <script src="plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
  <!-- jQuery Knob Chart -->
  <script src="plugins/jquery-knob/jquery.knob.min.js"></script>
  <!-- daterangepicker -->
  <script src="plugins/moment/moment.min.js"></script>
  <script src="plugins/daterangepicker/daterangepicker.js"></script>
  <!-- Tempusdominus Bootstrap 4 -->
  <script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
  <!-- Summernote -->
  <script src="plugins/summernote/summernote-bs4.min.js"></script>
  <!-- overlayScrollbars -->
  <script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
  <!-- AdminLTE App -->
  <script src="dist/js/adminlte.js"></script>

</body>

</html>