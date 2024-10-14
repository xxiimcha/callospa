-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 09, 2024 at 08:20 AM
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
-- Database: `callospa_admin_database`
--

-- --------------------------------------------------------

--
-- Stand-in structure for view `a`
-- (See below for the actual view)
--
CREATE TABLE `a` (
`username` varchar(255)
,`password` varchar(255)
);

-- --------------------------------------------------------

--
-- Table structure for table `activity_logs`
--

CREATE TABLE `activity_logs` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `action` text NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `activity_logs`
--

INSERT INTO `activity_logs` (`id`, `username`, `action`, `timestamp`) VALUES
(830, 'superadmin', 'Accessed Rooms Dashboard Page', '2024-10-08 14:13:28'),
(831, 'superadmin', 'Accessed Manage Users Page', '2024-10-08 14:13:38'),
(832, 'superadmin', 'Accessed Manage Amenities Page', '2024-10-08 14:13:44'),
(833, 'superadmin', 'Accessed Accounts Page', '2024-10-08 14:15:33'),
(834, 'superadmin', 'Accessed Archive Page', '2024-10-08 14:15:34'),
(835, 'superadmin', 'Accessed Accounts Page', '2024-10-08 14:15:37'),
(836, 'superadmin', 'Accessed Manage Rooms Page', '2024-10-08 14:18:09'),
(837, 'superadmin', 'Accessed Manage Rooms Page', '2024-10-08 14:18:21'),
(838, 'superadmin', 'Accessed Manage Rooms Page', '2024-10-08 14:18:22'),
(839, 'superadmin', 'Accessed Administrator Page', '2024-10-08 14:18:27'),
(840, 'superadmin', 'Accessed Archive Page', '2024-10-08 14:19:12'),
(841, 'superadmin', 'Accessed Archive Page', '2024-10-08 14:19:14'),
(842, 'superadmin', 'Accessed Administrator Page', '2024-10-08 14:19:18'),
(843, 'superadmin', 'Accessed Rooms Dashboard Page', '2024-10-08 14:20:29'),
(844, 'superadmin', 'Accessed Rooms Dashboard Page', '2024-10-08 14:20:30'),
(845, 'superadmin', 'Accessed Rooms Dashboard Page', '2024-10-08 14:20:37'),
(846, 'superadmin', 'Accessed Administrator Page', '2024-10-08 14:20:42'),
(847, 'superadmin', 'Accessed Administrator Page', '2024-10-08 14:20:43'),
(848, 'superadmin', 'Accessed Accounts Page', '2024-10-08 14:21:27'),
(849, 'superadmin', 'Accessed Administrator Page', '2024-10-08 14:21:40'),
(850, 'superadmin', 'Accessed Archive Page', '2024-10-08 14:21:42'),
(851, 'superadmin', 'Accessed Accounts Page', '2024-10-08 14:21:44'),
(852, 'superadmin', 'Accessed Manage Users Page', '2024-10-08 14:24:39'),
(853, 'superadmin', 'Accessed Manage Rooms Page', '2024-10-08 14:24:41'),
(854, 'superadmin', 'Accessed Manage Events Page', '2024-10-08 14:24:42'),
(855, 'superadmin', 'Accessed Manage Amenities Page', '2024-10-08 14:24:44'),
(856, 'superadmin', 'Accessed Administrator Page', '2024-10-08 14:28:21'),
(857, 'superadmin', 'Accessed Administrator Page', '2024-10-08 14:38:38'),
(858, 'superadmin', 'Accessed Archive Page', '2024-10-08 14:38:40'),
(859, 'superadmin', 'Accessed Manage Amenities Page', '2024-10-08 14:40:26'),
(860, 'superadmin', 'Accessed Archive Page', '2024-10-08 14:40:32'),
(861, 'superadmin', 'Accessed Manage Rooms Page', '2024-10-08 14:41:38'),
(862, 'superadmin', 'Accessed Manage Events Page', '2024-10-08 14:41:40'),
(863, 'superadmin', 'Accessed Administrator Page', '2024-10-08 14:45:03'),
(864, 'superadmin', 'Accessed Administrator Page', '2024-10-08 14:45:20'),
(865, 'superadmin', 'Accessed Administrator Page', '2024-10-08 14:47:15'),
(866, 'superadmin', 'Accessed Manage Users Page', '2024-10-08 14:47:17'),
(867, 'superadmin', 'Accessed Manage Rooms Page', '2024-10-08 14:47:20'),
(868, 'superadmin', 'Accessed Manage Events Page', '2024-10-08 14:47:21'),
(869, 'superadmin', 'Accessed Manage Amenities Page', '2024-10-08 14:47:22'),
(870, 'superadmin', 'Accessed Administrator Page', '2024-10-08 14:47:26'),
(871, 'superadmin', 'Accessed Administrator Page', '2024-10-08 14:47:45'),
(872, 'superadmin', 'Accessed Manage Users Page', '2024-10-08 14:51:53'),
(873, 'superadmin', 'Accessed Administrator Page', '2024-10-08 14:51:55'),
(874, 'superadmin', 'Accessed Manage Rooms Page', '2024-10-08 14:57:56'),
(875, 'superadmin', 'Accessed Administrator Page', '2024-10-08 15:09:25'),
(876, 'superadmin', 'Accessed Manage Rooms Page', '2024-10-08 15:09:27'),
(877, 'superadmin', 'Accessed Manage Events Page', '2024-10-08 15:09:30'),
(878, 'superadmin', 'Accessed Manage Amenities Page', '2024-10-08 15:09:32'),
(879, 'superadmin', 'Accessed Manage Events Page', '2024-10-08 15:09:34'),
(880, 'superadmin', 'Accessed Archive Page', '2024-10-08 15:09:36'),
(881, 'superadmin', 'Accessed Manage Events Page', '2024-10-08 15:09:42'),
(882, 'superadmin', 'Accessed Manage Events Page', '2024-10-08 15:10:54'),
(883, 'superadmin', 'Accessed Manage Events Page', '2024-10-08 15:11:02'),
(884, 'superadmin', 'Accessed Manage Events Page', '2024-10-08 15:11:07'),
(885, 'superadmin', 'Accessed Manage Package Page', '2024-10-08 15:12:07'),
(886, 'superadmin', 'Accessed Rooms Dashboard Page', '2024-10-08 15:17:07'),
(887, 'superadmin', 'Accessed Manage Rooms Page', '2024-10-08 15:17:10'),
(888, 'superadmin', 'Accessed Administrator Page', '2024-10-08 15:17:17'),
(889, 'superadmin', 'Accessed Manage Rooms Page', '2024-10-08 15:17:19'),
(890, 'superadmin', 'Accessed Manage Amenities Page', '2024-10-08 15:17:21'),
(891, 'superadmin', 'Accessed Manage Amenities Page', '2024-10-08 15:17:32'),
(892, 'superadmin', 'Accessed Accounts Page', '2024-10-08 15:17:35'),
(893, 'superadmin', 'Accessed Accounts Page', '2024-10-08 15:18:08'),
(894, 'superadmin', 'Accessed Rooms Dashboard Page', '2024-10-08 16:01:06'),
(895, 'superadmin', 'Accessed Rooms Dashboard Page', '2024-10-08 16:03:19'),
(896, 'superadmin', 'Accessed Rooms Dashboard Page', '2024-10-08 16:04:09'),
(897, 'superadmin', 'Accessed Rooms Dashboard Page', '2024-10-08 16:04:20'),
(898, 'superadmin', 'Accessed Rooms Dashboard Page', '2024-10-08 16:04:38'),
(899, 'superadmin', 'Accessed Rooms Dashboard Page', '2024-10-08 16:05:30'),
(900, 'superadmin', 'Accessed Rooms Dashboard Page', '2024-10-08 16:05:53'),
(901, 'superadmin', 'Accessed Rooms Dashboard Page', '2024-10-08 16:05:53'),
(902, 'superadmin', 'Accessed Rooms Dashboard Page', '2024-10-08 16:07:02'),
(903, 'superadmin', 'Accessed Rooms Dashboard Page', '2024-10-08 16:07:19'),
(904, 'superadmin', 'Accessed Rooms Dashboard Page', '2024-10-08 16:09:52'),
(905, 'superadmin', 'Accessed Rooms Dashboard Page', '2024-10-08 16:11:59'),
(906, 'superadmin', 'Accessed Rooms Dashboard Page', '2024-10-08 16:13:37'),
(907, 'superadmin', 'Accessed Rooms Dashboard Page', '2024-10-08 16:15:21'),
(908, 'superadmin', 'Accessed Rooms Dashboard Page', '2024-10-08 16:16:39'),
(909, 'superadmin', 'Accessed Administrator Page', '2024-10-08 16:57:51'),
(910, 'superadmin', 'Accessed Administrator Page', '2024-10-08 16:58:03'),
(911, 'superadmin', 'Accessed Administrator Page', '2024-10-08 16:58:56'),
(912, 'superadmin', 'Accessed Administrator Page', '2024-10-08 17:00:35'),
(913, 'superadmin', 'Accessed Administrator Page', '2024-10-08 17:01:38'),
(914, 'superadmin', 'Accessed Administrator Page', '2024-10-08 17:02:14'),
(915, 'superadmin', 'Accessed Administrator Page', '2024-10-08 17:14:57'),
(916, 'superadmin', 'Accessed Administrator Page', '2024-10-08 17:24:51'),
(917, 'superadmin', 'Accessed Administrator Page', '2024-10-08 17:26:18'),
(918, 'superadmin', 'Accessed Administrator Page', '2024-10-08 17:53:09'),
(919, 'superadmin', 'Accessed Administrator Page', '2024-10-08 17:59:24'),
(920, 'superadmin', 'Accessed Rooms Dashboard Page', '2024-10-08 18:00:50'),
(921, 'superadmin', 'Accessed Administrator Page', '2024-10-08 18:00:57'),
(922, 'superadmin', 'Accessed Rooms Dashboard Page', '2024-10-08 18:01:05'),
(923, 'superadmin', 'Accessed Administrator Page', '2024-10-08 18:03:23'),
(924, 'superadmin', 'Accessed Administrator Page', '2024-10-08 18:05:32'),
(925, 'superadmin', 'Accessed Administrator Page', '2024-10-08 18:07:54'),
(926, 'superadmin', 'Accessed Administrator Page', '2024-10-08 18:07:55'),
(927, 'superadmin', 'Accessed Administrator Page', '2024-10-08 18:07:59'),
(928, 'superadmin', 'Accessed Administrator Page', '2024-10-08 18:08:05'),
(929, 'superadmin', 'Accessed Administrator Page', '2024-10-08 18:08:12'),
(930, 'superadmin', 'Accessed Administrator Page', '2024-10-08 18:08:18'),
(931, 'superadmin', 'Accessed Administrator Page', '2024-10-08 18:08:28'),
(932, 'superadmin', 'Accessed Administrator Page', '2024-10-08 18:08:55'),
(933, 'superadmin', 'Accessed Administrator Page', '2024-10-08 18:08:56'),
(934, 'superadmin', 'Accessed Administrator Page', '2024-10-08 18:10:07'),
(935, 'superadmin', 'Accessed Administrator Page', '2024-10-08 18:10:10'),
(936, 'superadmin', 'Accessed Rooms Dashboard Page', '2024-10-08 18:10:15'),
(937, 'superadmin', 'Accessed Events Dashboard Page', '2024-10-08 18:10:20'),
(938, 'superadmin', 'Accessed Rooms Dashboard Page', '2024-10-08 18:10:25'),
(939, 'superadmin', 'Accessed Administrator Page', '2024-10-08 18:10:45'),
(940, 'superadmin', 'Accessed Administrator Page', '2024-10-08 18:10:50'),
(941, 'superadmin', 'Accessed Administrator Page', '2024-10-08 18:11:06'),
(942, 'superadmin', 'Accessed Administrator Page', '2024-10-08 18:11:16'),
(943, 'superadmin', 'Accessed Administrator Page', '2024-10-08 18:11:41'),
(944, 'superadmin', 'Accessed Administrator Page', '2024-10-08 18:11:45'),
(945, 'superadmin', 'Accessed Administrator Page', '2024-10-08 18:13:23'),
(946, 'superadmin', 'Accessed Rooms Dashboard Page', '2024-10-08 18:13:25'),
(947, 'superadmin', 'Accessed Administrator Page', '2024-10-08 18:35:44'),
(948, 'superadmin', 'Accessed Administrator Page', '2024-10-08 18:37:14'),
(949, 'superadmin', 'Accessed Rooms Dashboard Page', '2024-10-08 18:37:36'),
(950, 'superadmin', 'Accessed Rooms Dashboard Page', '2024-10-08 18:55:06'),
(951, 'superadmin', 'Accessed Rooms Dashboard Page', '2024-10-08 19:06:59'),
(952, 'superadmin', 'Accessed Rooms Dashboard Page', '2024-10-08 19:08:02'),
(953, 'superadmin', 'Accessed Rooms Dashboard Page', '2024-10-08 19:08:40'),
(954, 'superadmin', 'Accessed Rooms Dashboard Page', '2024-10-08 19:10:06'),
(955, 'superadmin', 'Accessed Rooms Dashboard Page', '2024-10-08 19:11:07'),
(956, 'superadmin', 'Accessed Rooms Dashboard Page', '2024-10-08 19:11:15'),
(957, 'superadmin', 'Accessed Rooms Dashboard Page', '2024-10-08 19:12:52'),
(958, 'superadmin', 'Accessed Rooms Dashboard Page', '2024-10-08 19:14:58'),
(959, 'superadmin', 'Accessed Rooms Dashboard Page', '2024-10-08 19:16:10'),
(960, 'superadmin', 'Accessed Rooms Dashboard Page', '2024-10-08 19:40:05'),
(961, 'superadmin', 'Accessed Rooms Dashboard Page', '2024-10-08 19:48:35'),
(962, 'superadmin', 'Accessed Rooms Dashboard Page', '2024-10-08 19:52:52'),
(963, 'superadmin', 'Accessed Administrator Page', '2024-10-08 20:15:57'),
(964, 'superadmin', 'Accessed Administrator Page', '2024-10-09 04:03:51'),
(965, 'superadmin', 'Accessed Manage Events Page', '2024-10-09 04:06:09'),
(966, 'superadmin', 'Accessed Administrator Page', '2024-10-09 04:36:41'),
(967, 'superadmin', 'Accessed Rooms Dashboard Page', '2024-10-09 04:36:51'),
(968, 'superadmin', 'Accessed Administrator Page', '2024-10-09 05:09:42'),
(969, 'superadmin', 'Accessed Administrator Page', '2024-10-09 05:09:44'),
(970, 'superadmin', 'Accessed Administrator Page', '2024-10-09 05:09:46'),
(971, 'superadmin', 'Accessed Events Dashboard Page', '2024-10-09 05:09:49'),
(972, 'superadmin', 'Accessed Events Dashboard Page', '2024-10-09 05:10:34'),
(973, 'superadmin', 'Accessed Administrator Page', '2024-10-09 05:21:51'),
(974, 'superadmin', 'Accessed Administrator Page', '2024-10-09 05:21:53'),
(975, 'superadmin', 'Accessed Events Dashboard Page', '2024-10-09 05:46:40'),
(976, 'superadmin', 'Accessed Administrator Page', '2024-10-09 05:46:42'),
(977, 'superadmin', 'Accessed Events Dashboard Page', '2024-10-09 05:46:45'),
(978, 'superadmin', 'Accessed Manage Rooms Page', '2024-10-09 06:04:37'),
(979, 'superadmin', 'Accessed Manage Package Page', '2024-10-09 06:05:57'),
(980, 'superadmin', 'Accessed Manage Events Page', '2024-10-09 06:06:25'),
(981, 'superadmin', 'Accessed Manage Package Page', '2024-10-09 06:06:39');

-- --------------------------------------------------------

--
-- Table structure for table `admin1`
--

CREATE TABLE `admin1` (
  `id` int(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `contactnum` int(100) NOT NULL,
  `firstname` varchar(255) DEFAULT NULL,
  `lastname` varchar(255) DEFAULT NULL,
  `middlename` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin1`
--

INSERT INTO `admin1` (`id`, `username`, `password`, `contactnum`, `firstname`, `lastname`, `middlename`) VALUES
(1, 'admin1', '$2y$10$NIUXrOCu1UlRV5Ikh64yfubv0fbGa/WXUCPE8pTNbMuW65pmP5h6.', 2147483647, 'Russell Prince', 'Bazooka', 'B'),
(1, 'admin3', '$2y$10$Q21s8AHUxzAISlG2976iauPnsBMr28DwfZT2k3FnP4iLej5pKZFqC', 2147483647, 'shdgfushdaf', 'jbdgadgsfbdus', 'b'),
(1, 'francis', '$2y$10$FRb0M/n10F1B1TP6.qxQSOvPCaWHhK257Mt/u0trWGl1CyUqF7roK', 2147483647, 'kiko', 'maton', 'd'),
(0, 'superadmin', '$2y$10$A8KFPDAYkaEUWRkc0LOTLOb3IqEuSfLNJSLayLGzEkN3IU3xtXxI6', 2147483647, 'Francis', 'Tagle', 'I');

-- --------------------------------------------------------

--
-- Table structure for table `approved_reservations`
--

CREATE TABLE `approved_reservations` (
  `reservation_id` int(11) NOT NULL,
  `reservation_type` enum('Amenity','Event','Package','Room') NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `middle_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) NOT NULL,
  `contact_number` varchar(50) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `handle` varchar(100) DEFAULT NULL,
  `sources` set('Facebook','Word of Mouth','Returning Customer','Google','Others') DEFAULT NULL,
  `source_other` varchar(255) DEFAULT NULL,
  `package_category` varchar(50) DEFAULT NULL,
  `package` varchar(100) DEFAULT NULL,
  `event_type` varchar(50) DEFAULT NULL,
  `room` varchar(50) DEFAULT NULL,
  `check_in_date` date NOT NULL,
  `check_out_date` date DEFAULT NULL,
  `check_in_time` time DEFAULT NULL,
  `check_out_time` time DEFAULT NULL,
  `guests` int(11) NOT NULL,
  `additional_guest` int(11) DEFAULT 0,
  `catering_preference` varchar(50) DEFAULT NULL,
  `total_cost` decimal(10,2) NOT NULL,
  `deposit_amount` decimal(10,2) NOT NULL,
  `remaining_balance` decimal(10,2) NOT NULL,
  `payment_method` enum('BDO') NOT NULL,
  `proof_of_payment` varchar(255) NOT NULL,
  `reservation_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `approved_reservations`
--

INSERT INTO `approved_reservations` (`reservation_id`, `reservation_type`, `first_name`, `middle_name`, `last_name`, `contact_number`, `email`, `handle`, `sources`, `source_other`, `package_category`, `package`, `event_type`, `room`, `check_in_date`, `check_out_date`, `check_in_time`, `check_out_time`, `guests`, `additional_guest`, `catering_preference`, `total_cost`, `deposit_amount`, `remaining_balance`, `payment_method`, `proof_of_payment`, `reservation_date`) VALUES
(5, 'Room', 'Joseph Russell', '', 'Maricaban', '2147483647', 'josephrussellm@gmail.com', '123123', 'Facebook', '', NULL, NULL, NULL, 'Yellow Room', '2024-10-08', '2024-10-09', '13:00:00', '10:00:00', 2, 2, NULL, 4300.00, 860.00, 3440.00, '', 'Screenshot 2024-10-05 023842.png', '2024-10-08 18:11:39'),
(6, 'Event', 'Joseph Russell', '', 'Maricaban', '9561420665', 'josephrussellm@gmail.com', 'josephrussellm', 'Facebook,Word of Mouth,Returning Customer,Google,Others', '', 'Exclusive Resort Venue', 'Day Resort Grounds Exclusive', '123', NULL, '2024-10-09', '2024-10-10', '08:00:00', '16:00:00', 40, 22, '0', 20500.00, 5125.00, 15375.00, '', 'Screenshot 2024-10-09 034141.png', '2024-10-09 05:09:34');

-- --------------------------------------------------------

--
-- Table structure for table `archived_files`
--

CREATE TABLE `archived_files` (
  `id` int(11) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `archived_on` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `archived_files`
--

INSERT INTO `archived_files` (`id`, `file_name`, `archived_on`) VALUES
(27, 'archives/archived_data_2024-10-06.xlsx', '2024-10-06 18:25:48'),
(28, 'archives/archived_data_2024-10-06.xlsx', '2024-10-07 00:29:30'),
(29, 'archives/archived_data_2024-10-06.xlsx', '2024-10-07 02:11:07'),
(30, 'archives/archived_data_2024-10-06.xlsx', '2024-10-07 02:24:16'),
(31, 'archives/archived_data_2024-10-07.xlsx', '2024-10-07 22:44:24'),
(32, 'archives/archived_data_2024-10-07.xlsx', '2024-10-07 22:48:32'),
(33, 'archives/archived_data_2024-10-07.xlsx', '2024-10-07 22:48:42'),
(34, 'archives/archived_data_2024-10-07.xlsx', '2024-10-07 22:48:50'),
(35, 'archives/archived_data_2024-10-07.xlsx', '2024-10-07 22:49:09'),
(36, 'archives/archived_data_2024-10-07.xlsx', '2024-10-07 22:49:32'),
(37, 'archives/archived_data_2024-10-07.xlsx', '2024-10-07 22:49:43'),
(38, 'archives/archived_data_2024-10-07.xlsx', '2024-10-07 22:50:35'),
(39, 'archives/archived_data_2024-10-07.xlsx', '2024-10-07 22:50:58'),
(40, 'archives/archived_data_2024-10-07.xlsx', '2024-10-07 22:51:55');

-- --------------------------------------------------------

--
-- Table structure for table `login_sessions`
--

CREATE TABLE `login_sessions` (
  `user_id` varchar(255) NOT NULL,
  `session_id` varchar(255) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `user_agent` varchar(255) NOT NULL,
  `login_time` datetime NOT NULL,
  `expires` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `login_sessions`
--

INSERT INTO `login_sessions` (`user_id`, `session_id`, `ip_address`, `user_agent`, `login_time`, `expires`) VALUES
('superadmin', '035d7a6c71a635e85f71c3a24177bdb2', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Safari/537.36 OPR/113.0.0.0', '2024-10-06 20:57:46', '2024-10-06 21:57:46'),
('superadmin', '0cad15a334e124a6d5eaddfbc651d3eb', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Safari/537.36 OPR/113.0.0.0', '2024-10-07 16:07:22', '2024-10-07 17:07:22'),
('superadmin', '0cc53e6b448d8eea57dc8765d9f8fc0b', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Safari/537.36 OPR/113.0.0.0', '2024-10-06 21:25:43', '2024-10-06 22:25:43'),
('superadmin', '0ef30485f5f324ff64097b693ed035cb', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Safari/537.36 OPR/113.0.0.0', '2024-10-08 17:17:17', '2024-10-08 18:17:17'),
('superadmin', '131aaeea706f8cf5839a6562b4dcf59a', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Safari/537.36 OPR/113.0.0.0', '2024-10-07 18:14:47', '2024-10-07 19:14:47'),
('superadmin', '2bc9edb0bc2edac3197ee4a901a25e80', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Safari/537.36 OPR/113.0.0.0', '2024-10-08 16:08:09', '2024-10-08 17:08:09'),
('superadmin', '33195183429057875eff38c2f01e1636', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Safari/537.36 OPR/113.0.0.0', '2024-10-07 17:07:23', '2024-10-07 18:07:23'),
('superadmin', '35ee543004edbba1de8bfc192c667001', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Safari/537.36 OPR/113.0.0.0', '2024-10-07 17:06:40', '2024-10-07 18:06:40'),
('superadmin', '3c13faf82e1cd6631f8bbb93560ee3d9', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Safari/537.36 OPR/113.0.0.0', '2024-10-07 17:00:34', '2024-10-07 18:00:34'),
('superadmin', '3f59ee33b0b9f88b0e0f9d81cb55a288', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Safari/537.36 OPR/113.0.0.0', '2024-10-07 17:02:14', '2024-10-07 18:02:14'),
('superadmin', '3fd5c83f04f7076e8d947c51dbdded1a', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Safari/537.36 OPR/113.0.0.0', '2024-10-07 13:05:56', '2024-10-07 14:05:56'),
('superadmin', '4141d19ea7af7d4b84fbbaf207b7020e', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Safari/537.36 OPR/113.0.0.0', '2024-10-08 15:57:42', '2024-10-08 16:57:42'),
('superadmin', '4212f86825dfc536d9b20e604311e24d', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Safari/537.36 OPR/113.0.0.0', '2024-10-06 20:51:02', '2024-10-06 21:51:02'),
('superadmin', '428f2678e58c85a08cc692fd36a2d7cf', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Safari/537.36 OPR/113.0.0.0', '2024-10-07 16:03:45', '2024-10-07 17:03:45'),
('superadmin', '4c133b9e5f4ed06130a7bb170178aa59', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Safari/537.36 OPR/113.0.0.0', '2024-10-07 16:57:47', '2024-10-07 17:57:47'),
('superadmin', '4cdb5ab50611590a70c9e0fb140a10d9', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Safari/537.36 OPR/113.0.0.0', '2024-10-07 16:44:11', '2024-10-07 17:44:11'),
('superadmin', '52ba5298425331eefbe8c12a78919abf', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Safari/537.36 OPR/113.0.0.0', '2024-10-07 16:52:12', '2024-10-07 17:52:12'),
('superadmin', '5403cf63c97fc3c9689ef099cdd86922', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Safari/537.36 OPR/113.0.0.0', '2024-10-07 18:30:52', '2024-10-07 19:30:52'),
('superadmin', '5697711bf5b814cce113478ea7d2f935', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Safari/537.36 OPR/113.0.0.0', '2024-10-07 16:10:47', '2024-10-07 17:10:47'),
('superadmin', '56c54262daeef2a54361c3590e3b0c51', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Safari/537.36 OPR/113.0.0.0', '2024-10-07 16:52:24', '2024-10-07 17:52:24'),
('superadmin', '57850385bcb102998bdda05f711f6f30', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Safari/537.36 OPR/113.0.0.0', '2024-10-07 17:05:23', '2024-10-07 18:05:23'),
('superadmin', '658054c139b75c927dbdda6492e1b0e7', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Safari/537.36 OPR/113.0.0.0', '2024-10-07 12:45:46', '2024-10-07 13:45:46'),
('superadmin', '6797a8ee7060f6fe63f449cba9a02e7f', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Safari/537.36 OPR/113.0.0.0', '2024-10-07 16:50:53', '2024-10-07 17:50:53'),
('superadmin', '6c0facb22c0fde81728c8f7fe488b530', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Safari/537.36 OPR/113.0.0.0', '2024-10-06 21:27:09', '2024-10-06 22:27:09'),
('superadmin', '6ec5b7698a41c6478dbc4ee002d84720', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Safari/537.36 OPR/113.0.0.0', '2024-10-07 16:42:18', '2024-10-07 17:42:18'),
('superadmin', '70b6482e1e1cf799e7372b65d4c4e9fd', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Safari/537.36 OPR/113.0.0.0', '2024-10-07 16:11:04', '2024-10-07 17:11:04'),
('superadmin', '753e44d276663612c6fdf06114b32817', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Safari/537.36 OPR/113.0.0.0', '2024-10-07 16:05:34', '2024-10-07 17:05:34'),
('superadmin', '7758e6764a259203ef658f562858e400', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Safari/537.36 OPR/113.0.0.0', '2024-10-07 15:43:58', '2024-10-07 16:43:58'),
('superadmin', '7d1032ea234e3ad518931fd5d51f3947', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Safari/537.36 OPR/113.0.0.0', '2024-10-07 16:56:36', '2024-10-07 17:56:36'),
('superadmin', '7dc4ae0c8e343dbbbb4d7e1cda520d9a', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Safari/537.36 OPR/113.0.0.0', '2024-10-07 16:53:57', '2024-10-07 17:53:57'),
('superadmin', '7dcab04597225845c3d8b25f093439c2', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Safari/537.36 OPR/113.0.0.0', '2024-10-07 18:02:13', '2024-10-07 19:02:13'),
('superadmin', '841e2ffda5069cbdd0976674268c42be', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Safari/537.36 OPR/113.0.0.0', '2024-10-06 21:10:00', '2024-10-06 22:10:00'),
('superadmin', '8a6e133ed8471b09b12c7a2689a42cd5', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Safari/537.36 OPR/113.0.0.0', '2024-10-06 21:25:01', '2024-10-06 22:25:01'),
('superadmin', '8bcaf7f5e381b29ba08d35ae6516076c', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Safari/537.36 OPR/113.0.0.0', '2024-10-07 15:46:29', '2024-10-07 16:46:29'),
('superadmin', '8e5c4c7cc6530ca53ca60d9ac8303aaf', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Safari/537.36 OPR/113.0.0.0', '2024-10-08 15:58:31', '2024-10-08 16:58:31'),
('superadmin', '9bc09b86db1ac8f6a3d797b420bfd56c', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Safari/537.36 OPR/113.0.0.0', '2024-10-07 13:55:46', '2024-10-07 14:55:46'),
('superadmin', '9c31620402404ea4b2bee3f3f837747c', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Safari/537.36 OPR/113.0.0.0', '2024-10-06 20:10:22', '2024-10-06 21:10:22'),
('superadmin', 'a052895b683220bbadf5f2c5f1f75a8e', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Safari/537.36 OPR/113.0.0.0', '2024-10-06 21:02:24', '2024-10-06 22:02:24'),
('superadmin', 'a16b4d220a508a0b2ac49d13aa22dde4', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Safari/537.36 OPR/113.0.0.0', '2024-10-08 15:59:53', '2024-10-08 16:59:53'),
('superadmin', 'a2cdeff5ff62d6193f6ec4f6c4d17532', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Safari/537.36 OPR/113.0.0.0', '2024-10-07 17:38:18', '2024-10-07 18:38:18'),
('superadmin', 'a37cda26e359da97f80ac48bffe8aa9c', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Safari/537.36 OPR/113.0.0.0', '2024-10-07 16:15:08', '2024-10-07 17:15:08'),
('superadmin', 'a5f957ccc070b81750e148bbd12fa96a', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Safari/537.36 OPR/113.0.0.0', '2024-10-06 21:35:55', '2024-10-06 22:35:55'),
('superadmin', 'a7b3f72203de145548286e372ff5b710', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Safari/537.36 OPR/113.0.0.0', '2024-10-07 13:58:55', '2024-10-07 14:58:55'),
('superadmin', 'aa3c380385abfca8e723b85d70546e1d', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Safari/537.36 OPR/113.0.0.0', '2024-10-07 18:42:18', '2024-10-07 19:42:18'),
('superadmin', 'aa44772300d7b7e263f6dae26576a197', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Safari/537.36 OPR/113.0.0.0', '2024-10-07 12:50:46', '2024-10-07 13:50:46'),
('superadmin', 'aca84d521ad2e1f945227e4f136b0f80', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Safari/537.36 OPR/113.0.0.0', '2024-10-07 18:41:41', '2024-10-07 19:41:41'),
('superadmin', 'afb66ca22b5472d89834355caadbc5e8', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Safari/537.36 OPR/113.0.0.0', '2024-10-07 17:37:31', '2024-10-07 18:37:31'),
('superadmin', 'b061ecaa917855cac80611685fb25b1e', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Safari/537.36 OPR/113.0.0.0', '2024-10-07 13:10:05', '2024-10-07 14:10:05'),
('superadmin', 'b07251c157515f6e4ddbcdc43038e3b3', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Safari/537.36 OPR/113.0.0.0', '2024-10-07 16:45:59', '2024-10-07 17:45:59'),
('superadmin', 'b103cb3c01c589d49d9c7c4b06ebcd7c', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Safari/537.36 OPR/113.0.0.0', '2024-10-07 16:06:05', '2024-10-07 17:06:05'),
('superadmin', 'b35404ffcbc681e6d2767b9cca8f8cb6', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Safari/537.36 OPR/113.0.0.0', '2024-10-07 15:44:06', '2024-10-07 16:44:06'),
('superadmin', 'b39b388b9ba8b297ca5618bf7132a287', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Safari/537.36 OPR/113.0.0.0', '2024-10-07 17:36:28', '2024-10-07 18:36:28'),
('superadmin', 'b53e7877ef2fc5dfbb015d6163c32f21', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Safari/537.36 OPR/113.0.0.0', '2024-10-07 17:50:41', '2024-10-07 18:50:41'),
('superadmin', 'bba40841d2072453c642aa2229cdcff6', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Safari/537.36 OPR/113.0.0.0', '2024-10-06 21:36:15', '2024-10-06 22:36:15'),
('superadmin', 'bd79ea14bb045644d25fc8d61ad1f8fb', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Safari/537.36 OPR/113.0.0.0', '2024-10-07 17:12:29', '2024-10-07 18:12:29'),
('superadmin', 'c875d67be4da692ea3d747c25a952c6b', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Safari/537.36 OPR/113.0.0.0', '2024-10-07 16:43:24', '2024-10-07 17:43:24'),
('superadmin', 'c8b004c72a09fa2f582947e64fd719d4', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Safari/537.36 OPR/113.0.0.0', '2024-10-07 16:58:24', '2024-10-07 17:58:24'),
('superadmin', 'cacec6ca5722d87c6e2b6bdab2cd5159', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Safari/537.36 OPR/113.0.0.0', '2024-10-07 16:03:58', '2024-10-07 17:03:58'),
('superadmin', 'cd1d76712e848dd3343f783936302370', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Safari/537.36 OPR/113.0.0.0', '2024-10-07 16:53:47', '2024-10-07 17:53:47'),
('superadmin', 'cd33260009334df4c436e348db11e790', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Safari/537.36 OPR/113.0.0.0', '2024-10-06 21:32:19', '2024-10-06 22:32:19'),
('admin1', 'd03b80573c36285064dc4018dd789c29', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Safari/537.36 OPR/113.0.0.0', '2024-10-07 16:04:23', '2024-10-07 17:04:23'),
('superadmin', 'd0b7047e24b74072a0447efff55aca43', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Safari/537.36 OPR/113.0.0.0', '2024-10-06 21:35:28', '2024-10-06 22:35:28'),
('superadmin', 'd7269d283f3f7c3c327b9c2211c8f3b7', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Safari/537.36 OPR/113.0.0.0', '2024-10-07 16:56:44', '2024-10-07 17:56:44'),
('superadmin', 'd736e68dc7b94c3f9d6c5be4523f4ea0', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Safari/537.36 OPR/113.0.0.0', '2024-10-07 17:00:06', '2024-10-07 18:00:06'),
('superadmin', 'd749918ee0229c80403b92dac9d37f82', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Safari/537.36 OPR/113.0.0.0', '2024-10-06 21:03:55', '2024-10-06 22:03:55'),
('superadmin', 'dc4e217cf4dc7a570a831fdc1bb7d06e', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Safari/537.36 OPR/113.0.0.0', '2024-10-07 16:11:25', '2024-10-07 17:11:25'),
('superadmin', 'e15a13344d0714747cddb5ce0b1e243d', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Safari/537.36 OPR/113.0.0.0', '2024-10-07 17:45:18', '2024-10-07 18:45:18'),
('superadmin', 'e4c365239f2b66b83a2c6dd16f80379d', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Safari/537.36 OPR/113.0.0.0', '2024-10-07 13:08:08', '2024-10-07 14:08:08'),
('superadmin', 'e72004875e4f97d1515ab796874a6121', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Safari/537.36 OPR/113.0.0.0', '2024-10-08 02:57:04', '2024-10-08 03:57:04'),
('superadmin', 'ec0e75a1b0171d36affa63c0098e66f6', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Safari/537.36 OPR/113.0.0.0', '2024-10-07 13:19:16', '2024-10-07 14:19:16'),
('superadmin', 'ef5384b2b1b98d23559bd13e705e7acf', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Safari/537.36 OPR/113.0.0.0', '2024-10-07 16:42:36', '2024-10-07 17:42:36'),
('superadmin', 'f0797bba1a07a4d410bf2f8202e53918', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Safari/537.36 OPR/113.0.0.0', '2024-10-06 21:24:04', '2024-10-06 22:24:04'),
('admin1', 'f0f30e4919a1c322f25e3192a2ac0158', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Safari/537.36 OPR/113.0.0.0', '2024-10-07 16:05:12', '2024-10-07 17:05:12'),
('superadmin', 'f11ae9806d6539cdf93a1f62152eddfb', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Safari/537.36 OPR/113.0.0.0', '2024-10-07 13:07:56', '2024-10-07 14:07:56'),
('superadmin', 'f25951d671f629297499837a84414824', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Safari/537.36 OPR/113.0.0.0', '2024-10-06 21:24:42', '2024-10-06 22:24:42'),
('superadmin', 'f3bad7e946d39ff233ec7f473cfe70d9', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/129.0.0.0 Safari/537.36 Edg/129.0.0.0', '2024-10-09 06:03:51', '2024-10-09 07:03:51'),
('superadmin', 'f497d975743e08437c7185e45e5766d9', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Safari/537.36 OPR/113.0.0.0', '2024-10-07 16:10:15', '2024-10-07 17:10:15'),
('superadmin', 'f62791a213e2adbc65c0fbbc9c0675f7', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Safari/537.36 OPR/113.0.0.0', '2024-10-08 02:32:11', '2024-10-08 03:32:11'),
('superadmin', 'f86c679fd7b7a5fbe560027ca4a152d2', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Safari/537.36 OPR/113.0.0.0', '2024-10-08 04:41:25', '2024-10-08 05:41:25'),
('superadmin', 'fb4486cbea537742a62d6157951d2ec2', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Safari/537.36 OPR/113.0.0.0', '2024-10-06 21:35:36', '2024-10-06 22:35:36');

-- --------------------------------------------------------

--
-- Table structure for table `plain_pass`
--

CREATE TABLE `plain_pass` (
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='plaintext password';

-- --------------------------------------------------------

--
-- Structure for view `a`
--
DROP TABLE IF EXISTS `a`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `a`  AS SELECT `plain_pass`.`username` AS `username`, `plain_pass`.`password` AS `password` FROM `plain_pass` ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin1`
--
ALTER TABLE `admin1`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `approved_reservations`
--
ALTER TABLE `approved_reservations`
  ADD PRIMARY KEY (`reservation_id`);

--
-- Indexes for table `archived_files`
--
ALTER TABLE `archived_files`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `login_sessions`
--
ALTER TABLE `login_sessions`
  ADD PRIMARY KEY (`session_id`),
  ADD KEY `fk_userid_username` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_logs`
--
ALTER TABLE `activity_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=982;

--
-- AUTO_INCREMENT for table `approved_reservations`
--
ALTER TABLE `approved_reservations`
  MODIFY `reservation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `archived_files`
--
ALTER TABLE `archived_files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `login_sessions`
--
ALTER TABLE `login_sessions`
  ADD CONSTRAINT `fk_userid_username` FOREIGN KEY (`user_id`) REFERENCES `admin1` (`username`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
