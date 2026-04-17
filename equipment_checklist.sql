-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Apr 17, 2026 at 05:02 PM
-- Server version: 8.4.7
-- PHP Version: 8.2.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `equipment_checklist`
--

-- --------------------------------------------------------

--
-- Table structure for table `checklist_questions`
--

DROP TABLE IF EXISTS `checklist_questions`;
CREATE TABLE IF NOT EXISTS `checklist_questions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `question` text NOT NULL,
  `equipment_id` int DEFAULT NULL,
  `is_mandatory` tinyint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=65 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `checklist_questions`
--

INSERT INTO `checklist_questions` (`id`, `question`, `equipment_id`, `is_mandatory`, `created_at`) VALUES
(56, 'Check Fuel Level', 1, 1, '2026-04-15 08:23:10'),
(57, 'Check battery Voltage', 1, 1, '2026-04-15 08:31:54'),
(58, 'Check distilled Water Level', 1, 1, '2026-04-15 08:32:00'),
(59, 'Check oil Level in Generator', 1, 1, '2026-04-15 08:32:04'),
(60, 'Check All Electrical Connection', 1, 1, '2026-04-15 08:32:07'),
(61, 'Check radiator Water Level', 1, 1, '2026-04-15 08:32:09'),
(62, 'Check the AMF panel', 1, 1, '2026-04-15 08:32:12'),
(63, 'Check the DG Syncronisations', 1, 1, '2026-04-15 08:32:14'),
(64, 'Test Run for the DG (A check for DG)', 1, 1, '2026-04-15 08:32:16');

-- --------------------------------------------------------

--
-- Table structure for table `equipment`
--

DROP TABLE IF EXISTS `equipment`;
CREATE TABLE IF NOT EXISTS `equipment` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `description` text,
  `location` varchar(150) DEFAULT NULL,
  `qr_code` varchar(255) DEFAULT NULL,
  `type` varchar(100) DEFAULT NULL,
  `status` varchar(50) DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `equipment`
--

INSERT INTO `equipment` (`id`, `name`, `description`, `location`, `qr_code`, `type`, `status`, `created_at`) VALUES
(1, 'DG Generator', 'B2 Diesel Generator', 'B2', 'EMCLDIE108', 'Electrical', 'active', '2026-04-15 08:20:16');

-- --------------------------------------------------------

--
-- Table structure for table `inspections`
--

DROP TABLE IF EXISTS `inspections`;
CREATE TABLE IF NOT EXISTS `inspections` (
  `id` int NOT NULL AUTO_INCREMENT,
  `equipment_id` int DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `status` varchar(50) DEFAULT 'in_progress',
  `started_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `completed_at` timestamp NULL DEFAULT NULL,
  `sync_status` varchar(50) DEFAULT 'synced',
  PRIMARY KEY (`id`),
  KEY `equipment_id` (`equipment_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=136056 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `inspections`
--

INSERT INTO `inspections` (`id`, `equipment_id`, `user_id`, `status`, `started_at`, `completed_at`, `sync_status`) VALUES
(249, 1, 1, 'completed', '2026-04-17 03:18:07', '2026-04-17 03:18:07', 'synced'),
(136055, 1, 1, 'completed', '2026-04-17 07:08:07', '2026-04-17 07:08:07', 'synced');

-- --------------------------------------------------------

--
-- Table structure for table `inspection_responses`
--

DROP TABLE IF EXISTS `inspection_responses`;
CREATE TABLE IF NOT EXISTS `inspection_responses` (
  `id` int NOT NULL AUTO_INCREMENT,
  `inspection_id` int DEFAULT NULL,
  `question_id` int DEFAULT NULL,
  `response` enum('comply','not_comply') NOT NULL,
  `remark` text,
  `image_url` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `inspection_id` (`inspection_id`),
  KEY `question_id` (`question_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2264060 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `inspection_responses`
--

INSERT INTO `inspection_responses` (`id`, `inspection_id`, `question_id`, `response`, `remark`, `image_url`, `created_at`) VALUES
(1, 249, 56, 'comply', '', '', '2026-04-17 03:18:07'),
(2, 249, 57, 'comply', '', '', '2026-04-17 03:18:07'),
(45027, 249, 58, 'comply', '', '', '2026-04-17 03:18:07'),
(88, 249, 59, 'comply', '', '', '2026-04-17 03:18:07'),
(440, 249, 60, 'comply', '', '', '2026-04-17 03:18:07'),
(2264054, 136055, 56, 'comply', '', '', '2026-04-17 07:08:07'),
(2264055, 136055, 57, '', '', '', '2026-04-17 07:08:07'),
(2264056, 136055, 58, 'comply', '', '', '2026-04-17 07:08:07'),
(43908, 136055, 59, '', '', '', '2026-04-17 07:08:07'),
(2264057, 136055, 60, 'comply', '', '', '2026-04-17 07:08:07'),
(2264058, 136055, 61, '', '', '', '2026-04-17 07:08:07'),
(6435, 136055, 62, 'comply', '', '', '2026-04-17 07:08:07'),
(2264059, 136055, 63, '', '', '', '2026-04-17 07:08:07'),
(3, 136055, 64, 'comply', '', '', '2026-04-17 07:08:07');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `username` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(50) DEFAULT 'inspector',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`username`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `password`, `role`, `created_at`) VALUES
(1, 'John', 'admin', '$2y$10$nwHh1mSmAFnQ9GD3H/JYz.Hm4ciwKBfIjIfRppTuHYSNbkZ7LYJEu', 'admin', '2026-04-15 12:42:02');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
