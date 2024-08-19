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
            <div class="modal-header bg-secondary text-white">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Laporan Harian</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="../../script/operator_crud.php" method="POST">
                <input type="hidden" name="id_projek" value="<?= $_SESSION['id_projek_op']?>">
                <div class="modal-body">
                    <div class="mb-3">
                        <div class="container-fluid px-4">
                            <div class="form-group">
                                <strong><?= $_SESSION['nama_projek_op']?></strong>
                                <h5>Tanggal Mulai : <?= $tanggal_mulai?></h5>
                                <h5>Tanggal Selesai : <?= $tanggal_selesai?></h5>
                                <h5>Tambahan Waktu : <?= $tambahan_waktu ? $tambahan_waktu : 'Tidak ada' ?></h5>
                            </div>
                            <br>
                            <div class="form-group">
                                <label for="tanggal"><t class="text-danger">*</t>Tanggal:</label>
                                <input type="date" id="tanggal" name="tanggal" class="form-control" required>
                                <small id="tanggalError_tambah" class="form-text text-danger" style="display:none;">*Tanggal harus dalam rentang .</small>
                            </div>
                            <br>
                            <div class="form-group">
                                <label for="pekerjaan"><t class="text-danger">*</t>Pekerjaan :</label>
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
                                ?>
                                
                                <div class="mt-3">
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
                            <br>
                            <small id="checkboxError" class="text-danger" style="display: none;">Data Pekerjaan Wajib di isi.</small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-secondary d-flex justify-content-between align-items-center">
                    <div>
                    <span class="text-white me-2">(<span class="text-white">*</span>) Wajib Disi</span>
                    <small id="modalError" class="text-danger" style="display: none;">*Periksa kembali form</small>
                    </div>
                    <div>
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success" name="lh_simpan">Submit</button>
                    </div>
                </div>

                </div>
            </form>
        </div>
    </div>
</div>

<script>
    //Vailidasi tanggal
        document.addEventListener("DOMContentLoaded", function() {
        // Function to validate date input
        function validateDateRange(startDate, endDate, additionalDate, inputDate, errorElement) {
            var startDateValue = new Date(startDate);
            var endDateValue = new Date(endDate);
            var inputDateValue = new Date(inputDate.value);
            var additionalDateValue = additionalDate ? new Date(additionalDate) : null;

            // Clear previous error
            errorElement.style.display = 'none';

            // Validate that input date is within the range of start and end date (or additional date if exists)
            if (inputDateValue < startDateValue || (additionalDateValue ? inputDateValue > additionalDateValue : inputDateValue > endDateValue)) {
                errorElement.style.display = 'block';
                return false;
            }

            return true;
        }

        // Event listener for form submission
        document.getElementById('lh_tambah').addEventListener('submit', function(event) {
            var startDate = "<?= $tanggal_mulai ?>";
            var endDate = "<?= $tanggal_selesai ?>";
            var additionalDate = "<?= $tambahan_waktu ?>";
            var inputDate = document.getElementById('tanggal');
            var errorElement = document.getElementById('tanggalError_tambah');

            if (!validateDateRange(startDate, endDate, additionalDate, inputDate, errorElement)) {
                event.preventDefault();
            }
        });
    });

    //JS Check Box
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

    //JS validasi checkbox
    document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form'); // pastikan Anda menarget form yang benar
    const checkboxes = document.querySelectorAll('#checkboxes input[type="checkbox"]');
    const errorElement = document.getElementById('checkboxError');

    form.addEventListener('submit', function(event) {
        let isChecked = false;

        checkboxes.forEach(function(checkbox) {
            if (checkbox.checked) {
                isChecked = true;
            }
        });

        if (!isChecked) {
            event.preventDefault();
            errorElement.style.display = 'block';
        } else {
            errorElement.style.display = 'none';
        }
    });
});

// JavaScript untuk menampilkan modalError jika terjadi kesalahan
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form'); // pastikan Anda menarget form yang benar
    const checkboxes = document.querySelectorAll('#checkboxes input[type="checkbox"]');
    const errorElement = document.getElementById('checkboxError');
    const modalError = document.getElementById('modalError');

    form.addEventListener('submit', function(event) {
        let isChecked = false;

        checkboxes.forEach(function(checkbox) {
            if (checkbox.checked) {
                isChecked = true;
            }
        });

        if (!isChecked) {
            event.preventDefault();
            errorElement.style.display = 'block';
            modalError.style.display = 'block'; // Tampilkan pesan modalError
        } else {
            errorElement.style.display = 'none';
            modalError.style.display = 'none'; // Sembunyikan pesan modalError
        }

        // Validasi tanggal
        var startDate = "<?= $tanggal_mulai ?>";
        var endDate = "<?= $tanggal_selesai ?>";
        var additionalDate = "<?= $tambahan_waktu ?>";
        var inputDate = document.getElementById('tanggal');
        var dateErrorElement = document.getElementById('tanggalError_tambah');

        if (!validateDateRange(startDate, endDate, additionalDate, inputDate, dateErrorElement)) {
            event.preventDefault();
            modalError.style.display = 'block'; // Tampilkan pesan modalError jika tanggal tidak valid
        } else {
            dateErrorElement.style.display = 'none';
        }
    });
});


</script>



