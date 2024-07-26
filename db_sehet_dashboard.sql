-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 26, 2024 at 06:32 PM
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
(2, 'Yousuf Admin', 'sehet_admin', 'sehet123', './assets/img/admin/6699948c7fbf46.28606562.png');

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
  `id` int(11) NOT NULL,
  `emp_id` varchar(20) NOT NULL,
  `emp_name` varchar(200) NOT NULL,
  `emp_father_name` varchar(100) NOT NULL,
  `emp_email` varchar(100) NOT NULL,
  `emp_contact` varchar(50) NOT NULL,
  `emp_nic` varchar(20) NOT NULL,
  `emp_dob` varchar(100) NOT NULL,
  `emp_designation` varchar(200) NOT NULL,
  `emp_status` varchar(50) NOT NULL DEFAULT 'deactivate',
  `changes_person` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_employees`
--

INSERT INTO `tbl_employees` (`id`, `emp_id`, `emp_name`, `emp_father_name`, `emp_email`, `emp_contact`, `emp_nic`, `emp_dob`, `emp_designation`, `emp_status`, `changes_person`) VALUES
(1, '1124-544', 'Ahmed Raza Jutt', 'Muhammad Razzaq', 'ahmed@gmail.com', '03129987650', '4230111018277', '2006-04-03', 'nursing_staff', 'activate', ''),
(2, '1234-567', 'Muhammad Minhal', 'Muhammad Qasim', 'minhal@gmail.com', '03269243543', '4230111018111', '2008-12-17', 'nursing_staff', 'activate', ''),
(3, '2222-564', 'Muhammad Raza', 'Muhammad Razzaq', 'raza@gmail.com', '03269243547', '4230111238111', '2000-07-06', 'physiotherapist', 'activate', ''),
(4, '4521-235', 'Ayub Khan', 'Muhammd Ayub', 'ayub@gmail.com', '03129987654', '4230111018223', '2001-06-12', 'nursing_staff', 'activate', ''),
(5, '4556-785', 'Yasir ', 'Nawaz', 'yasir122@gmail.com', '03269244586', '4230111078945', '2002-06-06', 'nursing_staff', 'activate', '');

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
(1, 'Shan Foods Pvt Ltd.', 'shanfoods@gamil.com', 'Yaseen Khan', '03269243547', '03269243547', 3, 3, 1, 'activate', '1,2,9'),
(2, 'NDure', 'ndure@gmail.com', 'Abdul Sttar', '03331234567', '03331234567', 3, 3, 1, 'activate', '1,2,10,12');

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
(1, 1, 1, NULL, '1200', NULL),
(2, 1, 2, NULL, '3000', NULL),
(3, 1, 2, 3, '3000', '500'),
(4, 1, 2, 4, '3000', '500'),
(5, 1, 9, NULL, '5000', NULL),
(12, 2, 1, NULL, '500', '0'),
(13, 2, 2, NULL, '1500', '0'),
(14, 2, 2, 3, '0', '600'),
(15, 2, 2, 4, '0', '700'),
(16, 2, 12, NULL, '2000', '0');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_patients`
--

CREATE TABLE `tbl_patients` (
  `patient_id` int(11) NOT NULL,
  `mr_no` varchar(50) NOT NULL,
  `registration_date` varchar(50) NOT NULL,
  `patient_name` varchar(200) NOT NULL,
  `attendent_name` varchar(100) NOT NULL,
  `patient_age` varchar(50) NOT NULL,
  `patient_gender` varchar(20) NOT NULL,
  `patient_contact` varchar(50) NOT NULL,
  `patient_whatsapp` varchar(50) NOT NULL,
  `patient_email` varchar(50) NOT NULL,
  `patient_status` varchar(50) NOT NULL,
  `patient_address` text NOT NULL,
  `patient_admit_date` varchar(50) NOT NULL,
  `patient_discharge_date` varchar(50) NOT NULL,
  `patient_total_days` varchar(50) NOT NULL DEFAULT '0',
  `province_id` int(11) NOT NULL,
  `city_id` int(11) NOT NULL,
  `area_id` int(11) NOT NULL,
  `refferal_id` int(11) NOT NULL,
  `panel_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `payment_status` varchar(50) NOT NULL,
  `patient_rate` varchar(100) NOT NULL,
  `staff_rate` varchar(100) NOT NULL,
  `service_id` int(11) NOT NULL,
  `recovery` varchar(300) NOT NULL,
  `running_bill` varchar(200) NOT NULL,
  `note` text NOT NULL,
  `changes_person` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_patients`
--

INSERT INTO `tbl_patients` (`patient_id`, `mr_no`, `registration_date`, `patient_name`, `attendent_name`, `patient_age`, `patient_gender`, `patient_contact`, `patient_whatsapp`, `patient_email`, `patient_status`, `patient_address`, `patient_admit_date`, `patient_discharge_date`, `patient_total_days`, `province_id`, `city_id`, `area_id`, `refferal_id`, `panel_id`, `employee_id`, `payment_status`, `patient_rate`, `staff_rate`, `service_id`, `recovery`, `running_bill`, `note`, `changes_person`) VALUES
(2, '2024-07-002', '2024-07-21 23:12:13', 'Muhammad Raza Jutt', 'Shakeel Ahmed', '19', 'female', '03091024600', '03091024600', 'muhammad@gmail.com', 'Discharged', '437 new iqbalabad Drigh Road Karachi', '2024-07-16', '2024-07-25', '9', 6, 9, 15, 2, 3, 1, 'Other', '1800', '1200', 2, 'recovery', 'bill', 'Very Well Notezzz', 'Admin'),
(3, '2024-07-003', '2024-07-21 23:15:34', 'Riaz Khan', 'Self', '19', 'male', '03091024111', '03091024111', 'riaz@gmail.com', 'Discharged', 'House No 33 Shar-e-faisal, Karachi', '2024-07-01', '2024-07-23', '22', 3, 2, 5, 1, 2, 1, 'r_from_patient', '2000', '1200', 1, 'recovery', 'Running Bill', 'Note Something in Note Field', 'Ahmed Raza '),
(4, '2024-07-003', '2024-07-24 04:24:43', 'Farooq Khan', 'Self', '35', 'male', '03091024628', '03091024628', 'farooq@gmail.com', 'Discharged', '437 new iqbalabad drigh road karachi', '2024-07-01', '2024-07-19', '18', 2, 10, 16, 1, 2, 1124, 'Other', '1500', '1300', 1, '', '', 'This is notes', 'Admin');

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
  `status` varchar(50) NOT NULL DEFAULT 'activate',
  `changes_person` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_refferals`
--

INSERT INTO `tbl_refferals` (`id`, `name`, `company`, `email`, `financial_share`, `status`, `changes_person`) VALUES
(1, 'Ahmed Raza', 'Ibex', 'Ahmed@gamil.com', 12, 'activate', ''),
(2, 'Abdullah Khalid', 'ABC Company', 'abdullah@gmail.com', 40, 'activate', '');

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

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

CREATE TABLE `tbl_users` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(250) NOT NULL,
  `user_father_name` varchar(255) NOT NULL,
  `user_email` varchar(200) NOT NULL,
  `user_password` varchar(250) NOT NULL,
  `user_contact` varchar(50) NOT NULL,
  `user_nic` varchar(50) NOT NULL,
  `user_dob` varchar(50) NOT NULL,
  `user_status` varchar(50) NOT NULL DEFAULT 'activate',
  `pages_access` varchar(300) NOT NULL,
  `registration_status` varchar(255) NOT NULL DEFAULT 'registered'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_users`
--

INSERT INTO `tbl_users` (`user_id`, `user_name`, `user_father_name`, `user_email`, `user_password`, `user_contact`, `user_nic`, `user_dob`, `user_status`, `pages_access`, `registration_status`) VALUES
(1, 'Ahmed Raza', 'Muhammad Razzaq', 'ahmed@gmail.com', 'ahmed123', '03269243547', '4230112345678', '2006-04-03', 'activate', 'service_management,address_management,reffrel_management,employee_management,patient_management', 'registered'),
(2, 'Muhammad Minhal Khan', 'Muhammad Qasim Khan', 'minhal11@gmail.com', 'minhal12345', '03269248547', '4230112345678', '2005-06-14', 'activate', 'service_management,address_management,reffrel_management,panel_management', 'registered');

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
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `emp_id` (`emp_id`);

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
-- Indexes for table `tbl_patients`
--
ALTER TABLE `tbl_patients`
  ADD PRIMARY KEY (`patient_id`);

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
-- Indexes for table `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD PRIMARY KEY (`user_id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_extra_services`
--
ALTER TABLE `tbl_extra_services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_panel`
--
ALTER TABLE `tbl_panel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_panel_services`
--
ALTER TABLE `tbl_panel_services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `tbl_patients`
--
ALTER TABLE `tbl_patients`
  MODIFY `patient_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_province`
--
ALTER TABLE `tbl_province`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_refferals`
--
ALTER TABLE `tbl_refferals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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

--
-- AUTO_INCREMENT for table `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
