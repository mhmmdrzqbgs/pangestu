<?php
include '../../config/session.php';
include '../../config/config-db.php';

// Ambil data guru beserta kelas yang diajar
$query = "SELECT id_user, nama, email, 
                 IFNULL(class, 'Belum Ada Kelas') AS kelas
          FROM user
          WHERE role = 'Guru'";

$result = $conn->query($query);

$guruList = [];
while ($row = $result->fetch_assoc()) {
    $guruList[] = $row;
}
?>
