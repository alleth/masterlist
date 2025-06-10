-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 10, 2025 at 07:39 AM
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
-- Database: `hw_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `user_tbl`
--

CREATE TABLE `user_tbl` (
  `id` int(11) NOT NULL,
  `fname` varchar(25) DEFAULT NULL,
  `lname` varchar(25) DEFAULT NULL,
  `region_assigned` varchar(35) DEFAULT NULL,
  `user_type` varchar(25) DEFAULT NULL,
  `cluster_name` varchar(45) DEFAULT NULL,
  `user_name` varchar(25) DEFAULT NULL,
  `user_pass` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_tbl`
--

INSERT INTO `user_tbl` (`id`, `fname`, `lname`, `region_assigned`, `user_type`, `cluster_name`, `user_name`, `user_pass`) VALUES
(1, 'The', 'Administrator', 'All', 'ADM', 'All', 'admin', 'admin'),
(57, 'Alleth Rey', 'Dazo', '9', 'FSE', 'VisMin', 'amdazo', '$2y$10$Z0iDvXu04fW4LsgOaO3j4unFVTOKGybhkmf8Xh7suG4ZoJubIHP3q'),
(58, 'Edward Chris', 'Avila', '10', 'FSE', 'VisMin', 'ebavila', '$2y$10$qZSgMJzGbkF6YKcY/19Ec.B7Ok128DeIlhe1ZJ6huDao5SIe7B8Fy'),
(59, 'Dina', 'Naliligo', '2', 'FSE', 'Luzon', 'dindin', '$2y$10$Sx7JS15Cfbza3A.WgDwaQenE4AzjrZ9NjtQU8JRvwWHdhB..E1AEC'),
(60, 'Pedro', 'Penduko', '9', 'SPV', 'VisMin', 'penpen', '$2y$10$QA3U74RGTDQ21.ien/CAMueExmVjTzpMUsUzsVQrh.F/3X1XjFgmO');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `user_tbl`
--
ALTER TABLE `user_tbl`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `user_tbl`
--
ALTER TABLE `user_tbl`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
