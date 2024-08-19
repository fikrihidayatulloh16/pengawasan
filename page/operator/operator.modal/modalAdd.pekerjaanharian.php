<?php
include "../../koneksi.php";
$id_projek = $_SESSION['id_projek_op'];
?>

<!-- Tambah Modal Pekerja-->
<div class="modal fade" id="ph-pekerja-tambah-<?= $sub['id_m_sub_pekerjaan'] ?>" tabindex="-1" aria-labelledby="ph-pekerja-tambah-label-<?=$index?>" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-secondary text-white">
                <h5 class="modal-title" id="ph-pekerja-tambah-label-<?=$index?>">Tambah Data Pekerja</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="../../script/operator_crud.php" method="POST">
                <div class="modal-body">
                    <div class="container-fluid px-4">
                        <div class="mb-3">
                            <label class="form-label">Projek:</label>
                            <p class="mb-0"><?= $_SESSION['nama_projek_op']?></p>
                            <p class="mb-0"><?= $_SESSION['id_projek_op']?></p>
                        </div>
                        <div class="mb-3">
                            <label for="dropdown-pekerja" class="form-label">Pekerja:</label>
                            <select id="dropdown-pekerja" name="id_m_pekerja" class="form-select" aria-label="Pilih Pekerja" required>
                                <option value="" disabled selected>Pilih Pekerja</option>
                                <?php
                                // Ambil ID yang sudah dipilih sebelumnya
                                $selected_pekerja = []; // Array untuk menyimpan ID yang sudah dipilih

                                $pekerja_selected = mysqli_query($conn, "SELECT id_m_pekerja FROM pekerja WHERE id_laporan_harian = '$id_laporan_harian' AND id_m_sub_pekerjaan = '$id_sub_pekerjaan'");
                                while ($row = mysqli_fetch_assoc($pekerja_selected)) {
                                    $selected_pekerja[] = $row['id_m_pekerja'];
                                }

                                // Ambil semua pekerja untuk ditampilkan di dropdown
                                $ph_pekerja = mysqli_query($conn, "SELECT mp.id_m_pekerja, mp.jenis_pekerja 
                                                                FROM m_pekerja AS mp
                                                                WHERE mp.id_projek = '$id_projek'
                                                                ORDER BY mp.id_m_pekerja ASC");

                                while ($data_pk = mysqli_fetch_array($ph_pekerja)) : 
                                    $id_pekerja = $data_pk['id_m_pekerja'];
                                    $jenis_pekerja = $data_pk['jenis_pekerja'];

                                    // Cek apakah pekerja sudah dipilih sebelumnya
                                    $disabled = in_array($id_pekerja, $selected_pekerja) ? 'disabled' : '';
                                    $text = in_array($id_pekerja, $selected_pekerja) ? '<?= $jenis_pekerja ?> (sudah dipilih)' : '';
                                ?>
                                    <option value="<?= $id_pekerja ?>" <?= $disabled ?>> <?= $jenis_pekerja ?> - Orang <?= $text ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="jumlah-pekerja" class="form-label">Jumlah:</label>
                            <input class="form-control" type="number" id="jumlah-pekerja" name="jumlah_pekerja" placeholder="Masukkan jumlah" required>
                        </div>
                        <input type="hidden" name="id_laporan_harian" value="<?= $id_laporan_harian?>">
                        <input type="hidden" name="id_sub_pekerjaan" value="<?= $id_sub_pekerjaan?>">
                    </div>
                </div>
                <div class="modal-footer bg-secondary">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success" name="ph-pekerja-simpan">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Tambah Modal Peralatan-->
<div class="modal fade" id="ph-peralatan-tambah-<?= $index ?>" tabindex="-1" aria-labelledby="ph-peralatan-tambah-label-<?= $index ?>" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-secondary text-white">
                <h5 class="modal-title" id="ph-peralatan-tambah-label-<?= $index ?>">Tambah Data Peralatan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="../../script/operator_crud.php" method="POST">
                <div class="modal-body">
                    <div class="container-fluid px-4">
                        <div class="mb-3">
                            <label class="form-label">Projek:</label>
                            <p class="mb-0"><?= $_SESSION['nama_projek_op']?></p>
                            <p class="mb-0"><?= $_SESSION['id_projek_op']?></p>
                        </div>
                        <div class="mb-3">
                            <label for="dropdown-peralatan" class="form-label">Nama Peralatan:</label>
                            <select id="dropdown-peralatan" name="id_m_peralatan" class="form-select" aria-label="Pilih Peralatan" required>
                                <option value="" disabled selected>Pilih Peralatan</option>
                                <?php
                                // Ambil ID yang sudah dipilih sebelumnya
                                $selected_peralatan = []; // Array untuk menyimpan ID yang sudah dipilih

                                $peralatan_selected = mysqli_query($conn, "SELECT id_m_peralatan FROM peralatan WHERE id_laporan_harian = '$id_laporan_harian' AND id_m_sub_pekerjaan = '$id_sub_pekerjaan'");
                                while ($row = mysqli_fetch_assoc($peralatan_selected)) {
                                    $selected_peralatan[] = $row['id_m_peralatan'];
                                }
                                $ph_peralatan = mysqli_query($conn, "SELECT mp.id_m_peralatan, mp.nama_alat, mp.satuan 
                                                                    FROM laporan_harian AS lh
                                                                    JOIN m_projek AS pj ON lh.id_projek = pj.id_projek
                                                                    JOIN m_peralatan AS mp ON mp.id_projek = pj.id_projek
                                                                    WHERE lh.id_projek = '$id_projek'  
                                                                    AND pj.id_projek = '$id_projek'
                                                                    AND lh.id_laporan_harian = '$id_laporan_harian'
                                                                    ORDER BY id_m_peralatan ASC");
                                while ($data_pk = mysqli_fetch_array($ph_peralatan)) : 
                                    $id_m_peralatan = $data_pk['id_m_peralatan'];
                                    $nama_alat = $data_pk['nama_alat'];

                                    // Cek apakah pekerja sudah dipilih sebelumnya
                                    $disabled = in_array($id_m_peralatan, $selected_peralatan) ? 'disabled' : '';
                                    $text = in_array($id_m_peralatan, $selected_peralatan) ? '<?= $nama_alat ?> (sudah dipilih)' : '';
                                ?>
                                    <option value="<?= $data_pk['id_m_peralatan']?>" <?= $disabled ?>><?= $data_pk['nama_alat'] ?> - <?= $data_pk['satuan'] ?> <?= $text ?> </option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="jumlah-peralatan" class="form-label">Jumlah:</label>
                            <input class="form-control" type="number" id="jumlah-peralatan" name="jumlah_peralatan" placeholder="Masukkan Jumlah" required>
                        </div>
                        <input type="hidden" name="id_laporan_harian" value="<?= $id_laporan_harian?>">
                        <input type="hidden" name="id_sub_pekerjaan" value="<?= $id_sub_pekerjaan?>">
                    </div>
                </div>
                <div class="modal-footer bg-secondary">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success" name="ph-peralatan-simpan">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Tambah Modal Bahan-->
<div class="modal fade" id="ph-bahan-tambah-<?= $index ?>" tabindex="-1" aria-labelledby="ph-bahan-tambah-label-<?= $index ?>" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-secondary text-white">
                <h5 class="modal-title" id="ph-bahan-tambah-label-<?= $index ?>">Tambah Data Bahan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="../../script/operator_crud.php" method="POST">
                <div class="modal-body">
                    <div class="container-fluid px-4">
                        <div class="mb-3">
                            <label for="dropdown-bahan" class="form-label">Nama Bahan:</label>
                            <select id="dropdown-bahan" name="id_m_bahan" class="form-select" aria-label="Pilih Bahan" required>
                                <option value="" disabled selected>Pilih Bahan</option>
                                <?php
                                // Ambil ID yang sudah dipilih sebelumnya
                                $selected_bahan = []; // Array untuk menyimpan ID yang sudah dipilih

                                $bahan_selected = mysqli_query($conn, "SELECT id_m_bahan FROM bahan WHERE id_laporan_harian = '$id_laporan_harian' AND id_m_sub_pekerjaan = '$id_sub_pekerjaan'");
                                while ($row = mysqli_fetch_assoc($bahan_selected)) {
                                    $selected_bahan[] = $row['id_m_bahan'];
                                }

                                $ph_bahan = mysqli_query($conn, "SELECT lh.id_laporan_harian, lh.id_projek, mb.id_m_bahan, mb.nama_bahan, mb.satuan 
                                                                    FROM laporan_harian AS lh
                                                                    JOIN m_projek AS pj ON lh.id_projek = pj.id_projek
                                                                    JOIN m_bahan AS mb ON mb.id_projek = pj.id_projek
                                                                    WHERE lh.id_projek = '$id_projek'  
                                                                    AND pj.id_projek = '$id_projek'
                                                                    AND lh.id_laporan_harian = '$id_laporan_harian'
                                                                    ORDER BY id_m_bahan ASC");
                                while ($data_bh = mysqli_fetch_array($ph_bahan)) : 
                                    $id_m_bahan = $data_bh['id_m_bahan'];
                                    $nama_bahan = $data_bh['nama_bahan'];

                                    // Cek apakah pekerja sudah dipilih sebelumnya
                                    $disabled = in_array($id_m_bahan, $selected_bahan) ? 'disabled' : '';
                                    $text = in_array($id_m_bahan, $selected_bahan) ? '<?= $nama_bahan ?> (sudah dipilih)' : '';
                                ?>
                                    <option value="<?= $data_bh['id_m_bahan'] ?>" <?= $disabled ?>><?= $data_bh['nama_bahan'] ?> - <?= $data_bh['satuan'] ?> <?= $text ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="jumlah-bahan" class="form-label">Jumlah:</label>
                            <input class="form-control" type="number" id="jumlah-bahan" name="jumlah_bahan" placeholder="Masukkan Jumlah" required>
                        </div>
                        <input type="hidden" name="id_laporan_harian" value="<?= $id_laporan_harian?>">
                        <input type="hidden" name="id_sub_pekerjaan" value="<?= $id_sub_pekerjaan?>">
                    </div>
                </div>
                <div class="modal-footer bg-secondary">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success" name="ph-bahan-simpan">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
