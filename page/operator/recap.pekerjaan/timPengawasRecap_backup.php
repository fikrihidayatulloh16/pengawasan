<?php 
$id_projek = $_SESSION['id_projek_op'];

$tampil = mysqli_query($conn, "SELECT tp.tim_pengawas , tp.tim_leader, mp.pengawas
                               FROM tim_pengawas AS tp
                               JOIN m_projek AS mp ON mp.id_projek = tp.id_projek
                               WHERE tp.id_projek = '$id_projek'
                               ORDER BY tp.id_projek ASC");
?>
<div class=" mt-3">
        
        <table class="table">
            <tr>
                <th class="col-6">Disusun Oleh</th>
                <th class="text-top col-6">Diperiksa</th>
            </tr>
            <tr>
                <th class="col-6">Pengawas Lapangan</th>
                <th class="col-6">Tim Leader</th>
            </tr>
            <?php
                if (mysqli_num_rows($tampil) > 0) {
                    while ($data = mysqli_fetch_array($tampil)) : 
            ?>
            <tr>
                <th class="col-6"><?= $data['pengawas'] ?></th>
                <th class="col-6"><?= $data['pengawas'] ?></th>
            </tr>
            
            <tr>
                <td class="text-center col-6"><?= $data['tim_pengawas'] ?></td>
                <td class="text-center col-6"><?= $data['tim_leader'] ?></td>
            </tr>
            <?php 
                endwhile;
                } else { 
            ?>
            <tr>
                <td colspan="4" class="text-center">
                    Tidak ada data Tim Pengawas.
                    <a href="operator.timPengawas.php" class="btn btn-warning text-dark ms-2 mt-0"><i class='bx bxs-edit-alt'>Ubah</i></a>
                </td>
            </tr>
            <?php } ?>
        </table>
    </div>