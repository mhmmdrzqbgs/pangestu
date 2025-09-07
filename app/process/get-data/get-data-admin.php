<?php
include '../../config/session.php';

// Pastikan file konfigurasi database tersedia
$configPath = '../../config/config-db.php';
if (!file_exists($configPath)) {
    die("Error: File konfigurasi database tidak ditemukan.");
}
include $configPath;

// Ambil jumlah total siswa
$queryTotalSiswa = $conn->query("SELECT COUNT(*) AS total_siswa FROM siswa");
$total_siswa = $queryTotalSiswa->fetch_assoc()['total_siswa'] ?? 0;

// Ambil jumlah total guru
$queryTotalGuru = $conn->query("SELECT COUNT(*) AS total_guru FROM user WHERE role = 'Guru'");
$total_guru = $queryTotalGuru->fetch_assoc()['total_guru'] ?? 0;

// Ambil jumlah total kelas unik
$queryTotalKelas = $conn->query("SELECT COUNT(DISTINCT kelas) AS total_kelas FROM siswa");
$total_kelas = $queryTotalKelas->fetch_assoc()['total_kelas'] ?? 0;

// Ambil tahun ajaran aktif dari tabel tahun_ajaran
$queryTahunAjaranAktif = $conn->query("SELECT tahun, semester FROM tahun_ajaran WHERE status = 'aktif' LIMIT 1");
$tahun_ajaran_aktif = "Belum Ada";

if ($queryTahunAjaranAktif->num_rows > 0) {
    $row = $queryTahunAjaranAktif->fetch_assoc();
    $tahun_ajaran_aktif = $row['tahun'] . " (Semester " . $row['semester'] . ")";
}

// Ambil pengumuman terbaru dari database
$queryPengumuman = $conn->query("SELECT judul, isi, tanggal FROM pengumuman ORDER BY tanggal DESC LIMIT 5");
$pengumuman_list = [];
while ($row = $queryPengumuman->fetch_assoc()) {
    $pengumuman_list[] = $row;
}

// Menutup koneksi
$conn->close();
?>
