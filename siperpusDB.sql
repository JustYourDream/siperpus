-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 17, 2021 at 05:19 PM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 7.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `siperpus`
--
CREATE DATABASE IF NOT EXISTS `siperpus` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `siperpus`;

-- --------------------------------------------------------

--
-- Table structure for table `data_anggota`
--

CREATE TABLE `data_anggota` (
  `no_anggota` varchar(25) NOT NULL,
  `nama_anggota` varchar(35) NOT NULL,
  `tempat_lahir` varchar(25) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `jurusan_anggota` varchar(50) NOT NULL,
  `alamat_anggota` varchar(50) NOT NULL,
  `agama_anggota` varchar(20) NOT NULL,
  `jkel_anggota` varchar(15) NOT NULL,
  `foto_anggota` varchar(255) NOT NULL,
  `qr_anggota` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `data_anggota`
--

INSERT INTO `data_anggota` (`no_anggota`, `nama_anggota`, `tempat_lahir`, `tanggal_lahir`, `jurusan_anggota`, `alamat_anggota`, `agama_anggota`, `jkel_anggota`, `foto_anggota`, `qr_anggota`) VALUES
('20202001', 'Alfian Maol', 'Pemalang', '2000-08-28', 'Teknik Komputer dan Jaringan', 'Jl. KH Makmur No. 27', 'Islam', 'Laki-laki', '20202001-PIC-59', '20202001-QR.png'),
('20202002', 'Sasha Brauss', 'Paradise', '2000-02-12', 'Tata Busana', 'Shigashina District', 'Katolik', 'Perempuan', '20202002-PIC-01', '20202002-QR.png'),
('20202003', 'Mikasa Ackerman', 'Paradise', '2000-01-20', 'Desain Pemodelan dan Informasi Bangunan', 'Shigashina District', 'Kristen Protestan', 'Perempuan', '20202003-PIC-27', '20202003-QR.png'),
('20202004', 'Alan Walker', 'California', '1998-12-22', 'Teknik Kendaraan Ringan Otomotif', 'Sillicon Valley', 'Kristen Protestan', 'Laki-laki', '20202004-PIC-51', '20202004-QR.png'),
('20202005', 'Breel Embolo', 'Swisse', '2000-02-28', 'Teknik Elektronika Industri', 'Switzerland', 'Katolik', 'Laki-laki', 'MALE-PIC', '20202005-QR.png');

-- --------------------------------------------------------

--
-- Table structure for table `data_buku`
--

CREATE TABLE `data_buku` (
  `no_induk` int(11) NOT NULL,
  `isbn` varchar(20) NOT NULL,
  `judul_buku` varchar(100) NOT NULL,
  `pengarang_buku` varchar(30) NOT NULL,
  `kota_dibuat` varchar(20) NOT NULL,
  `penerbit_buku` varchar(30) NOT NULL,
  `tahun_buku` year(4) NOT NULL,
  `eksemplar_buku` int(11) NOT NULL,
  `no_rak` varchar(10) NOT NULL,
  `kategori_buku` varchar(40) NOT NULL,
  `qr_code` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `data_buku`
--

INSERT INTO `data_buku` (`no_induk`, `isbn`, `judul_buku`, `pengarang_buku`, `kota_dibuat`, `penerbit_buku`, `tahun_buku`, `eksemplar_buku`, `no_rak`, `kategori_buku`, `qr_code`) VALUES
(5491, '21212121200', 'Codeigniter 4', 'Effendy', 'Yogyakarta', 'Alex Komputindo', 2021, 15, '6', 'Teknologi & Ilmu Terapan', '5491-QR.png'),
(5492, '282828939019', 'Sistem Informasi', 'Effendy', 'Bandung', 'Sinar Plus', 2020, 10, '6', 'Teknologi & Ilmu Terapan', '5492-QR.png'),
(5493, '282828939012', 'Belajar Javascript', 'Linus Torvalds', 'Sillicon Valley', 'New York Times', 2019, 5, '2', 'Teknologi & Ilmu Terapan', '5493-QR.png'),
(5494, '280820026922', 'Belajar Aritmatika', 'Seto Mulyadi', 'Banyuwangi', 'Gramedia', 2019, 4, '1', 'Ilmu-ilmu & Matematika', '5494-QR.png'),
(5495, '202020098482', 'Java Programming', 'Linus', 'Nevada', 'EA Sports', 2020, 4, '3', 'Teknologi & Ilmu Terapan', '5495-QR.png');

--
-- Triggers `data_buku`
--
DELIMITER $$
CREATE TRIGGER `delete_buku` AFTER DELETE ON `data_buku` FOR EACH ROW DELETE FROM insert_buku WHERE no_induk = old.no_induk
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `insert_buku` AFTER INSERT ON `data_buku` FOR EACH ROW INSERT INTO insert_buku SET no_induk = new.no_induk, judul_buku = new.judul_buku, eksemplar_buku = new.eksemplar_buku, kategori_buku = new.kategori_buku, tanggal_insert = now()
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_buku` AFTER UPDATE ON `data_buku` FOR EACH ROW UPDATE insert_buku SET judul_buku = new.judul_buku, kategori_buku = new.kategori_buku, eksemplar_buku = new.eksemplar_buku WHERE no_induk = old.no_induk
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `data_ebook`
--

CREATE TABLE `data_ebook` (
  `id_ebook` varchar(10) NOT NULL,
  `judul_ebook` varchar(50) NOT NULL,
  `pengarang` varchar(40) NOT NULL,
  `penerbit` varchar(35) NOT NULL,
  `kategori_ebook` varchar(30) NOT NULL,
  `cover_ebook` varchar(25) NOT NULL,
  `file_ebook` varchar(25) NOT NULL,
  `qr_ebook` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `data_ebook`
--

INSERT INTO `data_ebook` (`id_ebook`, `judul_ebook`, `pengarang`, `penerbit`, `kategori_ebook`, `cover_ebook`, `file_ebook`, `qr_ebook`) VALUES
('EB00001', 'PHP : The Right Way', 'Josh Lockchart & Phil Sturgeon', 'Leanpub', 'Teknologi & Ilmu Terapan', 'EB00001-Cover', 'EB00001-Ebook.pdf', 'EB00001-QR.png'),
('EB00002', 'Apalagi Islam Itu Kalau Bukan Cinta', 'Husein Ja\'far Al-Hadar', 'Gerakan Islam Cinta', 'Agama', 'EB00002-Cover', 'EB00002-Ebook.pdf', 'EB00002-QR.png'),
('EB00003', 'Sebuah Seni Untuk Bersikap Bodo Amat', 'Mark Manson', 'Gramedia', 'Ilmu Sosial', 'EB00003-Cover', 'EB00003-Ebook.pdf', 'EB00003-QR.png');

-- --------------------------------------------------------

--
-- Table structure for table `data_peminjaman`
--

CREATE TABLE `data_peminjaman` (
  `id_peminjaman` varchar(10) NOT NULL,
  `tanggal_pinjam` date NOT NULL,
  `tanggal_kembali` date NOT NULL,
  `id_buku` int(11) NOT NULL,
  `jml_pinjam` int(11) NOT NULL,
  `no_anggota` varchar(25) NOT NULL,
  `status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `data_peminjaman`
--

INSERT INTO `data_peminjaman` (`id_peminjaman`, `tanggal_pinjam`, `tanggal_kembali`, `id_buku`, `jml_pinjam`, `no_anggota`, `status`) VALUES
('PJ00001', '2021-04-03', '2021-04-07', 5491, 1, '20202001', 'Dikembalikan'),
('PJ00002', '2021-04-14', '2021-04-17', 5492, 1, '20202002', 'Dikembalikan'),
('PJ00003', '2021-04-14', '2021-04-21', 5493, 1, '20202001', 'Dikembalikan'),
('PJ00004', '2021-04-18', '2021-04-21', 5493, 1, '20202003', 'Dikembalikan'),
('PJ00005', '2021-05-01', '2021-05-07', 5492, 1, '20202002', 'Dikembalikan'),
('PJ00006', '2021-06-15', '2021-06-18', 5495, 1, '20202003', 'Dipinjam'),
('PJ00007', '2021-06-15', '2021-06-18', 5494, 1, '20202001', 'Dipinjam');

-- --------------------------------------------------------

--
-- Table structure for table `data_pengembalian`
--

CREATE TABLE `data_pengembalian` (
  `id_peminjaman` varchar(10) NOT NULL,
  `tanggal_pinjam` date NOT NULL,
  `tanggal_kembali` date NOT NULL,
  `no_anggota` varchar(25) NOT NULL,
  `tgl_dikembalikan` date NOT NULL,
  `denda` int(11) NOT NULL,
  `status_pembayaran` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `data_pengembalian`
--

INSERT INTO `data_pengembalian` (`id_peminjaman`, `tanggal_pinjam`, `tanggal_kembali`, `no_anggota`, `tgl_dikembalikan`, `denda`, `status_pembayaran`) VALUES
('PJ00001', '2021-04-03', '2021-04-07', '20202001', '2021-04-10', 1500, 'Dibayar'),
('PJ00002', '2021-04-14', '2021-04-17', '20202002', '2021-04-14', 0, 'Tidak Ada'),
('PJ00003', '2021-04-14', '2021-04-21', '20202001', '2021-04-18', 0, 'Tidak Ada'),
('PJ00004', '2021-04-18', '2021-04-21', '20202003', '2021-04-26', 2500, 'Dibayar'),
('PJ00005', '2021-05-01', '2021-05-07', '20202002', '2021-05-30', 11500, 'Dibayar');

-- --------------------------------------------------------

--
-- Table structure for table `data_pengunjung`
--

CREATE TABLE `data_pengunjung` (
  `no` int(11) NOT NULL,
  `no_anggota` varchar(25) NOT NULL,
  `nama` varchar(35) NOT NULL,
  `jurusan_anggota` varchar(50) NOT NULL,
  `tanggal_kunjungan` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `data_pengunjung`
--

INSERT INTO `data_pengunjung` (`no`, `no_anggota`, `nama`, `jurusan_anggota`, `tanggal_kunjungan`) VALUES
(1, '20202001', 'Alfian Maol', 'Teknik Komputer dan Jaringan', '2021-04-18'),
(2, '20202002', 'Sasha Brauss', 'Tata Busana', '2021-04-18'),
(3, '20202003', 'Mikasa Ackerman', 'Desain Pemodelan dan Informasi Bangunan', '2021-04-18'),
(4, '20202004', 'Alan Walker', 'Teknik Kendaraan Ringan Otomotif', '2021-04-18'),
(5, '20202003', 'Mikasa Ackerman', 'Desain Pemodelan dan Informasi Bangunan', '2021-04-18'),
(6, '20202003', 'Mikasa Ackerman', 'Desain Pemodelan dan Informasi Bangunan', '2021-04-30'),
(7, '20202002', 'Sasha Brauss', 'Tata Busana', '2021-04-30'),
(8, '20202001', 'Alfian Maol', 'Teknik Komputer dan Jaringan', '2021-05-03');

-- --------------------------------------------------------

--
-- Table structure for table `insert_buku`
--

CREATE TABLE `insert_buku` (
  `no_induk` int(11) NOT NULL,
  `judul_buku` varchar(100) NOT NULL,
  `kategori_buku` varchar(40) NOT NULL,
  `eksemplar_buku` int(11) NOT NULL,
  `tanggal_insert` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `insert_buku`
--

INSERT INTO `insert_buku` (`no_induk`, `judul_buku`, `kategori_buku`, `eksemplar_buku`, `tanggal_insert`) VALUES
(5491, 'Codeigniter 4', 'Teknologi & Ilmu Terapan', 15, '2021-03-31 16:37:57'),
(5492, 'Sistem Informasi', 'Teknologi & Ilmu Terapan', 10, '2021-04-03 23:23:57'),
(5493, 'Belajar Javascript', 'Teknologi & Ilmu Terapan', 5, '2021-04-13 23:27:28'),
(5494, 'Belajar Aritmatika', 'Ilmu-ilmu & Matematika', 4, '2021-04-17 23:01:07'),
(5495, 'Java Programming', 'Teknologi & Ilmu Terapan', 4, '2021-05-01 16:32:28');

-- --------------------------------------------------------

--
-- Table structure for table `pengguna`
--

CREATE TABLE `pengguna` (
  `no` int(11) NOT NULL,
  `nama` varchar(35) NOT NULL,
  `role` varchar(10) NOT NULL,
  `id` varchar(25) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pengguna`
--

INSERT INTO `pengguna` (`no`, `nama`, `role`, `id`, `password`) VALUES
(1, 'Eren Yeager', 'Petugas', '26092000', '25d55ad283aa400af464c76d713c07ad'),
(2, 'Berthold Hoover', 'Petugas', '28082000', '25d55ad283aa400af464c76d713c07ad'),
(11, 'Alfian Maol', 'Anggota', '20202001', '25d55ad283aa400af464c76d713c07ad'),
(12, 'Sasha Brauss', 'Anggota', '20202002', '25d55ad283aa400af464c76d713c07ad'),
(18, 'Mikasa Ackerman', 'Anggota', '20202003', '25d55ad283aa400af464c76d713c07ad'),
(19, 'Alan Walker', 'Anggota', '20202004', '25d55ad283aa400af464c76d713c07ad'),
(20, 'Breel Embolo', 'Anggota', '20202005', '25d55ad283aa400af464c76d713c07ad');

-- --------------------------------------------------------

--
-- Table structure for table `petugas`
--

CREATE TABLE `petugas` (
  `id_petugas` varchar(25) NOT NULL,
  `nama_petugas` varchar(40) NOT NULL,
  `jabatan_petugas` varchar(25) NOT NULL,
  `no_telp_petugas` char(14) NOT NULL,
  `alamat_petugas` varchar(50) NOT NULL,
  `foto_petugas` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `petugas`
--

INSERT INTO `petugas` (`id_petugas`, `nama_petugas`, `jabatan_petugas`, `no_telp_petugas`, `alamat_petugas`, `foto_petugas`) VALUES
('26092000', 'Eren Yeager', 'Petugas', '085156506725', 'Jl. Shigashina No. 20 Paradise', '26092000-PIC-05'),
('28082000', 'Berthold Hoover', 'Petugas', '0811281794', 'Jl. Liberio No.3 Marley', '28082000-PIC-20');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `data_anggota`
--
ALTER TABLE `data_anggota`
  ADD PRIMARY KEY (`no_anggota`);

--
-- Indexes for table `data_buku`
--
ALTER TABLE `data_buku`
  ADD PRIMARY KEY (`no_induk`);

--
-- Indexes for table `data_ebook`
--
ALTER TABLE `data_ebook`
  ADD PRIMARY KEY (`id_ebook`);

--
-- Indexes for table `data_peminjaman`
--
ALTER TABLE `data_peminjaman`
  ADD PRIMARY KEY (`id_peminjaman`);

--
-- Indexes for table `data_pengembalian`
--
ALTER TABLE `data_pengembalian`
  ADD PRIMARY KEY (`id_peminjaman`);

--
-- Indexes for table `data_pengunjung`
--
ALTER TABLE `data_pengunjung`
  ADD PRIMARY KEY (`no`);

--
-- Indexes for table `insert_buku`
--
ALTER TABLE `insert_buku`
  ADD PRIMARY KEY (`no_induk`);

--
-- Indexes for table `pengguna`
--
ALTER TABLE `pengguna`
  ADD PRIMARY KEY (`no`);

--
-- Indexes for table `petugas`
--
ALTER TABLE `petugas`
  ADD PRIMARY KEY (`id_petugas`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `data_pengunjung`
--
ALTER TABLE `data_pengunjung`
  MODIFY `no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `pengguna`
--
ALTER TABLE `pengguna`
  MODIFY `no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
