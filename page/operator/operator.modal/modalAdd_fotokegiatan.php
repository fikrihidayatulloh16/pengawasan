<!-- Modal Tambah Foto Kegiatan -->
<div class="modal fade" id="fk_tambah" tabindex="-1" aria-labelledby="fk_tambahLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-secondary text-white">
                <h5 class="modal-title" id="fk_tambahLabel">Tambah Foto Kegiatan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="../../script/operator_crud.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id_laporan_harian" value="<?= $id_laporan_harian ?>">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="inputFoto" class="form-label">Foto</label>
                        <input type="file" class="form-control" id="foto" name="foto" accept="image/*" required>
                    </div>
                    <!-- Preview Gambar -->
                    <div class="mb-3">
                        <img id="preview-image" src="#" alt="Preview Foto" style="display: none; max-width: 100%; height: auto;">
                    </div>
                    <div class="mb-3">
                        <label for="keterangan" class="form-label">Keterangan</label>
                        <textarea type="text" id="keterangan" name="keterangan" class="form-control"  rows="3" maxlength="255" placeholder="Masukkan Keterangan Foto"></textarea>
                    </div>
                </div>
                <div class="modal-footer bg-secondary">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success" name="foto_simpan">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.getElementById('foto').onchange = function(event) {
        const reader = new FileReader();
        reader.onload = function(){
            const preview = document.getElementById('preview-image');
            preview.src = reader.result;
            preview.style.display = 'block';
        }
        reader.readAsDataURL(event.target.files[0]);
    };
</script>
