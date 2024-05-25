<?php

$db = mysqli_connect("localhost", "root", "", "booking_system");

function query($query){
    global $db;
    $result = mysqli_query($db, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }

    return $rows;
}
function tambah_ruangan($data){
    global $db;


    $nama_ruangan = htmlspecialchars($data["nama_ruangan"]);
    $kapasitas= htmlspecialchars($data["kapasitas"]);
    $lantai = htmlspecialchars($data["lantai"]);
    $gedung = htmlspecialchars($data["gedung"]);
    // $gambar1 = htmlspecialchars($data["gambar1"]);
    // $gambar2 = htmlspecialchars($data["gambar2"]);
    // $gambar3 = htmlspecialchars($data["gambar3"]);
    // $deskripsi = htmlspecialchars($data["deskripsi"]);
    $status_ruangan = htmlspecialchars($data["status_ruangan"]);

    $query = "INSERT INTO ruangan VALUES (
                 '','$nama_ruangan','$kapasitas','$lantai','$gedung','$status_ruangan'
                    )
                    ";

    mysqli_query($db, $query);
    return mysqli_affected_rows($db);
}

function tambah_unit($data){
    global $db;

    $nama_unit = htmlspecialchars($data["nama_unit"]);

    $query = "INSERT INTO unit_departemen VALUES (
                 '','$nama_unit'
                    )
                    ";

    mysqli_query($db, $query);
    return mysqli_affected_rows($db);
}

function tambah_peminjaman($data){
    global $db;

    $kode_peminjaman = uniqid();
    $nama = htmlspecialchars($data["nama"]);
    $nama_acara= htmlspecialchars($data["nama_acara"]);
    $nrp = htmlspecialchars($data["nrp"]);
    $whatsapp = htmlspecialchars($data["whatsapp"]);
    $unit_departemen = htmlspecialchars($data["unit_departemen"]);
    $tanggal = htmlspecialchars($data["tanggal"]);
    $ruangan = htmlspecialchars($data["ruangan"]);


    // Tangani nilai yang dikirimkan dari form untuk sesi
    $sesi_values = array_fill_keys(array('sesi1', 'sesi2', 'sesi3', 'sesi4', 'sesi5', 'sesi6'), 0);
    if(isset($_POST['sesi'])) {
        foreach($_POST['sesi'] as $selected) {
            $sesi_values[$selected] = 1;
        }
    }

    $foto_ktp = upload_ktp();
    $surat_skpb = upload_surat_skpb();
    $surat_sarpras = upload_surat_sarpras();
    if($foto_ktp===false|| $surat_skpb===false || $surat_sarpras===false){
        return false;
    }

    $query = "INSERT INTO pengajuan2 VALUES (
                 '','$kode_peminjaman','insidentil','$nama','$nama_acara','$nrp','$whatsapp','$foto_ktp','$unit_departemen','$tanggal',
                    '{$sesi_values['sesi1']}','{$sesi_values['sesi2']}','{$sesi_values['sesi3']}','{$sesi_values['sesi4']}',
                    '{$sesi_values['sesi5']}','{$sesi_values['sesi6']}','$ruangan','$surat_skpb','$surat_sarpras','Menunggu Persetujuan'
                    )
                    ";

    mysqli_query($db, $query);
    return mysqli_affected_rows($db);
}

function tambah_kelas($data){
    global $db;

    $nama_acara= htmlspecialchars($data["nama_acara"]);
    $tanggal = htmlspecialchars($data["tanggal"]);
    $ruangan = htmlspecialchars($data["ruangan"]);


    // Tangani nilai yang dikirimkan dari form untuk sesi
    $sesi_values = array_fill_keys(array('sesi1', 'sesi2', 'sesi3', 'sesi4', 'sesi5', 'sesi6'), 0);
    if(isset($_POST['sesi'])) {
        foreach($_POST['sesi'] as $selected) {
            $sesi_values[$selected] = 1;
        }
    }

    $query = "INSERT INTO pengajuan2 VALUES (
                 '','','semester','','$nama_acara','','','','','$tanggal',
                    '{$sesi_values['sesi1']}','{$sesi_values['sesi2']}','{$sesi_values['sesi3']}','{$sesi_values['sesi4']}',
                    '{$sesi_values['sesi5']}','{$sesi_values['sesi6']}','$ruangan','','','Kelas SKPB'
                    )
                    ";

    mysqli_query($db, $query);
    return mysqli_affected_rows($db);
}
function upload_ktp()
{
    $namaFile = $_FILES['foto_ktp']['name'];
    $ukuranFile = $_FILES['foto_ktp']['size'];
    $error = $_FILES['foto_ktp']['error'];
    $tmpName = $_FILES['foto_ktp']['tmp_name'];

    if($error===4){
        return "";
    }
        $ekstensiGambarValid = ['jpg', 'jpeg', 'png', 'JPG', 'JPEG', 'PNG', 'pdf'];
        $ekstensiGambar = explode('.', $namaFile);
        $ekstensiGambar = strtolower(end($ekstensiGambar));

        if (!in_array($ekstensiGambar, $ekstensiGambarValid)) {
            echo "<script>
                    alert('Format file KTP/KTM tidak valid!');
                </script>";
            return false;
        }

        // cek jika ukurannya terlalu besar
        if ($ukuranFile > 2000000) {
            echo "<script>
                    alert('Ukuran file KTM/KTP lebih dari 2 MB!');
                </script>";
            return false;
        }

        // lolos pengecekan, gambar siap diupload
        // generate nama gambar baru
        $namaFileBaru = uniqid();
        $namaFileBaru .= '.';
        $namaFileBaru .= $ekstensiGambar;

        move_uploaded_file($tmpName, 'dist/img/ktm/' . $namaFileBaru);

        return $namaFileBaru;
    
}

function upload_surat_skpb()
{
    $namaFile = $_FILES['surat_skpb']['name'];
    $ukuranFile = $_FILES['surat_skpb']['size'];
    $error = $_FILES['surat_skpb']['error'];
    $tmpName = $_FILES['surat_skpb']['tmp_name'];

    if($error===4){
        return "";
    }
        $ekstensiGambarValid = ['jpg', 'jpeg', 'png', 'JPG', 'JPEG', 'PNG', 'pdf'];
        $ekstensiGambar = explode('.', $namaFile);
        $ekstensiGambar = strtolower(end($ekstensiGambar));

        if (!in_array($ekstensiGambar, $ekstensiGambarValid)) {
            echo "<script>
                    alert('Format file surat SKPB tidak valid!');
                </script>";
            return false;
        }

        // cek jika ukurannya terlalu besar
        if ($ukuranFile > 2000000) {
            echo "<script>
                    alert('Ukuran file surat skpb lebih dari 2 MB!');
                </script>";
            return false;
        }

        // lolos pengecekan, gambar siap diupload
        // generate nama gambar baru
        $namaFileBaru = uniqid();
        $namaFileBaru .= '.';
        $namaFileBaru .= $ekstensiGambar;

        move_uploaded_file($tmpName, 'dist/img/surat_skpb/' . $namaFileBaru);

        return $namaFileBaru;
    
}

function upload_surat_sarpras(){
    $namaFile = $_FILES['surat_sarpras']['name'];
    $ukuranFile = $_FILES['surat_sarpras']['size'];
    $error = $_FILES['surat_sarpras']['error'];
    $tmpName = $_FILES['surat_sarpras']['tmp_name'];

    if($error===4){
        return "";
    }
        $ekstensiGambarValid = ['jpg', 'jpeg', 'png', 'JPG', 'JPEG', 'PNG', 'pdf'];
        $ekstensiGambar = explode('.', $namaFile);
        $ekstensiGambar = strtolower(end($ekstensiGambar));

        if (!in_array($ekstensiGambar, $ekstensiGambarValid)) {
            echo "<script>
                    alert('Format file surat sarpras tidak valid!');
                </script>";
            return false;
        }

        // cek jika ukurannya terlalu besar
        if ($ukuranFile > 2000000) {
            echo "<script>
                    alert('Ukuran file surat sarpras lebih dari 2 MB!');
                </script>";
            return false;
        }

        // lolos pengecekan, gambar siap diupload
        // generate nama gambar baru
        $namaFileBaru = uniqid();
        $namaFileBaru .= '.';
        $namaFileBaru .= $ekstensiGambar;

        move_uploaded_file($tmpName, 'dist/img/surat_sarpras/' . $namaFileBaru);

        return $namaFileBaru;
    
}


function hapus_peminjaman($id)
{
    global $db;
    mysqli_query($db, "DELETE FROM pengajuan2 WHERE id = $id");
    return mysqli_affected_rows($db);
}
function hapus_peminjaman_semua($kode_peminjaman)
{
    global $db;
    mysqli_query($db, "DELETE FROM pengajuan2 WHERE kode_peminjaman = '$kode_peminjaman'");
    return mysqli_affected_rows($db);
}
function hapus_ruangan($id)
{
    global $db;
    mysqli_query($db, "DELETE FROM ruangan WHERE id = $id");
    return mysqli_affected_rows($db);
}
function hapus_unit($id)
{
    global $db;
    mysqli_query($db, "DELETE FROM unit_departemen WHERE id = $id");
    return mysqli_affected_rows($db);
}
function ubah_peminjaman($data)
{
    global $db;
    global $id;

    $nama = htmlspecialchars($data["nama"]);
    $nama_acara= htmlspecialchars($data["nama_acara"]);
    $nrp = htmlspecialchars($data["nrp"]);
    $whatsapp = htmlspecialchars($data["whatsapp"]);
    $unit_departemen = htmlspecialchars($data["unit_departemen"]);
    $tanggal = htmlspecialchars($data["tanggal"]);
    $ruangan = htmlspecialchars($data["ruangan"]);

    // Tangani nilai yang dikirimkan dari form untuk sesi
    $sesi_values = array_fill_keys(array('sesi1', 'sesi2', 'sesi3', 'sesi4', 'sesi5', 'sesi6'), 0);
    if(isset($_POST['sesi'])) {
        foreach($_POST['sesi'] as $selected) {
            $sesi_values[$selected] = 1;
        }
    }

    $foto_ktp = htmlspecialchars($data["foto_ktp"]);
    $surat_skpb = htmlspecialchars($data["surat_skpb"]);
    $surat_sarpras = htmlspecialchars($data["surat_sarpras"]);

    // cek apakah user pilih ktp/ktm baru atau tidak
    if($_FILES["foto_ktp"]["error"] === 4){
        $foto_ktp_baru = $foto_ktp;
    } else{
        $foto_ktp_baru = upload_ktp();
        if(!$foto_ktp_baru){
            return false;
        }
    }

    // cek apakah user pilih surat skpb baru atau tidak
    if($_FILES["surat_skpb"]["error"] === 4){
        $surat_skpb_baru = $surat_skpb;
    } else{
        $surat_skpb_baru = upload_surat_skpb();
        if(!$surat_skpb_baru){
            return false;
        }
    }

    // cek apakah user pilih surat sarpras baru atau tidak
    if($_FILES["surat_sarpras"]["error"] === 4){
        $surat_sarpras_baru = $surat_sarpras;
    } else{
        $surat_sarpras_baru = upload_surat_sarpras();
        if(!$surat_sarpras_baru){
            return false;
        }
    }


    $query = "UPDATE pengajuan2 SET  
                    nama = '$nama', 
                    nama_acara = '$nama_acara',
                    nrp = '$nrp',
                    whatsapp = '$whatsapp',
                    foto_ktp = '$foto_ktp_baru',
                    unit_departemen = '$unit_departemen',
                    tanggal = '$tanggal',
                    ruangan = '$ruangan',
                    surat_skpb ='$surat_skpb_baru',
                    surat_sarpras ='$surat_sarpras_baru',
                    sesi1 = {$sesi_values['sesi1']},
                    sesi2 = {$sesi_values['sesi2']},
                    sesi3 = {$sesi_values['sesi3']},
                    sesi4 = {$sesi_values['sesi4']},
                    sesi5 = {$sesi_values['sesi5']},
                    sesi6 = {$sesi_values['sesi6']}

                    WHERE id = $id
    ";

    mysqli_query($db, $query);
    return mysqli_affected_rows($db);
}
function ubah_kelas($data)
{
    global $db;
    global $id;

    $nama_acara= htmlspecialchars($data["nama_acara"]);
    $tanggal = htmlspecialchars($data["tanggal"]);
    $ruangan = htmlspecialchars($data["ruangan"]);

    // Tangani nilai yang dikirimkan dari form untuk sesi
    $sesi_values = array_fill_keys(array('sesi1', 'sesi2', 'sesi3', 'sesi4', 'sesi5', 'sesi6'), 0);
    if(isset($_POST['sesi'])) {
        foreach($_POST['sesi'] as $selected) {
            $sesi_values[$selected] = 1;
        }
    }


    $query = "UPDATE pengajuan2 SET  
                    nama_acara = '$nama_acara',
                    tanggal = '$tanggal',
                    ruangan = '$ruangan',
                    sesi1 = {$sesi_values['sesi1']},
                    sesi2 = {$sesi_values['sesi2']},
                    sesi3 = {$sesi_values['sesi3']},
                    sesi4 = {$sesi_values['sesi4']},
                    sesi5 = {$sesi_values['sesi5']},
                    sesi6 = {$sesi_values['sesi6']}

                    WHERE id = $id
    ";

    mysqli_query($db, $query);
    return mysqli_affected_rows($db);
}
function ubah_peminjaman_semua($data)
{
    global $db;
    global $kode_peminjaman;

    $nama = htmlspecialchars($data["nama"]);
    $nama_acara= htmlspecialchars($data["nama_acara"]);
    $nrp = htmlspecialchars($data["nrp"]);
    $whatsapp = htmlspecialchars($data["whatsapp"]);
    $unit_departemen = htmlspecialchars($data["unit_departemen"]);
    // $tanggal = htmlspecialchars($data["tanggal"]);
     $ruangan = htmlspecialchars($data["ruangan"]);

    $foto_ktp = htmlspecialchars($data["foto_ktp"]);
    $surat_skpb = htmlspecialchars($data["surat_skpb"]);
    $surat_sarpras = htmlspecialchars($data["surat_sarpras"]);

    // Tangani nilai yang dikirimkan dari form untuk sesi
    $sesi_values = array_fill_keys(array('sesi1', 'sesi2', 'sesi3', 'sesi4', 'sesi5', 'sesi6'), 0);
    if(isset($_POST['sesi'])) {
        foreach($_POST['sesi'] as $selected) {
            $sesi_values[$selected] = 1;
        }
}


    // cek apakah user pilih ktp/ktm baru atau tidak
    if($_FILES["foto_ktp"]["error"] === 4){
        $foto_ktp_baru = $foto_ktp;
    } else{
        $foto_ktp_baru = upload_ktp();
        if(!$foto_ktp_baru){
            return false;
        }
    }

    // cek apakah user pilih surat skpb baru atau tidak
    if($_FILES["surat_skpb"]["error"] === 4){
        $surat_skpb_baru = $surat_skpb;
    } else{
        $surat_skpb_baru = upload_surat_skpb();
        if(!$surat_skpb_baru){
            return false;
        }
    }

    // cek apakah user pilih surat sarpras baru atau tidak
    if($_FILES["surat_sarpras"]["error"] === 4){
        $surat_sarpras_baru = $surat_sarpras;
    } else{
        $surat_sarpras_baru = upload_surat_sarpras();
        if(!$surat_sarpras_baru){
            return false;
        }
    }


    $query = "UPDATE pengajuan2 SET  
                    nama = '$nama', 
                    nama_acara = '$nama_acara',
                    nrp = '$nrp',
                    whatsapp = '$whatsapp',
                    foto_ktp = '$foto_ktp_baru',
                    unit_departemen = '$unit_departemen',
                    ruangan = '$ruangan',
                    surat_skpb ='$surat_skpb_baru',
                    surat_sarpras ='$surat_sarpras_baru',
                    sesi1 = {$sesi_values['sesi1']},
                    sesi2 = {$sesi_values['sesi2']},
                    sesi3 = {$sesi_values['sesi3']},
                    sesi4 = {$sesi_values['sesi4']},
                    sesi5 = {$sesi_values['sesi5']},
                    sesi6 = {$sesi_values['sesi6']}

                    WHERE kode_peminjaman = '$kode_peminjaman'
    ";

    mysqli_query($db, $query);
    return mysqli_affected_rows($db);
}

function ubah_ruangan($data)
{
    global $db;

    $id = $data["id"];
    $nama_ruangan = htmlspecialchars($data["nama_ruangan"]);
    $kapasitas= intval($data["kapasitas"]);
    $lantai = intval($data["lantai"]);
    $gedung = htmlspecialchars($data["gedung"]);
    // $gambar1 = htmlspecialchars($data["gambar1"]);
    // $gambar2 = htmlspecialchars($data["gambar2"]);
    // $gambar3 = htmlspecialchars($data["gambar3"]);
    // $deskripsi = htmlspecialchars($data["deskripsi"]);
    $status_ruangan = htmlspecialchars($data["status_ruangan"]);

    $query = "UPDATE ruangan SET  
                    nama_ruangan = '$nama_ruangan', 
                    kapasitas = '$kapasitas',
                    lantai = '$lantai',
                    gedung = '$gedung',
                    status_ruangan = '$status_ruangan'


                    WHERE id = $id
    ";

    mysqli_query($db, $query);
    return mysqli_affected_rows($db);
}

function ubah_unit($data)
{
    global $db;

    $id = $data["id"];
    $nama_unit = htmlspecialchars($data["nama_unit"]);

    $query = "UPDATE unit_departemen SET  
                    nama_unit = '$nama_unit'
                    WHERE id = $id
    ";
    mysqli_query($db, $query);
    return mysqli_affected_rows($db);
}


function setujui($data)
{
    global $db;
    global $id;


    $query = "UPDATE pengajuan2 SET  
                    status = 'Disetujui'
                    WHERE id = $id
    ";

    mysqli_query($db, $query);
    return mysqli_affected_rows($db);
}
function setujui_semua($data)
{
    global $db;
    global $kode_peminjaman;


    $query = "UPDATE pengajuan2 SET  
                    status = 'Disetujui'
                    WHERE kode_peminjaman = '$kode_peminjaman'
    ";

    mysqli_query($db, $query);
    return mysqli_affected_rows($db);
}
function tolak($data)
{
    global $db;
    global $id;

    $query = "UPDATE pengajuan2 SET  
                    status = 'Ditolak'
                    WHERE id = $id
    ";

    mysqli_query($db, $query);
    return mysqli_affected_rows($db);
}

function tolak_semua($data)
{
    global $db;
    global $kode_peminjaman;


    $query = "UPDATE pengajuan2 SET  
                    status = 'Ditolak'
                    WHERE kode_peminjaman = '$kode_peminjaman'
    ";

    mysqli_query($db, $query);
    return mysqli_affected_rows($db);
}

function verifikasi($data)
{
    global $db;
    global $id;


    $query = "UPDATE pengajuan2 SET  
                    status = 'Terverifikasi'
                    WHERE id = $id
    ";

    mysqli_query($db, $query);
    return mysqli_affected_rows($db);
}

function verifikasi_semua($data)
{
    global $db;
    global $kode_peminjaman;


    $query = "UPDATE pengajuan2 SET  
                    status = 'Terverifikasi'
                    WHERE kode_peminjaman = '$kode_peminjaman'
    ";

    mysqli_query($db, $query);
    return mysqli_affected_rows($db);
}

function tolak_verifikasi($data)
{
    global $db;
    global $id;


    $query = "UPDATE pengajuan2 SET  
                    status = 'Menunggu Persetujuan'
                    WHERE id = $id
    ";

    mysqli_query($db, $query);
    return mysqli_affected_rows($db);
}
function tolak_verifikasi_semua($data)
{
    global $db;
    global $kode_peminjaman;


    $query = "UPDATE pengajuan2 SET  
                    status = 'Menunggu Persetujuan'
                    WHERE kode_peminjaman = '$kode_peminjaman'
    ";

    mysqli_query($db, $query);
    return mysqli_affected_rows($db);
}

function unverify($data)
{
    global $db;
    global $id;


    $query = "UPDATE pengajuan2 SET  
                    status = 'Disetujui'
                    WHERE id = $id
    ";

    mysqli_query($db, $query);
    return mysqli_affected_rows($db);
}
function unverify_semua($data)
{
    global $db;
    global $kode_peminjaman;


    $query = "UPDATE pengajuan2 SET  
                    status = 'Disetujui'
                    WHERE kode_peminjaman = '$kode_peminjaman'
    ";

    mysqli_query($db, $query);
    return mysqli_affected_rows($db);
}


function cari_semua_pengajuan($keyword)
{
    $query = "SELECT * FROM pengajuan2 WHERE 
        nama LIKE '%$keyword%' OR 
        kode_peminjaman LIKE '%$keyword%' OR 
        nrp LIKE '%$keyword%' OR 
        whatsapp LIKE '%$keyword%' OR 
        nama_acara LIKE '%$keyword%' OR 
        unit_departemen LIKE '%$keyword%' OR 
        tanggal LIKE '%$keyword%' ";
    return query($query);
}

function cari_ruangan($keyword)
{
    $query = "SELECT * FROM ruangan WHERE 
     nama_ruangan LIKE '%$keyword%' OR 
     kapasitas LIKE '%$keyword%' OR 
     gedung LIKE '%$keyword%' OR  
     lantai LIKE '%$keyword%' OR 
     status_ruangan LIKE '%$keyword%'  
     
     ";
    return query($query);
}

function cari_unit($keyword)
{
    $query = "SELECT * FROM unit_departemen WHERE 
     nama_unit LIKE '%$keyword%' 
     ";
    return query($query);
}

function cari_menunggu_persetujuan($keyword)
{
    $query = "SELECT * FROM pengajuan2 WHERE status='Menunggu Persetujuan' 
    AND (
     nama LIKE '%$keyword%' OR 
     kode_peminjaman LIKE '%$keyword%' OR 
     nrp LIKE '%$keyword%' OR whatsapp LIKE '%$keyword%' OR 
     nama_acara LIKE '%$keyword%' OR 
     unit_departemen LIKE '%$keyword%' 
     OR tanggal LIKE '%$keyword%' 
     
     )";
    return query($query);
}

function cari_menunggu_verifikasi($keyword)
{
    $query = "SELECT * FROM pengajuan2 WHERE status='Disetujui' 
    AND (
     nama LIKE '%$keyword%' OR 
     kode_peminjaman LIKE '%$keyword%' OR 
     nrp LIKE '%$keyword%' OR whatsapp LIKE '%$keyword%' OR 
     nama_acara LIKE '%$keyword%' OR 
     unit_departemen LIKE '%$keyword%' 
     OR tanggal LIKE '%$keyword%' 
     
     )";
    return query($query);
}

function cari_terverifikasi($keyword)
{
    $query = "SELECT * FROM pengajuan2 WHERE status='Terverifikasi' 
    AND (
     nama LIKE '%$keyword%' OR 
     kode_peminjaman LIKE '%$keyword%' OR 
     nrp LIKE '%$keyword%' OR whatsapp LIKE '%$keyword%' OR 
     nama_acara LIKE '%$keyword%' OR 
     unit_departemen LIKE '%$keyword%' 
     OR tanggal LIKE '%$keyword%' 
     
     )";
    return query($query);
}


function cari_ditolak($keyword)
{
    $query = "SELECT * FROM pengajuan2 WHERE status='Ditolak' 
    AND (
     nama LIKE '%$keyword%' OR 
     kode_peminjaman LIKE '%$keyword%' OR 
     nrp LIKE '%$keyword%' OR whatsapp LIKE '%$keyword%' OR 
     nama_acara LIKE '%$keyword%' OR 
     unit_departemen LIKE '%$keyword%' 
     OR tanggal LIKE '%$keyword%' 
     
     )";
    return query($query);
}
