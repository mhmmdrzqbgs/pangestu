<?php
include '../config/session.php';
include '../config/config-db.php';

// Pastikan data dikirim via POST
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    die("Akses tidak sah.");
}

// Validasi input
if (!isset($_POST['id_siswa'], $_POST['semester'], $_POST['tahun_ajaran_id'])) {
    die("Data tidak lengkap.");
}

$id_siswa = intval($_POST['id_siswa']);
$semester = intval($_POST['semester']);
$tahun_ajaran_id = intval($_POST['tahun_ajaran_id']);
$nilai_id = isset($_POST['nilai_id']) ? intval($_POST['nilai_id']) : null;

// Data nilai
$nilai = [
    'b_indonesia' => intval($_POST['b_indonesia'] ?? 0),
    'b_jawa' => intval($_POST['b_jawa'] ?? 0),
    'pjok' => intval($_POST['pjok'] ?? 0),
    'ipas' => intval($_POST['ipas'] ?? 0),
    'matematika' => intval($_POST['matematika'] ?? 0),
    'pai' => intval($_POST['pai'] ?? 0),
    'b_inggris' => intval($_POST['b_inggris'] ?? 0),
    'pkn' => intval($_POST['pkn'] ?? 0),
    'seni' => intval($_POST['seni'] ?? 0)
];

// Cek apakah data nilai sudah ada atau belum
$query = $conn->prepare("SELECT id FROM nilai WHERE siswa_id = ? AND semester = ? AND tahun_ajaran_id = ?");
$query->bind_param("iii", $id_siswa, $semester, $tahun_ajaran_id);
$query->execute();
$query->store_result();

if ($query->num_rows > 0) {
    // Jika nilai sudah ada, lakukan UPDATE
    $query->bind_result($existing_id);
    $query->fetch();
    $query->close();

    $update = $conn->prepare("UPDATE nilai 
        SET b_indonesia = ?, b_jawa = ?, pjok = ?, ipas = ?, 
            matematika = ?, pai = ?, b_inggris = ?, pkn = ?, seni = ?
        WHERE id = ?");
    $update->bind_param(
        "iiiiiiiiii",
        $nilai['b_indonesia'],
        $nilai['b_jawa'],
        $nilai['pjok'],
        $nilai['ipas'],
        $nilai['matematika'],
        $nilai['pai'],
        $nilai['b_inggris'],
        $nilai['pkn'],
        $nilai['seni'],
        $existing_id
    );

    if ($update->execute()) {
        echo "<script>alert('Nilai berhasil diperbarui!'); window.location.href='../layout/guru/data.php?tahun_semester=" . urlencode($tahun_ajaran_id . '_' . $semester) . "';</script>";
    } else {
        echo "<script>alert('Gagal memperbarui nilai!'); window.history.back();</script>";
    }
    $update->close();
} else {
    // Jika nilai belum ada, lakukan INSERT
    $query->close();
    $insert = $conn->prepare("INSERT INTO nilai (siswa_id, semester, tahun_ajaran_id, b_indonesia, b_jawa, pjok, ipas, 
                           matematika, pai, b_inggris, pkn, seni)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $insert->bind_param(
        "iiiiiiiiiiii",
        $id_siswa,
        $semester,
        $tahun_ajaran_id,
        $nilai['b_indonesia'],
        $nilai['b_jawa'],
        $nilai['pjok'],
        $nilai['ipas'],
        $nilai['matematika'],
        $nilai['pai'],
        $nilai['b_inggris'],
        $nilai['pkn'],
        $nilai['seni']
    );

    if ($insert->execute()) {
        echo "<script>alert('Nilai berhasil ditambahkan!'); window.location.href='../layout/guru/data.php?tahun_semester=" . urlencode($tahun_ajaran_id . '_' . $semester) . "';</script>";
    } else {
        echo "<script>alert('Gagal menambahkan nilai!'); window.history.back();</script>";
    }
    $insert->close();
}

$conn->close();
