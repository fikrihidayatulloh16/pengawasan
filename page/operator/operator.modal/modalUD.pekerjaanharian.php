<!-- Ubah Pekerja Modal -->
<div class="modal fade" id="ph-pekerja-ubah-<?=$data_pekerja['id_pekerja']?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-secondary text-white">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Ubah Data Pekerja</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="../../script/operator_crud.php" method="POST">
                <input type="hidden" name="id_pekerja" value="<?=$data_pekerja['id_pekerja']?>">
                <input type="hidden" name="id_m_pekerja" value="<?=$data_pekerja['id_m_pekerja']?>">
                <div class="modal-body">
                <div class="mb-3">
                        <div class="container-fluid px-4">
                            <div class="form-group">
                                <label for="id_projek">Projek:</label>
                                <h5><?= $_SESSION['nama_projek_op']?></h5>
                                <h5><?= $_SESSION['id_projek_op']?></h5>
                            </div>
                            <br>
                            <div class="form-group">
                                <label for="pekerjaan">Pekerja :</label>
                                <h5 for="nama_sub_pekerjaan" class="form-label"><?=$data_pekerja['jenis_pekerja']?></h5>
                            </div>
                            <br>
                            <div class="form-group">
                                <label for="jumlah_pekerja">Jumlah :</label>
                                <input class="form-control" type="number" name="jumlah_pekerja" value="<?= $data_pekerja['jumlah_pekerja'] ?>" placeholder="Masukkan jumlah " required>
                            </div>

                        
                             <!-- input tambahan yang diperlukan -->
                            <div class="form-group">
                                <input type="hidden" name="id_laporan_harian" value="<?= $id_laporan_harian?>">
                                <input type="hidden" name="id_sub_pekerjaan" value="<?= $id_sub_pekerjaan?>">
                                
                            </div>
                        
                        </div>
                    </div>
                </div>
                    <div class="modal-footer bg-secondary">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success text-white" name="ph-pekerja-ubah">Submit</button>
                    </div>
            </form>
        </div>
    </div>
</div>

<!-- Hapus Modal Pekerja-->
<div class="modal fade" id="ph-pekerja-hapus-<?=$data_pekerja['id_pekerja']?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-secondary text-white">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Hapus Data Pekerja</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="../../script/operator_crud.php" method="POST">
                <input type="hidden" name="id_pekerja" value="<?=$data_pekerja['id_pekerja']?>">

                <div class="modal-body">
                    <div class="mb-3">
                        <label for="id_pekerja" class="form-label">ID</label>
                        <h5 for="id_pekerja" class="form-label" id="id_pekerja" name="id_pekerja" value="<?= $data_pekerja['id_pekerja']?>"><?=$data_pekerja['id_pekerja']?></h5>
                        <label for="jenis_pekerja" class="form-label">Jenis Pekerja</label>
                        <h5 for="nama_sub_pekerjaan" class="form-label text-danger"><?=$data_pekerja['jenis_pekerja']?></h5>
                        <label for="jenis_pekerja" class="form-label">Jumlah</label>
                        <h5 for="nama_sub_pekerjaan" class="form-label text-danger"><?=$data_pekerja['jumlah_pekerja']?> Orang</h5>
                    </div>
                </div>
                                    
                <div class="modal-footer bg-secondary">
                    <button type="submit" class="btn btn-danger" name="ph-pekerja-hapus">Delete</button>
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
                         
<!-- Ubah Peralatan Modal -->
<div class="modal fade" id="ph-peralatan-ubah-<?=$data_peralatan['id_peralatan']?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-secondary text-white">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Ubah Data Peralatan</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="../../script/operator_crud.php" method="POST">
                <input type="hidden" name="id_peralatan" value="<?=$data_peralatan['id_peralatan']?>">
                <input type="hidden" name="id_m_peralatan" value="<?=$data_peralatan['id_m_peralatan']?>">
                <div class="modal-body">
                    <div class="container-fluid px-4">
                        <div class="mb-3">
                            <label class="form-label">Projek:</label>
                            <p class="mb-0"><?= $_SESSION['nama_projek_op']?></p>
                            <p class="mb-0"><?= $_SESSION['id_projek_op']?></p>
                        </div>
                        <div class="mb-3">
                            <label for="dropdown-peralatan" class="form-label">Nama Peralatan:</label>
                            <h5 for="nama_sub_pekerjaan" class="form-label"><?=$data_peralatan['nama_alat']?></h5>
                        </div>
                        <div class="mb-3">
                            <label for="jumlah-peralatan" class="form-label">Jumlah:</label>
                            <input class="form-control" type="number" id="jumlah-peralatan" name="jumlah_peralatan" value="<?=$data_peralatan['jumlah_peralatan']?>" placeholder="Masukkan Jumlah" required>
                        </div>
                        <input type="hidden" name="id_laporan_harian" value="<?= $id_laporan_harian?>">
                        <input type="hidden" name="id_sub_pekerjaan" value="<?= $id_sub_pekerjaan?>">
                    </div>
                </div>
                                    
                    <div class="modal-footer bg-secondary">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success text-white" name="ph-peralatan-ubah">Submit</button>
                    </div>
            </form>
        </div>
    </div>
</div>

<!-- Hapus Peralatan Pekerja-->
<div class="modal fade" id="ph-peralatan-hapus-<?=$data_peralatan['id_peralatan']?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-secondary text-white">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Hapus Data Peralatan</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="../../script/operator_crud.php" method="POST">
                <input type="hidden" name="id_peralatan" value="<?=$data_peralatan['id_peralatan']?>">

                <div class="modal-body">
                    <div class="mb-3">
                        <label for="id_peralatan" class="form-label">ID</label>
                        <h5 for="id_peralatan" class="form-label" id="id_peralatan" name="id_peralatan" value="<?= $data_peralatan['id_peralatan']?>"><?=$data_peralatan['id_peralatan']?></h5>
                        <label for="nama_alat" class="form-label">Nama Peralatan</label>
                        <h5 for="nama_alat" class="form-label text-danger"><?=$data_peralatan['nama_alat']?></h5>
                        <label for="jumlah_peralatan" class="form-label">Jumlah</label>
                        <h5 for="jumlah_peralatan" class="form-label text-danger"><?=$data_peralatan['jumlah_peralatan']?> <?=$data_peralatan['satuan']?></h5>
                    </div>
                </div>

                <div class="modal-footer bg-secondary">
                    <button type="submit" class="btn btn-danger" name="ph-peralatan-hapus">Delete</button>
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
                         
<!-- Ubah Peralatan Modal -->
<div class="modal fade" id="ph-bahan-ubah-<?=$data_bahan['id_bahan']?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-secondary text-white">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Ubah Data Bahan</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="../../script/operator_crud.php" method="POST">
                <input type="hidden" name="id_bahan" value="<?=$data_bahan['id_bahan']?>">
                <input type="hidden" name="id_m_bahan" value="<?=$data_bahan['id_m_bahan']?>">
                <div class="modal-body">
                    <div class="container-fluid px-4">
                        <div class="mb-3">
                            <label for="dropdown-bahan" class="form-label">Nama Bahan:</label>
                            <h5 for="nama_sub_pekerjaan" class="form-label"><?=$data_bahan['nama_bahan']?></h5>
                        </div>
                        <div class="mb-3">
                            <label for="jumlah-bahan" class="form-label">Jumlah:</label>
                            <input class="form-control" type="number" id="jumlah-bahan" name="jumlah_bahan" value="<?=$data_bahan['jumlah_bahan']?>" placeholder="Masukkan Jumlah" required>
                        </div>
                        <input type="hidden" name="id_laporan_harian" value="<?= $id_laporan_harian?>">
                        <input type="hidden" name="id_sub_pekerjaan" value="<?= $id_sub_pekerjaan?>">
                    </div>
                </div>
                                    
                    <div class="modal-footer bg-secondary">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success text-light" name="ph-bahan-ubah">Submit</button>
                    </div>
            </form>
        </div>
    </div>
</div>

<!-- Hapus bahan-->
<div class="modal fade" id="ph-bahan-hapus-<?=$data_bahan['id_bahan']?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-secondary text-white">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Hapus Data Bahan</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="../../script/operator_crud.php" method="POST">
                <input type="hidden" name="id_bahan" value="<?=$data_bahan['id_bahan']?>">

                <div class="modal-body">
                    <div class="mb-3">
                        <label for="id_bahan" class="form-label">ID</label>
                        <h5 for="id_bahan" class="form-label" id="id_bahan" name="id_bahan" value="<?=$data_bahan['id_bahan']?>"><?=$data_bahan['id_bahan']?></h5>
                        <label for="nama_bahan" class="form-label">Nama Peralatan</label>
                        <h5 for="nama_bahan" class="form-label text-danger"><?=$data_bahan['nama_bahan']?></h5>
                        <label for="jumlah_bahan" class="form-label">Jumlah</label>
                        <h5 for="jumlah_bahan" class="form-label text-danger"><?=$data_bahan['jumlah_bahan']?> <?=$data_bahan['satuan']?></h5>
                    </div>
                </div>

                <div class="modal-footer bg-secondary">
                    <button type="submit" class="btn btn-danger" name="ph-bahan-hapus">Delete</button>
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>