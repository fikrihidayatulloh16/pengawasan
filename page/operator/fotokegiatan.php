<?php
// Menghubungkan ke database
include "../../koneksi.php";
include "../../public/layout/operator/header.operator.php";

//mengambil nilai sesi
if (empty($_SESSION['id_laporan_harian'])) {
    if (isset($_GET['id_laporan_harian']) && isset($_GET['tanggal_laporan']) && isset($_GET['nomor'])) {
        $id_laporan_harian = $_GET['id_laporan_harian'];
        $tanggal_laporan = $_GET['tanggal_laporan'];
        $nomor = $_GET['nomor'];

        $_SESSION['id_laporan_harian'] = $id_laporan_harian;
        $_SESSION['tanggal_laporan'] = $tanggal_laporan;
        $_SESSION['nomor'] = $nomor;
    }
}


$id_laporan_harian = $_SESSION['id_laporan_harian'];
?>

<style>
        /* Custom CSS untuk menyesuaikan tabel */
        .table {
            border-color: #000; /* Warna garis tabel menjadi hitam */
        }
        .table th, .table td {
            padding: 1rem; /* Mengurangi padding agar jarak antar kolom lebih kecil */
        }
        .text-center {
            text-align: center; /* Mengatur teks di tengah untuk kelas text-center */
        }
</style>

<div style="background-color: #f0f0f0; padding: 10px; border-radius: 5px;">
    <button type="button-center" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#fk_tambah"><i class='bx bx-plus-medical' style="margin-right: 5px;"></i>Tambah</button>
    <a href="laporanharian.php" class="btn btn-secondary align-item-right">
        <i class='bx bx-arrow-back' style="margin-right: 5px;"></i>Kembali
    </a>
</div>

<?php include 'operator.modal/modalAdd_fotokegiatan.php' ?>


<div class="container mt-3">
    
    <div class="card mt-3">
        <h5 class="card-header bg-primary text-white">Data Foto Kegiatan</h5>
        <table class="table table-striped table-bordered table-thick-border">
            <tr>
                <th class="col-1">No.</th>
                <th>Foto</th>
                <th class="col-3">Keterangan</th>
                <th class="col-2">Aksi</th>
            </tr>
            <?php
                $tampil = mysqli_query($conn, "SELECT fk.id_foto_kegiatan, fk.id_laporan_harian , fk.foto, fk.keterangan
                                               FROM foto_kegiatan AS fk
                                               JOIN laporan_harian AS lh ON lh.id_laporan_harian = fk.id_laporan_harian
                                               WHERE fk.id_laporan_harian = '$id_laporan_harian'
                                               AND lh.id_laporan_harian = '$id_laporan_harian'
                                               ORDER BY fk.id_laporan_harian ASC");
                $nomor = 1;

                if (mysqli_num_rows($tampil) > 0) {
                    while ($data = mysqli_fetch_array($tampil)) : 
            ?>
            <tr>
                <td class="text-center"><?= $nomor ?></td>
                <td class="text-center"><img src="uploads/<?= $data['foto'] ?>" alt="Foto Kegiatan"></td>
                <td class="text-center"><?= $data['keterangan'] ?></td>
                <td class="text-center">
                    <form action="../../script/operator_crud.php" method="POST">
                        <a href="#" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#foto_hapus<?= $data['id_foto_kegiatan'] ?>">
                            <i class='bx bxs-trash-alt'></i> Hapus
                        </a>
                        <a href="#" class="btn btn-warning text-dark" data-bs-toggle="modal" data-bs-target="#foto_ubah<?= $data['id_foto_kegiatan'] ?>">
                            <i class='bx bxs-edit-alt'></i> Ubah
                        </a>
                        <input type="hidden" name="id_laporan_harian" value="<?= $data['id_laporan_harian'] ?>">
                    </form>
                </td>
            </tr>
            <?php 
                $nomor++; 
                include "operator.modal/modalUD.permasalahan.php";
                endwhile;
                } else { 
            ?>
            <tr>
                <td colspan="4" class="text-center">Tidak ada data Foto Kegiatan.</td>
            </tr>
            <?php } ?>
        </table>
    </div>
</div>

<?php
    include "../../public/layout/operator/footer.operator.php";
?>