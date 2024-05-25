<?php 
session_start();
if ($_SESSION['status'] != "login") {
  header("location:authentication/login.php");
}

require 'function.php';

$login = $_SESSION['id'];
$result = mysqli_query($db, "SELECT * FROM `admin` WHERE id ='$login'");
$admin = mysqli_fetch_array($result);

// Cek apakah terdapat URL sebelumnya yang disimpan dalam sesi
if(isset($_SESSION['previous_url'])){
  $previous_url = $_SESSION['previous_url'];
  unset($_SESSION['previous_url']); // Hapus URL sebelumnya dari sesi
} else {
  // Jika tidak ada URL sebelumnya, arahkan ke halaman default
  $previous_url = 'default.php';
}
 ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Ubah Data Kelas SKPB</title>

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


  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>


<style>
  body {
    font-family: 'Maven Pro', sans-serif !important;
  }
</style>


<?php
$id = $_GET["id"];

$ajuan_peminjaman = query("SELECT * FROM pengajuan2 WHERE id =$id")[0];


//cek apakah tombol submit sudah di tekan atau belum
if (isset($_POST["submit"])) {
  //cek apakah data berhasil di tambahkan atau tidak
  if (ubah_kelas($_POST) >= 0 ) {
      echo "
          <script>
              alert('Data Berhasil Diubah!');
              window.history.back();
          </script>
      ";
    }
  else {
    echo "
        <script>
            alert('Data Gagal Diubah');
            window.history.back();
        </script>
    ";
  }
}


?>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">

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
              <h1 class="m-0">Ubah Data Kelas SKPB</h1>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->

      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-body">

                  <form action="" method="post">
                    <input type="hidden" name="id" value="<?= $ajuan_peminjaman["id"]; ?>">

                    <div class="row">
                      <div class="col-md-6">

                        <div class="form-group">
                          <label for="nama_acara">Nama Mata Kuliah</label> 
                          <input name="nama_acara" type="text" value="<?= $ajuan_peminjaman["nama_acara"]; ?>" class="form-control" id="nama_acara" placeholder="Masukkan Nama Kegiatan">
                        </div>


                        <div class="form-group">
                          <label for="tanggal">Tanggal</label>
                          <input name="tanggal" type="date" value="<?= $ajuan_peminjaman["tanggal"]; ?>" class="form-control" id="tanggal" placeholder="Pilih Tanggal">
                        </div> 
                  <?php
                    $db = mysqli_connect("localhost", "root", "", "booking_system");
                    if (!$db) {
                        die("Koneksi database gagal: " . mysqli_connect_error());
                    }

                    // Ambil data sesi dari database
                    $query = "SELECT sesi1, sesi2, sesi3, sesi4, sesi5, sesi6 FROM pengajuan2 WHERE id = '$id'";
                    $result = mysqli_query($db, $query);

                    if (!$result) {
                        die("Query database gagal: " . mysqli_error($db));
                    }

                    $sesi_values = mysqli_fetch_assoc($result);

                    // Daftar opsi sesi
                    $opsi_sesi = array(
                        "sesi1" => "Sesi 1 (07.00-08.50)",
                        "sesi2" => "Sesi 2 (09.00-10.50)",
                        "sesi3" => "Sesi 3 (11.00-12.50)",
                        "sesi4" => "Sesi 4 (13.30-15.20)",
                        "sesi5" => "Sesi 5 (15.30-17.20)",
                        "sesi6" => "Sesi 6 (>18.00)"
                    );
                  ?>
                  <div class="form-group">
                      <label for="sesi">Sesi</label>
                      <select multiple class="form-control" id="sesi" name="sesi[]">
                          <?php
                          foreach ($opsi_sesi as $key => $value) {
                              $selected = (isset($sesi_values[$key]) && $sesi_values[$key] == 1) ? "selected" : "";
                              echo '<option value="' . $key . '" ' . $selected . '>' . $value . '</option>';
                          }
                          ?>
                      </select>
                  </div>


                      <?php
                          $db = mysqli_connect("localhost", "root", "", "booking_system");
                          if (!$db) {
                            die("Koneksi database gagal: " . mysqli_connect_error());
                          }
                          $query = "SELECT nama_ruangan FROM ruangan";
                          $result = mysqli_query($db, $query);

                          if (!$result) {
                            die("Query database gagal: " . mysqli_error($db));
                          }

                          $ruangan_values = array();

                          while ($row = mysqli_fetch_assoc($result)) {
                            $ruangan_values[] = $row["nama_ruangan"];
                          }

                        ?>

                          <div class="form-group">
                            <label for="ruangan">Ruangan</label>
                            <select name="ruangan" class="custom-select form-control rounded">
                              <option value="" disabled selected hidden>Pilih Ruangan</option>

                              <?php
                              foreach ($ruangan_values as $value) {
                                $selected = ($value == $ajuan_peminjaman["ruangan"]) ? "selected" : "";
                                echo '<option value="' . $value . '" ' . $selected . '>' . $value . '</option>';
                              }
                              ?>
                            </select>
                          </div>
                     
                  

                    <div class="card-body flex flex-row justify-between">
                        <button type="submit" name="submit" class="btn btn-primary">Ubah</button>
                    </div>

                </div>
                    
                    

                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <footer class="main-footer">
      <strong>Copyright &copy; 2024 <a href="#">SKPB</a>.</strong>
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