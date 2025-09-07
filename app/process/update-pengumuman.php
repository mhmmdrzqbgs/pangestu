<?php
include '../config/session.php';
include '../config/config-db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $judul = $_POST['judul'];
    $isi = $_POST['isi'];

    $query = "UPDATE pengumuman SET judul = ?, isi = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssi", $judul, $isi, $id);

    if ($stmt->execute()) {
        header("Location: ../layout/admin/pengumuman.php?status=sukses");
    } else {
        header("Location: ../layout/admin/pengumuman.php?status=gagal");
    }
    exit();
}
?>
