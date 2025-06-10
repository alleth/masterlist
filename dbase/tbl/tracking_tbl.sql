-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 10, 2025 at 02:53 PM
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
-- Table structure for table `tracking_tbl`
--

CREATE TABLE `tracking_tbl` (
  `tracking_id` int(11) NOT NULL,
  `trxn_date` varchar(55) DEFAULT NULL,
  `tracking_num` varchar(12) DEFAULT NULL,
  `site_code` varchar(11) DEFAULT NULL,
  `hw_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `pullout_date` varchar(45) DEFAULT NULL,
  `pullout_status` varchar(75) DEFAULT NULL,
  `request_type` varchar(45) DEFAULT NULL,
  `cluster_name` varchar(45) DEFAULT NULL,
  `request_status` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tracking_tbl`
--

INSERT INTO `tracking_tbl` (`tracking_id`, `trxn_date`, `tracking_num`, `site_code`, `hw_id`, `user_id`, `pullout_date`, `pullout_status`, `request_type`, `cluster_name`, `request_status`) VALUES
(8, '2025-04-11 11:26:30', '123456789102', '0700', 6737, 52, '04/10/2025', 'Declined', 'Pull out', 'VisMin', 0),
(12, '2025-04-13 16:25:50', '123456789010', '0748', 11647, 22, '04/04/2025', 'Declined', 'Pull out', 'VisMin', 0),
(15, '2025-04-19 22:30:28', '123456789101', '0748', 11647, 22, '03/27/2025', 'Received', 'Pull out', 'VisMin', 0),
(16, '2025-05-28 15:11:32', '012345678910', '0700', 6737, 57, '05/01/2025', 'Received', 'Pull out', 'VisMin', 0),
(17, '2025-06-04 21:47:49', '123456789011', '0700', 6738, 57, '06/05/2025', 'Received', 'Pull out', 'VisMin', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tracking_tbl`
--
ALTER TABLE `tracking_tbl`
  ADD PRIMARY KEY (`tracking_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tracking_tbl`
--
ALTER TABLE `tracking_tbl`
  MODIFY `tracking_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
