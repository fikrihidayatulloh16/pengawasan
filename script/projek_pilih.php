<?php
include "../koneksi.php";

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
                    sessionStorage.setItem('navigated', 'true');
                    window.location.href = '../page/admin/m_pekerjaan.php?message=Projek Berhasil Dipilih';
                  </script>";
        } else {
            echo "<script>
                    showSuccessAlert('Pilih Projek Gagal!');
                    setTimeout(function() {
                        window.location.href = '../page/admin/m_pekerjaan.php';
                    }, 3500);
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