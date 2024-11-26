-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 26, 2024 at 05:04 AM
-- Server version: 10.4.28-MariaDB
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
-- Table structure for table `hw_brand_tbl`
--

CREATE TABLE `hw_brand_tbl` (
  `hw_brand_id` int(11) NOT NULL,
  `hw_brand_name` varchar(25) NOT NULL,
  `hw_type` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hw_brand_tbl`
--

INSERT INTO `hw_brand_tbl` (`hw_brand_id`, `hw_brand_name`, `hw_type`) VALUES
(1, 'HP', 'CPU-PC'),
(2, 'HP', 'Server');

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
  `hw_asset_num` varchar(11) NOT NULL,
  `hw_serial_num` varchar(30) NOT NULL,
  `hw_month_acq` varchar(25) NOT NULL,
  `hw_day_acq` varchar(11) NOT NULL,
  `hw_year_acq` varchar(11) NOT NULL,
  `hw_status` varchar(25) NOT NULL,
  `hw_host_name` varchar(35) NOT NULL,
  `hw_ip_add` varchar(35) NOT NULL,
  `hw_mac_add` varchar(35) NOT NULL,
  `hw_user_name` varchar(35) NOT NULL,
  `hw_primary_role` varchar(50) NOT NULL,
  `hw_acq_val` varchar(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hw_tbl`
--

INSERT INTO `hw_tbl` (`hw_id`, `region_name`, `site_code`, `site_name`, `hw_brand_name`, `hw_model`, `hw_asset_num`, `hw_serial_num`, `hw_month_acq`, `hw_day_acq`, `hw_year_acq`, `hw_status`, `hw_host_name`, `hw_ip_add`, `hw_mac_add`, `hw_user_name`, `hw_primary_role`, `hw_acq_val`, `user_id`) VALUES
(1, 'Region 7', '0732', 'Mandaue DO', 'HP', 'PRODESK', '123456', 'ABCDE12345', '03', '15', '2022', 'ON SITE', '0732W0001_1', '10.7.32.71', '18-60-24-DF-8A-17', 'Arjay P. Enecillo', 'Evaluator', '43,650.00', 0),
(2, 'Region 7', '0732', 'Mandaue DO', 'HP', 'G9', '54321', 'EDCBA54321', '05', '01', '2024', 'DEFFECTIVE', '0732_W001_2', '10.7.32.72', '18-60-24-DF-8A-18', 'Lea Villaceran', 'Site Support', '56,995.00', 0),
(6, 'Region 7', '0706', 'Bayawan EO', 'HP', 'Pro3000', 'SDFSDFSD', 'ABCDE12345', '01', '01', '1999', 'ON SITE', 'dasdsad', 'sadsadsa', 'dsadsad', 'asdasdasdas', 'Evaluator', 'dasdasdasda', 0),
(7, 'Region 7', '0716', 'Cebu City DO', 'HP', 'Elitedesk', 'FSDF', 'ABCDE123456', '01', '01', '1999', 'ON SITE', 'SFSDFSD', 'FSDFSD', 'FSDF', 'SDFSDFSD', 'Site Support', 'SDASDASDA', 0),
(8, 'Region 3', '0320', 'Baloc DO', 'HP', 'G9', '123456', 'sadasdsadasd', '01', '01', '2020', 'ON SITE', 'fsdfsd', 'fsdfsd', 'fsdfsd', 'fsdfsd', 'Evaluator', 'fsdfsdfds', 0),
(9, 'Region 7', '0712', 'Carcar DO', 'HP', 'G9', 'sdasdas', 'ABCDE12345', '01', '01', '2011', 'ON SITE', 'DASDAS', 'DSADSADAS', 'DSADAS', 'DASDAS', 'Evaluator', 'DASDSADAS', 0),
(10, 'Region 7', '0716', 'Cebu City DO', 'HP', 'Pro3000', 'DSADSADSAD', 'EDCBA54321', '01', '01', '1999', 'ON SITE', 'DSADSA', 'DSADSA', 'DASDSA', 'DSADSA', 'Evaluator', 'DASDSADSA', 0),
(11, 'Region 4-A', '0444', 'Balayan EO', 'HP', 'G9', 'sdfsdfsdf', 'sdfsdfsdfsd', '01', '01', '2013', 'ON SITE', 'fsdfsd', 'fdsf', 'sdfsdf', 'sdfsdfsd', 'Evaluator', 'fdsfdsfds', 0),
(12, 'Region 2', '0210', 'Aritao Extension Office', 'HP', 'Pro3000', '123456', 'fdsfsd', '01', '01', '1999', 'ON SITE', 'sdfsd', 'fsdfsdfsd', 'fsd', 'sdfdsf', 'Evaluator', 'dsfsdfsd', 0),
(13, 'Region 2', '0212', 'Basco District Office', 'HP', 'PRODESK', '54321', 'dfdsfsdf', '01', '01', '1999', 'ON SITE', 'fsdf', 'sdfsdf', 'dsfds', 'fdsfdsf', 'Evaluator', 'fsdfdsfsdf', 0);

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
(16, 'CAR'),
(17, 'CARAGA');

-- --------------------------------------------------------

--
-- Table structure for table `site_list_tbl`
--

CREATE TABLE `site_list_tbl` (
  `site_id` int(11) NOT NULL,
  `site_code` varchar(11) NOT NULL,
  `site_name` varchar(75) NOT NULL,
  `address` varchar(250) NOT NULL,
  `region_id` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `site_list_tbl`
--

INSERT INTO `site_list_tbl` (`site_id`, `site_code`, `site_name`, `address`, `region_id`) VALUES
(7, '0100', 'Regional Office ', 'Aguila Road, San Fernando City, La Union', '2'),
(8, '0101', 'New Registration Unit', 'Aguila Road, San Fernando City, La Union', '2'),
(9, '0104', 'Agoo DO', 'San Jose Sur, Agoo, La Union', '2'),
(10, '0108', 'Alaminos DO', 'Tanaytay, Alaminos City, Pangasinan', '2'),
(11, '0110', 'Burgos EO', 'Poblacion, Burgos, Ilocos Norte', '2'),
(12, '0112', 'Batac DO', 'Quiling Sur, Batac City, Ilocos Norte', '2'),
(13, '0116', 'Candon DO', 'Bagani Campo, Candon City, Ilocos Sur', '2'),
(14, '0120', 'Dagupan DO', 'AB Fernandez West Ave., Dagupan City, Pangasinan', '2'),
(15, '0122', 'Dagupan LC', 'AB Fernandez West Ave., Dagupan City, Pangasinan', '2'),
(16, '0123', 'DLRO BHF Plaza Mall', 'BHF Plaza, Mayombo, Dagupan, Pangasinan', '2'),
(17, '0124', 'Laoag DO', 'P. Gomez St., Laoag City, Ilocos Norte', '2'),
(18, '0128', 'Lingayen DO', 'Capitol Compound, Lingayen, Pangasinan', '2'),
(19, '0130', 'Naguillan EO', 'Cabaritan, Naguilian, La Union', '2'),
(20, '0132', 'San Carlos DO', 'Rizal Ave., San Carlos City, Pangasinan', '2'),
(21, '0134', 'San Fernando LC', 'Aguila Road, San Fernando City, La Union', '2'),
(22, '0136', 'San Fernando DO', 'Aguila Road, San Fernando City, La Union', '2'),
(23, '0138', 'Rosales DO', 'Carmay East, Rosales, Pangasinan', '2'),
(24, '0140', 'Urdaneta DO', 'Sta. Maria Norte, Binalonan, Pangasinan', '2'),
(25, '0142', 'Urdaneta LC', '', '2'),
(26, '0143', 'DLRO CB Mall Pangasinan', 'CB Mall, Mc Arthur Highway Nancayasan Urdaneta Pangasinan', '2'),
(27, '0144', 'San Ildefonso DO | Vigan DO', 'Poblacion East, San Ildefonso, Ilocos Sur', '2'),
(28, '0146', 'Bayambang EO', 'J.P. Rizal Street, Poblacion Sur, Bayambang, Pangasinan', '2'),
(29, '9001', 'Bayambang kiosk', '', '2'),
(30, '0200', 'Regional Office', 'San Gabriel Village, Tuguegarao City, Cagayan Valley', '3'),
(31, '0201', 'New Registration Unit', 'San Gabriel Village, Tuguegarao City, Cagayan Valley', '3'),
(32, '0204', 'Aparri District Office', 'Minanga, Aparri, Cagayan Valley', '3'),
(33, '0210', 'Aritao Extension Office', 'Central Terminal, Aritao, Nueva Vizcaya', '3'),
(34, '0212', 'Basco District Office', 'Kayvaluganan, Basco, Batanes', '3'),
(35, '0216', 'Bayombong District Office', 'Capitol Compound, Bayombong, Nueva Vizcaya', '3'),
(36, '0218', 'Cabagan Extension Office', 'National Highway, Magassi, Cabagan, Isabela', '3'),
(37, '0220', 'Cabarroguis District Office', 'Zamora, Cabarroguis, Quirino', '3'),
(38, '0224', 'Cauayan District Office', 'Central Terminal, Cabaruan, Cauayan City, Isabela', '3'),
(39, '0226', 'Gattaran Extension Office', 'Centro Sur, Gattaran, Cagayan Valley', '3'),
(40, '0228', 'Ilagan District Office', 'Osmena, Ilagan, Isabela', '3'),
(41, '0231', 'Tuao Extension Office', 'National Highway, Lakambini, Tuao, Cagayan Valley', '3'),
(42, '0232', 'Roxas District Office', 'San Antonio, Roxas, Isabela', '3'),
(43, '0236', 'Sanchez Mira Extension Office', 'Centro 2, Sanchez Mira, Cagayan Valley', '3'),
(44, '0240', 'San Isidro District Office', 'Ramos East, San Isidro, Isabela', '3'),
(45, '0242', 'Santiago Extension Office', 'Bypass Road, Ambalatungan, Santiago City, Isabela', '3'),
(46, '0244', 'Tuguegarao District Office', 'San Gabriel Village, Tuguegarao City, Cagayan Valley', '3'),
(47, '0248', 'Tuguegarao Licensing Center', 'San Gabriel Village, Tuguegarao City, Cagayan Valley', '3'),
(48, '0227', 'Alicia DO', '', '3'),
(100, '0300', 'Regional Office ', 'Gov\'t. Center, Brg. Maimpis, San Fernando City, Pampanga', '4'),
(101, '0301', 'New Registration Unit ', 'Gov\'t. Center, Brg. Maimpis, San Fernando City, Pampanga', '4'),
(102, '0304', 'Angeles DO', 'McArthur Highway, Brgy. Sto Domingo, Angeles City, Pampanga', '4'),
(103, '0306', 'San Simon DO', 'San Agustin, San Simon, Pampanga', '4'),
(104, '0308', 'Balanga DO', 'Government Center, Ala-Uli, Pilar, Bataan', '4'),
(105, '0310', 'DLRO Balagtas Town Center', '2/F Balagtas Town Center, McArthur Hi-way, Balagtas, Bulacan', '4'),
(106, '0312', 'Baler EO', 'Brgy. Bacong, San Luis, Aurora', '4'),
(107, '0316', 'San Rafael DO (Baliuag)', 'DRT Hi-Way, Ulingao, San Rafael, Bulacan', '4'),
(108, '0320', 'Baloc DO', 'Purok III, Baloc, Sto Domingo, Nueva Ecija', '4'),
(109, '0324', 'Bataan LC', 'Government Center, Ala-Uli, Pilar, Bataan', '4'),
(110, '0328', 'Bulacan LC', 'McArthur Hi-way, Tabang, Guiguinto, Bulacan', '4'),
(111, '0332', 'Cabanatuan DO', 'Sanciangco Ext., Brgy. Barrera, Cabanatuan City, Nueva Ecija', '4'),
(112, '0335', 'DLRC SM Cabanatuan', 'Brgy. H. Concepcion, Along, Pan-Philippine Hwy, Cabanatuan City, Nueva Ecija', '4'),
(113, '0336', 'Mabalacat EO', '2nd Floor, Marina Arcade, Dau, Mabalacat, Pampanga', '4'),
(114, '0340', 'Gapan DO', 'Bayanihan, Gapan City, Nueva Ecija', '4'),
(115, '0344', 'Guagua DO', 'Brgy. Quilo, San Matias, Guagua, Pampanga', '4'),
(116, '0348', 'Iba DO', 'Balili, Palanginan, Iba, Zambales', '4'),
(117, '0352', 'Malolos DO', 'McArthur Hi-way, Tabang, Guiguinto, Bulacan', '4'),
(118, '0353', 'San Jose Del Monte EO', 'Linawan, Muzon, San Jose Del Monte Bulacan', '4'),
(119, '0354', 'DLRO Malolos', 'Robinson\'s Mall, Malolos, Bulacan', '4'),
(120, '0356', 'Meycauayan DO', 'Camalig Road, Brgy. Camalig, Meycauayan, Bulacan', '4'),
(121, '0357', 'DLRO SM Pulilan', 'SM City Pulilan, Bulacan', '4'),
(122, '0358', 'DLRO SM Marilao', 'SM Marilao, Brgy. Ibayo, Marilao, Bulacan', '4'),
(123, '0360', 'Nueva Ecija LC', 'Sanciango Ext. Brgy. Barrera, Cabanatuan City, Nueva Ecija', '4'),
(124, '0364', 'Olongapo DO', 'Gordon Ave. Pag-Asa, Olongapo City', '4'),
(125, '0368', 'Palayan EO', 'Barrio Caimito, Palayan City, Nueva Ecija', '4'),
(126, '0369', 'Mabiga EO', '2nd Floor, Square 8 Building, Mc Arthur Highway, Brgy. Mabiga, Mabalacat City', '4'),
(127, '0372', 'San Fernando LC', 'Capitol Compound, Sto. Nino, San Fernando City, Pampanga', '4'),
(128, '0376', 'Paniqui EO', 'Namkuang Road Brgy. Estacion Paniqui, Tarlac', '4'),
(129, '0377', 'Bocaue Extension Office ', '9022 serv14 MacArthur Hi-Way Lolomboy Bocaue Bulacan', '4'),
(130, '0380', 'San Fernando DO', 'Gov\'t. Center, Brg. Maimpis, San Fernando City, Pampanga', '4'),
(131, '0381', 'DLRO Robinsons Pampanga', 'Robinsons Starmills, San Fernando City, Pampanga', '4'),
(132, '0382', 'Angeles Extension Office (Marquee)', '3rd Floor, Marquee Mall, Angeles City, Pampanga ', '4'),
(133, '0383', 'DLRO SM San Jose Del Monte', 'SM City, San Jose Del Monte City, Bulacan', '4'),
(134, '0384', 'San Jose DO', 'Bonifacio St. Brgy Tulat San Jose City Nueva Ecija 3121', '4'),
(135, '0385', 'Sta. Maria DO', 'Bagbaguin, Sta Maria, Bulacan', '4'),
(136, '0386', 'SBMA EO', '308 Canal Rd., Subic Bay Freeport Zone, Olongapo City, Zambales', '4'),
(137, '0387', 'Capas EO', 'McArthur Hi-way, Dolores, Capas, Tarlac', '4'),
(138, '0388', 'Tarlac DO', 'JG Perez Avenue Government Center Brgy Binauganan Tarlac City', '4'),
(139, '0389', 'New Registration Unit - SBMA', 'Bldg. 308 Canal Road, SBMA, Olongapo City', '4'),
(140, '0390', 'SBMA - MAIDRS', 'Bldg. 308 Canal Road, SBMA, Olongapo City', '4'),
(141, '0392', 'Tarlac LC', '3rd Floor, Metrotown Mall, Sto. Cristo, Tarlac City', '4'),
(142, '0397', 'DLRO SM Olongapo', '4th Flr., Extension Bldg., SM City Olongapo Downtown, Magsaysay Drive, cor Gordon Ave, Olongapo, 2200 Zambales', '4'),
(143, '0398', 'DLRC SM Clark', 'SM City Clark, Angeles City, Pampanga', '4'),
(144, '0399', 'Zambales LC', 'Gordon Ave. Pag-Asa, Olongapo City', '4'),
(145, '9003', 'Epatrol', 'N/A', '4'),
(146, '0309', 'Orani DO', 'Roman Superhighway, Barangay Doña, Orani, Bataan', '4'),
(147, '0317', 'Bustos EO', '111 General Alejo G Santos highway Bustos, Bulacan', '4'),
(148, '0361', 'Aliaga DO', ' ', '4'),
(149, '0370', 'DLRO Vista Mall Bataan', 'Cupang Proper, Balanga City, Bataan', '4'),
(150, '0355', 'DLRO Telebastagan', ' ', '4'),
(151, '0400', 'Regional Office ', '2nd Flr. Building City Hall Compd Interior B Morada Avenue Lipa City', '5'),
(152, '0401', 'New Registration Unit', '3rd Flr. Building City Hall Compd Interior B Morada Avenue Lipa City', '5'),
(153, '0404', 'Batangas DO', 'Areza Compd., Brgy Concepcion National Highway Batangas City', '5'),
(154, '0408', 'Batangas LC', 'Areza Compd., Brgy Concepcion National Highway Batangas City', '5'),
(155, '0410', 'Binan LC', '154 Areza Town Center Barangay Canlalay Binan Laguna', '5'),
(156, '0411', 'Catanauan Extension Office', 'Lopez to Catanauan Road Brgy Canculajao Catanuan Quezon', '5'),
(157, '0412', 'Bacoor DO', 'Revilla Business Park Habay II Bacoor Cavite', '5'),
(158, '0413', 'DLRO Imus', '3rd Flr. Robinsons Mall Tanzang Luma Imus Cavite', '5'),
(159, '0414', 'Dasmarinas EO', 'CC Compound Brgy. Sabang, Dasmarinas City', '5'),
(160, '0415', 'DLRO Dasma', '3rd Flr. Robinson\'s Place, Pala-Pala, Dasmariñas City, Cavite', '5'),
(161, '0417', 'DLRO SM City Batangas', 'SM Batangas City, Pallocan West Batangas City', '5'),
(162, '0418', 'San Pedro Extension Office', 'Atienza Compd., National Highway Brgy. Nueva San Pedro City', '5'),
(163, '0420', 'Cabuyao DO (Binan)', '154 Areza Town Center Barangay Canlalay Binan Laguna', '5'),
(164, '0421', 'DLRC Sta. Rosa', '3rd Floor, Robinson\'s Market, Sta. Rosa, Laguna', '5'),
(165, '0422', 'Calamba DO', 'Brgy. Uno, Crossing, Calamba City', '5'),
(166, '0423', 'DLRO Cainta', '3rd Flr. Robinsons Big R Ortigas Avenue, Cainta Rizal ', '5'),
(167, '0428', 'Kawit DO', 'Brgy. Putol, Kawit, Cavite', '5'),
(168, '0429', 'DLRO Gentri', '3rd Flr. Robinsons Place Brgy Tejero General Trias Cavite ', '5'),
(169, '0430', 'Carmona DO', 'Verdant Square Governors Drive Brgy Mabuhay Carmona Cavite', '5'),
(170, '0432', 'Cavite LC', 'Brgy. Putol, Kawit, Cavite', '5'),
(171, '0436', 'Gumaca DO', 'Brgy. Panihikan, Gumaca, Quezon', '5'),
(172, '0438', 'Imus DO', 'Brgy. Malagasang 2C Imus Cavite', '5'),
(173, '0440', 'Laguna LC', 'Brgy. San Nicolas, San Pablo City, Laguna', '5'),
(174, '0441', 'DLRO CLA Pagsanjan', 'ATC Brgy. Binan Pagsanjan Laguna', '5'),
(175, '0442', 'DLRO Southwoods', '3rd Flr. Southwoods Mall Brgy. San Francisco Binan Laguna', '5'),
(176, '0444', 'Balayan EO', 'Brgy. Calzada (Ermita), Balayan, Batangas', '5'),
(177, '0446', 'DLRO Lipa', '2nd Flr. Robinsons Place Lipa Mataas ng Lupa Lipa City Batangas', '5'),
(178, '0448', 'Lipa DO', 'The Olan Place Brgy Maraouy Lipa City Batangas', '5'),
(179, '0452', 'Lucena DO', 'Lucena Grand Central Terminal, Diversion Road, Ilayang Dupay, Quezon', '5'),
(180, '0454', 'Morong EO', 'Manila East Rd., Sitio Paglabas San Pedro Morong Rizal', '5'),
(181, '0457', 'Naic EO', 'A Soriano Highway Barangay Timalang-Balsahan, Naic, Cavite', '5'),
(182, '0464', 'Quezon LC', 'Lucena Grand Central Terminal, Diversion Road, Ilayang Dupay, Quezon', '5'),
(183, '0471', 'Alabat EO', 'Bonifacio St. Brgy. 5 Poblacion, Alabat Island, Quezon Province', '5'),
(184, '0472', 'San Pablo DO', 'Alaminos Compound, Brgy. San Benito, Alaminos, Laguna', '5'),
(185, '0476', 'Sta. Cruz \"Pila\" DO', 'Brgy. Sta. Clara Sur, Pila, Laguna', '5'),
(186, '0477', 'Taytay Extension Office ', '168 Velasquez st., Brgy San Juan Taytay Rizal ', '5'),
(187, '0478', 'Tanay EO', 'Sampaloc Road Brgy Plaza Aldea, Tanay, Rizal', '5'),
(188, '0479', 'DLRO SM Masinag', '', '5'),
(189, '0480', 'Tagaytay EO', 'Areza Compound, Mahogany Market, Kaybagal South, Tagaytay City, Cavite', '5'),
(190, '0482', 'Tagkawayan EO', 'Brgy. Munting Parang, Quirino Highway, Tagkawayan, Quezon', '5'),
(191, '0484', 'Binangonan EO', 'Manila East Rd., Brgy. Pag-asa, Binangonan, Rizal', '5'),
(192, '0488', 'Cainta EO', 'Bazaar City 9 GMC Compoud Felix Avenue Brgy., Sto Domingo Cainta Rizal', '5'),
(193, '0489', 'Antipolo Extension Office', 'Sitio Angao C Lawis Extension Brgy Dela Paz Antipolo City', '5'),
(194, '0491', 'DLRO San Mateo', '2nd flr. SM San Mateo Rizal', '5'),
(195, '0492', 'Taal EO', 'Taal Sports Complex, Brgy. Tierra Alta, Taal, Batangas', '5'),
(196, '9004', 'E-patrol', '', '5'),
(197, '0499', 'Montalban EO', '', '5'),
(198, '0498', 'Tanauan DO', '', '5'),
(199, '0493', 'San Mateo EO', '', '5'),
(200, '0490', 'DLRO Robinsons Montalban', '', '5'),
(201, '0419', 'DLRO San Pedro ', '', '5'),
(202, '0406', 'DLRO Robinsons Antipolo', '', '5'),
(203, '0431', 'DLRO SM Trece Martirez', '', '5'),
(204, '0487', 'DLRO SM Angono', '', '5'),
(205, '0443', 'DLRO Xentro Mall', '', '5'),
(236, '0402', 'Regional Office ', 'Brgy. Tawiran, Dolce Casa Di Jo, Calapan City, Oriental Mindoro', '6'),
(237, '0403', 'New Registration Unit ', 'Brgy. Tawiran, Dolce Casa Di Jo, Calapan City, Oriental Mindoro', '6'),
(238, '0416', 'Boac DO', 'Brgy. Bangbangalon, Boac, Marinduque', '6'),
(239, '0424', 'Calapan DO', 'Dolce Casa Di Jo Ville, Brgy. Tawiran, Calapan City, Oriental Mindoro', '6'),
(240, '0445', 'Brooke\'s Point EO', 'Brgy Tubtob Brookespoint Palawan', '6'),
(241, '0456', 'Romblon DO', 'J.P. Rizal St., Brgy. Tabing Dagat, Odiongan, Romblon', '6'),
(242, '0460', 'Palawan DO', 'Valencia St., Puerto Princesa City, Palawan', '6'),
(243, '0461', 'Mamburao District Office', 'Mamburao st. Occidental Mindoro', '6'),
(244, '0462', 'Pinamalayan EO', 'Brgy. Papandayan, Pinamalayan, Oriental Mindoro', '6'),
(245, '0465', 'Palawan EO', 'Robinson\'s Palawan Puerto Princesa', '6'),
(246, '0466', 'Sablayan EO', 'Sitio Tuburan, Barangay Poblacion, Sablayan, Occidental Mindoro', '6'),
(247, '0468', 'San Jose DO', 'Municipal Compound, San Jose, Occidental Mindoro', '6'),
(248, '0470', 'Roxas EO', 'Dr. Leon Cusi St. Brgy Paclasan Roxas Oriental Mindoro', '6'),
(249, '9041', 'E-patrol', '', '6'),
(250, '0463', 'Roxas EO (Palawan)', '', '6'),
(251, '0500', 'Regional Office (Operations Div)', ' Purok 4 Barangay, Legazpi City, 4500 Albay', '7'),
(252, '0501', 'New Registration Unit ', ' Purok 4 Barangay, Legazpi City, 4500 Albay', '7'),
(253, '0504', 'Daet DO', 'Alawihaw, Daet Camarines Norte', '7'),
(254, '0508', 'Partido DO', 'Gov Jose T. Fuentebella National Hwy, Tigaon, Camarines Sur', '7'),
(255, '0512', 'Ligao DO (Guinobatan DO)', 'Maharlika Highway, Sta. Cruz, Ligao City, 4504 Albay Philippines', '7'),
(256, '0516', 'Iriga DO', 'San Isidro, Iriga City, Camarines Sur', '7'),
(257, '0518', 'Irosin EO', 'CM Recto St. Irosin Sorsogon', '7'),
(258, '0524', 'Legaspi DO', 'Embarcadero De Legaspi, Legaspi Boulevard, Legaspi City', '7'),
(259, '0528', 'Masbate DO', 'Capitol Rd, Masbate City, Masbate', '7'),
(260, '0532', 'Naga DO', 'LCC Road, Brgy. Sabang, Naga, 4400 Camarines Sur', '7'),
(261, '0535', 'Naga LRS', '', '7'),
(262, '0534', 'Ragay DO', 'Roland R. Andaya Highway, Barangay Banga, Ragay, Camarines Sur, Ragay', '7'),
(263, '0536', 'Sorsogon DO', 'Cabid-an Sorsogon, Sorsogon City', '7'),
(264, '0537', 'Pamplona EO', 'Zone 4, Brgy. Del Rosario, Pamplona, Camarines Sur', '7'),
(265, '0539', 'New Registration Unit - Pamplona', '', '7'),
(266, '0540', 'Tabaco DO', 'Central Terminal, Daraga - Legazpi City - Tiwi Rd, Tabaco City, Albay', '7'),
(267, '0544', 'Virac DO', 'San Isidro Village, Airport Site, Virac 4800', '7'),
(268, '9005', 'E-patrol', '', '7'),
(269, '0531', 'Pili EO', '', '7'),
(270, '0600', 'Regional Office ', 'Brgy. Quintin Salas, Jaro, Iloilo City', '8'),
(271, '0601', 'New Registration Unit', 'Brgy. Quintin Salas, Jaro, Iloilo City', '8'),
(272, '0604', 'Bacolod City DO', 'Sitio Mayaosayao, Brgy. Mansilingan, Bacolod City', '8'),
(273, '0605', 'DLRO Bacolod', '', '8'),
(274, '0606', 'Barotac Viejo DO', 'Barotac Viejo Municipal Compound,Btac. Viejo, Iloilo', '8'),
(275, '0608', 'Himamaylan DO', 'Gatuslao Park, Himamaylan, Negros Occ.', '8'),
(276, '0610', 'Sipalay DO', 'Brgy. 3, Sipalay, Negros Occidental', '8'),
(277, '0612', 'Cadiz DO', 'Gustilo Blvd., Cadiz City, Negros Occ.', '8'),
(278, '0616', 'Calinog DO', 'Calinog Mun. Comp., Calinog, Iloilo', '8'),
(279, '0617', 'DLRO GT Town Center Pavia', 'GT Town Center, Pavia, Iloilo', '8'),
(280, '0618', 'Guimaras DO', 'Buenavista Municipal Compound, Buenavista, Guimaras', '8'),
(281, '0619', 'Guimbal EO', 'Guimbal Mun. Comp., Guimbal, Iloilo', '8'),
(282, '0620', 'Iloilo City DO', 'Brgy. Quintin Salas, Jaro, Iloilo City', '8'),
(283, '0624', 'Iloilo LC', 'Brgy. Quintin Salas, Jaro, Iloilo City', '8'),
(284, '0626', 'DLRO Iloilo', 'Robinsons Place, Iloilo City', '8'),
(285, '0628', 'Kalibo DO', 'Brgy. Tigayon, Kalibo, Aklan', '8'),
(286, '0630', 'Pontevedra EO', 'Pontevedra Mun. Comp., Pontevedra, Negros Occidental', '8'),
(287, '0632', 'Negros Occidental LC', 'Sitio Mayaosayao, Brgy. Mansilingan, Bacolod City', '8'),
(288, '0634', 'Passi EO', 'Brgy. Bacuranan, Passi City, Iloilo', '8'),
(289, '0635', 'Pilar EO', ' San Blas, Pilar, Capiz', '8'),
(290, '0636', 'Roxas City DO', 'Brgy. Tiza, Roxas City, Capiz', '8'),
(291, '0640', 'San Carlos DO', 'San Carlos City, Negros Occidental', '8'),
(292, '0644', 'Antique DO', 'Precioso St., DPWH Compound San Jose, Antique', '8'),
(293, '0650', 'Dumalag EO (Sigma)', 'Poblacion Norte, Sigma, Capiz', '8'),
(294, '0621', 'EB Magalona DO', '', '8'),
(295, '0652', 'Western Aklan DO', '', '8'),
(296, '0627', 'DLRO Festive Mall', '', '8'),
(297, '0631', 'DLRO Ayala Bacolod', '', '8'),
(339, '0700', 'Regional Office ', 'Natalio Bacalso Ave., Cebu City', '9'),
(340, '0701', 'New Registration Unit', 'LTO MVIC, M. Logarta Ave. Subangdaku Mandaue city', '9'),
(341, '0702', 'Malasakit LC', 'Natalio Bacalso Ave., Cebu City', '9'),
(342, '0703', 'MAIDRS - RO7', 'LTO MVIC, M. Logarta Ave. Subangdaku Mandaue city', '9'),
(343, '0704', 'Bais DO', 'Satellite Market, Bais City, Negros Oriental', '9'),
(344, '0706', 'Bayawan EO', 'Brgy. Ubos, Bayawan City, Neg. Oriental', '9'),
(345, '0712', 'Carcar DO', 'Pajo Valladolid, Carcar City, Cebu', '9'),
(346, '0713', 'Toledo LEO', 'Brgy. Sta. Cruz, Sto. Nino, Balamban, Cebu', '9'),
(347, '0714', 'Dalaguete DO', 'Consolacion, Dalaguete, Cebu Province', '9'),
(348, '0716', 'Cebu City DO', 'Robinson\'s Galleria, Cebu City', '9'),
(349, '0717', 'DLRO Robinsons Fuente', 'Sta. Cruz, Fuente Osmeña Boulevard, Cebu City', '9'),
(350, '0719', 'Talisay EO Licensing Section', 'Talisay South Central Square, Lawaan II, Talisay City, Cebu', '9'),
(351, '0751', 'Talisay EO', 'Talisay South Central Square, Lawaan II, Talisay City, Cebu', '9'),
(352, '0720', 'Cebu City LC', 'SM Seaside South Road properties Cebu City', '9'),
(353, '0722', 'DLRC SM Cebu', 'SM North Reclamation Area, Cebu City', '9'),
(354, '0724', 'Danao DO', 'Taytay, Danao City, Cebu', '9'),
(355, '0727', 'Lapu-Lapu City LC', 'ICM Mall, Barangay Pusok Lapu-Lapu City', '9'),
(356, '0728', 'Dumaguete DO', 'Capitol Site, Taclobo, Dumaguete City, Negros Oriental', '9'),
(357, '0730', 'Jagna EO', 'West Canayaon, Garcia Hernandez, Bohol', '9'),
(358, '0732', 'Mandaue DO', 'to be determined', '9'),
(359, '0736', 'Mandaue City LC', 'to be determined', '9'),
(360, '0738', 'Medellin EO', 'New Medellin Public Market, Medellin, Cebu', '9'),
(361, '0739', 'Camotes Island EO', 'Eastern Poblacion Poro, Cebu', '9'),
(362, '0741', 'La Libertad DO', 'South Poblacion, La Libertad Neg. Oriental', '9'),
(363, '0742', 'Bantayan EO', 'Santa Fe, Bantayan island, Cebu', '9'),
(364, '0743', 'Ronda DO', 'Poblacion, Municipality of Ronda, Cebu Province', '9'),
(365, '0744', 'Siquijor DO', 'Caipilan, Siquijor, Siquijor', '9'),
(366, '0748', 'Tagbilaran DO', 'R. Enerio St., Tagbilaran City. Bohol', '9'),
(367, '0752', 'Toledo DO', 'S. Osmeña St., Poblacion, Toledo City', '9'),
(368, '0753', 'Talibon EO', 'Cajes Del Rosario Bldg., Pob. Talibon, Bohol', '9'),
(369, '0760', 'Lapu-Lapu EO', 'Lapu-Lapu City Hall, Lapu-Lapu City, Cebu', '9'),
(370, '0761', 'Tagbilaran DO LEO', 'Alturas Mall, Tagbilaran City, Bohol', '9'),
(371, '9007', 'E-Patrol', '', '9'),
(372, '0749', 'DLRO Island City Mall Bohol', '', '9'),
(373, '0800', 'Regional Office ', 'Government Center, Barangay Candahug, Palo, Leyte', '10'),
(374, '0801', 'New Registration Unit', 'Government Center, Barangay Candahug, Palo, Leyte', '10'),
(375, '0802', 'Baybay DO', 'Government Center Magsaysay Ave., Zone 23, Baybay City, Leyte', '10'),
(376, '0804', 'Borongan DO', 'Brgy. Bato, Borongan, Eastern Samar ', '10'),
(377, '0808', 'Calbayog DO', 'Pido St., Calbayog City, Western Samar ', '10'),
(378, '0812', 'Carigara DO', 'Sitio Bariis, Brgy. Visoria West Carigara, Leyte', '10'),
(379, '0816', 'Catarman DO', 'Brgy. Dalakit, Catarman, Northern Samar', '10'),
(380, '0820', 'Catbalogan DO', 'Capitol Ground, Rizal Ave., Ext. Catbalogan, Western Samar', '10'),
(381, '0822', 'Guiuan EO', 'Barangay 6, Guiuan Eastern Samar', '10'),
(382, '0824', 'Maasin DO', 'Brgy. Agbao, Maasin City, Southern Leyte', '10'),
(383, '0827', 'Javier EO', 'Brgy. Picas Norte, Maharlika Highway, Javier, Leyte', '10'),
(384, '0828', 'Naval DO', 'Sitio Bliss, Calumpang, Naval, Biliran', '10'),
(385, '0831', 'Burauen EO', 'Ground Floor, Burauen LGU, Sto.Niño Street Pob. 7, Burauen Leyte', '10'),
(386, '0832', 'Ormoc DO', 'Anubing St., Brgy Cogon, Ormoc City, Leyte', '10'),
(387, '0835', 'Mercedes EO', 'LTO Mercedes EO, Mercedes, Eastern Samar', '10'),
(388, '0836', 'Palompon DO', 'LTO Heights, Guiwan I, Palompon, Leyte ', '10'),
(389, '0840', 'San Juan DO', 'Carillo St., San Juan, Southern Leyte', '10'),
(390, '0841', 'Sogod EO', 'Zone IV, Sogod Southern Leyte', '10'),
(391, '0844', 'Tacloban DO', 'Old Army Road, Tacloban City, Leyte', '10'),
(392, '0846', 'Tacloban EO', 'Old Army Road, Tacloban City, Leyte', '10'),
(393, '0848', 'Tacloban City LC', 'Old Army Road, Tacloban City, Leyte', '10'),
(394, '0826', 'Laoang DO', '', '10'),
(395, '9008', 'E-Patrol', 'Cojibas PMVIC COmpound, Ormoc City, Leyte', '10'),
(407, '0900', 'Regional Office ', 'Veterans Avenue,Sta Barbara,Zamboanga City', '11'),
(408, '0901', 'New Registration Unit', 'Ecozone Main Office Bldg. San Ramon,Zamboanga City', '11'),
(409, '0904', 'Basilan DO', 'Rizal Avenue,Brgy.Madasigon,Molave,Zamboanga del Sur', '11'),
(410, '0907', 'Buug EO', 'Hway Poblacion,Buug,Zamboanga Sibugay', '11'),
(411, '0908', 'Dipolog DO', 'Lower Turno,Dipolog City,Zamboanga del Norte', '11'),
(412, '0910', 'MAIDRS - Dipolog', '', '11'),
(413, '0909', 'Dipolog LC', 'Lower Turno,Dipolog City,Zamboanga del Norte', '11'),
(414, '0912', 'Ipil DO', 'Poblacion Ipil,Zamboanga Sibugay Province', '11'),
(415, '0913', 'MAIDRS - Ipil', '', '11'),
(416, '0920', 'Pagadian DO/MAIDRS', 'Tiguma,Zamboanga del Sur', '11'),
(417, '0922', 'MAIDRS - Pagadian', '', '11'),
(418, '0926', 'Sindangan EO', 'Dataro Building,Sindangan Zamboanga del Norte', '11'),
(419, '0927', 'DLRC Yubenco StarMall, Zamboanga', 'Yubengco Putik,Zamboanga City', '11'),
(420, '0928', 'Zamboanga DO', 'Veterans Avenue,Sta Barbara,Zamboanga City', '11'),
(421, '0929', 'Zambo Ecozone EO', 'Ecozone Main Office Bldg. San Ramon,Zamboanga City', '11'),
(422, '0930', 'Molave EO', 'Rizal Avenue,Brgy.Madasigon,Molave,Zamboanga del Sur', '11'),
(423, '0931', 'Zamboanga  License Renewal Section', 'KCC Mall,Gov. Camins Avenue,Zamboanga City', '11'),
(424, '0932', 'Zamboanga LC', 'Veterans Avenue,Sta Barbara,Zamboanga City', '11'),
(425, '0933', 'Siocon EO', 'Siocon,Zamboanga del Norte', '11'),
(426, '9009', 'E-Patrol Zamboanga', 'San Jose Road,Zamboanga City', '11'),
(427, '0925', 'Tetuan EO', '', '11'),
(428, '0911', 'Dapitan EO', '', '11'),
(468, '1000', 'Regional Office ', 'MVIS Compound, Bulua, Cagayan de Oro City', '12'),
(469, '1001', 'New Registration Unit', 'MVIS Compound, Bulua, Cagayan de Oro City', '12'),
(470, '1007', 'DLRO Limketkai', 'Limketkai Mall, Lapasan, Cagayan de oro City', '12'),
(471, '1008', 'Cagayan De Oro DO', 'MVIS Compound, Bulua, Cagayan de Oro City', '12'),
(472, '1009', 'Cagayan De Oro LC', 'MVIS Compound, Bulua, Cagayan de Oro City', '12'),
(473, '1012', 'Maramag EO', 'Purok 5, North Poblacion, Maramag, Bukidnon', '12'),
(474, '1014', 'Kibawe DO', 'Purok 5, West Kibawe, Kibawe, Bukidnon ', '12'),
(475, '1016', 'Gingoog DO', 'F. Duguenio St., Sta Clara Rd. Brgy 26, Gingoog City, Misamis Oriental ', '12'),
(476, '1017', 'Iligan DO', 'Rosario Heights, Tubod, Iligan City', '12'),
(477, '1006', 'MAIDRS - Iligan', '', '12'),
(478, '1018', 'Initao EO', 'Initao Public Market, Poblacion Initao, Misamis Oriental', '12'),
(479, '1020', 'Malaybalay DO', 'San Victories Street, Brgy. 9, Malaybalay City', '12'),
(480, '1005', 'MAIDRS - Malaybalay', '', '12'),
(481, '1024', 'Camiguin DO', 'Lakas, Mambajao, Camiguin', '12'),
(482, '1028', 'Oroquieta DO', 'Capitol Drive, Oroquieta City', '12'),
(483, '1032', 'Ozamis DO', 'Bernard St., Ozamis City, Misamis Occidental', '12'),
(484, '1036', 'Cagayan de Oro DO - East (Puerto EO)', 'Zone 2, Agusan, Cagayan De Oro', '12'),
(485, '1038', 'DLRO SM Uptown', 'SM City Uptown Mall, Upper Carmen, CDO, Misamis Oriental', '12'),
(486, '1044', 'Tangub DO', 'IBJT, Tangub City, Misamis Occidental', '12'),
(487, '1046', 'Tubod DO', 'Agora Complex, Tubod, Lanao del Norte', '12'),
(488, '1048', 'Valencia EO', 'New Bus Terminal, Lumbo, Valencia City', '12'),
(489, '9010', 'E-Patrol', 'Poblacion Balingasag, Balingasag, Misamis Oriental', '12'),
(490, '1100', 'Regional Office ', 'LTO MVIS Cmpd., Fronting SM City Ecoland Davao City', '13'),
(491, '1101', 'New Registration Unit', 'LTO MVIS Cmpd., Fronting SM City Ecoland Davao City', '13'),
(492, '1108', 'Davao City North DO', 'LTO MVIS Cmpd., Fronting SM City Ecoland Davao City', '13'),
(493, '1110', 'Davao de Oro DO', 'Government Center, Nabunturan, Davao de Oro', '13'),
(494, '1112', 'Davao South City DO', 'LTO MVIS Cmpd., Fronting SM City Ecoland Davao City', '13'),
(495, '1114', 'DLRC SM Davao', '', '13'),
(496, '1116', 'Digos DO', 'Aurora 6th St., San Jose, Digos City, Davao del Sur', '13'),
(497, '1118', 'DLRO Gaisano Mall Buhangin', 'Ground flr. Gaisano Grand City Mall, Corner Tigatto-Cabantian Rd. Buhangin Davao City', '13'),
(498, '1126', 'Malita DO', 'National Highway, Poblacion,  Malita Davao Occidental', '13'),
(499, '1128', 'Mati DO', 'Government Center, Dahican Mati City', '13'),
(500, '1131', 'Samal DO', 'Brgy. Miranda, Babak District, Island Garden, Samal City', '13'),
(501, '1135', 'Panabo DO', 'Government Center,  Panabo City Davao del Norte', '13'),
(502, '1136', 'Tagum DO', 'Provincial Government Center, Brgy. Mankilam, Tagum City', '13'),
(503, '1137', 'DLRC Felcris Toril', 'Felcris Mall Supermarket, Mcarthur Highway, Toril Davao City', '13'),
(504, '1138', 'DLRC Tagum', 'Gaisano Mall of Tagum, Tagum City', '13'),
(505, '1139', 'DLRO Gaisano Digos', 'Ground Flr., Gaisano Grand Mall, Tres de Mayo, Digos City', '13'),
(506, '9011', 'E-Patrol', 'Public Market, Poblacion, Sulop Davao del Sur', '13'),
(507, '1200', 'Regional Office ', 'Purok Yellowbell, Brgy. Sta. Cruz, Koronadal City, South Cotabato', '14'),
(508, '1201', 'New Registration Unit', 'Purok Yellowbell, Brgy. Sta. Cruz, Koronadal City, South Cotabato', '14'),
(509, '1207', 'Tambler EO', 'Purok Banisil, Brgy. Tambler, General Santos City', '14'),
(510, '1209', 'DLRC GenSan', '2/F Robinsons Place, J. Catolico St., Lagao, General Santos City', '14'),
(511, '1210', 'General Santos DO', 'City Hall Compound, Brgy, West, General Santos City', '14'),
(512, '1211', 'General Santos LC', 'City Hall Compound, Brgy, West, General Santos City', '14'),
(513, '1218', 'Kabacan EO', 'National Highway, Brgy. Kayaga, Kabacan, North Cotabato', '14'),
(514, '1220', 'Kidapawan DO', 'Osmeña Drive, Kidapawan City, Cotabato', '14'),
(515, '1222', 'Datu Abdullah Sangki EO', 'Municipal Hall Compound, Datu Abdullah Sangki, Maguindanao del Sur', '14'),
(516, '1226', 'Koronadal DO', 'Jaycee Ave., Koronadal City, South Cotabato', '14'),
(517, '1225', 'Koronadal LC ', 'Jaycee Ave., Koronadal City, South Cotabato', '14'),
(518, '1227', 'DLRC Koronadal', '2/F Gaisano Grand Mall, Koronadal City', '14'),
(519, '1230', 'Polomolok EO', 'National Highway, Polomolok, South Cotabato', '14'),
(520, '1236', 'Midsayap EO', 'Municipal Hall Compound, Midsayap, North Cotabato', '14'),
(521, '1241', 'Saranggani DO', 'President Quirino St., Poblacion, Alabel, Sarangani Province', '14'),
(522, '1242', 'Surallah DO', 'JP Laurel St., Surallah, South Cotabato', '14'),
(523, '1244', 'Tacurong DO', 'Roxas Avenue, Tacurong City, Sultan Kudarat', '14'),
(524, '1248', 'Wao EO', 'in front of Landbank, Wao, Lanao del Sur', '14'),
(525, '9012', 'E-Patrol', 'Maasim, Sarangani Province', '14'),
(526, '1213', 'DLRO SM GenSan', '', '14'),
(527, '1308', 'Quezon City EO', '173 20th ave cor. Mirasol st Cubao Q.c', '1'),
(528, '1312', 'Diliman DO ', 'LTO Central Office Compound, Brgy Pinyahan, East Avenue Quezon City', '1'),
(529, '1316', 'San Juan LC', 'San Juan Commercial Complex, N Domingo St San Juan City', '1'),
(530, '1320', 'La Loma DO', '#3 Biak na bato St. corner P. Florentino St. Brgy. Sto Domingo, Quezon City ', '1'),
(531, '1336', 'Mandaluyong EO', '121 Shaw blvd Mandaluyong', '1'),
(532, '1337', 'Pateros Extension Office', '92 ARM Bldg. M. Almeda st. Brgy San Roque Pateros Manila ', '1'),
(533, '1338', 'DLRO Rob Galleria', 'Lower Groundfloor Edsa cor Ortigas Ave. Q.C', '1'),
(534, '1356', 'Marikina DO', 'LOL Bldg JP Rizal cor Ming Ramos Lane Brgy Sto Nino Marikina City', '1'),
(535, '1357', 'DLRO Metroeast', 'Basement Robinson Metro East', '1'),
(536, '1359', 'DLRO Fisher Mall', 'Fisher Mall, Upper basement 1104 Quezon Ave Q.C', '1'),
(537, '1360', 'Quezon City LC', 'LTO Central Office Compound, Brgy Pinyahan, East Avenue Quezon City', '1'),
(538, '1362', 'DLRO Ever Gotesco', 'Ever Gotesco Mall, Commonwealth Avenue, Quezon City', '1'),
(539, '1363', 'DLRO SM Novaliches', 'SM Novaliches, Quirino Highway, Novaliches, Quezon City', '1'),
(540, '1364', 'Novaliches DO', '1129 Quirino Highway, Brgy. Kaligayahan, Novaliches, Quezon City', '1'),
(541, '1365', 'DLRO Rob Fairview/Novaliches', 'Robinsons NOvaliches Pasong Putil QC', '1'),
(542, '1372', 'Pasig DO', 'Inside of Ynares Complex Compound Brgy Oranbo', '1'),
(543, '1374', 'DLRO Tiendesitas', 'Tiendesitas shopping mall Car park las tiendas entrance brgy ugong pasig city ', '1'),
(544, '1376', 'Quezon City LRS', 'LTO Central Office Compound, Brgy Pinyahan, East Avenue Quezon City', '1'),
(545, '1377', 'Pilot DO', 'LTO Compound East Ave Diliman QC', '1'),
(546, '1379', 'DLRO SM North', 'Lower Ground Floor, Government Service Express SM Annex Q.C', '1'),
(547, '1380', 'Quezon City DO', 'Butel Bldg P Tuazon Cubao QC', '1'),
(548, '1381', 'DLRO FCM', 'Fairview Center Mall, Don Mariano Marcos Ave. cor. Regalado St., Novaliches, Quezon City', '1'),
(549, '1383', 'DLRO Ali Mall', 'LTO DLRO Alimall 2nd Floor Cubao Q.C', '1'),
(550, '1384', 'San Juan DO', 'Severina Bldg 80 Ramon Magsaysay Dona Imelda QC', '1'),
(551, '1386', 'DLRO Shaw Center Mall', '360 Shaw Center Mall Nueve de Febrero Mandaluyong', '1'),
(552, '1391', 'Taguig EO', 'Old Admin. Bldg., FTI Compound, Taguig City', '1'),
(553, '1395', 'Taguig LEO', 'Old Admin. Bldg., FTI Compound, Taguig City', '1'),
(554, '1396', 'Valenzuela DO', 'Arca Plaza Maysan Road, Valenzuela City', '1'),
(555, '1397', 'Valenzuela LRS', 'Arca Plaza Maysan Road, Valenzuela City', '1'),
(556, '1800', 'Regional Office - East', 'LTO Central Office Compound, Brgy Pinyahan, East Avenue Quezon City', '1'),
(557, '1801', 'NRU - East 1801', 'LTO Central Office Compound, Brgy Pinyahan, East Avenue Quezon City', '1'),
(558, '1806', 'DLRO Choice Market', '58 Ortigas Avenue, Rosario, Pasig City', '1'),
(559, '9000', 'Epatrol 9000 - East', '', '1'),
(560, '1345', 'LTO Licensing Center-PITX', '', '1'),
(561, '1805', 'DLRO Eastwood', '', '1'),
(562, '1361', 'DLRO Uptown Center', '', '1'),
(563, '1803', 'DLRO California Garden Square', '', '1'),
(564, '1804', 'DLRO Venice Grand Canal Mall', '', '1'),
(565, '1807', 'DLRO Estancia Mall', '', '1'),
(566, '1300', 'Regional Office - West', '#20 G Araneta Ave. Quezon City', '1'),
(567, '1301', 'NRU - West 1301', '#20 G Araneta Ave. Quezon City', '1'),
(568, '1302', 'DLRO SM Manila', 'SM Manila, 5th floor Metro Manila ', '1'),
(569, '1303', 'NRU - West 1303', '#20 G Araneta Ave. Quezon City', '1'),
(570, '1304', 'Caloocan DO', 'Butel Building, Araneta Ave., Caloocan City', '1'),
(571, '1305', 'DLRO Araneta Square Mall', 'Araneta Square Mall, Monumento, Caloocan City', '1'),
(572, '1306', 'Caloocan LC', 'Butel Building, Araneta Ave., Caloocan City', '1'),
(573, '1309', 'DLRO Rob Manila', '3rd Level Open Space Parking Padre Faura Wing, Robinson Place Ermita, Manila ', '1'),
(574, '1324', 'Las Pinas DO', 'Francisco Motors Compound, Talon 1, Alabang-Zapote Rd., Las Piñas City', '1'),
(575, '1325', 'DLRO Rob Las Pinas', 'Robinsons Las Piñas, Alabang-Zapote Road, Las Piñas City', '1'),
(576, '1328', 'Makati DO', 'Butel Bldg., Pilia St., Makati City', '1'),
(577, '1329', 'Makati LC', '', '1'),
(578, '1330', 'DLRO Ayala MRT', '2F The Link Ayala Center Parkway Drive san Lorenzo Makati City', '1'),
(579, '1331', 'DLRO Guadalupe', 'Guadalupe Commercial Complex, Makati City', '1'),
(580, '1332', 'Malabon EO', 'Malabon City Hall Bldg., F.Sevilla Bldg., Malabon City', '1'),
(581, '1340', 'Manila East DO', '776 Domingo Santiago St. Sampaloc, Manila ', '1'),
(582, '1344', 'Manila North DO', 'JT Centrale 1686 Fugoso St. Cor Felix Huertas rd Sta.Cruz, Manila', '1'),
(583, '1346', 'DLRO Lucky China Town', 'Lucky Chinatown Mall Annez, B 3rd St. Binondo, Manila ', '1'),
(584, '1348', 'Manila South DO', 'Annex 2 Bldg.Central Post Office Compound, Liwasang Bonifacio Lawton', '1'),
(585, '1352', 'Manila West DO', '2154 BETA Bldg. España cor. Josefina St. Sampaloc, Manila ', '1'),
(586, '1358', 'Navotas DO', 'Gen. Gas Plant Bldg., Fishport, Cplx. North Bay Complex, Navotas City', '1'),
(587, '1366', 'Muntinlupa DO', 'National Road, Tunasan, Muntinlupa City', '1'),
(588, '1367', 'Paranaque EO', 'Olivares Plaza, Brgy. San Dionisio, Parañaque City', '1'),
(589, '1368', 'Pasay DO', 'Domestic Road, Pasay City', '1'),
(590, '1369', 'DLRO Metropoint', 'Metropoint Mall, EDSA cor Taft Avenue, Pasay City', '1'),
(591, '1371', 'DLRO MOA', 'Level 2 North Parking Bldg., SM Mall of Asia, Brgy. 76, Pasay City', '1'),
(592, '1378', 'Pilot EO', 'Domestic Road, Pasay City', '1'),
(593, '1385', 'DLRO Alabang Town Center', 'Ayala Alabang Town Center, Muntinlupa City', '1'),
(594, '1387', 'Pasay MVRRS Drive-Thru', 'Domestic Road, Pasay City', '1'),
(595, '1388', 'Pasay LC', 'Domestic Road, Pasay City', '1'),
(596, '1390', 'Las Pinas LEO', 'Francisco Motors Compound, Talon 1, Alabang-Zapote Rd., Las Piñas City', '1'),
(597, '1392', 'Manila LC', 'JT Centrale 1686 Fugoso St. Cor Felix Huertas rd Sta.Cruz, Manila', '1'),
(598, '9020', 'Epatrol 9020 - West', '', '1'),
(599, '1327', 'DLRO Paseo Center', '', '1'),
(600, '1326', 'DLRO SM Southmall', '', '1'),
(601, '1359', 'DLRO Fishermall Malabon', '', '1'),
(602, '1354', 'DLRO Ayala Circuit Mall', '', '1'),
(603, '1307', 'DLRO Zabarte Town Center', '', '1'),
(604, '1339', 'DLRO Ayala South Park', '', '1'),
(605, '1400', 'Regional Office', 'Post Office Bdlg., Post Office Loop, Upper Session Road, Baguio City', '16'),
(606, '1401', 'New Registration Unit', 'Post Office Bdlg., Post Office Loop, Upper Session Road, Baguio City', '16'),
(607, '1404', 'Baguio DO', 'LTO Compound, Polo Field, Pacdal, Baguio City', '16'),
(608, '1406', 'Baguio LC', 'LTO Compound, Polo Field, Pacdal, Baguio City', '16'),
(609, '1408', 'Bangued DO', 'DPWH compound, Rizal St., Zone 7, Bangued , Abra', '16'),
(610, '1412', 'Bontoc DO', 'Poblacion, Bontoc, Mt. Province', '16'),
(611, '1414', 'Luna DO', 'Sitio Payanan, San Gregorio, Luna, Apayao', '16'),
(612, '1416', 'Lagawe DO', 'Bannit, Lamut, Ifugao', '16'),
(613, '1420', 'La Trinidad DO', 'Wangal, La Trinidad, Benguet', '16'),
(614, '1424', 'Tabuk DO', 'Purok 6, Hilltop, Bulanao, Tabuk City, Kalinga', '16'),
(615, '1426', 'DLRO Porta Vaga Mall ', 'Porta Vaga Mall, Session Road, Baguio City', '16'),
(616, '1428', 'Alfonso Lista EO', 'Santa Maria, Alfonso Lista,  Ifugao', '16'),
(617, '1500', 'Regional Office', 'J. Rosales Avenue, Butuan City', '17'),
(618, '1501', 'New Registration Unit', 'J. Rosales Avenue, Butuan City', '17'),
(619, '1504', 'Bislig DO', 'Bliss Project Mancarugo, Bislig City, Surigao del Sur', '17'),
(620, '1506', 'DLRO Robinsons Butuan ', 'Robinson\'s Mall, J.C. Aquino Avenue, Butuan City', '17'),
(621, '1507', 'Bayugan DO', '2nd floor AVON Bldg. National Highway, Bayugan City', '17'),
(622, '1508', 'Butuan DO', 'J. Rosales Avenue, Butuan City', '17'),
(623, '1510', 'Cabadbaran DO', 'Cabadbaran City, Agusan del Norte', '17'),
(624, '1512', 'Dapa DO', 'Km 3, Barangay Osmeṅa, Dapa, Surigao del Norte', '17'),
(625, '1516', 'Patin-ay DO', 'Patin-ay, Prosperidad, Agusan del Sur', '17'),
(626, '1520', 'Surigao DO', 'Capitol Road, Surigao City, Surigao del Norte', '17'),
(627, '1524', 'Tandag DO', 'Capitol Road,Brgy Telaje, Tandag City, Surigao del Sur', '17'),
(628, '1526', 'Trento EO', 'P-5, Barangay Poblacion, Trento, Agusan Del Sur', '17'),
(629, '1240', 'Maguindanao DO', 'Datu Odin Sinsuat, MAguindanao', '15'),
(630, '1232', 'Marawi DO', 'Matampay, Marawi City Lanao del Sur', '15'),
(631, '2002', 'Cotabato DO', 'ARMM Compound, Cotabato City, Cotabato', '15'),
(632, '2003', 'Cotabato LC', 'ARMM Compound, Cotabato City, Cotabato', '15'),
(633, '2004', 'Bongao EO', 'Capitol Hills Road, Bongao, Tawi-Tawi', '15'),
(634, '2005', 'Jolo DO', 'Capitol Site, Bangkal Patikul, Jolo, Sulu', '15');

-- --------------------------------------------------------

--
-- Table structure for table `srvr_tbl`
--

CREATE TABLE `srvr_tbl` (
  `srvr_id` int(11) NOT NULL,
  `region` varchar(15) NOT NULL,
  `itsoi_count` int(10) NOT NULL,
  `site_code` varchar(5) NOT NULL,
  `site_name` varchar(15) NOT NULL,
  `asset_no` varchar(20) NOT NULL,
  `serial_no` varchar(20) NOT NULL,
  `brand` varchar(25) NOT NULL,
  `srvr_loc` varchar(25) NOT NULL,
  `srvr_brand_model` varchar(25) NOT NULL,
  `memory` varchar(15) NOT NULL,
  `WOS_2003` int(24) NOT NULL,
  `WOS_2012` int(24) NOT NULL,
  `WOS_2016` int(24) NOT NULL,
  `hp` int(10) NOT NULL,
  `ibm` int(10) NOT NULL,
  `xitrix` int(10) NOT NULL,
  `dell` int(10) NOT NULL,
  `lenovo` int(10) NOT NULL,
  `w_adles` int(10) NOT NULL,
  `ft_installers` int(10) NOT NULL,
  `net_2` int(10) NOT NULL,
  `net_4` int(10) NOT NULL,
  `net_4-7` int(10) NOT NULL,
  `install_iis` int(10) NOT NULL,
  `or_printing_patch` int(10) NOT NULL,
  `recomp_ver` varchar(15) NOT NULL,
  `batch_uploader_ver` varchar(15) NOT NULL,
  `anti_virus` varchar(15) NOT NULL,
  `cp_downloader` varchar(15) NOT NULL,
  `trojan_plate_integrator` varchar(15) NOT NULL,
  `site_stats` varchar(15) NOT NULL,
  `remarks` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `srvr_tbl`
--

INSERT INTO `srvr_tbl` (`srvr_id`, `region`, `itsoi_count`, `site_code`, `site_name`, `asset_no`, `serial_no`, `brand`, `srvr_loc`, `srvr_brand_model`, `memory`, `WOS_2003`, `WOS_2012`, `WOS_2016`, `hp`, `ibm`, `xitrix`, `dell`, `lenovo`, `w_adles`, `ft_installers`, `net_2`, `net_4`, `net_4-7`, `install_iis`, `or_printing_patch`, `recomp_ver`, `batch_uploader_ver`, `anti_virus`, `cp_downloader`, `trojan_plate_integrator`, `site_stats`, `remarks`) VALUES
(1, 'CAR', 1, '1400', 'Regional Office', '22396', 'Unreadable', 'IBM', 'Onsite', 'IBM x3200', '3 GB', 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', '', '', '', 'UP', ''),
(2, 'CAR', 1, '1404', 'Baguio DO', '38599', 'SGH735W0LH', 'HP', 'Onsite', 'HP Proliant ML110 Gen 9', '16 GB', 0, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', '', '', '', 'UP', ''),
(3, 'CAR', 1, '1406', 'Baguio LC', '41500', 'SGH809WBWW', 'HP', 'Onsite', 'HP Proliant ML110 Gen 9', '16 GB', 0, 1, 0, 1, 0, 0, 0, 0, 1, 1, 1, 1, 1, 0, 1, '', '', '', '', '', 'UP', ''),
(4, 'CAR', 1, '1408', 'Bangued DO', '42356', 'SHG838X5X9', 'HP', 'Onsite', 'HP Proliant ML110 Gen 10', '16 GB', 0, 1, 0, 1, 0, 0, 0, 0, 1, 1, 1, 1, 0, 0, 1, '', '', '', '', '', 'UP', 'LTMS site '),
(5, 'CAR', 1, '1412', 'Bontoc DO', '34519', '99F3628', 'IBM', 'Onsite', 'IBM x3200', '4 GB', 1, 0, 0, 0, 1, 0, 0, 0, 1, 1, 1, 1, 0, 0, 1, '', '', '', '', '', 'UP', 'For site validation'),
(6, 'CAR', 1, '1414', 'Luna DO', '35172', '99B9335', 'HP', 'Onsite', 'HP Proliant ML110 Gen 10', '16 GB', 0, 0, 1, 1, 0, 0, 0, 0, 1, 1, 1, 1, 0, 0, 1, '', '', '', '', '', 'UP', ''),
(7, 'CAR', 1, '1416', 'Lagawe DO', '7844', '4362IRS-99D1900', 'IBM', 'Onsite', 'IBM x3200', '3 GB', 1, 0, 0, 0, 1, 0, 0, 0, 1, 1, 1, 1, 0, 0, 1, '', '', '', '', '', 'UP', ''),
(8, 'CAR', 1, '1420', 'La Trinidad DO', '41499', 'SGH809WBBVY', 'HP', 'Onsite', 'HP Proliant ML110 Gen 9', '16 GB', 0, 1, 0, 1, 0, 0, 0, 0, 1, 1, 1, 1, 1, 0, 1, '', '', '', '', '', 'UP', ''),
(9, 'CAR', 1, '1424', 'Tabuk DO', '34323', '436854A', 'IBM', 'Onsite', 'IBM x3200', '4 GB', 1, 0, 0, 0, 1, 0, 0, 0, 1, 1, 1, 1, 0, 0, 1, '', '', '', '', '', 'UP', ''),
(10, 'CAR', 1, '1428', 'Alfonso Lista E', '1', '1', 'HP', 'Onsite', 'HP ML110 Gen 10', '16gig', 1, 0, 0, 0, 0, 1, 0, 0, 1, 1, 1, 1, 0, 0, 1, '', '', '', '', '', 'UP', ''),
(11, 'I', 1, '0100', 'Regional Office', '17636', '99A4768', 'IBM', 'Onsite', 'IBM x3200', '3gig', 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'v3.2', '15k.6a', '', '', '', 'Up', ''),
(12, 'I', 1, '0104', 'Agoo DO', '2076', '99C7645', 'IBM', 'Onsite', 'IBM x3200', '3gig', 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'v3.2', '15k.6a', '', '', '', 'Up', ''),
(13, 'I', 1, '0108', 'Alaminos DO', '42341', 'SGH838XSXO', 'HP', 'Onsite', 'HP Proliant ML110 Gen 10', '16gig', 0, 1, 0, 1, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 0, 'v3.2', '15k.6a', '', '', '', 'Up', ''),
(14, 'I', 1, '0110', 'Burgos EO', '12872', 'OSEP62200379', 'XITRIX', 'Onsite', 'XITRIX PowerFrame 5295', '1gig', 1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'v3.2', '15k.6a', '', '', '', 'Up', ''),
(15, 'I', 1, '0112', 'Batac DO', '17949', '', 'IBM', 'Onsite', 'IBM x3200', '3gig', 1, 0, 0, 0, 1, 0, 0, 0, 1, 1, 1, 1, 0, 1, 0, 'v3.2', '15k.6a', '', '', '', 'UP', ''),
(16, 'I', 1, '0116', 'Candon DO', '41482', 'SGH809WBWL', 'HP', 'Onsite', 'Hp Proliant ML110 Gen9', '16gig', 0, 1, 0, 1, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 0, 'v3.2', '15k.6a', '', '', '', 'Up', ''),
(17, 'I', 2, '0120', 'Dagupan DO', '38575', 'SGH735W0M0', 'HP', 'Onsite', 'Hp Proliant ML110 Gen9', '16gig', 0, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'v3.2', '15k.6a', '', '', '', 'Up', ''),
(18, 'I', 2, '0122', 'Dagupan LC', '22197', '99A0744', 'IBM', 'Onsite', 'IBM x3200', '3gig', 1, 0, 0, 0, 1, 0, 0, 0, 1, 1, 1, 1, 0, 1, 0, '', '', '', '', '', 'RTO', '         LTMS site'),
(19, 'I', 1, '0124', 'Laoag DO', '41481', 'SGH809WBWD', 'HP', 'Onsite', 'Hp Proliant ML110 Gen9', '16gig', 0, 1, 0, 1, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 0, 'v3.2', '15k.6a', '', '', '', 'UP', ''),
(20, 'I', 1, '0128', 'Lingayen DO', '41483', 'SGH809WBWA', 'HP', 'Onsite', 'Hp Proliant ML110 Gen9', '16gig', 0, 0, 1, 1, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 0, 'v3.2', '15k.6a', '', '', '', 'UP', ''),
(21, 'I', 1, '0130', 'Naguillan EO', '35178', '99B9336', 'IBM', 'Onsite', 'IBM x3200', '2gig', 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'v3.2', '15k.6a', '', '', '', 'UP', ''),
(22, 'I', 1, '0132', 'San Carlos DO', '38577', 'SGH735W0LE', 'HP', 'Onsite', 'HP Proliant ML110 Gen 10', '16gig', 0, 1, 0, 1, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 0, 'v3.2', '15k.6a', '', '', '', 'Up', ''),
(23, 'I', 1, '0134', 'San Fernando LC', '4780', '99A5558', 'IBM', 'Onsite', 'IBM x3200', '3gig', 1, 0, 0, 0, 1, 0, 0, 0, 1, 1, 1, 1, 0, 1, 0, 'v3.2', '15k.6a', '', '', '', 'Up', ''),
(24, 'I', 1, '0136', 'San Fernando DO', '38577', 'SGH735W0LE', 'HP', 'Onsite', 'Hp Proliant ML110 Gen9', '16gig', 0, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'v3.2', '15k.6a', '', '', '', 'Up', ''),
(25, 'I', 1, '0138', 'Rosales DO', '47450', 'SGH249TK68', 'HP', 'Onsite', 'HP Proliant ML110 Gen 10', '16gig', 0, 0, 1, 1, 0, 0, 0, 0, 1, 1, 1, 1, 0, 1, 0, 'v3.2', '15k.6a', '', '', '', 'Up', ''),
(26, 'I', 2, '0140', 'Urdaneta DO', '38576', 'SGH735W0L7', 'HP', 'Onsite', 'Hp Proliant ML110 Gen9', '16gig', 0, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'v3.2', '15k.6a', '', '', '', 'Up', ''),
(27, 'I', 2, '0142', 'Urdaneta LC', '2003', '99B0873', 'IBM', 'Onsite', 'IBM x3200', '3gig', 1, 0, 0, 0, 1, 0, 0, 0, 1, 1, 1, 1, 0, 1, 0, '', '', '', '', '', 'RTO', 'LTMS site'),
(28, 'I', 1, '0144', 'San Ildefonso D', '4575', '99A5564', 'IBM', 'Onsite', 'IBM x3200', '3gig', 1, 0, 0, 0, 1, 0, 0, 0, 1, 1, 1, 1, 0, 1, 0, 'v3.2', '15k.6a', '', '', '', 'Up', ''),
(29, 'I', 1, '0146', 'Bayambang EO', '42985', 'SGH913YLFN', 'HP', 'Onsite', 'HP Proliant ML110 Gen 10', '16gig', 0, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'v3.2', '15k.6a', '', '', '', 'Up', ''),
(30, 'III', 1, '0300', 'Regional Office', '7840', '99D1906', 'IBM', 'Onsite', 'IBM x3200', '3gig', 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', '', '', '', 'UP', ''),
(31, 'III', 1, '0301', 'New Registratio', '47494', 'SGH24TK2P', 'HP', 'Onsite', 'Hp Proliant ML110 Gen9', '16gig', 0, 1, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', '', '', '', 'UP', ''),
(32, 'III', 1, '0304', 'Angeles DO', '47464', 'SGH249TK4M', 'HP', 'Onsite', 'HP Proliant ML110 Gen 10', '16gig', 0, 0, 1, 1, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 0, '', '', '', '', '', 'UP', ''),
(33, 'III', 1, '0306', 'San Simon DO', '13569', '99D0071', 'IBM', 'Onsite', 'IBM x3200', '3gug', 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', '', '', '', 'UP', ''),
(34, 'III', 1, '0308', 'Balanga DO', '43243', 'SGH838XSWN', 'HP', 'Onsite', 'HP Proliant ML110 Gen 10', '16gig', 0, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', '', '', '', 'UP', ''),
(35, 'III', 1, '0312', 'Baler EO', '7842', '99D1905', 'IBM', 'Onsite', 'IBM x3200', '4gig', 1, 0, 0, 0, 1, 0, 0, 0, 1, 1, 1, 1, 0, 1, 0, '', '', '', '', '', 'UP', ''),
(36, 'III', 1, '0316', 'San Rafael DO (', '38574', 'SGH735W0LM', 'HP', 'Onsite', 'Hp Proliant ML110 Gen9', '16gig', 0, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', '', '', '', 'UP', ''),
(37, 'III', 1, '0320', 'Baloc DO', '47453', 'SGH249TK5L', 'HP', 'Onsite', 'Hp Proliant ML110 Gen9', '16gig', 0, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', '', '', '', 'UP', ''),
(38, 'III', 1, '0324', 'Bataan LC', '23521', '99B9718', 'IBM', 'Onsite', 'IBM x3200', '3gig', 1, 0, 0, 0, 0, 1, 0, 0, 1, 1, 1, 1, 0, 1, 0, '', '', '', '', '', 'Up', ' LTMS site'),
(39, 'III', 1, '0328', 'Bulacan LC', '200-708-000731', '99AO741', 'IBM', 'Onsite', 'IBM', '4gig', 1, 0, 0, 0, 1, 0, 0, 0, 1, 1, 1, 1, 0, 1, 0, '', '', '', '', '', 'RTO', 'LTMS site'),
(40, 'III', 1, '0332', 'Cabanatuan DO', '41471', 'SGH809WBWM', 'HP', 'Onsite', 'Hp Proliant ML110 Gen9', '8gig', 0, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', '', '', '', 'UP', ''),
(41, 'III', 1, '0336', 'Mabalacat EO', '42358', 'SGH838XSWR', 'HP', 'Onsite', 'HP Proliant ML110 Gen 10', '16gig', 0, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', '', '', '', 'UP', ''),
(42, 'III', 1, '0340', 'Gapan DO', '47454', 'SGH249TK5D', 'HP', 'Onsite', 'HP Proliant ML110 Gen 10', '16gig', 0, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', '', '', '', 'up', ''),
(43, 'III', 1, '0344', 'Guagua DO', '47493', 'SGH249TK3Y', 'HP', 'Onsite', 'HP Proliant ML110 Gen 10', '16gig', 0, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', '', '', '', 'UP', ''),
(44, 'III', 1, '0348', 'Iba DO', '3630', '99A4766', 'IBM', 'Onsite', 'IBM x3200', '2gig', 1, 0, 0, 0, 1, 0, 0, 0, 1, 1, 1, 1, 0, 1, 0, '', '', '', '', '', 'UP', ''),
(45, 'III', 1, '0352', 'Malolos DO', '42353', 'SGH838XSWK', 'HP', 'Onsite', 'HP Proliant ML110 Gen 10', '16gig', 0, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', '', '', '', 'UP', ''),
(46, 'III', 1, '0353', 'San Jose Del Mo', '43625', 'SGH936XYRR', 'HP', 'Onsite', 'HP Proliant ML110 Gen 10', '16gig', 0, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', '', '', '', 'RTO', 'LTMS site'),
(47, 'III', 1, '0356', 'Meycauayan DO', '41467', 'SGH809WBW6', 'HP', 'Onsite', 'Hp Proliant ML110 Gen9', '16gig', 0, 1, 0, 1, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 0, '', '', '', '', '', 'UP', ''),
(48, 'III', 1, '0360', 'Nueva Ecija LC', '47486', 'SGH249TK4J', 'HP', 'Onsite', 'HP Proliant ML110 Gen 10', '', 0, 0, 0, 0, 0, 1, 0, 0, 1, 1, 1, 1, 0, 1, 0, '', '', '', '', '', 'RTO', 'LTMS site'),
(49, 'III', 1, '0364', 'Olongapo DO', '46452', 'SGH137VC4S', 'HP', 'Onsite', 'HP Proliant ML110 Gen 10', '16gig', 0, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', '', '', '', 'UP', ''),
(50, 'III', 1, '0368', 'Palayan EO', '18522', '99A0713', 'IBM', 'Onsite', 'IBM X3200', '3gig', 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', '', '', '', 'UP', ''),
(51, 'III', 1, '0372', 'San Fernando LC', '34413', '99E4775', 'IBM', 'Onsite', 'IBM x3200', '4gig', 1, 0, 0, 0, 1, 0, 0, 0, 1, 1, 1, 1, 0, 1, 0, '', '', '', '', '', 'RTO', 'LTMS site'),
(52, 'III', 1, '0376', 'Paniqui EO', '3629', '200709-001858', 'IBM', 'Onsite', 'IBM x3200', '3gig', 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', '', '', '', 'UP', ''),
(53, 'III', 1, '0380', 'San Fernando DO', '38581', 'SGH735W0LL', 'HP', 'Onsite', 'Hp Proliant ML110 Gen9', '16gig', 0, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', '', '', '', 'UP', ''),
(54, 'III', 1, '0382', 'Angeles Extensi', '42986', 'SGH913YLFM', 'HP', 'Onsite', 'HP Proliant ML110 Gen 10', '16gig', 0, 1, 0, 1, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 0, '', '', '', '', '', 'UP', ''),
(55, 'III', 1, '0384', 'San Jose DO', '18666', '99B9717', 'IBM', 'Onsite', 'IBM x3200', '2gig', 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', '', '', '', 'UP', ''),
(56, 'III', 1, '0385', 'Sta. Maria DO', '41469', 'SGH809WBWT', 'HP', 'Onsite', 'Hp Proliant ML110 Gen9', '16gig', 0, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', '', '', '', 'UP', ''),
(57, 'III', 1, '0386', 'SBMA EO', '3882', '99A5536', 'IBM', 'Onsite', 'IBM x3200', '3gig', 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', '', '', '', 'UP', ''),
(58, 'III', 1, '0387', 'Capas EO', '7843', '99D1899', 'IBM', 'Onsite', 'IBM x3200', '3gig', 1, 0, 0, 0, 1, 0, 0, 0, 1, 1, 1, 1, 1, 1, 0, '', '', '', '', '', 'UP', ''),
(59, 'III', 1, '0388', 'Tarlac DO', '41470', 'SGH809WBX4', 'HP', 'Onsite', 'Hp Proliant ML110 Gen9', '16gig', 0, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', '', '', '', 'UP', ''),
(60, 'III', 2, '0389', 'New Registratio', '10787', '436256A-9902660', 'IBM', 'Onsite', 'IBM x3200', '1.5 GB', 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', '', '', '', 'UP', ''),
(61, 'III', 2, '0390', 'SBMA - MAIDRS', '2071', '99C7647', 'IBM', 'Onsite', 'IBM x3200', '3gig', 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', '', '', '', 'UP', ''),
(62, 'III', 1, '0392', 'Tarlac LC', '35175', '99B9358', 'IBM', 'Onsite', 'IBM X3200', '2gig', 1, 0, 0, 0, 1, 0, 0, 0, 1, 1, 1, 1, 0, 1, 0, '', '', '', '', '', 'RTO', 'LTMS site'),
(63, 'III', 1, '0399', 'Zambales LC', '3632', '99A4769', 'IBM', 'Onsite', 'IBM x3200', '3gig', 1, 0, 0, 0, 1, 0, 0, 0, 1, 1, 1, 1, 0, 1, 0, '', '', '', '', '', 'RTO', 'LTMS site'),
(64, 'IVB', 1, '0402', 'Regional Office', '7872', '99A5547', 'IBM', 'Onsite', 'IBM x3200', '2gig', 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'v3.2', '15k.6a', 'escan', 'n/a', 'n/a', 'Up', ''),
(65, 'IVB', 1, '0416', 'Boac DO', '42357', 'SGH838XSWG', 'HP', 'Onsite', 'HP Proliant ML110 Gen 10', '16gig', 0, 1, 0, 1, 0, 0, 0, 0, 1, 1, 0, 0, 1, 1, 0, 'v3.2', '15k.6a', 'escan', 'n/a', 'n/a', 'UP', ''),
(66, 'IVB', 1, '0424', 'Calapan DO', '38585', 'SGH7035W0LS', 'HP', 'Onsite', 'HP Proliant ML110 Gen 9', '16gig', 0, 1, 0, 1, 0, 0, 0, 0, 1, 1, 0, 0, 1, 1, 0, 'v3.2', '15k.6a', 'escan', 'n/a', 'n/a', 'UP', ''),
(67, 'IVB', 1, '0445', 'Brooke\'s Point ', '11234', '200710-000177|99A553', 'IBM', 'Onsite', 'IBM x3200', '3gig', 1, 0, 0, 0, 1, 0, 0, 0, 1, 1, 1, 1, 0, 1, 0, '', '', '', '', '', 'Up', ''),
(68, 'IVB', 1, '0456', 'Romblon DO', '14803', 'ESP36230195', 'XITRIX', 'Onsite', 'XITRIX PowerFrame 5295', '2gig', 1, 0, 0, 0, 0, 1, 0, 0, 1, 1, 1, 1, 0, 1, 0, '', '', '', '', '', 'Up', ''),
(69, 'IVB', 1, '0460', 'Palawan DO', '41497', 'SGH809WBWN', 'HP', 'Onsite', 'Hp Proliant Ml110 Gen9', '16gig', 0, 1, 0, 1, 0, 0, 0, 0, 1, 1, 0, 0, 1, 1, 0, 'v3.2', '15k.6a', 'escan', 'n/a', 'n/a', 'Up', ''),
(70, 'IVB', 1, '0461', 'Mamburao Distri', '6360', 'ESP36190119 | ESP361', 'HP', 'Onsite', 'Hp Proliant Ml110 Gen10', '3gig', 1, 0, 0, 0, 0, 1, 0, 0, 1, 1, 0, 0, 0, 0, 0, 'v3.2', '15k.6a', 'escan', 'n/a', 'n/a', 'Up', ''),
(71, 'IVB', 1, '0462', 'Pinamalayan EO', '21235', 'ESPG3260278', 'HP', 'Onsite', 'Hp Proliant Ml110 Gen10', '2gig', 1, 0, 0, 0, 1, 0, 0, 0, 1, 1, 1, 1, 0, 1, 0, 'v3.2', '15k.6a', 'escan', 'n/a', 'n/a', 'UP', ''),
(72, 'IVB', 1, '0465', 'Palawan EO', '10780', '99D2661', 'IBM', 'Onsite', 'IBM x3200', '4gig', 1, 0, 0, 0, 1, 0, 0, 0, 1, 1, 1, 1, 0, 1, 0, '', '', '', '', '', 'RTO', ''),
(73, 'IVB', 1, '0466', 'Sablayan EO', '41468', 'SGH809WBX5', 'HP', 'Onsite', 'ML110 Gen 9', '16gig', 0, 1, 0, 0, 1, 0, 0, 0, 1, 1, 0, 1, 1, 1, 0, 'v3.2', '15k.6a', 'escan', 'n/a', 'n/a', 'UP', ''),
(74, 'IVB', 1, '0468', 'San Jose DO', '4285', '99A0737/99A0724', 'IBM', 'Onsite', 'IBM x3200', '4gig', 1, 0, 0, 0, 1, 0, 0, 0, 1, 1, 1, 1, 0, 1, 0, '', '', '', '', '', 'UP', ''),
(75, 'IVB', 1, '0458', 'San Agustin ', '1', '', 'XITRIX', 'Onsite', 'XITRIX PowerFrame 5295', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', '', '', '', '', ''),
(76, 'IVB', 1, '0469', 'Victoria EO', '34525', '99F3626', 'IBM', 'Onsite', 'IBM x3200 M2', '2GB', 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', '', '', '', '', ''),
(77, 'IVB', 1, '0434', 'Coron EO', '18735', 'ESP36260093', 'XITRIX', 'Onsite', 'XITRIX PowerFrame 5295', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', '', '', '', '', ''),
(78, 'V', 1, '0500', 'Regional Office', '3244', '99A4764', 'IBM', 'Onsite', 'IBM', '2 GB', 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'v3.2', '15k.6a', '', '', '', 'Up', 'dotnet 1.1'),
(79, 'V', 1, '0501', 'New Registratio', '46455', 'SGH137VC49', 'HP', 'Onsite', 'HP Pro Gen10', '16 GB', 0, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'v3.2', '15k.7', '', '', '', 'UP', ''),
(80, 'V', 1, '0504', 'Daet DO', '13408', '99A0725', 'HP', 'Onsite', 'IBM', '2 GB', 1, 0, 0, 0, 1, 0, 0, 0, 1, 0, 1, 1, 0, 0, 0, '', '', '', '', '', 'Up', ''),
(81, 'V', 1, '0508', 'Partido DO', '47491', 'SGH249TK5Z', 'HP', 'Onsite', 'XITRIX PowerFrame 5295', '2 GB', 1, 0, 0, 0, 0, 1, 0, 0, 1, 1, 1, 1, 0, 1, 0, 'v3.2', '15k.6a', '', '', '', 'RTO', 'Server hardware problem -  for'),
(82, 'V', 1, '0512', 'Ligao DO (Guino', '42355', 'SGH838XSWZ', 'HP', 'Onsite', 'HP Pro Gen10', '16 GB', 0, 1, 0, 1, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 0, 'v3.2', '15k.6a', '', '', '', 'UP', ''),
(83, 'V', 1, '0516', 'Iriga DO', '41485', 'SGH809WBWJ', 'HP', 'Onsite', 'HP Pro Gen9', '16 GB', 0, 1, 0, 1, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 0, 'v3.2', '15k.6a', '', '', '', 'UP', ''),
(84, 'V', 1, '0524', 'Legaspi DO', '38586', 'SGH735WOLA', 'HP', 'Onsite', 'HP Pro Gen9', '16 GB', 0, 1, 0, 1, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 0, 'v3.2', '15k.6a', '', '', '', 'UP', ''),
(85, 'V', 1, '0528', 'Masbate DO', '47463', 'SGH249FK3G', 'HP', 'Onsite', 'HP Pro Gen10', '16 GB', 0, 0, 1, 1, 0, 0, 0, 0, 1, 1, 1, 1, 0, 1, 0, 'v3.2', '15k.6a', '', '', '', 'Up', ''),
(86, 'V', 2, '0532', 'Naga DO', '41484', 'SGH809WBW1', 'HP', 'Onsite', 'HP ', '16 GB', 0, 1, 0, 1, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 0, 'v3.2', '15k.6a', '', '', '', 'UP', ''),
(87, 'V', 1, '0534', 'Ragay DO', '34410', '99Z6915', 'IBM', 'Onsite', 'IBM x3200', '4 GB', 1, 0, 0, 0, 1, 0, 0, 0, 1, 1, 1, 1, 0, 1, 0, 'v3.2', '15k.6a', '', '', '', 'UP', ''),
(88, 'V', 1, '0536', 'Sorsogon DO', '42345', 'SGH838XSWY', 'HP', 'Onsite', 'HP Pro Gen10', '16 GB', 0, 1, 0, 1, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 0, 'v3.2', '15k.6a', '', '', '', 'UP', ''),
(89, 'V', 2, '0537', 'Pamplona EO', '1', '', 'XITRIX', 'Onsite', 'XITRIX PowerFrame 5295', '8 GB', 0, 1, 0, 0, 0, 0, 1, 0, 1, 1, 1, 1, 1, 1, 0, 'v3.2', '15k.6a', '', '', '', 'UP', ''),
(90, 'V', 1, '0540', 'Tabaco DO', '47466', 'SGH249TK6G', 'HP', 'Onsite', 'HP Pro Gen10', '2 GB', 0, 0, 1, 1, 0, 0, 0, 0, 1, 1, 1, 1, 0, 1, 0, 'v3.2', '15k.6a', '', '', '', 'UP', ''),
(91, 'V', 1, '0544', 'Virac DO', '19617', '99A0731', 'IBM', 'Onsite', 'IBM', '3 GB', 1, 0, 0, 0, 1, 0, 0, 0, 1, 1, 1, 1, 0, 1, 0, '', '', '', '', '', 'RTO', 'Defective modem - modem is now'),
(92, 'II', 1, '0200', 'Regional Office', '47452', 'SGH249TK5H', 'HP', 'Onsite', 'Hp Proliant Ml110 Gen9', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', '', '', '', '', ''),
(93, 'II', 1, '0204', 'Aparri District', '41496', 'SGH809WBX0', 'HP', 'Onsite', 'HP Proliant ML110 Gen 9', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', '', '', '', '', ''),
(94, 'II', 1, '0210', 'Aritao Extensio', '3353', '9980875', 'IBM', 'Onsite', '', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', '', '', '', '', ''),
(95, 'II', 1, '0212', 'Basco District ', '6697', 'QSEP61800040', 'XITRIX', 'Onsite', '', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', '', '', '', '', ''),
(96, 'II', 1, '0216', 'Bayombong Distr', '41498', 'SGH809WBX2', 'HP', 'Onsite', 'HP Proliant ML110 Gen 9', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', '', '', '', '', ''),
(97, 'II', 1, '0218', 'Cabagan Extensi', '3847', '99A4781', 'IBM', 'Onsite', '', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', '', '', '', '', ''),
(98, 'II', 1, '0220', 'Cabarroguis Dis', '47451', 'SGH249TK5S', 'HP', 'Onsite', 'HP Proliant ML110 ', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', '', '', '', '', ''),
(99, 'II', 1, '0224', 'Cauayan Distric', '41491', 'SGH809WBW8', 'HP', 'Onsite', 'HP Proliant ML110 Gen 9', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', '', '', '', '', ''),
(100, 'II', 1, '0226', 'Gattaran Extens', '13566', '99A5555', 'IBM', 'Onsite', '', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', '', '', '', '', ''),
(101, 'II', 1, '0228', 'Ilagan District', '4781', '99A5541', 'IBM', 'Onsite', '', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', '', '', '', '', ''),
(102, 'II', 1, '0231', 'Tuao Extension ', '69181', '', 'IBM', 'Onsite', '', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', '', '', '', '', ''),
(103, 'II', 1, '0232', 'Roxas District ', '42352', 'SGH838XSWD', 'HP', 'Onsite', 'HP Proliant ML110 Gen 10', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', '', '', '', '', ''),
(104, 'II', 1, '0236', 'Sanchez Mira Ex', '43627', 'SGH936XYRS', 'HP', 'Onsite', 'HP Proliant ML110 Gen 10', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', '', '', '', '', ''),
(105, 'II', 1, '0240', 'San Isidro Dist', '42342', 'SGH838XSWF', 'HP', 'Onsite', 'HP Proliant ML110 Gen 10', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', '', '', '', '', ''),
(106, 'II', 1, '0242', 'Santiago Extens', '1', '', 'HP', 'Onsite', '', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', '', '', '', '', ''),
(107, 'II', 1, '0244', 'Tuguegarao Dist', '38578', 'SGH735W0MG', 'HP', 'Onsite', 'HP Proliant ML110 Gen 9', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', '', '', '', '', ''),
(108, 'II', 1, '0248', 'Tuguegarao Lice', '6507', '200708-000717', 'IBM', 'Onsite', '', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', '', '', '', '', ''),
(109, 'II', 1, '0227', 'Alicia DO', '1', '', 'XITRIX', 'onsite', '', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', '', '', '', '', ''),
(110, 'IVA', 1, '0400', 'Regional Office', '34518', '99F3921', 'IBM', 'Onsite', 'IBM x3200 ', '4gig', 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'v3.2', '15k.6a', 'escan', '3', 'n/a', 'Up', ''),
(111, 'IVA', 1, '0404', 'Batangas DO', '42360', 'SGH838XSWH', 'HP', 'Onsite', 'HP Proliant ML110 Gen 10', '16gig', 0, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'v3.2', '15k.6a', 'escan', 'n/a', 'n/a', 'Up', ''),
(112, 'IVA', 1, '0408', 'Batangas LC', '19243', 'ESP36230231', 'HP', 'Onsite', 'HP Proliant ML110 Gen 10', '2gig', 1, 0, 0, 0, 0, 1, 0, 0, 1, 1, 1, 1, 0, 1, 0, '', '', '', '', '', 'Up', ''),
(113, 'IVA', 1, '0410', 'Binan LC', '21229', '200708-000703', 'IBM', 'Onsite', 'IBM x3200', '3gig', 1, 0, 0, 0, 1, 0, 0, 0, 1, 1, 1, 1, 0, 1, 0, 'v3.2', '15k.6a', 'escan', 'n/a', 'n/a', 'UP', ''),
(114, 'IVA', 1, '0411', 'Catanauan Exten', '23713', 'QSEP61800487', 'XITRIX', 'Onsite', 'XITRIX PowerFrame 5295', '4gig', 1, 0, 0, 0, 0, 1, 0, 0, 1, 1, 1, 1, 0, 1, 0, 'v3.2', '15k.6a', 'escan', 'n/a', 'n/a', 'UP', ''),
(115, 'IVA', 1, '0412', 'Bacoor DO', '41472', 'SGH8089WBWB', 'HP', 'Onsite', 'HP Proliant ML110 Gen 9', '16gig', 0, 1, 0, 1, 0, 0, 0, 0, 1, 1, 0, 0, 1, 1, 0, 'v3.2', '15k.6a', 'escan', 'n/a', 'n/a', 'UP', ''),
(116, 'IVA', 1, '0414', 'Dasmarinas DO', '4576', '99A5557', 'IBM ', 'Onsite', 'IBM x3200', '2gig', 1, 0, 0, 0, 1, 0, 0, 0, 1, 1, 1, 1, 0, 1, 0, 'v3.2', '15k.6a', 'escan', 'n/a', 'n/a', 'UP', ''),
(117, 'IVA', 1, '0420', 'Cabuyao DO (Bin', '41473', 'SGH809WBW4', 'HP', 'Onsite', 'HP Proliant ML110 Gen 9', '16gig', 0, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'v3.2', '15k.6a', 'escan', 'n/a', 'n/a', 'UP', ''),
(118, 'IVA', 1, '0422', 'Calamba DO', '38583', 'SGH735W0M4', 'HP', 'Onsite', 'HP Proliant ML110 Gen 9', '16gig', 0, 1, 0, 1, 0, 0, 0, 0, 1, 1, 0, 0, 1, 1, 0, 'v3.2', '15k.6a', 'escan', 'n/a', 'n/a', 'UP', ''),
(119, 'IVA', 1, '0428', 'Kawit DO', '38584', 'SGH735W0LY', 'HP', 'Onsite', 'HP Proliant ML110 Gen 9', '16gig', 0, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'v3.2', '15k.6a', 'escan', 'n/a', 'n/a', 'UP', ''),
(120, 'IVA', 1, '0430', 'Carmona DO', '47455', 'SGH249TK3V', 'HP', 'Onsite', 'HP Proliant ML110 Gen 10', '16gig', 0, 0, 1, 1, 0, 0, 0, 0, 1, 1, 1, 1, 0, 1, 0, 'v3.2', '15k.6a', 'escan', 'n/a', 'n/a', 'UP', ''),
(121, 'IVA', 1, '0432', 'Cavite LC', '34523', '99F5462', 'IBM', 'Onsite', 'IBM x3200', '3gig', 1, 0, 0, 0, 1, 0, 0, 0, 1, 1, 1, 0, 0, 1, 0, '', '', '', '', '', 'RTO', ''),
(122, 'IVA', 1, '0436', 'Gumaca DO', '47456', 'SGH249TK2Z', 'HP', 'Onsite', 'Hp Proliant Ml110 Gen10', '16gig', 0, 0, 1, 1, 0, 0, 0, 0, 1, 1, 1, 1, 0, 1, 0, 'v3.2', '15k.6a', 'escan', 'n/a', 'n/a', 'UP', ''),
(123, 'IVA', 1, '0440', 'Laguna LC', '3848', '99A4768', 'IBM', 'Onsite', 'IBM x3200', '3gig', 1, 0, 0, 0, 1, 0, 0, 0, 1, 1, 1, 1, 0, 1, 0, '', '', '', '', '', '', ''),
(124, 'IVA', 1, '0444', 'Balayan EO', '3878', '99A5563', 'IBM', 'Onsite', 'IBM x3200', '2gig', 1, 0, 0, 0, 1, 0, 0, 0, 1, 1, 0, 0, 1, 1, 0, '', '', '', '', '', 'RTO', 'RTO (10/16/2023)'),
(125, 'IVA', 1, '0448', 'Lipa DO', '38582', 'SGH735W0M3', 'HP', 'Onsite', 'Hp Proliant Ml110 Gen9', '16gig', 0, 1, 0, 1, 0, 0, 0, 0, 1, 1, 0, 0, 1, 1, 0, 'v3.2', '15k.6a', 'escan', 'n/a', 'n/a', 'UP', ''),
(126, 'IVA', 1, '0452', 'Lucena DO', '46453', 'SGH137VC4Z', 'HP', 'Onsite', 'Hp Proliant Ml110 Gen10', '16gig', 0, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', '', '', '', 'RTO', 'RTO (10/16/2023)'),
(127, 'IVA', 1, '0454', 'Morong EO', '23897', 'ESP36230185', 'HP', 'Onsite', 'XITRIX PowerFrame 5295', '2gig', 1, 0, 0, 0, 0, 1, 0, 0, 1, 1, 1, 1, 0, 1, 0, 'v3.2', '15k.6a', 'escan', 'n/a', 'n/a', 'UP', ''),
(128, 'IVA', 1, '0457', 'Naic EO', '4802', '43621RS-99C1531', 'IBM', 'Onsite', 'IBM x3200', '3gig', 1, 0, 0, 0, 1, 0, 0, 0, 1, 1, 1, 1, 0, 1, 0, 'v3.2', '15k.6a', 'escan', 'n/a', 'n/a', 'UP', ''),
(129, 'IVA', 1, '0464', 'Quezon LC', '24141', 'ESP36230246', 'HP', 'Onsite', 'XITRIX PowerFrame 5295', '2gig', 1, 0, 0, 0, 0, 1, 0, 0, 1, 1, 1, 1, 0, 1, 0, 'v3.2', '15k.6a', 'escan', 'n/a', 'n/a', '', ''),
(130, 'IVA', 1, '0471', 'Alabat EO', '00776', 'ESP96261068', 'HP', 'Onsite', 'XITRIX PowerFrame 5295', '2gig', 1, 0, 0, 0, 0, 1, 0, 0, 1, 1, 1, 1, 0, 1, 0, '', '', '', '', '', 'RTO', ''),
(131, 'IVA', 1, '0472', 'San Pablo DO', '46454', 'SGH137VC4P', 'HP', 'Onsite', 'HP Proliant ML110 Gen 10', '16gig', 0, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', '', '', '', 'UP', ''),
(132, 'IVA', 1, '0476', 'Sta. Cruz \"Pila', '42344', 'SGH838XSWS', 'HP', 'Onsite', 'HP Proliant ML110 Gen 10', '16gig', 0, 1, 0, 1, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 0, '', '', '', '', '', 'UP', ''),
(133, 'IVA', 1, '0478', 'Tanay EO', '1', '', 'Dell', '', 'Dell EMC Poweredge T440', '8gig', 0, 1, 0, 0, 0, 0, 1, 0, 1, 1, 0, 0, 1, 1, 0, '', '', '', '', '', 'UP', ''),
(134, 'IVA', 1, '0480', 'Tagaytay EO', '42354', 'SG838XSX8', 'HP', 'Onsite', 'HP Proliant ML110 Gen 10', '16gig', 0, 1, 0, 1, 0, 0, 0, 0, 1, 1, 0, 0, 1, 1, 0, '', '', '', '', '', 'UP', ''),
(135, 'IVA', 1, '0482', 'Tagkawayan EO', '10476', 'ESP36190019', 'XITRIX', '', 'XITRIX PowerFrame 5295', '2gig', 1, 0, 0, 0, 0, 1, 0, 0, 1, 1, 1, 1, 0, 1, 0, '', '', '', '', '', 'UP', ''),
(136, 'IVA', 1, '0484', 'Binangonan EO', '41474', 'SGH809WBX1', 'HP', 'Onsite', 'HP Proliant ML110 Gen 9', '16gig', 0, 1, 0, 1, 0, 0, 0, 0, 1, 1, 0, 0, 1, 1, 0, '', '', '', '', '', 'UP', ''),
(137, 'IVA', 1, '0488', 'Cainta EO', '32758', 'P39Y9431', 'IBM', 'LTO CAINTA EO', 'IBM x3200', '2gig', 1, 0, 0, 0, 1, 0, 0, 0, 1, 1, 1, 1, 0, 0, 0, '', '', '', '', '', 'UP', ''),
(138, 'IVA', 1, '0489', 'Antipolo Extens', '1', '54571AA-06GTKTR', 'IBM', 'Onsite', 'IBM x3100 M5', '8gig', 0, 1, 0, 0, 1, 0, 0, 0, 1, 1, 0, 0, 1, 1, 0, '', '', '', '', '', 'UP', ''),
(139, 'IVA', 1, '0492', 'Taal EO', '3881', '43621rs-99a5546', 'IBM', 'Onsite', 'IBM x3200 M2', '3gig', 1, 0, 0, 0, 1, 0, 0, 0, 1, 1, 1, 1, 0, 1, 0, '', '', '', '', '', 'UP', ''),
(140, 'VI', 1, '0600', 'Regional Office', '4289', '99A5554', 'IBM', 'Onsite', 'IBM x3200', '2gig', 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'v3.2', '15k.6a', '', '', '', 'Up', ''),
(141, 'VI', 1, '0604', 'Bacolod City DO', '38587', 'SGH735W0LN', 'HP', 'Onsite', 'HP ML110 Gen 9', '16gig', 0, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'v3.2', '15k.6a', '', '', '', 'Up', ''),
(142, 'VI', 1, '0606', 'Barotac Viejo D', '3872', '99A5556', 'IBM', 'Onsite', 'IBM x3200', '3gig', 1, 0, 0, 0, 1, 0, 0, 0, 1, 1, 1, 1, 0, 1, 0, 'v3.2', '15k.6a', '', '', '', 'Up', ''),
(143, 'VI', 1, '0608', 'Himamaylan DO', '41477', 'SGH809WBWX', 'HP', 'Onsite', 'HP ML110 Gen 9', '16gig', 0, 1, 0, 1, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 0, 'v3.2', '15k.6a', '', '', '', 'Up', ''),
(144, 'VI', 1, '0610', 'Sipalay DO', '1', '1', 'HP', 'Onsite', 'HP ML110 Gen 10', '16gig', 1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'v3.2', '15k.6a', '', '', '', 'Up', ''),
(145, 'VI', 1, '0612', 'Cadiz DO', '11682', '99A5542', 'IBM', 'Onsite', 'IBM x3200', '3gig', 1, 0, 0, 0, 1, 0, 0, 0, 1, 1, 1, 1, 0, 1, 0, '', '', '', '', '', 'Up', ''),
(146, 'VI', 1, '0616', 'Calinog DO', '41476', 'SGH809WBW2', 'HP', 'Onsite', 'HP ML110 Gen 9', '16gig', 0, 1, 0, 1, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 0, 'v3.2', '15k.6a', '', '', '', 'Up', ''),
(147, 'VI', 1, '0618', 'Guimaras DO', '34412', '99E6913', 'IBM', 'Onsite', 'IBM x3200', '4gig', 1, 0, 0, 0, 1, 0, 0, 0, 1, 1, 1, 1, 0, 1, 0, '', '', '', '', '', 'RTO', ' LTMS site and due for site tr'),
(148, 'VI', 1, '0619', 'Guimbal EO', '47462', 'SGH249TK59', 'HP', 'Onsite', 'HP ML110 Gen 10', '16gig', 0, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'v3.2', '15k.6a', '', '', '', 'Up', ''),
(149, 'VI', 1, '0620', 'Iloilo City DO', '38588', 'SGH735W0L9', 'HP', 'Onsite', 'HP ML110 Gen 9', '16gig', 0, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'v3.2', '15k.6a', '', '', '', 'Up', ''),
(150, 'VI', 1, '0624', 'Iloilo LC', '1', '', 'HP', 'Onsite', 'HP ML110 Gen 10', '16gig', 0, 1, 0, 1, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 0, 'v3.2', '15k.6a', '', '', '', 'Up', 'Xitrix Server Pulled Out confi'),
(151, 'VI', 1, '0628', 'Kalibo DO', '38589', 'SGH73510OLB', 'HP', 'Onsite', 'HP ML110 Gen 9', '16gig', 0, 1, 0, 1, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 0, 'v3.2', '15k.6a', '', '', '', 'Up', ''),
(152, 'VI', 1, '0630', 'Pontevedra EO', '42361', 'SGH838XSX2', 'HP', 'Onsite', 'HP ML110 Gen 10', '16gig', 0, 1, 0, 1, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 0, 'v3.2', '15k.6a', '', '', '', 'Up', ''),
(153, 'VI', 1, '0632', 'Negros Occident', '34409', '99E4760', 'HP', 'Onsite', 'HP ML110 Gen 9', '16gig', 0, 1, 0, 1, 0, 0, 0, 0, 1, 1, 1, 1, 0, 1, 0, 'v3.2', '15k.6a', '', '', '', 'Up', ''),
(154, 'VI', 1, '0634', 'Passi EO', '1', '', 'HP', 'Onsite', 'HP ML110 Gen 9', '16gig', 0, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'v3.2', '15k.6a', '', '', '', 'Up', ''),
(155, 'VI', 1, '0635', 'Pilar EO', '3294', '436256A-99A0743', 'HP', 'Onsite', 'HP ML110 Gen 10', '16gig', 0, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'v3.2', '15k.6a', '', '', '', 'Up', ''),
(156, 'VI', 1, '0636', 'Roxas City DO', '1', '', 'HP', 'Onsite', 'HP ML110 Gen 9', '16gig', 0, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'v3.2', '15k.6a', '', '', '', 'Up', ''),
(157, 'VI', 1, '0640', 'San Carlos DO', '3422', '99E4772', 'IBM', 'Onsite', 'IBM x3200', '4gig', 1, 0, 0, 0, 1, 0, 0, 0, 1, 1, 1, 1, 0, 1, 0, 'v3.2', '15k.6a', '', '', '', 'Up', ''),
(158, 'VI', 1, '0644', 'Antique DO', '42362', 'SGH838XSX5', 'HP', 'Onsite', 'HP ML110 Gen 10', '16gig', 0, 1, 0, 1, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 0, 'v3.2', '15k.6a', '', '', '', 'Up', ''),
(159, 'VI', 1, '0650', 'Dumalag EO (Sig', '2761', '', 'IBM', 'Onsite', 'IBM X3200', '1gig', 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'v3.2', '15k.6a', '', '', '', 'Up', ''),
(160, 'VII', 1, '0700', 'Regional Office', '30836', '4362IRS-99A5549', 'IBM', 'Onsite', 'IBM x3200', '3gig', 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'v3.2', '15k.6a', '', '', '', 'UP', ''),
(161, 'VII', 1, '0701', 'New Registratio', '1', '1', 'HP', 'Onsite', 'HP ML110 Gen 10', '16gig', 0, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'v3.2', '15k.6a', '', '', '', 'UP', ''),
(162, 'VII', 1, '0702', 'Malasakit LC', '1', '1', 'HP', 'Onsite', 'HP ML110 Gen 10', '16gig', 0, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'v3.2', '15k.6a', '', '', '', 'UP', 'Xitrix Server Pulled Out confi'),
(163, 'VII', 1, '0703', 'MAIDRS - RO7', '3883', '', 'HP', 'Onsite', 'HP ML110 Gen 10', '16gig', 0, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'v3.2', '15k.6a', '', '', '', 'UP', ''),
(164, 'VII', 1, '0704', 'Bais DO', '4288', '4362IRS-99A5532', 'IBM', 'Onsite', 'IBM x3200', '3gig', 1, 0, 0, 0, 1, 0, 0, 0, 1, 1, 1, 1, 0, 1, 0, 'v3.2', '15k.6a', '', '', '', 'UP', ''),
(165, 'VII', 1, '0706', 'Bayawan EO', '12031', '', 'IBM', 'Onsite', 'IBM x3200', '3gig', 1, 0, 0, 0, 1, 0, 0, 0, 1, 1, 1, 1, 0, 1, 0, 'v3.2', '15k.6a', '', '', '', 'UP', ''),
(166, 'VII', 1, '0712', 'Carcar DO', '42346', 'SGH838XSX3', 'HP', 'Onsite', 'HP ML110 Gen 9', '16gig', 0, 1, 0, 1, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 0, 'v3.2', '15k.6a', '', '', '', 'UP', ''),
(167, 'VII', 1, '0714', 'Dalaguete DO', '37621', 'QSEP62200345', 'IBM', 'Onsite', 'IBM x3200', '2gig', 1, 0, 0, 0, 1, 0, 0, 0, 1, 1, 1, 1, 0, 1, 0, 'v3.2', '15k.6a', '', '', '', 'Up', ''),
(168, 'VII', 1, '0716', 'Cebu City DO', '38592', 'SGH735W0LK', 'HP', 'Onsite', 'HP ML110 Gen 9', '16gig', 0, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'v3.2', '15k.6a', '', '', '', 'UP', ''),
(169, 'VII', 2, '0751', 'Talisay EO', '38590', 'SGH735W0M2', 'HP', 'Onsite', 'HP ML110 Gen 9', '16gig', 0, 1, 0, 1, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 0, 'v3.2', '15k.6a', '', '', '', 'RTO', 'LTMS site with network switch '),
(170, 'VII', 1, '0720', 'Cebu City LC', '7939', '200708-000724', 'IBM', 'Onsite', 'IBM x3200', '3gig', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', '', '', '', 'RTO', ' LTMS site w/ unsettled networ'),
(171, 'VII', 1, '0724', 'Danao DO', '42359', '', 'HP', 'Onsite', 'HP ML110 Gen 10', '16gig', 0, 1, 0, 1, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 0, '', '', '', '', '', 'RTO', 'LTMS site'),
(172, 'VII', 1, '0728', 'Dumaguete DO', '41479', 'SGH809WBW', 'HP', 'Onsite', 'HP ML110', '16gig', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', '', '', '', 'RTO', ''),
(173, 'VII', 1, '0730', 'Jagna EO', '2006', '99B0876', 'IBM', 'Onsite', 'IBM x3200', '3gig', 1, 0, 0, 0, 1, 0, 0, 0, 1, 1, 1, 1, 0, 1, 0, 'v3.2', '15k.6a', '', '', '', 'UP', ''),
(174, 'VII', 1, '0732', 'Mandaue DO', '38591', 'SGH735W0M1', 'HP', 'Onsite', 'HP ML110', '16gig', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', '', '', '', 'RTO', ''),
(175, 'VII', 1, '0736', 'Mandaue City LC', '4577', '', 'IBM', 'Onsite', 'IBM x3200', '2gig', 1, 0, 0, 0, 1, 0, 0, 0, 1, 1, 1, 1, 0, 1, 0, '', '', '', '', '', 'RTO', ''),
(176, 'VII', 1, '0738', 'Medellin EO', '32760', '436854A-9907409', 'IBM', 'Onsite', 'IBM x3200', '3gig', 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'v3.2', '15k.6a', '', '', '', 'Up', ''),
(177, 'VII', 1, '0739', 'Camotes Island ', '13144', 'QSEP62200345', 'XITRIX', 'Onsite', 'XITRIX PowerFrame 5295', '2gig', 1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', '', '', '', 'UP', ''),
(178, 'VII', 1, '0741', 'La Libertad DO', '1991', '99B9866', 'IBM', 'Onsite', 'IBM x3200', '3gig', 1, 0, 0, 0, 1, 0, 0, 0, 1, 1, 1, 1, 0, 1, 0, 'v3.2', '15k.6a', '', '', '', 'UP', ''),
(179, 'VII', 1, '0742', 'Bantayan EO', '4286', '43621RS-99A4777', 'IBM', 'Onsite', 'IBM X3200', '2gig', 1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'v3.2', '15k.6a', '', '', '', 'UP', ''),
(180, 'VII', 1, '0743', 'Ronda DO', '29432', '436754A-99B6944', 'IBM', 'Onsite', 'IBM x3200', '2gig', 1, 0, 0, 0, 1, 0, 0, 0, 1, 1, 1, 1, 0, 1, 0, 'v3.2', '15k.6a', '', '', '', 'UP', ''),
(181, 'VII', 1, '0744', 'Siquijor DO', '1989', '99B9865', 'IBM', 'Onsite', 'IBM x3200', '3gig', 1, 0, 0, 0, 1, 0, 0, 0, 1, 1, 1, 1, 0, 1, 0, 'v3.2', '15k.6a', '', '', '', 'Up', ''),
(182, 'VII', 1, '0748', 'Tagbilaran DO', '41480', 'SGH80NUWBF', 'HP', 'Onsite', 'HP ML110', '16gig', 0, 1, 0, 1, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 0, 'v3.2', '15k.6a', '', '', '', 'Up', ''),
(183, 'VII', 1, '0752', 'Toledo DO', '777', '99A4780', 'IBM', 'Onsite', 'IBM x3200', '3gig', 1, 0, 0, 0, 1, 0, 0, 0, 1, 1, 1, 1, 0, 1, 0, 'v3.2', '15k.6a', '', '', '', 'Up', ''),
(184, 'VII', 1, '0753', 'Talibon EO', '29439', '99B6946', 'IBM', 'Onsite', 'IBM x3200', '3gig', 1, 0, 0, 0, 1, 0, 0, 0, 1, 1, 1, 1, 0, 1, 0, 'v3.2', '15k.6a', '', '', '', 'Up', ''),
(185, 'VII', 1, '0760', 'Lapu-Lapu EO', '41478', 'SGH809WBW0', 'HP', 'Onsite', 'HP ML110 Gen 9', '16gig', 0, 1, 0, 1, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 0, 'v3.2', '15k.6a', '', '', '', 'Up', ''),
(186, 'IX', 1, '0900', 'Regional Office', '47472', 'SGH249TK53', 'HP', 'Onsite', 'HP ML110 Gen 10', '16gig', 0, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '3.2', '15k6a', 'escan', '', '', 'UP', ''),
(187, 'IX', 1, '0901', 'New Registratio', '47489', 'SGH249TK4B', 'HP', 'Onsite', 'HP ML110 Gen 10', '16gig', 0, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '3.2', '15k7', 'escan', '', '', 'UP', ''),
(188, 'IX', 1, '0904', 'Basilan DO', '4902', '99A4772', 'IBM', 'Onsite', 'IBM x3200', '3gig', 1, 0, 0, 0, 1, 0, 0, 0, 1, 1, 1, 1, 0, 1, 0, '3.2', '15k6a', 'escan', '', '', 'UP', ''),
(189, 'IX', 1, '0907', 'Buug EO', '14567', '99A4773', 'IBM', 'Onsite', 'IBM x3200', '3gig', 1, 0, 0, 0, 1, 0, 0, 0, 1, 1, 1, 1, 0, 1, 0, '3.2', '15k4', 'escan', '', '', 'UP', ''),
(190, 'IX', 1, '0908', 'Dipolog DO', '41488', 'SGH809WBW7', 'HP', 'Onsite', 'HP ML110 Gen 9', '16gig', 0, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '3.2', '15k6a', 'escan', '', '', 'UP', ''),
(191, 'IX', 2, '0910', 'MAIDRS - Dipolo', '22613', 'QSEP62601387', 'XITRIX', 'Onsite', 'XITRIX PowerFrame 5295', '2gig', 1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, '3.2', '15k6a', 'escan', '', '', 'UP', ''),
(192, 'IX', 2, '0912', 'Ipil DO', '47471', 'SGH249TK7B', 'HP', 'Onsite', 'HP ML110 Gen 10', '16gig', 0, 0, 1, 1, 0, 0, 0, 0, 1, 1, 1, 1, 0, 1, 0, '3.2', '15k6a', 'escan', '', '', 'UP', ''),
(193, 'IX', 2, '0913', 'MAIDRS - Ipil', '18443', 'QSEP62601194', 'XITRIX', 'Onsite', 'XITRIX PowerFrame 5295', '2gig', 1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, '3.2', '15k6a', 'escan', '', '', 'UP', ''),
(194, 'IX', 2, '0920', 'Pagadian DO/MAI', '41492', 'SGH809WBWY', 'HP', 'Onsite', 'HP ML110 Gen 9', '16gig', 0, 1, 0, 1, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 0, '3.2', '15k6a', 'escan', '', '', 'UP', ''),
(195, 'IX', 2, '0922', 'MAIDRS - Pagadi', '10781', '436256A-99D2662', 'IBM', 'Onsite', 'IBM x3200 M2', '4 GB', 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', '', '', '', 'RTO', ''),
(196, 'IX', 1, '0926', 'Sindangan EO', '29437', '99B6949', 'IBM', 'Onsite', 'IBM x3200 M2', '3 GB', 1, 0, 0, 0, 1, 0, 0, 0, 1, 1, 1, 1, 0, 1, 0, '3.2', '15k6a', 'escan', '', '', 'UP', ''),
(197, 'IX', 1, '0928', 'Zamboanga DO', '38594', 'SGH735W0LF', 'HP', 'Onsite', 'HP ML110 Gen 9', '16gig', 0, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '3.2', '15k6a', 'escan', '', '', 'UP', ''),
(198, 'IX', 1, '0930', 'Molave EO', '34524', '436854A-99F3923', 'IBM', 'Onsite', 'IBM x3200 M2', '4 GB', 1, 0, 0, 0, 1, 0, 0, 0, 1, 1, 1, 1, 0, 1, 0, '', '', '', '', '', 'RTO', ''),
(199, 'IX', 1, '0932', 'Zamboanga LC', '42365', 'SGH7371W0LF', 'HP', 'Onsite', 'HP ML110 Gen 9', '16gig', 0, 1, 0, 1, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 0, '', '', '', '', '', 'RTO', 'No logged transactions due to '),
(200, 'BARMM', 1, '2004', 'Bongao EO', 'PE 10544', '99A0697', 'IBM', 'Onsite', 'IBM X3200', '3gig', 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '3.2', '15k6a', 'escan', '', '', 'Up', ''),
(201, 'BARMM', 1, '2002', 'Cotabato DO', '3315', 'ESP362200161|ESP3620', 'XITRIX', 'Onsite', 'XITRIX PowerFrame 5295', '2gig', 1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', '', '', '', '', ''),
(202, 'BARMM', 1, '2003', 'Cotabato LC', 'PE 37280', '', 'IBM', 'Onsite', 'IBM x3200 M2', '2GB', 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '3.2', '15k6a', 'escan', '', '', 'UP', ''),
(203, 'BARMM', 1, '1240', 'Maguindanao DO', 'PE 12566', '99B9716', 'IBM', 'Onsite', 'IBM x3200 M2', '2GB', 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '3.2', '15k6a', 'escan', '', '', 'UP', 'Please update Site code to 200'),
(204, 'BARMM', 1, '1232', 'Marawi DO', 'PE O4807', '99C1525', 'IBM', 'Onsite', 'IBM x3200 M2', '2GB', 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '3.2', '15k6a', 'escan', '', '', 'UP', 'Please update Site code to 200'),
(205, 'BARMM', 1, '2005', 'Jolo DO', '2725', '', 'IBM', 'Onsite', 'IBM x3200 M2', '2GB', 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '3.2', '15k6a', 'escan', '', '', 'UP', ''),
(206, 'XII', 1, '1248', 'Banisilan (Wao ', '7868', '99CI537', 'IBM', 'Onsite', 'IBM x3200', '3gig', 1, 0, 0, 0, 1, 0, 0, 0, 1, 1, 0, 0, 0, 1, 0, '', '', '', '', '', 'RTO', 'No logged transactions due to '),
(207, 'BARMM', 1, '2009', 'Wao DO ', '19348', 'ESP36260299', 'XITRIX', 'Onsite', 'XITRIX PowerFrame 5295', '3gig', 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', '', '', '', 'On Site ', ''),
(208, 'X', 1, '1000', 'Regional Office', '47478', 'SGH249TK6Y', 'HP', 'Onsite', 'HP ML110 Gen 10', '16gig', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', '', '', '', '', ''),
(209, 'X', 1, '1001', 'New Registratio', '46456', 'SGH137VC52', 'HP', 'Onsite', 'HP ML110 Gen 10', '16gig', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', '', '', '', '', ''),
(210, 'X', 1, '1008', 'Cagayan De Oro ', 'SERVICE UNIT 015', 'SGH74TWLOT', 'HP', 'Onsite', 'HP ML110 Gen 10', '16gig', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', '', '', '', '', ''),
(211, 'X', 1, '1009', 'Cagayan De Oro ', '42347', 'SGH838XSX7', 'HP', 'Onsite', 'HP ML110 Gen 10', '16gig', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', '', '', '', '', ''),
(212, 'X', 1, '1012', 'Maramag EO', '47473', 'SGH249TK2W', 'HP', 'Onsite', 'HP ML110 Gen 10', '16gig', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', '', '', '', '', ''),
(213, 'X', 1, '1014', 'Kibawe DO', '1', '1', 'HP', 'Onsite', 'HP ML110 Gen 10', '16gig', 1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', '', '', '', '', ''),
(214, 'X', 1, '1016', 'Gingoog DO', '4925', '99C15136', 'IBM', 'Onsite', 'IBM X3200', '3gig', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', '', '', '', '', ''),
(215, 'X', 2, '1017', 'Iligan DO', '41489', 'SGH809WBW3', 'HP', 'Onsite', 'HP ML110 Gen 9', '16gig', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', '', '', '', '', ''),
(216, 'X', 2, '1006', 'MAIDRS - Iligan', '2873', '99A5545', 'IBM', 'Onsite', 'IBM X3200', '3gig', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', '', '', '', '', ''),
(217, 'X', 1, '1018', 'Initao EO', '2074', '99A0711', 'IBM', 'Onsite', 'IBM X3200', '3gig', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', '', '', '', '', ''),
(218, 'X', 2, '1020', 'Malaybalay DO', '41490', 'SGH809WBWK', 'HP', 'Onsite', 'HP ML110 Gen 9', '16gig', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', '', '', '', '', ''),
(219, 'X', 2, '1005', 'MAIDRS - Malayb', '35179', '9988487', 'IBM', 'Onsite', 'IBM X3200', '3gig', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', '', '', '', '', ''),
(220, 'X', 1, '1024', 'Camiguin DO', '34520', '99F3623', 'IBM', 'Onsite', 'IBM X3200', '3gig', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', '', '', '', '', ''),
(221, 'X', 1, '1028', 'Oroquieta DO', '47474', 'SGH249TK56', 'HP', 'Onsite', 'HP ML110 Gen 10', '16gig', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', '', '', '', '', ''),
(222, 'X', 1, '1032', 'Ozamis DO', '4928', '99C1544', 'IBM', 'Onsite', 'IBM X3200', '3gig', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', '', '', '', '', ''),
(223, 'X', 1, '1036', 'Cagayan de Oro ', '47475', 'SGH249TK6C', 'HP', 'Onsite', 'HP ML110 Gen 10', '16gig', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', '', '', '', '', ''),
(224, 'X', 1, '1044', 'Tangub DO', '47476', 'SGH249TK4T', 'HP', 'Onsite', 'HP ML110 Gen 10', '16gig', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', '', '', '', '', ''),
(225, 'X', 1, '1046', 'Tubod DO', '2073', '', 'IBM', 'Onsite', 'IBM X3200', '3gig', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', '', '', '', '', ''),
(226, 'X', 1, '1021', 'Balingasag DO', '20756', 'ESP36190121	', 'XITRIX', 'Onsite', 'XITRIX PowerFrame 5295', '2gig', 1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', '', '', '', '', ''),
(227, 'X', 1, '1048', 'Valencia EO', '47477', 'SGH249TK2S', 'HP', 'Onsite', 'HP ML110 Gen 10', '16gig', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', '', '', '', '', ''),
(228, 'Caraga', 1, '1500', 'Regional Office', '7895', '4362IRS - 99C1533', 'IBM', 'Onsite', 'IBM X3200', '3gig', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', '', '', '', '', ''),
(229, 'Caraga', 1, '1501', 'New Registratio', 'Unreadable', '06EXGFP/YK10UN4C8010', 'IBM', 'Onsite', 'IBM x3500', '8gig', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', '', '', '', '', ''),
(230, 'Caraga', 1, '1504', 'Bislig DO', '42350', 'SGH938XSWP', 'HP', 'Onsite', 'HP ML110 Gen 10', '16gig', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', '', '', '', '', ''),
(231, 'Caraga', 1, '1507', 'Bayugan DO', '47481', 'SGH249TK4Q', 'HP', 'Onsite', 'HP ML110 Gen 10', '16gig', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', '', '', '', '', ''),
(232, 'Caraga', 1, '1508', 'Butuan DO', '47482', 'SGH249TK3R', 'HP', 'Onsite', 'HP ML110 Gen 10', '16gig', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', '', '', '', '', ''),
(233, 'Caraga', 1, '1510', 'Cabadbaran DO', '34325', '43685A-99E1655', 'IBM', 'Onsite', 'IBM X3200', '3gig', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', '', '', '', '', ''),
(234, 'Caraga', 1, '1512', 'Dapa DO', '1', '1', 'HP', 'Onsite', 'HP Proliant ML110 Gen 10', '16 GB', 1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', '', '', '', '', ''),
(235, 'Caraga', 1, '1516', 'Patin-ay DO', '20999', 'Unreadable', 'IBM', 'Onsite', 'IBM X3200', '3gig', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', '', '', '', '', ''),
(236, 'Caraga', 1, '1520', 'Surigao DO', '41494', 'SGH809WBW5', 'HP', 'Onsite', 'HP ML110 Gen 9', '16gig', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', '', '', '', '', ''),
(237, 'Caraga', 1, '1524', 'Tandag DO', '7845', 'SGH913YLEP', 'IBM', 'Onsite', 'IBM X3200', '3gig', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', '', '', '', '', ''),
(238, 'Caraga', 1, '1526', 'Trento EO', '22028', 'Unreadable', 'IBM', 'Onsite', 'IBM X3200', '3gig', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', '', '', '', '', ''),
(239, 'XI', 1, '1100', 'Regional Office', '47479', 'SGH249TK47', 'HP', 'Onsite', 'HP ML110 Gen 10', '16gig', 0, 0, 1, 1, 0, 0, 0, 0, 0, 0, 1, 1, 1, 0, 0, 'v3.2', '15k.7', 'Escan', 'N/A', 'N/A', 'Up', ''),
(240, 'XI', 1, '1108', 'Davao City Nort', '42348', 'SGH838XSX1', 'HP', 'Onsite', 'HP ML110 Gen 10', '16gig', 0, 1, 0, 1, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 0, '', '', '', '', '', 'RTO', 'LTMS site'),
(241, 'XI', 1, '1110', 'Davao de Oro DO', '46457', 'SGH137VC4L', 'HP', 'Onsite', 'HP ML110 Gen 10', '16gig', 0, 1, 0, 1, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 0, 'v3.2', '15k.6a', 'Escan', 'N/A', 'N/A', 'Up', ''),
(242, 'XI', 1, '1112', 'Davao South Cit', '47496', 'SGH249TK7J', 'HP', 'Onsite', 'HP ML110 Gen 9', '16gig', 0, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'v3.2', '15k.6a', 'Escan', 'N/A', 'N/A', 'Up', ''),
(243, 'XI', 1, '1116', 'Digos DO', '41493', 'SGH809WBW', 'HP', 'Onsite', 'HP ML110 Gen 9', '16gig', 0, 1, 0, 1, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 0, 'v3.2', '15k.6a', 'Escan', 'N/A', 'N/A', 'Up', ''),
(244, 'XI', 1, '1126', 'Malita DO', '47461', 'SGH249TK6K', 'HP', 'Onsite', 'HP ML110 Gen 10', '16gig', 0, 0, 1, 1, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 0, 'v3.2', '15k.6a', 'Escan', 'N/A', 'N/A', 'Up', ''),
(245, 'XI', 1, '1128', 'Mati DO', '15679', '99A0726', 'IBM', 'Onsite', 'IBM X3200', '3gig', 1, 0, 0, 0, 1, 0, 0, 0, 1, 1, 1, 1, 0, 1, 0, 'v3.2', '15k.6a', 'Escan', 'N/A', 'N/A', 'Up', ''),
(246, 'XI', 1, '1131', 'Samal DO', '4926', '99C1535', 'IBM', 'Onsite', 'IBM X3200', '3gig', 1, 0, 0, 0, 1, 0, 0, 0, 1, 1, 1, 1, 0, 1, 0, '', '', '', '', '', 'RTO', 'LTMS site & waiting for networ'),
(247, 'XI', 1, '1135', 'Panabo DO', '47484', 'SGH249TK50', 'HP', 'Onsite', 'HP ML110 Gen 10', '16gig', 0, 0, 1, 0, 0, 1, 0, 0, 1, 1, 1, 1, 1, 1, 0, 'v3.2', '15k.6a', 'Escan', 'N/A', 'N/A', 'Up', ''),
(248, 'XI', 1, '1136', 'Tagum DO', '38597', 'SGH735WOLX', 'HP', 'Onsite', 'HP ML110 Gen 9', '16gig', 0, 1, 0, 1, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 0, 'v3.2', '15k.6a', 'Escan', 'N/A', 'N/A', 'Up', ''),
(249, 'XII', 1, '1200', 'Regional Office', '47480', 'SGH249TK4F', 'HP', 'Onsite', 'HP ML110 Gen 10', '16gig', 0, 0, 1, 1, 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 0, '', '', '', '', '', 'UP', ''),
(250, 'XII', 1, '1201', 'New Registratio', '46458', 'SGH137VC4D', 'HP', 'Onsite', 'HP ML110 Gen 10', '16gig', 0, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', '', '', '', 'UP', ''),
(251, 'XII', 1, '1210', 'General Santos ', '34751', 'SGH249TK44', 'HP', 'Onsite', 'HP ML110 Gen 10', '16 GB', 0, 0, 1, 1, 0, 0, 0, 0, 0, 1, 1, 1, 0, 0, 0, '', '', '', '', '', 'UP', ''),
(252, 'XII', 1, '1211', 'General Santos ', '20625', '99A0738', 'IBM', 'Onsite', 'IBM x3200', '3gig', 1, 0, 0, 0, 1, 0, 0, 0, 1, 1, 1, 1, 0, 1, 0, '', '', '', '', '', 'RTO', 'LTMS site'),
(253, 'XII', 1, '1218', 'Kabacan EO', '42349', 'SGH838XSWQ', 'HP', 'Onsite', 'HP ML110 Gen 10', '16gig', 0, 1, 0, 1, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 0, '', '', '', '', '', 'UP', ''),
(254, 'XII', 1, '1220', 'Kidapawan DO', '30473', '99A5533', 'IBM', 'Onsite', 'IBM x3200', '3gig', 1, 0, 0, 0, 1, 0, 0, 0, 1, 1, 1, 1, 0, 1, 0, '', '', '', '', '', 'UP', ''),
(255, 'XII', 1, '1222', 'Datu Abdullah S', '4579', '99A55552', 'IBM', 'Onsite', 'IBM x3200', '3gig', 1, 0, 0, 0, 1, 0, 0, 0, 1, 1, 1, 1, 0, 1, 0, '', '', '', '', '', 'UP', ''),
(256, 'XII', 2, '1226', 'Koronadal DO', '38598', 'SGH735W0LJ', 'HP', 'Onsite', 'HP ML110 Gen 9', '16gig', 0, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', '', '', '', 'UP', ''),
(257, 'XII', 2, '1225', 'Koronadal LC ', '2004', '99B0874', 'IBM', 'Onsite', 'IBM x3200 M2', '3 GB', 1, 0, 0, 0, 1, 0, 0, 0, 1, 1, 1, 1, 0, 1, 0, '', '', '', '', '', 'RTO', 'LTMS site'),
(258, 'XII', 1, '1230', 'Polomolok EO', '41495', 'SGH809WBWH', 'HP', 'Onsite', 'HP ML110 Gen 9', '16gig', 0, 1, 0, 1, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 0, '', '', '', '', '', 'UP', ''),
(259, 'XII', 1, '1236', 'Midsayap EO', '28002', '', 'IBM', 'Onsite', 'IBM X3200', '3gig', 1, 0, 0, 0, 1, 0, 0, 0, 1, 1, 1, 1, 0, 1, 0, '', '', '', '', '', 'UP', ''),
(260, 'XII', 1, '1241', 'Saranggani DO', '7869', '99C1543', 'IBM', 'Onsite', 'IBM X3200', '3gig', 1, 0, 0, 0, 1, 0, 0, 0, 1, 1, 1, 1, 0, 1, 0, '', '', '', '', '', 'UP', ''),
(261, 'XII', 1, '1242', 'Surallah DO', '28511', '99A0729', 'IBM', 'Onsite', 'IBM x3200', '3gig', 1, 0, 0, 0, 1, 0, 0, 0, 1, 1, 1, 1, 0, 1, 0, '', '', '', '', '', 'UP', ''),
(262, 'XII', 1, '1244', 'Tacurong DO', '42366', 'SGH838XSX6', 'HP', 'Onsite', 'HP ML110 Gen 10', '16gig', 0, 1, 0, 1, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 0, '', '', '', '', '', 'UP', ''),
(263, 'XII', 1, '1243', 'Esperanza EO', '7839', '99D1903', 'IBM', 'Onsite', 'IBM x3200', '3gig', 1, 0, 0, 0, 1, 0, 0, 0, 1, 1, 0, 0, 0, 1, 0, '', '', '', '', '', 'UP', ''),
(264, 'VIII', 1, '0800', 'Regional Office', '786', '99B9723', 'IBM', 'Onsite', 'IBM x3200', '3gig', 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '3.2', '15k6a', 'escan', '3', 'Yes', 'UP', ''),
(265, 'VIII', 1, '0801', 'New Registratio', '47470', 'SGH249TK3C', 'HP', 'Onsite', 'HP ML110 Gen 10', '16gig', 0, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '3.2', '15k7a', 'escan', '', '', 'UP', ''),
(266, 'VIII', 1, '0802', 'Baybay DO', '41490', 'SGH809WBWK', 'HP', 'Onsite', 'HP ML110 Gen 9', '16gig', 0, 1, 0, 1, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 0, '3.2', '15k6a', 'escan', '', '', 'UP', ''),
(267, 'VIII', 1, '0804', 'Borongan DO', '1', '1', 'HP', 'Onsite', 'HP Proliant ML110 Gen 10', '16 GB', 1, 0, 0, 0, 0, 1, 0, 0, 1, 1, 1, 1, 0, 1, 0, '3.2', '15k6a', 'McAfee', '', '', 'UP', '');
INSERT INTO `srvr_tbl` (`srvr_id`, `region`, `itsoi_count`, `site_code`, `site_name`, `asset_no`, `serial_no`, `brand`, `srvr_loc`, `srvr_brand_model`, `memory`, `WOS_2003`, `WOS_2012`, `WOS_2016`, `hp`, `ibm`, `xitrix`, `dell`, `lenovo`, `w_adles`, `ft_installers`, `net_2`, `net_4`, `net_4-7`, `install_iis`, `or_printing_patch`, `recomp_ver`, `batch_uploader_ver`, `anti_virus`, `cp_downloader`, `trojan_plate_integrator`, `site_stats`, `remarks`) VALUES
(268, 'VIII', 1, '0808', 'Calbayog DO', '47469', 'SGH249TK4X', 'HP', 'Onsite', 'HP ML110 Gen 10', '16gig', 0, 0, 1, 1, 0, 0, 0, 0, 1, 1, 1, 1, 0, 1, 0, '3.2', '15k6a', 'escan', '', '', 'UP', ''),
(269, 'VIII', 1, '0812', 'Carigara DO', '47460', 'SGH249TK2D', 'HP', 'Onsite', 'HP ML110 Gen 10', '16gig', 0, 0, 1, 1, 0, 0, 0, 0, 1, 1, 1, 1, 0, 1, 0, '3.2', '15k6a', 'escan', '', '', 'UP', ''),
(270, 'VIII', 1, '0816', 'Catarman DO', '47499', 'SGH249TK5W', 'HP', 'Onsite', 'HP ML110 Gen 10', '16gig', 0, 0, 1, 1, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 0, '3.2', '15k6a', 'escan', '', '', 'UP', ''),
(271, 'VIII', 1, '0820', 'Catbalogan DO', '42364', 'SGH838XSWJ', 'HP', 'Onsite', 'HP ML110 Gen 10', '16gig', 0, 1, 0, 1, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 0, '3.2', '15k6a', 'escan', '', '', 'UP', ''),
(272, 'VIII', 1, '0822', 'Guiuan EO', '16450', '99A4767', 'IBM', 'Onsite', 'IBM x3200', '3gig', 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', '', '', '', 'RTO', ''),
(273, 'VIII', 1, '0824', 'Maasin DO', '41486', 'SGH809WBW9', 'HP', 'Onsite', 'HP ML110 Gen 9', '16gig', 0, 1, 0, 1, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 0, '3.2', '15k6a', 'escan', '', '', 'UP', ''),
(274, 'VIII', 1, '0828', 'Naval DO', '47468', 'SGH249TK77', 'HP', 'Onsite', 'HP ML110 Gen 10', '16gig', 0, 0, 1, 1, 0, 0, 0, 0, 1, 1, 1, 1, 0, 1, 0, '3.2', '15k7a', 'escan', '', '', 'UP', ''),
(275, 'VIII', 1, '0831', 'Burauen EO', '23504', 'ESP36260019', 'XITRIX', 'Onsite', 'XITRIX PowerFrame 5295', '2gig', 1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, '3.2', '15k6a', 'escan', '', '', 'UP', ''),
(276, 'VIII', 1, '0832', 'Ormoc DO', '38593', 'SGH735W0LT', 'HP', 'Onsite', 'HP ML110 Gen 9', '16gig', 0, 1, 0, 1, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 0, '3.2', '15k6a', 'escan', '', '', 'UP', ''),
(277, 'VIII', 1, '0835', 'Mercedes EO', '30538', '990D1837', 'IBM', 'Onsite', 'IBM x3200', '3gig', 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '3.2', '15k6a', 'escan', '', '', 'UP', ''),
(278, 'VIII', 1, '0836', 'Palompon DO', '4573', '99A5555', 'IBM', 'Onsite', 'IBM x3200', '3gig', 1, 0, 0, 0, 1, 0, 0, 0, 1, 1, 1, 1, 0, 1, 0, '3.2', '15k6a', 'escan', '', '', 'UP', ''),
(279, 'VIII', 1, '0840', 'San Juan DO', '4923', '99C1529', 'IBM', 'Onsite', 'IBM x3200', '3gig', 1, 0, 0, 0, 1, 0, 0, 0, 1, 1, 1, 1, 0, 1, 0, '3.2', '15k6a', 'escan', '', '', 'UP', ''),
(280, 'VIII', 1, '0841', 'Sogod EO', '4578', '99A5544', 'IBM', 'Onsite', 'IBM x3200', '3gig', 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '3.2', '15k6a', 'escan', '', '', 'UP', ''),
(281, 'VIII', 1, '0844', 'Tacloban DO', '47467', 'SGH249TK5P', 'HP', 'Onsite', 'HP ML110 Gen 10', '16gig', 0, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '3.2', '15k6a', 'escan', '', '', 'UP', ''),
(282, 'VIII', 1, '0846', 'Tacloban EO', '3631', '99A4778', 'IBM', 'Onsite', 'IBM x3200', '3gig', 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '3.2', '15k6a', 'escan', '', '', 'UP', ''),
(283, 'VIII', 1, '0848', 'Tacloban City L', '1', '', 'HP', 'Onsite', 'HP ML110 Gen 10', '16gig', 0, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '3.2', '15k6a', 'escan', '', '', 'UP', 'Xitrix Server Pulled Out confi'),
(284, 'CO', 1, '0071', 'Central Licensi', '4784', '200710000178', 'IBM', 'SMC', 'IBM', '3 GB', 1, 0, 0, 0, 1, 0, 0, 0, 1, 1, 1, 1, 0, 1, 0, 'v3.2', '15k.6a', 'Escan', 'N/A', 'N/A', 'Up', ''),
(285, 'CO', 1, '0098', 'Registration Se', '38359', '71P2LQ2', 'HP', 'SMC', 'Dell R440', '16 GB', 0, 1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 'v3.2', '15k.6a', 'Escan', 'V3.0', 'N/A', 'Up', ''),
(286, 'CO', 1, '0099', 'Law Enforcement', '38360', '71Q6LQ2', 'HP', 'SMC', 'Dell R440', '16 GB', 0, 1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 'v3.2', '15k.6a', 'Escan', 'N/A', 'N/A', 'Up', ''),
(287, 'NCR', 1, '1308', 'Quezon City EO', '47446', 'SGH249TK65', 'HP', 'Onsite', 'HP ML110 Gen10', '16 GB', 0, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'v3.2', '15k.7', 'Escan', 'N/A', 'N/A', 'UP', ''),
(288, 'NCR', 1, '1312', 'Diliman DO ', '41465', 'SGH809WBWP', 'HP', 'Onsite', 'HP ML110 Gen9', '16 GB', 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'v3.2', '15k.7', 'Escan', 'N/A', 'N/A', 'UP', ''),
(289, 'NCR', 1, '1316', 'San Juan LC', '4782', '200710-000189', 'IBM', 'Onsite', 'IBM', '3 GB', 1, 0, 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 0, 1, 0, 'v3.2', '15k.6a', 'Escan', 'N/A', 'N/A', 'Up', ''),
(290, 'NCR', 1, '1320', 'La Loma DO', '47495', 'SGH249TK3N', 'HP', 'Onsite', 'HP ML110 Gen10', '16 GB', 0, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'v3.2', '15k.6a', 'Escan', 'N/A', 'N/A', 'Up', ''),
(291, 'NCR', 1, '1336', 'Mandaluyong EO', '47448', 'SGH249TK2H', 'HP', 'Onsite', 'HP ML110 Gen10', '16 GB', 0, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'v3.2', '15k.7', 'Escan', 'N/A', 'N/A', 'UP', ''),
(292, 'NCR', 1, '1356', 'Marikina DO', '38580', 'SGH735WDLD', 'HP', 'Onsite', 'HP ML110 Gen9', '16 GB', 0, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'v3.2', '15k.6a', 'Escan', 'N/A', 'N/A', 'UP', ''),
(293, 'NCR', 1, '1360', 'Quezon City LC', '41466', 'SGH809WBWC', 'HP', 'Onsite', 'HP ML110 Gen9', '16 GB', 0, 1, 0, 1, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 0, '', '', '', '', '', 'RTO', ''),
(294, 'NCR', 1, '1364', 'Novaliches DO', '38573', 'SGH735W0M5', 'HP', 'Onsite', 'HP ML110 Gen9', '16 GB', 0, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'v3.2', '15k.6a', 'Escan', 'N/A', 'N/A', 'UP', ''),
(295, 'NCR', 1, '1372', 'Pasig DO', '38572', 'SGH735W0LW', 'HP', 'Onsite', 'HP ML110 Gen9', '16 GB', 0, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'v3.2', '15k.6a', 'Escan', 'N/A', 'N/A', 'UP', ''),
(296, 'NCR', 1, '1376', 'Quezon City LRS', '35161', '732854A 99B9328', 'IBM', 'Onsite', 'IBM', '2 GB', 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'v3.2', '15k.6a', 'Mcafee', 'N/A', 'N/A', 'UP', ''),
(297, 'NCR', 1, '1377', 'Pilot DO', '46451', 'SGH137VC41', 'HP', 'Onsite', 'HP ML110 Gen10', '16 GB', 0, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'v3.2', '15k.6a', 'Escan', 'N/A', 'N/A', 'UP', ''),
(298, 'NCR', 1, '1380', 'Quezon City DO', '41464', 'SGH809WBWS', 'HP', 'Onsite', 'HP ML110 Gen9', '16 GB', 0, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'v3.2', '15k.7', 'Escan', 'N/A', 'Up', 'UP', ''),
(299, 'NCR', 1, '1384', 'San Juan DO', '47487', 'SGH249TK62', 'HP', 'Onsite', 'HP ML110 Gen10', '16 GB', 0, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'v3.2', '15k.6a', 'Escan', 'N/A', 'N/A', 'UP', ''),
(300, 'NCR', 1, '1391', 'Taguig EO', '47447', 'SGH249TK71', 'HP', 'Onsite', 'HP ML110 Gen10', '16 GB', 0, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'v3.2', '15k.7', 'Escan', 'N/A', 'N/A', 'UP', ''),
(301, 'NCR', 1, '1396', 'Valenzuela DO', '41463', 'SGH809WBWE', 'HP', 'Onsite', 'HP ML110 Gen9', '16 GB', 0, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'v3.2', '15k.6a', 'Escan', 'N/A', 'N/A', 'UP', ''),
(302, 'NCR', 1, '1397', 'Valenzuela LRS', '3883', '99A5550', 'IBM', 'Onsite', 'IBM', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', '', '', '', '', ''),
(303, 'NCR', 1, '1800', 'Regional Office', '38160', 'ESP36260301', 'XITRIX', 'Onsite', 'XITRIX PowerFrame 5295', '2 GB', 1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', '', '', '', 'RTO', ''),
(304, 'NCR', 1, '1801', 'NRU - East 1801', '46449', 'SGH137VC4W', 'HP', 'SMC', 'HP ML110 Gen10', '16 GB', 0, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'v3.2', '15k.7', 'Escan', 'N/A', 'Up', 'UP', ''),
(305, 'NCR', 1, '1300', 'Regional Office', '48798', 'SGH343NBKL', 'HP', 'Onsite', 'HP ML110 Gen10', '16 GB', 1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'v3.2', '15k.6a', 'Mcafee', 'N/A', 'N/A', 'Up', 'dotnet 1.1'),
(306, 'NCR', 1, '1301', 'NRU - West 1301', '42984', 'SGH913YLFP', 'HP', 'Onsite', 'HP ML110 Gen10', '16 GB', 0, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'v3.2', '15k.7', 'Escan', 'N/A', 'UP', 'Up', ''),
(307, 'NCR', 1, '1303', 'NRU - West 1303', '43626', 'SGH936XYRT', 'HP', 'Onsite', 'HP ML110 Gen10', '16 GB', 0, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'v3.2', '15k.7', 'Escan', 'N/A', 'UP', 'Up', ''),
(308, 'NCR', 1, '1304', 'Caloocan DO', '46450', 'SGH137VC4H', 'HP', 'Onsite', 'HP ML110 Gen10', '16 GB', 0, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'v3.2', '15k.7', 'Escan', 'N/A', 'N/A', 'Up', ''),
(309, 'NCR', 1, '1306', 'Caloocan LC', '1990', '99B9864', 'IBM', 'Onsite', 'IBM', '3 GB', 1, 0, 0, 0, 1, 0, 0, 0, 1, 1, 1, 1, 0, 1, 0, 'v3.2', '15k.6a', 'Escan', 'N/A', 'N/A', 'Up', ''),
(310, 'NCR', 2, '1324', 'Las Pinas DO', '47449', 'SGH249TK6R', 'HP', 'Onsite', 'HP ML110 Gen10', '16 GB', 0, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'v3.2', '15k.7', 'Escan', 'N/A', 'N/A', 'Up', ''),
(311, 'NCR', 2, '1323', 'Las Pinas DO DI', '30009', 'ESP36230233', 'XITRIX', 'Onsite', 'XITRIX PowerFrame 5295', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', '', '', '', '', ''),
(312, 'NCR', 2, '1328', 'Makati DO', '41462', 'SGH809WBVX', 'HP', 'Onsite', 'HP ML110 Gen9', '16 GB', 0, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'v3.2', '15k.6a', 'Escan', 'N/A', 'N/A', 'UP', ''),
(313, 'NCR', 2, '1329', 'Makati LC', '48807', 'SGH343NBK9', 'HP', 'Onsite', 'HP ML110 Gen10', '16 GB', 1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', '', '', '', 'RTO', ' LTMS site'),
(314, 'NCR', 1, '1332', 'Malabon EO', '42368', 'SGH838XSWC', 'HP', 'Onsite', 'HP ML110 Gen10', '16 GB', 0, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'v3.2', '15k.6a', 'Escan', 'N/A', 'N/A', 'Up', ''),
(315, 'NCR', 1, '1340', 'Manila East DO', '42367', 'SGH838XSWW', 'HP', 'Onsite', 'HP ML110 Gen10', '16 GB', 0, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'v3.2', '15k.6a', 'Escan', 'N/A', 'N/A', 'UP', ''),
(316, 'NCR', 1, '1344', 'Manila North DO', '7978', '43626A-99A0715', 'IBM', 'Onsite', 'IBM', '3 GB', 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'v3.2', '15k.6a', 'Escan', 'N/A', 'N/A', 'UP', 'dotnet 1.1'),
(317, 'NCR', 1, '1348', 'Manila South DO', '10783', '200803-001868', 'IBM', 'Onsite', 'IBM', '3 GB', 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'v3.2', '15k.6a', 'Escan', 'N/A', 'N/A', 'Up', ''),
(318, 'NCR', 1, '1352', 'Manila West DO', '42369', 'SGH838XSX4', 'HP', 'Onsite', 'HP ML110 Gen10', '16 GB', 0, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'v3.2', '15k.6a', 'Escan', 'N/A', 'N/A', 'UP', ''),
(319, 'NCR', 1, '1358', 'Navotas DO', '14427', '99A0700', 'IBM', 'Onsite', 'IBM', '3 GB', 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'v3.2', '15k.6a', 'Escan', 'N/A', 'N/A', 'UP', ''),
(320, 'NCR', 2, '1366', 'Muntinlupa DO', '38571', 'SGH735WOLV', 'HP', 'Onsite', 'HP ML110 Gen9', '16 GB', 0, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'v3.2', '15k.7', 'Escan', 'N/A', 'Up', 'UP', ''),
(321, 'NCR', 2, '1350', 'Muntinlupa DIY', '07549', 'QSEP61800887', 'XITRIX', 'Onsite', 'XITRIX PowerFrame 5295', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', '', '', '', '', ''),
(322, 'NCR', 1, '1367', 'Paranaque EO', '47483', 'SGH249TK7F', 'HP', 'Onsite', 'HP ML110 Gen9', '3 GB', 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'v3.2', '15k.6a', 'Mcafee', 'N/A', 'N/A', 'UP', ''),
(323, 'NCR', 1, '1368', 'Pasay DO', '35180', '998780', 'IBM', 'Onsite', 'IBM', '2 GB', 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'v3.2', '15k.6a', 'Mcafee', 'N/A', 'N/A', 'UP', ''),
(324, 'NCR', 1, '1378', 'Pilot EO', '3293', '200709-001344', 'IBM', 'Onsite', 'IBM', '3 GB', 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'v3.2', '15k.6a', 'Escan', 'N/A', 'N/A', 'UP', ''),
(325, 'NCR', 1, '1387', 'Pasay MVRRS Dri', '4804', '99B9867', 'IBM', 'SMC', 'IBM', '3 GB', 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', '', '', '', 'RTO', 'Server down - For discussion w'),
(326, 'NCR', 1, '1388', 'Pasay LC', '34526', '436854A-99FT393', 'IBM', 'Onsite', 'IBM', '4 GB', 1, 0, 0, 0, 1, 0, 0, 0, 1, 1, 1, 1, 0, 1, 0, '', '', '', '', '', 'RTO', 'LTMS site'),
(327, 'NCR', 1, '1390', 'Las Pinas LEO', '48805', 'SGH343NBKD', 'HP', 'Onsite', 'HP ML110 Gen10', '16 GB', 1, 0, 0, 0, 1, 0, 0, 0, 1, 1, 1, 1, 0, 1, 0, 'v3.2', '15k.6a', 'Escan', 'N/A', 'N/A', 'UP', ''),
(328, 'NCR', 2, '1392', 'Manila LC', '47498', 'SGH249TK6N', 'HP', 'Onsite', 'ML110', '2 GB', 1, 0, 0, 0, 0, 1, 0, 0, 1, 1, 1, 1, 0, 1, 0, 'v3.2', '15k.6a', 'Mcafee', 'N/A', 'N/A', 'UP', ''),
(329, 'NCR', 2, '1393', 'Manila LRS', '4940', '99A5567', 'IBM', 'Onsite', 'IBM', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', '', '', '', '', '');

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
-- Indexes for table `hw_brand_tbl`
--
ALTER TABLE `hw_brand_tbl`
  ADD PRIMARY KEY (`hw_brand_id`);

--
-- Indexes for table `hw_model_tbl`
--
ALTER TABLE `hw_model_tbl`
  ADD PRIMARY KEY (`hw_model_id`);

--
-- Indexes for table `hw_tbl`
--
ALTER TABLE `hw_tbl`
  ADD PRIMARY KEY (`hw_id`);

--
-- Indexes for table `region_tbl`
--
ALTER TABLE `region_tbl`
  ADD PRIMARY KEY (`region_id`);

--
-- Indexes for table `site_list_tbl`
--
ALTER TABLE `site_list_tbl`
  ADD PRIMARY KEY (`site_id`);

--
-- Indexes for table `srvr_tbl`
--
ALTER TABLE `srvr_tbl`
  ADD PRIMARY KEY (`srvr_id`);

--
-- Indexes for table `user_tbl`
--
ALTER TABLE `user_tbl`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `hw_brand_tbl`
--
ALTER TABLE `hw_brand_tbl`
  MODIFY `hw_brand_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `hw_model_tbl`
--
ALTER TABLE `hw_model_tbl`
  MODIFY `hw_model_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `hw_tbl`
--
ALTER TABLE `hw_tbl`
  MODIFY `hw_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `region_tbl`
--
ALTER TABLE `region_tbl`
  MODIFY `region_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `site_list_tbl`
--
ALTER TABLE `site_list_tbl`
  MODIFY `site_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=635;

--
-- AUTO_INCREMENT for table `srvr_tbl`
--
ALTER TABLE `srvr_tbl`
  MODIFY `srvr_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=330;

--
-- AUTO_INCREMENT for table `user_tbl`
--
ALTER TABLE `user_tbl`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
