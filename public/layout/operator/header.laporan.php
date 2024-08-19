<?php
session_start();

$navBrands = '<a class="navbar-brand" href="../../page/operator/laporanharian.php">OPERATOR</a>';

$navItems = '
    <li class="nav-item">
        <a class="nav-link active nav-head" aria-current="page" href="#" style="font-size: 2;">LAPORAN HARIAN</a>
    </li>

    <li class="nav-item">
        <a class="nav-link nav-head ms-lg-5" href="#">LAPORAN BULANAN</a>
    </li>';
    
include '../../public/layout/header.php';
include "../../public/alert/successAlert.php";
?>

<!-- Content of Page -->

<div class="container" >
      <div class="container header-laporan text-center mt-3">
        <h3 style="color : #818181;">Laporan Harian</h3>
        <h4 class="roboto-text">Pengawasan Pembangunan <?= $_SESSION['nama_projek_op']?></h4>
    </div>
    <hr class="container separator-header">
</div>