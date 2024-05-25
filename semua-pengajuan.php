<?php
session_start();
require 'function.php';
if ($_SESSION['status'] != "login") {
  header("location:authentication/login.php");
}

$login = $_SESSION['id'];
$result = mysqli_query($db, "SELECT * FROM `admin` WHERE id ='$login'");
$admin = mysqli_fetch_array($result);

$pengajuan_semua = query("SELECT * FROM pengajuan2 WHERE status !='Kelas SKPB'");

// if (isset($_POST["cari"])) {
//   $pengajuan_semua = cari_semua_pengajuan($_POST["keyword"]);

//   if(empty($pengajuan_semua)){
//     $error = true;
// }
// }

if(isset($_POST["submit"]) ){
    
  // cek apakah data berhasil ditambahkan atau tidak
  if(tambah_peminjaman($_POST) > 0){
      echo "
          <script>
              alert('Data Peminjaman Berhasil Ditambahkan!');
              window.location.href = 'semua-pengajuan.php';
          </script>
      ";
  } else{
      echo "
          <script>
              alert('Data Peminjaman Gagal Ditambahkan!');
              window.history.back();
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
                <h3 class="card-title" colspan="14">Tabel Peminjaman Ruangan <span class="text-primary font-weight-bold">(All)</span></h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
              <button type="button" class="btn btn-primary mb-5" data-toggle="modal" data-target="#modal-lg">
                  Tambah Data
                </button>
                <br>
                <br>


                <!-- <?php if(isset($error)) : ?>
                <?php $key = $_POST["keyword"]; ?>
                echo "
                    <script>
                        alert('Pencarian dengan keyword <?=$key?> tidak ditemukan');
                        document.location.href = 'semua-pengajuan.php';
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
                    <th>Kode Peminjaman</th>
                    <th>Jenis Peminjaman</th>
                    <th>Nama Lengkap</th>
                    <th>Nama Kegiatan/Mata Kuliah</th>
                    <th>NIP/NPP/NRP</th>
                    <th>Nomor HP/WA</th>
                    <th>Unit/Departemen</th>
                    <th>Tanggal</th>
                    <th>Sesi</th>
                    <th>Ruangan</th>
                    <th>KTP/KTM</th>
                    <th>Surat SKPB</th>
                    <th>Surat Sarpras</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                  </thead>

                  <tbody>
                  <?php
                        
                        $i = 1;
                        foreach ($pengajuan_semua as $row) :
                  ?>

                    <tr>
                      <td><?= $i ?></td>
                      <td><?= $row["kode_peminjaman"]; ?></td>
                      <td class="text-center">
                        <span class="badge badge-<?php 
                          if ($row['jenis'] == 'insidentil') {
                            echo 'warning';
                          } else{
                            echo 'secondary';
                          }
                          ?>">
                          <?php echo $row['jenis'] ?>
                        </span>
                      </td>
                      <td><?= $row["nama"]; ?></td>
                      <td><?= $row["nama_acara"]; ?></td>
                      <td><?= $row["nrp"]; ?></td>
                      <td><?= $row["whatsapp"]; ?></td>
                      <td><?= $row["unit_departemen"]; ?></td>
                      <td><?= $row["tanggal"]; ?></td>
                      <td>
                          <?php
                          // Tampilkan sesi/jam yang memiliki nilai 1
                          for ($j = 1; $j <= 6; $j++) {
                              $sesi = 'sesi' . $j;
                              if ($row[$sesi] == 1) {
                                  echo '- Sesi ' . $j . '<br>';
                              }
                          }
                          ?>
                      </td>

                      <td><?= $row["ruangan"]; ?></td>

                      <td class="text-nowrap text-bold text-warning">
                          <?php if (isset($row['foto_ktp']) && trim($row['foto_ktp']) !== '') { ?>
                              <a href="dist/img/ktm/<?php echo $row['foto_ktp'] ?>" class="btn-sm btn-primary" target="_blank">
                                  <i class="fas fa-external-link-alt"></i> KTP/KTM
                              </a>
                          <?php } ?>
                      </td>
                      
                      <td class="text-nowrap text-bold text-warning">
                          <?php if (isset($row['surat_skpb']) && trim($row['surat_skpb']) !== '') { ?>
                              <a href="dist/img/surat_skpb/<?php echo $row['surat_skpb'] ?>" class="btn-sm btn-primary" target="_blank">
                                  <i class="fas fa-external-link-alt"></i> Surat SKPB
                              </a>
                          <?php } ?>
                      </td>


                      <td class="text-nowrap text-bold text-warning">
                          <?php if (isset($row['surat_sarpras']) && trim($row['surat_sarpras']) !== '') { ?>
                              <a href="dist/img/surat_sarpras/<?php echo $row['surat_sarpras'] ?>" class="btn-sm btn-primary" target="_blank">
                                  <i class="fas fa-external-link-alt"></i> Surat Sarpras
                              </a>
                          <?php } ?>
                      </td>


                      
                      <td class="text-center">
                        <span class="badge badge-<?php 
                          if ($row['status'] == 'Terverifikasi') {
                            echo 'success';
                          } elseif ($row['status'] == 'Disetujui') {
                            echo 'warning';
                          } elseif ($row['status'] == 'Menunggu Persetujuan'){
                            echo 'danger';
                          } else{
                            echo 'dark';
                          }
                          ?>">
                          <?php echo $row['status'] ?>
                        </span>
                      </td>
                      <td>
                        <a href="ubah-peminjaman.php?id=<?= $row["id"]; ?>&kode_peminjaman=<?= $row["kode_peminjaman"]; ?>" class="btn btn-sm btn-success">
                          <i class="fas fa-edit"></i> Edit
                        </a>

                        <a href="#" id="btn-hapus-<?= $row["id"]; ?>" onclick="confirmHapus(<?= $row['id']; ?>,'<?= $row['kode_peminjaman'];?>');" class="btn btn-sm btn-danger">
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
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Tambah Pengajuan</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form method="post" action="" enctype="multipart/form-data" onsubmit="return validateForm()">
              <div class="modal-body row g-3">
                <div class="col-md-6">

                    <div class="form-group">
                      <label for="nama">Nama Lengkap<span class="required-sign">*</span></label>
                      <input name="nama" type="text" class="form-control" id="nama" placeholder="Masukkan Nama Lengkap" required>
                    </div>

                    <div class="form-group">
                      <label for="nama_acara">Nama Kegiatan/Mata Kuliah<span class="required-sign">*</span></label>
                      <input name="nama_acara" type="text" class="form-control" id="nama_acara" placeholder="Masukkan Nama Kegiatan/Mata Kuliah" required>
                    </div>

                    <div class="form-group">
                      <label for="nrp">NIP/NPP/NRP<span class="required-sign">*</span></label>
                      <input name="nrp" type="text" class="form-control" id="nrp" placeholder="Masukkan NIP/NPP/NRP" required>
                    </div>

                    <div class="form-group">
                      <label for="whatsapp">Nomor Whatsapp<span class="required-sign">*</span></label>
                      <input name="whatsapp" type="text" class="form-control" id="whatsapp" placeholder="Masukkan Nomor Whatsapp" required>
                    </div>

                    <div class="form-group">
                        <label for="departemen">Unit/Departemen<span class="required-sign">*</span>
                              <select id="departemen" name="unit_departemen" class="form-control bg-slate-200 text-dark p-2 rounded-md focus:outline-none focus:ring-primary focus:ring-1 focus:border-primary" required>
                                <option value="" disabled selected hidden>Pilih Unit/Departemen</option>
                                <?php
                                  $db = mysqli_connect("localhost", "root", "", "booking_system");
                                  $result = mysqli_query($db, "SELECT * FROM unit_departemen");
                                    while ($row = mysqli_fetch_assoc($result)) {
                                      echo "<option value='" .  $row['nama_unit'] . "'>" . $row['nama_unit'] . "</option>";
                                    }
                                  ?>
                              </select>
                          </label>

                    </div>

                    <div class="form-group">
                      <label for="tanggal">Tanggal<span class="required-sign">*</span></label>
                      <input name="tanggal" type="date" class="form-control" id="tanggal" placeholder="Pilih Tanggal" required>
                    </div> 

                </div>

                <div class="col-md-6">
                  <div class="form-group">
                      <label for="sesi">Sesi<span class="required-sign">*</label>
                      <select multiple class="form-control" id="sesi" name="sesi[]" required>
                          <option value="sesi1">Sesi 1 (07.00-08.50)</option>
                          <option value="sesi2">Sesi 2 (09.00-10.50)</option>
                          <option value="sesi3">Sesi 3 (11.00-12.50)</option>
                          <option value="sesi4">Sesi 4 (13.30-15.20)</option>
                          <option value="sesi5">Sesi 5 (15.30-17.20)</option>
                          <option value="sesi6">Sesi 6 (>18.00)</option>
                      </select>
                  </div>

                    <div class="form-group">
                      
                        <label for="ruangan">Ruangan<span class="required-sign">*</span>
                              <select id="ruangan" name="ruangan" class="form-control bg-slate-200 text-dark p-1 rounded-md focus:outline-none focus:ring-primary focus:ring-1 focus:border-primary" required>
                                <option value="" disabled selected hidden>Pilih Ruangan</option>
                                <?php
                                  $db = mysqli_connect("localhost", "root", "", "booking_system");
                                  $result = mysqli_query($db, "SELECT * FROM ruangan");
                                    while ($row = mysqli_fetch_assoc($result)) {
                                      echo "<option value='" .  $row['nama_ruangan'] . "'>" . $row['nama_ruangan'] . "</option>";
                                    }
                                  ?>
                              </select>
                          </label>

                    </div>

                    <div class="form-group">
                      <label for="foto_ktp">KTP/KTM</label>
                      <input name="foto_ktp" type="file" class="form-control" id="foto_ktp" placeholder="Upload KTP/KTM">
                    </div>

                    <div class="form-group">
                      <label for="surat_skpb">Surat SKPB</label>
                      <input name="surat_skpb" type="file" class="form-control" id="surat_skpb" placeholder="Upload Surat SKPB">
                    </div>

                    <div class="form-group">
                      <label for="surat_sarpras">Surat Sarpras</label>
                      <input name="surat_sarpras" type="file" class="form-control" id="surat_sarpras" placeholder="Upload Surat Sarpras">
                    </div>

              </div>
                
              </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
              <button type="submit" name="submit" id="submit" class="btn btn-primary">Simpan</button>
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
        function confirmHapus(id,kode_peminjaman) {
      const modal = `
        <div class="modal fade" id="modal-hapus-${id}" tabindex="-1" aria-labelledby="modal-hapus-label-${id}" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="modal-hapus-label-${id}">Konfirmasi Persetujuan</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                
              </div>
              <div class="modal-body">
                Apakah anda yakin ingin mennghapus semua pengajuan dengan kode peminjaman ${kode_peminjaman}?
              </div>
              <div class="modal-footer">
                <a href="hapus-peminjaman.php?kode_peminjaman=${kode_peminjaman}" class="btn btn-primary">Ya, semua</a>
                <a href="hapus-peminjaman.php?id=${id}" class="btn btn-secondary">Tidak, hanya yang dipilih</a>
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
     <script>
    function validateForm() {
        let nrpValue = document.getElementById('nrp').value.trim();
        if (nrpValue !== '' && (!/^\d+$/.test(nrpValue) && parseInt(nrpValue) <= 0)) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'NRP/NIP/NPP tidak valid!',
            });
            document.getElementById('nrp').value = '';
            return false;
        }

        let whatsappValue = document.getElementById('whatsapp').value.trim();
        if (whatsappValue !== '' && (!/^\d+$/.test(whatsappValue) && parseInt(whatsappValue) <= 0)) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Nomor Whatsapp tidak valid!',
            });
            document.getElementById('whatsapp').value = '';
            return false;
        }

        return true;
    }
</script>


</body>

</html>