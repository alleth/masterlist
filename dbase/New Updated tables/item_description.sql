-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 01, 2025 at 05:14 AM
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
-- Table structure for table `item_description`
--

CREATE TABLE `item_description` (
  `item_id` int(11) NOT NULL,
  `item_desc` varchar(25) NOT NULL,
  `sub_major_type` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `item_description`
--

INSERT INTO `item_description` (`item_id`, `item_desc`, `sub_major_type`) VALUES
(1, 'CPU-PC', 'CPU'),
(2, 'CPU-Server', 'Server'),
(3, 'Monitor-LCD', 'Monitor'),
(4, 'UPS-PC', 'UPS'),
(5, 'Keyboard', 'Other Peripherals'),
(6, 'Mouse', 'Other Peripherals'),
(8, 'UPS-Server', 'UPS'),
(9, 'LaserJet', 'Printer'),
(10, 'InkJet', 'Printer'),
(13, 'Dotmatrix', 'Printer'),
(14, 'SDWAN', 'Network Equipment'),
(15, 'Webcam', 'Other Peripherals'),
(16, 'Sigpad', 'Other Peripherals'),
(17, 'Switch', 'Network Equipment'),
(18, 'Data Cabinet', 'Network Equipment'),
(19, 'Table', 'Furniture and Fixture'),
(20, 'Router', 'Network Equipment');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `item_description`
--
ALTER TABLE `item_description`
  ADD PRIMARY KEY (`item_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `item_description`
--
ALTER TABLE `item_description`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
