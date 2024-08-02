-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 02, 2024 at 12:43 PM
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
  `city_id` int(11) NOT NULL,
  `disabled_status` varchar(50) NOT NULL DEFAULT 'enabled'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_area`
--

INSERT INTO `tbl_area` (`id`, `area`, `city_id`, `disabled_status`) VALUES
(1, 'Abdullah Town', 3, 'enabled'),
(3, 'Gulshn-e-Iqbal', 1, 'enabled'),
(5, 'Aziz Bhati Town', 2, 'enabled'),
(7, ' Data Gang Baksh Town', 2, 'enabled'),
(8, 'Faisal Mosque', 3, 'enabled'),
(9, 'Islamia College University', 6, 'enabled'),
(10, 'Peshawar Garrison Club', 6, 'enabled'),
(11, 'Chiltan', 7, 'enabled'),
(12, 'Takatoo', 7, 'enabled'),
(13, 'Jiwani', 8, 'enabled'),
(14, 'Makola', 8, 'enabled'),
(15, 'Bag Notar', 9, 'enabled'),
(16, 'Ratodero', 10, 'enabled'),
(17, 'Shahfaisal Colony', 1, 'enabled');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_city`
--

CREATE TABLE `tbl_city` (
  `id` int(11) NOT NULL,
  `city` varchar(255) NOT NULL,
  `province_id` int(11) NOT NULL,
  `disabled_status` varchar(50) NOT NULL DEFAULT 'enabled'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_city`
--

INSERT INTO `tbl_city` (`id`, `city`, `province_id`, `disabled_status`) VALUES
(1, 'Karachi', 2, 'enabled'),
(2, 'Lahore', 3, 'disabled'),
(3, 'Islamabad', 3, 'enabled'),
(6, 'Peshawar', 6, 'enabled'),
(7, 'Quetta', 5, 'enabled'),
(8, 'Gwadar', 5, 'enabled'),
(9, 'Abbottabad', 6, 'enabled'),
(10, 'Larkana', 2, 'enabled'),
(11, 'Raiiwind', 3, 'enabled');

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
  `disabled_status` varchar(50) NOT NULL DEFAULT 'enabled'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_employees`
--

INSERT INTO `tbl_employees` (`id`, `emp_id`, `emp_name`, `emp_father_name`, `emp_email`, `emp_contact`, `emp_nic`, `emp_dob`, `emp_designation`, `emp_status`, `disabled_status`) VALUES
(1, '1124-544', 'Ahmed Raza Jutt', 'Muhammad Razzaq', 'ahmed@gmail.com', '03129987650', '4230111018277', '2006-04-03', 'nursing_staff', 'activate', 'enabled'),
(2, '1234-567', 'Muhammad Minhal', 'Muhammad Qasim', 'minhal@gmail.com', '03269243543', '4230111018111', '2008-12-17', 'nursing_staff', 'activate', 'enabled'),
(3, '2222-564', 'Muhammad Raza', 'Muhammad Razzaq', 'raza@gmail.com', '03269243547', '4230111238111', '2000-07-06', 'physiotherapist', 'activate', 'enabled'),
(4, '4521-235', 'Ayub Khan', 'Muhammd Ayub', 'ayub@gmail.com', '03129987654', '4230111018223', '2001-06-12', 'nursing_staff', 'activate', 'enabled'),
(5, '4556-785', 'Yasir ', 'Nawaz', 'yasir122@gmail.com', '03269244586', '4230111078945', '2002-06-06', 'nursing_staff', 'activate', 'enabled'),
(6, '6647-224', 'Shabir Salehri', 'Muhammad Shreef', 'shabir@gmail.com', '03129987654', '4230111018223', '1999-06-24', 'physiotherapist', 'activate', 'enabled');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_extra_services`
--

CREATE TABLE `tbl_extra_services` (
  `id` int(11) NOT NULL,
  `extra_service` varchar(200) NOT NULL,
  `extra_service_price` bigint(20) NOT NULL,
  `sub_services_id` int(11) NOT NULL,
  `status` varchar(100) NOT NULL DEFAULT 'available',
  `disabled_status` varchar(50) NOT NULL DEFAULT 'enabled'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_extra_services`
--

INSERT INTO `tbl_extra_services` (`id`, `extra_service`, `extra_service_price`, `sub_services_id`, `status`, `disabled_status`) VALUES
(1, 'Leg Injection', 700, 3, 'available', 'enabled'),
(2, 'Hand Injection', 500, 3, 'available', 'enabled'),
(3, 'Heart Ultrasound', 3500, 9, 'available', 'enabled'),
(4, 'Heart Sonogram', 3000, 9, 'unavailable', 'enabled');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_history`
--

CREATE TABLE `tbl_history` (
  `id` int(11) NOT NULL,
  `page_name` varchar(200) NOT NULL,
  `changes_person` varchar(300) NOT NULL,
  `change_type` varchar(100) NOT NULL,
  `date` varchar(50) NOT NULL,
  `time` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_history`
--

INSERT INTO `tbl_history` (`id`, `page_name`, `changes_person`, `change_type`, `date`, `time`) VALUES
(1, 'manage_service', 'Admin', 'add_manage_service', '2024-07-31', '12:00:19'),
(2, 'service_main_head', 'Admin', 'add_service_main_head', '2024-07-31', '12:02:08'),
(3, 'service_main_head', 'Admin', 'add_service_main_head', '2024-07-31', '12:02:58'),
(4, 'service_main_head', 'Admin', 'add_service_main_head', '2024-07-31', '12:03:10'),
(5, 'service_main_head', 'Admin', 'add_service_main_head', '2024-07-31', '12:03:21'),
(6, 'service_main_head', 'Admin', 'add_service_main_head', '2024-07-31', '12:03:44'),
(7, 'manage_service', 'Admin', 'add_manage_service', '2024-07-31', '12:04:00'),
(8, 'service_main_head', 'Admin', 'add_service_main_head', '2024-07-31', '12:04:27'),
(9, 'service_main_head', 'Admin', 'add_service_main_head', '2024-07-31', '12:04:45'),
(10, 'service_main_head', 'Admin', 'add_service_main_head', '2024-07-31', '12:05:02'),
(11, 'service_main_head', 'Admin', 'add_service_main_head', '2024-07-31', '12:05:19'),
(12, 'service_sub_head', 'Admin', 'add_service_sub_head', '2024-07-31', '12:05:46'),
(13, 'service_sub_head', 'Admin', 'add_service_sub_head', '2024-07-31', '12:06:00'),
(14, 'service_sub_head', 'Admin', 'add_service_sub_head', '2024-07-31', '12:07:46'),
(15, 'service_sub_head', 'Admin', 'add_service_sub_head', '2024-07-31', '12:08:06'),
(16, 'manage_service', 'Admin', 'disable_manage_service', '2024-07-31', '12:20:17'),
(17, 'manage_service', 'Admin', 'enable_manage_service', '2024-07-31', '12:22:45'),
(18, 'manage_service', 'Admin', 'disable_manage_service', '2024-07-31', '12:24:29'),
(19, 'service_main_head', 'Ahmed Raza', 'enable_service_main_head', '2024-07-31', '12:36:33'),
(20, 'service_main_head', 'Admin', 'enable_service_main_head', '2024-07-31', '12:42:30'),
(21, 'service_main_head', 'Admin', 'enable_service_main_head', '2024-07-31', '12:43:22'),
(22, 'service_main_head', 'Admin', 'enable_service_main_head', '2024-07-31', '12:44:10'),
(23, 'service_main_head', 'Admin', 'disable_service_main_head', '2024-07-31', '12:44:47'),
(24, 'manage_service', 'Admin', 'enable_manage_service', '2024-07-31', '12:48:00'),
(25, 'service_sub_head', 'Admin', 'disable_service_sub_head', '2024-07-31', '12:57:33'),
(26, 'service_sub_head', 'Admin', 'enable_service_sub_head', '2024-07-31', '12:58:14'),
(27, 'service_sub_head', 'Admin', 'unavailable_service_sub_head', '2024-07-31', '12:58:38'),
(28, 'service_sub_head', 'Admin', 'edit_service_sub_head', '2024-07-31', '12:59:44'),
(29, 'province', 'Admin', 'add_province', '2024-07-31', '01:09:24'),
(30, 'province', 'Admin', 'edit_province', '2024-07-31', '01:13:22'),
(31, 'province', 'Admin', 'disable_province', '2024-07-31', '01:28:36'),
(32, 'province', 'Admin', 'enable_province', '2024-07-31', '01:28:46'),
(33, 'province', 'Admin', 'disable_province', '2024-07-31', '01:01:00'),
(34, 'province', 'Admin', 'enable_province', '2024-07-31', '01:01:14'),
(35, 'city', 'Admin', 'add_city', '2024-07-31', '01:06:19'),
(36, 'city', 'Admin', 'edit_city', '2024-07-31', '01:08:28'),
(37, 'city', 'Admin', 'disable_city', '2024-07-31', '01:20:27'),
(38, 'city', 'Admin', 'disable_city', '2024-07-31', '01:21:39'),
(39, 'city', 'Admin', 'disable_city', '2024-07-31', '01:22:02'),
(40, 'city', 'Admin', 'disable_city', '2024-07-31', '01:22:27'),
(41, 'city', 'Admin', 'enable_city', '2024-07-31', '01:24:02'),
(42, 'province', 'Admin', 'disable_province', '2024-07-31', '01:26:18'),
(43, 'city', 'Admin', 'enable_city', '2024-07-31', '01:27:42'),
(44, 'area', 'Admin', 'edit_area', '2024-07-31', '01:40:47'),
(45, 'area', 'Admin', 'add_area', '2024-07-31', '01:41:21'),
(46, 'area', 'Admin', 'disable_area', '2024-07-31', '01:51:55'),
(47, 'area', 'Admin', 'enable_area', '2024-07-31', '01:52:36'),
(48, 'refferals', 'Admin', 'add_refferals', '2024-07-31', '11:59:11'),
(49, 'refferals', 'Admin', 'edit_refferals', '2024-08-01', '12:02:35'),
(50, 'refferals', 'Admin', 'disable_refferals', '2024-08-01', '12:08:49'),
(51, 'refferals', 'Admin', 'disable_refferals', '2024-08-01', '12:10:14'),
(52, 'refferals', 'Admin', 'disable_refferals', '2024-08-01', '12:10:22'),
(53, 'province', 'Admin', 'enable_province', '2024-08-01', '12:27:24'),
(54, 'panels', 'Admin', 'add_panels', '2024-08-01', '12:38:45'),
(55, 'panels', 'Admin', 'edit_panels', '2024-08-01', '12:40:47'),
(56, 'panels', 'Admin', 'disable_panels', '2024-08-01', '12:46:21'),
(57, 'panels', 'Admin', 'enable_panels', '2024-08-01', '12:46:36'),
(58, 'province', 'Admin', 'disable_province', '2024-08-01', '12:53:53'),
(59, 'city', 'Admin', 'enable_city', '2024-08-01', '12:56:59'),
(60, 'area', 'Admin', 'disable_area', '2024-08-01', '12:57:24'),
(61, 'area', 'Admin', 'enable_area', '2024-08-01', '12:57:41'),
(62, 'city', 'Admin', 'disable_city', '2024-08-01', '01:05:54'),
(63, 'panels', 'Admin', 'deactivate_panels', '2024-08-01', '01:08:53'),
(64, 'panels', 'Admin', 'activate_panels', '2024-08-01', '01:09:13'),
(65, 'employees', 'Admin', 'add_employees', '2024-08-01', '01:18:31'),
(66, 'employees', 'Admin', 'edit_employees', '2024-08-01', '01:27:52'),
(67, 'employees', '', 'disable_employees', '2024-08-01', '01:42:39'),
(68, 'employees', '', 'disable_employees', '2024-08-01', '01:43:10'),
(69, 'employees', '', 'disable_employees', '2024-08-01', '01:44:31'),
(70, 'employees', 'Admin', 'disable_employees', '2024-08-01', '01:46:22'),
(71, 'employees', 'Admin', 'disable_employees', '2024-08-01', '01:47:53'),
(72, 'employees', 'Admin', 'enable_employees', '2024-08-01', '01:49:26'),
(73, 'employees', 'Admin', 'disable_employees', '2024-08-01', '01:50:06'),
(74, 'employees', 'Admin', 'disable_employees', '2024-08-01', '01:51:43'),
(75, 'employees', 'Admin', 'disable_employees', '2024-08-01', '01:52:03'),
(76, 'employees', 'Admin', 'enable_employees', '2024-08-01', '01:54:20'),
(77, 'employees', 'Admin', 'activate_employees', '2024-08-01', '01:56:32'),
(78, 'employees', 'Admin', 'deactivate_employees', '2024-08-01', '01:56:42'),
(79, 'employees', 'Admin', 'deactivate_employees', '2024-08-01', '01:57:00'),
(80, 'employees', 'Admin', 'activate_employees', '2024-08-01', '01:59:36'),
(81, 'employees', 'Admin', 'enable_employees', '2024-08-01', '01:59:46');

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
  `services` text NOT NULL,
  `disabled_status` varchar(50) NOT NULL DEFAULT 'enabled'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_panel`
--

INSERT INTO `tbl_panel` (`id`, `company`, `email`, `focal_person`, `company_contact`, `focal_person_contact`, `province_id`, `city_id`, `area_id`, `status`, `services`, `disabled_status`) VALUES
(1, 'Shan Foods Pvt Ltd.', 'shanfoods@gamil.com', 'Yaseen Khan', '03269243547', '03269243547', 3, 3, 1, 'activate', '1,2,9', 'enabled'),
(2, 'NDure', 'ndure@gmail.com', 'Abdul Sttar', '03331234567', '03331234567', 3, 3, 1, 'activate', '1,2,10,12', 'enabled'),
(3, 'Bata Shoes', 'batashoes@gmail.com', 'Muhammad Raheem', '03331234567', '03331234567', 3, 2, 5, 'activate', '1,3,8', 'enabled'),
(4, 'HBL Private Limitted.', 'hbl@gmail.com', 'Wahab Khan', '03269243547', '03269243547', 2, 10, 16, 'activate', '2,6', 'enabled');

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
(16, 2, 12, NULL, '2000', '0'),
(17, 3, 1, NULL, '600', '0'),
(18, 3, 3, NULL, '999', '0'),
(19, 3, 3, 1, '999', '500'),
(20, 3, 3, 2, '999', '400'),
(21, 3, 8, NULL, '12000', '0'),
(24, 4, 1, NULL, '500', '0'),
(25, 4, 2, NULL, '600', '0'),
(26, 4, 6, NULL, '4500', '0');

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
  `employee_id` varchar(11) NOT NULL,
  `payment_status` varchar(50) NOT NULL,
  `patient_rate` varchar(100) NOT NULL,
  `staff_rate` varchar(100) NOT NULL,
  `service_id` int(11) NOT NULL,
  `recovery` varchar(300) NOT NULL,
  `running_bill` varchar(200) NOT NULL,
  `note` text NOT NULL,
  `changes_person` varchar(255) NOT NULL,
  `disabled_status` varchar(50) NOT NULL DEFAULT 'enabled'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_patients`
--

INSERT INTO `tbl_patients` (`patient_id`, `mr_no`, `registration_date`, `patient_name`, `attendent_name`, `patient_age`, `patient_gender`, `patient_contact`, `patient_whatsapp`, `patient_email`, `patient_status`, `patient_address`, `patient_admit_date`, `patient_discharge_date`, `patient_total_days`, `province_id`, `city_id`, `area_id`, `refferal_id`, `panel_id`, `employee_id`, `payment_status`, `patient_rate`, `staff_rate`, `service_id`, `recovery`, `running_bill`, `note`, `changes_person`, `disabled_status`) VALUES
(1, '2024-07-001', '2024-07-30 01:26:36', 'Ahmed Raza', 'Self', '22', 'male', '03091024628', '03091024628', 'ahmed@gmail.com', 'Discharged', 'House No 437 New Iqbalabad Drigh Road Karachi', '2024-08-15', '2024-08-15', '0', 3, 2, 7, 2, 1, '2222-564', 'zakat_donation', '3000', '1500', 1, 'recovery', 'Running Bill', 'Last Change == Minhal', 'Muhammad Minhal Khan', 'enabled');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_province`
--

CREATE TABLE `tbl_province` (
  `id` int(11) NOT NULL,
  `province` varchar(100) NOT NULL,
  `disabled_status` varchar(50) NOT NULL DEFAULT 'enabled'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_province`
--

INSERT INTO `tbl_province` (`id`, `province`, `disabled_status`) VALUES
(2, 'Sindh', 'enabled'),
(3, 'Punjab', 'enabled'),
(5, 'Balochistan', 'enabled'),
(6, 'KPK', 'enabled'),
(7, 'Sindh 2', 'disabled');

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
  `disabled_status` varchar(50) NOT NULL DEFAULT 'enabled'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_refferals`
--

INSERT INTO `tbl_refferals` (`id`, `name`, `company`, `email`, `financial_share`, `status`, `disabled_status`) VALUES
(1, 'Ahmed Raza', 'Ibexx', 'Ahmed@gamil.com', 12, 'activate', 'disabled'),
(2, 'Abdullah Khalid', 'ABC Company', 'abdullah@gmail.com', 40, 'activate', 'enabled'),
(3, 'Khurram bhai', 'Soorty Enterprise ', 'usuf.razzak1996@gmail.com', 20, 'activate', 'enabled'),
(4, 'Muhammad Raza', 'ABC Company', 'ar03126655@gmail.com', 21, 'activate', 'disabled');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_services`
--

CREATE TABLE `tbl_services` (
  `id` int(11) NOT NULL,
  `service` varchar(200) NOT NULL,
  `status` varchar(30) NOT NULL DEFAULT 'available',
  `disabled_status` varchar(50) NOT NULL DEFAULT 'enabled'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_services`
--

INSERT INTO `tbl_services` (`id`, `service`, `status`, `disabled_status`) VALUES
(1, 'Medical', 'available', 'enabled'),
(2, 'Diagnostics', 'available', 'enabled');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_sub_services`
--

CREATE TABLE `tbl_sub_services` (
  `id` int(11) NOT NULL,
  `sub_service` varchar(200) NOT NULL,
  `sub_service_price` bigint(20) NOT NULL,
  `services_id` int(11) NOT NULL,
  `status` varchar(100) NOT NULL DEFAULT 'available',
  `disabled_status` varchar(50) NOT NULL DEFAULT 'enabled'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_sub_services`
--

INSERT INTO `tbl_sub_services` (`id`, `sub_service`, `sub_service_price`, `services_id`, `status`, `disabled_status`) VALUES
(1, 'Attendent', 1000, 1, 'available', 'enabled'),
(2, 'Consultation', 1500, 1, 'available', 'enabled'),
(3, 'Injection', 1000, 1, 'available', 'enabled'),
(4, 'Drip Application', 2000, 1, 'available', 'disabled'),
(5, 'Blood Collection', 700, 1, 'available', 'enabled'),
(6, 'Portable ECG', 2500, 2, 'available', 'enabled'),
(7, 'Portable UltraSound - Doppler', 1300, 2, 'available', 'enabled'),
(8, 'Portable UltraSound - Conventional', 1900, 2, 'available', 'enabled'),
(9, 'Portable Enchardiography', 3000, 2, 'available', 'enabled');

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
(2, 'Muhammad Minhal Khan', 'Muhammad Qasim Khan', 'minhal11@gmail.com', 'minhal12345', '03269248547', '4230112345678', '2005-06-14', 'activate', 'panel_management,employee_management,user_management,patient_management', 'registered');

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
-- Indexes for table `tbl_history`
--
ALTER TABLE `tbl_history`
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `tbl_city`
--
ALTER TABLE `tbl_city`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tbl_employees`
--
ALTER TABLE `tbl_employees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_extra_services`
--
ALTER TABLE `tbl_extra_services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_history`
--
ALTER TABLE `tbl_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT for table `tbl_panel`
--
ALTER TABLE `tbl_panel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_panel_services`
--
ALTER TABLE `tbl_panel_services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `tbl_patients`
--
ALTER TABLE `tbl_patients`
  MODIFY `patient_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_province`
--
ALTER TABLE `tbl_province`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbl_refferals`
--
ALTER TABLE `tbl_refferals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_services`
--
ALTER TABLE `tbl_services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_sub_services`
--
ALTER TABLE `tbl_sub_services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
