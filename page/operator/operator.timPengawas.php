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
    
<?php include 'operator.modal/modalAdd.timPengawas.php'; ?>

<div class="container mt-3">
    <a href="pekerjaan.php" class="btn btn-secondary align-item-right ms-3 mt-3">
        <i class='bx bx-arrow-back' style="margin-right: 5px;"></i> Kembali
    </a>

    <button type="button-center" class="btn btn-success ms-3 mt-3" data-bs-toggle="modal" data-bs-target="#pengawas_tambah">
        <i class='bx bx-plus-medical' style="margin-right: 5px;" name="pengawas_tambah"></i> Tambah
    </button>
    
    <div class="card mt-3">
        <h5 class="card-header bg-primary text-white">Data Tim Pengawas</h5>
        <table class="table table-striped table-bordered table-thick-border">
            <tr>
                <th>Tim Pengawas</th>
                <th>Tim Leader</th>
                <th class="col-2">Aksi</th>
            </tr>
            <?php
                $tampil = mysqli_query($conn, "SELECT tp.id_tim_pengawas, tp.tim_pengawas , tp.tim_leader
                                               FROM tim_pengawas AS tp
                                               JOIN m_projek AS mp ON mp.id_projek = tp.id_projek
                                               WHERE tp.id_projek = '$id_projek'
                                               ORDER BY tp.id_projek ASC");
                $nomor_masalah = 1;

                if (mysqli_num_rows($tampil) > 0) {
                    while ($data = mysqli_fetch_array($tampil)) : 
            ?>
            <tr>
                <td class="text-center"><?= $data['tim_pengawas'] ?></td>
                <td class="text-center"><?= $data['tim_leader'] ?></td>
                <td class="text-center">
                    <form action="../../script/projek_pilih.php" method="POST">
                        <a href="#" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalHapus<?= $data['id_tim_pengawas'] ?>">
                            <i class='bx bxs-trash-alt'></i> Hapus
                        </a>
                        <a href="#" class="btn btn-warning text-dark" data-bs-toggle="modal" data-bs-target="#modalUbah<?= $data['id_tim_pengawas'] ?>">
                            <i class='bx bxs-edit-alt'></i> Ubah
                        </a>
                        <input type="hidden" name="id_laporan" value="<?= $data['id_tim_pengawas'] ?>">
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
                <td colspan="4" class="text-center">Tidak ada data Tim Pengawas .</td>
            </tr>
            <?php } ?>
        </table>
    </div>
</div>

<?php
    include "../../public/layout/operator/footer.operator.php";
?>
