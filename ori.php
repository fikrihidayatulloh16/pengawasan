<div class="form-group">
                                <label for="pekerjaan">Pekerjaan :</label>
                                <div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        Pilih Master Pekerjaan
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-secondary">
                                        <?php
                                            //menampilkan data pekerjaan berdasarkan projek
                                            include "../../koneksi.php";
                                            $id_projek = $_SESSION['id_projek_op'];

                                            $tampil_pk = mysqli_query($conn, "SELECT id_m_pekerjaan, nama_pekerjaan FROM m_pekerjaan AS pk, m_projek AS pj WHERE pk.id_projek = '$id_projek' AND pj.id_projek = '$id_projek' ORDER BY id_m_pekerjaan ASC");
                                            while ($data_pk = mysqli_fetch_array($tampil_pk)) : 

                                            ?>
                                                <li><a class="dropdown-item" href="#" onclick="showSubPekerjaan(<?= $data_pk['id_m_pekerjaan'] ?>)"><?= $data_pk['nama_pekerjaan']?></a></li>
                                                <?php endwhile; ?>
                                    </ul>
                                </div>
                            </div>
                            <br>
                                        <?php
                                            $tampil_sp = mysqli_query($conn, "
                                                SELECT sp.id_m_sub_pekerjaan, sp.nama_sub_pekerjaan,  pk.id_m_pekerjaan, pk.nama_pekerjaan
                                                FROM m_sub_pekerjaan AS sp
                                                JOIN m_pekerjaan AS pk ON sp.id_m_pekerjaan = pk.id_m_pekerjaan
                                                JOIN m_projek AS pj ON pk.id_projek = pj.id_projek
                                                WHERE pk.id_projek = '$id_projek'
                                                AND pj.id_projek = '$id_projek'
                                                ORDER BY sp.id_m_sub_pekerjaan ASC
                                            ");
                                            while ($data_sp = mysqli_fetch_array($tampil_sp)) : 
                                        ?>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="options[]" value="<?= $data_sp['id_m_sub_pekerjaan']; ?>" id="option<?= $data_sp['id_m_sub_pekerjaan']; ?>">
                                            <label class="form-check-label" for="option<?= $data_sp['id_m_sub_pekerjaan']; ?>"><?= $data_sp['nama_sub_pekerjaan']; ?></label>
                                        </div>
                                        <?php endwhile; ?>