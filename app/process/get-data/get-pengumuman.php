<?php
include '../../config/config-db.php';

// Perbaiki query JOIN dengan kolom yang benar
$query = "SELECT pengumuman.*, user.id_user, user.nama AS nama_user 
          FROM pengumuman 
          JOIN user ON pengumuman.user_id = user.id_user 
          ORDER BY tanggal DESC";

$result = $conn->query($query);

$pengumuman_list = [];
while ($row = $result->fetch_assoc()) {
    $pengumuman_list[] = $row;
}

$conn->close();
?>
