-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 13, 2024 at 09:36 AM
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
-- Database: `callospa_resort_database`
--

-- --------------------------------------------------------

--
-- Table structure for table `amenities`
--

CREATE TABLE `amenities` (
  `id` int(11) NOT NULL,
  `amenities_categories` varchar(255) NOT NULL,
  `amenities_categories_image_url` varchar(255) DEFAULT NULL,
  `amenities_categories_description` text DEFAULT NULL,
  `amenities_subcategory_name` varchar(255) NOT NULL,
  `amenities_subcategory_image_url` varchar(255) DEFAULT NULL,
  `amenities_subcategory_description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `duration` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `amenities`
--

INSERT INTO `amenities` (`id`, `amenities_categories`, `amenities_categories_image_url`, `amenities_categories_description`, `amenities_subcategory_name`, `amenities_subcategory_image_url`, `amenities_subcategory_description`, `price`, `duration`) VALUES
(1, 'Massage Therapies', 'images/1.jpg', 'Soothe your muscles and relax your mind with our specialized massage therapies.', 'Total Body Pampering', 'images/1.jpg, images/1.jpg, images/1.jpg, images/1.jpg', 'Experience the ultimate relaxation with a full-body massage that targets every muscle.', 2500.00, '1 hour'),
(2, 'Massage Therapies', 'images/1.jpg', 'Soothe your muscles and relax your mind with our specialized massage therapies.', 'Signature Massage', 'images/1.jpg, images/1.jpg, images/1.jpg, images/1.jpg', 'Our unique Signature Massage is tailored to your body\'s needs, ensuring total comfort and relief.', 500.00, '1 hour'),
(3, 'Massage Therapies', 'images/1.jpg', 'Soothe your muscles and relax your mind with our specialized massage therapies.', 'Signature Massage Child', 'images/1.jpg, images/1.jpg, images/1.jpg, images/1.jpg', 'A gentle massage for children, designed to relax and rejuvenate young muscles.', 300.00, '30 mins'),
(4, 'Massage Therapies', 'images/1.jpg', 'Soothe your muscles and relax your mind with our specialized massage therapies.', 'Ventosa Massage', 'images/1.jpg, images/1.jpg, images/1.jpg, images/1.jpg', 'A therapeutic massage using glass cups to create suction, relieving muscle tension.', 1000.00, '1 hour'),
(5, 'Massage Therapies', 'images/1.jpg', 'Soothe your muscles and relax your mind with our specialized massage therapies.', 'Stone Massage', 'images/1.jpg, images/1.jpg, images/1.jpg, images/1.jpg', 'Relax with the heat and pressure of smooth, warm stones to ease tension in your muscles.', 1500.00, '1 hour'),
(6, 'Massage Therapies', 'images/1.jpg', 'Soothe your muscles and relax your mind with our specialized massage therapies.', 'Mandara Twins', 'images/1.jpg, images/1.jpg, images/1.jpg, images/1.jpg', 'A luxurious dual therapist massage, providing simultaneous relaxation for twice the comfort.', 1500.00, '1.5 hours'),
(7, 'Body Treatments', 'images/1.jpg', 'Rejuvenate your skin and senses with our luxurious body treatments.', 'Body Scrub', 'images/1.jpg, images/1.jpg, images/1.jpg, images/1.jpg', 'Revitalize your skin with an exfoliating body scrub that leaves you feeling refreshed and glowing.', 650.00, '1 hour'),
(8, 'Body Treatments', 'images/1.jpg', 'Rejuvenate your skin and senses with our luxurious body treatments.', 'Ear Candling', 'images/1.jpg, images/1.jpg, images/1.jpg, images/1.jpg', 'A calming ear cleaning therapy that helps remove impurities and relax the mind.', 350.00, '1 hour'),
(9, 'Foot Treatment', 'images/1.jpg', 'Pamper your feet with our soothing foot treatments.', 'Malaysian Foot Reflex', 'images/1.jpg, images/1.jpg, images/1.jpg, images/1.jpg', 'A traditional Malaysian reflexology treatment to alleviate foot pain and improve circulation.', 300.00, '30-45 mins'),
(10, 'Foot Treatment', 'images/1.jpg', 'Pamper your feet with our soothing foot treatments.', 'Foot Reflex', 'images/1.jpg, images/1.jpg, images/1.jpg, images/1.jpg', 'A therapeutic foot massage that focuses on pressure points to relieve tension and stress.', 500.00, '1 hour'),
(11, 'Foot Treatment', 'images/1.jpg', 'Pamper your feet with our soothing foot treatments.', 'Foot Spa', 'images/1.jpg, images/1.jpg, images/1.jpg, images/1.jpg', 'Enjoy a relaxing foot spa session that soothes tired feet and softens the skin.', 430.00, '1 hour'),
(12, 'Hair Treatments', 'images/1.jpg', 'Transform your hair with our restorative hair treatments.', 'Hair Spa', 'images/1.jpg, images/1.jpg, images/1.jpg, images/1.jpg', 'A deep conditioning treatment to nourish and revitalize dry, damaged hair.', 350.00, '1 hour'),
(13, 'Nail Services', 'images/1.jpg', 'Treat yourself to our professional nail services.', 'Manicure', 'images/1.jpg, images/1.jpg, images/1.jpg, images/1.jpg', 'Get perfectly polished nails with our luxurious manicure service.', 350.00, '1 hour'),
(14, 'Nail Services', 'images/1.jpg', 'Treat yourself to our professional nail services.', 'Pedicure', 'images/1.jpg, images/1.jpg, images/1.jpg, images/1.jpg', 'Pamper your feet with a soothing pedicure, leaving your nails polished and beautiful.', 400.00, '1 hour'),
(15, 'Nail Services', 'images/1.jpg', 'Treat yourself to our professional nail services.', 'Mani + Pedi', 'images/1.jpg, images/1.jpg, images/1.jpg, images/1.jpg', 'The ultimate nail treatment combo, providing a full manicure and pedicure experience.', 650.00, '1 hour'),
(16, 'Special Packages', 'images/1.jpg', 'Explore our exclusive special packages designed for comprehensive relaxation.', 'Affordable Escape', 'images/1.jpg, images/1.jpg, images/1.jpg, images/1.jpg', 'A perfect getaway at an affordable price, combining multiple relaxing treatments.', 1200.00, '1 hour'),
(17, 'Special Packages', 'images/1.jpg', 'Explore our exclusive special packages designed for comprehensive relaxation.', 'Kiddie Package', 'images/1.jpg, images/1.jpg, images/1.jpg, images/1.jpg', 'A delightful package designed for children, offering a safe and fun relaxation experience.', 750.00, '1 hour');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `venue` varchar(255) DEFAULT NULL,
  `event_type` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `inclusions` text DEFAULT NULL,
  `guests` int(11) DEFAULT NULL,
  `event_images` text DEFAULT NULL,
  `check_in_time` time DEFAULT NULL,
  `check_out_time` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `venue`, `event_type`, `price`, `description`, `inclusions`, `guests`, `event_images`, `check_in_time`, `check_out_time`) VALUES
(1, 'Exclusive Resort Venue', 'Day Resort Grounds Exclusive', 15000.00, 'Treat yourself and your friends to a relaxing day at our beautiful resort. Enjoy exclusive access for endless swimming and lounging perfect for creating unforgettable memories together.', 'Exclusive access to resort facilities, unlimited swimming, lounging space', 40, 'images/1.jpg, images/1.jpg, images/1.jpg, images/1.jpg', '08:00:00', '16:00:00'),
(2, 'Exclusive Resort Venue', 'Night Resort Grounds Exclusive', 15000.00, 'Escape to a magical night at our resort! Swim and lounge under the stars, setting the stage for laughter and bonding with your loved ones.', 'Exclusive access to resort facilities, unlimited swimming, lounging space', 40, 'images/1.jpg, images/1.jpg, images/1.jpg, images/1.jpg', '17:00:00', '07:00:00'),
(3, 'Reception Hall Venue', '1 Day with Reception Hall', 47200.00, 'Host an unforgettable event in our exclusive reception hall. Enjoy a seamless experience with the perfect setting for your special occasion.', 'Access to reception hall and swimming pool, setup and teardown time', 250, 'images/1.jpg, images/1.jpg, images/1.jpg, images/1.jpg', '08:00:00', '16:00:00'),
(4, 'Reception Hall Venue', '24-Hour with Reception Hall', 73000.00, 'Make your celebration truly memorable with a full day in our reception hall. It\'s the ideal backdrop for your special moments.', 'Access to reception hall, swimming pool, room options, complimentary spa pampering', 250, 'images/1.jpg, images/1.jpg, images/1.jpg, images/1.jpg', '08:00:00', '08:00:00'),
(5, 'Conference Room Venue', '1 Day with Conference Room', 47200.00, 'Bring your ideas to life in our dedicated conference room. Enjoy a productive day in a space designed for collaboration and creativity.', 'Access to conference room and swimming pool, setup and teardown time', 75, 'images/1.jpg, images/1.jpg, images/1.jpg, images/1.jpg', '08:00:00', '16:00:00'),
(6, 'Conference Room Venue', '24-Hour with Conference Room', 73000.00, 'Transform your next event with a full day in our conference room. It\'s the perfect place to host meetings or gatherings with a touch of luxury.', 'Access to conference room, swimming pool, room options, complimentary spa pampering', 75, 'images/1.jpg, images/1.jpg, images/1.jpg, images/1.jpg', '08:00:00', '08:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `packages`
--

CREATE TABLE `packages` (
  `id` int(11) NOT NULL,
  `package_name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `check_in_time` time NOT NULL,
  `check_out_time` time NOT NULL,
  `duration` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `inclusions` text NOT NULL,
  `guests` int(11) NOT NULL,
  `images` text NOT NULL,
  `room_ids` text DEFAULT NULL,
  `spa_subcategories` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `packages`
--

INSERT INTO `packages` (`id`, `package_name`, `price`, `check_in_time`, `check_out_time`, `duration`, `description`, `inclusions`, `guests`, `images`, `room_ids`, `spa_subcategories`) VALUES
(1, 'Package Test', 10000.00, '00:00:00', '00:00:00', '10', 'Test Package', '', 2, '', '1', 'Signature Massage Child'),
(2, 'Test', 1200.00, '00:00:00', '00:00:00', '23', 'Test', '', 2, '', '1', 'Ear Candling'),
(3, 'Test', 1200.00, '00:00:00', '00:00:00', '23', 'Test', '', 2, '', '1', 'Ear Candling'),
(4, 'Test', 10000.00, '00:00:00', '00:00:00', '10', 'Test', '', 2, '', '3', '');

-- --------------------------------------------------------

--
-- Table structure for table `pending_amenity_reservations`
--

CREATE TABLE `pending_amenity_reservations` (
  `reservation_id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `middle_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) NOT NULL,
  `contact_number` varchar(50) DEFAULT NULL,
  `email` varchar(50) NOT NULL,
  `handle` varchar(100) DEFAULT NULL,
  `sources` set('Facebook','Word of Mouth','Returning Customer','Google','Others') DEFAULT NULL,
  `source_other` varchar(255) DEFAULT NULL,
  `package_category` varchar(50) NOT NULL,
  `package` varchar(50) NOT NULL,
  `check_in_date` date NOT NULL,
  `check_in_time` time NOT NULL,
  `check_out_time` time NOT NULL,
  `guests` int(11) DEFAULT NULL,
  `total_cost` decimal(10,2) NOT NULL,
  `deposit_amount` decimal(10,2) NOT NULL,
  `remaining_balance` decimal(10,2) NOT NULL,
  `payment_method` enum('BDO') NOT NULL,
  `proof_of_payment` varchar(50) NOT NULL,
  `reservation_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pending_amenity_reservations`
--

INSERT INTO `pending_amenity_reservations` (`reservation_id`, `first_name`, `middle_name`, `last_name`, `contact_number`, `email`, `handle`, `sources`, `source_other`, `package_category`, `package`, `check_in_date`, `check_in_time`, `check_out_time`, `guests`, `total_cost`, `deposit_amount`, `remaining_balance`, `payment_method`, `proof_of_payment`, `reservation_date`) VALUES
(28, 'Charmaine', '', 'Cator', '912345678', 'charmaine.l.d.cator@gmail.com', '', 'Word of Mouth', '', '', 'Total Body Pampering', '2024-10-12', '08:00:00', '09:00:00', 3, 0.00, 0.00, 0.00, 'BDO', '1728349960324.jpg', '2024-10-10 01:54:24');

-- --------------------------------------------------------

--
-- Table structure for table `pending_event_reservations`
--

CREATE TABLE `pending_event_reservations` (
  `reservation_id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `middle_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) NOT NULL,
  `contact_number` varchar(255) DEFAULT NULL,
  `email` varchar(50) NOT NULL,
  `handle` varchar(100) DEFAULT NULL,
  `sources` set('Facebook','Word of Mouth','Returning Customer','Google','Others') DEFAULT NULL,
  `source_other` varchar(255) DEFAULT NULL,
  `package_category` varchar(50) NOT NULL,
  `package` varchar(50) NOT NULL,
  `event_type` varchar(50) NOT NULL,
  `check_in_date` date NOT NULL,
  `check_out_date` date NOT NULL,
  `check_in_time` time NOT NULL,
  `check_out_time` time NOT NULL,
  `guests` int(11) NOT NULL,
  `additional_guest` int(11) DEFAULT 0,
  `catering_preference` varchar(50) NOT NULL,
  `total_cost` decimal(10,2) NOT NULL,
  `deposit_amount` decimal(10,2) NOT NULL,
  `remaining_balance` decimal(10,2) NOT NULL,
  `payment_method` enum('BDO') NOT NULL,
  `proof_of_payment` varchar(50) NOT NULL,
  `reservation_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pending_package_reservations`
--

CREATE TABLE `pending_package_reservations` (
  `reservation_id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `middle_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) NOT NULL,
  `contact_number` int(15) NOT NULL,
  `email` varchar(100) NOT NULL,
  `handle` varchar(100) DEFAULT NULL,
  `sources` set('Facebook','Word of Mouth','Returning Customer','Google','Others') DEFAULT NULL,
  `source_other` varchar(255) DEFAULT NULL,
  `package` varchar(100) NOT NULL,
  `check_in_date` date NOT NULL,
  `check_out_date` date NOT NULL,
  `check_in_time` time DEFAULT NULL,
  `check_out_time` time DEFAULT NULL,
  `guests` int(11) NOT NULL,
  `additional_guest` int(11) DEFAULT NULL,
  `total_cost` decimal(10,2) NOT NULL,
  `deposit_amount` decimal(10,2) NOT NULL,
  `remaining_balance` decimal(10,2) NOT NULL,
  `payment_method` enum('BDO') NOT NULL,
  `proof_of_payment` varchar(255) NOT NULL,
  `reservation_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pending_room_reservations`
--

CREATE TABLE `pending_room_reservations` (
  `reservation_id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `middle_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) NOT NULL,
  `contact_number` int(15) DEFAULT NULL,
  `email` varchar(50) NOT NULL,
  `handle` varchar(100) DEFAULT NULL,
  `sources` set('Facebook','Word of Mouth','Returning Customer','Google','Others') DEFAULT NULL,
  `source_other` varchar(255) DEFAULT NULL,
  `room` varchar(50) NOT NULL,
  `check_in_date` date NOT NULL,
  `check_out_date` date NOT NULL,
  `check_in_time` time DEFAULT NULL,
  `check_out_time` time DEFAULT NULL,
  `guests` int(11) NOT NULL,
  `additional_guest` int(11) DEFAULT NULL,
  `total_cost` decimal(10,2) NOT NULL,
  `deposit_amount` decimal(10,2) NOT NULL,
  `remaining_balance` decimal(10,2) DEFAULT NULL,
  `payment_method` enum('BDO') NOT NULL,
  `proof_of_payment` varchar(50) NOT NULL,
  `reservation_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `id` int(11) NOT NULL,
  `room_name` varchar(255) DEFAULT NULL,
  `subcategory_rooms` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `inclusions` text DEFAULT NULL,
  `guests` int(11) DEFAULT NULL,
  `room-images` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`id`, `room_name`, `subcategory_rooms`, `price`, `description`, `inclusions`, `guests`, `room-images`) VALUES
(1, 'Couple\'s Suite 1', 'asd', 12312.00, 'Breakfast for two, complimentary wine', '2', 12, 'images/1.jpg'),
(2, 'Blue Room', NULL, 4200.00, 'A serene blue room with a calming ambiance.', 'Free parking, daily housekeeping', 6, 'images/1.jpg, images/1.jpg, images/1.jpg, images/1.jpg'),
(3, 'Beige Room', NULL, 3300.00, 'A neutral beige room with a relaxing feel.', 'Complimentary snacks, free Wi-Fi', 2, 'images/1.jpg, images/1.jpg, images/1.jpg, images/1.jpg'),
(4, 'Family Room', NULL, 7000.00, 'A spacious room ideal for families.', 'Kids eat free, late check-out', 10, 'images/1.jpg, images/1.jpg, images/1.jpg, images/1.jpg'),
(5, 'Tatami Room', NULL, 9000.00, 'A traditional room with tatami mats for a unique experience.', 'Traditional tea set, guided tour', 20, 'images/1.jpg, images/1.jpg, images/1.jpg, images/1.jpg'),
(6, 'Couple\'s Suite', 'Yellow Room', 3800.00, 'A bright yellow room with cheerful vibes.', 'Breakfast for two, complimentary wine', 2, 'images/1.jpg, images/1.jpg, images/1.jpg, images/1.jpg'),
(7, 'Couple\'s Suite', 'Coffee Brown Room', 4500.00, 'A warm coffee brown room with a cozy atmosphere.', 'Complimentary chocolate, room upgrade', 2, 'images/1.jpg, images/1.jpg, images/1.jpg, images/1.jpg'),
(8, 'Couple\'s Suite', 'Santorini White Room', 4500.00, 'A pristine white room inspired by Santorini\'s elegance.', 'Spa discount, welcome drink', 2, 'images/1.jpg, images/1.jpg, images/1.jpg, images/1.jpg'),
(9, 'Couple\'s Suite', 'Red Room', 4500.00, 'A vibrant red room with a bold design.', 'Romantic dinner for two, late check-out', 2, 'images/1.jpg, images/1.jpg, images/1.jpg, images/1.jpg'),
(10, 'Couple\'s Suite', 'Green Room', 4500.00, 'A refreshing green room with a calming feel.', 'Daily breakfast, guided nature walk', 2, 'images/1.jpg, images/1.jpg, images/1.jpg, images/1.jpg'),
(11, 'Couple\'s Suite', 'Peach Room', 5000.00, 'A soft peach room with a relaxing ambiance.', 'Complimentary dessert, early check-in', 3, 'images/1.jpg, images/1.jpg, images/1.jpg, images/1.jpg'),
(12, 'Test Room', 'Test', 3000.00, 'Test Room', '0', 2, '670b1f7ac1ccb_1728782202.jpg, 670b1f7ac203e_1728782202.jpeg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `amenities`
--
ALTER TABLE `amenities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `packages`
--
ALTER TABLE `packages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pending_amenity_reservations`
--
ALTER TABLE `pending_amenity_reservations`
  ADD PRIMARY KEY (`reservation_id`);

--
-- Indexes for table `pending_event_reservations`
--
ALTER TABLE `pending_event_reservations`
  ADD PRIMARY KEY (`reservation_id`);

--
-- Indexes for table `pending_package_reservations`
--
ALTER TABLE `pending_package_reservations`
  ADD PRIMARY KEY (`reservation_id`);

--
-- Indexes for table `pending_room_reservations`
--
ALTER TABLE `pending_room_reservations`
  ADD PRIMARY KEY (`reservation_id`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `amenities`
--
ALTER TABLE `amenities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `packages`
--
ALTER TABLE `packages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `pending_amenity_reservations`
--
ALTER TABLE `pending_amenity_reservations`
  MODIFY `reservation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `pending_event_reservations`
--
ALTER TABLE `pending_event_reservations`
  MODIFY `reservation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `pending_package_reservations`
--
ALTER TABLE `pending_package_reservations`
  MODIFY `reservation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `pending_room_reservations`
--
ALTER TABLE `pending_room_reservations`
  MODIFY `reservation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
