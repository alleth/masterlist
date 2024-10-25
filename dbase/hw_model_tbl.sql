-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 25, 2024 at 07:32 AM
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
-- Table structure for table `hw_model_tbl`
--

CREATE TABLE `hw_model_tbl` (
  `hw_model_id` int(11) NOT NULL,
  `hw_model_name` varchar(25) NOT NULL,
  `hw_brand_id` varchar(35) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hw_model_tbl`
--

INSERT INTO `hw_model_tbl` (`hw_model_id`, `hw_model_name`, `hw_brand_id`) VALUES
(1, 'PRODESK', '1'),
(2, 'G9', '1'),
(3, 'Pro3000', '1'),
(4, 'Elitedesk', '1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `hw_model_tbl`
--
ALTER TABLE `hw_model_tbl`
  ADD PRIMARY KEY (`hw_model_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `hw_model_tbl`
--
ALTER TABLE `hw_model_tbl`
  MODIFY `hw_model_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
