<?php
// Koneksi ke database (Sesuaikan dengan konfigurasi Anda)
$servername = "localhost";
$username = "root"; // Ganti sesuai username database Anda
$password = ""; // Ganti sesuai password database Anda
$dbname = "pengawasan"; // Ganti sesuai nama database Anda

// Buat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Query SQL untuk mengambil data dari tabel m_projek
$sql = "SELECT * FROM m_projek";
$result = $conn->query($sql);

// Cek apakah ada hasil query
if ($result->num_rows > 0) {
    // Buat tabel HTML untuk menampilkan data
    echo '<table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>ID Proyek</th>
                    <th>Nama Proyek</th>
                    <th>Tanggal Mulai</th>
                    <th>Tanggal Selesai</th>
                    <th>Pemilik Pekerjaan</th>
                    <th>Pengawas</th>
                    <th>Kontraktor</th>
                    <th>Tambahan Waktu</th>
                </tr>
            </thead>
            <tbody>';

    // Output data dari setiap baris hasil query
    while ($row = $result->fetch_assoc()) {
        echo '<tr>
                <td>' . htmlspecialchars($row['id_projek']) . '</td>
                <td>' . htmlspecialchars($row['nama_projek']) . '</td>
                <td>' . htmlspecialchars($row['tanggal_mulai']) . '</td>
                <td>' . htmlspecialchars($row['tanggal_selesai']) . '</td>
                <td>' . htmlspecialchars($row['pemilik_pekerjaan']) . '</td>
                <td>' . htmlspecialchars($row['pengawas']) . '</td>
                <td>' . htmlspecialchars($row['kontraktor']) . '</td>
                <td>' . htmlspecialchars($row['tambahan_waktu']) . '</td>
              </tr>';
    }

    echo '</tbody></table>';
} else {
    echo '<p class="text-center">Belum ada data proyek.</p>';
}

// Tutup koneksi
$conn->close();
?>
