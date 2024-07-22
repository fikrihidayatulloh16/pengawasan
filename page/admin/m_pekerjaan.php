<?php
    include "../../koneksi.php";
    include "../../public/layout/admin/header.php";
    
?>

<style>
    @media (min-width: 1024px) {
        .kolom-aksi {
            columns: 5;
        }
    }

    @media (max-width: 768px) {
        .kolom-aksi {
            width: 33.3333%; /* 4 dari 12 kolom */
        }
        span {
            display: none;
        }
    }
</style>

<body>
    <h1 class="text-center">Master Pekerjaan</h1>
    <h2 class="text-center">Nama Projek : <?= $_SESSION['nama_projek']?></h2>
    <h2 class="text-center">ID Projek : <?= $_SESSION['id_projek']?></h2>
    
    <!-- Modal -->
    <div class="modal fade" id="form" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Master Pekerjaan</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="../../script/insert.php" method="POST">
            <input type="hidden" name="id_projek" value="<?= $_SESSION['id_projek']?>">
                <div class="modal-body">
                    <div class="mb-3">
                        <?php
                        // Ambil nilai terakhir id_m_pekerjaan dari database
                        $sql_get_last_id = "SELECT MAX(id_m_pekerjaan) AS last_id FROM m_pekerjaan";
                        $result = $conn->query($sql_get_last_id);
                        $row = $result->fetch_assoc();
                        $last_id = $row['last_id'];
                    
                        // Menghasilkan id_m_pekerjaan baru dengan format PJM001, PJM002, ...
                        if ($last_id) {
                            $num = intval(substr($last_id, 3)) + 1;
                        } else {
                            $num = 1;
                        }
                        $new_id = 'P' . str_pad($num, 4, '0', STR_PAD_LEFT); //$new_id_m_pekerjaan = 'PJM' . str_pad($num, 3, '0', STR_PAD_LEFT); <-- untuk 5 karakter contoh PJM001
                        ?>
                        <label for="id_m_pekerjaan" class="form-label">ID (Tidak Bisa Diubah)</label>
                        <h5 for="id_m_pekerjaan" class="form-label"><?=$new_id?></h5>
                        <label for="nama_pekerjaan" class="form-label">Nama Pekerjaan</label>
                        <input type="text" class="form-control" id="nama_pekerjaan" name="nama_pekerjaan" placeholder="Masukkan Nama Pekerjaan"required><br><br>
                    </div>
                </div>
            
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary" name="pekerjaan_simpan">Simpan</button>
                </div>
            </form>
        </div>
        </div>
    </div>

    <div class="container mt-3">

            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#form">
                <i class='bx bx-plus-medical' width='500px' name="btambah"></i> Tambah</button>

        <div class="card">
            <h5 class="card-header bg-primary text-white">Data Master Pekerjaan</h5>

                <table>
                <tr>
    <th class="col-2">ID</th>
    <th>Nama Pekerjaan</th>
    <th class="col-2">Aksi</th>
</tr>
<?php
    //menampilkan data
    $id_projek = $_SESSION['id_projek'];
    $tampil = mysqli_query($conn, "SELECT id_m_pekerjaan, nama_pekerjaan FROM m_pekerjaan AS pk, m_projek AS pj WHERE pk.id_projek = '$id_projek' AND pj.id_projek = '$id_projek' ORDER BY id_m_pekerjaan ASC");
    while ($data = mysqli_fetch_array($tampil)) :
?>
<tr>
    <td><?= $data['id_m_pekerjaan'] ?></td>
    <td>
    <div class="accordion" id="accordionExample">
        <div class="accordion-item">
        <h2 class="accordion-header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne<?= $data['id_m_pekerjaan'] ?>" aria-expanded="false" aria-controls="collapseOne<?= $data['id_m_pekerjaan'] ?>">
                <?= $data['nama_pekerjaan'] ?>
            </button>
        </h2>
        </div>
    </div>
    </td>
    <td>
        <form action="../../script/pekerjaan_pilih.php" method="POST">
            <a href="#" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalHapus<?= $data['id_m_pekerjaan'] ?>"><i class='bx bxs-trash-alt'><span> Hapus</span></i></a>
            <a href="#" class="btn btn-warning text-dark mt-1" data-bs-toggle="modal" data-bs-target="#modalUbah<?= $data['id_m_pekerjaan'] ?>"><i class='bx bxs-edit-alt'><span> Ubah</span></i></a>
            <input type="hidden" name="id_m_pekerjaan" value="<?= $data['id_m_pekerjaan'] ?>">
            <input type="hidden" name="nama_pekerjaan" value="<?= $data['nama_pekerjaan'] ?>">
        </form>
    </td>
</tr>

    <?php include "m_sub_pekerjaan.php"?>
                            

                            <!-- Ubah Modal -->
                            <div class="modal fade" id="modalUbah<?=$data['id_m_pekerjaan']?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header bg-primary text-white">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Ubah Master Pekerjaan</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="../../script/insert.php" method="POST">
                                        <input type="hidden" name="id_m_pekerjaan" value="<?=$data['id_m_pekerjaan']?>">
                                        <div class="modal-body">
                                            
                                            <div class="mb-3">
                                                <label for="id_m_pekerjaan" class="form-label">ID (Tidak Bisa Diubah)</label>
                                                <h5 for="id_m_pekerjaan" class="form-label"><?=$data['id_m_pekerjaan']?></h5>
                                                <label for="nama_pekerjaan" class="form-label">Nama Pekerjaan</label>
                                                <input type="text" class="form-control" id="nama_pekerjaan" name="nama_pekerjaan" value="<?= $data['nama_pekerjaan']?>" placeholder="Masukkan Nama Pekerjaan" required><br><br>
                                            </div>
                                        </div>
                                    
                                        <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                        <button type="submit" class="btn btn-warning text-dark" name="pekerjaan_ubah">Ubah</button>
                                        </div>
                                    </form>
                                </div>
                                </div>
                            </div>

                            <!-- Hapus Modal -->
                            <div class="modal fade" id="modalHapus<?=$data['id_m_pekerjaan']?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header bg-danger text-dark">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Hapus Master Pekerjaan</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="../../script/insert.php" method="POST">
                                    <input type="hidden" name="id_m_pekerjaan" value="<?=$data['id_m_pekerjaan']?>">
                                        <div class="modal-body">
                                            
                                            <div class="mb-3">
                                                <label for="id_m_pekerjaan" class="form-label">ID</label>
                                                <h5 for="id_m_pekerjaan" class="form-label" id="id_m_pekerjaan" name="id_m_pekerjaan" value="<?= $data['id_m_pekerjaan']?>"><?=$data['id_m_pekerjaan']?></h5>
                                                <label for="jenis_pekerja" class="form-label">Jenis Pekerja</label>
                                                <h5 for="id_m_pekerjaan" class="form-label text-danger"><?=$data['nama_pekerjaan']?></h5>
                                            </div>
                                        </div>
                                    
                                        <div class="modal-footer">
                                        <button type="submit" class="btn btn-danger" name="pekerjaan_hapus">Hapus</button>
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
        fetch('get data/get_m_pekerjaan.php')
            .then(response => response.text())
            .then(data => {
                document.getElementById('data-container').innerHTML = data;
            });
    </script>
</body>

<?php
    include "../../public/layout/admin/header2.php";
?>