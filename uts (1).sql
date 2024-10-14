-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 14, 2024 at 07:46 AM
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
-- Database: `tugas`
--

-- --------------------------------------------------------

--
-- Table structure for table `uts`
--

CREATE TABLE `uts` (
  `id` int(11) NOT NULL,
  `nama_game` varchar(50) NOT NULL,
  `berat_game` varchar(50) NOT NULL,
  `harga_game` varchar(50) NOT NULL,
  `tgl_rilis` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `uts`
--

INSERT INTO `uts` (`id`, `nama_game`, `berat_game`, `harga_game`, `tgl_rilis`) VALUES
(12, 'Valorant', '50 GB', 'Free', '2020-06-02'),
(13, 'Dragon Ball Sparking Zero!', '89 GB', 'Rp 699.000', '2024-10-11'),
(14, 'Genshin Impact', '130 GB', 'Free', '2020-09-28'),
(15, 'Grand Theft Auto V', '120 GB', 'Rp 300.750', '2013-09-17'),
(16, 'Silent Hill 2', '50 GB', 'Rp 937.000', '2024-10-08'),
(17, 'Core Keeper', '2 GB', 'Rp 165.999', '2024-08-27'),
(18, 'Counter-Strike 2', '35 GB', 'Free', '2023-09-27'),
(19, 'Call of Duty®: Warzone™', '125 GB', 'Free', '2022-11-17'),
(20, 'Dota 2', '60 GB', 'Free', '2013-07-10');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `uts`
--
ALTER TABLE `uts`
  ADD PRIMARY KEY (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
