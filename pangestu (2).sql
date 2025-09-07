-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 07 Sep 2025 pada 05.05
-- Versi server: 8.0.30
-- Versi PHP: 8.3.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pangestu`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `catatan_guru`
--

CREATE TABLE `catatan_guru` (
  `id` int NOT NULL,
  `siswa_id` int NOT NULL,
  `guru_id` int NOT NULL,
  `catatan` text COLLATE utf8mb4_general_ci NOT NULL,
  `tanggal` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `catatan_guru`
--

INSERT INTO `catatan_guru` (`id`, `siswa_id`, `guru_id`, `catatan`, `tanggal`) VALUES
(7, 4, 5, 'lebih fokus belajar', '2025-05-17 06:53:58');

-- --------------------------------------------------------

--
-- Struktur dari tabel `nilai`
--

CREATE TABLE `nilai` (
  `id` int NOT NULL,
  `siswa_id` int NOT NULL,
  `semester` enum('1','2') COLLATE utf8mb4_general_ci NOT NULL,
  `b_indonesia` float DEFAULT '0',
  `b_jawa` float DEFAULT '0',
  `pjok` float DEFAULT '0',
  `ipas` float DEFAULT '0',
  `matematika` float DEFAULT '0',
  `pai` float DEFAULT '0',
  `b_inggris` float DEFAULT '0',
  `pkn` float DEFAULT '0',
  `seni` float DEFAULT '0',
  `tahun_ajaran_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `nilai`
--

INSERT INTO `nilai` (`id`, `siswa_id`, `semester`, `b_indonesia`, `b_jawa`, `pjok`, `ipas`, `matematika`, `pai`, `b_inggris`, `pkn`, `seni`, `tahun_ajaran_id`) VALUES
(2, 2, '1', 78, 85, 79, 82, 80, 87, 84, 77, 90, 3),
(3, 3, '1', 90, 92, 88, 89, 85, 94, 91, 86, 93, 3),
(4, 4, '1', 87, 85, 80, 83, 82, 91, 86, 79, 88, 3),
(8, 2, '1', 80, 85, 79, 83, 78, 89, 87, 81, 84, 1),
(9, 3, '1', 85, 88, 82, 87, 80, 91, 89, 83, 86, 1),
(10, 4, '1', 79, 81, 77, 82, 74, 85, 83, 78, 80, 1),
(11, 5, '1', 82, 86, 80, 88, 76, 88, 85, 79, 82, 1),
(12, 6, '1', 90, 92, 87, 91, 85, 95, 93, 88, 94, 1),
(14, 2, '2', 82, 87, 81, 85, 77, 91, 88, 82, 86, 2),
(15, 3, '2', 87, 89, 85, 90, 83, 94, 91, 86, 89, 2),
(16, 4, '2', 81, 83, 85, 86, 78, 89, 86, 81, 84, 2),
(17, 5, '2', 85, 88, 84, 92, 82, 92, 89, 85, 88, 2),
(18, 6, '2', 92, 95, 90, 94, 88, 98, 96, 91, 97, 2),
(19, 9, '1', 90, 70, 84, 84, 78, 92, 87, 77, 97, 3),
(21, 9, '2', 77, 65, 90, 75, 62, 70, 75, 71, 83, 2),
(23, 9, '1', 56, 57, 70, 61, 49, 70, 65, 60, 70, 1),
(30, 5, '1', 90, 90, 80, 80, 80, 80, 70, 90, 60, 3),
(33, 11, '1', 76, 79, 86, 82, 76, 81, 83, 84, 87, 3),
(34, 12, '1', 76, 80, 95, 76, 79, 85, 79, 86, 91, 3),
(35, 13, '1', 83, 76, 84, 82, 81, 81, 83, 81, 84, 3),
(36, 14, '1', 81, 84, 83, 85, 82, 87, 81, 83, 86, 3),
(37, 15, '1', 78, 79, 92, 81, 76, 84, 76, 84, 86, 3),
(38, 16, '1', 81, 80, 88, 76, 70, 85, 79, 81, 84, 3),
(39, 17, '1', 82, 83, 85, 81, 80, 84, 79, 81, 83, 3),
(40, 18, '1', 83, 81, 80, 84, 81, 86, 81, 87, 88, 3),
(41, 19, '1', 79, 83, 86, 83, 76, 84, 73, 84, 87, 3),
(42, 20, '1', 83, 86, 93, 87, 82, 85, 81, 89, 93, 3),
(43, 11, '1', 81, 77, 76, 85, 71, 82, 81, 83, 84, 1),
(44, 12, '1', 81, 73, 95, 83, 72, 83, 81, 85, 83, 1),
(45, 13, '1', 81, 81, 83, 83, 79, 83, 82, 77, 85, 1),
(46, 14, '1', 81, 78, 94, 86, 79, 82, 76, 78, 81, 1),
(47, 15, '1', 82, 77, 85, 81, 72, 83, 85, 81, 81, 1),
(48, 16, '1', 84, 81, 91, 84, 81, 85, 82, 83, 84, 1),
(49, 17, '1', 83, 78, 94, 85, 77, 83, 85, 81, 83, 1),
(50, 18, '1', 86, 84, 83, 75, 73, 83, 82, 84, 85, 1),
(51, 19, '1', 83, 76, 85, 81, 73, 80, 75, 81, 84, 1),
(52, 20, '1', 83, 81, 93, 85, 80, 83, 80, 85, 84, 1),
(53, 11, '2', 80, 81, 95, 77, 70, 85, 75, 84, 78, 2),
(54, 12, '2', 71, 78, 88, 73, 70, 79, 75, 77, 80, 2),
(55, 13, '2', 76, 71, 83, 75, 70, 85, 72, 80, 85, 2),
(56, 14, '2', 80, 76, 88, 81, 74, 85, 78, 81, 79, 2),
(57, 15, '2', 81, 78, 90, 76, 72, 83, 76, 84, 83, 2),
(58, 16, '2', 76, 74, 83, 82, 71, 83, 71, 84, 83, 2),
(59, 17, '2', 82, 78, 98, 81, 76, 85, 79, 84, 86, 2),
(60, 18, '2', 76, 79, 88, 73, 70, 83, 74, 82, 85, 2),
(61, 19, '2', 81, 77, 93, 81, 77, 84, 85, 85, 86, 2),
(62, 20, '2', 76, 71, 88, 73, 70, 81, 73, 81, 83, 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengumuman`
--

CREATE TABLE `pengumuman` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `judul` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `isi` text COLLATE utf8mb4_general_ci NOT NULL,
  `tanggal` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pengumuman`
--

INSERT INTO `pengumuman` (`id`, `user_id`, `judul`, `isi`, `tanggal`) VALUES
(6, 8, 'Libur Hari Raya Idul Fitri 1446H', 'Libur akan dimulai pada tanggal 21 Maret 2025 - 8 April 2025', '2025-03-17 10:12:59');

-- --------------------------------------------------------

--
-- Struktur dari tabel `siswa`
--

CREATE TABLE `siswa` (
  `id` int NOT NULL,
  `nama` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `jenis_kelamin` enum('L','P') COLLATE utf8mb4_general_ci NOT NULL,
  `kelas` enum('1','2','3','4','5','6') COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `siswa`
--

INSERT INTO `siswa` (`id`, `nama`, `jenis_kelamin`, `kelas`) VALUES
(2, 'Budi Santoso', 'L', '2'),
(3, 'Citra Maharani', 'P', '3'),
(4, 'APTA ARIFATHUSSHOFIYAH', 'P', '4'),
(5, 'Eko Saputra', 'L', '5'),
(6, 'Fitri Handayani', 'P', '6'),
(9, 'Muh. Rizqi', 'L', '1'),
(11, 'ARYA SETO GUMILANG', 'L', '4'),
(12, 'BAGUS RISKY PRATAMA', 'L', '4'),
(13, 'FEREL ANDREW EXCELENTIANO', 'L', '4'),
(14, 'HANA NUR HANIFAH', 'P', '4'),
(15, 'KHAFIS ABDULLAH ANANTO', 'L', '4'),
(16, 'KHANZA KHALILA SHABIRA', 'P', '4'),
(17, 'MUHAMMAD RIZKY SEPTYAN', 'L', '4'),
(18, 'MUTIARA NUR RAMADHANI', 'P', '4'),
(19, 'PANDU SURYA AZKA S', 'L', '4'),
(20, 'STEVANO MICHAEL WIJAYA', 'L', '4');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tahun_ajaran`
--

CREATE TABLE `tahun_ajaran` (
  `id` int NOT NULL,
  `tahun` varchar(9) COLLATE utf8mb4_general_ci NOT NULL,
  `semester` enum('1','2') COLLATE utf8mb4_general_ci NOT NULL,
  `status` enum('aktif','nonaktif') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'nonaktif'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tahun_ajaran`
--

INSERT INTO `tahun_ajaran` (`id`, `tahun`, `semester`, `status`) VALUES
(1, '2023/2024', '1', 'nonaktif'),
(2, '2023/2024', '2', 'nonaktif'),
(3, '2024/2025', '1', 'nonaktif'),
(7, '2024/2025', '2', 'aktif');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id_user` int NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `nama` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `role` enum('Admin','Guru') COLLATE utf8mb4_general_ci NOT NULL,
  `last_activity` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `class` enum('1','2','3','4','5','6') COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id_user`, `email`, `password`, `nama`, `role`, `last_activity`, `class`) VALUES
(1, 'admin@kepsek.com', '$2y$10$UBcXjUhyHbs4azJpC8FOsesY7a.JWLTOU0CbNHvFxGWduLoew/cL6', 'KASMONAH, S.Pd.S.D., M.Pd.', 'Admin', '2025-03-18 13:05:24', NULL),
(2, 'guru@kelas1.com', '$2y$10$.p81MWeQKNBfsYyUecPMOeDtllaj4sYEKKaBHCZCD.irwIzzoip2m', 'DWI RUFIANINGSIH, S.Pd.', 'Guru', '2025-03-18 13:06:03', '1'),
(3, 'guru@kelas2.com', '$2y$10$WH9R7L5K/1BMcmzbxH4fN.OAspZBfGY/OvqHkBfw35wqdAdh9ctcy', 'M. BUDI SANTOSO, S.Pd.', 'Guru', '2025-03-18 13:06:22', '2'),
(4, 'guru@kelas3.com', '$2y$10$7MB0PZxJEd83U3SwLA8meunJr4ccIOQmPql/CJYpc5BZX8ylPCroq', 'DIAH PRATIWI, S.Pd.', 'Guru', '2025-03-18 13:06:38', '3'),
(5, 'guru@kelas4.com', '$2y$10$Iun9RnPIFGAaiR.zGffin.VTrfKfRbnTCf3f4gHArq2kKhraFf0pe', 'TRI WULAN F., S.Pd.', 'Guru', '2025-03-18 13:06:57', '4'),
(6, 'guru@kelas5.com', '$2y$10$rA6jCNw5K0oPsQvZLaMe3OUs4Xi6VzDvpPsOcX2tUrq6HShvv/97q', 'MARTIANA, S.Pd.S.D.', 'Guru', '2025-03-18 13:07:45', '5'),
(7, 'guru@kelas6.com', '$2y$10$YAZNQs5nI4LEp9Kg5.rMzez/QkuXNc2sY8izi6T.7QR7ozGR.eLm6', 'SITI AMINI, S.Pd.', 'Guru', '2025-03-18 13:07:59', '6'),
(8, 'admin@operator.com', '$2y$10$3hqCLJTo8XoAKDY17IRQLeT1EMspUokYuS9wbQg3AmiN0djNECPSK', 'ABIB DWI PRASTIYO', 'Admin', '2025-03-18 13:05:43', NULL);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `catatan_guru`
--
ALTER TABLE `catatan_guru`
  ADD PRIMARY KEY (`id`),
  ADD KEY `siswa_id` (`siswa_id`),
  ADD KEY `guru_id` (`guru_id`);

--
-- Indeks untuk tabel `nilai`
--
ALTER TABLE `nilai`
  ADD PRIMARY KEY (`id`),
  ADD KEY `siswa_id` (`siswa_id`),
  ADD KEY `fk_nilai_tahun` (`tahun_ajaran_id`);

--
-- Indeks untuk tabel `pengumuman`
--
ALTER TABLE `pengumuman`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indeks untuk tabel `siswa`
--
ALTER TABLE `siswa`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tahun_ajaran`
--
ALTER TABLE `tahun_ajaran`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tahun` (`tahun`,`semester`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `catatan_guru`
--
ALTER TABLE `catatan_guru`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `nilai`
--
ALTER TABLE `nilai`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT untuk tabel `pengumuman`
--
ALTER TABLE `pengumuman`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `siswa`
--
ALTER TABLE `siswa`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT untuk tabel `tahun_ajaran`
--
ALTER TABLE `tahun_ajaran`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `catatan_guru`
--
ALTER TABLE `catatan_guru`
  ADD CONSTRAINT `catatan_guru_ibfk_1` FOREIGN KEY (`siswa_id`) REFERENCES `siswa` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `catatan_guru_ibfk_2` FOREIGN KEY (`guru_id`) REFERENCES `user` (`id_user`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `nilai`
--
ALTER TABLE `nilai`
  ADD CONSTRAINT `fk_nilai_tahun` FOREIGN KEY (`tahun_ajaran_id`) REFERENCES `tahun_ajaran` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `nilai_ibfk_1` FOREIGN KEY (`siswa_id`) REFERENCES `siswa` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pengumuman`
--
ALTER TABLE `pengumuman`
  ADD CONSTRAINT `pengumuman_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id_user`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
