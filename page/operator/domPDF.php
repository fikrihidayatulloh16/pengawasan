<?php
require_once __DIR__ . '../../../vendor/autoload.php';
use Dompdf\Dompdf;
use Dompdf\Options;

// Ambil data yang diperlukan
include '../../koneksi.php';

$id_projek = $_GET['id_projek_op'];
$id_laporan_harian = $_GET['id_laporan_harian'];
$tanggal_laporan = $_GET['tanggal_laporan'];

ob_start();
include 'cetak_temp.php';
$html = ob_get_clean();

// Inisialisasi Dompdf
$options = new Options();
$options->set('isHtml5ParserEnabled', true);
$options->set('isRemoteEnabled', true); // Izinkan akses ke file remote seperti gambar
$dompdf = new Dompdf($options);

// Load HTML ke Dompdf
$dompdf->loadHtml($html);

// Set ukuran kertas ke A4 dan orientasi potrait
$dompdf->setPaper('A4', 'portrait');

// Render HTML ke PDF
$dompdf->render();

// Output PDF
$dompdf->stream("laporan_harian_" . $tanggal_laporan . ".pdf", ["Attachment" => false]);
exit(0);
