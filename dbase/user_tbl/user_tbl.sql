-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 26, 2025 at 03:02 AM
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
  `user_pass` varchar(255) DEFAULT NULL,
  `profile_picture` varchar(125) DEFAULT NULL,
  `failed_attempts` int(11) NOT NULL DEFAULT 0,
  `lockout_until` timestamp(1) NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_tbl`
--

INSERT INTO `user_tbl` (`id`, `fname`, `lname`, `region_assigned`, `user_type`, `cluster_name`, `user_name`, `user_pass`, `profile_picture`, `failed_attempts`, `lockout_until`) VALUES
(1, 'Admin', 'Administrator', '0', 'ADM', 'All Cluster', 'admin', '$2y$10$fcoKsvCpivipBwYYpbou7uATGLLilOw2KZ/5DTwfIKa5.0QlrZq/K', 'assets/img/avatar.png', 0, NULL),
(57, 'Alleth Rey', 'Dazo', '9', 'FSE', 'VisMin', 'amdazo', '$2y$10$Dt5UaGWRsQOkauHzbb/.D.H.445wJL1k.QLSEJcZ/ZOXIiQNHimmC', 'assets/img/avatar.png', 0, NULL),
(58, 'Edward Chris', 'Avila', '10', 'FSE', 'VisMin', 'ebavila', '$2y$10$qZSgMJzGbkF6YKcY/19Ec.B7Ok128DeIlhe1ZJ6huDao5SIe7B8Fy', 'assets/img/avatar.png', 0, NULL),
(70, 'Jorell', 'Oliquino', '18', 'SPV', 'VisMin', 'jcoliquino', '$2y$10$Apryev2C9deAeVbCy0YiHu9bRRNsuRDwzKlAZ1IsxWD9iivS0HTh6', 'assets/img/avatar.png', 0, NULL),
(75, 'Hendrick', 'Vicente', '18', 'SPV', 'Luzon', 'hlvicente', '$2y$10$0URxUWqUPA23zxSHDzhd0.ImYHTuE3xJAWJ0D6r9/Moc/XjvzCc0K', 'assets/img/avatar.png', 0, NULL),
(76, 'Albert', 'Loyola', '18', 'SPV', 'NCR', 'aaloyola', '$2y$10$78iwuvKlDvgiRc5sAhCRxOx8Fc0vs5m6yMzDdU5powTi.24ZVohg2', 'assets/img/avatar.png', 0, NULL),
(77, 'Eduard', 'Mulingtapang', '18', 'ADM', 'All Cluster', 'ebmulingtapang', '$2y$10$HhZ8XEuYARkihKS1.DS6mevQ/tBWYUjYJm3oBYzKg2zk6WWQ5vwgW', 'assets/img/avatar.png', 0, NULL),
(79, 'Pedro', 'Penduko', '18', 'SPV', 'NCR', 'penpen', '$2y$10$H.95dzRkHy8XXCQd/bW06OXsNdorOCS4Kt94YWHaFKbX04Wml2rg6', 'assets/img/avatar.png', 0, NULL);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
