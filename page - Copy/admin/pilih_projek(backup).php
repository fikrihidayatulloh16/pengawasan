<?php
    include "../../koneksi.php";
    include "../../public/layout/admin/header.php";
?>

<body>
    <!-- Modal masukkan projek -->
    <div class="modal fade" id="pilih_projek" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Pilih Projek</h1>
                </div>
                <form method="POST">
                    <input type="hidden" name="id_projek" id="id_projek" value="">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nama_projek" class="form-label">Pilih Projek untuk menampilkan data pekerjaan</label>
                                <label for="kategori">Pilih Kategori:</label>
                                <select name="kategori" id="kategori">
                                    <?php
                                    // Loop untuk menampilkan data dalam dropdown
                                    $tampil = mysqli_query($conn, "SELECT * FROM m_projek ORDER BY id_projek ASC");
                                    while ($row = $tampil->fetch_assoc()) {
                                        echo "<option value='" . $row['id_projek'] . "'>".$row['id_projek'] . $row['nama_projek'] . "</option>";
                                    }

                                    ?>
                                </select>
                                <br><br>
                                <input type="submit" value="Submit">
                        </div>
                    </div>

                    

                    <div class="modal-footer">
                        <button type="submit" data-bs-dismiss="modal" class="btn btn-success" name="projek_pilih">Pilih</button>
                    </div>
                </form>
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

        // Tampilkan modal saat halaman dimuat
        window.onload = function() {
            var myModal = new bootstrap.Modal(document.getElementById('pilih_projek'), {
                backdrop: 'static',
                keyboard: false
            });
            myModal.show();
        };
    </script>

</body>

<?php
    include "../../public/layout/admin/header2.php";
?>