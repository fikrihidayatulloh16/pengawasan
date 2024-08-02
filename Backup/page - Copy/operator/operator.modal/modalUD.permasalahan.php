    <!-- Ubah Modal Permasalahan-->
<div class="modal fade" id="modalUbah<?=$data['id_permasalahan']?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Ubah Data Permasalahan</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="../../script/operator_crud.php" method="POST">
                <input type="hidden" name="id_permasalahan" value="<?=$data['id_permasalahan']?>">
                <div class="modal-body">                    
                    <div class="mb-3">
                        <div class="form-group">
                            <label for="id_permasalahan" class="form-label">ID (Tidak Bisa Diubah)</label>
                            <h5 for="id_permasalahan" class="form-label"><?=$data['id_permasalahan']?></h5>
                        </div>

                        <div class="form-group">
                            <label for="permasalahan">Permasalahan:</label>
                            <textarea type="text" id="permasalahan" name="permasalahan" class="form-control"  rows="3" maxlength="255" value="<?= $data['permasalahan']?>" placeholder="Masukkan Permasalahan" required></textarea>
                        </div>
                        <br>
                        <div class="form-group">
                            <label for="saran">Saran :</label>
                            <textarea type="text" id="saran" name="saran" class="form-control"  rows="3" maxlength="255" value="<?= $data['saran']?>" placeholder="Masukkan Saran" required></textarea>
                        </div>
                    </div>
                </div>
                                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-warning text-dark" name="masalah_ubah">Ubah</button>
                    </div>
            </form>
        </div>
    </div>
</div>

<!-- Hapus Modal Permasalahan-->
<div class="modal fade" id="modalHapus<?=$data['id_permasalahan']?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-dark">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Hapus Data Permasalahan</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="../../script/operator_crud.php" method="POST">
                <input type="hidden" name="id_permasalahan" value="<?=$data['id_permasalahan']?>">

                <div class="modal-body">
                    <div class="mb-3">
                        <div class="form-group">
                            <label for="id_permasalahan" class="form-label">ID (Tidak Bisa Diubah)</label>
                            <h5 for="id_permasalahan" class="form-label"><?=$data['id_permasalahan']?></h5>
                        </div>

                        <div class="form-group">
                            <label for="permasalahan">Permasalahan:</label>
                            <h5 for="id_permasalahan" class="form-label text-danger"><?= $data['permasalahan']?></h5>
                          
                        </div>
                        <br>
                        <div class="form-group">
                            <label for="saran">Saran :</label>
                            <h5 for="id_permasalahan" class="form-label text-danger"><?= $data['saran']?></h5>
                        </div>
                    </div>
                </div>
                                    
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger" name="masalah_hapus">Hapus</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </form>
        </div>
    </div>
</div>
                            