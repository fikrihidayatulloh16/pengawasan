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

    if (isset($_POST['pekerjaan_pilih'])){
        // Mengambil Data
        $pilih = $_POST['id_m_pekerjaan'];
        $nama = $_POST['nama_pekerjaan'];

        $_SESSION['id_m_pekerjaan'] = $pilih;
        $_SESSION['nama_pekerjaan'] = $nama;

        if ($pilih && $nama) {
            echo "<script>
                    document.location='../page/admin/m_sub_pekerjaan.php';
                </script>";
        } else {
            echo "<script>
                    alert('pilih projek Gagal!');
                    document.location='../page/admin/m_pekerjaan.php';
                </script>";
        }
    }
?>