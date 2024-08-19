<?php


include '../../koneksi.php';


$id_projek = $_GET['id_projek_op'];
$id_laporan_harian = $_GET['id_laporan_harian'];
$tanggal_laporan = $_GET['tanggal_laporan'];


include '../../script/Cetak_model.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <!--  jQuery dan DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <!-- Font From Google -->
    <link href="https://fonts.googleapis.com/css2?family=ABeeZee&family=Inter:wght@400;700&family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <!-- Bootstrap CDN Link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Boxiocns CDN Link -->
    <link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link href="../../css/general.css" rel="stylesheet">
</head>

<style>
body {
    font-family: Arial, sans-serif;
    margin: 0; /* Margin ditangani oleh mPDF atau DomPDF */
    padding-left: 10px;
    padding-right: 10px;
}
.header, .footer {
    border: 1px solid #333; /* Uniform border thickness for all sections */
    background-color: #fff;
    padding: 20px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    margin-bottom: 20px;
    text-align: center;
}

.custom-img {
        width: 100px; /* Sesuaikan dengan ukuran yang diinginkan */
        height: 100px;
    }

.section-title {
    font-size: 18px;
    color: #333;
    text-transform: uppercase;
    padding: 10px;
    background-color: #f4f4f4;
    margin-bottom: 0; /* Remove extra margin */
    border-left: 1px solid #333; /* Uniform border thickness */
    border-right: 1px solid #333;
}

.table-container {
    padding: 0; /* Remove extra padding */
    border: 1px solid #333; /* Uniform border thickness */
}

table {
    width: 100%;
    border-spacing: 0; /* No space between borders */
    border: 1px solid #333; /* Uniform border thickness for the table */
    border-collapse: collapse; /* Collapse borders into one */
}

th, td {
    padding: 8px;
    text-align: left;
    font-size: 16px;
    border: 1px solid #333; /* Uniform border thickness for table cells */
}

th {
    font-size: 18px;
    color: #333;
    text-transform: uppercase;
    padding: 10px;
    background-color: #e9ecef;
    margin-bottom: 0; /* Remove extra margin */
}

.image-container {
        max-width: 100%; /* Batas maksimum lebar gambar sesuai dengan kontainer */
        height: auto; /* Menjaga rasio aspek gambar */
    }

.image-container img {
        width: 100%; /* Gambar akan menyesuaikan dengan lebar kontainer */
        height: auto; /* Menjaga rasio aspek gambar */
    }

.chart-container {
    width: max-content;
    height: 300px;
    margin: 1% auto;
}

.legend-container {
    text-align: center;
    margin-top: 50px;
}
.legend-item {
    display: inline-flex;
    align-items: center;
    margin-right: 20px;
}
.legend-color {
    width: 20px;
    height: 20px;
    margin-right: 10px;
    border-radius: 50%;
}
.legend-label {
    font-size: 14px;
}

.card-header{
    display: none;
}

.card, .mt-3 {
    margin-top: 0px;
}

.footer {
    font-size: 16px;
    padding: 20px;
}


</style>
<body>
    <div class="container">
    <table>
        <tr>
            <td class="text-center" style="border-right: 0px;">
                <img src="http://localhost/pengawasan_me/public/asset/img/uploads/logo/<?= $projek['logo_pemilik'] ?>" alt="logo_pemilik" class="img-fluid custom-img mt-3">
            </td>
            <td class="text-center">
                <?= $projek['pemilik_pekerjaan'] ?>
            </td>
            <td class="text-center">
                Konsultan Pengawas
                <br>
                <img src="http://localhost/pengawasan_me/public/asset/img/uploads/logo/<?= $projek['logo_pengawas'] ?>" alt="logo_pengawas" class="img-fluid custom-img mt-3">
                <br>
                <?= $projek['pengawas'] ?>
            </td>
            <td class="text-center"> 
                Kontraktor Pelaksana
                <br>
                <img src="http://localhost/pengawasan_me/public/asset/img/uploads/logo/<?= $projek['logo_kontraktor'] ?>" alt="logo_kontrakor" class="img-fluid custom-img mt-3">
                <br>
                <?= $projek['kontraktor'] ?>
            </td>
        </tr>
        <tr>
            <td class="text-center" colspan="2" rowspan="4">
            <?= $projek['nama_projek'] ?>
            </td>
            <td class="text-center">
                TANGGAL
            </td>
            <td>
                <?= $tanggal_laporan ?>
            </td>
        </tr>
        <tr>
            <td class="text-center" rowspan="4">LAMPIRAN</td>
            <td>1. Dokumentasi</td>
        </tr>
        <tr>
        <td>2. Site Instruction</td>
        </tr>
        <tr>
        <td>3. Lain-lain</td>
        </tr>
    </table>

    <div class="section-title text-center" style="border-bottom: 1px solid #333;">Laporan Harian PENGAWAS</div>
    
    <div class="section-title">A. Cuaca</div>
    <div class="table-container">
        
        <?php include "recap.pekerjaan/cuacaRecap.php" ?>
    </div>

    <div class="section-title">B. Rincian Pekerjaan</div>
    <div>
        <table class="table table-thick-border-pekerjaan table-bordered">
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

    <div class="section-title">C. Permasalahan dan Tindak Lanjut</div>
    <div>
    <table>
            <tr>
                <th class="col-1 text-center">No.</th>
                <th class="col-5 text-center">Permasalahan</th>
                <th class="col-5 text-center">Saran</th>
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

    <div>
        <table>
            <?php
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
                <td class="text-center col-6">
                    Disusun/ Dibuat Oleh
                    <br>
                    <?= $projek['pengawas'] ?>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <?= $data['tim_pengawas'] ?>
                    <br>
                    Tim Pengawas
                </td>
                <td class="text-center col-6">
                    Diperiksa
                    <br>
                    <?= $projek['pengawas'] ?>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <?= $data['tim_leader'] ?>
                    <br>
                    Tim Leader
            </td>
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

    <div class="section-title text-center">Dokumentasi Harian</div>
    <div class="table-container">
    <div class="container">
            <?php
                $tampil = mysqli_query($conn, "SELECT fk.id_foto_kegiatan, fk.id_laporan_harian, fk.foto, fk.keterangan
                                               FROM foto_kegiatan AS fk
                                               JOIN laporan_harian AS lh ON lh.id_laporan_harian = fk.id_laporan_harian
                                               WHERE fk.id_laporan_harian = '$id_laporan_harian'
                                               AND lh.id_laporan_harian = '$id_laporan_harian'
                                               ORDER BY fk.id_laporan_harian ASC");

                if (mysqli_num_rows($tampil) > 0) {
                    $num_row = 0;
                    while ($data = mysqli_fetch_array($tampil)) {
                        if ($num_row % 2 == 0) {
                            // Mulai baris baru untuk setiap dua gambar
                            echo '<div class="row mt-lg-3">';
                        }
            ?>
            <div class="image-container text-center col-lg-6 col-sm-12">
                <img src="http://localhost/pengawasan_me/public/asset/img/uploads/foto_kegiatan/<?= $data['foto'] ?>" alt="Foto Kegiatan" class="img-fluid image-rekap mt-3"><br><?= $data['keterangan'] ?>
            </div>
            <?php
                        $num_row++;
                        if ($num_row % 2 == 0) {
                            // Tutup baris setelah dua gambar
                            echo '</div>';
                        }
                    }
                    if ($num_row % 2 != 0) {
                        // Tutup baris jika ada gambar ganjil
                        echo '</div>';
                    }
                } else {
            ?>
            <div class="row">
                <div class="col-12 text-center">Tidak ada data Foto Kegiatan.</div>
            </div>
            <?php } ?>
        </div>
    </div>
</body>
</div>
</html>