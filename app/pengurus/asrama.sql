-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 20 Nov 2024 pada 11.15
-- Versi server: 10.4.28-MariaDB
-- Versi PHP: 8.1.17

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
  `keterangan` varchar(255) DEFAULT NULL,
  `sholat` varchar(200) NOT NULL,
  `liqoan` varchar(200) NOT NULL,
  `tahajud` varchar(200) NOT NULL,
  `kajian` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `absensi`
--

INSERT INTO `absensi` (`id_absen`, `id_kegiatan`, `nim`, `id_extra`, `nim_pengurus`, `status_kehadiran`, `waktu_absen`, `jenis_absen`, `keterangan`, `sholat`, `liqoan`, `tahajud`, `kajian`) VALUES
(0, NULL, '220411100077', NULL, '220411100060', 'hadir', '2024-11-18 12:00:00', 'Harian', 'maghrib', '', '', '', ''),
(1, NULL, '220411100077', NULL, '220411100060', 'sakit', '2024-11-18 00:43:00', 'Harian', 'maghrib', '', '', '', ''),
(2, NULL, '220411100077', NULL, '220411100060', 'hadir', '2024-11-19 16:54:00', 'Harian', 'maghrib', '', '', '', ''),
(4, NULL, '220411100067', NULL, '220411100020', '', '0000-00-00 00:00:00', 'Harian', '', '', '', '', ''),
(5, NULL, '220411100077', NULL, '220411100060', '', '0000-00-00 00:00:00', 'Harian', '', '', '', '', ''),
(6, NULL, '220411100077', NULL, '220411100060', '', '0000-00-00 00:00:00', 'Harian', '\r\n', '', '', '', ''),
(7, NULL, '220411100077', NULL, NULL, '', '0000-00-00 00:00:00', 'Harian', '', '', '', '', ''),
(8, NULL, '220411100067', NULL, '220411100020', NULL, '0000-00-00 00:00:00', 'Harian', NULL, '', '', '', '');

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
  `saran_masukan` longtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
('Wildan', '220411100020', '206', 'D', '081554906254', NULL, NULL, NULL, 'Divisi Peribadatan', NULL, NULL, NULL),
('nadhif', '220411100060', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `spk`
--

CREATE TABLE `spk` (
  `id_spk` int(11) NOT NULL,
  `nim` varchar(12) DEFAULT NULL,
  `score` float DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
('22041110001', NULL, '220411100020', 'Hiyuki', '081554906254', NULL, '307', NULL, NULL, 'D', 'Teknik INformatika'),
('220411100067', NULL, '220411100060', 'fadhil', '081554906254', NULL, '201', NULL, NULL, 'D', NULL),
('220411100077', NULL, '220411100060', 'wildan', '081554906254', NULL, '201', NULL, NULL, 'd', NULL);

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
  ADD PRIMARY KEY (`id_formulir`);

--
-- Indeks untuk tabel `kegiatan`
--
ALTER TABLE `kegiatan`
  ADD PRIMARY KEY (`id_kegiatan`);

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
-- Indeks untuk tabel `spk`
--
ALTER TABLE `spk`
  ADD PRIMARY KEY (`id_spk`),
  ADD KEY `fk_spk_relations_warga` (`nim`);

--
-- Indeks untuk tabel `warga`
--
ALTER TABLE `warga`
  ADD PRIMARY KEY (`nim`),
  ADD KEY `fk_warga_relations_pengurus` (`nim_pengurus`),
  ADD KEY `fk_warga_relations_extrakul` (`id_extra`);

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
-- Ketidakleluasaan untuk tabel `pendaftaran`
--
ALTER TABLE `pendaftaran`
  ADD CONSTRAINT `fk_pendafta_relations_warga` FOREIGN KEY (`nim`) REFERENCES `warga` (`nim`);

--
-- Ketidakleluasaan untuk tabel `spk`
--
ALTER TABLE `spk`
  ADD CONSTRAINT `fk_spk_relations_warga` FOREIGN KEY (`nim`) REFERENCES `warga` (`nim`);

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
