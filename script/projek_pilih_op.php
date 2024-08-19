<?php
include "../koneksi.php";
//memulai sesi
session_start();

    if (isset($_POST['projek_pilih_op'])){
        // Mengambil Data
        $pilih = $_POST['id_projek'];
        $nama = $_POST['nama_projek'];
        $tanggal_mulai = $_POST['tanggal_mulai'];
        $tanggal_selesai = $_POST['tanggal_selesai'];
        $tambahan_waktu = $_POST['tambahan_waktu'];

        $_SESSION['nama_projek_op'] = $nama;
        $_SESSION['id_projek_op'] = $pilih;
        $_SESSION['tanggal_mulai_op'] = $tanggal_mulai;
        $_SESSION['tanggal_selesai_op'] = $tanggal_selesai;
        $_SESSION['tambahan_waktu_op'] = $tambahan_waktu;


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