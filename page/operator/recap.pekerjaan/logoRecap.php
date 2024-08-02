<?php 
$id_projek = $_SESSION['id_projek_op'];

$tampil = mysqli_query($conn, "SELECT logo_pemilik, logo_pengawas , logo_kontrakor
                               FROM m_projek
                               WHERE id_projek = '$id_projek'");
$data = mysqli_fetch_array($tampil)
?>

<style>
    .custom-img {
        max-width: 150px; /* Sesuaikan dengan ukuran yang diinginkan */
        max-height: 150px;
    }
</style>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4 text-center">
            <img src="uploads/<?= $data['logo_pemilik'] ?>" alt="logo_pemilik" class="img-fluid custom-img">
        </div>
        <div class="col-md-4 text-center">
            <img src="uploads/<?= $data['logo_pengawas'] ?>" alt="logo_pengawas" class="img-fluid custom-img">
        </div>
        <div class="col-md-4 text-center">
            <img src="uploads/<?= $data['logo_kontrakor'] ?>" alt="logo_kontrakor" class="img-fluid custom-img">
        </div>
    </div>
</div>
