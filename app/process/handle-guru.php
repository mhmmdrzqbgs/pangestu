<?php
include '../config/config-db.php';

// Edit Wali Kelas
if (isset($_POST['id_user']) && isset($_POST['kelas'])) {
    $id_user = $_POST['id_user'];
    $kelas = $_POST['kelas'];

    $query = "UPDATE user SET class = '$kelas' WHERE id_user = '$id_user' AND role = 'Guru'";
    if ($conn->query($query)) {
        header("Location: ../layout/admin/manage-wali-kelas.php?success=updated");
        exit;
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
