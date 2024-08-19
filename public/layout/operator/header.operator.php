<?php
session_start();

$navBrands = '<a class="navbar-brand" href="../../page/operator/laporanharian.php">OPERATOR</a>';

$id_projek_op = $_SESSION['id_projek_op'];
$id_laporan_harian = $_SESSION['id_laporan_harian'];
$tanggal_laporan = $_SESSION['tanggal_laporan'];

$navItems = '
    <li class="nav-item">
        <a class="nav-link nav-head" aria-current="page" href="pekerjaan.php";">LAPORAN HARIAN</a>
    </li>
    <li class="nav-item dropdown">
          <a class="nav-link nav-head dropdown-toggle ms-lg-3" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            LAINNYA
            <i class="bx bx-caret-down"></i>
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="../../page/operator/operator.pekerjaan.php">Pekerjaan</a></li>
            <li><a class="dropdown-item" href="../../page/operator/cuaca.php">Cuaca</a></li>
            <li><a class="dropdown-item" href="../../page/operator/operator.permasalahan.php">Permasalahan</a></li>
            <li><a class="dropdown-item" href="../../page/operator/fotokegiatan.php">Lampiran Foto</a></li>
            <li><a class="dropdown-item" href="../../page/operator/operator.timPengawas.php">Tim Pengawas</a></li>
          </ul>
      </li>
      <li class="nav-item">
          <a class="nav-link nav-head ms-lg-3" aria-current="page" href="domPDF.php?id_projek_op=' . $id_projek_op . '&id_laporan_harian=' . $id_laporan_harian . '&tanggal_laporan=' . $tanggal_laporan . '">UNDUH
          <i class="bx bx-download"></i>
          </a>
      </li>';
    
include '../../public/layout/header.php';
include "../../public/alert/successAlert.php";
?>

<!-- Content of Page -->z

<div class="container" >
      <div class="container header-laporan text-center mt-3">
        <h3 style="color : #818181;">Laporan Harian</h3>
        <h4 class="roboto-text">Pengawasan Pembangunan <?= $_SESSION['nama_projek_op']?></h4>
        <h4 class="roboto-text">Hari ke-<?= $_SESSION['nomor']?> | <?= $_SESSION['tanggal_laporan']?></h4>
    </div>
    <hr class="container separator-header">
</div>