<?php
    include "../../koneksi.php";
    include "../../public/layout/operator/header.operator.php";

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

    $m_pekerjaan = mysqli_query($conn, "SELECT ms.id_m_sub_pekerjaan, mp.nama_pekerjaan
                                        FROM m_pekerjaan AS mp
                                        JOIN m_sub_pekerjaan AS ms ON ms.id_m_pekerjaan = mp.id_m_pekerjaan 
                                        JOIN pekerjaan_harian AS ph ON ph.id_m_sub_pekerjaan = ms.id_m_sub_pekerjaan
                                        WHERE ph.id_laporan_harian = '$id_laporan_harian'");
    $data_pekerjaan = mysqli_fetch_assoc($m_pekerjaan);
    $nama_pekerjaan = $data_pekerjaan['nama_pekerjaan'];
?>
<style>
    .table-thick-border {
        border: 1px solid #000 !important;
    }
    .table-thick-border th, .table-thick-border td {
        border: 1px solid #000 !important;
    }
    th {
        text-align: center;
    }
</style>

<div style="background-color: #f0f0f0; padding: 10px; border-radius: 5px;">
    <h3 class="text-center">Laporan Harian ke-<?= $_SESSION['nomor'] ?></h3>
    <h4 class="text-center">Projek: <?= $_SESSION['nama_projek_op'] ?></h4>
    <h4 class="text-center">Tanggal: <?= $_SESSION['tanggal_laporan'] ?></h4>
    <h4 class="text-center"><?= $nama_pekerjaan ?></h4>
    <button type="button" class="btn btn-success ms-5" data-bs-toggle="modal" data-bs-target="#masalah_tambah">
        <i class='bx bx-plus-medical' style="margin-right: 5px;"></i>Tambah
    </button>
    <a href="laporanharian.php" class="btn btn-secondary align-item-right">
        <i class='bx bx-arrow-back' style="margin-right: 5px;"></i>Kembali
    </a>
</div>
    
<?php include 'operator.modal/modalAdd.permasalahan.php'; ?>

<div class="container mt-3">
    
    <div class="card mt-3">
        <h5 class="card-header bg-primary text-white">Data Tim Pengawas</h5>
        <table class="table table-striped table-bordered table-thick-border">
            <tr>
                <th>No.</th>
                <th>Tim Pengawas</th>
                <th>Saran</th>
                <th class="col-2">Aksi</th>
            </tr>
            <?php
                $tampil = mysqli_query($conn, "SELECT ps.id_permasalahan, ps.id_laporan_harian, ps.permasalahan, ps.saran
                                               FROM permasalahan AS ps
                                               JOIN laporan_harian AS lh ON lh.id_laporan_harian = ps.id_laporan_harian
                                               WHERE ps.id_laporan_harian = '$id_laporan_harian'
                                               AND lh.id_laporan_harian = '$id_laporan_harian'
                                               ORDER BY ps.id_laporan_harian ASC");
                $nomor_masalah = 1;

                if (mysqli_num_rows($tampil) > 0) {
                    while ($data = mysqli_fetch_array($tampil)) : 
            ?>
            <tr>
                <td class="text-center"><?= $nomor_masalah ?></td>
                <td class="text-center"><?= $data['permasalahan'] ?></td>
                <td class="text-center"><?= $data['saran'] ?></td>
                <td class="text-center">
                    <form action="../../script/projek_pilih.php" method="POST">
                        <a href="#" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalHapus<?= $data['id_permasalahan'] ?>">
                            <i class='bx bxs-trash-alt'></i> Hapus
                        </a>
                        <a href="#" class="btn btn-warning text-dark" data-bs-toggle="modal" data-bs-target="#modalUbah<?= $data['id_permasalahan'] ?>">
                            <i class='bx bxs-edit-alt'></i> Ubah
                        </a>
                        <input type="hidden" name="id_laporan" value="<?= $data['id_laporan_harian'] ?>">
                    </form>
                </td>
            </tr>
            <?php 
                $nomor_masalah++; 
                include "operator.modal/modalUD.permasalahan.php";
                endwhile;
                } else { 
            ?>
            <tr>
                <td colspan="4" class="text-center">Tidak ada data permasalahan.</td>
            </tr>
            <?php } ?>
        </table>
    </div>
</div>

<?php
    include "../../public/layout/operator/footer.operator.php";
?>
