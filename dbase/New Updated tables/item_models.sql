-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 29, 2025 at 11:04 AM
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
-- Table structure for table `item_models`
--

CREATE TABLE `item_models` (
  `id` int(11) NOT NULL,
  `item_desc` varchar(25) NOT NULL,
  `brand` varchar(25) NOT NULL,
  `model` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `item_models`
--

INSERT INTO `item_models` (`id`, `item_desc`, `brand`, `model`) VALUES
(1, 'CPU-PC', 'HP', 'DX2710'),
(2, 'CPU-PC', 'HP', 'DX2810'),
(3, 'CPU-PC', 'HP', 'Prodesk G9'),
(4, 'CPU-PC', 'HP', 'Prodesk G4'),
(5, 'CPU-PC', 'HP', 'Elitedesk G7'),
(6, 'CPU-Server', 'HP', 'ML110 Gen10'),
(7, 'CPU-Server', 'HP', 'ML110 Gen9'),
(8, 'CPU-Server', 'IBM', 'X3200'),
(9, 'Monitor-LCD', 'HP', '19.5\"'),
(10, 'Monitor-LCD', 'HP', '19\"'),
(11, 'Keyboard', 'HP', 'N/A'),
(12, 'Mouse', 'N/A', 'N/A'),
(13, 'Printer-InkJet', 'Epson', 'L310'),
(14, 'Printer-Dotmatrix', 'Epson', 'LX310'),
(15, 'Printer-LaserJet', 'HP', 'M507n'),
(16, 'Printer-LaserJet', 'HP', '4003dn'),
(17, 'Printer-LaserJet', 'HP', 'M401'),
(18, 'Printer-LaserJet', 'HP', 'M402'),
(19, 'Printer-LaserJet', 'HP', '2015'),
(20, 'Printer-LaserJet', 'HP', '4100'),
(21, 'Switch', 'Cisco', 'Catalyst 2960'),
(22, 'Switch', 'Cisco', 'Catalyst 2924'),
(23, 'CPU-PC', 'Others', 'Others'),
(24, 'Data Cabinet', 'N/A', 'N/A'),
(25, 'SDWAN', 'Fortinet', '40F'),
(26, 'Webcam', 'Logitec', 'C922'),
(27, 'Router', 'CIsco', 'C1111'),
(28, 'SDWAN', 'Fortinet', '60F'),
(29, 'Test-Data', 'Test-Data', 'Test-Data'),
(30, 'Sigpad', 'Wacom', 'STU-430'),
(31, 'Table', 'N/A', 'N/A'),
(33, 'Webcam', 'Logitech', 'C920'),
(34, 'CPU-PC', 'HP', 'Pro 3000'),
(35, 'CPU-PC', 'Dell', 'OptiPlex 380'),
(36, 'CPU-Server', 'Xitrix', 'Powerframe 2960'),
(37, 'Switch', 'Cisco', 'SG350-28'),
(38, 'Switch', 'Cisco', 'CBS350-24T'),
(41, 'Switch', 'Cisco', '1800 Series'),
(42, 'Switch', 'Cisco', '1900 Series'),
(43, 'Switch', 'Cisco', 'Catalyst 2900'),
(44, 'Switch', 'Cisco', 'Catalyst 2950'),
(45, 'Switch', 'Alcatel', 'OS6450-P24L'),
(46, 'Switch', 'D-Link', 'DES-1008A'),
(47, 'Switch', 'D-Link', 'DGS-1016C'),
(48, 'SDWAN', 'Fortinet', '100F'),
(49, 'Data Cabinet', 'N/A', 'N/A'),
(50, 'Table', 'N/A', 'N/A');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `item_models`
--
ALTER TABLE `item_models`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `item_models`
--
ALTER TABLE `item_models`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
