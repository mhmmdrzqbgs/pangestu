<?php
include '../config/session.php';
include '../config/config-db.php';

// Cek apakah ID tersedia
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("ID Catatan tidak ditemukan!");
}

$catatan_id = intval($_GET['id']);

// Hapus data catatan berdasarkan ID
$delete = $conn->prepare("DELETE FROM catatan_guru WHERE id = ?");
$delete->bind_param("i", $catatan_id);

if ($delete->execute()) {
    echo "<script>alert('Catatan berhasil dihapus!'); window.location='../layout/guru/catatan.php';</script>";
} else {
    echo "<script>alert('Gagal menghapus catatan!');</script>";
}

$delete->close();
$conn->close();
?>
