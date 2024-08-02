<?php
    include "../../koneksi.php";
    include "../../public/layout/admin/header_projek.php";
?>

<body>
    <h1 class="text-center">Master Projek</h1>
    
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

            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#formProjek"><i class='bx bx-plus-medical' width='500px' name="btambah"></i>Tambah</button>

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
                                    <form action="../../script/projek_pilih.php" method="POST">
                                    <a href="#" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalHapus<?=$data['id_projek']?>"><i class='bx bxs-trash-alt' ></i>Hapus</a>
                                    <a href="#" class="btn btn-warning text-dark" data-bs-toggle="modal" data-bs-target="#modalUbah<?=$data['id_projek']?>"><i class='bx bxs-edit-alt' >Ubah</i></a>
                                    <input type="hidden" name="id_projek" value="<?=$data['id_projek']?>">
                                    <input type="hidden" name="nama_projek" value="<?=$data['nama_projek']?>">
                                    <button type="submit" href="#" class="btn btn-primary text-white" id="projek_pilih" name="projek_pilih">Pilih</i></button>
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
                                                <input type="text" class="form-control" id="nama_projek" name="nama_projek" value="<?= $data['nama_projek']?>" placeholder="Masukkan Nama Projek" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="tanggal_mulai_ubah" class="form-label">Tanggal Mulai</label>
                                                <input type="date" class="form-control" id="tanggal_mulai_ubah" name="tanggal_mulai_ubah" value="<?= $data['tanggal_mulai']?>" placeholder="Masukkan Nama Tanggal Mulai" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="tanggal_selesai_ubah" class="form-label">Tanggal Selesai</label>
                                                <input type="date" class="form-control" id="tanggal_selesai_ubah" name="tanggal_selesai_ubah" value="<?= $data['tanggal_selesai']?>" placeholder="Masukkan Tanggal Selesai" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="pemilik_pekerjaan" class="form-label">Pemilik Pekerjaan</label>
                                                <input type="text" class="form-control" id="pemilik_pekerjaan" name="pemilik_pekerjaan" value="<?= $data['pemilik_pekerjaan']?>" placeholder="Masukkan Pemilik Pekerjaan" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="pengawas" class="form-label">Pengawas</label>
                                                <input type="text" class="form-control" id="pengawas" name="pengawas" value="<?= $data['pengawas']?>" placeholder="Masukkan Nama Pengawas" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="kontraktor" class="form-label">Kontraktor</label>
                                                <input type="text" class="form-control" id="kontraktor" name="kontraktor" value="<?= $data['kontraktor']?>" placeholder="Masukkan Nama kontraktor" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="tambahan_waktu_ubah" class="form-label">Tambahan Waktu</label>
                                                <input type="date" class="form-control" id="tambahan_waktu_ubah" name="tambahan_waktu_ubah" value="<?= $data['tambahan_waktu']?>" placeholder="Masukkan Tambahan Waktu">
                                            </div>
                                    
                                        </div>
                                    
                                        <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                        <button type="submit" class="btn btn-warning text-dark" name="projek_ubah">Ubah</button>
                                        </div>
                                    </form>
                                </div>
                                </div>
                            </div>

                            <!-- Hapus Modal -->
                            <div class="modal fade" id="modalHapus<?=$data['id_projek']?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header bg-danger text-dark">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Hapus Master Projek</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="../../script/insert.php" method="POST">
                                    <input type="hidden" name="id_projek" value="<?=$data['id_projek']?>">
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="id_projek" class="form-label">ID Proyek</label>
                                                <h5 for="id_projek" class="form-label" id="id_projek" name="id_projek" value="<?= $data['id_projek']?>"><?=$data['id_projek']?></h5>
                                            </div>
                                            <div class="mb-3">
                                                <label for="nama_projek" class="form-label">Nama Proyek</label>
                                                <h5 for="nama_projek" class="form-label text-danger"><?=$data['nama_projek']?></h5>
                                                
                                            </div>
                                            <div class="mb-3">
                                                <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
                                                <h5 for="tanggal_mulai" class="form-label text-danger"><?=$data['tanggal_mulai']?></h5>
                                                
                                            </div>
                                            <div class="mb-3">
                                                <label for="tanggal_selesai" class="form-label">Tanggal Selesai</label>
                                                <h5 for="tanggal_selesai" class="form-label text-danger"><?=$data['tanggal_selesai']?></h5>
                                               
                                            </div>
                                            <div class="mb-3">
                                                <label for="pemilik_pekerjaan" class="form-label">Pemilik Pekerjaan</label>
                                                <h5 for="pemilik_pekerjaan" class="form-label text-danger"><?=$data['pemilik_pekerjaan']?></h5>
                                               
                                            </div>
                                            <div class="mb-3">
                                                <label for="pengawas" class="form-label">Pengawas</label>
                                                <h5 for="pengawas" class="form-label text-danger"><?=$data['pengawas']?></h5>
                                               
                                            </div>
                                            <div class="mb-3">
                                                <label for="kontraktor" class="form-label">Kontraktor</label>
                                                <h5 for="kontraktor" class="form-label text-danger"><?=$data['kontraktor']?></h5>
                                               
                                            </div>
                                            <div class="mb-3">
                                                <label for="tambahan_waktu" class="form-label">Tambahan Waktu</label>
                                                <h5 for="tambahan_waktu" class="form-label text-danger"><?=$data['tambahan_waktu']?></h5>
                                              
                                            </div>
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
    
    <script>
            document.addEventListener('DOMContentLoaded', function() {
                const form = document.getElementById('form_ubah');
                const tanggalMulaiInput = document.getElementById('tanggal_mulai_ubah');
                const tanggalSelesaiInput = document.getElementById('tanggal_selesai_ubah');
                const tambahanWaktuInput = document.getElementById('tambahan_waktu_ubah');

                form.addEventListener('submit', function(event) {
                    const tanggalMulai = new Date(tanggalMulaiInput.value);
                    const tanggalSelesai = new Date(tanggalSelesaiInput.value);
                    const tambahanWaktu = new Date(tambahanWaktuInput.value);

                    // Validasi tanggal mulai tidak boleh lebih dari tanggal selesai
                    if (tanggalMulai > tanggalSelesai) {
                        alert('Tanggal mulai tidak boleh lebih dari tanggal selesai!');
                        event.preventDefault();
                        return;
                    }

                    // Validasi tambahan waktu tidak boleh lebih dari tanggal selesai
                    if (tambahanWaktu > tanggalSelesai) {
                        alert('Tanggal tambahan waktu tidak boleh lebih dari tanggal selesai!');
                        event.preventDefault();
                        return;
                    }

                    // Jika semua validasi berhasil, form akan dikirim
                });
            });
        
            document.getElementById('form_tambah').addEventListener('submit', function(event) {
                // Ambil nilai tanggal yang dipilih
                var tanggalMulaiInput = document.getElementById('tanggal_mulai_tambah').value;
                var tanggalSelesaiInput = document.getElementById('tanggal_selesai_tambah').value;
                var tanggalTambahanInput = document.getElementById('tambahan_waktu_tambah').value;
                var tanggalMulaiError = document.getElementById('tanggalMulaiError_tambah');
                var tanggalSelesaiError = document.getElementById('tanggalSelesaiError_tambah');
                var tanggalTambahanError = document.getElementById('tanggalTambahanError_tambah');

                // Ambil tanggal saat ini
                var today = new Date();
                today.setHours(0, 0, 0, 0); // Set waktu ke 00:00:00 untuk perbandingan yang tepat

                // Buat objek tanggal dari nilai input
                var tanggalMulai = new Date(tanggalMulaiInput);
                var tanggalSelesai = new Date(tanggalSelesaiInput);
                var tanggalTambahan = new Date(tanggalTambahanInput);

                // Validasi tanggal mulai tidak boleh lebih awal dari hari ini
                var valid = true; // flag to track form validity
                if (tanggalMulai <= today) {
                    tanggalMulaiError.style.display = 'block';
                    valid = false;
                } else {
                    tanggalMulaiError.style.display = 'none';
                }

                // Validasi tanggal akhir tidak boleh kurang dari tanggal mulai
                if (tanggalSelesai <= tanggalMulai) {
                    tanggalSelesaiError.style.display = 'block';
                    valid = false;
                } else {
                    tanggalSelesaiError.style.display = 'none';
                }

                // Validasi tanggal akhir tidak boleh kurang dari tanggal mulai
                if (tanggalSelesai <= tanggalMulai) {
                    tanggalSelesaiError.style.display = 'block';
                    valid = false;
                } else {
                    tanggalSelesaiError.style.display = 'none';
                }

                // Validasi tanggal tambahan tidak boleh kurang dari tanggal selesai
                if (tanggalTambahan <= tanggalSelesai) {
                    tanggalTambahanError.style.display = 'block';
                    valid = false;
                } else {
                    tanggalTambahanError.style.display = 'none';
                }

                if (!valid) {
                    event.preventDefault();
                }
            });
    </script>
    
</body>

<?php
    include "../../public/layout/admin/header2.php";