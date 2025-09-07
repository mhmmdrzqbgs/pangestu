<?php
include '../config/session.php';
include '../config/config-db.php';

$guru_id = $_SESSION['id_user'];
$siswa_id = $_POST['siswa_id'];
$catatan = $_POST['catatan'];

$query = $conn->prepare("INSERT INTO catatan_guru (siswa_id, guru_id, catatan) VALUES (?, ?, ?)");
$query->bind_param("iis", $siswa_id, $guru_id, $catatan);

if ($query->execute()) {
    header("Location: ../layout/guru/catatan.php?pesan=sukses");
} else {
    header("Location: ../layout/guru/catatan.php?pesan=gagal");
}
?>
