<!-- Modal Tambah Foto Kegiatan -->
<div class="modal fade" id="fk_tambah" tabindex="-1" aria-labelledby="fk_tambahLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
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
                    <div class="mb-3">
                        <label for="keterangan" class="form-label">Keterangan</label>
                        <textarea type="text" id="keterangan" name="keterangan" class="form-control"  rows="3" maxlength="255" placeholder="Masukkan Keterangan Foto"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary" name="foto_simpan">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
