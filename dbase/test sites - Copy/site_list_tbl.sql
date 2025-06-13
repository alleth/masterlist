-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 13, 2025 at 08:58 AM
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
-- Table structure for table `site_list_tbl`
--

CREATE TABLE `site_list_tbl` (
  `site_id` int(11) NOT NULL,
  `site_code` varchar(11) NOT NULL,
  `site_name` varchar(75) NOT NULL,
  `site_address` varchar(250) NOT NULL,
  `region_id` varchar(11) NOT NULL,
  `office_type` varchar(75) DEFAULT NULL,
  `site_partnership` varchar(75) DEFAULT NULL,
  `office_site_code` int(2) NOT NULL,
  `physical_site_count` int(2) NOT NULL,
  `mv_tx` int(2) NOT NULL,
  `mv_new_tx` int(2) NOT NULL,
  `dl_tx` int(2) NOT NULL,
  `dl_new_tx` int(2) NOT NULL,
  `maidras_tx` int(2) NOT NULL,
  `letas_tx` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `site_list_tbl`
--

INSERT INTO `site_list_tbl` (`site_id`, `site_code`, `site_name`, `site_address`, `region_id`, `office_type`, `site_partnership`, `office_site_code`, `physical_site_count`, `mv_tx`, `mv_new_tx`, `dl_tx`, `dl_new_tx`, `maidras_tx`, `letas_tx`) VALUES
(14, '0120', 'Dagupan DO', 'AB Fernandez West Ave., Dagupan City, Pangasinan', '2', 'District Office', 'Government', 1200122, 2, 1, 0, 0, 0, 0, 0),
(15, '0122', 'Dagupan LC', 'AB Fernandez West Ave., Dagupan City, Pangasinan', '2', 'Licensing Center', 'Government', 1200122, 2, 0, 0, 1, 1, 0, 0),
(24, '0140', 'Urdaneta DO', 'Sta. Maria Norte, Binalonan, Pangasinan', '2', 'District Office', 'Government', 1400142, 2, 1, 0, 0, 0, 0, 0),
(25, '0142', 'Urdaneta LC', 'Sta. Maria Norte, Binalonan, Pangasinan', '2', 'Licensing Center', 'Government', 1400142, 2, 0, 0, 1, 1, 0, 0),
(340, '0701', 'New Registration Unit', 'LTO MVIC, M. Logarta Ave. Subangdaku Mandaue city', '9', 'NRU', 'Government', 701, 1, 0, 1, 0, 0, 0, 0),
(342, '0703', 'MAIDRS - RO7', 'LTO MVIC, M. Logarta Ave. Subangdaku Mandaue city', '9', 'MAIDRS', 'Government', 703, 1, 0, 0, 0, 0, 1, 0),
(348, '0716', 'Cebu City DO', 'Robinson\'s Galleria, Cebu City', '9', 'District Office', 'Proponent', 716, 1, 1, 1, 1, 1, 0, 0),
(358, '0732', 'Mandaue DO', 'City Timesquare 2 Mandaue City, Cebu', '9', 'District Office', 'Proponent', 732, 1, 1, 0, 0, 0, 0, 0),
(359, '0736', 'Mandaue City LC', 'City Timesquare 2 Mandaue City, Cebu', '9', 'Licensing Center', 'Proponent', 736, 1, 0, 0, 1, 1, 0, 0),
(365, '0744', 'Siquijor DO', 'Caipilan, Siquijor, Siquijor', '9', 'District Office', 'Government', 744, 1, 1, 1, 1, 1, 0, 1),
(366, '0748', 'Tagbilaran DO', 'R. Enerio St., Tagbilaran City. Bohol', '9', 'District Office', 'Government', 748, 1, 1, 1, 1, 1, 0, 1),
(367, '0752', 'Toledo DO', 'S. Osmeña St., Poblacion, Toledo City', '9', 'District Office', 'Government', 752, 1, 1, 1, 1, 1, 0, 1),
(373, '0800', 'Regional Office ', 'Government Center, Barangay Candahug, Palo, Leyte', '10', 'Regional Office', 'Government', 800, 1, 0, 0, 0, 0, 1, 1),
(374, '0801', 'New Registration Unit', 'Government Center, Barangay Candahug, Palo, Leyte', '10', 'NRU', 'Government', 801, 1, 0, 1, 0, 0, 0, 0),
(375, '0802', 'Baybay DO', 'Government Center Magsaysay Ave., Zone 23, Baybay City, Leyte', '10', 'District Office', 'Government', 802, 1, 1, 1, 1, 1, 1, 1),
(376, '0804', 'Borongan DO', 'Brgy. Bato, Borongan, Eastern Samar ', '10', 'District Office', 'Government', 804, 1, 1, 1, 1, 1, 0, 1),
(386, '0832', 'Ormoc DO', 'Anubing St., Brgy Cogon, Ormoc City, Leyte', '10', 'District Office', 'Government', 832, 1, 1, 1, 1, 1, 1, 1),
(389, '0840', 'San Juan DO', 'Carillo St., San Juan, Southern Leyte', '10', 'District Office', 'Government', 840, 1, 1, 0, 1, 1, 0, 1),
(391, '0844', 'Tacloban DO', 'Old Army Road, Tacloban City, Leyte', '10', 'District Office', 'Government', 844, 1, 1, 0, 0, 0, 0, 0),
(392, '0846', 'Tacloban EO', 'Old Army Road, Tacloban City, Leyte', '10', 'Extension Office', 'Government', 841, 1, 1, 0, 0, 0, 0, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `site_list_tbl`
--
ALTER TABLE `site_list_tbl`
  ADD PRIMARY KEY (`site_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `site_list_tbl`
--
ALTER TABLE `site_list_tbl`
  MODIFY `site_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1074;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
