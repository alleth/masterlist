-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 29, 2025 at 11:03 AM
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
-- Table structure for table `item_brand`
--

CREATE TABLE `item_brand` (
  `id` int(11) NOT NULL,
  `item_desc` varchar(25) NOT NULL,
  `brand` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `item_brand`
--

INSERT INTO `item_brand` (`id`, `item_desc`, `brand`) VALUES
(2, 'CPU-PC', 'HP'),
(3, 'CPU-PC', 'Dell'),
(4, 'CPU-Server', 'HP'),
(5, 'CPU-Server', 'IBM'),
(6, 'CPU-Server', 'Lenovo'),
(7, 'CPU-Server', 'Xitrix'),
(8, 'Monitor-LCD', 'HP'),
(9, 'Monitor-LCD', 'Phillips'),
(10, 'UPS-PC', 'Eaton'),
(11, 'UPS-PC', 'Powerware'),
(12, 'UPS-PC', 'Powercom'),
(13, 'Keyboard', 'HP'),
(14, 'Keyboard', 'A4Tech'),
(15, 'Mouse', 'HP'),
(16, 'Mouse', 'A4Tech'),
(17, 'UPS-Server', 'Leibert'),
(18, 'UPS-Server', 'Powerware'),
(19, 'UPS-Server', 'Powercom'),
(20, 'Printer-LaserJet', 'HP'),
(21, 'Printer-LaserJet', 'Samsung'),
(22, 'Printer-InkJet', 'Epson'),
(23, 'Printer-Dotmatrix', 'Epson'),
(24, 'SDWAN', 'Fortinet'),
(25, 'Webcam', 'Logitech'),
(26, 'Sigpad', 'Wacom'),
(27, 'Switch', 'Cisco'),
(28, 'Data Cabinet', 'N/A'),
(29, 'Table', 'N/A'),
(30, 'Router', 'Cisco'),
(47, 'Switch', 'Alcatel'),
(48, 'Switch', 'D-Link'),
(49, 'Switch', 'TP Link');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `item_brand`
--
ALTER TABLE `item_brand`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `item_brand`
--
ALTER TABLE `item_brand`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
