-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: db
-- Generation Time: Mar 09, 2026 at 08:47 AM
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
-- Database: `skjacth_academic`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_teacher_evaluation`
--

CREATE TABLE `tb_teacher_evaluation` (
  `eva_id` int(11) NOT NULL,
  `eva_teacher_id` varchar(20) NOT NULL,
  `eva_year` varchar(4) NOT NULL COMMENT 'ปีงบประมาณ เช่น 2569',
  `eva_round` int(1) NOT NULL COMMENT 'รอบที่ 1 หรือ 2',
  `eva_file` text DEFAULT NULL COMMENT 'ชื่อไฟล์ PDF',
  `eva_canva_link` text DEFAULT NULL,
  `eva_status` varchar(50) DEFAULT 'ส่งแล้ว',
  `eva_comment` text DEFAULT NULL,
  `eva_created_at` datetime DEFAULT current_timestamp(),
  `eva_updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `tb_teacher_evaluation`
--

INSERT INTO `tb_teacher_evaluation` (`eva_id`, `eva_teacher_id`, `eva_year`, `eva_round`, `eva_file`, `eva_canva_link`, `eva_status`, `eva_comment`, `eva_created_at`, `eva_updated_at`) VALUES
(1, 'pers_021', '2569', 1, 'PA_2569_1_pers_021_1773032830.pdf', 'https://www.canva.com/design/DAG_k3OjzqE/X67bfIvem1C5ZgaadZnfQA/view?utm_content=DAG_k3OjzqE&utm_campaign=designshare&utm_medium=link2&utm_source=uniquelinks&utlId=h6e715491a3', 'ส่งแล้ว', NULL, '2026-03-09 05:06:07', '2026-03-09 08:43:48');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_teacher_evaluation`
--
ALTER TABLE `tb_teacher_evaluation`
  ADD PRIMARY KEY (`eva_id`),
  ADD KEY `idx_teacher_year_round` (`eva_teacher_id`,`eva_year`,`eva_round`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_teacher_evaluation`
--
ALTER TABLE `tb_teacher_evaluation`
  MODIFY `eva_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
