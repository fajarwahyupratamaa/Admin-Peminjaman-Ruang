<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hapus Data Unit/Departemen</title>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
</head>
<style>
    body {
    font-family: 'Maven Pro', sans-serif !important;
  }
</style>
<body>

<?php 
require 'function.php';

$id = $_GET['id'];

if( hapus_unit($id) > 0 ) {
    echo '<script>
    swal("Berhasil!", "Data Berhasil Dihapus", "success")
    .then((value) => {
    window.location.href = "unit-departemen.php";
    });
    </script>';
} else {
    echo '<script>
    swal("Oops!", "Data Gagal Dihapus", "error")
    .then((value) => {
        window.location.href = "unit-departemen.php";
        });
    </script>';
}

?>
    
</body>
</html>


