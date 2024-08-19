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

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

            <?php include 'operator.modal/modalAdd.laporanharian.php' ?>

            <div class="container mt-4">
    <div class="card mt-100">
        <h5 class="card-header text-white d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center">
            <form>
                <label for="row_count">Tampilkan Baris:</label>
                <select id="row_count" name="row_count" onchange="updateTable()">
                    <option value="15" selected>15</option>
                    <option value="30">30</option>
                    <option value="60">60</option>
                    <option value="all">Semua</option>
                </select>
            </form>
            </div>
            <button type="button" class="btn btn-tambah" data-bs-toggle="modal" data-bs-target="#lh_tambah">
                <i class='bx bx-plus-medical' style="margin-right: 5px;" name="lh_tambah"></i>ADD
            </button>
        </h5>

        <table class="table-thick-border" id="myTable">
            <thead>
                <tr>
                    <th>No. <i id="icon0" class="fas fa-sort sort-icon" onclick="sortTable(0)"></i></th>
                    <th>Hari Ke- <i id="icon1" class="fas fa-sort sort-icon" onclick="sortTable(1)"></i></th>
                    <th>Tanggal <i id="icon2" class="fas fa-sort sort-icon" onclick="sortTable(2)"></i></th>
                    <th>Progres <i id="icon3" class="fas fa-sort sort-icon" onclick="sortTable(3)"></i></th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody id="table-body">
                                
                                    <?php
                                    
                                        
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
                                                                    ");
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
                                                    <a href="#" class="btn btn-aksi mt-1" data-bs-toggle="modal" data-bs-target="#lh-ubah-<?=$data['id_laporan_harian']?>"><i class="bx bx-download"></i></a>
                                                    <input type="hidden" name="id_laporan" value="<?=$data['id_laporan_harian']?>">
                                                </form>
                                            </td>
                                        </tr>
                <?php include 'operator.modal/modalUD_laporanharian.php'; $nomor++; endwhile; ?>
            </tbody>
        </table>

        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-end mt-3 me-3" id="pagination">
                <!-- Pagination dynamically generated by JavaScript -->
            </ul>
        </nav>
    </div>
</div>

<script src="http://localhost/pengawasan_me/public/asset/js/laporan_harian.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>

<?php include "../../public/layout/footer2.php"; ?>