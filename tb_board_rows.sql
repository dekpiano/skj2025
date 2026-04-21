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
-- Table structure for table `tb_board_rows`
--

CREATE TABLE `tb_board_rows` (
  `row_id` int(11) UNSIGNED NOT NULL,
  `row_title` varchar(255) DEFAULT NULL,
  `row_cols` int(11) NOT NULL DEFAULT 1,
  `row_sort` int(11) NOT NULL DEFAULT 0,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `tb_board_rows`
--

INSERT INTO `tb_board_rows` (`row_id`, `row_title`, `row_cols`, `row_sort`, `created_at`, `updated_at`) VALUES
(1, 'แถว 1', 1, 0, '2026-04-20 16:24:11', '2026-04-20 16:24:33'),
(2, 'แถว 2', 4, 0, '2026-04-20 16:25:52', '2026-04-20 16:25:52');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_board_rows`
--
ALTER TABLE `tb_board_rows`
  ADD PRIMARY KEY (`row_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_board_rows`
--
ALTER TABLE `tb_board_rows`
  MODIFY `row_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
