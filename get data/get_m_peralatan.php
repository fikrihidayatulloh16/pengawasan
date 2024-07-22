<?php
// Koneksi ke database
$servername = "localhost";
$username = "root"; // sesuaikan dengan username database Anda
$password = ""; // sesuaikan dengan password database Anda
$dbname = "pengawasan"; // sesuaikan dengan nama database Anda

// Buat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Query SQL untuk mengambil data dari tabel m_peralatan
$sql = "SELECT id_m_peralatan, nama_alat, satuan FROM m_peralatan";
$result = $conn->query($sql);

// Cek jika hasilnya lebih dari 0 baris
if ($result->num_rows > 0) {
    // Output data dari setiap baris
    echo "<table class='table'>";
    echo "<thead><tr><th>ID Peralatan</th><th>Nama Alat</th><th>Satuan</th></tr></thead>";
    echo "<tbody>";
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row["id_m_peralatan"]. "</td><td>" . $row["nama_alat"]. "</td><td>" . $row["satuan"]. "</td></tr>";
    }
    echo "</tbody>";
    echo "</table>";
} else {
    echo "0 results";
}

// Tutup koneksi database
$conn->close();
?>
