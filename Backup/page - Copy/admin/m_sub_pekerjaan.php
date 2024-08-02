<?php
    include "../../koneksi.php";
    include "../../public/layout/admin/header.php";
    
?>

<body>
    <h1 class="text-center">Master Sub Pekerjaan</h1>
    <h2 class="text-center">Projek : <?= $_SESSION['nama_projek']?></h2>
    <h2 class="text-center">Pekerjaan : <?= $_SESSION['nama_pekerjaan']?></h2>
    <h2 class="text-center">ID : <?= $_SESSION['id_m_pekerjaan']?></h2>

    <!-- Tambah Modal -->
    <div class="modal fade" id="form" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Master Sub Pekerjaan</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="../../script/insert.php" method="POST">
            <input type="hidden" name="id_m_pekerjaan" value="<?= $_SESSION['id_m_pekerjaan']?>">
                <div class="modal-body">
                    <div class="mb-3">
                        <?php
                        // Ambil nilai terakhir id_m_sub_pekerjaan dari database
                        $sql_get_last_id = "SELECT MAX(id_m_sub_pekerjaan) AS last_id FROM m_sub_pekerjaan";
                        $result = $conn->query($sql_get_last_id);
                        $row = $result->fetch_assoc();
                        $last_id = $row['last_id'];
                    
                        // Menghasilkan id_m_pekerjaan baru dengan format PJM001, PJM002, ...
                        if ($last_id) {
                            $num = intval(substr($last_id, 3)) + 1;
                        } else {
                            $num = 1;
                        }
                        $new_id = 'SP' . str_pad($num, 6, '0', STR_PAD_LEFT); //$new_id_m_pekerjaan = 'PJM' . str_pad($num, 3, '0', STR_PAD_LEFT); <-- untuk 5 karakter contoh PJM001
                        ?>
                        <label for="id_m_sub_pekerjaan" class="form-label">ID Sub Pekerjaan (Tidak Bisa Diubah)</label>
                        <h5 for="id_m_sub_pekerjaan" class="form-label"><?= $new_id ?></h5>
                        <label for="id_m_sub_pekerjaan" class="form-label">ID Pekerjaan (Tidak Bisa Diubah)</label>
                        <h5 for="id_m_pekerjaan" class="form-label"><?=$_SESSION['id_m_pekerjaan']?></h5>
                        <label for="nama_sub_pekerjaan" class="form-label">Nama Sub Pekerjaan</label>
                        <input type="text" class="form-control" id="nama_sub_pekerjaan" name="nama_sub_pekerjaan" placeholder="Masukkan Nama Sub Pekerjaan"required><br><br>
                    </div>
                </div>
            
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary" name="sub_simpan">Simpan</button>
                </div>
            </form>
        </div>
        </div>
    </div>

    <div class="container mt-3">
            <button type="button-center" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#form"><i class='bx bx-plus-medical' style="margin-right: 5px;" name="btambah"></i>Tambah</button>
            <a href="m_pekerjaan.php" class="btn btn-secondary align-item-right" ><i class='bx bx-arrow-back' style="margin-right: 5px;"></i>Kembali</a>
            
        <div class="card">
            <h5 class="card-header bg-primary text-white">Data Master Sub Pekerjaan</h5>

                <table>
                    <tr>
                        <th>ID</th>
                        <th>Nama pekerjaan</th>
                        <th class="col-2">Aksi</th>
                    </tr>

                    <?php
                    //menampilkan data
                    $id_projek = $_SESSION['id_projek'];
                    $id_pekerjaan = $_SESSION['id_m_pekerjaan'];
                    $nama_pekerjaan = $_SESSION['nama_pekerjaan'];

                    //Membuat tabel  berdasarkan kueri
                    $tampil = mysqli_query($conn, "
                        SELECT sp.id_m_sub_pekerjaan, sp.nama_sub_pekerjaan
                        FROM m_sub_pekerjaan AS sp
                        JOIN m_pekerjaan AS pk ON sp.id_m_pekerjaan = pk.id_m_pekerjaan
                        JOIN m_projek AS pj ON pk.id_projek = pj.id_projek
                        WHERE sp.id_m_pekerjaan = '$id_pekerjaan'
                        AND pk.id_m_pekerjaan = '$id_pekerjaan'
                        AND pk.id_projek = pj.id_projek
                        ORDER BY sp.id_m_sub_pekerjaan ASC
                    ");
                    while ($data = mysqli_fetch_array($tampil)) :
                ?>

                <tr>
                    <td><?= $data['id_m_sub_pekerjaan']?></td>
                    <td><?= $data['nama_sub_pekerjaan']?></td>
                    <td>
                        <a href="#" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalHapus<?=$data['id_m_sub_pekerjaan']?>"><i class='bx bxs-trash-alt' style="margin-right: 8px;"> Hapus</i></a>
                        <a href="#" class="btn btn-warning text-dark"  data-bs-toggle="modal" data-bs-target="#modalUbah<?=$data['id_m_sub_pekerjaan']?>"><i class='bx bxs-edit-alt'>Ubah</i></a>
                    </td>
                </tr>
                <?php include "modal.admin/sub_modal.php"; ?>
                <?php endwhile; ?>
                </table>
                
            </div>
        </div>
    </div>
</body>

<?php
    include "../../public/layout/admin/header2.php";
?>