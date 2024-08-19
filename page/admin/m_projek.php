<?php
    include "../../koneksi.php";
    include "../../public/layout/admin/header_projek.php";
?>

<style>
    @media (max-width: 576px) {
        .kolom-aksi {
            width: 50%; /* 4 dari 12 kolom */
        }

        span {
            display: none;
        }
    }
</style>

<body>
    <h1 class="text-center">Master Projek</h1>
        
        <!-- Modal Tambah Proyek -->
        <div class="modal fade" id="formProjek" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="exampleModalLabel">Tambah Proyek</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="form_tambah" action="../../script/insert.php" method="POST" enctype="multipart/form-data">
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
                                <label for="logo1" class="form-label">Logo Pemilik</label>
                                <input type="file" class="form-control" id="logo1" name="logo1" accept="image/*">
                                <div class="mb-3 mt-3 d-flex justify-content-center">
                                    <img id="logo1-preview" src="#" alt="Preview Logo" style="display: none; max-width: 100%; height: auto;">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="pengawas" class="form-label">Pengawas</label>
                                <input type="text" class="form-control" id="pengawas" name="pengawas" required>
                            </div>
                            <div class="mb-3">
                                <label for="logo2" class="form-label">Logo Pengawas</label>
                                <input type="file" class="form-control" id="logo2" name="logo2" accept="image/*">
                                <div class="mb-3 mt-3 d-flex justify-content-center">
                                    <img id="logo2-preview" src="#" alt="Preview Logo" style="display: none; max-width: 100%; height: auto;">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="kontraktor" class="form-label">Kontraktor</label>
                                <input type="text" class="form-control" id="kontraktor" name="kontraktor" required>
                            </div>
                            <div class="mb-3">
                                <label for="logo3" class="form-label">Logo Kontraktor</label>
                                <input type="file" class="form-control" id="logo3" name="logo3" accept="image/*">
                                <div class="mb-3 mt-3 d-flex justify-content-center">
                                    <img id="logo3-preview" src="#" alt="Preview Logo" style="display: none; max-width: 100%; height: auto;">
                                </div>
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
                    <div class="table-responsive">
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
                                    <td class="kolom-aksi">
                                        <form action="../../script/projek_pilih.php" method="POST">
                                        <a href="#" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalHapus<?=$data['id_projek']?>"><i class='bx bxs-trash-alt'><span> Hapus</span></i></a>
                                        <a href="#" class="btn btn-warning text-dark mt-1" data-bs-toggle="modal" data-bs-target="#modalUbah<?=$data['id_projek']?>"><i class='bx bxs-edit-alt' ><span> Ubah</span></i></a>
                                        <input type="hidden" name="id_projek" value="<?=$data['id_projek']?>">
                                        <input type="hidden" name="nama_projek" value="<?=$data['nama_projek']?>">
                                        <button type="submit" href="#" class="btn btn-primary text-white mt-1" id="projek_pilih" name="projek_pilih"><i class='bx bxs-right-arrow-circle'><span> Pilih</span></i></button>
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
                                        <form id="form_ubah" action="../../script/insert.php" method="POST" enctype="multipart/form-data">
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
                                                    <label for="logo1" class="form-label">Logo Pemilik</label>
                                                    <input type="file" class="form-control" id="logo1-ubah-<?=$data['logo_pemilik']?>" name="logo1" accept="image/*" onchange="previewImageUbah(this, 'logo1-preview-ubah-<?=$data['logo_pemilik']?>')">
                                                    <div class="mb-3 mt-3 d-flex justify-content-center">
                                                        <img id="logo1-preview-ubah-<?=$data['logo_pemilik']?>" src="http://localhost/pengawasan_me/public/asset/img/uploads/logo/<?=$data['logo_pemilik']?>" alt="Preview Logo" style="max-width: 100%; height: auto;">
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="pengawas" class="form-label">Pengawas</label>
                                                    <input type="text" class="form-control" id="pengawas_ubah_<?=$data['id_projek']?>" name="pengawas" value="<?= $data['pengawas']?>" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="logo2" class="form-label">Logo Pengawas</label>
                                                    <input type="file" class="form-control" id="logo2-ubah-<?=$data['logo_pengawas']?>" name="logo2" accept="image/*" onchange="previewImageUbah(this, 'logo2-preview-ubah-<?=$data['logo_pengawas']?>')">
                                                    <div class="mb-3 mt-3 d-flex justify-content-center">
                                                        <img id="logo2-preview-ubah-<?=$data['logo_pengawas']?>" src="http://localhost/pengawasan_me/public/asset/img/uploads/logo/<?=$data['logo_pengawas']?>" alt="Preview Logo" style="max-width: 100%; height: auto;">
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="kontraktor" class="form-label">Kontraktor</label>
                                                    <input type="text" class="form-control" id="kontraktor_ubah_<?=$data['id_projek']?>" name="kontraktor" value="<?= $data['kontraktor']?>" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="logo3" class="form-label">Logo Kontraktor</label>
                                                    <input type="file" class="form-control" id="logo3-ubah-<?=$data['logo_kontraktor']?>" name="logo3" accept="image/*" onchange="previewImageUbah(this, 'logo3-preview-ubah-<?=$data['logo_kontraktor']?>')">
                                                    <div class="mb-3 mt-3 d-flex justify-content-center">
                                                        <img id="logo3-preview-ubah-<?=$data['logo_kontraktor']?>" src="http://localhost/pengawasan_me/public/asset/img/uploads/logo/<?=$data['logo_kontraktor']?>" alt="Preview Logo" style="max-width: 100%; height: auto;">
                                                    </div>
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

              function previewImage(inputId, previewId) {
                const input = document.getElementById(inputId);
                const preview = document.getElementById(previewId);

                input.addEventListener('change', function() {
                    const file = this.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            preview.src = e.target.result;
                            preview.style.display = 'block';
                        }
                        reader.readAsDataURL(file);
                    } else {
                        preview.src = '#';
                        preview.style.display = 'none';
                    }
                });
            }

            previewImage('logo1', 'logo1-preview');
            previewImage('logo2', 'logo2-preview');
            previewImage('logo3', 'logo3-preview');

        function previewImageUbah(input, previewId) {
        const file = input.files[0];
        const preview = document.getElementById(previewId);

        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
            }
            reader.readAsDataURL(file);
        } else {
            preview.src = "";  // Clear the preview if no file is selected
        }
    }
        </script>
    
</body>

<?php
    include "../../public/layout/admin/header2.php";
?>