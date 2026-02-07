-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Feb 22, 2025 at 05:51 AM
-- Server version: 8.0.41-0ubuntu0.22.04.1
-- PHP Version: 8.3.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ukk_perpus`
--

-- --------------------------------------------------------

--
-- Table structure for table `buku`
--

CREATE TABLE `buku` (
  `id_buku` int NOT NULL,
  `id_kategori` int DEFAULT NULL,
  `judul` varchar(255) DEFAULT NULL,
  `penulis` varchar(255) DEFAULT NULL,
  `penerbit` varchar(255) DEFAULT NULL,
  `tahun_terbit` varchar(255) DEFAULT NULL,
  `deskripsi` text,
  `stok` int NOT NULL,
  `gambar` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `buku`
--

INSERT INTO `buku` (`id_buku`, `id_kategori`, `judul`, `penulis`, `penerbit`, `tahun_terbit`, `deskripsi`, `stok`, `gambar`) VALUES
(1, 2, 'Rat', 'Kosnadi', 'Riski', '2024', 'TEKOS TEKOS TEKOS', 4, '1739415949_akek.png'),
(17, NULL, 'tes', 'gakro', 'afdgfdg', '21564654', 'afsadfhgjhbhjdbajhsfdv', 2, '1740198675_298032c0dbc3262f169f7e4a9f253ddf.jpg'),
(18, NULL, 'tester', 'brembo', 'cep', '2028', 'ajdhbjkbfgbejhfbwe', 1, 'eae1b85dd9317bb67a65401439917460.jpg'),
(19, NULL, 'Apakah agama itu nyata', 'Hakim setengah pusing', 'Cep sakit hati', '2026', 'akhfjkehjkfbnbjkbsdf', 1, 'ZeroTwo.jpeg'),
(20, NULL, 'Choco Cep', 'Cepto', 'Cak kus', '2027', 'hasjhjhbfdhjbfhjesedfjkhjkenbjfkbjhbfdhjbchdsbfjhbejhdbfchjbehjbjhcdbhujgfdbvhjbhjsdbfegbhjfbewhgfgbhbgjkvsfgjkseajngfkjnsg', 1, '1733230147763.jpg'),
(21, NULL, 'Hakim sang guru mengaji', 'Arsanul hakim', 'Los santoss', '2024', 'jkhsdkbjawkbdkjbwekjbnjkbndjhkabjhbfef', 1, ''),
(22, NULL, 'Cak kos sang ahli kungfu', 'Ujang', 'Brembo', '2021', 'ajhgbjhajhsgdbwegyhgvhdsjvfhevbhvfbahjvsbduyhawggeyuhfghvjbsdf', 8, ''),
(23, NULL, 'Kemiri the banteng', 'Erik', 'Goper', '2026', 'jhgfjhwgesutrfgsjhgfjhsgedfcuygserfguweygsfuybhsfvjkhsdfbgjhvbb', 2, ''),
(24, NULL, 'Cep go to white', 'Cepto', 'Cep sakit hati', '2020', 'ajbsdjbajhdbfhebfjhbjhbauhwhajbjhbdhjsbfhjbdsjhfgbwbefhjbdhjgfcagbhjsfdbhjdfjhcvejhwfvewvfhjv', 3, ''),
(25, NULL, 'karep e', 'aku dewe', 'jauh', '2004', 'krpmu ws', 10, '1734144930286.png');

-- --------------------------------------------------------

--
-- Table structure for table `buku_kategori`
--

CREATE TABLE `buku_kategori` (
  `id_buku` int NOT NULL,
  `id_kategori` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `buku_kategori`
--

INSERT INTO `buku_kategori` (`id_buku`, `id_kategori`) VALUES
(1, 2),
(17, 2),
(18, 2),
(22, 2),
(17, 4),
(18, 4),
(21, 4),
(25, 4),
(1, 5),
(18, 5),
(24, 5),
(17, 6),
(19, 6),
(25, 6),
(23, 7);

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id_kategori` int NOT NULL,
  `kategori` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id_kategori`, `kategori`) VALUES
(2, 'Tekoss'),
(4, 'Letong'),
(5, 'Cepto'),
(6, 'Agama'),
(7, 'Kemiri');

-- --------------------------------------------------------

--
-- Table structure for table `peminjaman`
--

CREATE TABLE `peminjaman` (
  `id_peminjaman` int NOT NULL,
  `id_user` int DEFAULT NULL,
  `id_buku` int DEFAULT NULL,
  `tanggal_peminjaman` varchar(255) DEFAULT NULL,
  `tanggal_pengembalian` varchar(255) DEFAULT NULL,
  `status_peminjaman` enum('dipinjam','dikembalikan') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `peminjaman`
--

INSERT INTO `peminjaman` (`id_peminjaman`, `id_user`, `id_buku`, `tanggal_peminjaman`, `tanggal_pengembalian`, `status_peminjaman`) VALUES
(1, 5, 1, '2025-02-09', '2025-02-26', 'dikembalikan'),
(2, 5, 1, '2025-02-09', '2025-02-13', 'dikembalikan'),
(7, 5, 1, '2025-02-13', '2025-02-19', 'dikembalikan'),
(8, 5, 1, '', '', 'dikembalikan'),
(9, 8, 1, '', '', 'dikembalikan'),
(19, 5, 1, '2025-02-13', '2025-02-20', 'dikembalikan'),
(20, 5, 1, '2025-02-13', '2025-02-20', 'dipinjam'),
(21, 5, 17, '2025-02-19', '2025-02-26', 'dikembalikan'),
(22, 5, 17, '2025-02-22', '2025-03-01', 'dipinjam');

-- --------------------------------------------------------

--
-- Table structure for table `ulasan`
--

CREATE TABLE `ulasan` (
  `id_ulasan` int NOT NULL,
  `id_user` int DEFAULT NULL,
  `id_buku` int DEFAULT NULL,
  `ulasan` text,
  `rating` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `ulasan`
--

INSERT INTO `ulasan` (`id_ulasan`, `id_user`, `id_buku`, `ulasan`, `rating`) VALUES
(1, 2, 1, 'Nggateli', 1),
(3, 2, 1, 'bagus', 1),
(8, 5, 18, 'mbotok', 1),
(9, 5, 18, 'elek', 4);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int NOT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `alamat` text,
  `no_telepon` varchar(255) DEFAULT NULL,
  `level` enum('admin','petugas','peminjam') DEFAULT NULL,
  `created_at` varchar(255) NOT NULL,
  `status` enum('aktif','banned') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `nama`, `username`, `password`, `email`, `alamat`, `no_telepon`, `level`, `created_at`, `status`) VALUES
(2, 'administrator', 'admin', 'admin123', 'admin@gmail.com', 'mbergentong', '08774152', 'admin', '2025-02-19 22:08:19', 'aktif'),
(5, 'first user', 'user', '12345', 'akekgans@gmail.com', 'nggodong - madura', '0851213454', 'peminjam', '2025-02-19 22:08:19', 'aktif'),
(6, 'rafli wahyu', 'akekgans', '12345678', 'akekchan@gmail.com', 'mbergentong', '0852147963', 'petugas', '', 'aktif'),
(8, 'adi', 'adi', 'Adijuwono1', 'adi@gmail.com', 'karangjati', '1234578910', 'peminjam', '', 'aktif'),
(10, 'akek ganteng', 'akek', '12345678', 'akek@gmail.com', 'mbersari', '1234568790', 'peminjam', '2025-02-19 22:08:19', 'aktif');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `buku`
--
ALTER TABLE `buku`
  ADD PRIMARY KEY (`id_buku`),
  ADD KEY `buku_id_kategori_IDX` (`id_kategori`) USING BTREE;

--
-- Indexes for table `buku_kategori`
--
ALTER TABLE `buku_kategori`
  ADD PRIMARY KEY (`id_buku`,`id_kategori`),
  ADD KEY `id_kategori` (`id_kategori`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indexes for table `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD PRIMARY KEY (`id_peminjaman`),
  ADD KEY `peminjaman_id_user_IDX` (`id_user`,`id_buku`) USING BTREE,
  ADD KEY `id_buku` (`id_buku`);

--
-- Indexes for table `ulasan`
--
ALTER TABLE `ulasan`
  ADD PRIMARY KEY (`id_ulasan`),
  ADD KEY `ulasan_id_user_IDX` (`id_user`,`id_buku`) USING BTREE,
  ADD KEY `id_user` (`id_user`,`id_buku`),
  ADD KEY `id_buku` (`id_buku`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `buku`
--
ALTER TABLE `buku`
  MODIFY `id_buku` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id_kategori` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `peminjaman`
--
ALTER TABLE `peminjaman`
  MODIFY `id_peminjaman` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `ulasan`
--
ALTER TABLE `ulasan`
  MODIFY `id_ulasan` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `buku`
--
ALTER TABLE `buku`
  ADD CONSTRAINT `buku_ibfk_1` FOREIGN KEY (`id_kategori`) REFERENCES `kategori` (`id_kategori`);

--
-- Constraints for table `buku_kategori`
--
ALTER TABLE `buku_kategori`
  ADD CONSTRAINT `buku_kategori_ibfk_1` FOREIGN KEY (`id_buku`) REFERENCES `buku` (`id_buku`) ON DELETE CASCADE,
  ADD CONSTRAINT `buku_kategori_ibfk_2` FOREIGN KEY (`id_kategori`) REFERENCES `kategori` (`id_kategori`) ON DELETE CASCADE;

--
-- Constraints for table `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD CONSTRAINT `peminjaman_ibfk_1` FOREIGN KEY (`id_buku`) REFERENCES `buku` (`id_buku`),
  ADD CONSTRAINT `peminjaman_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`);

--
-- Constraints for table `ulasan`
--
ALTER TABLE `ulasan`
  ADD CONSTRAINT `ulasan_ibfk_2` FOREIGN KEY (`id_buku`) REFERENCES `buku` (`id_buku`),
  ADD CONSTRAINT `ulasan_ibfk_3` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
