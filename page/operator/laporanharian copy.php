<?php
    include "../../koneksi.php";
    include "../../public/layout/operator/header.laporan.php";

    // Mengambil data projek dari database
    $id_projek = $_SESSION['id_projek_op'];
    $tampil_awal = mysqli_query($conn, "SELECT tanggal_mulai, tanggal_selesai, tambahan_waktu
                                    FROM m_projek AS pj
                                    WHERE id_projek = '$id_projek'");

    while ($data = mysqli_fetch_array($tampil_awal)) : 
                                    $tanggal_mulai = $data['tanggal_mulai'];
                                    $tanggal_selesai = $data['tanggal_selesai'];
                                    $tambahan_waktu = $data['tambahan_waktu'];
                                endwhile;

                                $nama_hari = array(
                                    'Sunday' => 'Minggu',
                                    'Monday' => 'Senin',
                                    'Tuesday' => 'Selasa',
                                    'Wednesday' => 'Rabu',
                                    'Thursday' => 'Kamis',
                                    'Friday' => 'Jumat',
                                    'Saturday' => 'Sabtu'
                                );
                                
                                $nama_bulan = array(
                                    'January' => 'Januari',
                                    'February' => 'Februari',
                                    'March' => 'Maret',
                                    'April' => 'April',
                                    'May' => 'Mei',
                                    'June' => 'Juni',
                                    'July' => 'Juli',
                                    'August' => 'Agustus',
                                    'September' => 'September',
                                    'October' => 'Oktober',
                                    'November' => 'November',
                                    'December' => 'Desember'
                                );

                                
?>
            <?php include 'operator.modal/modalAdd.laporanharian.php' ?>

                <div class="container mt-3">
                    <div class="card mt-100">
                    <h5 class="card-header text-white d-flex align-items-center justify-content-between">
                        <form method="GET" action="">
                        <label for="row_count">Tampilkan Baris:</label>
                        <select id="row_count" name="row_count" onchange="this.form.onClick()">
                            <option value="5" <?= isset($_GET['row_count']) && $_GET['row_count'] == 5 ? 'selected' : '' ?>>5</option>
                            <option value="10" <?= isset($_GET['row_count']) && $_GET['row_count'] == 10 ? 'selected' : '' ?>>10</option>
                            <option value="15" <?= isset($_GET['row_count']) && $_GET['row_count'] == 15 ? 'selected' : '' ?>>15</option>
                            <option value="20" <?= isset($_GET['row_count']) && $_GET['row_count'] == 20 ? 'selected' : '' ?>>20</option>
                        </select>
                    </form>
                        <button type="button" class="btn btn-tambah" data-bs-toggle="modal" data-bs-target="#lh_tambah">
                            <i class='bx bx-plus-medical' style="margin-right: 5px;" name="lh_tambah"></i>ADD
                        </button>
                    </h5>

                            <table class="table-thick-border">
                                
                                    <tr>
                                        <th>No.</th>
                                        <th>Hari Ke-</th>
                                        <th>Tanggal</th>
                                        <th>Progres</th>
                                        <th class="col-2">Aksi</th>
                                    </tr>
                                
                                    <?php
                                        $row_count = 10;
                                        
                                        if (isset($_GET['row_count'])) {
                                            $row_count = (int)$_GET['row_count'];
                                        }
                                        // Mengambil data laporan dari database
                                        $tampil = mysqli_query($conn, "SELECT lp.id_laporan_harian , lp.tanggal AS tanggal_laporan, lp.progress_harian, pj.tanggal_mulai, pj.tanggal_selesai, pj.tambahan_waktu
                                                                    FROM laporan_harian AS lp
                                                                    JOIN m_projek AS pj ON lp.id_projek = pj.id_projek
                                                                    WHERE lp.id_projek = '$id_projek'
                                                                    AND pj.id_projek = '$id_projek'
                                                                    ORDER BY lp.id_laporan_harian  ASC
                                                                    LIMIT $row_count");
                                        $nomor = 1;

                                        while ($data = mysqli_fetch_array($tampil)) : 
                                            $tanggal_laporan_temp = $data['tanggal_laporan'];
                                            $hari = $nama_hari[date('l', strtotime($tanggal_laporan_temp))];
                                            $tanggal = date('d', strtotime($tanggal_laporan_temp));
                                            $bulan = $nama_bulan[date('F', strtotime($tanggal_laporan_temp))];
                                            $tahun = date('Y', strtotime($tanggal_laporan_temp));
                                        
                                            $tanggal_laporan = "$hari, $tanggal $bulan $tahun";

                                            // Menghitung selisih hari
                                            $datetime1 = new DateTime($tanggal_mulai);
                                            $datetime2 = new DateTime($tanggal_laporan_temp); 
                                            $interval = $datetime1->diff($datetime2);
                                            $hari_ke = $interval->days + 1; // Ditambah 1 karena hari pertama adalah hari ke-1
                                            
                                    ?>
                                    
                                        <tr>
                                            <td class="text-center align-middle"><?= $nomor ?></td>
                                                <?php echo "<td class='text-center align-middle'><a name='laporan_pilih' href='../../script/operator.script/laporan_pilih.php?
                                                    id_laporan_harian=" . $data['id_laporan_harian'] . 
                                                    "&tanggal_laporan=" . $tanggal_laporan . 
                                                    "&nomor=" . $hari_ke . 
                                                    "'>Hari-ke " .  $hari_ke . "</a></td>"; 
                                                ?>
                                            <td class="text-center align-middle" style="color:464F60;"><?= $tanggal_laporan ?></td>
                                            <td class="text-center align-middle"><?= $data['progress_harian'] ?></td>
                                            <td>
                                                <form action="../../script/projek_pilih.php" method="POST">
                                                    <a href="#" class="btn btn-aksi" data-bs-toggle="modal" data-bs-target="#lh-hapus-<?=$data['id_laporan_harian']?>"><i class='bx bx-trash' ></i></a>
                                                    <a href="#" class="btn btn-aksi mt-1" data-bs-toggle="modal" data-bs-target="#lh-ubah-<?=$data['id_laporan_harian']?>"><i class='bx bx-edit-alt'></i></a>
                                                    <input type="hidden" name="id_laporan" value="<?=$data['id_laporan_harian']?>">
                                                </form>
                                            </td>
                                        </tr>
                                <?php 
                                    include 'operator.modal/modalUD_laporanharian.php';
                                    $nomor++; 
                                    endwhile; 
                                ?>
                            </table>
                            <nav aria-label="Page navigation example">
                                            <ul class="pagination justify-content-end mt-3 me-3">
                                                <li class="page-item disabled">
                                                <a class="page-link" href="#" aria-label="Previous">
                                                    <span aria-hidden="true">&laquo;</span>
                                                </a>
                                                </li>
                                                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                                <li class="page-item">
                                                <a class="page-link" href="#" aria-label="Next">
                                                    <span aria-hidden="true">&raquo;</span>
                                                </a>
                                                </li>
                                            </ul>
                                        </nav>
                        </div>
                    </div>

<script>

</script>


<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>

<?php include "../../public/layout/footer2.php"; ?>