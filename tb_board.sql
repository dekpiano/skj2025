-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: db
-- Generation Time: Apr 21, 2026 at 04:27 AM
-- Server version: 10.6.25-MariaDB-ubu2204
-- PHP Version: 8.3.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `skjacth_personnel`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_board`
--

CREATE TABLE `tb_board` (
  `board_id` int(11) UNSIGNED NOT NULL,
  `row_id` int(11) UNSIGNED DEFAULT NULL,
  `board_prefix` varchar(50) DEFAULT NULL,
  `board_firstname` varchar(100) NOT NULL,
  `board_lastname` varchar(100) NOT NULL,
  `board_position` varchar(100) NOT NULL,
  `board_type` varchar(100) NOT NULL,
  `board_img` varchar(255) DEFAULT NULL,
  `board_sort` int(11) NOT NULL DEFAULT 0,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `tb_board`
--

INSERT INTO `tb_board` (`board_id`, `row_id`, `board_prefix`, `board_firstname`, `board_lastname`, `board_position`, `board_type`, `board_img`, `board_sort`, `created_at`, `updated_at`) VALUES
(1, 1, 'นาย', 'วชิร', 'วิทย์', 'ประธานฝ่ายสงฆ์', '', '1776676425_d95945cfa1a86b6ff9be.png', 0, '2026-04-20 16:13:45', '2026-04-20 17:54:32'),
(2, 2, 'นาง', 'มาสิ', 'มา', 'ประธานฝ่ายสงฆ์', '', '1776677136_f1c550183540218ec5f5.png', 0, '2026-04-20 16:25:36', '2026-04-20 17:54:46');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_board`
--
ALTER TABLE `tb_board`
  ADD PRIMARY KEY (`board_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_board`
--
ALTER TABLE `tb_board`
  MODIFY `board_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
