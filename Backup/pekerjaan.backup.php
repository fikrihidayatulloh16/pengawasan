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
        border: #000;
    }

    td {
        border: dark;
    }

    .header-laporan {
        background-image: linear-gradient(#410DFD, #0D6EFD);
    }

    .image-container {
        max-width: 100%; /* Batas maksimum lebar gambar sesuai dengan kontainer */
        height: auto; /* Menjaga rasio aspek gambar */
    }

    .image-container img {
        width: 100%; /* Gambar akan menyesuaikan dengan lebar kontainer */
        height: auto; /* Menjaga rasio aspek gambar */
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

    <?php include "recap.pekerjaan/logoRecap.php" ?>


    <?php include "recap.pekerjaan/cuacaRecap.php" ?>

    <div class="card mt-3">
        <h5 class="card-header bg-primary text-white">
            Data Pekerjaan Harian
            <a href="operator.pekerjaan.php" class="btn btn-warning text-dark ms-2 mt-0"><i class='bx bxs-edit-alt'>Ubah</i></a>
        </h5>
        <div class="table-responsive">
        <table class="table table-striped ">
            <tr class="text-center">
                <th class="border-start border-dark text-center align-middle">
                    Nama Sub Pekerjaan
                </th>
                <th class="border-start border-dark text-center align-middle">
                    Jenis Pekerja
                </th>
                <th class="border-end border-dark text-center align-middle">
                    Jumlah Pekerja
                </th>
                <th class="text-center align-middle">
                    Nama Alat
                </th>
                <th class="border-end border-dark text-center align-middle">
                    Jumlah Peralatan
                </th>
                <th class="text-center align-middle">
                    Nama Bahan
                </th>
                <th class="border-end border-dark text-center align-middle">
                    Jumlah Bahan
                </th>
            </tr>
            <tbody class="table-group-divider">
            <?php
            if (mysqli_num_rows($tampil_sub_pekerjaan) > 0) {
                while ($data_sub_pekerjaan = mysqli_fetch_assoc($tampil_sub_pekerjaan)) :
                    $id_m_sub_pekerjaan = $data_sub_pekerjaan['id_m_sub_pekerjaan'];
            ?>
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
                <tr class="text-center align-middle">
                    <?php if ($i == 0): ?>
                        <td rowspan="<?= $max_rows ?>" class="text-center border-start border-dark"><?= $data_sub_pekerjaan['nama_sub_pekerjaan'] ?></td>
                    <?php endif; ?>
                    <td class="text-center border-start border-dark"><?= $pekerja['jenis_pekerja'] ?? '' ?></td>
                    <td class="text-center border-end border-dark"><?= $pekerja['jumlah_pekerja'] ?? '' ?></td>
                    <td class="text-center border-dark"><?= $alat['nama_alat'] ?? '' ?></td>
                    <td class="text-center border-end border-dark"><?= $alat['jumlah_peralatan'] ?? '' ?> <?= $alat['satuan'] ?? '' ?></td>
                    <td class="text-center border-dark"><?= $bahan['nama_bahan'] ?? '' ?></td>
                    <td class="text-center border-end border-dark"><?= $bahan['jumlah_bahan'] ?? '' ?> <?= $bahan['satuan'] ?? '' ?></td>
                </tr>
                <?php
                    }
                } else {
                ?>
                <tr>
                    <td colspan="9" class="text-center">Tidak ada data Sub <?= $data_sub_pekerjaan['nama_sub_pekerjaan'] ?></td>
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
            </tbody>
        </table>
        </div>
    </div>

    <?php 
        include "recap.pekerjaan/permasalahanRecap.php";

        include "recap.pekerjaan/fotoKegiatanRecap.php";

        include "recap.pekerjaan/timPengawasRecap.php" ;
    ?>
</div>

<?php
    include "../../public/layout/operator/footer.operator.php";
?>
