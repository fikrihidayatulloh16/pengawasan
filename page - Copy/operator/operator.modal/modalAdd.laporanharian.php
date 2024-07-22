<?php
include "../../koneksi.php";
$id_projek = $_SESSION['id_projek_op'];
?>

<style>
    .hidden {
        display: none;
    }
</style>

<!-- Tambah Modal -->
<div class="modal fade" id="lh_tambah" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Laporan Harian</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="../../script/operator_crud.php" method="POST">
                <input type="hidden" name="id_projek" value="<?= $_SESSION['id_projek_op']?>">
                <div class="modal-body">
                    <div class="mb-3">
                        <div class="container-fluid px-4">
                            <div class="form-group">
                                <label for="id_projek">Projek:</label>
                                <h5><?= $_SESSION['nama_projek_op']?></h5>
                            </div>
                            <br>
                            <div class="form-group">
                                <label for="tanggal">Tanggal:</label>
                                <input type="date" id="tanggal" name="tanggal" class="form-control" required>
                            </div>
                            <br>
                            <div class="form-group">
                                <label for="pekerjaan">Pekerjaan :</label>
                                <select id="dropdown" name="id_m_pekerjaan" class="form-select form-select-lg" aria-label="Pilih Pekerjaan">
                                    <option value="" disabled selected>Pilih Pekerjaan</option>
                                    <?php
                                    // Menampilkan data pekerjaan berdasarkan projek
                                    $tampil_pk = mysqli_query($conn, "SELECT id_m_pekerjaan, nama_pekerjaan 
                                                                    FROM m_pekerjaan AS pk, m_projek AS pj 
                                                                    WHERE pk.id_projek = '$id_projek' AND pj.id_projek = '$id_projek' 
                                                                    ORDER BY id_m_pekerjaan ASC");
                                    while ($data_pk = mysqli_fetch_array($tampil_pk)) : 
                                    ?>
                                        <option class="dropdown-item mt-3" value="<?= $data_pk['id_m_pekerjaan'] ?>"><?= $data_pk['nama_pekerjaan'] ?></option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                            <br>
                            <div id="checkboxes" require>
                                <?php
                                $tampil_sp = mysqli_query($conn, "SELECT pk.id_m_pekerjaan, pk.nama_pekerjaan, sp.id_m_sub_pekerjaan, sp.nama_sub_pekerjaan
                                    FROM m_sub_pekerjaan AS sp
                                    JOIN m_pekerjaan AS pk ON sp.id_m_pekerjaan = pk.id_m_pekerjaan
                                    JOIN m_projek AS pj ON pk.id_projek = pj.id_projek
                                    WHERE pk.id_projek = '$id_projek'
                                    AND pj.id_projek = '$id_projek'
                                    ORDER BY pk.id_m_pekerjaan ASC
                                ");
                                $current_pekerjaan_id = null;
                                while ($data_sp = mysqli_fetch_array($tampil_sp)) :
                                    // Jika pekerjaan baru, buat div baru
                                    if ($data_sp['id_m_pekerjaan'] !== $current_pekerjaan_id) {
                                        // Tutup div sebelumnya jika ada
                                        if ($current_pekerjaan_id !== null) {
                                            echo '</div>';
                                        }
                                        // Buka div baru untuk pekerjaan baru
                                        echo '<div id="' . $data_sp['id_m_pekerjaan'] . '" class="hidden">';
                                        $current_pekerjaan_id = $data_sp['id_m_pekerjaan'];
                                    }
                                ?><div class="mt-3">
                                        <input class="form-check-input" type="checkbox" name="box_sp[]" value="<?= $data_sp['id_m_sub_pekerjaan']?>" require>
                                        <label class="" for="<?= $data_sp['id_m_sub_pekerjaan']?>"><?= $data_sp['nama_sub_pekerjaan']?></label><br>
                                    </div>
                                <?php endwhile; ?>
                                <?php
                                // Tutup div terakhir setelah selesai looping
                                if ($current_pekerjaan_id !== null) {
                                    echo '</div>';
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary" name="lh_simpan">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.getElementById('dropdown').addEventListener('change', function() {
        var selectedOption = this.value;
        var checkboxes = document.getElementById('checkboxes').children;

        for (var i = 0; i < checkboxes.length; i++) {
            checkboxes[i].classList.add('hidden');
        }

        document.getElementById(selectedOption).classList.remove('hidden');
    });

    // Saat halaman dimuat, sembunyikan semua opsi checkbox kecuali yang pertama dipilih
    window.addEventListener('DOMContentLoaded', function() {
        var selectedOption = document.getElementById('dropdown').value;
        var checkboxes = document.getElementById('checkboxes').children;

        for (var i = 0; i < checkboxes.length; i++) {
            checkboxes[i].classList.add('hidden');
        }

        document.getElementById(selectedOption).classList.remove('hidden');
    });
</script>


<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
