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

    if (isset($_POST['projek_pilih'])){
        // Mengambil Data
        $pilih = $_POST['id_projek'];
        $nama = $_POST['nama_projek'];

        $_SESSION['nama_projek'] = $nama;
        $_SESSION['id_projek'] = $pilih;

        if ($pilih && $nama) {
            echo "<script>
                    alert('Projek Berhasil Dipilih');
                    document.location='../page/admin/m_pekerjaan.php';
                </script>";
        } else {
            echo "<script>
                    alert('pilih projek Gagal!');
                    document.location='../page/admin/m_pekerjaan.php';
                </script>";
        }
    }

    // Contoh validasi login sederhana
$username = $_POST['username'];
$password = $_POST['password'];

// Gantilah ini dengan validasi sebenarnya dari database
if ($username === 'user' && $password === 'pass') {
    $_SESSION['username'] = $username;
    header("Location: dashboard.php");
    exit();
} else {
    echo "Login gagal. Username atau password salah.";
}

?>