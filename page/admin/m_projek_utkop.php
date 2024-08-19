<?php
    include "../../koneksi.php";
    include "../../public/layout/admin/header_projek.php";
?>

<body>
    <h1 class="text-center">(temp)Data Master Projek untuk operator</h1>
        
        <!-- Modal Tambah Proyek -->
        <!-- Modal formProjek -->
        <div class="modal fade" id="formProjek" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="exampleModalLabel">Tambah Proyek</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="form_tambah" action="../../script/insert.php" method="POST">
                        <div class="modal-body">
                            <div class="mb-3">
                                <?php 
                                // Ambil nilai terakhir id_m_pekerja dari database
                                $sql_get_last_id = "SELECT MAX(id_projek) AS last_id FROM m_projek";
                                $result = $conn->query($sql_get_last_id);
                                $row = $result->fetch_assoc();
                                $last_id = $row['last_id'];

                                // Menghasilkan id_m_pekerja baru dengan format PJM001, PJM002, ...
                                if ($last_id) {
                                    $num = intval(substr($last_id, 3)) + 1;
                                } else {
                                    $num = 1;
                                }
                                $new_id_m_projek = 'PRJ' . str_pad($num, 3, '0', STR_PAD_LEFT); //str_pad($num, 3, '0', STR_PAD_LEFT); <-- untuk 5 karakter contoh PJM001
                                ?>
                                <label for="nama_projek" class="form-label">ID(tidak bisa diubah)</label>
                                <h5 for="id_m_pekerjaan" class="form-label"><?=$new_id_m_projek?></h5>
                                <label for="nama_projek" class="form-label">Nama Proyek</label>
                                <input type="text" class="form-control" id="nama_projek" name="nama_projek" required>
                            </div>
                            <div class="mb-3">
                                <label for="tanggal_mulai_tambah" class="form-label">Tanggal Mulai</label>
                                <input type="date" class="form-control" id="tanggal_mulai_tambah" name="tanggal_mulai_tambah" required>
                                <small id="tanggalMulaiError_tambah" class="form-text text-danger" style="display:none;">Tanggal mulai tidak boleh lebih awal dari hari ini.</small>
                            </div>
                            <div class="mb-3">
                                <label for="tanggal_selesai" class="form-label">Tanggal Selesai</label>
                                <input type="date" class="form-control" id="tanggal_selesai_tambah" name="tanggal_selesai_tambah" required>
                                <small id="tanggalSelesaiError_tambah" class="form-text text-danger" style="display:none;">Tanggal selesai tidak boleh kurang dari tanggal mulai.</small>
                            </div>
                            <div class="mb-3">
                                <label for="pemilik_pekerjaan" class="form-label">Pemilik Pekerjaan</label>
                                <input type="text" class="form-control" id="pemilik_pekerjaan" name="pemilik_pekerjaan" required>
                            </div>
                            <div class="mb-3">
                                <label for="pengawas" class="form-label">Pengawas</label>
                                <input type="text" class="form-control" id="pengawas" name="pengawas" required>
                            </div>
                            <div class="mb-3">
                                <label for="kontraktor" class="form-label">Kontraktor</label>
                                <input type="text" class="form-control" id="kontraktor" name="kontraktor" required>
                            </div>
                            <div class="mb-3">
                                <label for="tambahan_waktu_tambah" class="form-label">Tambahan Waktu</label>
                                <input type="date" class="form-control" id="tambahan_waktu_tambah" name="tambahan_waktu_tambah">
                                <small id="tanggalTambahanError_tambah" class="form-text text-danger" style="display:none;">Tanggal Tambahan tidak boleh kurang dari tanggal selesai!.</small>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary" name="projek_simpan">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <div class="container mt-3">

                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#formProjek"><i class='bx bx-plus-medical' width='500px' name="btambah"></i> Tambah</button>

            <div class="card">
                <h5 class="card-header bg-primary text-white">Data Master Projek</h5>

                    <table>
                    <tr>
                        <th>ID</th>
                        <th>Nama Proyek	</th>
                        <th>Tanggal Mulai</th>
                        <th>Tanggal Selesai</th>
                        <th>Pemilik Pekerjaan</th>
                        <th>Pengawas</th>
                        <th>Kontraktor</th>
                        <th>Tambahan Waktu</th>
                        <th class="col-3">Aksi</th>
                    </tr>
                        <?php
                            //menampilkan data
                            $tampil = mysqli_query($conn, "SELECT * FROM m_projek ORDER BY id_projek ASC");
                            while ($data = mysqli_fetch_array($tampil)) : 
                        ?>
                                <tr>
                                    <td><?= $data['id_projek']?></td>
                                    <td><?= $data['nama_projek']?></td>
                                    <td><?= $data['tanggal_mulai']?></td>
                                    <td><?= $data['tanggal_selesai']?></td>
                                    <td><?= $data['pemilik_pekerjaan']?></td>
                                    <td><?= $data['pengawas']?></td>
                                    <td><?= $data['kontraktor']?></td>
                                    <td><?= $data['tambahan_waktu']?></td> 
                                    <td>
                                        <form action="../../script/projek_pilih_op.php" method="POST">
                                        <a href="#" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalHapus<?=$data['id_projek']?>"><i class='bx bxs-trash-alt' > Hapus</i></a>
                                        <a href="#" class="btn btn-warning text-dark" data-bs-toggle="modal" data-bs-target="#modalUbah<?=$data['id_projek']?>"><i class='bx bxs-edit-alt' > Ubah</i></a>
                                        <input type="hidden" name="id_projek" value="<?=$data['id_projek']?>">
                                        <input type="hidden" name="nama_projek" value="<?=$data['nama_projek']?>">
                                        <input type="hidden" name="tanggal_mulai" value="<?=$data['tanggal_mulai']?>">
                                        <input type="hidden" name="tanggal_selesai" value="<?=$data['tanggal_selesai']?>">
                                        <input type="hidden" name="tambahan_waktu" value="<?=$data['tambahan_waktu']?>">
                                        <button type="submit" href="#" class="btn btn-primary text-white" id="projek_pilih_op" name="projek_pilih_op">Pilih</i></button>
                                        </form>
                                    </td>
                                </tr>

                                <!-- Ubah Modal -->
                                <div class="modal fade" id="modalUbah<?=$data['id_projek']?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header bg-primary text-white">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Ubah Master Projek</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form id="form_ubah" action="../../script/insert.php" method="POST">
                                            <input type="hidden" name="id_projek" value="<?=$data['id_projek']?>">
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label for="id_projek" class="form-label">ID Proyek</label>
                                                    <h5 for="id_projek" class="form-label"><?=$data['id_projek']?></h5>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="nama_projek" class="form-label">Nama Proyek</label>
                                                    <input type="text" class="form-control" id="nama_projek_ubah_<?=$data['id_projek']?>" name="nama_projek" value="<?= $data['nama_projek']?>" placeholder="Masukkan Nama Projek" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="tanggal_mulai_ubah" class="form-label">Tanggal Mulai</label>
                                                    <input type="date" class="form-control" id="tanggal_mulai_ubah_<?=$data['id_projek']?>" name="tanggal_mulai_ubah" value="<?= $data['tanggal_mulai']?>" required>
                                                    <small id="tanggalMulaiError_ubah_<?=$data['id_projek']?>" class="form-text text-danger" style="display:none;">Tanggal mulai tidak boleh lebih awal dari hari ini.</small>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="tanggal_selesai_ubah" class="form-label">Tanggal Selesai</label>
                                                    <input type="date" class="form-control" id="tanggal_selesai_ubah_<?=$data['id_projek']?>" name="tanggal_selesai_ubah" value="<?= $data['tanggal_selesai']?>" required>
                                                    <small id="tanggalSelesaiError_ubah_<?=$data['id_projek']?>" class="form-text text-danger" style="display:none;">Tanggal selesai tidak boleh kurang dari tanggal mulai.</small>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="pemilik_pekerjaan" class="form-label">Pemilik Pekerjaan</label>
                                                    <input type="text" class="form-control" id="pemilik_pekerjaan_ubah_<?=$data['id_projek']?>" name="pemilik_pekerjaan" value="<?= $data['pemilik_pekerjaan']?>" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="pengawas" class="form-label">Pengawas</label>
                                                    <input type="text" class="form-control" id="pengawas_ubah_<?=$data['id_projek']?>" name="pengawas" value="<?= $data['pengawas']?>" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="kontraktor" class="form-label">Kontraktor</label>
                                                    <input type="text" class="form-control" id="kontraktor_ubah_<?=$data['id_projek']?>" name="kontraktor" value="<?= $data['kontraktor']?>" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="tambahan_waktu_ubah" class="form-label">Tambahan Waktu</label>
                                                    <input type="date" class="form-control" id="tambahan_waktu_ubah_<?=$data['id_projek']?>" name="tambahan_waktu_ubah" value="<?= $data['tambahan_waktu']?>">
                                                    <small id="tanggalTambahanError_ubah_<?=$data['id_projek']?>" class="form-text text-danger" style="display:none;">Tanggal Tambahan tidak boleh kurang dari tanggal selesai!.</small>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                                <button type="submit" class="btn btn-warning" name="projek_ubah">Ubah</button>
                                            </div>
                                        </form>
                                    </div>
                                    </div>
                                </div>

                                <!-- Modal Hapus -->
                                <div class="modal fade" id="modalHapus<?=$data['id_projek']?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header bg-danger text-white">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Hapus Master Projek</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="../../script/insert.php" method="POST">
                                            <input type="hidden" name="id_projek" value="<?=$data['id_projek']?>">
                                            <div class="modal-body">
                                                <p>Apakah anda yakin ingin menghapus data <strong><?=$data['nama_projek']?></strong>?</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-danger" name="projek_hapus">Hapus</button>
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                            </div>
                                        </form>
                                    </div>
                                    </div>
                                </div>
                        <?php endwhile; ?>
                    </table>
                </div>
            </div>
        </div>

        <!-- JavaScript validation -->
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                // Helper function to validate dates
                function validateDates(startDate, endDate, additionalDate, startError, endError, additionalError) {
                    var today = new Date().toISOString().split('T')[0];

                    // Clear previous errors
                    startError.style.display = 'none';
                    endError.style.display = 'none';
                    additionalError.style.display = 'none';

                    var isValid = true;

                    /*
                    // Validate start date
                    if (startDate.value < today) {
                        startError.style.display = 'block';
                        isValid = false;
                    } 
                    */

                    // Validate end date
                    if (endDate.value <= startDate.value) {
                        endError.style.display = 'block';
                        isValid = false;
                    }

                    if (additionalDate.value !== '') {
                        const additionalDateValue = new Date(additionalDate.value);
                        const endDateValue = new Date(endDate.value);

                        if (additionalDateValue <= endDateValue) {
                            additionalError.style.display = 'block';
                            isValid = false; // Assuming isValid is a boolean flag used for form validation
                        } else {
                            additionalError.style.display = 'none';
                        }
                    }
                    return isValid;
                }

                // Add event listener for "Tambah" form submission
                document.getElementById('form_tambah').addEventListener('submit', function(event) {
                    var startDate = document.getElementById('tanggal_mulai_tambah');
                    var endDate = document.getElementById('tanggal_selesai_tambah');
                    var additionalDate = document.getElementById('tambahan_waktu_tambah');
                    var startError = document.getElementById('tanggalMulaiError_tambah');
                    var endError = document.getElementById('tanggalSelesaiError_tambah');
                    var additionalError = document.getElementById('tanggalTambahanError_tambah');

                    if (!validateDates(startDate, endDate, additionalDate, startError, endError, additionalError)) {
                        event.preventDefault();
                    }
                });

                <?php
                // Add event listeners for "Ubah" forms submission
                $tampil = mysqli_query($conn, "SELECT * FROM m_projek ORDER BY id_projek ASC");
                while ($data = mysqli_fetch_array($tampil)) :
                ?>
                    document.getElementById('modalUbah<?=$data['id_projek']?>').addEventListener('submit', function(event) {
                        var startDate = document.getElementById('tanggal_mulai_ubah_<?=$data['id_projek']?>');
                        var endDate = document.getElementById('tanggal_selesai_ubah_<?=$data['id_projek']?>');
                        var additionalDate = document.getElementById('tambahan_waktu_ubah_<?=$data['id_projek']?>');
                        var startError = document.getElementById('tanggalMulaiError_ubah_<?=$data['id_projek']?>');
                        var endError = document.getElementById('tanggalSelesaiError_ubah_<?=$data['id_projek']?>');
                        var additionalError = document.getElementById('tanggalTambahanError_ubah_<?=$data['id_projek']?>');

                        if (!validateDates(startDate, endDate, additionalDate, startError, endError, additionalError)) {
                            event.preventDefault();
                        }
                    });
                <?php endwhile; ?>
            });
        </script>
    
</body>

<?php
    include "../../public/layout/admin/header2.php";