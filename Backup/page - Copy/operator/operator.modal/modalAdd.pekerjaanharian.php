<?php
include "../../koneksi.php";
$id_projek = $_SESSION['id_projek_op'];
?>

<style>
    .hidden {
        display: none;
    }
</style>

<!-- Tambah Modal Pekerja-->
<div class="modal fade" id="ph-pekerja-tambah-<?=$index?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Data Pekerja</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="../../script/operator_crud.php" method="POST">
                <div class="modal-body">
                    <div class="mb-3">
                        <div class="container-fluid px-4">
                            <div class="form-group">
                                <label for="id_projek">Projek:</label>
                                <h5><?= $_SESSION['nama_projek_op']?></h5>
                                <h5><?= $_SESSION['id_projek_op']?></h5>
                            </div>
                            <br>

                            <div class="form-group">
                                <label for="pekerjaan">Pekerja :</label>
                                <select id="dropdown-pekerja" name="id_m_pekerja" class="form-select" aria-label="Pilih Pekerja">
                                    <option value="" disabled selected>Pilih Pekerja</option>
                                    <?php
                                    // Menampilkan data pekerjaan berdasarkan projek
                                    $ph_pekerja = mysqli_query($conn, "SELECT lh.id_laporan_harian, lh.id_projek, mp.id_m_pekerja, mp.jenis_pekerja 
                                                                        FROM laporan_harian AS lh
                                                                        JOIN m_projek AS pj ON lh.id_projek = pj.id_projek
                                                                        JOIN m_pekerja AS mp ON mp.id_projek = pj.id_projek
                                                                        WHERE lh.id_projek = '$id_projek'  
                                                                        AND pj.id_projek = '$id_projek'
                                                                        AND lh.id_laporan_harian = '$id_laporan_harian'
                                                                        ORDER BY id_m_pekerja ASC");
                                    while ($data_pk = mysqli_fetch_array($ph_pekerja)) : 
                                    ?>
                                        <option class="dropdown-item" value="<?= $data_pk['id_m_pekerja'] ?>"><?= $data_pk['jenis_pekerja'] ?></option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                            <br>
                            <div class="form-group">
                                <label for="id_projek">Jumlah :</label>
                                <input class="form-control type="number" name="jumlah_pekerja" placeholder="Masukkan jumlah ">
                            </div>
                            
                             <!-- input tambahan yang diperlukan -->
                            <div class="form-group">
                                <input type="hidden" name="id_laporan_harian" value="<?= $id_laporan_harian?>">
                                <input type="hidden" name="id_sub_pekerjaan" value="<?= $id_sub_pekerjaan?>">
                                
                            </div>
                        
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary" name="ph-pekerja-simpan">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Tambah Modal Peralatan-->
<div class="modal fade" id="ph-peralatan-tambah-<?= $index ?>" tabindex="-1" aria-labelledby="ph-pekerja-tambah-label-<?= $index ?>" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ph-peralatan-tambah-label-<?= $index ?>">Tambah Data Peralatan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Add your form fields here -->
                <form action="../../script/operator_crud.php" method="POST">
                    <div class="mb-3">
                        <label for="jumlah-pekerja-<?= $index ?>" class="form-label">Projek</label>
                            <h5><?= $_SESSION['nama_projek_op']?></h5>
                            <h5><?= $_SESSION['id_projek_op']?></h5>
                    </div>
                    <div class="mb-3">
                        <label for="nama-pekerja-<?= $index ?>" class="form-label">Nama Peralatan</label>
                        <select id="dropdown-peralatan" name="id_m_peralatan" class="form-select" aria-label="Pilih Peralatan">
                            <option value="" disabled selected>Pilih Peralatan</option>
                                        <?php
                                        // Menampilkan data pekerjaan berdasarkan projek
                                        $ph_peralatan = mysqli_query($conn, "SELECT lh.id_laporan_harian, lh.id_projek, mp.id_m_peralatan, mp.nama_alat, mp.satuan 
                                                                            FROM laporan_harian AS lh
                                                                            JOIN m_projek AS pj ON lh.id_projek = pj.id_projek
                                                                            JOIN m_peralatan AS mp ON mp.id_projek = pj.id_projek
                                                                            WHERE lh.id_projek = '$id_projek'  
                                                                            AND pj.id_projek = '$id_projek'
                                                                            AND lh.id_laporan_harian = '$id_laporan_harian'
                                                                            ORDER BY id_m_peralatan ASC");
                                        while ($data_pk = mysqli_fetch_array($ph_peralatan)) : 

                                        ?>

                                            <option class="dropdown-item" value="<?= $data_pk['id_m_peralatan'] ?>"><?= $data_pk['nama_alat'] ?> - <?= $data_pk['satuan'] ?></option>
                                        <?php endwhile; ?>
                                </select>
                    </div>
                    <div class="mb-3">
                        <label for="jumlah-pekerja-<?= $index ?>" class="form-label">Jumlah</label>
                        <input class="form-control type="number"  id="jumlah-peralatan-<?= $index ?>" name="jumlah_peralatan" placeholder="Masukkan Jumlah">
                    </div>

                    <!-- input tambahan yang diperlukan -->
                    <div class="form-group">
                        <input type="hidden" name="id_laporan_harian" value="<?= $id_laporan_harian?>">
                        <input type="hidden" name="id_sub_pekerjaan" value="<?= $id_sub_pekerjaan?>">
                                
                    </div>
                    <!-- Add more form fields as needed -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" name="ph-peralatan-simpan">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Tambah Modal Bahan-->
<div class="modal fade" id="ph-bahan-tambah-<?= $index ?>" tabindex="-1" aria-labelledby="ph-pekerja-tambah-label-<?= $index ?>" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ph-bahan-tambah-label-<?= $index ?>">Tambah Data Bahan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Add your form fields here -->
                <form action="../../script/operator_crud.php" method="POST">
                    <div class="mb-3">
                        <label for="nama-pekerja-<?= $index ?>" class="form-label">Nama Bahan</label>
                        <select id="dropdown-pekerja" name="id_m_bahan" class="form-select" aria-label="Pilih Bahan">
                            <option value="" disabled selected>Pilih Bahan</option>
                            <?php
                                // Menampilkan data pekerjaan berdasarkan projek
                                $ph_bahan = mysqli_query($conn, "SELECT lh.id_laporan_harian, lh.id_projek, mb.id_m_bahan, mb.nama_bahan, mb.satuan 
                                                                        FROM laporan_harian AS lh
                                                                        JOIN m_projek AS pj ON lh.id_projek = pj.id_projek
                                                                        JOIN m_bahan AS mb ON mb.id_projek = pj.id_projek
                                                                        WHERE lh.id_projek = '$id_projek'  
                                                                        AND pj.id_projek = '$id_projek'
                                                                        AND lh.id_laporan_harian = '$id_laporan_harian'
                                                                        ORDER BY id_m_bahan ASC");
                                                                        
                                while ($data_bh = mysqli_fetch_array($ph_bahan)) : 
                            ?>

                                            <option class="dropdown-item" value="<?= $data_bh['id_m_bahan'] ?>"><?= $data_bh['nama_bahan'] ?> - <?= $data_bh['satuan'] ?></option>
                                        <?php endwhile; ?>
                                </select>
                    </div>
                    <div class="mb-3">
                        <label for="jumlah-pekerja-<?= $index ?>" class="form-label">Jumlah</label>
                        <input class="form-control" type="number" id="jumlah-bahan-<?= $index ?>" name="jumlah_bahan" placeholder="Masukkan Jumlah">
                    </div>
                    <!-- input tambahan yang diperlukan -->
                    <div class="form-group">
                        <input type="hidden" name="id_laporan_harian" value="<?= $id_laporan_harian?>">
                        <input type="hidden" name="id_sub_pekerjaan" value="<?= $id_sub_pekerjaan?>">
                                
                    </div>
                    <!-- Add more form fields as needed -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" name="ph-bahan-simpan">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
