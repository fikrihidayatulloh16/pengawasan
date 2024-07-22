<?php
include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_laporan_harian = $_POST['id_laporan_harian'];
    $keterangan = $_POST['keterangan'];

    // Periksa apakah id_laporan_harian ada di tabel pekerjaan_harian
    $check_sql = "SELECT id_laporan_harian FROM pekerjaan_harian WHERE id_laporan_harian = ?";
    $check_stmt = $conn->prepare($check_sql);

    if ($check_stmt === false) {
        die("Error preparing the SQL statement: " . $conn->error);
    }

    $check_stmt->bind_param("i", $id_laporan_harian);
    $check_stmt->execute();
    $check_stmt->store_result();

    if ($check_stmt->num_rows === 0) {
        die("Error: id_laporan_harian tidak ditemukan di tabel pekerjaan_harian.");
    }

    $check_stmt->close();

    // Handling file upload
    $foto_name = $_FILES['foto']['name'];
    $foto_temp = $_FILES['foto']['tmp_name'];
    $foto_path = '/opt/lampp/htdocs/pengawasan/page/operator/uploads/' . $foto_name; // Lokasi absolut di server tempat Anda menyimpan gambar

    // Pindahkan file dari temporary location ke lokasi yang ditentukan
    if (move_uploaded_file($foto_temp, $foto_path)) {
        // Ambil ID terbaru dari tabel foto_kegiatan
        $sql = "SELECT id_foto_kegiatan FROM foto_kegiatan ORDER BY id_foto_kegiatan DESC LIMIT 1";
        $result = $conn->query($sql);
        if ($result === false) {
            die("Error executing the SQL statement: " . $conn->error);
        }

        $latest_id = $result->fetch_assoc();
        if ($latest_id) {
            // Jika ada ID, tambahkan 1 ke ID tersebut
            $latest_id_number = (int)substr($latest_id['id_foto_kegiatan'], 3) + 1;
            $new_id = 'FTO' . str_pad($latest_id_number, 6, '0', STR_PAD_LEFT);
        } else {
            // Jika tidak ada ID, mulai dari FTO000001
            $new_id = 'FTO000001';
        }

        // Simpan data ke database
        $sql = "INSERT INTO foto_kegiatan (id_foto_kegiatan, id_laporan_harian, foto, keterangan) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);

        if ($stmt === false) {
            die("Error preparing the SQL statement: " . $conn->error);
        }

        $stmt->bind_param("siss", $new_id, $id_laporan_harian, $foto_name, $keterangan);
        
        if ($stmt->execute()) {
            echo "Data foto kegiatan berhasil disimpan.";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Gagal mengunggah file.";
    }

    $conn->close();
}
?>
