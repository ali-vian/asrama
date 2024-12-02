-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Waktu pembuatan: 11 Nov 2024 pada 05.49
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
  `jenis_absen` varchar(12) DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
  `no_hp_ortu` varchar(255) DEFAULT NULL,
  `status` enum('pending','accepted','rejected') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `pendaftaran`
--

INSERT INTO `pendaftaran` (`id`, `nim`, `nama_lengkap`, `prodi_pendaftar`, `foto_pendaftar`, `alamat_pendaftar`, `ttl`, `no_hp_pendaftar`, `email_pendaftar`, `created_at_pendaftar`, `nomor_pendaftaran`, `jenis_kelamin`, `jalur_masuk`, `foto_bukti_lolos_ptn`, `nama_ayah`, `nama_ibu`, `no_hp_ortu`, `status`) VALUES
('1', '2101001', 'Alya Rahma', 'Teknik Informatika', 'alyarahma.jpg', 'Jl. Merdeka No. 5', '2002-01-15', '081234567890', 'alya.rahma@gmail.com', '2024-11-10 16:06:29', '1001', 'Perempuan', 'SNBP', 'bukti_snbp_alyarahma.jpg', 'Budi Rahman', 'Siti Nurhayati', '081234567891', 'accepted'),
('10', '2101010', 'Joko Susilo', 'Teknik Mesin', 'jokosusilo.jpg', 'Jl. Sultan Agung No. 3', '2001-12-10', '081234567810', 'joko.susilo@gmail.com', '2024-11-10 16:04:20', '1010', 'Laki-laki', 'SNBP', 'bukti_snbp_jokosusilo.jpg', 'Suprapto', 'Rini Kusuma', '081234567811', 'accepted'),
('11', '2101011', 'Karina Putri', 'Desain Produk', 'karinaputri.jpg', 'Jl. Raden Saleh No. 15', '2002-04-12', '081234567811', 'karina.putri@gmail.com', '2024-11-10 16:24:26', '1011', 'Perempuan', 'Mandiri', 'bukti_mandiri_karinaputri.jpg', 'Rizal Putra', 'Sari Puspita', '081234567812', 'rejected'),
('12', '2101012', 'Lutfi Ahmad', 'Teknik Perkapalan', 'lutfiahmad.jpg', 'Jl. Diponegoro No. 8', '2001-11-22', '081234567812', 'lutfi.ahmad@gmail.com', '2024-11-10 16:01:56', '1012', 'Laki-laki', 'SNBT', 'bukti_snbt_lutfiahmad.jpg', 'Mustafa Ahmad', 'Fauziah', '081234567813', 'pending'),
('13', '2101013', 'Mega Wijaya', 'Teknik Geologi', 'megawijaya.jpg', 'Jl. Pintu Air No. 10', '2002-09-15', '081234567813', 'mega.wijaya@gmail.com', '2024-11-10 16:01:50', '1013', 'Perempuan', 'SNBP', 'bukti_snbp_megawijaya.jpg', 'Sunarto Wijaya', 'Ratna Wulandari', '081234567814', 'pending'),
('14', '2101014', 'Nina Permata', 'Ilmu Komunikasi', 'ninapermata.jpg', 'Jl. Kramat No. 6', '2001-06-08', '081234567814', 'nina.permata@gmail.com', '2024-11-10 16:01:45', '1014', 'Perempuan', 'Mandiri', 'bukti_mandiri_ninapermata.jpg', 'Ismail Permata', 'Rini Astuti', '081234567815', 'pending'),
('16', '2101016', 'Putri Maharani', 'Kedokteran', 'putrimaharani.jpg', 'Jl. Mawar No. 22', '2002-07-19', '081234567816', 'putri.maharani@gmail.com', '2024-11-10 16:02:12', '1016', 'Perempuan', 'SNBP', 'bukti_snbp_putrimaharani.jpg', 'Hendro Maharani', 'Dewi Susanti', '081234567817', 'pending'),
('17', '2101017', 'Riko Pratama', 'Psikologi', 'rikopratama.jpg', 'Jl. Kenanga No. 5', '2001-05-01', '081234567817', 'riko.pratama@gmail.com', '2024-11-10 16:05:25', '1017', 'Laki-laki', 'Mandiri', 'bukti_mandiri_rikopratama.jpg', 'Syamsul Pratama', 'Kartika Dewi', '081234567818', 'pending'),
('18', '2101018', 'Santi Ayunda', 'Ekonomi', 'santiayunda.jpg', 'Jl. Cemara No. 30', '2001-10-25', '081234567818', 'santi.ayunda@gmail.com', '2024-11-10 16:05:32', '1018', 'Perempuan', 'SNBT', 'bukti_snbt_santiayunda.jpg', 'Irwansyah', 'Erna Permata', '081234567819', 'pending'),
('19', '2101019', 'Toni Wibowo', 'Sastra Inggris', 'toniwibowo.jpg', 'Jl. Diponegoro No. 11', '2001-03-09', '081234567819', 'toni.wibowo@gmail.com', '2024-11-10 16:05:49', '1019', 'Laki-laki', 'SNBP', 'bukti_snbp_toniwibowo.jpg', 'Subandi Wibowo', 'Marina Widya', '081234567820', 'pending'),
('2', '2101002', 'Budi Santoso', 'Teknik Sipil', 'budisantoso.jpg', 'Jl. Sudirman No. 12', '2001-05-20', '081234567891', 'budi.santoso@gmail.com', '2024-11-10 16:05:43', '1002', 'Laki-laki', 'SNBP', 'bukti_snbp_budisantoso.jpg', 'Ahmad Santoso', 'Ratna Dewi', '081234567892', 'pending'),
('3', '2101003', 'Citra Lestari', 'Arsitektur', 'citralestari.jpg', 'Jl. Gatot Subroto No. 8', '2002-03-18', '081234567892', 'citra.lestari@gmail.com', '2024-11-10 15:11:48', '1003', 'Perempuan', 'Mandiri', 'bukti_mandiri_citralestari.jpg', 'Wahyudi Lestari', 'Dewi Ayu', '081234567893', 'pending'),
('4', '2101004', 'Dewi Kartika', 'Teknik Kimia', 'dewikartika.jpg', 'Jl. Pahlawan No. 3', '2001-08-25', '081234567893', 'dewi.kartika@gmail.com', '2024-11-10 15:11:42', '1004', 'Perempuan', 'SNBP', 'bukti_snbp_dewikartika.jpg', 'Suhendra Kartika', 'Sri Hartati', '081234567894', 'pending'),
('5', '2101005', 'Eka Pratama', 'Teknik Elektro', 'ekapratama.jpg', 'Jl. Diponegoro No. 14', '2002-11-30', '081234567894', 'eka.pratama@gmail.com', '2024-11-10 15:11:36', '1005', 'Laki-laki', 'SNBT', 'bukti_snbt_ekapratama.jpg', 'Usman Pratama', 'Aisyah Sari', '081234567895', 'pending'),
('6', '2101006', 'Farah Amalia', 'Manajemen', 'farahamalia.jpg', 'Jl. Imam Bonjol No. 20', '2002-07-13', '081234567895', 'farah.amalia@gmail.com', '2024-11-10 16:02:18', '1006', 'Perempuan', 'Mandiri', 'bukti_mandiri_farahamalia.jpg', 'Mulyadi Amalia', 'Hesti Purnama', '081234567896', 'pending'),
('7', '2101007', 'Gilang Saputra', 'Akuntansi', 'gilangsaputra.jpg', 'Jl. Kartini No. 9', '2001-09-07', '081234567896', 'gilang.saputra@gmail.com', '2024-11-06 12:46:19', '1007', 'Laki-laki', 'SNBT', 'bukti_snbt_gilangsaputra.jpg', 'Samsul Saputra', 'Ratih Kumala', '081234567897', 'pending');

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
('Joko Susilo', '2101010', '306', 'G', '081234567810', '', 'joko.susilo@gmail.com', 'Keamanan', 'Bendahara', 'jokosusilo.jpg', 'Teknik Mesin', 'Perempuan'),
('Ahmad Fauzi', '210123101', 'A101', 'Gedung A', '081234567891', 'hashedpassword1', 'ahmad.fauzi@mail.com', 'Keamanan', 'Ketua', 'foto_ahmad_fauzi.jpg', 'Teknik Informatika', 'Laki-laki'),
('Budi Setiawan', '210123102', 'B202', 'Gedung B', '082234567892', 'hashedpassword2', 'budi.setiawan@mail.com', 'Kebersihan', 'Wakil Ketua', 'foto_budi_setiawan.jpg', 'Manajemen', 'Laki-laki'),
('Citra Lestari', '210123103', 'C303', 'Gedung C', '083234567893', 'hashedpassword3', 'citra.lestari@mail.com', 'Kesejahteraan', 'Sekretaris', 'foto_citra_lestari.jpg', 'Psikologi', 'Perempuan'),
('Dewi Kusuma', '210123104', 'A102', 'Gedung A', '084234567894', 'hashedpassword4', 'dewi.kusuma@mail.com', 'Kesehatan', 'Bendahara', 'foto_dewi_kusuma.jpg', 'Kedokteran', 'Perempuan'),
('Eka Wijaya', '210123105', 'B203', 'Gedung B', '085234567895', 'hashedpassword5', 'eka.wijaya@mail.com', 'Keamanan', 'Koordinator', 'foto_eka_wijaya.jpg', 'Hukum', 'Laki-laki'),
('Fitri Aulia', '210123106', 'C304', 'Gedung C', '086234567896', 'hashedpassword6', 'fitri.aulia@mail.com', 'Kesejahteraan', 'Anggota', 'foto_fitri_aulia.jpg', 'Farmasi', 'Perempuan'),
('Gilang Maulana', '210123107', 'A103', 'Gedung A', '087234567897', 'hashedpassword7', 'gilang.maulana@mail.com', 'Kebersihan', 'Anggota', 'foto_gilang_maulana.jpg', 'Teknik Mesin', 'Laki-laki'),
('Hana Fitriani', '210123108', 'B204', 'Gedung B', '088234567898', 'hashedpassword8', 'hana.fitriani@mail.com', 'Kesehatan', 'Anggota', 'foto_hana_fitriani.jpg', 'Akuntansi', 'Perempuan'),
('Indra Saputra', '210123109', 'C305', 'Gedung C', '089234567899', 'hashedpassword9', 'indra.saputra@mail.com', 'Keamanan', 'Anggota', 'foto_indra_saputra.jpg', 'Sastra Inggris', 'Laki-laki'),
('Joko Prasetyo', '210123110', 'A104', 'Gedung A', '080234567890', 'hashedpassword10', 'joko.prasetyo@mail.com', 'Kesejahteraan', 'Anggota', 'foto_joko_prasetyo.jpg', 'Ekonomi', 'Laki-laki'),
('Jaya Saputra', '210123209', 'C305', 'Gedung C', '089345678918', 'hashedpassword19', 'jaya.saputra@mail.com', 'Kebersihan', 'Koordinator', 'foto_jaya.jpg', 'Sastra Inggris', 'Laki-laki'),
('Kurniawan Jaya', '210123210', 'B207', 'Gedung A', '080345678919', 'hashedpassword20', 'kurniawan.jaya@mail.com', 'Teknisi', 'Bendahara', 'foto_kurniawan.jpg', 'Ekonomi', 'Laki-laki'),
('Veronica Dewi', '210123301', 'A112', 'Gedung A', '081345678930', 'hashedpassword31', 'veronica.dewi@mail.com', 'Kebersihan', 'Koordinator', 'foto_veronica.jpg', 'Manajemen Bisnis', 'Perempuan'),
('Wahyu Nugroho', '210123302', 'B212', 'Gedung B', '082345678931', 'hashedpassword32', 'wahyu.nugroho@mail.com', 'Kesehatan', 'Anggota', 'foto_wahyu.jpg', 'Teknik Sipil', 'Laki-Laki'),
('Xander Pratama', '210123303', 'C312', 'Gedung C', '083345678932', 'hashedpassword33', 'xander.pratama@mail.com', 'Keamanan', 'Bendahara', 'foto_xander.jpg', 'Ilmu Komputer', 'Laki-Laki'),
('Zaky Ramadhan', '210123315', 'B213', 'Gedung B', '085345678944', 'hashedpassword45', 'zaky.ramadhan@mail.com', 'Keamanan', 'Anggota', 'foto_zaky.jpg', 'Hukum', 'Laki-laki'),
('Aulia Nirmala', '210123316', 'C313', 'Gedung C', '086345678945', 'hashedpassword46', 'aulia.nirmala@mail.com', 'Kebersihan dan Kesehatan', 'Sekretaris', 'foto_aulia.jpg', 'Farmasi', 'Perempuan'),
('Bambang Satrio', '210123317', 'A114', 'Gedung A', '087345678946', 'hashedpassword47', 'bambang.satrio@mail.com', 'Teknisi', 'Anggota', 'foto_bambang.jpg', 'Teknik Mesin', 'Laki-laki'),
('Citra Wulandari', '210123318', 'B214', 'Gedung B', '088345678947', 'hashedpassword48', 'citra.wulandari@mail.com', 'Keamanan', 'Koordinator', 'foto_citra.jpg', 'Akuntansi', 'Perempuan'),
('Dedi Santoso', '210123319', 'C314', 'Gedung C', '089345678948', 'hashedpassword49', 'dedi.santoso@mail.com', 'Kebersihan dan Kesehatan', 'Koordinator', 'foto_dedi.jpg', 'Sastra Inggris', 'Laki-laki'),
('Eka Wibisono', '210123320', 'A115', 'Gedung A', '080345678949', 'hashedpassword50', 'eka.wibisono@mail.com', 'Teknisi', 'Anggota', 'foto_eka.jpg', 'Ekonomi', 'Laki-laki'),
('Rio Saputra', '210123401', 'C305', 'Gedung A', '081234567890', 'hashedpassword1', 'rio.saputra@mail.com', 'Teknisi', 'Koordinator', 'foto_rio.jpg', 'Teknik Informatika', 'Laki-laki'),
('Lina Rahmawati', '210123402', 'C305', 'Gedung B', '082234567891', 'hashedpassword2', 'lina.rahmawati@mail.com', 'Teknisi', 'Koordinator', 'foto_lina.jpg', 'Manajemen', 'Laki-laki'),
('Aris Setiawan', '210123403', 'C305', 'Gedung C', '083234567892', 'hashedpassword3', 'aris.setiawan@mail.com', 'Kebersihan', 'Koordinator', 'foto_aris.jpg', 'Psikologi', 'Laki-laki'),
('Dani Santoso', '210123405', 'C305', 'Gedung B', '085234567894', 'hashedpassword5', 'dani.santoso@mail.com', 'Teknisi', 'Bendahara', 'foto_dani.jpg', 'Hukum', 'Laki-laki'),
('Hadi Susanto', '210123407', 'C305', 'Gedung A', '087234567896', 'hashedpassword7', 'hadi.susanto@mail.com', 'Teknisi', 'Koordinator', 'foto_hadi.jpg', 'Teknik Mesin', 'Laki-laki'),
('Bayu Prasetya', '210123701', 'A105', 'Gedung A', '081345678930', 'hashedpassword31', 'bayu.prasetya@mail.com', 'Kebersihan dan Kesehatan', 'Koordinator', 'foto_bayu.jpg', 'Teknik Informatika', 'Laki-laki'),
('Cici Andriana', '210123702', 'B205', 'Gedung B', '082345678931', 'hashedpassword32', 'cici.andriana@mail.com', 'Teknisi', 'Anggota', 'foto_cici.jpg', 'Manajemen', 'Perempuan'),
('Dian Kusuma', '210123703', 'C306', 'Gedung C', '083345678932', 'hashedpassword33', 'dian.kusuma@mail.com', 'Keamanan', 'Koordinator', 'foto_dian.jpg', 'Psikologi', 'Laki-laki'),
('Eva Susanti', '210123704', 'A106', 'Gedung A', '084345678933', 'hashedpassword34', 'eva.susanti@mail.com', 'Kebersihan dan Kesehatan', 'Bendahara', 'foto_eva.jpg', 'Kedokteran', 'Perempuan'),
('Farid Alamsyah', '210123705', 'B206', 'Gedung B', '085345678934', 'hashedpassword35', 'farid.alamsyah@mail.com', 'Teknisi', 'Anggota', 'foto_farid.jpg', 'Hukum', 'Laki-laki'),
('Gita Prameswari', '210123706', 'C307', 'Gedung C', '086345678935', 'hashedpassword36', 'gita.prameswari@mail.com', 'Keamanan', 'Koordinator', 'foto_gita.jpg', 'Farmasi', 'Perempuan'),
('Hendra Suhendra', '210123707', 'A107', 'Gedung A', '087345678936', 'hashedpassword37', 'hendra.suhendra@mail.com', 'Kebersihan dan Kesehatan', 'Sekretaris', 'foto_hendra.jpg', 'Teknik Mesin', 'Laki-laki'),
('Veronica Dewi', '210123711', 'A112', 'Gedung A', '081345678940', 'hashedpassword41', 'veronica.dewi@mail.com', 'Teknisi', 'Anggota', 'foto_veronica.jpg', 'Manajemen Bisnis', 'Perempuan'),
('Wahyu Nugroho', '210123712', 'B212', 'Gedung B', '082345678941', 'hashedpassword42', 'wahyu.nugroho@mail.com', 'Keamanan', 'Anggota', 'foto_wahyu.jpg', 'Teknik Sipil', 'Laki-laki'),
('Ika Trisnawati', '210123778', 'B207', 'Gedung B', '088345678937', 'hashedpassword38', 'ika.trisnawati@mail.com', 'Teknisi', 'Anggota', 'foto_ika.jpg', 'Akuntansi', 'Perempuan'),
('Jaya Saputra', '210123779', 'C308', 'Gedung C', '089345678938', 'hashedpassword39', 'jaya.saputra@mail.com', 'Keamanan', 'Koordinator', 'foto_jaya.jpg', 'Sastra Inggris', 'Laki-laki'),
('Kurniawan Jaya', '210127310', 'A108', 'Gedung A', '080345678939', 'hashedpassword40', 'kurniawan.jaya@mail.com', 'Kebersihan dan Kesehatan', 'Koordinator', 'foto_kurniawan.jpg', 'Ekonomi', 'Laki-laki'),
('Xander Pratama', '210127313', 'C312', 'Gedung C', '083345678942', 'hashedpassword43', 'xander.pratama@mail.com', 'Kebersihan dan Kesehatan', 'Bendahara', 'foto_xander.jpg', 'Ilmu Komputer', 'Laki-laki'),
('Yolanda Ayu', '210127314', 'A113', 'Gedung A', '084345678943', 'hashedpassword44', 'yolanda.ayu@mail.com', 'Teknisi', 'Anggota', 'foto_yolanda.jpg', 'Psikologi', 'Perempuan');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `warga`
--

CREATE TABLE `warga` (
  `nim` varchar(12) NOT NULL,
  `id_extra` int(11) DEFAULT NULL,
  `nim_pengurus` varchar(12) DEFAULT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `ttl` varchar(255) DEFAULT NULL,
  `jenis_kelamin` varchar(12) DEFAULT NULL,
  `no_hp` varchar(12) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `kamar` varchar(12) DEFAULT NULL,
  `foto_warga` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `gedung` varchar(12) DEFAULT NULL,
  `prodi` varchar(255) DEFAULT NULL,
  `id` varchar(12) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `warga`
--

INSERT INTO `warga` (`nim`, `id_extra`, `nim_pengurus`, `nama`, `ttl`, `jenis_kelamin`, `no_hp`, `password`, `kamar`, `foto_warga`, `email`, `gedung`, `prodi`, `id`) VALUES
('2101001', NULL, NULL, 'Alya Rahma', '2002-01-15', 'Perempuan', '081234567890', NULL, '304', 'alyarahma.jpg', 'alya.rahma@gmail.com', 'D', 'Teknik Informatika', '1');

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
  ADD KEY `fk_warga_relations_extrakul` (`id_extra`),
  ADD KEY `fk_warga_pendaftaran` (`id`);

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
-- Ketidakleluasaan untuk tabel `spk`
--
ALTER TABLE `spk`
  ADD CONSTRAINT `fk_spk_relations_warga` FOREIGN KEY (`nim`) REFERENCES `warga` (`nim`);

--
-- Ketidakleluasaan untuk tabel `warga`
--
ALTER TABLE `warga`
  ADD CONSTRAINT `fk_warga_pendaftaran` FOREIGN KEY (`id`) REFERENCES `pendaftaran` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_warga_relations_extrakul` FOREIGN KEY (`id_extra`) REFERENCES `extrakulikuler` (`id_extra`),
  ADD CONSTRAINT `fk_warga_relations_pengurus` FOREIGN KEY (`nim_pengurus`) REFERENCES `pengurus` (`nim_pengurus`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
