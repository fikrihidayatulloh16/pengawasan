<?php
$servername = "localhost";
$username = "root"; // username default XAMPP
$password = ""; // password default XAMPP
$dbname = "pengawasan"; // ganti ini dengan nama database kamu

// Buat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// SQL untuk mengambil data dari tabel m_pekerjaan
$sql = "SELECT id_m_pekerjaan, nama_pekerjaan FROM m_pekerjaan";
$result = $conn->query($sql);

// Menampilkan hasil dari tabel m_pekerjaan
echo "<h2>Data Pekerjaan</h2>";
if ($result->num_rows > 0) {
    echo "<table class='table'>";
    echo "<thead><tr><th>ID Pekerjaan</th><th>Nama Pekerjaan</th></tr></thead>";
    echo "<tbody>";
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row["id_m_pekerjaan"]. "</td><td>" . $row["nama_pekerjaan"]. "</td></tr>";
    }
    echo "</tbody>";
    echo "</table>";
} else {
    echo "0 results";
}

// Tutup koneksi
$conn->close();
?>
