-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 19, 2025 at 10:34 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ikhsan`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admin`
--

CREATE TABLE `tbl_admin` (
  `id_admin` int(10) NOT NULL,
  `nm_admin` varchar(20) NOT NULL,
  `username` varchar(10) NOT NULL,
  `email` varchar(30) NOT NULL,
  `password` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_admin`
--

INSERT INTO `tbl_admin` (`id_admin`, `nm_admin`, `username`, `email`, `password`) VALUES
(1, 'administrator', 'admin', 'admin@gmail.com', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_banner`
--

CREATE TABLE `tbl_banner` (
  `id_banner` int(11) NOT NULL,
  `judul` varchar(255) DEFAULT NULL,
  `isi` longtext DEFAULT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `diskon` decimal(10,2) DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT NULL,
  `id_produk` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_banner`
--

INSERT INTO `tbl_banner` (`id_banner`, `judul`, `isi`, `gambar`, `diskon`, `status`, `id_produk`) VALUES
(1, 'diskon 50%', '<p>tess</p>', '1200x480px_2x_6.jpg', 50.00, 'active', '[\"77\",\"78\",\"79\"]'),
(2, 'diskon 20%', '<p>tess</p>', '2400x960.jpg', 20.00, 'active', '[\"74\",\"75\",\"76\"]'),
(3, 'tes', '<p>tes</p>', '1200x480_1.jpg', 0.00, 'active', '[\"\"]');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_detail_order`
--

CREATE TABLE `tbl_detail_order` (
  `id_detail_order` int(10) NOT NULL,
  `id_order` int(10) NOT NULL,
  `id_produk` int(10) NOT NULL,
  `nm_produk` varchar(50) NOT NULL,
  `harga` int(11) NOT NULL,
  `size` varchar(255) DEFAULT NULL,
  `jml_order` int(3) NOT NULL,
  `berat` int(10) NOT NULL,
  `subberat` int(10) NOT NULL,
  `diskon` decimal(10,2) DEFAULT NULL,
  `subharga` int(10) NOT NULL,
  `id_banner` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_detail_order`
--

INSERT INTO `tbl_detail_order` (`id_detail_order`, `id_order`, `id_produk`, `nm_produk`, `harga`, `size`, `jml_order`, `berat`, `subberat`, `diskon`, `subharga`, `id_banner`) VALUES
(5, 9, 79, 'New Balence', 380000, '40', 1, 1, 1, 0.00, 380000, 0),
(6, 10, 77, 'Adidas Samba', 320000, '42', 1, 1, 1, 160000.00, 160000, 1),
(7, 11, 77, 'Adidas Samba', 320000, '44', 1, 1, 1, 0.00, 320000, 0),
(8, 12, 78, 'Samba', 320000, '42', 1, 1, 1, 0.00, 320000, 0),
(9, 13, 105, 'Nike Zoom X', 300000, '40', 1, 1, 1, 0.00, 300000, 0),
(10, 14, 79, 'New Balence', 380000, '44', 1, 1, 1, 0.00, 380000, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_detail_order_offline`
--

CREATE TABLE `tbl_detail_order_offline` (
  `id_detail_order` int(11) NOT NULL,
  `id_order` int(11) NOT NULL,
  `id_produk` int(11) NOT NULL,
  `nm_produk` varchar(50) NOT NULL,
  `harga` int(11) NOT NULL,
  `size` varchar(255) DEFAULT NULL,
  `jml_order` int(11) NOT NULL,
  `berat` int(11) NOT NULL,
  `subberat` int(11) NOT NULL,
  `diskon` decimal(10,2) DEFAULT NULL,
  `subharga` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `tbl_detail_order_offline`
--

INSERT INTO `tbl_detail_order_offline` (`id_detail_order`, `id_order`, `id_produk`, `nm_produk`, `harga`, `size`, `jml_order`, `berat`, `subberat`, `diskon`, `subharga`) VALUES
(2, 2, 79, 'New Balence', 350000, '41', 1, 0, 0, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_kat_produk`
--

CREATE TABLE `tbl_kat_produk` (
  `id_kategori` int(10) NOT NULL,
  `nm_kategori` varchar(30) NOT NULL,
  `level` enum('1','2','3') NOT NULL,
  `parent_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_kat_produk`
--

INSERT INTO `tbl_kat_produk` (`id_kategori`, `nm_kategori`, `level`, `parent_id`) VALUES
(57, 'Wanita', '1', 0),
(58, 'Pria', '1', 0),
(59, 'Anak', '1', 0),
(60, 'Koper', '1', 0),
(61, 'Sepatu wanita', '2', 57),
(62, 'Sendal wanita', '2', 57),
(63, 'Aksesoris Wanita', '2', 57),
(64, 'Sepatu Pria', '2', 58),
(65, 'Sendal Pria', '2', 58),
(66, 'Aksesoris Pria', '2', 58),
(67, 'Sepatu Anak', '2', 59),
(68, 'Sendal Anak', '2', 59),
(69, 'Aksesoris Anak', '2', 59),
(70, 'Semua Sepatu Pria', '3', 64),
(71, 'Semua Sendal Pria', '3', 65),
(72, 'Tas Pria', '3', 66),
(73, 'Kaos Kaki Pria', '3', 66),
(74, 'Sneakers Pria', '3', 64),
(75, 'Slip On Pria', '3', 64),
(76, 'Pantofel Pria', '3', 64),
(77, 'Sepatu Olahraga Pria', '3', 64),
(78, 'Sepatu Futsal Pria', '3', 64),
(79, 'Sepatu Bola Pria', '3', 64),
(80, 'Sepatu Badminton Pria', '3', 64),
(81, 'Semua Sepatu Wanita', '3', 61),
(82, 'Sneakers Wanita', '3', 61);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_order`
--

CREATE TABLE `tbl_order` (
  `id_order` int(10) NOT NULL,
  `id_pelanggan` int(10) NOT NULL,
  `id_banner` varchar(255) DEFAULT NULL,
  `nm_penerima` varchar(30) NOT NULL DEFAULT '',
  `telp` varchar(13) NOT NULL,
  `provinsi` varchar(30) NOT NULL,
  `kota` varchar(30) NOT NULL,
  `kode_pos` int(10) NOT NULL,
  `alamat_pengiriman` varchar(50) NOT NULL,
  `tgl_order` date NOT NULL,
  `ongkir` int(10) NOT NULL,
  `total_order` int(10) NOT NULL,
  `status` varchar(30) DEFAULT 'Belum Dibayar',
  `no_resi` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_order`
--

INSERT INTO `tbl_order` (`id_order`, `id_pelanggan`, `id_banner`, `nm_penerima`, `telp`, `provinsi`, `kota`, `kode_pos`, `alamat_pengiriman`, `tgl_order`, `ongkir`, `total_order`, `status`, `no_resi`) VALUES
(9, 14, NULL, 'ikhsan', '081240615161', '25', '425', 91018, 'jln f kalasuat', '2025-04-08', 17000, 340000, 'Produk Diterima', 'spx91110003u47575'),
(10, 14, NULL, 'ikhsan', '2222222', '25', '425', 98412, 'jln f kalasuat', '2025-04-08', 17000, 177000, 'Produk Diterima', ''),
(11, 14, NULL, 'ikhsan', '00000000', '25', '425', 91018, 'jln f kalasuat', '2025-04-17', 17000, 337000, 'Sudah Dibayar', NULL),
(12, 14, NULL, 'ikhsan', '081240615161', '25', '425', 91018, 'jln f kalasuat', '2025-04-17', 17000, 337000, 'Produk Diterima', ''),
(13, 14, NULL, 'ikhsan', '00000000000', '25', '425', 91018, 'jln f kalasuat', '2025-04-19', 17000, 317000, 'Sudah Dibayar', NULL),
(14, 14, NULL, 'ikhsan', '000000', '25', '425', 91018, 'jln f kalasuat', '2025-04-19', 17000, 397000, 'Produk Diterima', '000000000000');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_order_offline`
--

CREATE TABLE `tbl_order_offline` (
  `id_order` int(11) NOT NULL,
  `nm_penerima` varchar(30) NOT NULL DEFAULT '',
  `telp` varchar(13) NOT NULL,
  `provinsi` varchar(30) NOT NULL,
  `kota` varchar(30) NOT NULL,
  `kode_pos` int(11) NOT NULL,
  `alamat_pengiriman` varchar(50) NOT NULL,
  `tgl_order` date NOT NULL,
  `ongkir` int(11) NOT NULL,
  `total_order` int(11) NOT NULL,
  `status` varchar(30) DEFAULT 'Belum Dibayar',
  `no_resi` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `tbl_order_offline`
--

INSERT INTO `tbl_order_offline` (`id_order`, `nm_penerima`, `telp`, `provinsi`, `kota`, `kode_pos`, `alamat_pengiriman`, `tgl_order`, `ongkir`, `total_order`, `status`, `no_resi`) VALUES
(2, '', '', '', '', 0, '', '2025-04-08', 0, 350000, 'Sudah Dibayar', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pelanggan`
--

CREATE TABLE `tbl_pelanggan` (
  `id_pelanggan` int(10) NOT NULL,
  `nm_pelanggan` varchar(30) NOT NULL,
  `username` varchar(10) NOT NULL,
  `email` varchar(30) NOT NULL,
  `password` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_pelanggan`
--

INSERT INTO `tbl_pelanggan` (`id_pelanggan`, `nm_pelanggan`, `username`, `email`, `password`) VALUES
(14, ' ikhsan', 'ikhsan', 'ikhsan31365@gmail.com', 'ikhsan');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pembayaran`
--

CREATE TABLE `tbl_pembayaran` (
  `id_pembayaran` int(10) NOT NULL,
  `id_order` int(10) NOT NULL,
  `nm_pembayar` varchar(30) NOT NULL,
  `nm_bank` varchar(20) NOT NULL,
  `jml_pembayaran` int(10) NOT NULL,
  `tgl_bayar` date NOT NULL,
  `bukti_transfer` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_pembayaran`
--

INSERT INTO `tbl_pembayaran` (`id_pembayaran`, `id_order`, `nm_pembayar`, `nm_bank`, `jml_pembayaran`, `tgl_bayar`, `bukti_transfer`) VALUES
(5, 9, 'Ikhsan', 'bri', 340000, '2025-04-08', 'Cuplikan layar 2025-04-05 225927.png'),
(6, 10, 'Ikhsan', 'bri', 177000, '2025-04-08', 'Cuplikan layar 2025-02-11 210344.png'),
(7, 11, 'Ikhsan', 'bri', 337000, '2025-04-17', 'IMG_20250413_140639 (1).png'),
(8, 12, 'ikhsan', 'bri', 337000, '2025-04-17', 'IMG_20250413_140639 (1).png'),
(9, 13, 'Ikhsan', 'bri', 317000, '2025-04-19', 'IMG_20250415_160822.png'),
(10, 14, 'ikhsan', 'bri', 397000, '2025-04-19', 'Cuplikan layar 2025-04-17 140601.png');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pembayaran_offline`
--

CREATE TABLE `tbl_pembayaran_offline` (
  `id_pembayaran` int(11) NOT NULL,
  `id_order` int(11) NOT NULL,
  `nm_pembayar` varchar(30) NOT NULL,
  `nm_bank` varchar(20) NOT NULL,
  `jml_pembayaran` int(11) NOT NULL,
  `tgl_bayar` date NOT NULL,
  `bukti_transfer` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_produk`
--

CREATE TABLE `tbl_produk` (
  `id_produk` int(10) NOT NULL,
  `id_kategori` varchar(255) NOT NULL,
  `kd_produk` varchar(100) DEFAULT NULL,
  `nm_produk` varchar(50) NOT NULL,
  `berat` int(10) NOT NULL,
  `harga` int(10) NOT NULL,
  `stok` int(3) NOT NULL,
  `gambar` varchar(255) NOT NULL,
  `deskripsi` text NOT NULL,
  `size` varchar(255) DEFAULT NULL,
  `modal` decimal(14,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_produk`
--

INSERT INTO `tbl_produk` (`id_produk`, `id_kategori`, `kd_produk`, `nm_produk`, `berat`, `harga`, `stok`, `gambar`, `deskripsi`, `size`, `modal`) VALUES
(77, '[\"70\",\"74\"]', 'SP01', 'Adidas Samba', 1, 320000, 5, '[\"IMG_20250413_140639 (1).png\",\"IMG_20250413_140706.png\",\"IMG_20250413_140724.png\"]', '', '[{\"size\":\"40\",\"stock\":1},{\"size\":\"42\",\"stock\":2},{\"size\":\"43\",\"stock\":1},{\"size\":\"44\",\"stock\":1}]', 150000.00),
(78, '[\"70\",\"74\"]', 'SP02', 'Samba', 1, 320000, 2, '[\"IMG_20250413_140746.png\",\"IMG_20250413_140802.png\",\"IMG_20250413_140817.png\"]', '', '[{\"size\":\"43\",\"stock\":1},{\"size\":\"44\",\"stock\":1}]', 150000.00),
(79, '[\"70\",\"74\"]', 'SP03', 'New Balence', 1, 380000, 2, '[\"IMG_20250413_140847.png\",\"IMG_20250413_140912.png\",\"IMG_20250413_140929.png\"]', '', '[{\"size\":\"42\",\"stock\":1},{\"size\":\"43\",\"stock\":1},{\"size\":\"44\",\"stock\":0}]', 150000.00),
(80, '[\"70\",\"75\"]', 'SP04', 'Slip On', 1, 180000, 5, '[\"IMG_20250413_140956.png\",\"IMG_20250413_141010.png\",\"IMG_20250413_141025.png\"]', '', '[{\"size\":\"40\",\"stock\":1},{\"size\":\"41\",\"stock\":1},{\"size\":\"42\",\"stock\":1},{\"size\":\"43\",\"stock\":1},{\"size\":\"44\",\"stock\":1}]', 80000.00),
(81, '[\"70\",\"74\"]', 'SP05', 'Asics', 1, 380000, 5, '[\"IMG_20250413_141046.png\",\"IMG_20250413_141118.png\"]', '', '[{\"size\":\"40\",\"stock\":1},{\"size\":\"41\",\"stock\":1},{\"size\":\"42\",\"stock\":1},{\"size\":\"43\",\"stock\":1},{\"size\":\"44\",\"stock\":1}]', 150000.00),
(82, '[\"70\",\"78\"]', 'SP06', 'Ortus', 1, 180000, 5, '[\"IMG_20250413_144528.png\",\"IMG_20250413_144553.png\",\"IMG_20250413_144607.png\"]', '', '[{\"size\":\"40\",\"stock\":1},{\"size\":\"41\",\"stock\":1},{\"size\":\"42\",\"stock\":2},{\"size\":\"44\",\"stock\":1}]', 75000.00),
(83, '[\"70\",\"79\"]', 'SP07', 'Adidas F50', 1, 200000, 5, '[\"IMG_20250413_144628.png\",\"IMG_20250413_144642.png\",\"IMG_20250413_144653.png\"]', '', '[{\"size\":\"40\",\"stock\":1},{\"size\":\"41\",\"stock\":1},{\"size\":\"42\",\"stock\":2},{\"size\":\"44\",\"stock\":1}]', 75000.00),
(84, '[\"70\",\"77\"]', 'SP08', 'Nike Zoom X', 1, 380000, 5, '[\"IMG_20250413_144711.png\",\"IMG_20250413_144725.png\",\"IMG_20250413_144737.png\"]', '', '[{\"size\":\"40\",\"stock\":1},{\"size\":\"41\",\"stock\":1},{\"size\":\"42\",\"stock\":1},{\"size\":\"43\",\"stock\":1},{\"size\":\"44\",\"stock\":1}]', 150000.00),
(85, '[\"70\",\"77\"]', 'SP09', 'Nike Zoom X', 1, 450000, 5, '[\"IMG_20250413_145033.png\",\"IMG_20250413_145044.png\",\"IMG_20250413_145054.png\"]', '', '[{\"size\":\"40\",\"stock\":1},{\"size\":\"41\",\"stock\":1},{\"size\":\"42\",\"stock\":1},{\"size\":\"43\",\"stock\":1},{\"size\":\"44\",\"stock\":1}]', 220000.00),
(86, '[\"70\",\"77\"]', 'SP10', 'Nike Zoom X', 1, 450000, 5, '[\"IMG_20250413_144949.png\",\"IMG_20250413_145006.png\",\"IMG_20250413_145019.png\"]', '', '[{\"size\":\"40\",\"stock\":1},{\"size\":\"41\",\"stock\":1},{\"size\":\"42\",\"stock\":1},{\"size\":\"43\",\"stock\":1},{\"size\":\"44\",\"stock\":1}]', 220000.00),
(87, '[\"70\",\"77\"]', 'SP11', 'Nike Zoom X', 1, 450000, 5, '[\"IMG_20250413_144911.png\",\"IMG_20250413_144922.png\",\"IMG_20250413_144933.png\"]', '', '[{\"size\":\"40\",\"stock\":1},{\"size\":\"41\",\"stock\":1},{\"size\":\"42\",\"stock\":1},{\"size\":\"43\",\"stock\":1},{\"size\":\"44\",\"stock\":1}]', 220000.00),
(88, '[\"70\",\"77\"]', 'SP12', 'Nike Zoom X', 1, 450000, 5, '[\"IMG_20250413_144830.png\",\"IMG_20250413_144842.png\",\"IMG_20250413_144854.png\"]', '', '[{\"size\":\"40\",\"stock\":1},{\"size\":\"41\",\"stock\":1},{\"size\":\"42\",\"stock\":1},{\"size\":\"43\",\"stock\":1},{\"size\":\"44\",\"stock\":1}]', 220000.00),
(89, '[\"70\",\"74\"]', 'SP13', 'Nike Air Max', 1, 400000, 5, '[\"IMG_20250415_120635.png\",\"IMG_20250415_120653.png\",\"IMG_20250415_120716.png\"]', '', '[{\"size\":\"40\",\"stock\":1},{\"size\":\"41\",\"stock\":1},{\"size\":\"42\",\"stock\":1},{\"size\":\"43\",\"stock\":1},{\"size\":\"44\",\"stock\":1}]', 170000.00),
(90, '[\"70\",\"74\"]', 'SP14', 'Nike Air Max', 1, 400000, 5, '[\"IMG_20250415_120740.png\",\"IMG_20250415_120751.png\",\"IMG_20250415_120800.png\"]', '', '[{\"size\":\"40\",\"stock\":1},{\"size\":\"41\",\"stock\":1},{\"size\":\"42\",\"stock\":1},{\"size\":\"43\",\"stock\":1},{\"size\":\"44\",\"stock\":1}]', 170000.00),
(91, '[\"70\",\"74\"]', 'SP15', 'Nike 720', 1, 300000, 5, '[\"IMG_20250415_120814.png\",\"IMG_20250415_120823.png\",\"IMG_20250415_120836.png\"]', '', '[{\"size\":\"40\",\"stock\":1},{\"size\":\"41\",\"stock\":1},{\"size\":\"42\",\"stock\":1},{\"size\":\"43\",\"stock\":1},{\"size\":\"44\",\"stock\":1}]', 170000.00),
(92, '[\"70\",\"74\"]', 'SP16', 'KDM New', 1, 380000, 5, '[\"IMG_20250415_120849.png\",\"IMG_20250415_120913.png\",\"IMG_20250415_120923.png\"]', '', '[{\"size\":\"40\",\"stock\":1},{\"size\":\"41\",\"stock\":1},{\"size\":\"42\",\"stock\":1},{\"size\":\"43\",\"stock\":1},{\"size\":\"44\",\"stock\":1}]', 170000.00),
(93, '[\"70\",\"74\"]', 'SP17', 'Nike Air', 1, 350000, 5, '[\"IMG_20250415_120931.png\",\"IMG_20250415_120948.png\",\"IMG_20250415_120958.png\"]', '', '[{\"size\":\"40\",\"stock\":1},{\"size\":\"41\",\"stock\":1},{\"size\":\"42\",\"stock\":1},{\"size\":\"43\",\"stock\":1},{\"size\":\"44\",\"stock\":1}]', 150000.00),
(94, '[\"70\",\"74\"]', 'SP18', 'Nike', 1, 300000, 5, '[\"IMG_20250415_121008.png\",\"IMG_20250415_121018.png\",\"IMG_20250415_121030.png\"]', '', '[{\"size\":\"40\",\"stock\":1},{\"size\":\"41\",\"stock\":1},{\"size\":\"42\",\"stock\":1},{\"size\":\"43\",\"stock\":1},{\"size\":\"44\",\"stock\":1}]', 150000.00),
(95, '[\"70\",\"74\"]', 'SP19', 'Nike Air', 1, 350000, 5, '[\"IMG_20250415_121041.png\",\"IMG_20250415_121053.png\",\"IMG_20250415_121105.png\"]', '', '[{\"size\":\"40\",\"stock\":1},{\"size\":\"41\",\"stock\":1},{\"size\":\"42\",\"stock\":1},{\"size\":\"43\",\"stock\":1},{\"size\":\"44\",\"stock\":1}]', 150000.00),
(96, '[\"70\",\"74\"]', 'SP20', 'Nike', 1, 180000, 5, '[\"IMG_20250415_121116.png\",\"IMG_20250415_121127.png\",\"IMG_20250415_121138.png\"]', '', '[{\"size\":\"40\",\"stock\":1},{\"size\":\"41\",\"stock\":1},{\"size\":\"42\",\"stock\":1},{\"size\":\"43\",\"stock\":1},{\"size\":\"44\",\"stock\":1}]', 150000.00),
(97, '[\"70\",\"74\"]', 'SP21', 'Nike Air Max', 1, 350000, 5, '[\"IMG_20250415_121149.png\",\"IMG_20250415_121159.png\",\"IMG_20250415_121208.png\"]', '', '[{\"size\":\"40\",\"stock\":1},{\"size\":\"41\",\"stock\":1},{\"size\":\"42\",\"stock\":1},{\"size\":\"43\",\"stock\":1},{\"size\":\"44\",\"stock\":1}]', 150000.00),
(98, '[\"70\",\"74\"]', 'SP22', 'Nike Air Max', 1, 350000, 5, '[\"IMG_20250415_121218.png\",\"IMG_20250415_121228.png\",\"IMG_20250415_121240.png\"]', '', '[{\"size\":\"40\",\"stock\":1},{\"size\":\"41\",\"stock\":1},{\"size\":\"42\",\"stock\":1},{\"size\":\"43\",\"stock\":1},{\"size\":\"44\",\"stock\":1}]', 150000.00),
(99, '[\"70\",\"74\"]', 'SP23', 'Nike', 1, 320000, 5, '[\"IMG_20250415_121252.png\",\"IMG_20250415_121303.png\",\"IMG_20250415_121312.png\"]', '', '[{\"size\":\"40\",\"stock\":1},{\"size\":\"41\",\"stock\":1},{\"size\":\"42\",\"stock\":1},{\"size\":\"43\",\"stock\":1},{\"size\":\"44\",\"stock\":1}]', 150000.00),
(100, '[\"70\",\"74\"]', 'SP24', 'Nike Air', 1, 500000, 5, '[\"IMG_20250415_121327.png\",\"IMG_20250415_121342.png\",\"IMG_20250415_121352.png\"]', '', '[{\"size\":\"40\",\"stock\":1},{\"size\":\"41\",\"stock\":1},{\"size\":\"42\",\"stock\":1},{\"size\":\"43\",\"stock\":1},{\"size\":\"44\",\"stock\":1}]', 220000.00),
(101, '[\"70\",\"74\"]', 'SP25', 'Nike Air', 1, 500000, 5, '[\"IMG_20250415_121405.png\",\"IMG_20250415_121416.png\",\"IMG_20250415_121426.png\"]', '', '[{\"size\":\"40\",\"stock\":1},{\"size\":\"41\",\"stock\":1},{\"size\":\"42\",\"stock\":1},{\"size\":\"43\",\"stock\":1},{\"size\":\"44\",\"stock\":1}]', 220000.00),
(102, '[\"70\",\"74\"]', 'SP26', 'Nike Air', 1, 320000, 5, '[\"IMG_20250415_121435.png\",\"IMG_20250415_121444.png\",\"IMG_20250415_121453.png\"]', '', '[{\"size\":\"40\",\"stock\":1},{\"size\":\"41\",\"stock\":1},{\"size\":\"42\",\"stock\":1},{\"size\":\"43\",\"stock\":1},{\"size\":\"44\",\"stock\":1}]', 150000.00),
(103, '[\"70\",\"74\"]', 'SP27', 'Nike Air', 1, 320000, 5, '[\"IMG_20250415_121502.png\",\"IMG_20250415_121510.png\",\"IMG_20250415_121519.png\"]', '', '[{\"size\":\"40\",\"stock\":1},{\"size\":\"41\",\"stock\":1},{\"size\":\"42\",\"stock\":1},{\"size\":\"43\",\"stock\":1},{\"size\":\"44\",\"stock\":1}]', 150000.00),
(104, '[\"70\",\"74\"]', 'SP28', 'Nike Air Max', 0, 335000, 5, '[\"IMG_20250415_121528.png\",\"IMG_20250415_121539.png\",\"IMG_20250415_121548.png\"]', '', '[{\"size\":\"40\",\"stock\":1},{\"size\":\"41\",\"stock\":1},{\"size\":\"42\",\"stock\":1},{\"size\":\"43\",\"stock\":1},{\"size\":\"44\",\"stock\":1}]', 150000.00),
(105, '[\"70\",\"77\"]', 'SP29', 'Nike Zoom X', 1, 300000, 4, '[\"IMG_20250415_121557.png\",\"IMG_20250415_121603.png\",\"IMG_20250415_121612.png\"]', '', '[{\"size\":\"40\",\"stock\":0},{\"size\":\"41\",\"stock\":1},{\"size\":\"42\",\"stock\":1},{\"size\":\"43\",\"stock\":1},{\"size\":\"44\",\"stock\":1}]', 150000.00),
(106, '[\"70\",\"74\"]', 'SP30', 'Fashion', 0, 200000, 5, '[\"IMG_20250415_121619.png\",\"IMG_20250415_121627.png\",\"IMG_20250415_121636.png\"]', '', '[{\"size\":\"40\",\"stock\":1},{\"size\":\"41\",\"stock\":1},{\"size\":\"42\",\"stock\":1},{\"size\":\"43\",\"stock\":1},{\"size\":\"44\",\"stock\":1}]', 90000.00),
(107, '[\"70\",\"74\"]', 'SP31', 'Nike Air', 1, 350000, 5, '[\"IMG_20250415_121643.png\",\"IMG_20250415_121650.png\",\"IMG_20250415_121701.png\"]', '', '[{\"size\":\"40\",\"stock\":1},{\"size\":\"41\",\"stock\":1},{\"size\":\"42\",\"stock\":1},{\"size\":\"43\",\"stock\":1},{\"size\":\"44\",\"stock\":1}]', 150000.00),
(108, '[\"74\",\"70\"]', 'SP32', 'Adidas', 1, 300000, 5, '[\"IMG_20250415_121708.png\",\"IMG_20250415_121715.png\",\"IMG_20250415_121721.png\"]', '', '[{\"size\":\"40\",\"stock\":1},{\"size\":\"41\",\"stock\":1},{\"size\":\"42\",\"stock\":1},{\"size\":\"43\",\"stock\":1},{\"size\":\"44\",\"stock\":1}]', 130000.00),
(109, '[\"70\",\"74\"]', 'SP33', 'Adidas', 1, 300000, 5, '[\"IMG_20250415_121729.png\",\"IMG_20250415_121738.png\",\"IMG_20250415_121745.png\"]', '', '[{\"size\":\"40\",\"stock\":1},{\"size\":\"41\",\"stock\":1},{\"size\":\"42\",\"stock\":1},{\"size\":\"43\",\"stock\":1},{\"size\":\"44\",\"stock\":1}]', 150000.00),
(110, '[\"70\",\"74\"]', 'SP34', 'Adidas Marathon X', 1, 300000, 1, '[\"IMG_20250415_121759.png\",\"IMG_20250415_121806.png\",\"IMG_20250415_121817.png\"]', '', '[{\"size\":\"40\",\"stock\":1}]', 150000.00),
(111, '[\"70\",\"74\"]', 'SP35', 'Adidas', 1, 300000, 3, '[\"IMG_20250415_121827.png\",\"IMG_20250415_121833.png\",\"IMG_20250415_121844.png\"]', '', '[{\"size\":\"40\",\"stock\":1},{\"size\":\"41\",\"stock\":1},{\"size\":\"43\",\"stock\":1}]', 150000.00),
(112, '[\"74\",\"70\"]', 'SP36', 'Adidas', 1, 300000, 2, '[\"IMG_20250415_121922.png\",\"IMG_20250415_121930.png\",\"IMG_20250415_121938.png\"]', '', '[{\"size\":\"40\",\"stock\":1},{\"size\":\"41\",\"stock\":1}]', 150000.00),
(113, '[\"70\",\"74\"]', 'SP37', 'KDM', 1, 250000, 1, '[\"IMG_20250415_122015.png\",\"IMG_20250415_122024.png\",\"IMG_20250415_122031.png\"]', '', '[{\"size\":\"40\",\"stock\":1}]', 150000.00),
(114, '[\"74\",\"70\"]', 'SP38', 'Nike Zoom X', 1, 500000, 1, '[\"IMG_20250415_122309.png\",\"IMG_20250415_122324.png\",\"IMG_20250415_122508.png\"]', '', '[{\"size\":\"40\",\"stock\":1}]', 220000.00),
(115, '[\"70\",\"74\"]', 'SP39', 'Nike Zoom X', 1, 500000, 1, '[\"IMG_20250415_122333.png\",\"IMG_20250415_122342.png\",\"IMG_20250415_122351.png\"]', '', '[{\"size\":\"40\",\"stock\":1}]', 220000.00),
(116, '[\"70\",\"74\"]', 'SP40', 'Nike Air Max', 1, 400000, 1, '[\"IMG_20250415_122530.png\",\"IMG_20250415_122541.png\",\"IMG_20250415_122550.png\"]', '', '[{\"size\":\"40\",\"stock\":1}]', 170000.00),
(117, '[\"70\",\"74\"]', 'SP41', 'Nike Air Max', 1, 400000, 1, '[\"IMG_20250415_122558.png\",\"IMG_20250415_122606.png\",\"IMG_20250415_122614.png\"]', '', '[{\"size\":\"40\",\"stock\":1}]', 170000.00),
(118, '[\"70\",\"74\"]', 'SP42', 'Nike Air Max', 1, 400000, 1, '[\"IMG_20250415_122623.png\",\"IMG_20250415_122630.png\",\"IMG_20250415_122637.png\"]', '', '[{\"size\":\"40\",\"stock\":1}]', 170000.00),
(119, '[\"74\",\"70\"]', 'SP43', 'Nike Air Max', 1, 400000, 1, '[\"IMG_20250415_122645.png\",\"IMG_20250415_122653.png\",\"IMG_20250415_122700.png\"]', '', '[{\"size\":\"40\",\"stock\":1}]', 170000.00),
(120, '[\"70\",\"74\"]', 'SP44', 'Nike Air Max', 1, 400000, 1, '[\"IMG_20250415_122708.png\",\"IMG_20250415_122722.png\",\"IMG_20250415_122731.png\"]', '', '[{\"size\":\"40\",\"stock\":1}]', 170000.00),
(121, '[\"81\",\"82\"]', 'SW01', 'Nikf', 1, 300000, 1, '[\"IMG_20250415_160822.png\",\"IMG_20250415_160828.png\",\"IMG_20250415_160835.png\"]', '', '[{\"size\":\"40\",\"stock\":1}]', 120000.00),
(122, '[\"82\",\"81\"]', 'SW02', 'Nike Air Max', 1, 380000, 1, '[\"IMG_20250415_161012.png\",\"IMG_20250415_161017.png\",\"IMG_20250415_161022.png\"]', '', '[{\"size\":\"36\",\"stock\":1}]', 150000.00),
(123, '[\"81\",\"82\"]', 'SW03', 'Nike Air Max', 1, 380000, 1, '[\"IMG_20250415_161116.png\",\"IMG_20250415_161120.png\",\"IMG_20250415_161125.png\"]', '', '[{\"size\":\"36\",\"stock\":1}]', 150000.00),
(124, '[\"81\",\"82\"]', 'SW04', 'Fashion', 1, 280000, 1, '[\"IMG_20250415_161352.png\",\"IMG_20250415_161357.png\",\"IMG_20250415_161402.png\"]', '', '[{\"size\":\"36\",\"stock\":1}]', 100000.00),
(125, '[\"81\",\"82\"]', 'SW05', 'Fashion', 1, 300000, 1, '[\"IMG_20250415_161627.png\",\"IMG_20250415_161631.png\",\"IMG_20250415_161636.png\"]', '', '[{\"size\":\"36\",\"stock\":1}]', 120000.00),
(126, '[\"81\",\"82\"]', 'SW06', 'Omitsuka', 1, 300000, 1, '[\"IMG_20250415_161818.png\",\"IMG_20250415_161822.png\",\"IMG_20250415_161831.png\"]', '', '[{\"size\":\"36\",\"stock\":1}]', 150000.00),
(127, '[\"81\",\"82\"]', 'SW07', 'FYER', 1, 300000, 1, '[\"IMG_20250415_161917.png\",\"IMG_20250415_161922.png\",\"IMG_20250415_161929.png\"]', '', '[{\"size\":\"36\",\"stock\":1}]', 120000.00),
(128, '[\"81\",\"82\"]', 'SW08', 'Nike Air Force 1', 1, 335000, 1, '[\"IMG_20250415_162128.png\",\"IMG_20250415_162132.png\",\"IMG_20250415_162137.png\"]', '', '[{\"size\":\"36\",\"stock\":1}]', 150000.00),
(129, '[\"81\",\"82\"]', 'SW09', 'Fashion', 1, 300000, 1, '[\"IMG_20250415_162145.png\",\"IMG_20250415_162149.png\",\"IMG_20250415_162153.png\"]', '', '[{\"size\":\"36\",\"stock\":1}]', 150000.00),
(130, '[\"81\",\"82\"]', 'SW10', 'NIKA', 1, 320000, 1, '[\"IMG_20250415_162341.png\",\"IMG_20250415_162347.png\",\"IMG_20250415_162356.png\"]', '', '[{\"size\":\"36\",\"stock\":1}]', 150000.00),
(131, '[\"81\",\"82\"]', 'SW11', 'Fashion', 1, 300000, 1, '[\"IMG_20250415_162434.png\",\"IMG_20250415_162440.png\",\"IMG_20250415_162445.png\"]', '', '[{\"size\":\"36\",\"stock\":1}]', 150000.00),
(132, '[\"81\",\"82\"]', 'SW12', 'Fashion', 1, 300000, 1, '[\"IMG_20250415_162650.png\",\"IMG_20250415_162656.png\",\"IMG_20250415_162701.png\"]', '', '[{\"size\":\"36\",\"stock\":1}]', 150000.00),
(133, '[\"81\",\"82\"]', 'SW13', 'Fashion', 1, 300000, 1, '[\"IMG_20250415_162832.png\",\"IMG_20250415_162837.png\",\"IMG_20250415_162842.png\"]', '', '[{\"size\":\"37\",\"stock\":1}]', 150000.00),
(134, '[\"81\",\"82\"]', 'SW14', 'ASICS', 1, 350000, 1, '[\"IMG_20250415_162909.png\",\"IMG_20250415_162914.png\",\"IMG_20250415_162918.png\"]', '', '[{\"size\":\"37\",\"stock\":1}]', 150000.00),
(135, '[\"81\",\"82\"]', 'SW15', 'Fashion', 1, 320000, 1, '[\"IMG_20250415_163050.png\",\"IMG_20250415_163055.png\",\"IMG_20250415_163100.png\"]', '', '[{\"size\":\"36\",\"stock\":1}]', 150000.00),
(136, '[\"81\",\"82\"]', 'SW16', 'Fashion', 1, 320000, 1, '[\"IMG_20250415_163107.png\",\"IMG_20250415_163113.png\",\"IMG_20250415_163119.png\"]', '', '[{\"size\":\"36\",\"stock\":1}]', 150000.00),
(137, '[\"81\",\"82\"]', 'SW17', 'AOIDAS', 1, 300000, 1, '[\"IMG_20250415_163206.png\",\"IMG_20250415_163211.png\",\"IMG_20250415_163215.png\"]', '', '[{\"size\":\"36\",\"stock\":1}]', 150000.00);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indexes for table `tbl_banner`
--
ALTER TABLE `tbl_banner`
  ADD PRIMARY KEY (`id_banner`);

--
-- Indexes for table `tbl_detail_order`
--
ALTER TABLE `tbl_detail_order`
  ADD PRIMARY KEY (`id_detail_order`),
  ADD KEY `id_order` (`id_order`),
  ADD KEY `id_produk` (`id_produk`);

--
-- Indexes for table `tbl_detail_order_offline`
--
ALTER TABLE `tbl_detail_order_offline`
  ADD PRIMARY KEY (`id_detail_order`) USING BTREE,
  ADD KEY `id_order` (`id_order`) USING BTREE,
  ADD KEY `id_produk` (`id_produk`) USING BTREE;

--
-- Indexes for table `tbl_kat_produk`
--
ALTER TABLE `tbl_kat_produk`
  ADD PRIMARY KEY (`id_kategori`),
  ADD KEY `parent_id` (`parent_id`);

--
-- Indexes for table `tbl_order`
--
ALTER TABLE `tbl_order`
  ADD PRIMARY KEY (`id_order`),
  ADD KEY `id_pelanggan` (`id_pelanggan`);

--
-- Indexes for table `tbl_order_offline`
--
ALTER TABLE `tbl_order_offline`
  ADD PRIMARY KEY (`id_order`) USING BTREE;

--
-- Indexes for table `tbl_pelanggan`
--
ALTER TABLE `tbl_pelanggan`
  ADD PRIMARY KEY (`id_pelanggan`);

--
-- Indexes for table `tbl_pembayaran`
--
ALTER TABLE `tbl_pembayaran`
  ADD PRIMARY KEY (`id_pembayaran`),
  ADD KEY `id_order2` (`id_order`);

--
-- Indexes for table `tbl_pembayaran_offline`
--
ALTER TABLE `tbl_pembayaran_offline`
  ADD PRIMARY KEY (`id_pembayaran`) USING BTREE,
  ADD KEY `id_order2` (`id_order`) USING BTREE;

--
-- Indexes for table `tbl_produk`
--
ALTER TABLE `tbl_produk`
  ADD PRIMARY KEY (`id_produk`),
  ADD KEY `id_kategori` (`id_kategori`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  MODIFY `id_admin` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_banner`
--
ALTER TABLE `tbl_banner`
  MODIFY `id_banner` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_detail_order`
--
ALTER TABLE `tbl_detail_order`
  MODIFY `id_detail_order` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tbl_detail_order_offline`
--
ALTER TABLE `tbl_detail_order_offline`
  MODIFY `id_detail_order` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_kat_produk`
--
ALTER TABLE `tbl_kat_produk`
  MODIFY `id_kategori` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- AUTO_INCREMENT for table `tbl_order`
--
ALTER TABLE `tbl_order`
  MODIFY `id_order` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `tbl_order_offline`
--
ALTER TABLE `tbl_order_offline`
  MODIFY `id_order` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_pelanggan`
--
ALTER TABLE `tbl_pelanggan`
  MODIFY `id_pelanggan` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `tbl_pembayaran`
--
ALTER TABLE `tbl_pembayaran`
  MODIFY `id_pembayaran` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tbl_pembayaran_offline`
--
ALTER TABLE `tbl_pembayaran_offline`
  MODIFY `id_pembayaran` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_produk`
--
ALTER TABLE `tbl_produk`
  MODIFY `id_produk` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=138;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_detail_order`
--
ALTER TABLE `tbl_detail_order`
  ADD CONSTRAINT `id_order` FOREIGN KEY (`id_order`) REFERENCES `tbl_order` (`id_order`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `id_produk` FOREIGN KEY (`id_produk`) REFERENCES `tbl_produk` (`id_produk`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `tbl_detail_order_offline`
--
ALTER TABLE `tbl_detail_order_offline`
  ADD CONSTRAINT `tbl_detail_order_offline_ibfk_1` FOREIGN KEY (`id_order`) REFERENCES `tbl_order_offline` (`id_order`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `tbl_detail_order_offline_ibfk_2` FOREIGN KEY (`id_produk`) REFERENCES `tbl_produk` (`id_produk`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `tbl_order`
--
ALTER TABLE `tbl_order`
  ADD CONSTRAINT `id_pelanggan` FOREIGN KEY (`id_pelanggan`) REFERENCES `tbl_pelanggan` (`id_pelanggan`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `tbl_pembayaran`
--
ALTER TABLE `tbl_pembayaran`
  ADD CONSTRAINT `id_order2` FOREIGN KEY (`id_order`) REFERENCES `tbl_order` (`id_order`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
