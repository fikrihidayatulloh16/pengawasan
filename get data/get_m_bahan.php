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

// SQL untuk mengambil data dari tabel m_bahan
$sql = "SELECT id_m_bahan, nama_bahan, satuan FROM m_bahan";
$result = $conn->query($sql);

// Menampilkan hasil dari tabel m_bahan
echo "<h2>Data Bahan</h2>";
if ($result->num_rows > 0) {
    echo "<table class='table'>";
    echo "<thead><tr><th>ID Bahan</th><th>Nama Bahan</th><th>Satuan</th></tr></thead>";
    echo "<tbody>";
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row["id_m_bahan"]. "</td><td>" . $row["nama_bahan"]. "</td><td>" . $row["satuan"]. "</td></tr>";
    }
    echo "</tbody>";
    echo "</table>";
} else {
    echo "0 results";
}


// Tutup koneksi
$conn->close();
?>
