<?php
$servername = "localhost";  // Ganti dengan nama server Anda
$username = "root";     // Ganti dengan username database Anda
$password = "";     // Ganti dengan password database Anda
$dbname = "pengawasan";  // Ganti dengan nama database Anda

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Mengecek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>