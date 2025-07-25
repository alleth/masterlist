-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 11, 2025 at 10:15 AM
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
  `trxn_catered` varchar(140) DEFAULT NULL,
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

INSERT INTO `site_list_tbl` (`site_id`, `site_code`, `site_name`, `site_address`, `region_id`, `office_type`, `site_partnership`, `trxn_catered`, `physical_site_count`, `mv_tx`, `mv_new_tx`, `dl_tx`, `dl_new_tx`, `maidras_tx`, `letas_tx`) VALUES
(14, '0120', 'Dagupan DO', 'AB Fernandez West Ave., Dagupan City, Pangasinan', '2', 'District Office', 'Government', NULL, 2, 1, 0, 0, 0, 0, 0),
(15, '0122', 'Dagupan LC', 'AB Fernandez West Ave., Dagupan City, Pangasinan', '2', 'Licensing Center', 'Government', NULL, 2, 0, 0, 1, 1, 0, 0),
(24, '0140', 'Urdaneta', 'Sta. Maria Norte, Binalonan, Pangasinan', '2', 'District Office', 'Government', 'MV', 2, 1, 0, 0, 0, 0, 0),
(25, '0142', 'Urdaneta', 'Sta. Maria Norte, Binalonan, Pangasinan', '2', 'Licensing Center', 'Government', 'DL', 2, 0, 0, 1, 1, 0, 0),
(340, '0701', 'New Registration Unit', 'LTO MVIC, M. Logarta Ave. Subangdaku Mandaue city, Cebu', '9', 'NRU', 'Government', 'NRU', 1, 0, 1, 0, 0, 0, 0),
(342, '0703', 'MAIDRS - RO7', 'LTO MVIC, M. Logarta Ave. Subangdaku Mandaue city, Cebu', '9', 'MAIDRS', 'Government', 'MAIDRS', 1, 0, 0, 0, 0, 1, 0),
(348, '0716', 'Cebu City', 'Robinson&#39;s Galleria, Cebu City', '9', 'District Office', 'Proponent', 'MV,DL,NRU', 1, 1, 1, 1, 1, 0, 0),
(358, '0732', 'Mandaue City', 'City Timesquare 2 Mandaue City, Cebu', '9', 'District Office', 'Proponent', 'MV', 1, 1, 0, 0, 0, 0, 0),
(359, '0736', 'Mandaue City', 'City Timesquare 2 Mandaue City, Cebu', '9', 'Licensing Center', 'Proponent', 'DL', 1, 0, 0, 1, 1, 0, 0),
(365, '0744', 'Siquijor', 'Caipilan, Siquijor, Siquijor', '9', 'District Office', 'Government', 'MV,DL,LETAS', 1, 1, 1, 1, 1, 0, 1),
(366, '0748', 'Tagbilaran', 'R. Enerio St., Tagbilaran City. Bohol', '9', 'District Office', 'Government', 'MV,DL,LETAS', 1, 1, 1, 1, 1, 0, 1),
(367, '0752', 'Toledo', 'S. Osmeña St., Poblacion, Toledo City', '9', 'District Office', 'Government', 'MV,DL,LETAS', 1, 1, 1, 1, 1, 0, 1),
(373, '0800', 'Regional Office ', 'Government Center, Barangay Candahug, Palo, Leyte', '10', 'Regional Office', 'Government', 'None', 1, 0, 0, 0, 0, 1, 1),
(374, '0801', 'New Registration Unit', 'Government Center, Barangay Candahug, Palo, Leyte', '10', 'NRU', 'Government', 'NRU', 1, 0, 1, 0, 0, 0, 0),
(375, '0802', 'Baybay', 'Government Center Magsaysay Ave., Zone 23, Baybay City, Leyte', '10', 'District Office', 'Government', 'MV,DL,LETAS', 1, 1, 1, 1, 1, 1, 1),
(376, '0804', 'Borongan DO', 'Brgy. Bato, Borongan, Eastern Samar ', '10', 'District Office', 'Government', NULL, 1, 1, 1, 1, 1, 0, 1),
(386, '0832', 'Ormoc DO', 'Anubing St., Brgy Cogon, Ormoc City, Leyte', '10', 'District Office', 'Government', NULL, 1, 1, 1, 1, 1, 1, 1),
(389, '0840', 'San Juan DO', 'Carillo St., San Juan, Southern Leyte', '10', 'District Office', 'Government', NULL, 1, 1, 0, 1, 1, 0, 1),
(391, '0844', 'Tacloban DO', 'Old Army Road, Tacloban City, Leyte', '10', 'District Office', 'Government', NULL, 1, 1, 0, 0, 0, 0, 0),
(392, '0846', 'Tacloban EO', 'Old Army Road, Tacloban City, Leyte', '10', 'Extension Office', 'Government', NULL, 1, 1, 0, 0, 0, 0, 0),
(1083, '0711', 'Tubigon', 'Tubigon, Bohol', '9', 'Extension Office', 'Proponent', 'MV,DL,LETAS', 0, 0, 0, 0, 0, 0, 0),
(1084, '0762', 'Consolacion', 'SM Consolacion, Consolacion, Cebu', '9', 'Extension Office', 'Proponent', 'MV,DL', 0, 0, 0, 0, 0, 0, 0),
(1085, '0751', 'Talisay', 'Talisay, Cebu', '9', 'Extension Office', 'Proponent', 'MV', 0, 0, 0, 0, 0, 0, 0),
(1086, '0719', 'Talisay', 'Talisay, Cebu', '9', 'Extension Office', 'Proponent', 'DL', 0, 0, 0, 0, 0, 0, 0),
(1087, '0730', 'Jagna', 'Jagna, Bohol', '9', 'District Office', 'Government', 'MV,DL,LETAS', 0, 0, 0, 0, 0, 0, 0),
(1088, '0712', 'Carcar', 'Carcar City, Cebu', '9', 'District Office', 'Government', 'MV,DL,LETAS', 0, 0, 0, 0, 0, 0, 0);

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
  MODIFY `site_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1089;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
