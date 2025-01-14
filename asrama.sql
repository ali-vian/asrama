-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 14 Jan 2025 pada 14.39
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
(3, NULL, '250411100055', 1, '250420100066', 'hadir', '2024-12-15 20:53:00', 'Ekstrakurikuler', 'maghrib'),
(4, 7, '250411100055', NULL, '250420100066', 'Hadir', '2024-11-12 12:30:00', 'Kegiatan', NULL),
(52, NULL, '250411100055', NULL, '250313100100', 'Alfa', '2024-11-09 20:30:00', 'Harian (Subuh)', 'Tanpa Keterangan'),
(53, NULL, '250411100055', NULL, '250313100100', 'Alfa', '2024-11-09 21:10:00', 'Harian (Tadarus)', 'Tanpa Keterangan'),
(54, NULL, '250411100055', NULL, '250313100100', 'Hadir', '2024-11-10 11:00:00', 'Harian (Magrib)', NULL),
(55, NULL, '250411100055', NULL, '250313100100', 'Hadir', '2024-11-10 11:01:00', 'Harian (Kajian)', NULL),
(56, NULL, '250411100055', NULL, '250313100100', 'Hadir', '2024-11-10 12:04:10', 'Harian (Isya)', NULL),
(57, NULL, '250411100055', NULL, '250313100100', 'Alfa', '2024-11-09 19:00:00', 'Harian (Qiamul Lail)', 'Tanpa Keterangan'),
(58, NULL, '250411100055', NULL, '250313100100', 'Alfa', '2024-11-10 03:00:00', 'Harian (Tinggal Di Asrama)', 'Tanpa Keterangan'),
(73, NULL, '250411100004', 1, '250420100066', 'Hadir', '2024-12-15 22:00:00', 'Ekstrakurikuler', 'Senam Pagi'),
(76, NULL, '250411100007', NULL, '250420100066', 'Hadir', '2024-12-16 13:00:00', 'Harian (Isya)', 'Shalat Jamaah'),
(77, NULL, '250411100008', NULL, '250313100100', 'Alfa', '2024-12-14 21:00:00', 'Harian (Tadarus)', 'Tanpa Keterangan'),
(79, NULL, '250411100010', NULL, '250313100100', 'Alfa', '2024-12-13 19:00:00', 'Harian (Qiamul Lail)', 'Tidur'),
(81, NULL, '250411100012', NULL, '250215500115', 'Hadir', '2024-12-14 11:00:00', 'Harian (Magrib)', 'Shalat Jamaah'),
(82, NULL, '250411100055', NULL, '250215500115', 'Hadir', '2024-12-12 22:00:00', 'Harian (Subuh)', 'Shalat Jamaah'),
(92, 0, '220411100082', NULL, '250301100012', 'Alpha', '2024-12-16 06:30:15', 'Online', NULL),
(93, 0, '250100100001', NULL, '250311100022', 'Alpha', '2024-12-16 06:30:15', 'Online', NULL),
(94, 0, '250411100007', NULL, '250311100022', 'Alpha', '2024-12-16 06:30:15', 'Online', NULL),
(95, 0, '250411100008', NULL, '250311100022', 'Alpha', '2024-12-16 06:30:15', 'Online', NULL),
(96, 0, '250411100055', NULL, '250313100100', 'Alpha', '2024-12-16 06:30:15', 'Online', NULL),
(97, 0, '250411300088', NULL, '250313100100', 'Alpha', '2024-12-16 06:30:15', 'Online', NULL),
(98, 0, '250411100004', NULL, '25031330077', 'Alpha', '2024-12-16 06:30:15', 'Online', NULL),
(99, 0, '250411100014', NULL, '25031330077', 'Alpha', '2024-12-16 06:30:15', 'Online', NULL),
(100, 0, '250311100025', NULL, '25033300113', 'Alpha', '2024-12-16 06:30:15', 'Online', NULL),
(101, 0, '250411100012', NULL, '25033300113', 'Alpha', '2024-12-16 06:30:15', 'Online', NULL),
(102, 0, '250411100015', NULL, '250411200063', 'Alpha', '2024-12-16 06:30:15', 'Online', NULL),
(103, 0, '250411100010', NULL, '250420100066', 'Alpha', '2024-12-16 06:30:15', 'Online', NULL);

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
(2, '250411100055', '2024-11-11 09:15:00', 900000, 'Teller', 'diterima', 'bukti_bayar_2200010002.jpg', '');

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
(7, 7, '220411100082', 'testing', NULL, NULL, NULL, NULL, 'Materi yang diberikan ccukup menarik.');

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
(6, '220411100082', 'Testing 123', '2024-12-16 08:01:50', 'Akademik');

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
(86, '250411100055', 62.75, 'Tidak Lulus'),
(89, '220411100082', 19.85, 'Tidak Lulus'),
(90, '250100100001', 19.68, 'Tidak Lulus'),
(91, '250311100025', 16.66, 'Tidak Lulus'),
(93, '250411100004', 19.60, 'Tidak Lulus'),
(96, '250411100007', 16.98, 'Tidak Lulus'),
(98, '250411100008', 19.50, 'Tidak Lulus'),
(100, '250411100010', 19.36, 'Tidak Lulus'),
(101, '250411100012', 19.99, 'Tidak Lulus'),
(103, '250411100014', 16.77, 'Tidak Lulus'),
(104, '250411100015', 49.50, 'Tidak Lulus');

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
(81, '250411200063', 93.00, 96.00, 7.00, 1.00, 1.00),
(84, '220411100082', 94.00, 68.00, 0.00, 0.00, 0.00),
(85, '250100100001', 91.00, 67.00, 0.00, 0.00, 0.00),
(86, '250311100025', 91.00, 96.00, 0.00, 0.00, 0.00),
(87, '250411100003', 93.00, 67.00, 0.00, 0.00, 0.00),
(88, '250411100004', 93.00, 69.00, 0.00, 0.00, 0.00),
(89, '250411100005', 92.00, 96.00, 0.00, 0.00, 0.00),
(90, '250411100006', 92.00, 70.00, 0.00, 0.00, 0.00),
(91, '250411100007', 94.00, 96.00, 0.00, 0.00, 0.00),
(92, '250411100009', 92.00, 96.00, 0.00, 0.00, 0.00),
(93, '250411100008', 92.00, 69.00, 0.00, 0.00, 0.00),
(97, '250411100012', 91.00, 67.00, 1.00, 0.00, 0.00),
(98, '250411100010', 92.00, 70.00, 0.00, 0.00, 0.00),
(99, '250411100011', 91.00, 67.00, 1.00, 0.00, 0.00),
(100, '250411100013', 94.00, 96.00, 0.00, 0.00, 0.00),
(101, '250411100014', 92.00, 96.00, 0.00, 0.00, 0.00),
(102, '250411100015', 92.00, 69.00, 98.00, 0.00, 0.00);

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
('tes', 0, '2024-12-24 13:29:44', '2024-12-16 06:30:15', 'dsbgjakn', 'dsggaef', 'fdhsh'),
('Dormitory Competition', 2, '2024-11-25 09:00:00', '2024-11-17 06:27:53', 'Lomba cerdas cermat tingkat mahasiswa.', 'lomba_cc.jpg', 'Aula Gedung C'),
('Workshop Kewirausahaan', 7, '2024-12-15 09:30:00', '2024-11-17 06:27:53', 'Workshop mengenai pengelolaan bisnis dan ide startup.', 'workshop_kewirausahaan.jpg', 'Ruang Kelas Gedung E');

--
-- Trigger `kegiatan`
--
DELIMITER $$
CREATE TRIGGER `after_insert_kegiatan` AFTER INSERT ON `kegiatan` FOR EACH ROW BEGIN
    INSERT INTO absensi (id_absen, id_kegiatan, nim, id_extra, nim_pengurus, status_kehadiran,waktu_absen, jenis_absen)
    SELECT 
        NULL, 
        NEW.id_kegiatan, 
        warga.nim, 
        NULL,
        warga.nim_pengurus, 
        'Alpha',
        NULL,
        'Online'
    FROM warga;
END
$$
DELIMITER ;

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
(5, '250411200063', 'Farhan Maulana', 'Teknik Elektro', 'foto5.jpg', 'Jl. Diponegoro No.5', 'Makassar, 05-05-2004', '081234567895', 'farhan@gmail.com', '1ac5012170b65fb99f171ad799d045ac', '2024-12-03 17:22:33', 'REG-0005', 'Laki-laki', 'SBMPTN', 'bukti5.jpg', 'Rizal', 'Aisyah', '081234567894', 'accepted'),
(6, '250511010004', 'Dina Puspita', 'Psikologi', 'foto6.jpg', 'Jl. Satrio No.6', 'Yogyakarta, 06-06-2005', '081234567896', 'dina@gmail.com', 'f093c0fed979519fbc43d772b76f5c86', '2024-12-03 17:22:33', 'REG-0006', 'Perempuan', 'Mandiri', 'bukti6.jpg', 'Syahrul', 'Salma', '081234567895', 'accepted'),
(8, '250501200001', 'Rina Maharani', 'Ekonomi Pembangunan', 'foto8.jpg', 'Jl. Pahlawan No.8', 'Malang, 08-08-2001', '081234567898', 'rina@gmail.com', '9a1591b6e5317fb71c6032eedd5c051a', '2024-12-03 17:26:49', 'REG-0008', 'Perempuan', 'SBMPTN', 'bukti8.jpg', 'Hasan', 'Umi', '081234567897', 'rejected'),
(9, '250900100100', 'Arif Setiawan', 'Ekonomi Syariah', 'foto9.jpg', 'Jl. Mangga No.9', 'Bali, 09-09-2002', '081234567899', 'arif@gmail.com', 'd53d757c0f838ea49fb46e09cbcc3cb1', '2024-12-13 09:36:46', 'REG-0009', 'Laki-laki', 'Mandiri', 'bukti9.jpg', 'Rudi', 'Nurul', '081234567898', 'rejected'),
(10, '251000100200', 'Rini Handayani', 'Pendidikan Guru Sekola Dasar', 'foto10.jpg', 'Jl. Cemara No.10', 'Batam, 10-10-2003', '081234567890', 'rini@gmail.com', '07a7af79e06caf7153289574a97037ff', '2024-12-13 10:08:50', 'REG-0010', 'Perempuan', 'SNMPTN', 'bukti10.jpg', 'Bambang', 'Yuni', '081234567899', 'rejected'),
(11, '250110000025', 'Adi Nugroho', 'Sosiologi', 'foto11.jpg', 'Jl. Merpati No.11', 'Pontianak, 11-11-2004', '081234567891', 'adi@gmail.com', '7360409d967a24b667afc33a8384ec9e', '2024-12-13 12:43:53', 'REG-0011', 'Laki-laki', 'SBMPTN', 'bukti11.jpg', 'Edi', 'Sri', '081234567890', 'rejected'),
(12, '250400300022', 'Putri Ayu', 'Pendidikan IPA', 'foto12.jpg', 'Jl. Melati No.12', 'Palembang, 12-12-2005', '081234567892', 'putri@gmail.com', '82682943a05de360abb183236c632bd6', '2024-12-13 18:51:46', 'REG-0012', 'Perempuan', 'Mandiri', 'bukti12.jpg', 'Arman', 'Siti', '081234567891', 'rejected'),
(13, '250411300088', 'Dodi Prasetyo', 'Teknik Elektro', 'foto13.jpg', 'Jl. Mawar No.13', 'Padang, 13-01-2000', '081234567893', 'dodi@gmail.com', '', '2024-12-16 05:33:41', 'REG-0013', 'Laki-laki', 'SNMPTN', 'bukti13.jpg', 'Yanto', 'Lina', '081234567892', 'rejected'),
(14, '250100100001', 'Mira Kusuma', 'Akuntansi', 'foto14.jpg', 'Jl. Anggrek No.14', 'Manado, 14-02-2001', '081234567894', 'mira@gmail.com', '83469ed2521f07cb27804061cf244132', '2024-12-16 05:34:08', 'REG-0014', 'Perempuan', 'SBMPTN', 'bukti14.jpg', 'Rusdi', 'Asih', '081234567893', 'rejected'),
(15, '250311100025', 'Fajar Santoso', 'Ilmu Komunikasi', 'foto15.jpg', 'Jl. Nusa No.15', 'Kupang, 15-03-2002', '081234567895', 'fajar@gmail.com', '7bedc9fd30769590c992b8f7f23738f7', '2024-12-16 05:34:33', 'REG-0015', 'Laki-laki', 'Mandiri', 'bukti15.jpg', 'Slamet', 'Rina', '081234567894', 'rejected'),
(16, '220411100082', 'Mochammad Febrianu Hakim Alamsyah', 'Pendidikan Guru Sekolah Dasar', 'uploads/file (5).png', 'Dusun Klagen, Desa Tawar, Kecamatan Gondang', 'cgweih,12 april 3002', '082338842217', 'sdbwkn@gmail.com', '', '2024-12-16 05:35:43', '51315463', 'Laki-laki', 'SBMPTN', 'uploads/Diagram Tanpa Judu.png', 'sdv vcewje', 'ebcwk.', '082338842217', 'rejected'),
(17, '25041110003', 'Mochammad Febrianu Hakim Alamsyah', 'Pendidikan Guru Sekolah Dasar', 'uploads/81b619d60b0d4efd603caa40d0c5213d.jpg', 'Dusun Klagen, Desa Tawar, Kecamatan Gondang', 'cgweih,12 april 3002', '082338842217', 'sdbwkn@gmail.com', '', '2024-12-16 05:38:59', '51315463', 'Laki-laki', 'SBMPTN', 'uploads/FL.png', 'sdv vcewje', 'ebcwk.', '082338842217', 'rejected'),
(20, '250411100003', 'Budi Santoso', 'Teknik Mesin', 'foto3.jpg', 'Jl. Diponegoro No.3', 'Surabaya, 03-03-2002', '081234567893', 'budi@gmail.com', '482c811da5d5b4bc6d497ffa98491e38', '2024-12-16 05:39:36', 'REG-0003', 'Laki-laki', 'SNMPTN', 'bukti3.jpg', 'Sukardi', 'Sulastri', '081234567892', 'rejected'),
(21, '250411100004', 'Rina Astuti', 'Matematika', 'foto4.jpg', 'Jl. Kuningan No.4', 'Yogyakarta, 04-04-2003', '081234567894', 'rina@gmail.com', '482c811da5d5b4bc6d497ffa98491e38', '2024-12-16 05:40:15', 'REG-0004', 'Perempuan', 'SBMPTN', 'bukti4.jpg', 'Basuki', 'Marini', '081234567893', 'rejected'),
(22, '250411100005', 'Ahmad Fauzi', 'Kedokteran', 'foto5.jpg', 'Jl. Melati No.5', 'Malang, 05-05-2004', '081234567895', 'ahmadfauzi@gmail.com', '482c811da5d5b4bc6d497ffa98491e38', '2024-12-16 05:42:42', 'REG-0005', 'Laki-laki', 'SNMPTN', 'bukti5.jpg', 'Faisal', 'Hana', '081234567894', 'rejected'),
(23, '250411100006', 'Lina Kartika', 'Farmasi', 'foto6.jpg', 'Jl. Kebon Jeruk No.6', 'Semarang, 06-06-2005', '081234567896', 'lina@gmail.com', '482c811da5d5b4bc6d497ffa98491e38', '2024-12-16 05:43:12', 'REG-0006', 'Perempuan', 'SBMPTN', 'bukti6.jpg', 'Yusuf', 'Farah', '081234567895', 'rejected'),
(24, '250411100007', 'Anton Subroto', 'Arsitektur', 'foto7.jpg', 'Jl. Cempaka No.7', 'Bogor, 07-07-2006', '081234567897', 'anton@gmail.com', '482c811da5d5b4bc6d497ffa98491e38', '2024-12-16 05:43:46', 'REG-0007', 'Laki-laki', 'SNMPTN', 'bukti7.jpg', 'Agus', 'Anita', '081234567896', 'rejected'),
(25, '250411100008', 'Dewi Lestari', 'Psikologi', 'foto8.jpg', 'Jl. Anggrek No.8', 'Bandung, 08-08-2007', '081234567898', 'dewi@gmail.com', '482c811da5d5b4bc6d497ffa98491e38', '2024-12-16 05:44:19', 'REG-0008', 'Perempuan', 'SBMPTN', 'bukti8.jpg', 'Rizal', 'Ratna', '081234567897', 'rejected'),
(26, '250411100009', 'Samsul Arif', 'Teknik Elektro', 'foto9.jpg', 'Jl. Cemara No.9', 'Depok, 09-09-2008', '081234567899', 'samsul@gmail.com', '482c811da5d5b4bc6d497ffa98491e38', '2024-12-16 05:44:53', 'REG-0009', 'Laki-laki', 'SNMPTN', 'bukti9.jpg', 'Arman', 'Dina', '081234567898', 'rejected'),
(27, '250411100010', 'Ayu Puspita', 'Ilmu Komunikasi', 'foto10.jpg', 'Jl. Kenanga No.10', 'Medan, 10-10-2009', '081234567900', 'ayu@gmail.com', '482c811da5d5b4bc6d497ffa98491e38', '2024-12-16 05:46:04', 'REG-0010', 'Perempuan', 'SBMPTN', 'bukti10.jpg', 'Anwar', 'Zahra', '081234567899', 'rejected'),
(28, '250411100011', 'Joko Widodo', 'Teknik Sipil', 'foto11.jpg', 'Jl. Durian No.11', 'Solo, 11-11-2010', '081234567901', 'joko@gmail.com', '482c811da5d5b4bc6d497ffa98491e38', '2024-12-16 05:47:06', 'REG-0011', 'Laki-laki', 'SNMPTN', 'bukti11.jpg', 'Bagas', 'Santi', '081234567900', 'rejected'),
(29, '250411100012', 'Sri Mulyani', 'Ekonomi', 'foto12.jpg', 'Jl. Apel No.12', 'Makassar, 12-12-2011', '081234567902', 'sri@gmail.com', '482c811da5d5b4bc6d497ffa98491e38', '2024-12-16 05:47:55', 'REG-0012', 'Perempuan', 'SBMPTN', 'bukti12.jpg', 'Surya', 'Dewi', '081234567901', 'rejected'),
(30, '250411100013', 'Andi Firmansyah', 'Hukum', 'foto13.jpg', 'Jl. Mangga No.13', 'Maluku, 13-01-2012', '081234567903', 'andi@gmail.com', '482c811da5d5b4bc6d497ffa98491e38', '2024-12-16 05:48:26', 'REG-0013', 'Laki-laki', 'SNMPTN', 'bukti13.jpg', 'Gunawan', 'Nurul', '081234567902', 'rejected'),
(31, '250411100014', 'Tiara Andini', 'Sastra Indonesia', 'foto14.jpg', 'Jl. Alpukat No.14', 'Padang, 14-02-2013', '081234567904', 'tiara@gmail.com', '482c811da5d5b4bc6d497ffa98491e38', '2024-12-16 05:49:19', 'REG-0014', 'Perempuan', 'SBMPTN', 'bukti14.jpg', 'Herman', 'Tina', '081234567903', 'rejected'),
(32, '250411100015', 'Bagus Setiawan', 'Biologi', 'foto15.jpg', 'Jl. Sawo No.15', 'Pontianak, 15-03-2014', '081234567905', 'bagus@gmail.com', '482c811da5d5b4bc6d497ffa98491e38', '2024-12-03 17:36:00', 'REG-0015', 'Laki-laki', 'SNMPTN', 'bukti15.jpg', 'Didi', 'Linda', '081234567904', 'pending'),
(33, '250411100016', 'Putri Aisyah', 'Teknologi Pangan', 'foto16.jpg', 'Jl. Delima No.16', 'Banjarmasin, 16-04-2015', '081234567906', 'putri@gmail.com', '482c811da5d5b4bc6d497ffa98491e38', '2024-12-03 17:37:00', 'REG-0016', 'Perempuan', 'SBMPTN', 'bukti16.jpg', 'Rio', 'Anis', '081234567905', 'pending'),
(34, '250411100017', 'Rendi Mahardika', 'Fisika', 'foto17.jpg', 'Jl. Nangka No.17', 'Banda Aceh, 17-05-2016', '081234567907', 'rendi@gmail.com', '482c811da5d5b4bc6d497ffa98491e38', '2024-12-03 17:38:00', 'REG-0017', 'Laki-laki', 'SNMPTN', 'bukti17.jpg', 'Kurnia', 'Amira', '081234567906', 'pending'),
(35, '250411100018', 'Lutfi Halimah', 'Kesehatan Masyarakat', 'foto18.jpg', 'Jl. Ceri No.18', 'Palembang, 18-06-2017', '081234567908', 'lutfi@gmail.com', '482c811da5d5b4bc6d497ffa98491e38', '2024-12-03 17:39:00', 'REG-0018', 'Perempuan', 'SBMPTN', 'bukti18.jpg', 'Rahman', 'Rina', '081234567907', 'pending'),
(36, '250411100019', 'Eka Saputra', 'Kimia', 'foto19.jpg', 'Jl. Rambutan No.19', 'Batam, 19-07-2018', '081234567909', 'eka@gmail.com', '482c811da5d5b4bc6d497ffa98491e38', '2024-12-03 17:40:00', 'REG-0019', 'Laki-laki', 'SNMPTN', 'bukti19.jpg', 'Rangga', 'Aulia', '081234567908', 'pending'),
(37, '250411100020', 'Diana Permata', 'Geografi', 'foto20.jpg', 'Jl. Kelapa No.20', 'Jayapura, 20-08-2019', '081234567910', 'diana@gmail.com', '482c811da5d5b4bc6d497ffa98491e38', '2024-12-03 17:41:00', 'REG-0020', 'Perempuan', 'SBMPTN', 'bukti20.jpg', 'Ridwan', 'Zaskia', '081234567909', 'pending'),
(38, '250411100021', 'Asep Hidayat', 'Teknik Lingkungan', 'foto21.jpg', 'Jl. Merpati No.1', 'Bandung, 21-01-1999', '081234568001', 'asep@gmail.com', '482c811da5d5b4bc6d497ffa98491e38', '2024-12-05 01:00:00', 'REG-0021', 'Laki-laki', 'SNMPTN', 'bukti21.jpg', 'Darsono', 'Lestari', '081234568051', 'accepted'),
(39, '250411100022', 'Citra Anggraini', 'Seni Rupa', 'foto22.jpg', 'Jl. Rajawali No.2', 'Jakarta, 22-02-2000', '081234568002', 'citra@gmail.com', '482c811da5d5b4bc6d497ffa98491e38', '2024-12-05 01:05:00', 'REG-0022', 'Perempuan', 'SBMPTN', 'bukti22.jpg', 'Gunadi', 'Sulastri', '081234568052', 'pending'),
(40, '250411100023', 'Deni Pratama', 'Ekonomi Syariah', 'foto23.jpg', 'Jl. Garuda No.3', 'Depok, 23-03-2001', '081234568003', 'deni@gmail.com', '482c811da5d5b4bc6d497ffa98491e38', '2024-12-05 01:10:00', 'REG-0023', 'Laki-laki', 'SNMPTN', 'bukti23.jpg', 'Suwarno', 'Siti Aminah', '081234568053', 'rejected'),
(41, '250411100024', 'Eva Susanti', 'Kesejahteraan Sosial', 'foto24.jpg', 'Jl. Elang No.4', 'Surabaya, 24-04-2002', '081234568004', 'eva@gmail.com', '482c811da5d5b4bc6d497ffa98491e38', '2024-12-05 01:15:00', 'REG-0024', 'Perempuan', 'SBMPTN', 'bukti24.jpg', 'Teguh', 'Rahmawati', '081234568054', 'accepted'),
(42, '250411100025', 'Fikri Rahman', 'Teknik Industri', 'foto25.jpg', 'Jl. Cendrawasih No.5', 'Medan, 25-05-2003', '081234568005', 'fikri@gmail.com', '482c811da5d5b4bc6d497ffa98491e38', '2024-12-05 01:20:00', 'REG-0025', 'Laki-laki', 'SNMPTN', 'bukti25.jpg', 'Saputra', 'Dewi', '081234568055', 'pending'),
(43, '250411100026', 'Gita Permata', 'Pendidikan Bahasa Inggris', 'foto26.jpg', 'Jl. Pelikan No.6', 'Makassar, 26-06-2004', '081234568006', 'gita@gmail.com', '482c811da5d5b4bc6d497ffa98491e38', '2024-12-05 01:25:00', 'REG-0026', 'Perempuan', 'SBMPTN', 'bukti26.jpg', 'Iskandar', 'Nur Aini', '081234568056', 'accepted'),
(44, '250411100027', 'Hendra Wijaya', 'Teknik Kelautan', 'foto27.jpg', 'Jl. Bangau No.7', 'Bali, 27-07-2005', '081234568007', 'hendra@gmail.com', '482c811da5d5b4bc6d497ffa98491e38', '2024-12-05 01:30:00', 'REG-0027', 'Laki-laki', 'SNMPTN', 'bukti27.jpg', 'Anwar', 'Nining', '081234568057', 'rejected'),
(45, '250411100028', 'Indah Lestari', 'Pendidikan Matematika', 'foto28.jpg', 'Jl. Beo No.8', 'Bengkulu, 28-08-2006', '081234568008', 'indah@gmail.com', '482c811da5d5b4bc6d497ffa98491e38', '2024-12-05 01:35:00', 'REG-0028', 'Perempuan', 'SBMPTN', 'bukti28.jpg', 'Rahmad', 'Zahra', '081234568058', 'accepted'),
(46, '250411100029', 'Joko Prasetyo', 'Pendidikan IPA', 'foto29.jpg', 'Jl. Kakatua No.9', 'Pontianak, 29-09-2007', '081234568009', 'joko@gmail.com', '482c811da5d5b4bc6d497ffa98491e38', '2024-12-05 01:40:00', 'REG-0029', 'Laki-laki', 'SNMPTN', 'bukti29.jpg', 'Subroto', 'Kurniasih', '081234568059', 'pending'),
(47, '250411100030', 'Kartika Putri', 'Pendidikan Seni Tari', 'foto30.jpg', 'Jl. Kenari No.10', 'Padang, 30-10-2008', '081234568010', 'kartika@gmail.com', '482c811da5d5b4bc6d497ffa98491e38', '2024-12-05 01:45:00', 'REG-0030', 'Perempuan', 'SBMPTN', 'bukti30.jpg', 'Yusuf', 'Maria', '081234568060', 'accepted'),
(48, '250411100031', 'Lukman Hakim', 'Statistika', 'foto31.jpg', 'Jl. Rajawali No.11', 'Bandung, 31-01-2000', '081234568011', 'lukman@gmail.com', '482c811da5d5b4bc6d497ffa98491e38', '2024-12-05 01:50:00', 'REG-0031', 'Laki-laki', 'SNMPTN', 'bukti31.jpg', 'Fauzan', 'Indri', '081234568061', 'pending'),
(49, '250411100032', 'Maria Ulfah', 'Teknologi Informasi', 'foto32.jpg', 'Jl. Cendrawasih No.12', 'Bogor, 01-02-2001', '081234568012', 'maria@gmail.com', '482c811da5d5b4bc6d497ffa98491e38', '2024-12-05 01:55:00', 'REG-0032', 'Perempuan', 'SBMPTN', 'bukti32.jpg', 'Anas', 'Fitri', '081234568062', 'accepted'),
(50, '250411100033', 'Novan Maulana', 'Manajemen', 'foto33.jpg', 'Jl. Merak No.13', 'Semarang, 02-03-2002', '081234568013', 'novan@gmail.com', '482c811da5d5b4bc6d497ffa98491e38', '2024-12-05 02:00:00', 'REG-0033', 'Laki-laki', 'SNMPTN', 'bukti33.jpg', 'Hamzah', 'Aulia', '081234568063', 'rejected'),
(51, '250411100034', 'Olivia Rahmawati', 'Sastra Arab', 'foto34.jpg', 'Jl. Pelikan No.14', 'Jambi, 03-04-2003', '081234568014', 'olivia@gmail.com', '482c811da5d5b4bc6d497ffa98491e38', '2024-12-05 02:05:00', 'REG-0034', 'Perempuan', 'SBMPTN', 'bukti34.jpg', 'Gilang', 'Rina', '081234568064', 'accepted'),
(52, '250411100035', 'Putra Setiawan', 'Geologi', 'foto35.jpg', 'Jl. Rajawali No.15', 'Palembang, 04-05-2004', '081234568015', 'putra@gmail.com', '482c811da5d5b4bc6d497ffa98491e38', '2024-12-16 05:42:10', 'REG-0035', 'Laki-laki', 'SNMPTN', 'bukti35.jpg', 'Fadhil', 'Laras', '081234568065', 'rejected'),
(53, '250411100036', 'Qonita Ayu', 'Sastra Jepang', 'foto36.jpg', 'Jl. Bangau No.16', 'Aceh, 05-06-2005', '081234568016', 'qonita@gmail.com', '482c811da5d5b4bc6d497ffa98491e38', '2024-12-05 02:15:00', 'REG-0036', 'Perempuan', 'SBMPTN', 'bukti36.jpg', 'Ridho', 'Anis', '081234568066', 'accepted'),
(54, '250411100037', 'Raka Firmansyah', 'Teknik Geodesi', 'foto37.jpg', 'Jl. Cempaka No.17', 'Balikpapan, 06-07-2006', '081234568017', 'raka@gmail.com', '482c811da5d5b4bc6d497ffa98491e38', '2024-12-05 02:20:00', 'REG-0037', 'Laki-laki', 'SNMPTN', 'bukti37.jpg', 'Anwar', 'Dina', '081234568067', 'rejected');

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
('Hana Puspita', '250215500115', '408', 'Gedung E', '081234567897', '3b7972d6e14381a8f234aaf14c813d2e', 'hana@gmail.com', 'Kominfo', 'Anggota', 'foto8.jpg', 'Psikologi', 'Perempuan'),
('Siti Nurhaliza', '250301100012', 'ghj', 'C', '081234567892', '482c811da5d5b4bc6d497ffa98491e38', '220411100060@student.trunojoyo.ac.id', 'Kebersihan', 'Koordinator', 'foto2.jpg', 'Sastra Inggris', 'Laki-laki'),
('Habib Maulana', '250311100022', '102', 'Gedung D', '081234567890', '3573dd3c8f7fa2075538bb9c8a3a4d48', 'habib@gmail.com', 'Pengurus Harian', 'Ketua', 'foto1.jpg', 'Pendidikan Informatika', 'Laki-laki'),
('Erwin Pratama', '250313100100', '305', 'Gedung E', '081234567894', '66589ae77387a90660219a2aad624e94', 'erwin@gmail.com', 'Teknisi', 'Anggota', 'foto5.jpg', 'Teknik Mesin', 'Laki-laki'),
('Joko Susanto', '25031330077', '310', 'Gedung A', '081234567899', '278ea841c0d133059032b8a75320c3e0', 'joko@gmail.com', 'Kewirausahaan', 'Anggota', 'foto10.jpg', 'Agribisnis', 'Laki-laki'),
('Ivan Nugraha', '25033300113', '309', 'Gedung B', '081234567898', 'b7727d252be76bc6d142e19315cfc8fd', 'ivan@gmail.com', 'Peribadatan', 'Anggota', 'foto9.jpg', 'Sistem Informasi', 'Laki-laki'),
('Mochammad Febrianu Hakim Alamsyah', '25041110003', '202', 'D', '082338842217', '', 'sdbwkn@gmail.com', 'Kebersihan', 'Koordinator', 'uploads/81b619d60b0d4efd603caa40d0c5213d.jpg', 'Pendidikan Guru Sekolah Dasar', 'Laki-laki'),
('Farhan Maulana', '250411200063', 'ghj', 'D', '081234567895', '1ac5012170b65fb99f171ad799d045ac', '220411100082@student.trunojoyo.ac.id', 'Kebersihan', 'Koordinator', 'foto5.jpg', 'Teknik Elektro', 'Laki-laki'),
('Budi Santoso', '250413100023', '202', 'Gedung D', '081234567891', '9c5fa085ce256c7c598f6710584ab25d', 'budi@gmail.com', 'Kebersihan Kesehatan', 'CO', 'foto2.jpg', 'Manajemen', 'Laki-laki'),
('Dewi Anggraini', '250420100066', '214', 'Gedung D', '081234567893', 'fde0b737496c53bb85d07b31a02985a3', 'dewi@gmail.com', 'Pengurus Harian', 'Bendahara', 'foto4.jpg', 'Ilmu Komunikasi', 'Perempuan'),
('Dina Puspita', '250511010004', '304', 'E', '081234567896', 'f093c0fed979519fbc43d772b76f5c86', '220411100164@student.trunojoyo.ac.id', 'Peribadatan', 'Anggota', 'foto6.jpg', 'Psikologi', 'Perempuan'),
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
('220411100082', NULL, '250301100012', 'Mochammad Febrianu Hakim Alamsyah', '082338842217', '', '113', 'uploads/file (5).png', 'sdbwkn@gmail.com', 'E', 'Pendidikan Guru Sekolah Dasar'),
('250100100001', NULL, '250311100022', 'Mira Kusuma', '081234567894', '83469ed2521f07cb27804061cf244132', '113', 'foto14.jpg', 'mira@gmail.com', 'A', 'Akuntansi'),
('250311100025', NULL, '25033300113', 'Fajar Santoso', '081234567895', '7bedc9fd30769590c992b8f7f23738f7', '123', 'foto15.jpg', 'fajar@gmail.com', 'A', 'Ilmu Komunikasi'),
('250411100004', NULL, '25031330077', 'Rina Astuti', '081234567894', '482c811da5d5b4bc6d497ffa98491e38', '202', 'foto4.jpg', 'rina@gmail.com', 'A', 'Matematika'),
('250411100007', NULL, '250311100022', 'Anton Subroto', '081234567897', '482c811da5d5b4bc6d497ffa98491e38', '303', 'foto7.jpg', 'anton@gmail.com', 'D', 'Arsitektur'),
('250411100008', NULL, '250311100022', 'Dewi Lestari', '081234567898', '482c811da5d5b4bc6d497ffa98491e38', '113', 'foto8.jpg', 'dewi@gmail.com', 'A', 'Psikologi'),
('250411100010', NULL, '250420100066', 'Ayu Puspita', '081234567900', '482c811da5d5b4bc6d497ffa98491e38', '202', 'foto10.jpg', 'ayu@gmail.com', 'E', 'Ilmu Komunikasi'),
('250411100012', NULL, '25033300113', 'Sri Mulyani', '081234567902', '482c811da5d5b4bc6d497ffa98491e38', '202', 'foto12.jpg', 'sri@gmail.com', 'D', 'Ekonomi'),
('250411100014', NULL, '25031330077', 'Tiara Andini', '081234567904', '482c811da5d5b4bc6d497ffa98491e38', '202', 'foto14.jpg', 'tiara@gmail.com', 'A', 'Sastra Indonesia'),
('250411100015', NULL, '250411200063', 'Bagus Setiawan', '081234567905', '482c811da5d5b4bc6d497ffa98491e38', '113', 'foto15.jpg', 'bagus@gmail.com', 'E', 'Biologi'),
('250411100029', NULL, '250311100022', 'Joko Prasetyo', '081234568009', '482c811da5d5b4bc6d497ffa98491e38', '509', 'foto29.jpg', 'joko@gmail.com', 'A', 'Pendidikan IPA'),
('250411100055', NULL, '250313100100', 'Ahmad Riyadi', '081234567891', '482c811da5d5b4bc6d497ffa98491e38', '205', 'foto1.jpg', 'muhammadalivian164@gmail.com', 'D', 'Teknik Informatika'),
('250411300088', NULL, '250313100100', 'Dodi Prasetyo', '081234567893', '', '113', 'foto13.jpg', 'dodi@gmail.com', 'D', 'Teknik Elektro');

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
  MODIFY `id_absen` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=104;

--
-- AUTO_INCREMENT untuk tabel `bukti_pembayaran`
--
ALTER TABLE `bukti_pembayaran`
  MODIFY `id_bukti` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `formulir_kegiatan`
--
ALTER TABLE `formulir_kegiatan`
  MODIFY `id_formulir_kegiatan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `formulir_kepuasan`
--
ALTER TABLE `formulir_kepuasan`
  MODIFY `id_formulir` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `hasil_spk`
--
ALTER TABLE `hasil_spk`
  MODIFY `id_spk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=105;

--
-- AUTO_INCREMENT untuk tabel `hasil_tpa`
--
ALTER TABLE `hasil_tpa`
  MODIFY `id_test` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;

--
-- AUTO_INCREMENT untuk tabel `kriteria`
--
ALTER TABLE `kriteria`
  MODIFY `id_kriteria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT untuk tabel `pendaftaran`
--
ALTER TABLE `pendaftaran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT untuk tabel `sub_kriteria`
--
ALTER TABLE `sub_kriteria`
  MODIFY `id_subkriteria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=99;

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
