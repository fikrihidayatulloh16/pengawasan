<?php
include "../koneksi.php";
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
                    sessionStorage.setItem('navigated', 'true');
                    window.location.href = '../page/operator/laporanharian.php?message=Projek Berhasil Dipilih';
                  </script>";
        } else {
            echo "<script>
                    window.location.href = '../page/operator/laporanharian.php?message=Pilih Projek Gagal!';
                  </script>";
        }
    }
?>