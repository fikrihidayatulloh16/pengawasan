<?php
    include "../../koneksi.php";
    include "../../public/layout/operator/header.laporan.php";
?>
 <style>
        .table-thick-border {
            border: 1px solid #000 !important;
        }
        .table-thick-border th, .table-thick-border td {
            border: 1px solid #000 !important;
        }

        th, td {
            padding: 8px;
            text-align: center;
        }

        @media (max-width: 576px) {
            .kolom-aksi {
                width: 50%; /* 4 dari 12 kolom */
            }

            span {
                display: none;
            }
        }
</style>
            <h3 class=" text-center mt-4">Laporan Harian</h3>

                <h4 class="text-center">Nama Projek : <?= $_SESSION['nama_projek_op']?></h4>

            <?php include 'operator.modal/modalAdd.laporanharian.php' ?>

                <div class="container mt-100">
                    <button type="button-center" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#lh_tambah"><i class='bx bx-plus-medical' style="margin-right: 5px;" name="lh_tambah">
                        </i>Tambah
                    </button>
                    <a href="../admin/m_projek_utkop.php" class="btn btn-secondary align-item-right" ><i class='bx bx-arrow-back' style="margin-right: 5px;"></i>Kembali</a>
                    <div class="container">
                    <form method="GET" action="">
                        <label for="row_count">Tampilkan Baris:</label>
                        <select id="row_count" name="row_count" onchange="this.form.onClick()">
                            <option value="5" <?= isset($_GET['row_count']) && $_GET['row_count'] == 5 ? 'selected' : '' ?>>5</option>
                            <option value="10" <?= isset($_GET['row_count']) && $_GET['row_count'] == 10 ? 'selected' : '' ?>>10</option>
                            <option value="15" <?= isset($_GET['row_count']) && $_GET['row_count'] == 15 ? 'selected' : '' ?>>15</option>
                            <option value="20" <?= isset($_GET['row_count']) && $_GET['row_count'] == 20 ? 'selected' : '' ?>>20</option>
                        </select>
                    </form>
                    </div>
                    
                    
                    <div class="card mt-100">
                        <h5 class="card-header bg-primary text-white">Data Laporan Harian</h5>

                            <table class="table table-striped table-bordered table-thick-border">
                                <tr>
                                    <th>No.</th>
                                    <th>Hari Ke-</th>
                                    <th>Tanggal</th>
                                    <th>Progres</th>
                                    <th class="col-2">Aksi</th>
                                </tr>
                                    <?php
                                        $row_count = 10;
                                        $id_projek = $_SESSION['id_projek_op'];
                                        if (isset($_GET['row_count'])) {
                                            $row_count = (int)$_GET['row_count'];
                                        }
                                        // Mengambil data laporan dari database
                                        $tampil = mysqli_query($conn, "SELECT lp.id_laporan_harian , lp.tanggal AS tanggal_laporan, lp.progress_harian, pj.tanggal_mulai 
                                                                    FROM laporan_harian AS lp
                                                                    JOIN m_projek AS pj ON lp.id_projek = pj.id_projek
                                                                    WHERE lp.id_projek = '$id_projek'
                                                                    AND pj.id_projek = '$id_projek'
                                                                    ORDER BY lp.id_laporan_harian  ASC
                                                                    LIMIT $row_count");
                                        $nomor = 1;

                                        while ($data = mysqli_fetch_array($tampil)) : 
                                            $tanggal_laporan = $data['tanggal_laporan'];
                                            $tanggal_mulai = $data['tanggal_mulai'];

                                            // Menghitung selisih hari
                                            $datetime1 = new DateTime($tanggal_mulai);
                                            $datetime2 = new DateTime($tanggal_laporan); 
                                            $interval = $datetime1->diff($datetime2);
                                            $hari_ke = $interval->days + 1; // Ditambah 1 karena hari pertama adalah hari ke-1
                                    ?>
                                        <tr>
                                            <td class="text-center align-middle"><?= $nomor ?></td>
                                                <?php echo "<td class='text-center align-middle'><a name='laporan_pilih' href='../../script/operator.script/laporan_pilih.php?
                                                    id_laporan_harian=" . $data['id_laporan_harian'] . 
                                                    "&tanggal_laporan=" . $data['tanggal_laporan'] . 
                                                    "&nomor=" . $nomor . 
                                                    "'>Hari-ke " . $nomor . "</a></td>"; 
                                                ?>
                                            <td class="text-center align-middle"><?= $data['tanggal_laporan'] ?></td>
                                            <td class="text-center align-middle"><?= $data['progress_harian'] ?></td>
                                            <td>
                                                <form action="../../script/projek_pilih.php" method="POST">
                                                    <a href="#" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalHapus<?=$data['id_laporan_harian']?>"><i class='bx bxs-trash-alt' ><span> Hapus</span></i></a>
                                                    <a href="#" class="btn btn-warning text-dark mt-1" data-bs-toggle="modal" data-bs-target="#modalUbah<?=$data['id_laporan_harian']?>"><i class='bx bxs-edit-alt' ><span> Ubah</span></i></a>
                                                    <input type="hidden" name="id_laporan" value="<?=$data['id_laporan_harian']?>">
                                                </form>
                                            </td>
                                        </tr>
                                <?php $nomor++; endwhile; ?>
                            </table>
                        </div>
                    </div>

<?php
    include "../../public/alert/successAlert.php";

    include "../../public/layout/operator/footer.laporan.php";
?>