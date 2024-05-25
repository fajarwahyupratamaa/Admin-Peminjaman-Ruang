<?php
session_start();
require 'function.php';
if ($_SESSION['status'] != "login") {
  header("location:authentication/login.php");
}

$login = $_SESSION['id'];
$result = mysqli_query($db, "SELECT * FROM `admin` WHERE id ='$login'");
$admin = mysqli_fetch_array($result);

$unit = query("SELECT * FROM unit_departemen");
if (isset($_POST["cari"])) {
  $unit = cari_unit($_POST["keyword"]);

  if(empty($unit)){
    $error = true;
}
}
    // cek apakah tombol submit sudah ditekan atau belum
    if(isset($_POST["submit"]) ){
    
        // cek apakah data berhasil ditambahkan atau tidak
        if(tambah_unit($_POST) > 0){
            echo "
                <script>
                    alert('Data Unit/Departemen Berhasil Ditambahkan!');
                    document.location.href = 'unit-departemen.php';
                </script>
            ";
        } else{
            echo "
                <script>
                    alert('Data Unit/Departemen Gagal Ditambahkan!');
                    document.location.href = 'unit-departemen.php';
                </script>
            ";
        }
    }
          
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin | SKPB-Facility</title>
  <style>
        th {
            white-space: nowrap;
            text-align: center !important;
        }
        td {
            white-space: nowrap;
        }
      .required-sign {
        color: red;
      }
      .dataTables_length {
        position: absolute;
          margin-left: 300px;
          top: -50px;
      }

      .dataTables_filter {
          position: absolute;
          margin-left: 5px;
          top: -50px;
        }
        @media (max-width: 640px) {
          .dataTables_filter {
            top: -60px; /* Ubah nilai sesuai kebutuhan */
          }
          
        }

</style>
    </style>

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
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
</head>

<style>
  body {
    font-family: "Manrope", sans-serif !important;
  }
</style>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">

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
              <h1 class="m-0">Dashboard Pengelola <b>Fasilitas SKPB</b></h1>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->
      <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-14">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Tabel Daftar Unit/Departemen <span class="text-primary font-weight-bold">(All)</span></h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
              <button type="button" class="btn btn-primary mb-5" data-toggle="modal" data-target="#modal-lg">
                  Tambah Data
                </button>
                <br></br>

                <!-- <?php if(isset($error)) : ?>
                <?php $key = $_POST["keyword"]; ?>
                echo "
                    <script>
                        alert('Pencarian dengan keyword <?=$key?> tidak ditemukan');
                        document.location.href = 'unit-departemen.php';
                    </script>
                    ";
                <?php die; ?>
                <?php endif; ?>  

                <label for="keyword mt-2">Pencarian</label>
                  <form class="form-inline" action="" method="post">
                    <div class="form-group">  
                      <input type="text" name="keyword" id="keyword" autofocus autocomplete="off" class="form-control w-full" placeholder="Cari...">
                      <div class="input-group-append">
                        <button type="submit" name="cari" id="cari" class="btn btn-primary"><i class="fas fa-search"></i></button>
                      </div>
                    </div>
                  </form> -->
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>No</th>
                    <th>Nama Unit/Departemen</th>
                    <th>Action</th>
                  </tr>
                  </thead>

                  <tbody>
                  <?php
                        $i = 1;
                        foreach ($unit as $row) :                         
                        ?>

                    <tr>
                      <td><?= $i ?></td>
                      <td><?= $row["nama_unit"]; ?></td>
                      <td>
                      <a href="ubah-unit.php?id=<?= $row["id"]; ?>" class="btn btn-sm btn-success">
                          <i class="fas fa-edit"></i> Edit
                        </a>

                        <a href="#" id="btn-hapus-<?= $row["id"]; ?>" onclick="confirmHapus(<?= $row['id']; ?>);" class="btn btn-sm btn-danger">
                            <i class="fas fa-trash"></i> Hapus
                        </a>
                    </td>

                    </tr>
                    <?php
                      $i++;
                      endforeach;
                      ?>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>

     <!-- /.modal -->
     <div class="modal fade" id="modal-lg">
        <div class="modal-dialog modal-md">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Tambah Unit/Departemen</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
          <form method="post" action="">
            <div class="modal-body row g-3">
            <div class="col-md-12">
              <div class="form-group">
                <label for="nama_unit">Nama Unit/Departemen<span class="required-sign">*</span></label>    
                <input name="nama_unit" type="text" value="" class="form-control" id="nama_unit" placeholder="Masukkan Nama Unit/Departemen" required>
              </div>
              </div>      
            </div>
              <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                <button type="submit" name="submit" class="btn btn-primary">Simpan</button>
              </div>
            </div>
          </form>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <footer class="main-footer">
      <strong>Copyright &copy; <span id="currentYear"></span> <a href="#">SKPB ITS</a>.</strong>
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

  <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>

  <script>
    $(document).ready(function() {
      $('#example1').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "pageLength": 50
      });
    });
  </script>

  <script>
    document.getElementById("currentYear").textContent = new Date().getFullYear();
  </script>
    <script>
        function confirmHapus(id) {
      const modal = `
        <div class="modal fade" id="modal-hapus-${id}" tabindex="-1" aria-labelledby="modal-hapus-label-${id}" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="modal-hapus-label-${id}">Konfirmasi Persetujuan</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                
              </div>
              <div class="modal-body">
                Apakah anda yakin ingin menghapus data unit/departemen??
              </div>
              <div class="modal-footer">
                <a href="hapus-unit.php?id=${id}" class="btn btn-primary">Ya</a>
                <button type="button" class="btn btn-secondary mr-2" data-dismiss="modal">Tidak</button>

              </div>
            </div>
          </div>
        </div>
      `;

      // Tampilkan modal
      $("body").append(modal);
      $("#modal-hapus-" + id).modal("show");

      // Hapus modal setelah ditutup
      $("#modal-hapus-" + id).on("hidden.bs.modal", function () {
        $(this).remove();
      });
    }

  </script>

</body>

</html>