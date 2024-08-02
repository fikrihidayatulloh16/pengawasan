<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Form Laporan Harian - SB Admin</title>
    
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <!-- Bootstrap CDN Link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <!-- Boxiocns CDN Link -->
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link href="../../css/styles.operator.css" rel="stylesheet">
     <script type="text/javascript" src="../../asset/chartjs/canvasjs-chart-3.10.0/canvasjs.min.js"></script>
</head>

<style>
    .header-laporan {
        background: linear-gradient(to right, #007bff, #0056b3);
        color: white;
        padding: 20px;
        margin-top: 10px;
        border-radius: 10px;
        text-align: center;
    }
</style>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <a class="navbar-brand ps-3" href="halamanoperator.php">Start Bootstrap</a>
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle"><i class="fas fa-bars"></i></button>
        <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
            <div class="input-group">
                <input class="form-control" type="text" placeholder="Search for..." aria-label="Search for..." aria-describedby="btnNavbarSearch">
                <button class="btn btn-primary" id="btnNavbarSearch" type="button"><i class="fas fa-search"></i></button>
            </div>
        </form>

        

        <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="#!">Settings</a></li>
                    <li><a class="dropdown-item" href="#!">Activity Log</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="#!">Logout</a></li>
                </ul>
            </li>
        </ul>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <a class="nav-link" href="../../page/operator/pekerjaan.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-file-alt"></i></div><span style="padding-right: 5px;"></span>
                            Pekerjaan
                        </a>
                        <a class="nav-link" href="../../page/operator/cuaca.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-cloud-sun"></i></div>
                            Cuaca
                        </a>
                        <a class="nav-link" href="../../page/operator/operator.permasalahan.php">
                            <div class="sb-nav-link-icon"><i class='bx bx-calendar-exclamation'></i></div>
                            Permasalahan
                        </a>
                        <a class="nav-link" href="../../page/operator/fotokegiatan.php">
                            <div class="sb-nav-link-icon"><i class='bx bx-image' ></i></div>
                            Lampiran Foto
                        </a>
                        <a class="nav-link" href="../../page/operator/operator.timPengawas.php">
                            <div class="sb-nav-link-icon"><i class='bx bx-male'></i></i></div>
                            Tim Pengawas
                        </a>
                    </div>
                </div>
                <div class="sb-sidenav-footer">
                    <div class="small">Logged in as:</div>
                    Start Bootstrap
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <div class="container-fluid" >
                <div class="container header-laporan text-light mt-3">
                    <h3 class="text-center">Laporan Harian ke-<?= $_SESSION['nomor']?></h3>
                    <h4 class="text-center">Projek : <?= $_SESSION['nama_projek_op']?></h4>
                    <h4 class="text-center">Tanggal : <?= $_SESSION['tanggal_laporan']?></h4>
                </div>
            </div>
            <main>