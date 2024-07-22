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

// SQL untuk mengambil data dari tabel m_jam
$sql = "SELECT id_m_jam, jam_mulai, jam_selesai FROM m_jam";
$result = $conn->query($sql);

// Menampilkan hasil dari tabel m_jam
echo "<h2>Data Jam</h2>";
if ($result->num_rows > 0) {
    echo "<table class='table'>";
    echo "<thead><tr><th>ID Jam</th><th>Jam Mulai</th><th>Jam Selesai</th></tr></thead>";
    echo "<tbody>";
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row["id_m_jam"]. "</td><td>" . $row["jam_mulai"]. "</td><td>" . $row["jam_selesai"]. "</td></tr>";
    }
    echo "</tbody>";
    echo "</table>";
} else {
    echo "0 results";
}

// Tutup koneksi
$conn->close();
?>
