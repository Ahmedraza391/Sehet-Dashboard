-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 16, 2024 at 02:53 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_sehet_dashboard`
--

-- --------------------------------------------------------

--
-- Table structure for table `super_admin`
--

CREATE TABLE `super_admin` (
  `id` int(11) NOT NULL,
  `super_admin_name` varchar(200) NOT NULL,
  `admin_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `super_admin`
--

INSERT INTO `super_admin` (`id`, `super_admin_name`, `admin_id`) VALUES
(1, 'Ahmed Raza', 2);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admin`
--

CREATE TABLE `tbl_admin` (
  `id` int(11) NOT NULL,
  `admin_name` varchar(300) NOT NULL,
  `admin_username` varchar(255) NOT NULL,
  `admin_password` text NOT NULL,
  `admin_image` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_admin`
--

INSERT INTO `tbl_admin` (`id`, `admin_name`, `admin_username`, `admin_password`, `admin_image`) VALUES
(2, 'Yousuf Khadiawala', 'sehet_admin', 'sehet1234', './assets/img/admin/668a81f2b56219.64480461.png');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_area`
--

CREATE TABLE `tbl_area` (
  `id` int(11) NOT NULL,
  `area` varchar(255) NOT NULL,
  `city_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_area`
--

INSERT INTO `tbl_area` (`id`, `area`, `city_id`) VALUES
(1, 'Abdullah Town', 3),
(3, 'Gulshn-e-Iqbal', 1),
(5, 'Aziz Bhati Town', 2),
(7, ' Data Gang Baksh Town', 2),
(8, 'Faisal Mosque', 3),
(9, 'Islamia College University', 6),
(10, 'Peshawar Garrison Club', 6),
(11, 'Chiltan', 7),
(12, 'Takatoo', 7),
(13, 'Jiwani', 8),
(14, 'Makola', 8),
(15, 'Bag-Notar', 9),
(16, 'Ratodero', 10);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_city`
--

CREATE TABLE `tbl_city` (
  `id` int(11) NOT NULL,
  `city` varchar(255) NOT NULL,
  `province_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_city`
--

INSERT INTO `tbl_city` (`id`, `city`, `province_id`) VALUES
(1, 'Karachi', 2),
(2, 'Lahore', 3),
(3, 'Islamabad', 3),
(6, 'Peshawar', 6),
(7, 'Quetta', 5),
(8, 'Gwadar', 5),
(9, 'Abbottabad', 6),
(10, 'Larkana', 2);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_employees`
--

CREATE TABLE `tbl_employees` (
  `emp_id` int(11) NOT NULL,
  `emp_name` varchar(200) NOT NULL,
  `emp_father_name` varchar(100) NOT NULL,
  `emp_email` varchar(100) NOT NULL,
  `emp_password` varchar(200) NOT NULL,
  `emp_contact` varchar(20) NOT NULL,
  `emp_nic` varchar(20) NOT NULL,
  `emp_dob` varchar(100) NOT NULL,
  `emp_designation` varchar(200) NOT NULL,
  `emp_status` varchar(50) NOT NULL DEFAULT 'deactivate',
  `pages_access` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_employees`
--

INSERT INTO `tbl_employees` (`emp_id`, `emp_name`, `emp_father_name`, `emp_email`, `emp_password`, `emp_contact`, `emp_nic`, `emp_dob`, `emp_designation`, `emp_status`, `pages_access`) VALUES
(1, 'Ahmed Raza Jutt', 'Muhammad Razzaq Jutt', '0312ahmedjutt@gmail.com', '', '03269243547', '4230111018266', '2007-05-19', 'admin', 'activate', 'service_page, address_page');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_extra_services`
--

CREATE TABLE `tbl_extra_services` (
  `id` int(11) NOT NULL,
  `extra_service` varchar(200) NOT NULL,
  `extra_service_price` bigint(20) NOT NULL,
  `sub_services_id` int(11) NOT NULL,
  `status` varchar(100) NOT NULL DEFAULT 'available'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_extra_services`
--

INSERT INTO `tbl_extra_services` (`id`, `extra_service`, `extra_service_price`, `sub_services_id`, `status`) VALUES
(1, 'Computed Tomography', 1000, 8, 'available'),
(2, 'Plain Radiography ', 800, 8, 'available'),
(3, 'Leg Injection', 500, 2, 'available'),
(4, 'Hand Injection', 400, 2, 'available');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_panel`
--

CREATE TABLE `tbl_panel` (
  `id` int(11) NOT NULL,
  `company` varchar(200) NOT NULL,
  `email` varchar(100) NOT NULL,
  `focal_person` varchar(200) NOT NULL,
  `company_contact` varchar(15) NOT NULL,
  `focal_person_contact` varchar(15) NOT NULL,
  `province_id` int(11) NOT NULL,
  `city_id` int(11) NOT NULL,
  `area_id` int(11) NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'activate',
  `services` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_panel`
--

INSERT INTO `tbl_panel` (`id`, `company`, `email`, `focal_person`, `company_contact`, `focal_person_contact`, `province_id`, `city_id`, `area_id`, `status`, `services`) VALUES
(2, 'NDure', 'ndure@gmail.com', 'Wahab Khan', '03331234567', '03331234567', 2, 1, 3, 'activate', '1,2,3,4'),
(3, 'Service Shoes', 'serviceshoes@gmail.com', 'Ahmed Raza', '03242342342', '03242342342', 3, 2, 5, 'activate', '1,2'),
(4, 'POI Comps', 'poi@gmail.com', 'Wahab Khan', '03331234567', '03331234567', 5, 7, 11, 'activate', '1,2,8'),
(5, 'Bata Shoes', 'batashoes@gmail.com', 'Muhammad Ikram', '03071234567', '03071234567', 6, 6, 10, 'activate', '1,2'),
(6, 'ABC Comapny', 'abc@gmail.com', 'Muhammad Ikram', '03242342342', '03242342342', 3, 3, 1, 'activate', '2'),
(7, 'Ibex ', 'ibex@gmail.com', 'Muhammad Minhal', '03123445677', '03123445677', 5, 8, 14, 'activate', '2'),
(8, 'ZE Comps', 'comps@gmail.com', 'Muhammad Fayaz', '03269243547', '03269243547', 3, 2, 5, 'activate', '1,3,4,5,6,8,14'),
(9, 'Aj ', 'aj@gmail.com', 'Abdul Sttar', '03269243547', '03269243547', 2, 10, 16, 'activate', '1');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_panel_services`
--

CREATE TABLE `tbl_panel_services` (
  `id` int(11) NOT NULL,
  `panel_id` int(11) NOT NULL,
  `sub_services_id` int(11) NOT NULL,
  `extra_services_id` int(11) DEFAULT NULL,
  `sub_service_price` varchar(200) DEFAULT '0',
  `extra_service_price` varchar(200) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_panel_services`
--

INSERT INTO `tbl_panel_services` (`id`, `panel_id`, `sub_services_id`, `extra_services_id`, `sub_service_price`, `extra_service_price`) VALUES
(1, 2, 1, NULL, '1499', NULL),
(2, 2, 2, NULL, '800', NULL),
(3, 2, 2, 3, '800', NULL),
(4, 2, 3, NULL, '1200', NULL),
(5, 2, 4, NULL, '1200', NULL),
(9, 4, 1, NULL, '1798', NULL),
(10, 4, 2, NULL, '1000', NULL),
(11, 4, 2, 3, '1000', '0'),
(12, 4, 2, 4, '1000', NULL),
(13, 4, 8, NULL, '2000', NULL),
(14, 4, 8, 1, '2000', NULL),
(15, 4, 8, 2, '2000', NULL),
(16, 5, 1, NULL, '1300', NULL),
(17, 5, 2, NULL, '2000', NULL),
(18, 5, 2, 3, '2000', NULL),
(19, 5, 2, 4, '2000', NULL),
(20, 6, 2, NULL, '1020', NULL),
(21, 6, 2, 3, '1020', NULL),
(22, 6, 2, 4, '1020', NULL),
(26, 8, 1, NULL, '3998', NULL),
(27, 8, 3, NULL, '3000', NULL),
(28, 8, 4, NULL, '2000', NULL),
(29, 8, 5, NULL, '1000', NULL),
(30, 8, 6, NULL, '1198', NULL),
(31, 8, 8, NULL, '1500', NULL),
(32, 8, 8, 1, '1500', '750'),
(33, 8, 8, 2, '1500', '748'),
(34, 8, 14, NULL, '3000', NULL),
(36, 9, 1, NULL, '2700', '0'),
(38, 7, 2, NULL, '1500', '0'),
(39, 3, 1, NULL, '1000', '0'),
(40, 3, 2, NULL, '3000', '0');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_province`
--

CREATE TABLE `tbl_province` (
  `id` int(11) NOT NULL,
  `province` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_province`
--

INSERT INTO `tbl_province` (`id`, `province`) VALUES
(2, 'Sindh'),
(3, 'Punjab'),
(5, 'Balochistan'),
(6, 'KPK');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_refferals`
--

CREATE TABLE `tbl_refferals` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `company` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `financial_share` int(11) NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'show'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_refferals`
--

INSERT INTO `tbl_refferals` (`id`, `name`, `company`, `email`, `financial_share`, `status`) VALUES
(1, 'Ahmed Raza', 'Shan Food ', 'shanfood@gmail.com', 45, 'hide'),
(2, 'Farooq Khan Ustad', 'Getz Pharma', 'getz@gmail.com', 22, 'show'),
(3, 'Adnan Khan', 'Sui Gas Pvt Ltd.', 'adnanKhan@gmail.com', 30, 'hide'),
(6, 'Muhammad Istiyaq', 'PCB', 'raza@gmail.com', 23, 'show');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_services`
--

CREATE TABLE `tbl_services` (
  `id` int(11) NOT NULL,
  `service` varchar(200) NOT NULL,
  `status` varchar(30) NOT NULL DEFAULT 'available'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_services`
--

INSERT INTO `tbl_services` (`id`, `service`, `status`) VALUES
(1, 'Medical', 'available'),
(2, 'Diagnostics', 'available'),
(3, 'P&D', 'available');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_sub_services`
--

CREATE TABLE `tbl_sub_services` (
  `id` int(11) NOT NULL,
  `sub_service` varchar(200) NOT NULL,
  `sub_service_price` bigint(20) NOT NULL,
  `services_id` int(11) NOT NULL,
  `status` varchar(100) NOT NULL DEFAULT 'available'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_sub_services`
--

INSERT INTO `tbl_sub_services` (`id`, `sub_service`, `sub_service_price`, `services_id`, `status`) VALUES
(1, 'Attendent', 1000, 1, 'available'),
(2, 'Injection', 1200, 1, 'available'),
(3, 'Drip Application', 2000, 1, 'available'),
(4, 'Elderly Care', 0, 1, 'available'),
(5, 'Covid Care', 0, 1, 'available'),
(6, 'Dressing', 0, 1, 'available'),
(7, 'Blood Testing', 0, 2, 'available'),
(8, 'Portable XRAY', 2500, 2, 'available'),
(9, 'Portable UltraSound - Conventional', 0, 2, 'available'),
(10, 'Portable UltraSound - Doppler', 0, 2, 'available'),
(11, 'Pharmacy', 0, 3, 'available'),
(12, 'Postal Hospital Care', 0, 1, 'available'),
(13, 'Injections', 0, 1, 'available'),
(14, 'Portable UltraSound - Enchardiography', 1400, 2, 'available');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `super_admin`
--
ALTER TABLE `super_admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_area`
--
ALTER TABLE `tbl_area`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_city`
--
ALTER TABLE `tbl_city`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_employees`
--
ALTER TABLE `tbl_employees`
  ADD PRIMARY KEY (`emp_id`);

--
-- Indexes for table `tbl_extra_services`
--
ALTER TABLE `tbl_extra_services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_panel`
--
ALTER TABLE `tbl_panel`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_panel_services`
--
ALTER TABLE `tbl_panel_services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_province`
--
ALTER TABLE `tbl_province`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_refferals`
--
ALTER TABLE `tbl_refferals`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_services`
--
ALTER TABLE `tbl_services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_sub_services`
--
ALTER TABLE `tbl_sub_services`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `super_admin`
--
ALTER TABLE `super_admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_area`
--
ALTER TABLE `tbl_area`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `tbl_city`
--
ALTER TABLE `tbl_city`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tbl_employees`
--
ALTER TABLE `tbl_employees`
  MODIFY `emp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_extra_services`
--
ALTER TABLE `tbl_extra_services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_panel`
--
ALTER TABLE `tbl_panel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tbl_panel_services`
--
ALTER TABLE `tbl_panel_services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `tbl_province`
--
ALTER TABLE `tbl_province`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_refferals`
--
ALTER TABLE `tbl_refferals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tbl_services`
--
ALTER TABLE `tbl_services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_sub_services`
--
ALTER TABLE `tbl_sub_services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
