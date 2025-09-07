<?php
include '../config/session.php';
include '../config/config-db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Nonaktifkan semua tahun ajaran
    $conn->query("UPDATE tahun_ajaran SET status = 'nonaktif'");

    // Aktifkan tahun ajaran yang dipilih
    $conn->query("UPDATE tahun_ajaran SET status = 'aktif' WHERE id = $id");

    echo "<script>alert('Tahun ajaran berhasil diaktifkan!'); window.location.href='../layout/admin/tahun-ajaran.php';</script>";
}
?>
