<?php
require 'function.php';

header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Data Seluruh Peserta.xls");

$peserta = query("SELECT * FROM peserta");

if (isset($_POST["cari"])) {
  $peserta = cari($_POST["keyword"]);
}

?>

      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <div class="d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Semua Peserta Terdaftar OMITS 16th dan MISSION 7.0</h3>
                   <div>
                   <a href="#" class="btn btn-sm btn-success">
                      <i class="fas fa-file-excel"></i> Export Excel
                    </a>
                    <a href="#" class="btn btn-sm btn-danger">
                      <i class="fas fa-file-pdf"></i> Export PDF
                    </a>
                   </div>
                  </div>
                </div>
                <div class="card-body">
                  <label for="statusVerifikasi mt-2">Pencarian</label>
                  <form class="form-inline" action="" method="post">
                    <div class="form-group">
                      <input type="text" name="keyword" class="form-control" placeholder="Cari...">
                      <div class="input-group-append">
                        <button type="submit" name="cari" class="btn btn-primary"><i class="fas fa-search"></i></button>
                      </div>
                    </div>
                  </form>
                  <div class="mt-2 table-responsive">
                    <table id="example2" class="table table-bordered table-hover">
                      <thead>
                        <tr>
                          <th class="text-nowrap">Nama Ketua</th>
                          <th class="text-nowrap">Email Ketua</th>
                          <th class="text-nowrap">Kata Sandi</th>
                          <th class="text-nowrap">NISN/NIM Ketua</th>
                          <th class="text-nowrap">Bukti NISN/NIM</th>
                          <th class="text-nowrap">WhatsApp Ketua</th>
                          <th class="text-nowrap">Nama Anggota</th>
                          <th class="text-nowrap">NISN/NIM Anggota</th>
                          <th class="text-nowrap">Bukti NISN/NIM</th>
                          <th class="text-nowrap">WhatsApp Anggota</th>
                          <th class="text-nowrap">Kompetisi</th>
                          <th class="text-nowrap">Sekolah</th>
                          <th class="text-nowrap">Provinsi</th>
                          <th class="text-nowrap">Kota/Kabupaten</th>
                          <th class="text-nowrap">Region Jawa Timur</th>
                          <th class="text-nowrap">Region</th>
                          <th class="text-nowrap">Bukti Bayar</th>
                          <th class="text-nowrap">Status Verifikasi</th>
                          <th class="text-nowrap">Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        $i = 1;
                        foreach ($peserta as $row) :

                        ?>
                          <tr>
                            <td class="text-nowrap"><?php echo $row['nama1'] ?></td>
                            <td class="text-nowrap"><?php echo $row['email1'] ?></td>
                            <td class="text-nowrap"><?php echo $row['katasandi'] ?></td>
                            <td class="text-nowrap"><?php echo $row['nisn1'] ?>/td>
                            <td class="text-nowrap text-bold text-warning"><a href="C:/xampp/htdocs/omits16_versi2/dashboard/files/nisn/<?php echo $row['bukti_nisn'] ?>" class="btn-sm btn-warning" target="_blank"><i class="fas fa-arrow-right"></i> Bukti NISN/NIM</a></td>
                            <td class="text-nowrap"><?php echo $row['whatsapp'] ?></td>
                            <td class="text-nowrap"><?php echo $row['nama2'] ?></td>
                            <td class="text-nowrap"><?php echo $row['whatsapp2'] ?></td>
                            <td class="text-nowrap text-bold text-warning"><a href="C:/xampp/htdocs/omits16_versi2/dashboard/files/nisn/<?php echo $row['bukti_nisn2'] ?>" class="btn-sm btn-warning" target="_blank"><i class="fas fa-arrow-right"></i> Bukti NISN/NIM</a></td>
                            <td class="text-nowrap"><?php echo $row['whatsapp2'] ?></td>
                            <td class="text-nowrap"><span class="badge badge-primary"><?php echo $row['kompetisi'] ?></span></td>
                            <td class="text-nowrap"><?php echo $row['sekolah'] ?></td>
                            <td class="text-nowrap"><?php echo $row['provinsi'] ?></td>
                            <td class="text-nowrap"><?php echo $row['kota_kabupaten'] ?></td>
                            <td class="text-nowrap"><?php echo $row['region_jawatimur'] ?></td>
                            <td class="text-nowrap"><?php echo $row['region'] ?></td>
                            <td class="text-nowrap">
                              <a href="C:/xampp/htdocs/omits16_versi2/dashboard/files/bayar/<?= $row['bukti_bayar'] ?>" class="btn-sm btn-primary" target="_blank">
                                <i class="fas fa-file-image"></i> Lihat Bukti Bayar
                              </a>
                            </td>
                            <td class="text-nowrap"><span class="badge badge-success"><?php echo $row['verifikasi_pembayaran'] ?></span></td>
                            <td class="text-nowrap">
                              <a href="ubah.php?no_peserta=<?= $row['no_peserta'] ?>" class="btn-sm btn-primary">
                                <i class="fas fa-edit"></i> Edit
                              </a>

                              <a href="hapus.php?no_peserta=<?= $row['no_peserta'] ?>" onclick="return confirm('Yakin Hapus Data Ini?');" class="ml-2 btn-sm btn-danger">
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
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    
    </div>
   
