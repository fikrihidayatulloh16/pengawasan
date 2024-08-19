<div class="card mt-3">
    <h5 class="card-header">
        Data Permasalahan Harian
        <a href="operator.permasalahan.php" class="btn btn-edit ms-2 mt-0"><i class='bx bxs-edit-alt'></i>EDIT</a>
    </h5>
        <table class="table-thick-border">
            <tr>
                <th class="col-1">No.</th>
                <th class="col-5">Permasalahan</th>
                <th class="col-5">Saran</th>
            </tr>
            <?php
                $tampil = mysqli_query($conn, "SELECT ps.id_permasalahan, ps.id_laporan_harian, ps.permasalahan, ps.saran
                                               FROM permasalahan AS ps
                                               JOIN laporan_harian AS lh ON lh.id_laporan_harian = ps.id_laporan_harian
                                               WHERE ps.id_laporan_harian = '$id_laporan_harian'
                                               AND lh.id_laporan_harian = '$id_laporan_harian'
                                               ORDER BY ps.id_laporan_harian ASC");
                $nomor_masalah = 1;

                if (mysqli_num_rows($tampil) > 0) {
                    while ($data = mysqli_fetch_array($tampil)) : 
            ?>
            <tr>
                <td class="text-center"><?= $nomor_masalah ?></td>
                <td style="text-align: justify;"><?= $data['permasalahan'] ?></td>
                <td style="text-align: justify;"><?= $data['saran'] ?></td>
            </tr>
            <?php 
                $nomor_masalah++; 
                include "operator.modal/modalUD.permasalahan.php";
                endwhile;
                } else { 
            ?>
            <tr>
                <td colspan="4" class="text-center">Tidak ada data permasalahan.</td>
            </tr>
            <?php } ?>
        </table>
    </div>

    <hr class="separator">