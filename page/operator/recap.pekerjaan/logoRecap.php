<?php 
$id_projek = $_SESSION['id_projek_op'];

$tampil = mysqli_query($conn, "SELECT pemilik_pekerjaan, pengawas, kontraktor, logo_pemilik, logo_pengawas , logo_kontraktor
                               FROM m_projek
                               WHERE id_projek = '$id_projek'");
$data = mysqli_fetch_array($tampil)
?>

<style>
    .custom-img {
        width: 150px; /* Sesuaikan dengan ukuran yang diinginkan */
        height: 150px;
    }
</style>

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-4 text-center">
            <h4>Pemilik Pekerjaan</h4>
            <img src="http://localhost/pengawasan_me/public/asset/img/uploads/logo/<?= $data['logo_pemilik'] ?>" alt="logo_pemilik" class="img-fluid custom-img mt-3">
            <br>
            <?= $data['pemilik_pekerjaan'] ?>
        </div>
        <div class="col-md-4 text-center">
            <h4>Konsultan Pengawas</h4>
            <img src="http://localhost/pengawasan_me/public/asset/img/uploads/logo/<?= $data['logo_pengawas'] ?>" alt="logo_pengawas" class="img-fluid custom-img mt-3">
            <br>
            <?= $data['pengawas'] ?>
        </div>
        <div class="col-md-4 text-center">
            <h4>Kontraktor Pelaksana</h4>
            <img src="http://localhost/pengawasan_me/public/asset/img/uploads/logo/<?= $data['logo_kontraktor'] ?>" alt="logo_kontrakor" class="img-fluid custom-img mt-3">
            <br>
            <?= $data['kontraktor'] ?>
        </div>
    </div>
</div>
