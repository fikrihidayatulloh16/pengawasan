<style>
    .image-container {
    max-width: 100%; /* Batas maksimum lebar gambar sesuai dengan kontainer */
    height: 350px; /* Menjaga rasio aspek gambar */
    
}

.image-container .image-rekap {
    max-width: max-content; /* Gambar akan menyesuaikan dengan lebar kontainer */
    height: 300px; /* Menjaga rasio aspek gambar */
    
}
</style>

<div class="card mt-3">
    <h5 class="card-header">
        Data Lampiran Foto Kegiatan
        <a href="fotokegiatan.php" class="btn btn-edit ms-2 mt-0"><i class='bx bxs-edit-alt'></i>EDIT</a>
    </h5>
    <div class="card-body">
        <div class="container">
            <?php
                $tampil = mysqli_query($conn, "SELECT fk.id_foto_kegiatan, fk.id_laporan_harian, fk.foto, fk.keterangan
                                               FROM foto_kegiatan AS fk
                                               JOIN laporan_harian AS lh ON lh.id_laporan_harian = fk.id_laporan_harian
                                               WHERE fk.id_laporan_harian = '$id_laporan_harian'
                                               AND lh.id_laporan_harian = '$id_laporan_harian'
                                               ORDER BY fk.id_laporan_harian ASC");

                if (mysqli_num_rows($tampil) > 0) {
                    $num_row = 0;
                    while ($data = mysqli_fetch_array($tampil)) {
                        if ($num_row % 2 == 0) {
                            // Mulai baris baru untuk setiap dua gambar
                            echo '<div class="row mt-lg-3">';
                        }
            ?>
            <div class="image-container text-center col-lg-6 col-sm-12">
                <img src="http://localhost/pengawasan_me/public/asset/img/uploads/foto_kegiatan/<?= $data['foto'] ?>" alt="Foto Kegiatan" class="img-fluid image-rekap mt-3"><br><?= $data['keterangan'] ?>
            </div>
            <?php
                        $num_row++;
                        if ($num_row % 2 == 0) {
                            // Tutup baris setelah dua gambar
                            echo '</div>';
                        }
                    }
                    if ($num_row % 2 != 0) {
                        // Tutup baris jika ada gambar ganjil
                        echo '</div>';
                    }
                } else {
            ?>
            <div class="row">
                <div class="col-12 text-center">Tidak ada data Foto Kegiatan.</div>
            </div>
            <?php } ?>
        </div>
    </div>
</div>

<hr class="separator">