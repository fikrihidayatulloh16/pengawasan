<?php
    include "../../koneksi.php";
    include "../../public/layout/operator/header.operator.php";
    include "../../public/alert/successAlert.php";

    if (empty($_SESSION['id_laporan_harian'])) {
        // Ambil parameter id_laporan_harian dari URL
        if (isset($_GET['id_laporan_harian']) && isset($_GET['tanggal_laporan']) && isset($_GET['nomor'])) {
            $id_laporan_harian = $_GET['id_laporan_harian'];
            $tanggal_laporan = $_GET['tanggal_laporan'];
            $nomor = $_GET['nomor'];
    
            // Menyimpan ke dalam session
            $_SESSION['id_laporan_harian'] = $id_laporan_harian;
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

<link href="../../css/stylesPekerjaan.css" rel="stylesheet">

<style>

    .image-container {
        max-width: 100%; /* Batas maksimum lebar gambar sesuai dengan kontainer */
        height: auto; /* Menjaga rasio aspek gambar */
    }

    .image-container img {
        width: 100%; /* Gambar akan menyesuaikan dengan lebar kontainer */
        height: auto; /* Menjaga rasio aspek gambar */
    }
    
    /* Style untuk table */
.table-thick-border-pekerjaan {
    border: 1px solid #ffffff !important;
}

.table-thick-border-pekerjaan th {
    border-top: 1px solid #000000 !important;
    border-right: 1px solid #000000 !important;
}

.table-thick-border-pekerjaan td {
    border-right: 1px solid #000000 !important;
}

th {
    background-color: #707070;
    color: white;
    border-right: 1px solid #000000; /* Properti lengkap */
    /*border-bottom: 1px solid #ffffff; /* Tambahkan border-bottom jika diperlukan */
}

th, td {
    padding: 8px;
    text-align: center;
    font-family: 'Inter', sans-serif;
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

/*
// Mengambil data cuaca
$tampil_cuaca = mysqli_query($conn, "SELECT kondisi, jam_mulai, jam_selesai
                                        FROM cuaca
                                        WHERE id_laporan_harian = '$id_laporan_harian'");

// Initialize arrays to store weather conditions for each hour
$weather_hours = array_fill(0, 24, '');

// Update arrays with weather conditions
while ($data_cuaca = mysqli_fetch_assoc($tampil_cuaca)) {
    $kondisi = $data_cuaca['kondisi'];
    $jam_mulai = intval(date('H', strtotime($data_cuaca['jam_mulai'])));
    $jam_selesai = intval(date('H', strtotime($data_cuaca['jam_selesai'])));

    for ($hour = $jam_mulai; $hour <= $jam_selesai; $hour++) {
        $weather_hours[$hour] = $kondisi;
    }
}
*/
?>



<div class="container">

    <?php include "recap.pekerjaan/logoRecap.php" ?>

    <hr class="separator">

    <?php include "recap.pekerjaan/cuacaRecap.php" ?>



    <div class="card mt-3 cuaca-tabel2">
    <h5 class="card-header">Data Cuaca</h5>
    <div class="table-responsive tabel-cuaca" style="overflow-x: auto;">
        <table class="table table-striped tabel-cuaca">
            <thead>
                <tr class="text-center">
                    <th class="text-center align-middle no-column">No</th>
                    <th class="text-center align-middle weather-column">Keadaan Cuaca</th>
                    <?php for ($hour = 0; $hour < 24; $hour++): ?>
                        <th class="text-center align-middle"><?= sprintf('%02d:00', $hour) ?></th>
                    <?php endfor; ?>
                </tr>
            </thead>
            <tbody class="table-group-divider">
                <tr class="text-center align-middle ">
                    <td class="no-column">1</td>
                    <td class="weather-column">Cerah</td>
                    <?php for ($hour = 0; $hour < 24; $hour++): ?>
                        <td class="text-center align-middle <?= $weather_hours[$hour] == 'cerah' ? 'cerah' : '' ?>">
                            <?= $weather_hours[$hour] == 'cerah' ? 'Cerah' : '' ?>
                        </td>
                    <?php endfor; ?>
                </tr>
                <tr class="text-center align-middle">
                    <td class="no-column">2</td>
                    <td class="weather-column">Hujan</td>
                    <?php for ($hour = 0; $hour < 24; $hour++): ?>
                        <td class="text-center align-middle <?= $weather_hours[$hour] == 'hujan' ? 'hujan' : '' ?>">
                            <?= $weather_hours[$hour] == 'hujan' ? 'Hujan' : '' ?>
                        </td>
                    <?php endfor; ?>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<hr class="separator">

    <div class="card mt-3">
        <h5 class="card-header">
            Data Pekerjaan Harian
            <a href="operator.pekerjaan.php" class="btn btn-edit text-white ms-2 mt-0"><i class='bx bxs-edit-alt'></i>EDIT</a>
        </h5>
        <div class="table-responsive">
            <table class="table table-striped table-thick-border-pekerjaan table-bordered">
                <thead>
                    <tr class="text-center">
                        <th class="text-center align-middle" rowspan="2">Pekerjaan : <? $nama_pekerjaan ?></th>
                        <th class="text-center align-middle" colspan="2">Pekerja</th>
                        <th class="text-center align-middle" colspan="2">Peralatan</th>
                        <th class="text-center align-middle" colspan="2">Bahan</th>
                    </tr>
                    <tr class="text-center">
                        <th class="text-center align-middle">Jenis Pekerja</th>
                        <th class="text-center align-middle">Jumlah Pekerja</th>
                        <th class="text-center align-middle">Nama Alat</th>
                        <th class="text-center align-middle">Jumlah Peralatan</th>
                        <th class="text-center align-middle">Nama Bahan</th>
                        <th class="text-center align-middle">Jumlah Bahan</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    <?php
                    if (mysqli_num_rows($tampil_sub_pekerjaan) > 0) {
                        while ($data_sub_pekerjaan = mysqli_fetch_assoc($tampil_sub_pekerjaan)) :
                            $id_m_sub_pekerjaan = $data_sub_pekerjaan['id_m_sub_pekerjaan'];
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
                                    $bottom_border = ($i == $max_rows - 1) ? '1px solid black' : '0px solid black'; // Set thick border for last row
                                    ?>
                                    <tr class="text-center align-middle">
                                        <?php if ($i == 0): ?>
                                            <td rowspan="<?= $max_rows ?>" class="text-center kolom-sub" style="border-bottom: 1px solid black;"><?= $data_sub_pekerjaan['nama_sub_pekerjaan'] ?></td>
                                        <?php endif; ?>
                                        <td class="text-center kolom-pekerja" style="border-bottom: <?= $bottom_border ?>;"><?= $pekerja['jenis_pekerja'] ?? '' ?></td>
                                        <td class="text-center kolom-pekerja" style="border-bottom: <?= $bottom_border ?>;"><?= $pekerja['jumlah_pekerja'] ?? '' ?></td>
                                        <td class="text-center kolom-alat" style="border-bottom: <?= $bottom_border ?>;"><?= $alat['nama_alat'] ?? '' ?></td>
                                        <td class="text-center kolom-alat" style="border-bottom: <?= $bottom_border ?>;"><?= $alat['jumlah_peralatan'] ?? '' ?> <?= $alat['satuan'] ?? '' ?></td>
                                        <td class="text-center kolom-bahan" style="border-bottom: <?= $bottom_border ?>;"><?= $bahan['nama_bahan'] ?? '' ?></td>
                                        <td class="text-center kolom-bahan" style="border-bottom: <?= $bottom_border ?>;"><?= $bahan['jumlah_bahan'] ?? '' ?> <?= $bahan['satuan'] ?? '' ?></td>
                                    </tr>
                                    <?php
                                }
                            } else {
                                ?>
                                <tr>
                                    <td colspan="7" class="text-center">Tidak ada data Sub <?= $data_sub_pekerjaan['nama_sub_pekerjaan'] ?></td>
                                </tr>
                                <?php
                            }
                        endwhile;
                    } else {
                        ?>
                        <tr>
                            <td colspan="7" class="text-center">Tidak ada data.</td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <?php 
        include "recap.pekerjaan/permasalahanRecap.php";

        include "recap.pekerjaan/fotoKegiatanRecap.php";

        include "recap.pekerjaan/timPengawasRecap.php" ;
    ?>

    <a href="laporanharian.php" class="btn btn-kembali mt-2">
        <i class='bx bxs-chevrons-left'></i>Kembali
    </a>
</div>

<?php
    include "../../public/layout/footer.php";
?>
