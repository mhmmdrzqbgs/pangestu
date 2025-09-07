<?php
include '../../config/session.php';
include '../../config/config-db.php';

$id_user = $_SESSION['id_user'];

$query = $conn->prepare("SELECT class FROM user WHERE id_user = ?");
$query->bind_param("i", $id_user);
$query->execute();
$query->bind_result($class);
$query->fetch();
$query->close();

if (!$class) {
    die("Kelas tidak ditemukan untuk guru ini.");
}

$queryTahunAktif = $conn->prepare("SELECT id FROM tahun_ajaran WHERE status = 'aktif' LIMIT 1");
$queryTahunAktif->execute();
$queryTahunAktif->bind_result($tahun_ajaran_id);
$queryTahunAktif->fetch();
$queryTahunAktif->close();

// set nilai def
if (!$tahun_ajaran_id) {
    $tahun_ajaran_id = 0; 
}

// Total
$queryTotalSiswa = $conn->prepare("SELECT COUNT(*) FROM siswa WHERE kelas = ?");
$queryTotalSiswa->bind_param("s", $class);
$queryTotalSiswa->execute();
$queryTotalSiswa->bind_result($total_siswa);
$queryTotalSiswa->fetch();
$queryTotalSiswa->close();

// Rata-rata
$queryRataNilai = $conn->prepare(
    "SELECT AVG((b_indonesia + b_jawa + pjok + ipas + matematika + pai + b_inggris + pkn + seni) / 9) 
     FROM nilai 
     WHERE siswa_id IN (SELECT id FROM siswa WHERE kelas = ?) 
     AND tahun_ajaran_id = ?"
);
$queryRataNilai->bind_param("si", $class, $tahun_ajaran_id);
$queryRataNilai->execute();
$queryRataNilai->bind_result($rata_nilai);
$queryRataNilai->fetch();
$queryRataNilai->close();

// Jumlah siswa nilai rata-rata di bawah 70 semester aktif
$querySiswaPerhatian = $conn->prepare(
    "SELECT COUNT(*) FROM nilai 
     WHERE siswa_id IN (SELECT id FROM siswa WHERE kelas = ?) 
     AND tahun_ajaran_id = ? 
     AND ((b_indonesia + b_jawa + pjok + ipas + matematika + pai + b_inggris + pkn + seni) / 9) < 70"
);
$querySiswaPerhatian->bind_param("si", $class, $tahun_ajaran_id);
$querySiswaPerhatian->execute();
$querySiswaPerhatian->bind_result($siswa_perhatian);
$querySiswaPerhatian->fetch();
$querySiswaPerhatian->close();

// f grfk
$queryPerSemester = $conn->prepare(
    "SELECT tahun_ajaran.tahun, nilai.semester, 
     AVG((b_indonesia + b_jawa + pjok + ipas + matematika + pai + b_inggris + pkn + seni) / 9) 
     FROM nilai 
     JOIN tahun_ajaran ON nilai.tahun_ajaran_id = tahun_ajaran.id
     WHERE siswa_id IN (SELECT id FROM siswa WHERE kelas = ?)
     GROUP BY tahun_ajaran.tahun, nilai.semester 
     ORDER BY tahun_ajaran.tahun, nilai.semester"
);
$queryPerSemester->bind_param("s", $class);
$queryPerSemester->execute();
$queryPerSemester->bind_result($tahun_ajaran, $semester, $rata_semester);

$semester_data = [];
while ($queryPerSemester->fetch()) {
    $semester_data[] = [
        "tahun_ajaran" => $tahun_ajaran,
        "semester" => $semester,
        "rata_rata" => round($rata_semester, 2)
    ];
}
$queryPerSemester->close();

// Data pengum
$queryPengumuman = $conn->prepare(
    "SELECT pengumuman.judul, pengumuman.isi, pengumuman.tanggal, user.nama 
     FROM pengumuman 
     JOIN user ON pengumuman.user_id = user.id_user 
     ORDER BY pengumuman.tanggal DESC"
);
$queryPengumuman->execute();
$queryPengumuman->bind_result($judul, $isi, $tanggal, $nama_guru);

$pengumuman_data = [];
while ($queryPengumuman->fetch()) {
    $pengumuman_data[] = [
        "judul" => $judul,
        "isi" => $isi,
        "tanggal" => $tanggal,
        "nama_guru" => $nama_guru
    ];
}
$queryPengumuman->close();

$data_siswa = [
    "total_siswa" => $total_siswa ?? 0,
    "rata_nilai" => round($rata_nilai ?? 0, 2),
    "siswa_perhatian" => $siswa_perhatian ?? 0,
    "semester_data" => $semester_data,
    "pengumuman" => $pengumuman_data
];
?>
