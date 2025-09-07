<?php
include '../config/session.php';
include '../config/config-db.php';

// Cek apakah ID tersedia
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("ID user tidak ditemukan!");
}

$id_user = intval($_GET['id']);

// Hapus user dari database
$query = $conn->prepare("DELETE FROM user WHERE id_user = ?");
$query->bind_param("i", $id_user);

if ($query->execute()) {
    echo "<script>alert('User berhasil dihapus!'); window.location='../layout/admin/user-management.php';</script>";
} else {
    echo "<script>alert('Gagal menghapus user!');</script>";
}
?>
