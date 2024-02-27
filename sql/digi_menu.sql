-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Feb 27, 2024 at 05:20 PM
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
-- Database: `digi_menu`
--

-- --------------------------------------------------------

--
-- Table structure for table `about_section`
--

CREATE TABLE `about_section` (
  `sno` int(11) NOT NULL,
  `image` text DEFAULT NULL,
  `description` text DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `about_section`
--

INSERT INTO `about_section` (`sno`, `image`, `description`, `status`, `created_at`) VALUES
(1, 'about.jpg', 'We Will Spend Good Food and satisfying food......', 1, '2024-02-24 06:56:31');

-- --------------------------------------------------------

--
-- Table structure for table `address`
--

CREATE TABLE `address` (
  `sno` int(11) NOT NULL,
  `address` varchar(1000) DEFAULT NULL,
  `footer_menu_counts` int(11) NOT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `address`
--

INSERT INTO `address` (`sno`, `address`, `footer_menu_counts`, `status`, `created_at`) VALUES
(1, 'A108 Adam Street,.New York,.NY 535022-US', 1, 1, '2024-02-24 09:19:47'),
(2, 'A108 Adam Street,.New York,.NY 535022-US', 2, 1, '2024-02-24 09:19:47');

-- --------------------------------------------------------

--
-- Table structure for table `contact_us`
--

CREATE TABLE `contact_us` (
  `sno` int(11) NOT NULL,
  `mobile` bigint(11) DEFAULT NULL,
  `email` varchar(1000) DEFAULT NULL,
  `footer_menu_counts` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_us`
--

INSERT INTO `contact_us` (`sno`, `mobile`, `email`, `footer_menu_counts`, `status`, `created_at`) VALUES
(1, 6381945168, 'rickmathews2@gmail.com', 3, 1, '2024-02-24 11:13:42'),
(2, 6381945160, 'ibots.robin@gmail.com', 4, 1, '2024-02-24 11:13:42');

-- --------------------------------------------------------

--
-- Table structure for table `follow_us`
--

CREATE TABLE `follow_us` (
  `sno` int(11) NOT NULL,
  `platform` text DEFAULT NULL,
  `href` text DEFAULT NULL,
  `icon` text DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `follow_us`
--

INSERT INTO `follow_us` (`sno`, `platform`, `href`, `icon`, `status`, `created_at`) VALUES
(1, 'twitter', '#', 'bi bi-twitter', 1, '2024-02-24 12:10:57'),
(2, 'facebook', '#', 'bi bi-facebook', 1, '2024-02-24 12:10:57'),
(3, 'instagram', '#', 'bi bi-instagram', 1, '2024-02-24 12:10:57');

-- --------------------------------------------------------

--
-- Table structure for table `footer_access_control`
--

CREATE TABLE `footer_access_control` (
  `sno` int(11) NOT NULL,
  `footer_menu` text DEFAULT NULL,
  `icon` text DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `footer_access_control`
--

INSERT INTO `footer_access_control` (`sno`, `footer_menu`, `icon`, `status`, `created_at`) VALUES
(1, 'Address', 'bi bi-geo-alt icon', 1, '2024-02-24 08:48:24'),
(2, 'Contact Us', 'bi bi-telephone icon', 1, '2024-02-24 08:48:24'),
(3, 'Opening Hours', 'bi bi-clock icon', 1, '2024-02-24 08:48:24'),
(4, 'Follow Us', NULL, 1, '2024-02-24 08:48:24');

-- --------------------------------------------------------

--
-- Table structure for table `footer_menu_counts`
--

CREATE TABLE `footer_menu_counts` (
  `sno` int(11) NOT NULL,
  `name` text DEFAULT NULL,
  `footer_access_control` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `footer_menu_counts`
--

INSERT INTO `footer_menu_counts` (`sno`, `name`, `footer_access_control`, `status`, `created_at`) VALUES
(1, 'mannarpuram address', 1, 1, '2024-02-24 08:55:38'),
(2, 'palakarai address', 1, 1, '2024-02-24 08:55:38'),
(3, 'robin number', 2, 1, '2024-02-24 08:55:38'),
(4, 'robins number', 2, 1, '2024-02-24 08:55:38');

-- --------------------------------------------------------

--
-- Table structure for table `header_menu`
--

CREATE TABLE `header_menu` (
  `sno` int(11) NOT NULL,
  `href` text DEFAULT NULL,
  `menu_name` text DEFAULT NULL,
  `status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `header_menu`
--

INSERT INTO `header_menu` (`sno`, `href`, `menu_name`, `status`) VALUES
(1, '#about', 'About', 1),
(2, '#menu', 'Menu', 1),
(3, 'contact.php', 'Contact', 0);

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

CREATE TABLE `menus` (
  `sno` int(11) NOT NULL,
  `dish_name` text DEFAULT NULL,
  `dish_description` text DEFAULT NULL,
  `dish_image` text DEFAULT NULL,
  `dish_category` int(11) DEFAULT NULL,
  `dish_price` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`sno`, `dish_name`, `dish_description`, `dish_image`, `dish_category`, `dish_price`, `status`, `created_at`) VALUES
(1, 'Soup2', 'Milagu,Chilly Powder', 'menu-item-1.png', 1, 100, 1, '2024-02-23 10:52:40'),
(2, 'Soup1', 'Milagu,Chilly Powder', 'menu-item-1.png', 2, 200, 1, '2024-02-23 10:52:40'),
(3, 'Soup1', 'Milagu,Chilly Powder', 'menu-item-1.png', 3, 200, 1, '2024-02-23 10:52:40'),
(4, 'Soup1', 'Milagu,Chilly Powder', 'menu-item-1.png', 4, 200, 1, '2024-02-23 10:52:40'),
(5, 'Soup3', 'Milagu,Chilly Powder', 'menu-item-1.png', 1, 200, 1, '2024-02-23 10:52:40');

-- --------------------------------------------------------

--
-- Table structure for table `menu_headings`
--

CREATE TABLE `menu_headings` (
  `sno` int(11) NOT NULL,
  `menu_name` text DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `menu_headings`
--

INSERT INTO `menu_headings` (`sno`, `menu_name`, `status`, `created_at`) VALUES
(1, 'Starters', 1, '2024-02-24 06:55:32'),
(2, 'BreakFast', 1, '2024-02-24 06:55:32'),
(3, 'Lunch', 1, '2024-02-24 06:55:32'),
(4, 'Dinner', 1, '2024-02-24 06:55:32'),
(5, 'BreakFasts', 0, '2024-02-24 06:55:32');

-- --------------------------------------------------------

--
-- Table structure for table `openeing_hours`
--

CREATE TABLE `openeing_hours` (
  `sno` int(11) NOT NULL,
  `day` text DEFAULT NULL,
  `start_time` text DEFAULT NULL,
  `end_time` text DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `openeing_hours`
--

INSERT INTO `openeing_hours` (`sno`, `day`, `start_time`, `end_time`, `status`, `created_at`) VALUES
(1, 'Monday', '10AM', '11PM', 1, '2024-02-24 11:59:10'),
(2, 'Tuesday', '10AM', '11PM', 1, '2024-02-24 11:59:10'),
(3, 'Wednesday', '10AM', '11PM', 1, '2024-02-24 11:59:10'),
(4, 'Thursday', '10AM', '11PM', 1, '2024-02-24 11:59:10'),
(5, 'Friday', '10AM', '11PM', 1, '2024-02-24 11:59:10'),
(6, 'Saturday', '10AM', '11PM', 1, '2024-02-24 11:59:10'),
(7, 'Sunday', '10AM', '11PM', 1, '2024-02-24 11:59:10');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `about_section`
--
ALTER TABLE `about_section`
  ADD PRIMARY KEY (`sno`);

--
-- Indexes for table `address`
--
ALTER TABLE `address`
  ADD PRIMARY KEY (`sno`),
  ADD KEY `dish_cargory_dime4` (`footer_menu_counts`);

--
-- Indexes for table `contact_us`
--
ALTER TABLE `contact_us`
  ADD PRIMARY KEY (`sno`),
  ADD KEY `dish_cargory_dime5` (`footer_menu_counts`);

--
-- Indexes for table `follow_us`
--
ALTER TABLE `follow_us`
  ADD PRIMARY KEY (`sno`);

--
-- Indexes for table `footer_access_control`
--
ALTER TABLE `footer_access_control`
  ADD PRIMARY KEY (`sno`);

--
-- Indexes for table `footer_menu_counts`
--
ALTER TABLE `footer_menu_counts`
  ADD PRIMARY KEY (`sno`),
  ADD KEY `dish_cargory_dime3` (`footer_access_control`);

--
-- Indexes for table `header_menu`
--
ALTER TABLE `header_menu`
  ADD PRIMARY KEY (`sno`);

--
-- Indexes for table `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`sno`),
  ADD KEY `dish_cargory_dime1` (`dish_category`);

--
-- Indexes for table `menu_headings`
--
ALTER TABLE `menu_headings`
  ADD PRIMARY KEY (`sno`);

--
-- Indexes for table `openeing_hours`
--
ALTER TABLE `openeing_hours`
  ADD PRIMARY KEY (`sno`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `about_section`
--
ALTER TABLE `about_section`
  MODIFY `sno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `address`
--
ALTER TABLE `address`
  MODIFY `sno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `contact_us`
--
ALTER TABLE `contact_us`
  MODIFY `sno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `follow_us`
--
ALTER TABLE `follow_us`
  MODIFY `sno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `footer_access_control`
--
ALTER TABLE `footer_access_control`
  MODIFY `sno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `footer_menu_counts`
--
ALTER TABLE `footer_menu_counts`
  MODIFY `sno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `header_menu`
--
ALTER TABLE `header_menu`
  MODIFY `sno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `menus`
--
ALTER TABLE `menus`
  MODIFY `sno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `menu_headings`
--
ALTER TABLE `menu_headings`
  MODIFY `sno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `openeing_hours`
--
ALTER TABLE `openeing_hours`
  MODIFY `sno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `address`
--
ALTER TABLE `address`
  ADD CONSTRAINT `dish_cargory_dime4` FOREIGN KEY (`footer_menu_counts`) REFERENCES `footer_menu_counts` (`sno`);

--
-- Constraints for table `contact_us`
--
ALTER TABLE `contact_us`
  ADD CONSTRAINT `dish_cargory_dime5` FOREIGN KEY (`footer_menu_counts`) REFERENCES `footer_menu_counts` (`sno`);

--
-- Constraints for table `footer_menu_counts`
--
ALTER TABLE `footer_menu_counts`
  ADD CONSTRAINT `dish_cargory_dime3` FOREIGN KEY (`footer_access_control`) REFERENCES `footer_access_control` (`sno`);

--
-- Constraints for table `menus`
--
ALTER TABLE `menus`
  ADD CONSTRAINT `dish_cargory_dime1` FOREIGN KEY (`dish_category`) REFERENCES `menu_headings` (`sno`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
