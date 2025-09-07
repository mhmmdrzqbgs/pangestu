<?php
include '../config/session.php';
include '../config/config-db.php';

$id = $_GET['id'];
$query = "DELETE FROM pengumuman WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    header("Location: ../layout/admin/pengumuman.php?status=sukses");
} else {
    header("Location: ../layout/admin/pengumuman.php?status=gagal");
}
exit();
?>
