<?php
include '../config/session.php';
include '../config/config-db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tahun = $_POST['tahun'];
    $semester = $_POST['semester'];

    // Cek apakah tahun dan semester sudah ada
    $cek = $conn->query("SELECT * FROM tahun_ajaran WHERE tahun = '$tahun' AND semester = '$semester'");
    if ($cek->num_rows > 0) {
        echo "<script>alert('Tahun ajaran dan semester sudah ada!'); window.location.href='tahun-ajaran.php';</script>";
        exit;
    }

    // Tambahkan tahun ajaran baru
    $query = "INSERT INTO tahun_ajaran (tahun, semester, status) VALUES ('$tahun', '$semester', 'nonaktif')";
    if ($conn->query($query) === TRUE) {
        echo "<script>alert('Tahun ajaran berhasil ditambahkan!'); window.location.href='../layout/admin/tahun-ajaran.php';</script>";
    } else {
        echo "<script>alert('Gagal menambah tahun ajaran!'); window.location.href='../layout/admin/tahun-ajaran.php';</script>";
    }
}
?>
