-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 17, 2024 at 07:44 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `keuangan_projek`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `insert_inven` (IN `p_nama` VARCHAR(40), IN `p_harga` INT)   BEGIN
    INSERT INTO inven (nama, harga)
    VALUES (p_nama, p_harga);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insert_sumber` (IN `p_nama` VARCHAR(40), IN `p_harga` INT, IN `p_margin` INT)   BEGIN
    INSERT INTO sumber (nama, harga, margin)
    VALUES (p_nama, p_harga, p_margin);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `update_inven` (IN `p_id_inven` INT, IN `p_nama` VARCHAR(40), IN `p_harga` INT)   BEGIN
    UPDATE inven 
    SET 
        nama = p_nama,
        harga = p_harga
    WHERE id_inven = p_id_inven;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `update_sumber` (IN `p_id_sumber` INT, IN `p_nama` VARCHAR(40), IN `p_harga` INT, IN `p_margin` INT)   BEGIN
    UPDATE sumber 
    SET 
        nama = p_nama,
        harga = p_harga,
        margin = p_margin
    WHERE id_sumber = p_id_sumber;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id_admin` int NOT NULL,
  `nama` varchar(40) NOT NULL,
  `email` varchar(40) NOT NULL,
  `pass` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id_admin`, `nama`, `email`, `pass`) VALUES
(1, 'Andri', 'andri@gmail.com', '123'),
(2, 'riza', 'riza@mail.com', 'tes123');

-- --------------------------------------------------------

--
-- Table structure for table `catatan`
--

CREATE TABLE `catatan` (
  `id_catatan` int NOT NULL,
  `catatan` text NOT NULL,
  `id_admin` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `catatan`
--

INSERT INTO `catatan` (`id_catatan`, `catatan`, `id_admin`) VALUES
(1, 'Besok, Hari minggu akan ada kunjungan dari pihak dinas untuk mengecek kinerja karyawan.', 1),
(2, 'Hari Kamis jam 8 akan ada rapat, diharapkan kepada semua karyawan agar dapat berhadir.', 1),
(3, 'Tingkatkan lagi pendapatan, dan minimalkan pengeluaran', 1),
(4, 'tgl 6 domain dan hosting banyak yang akan expired, dan harus diperpanjang lagi', 2),
(5, 'Harap diperhatikan, stok beberapa barang inventaris sudah mencapai batas minimum (<50). Diharapkan segera dilakukan pengecekan dan pengisian ulang untuk menghindari kekurangan stok.', 2),
(6, 'Mohon kepada tim gudang untuk segera menindaklanjuti pengisian kembali stok yang sudah mencapai batas minim. Stok beberapa barang telah berada di bawah batas yang aman.', 2);

-- --------------------------------------------------------

--
-- Table structure for table `inven`
--

CREATE TABLE `inven` (
  `id_inven` int NOT NULL,
  `nama` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `harga` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `inven`
--

INSERT INTO `inven` (`id_inven`, `nama`, `harga`) VALUES
(6, 'Barang Return', NULL),
(7, 'Bahan Inventaris', 500000),
(10, 'Gaji Karyawan', 500000);

-- --------------------------------------------------------

--
-- Table structure for table `karyawan`
--

CREATE TABLE `karyawan` (
  `id_karyawan` int NOT NULL,
  `nama` varchar(40) NOT NULL,
  `posisi` varchar(40) NOT NULL,
  `alamat` varchar(40) NOT NULL,
  `umur` int NOT NULL,
  `kontak` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `karyawan`
--

INSERT INTO `karyawan` (`id_karyawan`, `nama`, `posisi`, `alamat`, `umur`, `kontak`) VALUES
(1, 'saiful', 'ketua', 'mns.aron', 19, '0888888'),
(6, 'Riza', 'Bendahara', 'Aceh', 19, '08333333333');

-- --------------------------------------------------------

--
-- Table structure for table `pemasukan`
--

CREATE TABLE `pemasukan` (
  `id_pemasukan` int NOT NULL,
  `tgl_pemasukan` date NOT NULL,
  `jml_satuan` int NOT NULL,
  `jumlah` int NOT NULL,
  `HB` int NOT NULL,
  `id_sumber` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pemasukan`
--

INSERT INTO `pemasukan` (`id_pemasukan`, `tgl_pemasukan`, `jml_satuan`, `jumlah`, `HB`, `id_sumber`) VALUES
(84, '2024-10-17', 6, 60000, 30000, 3),
(85, '2024-10-17', 100, 1500000, 500000, 4),
(86, '2024-10-17', 50, 500000, 250000, 3);

--
-- Triggers `pemasukan`
--
DELIMITER $$
CREATE TRIGGER `hitung_HB_sebelum_insert` BEFORE INSERT ON `pemasukan` FOR EACH ROW BEGIN
    -- Mengambil harga dari tabel sumber berdasarkan id_sumber dan menghitung jumlah
    SET NEW.HB = (SELECT hb FROM sumber WHERE id_sumber = NEW.id_sumber) * NEW.jml_satuan;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `hitung_HB_sebelum_update` BEFORE UPDATE ON `pemasukan` FOR EACH ROW BEGIN
    -- Mengambil harga dari tabel sumber berdasarkan id_sumber dan menghitung jumlah
    SET NEW.HB = (SELECT hb FROM sumber WHERE id_sumber = NEW.id_sumber) * NEW.jml_satuan;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `hitung_jumlah_sebelum_insert` BEFORE INSERT ON `pemasukan` FOR EACH ROW BEGIN
    -- Mengambil harga dari tabel sumber berdasarkan id_sumber dan menghitung jumlah
    SET NEW.jumlah = (SELECT harga FROM sumber WHERE id_sumber = NEW.id_sumber) * NEW.jml_satuan;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `hitung_jumlah_sebelum_update` BEFORE UPDATE ON `pemasukan` FOR EACH ROW BEGIN
    -- Mengambil harga dari tabel sumber berdasarkan id_sumber dan menghitung jumlah
    SET NEW.jumlah = (SELECT harga FROM sumber WHERE id_sumber = NEW.id_sumber) * NEW.jml_satuan;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `pengeluaran`
--

CREATE TABLE `pengeluaran` (
  `id_pengeluaran` int NOT NULL,
  `tgl_pengeluaran` date NOT NULL,
  `jml_satuan` int NOT NULL,
  `jumlah` int NOT NULL,
  `id_inven` int NOT NULL,
  `id_sumber` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pengeluaran`
--

INSERT INTO `pengeluaran` (`id_pengeluaran`, `tgl_pengeluaran`, `jml_satuan`, `jumlah`, `id_inven`, `id_sumber`) VALUES
(82, '2024-10-17', 1, 500000, 7, 1),
(83, '2024-10-17', 5, 50000, 6, 11),
(84, '2024-10-17', 3, 1500000, 10, 1),
(85, '2024-10-17', 8, 120000, 6, 4),
(86, '2024-10-17', 5, 50000, 6, 17);

--
-- Triggers `pengeluaran`
--
DELIMITER $$
CREATE TRIGGER `hitung_jumlah_sebelum_insert_keluar` BEFORE INSERT ON `pengeluaran` FOR EACH ROW BEGIN
    DECLARE harga_inven DECIMAL(10, 2);
    DECLARE harga_sumber DECIMAL(10, 2);

    -- Ambil harga dari tabel inven jika id_inven ada
    IF NEW.id_inven IS NOT NULL THEN
        SELECT harga INTO harga_inven 
        FROM inven 
        WHERE id_inven = NEW.id_inven;
    END IF;

    -- Ambil harga dari tabel sumber jika id_sumber ada
    IF NEW.id_sumber IS NOT NULL THEN
        SELECT harga INTO harga_sumber 
        FROM sumber 
        WHERE id_sumber = NEW.id_sumber;
    END IF;

    -- Hitung jumlah berdasarkan harga yang valid
    IF (NEW.id_sumber IS NOT NULL AND harga_sumber IS NOT NULL) THEN
        SET NEW.jumlah = harga_sumber * NEW.jml_satuan;
    ELSEIF (NEW.id_inven IS NOT NULL AND harga_inven IS NOT NULL) THEN
        SET NEW.jumlah = harga_inven * NEW.jml_satuan;
    ELSE
        SET NEW.jumlah = 0; -- atau NULL, tergantung kebutuhan
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `hitung_jumlah_sebelum_update_keluar` BEFORE UPDATE ON `pengeluaran` FOR EACH ROW BEGIN
    DECLARE harga_inven DECIMAL(10, 2);
    DECLARE harga_sumber DECIMAL(10, 2);

    -- Ambil harga dari tabel inven jika id_inven ada
    IF NEW.id_inven IS NOT NULL THEN
        SELECT harga INTO harga_inven 
        FROM inven 
        WHERE id_inven = NEW.id_inven;
    END IF;

    -- Ambil harga dari tabel sumber jika id_sumber ada
    IF NEW.id_sumber IS NOT NULL THEN
        SELECT harga INTO harga_sumber 
        FROM sumber 
        WHERE id_sumber = NEW.id_sumber;
    END IF;

    -- Hitung jumlah berdasarkan harga yang valid
    IF (NEW.id_sumber IS NOT NULL AND harga_sumber IS NOT NULL) THEN
        SET NEW.jumlah = harga_sumber * NEW.jml_satuan;
    ELSEIF (NEW.id_inven IS NOT NULL AND harga_inven IS NOT NULL) THEN
        SET NEW.jumlah = harga_inven * NEW.jml_satuan;
    ELSE
        SET NEW.jumlah = 0; -- atau NULL, tergantung kebutuhan
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `sumber`
--

CREATE TABLE `sumber` (
  `id_sumber` int NOT NULL,
  `nama` varchar(40) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `harga` int DEFAULT NULL,
  `margin` int DEFAULT NULL,
  `hb` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sumber`
--

INSERT INTO `sumber` (`id_sumber`, `nama`, `harga`, `margin`, `hb`) VALUES
(1, NULL, NULL, NULL, NULL),
(2, 'Alpukat Aligator', 10000, 5000, 5000),
(3, 'Alpukat Mentega', 10000, 5000, 5000),
(4, 'Kelengkeng Matalada', 15000, 10000, 5000),
(5, 'Mangga Manalagi', 10000, 5000, 5000),
(10, 'Jeruk Santang', 10000, 5000, 5000),
(17, 'jeruk', 10000, 4000, 6000);

--
-- Triggers `sumber`
--
DELIMITER $$
CREATE TRIGGER `before_insert_sumber` BEFORE INSERT ON `sumber` FOR EACH ROW BEGIN
    -- Hitung harga-baru dan margin-baru untuk insert
    SET NEW.hb = NEW.harga - NEW.margin; -- Hasil pengurangan harga dan margin dimasukkan ke kolom hb
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `before_update_sumber` BEFORE UPDATE ON `sumber` FOR EACH ROW BEGIN
    -- Hitung harga-baru dan margin-baru untuk update
    SET NEW.hb = NEW.harga - NEW.margin; -- Hasil pengurangan harga dan margin dimasukkan ke kolom hb
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `uang`
--

CREATE TABLE `uang` (
  `id_uang` int NOT NULL,
  `tgl_uang` date NOT NULL,
  `id_pengeluaran` int DEFAULT NULL,
  `id_pendapatan` int DEFAULT NULL,
  `jumlah` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `uang`
--

INSERT INTO `uang` (`id_uang`, `tgl_uang`, `id_pengeluaran`, `id_pendapatan`, `jumlah`) VALUES
(1, '2019-10-23', NULL, 1, 500000),
(2, '2019-10-24', 2, NULL, 10000);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indexes for table `catatan`
--
ALTER TABLE `catatan`
  ADD PRIMARY KEY (`id_catatan`),
  ADD KEY `id_admin` (`id_admin`);

--
-- Indexes for table `inven`
--
ALTER TABLE `inven`
  ADD PRIMARY KEY (`id_inven`);

--
-- Indexes for table `karyawan`
--
ALTER TABLE `karyawan`
  ADD PRIMARY KEY (`id_karyawan`);

--
-- Indexes for table `pemasukan`
--
ALTER TABLE `pemasukan`
  ADD PRIMARY KEY (`id_pemasukan`),
  ADD KEY `id_sumber` (`id_sumber`);

--
-- Indexes for table `pengeluaran`
--
ALTER TABLE `pengeluaran`
  ADD PRIMARY KEY (`id_pengeluaran`),
  ADD KEY `id_sumber` (`id_inven`),
  ADD KEY `id_sumber_2` (`id_sumber`);

--
-- Indexes for table `sumber`
--
ALTER TABLE `sumber`
  ADD PRIMARY KEY (`id_sumber`);

--
-- Indexes for table `uang`
--
ALTER TABLE `uang`
  ADD PRIMARY KEY (`id_uang`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `catatan`
--
ALTER TABLE `catatan`
  MODIFY `id_catatan` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `inven`
--
ALTER TABLE `inven`
  MODIFY `id_inven` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `karyawan`
--
ALTER TABLE `karyawan`
  MODIFY `id_karyawan` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `pemasukan`
--
ALTER TABLE `pemasukan`
  MODIFY `id_pemasukan` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;

--
-- AUTO_INCREMENT for table `pengeluaran`
--
ALTER TABLE `pengeluaran`
  MODIFY `id_pengeluaran` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;

--
-- AUTO_INCREMENT for table `sumber`
--
ALTER TABLE `sumber`
  MODIFY `id_sumber` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `uang`
--
ALTER TABLE `uang`
  MODIFY `id_uang` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `catatan`
--
ALTER TABLE `catatan`
  ADD CONSTRAINT `catatan_ibfk_1` FOREIGN KEY (`id_admin`) REFERENCES `admin` (`id_admin`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pemasukan`
--
ALTER TABLE `pemasukan`
  ADD CONSTRAINT `pemasukan_ibfk_1` FOREIGN KEY (`id_sumber`) REFERENCES `sumber` (`id_sumber`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pengeluaran`
--
ALTER TABLE `pengeluaran`
  ADD CONSTRAINT `pengeluaran_ibfk_1` FOREIGN KEY (`id_inven`) REFERENCES `inven` (`id_inven`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
