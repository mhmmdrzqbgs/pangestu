<?php
include '../config/session.php';
include '../config/config-db.php';

$id = intval($_GET['id']);
$query = $conn->prepare("DELETE FROM siswa WHERE id = ?");
$query->bind_param("i", $id);

if ($query->execute()) {
    header("Location: ../layout/admin/manage-siswa.php");
    exit();
}
