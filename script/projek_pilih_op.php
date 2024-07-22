<?php
$servername = "localhost";
$username = "root"; // username default XAMPP
$password = ""; // password default XAMPP
$dbname = "pengawasan"; // ganti ini dengan nama database kamu

// Buat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

//memulai sesi
session_start();

    if (isset($_POST['projek_pilih_op'])){
        // Mengambil Data
        $pilih = $_POST['id_projek'];
        $nama = $_POST['nama_projek'];

        $_SESSION['nama_projek_op'] = $nama;
        $_SESSION['id_projek_op'] = $pilih;

        if ($pilih && $nama) {
            echo "<script>
                    alert('Projek Berhasil Dipilih');
                    document.location='../page/operator/laporanharian.php';
                </script>";
        } else {
            echo "<script>
                    alert('pilih projek Gagal!');
                    document.location='../page/admin/m_pekerjaan.php';
                </script>";
        }
    }
?>