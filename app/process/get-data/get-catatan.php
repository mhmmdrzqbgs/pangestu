<?php
include '../../config/session.php';
include '../../config/config-db.php'; // Pastikan path benar

$guru_id = $_SESSION['id_user'];

// Ambil kelas yang diajar oleh guru
$queryKelas = $conn->prepare("SELECT class FROM user WHERE id_user = ?");
$queryKelas->bind_param("i", $guru_id);
$queryKelas->execute();
$queryKelas->bind_result($class);
$queryKelas->fetch();
$queryKelas->close();

if (!$class) {
    die("Kelas tidak ditemukan.");
}

// Ambil daftar siswa beserta catatan mereka
$querySiswa = $conn->prepare("
    SELECT s.id, s.nama, s.kelas, c.id AS catatan_id, c.catatan, c.tanggal
    FROM siswa s
    LEFT JOIN catatan_guru c ON s.id = c.siswa_id AND c.guru_id = ?
    WHERE s.kelas = ?
    ORDER BY s.nama ASC
");
$querySiswa->bind_param("is", $guru_id, $class);
$querySiswa->execute();
$querySiswa->bind_result($siswa_id, $nama, $kelas, $catatan_id, $catatan, $tanggal);

$siswa_data = [];
while ($querySiswa->fetch()) {
    $siswa_data[] = [
        "siswa_id" => $siswa_id,
        "nama" => $nama,
        "kelas" => $kelas,
        "catatan_id" => $catatan_id,
        "catatan" => $catatan,
        "tanggal" => $tanggal
    ];
}
$querySiswa->close();
?>
