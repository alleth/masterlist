-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 09, 2024 at 06:49 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

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
-- Table structure for table `region_tbl`
--

CREATE TABLE `region_tbl` (
  `region_id` int(11) NOT NULL,
  `region_name` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `region_tbl`
--

INSERT INTO `region_tbl` (`region_id`, `region_name`) VALUES
(1, 'NCR'),
(2, 'Region 1'),
(3, 'Region 2'),
(4, 'Region 3'),
(5, 'Region 4-A'),
(6, 'Region 4-B'),
(7, 'Region 5'),
(8, 'Region 6'),
(9, 'Region 7'),
(10, 'Region 8'),
(11, 'Region 9'),
(12, 'Region 10'),
(13, 'Region 11'),
(14, 'Region 12'),
(15, 'BARMM'),
(16, 'CAR');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `region_tbl`
--
ALTER TABLE `region_tbl`
  ADD PRIMARY KEY (`region_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `region_tbl`
--
ALTER TABLE `region_tbl`
  MODIFY `region_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
