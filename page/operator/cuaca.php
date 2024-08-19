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

<div class="container mt-5">
    <div class="card">
        <form method="post" action="../../script/operator_crud.php">
        <h5 class="card-header">
            Daftar Cuaca
        <div class="text-left pb-3">
            <button type="submit" class="btn btn-tambah" name="cuaca_ubah"><i class='bx bx-download'></i>Save</button>
        </div>
        </h5>
            <div class="table-responsive">
                    <table class="table-thick-border table-sm text-center" style="width: 100%;">
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
                                    <td style="align-items: middle;">
                                        <input type="hidden" name="id_cuaca[]" value="<?= $data['id_cuaca'] ?>">
                                        <select class="form-select text-center" name="kondisi[]">
                                            <option value="cerah" <?= ($data['kondisi'] == 'cerah') ? 'selected' : '' ?>>Cerah</option>
                                            <option value="gerimis" <?= ($data['kondisi'] == 'gerimis') ? 'selected' : '' ?>>Gerimis</option>
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

<div class="container">
        <a href="pekerjaan.php" class="btn btn-kembali mt-2">
        <i class='bx bxs-chevrons-left'></i>Kembali
    </a>
</div>

<?php
    include "../../public/layout/footer.php";
?>
