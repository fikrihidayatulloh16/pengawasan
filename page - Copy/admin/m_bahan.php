<?php
    include "../../koneksi.php";
    include "../../public/layout/admin/header.php";
?>

<body>
    <h1 class="text-center">Master Bahan</h1>
    <h2 class="text-center">Nama Projek : <?= $_SESSION['nama_projek']?></h2>
    <h2 class="text-center">ID Projek : <?= $_SESSION['id_projek']?></h2>
    
    <!-- Modal -->
    <div class="modal fade" id="form" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Master Bahan</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="../../script/insert.php" method="POST">
            <input type="hidden" name="id_projek" value="<?= $_SESSION['id_projek']?>">
                <div class="modal-body">
                    <div class="mb-3">
                    <?php
                        // Ambil nilai terakhir id_m_pekerja dari database
                        $sql_get_last_id = "SELECT MAX(id_m_bahan) AS last_id FROM m_bahan";
                        $result = $conn->query($sql_get_last_id);
                        $row = $result->fetch_assoc();
                        $last_id = $row['last_id'];

                        // Menghasilkan id_m_pekerja baru dengan format PJM001, PJM002, ...
                        if ($last_id) {
                            $num = intval(substr($last_id, 4)) + 1;
                        } else {
                            $num = 1;
                        }
                        $new_id= 'MBHN' . str_pad($num, 3, '0', STR_PAD_LEFT); //str_pad($num, 3, '0', STR_PAD_LEFT); <-- untuk 5 karakter contoh PJM001
                    ?>
                        <label for="id_m_pekerjaan" class="form-label">ID (Tidak Bisa Diubah)</label>
                        <h5 for="id_m_pekerjaan" class="form-label"><?=$new_id?></h5>
                        <label for="nama_bahan" class="form-label">Nama Bahan</label>
                        <input type="text" class="form-control" id="nama_bahan" name="nama_bahan" placeholder="Masukkan Nama Bahan"required><br><br>
                    </div>
                    <div class="mb-3">
                        <label for="satuan" class="form-label">Satuan</label>
                        <input type="text" class="form-control" id="satuan" name="satuan" placeholder="Masukkan Satuan"required><br><br>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary" name="bahan_simpan">Simpan</button>
                </div>
            </form>
            
        </div>
        </div>
    </div>

    <div class="container mt-3">

            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#form"><i class='bx bx-plus-medical' width='500px' name="btambah"></i> Tambah</button>

        <div class="card">
            <h5 class="card-header bg-primary text-white">Data Master Bahan</h5>
            

                <table>
                <tr>
                    <th>ID Bahan</th>
                    <th>Nama Bahan</th>
                    <th>Satuan</th>
                    <th class="col-2">Aksi</th>
                </tr>
                    <?php
                        //menampilkan data
                        $projek = $_SESSION['id_projek'];
                        
                        $tampil = mysqli_query($conn, "SELECT id_m_bahan, nama_bahan, satuan FROM m_bahan AS mb, m_projek AS mp WHERE mb.id_projek = '$projek' AND mp.id_projek = '$projek' ORDER BY id_m_bahan ASC");
                        while ($data = mysqli_fetch_array($tampil)) : 
                    ?>
                            <tr>
                                <td><?= $data['id_m_bahan']?></td>
                                <td><?= $data['nama_bahan']?></td>
                                <td><?= $data['satuan']?></td>
                                <td>
                                    <a href="#" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalHapus<?=$data['id_m_bahan']?>"><i class='bx bxs-trash-alt'> Hapus</i></a>
                                    <a href="#" class="btn btn-warning text-dark" data-bs-toggle="modal" data-bs-target="#modalUbah<?=$data['id_m_bahan']?>"><i class='bx bxs-edit-alt'> Ubah</i></a>
                                </td>
                            </tr>

                            <!-- Ubah Modal -->
                            <div class="modal fade" id="modalUbah<?=$data['id_m_bahan']?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header bg-primary text-white">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Ubah Data Master Bahan</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="../../script/insert.php" method="POST">
                                        <input type="hidden" name="id_m_bahan" value="<?=$data['id_m_bahan']?>">
                                        <div class="modal-body">
                                            
                                            <div class="mb-3">
                                                <label for="id_m_bahan" class="form-label">ID (Tidak Bisa Diubah)</label>
                                                <h5 for="id_m_bahan" class="form-label"><?=$data['id_m_bahan']?></h5>
                                                <label for="nama_bahan" class="form-label">Nama Bahan</label>
                                                <input type="text" class="form-control" id="nama_bahan" name="nama_bahan" value="<?= $data['nama_bahan']?>" placeholder="Masukkan Nama Bahan" required><br><br>
                                                <label for="satuan" class="form-label">Satuan</label>
                                                <input type="text" class="form-control" id="satuan" name="satuan" value="<?= $data['satuan']?>" placeholder="Masukkan satuan" required><br><br>
                                            </div>
                                        </div>
                                    
                                        <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                        <button type="submit" class="btn btn-warning text-dark" name="bahan_ubah">Ubah</button>
                                        </div>
                                    </form>
                                </div>
                                </div>
                            </div>

                            <!-- Hapus Modal -->
                            <div class="modal fade" id="modalHapus<?=$data['id_m_bahan']?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header bg-danger text-dark">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Hapus Data Master Bahan</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="../../script/insert.php" method="POST">
                                    <input type="hidden" name="id_m_bahan" value="<?=$data['id_m_bahan']?>">
                                        <div class="modal-body">
                                            
                                            <div class="mb-3">
                                                <label for="id_m_bahan" class="form-label">ID</label>
                                                <h5 for="id_m_bahan" class="form-label" id="id_m_bahan" name="id_m_bahan" value="<?= $data['id_m_bahan']?>"><?=$data['id_m_bahan']?></h5>
                                                <label for="nama_bahan" class="form-label">Nama Bahan</label>
                                                <h5 for="nama_bahan" class="form-label text-danger"><?=$data['nama_bahan']?></h5>
                                                <label for="satuan" class="form-label">Satuan</label>
                                                <h5 for="satuan" class="form-label text-danger"><?=$data['satuan']?></h5>
                                            </div>
                                        </div>
                                    
                                        <div class="modal-footer">
                                        <button type="submit" class="btn btn-danger" name="bahan_hapus">Hapus</button>
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
        // Menggunakan AJAX untuk mengambil data dari file PHP
        fetch('get data/get_m_bahan.php')
            .then(response => response.text())
            .then(data => {
                document.getElementById('data-container').innerHTML = data;
            });
    </script>
</body>

<?php
    include "../../public/layout/admin/header2.php";
?>
</html>
