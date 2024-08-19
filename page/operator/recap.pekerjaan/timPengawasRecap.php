<div class="card mt-3">
        <h5 class="card-header ">
            Data Tim Pengawas
            <a href="operator.timPengawas.php" class="btn btn-edit ms-2 mt-0"><i class='bx bxs-edit-alt'></i>EDIT</a>
        </h5>
        <table class="table-thick-border">
            <tr>
                <th class="col-6">Tim Pengawas</th>
                <th class="col-6">Tim Leader</th>
            </tr>
            <?php
                $id_projek = $_SESSION['id_projek_op'];

                $tampil = mysqli_query($conn, "SELECT tp.id_tim_pengawas, tp.tim_pengawas , tp.tim_leader
                                               FROM tim_pengawas AS tp
                                               JOIN m_projek AS mp ON mp.id_projek = tp.id_projek
                                               WHERE tp.id_projek = '$id_projek'
                                               ORDER BY tp.id_projek ASC");
                $nomor_masalah = 1;

                if (mysqli_num_rows($tampil) > 0) {
                    while ($data = mysqli_fetch_array($tampil)) : 
            ?>
            <tr>
                <td class="text-center col-6"><?= $data['tim_pengawas'] ?></td>
                <td class="text-center col-6"><?= $data['tim_leader'] ?></td>
            </tr>
            <?php 
                endwhile;
                } else { 
            ?>
            <tr>
                <td colspan="4" class="text-center">Tidak ada data Tim Pengawas .</td>
            </tr>
            <?php } ?>
        </table>
    </div>