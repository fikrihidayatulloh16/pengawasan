<!-- Modal Ubah Foto Kegiatan -->
<div class="modal fade" id="fk_ubah<?= $data['id_foto_kegiatan']?>" tabindex="-1" aria-labelledby="fk_tambahLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-secondary text-white">
                <h5 class="modal-title" id="fk_tambahLabel">Ubah Foto Kegiatan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="../../script/operator_crud.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id_foto_kegiatan" value="<?= $data['id_foto_kegiatan'] ?>">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="inputFoto" class="form-label">Foto</label>
                        <input type="file" class="form-control" id="foto-ubah-<?= $data['id_foto_kegiatan']?>" name="foto" accept="image/*">
                    </div>
                    <!-- Preview Gambar -->
                    <div class="mb-3">
                        <img id="preview-image-ubah-<?= $data['id_foto_kegiatan']?>" src="http://localhost/pengawasan_me/public/asset/img/uploads/foto_kegiatan/<?= $data['foto'] ?>" alt="Preview Foto" style="max-width: 100%; height: auto;">
                    </div>
                    <div class="mb-3">
                        <label for="keterangan" class="form-label">Keterangan</label>
                        <textarea type="text" id="keterangan" name="keterangan" class="form-control" rows="3" maxlength="255" placeholder="Masukkan Keterangan Foto"><?= $data['keterangan'] ?></textarea>
                    </div>
                </div>
                <div class="modal-footer bg-secondary">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success" name="foto-ubah">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Hapus foto kegiatan modal-->
<div class="modal fade" id="fk_hapus<?= $data['id_foto_kegiatan'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-secondary text-light">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Hapus Foto Kegiatan</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="../../script/operator_crud.php" method="POST">
                <input type="hidden" name="id_foto_kegiatan" value="<?=$data['id_foto_kegiatan']?>">

                <div class="modal-body">
                    <div class="mb-3">
                        <label for="id_foto_kegiatan" class="form-label">ID</label>
                        <h5 for="id_foto_kegiatan" class="form-label" id="id_foto_kegiatan" name="id_foto_kegiatan" value="<?= $data['id_foto_kegiatan']?>"><?=$data['id_foto_kegiatan']?></h5>
                        <label for="foto" class="form-label">Foto</label>
                        <img id="foto" src="http://localhost/pengawasan_me/public/asset/img/uploads/foto_kegiatan/<?= $data['foto'] ?>" alt="Preview Foto" style="max-width: 100%; height: auto;">
                        <br>
                        <label for="keterangan" class="form-label mt-3">Keterangan</label>
                        <p for="keterangan" class="form-label text-danger"><?=$data['keterangan']?></p>
                    </div>
                </div>
                                    
                <div class="modal-footer bg-secondary">
                    <button type="submit" class="btn btn-danger" name="foto-hapus">Delete</button>
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.getElementById('foto-ubah-<?= $data['id_foto_kegiatan']?>').onchange = function(event) {
        const reader = new FileReader();
        reader.onload = function(){
            const preview = document.getElementById('preview-image-ubah-<?= $data['id_foto_kegiatan']?>');
            preview.src = reader.result;
        }
        reader.readAsDataURL(event.target.files[0]);
    };
</script>
