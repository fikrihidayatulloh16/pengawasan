
<!-- Daftar Sub Pekerjaan Dengan Accordion -->

<?php include "modal.admin/modalAdd_sub.php"; ?>

<tr>
    <td class="p-0" colspan="3">
        <div id="collapseOne<?= $data['id_m_pekerjaan'] ?>" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
            <div class="accordion-body p-0">
                <div class="card ">
                    <h5 class="card-header bg-info text-dark mt-0">
                        Sub Pekerjaan
                    </h5>
                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#subTambah<?= $data['id_m_pekerjaan'] ?>">
                    <i class='bx bx-plus-medical' width='500px' name="btambah"></i> Tambah Sub Pekerjaan</button>
                    <table class="table bg-light table-striped table-borderless m-0">
                        <thead>
                            <tr class="bg-light">
                                <th class=" align-middle  col-2">ID</th>
                                <th class="align-middle">Nama Sub pekerjaan</th>
                                <th class="align-middle col-2">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            //menampilkan data
                            $id_pekerjaan = $data['id_m_pekerjaan'];
                            $tampil_sub = mysqli_query($conn, "
                                SELECT sp.id_m_sub_pekerjaan, sp.nama_sub_pekerjaan
                                FROM m_sub_pekerjaan AS sp
                                JOIN m_pekerjaan AS pk ON sp.id_m_pekerjaan = pk.id_m_pekerjaan
                                JOIN m_projek AS pj ON pk.id_projek = pj.id_projek
                                WHERE sp.id_m_pekerjaan = '$id_pekerjaan'
                                AND pk.id_m_pekerjaan = '$id_pekerjaan'
                                AND pk.id_projek = pj.id_projek
                                ORDER BY sp.id_m_sub_pekerjaan ASC
                            ");
                            while ($data_sub = mysqli_fetch_array($tampil_sub)) :
                            ?>
                            <tr class="bg-light">
                                <td class="align-middle bg-light"><?= $data_sub['id_m_sub_pekerjaan'] ?></td>
                                <td class="align-middle bg-light"><?= $data_sub['nama_sub_pekerjaan'] ?></td>
                                <td class="align-middle bg-light">
                                    <a href="#" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#subHapus<?= $data_sub['id_m_sub_pekerjaan']?>"><i class='bx bxs-trash-alt'><span> Hapus</span></i></a>
                                    <a href="#" class="btn btn-warning text-dark mt-1" data-bs-toggle="modal" data-bs-target="#subUbah<?= $data_sub['id_m_sub_pekerjaan'] ?>"><i class='bx bxs-edit-alt'><span> Ubah</span></i></a>
                                </td>
                            </tr>
                            
                            <?php include "modal.admin/modalUD_sub.php";?>
                            <?php endwhile; ?>
                            <tr><td class="bg-info" colspan="3"></td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </td>
</tr>