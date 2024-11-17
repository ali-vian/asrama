-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 16 Nov 2024 pada 13.39
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `asrama`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `absensi`
--

CREATE TABLE `absensi` (
  `id_absen` int(11) NOT NULL,
  `id_kegiatan` int(11) DEFAULT NULL,
  `nim` varchar(12) DEFAULT NULL,
  `id_extra` int(11) DEFAULT NULL,
  `nim_pengurus` varchar(12) DEFAULT NULL,
  `status_kehadiran` varchar(255) DEFAULT NULL,
  `waktu_absen` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `jenis_absen` varchar(12) DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `extrakulikuler`
--

CREATE TABLE `extrakulikuler` (
  `id_extra` int(11) NOT NULL,
  `nama_extra` varchar(255) DEFAULT NULL,
  `deskripsi_extra` longtext DEFAULT NULL,
  `gambar_pamflet` varchar(255) DEFAULT NULL,
  `jadwal` varchar(25) DEFAULT NULL,
  `kuota` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `extrakulikuler`
--

INSERT INTO `extrakulikuler` (`id_extra`, `nama_extra`, `deskripsi_extra`, `gambar_pamflet`, `jadwal`, `kuota`) VALUES
(1, 'Basketball', 'Kegiatan ekstrakurikuler untuk penggemar bola basket.', 'basketball_pamflet.jpg', 'Senin dan Rabu, 16:00 - 1', 30),
(2, 'Music Club', 'Klub musik untuk belajar dan berlatih alat musik.', 'musicclub_pamflet.jpg', 'Selasa dan Kamis, 17:00 -', 25),
(3, 'Debate Team', 'Tim debat untuk melatih kemampuan berbicara dan berargumen.', 'debate_pamflet.jpg', 'Jumat, 15:00 - 17:00', 20),
(4, 'Photography', 'Kegiatan fotografi untuk belajar mengambil gambar.', 'photography_pamflet.jpg', 'Sabtu, 10:00 - 12:00', 15),
(5, 'Robotics', 'Klub robotika untuk belajar merakit dan编程 robot.', 'robotics_pamflet.jpg', 'Minggu, 14:00 - 16:00', 10);

-- --------------------------------------------------------

--
-- Struktur dari tabel `formulir_kegiatan`
--

CREATE TABLE `formulir_kegiatan` (
  `id_formulir_kegiatan` int(11) NOT NULL,
  `id_kegiatan` int(11) DEFAULT NULL,
  `nim` varchar(12) DEFAULT NULL,
  `pertanyaan1` varchar(255) DEFAULT NULL,
  `pertanyaan2` varchar(255) DEFAULT NULL,
  `pertanyaan3` varchar(255) DEFAULT NULL,
  `pertanyaan4` varchar(255) DEFAULT NULL,
  `pertanyaan5` varchar(255) DEFAULT NULL,
  `saran_masukan` longtext DEFAULT NULL,
  `status` enum('aktif','tidak_aktif') DEFAULT 'aktif'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `formulir_kegiatan`
--

INSERT INTO `formulir_kegiatan` (`id_formulir_kegiatan`, `id_kegiatan`, `nim`, `pertanyaan1`, `pertanyaan2`, `pertanyaan3`, `pertanyaan4`, `pertanyaan5`, `saran_masukan`, `status`) VALUES
(1, 101, '12345678901', 'Bagus', 'Cukup Memadai', 'Kurang Memadai', 'Sangat Baik', 'Tidak Memadai', 'Perlu perbaikan di area parkir', 'tidak_aktif'),
(2, 102, '12345678902', 'Sangat Baik', 'Memadai', 'Baik', 'Cukup Memadai', 'Sangat Baik', 'Harus ada lebih banyak tempat duduk', 'tidak_aktif'),
(3, 103, '12345678903', 'Baik', 'Sangat Baik', 'Cukup Memadai', 'Memadai', 'Baik', 'Perlu peningkatan pada fasilitas ruang kelas', 'tidak_aktif'),
(4, 104, '12345678904', 'Cukup Memadai', 'Kurang Memadai', 'Sangat Baik', 'Baik', 'Cukup Memadai', 'Perlu lebih banyak pilihan makanan', 'tidak_aktif'),
(5, 105, '12345678905', 'Memadai', 'Cukup Memadai', 'Baik', 'Sangat Baik', 'Sangat Baik', 'Acara perlu ditingkatkan lagi kualitasnya', 'tidak_aktif');

-- --------------------------------------------------------

--
-- Struktur dari tabel `formulir_kepuasan`
--

CREATE TABLE `formulir_kepuasan` (
  `id_formulir` int(11) NOT NULL,
  `nim` varchar(12) DEFAULT NULL,
  `pesan` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `kategori` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `formulir_kepuasan`
--

INSERT INTO `formulir_kepuasan` (`id_formulir`, `nim`, `pesan`, `created_at`, `kategori`) VALUES
(1, '12345678901', 'Acara sangat baik, namun fasilitas perlu ditingkatkan.', '2024-11-15 03:00:00', 'positif'),
(2, '12345678902', 'Penyelenggaraan cukup baik, tapi tempat parkir kurang memadai.', '2024-11-15 04:00:00', 'negatif'),
(3, '12345678903', 'Event ini memuaskan, namun bisa lebih terorganisir.', '2024-11-15 05:00:00', 'positif'),
(4, '12345678904', 'Kegiatan menyenangkan, namun kurang variasi makanan.', '2024-11-15 06:00:00', 'negatif'),
(5, '12345678905', 'Penyelenggaraan baik, namun beberapa aspek perlu ditingkatkan.', '2024-11-15 07:00:00', 'positif');

-- --------------------------------------------------------

--
-- Struktur dari tabel `hasil_spk`
--

CREATE TABLE `hasil_spk` (
  `id_spk` int(11) NOT NULL,
  `id_calon_kr` varchar(255) DEFAULT NULL,
  `hasil_spk` float(10,2) DEFAULT NULL,
  `minggu` varchar(2) NOT NULL,
  `bulan` varchar(2) NOT NULL,
  `tahun` varchar(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `hasil_spk`
--

INSERT INTO `hasil_spk` (`id_spk`, `id_calon_kr`, `hasil_spk`, `minggu`, `bulan`, `tahun`) VALUES
(50, '12345678901', 65.00, '2', '11', '2024'),
(51, '12345678902', 73.33, '2', '11', '2024'),
(52, '12345678903', 66.50, '2', '11', '2024'),
(54, '12345678904', 80.00, '2', '11', '2024'),
(55, '12345678905', 31.00, '2', '11', '2024'),
(56, '12345678901', 65.00, '3', '11', '2024'),
(57, '12345678902', 73.33, '3', '11', '2024'),
(58, '12345678903', 66.50, '3', '11', '2024'),
(59, '12345678904', 80.00, '3', '11', '2024');

-- --------------------------------------------------------

--
-- Struktur dari tabel `hasil_tpa`
--

CREATE TABLE `hasil_tpa` (
  `id_test` int(11) NOT NULL,
  `id_calon_kr` varchar(255) DEFAULT NULL,
  `Sikap` float(10,2) DEFAULT NULL,
  `Pelanggaran` float(10,2) DEFAULT NULL,
  `Absensi_Harian` float(10,2) DEFAULT NULL,
  `Absensi_Kegiatan` float(10,2) DEFAULT NULL,
  `Absensi_Extra` float(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `hasil_tpa`
--

INSERT INTO `hasil_tpa` (`id_test`, `id_calon_kr`, `Sikap`, `Pelanggaran`, `Absensi_Harian`, `Absensi_Kegiatan`, `Absensi_Extra`) VALUES
(61, '12345678901', 62.00, 67.00, 72.00, 78.00, 83.00),
(62, '12345678902', 62.00, 69.00, 72.00, 77.00, 82.00),
(63, '12345678903', 65.00, 70.00, 72.00, 77.00, 82.00),
(64, '12345678904', 62.00, 67.00, 72.00, 77.00, 82.00);

-- --------------------------------------------------------

--
-- Struktur dari tabel `kegiatan`
--

CREATE TABLE `kegiatan` (
  `nama_kegiatan` varchar(255) DEFAULT NULL,
  `id_kegiatan` int(11) NOT NULL,
  `tanggal_kegiatan` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deskripsi` longtext DEFAULT NULL,
  `foto_pamflet` varchar(255) DEFAULT NULL,
  `tempat` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `kegiatan`
--

INSERT INTO `kegiatan` (`nama_kegiatan`, `id_kegiatan`, `tanggal_kegiatan`, `created_at`, `deskripsi`, `foto_pamflet`, `tempat`) VALUES
('Seminar Teknologi Terbaru', 101, '2024-11-20 00:00:00', '2024-11-10 01:00:00', 'Seminar mengenai perkembangan teknologi terbaru di bidang IT', 'seminar_tech.jpg', 'Gedung A, Universitas XYZ'),
('Workshop Desain Grafis', 102, '2024-11-25 00:00:00', '2024-11-12 02:30:00', 'Workshop praktis untuk mempelajari desain grafis menggunakan software terkini', 'workshop_design.jpg', 'Ruangan 101, Kampus ABC'),
('Pameran Fotografi', 103, '2024-12-01 00:00:00', '2024-11-14 03:15:00', 'Pameran yang menampilkan karya fotografi terbaik dari mahasiswa', 'pameran_foto.jpg', 'Galeri Seni Kampus DEF'),
('Lomba Debat Mahasiswa', 104, '2024-12-05 00:00:00', '2024-11-16 07:00:00', 'Lomba debat antar mahasiswa dengan tema politik dan sosial', 'lomba_debat.jpg', 'Auditorium Kampus GHI'),
('Pelatihan Public Speaking', 105, '2024-12-10 00:00:00', '2024-11-18 09:30:00', 'Pelatihan teknik public speaking untuk meningkatkan kemampuan komunikasi publik', 'public_speaking.jpg', 'Ruang Serbaguna Kampus JKL');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kriteria`
--

CREATE TABLE `kriteria` (
  `id_kriteria` int(11) NOT NULL,
  `kriteria` varchar(32) DEFAULT NULL,
  `bobot` float(5,2) DEFAULT NULL,
  `type` varchar(12) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `kriteria`
--

INSERT INTO `kriteria` (`id_kriteria`, `kriteria`, `bobot`, `type`) VALUES
(34, 'Sikap', 10.00, 'Benefit'),
(35, 'Pelanggaran', 10.00, 'Cost'),
(36, 'Absensi_Harian', 30.00, 'Cost'),
(37, 'Absensi_Kegiatan', 20.00, 'Cost'),
(38, 'Absensi_Extra', 10.00, 'Cost');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pendaftaran`
--

CREATE TABLE `pendaftaran` (
  `id` varchar(12) NOT NULL,
  `nim` varchar(12) DEFAULT NULL,
  `nama_lengkap` varchar(255) DEFAULT NULL,
  `prodi_pendaftar` varchar(255) DEFAULT NULL,
  `foto_pendaftar` varchar(255) DEFAULT NULL,
  `alamat_pendaftar` varchar(255) DEFAULT NULL,
  `ttl` varchar(255) DEFAULT NULL,
  `no_hp_pendaftar` varchar(12) DEFAULT NULL,
  `email_pendaftar` varchar(255) DEFAULT NULL,
  `created_at_pendaftar` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `nomor_pendaftaran` varchar(255) DEFAULT NULL,
  `jenis_kelamin` varchar(12) DEFAULT NULL,
  `jalur_masuk` varchar(255) DEFAULT NULL,
  `foto_bukti_lolos_ptn` varchar(255) DEFAULT NULL,
  `nama_ayah` varchar(255) DEFAULT NULL,
  `nama_ibu` varchar(255) DEFAULT NULL,
  `no_hp_ortu` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengurus`
--

CREATE TABLE `pengurus` (
  `nama_pengurus` varchar(255) DEFAULT NULL,
  `nim_pengurus` varchar(12) NOT NULL,
  `kamar_pengurus` varchar(12) DEFAULT NULL,
  `gedung_pengurus` varchar(12) DEFAULT NULL,
  `no_hp_pengurus` varchar(12) DEFAULT NULL,
  `password_pengurus` varchar(255) DEFAULT NULL,
  `email_pengurus` varchar(255) DEFAULT NULL,
  `divisi_pengurus` varchar(255) DEFAULT NULL,
  `jabatan_pengurus` varchar(255) DEFAULT NULL,
  `foto_pengurus` varchar(255) DEFAULT NULL,
  `prodi_pengurus` varchar(255) DEFAULT NULL,
  `jenis_kelamin_pengurus` varchar(12) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pengurus`
--

INSERT INTO `pengurus` (`nama_pengurus`, `nim_pengurus`, `kamar_pengurus`, `gedung_pengurus`, `no_hp_pengurus`, `password_pengurus`, `email_pengurus`, `divisi_pengurus`, `jabatan_pengurus`, `foto_pengurus`, `prodi_pengurus`, `jenis_kelamin_pengurus`) VALUES
('Fajar Adi', '98765432100', 'A101', 'Gedung A', '081234567800', 'pass1234', 'fajar@mail.com', 'Humas', 'Ketua', 'foto_fajar.jpg', 'Teknik Informatika', 'L'),
('Siti Nurhaliza', '98765432101', 'B202', 'Gedung B', '081234567801', 'pass5678', 'siti@mail.com', 'Kependudukan', 'Wakil Ketua', 'foto_siti.jpg', 'Sistem Informasi', 'P'),
('Rudi Hartono', '98765432102', 'C303', 'Gedung C', '081234567802', 'pass91011', 'rudi@mail.com', 'Keuangan', 'Bendahara', 'foto_rudi.jpg', 'Teknik Elektro', 'L'),
('Diana Melati', '98765432103', 'D404', 'Gedung D', '081234567803', 'pass1213', 'diana@mail.com', 'Sosial', 'Sekretaris', 'foto_diana.jpg', 'Manajemen', 'P'),
('Eko Prabowo', '98765432104', 'E505', 'Gedung E', '081234567804', 'pass1415', 'eko@mail.com', 'Acara', 'Koordinator', 'foto_eko.jpg', 'Akuntansi', 'L');

-- --------------------------------------------------------

--
-- Struktur dari tabel `sub_kriteria`
--

CREATE TABLE `sub_kriteria` (
  `id_subkriteria` int(11) NOT NULL,
  `id_kriteria` int(11) NOT NULL,
  `subkriteria` varchar(255) NOT NULL,
  `nilai` float(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `sub_kriteria`
--

INSERT INTO `sub_kriteria` (`id_subkriteria`, `id_kriteria`, `subkriteria`, `nilai`) VALUES
(62, 34, 'Baik Sekali', 5.00),
(63, 34, 'Baik', 4.00),
(64, 34, 'Cukup', 3.00),
(65, 34, 'Buruk', 2.00),
(66, 34, 'Buruk Sekali', 1.00),
(67, 35, '1 Kali', 1.00),
(68, 35, '2 Kali', 2.00),
(69, 35, '3 Kali', 3.00),
(70, 35, 'Lebih dari 3 Kali', 4.00),
(71, 35, 'Tidak Ada', 0.00),
(72, 36, 'Hadir Selalu', 1.00),
(73, 36, 'Alfa 1 Kali', 2.00),
(74, 36, 'Alfa 2 Kali', 3.00),
(75, 36, 'Alfa 3 Kali', 4.00),
(76, 36, 'Alfa Lebih dari 3 Kali', 5.00),
(77, 37, 'Hadir Selalu', 1.00),
(78, 37, 'Alfa 1 Kali', 2.00),
(79, 37, 'Alfa 2 Kali', 3.00),
(80, 37, 'Alfa 3 Kali', 4.00),
(81, 37, 'Alfa Lebih dari 3 Kali', 5.00),
(82, 38, 'Hadir Selalu', 1.00),
(83, 38, 'Alfa 1 Kali', 2.00),
(84, 38, 'Alfa 2 Kali', 3.00),
(85, 38, 'Alfa 3 Kali', 4.00),
(86, 38, 'Alfa Lebih dari 3 Kali', 5.00);

-- --------------------------------------------------------

--
-- Struktur dari tabel `warga`
--

CREATE TABLE `warga` (
  `nim` varchar(12) NOT NULL,
  `id_extra` int(11) DEFAULT NULL,
  `nim_pengurus` varchar(12) DEFAULT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `no_hp` varchar(12) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `kamar` varchar(12) DEFAULT NULL,
  `foto_warga` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `gedung` varchar(12) DEFAULT NULL,
  `prodi` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `warga`
--

INSERT INTO `warga` (`nim`, `id_extra`, `nim_pengurus`, `nama`, `no_hp`, `password`, `kamar`, `foto_warga`, `email`, `gedung`, `prodi`) VALUES
('12345678901', 1, '98765432100', 'Andi Setiawan', '081234567890', 'password123', 'A101', 'foto_andi.jpg', 'andi@mail.com', 'Gedung A', 'Teknik Informatika'),
('12345678902', 2, '98765432101', 'Budi Santoso', '081234567891', 'password456', 'B202', 'foto_budi.jpg', 'budi@mail.com', 'Gedung B', 'Sistem Informasi'),
('12345678903', 1, '98765432102', 'Cindy Dewi', '081234567892', 'password789', 'C303', 'foto_cindy.jpg', 'cindy@mail.com', 'Gedung C', 'Teknik Elektro'),
('12345678904', 3, '98765432103', 'Dewi Lestari', '081234567893', 'password101', 'D404', 'foto_dewi.jpg', 'dewi@mail.com', 'Gedung D', 'Manajemen'),
('12345678905', 2, '98765432104', 'Eko Prasetyo', '081234567894', 'password202', 'E505', 'foto_eko.jpg', 'eko@mail.com', 'Gedung E', 'Akuntansi');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `absensi`
--
ALTER TABLE `absensi`
  ADD PRIMARY KEY (`id_absen`),
  ADD KEY `fk_absensi_relations_pengurus` (`nim_pengurus`),
  ADD KEY `fk_absensi_relations_warga` (`nim`),
  ADD KEY `fk_absensi_relations_kegiatan` (`id_kegiatan`),
  ADD KEY `fk_absensi_relations_extrakul` (`id_extra`);

--
-- Indeks untuk tabel `extrakulikuler`
--
ALTER TABLE `extrakulikuler`
  ADD PRIMARY KEY (`id_extra`);

--
-- Indeks untuk tabel `formulir_kegiatan`
--
ALTER TABLE `formulir_kegiatan`
  ADD PRIMARY KEY (`id_formulir_kegiatan`),
  ADD KEY `fk_formulir_relations_kegiatan` (`id_kegiatan`),
  ADD KEY `fk_formulir_relations_warga` (`nim`);

--
-- Indeks untuk tabel `formulir_kepuasan`
--
ALTER TABLE `formulir_kepuasan`
  ADD PRIMARY KEY (`id_formulir`),
  ADD KEY `nim` (`nim`);

--
-- Indeks untuk tabel `hasil_spk`
--
ALTER TABLE `hasil_spk`
  ADD PRIMARY KEY (`id_spk`),
  ADD KEY `id_calon_kr` (`id_calon_kr`);

--
-- Indeks untuk tabel `hasil_tpa`
--
ALTER TABLE `hasil_tpa`
  ADD PRIMARY KEY (`id_test`),
  ADD KEY `id_calon_kr` (`id_calon_kr`);

--
-- Indeks untuk tabel `kegiatan`
--
ALTER TABLE `kegiatan`
  ADD PRIMARY KEY (`id_kegiatan`);

--
-- Indeks untuk tabel `kriteria`
--
ALTER TABLE `kriteria`
  ADD PRIMARY KEY (`id_kriteria`);

--
-- Indeks untuk tabel `pendaftaran`
--
ALTER TABLE `pendaftaran`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_pendafta_relations_warga` (`nim`);

--
-- Indeks untuk tabel `pengurus`
--
ALTER TABLE `pengurus`
  ADD PRIMARY KEY (`nim_pengurus`);

--
-- Indeks untuk tabel `sub_kriteria`
--
ALTER TABLE `sub_kriteria`
  ADD PRIMARY KEY (`id_subkriteria`);

--
-- Indeks untuk tabel `warga`
--
ALTER TABLE `warga`
  ADD PRIMARY KEY (`nim`),
  ADD KEY `fk_warga_relations_pengurus` (`nim_pengurus`),
  ADD KEY `fk_warga_relations_extrakul` (`id_extra`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `hasil_spk`
--
ALTER TABLE `hasil_spk`
  MODIFY `id_spk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT untuk tabel `hasil_tpa`
--
ALTER TABLE `hasil_tpa`
  MODIFY `id_test` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT untuk tabel `kriteria`
--
ALTER TABLE `kriteria`
  MODIFY `id_kriteria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT untuk tabel `sub_kriteria`
--
ALTER TABLE `sub_kriteria`
  MODIFY `id_subkriteria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `absensi`
--
ALTER TABLE `absensi`
  ADD CONSTRAINT `fk_absensi_relations_extrakul` FOREIGN KEY (`id_extra`) REFERENCES `extrakulikuler` (`id_extra`),
  ADD CONSTRAINT `fk_absensi_relations_kegiatan` FOREIGN KEY (`id_kegiatan`) REFERENCES `kegiatan` (`id_kegiatan`),
  ADD CONSTRAINT `fk_absensi_relations_pengurus` FOREIGN KEY (`nim_pengurus`) REFERENCES `pengurus` (`nim_pengurus`),
  ADD CONSTRAINT `fk_absensi_relations_warga` FOREIGN KEY (`nim`) REFERENCES `warga` (`nim`);

--
-- Ketidakleluasaan untuk tabel `formulir_kegiatan`
--
ALTER TABLE `formulir_kegiatan`
  ADD CONSTRAINT `fk_formulir_relations_kegiatan` FOREIGN KEY (`id_kegiatan`) REFERENCES `kegiatan` (`id_kegiatan`),
  ADD CONSTRAINT `fk_formulir_relations_warga` FOREIGN KEY (`nim`) REFERENCES `warga` (`nim`);

--
-- Ketidakleluasaan untuk tabel `formulir_kepuasan`
--
ALTER TABLE `formulir_kepuasan`
  ADD CONSTRAINT `formulir_kepuasan_ibfk_1` FOREIGN KEY (`nim`) REFERENCES `warga` (`nim`);

--
-- Ketidakleluasaan untuk tabel `pendaftaran`
--
ALTER TABLE `pendaftaran`
  ADD CONSTRAINT `fk_pendafta_relations_warga` FOREIGN KEY (`nim`) REFERENCES `warga` (`nim`);

--
-- Ketidakleluasaan untuk tabel `warga`
--
ALTER TABLE `warga`
  ADD CONSTRAINT `fk_warga_relations_extrakul` FOREIGN KEY (`id_extra`) REFERENCES `extrakulikuler` (`id_extra`),
  ADD CONSTRAINT `fk_warga_relations_pengurus` FOREIGN KEY (`nim_pengurus`) REFERENCES `pengurus` (`nim_pengurus`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
