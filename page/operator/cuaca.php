<?php
// Menghubungkan ke database
include "../../koneksi.php";
include "../../public/layout/operator/header.operator.php";

//mengambil nilai sesi
if (empty($_SESSION['id_laporan_harian'])) {
    if (isset($_GET['id_laporan_harian']) && isset($_GET['tanggal_laporan']) && isset($_GET['nomor'])) {
        $id_laporan_harian = $_GET['id_laporan_harian'];
        $tanggal_laporan = $_GET['tanggal_laporan'];
        $nomor = $_GET['nomor'];

        $_SESSION['id_laporan_harian'] = $id_laporan_harian;
        $_SESSION['tanggal_laporan'] = $tanggal_laporan;
        $_SESSION['nomor'] = $nomor;
    }
}

$id_laporan_harian = $_SESSION['id_laporan_harian'];

// Query untuk menampilkan data cuaca
$query = "SELECT c.id_cuaca, c.jam_mulai, c.jam_selesai, c.kondisi 
            FROM cuaca AS c 
            JOIN laporan_harian AS lh ON c.id_laporan_harian = lh.id_laporan_harian
            WHERE  c.id_laporan_harian = '$id_laporan_harian'
            AND lh.id_laporan_harian = '$id_laporan_harian'
            ORDER BY id_cuaca ASC";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Query error: " . mysqli_error($conn));
}
?>
    <style>
        /* Custom CSS untuk menyesuaikan tabel */
        .table {
            border-color: #000; /* Warna garis tabel menjadi hitam */
        }
        .table th, .table td {
            padding: 1rem; /* Mengurangi padding agar jarak antar kolom lebih kecil */
        }
        .text-center {
            text-align: center; /* Mengatur teks di tengah untuk kelas text-center */
        }

        body {
            background-color: #f0f0f0;
        }
    </style>

<a href="laporanharian.php" class="btn btn-secondary mt-2 ms-3" style="right: 0;">
        <i class='bx bx-arrow-back'></i>Kembali
</a>

<div class="container">
    <h1 class="mt-4">Data Cuaca</h1>
    <div class="card">
        <h5 class="card-header bg-primary text-white text-center">Daftar Cuaca</h5>
        <div class="card-body">
            <div class="table-responsive">
                <form method="post" action="../../script/operator_crud.php">
                    <div class="text-left pb-3">
                        <button type="submit" class="btn btn-info" name="cuaca_ubah">Simpan</button>
                    </div>

                    <table class="table table-striped table-bordered table-sm text-center">
                        <thead>
                            <tr>
                                <th>Jam Mulai</th>
                                <th>Jam Selesai</th>
                                <th>Kondisi Cuaca</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($data = mysqli_fetch_assoc($result)) : ?>
                                <tr>
                                    <td><?= $data['jam_mulai'] ?></td>
                                    <td><?= $data['jam_selesai'] ?></td>
                                    <td>
                                        <input type="hidden" name="id_cuaca[]" value="<?= $data['id_cuaca'] ?>">
                                        <select class="form-select" name="kondisi[]">
                                            <option value="cerah" <?= ($data['kondisi'] == 'cerah') ? 'selected' : '' ?>>Cerah</option>
                                            <option value="hujan" <?= ($data['kondisi'] == 'hujan') ? 'selected' : '' ?>>Hujan</option>
                                        </select>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
    include "../../public/layout/operator/footer.operator.php";
?>
