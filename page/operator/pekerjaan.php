<?php
    include "../../koneksi.php";
    include "../../public/layout/operator/header.operator.php";

    if (empty($_SESSION['id_laporan_harian'])) {
        // Ambil parameter id_laporan_harian dari URL
        if (isset($_GET['id_laporan_harian']) && isset($_GET['tanggal_laporan']) && isset($_GET['nomor'])) {
            $id_laporan_harian = $_GET['id_laporan_harian'];
            $tanggal_laporan = $_GET['tanggal_laporan'];
            $nomor = $_GET['nomor'];
    
            // Menyimpan ke dalam session
            $_SESSION['id_laporan_harian'] = $id_laporan_harian;
            $_SESSION['tanggal_laporan'] = $tanggal_laporan;
            $_SESSION['nomor'] = $nomor;
        }
    }

    $id_laporan_harian = $_SESSION['id_laporan_harian'];

    // Mengambil nama master pekerjaan
    $m_pekerjaan = mysqli_query($conn, "SELECT ms.id_m_sub_pekerjaan, mp.nama_pekerjaan
                                            FROM m_pekerjaan AS mp
                                            JOIN m_sub_pekerjaan AS ms ON ms.id_m_pekerjaan  = mp.id_m_pekerjaan 
                                            JOIN pekerjaan_harian AS ph ON ph.id_m_sub_pekerjaan = ms.id_m_sub_pekerjaan
                                            WHERE ph.id_laporan_harian = '$id_laporan_harian'");
    $data_pekerjaan = mysqli_fetch_assoc($m_pekerjaan);
    $nama_pekerjaan = $data_pekerjaan['nama_pekerjaan']
?>
<style>
    .table-thick-border {
        border: 1px solid #000 !important;
    }
    .table-thick-border th, .table-thick-border td {
        border: 1px solid #000 !important;
    }

    th {
        text-align: center;
    }

    .header-laporan {
        background-image: linear-gradient(#410DFD, #0D6EFD);
    }
</style>
<?php
    // Mengambil data sub pekerjaan
    $tampil_sub_pekerjaan = mysqli_query($conn, "SELECT msp.id_m_sub_pekerjaan, msp.nama_sub_pekerjaan
                                                    FROM m_sub_pekerjaan AS msp
                                                    JOIN pekerjaan_harian AS ph ON ph.id_m_sub_pekerjaan = msp.id_m_sub_pekerjaan
                                                    WHERE ph.id_laporan_harian = '$id_laporan_harian'");

    $tampil_pekerja = mysqli_query($conn, "SELECT mpj.jenis_pekerja, pj.jumlah_pekerja, ph.id_m_sub_pekerjaan
                                            FROM pekerja AS pj
                                            JOIN pekerjaan_harian AS ph ON pj.id_laporan_harian = ph.id_laporan_harian AND pj.id_m_sub_pekerjaan = ph.id_m_sub_pekerjaan
                                            JOIN m_pekerja AS mpj ON pj.id_m_pekerja = mpj.id_m_pekerja
                                            WHERE pj.id_laporan_harian = '$id_laporan_harian'");

    $tampil_peralatan = mysqli_query($conn, "SELECT mpl.nama_alat, pl.jumlah_peralatan, mpl.satuan, ph.id_m_sub_pekerjaan
                                            FROM peralatan AS pl
                                            JOIN pekerjaan_harian AS ph ON pl.id_laporan_harian = ph.id_laporan_harian AND pl.id_m_sub_pekerjaan = ph.id_m_sub_pekerjaan
                                            JOIN m_peralatan AS mpl ON pl.id_m_peralatan = mpl.id_m_peralatan
                                            WHERE pl.id_laporan_harian = '$id_laporan_harian'");

    $tampil_bahan = mysqli_query($conn, "SELECT mbh.nama_bahan, bh.jumlah_bahan, mbh.satuan, ph.id_m_sub_pekerjaan
                                            FROM bahan AS bh
                                            JOIN pekerjaan_harian AS ph ON bh.id_laporan_harian = ph.id_laporan_harian AND bh.id_m_sub_pekerjaan = ph.id_m_sub_pekerjaan
                                            JOIN m_bahan AS mbh ON bh.id_m_bahan = mbh.id_m_bahan
                                            WHERE bh.id_laporan_harian = '$id_laporan_harian'");
?>

<div class="container">
        <a href="laporanharian.php" class="btn btn-secondary ms-3 mt-3" ><i class='bx bx-arrow-back' style="margin-right: 5px;"></i>Kembali</a>
        <a href="operator.pekerjaan.php" class="btn btn-warning text-dark ms-2 mt-3" data-bs-toggle="modal" data-bs-target="#modalUbah<?=$data['id_laporan_harian']?>"><i class='bx bxs-edit-alt'>Ubah</i></a>
    <div class="card mt-3">
        <h5 class="card-header bg-primary text-white">
            Data Pekerja
        </h5>

        <table class="table table-striped table-bordered table-thick-border">
            <tr>
                <th>Nama Sub Pekerjaan</th>
                <th>Jenis Pekerja</th>
                <th>Jumlah Pekerja</th>
                <th>Nama Alat</th>
                <th>Jumlah Peralatan</th>
                <th>Satuan Alat</th>
                <th>Nama Bahan</th>
                <th>Jumlah Bahan</th>
                <th>Satuan Bahan</th>
            </tr>

            <?php
            if (mysqli_num_rows($tampil_sub_pekerjaan) > 0) {
                while ($data_sub_pekerjaan = mysqli_fetch_assoc($tampil_sub_pekerjaan)) :
                    $id_m_sub_pekerjaan = $data_sub_pekerjaan['id_m_sub_pekerjaan'];
            ?>
            <tr>
                <td class="text-center"></td>
                <?php
                $pekerja_result = mysqli_query($conn, "SELECT mpj.jenis_pekerja, pj.jumlah_pekerja
                                                        FROM pekerja AS pj
                                                        JOIN m_pekerja AS mpj ON pj.id_m_pekerja = mpj.id_m_pekerja
                                                        WHERE pj.id_laporan_harian = '$id_laporan_harian' AND pj.id_m_sub_pekerjaan = '$id_m_sub_pekerjaan'");
                $alat_result = mysqli_query($conn, "SELECT mpl.nama_alat, pl.jumlah_peralatan, mpl.satuan
                                                        FROM peralatan AS pl
                                                        JOIN m_peralatan AS mpl ON pl.id_m_peralatan = mpl.id_m_peralatan
                                                        WHERE pl.id_laporan_harian = '$id_laporan_harian' AND pl.id_m_sub_pekerjaan = '$id_m_sub_pekerjaan'");
                $bahan_result = mysqli_query($conn, "SELECT mbh.nama_bahan, bh.jumlah_bahan, mbh.satuan
                                                        FROM bahan AS bh
                                                        JOIN m_bahan AS mbh ON bh.id_m_bahan = mbh.id_m_bahan
                                                        WHERE bh.id_laporan_harian = '$id_laporan_harian' AND bh.id_m_sub_pekerjaan = '$id_m_sub_pekerjaan'");

                if (mysqli_num_rows($pekerja_result) > 0 || mysqli_num_rows($alat_result) > 0 || mysqli_num_rows($bahan_result) > 0) {
                    $max_rows = max(mysqli_num_rows($pekerja_result), mysqli_num_rows($alat_result), mysqli_num_rows($bahan_result));
                    for ($i = 0; $i < $max_rows; $i++) {
                        $pekerja = mysqli_fetch_assoc($pekerja_result);
                        $alat = mysqli_fetch_assoc($alat_result);
                        $bahan = mysqli_fetch_assoc($bahan_result);
                ?>
                <tr>
                    <?php if ($i >= 0): ?>
                        <td rowspan="<?= $max_rows ?>" class="text-center"><?= $data_sub_pekerjaan['nama_sub_pekerjaan'] ?></td>
                    <?php endif; ?>
                    <td class="text-center"><?= $pekerja['jenis_pekerja'] ?? '' ?></td>
                    <td class="text-center"><?= $pekerja['jumlah_pekerja'] ?? '' ?></td>
                    <td class="text-center"><?= $alat['nama_alat'] ?? '' ?></td>
                    <td class="text-center"><?= $alat['jumlah_peralatan'] ?? '' ?></td>
                    <td class="text-center"><?= $alat['satuan'] ?? '' ?></td>
                    <td class="text-center"><?= $bahan['nama_bahan'] ?? '' ?></td>
                    <td class="text-center"><?= $bahan['jumlah_bahan'] ?? '' ?></td>
                    <td class="text-center"><?= $bahan['satuan'] ?? '' ?></td>
                </tr>
                <?php
                    }
                } else {
                ?>
                <tr>
                    <td colspan="9" class="text-center">Tidak ada data.</td>
                </tr>
                <?php
                }
                endwhile;
            } else {
            ?>
            <tr>
                <td colspan="9" class="text-center">Tidak ada data sub pekerjaan.</td>
            </tr>
            <?php } ?>
        </table>
    </div>
</div>

<?php
    include "../../public/layout/operator/footer.operator.php";
?>
