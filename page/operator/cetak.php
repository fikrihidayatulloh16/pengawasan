<?php

require_once __DIR__ . '../../../vendor/autoload.php';

$mpdf = new \Mpdf\Mpdf();

include '../../koneksi.php';

$id_projek = $_GET['id_projek_op'];
$id_laporan_harian = $_GET['id_laporan_harian'];

$logo = mysqli_query($conn, "SELECT pemilik_pekerjaan, pengawas, kontraktor, logo_pemilik, logo_pengawas , logo_kontraktor
                               FROM m_projek
                               WHERE id_projek = '$id_projek'");
$data_logo = mysqli_fetch_array($logo);

$html = 
'<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <!--  jQuery dan DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <!-- Font From Google -->
    <link href="https://fonts.googleapis.com/css2?family=ABeeZee&family=Inter:wght@400;700&family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <!-- Bootstrap CDN Link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Boxiocns CDN Link -->
    <link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link href="../../css/general.css" rel="stylesheet">
</head>
<body>
    <h1>Hello world!</h1>
</body>
</html>';

$mpdf->WriteHTML($html);
$mpdf->Output();

?>

<?php


include '../../koneksi.php';

$id_projek = $_GET['id_projek_op'];
$id_laporan_harian = $_GET['id_laporan_harian'];
$tanggal_laporan = $_SESSION['tanggal_laporan'];

$projek_query = mysqli_query($conn, "SELECT *
                               FROM m_projek
                               WHERE id_projek = '$id_projek'");
$projek = mysqli_fetch_array($projek_query);

$laporan_query = mysqli_query($conn, "SELECT *
                               FROM m_projek
                               WHERE id_projek = '$id_projek'");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <!--  jQuery dan DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <!-- Font From Google -->
    <link href="https://fonts.googleapis.com/css2?family=ABeeZee&family=Inter:wght@400;700&family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <!-- Bootstrap CDN Link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Boxiocns CDN Link -->
    <link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link href="../../css/general.css" rel="stylesheet">
</head>

<style>
    .custom-img {
        width: 150px; /* Sesuaikan dengan ukuran yang diinginkan */
        height: 150px;
    }
</style>
<body>
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-4 text-center">
            <h4>Pemilik Pekerjaan</h4>
            <img src="http://localhost/pengawasan_me/public/asset/img/uploads/logo/<?= $projek['logo_pemilik'] ?>" alt="logo_pemilik" class="img-fluid custom-img mt-3">
            <br>
            <?= $projek['pemilik_pekerjaan'] ?>
        </div>
        <div class="col-md-4 text-center">
            <h4>Konsultan Pengawas</h4>
            <img src="http://localhost/pengawasan_me/public/asset/img/uploads/logo/<?= $projek['logo_pengawas'] ?>" alt="logo_pengawas" class="img-fluid custom-img mt-3">
            <br>
            <?= $projek['pengawas'] ?>
        </div>
        <div class="col-md-4 text-center">
            <h4>Kontraktor Pelaksana</h4>
            <img src="http://localhost/pengawasan_me/public/asset/img/uploads/logo/<?= $projek['logo_kontraktor'] ?>" alt="logo_kontrakor" class="img-fluid custom-img mt-3">
            <br>
            <?= $projek['kontraktor'] ?>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-6 text-center">
        <h3><?= $projek['nama_projek'] ?></h3>
        </div>

        <div class="col-3 ">
            <div class="row">
                Tanggal :
            </div>
                
            <div class="row">
                Lampiran
            </div>
        </div>

        <div class="col-3">

        </div>
    </div>
</div>
</body>
</html>
