-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Apr 17, 2026 at 06:53 PM
-- Server version: 9.1.0
-- PHP Version: 8.3.14

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
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `equipment_id` int UNSIGNED NOT NULL,
  `question` text NOT NULL,
  `is_mandatory` tinyint(1) NOT NULL DEFAULT '1',
  `type` varchar(50) NOT NULL DEFAULT 'boolean',
  `order_index` int NOT NULL DEFAULT '0',
  `category` varchar(100) DEFAULT NULL,
  `help_text` text,
  `remark_required_on_non_comply` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_questions_equipment` (`equipment_id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `checklist_questions`
--

INSERT INTO `checklist_questions` (`id`, `equipment_id`, `question`, `is_mandatory`, `type`, `order_index`, `category`, `help_text`, `remark_required_on_non_comply`, `created_at`) VALUES
(1, 1, 'Is battery voltage within normal range?', 1, 'boolean', 1, 'Electrical', 'Check battery voltage using multimeter (should be ~12V/24V)', 1, '2026-04-17 23:25:40'),
(2, 1, 'Is control panel functioning properly?', 1, 'boolean', 2, 'Electrical', 'Verify display, indicators, and buttons', 1, '2026-04-17 23:25:40'),
(3, 1, 'Is fuel level sufficient for operation?', 1, 'boolean', 3, 'Fuel System', 'Check fuel tank level visually or via gauge', 1, '2026-04-17 23:25:40'),
(4, 1, 'Any fuel leakage observed?', 1, 'boolean', 4, 'Fuel System', 'Inspect fuel lines and tank for leakage', 1, '2026-04-17 23:25:40'),
(5, 1, 'Is coolant level adequate?', 1, 'boolean', 5, 'Cooling System', 'Check radiator coolant level', 1, '2026-04-17 23:25:40'),
(6, 1, 'Radiator fan working properly?', 1, 'boolean', 6, 'Cooling System', 'Ensure fan rotates without noise or obstruction', 1, '2026-04-17 23:25:40'),
(7, 1, 'Any abnormal noise or vibration?', 1, 'boolean', 7, 'Mechanical', 'Run generator and observe sound/vibration', 1, '2026-04-17 23:25:40'),
(8, 1, 'Engine oil level within limit?', 1, 'boolean', 8, 'Mechanical', 'Check dipstick for oil level', 1, '2026-04-17 23:25:40'),
(9, 1, 'Is output voltage stable?', 1, 'boolean', 9, 'Output', 'Measure output voltage using meter', 1, '2026-04-17 23:25:40'),
(10, 1, 'Is generator taking load properly?', 1, 'boolean', 10, 'Output', 'Apply load and check performance', 1, '2026-04-17 23:25:40'),
(11, 2, 'Check fuel level is adequate', 1, 'boolean', 1, 'Fuel System', 'Ensure fuel tank is at least 50% full', 1, '2026-04-18 00:20:45'),
(12, 2, 'Inspect engine oil level', 1, 'boolean', 2, 'Engine', 'Use dipstick to verify oil level is within limits', 1, '2026-04-18 00:20:45'),
(13, 2, 'Check coolant level in radiator', 1, 'boolean', 3, 'Cooling System', 'Coolant should be between min and max marks', 1, '2026-04-18 00:20:45'),
(14, 2, 'Inspect battery voltage', 1, 'numeric', 4, 'Electrical', 'Expected voltage: 12V/24V depending on system', 1, '2026-04-18 00:20:45'),
(15, 2, 'Check for any oil leakage', 1, 'boolean', 5, 'Engine', 'Look around engine base and joints', 1, '2026-04-18 00:20:45'),
(16, 2, 'Verify control panel indicators', 1, 'boolean', 6, 'Control Panel', 'All lights and indicators should be working', 0, '2026-04-18 00:20:45'),
(17, 2, 'Check air filter condition', 0, 'boolean', 7, 'Air Intake', 'Ensure filter is clean and not clogged', 0, '2026-04-18 00:20:45'),
(18, 2, 'Measure output voltage', 1, 'numeric', 8, 'Electrical', 'Expected output: 220V-240V', 1, '2026-04-18 00:20:45'),
(19, 2, 'Check abnormal noise or vibration', 1, 'boolean', 9, 'General', 'Listen for unusual sounds during operation', 1, '2026-04-18 00:20:45'),
(20, 2, 'Ensure exhaust system is clear', 0, 'boolean', 10, 'Exhaust', 'No blockage or excessive smoke', 0, '2026-04-18 00:20:45');

-- --------------------------------------------------------

--
-- Table structure for table `equipment`
--

DROP TABLE IF EXISTS `equipment`;
CREATE TABLE IF NOT EXISTS `equipment` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `qr_code` varchar(255) NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'active',
  `model` varchar(150) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `manufacturer` varchar(150) DEFAULT NULL,
  `last_maintenance_date` date DEFAULT NULL,
  `next_maintenance_date` date DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `qr_code` (`qr_code`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `equipment`
--

INSERT INTO `equipment` (`id`, `name`, `qr_code`, `status`, `model`, `location`, `manufacturer`, `last_maintenance_date`, `next_maintenance_date`, `created_at`) VALUES
(1, 'Diesel Generator', 'QR-DG-B2-001', 'active', 'DG-750kVA', 'Block B2', 'Cummins', '2026-04-01', '2026-05-01', '2026-04-17 23:24:24'),
(2, 'Diesel Generator', 'QR-DG-B2-002', 'active', 'DG-500kVA', 'Block B2', 'Kirloskar', '2026-04-05', '2026-05-05', '2026-04-17 23:24:24'),
(3, 'Diesel Generator', 'QR-DG-B2-003', 'inactive', 'DG-250kVA', 'Block B2', 'Mahindra Powerol', '2026-03-20', '2026-04-20', '2026-04-17 23:24:24');

-- --------------------------------------------------------

--
-- Table structure for table `inspections`
--

DROP TABLE IF EXISTS `inspections`;
CREATE TABLE IF NOT EXISTS `inspections` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `equipment_id` int UNSIGNED NOT NULL,
  `user_id` int UNSIGNED NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'in_progress',
  `started_at` datetime DEFAULT NULL,
  `completed_at` datetime DEFAULT NULL,
  `sync_status` varchar(50) NOT NULL DEFAULT 'synced',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_inspections_equipment` (`equipment_id`),
  KEY `idx_inspections_user` (`user_id`),
  KEY `idx_inspections_completed` (`completed_at`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `inspections`
--

INSERT INTO `inspections` (`id`, `equipment_id`, `user_id`, `status`, `started_at`, `completed_at`, `sync_status`, `created_at`) VALUES
(1, 1, 1, 'completed', '2026-04-17 17:56:22', '2026-04-17 17:56:22', 'synced', '2026-04-17 23:26:22'),
(2, 2, 1, 'completed', '2026-04-17 18:51:51', '2026-04-17 18:51:51', 'synced', '2026-04-18 00:21:51'),
(3, 2, 1, 'completed', '2026-04-17 18:51:59', '2026-04-17 18:51:59', 'synced', '2026-04-18 00:21:59');

-- --------------------------------------------------------

--
-- Table structure for table `inspection_responses`
--

DROP TABLE IF EXISTS `inspection_responses`;
CREATE TABLE IF NOT EXISTS `inspection_responses` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `inspection_id` int UNSIGNED NOT NULL,
  `question_id` int UNSIGNED NOT NULL,
  `response` varchar(50) NOT NULL,
  `remark` text,
  `image_url` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_responses_inspection` (`inspection_id`),
  KEY `idx_responses_question` (`question_id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `inspection_responses`
--

INSERT INTO `inspection_responses` (`id`, `inspection_id`, `question_id`, `response`, `remark`, `image_url`, `created_at`) VALUES
(1, 1, 1, 'comply', '', '', '2026-04-17 17:56:22'),
(2, 1, 2, 'non-comply', '', '', '2026-04-17 17:56:22'),
(3, 1, 3, 'comply', '', '', '2026-04-17 17:56:22'),
(4, 1, 4, 'non-comply', '', '', '2026-04-17 17:56:22'),
(5, 1, 5, 'comply', '', '', '2026-04-17 17:56:22'),
(6, 1, 6, 'non-comply', '', '', '2026-04-17 17:56:22'),
(7, 1, 7, 'comply', '', '', '2026-04-17 17:56:22'),
(8, 1, 8, 'non-comply', '', '', '2026-04-17 17:56:22'),
(9, 1, 9, 'comply', '', '', '2026-04-17 17:56:22'),
(10, 1, 10, 'non-comply', '', '', '2026-04-17 17:56:22'),
(11, 2, 11, 'comply', '', '', '2026-04-17 18:51:51'),
(12, 2, 12, 'non-comply', '', '', '2026-04-17 18:51:51'),
(13, 2, 13, 'comply', '', '', '2026-04-17 18:51:51'),
(14, 2, 14, 'comply', '', '', '2026-04-17 18:51:51'),
(15, 2, 15, 'comply', '', '', '2026-04-17 18:51:51'),
(16, 2, 16, 'comply', '', '', '2026-04-17 18:51:51'),
(17, 2, 17, 'comply', '', '', '2026-04-17 18:51:51'),
(18, 2, 18, 'comply', '', '', '2026-04-17 18:51:51'),
(19, 2, 19, 'comply', '', '', '2026-04-17 18:51:51'),
(20, 2, 20, 'comply', '', '', '2026-04-17 18:51:51'),
(21, 3, 11, 'comply', '', '', '2026-04-17 18:51:59'),
(22, 3, 12, 'non-comply', '', '', '2026-04-17 18:51:59'),
(23, 3, 13, 'comply', '', '', '2026-04-17 18:51:59'),
(24, 3, 14, 'comply', '', '', '2026-04-17 18:51:59'),
(25, 3, 15, 'comply', '', '', '2026-04-17 18:51:59'),
(26, 3, 16, 'comply', '', '', '2026-04-17 18:51:59'),
(27, 3, 17, 'comply', '', '', '2026-04-17 18:51:59'),
(28, 3, 18, 'comply', '', '', '2026-04-17 18:51:59'),
(29, 3, 19, 'comply', '', '', '2026-04-17 18:51:59'),
(30, 3, 20, 'comply', '', '', '2026-04-17 18:51:59');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `username` varchar(150) NOT NULL,
  `email` varchar(150) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(50) NOT NULL DEFAULT 'admin',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `email`, `password`, `role`, `created_at`) VALUES
(1, 'Admin', 'admin', 'admin@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', '2026-04-17 23:09:13');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `checklist_questions`
--
ALTER TABLE `checklist_questions`
  ADD CONSTRAINT `fk_questions_equipment` FOREIGN KEY (`equipment_id`) REFERENCES `equipment` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `inspections`
--
ALTER TABLE `inspections`
  ADD CONSTRAINT `fk_inspections_equipment` FOREIGN KEY (`equipment_id`) REFERENCES `equipment` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_inspections_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT;

--
-- Constraints for table `inspection_responses`
--
ALTER TABLE `inspection_responses`
  ADD CONSTRAINT `fk_responses_inspection` FOREIGN KEY (`inspection_id`) REFERENCES `inspections` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_responses_question` FOREIGN KEY (`question_id`) REFERENCES `checklist_questions` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
