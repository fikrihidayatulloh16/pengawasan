<?php
include "../../koneksi.php";

// Memulai sesi
session_start();

if (isset($_GET['id_laporan_harian']) && isset($_GET['tanggal_laporan']) && isset($_GET['nomor'])) {
    // Mengambil Data
    $pilih = $_GET['id_laporan_harian'];
    $tanggal = $_GET['tanggal_laporan'];
    $nomor = $_GET['nomor'];

    // Menyimpan ke dalam sesi
    $_SESSION['id_laporan_harian'] = $pilih;
    $_SESSION['tanggal_laporan'] = $tanggal;
    $_SESSION['nomor'] = $nomor;

    if ($pilih && $tanggal && $nomor) {
        echo "<script>
                alert('Pilih Laporan Berhasil!');
                document.location='../../page/operator/pekerjaan.php';
            </script>";
    } else {
        echo "<script>
                alert('Pilih Laporan Gagal!');
                document.location='../../page/operator/laporanharian.php';
            </script>";
    }
} else {
    echo "<script>
            alert('Parameter tidak lengkap!');
            document.location='../../page/operator/laporanharian.php';
        </script>";
}
?>
