    <!-- Ubah Modal -->
    <div class="modal fade" id="modalUbah<?=$data['id_m_sub_pekerjaan']?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Ubah Master Sub Pekerjaan</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="../../script/insert.php" method="POST">
                <input type="hidden" name="id_m_sub_pekerjaan" value="<?=$data['id_m_sub_pekerjaan']?>">
                <div class="modal-body">                    
                    <div class="mb-3">
                        <label for="id_m_sub_pekerjaan" class="form-label">ID (Tidak Bisa Diubah)</label>
                        <h5 for="id_m_sub_pekerjaan" class="form-label"><?=$data['id_m_sub_pekerjaan']?></h5>
                        <label for="nama_sub_pekerjaan" class="form-label">Nama Sub Pekerjaan</label>
                        <input type="text" class="form-control" id="nama_sub_pekerjaan" name="nama_sub_pekerjaan" value="<?= $data['nama_sub_pekerjaan']?>" placeholder="Masukkan Nama Sub Pekerjaan" required><br><br>
                    </div>
                </div>
                                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-warning text-dark" name="sub_ubah">Ubah</button>
                    </div>
            </form>
        </div>

        </div>
                            </div>


        <!-- Hapus Modal -->
                            <div class="modal fade" id="modalHapus<?=$data['id_m_sub_pekerjaan']?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header bg-danger text-dark">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Hapus Master Pekerjaan</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="../../script/insert.php" method="POST">
                                    <input type="hidden" name="id_m_sub_pekerjaan" value="<?=$data['id_m_sub_pekerjaan']?>">
                                        <div class="modal-body">
                                            
                                            <div class="mb-3">
                                                <label for="id_m_sub_pekerjaan" class="form-label">ID</label>
                                                <h5 for="id_m_sub_pekerjaan" class="form-label" id="id_m_sub_pekerjaan" name="id_m_sub_pekerjaan" value="<?= $data['id_m_sub_pekerjaan']?>"><?=$data['id_m_sub_pekerjaan']?></h5>
                                                <label for="jenis_pekerja" class="form-label">Jenis Pekerja</label>
                                                <h5 for="nama_sub_pekerjaan" class="form-label text-danger"><?=$data['nama_sub_pekerjaan']?></h5>
                                            </div>
                                        </div>
                                    
                                        <div class="modal-footer">
                                        <button type="submit" class="btn btn-danger" name="sub_hapus">Hapus</button>
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                        </div>
                                    </form>
                                </div>
                                </div>
                            </div>
                            