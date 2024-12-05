-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 05 Des 2024 pada 17.29
-- Versi server: 10.4.24-MariaDB
-- Versi PHP: 8.1.6

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
  `jenis_absen` varchar(255) DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `absensi`
--

INSERT INTO `absensi` (`id_absen`, `id_kegiatan`, `nim`, `id_extra`, `nim_pengurus`, `status_kehadiran`, `waktu_absen`, `jenis_absen`, `keterangan`) VALUES
(1, 7, '250301100012', NULL, '250420100066', 'Hadir', '2024-11-11 12:00:00', 'Kegiatan', NULL),
(2, NULL, '250301100012', 2, '250420100066', 'Hadir', '2024-11-17 16:09:57', 'Ekstrakurikuler', 'Alasan pribadi'),
(3, NULL, '250411100055', 1, '250420100066', 'Hadir', '2024-11-11 12:30:00', 'Ekstrakurikuler', NULL),
(4, 7, '250411100055', NULL, '250420100066', 'Hadir', '2024-11-12 12:30:00', 'Kegiatan', NULL),
(7, 7, '250511010004', NULL, '250420100066', 'Hadir', '2024-11-12 12:15:00', 'Kegiatan', NULL),
(8, NULL, '250511010004', 4, '250420100066', 'Hadir', '2024-11-15 12:00:00', 'Ekstrakurikuler', NULL),
(9, NULL, '250301100012', NULL, '250213300055', 'Hadir', '2024-11-09 20:30:00', 'Harian (Subuh)', NULL),
(10, NULL, '250301100012', NULL, '250213300055', 'Izin', '2024-11-09 21:10:00', 'Harian (Tadarus)', 'Sakit Demam Derdiri'),
(11, NULL, '250301100012', NULL, '250213300055', 'Hadir', '2024-11-10 11:00:00', 'Harian (Magrib)', NULL),
(12, NULL, '250301100012', NULL, '250213300055', 'Hadir', '2024-11-10 11:01:00', 'Harian (Kajian)', NULL),
(13, NULL, '250301100012', NULL, '250213300055', 'Hadir', '2024-11-10 12:04:10', 'Harian (Isya)', NULL),
(14, NULL, '250301100012', NULL, '250213300055', 'Hadir', '2024-11-09 19:00:00', 'Harian (Qiamul Lail)', NULL),
(15, NULL, '250301100012', NULL, '250213300055', 'Hadir', '2024-11-10 03:00:00', 'Harian (Tinggal Di Asrama)', NULL),
(52, NULL, '250411100055', NULL, '250313100100', 'Alfa', '2024-11-09 20:30:00', 'Harian (Subuh)', 'Tanpa Keterangan'),
(53, NULL, '250411100055', NULL, '250313100100', 'Alfa', '2024-11-09 21:10:00', 'Harian (Tadarus)', 'Tanpa Keterangan'),
(54, NULL, '250411100055', NULL, '250313100100', 'Hadir', '2024-11-10 11:00:00', 'Harian (Magrib)', NULL),
(55, NULL, '250411100055', NULL, '250313100100', 'Hadir', '2024-11-10 11:01:00', 'Harian (Kajian)', NULL),
(56, NULL, '250411100055', NULL, '250313100100', 'Hadir', '2024-11-10 12:04:10', 'Harian (Isya)', NULL),
(57, NULL, '250411100055', NULL, '250313100100', 'Alfa', '2024-11-09 19:00:00', 'Harian (Qiamul Lail)', 'Tanpa Keterangan'),
(58, NULL, '250411100055', NULL, '250313100100', 'Alfa', '2024-11-10 03:00:00', 'Harian (Tinggal Di Asrama)', 'Tanpa Keterangan'),
(66, NULL, '250511010004', NULL, '250215500115', 'Alfa', '2024-11-09 20:30:00', 'Harian (Subuh)', 'Tidur'),
(67, NULL, '250511010004', NULL, '250215500115', 'Hadir', '2024-11-09 21:10:00', 'Harian (Tadarus)', NULL),
(68, NULL, '250511010004', NULL, '250215500115', 'Hadir', '2024-11-10 11:00:00', 'Harian (Magrib)', NULL),
(69, NULL, '250511010004', NULL, '250215500115', 'Hadir', '2024-11-10 11:01:00', 'Harian (Kajian)', NULL),
(70, NULL, '250511010004', NULL, '250215500115', 'Hadir', '2024-11-10 12:04:10', 'Harian (Isya)', NULL),
(71, NULL, '250511010004', NULL, '250215500115', 'Hadir', '2024-11-09 19:00:00', 'Harian (Qiamul Lail)', NULL),
(72, NULL, '250511010004', NULL, '250215500115', 'Hadir', '2024-11-10 03:00:00', 'Harian (Tinggal Di Asrama)', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `bukti_pembayaran`
--

CREATE TABLE `bukti_pembayaran` (
  `id_bukti` int(11) NOT NULL,
  `nim` varchar(12) NOT NULL,
  `tanggal_upload` datetime DEFAULT current_timestamp(),
  `jumlah_bayar` int(11) NOT NULL,
  `metode_bayar` varchar(30) NOT NULL,
  `status_verifikasi` enum('menunggu','diterima','ditolak') DEFAULT 'menunggu',
  `gambar` varchar(255) NOT NULL,
  `catatan_admin` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `bukti_pembayaran`
--

INSERT INTO `bukti_pembayaran` (`id_bukti`, `nim`, `tanggal_upload`, `jumlah_bayar`, `metode_bayar`, `status_verifikasi`, `gambar`, `catatan_admin`) VALUES
(1, '250301100012', '2024-11-10 14:30:00', 900000, 'Transfer Bank', 'diterima', 'bukti_transfer_2200010001.jpg', 'Pembayaran diterima, terima kasih.'),
(2, '250411100055', '2024-11-11 09:15:00', 900000, 'Teller', 'menunggu', 'bukti_bayar_2200010002.jpg', NULL),
(4, '250511010004', '2024-11-13 11:45:00', 900000, 'Transfer Bank', 'diterima', 'bukti_transfer_2200010004.jpg', 'Pembayaran berhasil diverifikasi.');

-- --------------------------------------------------------

--
-- Struktur dari tabel `extrakulikuler`
--

CREATE TABLE `extrakulikuler` (
  `id_extra` int(11) NOT NULL,
  `nama_extra` varchar(255) DEFAULT NULL,
  `deskripsi_extra` text DEFAULT NULL,
  `gambar_pamflet` varchar(255) DEFAULT NULL,
  `jadwal` varchar(25) DEFAULT NULL,
  `kuota` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `extrakulikuler`
--

INSERT INTO `extrakulikuler` (`id_extra`, `nama_extra`, `deskripsi_extra`, `gambar_pamflet`, `jadwal`, `kuota`) VALUES
(1, 'Tarbiyatul Arabiyah', 'Kegiatan ekstrakurikuler untuk meningkatkan kemampuan bahasa arab', 'tarbiyatul_pamflet.jpg', 'Senin dan Rabu, 16:00 - 1', 30),
(2, 'English Course', 'Course English untuk belajar dan berlatih bahasa inggris.', 'english_pamflet.jpg', 'Selasa dan Kamis, 17:00 -', 25),
(3, 'Dormitory IT', 'Extra untuk melatih kemampuan editing dan fotografi.', 'it_pamflet.jpg', 'Jumat, 15:00 - 17:00', 20),
(4, 'Arduino', 'Kegiatan untuk belajar micro cotroller dengan menggunakan arduino.', 'arduino_pamflet.jpg', 'Sabtu, 10:00 - 12:00', 15),
(5, 'Pelatihan Banjari', 'Klub banjari untuk belajar banjari', 'banjari_pamflet.jpg', 'Minggu, 14:00 - 16:00', 10);

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
  `saran_masukan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `formulir_kegiatan`
--

INSERT INTO `formulir_kegiatan` (`id_formulir_kegiatan`, `id_kegiatan`, `nim`, `pertanyaan1`, `pertanyaan2`, `pertanyaan3`, `pertanyaan4`, `pertanyaan5`, `saran_masukan`) VALUES
(1, 2, '250411100055', 'Sangat Baik', 'Baik', 'Cukup', 'Sangat Baik', 'Baik', 'Acara sangat bermanfaat, harap diadakan lebih sering.'),
(2, 2, '250301100012', 'Baik', 'Cukup', 'Cukup', 'Baik', 'Cukup', 'Harap waktu kegiatan lebih fleksibel.'),
(4, 2, '250511010004', 'Baik', 'Baik', 'Baik', 'Cukup', 'Baik', 'Mungkin bisa ditambahkan contoh studi kasus di kegiatan ini.'),
(5, 7, '250511010004', 'Cukup', 'Cukup', 'Cukup', 'Cukup', 'Baik', 'Harap panitia lebih tegas soal jadwal dimulai.'),
(7, 7, '250411100055', 'Baik', 'Baik', 'Cukup', 'Baik', 'Sangat Baik', 'Saran saya, promosi lebih gencar di sosial media.');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `formulir_kepuasan`
--

INSERT INTO `formulir_kepuasan` (`id_formulir`, `nim`, `pesan`, `created_at`, `kategori`) VALUES
(3, '250511010004', 'Pamflet acara sulit ditemukan di media sosial.', '2024-11-17 06:32:10', 'Promosi'),
(4, '250301100012', 'Instruktur workshop sangat profesional.', '2024-11-17 06:32:10', 'Kualitas Pengajar'),
(5, '250301100012', 'Jadwal kegiatan terlalu berdekatan dengan ujian.', '2024-11-17 06:32:10', 'Penjadwalan'),
(6, '250301100012', 'Acara sangat terorganisir dan sesuai jadwal.', '2024-11-17 06:32:10', 'Kegiatan');

-- --------------------------------------------------------

--
-- Struktur dari tabel `hasil_spk`
--

CREATE TABLE `hasil_spk` (
  `id_spk` int(11) NOT NULL,
  `id_calon_kr` varchar(12) CHARACTER SET utf8mb4 NOT NULL,
  `hasil_spk` float(10,2) DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `hasil_spk`
--

INSERT INTO `hasil_spk` (`id_spk`, `id_calon_kr`, `hasil_spk`, `status`) VALUES
(85, '250301100012', 75.18, 'Lulus'),
(86, '250411100055', 62.86, 'Tidak Lulus'),
(88, '250511010004', 75.50, 'Lulus');

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `hasil_tpa`
--

INSERT INTO `hasil_tpa` (`id_test`, `id_calon_kr`, `Sikap`, `Pelanggaran`, `Absensi_Harian`, `Absensi_Kegiatan`, `Absensi_Extra`) VALUES
(79, '250301100012', 92.00, 70.00, 6.00, 1.00, 1.00),
(80, '250411100055', 93.00, 67.00, 3.00, 1.00, 1.00),
(81, '250411200063', 93.00, 96.00, 7.00, 1.00, 1.00),
(82, '250511010004', 91.00, 67.00, 6.00, 1.00, 1.00);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `kegiatan`
--

INSERT INTO `kegiatan` (`nama_kegiatan`, `id_kegiatan`, `tanggal_kegiatan`, `created_at`, `deskripsi`, `foto_pamflet`, `tempat`) VALUES
('Dormitory Competition', 2, '2024-11-25 09:00:00', '2024-11-17 06:27:53', 'Lomba cerdas cermat tingkat mahasiswa.', 'lomba_cc.jpg', 'Aula Gedung C'),
('Workshop Kewirausahaan', 7, '2024-12-15 09:30:00', '2024-11-17 06:27:53', 'Workshop mengenai pengelolaan bisnis dan ide startup.', 'workshop_kewirausahaan.jpg', 'Ruang Kelas Gedung E');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kriteria`
--

CREATE TABLE `kriteria` (
  `id_kriteria` int(11) NOT NULL,
  `kriteria` varchar(32) DEFAULT NULL,
  `bobot` float(5,2) DEFAULT NULL,
  `type` varchar(12) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `kriteria`
--

INSERT INTO `kriteria` (`id_kriteria`, `kriteria`, `bobot`, `type`) VALUES
(34, 'Sikap', 10.00, 'Benefit'),
(35, 'Pelanggaran', 10.00, 'Cost'),
(36, 'Absensi_Harian', 30.00, 'Benefit'),
(37, 'Absensi_Kegiatan', 20.00, 'Benefit'),
(38, 'Absensi_Extra', 10.00, 'Benefit');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pendaftaran`
--

CREATE TABLE `pendaftaran` (
  `id` int(11) NOT NULL,
  `nim` varchar(12) DEFAULT NULL,
  `nama_lengkap` varchar(255) DEFAULT NULL,
  `prodi_pendaftar` varchar(255) DEFAULT NULL,
  `foto_pendaftar` varchar(255) DEFAULT NULL,
  `alamat_pendaftar` varchar(255) DEFAULT NULL,
  `ttl` varchar(255) DEFAULT NULL,
  `no_hp_pendaftar` varchar(12) DEFAULT NULL,
  `email_pendaftar` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `created_at_pendaftar` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `nomor_pendaftaran` varchar(255) DEFAULT NULL,
  `jenis_kelamin` varchar(12) DEFAULT NULL,
  `jalur_masuk` varchar(255) DEFAULT NULL,
  `foto_bukti_lolos_ptn` varchar(255) DEFAULT NULL,
  `nama_ayah` varchar(255) DEFAULT NULL,
  `nama_ibu` varchar(255) DEFAULT NULL,
  `no_hp_ortu` varchar(255) DEFAULT NULL,
  `status` enum('pending','rejected','accepted','') NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `pendaftaran`
--

INSERT INTO `pendaftaran` (`id`, `nim`, `nama_lengkap`, `prodi_pendaftar`, `foto_pendaftar`, `alamat_pendaftar`, `ttl`, `no_hp_pendaftar`, `email_pendaftar`, `password`, `created_at_pendaftar`, `nomor_pendaftaran`, `jenis_kelamin`, `jalur_masuk`, `foto_bukti_lolos_ptn`, `nama_ayah`, `nama_ibu`, `no_hp_ortu`, `status`) VALUES
(1, '250411100055', 'Ahmad Riyadi', 'Teknik Informatika', 'foto1.jpg', 'Jl. Merdeka No.1', 'Jakarta, 01-01-2000', '081234567891', 'ahmadriyadi@gmail.com', '482c811da5d5b4bc6d497ffa98491e38', '2024-12-03 17:22:33', 'REG-0001', 'Laki-laki', 'SNMPTN', 'bukti1.jpg', 'Budi Riyadi', 'Siti Aminah', '081234567890', 'accepted'),
(2, '250301100012', 'Siti Nurhaliza', 'Sastra Inggris', 'foto2.jpg', 'Jl. Sudirman No.2', 'Bandung, 02-02-2001', '081234567892', 'siti@gmail.com', '482c811da5d5b4bc6d497ffa98491e38', '2024-12-03 17:22:33', 'REG-0002', 'Perempuan', 'SBMPTN', 'bukti2.jpg', 'Rahmat', 'Maryam', '081234567891', 'accepted'),
(3, '250201100155', 'Rizki Pratama', 'Manajemen', 'foto3.jpg', 'Jl. Kuningan No.3', 'Surabaya, 03-03-2002', '081234567893', 'rizki@gmail.com', '9592638716b04b52fe6e041429822a79', '2024-12-03 17:22:33', 'REG-0003', 'Laki-laki', 'Mandiri', 'bukti3.jpg', 'Hadi Pratama', 'Nurhasanah', '081234567892', 'rejected'),
(4, '250111000156', 'Nurul Azizah', 'Pendidikan Informatika', 'foto4.jpg', 'Jl. Suryo No.4', 'Medan, 04-04-2003', '081234567894', 'nurul@gmail.com', '55811d685377dc59c4f23b946670dcca', '2024-12-03 17:22:33', 'REG-0004', 'Perempuan', 'SNMPTN', 'bukti4.jpg', 'Ahmad', 'Siti', '081234567893', 'rejected'),
(5, '250411200063', 'Farhan Maulana', 'Teknik Elektro', 'foto5.jpg', 'Jl. Diponegoro No.5', 'Makassar, 05-05-2004', '081234567895', 'farhan@gmail.com', '1ac5012170b65fb99f171ad799d045ac', '2024-12-03 17:22:33', 'REG-0005', 'Laki-laki', 'SBMPTN', 'bukti5.jpg', 'Rizal', 'Aisyah', '081234567894', 'accepted'),
(6, '250511010004', 'Dina Puspita', 'Psikologi', 'foto6.jpg', 'Jl. Satrio No.6', 'Yogyakarta, 06-06-2005', '081234567896', 'dina@gmail.com', 'f093c0fed979519fbc43d772b76f5c86', '2024-12-03 17:22:33', 'REG-0006', 'Perempuan', 'Mandiri', 'bukti6.jpg', 'Syahrul', 'Salma', '081234567895', 'accepted'),
(7, '250411100082', 'Hendra Wijaya', 'Ilmu Hukum', 'foto7.jpg', 'Jl. Thamrin No.7', 'Semarang, 07-07-2000', '081234567897', 'hendra@gmail.com', '', '2024-12-03 17:41:09', 'REG-0007', 'Laki-laki', 'SNMPTN', 'bukti7.jpg', 'Usman', 'Fatimah', '081234567896', 'rejected'),
(8, '250501200001', 'Rina Maharani', 'Ekonomi Pembangunan', 'foto8.jpg', 'Jl. Pahlawan No.8', 'Malang, 08-08-2001', '081234567898', 'rina@gmail.com', '9a1591b6e5317fb71c6032eedd5c051a', '2024-12-03 17:26:49', 'REG-0008', 'Perempuan', 'SBMPTN', 'bukti8.jpg', 'Hasan', 'Umi', '081234567897', 'rejected'),
(9, '250900100100', 'Arif Setiawan', 'Ekonomi Syariah', 'foto9.jpg', 'Jl. Mangga No.9', 'Bali, 09-09-2002', '081234567899', 'arif@gmail.com', 'd53d757c0f838ea49fb46e09cbcc3cb1', '2024-12-03 20:12:11', 'REG-0009', 'Laki-laki', 'Mandiri', 'bukti9.jpg', 'Rudi', 'Nurul', '081234567898', 'pending'),
(10, '251000100200', 'Rini Handayani', 'Pendidikan Guru Sekola Dasar', 'foto10.jpg', 'Jl. Cemara No.10', 'Batam, 10-10-2003', '081234567890', 'rini@gmail.com', '07a7af79e06caf7153289574a97037ff', '2024-12-03 20:12:11', 'REG-0010', 'Perempuan', 'SNMPTN', 'bukti10.jpg', 'Bambang', 'Yuni', '081234567899', 'pending'),
(11, '250110000025', 'Adi Nugroho', 'Sosiologi', 'foto11.jpg', 'Jl. Merpati No.11', 'Pontianak, 11-11-2004', '081234567891', 'adi@gmail.com', '7360409d967a24b667afc33a8384ec9e', '2024-12-03 20:12:11', 'REG-0011', 'Laki-laki', 'SBMPTN', 'bukti11.jpg', 'Edi', 'Sri', '081234567890', 'pending'),
(12, '250400300022', 'Putri Ayu', 'Pendidikan IPA', 'foto12.jpg', 'Jl. Melati No.12', 'Palembang, 12-12-2005', '081234567892', 'putri@gmail.com', '82682943a05de360abb183236c632bd6', '2024-12-03 17:23:54', 'REG-0012', 'Perempuan', 'Mandiri', 'bukti12.jpg', 'Arman', 'Siti', '081234567891', 'pending'),
(13, '250411300088', 'Dodi Prasetyo', 'Teknik Elektro', 'foto13.jpg', 'Jl. Mawar No.13', 'Padang, 13-01-2000', '081234567893', 'dodi@gmail.com', '', '2024-12-03 17:25:45', 'REG-0013', 'Laki-laki', 'SNMPTN', 'bukti13.jpg', 'Yanto', 'Lina', '081234567892', 'pending'),
(14, '250100100001', 'Mira Kusuma', 'Akuntansi', 'foto14.jpg', 'Jl. Anggrek No.14', 'Manado, 14-02-2001', '081234567894', 'mira@gmail.com', '83469ed2521f07cb27804061cf244132', '2024-12-03 17:25:45', 'REG-0014', 'Perempuan', 'SBMPTN', 'bukti14.jpg', 'Rusdi', 'Asih', '081234567893', 'pending'),
(15, '250311100025', 'Fajar Santoso', 'Ilmu Komunikasi', 'foto15.jpg', 'Jl. Nusa No.15', 'Kupang, 15-03-2002', '081234567895', 'fajar@gmail.com', '7bedc9fd30769590c992b8f7f23738f7', '2024-12-03 20:12:11', 'REG-0015', 'Laki-laki', 'Mandiri', 'bukti15.jpg', 'Slamet', 'Rina', '081234567894', 'pending');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `pengurus`
--

INSERT INTO `pengurus` (`nama_pengurus`, `nim_pengurus`, `kamar_pengurus`, `gedung_pengurus`, `no_hp_pengurus`, `password_pengurus`, `email_pengurus`, `divisi_pengurus`, `jabatan_pengurus`, `foto_pengurus`, `prodi_pengurus`, `jenis_kelamin_pengurus`) VALUES
('Citra Lestari', '250213300055', '303', 'Gedung C', '081234567892', 'a471cc23d89f15b4c552246412714ee8', 'citra@gmail.com', 'Pengurus Harian', 'Sekretaris', 'foto3.jpg', 'Ekonomi Pembangunan', 'Perempuan'),
('Hana Puspita', '250215500115', '408', 'Gedung E', '081234567897', '3b7972d6e14381a8f234aaf14c813d2e', 'hana@gmail.com', 'Kominfo', 'Anggota', 'foto8.jpg', 'Psikologi', 'Perempuan'),
('Habib Maulana', '250311100022', '102', 'Gedung D', '081234567890', '3573dd3c8f7fa2075538bb9c8a3a4d48', 'habib@gmail.com', 'Pengurus Harian', 'Ketua', 'foto1.jpg', 'Pendidikan Informatika', 'Laki-laki'),
('Erwin Pratama', '250313100100', '305', 'Gedung E', '081234567894', '66589ae77387a90660219a2aad624e94', 'erwin@gmail.com', 'Teknisi', 'Anggota', 'foto5.jpg', 'Teknik Mesin', 'Laki-laki'),
('Joko Susanto', '25031330077', '310', 'Gedung A', '081234567899', '278ea841c0d133059032b8a75320c3e0', 'joko@gmail.com', 'Kewirausahaan', 'Anggota', 'foto10.jpg', 'Agribisnis', 'Laki-laki'),
('Ivan Nugraha', '25033300113', '309', 'Gedung B', '081234567898', 'b7727d252be76bc6d142e19315cfc8fd', 'ivan@gmail.com', 'Peribadatan', 'Anggota', 'foto9.jpg', 'Sistem Informasi', 'Laki-laki'),
('Farhan Maulana', '250411200063', 'ghj', 'D', '081234567895', '1ac5012170b65fb99f171ad799d045ac', '220411100082@student.trunojoyo.ac.id', 'Kebersihan', 'Koordinator', 'foto5.jpg', 'Teknik Elektro', 'Laki-laki'),
('Budi Santoso', '250413100023', '202', 'Gedung D', '081234567891', '9c5fa085ce256c7c598f6710584ab25d', 'budi@gmail.com', 'Kebersihan Kesehatan', 'CO', 'foto2.jpg', 'Manajemen', 'Laki-laki'),
('Dewi Anggraini', '250420100066', '214', 'Gedung D', '081234567893', 'fde0b737496c53bb85d07b31a02985a3', 'dewi@gmail.com', 'Pengurus Harian', 'Bendahara', 'foto4.jpg', 'Ilmu Komunikasi', 'Perempuan'),
('Fitriani Putri', '250513100203', '206', 'Gedung C', '081234567895', '8ac99bb12b7c18e27d06fd34fe1203fc', 'fitri@gmail.com', 'Keamanan', 'Anggota', 'foto6.jpg', 'Pendidikan IPA', 'Perempuan');

-- --------------------------------------------------------

--
-- Struktur dari tabel `sub_kriteria`
--

CREATE TABLE `sub_kriteria` (
  `id_subkriteria` int(11) NOT NULL,
  `id_kriteria` int(11) NOT NULL,
  `subkriteria` varchar(255) NOT NULL,
  `nilai` float(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `sub_kriteria`
--

INSERT INTO `sub_kriteria` (`id_subkriteria`, `id_kriteria`, `subkriteria`, `nilai`) VALUES
(67, 35, '1 Kali', 1.00),
(68, 35, '2 Kali', 2.00),
(69, 35, '3 Kali', 3.00),
(70, 35, 'Lebih dari 3 Kali', 4.00),
(91, 34, 'Buruk', 1.00),
(92, 34, 'Baik Sekali', 5.00),
(93, 34, 'Baik', 4.00),
(94, 34, 'Cukup', 3.00),
(95, 34, 'Kurang', 2.00),
(96, 35, 'Tidak Ada', -1.00);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `warga`
--

INSERT INTO `warga` (`nim`, `id_extra`, `nim_pengurus`, `nama`, `no_hp`, `password`, `kamar`, `foto_warga`, `email`, `gedung`, `prodi`) VALUES
('250301100012', 4, '250213300055', 'Siti Nurhaliza', '081234567892', '482c811da5d5b4bc6d497ffa98491e38', '314', 'foto2.jpg', '220411100060@student.trunojoyo.ac.id', 'C', 'Sastra Inggris'),
('250411100055', NULL, '250313100100', 'Ahmad Riyadi', '081234567891', '482c811da5d5b4bc6d497ffa98491e38', '205', 'foto1.jpg', 'muhammadalivian164@gmail.com\r\n', 'D', 'Teknik Informatika'),
('250511010004', 5, '250215500115', 'Dina Puspita', '081234567896', 'f093c0fed979519fbc43d772b76f5c86', '404', 'foto6.jpg', '220411100164@student.trunojoyo.ac.id', 'E', 'Psikologi');

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
-- Indeks untuk tabel `bukti_pembayaran`
--
ALTER TABLE `bukti_pembayaran`
  ADD PRIMARY KEY (`id_bukti`),
  ADD KEY `nim` (`nim`);

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
  ADD KEY `nim` (`nim`);

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
  ADD PRIMARY KEY (`id_subkriteria`),
  ADD KEY `id_kriteria` (`id_kriteria`);

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
-- AUTO_INCREMENT untuk tabel `absensi`
--
ALTER TABLE `absensi`
  MODIFY `id_absen` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT untuk tabel `bukti_pembayaran`
--
ALTER TABLE `bukti_pembayaran`
  MODIFY `id_bukti` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `hasil_spk`
--
ALTER TABLE `hasil_spk`
  MODIFY `id_spk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;

--
-- AUTO_INCREMENT untuk tabel `hasil_tpa`
--
ALTER TABLE `hasil_tpa`
  MODIFY `id_test` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- AUTO_INCREMENT untuk tabel `kriteria`
--
ALTER TABLE `kriteria`
  MODIFY `id_kriteria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT untuk tabel `pendaftaran`
--
ALTER TABLE `pendaftaran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT untuk tabel `sub_kriteria`
--
ALTER TABLE `sub_kriteria`
  MODIFY `id_subkriteria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=97;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `absensi`
--
ALTER TABLE `absensi`
  ADD CONSTRAINT `absensi_ibfk_1` FOREIGN KEY (`nim`) REFERENCES `warga` (`nim`) ON DELETE CASCADE,
  ADD CONSTRAINT `absensi_ibfk_2` FOREIGN KEY (`nim_pengurus`) REFERENCES `pengurus` (`nim_pengurus`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_absensi_relations_extrakul` FOREIGN KEY (`id_extra`) REFERENCES `extrakulikuler` (`id_extra`),
  ADD CONSTRAINT `fk_absensi_relations_kegiatan` FOREIGN KEY (`id_kegiatan`) REFERENCES `kegiatan` (`id_kegiatan`);

--
-- Ketidakleluasaan untuk tabel `bukti_pembayaran`
--
ALTER TABLE `bukti_pembayaran`
  ADD CONSTRAINT `bukti_pembayaran_ibfk_1` FOREIGN KEY (`nim`) REFERENCES `warga` (`nim`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `formulir_kegiatan`
--
ALTER TABLE `formulir_kegiatan`
  ADD CONSTRAINT `fk_formulir_relations_kegiatan` FOREIGN KEY (`id_kegiatan`) REFERENCES `kegiatan` (`id_kegiatan`),
  ADD CONSTRAINT `formulir_kegiatan_ibfk_1` FOREIGN KEY (`nim`) REFERENCES `warga` (`nim`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `formulir_kepuasan`
--
ALTER TABLE `formulir_kepuasan`
  ADD CONSTRAINT `formulir_kepuasan_ibfk_2` FOREIGN KEY (`nim`) REFERENCES `warga` (`nim`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `hasil_spk`
--
ALTER TABLE `hasil_spk`
  ADD CONSTRAINT `hasil_spk_ibfk_2` FOREIGN KEY (`id_calon_kr`) REFERENCES `warga` (`nim`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `sub_kriteria`
--
ALTER TABLE `sub_kriteria`
  ADD CONSTRAINT `sub_kriteria_ibfk_1` FOREIGN KEY (`id_kriteria`) REFERENCES `kriteria` (`id_kriteria`);

--
-- Ketidakleluasaan untuk tabel `warga`
--
ALTER TABLE `warga`
  ADD CONSTRAINT `fk_warga_relations_extrakul` FOREIGN KEY (`id_extra`) REFERENCES `extrakulikuler` (`id_extra`),
  ADD CONSTRAINT `warga_ibfk_1` FOREIGN KEY (`nim_pengurus`) REFERENCES `pengurus` (`nim_pengurus`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
