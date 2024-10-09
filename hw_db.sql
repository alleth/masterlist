-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 08, 2024 at 09:50 AM
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
-- Table structure for table `hw_tbl`
--

CREATE TABLE `hw_tbl` (
  `hw_id` int(11) NOT NULL,
  `region_name` varchar(25) NOT NULL,
  `site_code` varchar(11) NOT NULL,
  `site_name` varchar(25) NOT NULL,
  `hw_brand_name` varchar(25) NOT NULL,
  `hw_model` varchar(25) NOT NULL,
  `hw_asset_num` int(11) NOT NULL,
  `hw_serial_num` varchar(30) NOT NULL,
  `hw_month_acq` varchar(25) NOT NULL,
  `hw_day_acq` varchar(11) NOT NULL,
  `hw_year_acq` int(11) NOT NULL,
  `hw_status` varchar(25) NOT NULL,
  `hw_host_name` varchar(35) NOT NULL,
  `hw_ip_add` varchar(35) NOT NULL,
  `hw_mac_add` varchar(35) NOT NULL,
  `hw_user_name` varchar(35) NOT NULL,
  `hw_primary_role` varchar(50) NOT NULL,
  `hw_acq_val` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hw_tbl`
--

INSERT INTO `hw_tbl` (`hw_id`, `region_name`, `site_code`, `site_name`, `hw_brand_name`, `hw_model`, `hw_asset_num`, `hw_serial_num`, `hw_month_acq`, `hw_day_acq`, `hw_year_acq`, `hw_status`, `hw_host_name`, `hw_ip_add`, `hw_mac_add`, `hw_user_name`, `hw_primary_role`, `hw_acq_val`) VALUES
(1, 'Region 7', '0732', 'Mandaue DO', 'HP', 'PRODESK', 123456, 'ABCDE12345', '03', '15', 2022, 'ON SITE', '0732W0001_1', '10.7.32.71', '18-60-24-DF-8A-17', 'Arjay P. Enecillo', 'Evaluator', '43,650.00'),
(2, 'Region 7', '0732', 'Mandaue DO', 'HP', 'G9', 54321, 'EDCBA54321', '05', '01', 2024, 'DEFFECTIVE', '0732_W001_2', '10.7.32.72', '18-60-24-DF-8A-18', 'Lea Villaceran', 'Site Support', '56,995.00');

-- --------------------------------------------------------

--
-- Table structure for table `user_tbl`
--

CREATE TABLE `user_tbl` (
  `id` int(11) NOT NULL,
  `fname` varchar(25) DEFAULT NULL,
  `lname` varchar(25) DEFAULT NULL,
  `user_type` varchar(25) DEFAULT NULL,
  `user_name` varchar(25) DEFAULT NULL,
  `user_pass` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_tbl`
--

INSERT INTO `user_tbl` (`id`, `fname`, `lname`, `user_type`, `user_name`, `user_pass`) VALUES
(1, 'Administrator', 'Administrator', 'Administrator', 'admin', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `hw_tbl`
--
ALTER TABLE `hw_tbl`
  ADD PRIMARY KEY (`hw_id`);

--
-- Indexes for table `user_tbl`
--
ALTER TABLE `user_tbl`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `hw_tbl`
--
ALTER TABLE `hw_tbl`
  MODIFY `hw_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user_tbl`
--
ALTER TABLE `user_tbl`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
