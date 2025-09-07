<?php
$host = "localhost";
$db_name = "pangestu";
$username = "root";
$password = "";

// Aktifkan mode pelaporan error untuk debugging
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    $conn = new mysqli($host, $username, $password, $db_name);
    
    // Set karakter encoding ke utf8mb4 untuk mendukung berbagai karakter
    $conn->set_charset("utf8mb4");

} catch (Exception $e) {
    die("Koneksi gagal: " . $e->getMessage());
}
?>
