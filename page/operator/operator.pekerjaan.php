<?php
    include "../../koneksi.php";
    include "../../public/layout/operator/header.operator.php";

    if (empty($_SESSION['id_laporan_harian'])) {
        // Ambil parameter id_laporan_harian dari URL
        if (isset($_GET['id_laporan_harian']) && isset($_GET['tanggal_laporan']) && isset($_GET['nomor'])) {
            $id_laporan_harian = $_GET['id_laporan_harian'];
            $tanggal_laporan = $_GET['tanggal_laporan'];
            $nomor = $_GET['nomor'];
    
            // Meynimpan ke dalam session
            $_SESSION['id_laporan_harian'] = $id_laporan_harian;
            $_SESSION['tanggal_laporan'] = $tanggal_laporan;
            $_SESSION['nomor'] = $nomor;
        }
    }

    $id_laporan_harian = $_SESSION['id_laporan_harian'];

    //mengambil nama master pekerjaan
    $m_pekerjaan = mysqli_query($conn, "SELECT ms.id_m_sub_pekerjaan, mp.nama_pekerjaan
                                            FROM m_pekerjaan AS mp
                                            JOIN m_sub_pekerjaan AS ms ON ms.id_m_pekerjaan  = mp.id_m_pekerjaan 
                                            JOIN pekerjaan_harian AS ph ON ph.id_m_sub_pekerjaan = ms.id_m_sub_pekerjaan
                                            WHERE ph.id_laporan_harian = '$id_laporan_harian'");
    $data_pekerjaan = mysqli_fetch_assoc($m_pekerjaan);
    $nama_pekerjaan = $data_pekerjaan['nama_pekerjaan']
?>
<?php
    // Mengambil data pekerjaan dari tabel pekerjaan harian
    $sub_pekerjaan = mysqli_query($conn, "SELECT ph.id_laporan_harian, ph.id_m_sub_pekerjaan, ms.nama_sub_pekerjaan
                                          FROM pekerjaan_harian AS ph
                                          JOIN m_sub_pekerjaan AS ms ON ph.id_m_sub_pekerjaan = ms.id_m_sub_pekerjaan
                                          JOIN laporan_harian AS lh ON lh.id_laporan_harian = ph.id_laporan_harian
                                          WHERE ph.id_laporan_harian = '$id_laporan_harian'
                                          AND ph.id_laporan_harian = '$id_laporan_harian' ");

    $nomor = 1;

    $id_sub = [];
    while ($data = mysqli_fetch_assoc($sub_pekerjaan)) {
        $id_sub[] = $data;
    }
?>

<style>
.nav-tabs {

    flex-wrap: nowrap;
    overflow-x: auto;
    white-space: nowrap;
}

.nav-tabs .nav-link {
    background-color: white;
    color: white;
    border-color: grey;
}

.nav-tabs .nav-link.active {
    background-color: grey;
    color: white;
}

.nav-tabs::-webkit-scrollbar { 
    display: none;  /* Safari and Chrome */
}

.nav-tabs .nav-link:not(.active) {
    color: black;
}

.nav-tabs .nav-link:not(.active):hover {
    background-color: grey;
    color: white;
}

</style>

<div class="container">
    <nav>
        <div class="nav nav-tabs mt-3   " id="nav-tab" role="tablist">
            <?php foreach ($id_sub as $index => $sub): ?>
                <button class="nav-link <?= $index === 0 ? 'active' : '' ?> " id="nav-<?= $sub['id_m_sub_pekerjaan'] ?>-tab" style="" data-bs-toggle="tab" data-bs-title="<?= $sub['nama_sub_pekerjaan'] ?>" data-bs-target="#nav-<?= $sub['id_m_sub_pekerjaan'] ?>" type="button" role="tab" aria-controls="nav-<?= $sub['id_m_sub_pekerjaan'] ?>" aria-selected="<?= $index === 0 ? 'true' : 'false' ?>">
                <?= $sub['nama_sub_pekerjaan'] ?>
                </button>
            <?php endforeach; ?>
        </div>
    </nav>
<div class="tab-content background-color-dark " id="nav-tabContent">
    <?php foreach ($id_sub as $index => $sub): ?>
        <div class="tab-pane fade <?= $index === 0 ? 'show active' : '' ?>" id="nav-<?= $sub['id_m_sub_pekerjaan'] ?>" role="tabpanel" aria-labelledby="nav-<?= $sub['id_m_sub_pekerjaan'] ?>-tab" tabindex="0">
            
        <!-- Add your content for each tab here -->
            <?php
                $id_sub_pekerjaan = $sub['id_m_sub_pekerjaan'];

                include "operator.modal/modalAdd.pekerjaanharian.php";
            ?>

         
            <h2 class="ms-5 mt-5">Sub : <?= $sub['nama_sub_pekerjaan'] ?></h2>

            <div class="container mt-3">
                <div class="card mt-3">
                    <h5 class="card-header">
                        Data Pekerja
                        <button type="button-center" class="btn btn-tambah" data-bs-toggle="modal" data-bs-target="#ph-pekerja-tambah-<?= $sub['id_m_sub_pekerjaan'] ?>"><i class='bx bx-plus-medical' style="margin-right: 5px;" name="lh_tambah"></i>
                        ADD
                        </button>
                    </h5>

                     <table class="table-thick-border">
                        <tr>
                            <th class="col-3">Nama</th>
                            <th>Jumlah</th>
                            <th class="kolom-aksi-pekerjaan col-2 text-center">Aksi</th>
                        </tr>
                        
                        <?php
                        //mengambil data pekerja dari database
                        $tampil_pekerja = mysqli_query($conn, "SELECT pj.id_pekerja, mpj.id_m_pekerja, mpj.jenis_pekerja, pj.jumlah_pekerja, ph.id_m_sub_pekerjaan
                                            FROM pekerja AS pj
                                            JOIN pekerjaan_harian AS ph ON pj.id_laporan_harian = ph.id_laporan_harian AND pj.id_m_sub_pekerjaan = ph.id_m_sub_pekerjaan
                                            JOIN m_pekerja AS mpj ON pj.id_m_pekerja = mpj.id_m_pekerja
                                            WHERE pj.id_laporan_harian = '$id_laporan_harian'
                                            AND pj.id_m_sub_pekerjaan = '$id_sub_pekerjaan'");
                        if (mysqli_num_rows($tampil_pekerja) > 0) {
                            while ($data_pekerja = mysqli_fetch_assoc($tampil_pekerja)) :
                        ?>

                        <tr>
                            <td class="text-center"><?= $data_pekerja['jenis_pekerja'] ?></td>
                            <td class="text-center"><?= $data_pekerja['jumlah_pekerja'] ?> Orang</td>
                            <td class="text-center">
                                <form action="../../script/projek_pilih.php" method="POST">
                                    <a href="#" class="btn btn-aksi" data-bs-toggle="modal" data-bs-target="#ph-pekerja-hapus-<?=$data_pekerja['id_pekerja']?>"><i class='bx bx-trash' ></i></a>
                                    <a href="#" class="btn btn-aksi" data-bs-toggle="modal" data-bs-target="#ph-pekerja-ubah-<?=$data_pekerja['id_pekerja']?>"><i class='bx bxs-edit-alt' ></i></a>
                                    <input type="hidden" name="id_laporan" value="<?=$data['id_laporan_harian']?>">
                                </form>
                            </td>
                        </tr>

                        <?php 
                        include "operator.modal/modalUD.pekerjaanharian.php"; 
                        endwhile; 
                        } else { 
                        ?>

                        <tr>
                            <td colspan="4" class="text-center">Tidak ada data Pekerja!.</td>
                        </tr>
                        <?php } ?>
                     </table>
                </div>

                <hr class="separator mt-5">

                <div class="card mt-5">
                    <h5 class="card-header">
                        Data Peralatan
                        <button type="button-center" class="btn btn-tambah" data-bs-toggle="modal" data-bs-target="#ph-peralatan-tambah-<?=$index?>"><i class='bx bx-plus-medical' style="margin-right: 5px;" name="lh_tambah"></i>
                        ADD
                        </button>
                    </h5>

                     <table class="table-thick-border ">
                        <tr>
                            <th class="col-3">Nama</th>
                            <th>Jumlah</th>
                            <th class="kolom-aksi-pekerjaan col-2">Aksi</th>
                        </tr>

                        <?php
                        //mengambil data pekerja dari database
                        $peralatan = mysqli_query($conn, "SELECT pl.id_peralatan,mp.id_m_peralatan, mp.nama_alat, pl.jumlah_peralatan, mp.satuan
                                                        FROM peralatan AS pl
                                                        JOIN m_peralatan AS mp ON pl.id_m_peralatan = mp.id_m_peralatan
                                                        JOIN pekerjaan_harian AS ph ON pl.id_laporan_harian = ph.id_laporan_harian AND pl.id_m_sub_pekerjaan = ph.id_m_sub_pekerjaan
                                                        WHERE pl.id_laporan_harian = '$id_laporan_harian'
                                                        AND pl.id_m_sub_pekerjaan = '$id_sub_pekerjaan'")
                                                        ;
                            if (mysqli_num_rows($peralatan) > 0) {
                        while ($data_peralatan = mysqli_fetch_assoc($peralatan)) :
                        ?>
                        
                        <tr>
                            <td class="text-center"><?= $data_peralatan['nama_alat'] ?></td>
                            <td class="text-center"><?= $data_peralatan['jumlah_peralatan'] ?> <?= $data_peralatan['satuan'] ?></td>
                            <td class="text-center">
                                <form action="../../script/projek_pilih.php" method="POST">
                                    <a href="#" class="btn btn-aksi" data-bs-toggle="modal" data-bs-target="#ph-peralatan-hapus-<?=$data_peralatan['id_peralatan']?>"><i class='bx bx-trash' ></i></a>
                                    <a href="#" class="btn btn-aksi" data-bs-toggle="modal" data-bs-target="#ph-peralatan-ubah-<?=$data_peralatan['id_peralatan']?>"><i class='bx bxs-edit-alt' ></i></a>
                                    <input type="hidden" name="id_peralatan" value="<?=$data_peralatan['id_peralatan']?>">
                                </form>
                            </td>
                        </tr>
                        <?php 
                            include "operator.modal/modalUD.pekerjaanharian.php"; 
                            endwhile; 
                            } else { 
                        ?>
                        <tr>
                            <td colspan="4" class="text-center">Tidak ada data Perlatan.</td>
                        </tr>
                        <?php } ?>
                     </table>
                </div>

                <hr class="separator mt-5">

                <div class="card mt-5">
                    <h5 class="card-header">
                        Data Bahan
                        <button type="button-center" class="btn btn-tambah" data-bs-toggle="modal" data-bs-target="#ph-bahan-tambah-<?=$index?>"><i class='bx bx-plus-medical' style="margin-right: 5px;" name="lh_tambah"></i>
                        ADD
                        </button>
                    </h5>

                     <table class="table-thick-border">
                        <tr>
                            <th class="col-3">Nama</th>
                            <th>Jumlah</th>
                            <th class="kolom-aksi-pekerjaan col-2">Aksi</th>
                        </tr>

                        <?php
                        //mengambil data pekerja dari database
                        $bahan = mysqli_query($conn, "SELECT bh.id_bahan, mb.id_m_bahan, mb.nama_bahan, bh.jumlah_bahan, mb.satuan
                                                        FROM bahan AS bh
                                                        JOIN m_bahan AS mb ON bh.id_m_bahan = mb.id_m_bahan
                                                        JOIN pekerjaan_harian AS ph ON bh.id_laporan_harian = ph.id_laporan_harian AND bh.id_m_sub_pekerjaan = ph.id_m_sub_pekerjaan
                                                        WHERE bh.id_laporan_harian = '$id_laporan_harian'
                                                        AND ph.id_m_sub_pekerjaan = '$id_sub_pekerjaan'");
                            if (mysqli_num_rows($bahan) > 0) {
                        while ($data_bahan = mysqli_fetch_assoc($bahan)) :
                        ?>
                        
                        <tr>
                            <td class="text-center"><?= $data_bahan['nama_bahan'] ?></td>
                            <td class="text-center"><?= $data_bahan['jumlah_bahan']?> <?= $data_bahan['satuan'] ?></td>
                            <td class="text-center">
                                <form action="../../script/projek_pilih.php" method="POST">
                                    <a href="#" class="btn btn-aksi" data-bs-toggle="modal" data-bs-target="#ph-bahan-hapus-<?=$data_bahan['id_bahan']?>"><i class='bx bx-trash' ></i></a>
                                    <a href="#" class="btn btn-aksi" data-bs-toggle="modal" data-bs-target="#ph-bahan-ubah-<?=$data_bahan['id_bahan']?>"><i class='bx bxs-edit-alt' ></i></a>
                                    <input type="hidden" name="id_laporan" value="<?=$data['id_laporan_harian']?>">
                                </form>
                            </td>
                        </tr>
                        <?php 
                        include "operator.modal/modalUD.pekerjaanharian.php";
                        endwhile; 
                         } else { 
                        ?>
                        <tr>
                            <td colspan="4" class="text-center">Tidak ada data Bahan.</td>
                        </tr>
                        <?php } ?>
                     </table>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<a href="pekerjaan.php" class="btn btn-kembali mt-2">
        <i class='bx bxs-chevrons-left'></i>Kembali
    </a>

</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        var activeTab = localStorage.getItem("activeTab");
        if (activeTab) {
            var tabButton = document.querySelector('#' + activeTab + '-tab');
            var tabPane = document.querySelector('#' + activeTab);

            if (tabButton && tabPane) {
                var currentlyActiveButton = document.querySelector('.nav-link.active');
                var currentlyActivePane = document.querySelector('.tab-pane.show.active');

                if (currentlyActiveButton) currentlyActiveButton.classList.remove('active');
                if (currentlyActivePane) currentlyActivePane.classList.remove('show', 'active');

                tabButton.classList.add('active');
                tabPane.classList.add('show', 'active');
            }
        }

        var tabs = document.querySelectorAll('.nav-link');
        tabs.forEach(function(tab) {
            tab.addEventListener('click', function() {
                localStorage.setItem('activeTab', this.getAttribute('data-bs-target').substring(1));
            });
        });
    });
</script>

<?php include "../../public/layout/footer.php"; ?>
