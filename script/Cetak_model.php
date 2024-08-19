<?php

$projek_query = mysqli_query($conn, "SELECT *
                               FROM m_projek
                               WHERE id_projek = '$id_projek'");
$projek = mysqli_fetch_array($projek_query);

$laporan_query = mysqli_query($conn, "SELECT *
                               FROM laporan_harian
                               WHERE id_projek = '$id_projek'");
$laporan = mysqli_fetch_array($laporan_query);

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