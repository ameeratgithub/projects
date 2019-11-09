-- phpMyAdmin SQL Dump
-- version 5.1.0-dev
-- https://www.phpmyadmin.net/
--
-- Host: 192.168.30.23
-- Generation Time: Jul 26, 2019 at 02:23 PM
-- Server version: 8.0.3-rc-log
-- PHP Version: 7.2.19-1+0~20190531112637.22+stretch~1.gbp75765b

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hpc`
--

-- --------------------------------------------------------

--
-- Table structure for table `biltihistory`
--

CREATE TABLE `biltihistory` (
  `number` varchar(200) NOT NULL,
  `adda` varchar(100) NOT NULL,
  `invoiceid` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `companies`
--

CREATE TABLE `companies` (
  `id` tinyint(4) UNSIGNED NOT NULL,
  `name` varchar(45) NOT NULL,
  `abbreviation` varchar(20) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `companies`
--

INSERT INTO `companies` (`id`, `name`, `abbreviation`, `created_at`, `updated_at`) VALUES
(5, 'Lucky Plastic', 'LP', '2017-11-06 22:12:06', '2017-11-06 22:12:06'),
(6, 'Sreena', 'SR', '2017-11-06 22:12:22', '2017-11-06 22:12:22'),
(7, 'Amapha', 'AM', '2017-11-06 22:12:46', '2017-11-12 09:37:37'),
(8, 'Safdar Brother', 'SB', '2017-11-06 22:13:20', '2017-11-07 21:08:02'),
(9, 'Poineer', 'PR', '2017-11-07 20:15:22', '2017-11-07 20:15:22'),
(10, 'Crystal Light', 'CL', '2017-11-07 20:16:15', '2017-11-07 20:16:15'),
(11, 'Club', 'CLB', '2017-11-07 20:16:31', '2017-11-07 20:16:31'),
(12, 'TW', 'TW', '2017-11-07 21:23:36', '2017-11-07 21:23:36'),
(13, 'A-Pak', 'AP', '2017-11-07 21:24:14', '2017-11-07 21:24:14'),
(14, 'S-Pak', 'SP', '2017-11-07 21:24:40', '2017-11-07 21:24:40'),
(15, 'Local', 'Local', '2017-11-12 12:28:21', '2017-11-12 12:28:21');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `name` varchar(45) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `address` varchar(45) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `registeredby` smallint(6) NOT NULL,
  `updatedby` smallint(6) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `name`, `phone`, `address`, `created_at`, `updated_at`, `registeredby`, `updatedby`) VALUES
(13, 'Habib Plastic', '0303 4545210', 'Gujranwala', '2017-11-11 22:36:59', '2017-11-11 22:36:59', 2, NULL),
(12, 'Chodry Dairy', '0313 6400951', 'Gujranwala', '2017-11-11 14:02:04', '2017-11-12 13:44:37', 2, 2),
(14, 'Khuram Plastic', '0323 6442495', 'Gujranwala', '2017-11-11 22:39:43', '2017-11-11 22:39:43', 2, NULL),
(15, 'Madni Mobile', '0333 8227007', 'Gujranwala', '2017-11-11 22:42:56', '2017-11-12 13:44:54', 2, 2),
(16, 'Shafiq Shaheenabad', '0321 7444424', 'Gujranwala', '2017-11-11 22:45:50', '2017-11-11 22:45:50', 2, NULL),
(17, 'Ahmad Plastic Shaheenabad', '0335 1510000', 'Gujranwala', '2017-11-11 22:49:03', '2017-11-11 22:49:03', 2, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(10) UNSIGNED NOT NULL,
  `customerid` int(11) NOT NULL,
  `method` varchar(45) DEFAULT NULL,
  `resource` varchar(50) DEFAULT NULL,
  `paid` int(11) UNSIGNED DEFAULT '0',
  `purchased` int(11) UNSIGNED DEFAULT '0',
  `remained` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `customerid`, `method`, `resource`, `paid`, `purchased`, `remained`, `created_at`, `updated_at`) VALUES
(97, 13, NULL, NULL, 0, 64284, 212668, '2017-11-13 21:01:51', '2017-11-13 21:01:51'),
(94, 13, 'Credit', NULL, 0, 248384, 248384, '2017-11-12 12:31:54', '2017-11-12 12:31:54'),
(96, 13, 'cash', 'UBL', 100000, 0, 148384, '2017-11-12 22:20:52', '2017-11-12 22:20:52'),
(98, 13, NULL, NULL, 0, 74384, 222768, '2017-11-13 21:48:35', '2017-11-13 21:48:35');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `code` varchar(50) NOT NULL,
  `description` varchar(200) NOT NULL,
  `companyid` tinyint(4) UNSIGNED NOT NULL,
  `repositoryno` varchar(20) NOT NULL,
  `type` varchar(45) NOT NULL,
  `quantity` smallint(5) UNSIGNED DEFAULT NULL,
  `stock` smallint(5) UNSIGNED NOT NULL DEFAULT '0',
  `reorderrate` smallint(5) UNSIGNED NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`code`, `description`, `companyid`, `repositoryno`, `type`, `quantity`, `stock`, `reorderrate`, `created_at`, `updated_at`) VALUES
('LP-1', 'Tray', 5, 'G-3', 'pieces', 600, 489, 10, '2017-11-07 21:33:12', '2017-11-11 20:13:26'),
('LP-5', 'Pizza Box (S)', 5, 'G-3', 'pieces', 150, 491, 10, '2017-11-07 21:34:25', '2017-11-11 14:07:33'),
('LP-6', 'Pizza Box (L)', 5, 'G-3', 'pieces', 100, 488, 10, '2017-11-07 21:36:55', '2017-11-11 14:48:46'),
('LP-8', 'Tray', 5, 'G-3', 'pieces', 600, 500, 10, '2017-11-07 21:39:35', '2017-11-07 21:39:35'),
('LP-9', 'Biryani Box', 5, 'G-3', 'pieces', 200, 467, 100, '2017-11-07 21:40:48', '2017-11-13 21:48:35'),
('LP-10', 'Box', 5, 'G-3', 'pieces', 150, 500, 25, '2017-11-07 21:42:02', '2017-11-07 21:42:02'),
('LP-11', 'Box', 5, 'G-3', 'pieces', 200, 469, 125, '2017-11-07 21:42:58', '2017-11-13 21:48:35'),
('LP-12', 'Egg Packing (L)', 5, 'G-3', 'pieces', 100, 500, 15, '2017-11-07 21:44:38', '2017-11-08 22:21:50'),
('LP-14', 'Plat', 5, 'G-3', 'pieces', 300, 485, 100, '2017-11-07 21:46:01', '2017-11-13 21:48:35'),
('LP-15', 'Plat', 5, 'G-3', 'pieces', 300, 500, 50, '2017-11-07 21:46:56', '2017-11-07 21:46:56'),
('LP-16', 'Egg Packing (S)', 5, 'G-3', 'pieces', 300, 500, 20, '2017-11-07 21:48:09', '2017-11-08 22:22:59'),
('LP-17', 'Tray', 5, 'G-3', 'pieces', 100, 500, 5, '2017-11-07 21:50:20', '2017-11-07 21:50:20'),
('LP-18', 'Bowl', 5, 'G-3', 'pieces', 300, 500, 45, '2017-11-07 21:52:33', '2017-11-07 21:52:50'),
('LP-19', 'Large Box', 5, 'G-3', 'pieces', 100, 500, 40, '2017-11-07 21:53:49', '2017-11-07 21:53:49'),
('LP-20', 'Tray', 5, 'G-3', 'pieces', 100, 500, 5, '2017-11-07 21:55:29', '2017-11-07 21:55:29'),
('LP-22', 'Biryani Box', 5, 'G-3', 'pieces', 150, 500, 100, '2017-11-07 21:59:31', '2017-11-07 21:59:31'),
('LP-24', 'Biryani Box', 5, 'G-3', 'pieces', 150, 494, 60, '2017-11-07 22:00:20', '2017-11-11 20:13:26'),
('LP-26', 'Box', 5, 'G-3', 'pieces', 200, 483, 35, '2017-11-07 22:03:56', '2017-11-11 20:30:45'),
('LP-28', 'Plate (L)', 5, 'G-3', 'pieces', 400, 500, 10, '2017-11-07 22:08:21', '2017-11-08 22:23:34'),
('LP-29', 'Plat', 5, 'G-3', 'pieces', 300, 500, 35, '2017-11-07 22:09:00', '2017-11-07 22:09:00'),
('LP-30', 'Plat', 5, 'G-3', 'pieces', 400, 500, 20, '2017-11-07 22:10:08', '2017-11-07 22:10:08'),
('LP-31', 'Tray', 5, 'G-3', 'pieces', 100, 500, 5, '2017-11-08 19:52:59', '2017-11-08 19:52:59'),
('LP-32', 'Box', 5, 'G-3', 'pieces', 200, 500, 10, '2017-11-08 19:53:59', '2017-11-08 19:53:59'),
('LP-33', 'Box', 5, 'G-3', 'pieces', 200, 500, 10, '2017-11-08 19:55:43', '2017-11-08 19:55:43'),
('LP-34', 'Plat', 5, 'G-3', 'pieces', 300, 500, 30, '2017-11-08 19:56:35', '2017-11-08 19:56:35'),
('LP-35', 'Tray', 5, 'G-3', 'pieces', 100, 500, 20, '2017-11-08 19:57:39', '2017-11-08 19:57:39'),
('LP-36', 'Box', 5, 'G-3', 'pieces', 300, 500, 15, '2017-11-08 19:59:28', '2017-11-08 19:59:28'),
('LP-38', 'Bowl', 5, 'G-3', 'pieces', 200, 500, 50, '2017-11-08 20:00:24', '2017-11-08 20:00:24'),
('LP-42', 'Plat (S)', 5, 'G-3', 'pieces', 400, 500, 25, '2017-11-08 20:01:18', '2017-11-08 22:24:35'),
('LP-51', 'Descrep', 5, 'G-3', 'pieces', 100, 500, 20, '2017-11-08 22:14:01', '2017-11-08 22:14:01'),
('LP-52', 'Descrep', 5, 'G-3', 'pieces', 100, 500, 10, '2017-11-08 22:14:30', '2017-11-08 22:14:30'),
('LP-53', 'Descrep', 5, 'G-3', 'pieces', 200, 500, 10, '2017-11-08 22:15:18', '2017-11-08 22:15:18'),
('LP-54', 'Descrep', 5, 'G-3', 'pieces', 200, 500, 10, '2017-11-08 22:17:01', '2017-11-08 22:17:01'),
('LP-55', 'Descrep', 5, 'G-3', 'pieces', 100, 500, 10, '2017-11-08 22:17:35', '2017-11-08 22:17:35'),
('LP-56', 'Descrep', 5, 'G-3', 'pieces', 100, 500, 10, '2017-11-08 22:18:17', '2017-11-08 22:18:17'),
('LP-57', 'Descrep', 5, 'G-3', 'pieces', 100, 500, 10, '2017-11-08 22:18:42', '2017-11-08 22:18:42'),
('LP-58', 'Descrep', 5, 'G-3', 'pieces', 100, 500, 10, '2017-11-08 22:19:12', '2017-11-08 22:19:12'),
('LP-66', 'Tea Spoon', 5, 'G-3', 'pieces', 100, 500, 10, '2017-11-08 22:20:21', '2017-11-08 22:20:21'),
('LP-67', 'Sundae Spoon', 5, 'G-3', 'pieces', 200, 500, 30, '2017-11-08 22:26:45', '2017-11-08 22:26:45'),
('LP-68', 'Dessert Spoon', 5, 'G-3', 'pieces', 200, 500, 10, '2017-11-08 22:27:55', '2017-11-08 22:27:55'),
('LP-69', 'Coffee Spoon', 5, 'G-3', 'pieces', 300, 500, 50, '2017-11-08 22:28:58', '2017-11-08 22:28:58'),
('LP-70', 'Ice Cream Stick', 5, 'G-3', 'pieces', 300, 500, 30, '2017-11-08 22:29:36', '2017-11-08 22:29:36'),
('LP-71', 'Ice Cream Spoon', 5, 'G-3', 'pieces', 200, 500, 30, '2017-11-08 22:31:38', '2017-11-08 22:31:38'),
('LP-72', 'Table Spoon', 5, 'G-3', 'pieces', 300, 500, 30, '2017-11-08 22:32:16', '2017-11-08 22:32:16'),
('LP-73', 'Fork', 5, 'G-3', 'pieces', 200, 500, 10, '2017-11-08 22:33:13', '2017-11-08 22:33:13'),
('LP-74', 'Salad Fork', 5, 'G-3', 'pieces', 200, 500, 10, '2017-11-08 22:33:40', '2017-11-08 22:33:40'),
('LP-75', 'Spork', 5, 'G-3', 'pieces', 300, 500, 100, '2017-11-08 22:34:36', '2017-11-08 22:34:36'),
('SB-1(American Dairy)', 'Milk', 8, 'G-1', 'kg', 25, 490, 50, '2017-11-10 20:33:24', '2017-11-11 19:56:03'),
('SB-2(Farmer Choice)', 'Milk', 8, 'G-1', 'kg', 25, 500, 50, '2017-11-10 20:34:38', '2017-11-10 20:34:38'),
('SB-3(Milko)', 'Milk', 8, 'G-1', 'kg', 25, 495, 15, '2017-11-10 20:35:40', '2017-11-11 14:30:08'),
('SB-4(Uni Lack)', 'Milk', 8, 'G-1', 'kg', 25, 500, 25, '2017-11-10 20:36:27', '2017-11-10 20:36:27'),
('SB-5(Leader)', 'Milk', 8, 'G-1', 'kg', 25, 500, 5, '2017-11-10 20:39:35', '2017-11-10 20:39:35'),
('SB-6(Best Choice)', 'Milk', 8, 'G-1', 'kg', 25, 500, 15, '2017-11-10 20:41:59', '2017-11-10 20:41:59'),
('SB-7(Paras)', 'Pouch Milk (1) KG', 8, 'G-1', 'kg', 25, 500, 70, '2017-11-10 20:46:06', '2017-11-10 20:46:06'),
('SB-8(Cock Tail)', 'S-W 3KG', 8, 'G-1', 'pieces', 6, 500, 100, '2017-11-10 20:48:00', '2017-11-12 21:50:19'),
('SB-9(Cock Tail)', 'S-W 836 G', 8, 'G-1', 'pieces', 24, 500, 100, '2017-11-10 20:54:18', '2017-11-12 21:50:43'),
('SB-12(Pine Apple)', '565G Broken Slice(Fruitamin)', 8, 'G-1', 'pieces', 24, 500, 100, '2017-11-10 22:49:46', '2017-11-12 21:51:06'),
('SB-10(Pine Apple)', '3KG Slice (Fruitamin)', 8, 'G-1', 'kg', 6, 498, 100, '2017-11-10 20:57:04', '2017-11-12 21:53:01'),
('SB-11(Pine Apple) ', '565G Slice(Fruitamin)', 8, 'G-1', 'pieces', 24, 490, 100, '2017-11-10 21:15:50', '2017-11-12 22:11:14'),
('SB-13(Red Cherry)', '(10)KG Balti', 8, 'G-1', 'kg', 10, 498, 60, '2017-11-10 22:54:23', '2017-11-10 23:22:37'),
('A-Pak-1 (6-OZ)', 'Thrmopol Cup', 13, 'G-1', 'pieces', 1000, 500, 150, '2017-11-11 15:08:21', '2017-11-11 23:00:58'),
('A-Pak-2 (8-OZ)', 'Thrmopol Cup', 13, 'G-1', 'pieces', 1000, 500, 25, '2017-11-11 15:09:15', '2017-11-11 23:00:58'),
('A-Pak-3 (9-OZ)', 'Thrmopol Cup', 13, 'G-1', 'pieces', 1000, 500, 20, '2017-11-11 15:10:20', '2017-11-11 23:00:58'),
('LP-Medium Spoon', 'Medium Spoon', 5, 'G-3', 'pieces', 3000, 500, 70, '2017-11-11 15:26:49', '2017-11-11 22:47:50'),
('LP-Small Spoon', 'Small Spoon', 5, 'G-3', 'pieces', 9000, 500, 25, '2017-11-11 15:27:38', '2017-11-11 23:00:58'),
('LP-(6-OZ)', 'Thrmopol Cup', 5, 'G-3', 'pieces', 1000, 476, 100, '2017-11-11 15:29:03', '2017-11-13 21:48:35'),
('LP-(8-OZ)', 'Thrmopol Cup', 5, 'G-3', 'pieces', 1000, 500, 25, '2017-11-11 15:30:30', '2017-11-11 23:00:58'),
('LP-(12-OZ)', 'Thrmopol Cup', 5, 'G-3', 'pieces', 500, 500, 10, '2017-11-11 15:33:04', '2017-11-11 15:33:04'),
('LP-(16-OZ)', 'Thrmopol Cup', 5, 'G-3', 'pieces', 500, 500, 10, '2017-11-11 15:33:50', '2017-11-11 15:33:50'),
('LP-(22-OZ)', 'Plastic Cup', 5, 'G-3', 'pieces', 1000, 1000, 10, '2017-11-11 15:34:53', '2017-11-11 22:47:50'),
('LP-Dom-Lid', 'Dom lid', 5, 'G-3', 'pieces', 1000, 500, 10, '2017-11-11 15:36:16', '2017-11-11 15:36:16'),
('LP-(6-OZ) Crystal', 'Glass', 5, 'G-3', 'pieces', 1000, 500, 5, '2017-11-11 15:37:17', '2017-11-11 15:37:17'),
('LP-Fork', 'Fork', 5, 'G-3', 'pieces', 3000, 500, 5, '2017-11-11 15:38:49', '2017-11-11 15:38:49'),
('LP-Knife', 'Knife', 5, 'G-3', 'pieces', 3000, 500, 5, '2017-11-11 15:39:40', '2017-11-11 15:39:40'),
('TW-500ml', 'Container', 12, 'G-1', 'pieces', 250, 475, 50, '2017-11-11 15:47:55', '2017-11-13 21:48:35'),
('TW-750ml', 'Container', 12, 'G-1', 'pieces', 250, 485, 60, '2017-11-11 15:48:55', '2017-11-13 21:48:35'),
('TW-1000ml', 'Container', 12, 'G-1', 'pieces', 250, 496, 60, '2017-11-11 15:49:41', '2017-11-12 22:11:14'),
('TW-1500ml', 'Container', 12, 'G-1', 'pieces', 150, 500, 50, '2017-11-11 15:50:51', '2017-11-11 15:50:51'),
('TW-2000ml', 'Container', 12, 'G-1', 'pieces', 100, 500, 50, '2017-11-11 15:52:58', '2017-11-11 15:52:58'),
('SR-200ml Bowl', 'Raita Bowl', 6, 'G-1', 'pieces', 1000, 500, 40, '2017-11-11 16:20:38', '2017-11-11 16:20:38'),
('SR-200ml Lid W-C', 'Lid with cut', 6, 'G-1', 'pieces', 2000, 500, 30, '2017-11-11 16:22:01', '2017-11-11 16:22:01'),
('SR-200ml Lid', 'Lid Outcut', 6, 'G-1', 'pieces', 2000, 500, 50, '2017-11-11 16:22:48', '2017-11-11 16:22:48'),
('SR-(12-OZ) Ring', 'Ring', 6, 'G-1', 'pieces', 1000, 500, 50, '2017-11-11 16:23:51', '2017-11-11 16:23:51'),
('SR-(16-OZ) Ring', 'Ring', 6, 'G-1', 'pieces', 1000, 500, 40, '2017-11-11 16:24:32', '2017-11-11 16:24:32'),
('SR-230ml Glass', 'Glass', 6, 'G-1', 'pieces', 2000, 500, 50, '2017-11-11 16:25:28', '2017-11-11 16:25:28'),
('PR-200ml Bowl', 'Bowl', 9, 'G-1', 'pieces', 1000, 500, 50, '2017-11-11 16:28:25', '2017-11-11 16:28:25'),
('PR-Dabi (60G)', 'Dabi', 9, 'G-1', 'pieces', 2000, 500, 15, '2017-11-11 16:31:33', '2017-11-11 16:31:33'),
('PR-Dabi (80G)', 'Dabi', 9, 'G-1', 'pieces', 2000, 500, 40, '2017-11-11 16:32:08', '2017-11-11 16:32:08'),
('PR-Dabi (125G)', 'Dabi', 9, 'G-1', 'pieces', 2000, 500, 35, '2017-11-11 16:32:53', '2017-11-11 16:32:53'),
('PR-Glass-I', 'Glass-1', 9, 'G-1', 'pieces', 1400, 500, 40, '2017-11-11 16:34:20', '2017-11-11 16:34:20'),
('PR-400ml Bowl', 'Bowl', 9, 'G-1', 'pieces', 1000, 500, 30, '2017-11-11 16:35:51', '2017-11-11 16:35:51'),
('PR-500ml Bowl', 'Bowl', 9, 'G-1', 'pieces', 1000, 500, 25, '2017-11-11 16:36:28', '2017-11-11 16:36:28'),
('PR-250ml Bowl', 'Bowl', 9, 'G-1', 'pieces', 1000, 500, 5, '2017-11-11 16:37:34', '2017-11-11 16:37:34'),
('PR-74mm Lid', 'Lid', 9, 'G-1', 'pieces', 3500, 500, 10, '2017-11-11 16:53:48', '2017-11-11 16:53:48'),
('PR-95mm Lid', 'Lid', 9, 'G-1', 'pieces', 2000, 500, 20, '2017-11-11 16:55:29', '2017-11-11 16:55:29'),
('PR-117mm lid', 'Lid', 9, 'G-1', 'pieces', 1000, 500, 40, '2017-11-11 16:56:17', '2017-11-11 16:56:17'),
('Local-Shwarma Paper', 'Paper', 15, 'G-1', 'pieces', 1, 460, 50, '2017-11-12 13:00:39', '2017-11-13 21:48:35'),
('Local-(16-OZ) Paper Cup', 'Paper Cup', 15, 'G-1', 'pieces', 1000, 500, 40, '2017-11-12 13:02:42', '2017-11-12 13:41:42'),
('Local-(16-OZ) Paper Cup Lid', 'Lid', 15, 'G-1', 'pieces', 1000, 500, 50, '2017-11-12 13:03:12', '2017-11-12 13:41:42'),
('SR-(5-OZ) Crystal', 'Glass', 6, 'G-1', 'pieces', 5000, 500, 50, '2017-11-12 13:06:32', '2017-11-12 13:41:42'),
('SR-(5-OZ) Milky', 'Glass', 6, 'G-1', 'pieces', 5000, 500, 40, '2017-11-12 13:07:23', '2017-11-12 13:41:42'),
('SR-(6-OZ) Crystal', 'Glass', 6, 'G-1', 'pieces', 2000, 484, 100, '2017-11-12 13:09:16', '2017-11-13 21:48:35'),
('SR-(6-OZ) Milky', 'Glass', 6, 'G-1', 'pieces', 2000, 500, 40, '2017-11-12 13:10:07', '2017-11-12 13:41:42'),
('AM-8 200ml Bowl', 'Bowl', 7, 'G-1', 'pieces', 1500, 498, 30, '2017-11-12 13:14:45', '2017-11-13 21:01:51'),
('AM-10 200ml Bowl', 'Bowl', 7, 'G-1', 'pieces', 1500, 496, 30, '2017-11-12 13:16:06', '2017-11-13 21:48:35'),
('AM-40 200ml lid', 'Lid', 7, 'G-1', 'pieces', 1500, 497, 30, '2017-11-12 13:17:06', '2017-11-13 21:48:35'),
('AM-48 200ml Lid', 'Lid', 7, 'G-1', 'pieces', 3000, 497, 30, '2017-11-12 13:18:28', '2017-11-13 21:48:35'),
('SB-14 (Pine Apple)', '3Kg Broken Slice(Fruitamin)', 8, 'G-2', 'pieces', 6, 496, 50, '2017-11-12 21:57:25', '2017-11-12 22:11:14');

-- --------------------------------------------------------

--
-- Table structure for table `repositories`
--

CREATE TABLE `repositories` (
  `number` varchar(20) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `repositories`
--

INSERT INTO `repositories` (`number`, `created_at`, `updated_at`) VALUES
('G-1', NULL, NULL),
('G-2', NULL, NULL),
('G-3', NULL, NULL),
('G-4', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `saledetails`
--

CREATE TABLE `saledetails` (
  `id` int(10) UNSIGNED NOT NULL,
  `saleid` int(11) NOT NULL,
  `productcode` varchar(50) NOT NULL,
  `quantity` int(11) NOT NULL,
  `rate` int(11) NOT NULL,
  `total` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `saledetails`
--

INSERT INTO `saledetails` (`id`, `saleid`, `productcode`, `quantity`, `rate`, `total`) VALUES
(1, 1, 'LP-5', 5, 2, 1500),
(2, 1, 'LP-11', 5, 4, 3550),
(3, 2, 'LP-5', 2, 2, 600),
(4, 3, 'LP-5', 2, 3, 900),
(5, 4, 'SB-3(Milko)', 5, 6000, 30000),
(6, 5, 'LP-6', 12, 1, 1440),
(7, 6, 'SB-1(American Dairy)', 10, 8800, 88000),
(8, 7, 'LP-11', 5, 4, 3800),
(9, 7, 'LP-24', 6, 5, 4500),
(10, 7, 'LP-26', 6, 4, 4320),
(11, 7, 'LP-1', 6, 2, 6120),
(12, 7, 'LP-9', 8, 5, 7520),
(13, 8, 'LP-26', 6, 4, 4320),
(14, 9, 'LP-26', 5, 4, 4000),
(15, 10, 'LP-9', 5, 4, 4465),
(16, 10, 'LP-11', 5, 4, 3600),
(17, 10, 'LP-14', 5, 1, 2049),
(18, 10, 'TW-750ml', 5, 7, 9060),
(19, 10, 'TW-500ml', 5, 7, 8250),
(20, 10, 'AM-40 200ml lid', 1, 1, 1500),
(21, 10, 'LP-(6-OZ)', 8, 2, 12800),
(22, 10, 'AM-10 200ml Bowl', 2, 2, 4500),
(23, 10, 'AM-48 200ml Lid', 1, 1, 3000),
(24, 10, 'SR-(6-OZ) Crystal', 4, 1, 4560),
(25, 10, 'Local-Shwarma Paper', 10, 1030, 10300),
(26, 11, 'LP-11', 3, 4, 2280),
(27, 11, 'LP-9', 5, 4, 4465),
(28, 11, 'SR-(6-OZ) Crystal', 2, 1, 2200),
(29, 11, 'TW-500ml', 5, 7, 8125),
(30, 11, 'TW-1000ml', 2, 8, 3750),
(31, 11, 'SB-11(Pine Apple) ', 5, 130, 15600),
(32, 11, 'SB-14 (Pine Apple)', 2, 500, 6000),
(33, 12, 'LP-11', 3, 4, 2280),
(34, 12, 'LP-9', 5, 4, 4465),
(35, 12, 'SR-(6-OZ) Crystal', 2, 1, 2200),
(36, 12, 'TW-500ml', 5, 7, 8125),
(37, 12, 'TW-1000ml', 2, 8, 3750),
(38, 12, 'SB-11(Pine Apple) ', 5, 130, 15600),
(39, 12, 'SB-14 (Pine Apple)', 2, 500, 6000),
(40, 13, 'LP-9', 5, 4, 4465),
(41, 13, 'LP-11', 5, 4, 3600),
(42, 13, 'LP-14', 5, 1, 2049),
(43, 13, 'TW-750ml', 5, 7, 9060),
(44, 13, 'TW-500ml', 5, 7, 8250),
(45, 13, 'AM-40 200ml lid', 1, 1, 1500),
(46, 13, 'AM-8 200ml Bowl', 2, 2, 4500),
(47, 13, 'AM-48 200ml Lid', 1, 1, 3000),
(48, 13, 'Local-Shwarma Paper', 10, 1050, 10500),
(49, 13, 'LP-(6-OZ)', 8, 2, 12800),
(50, 13, 'SR-(6-OZ) Crystal', 4, 1, 4560),
(51, 14, 'LP-9', 5, 4, 4465),
(52, 14, 'LP-11', 5, 4, 3600),
(53, 14, 'LP-14', 5, 1, 2049),
(54, 14, 'TW-750ml', 5, 7, 9060),
(55, 14, 'Local-Shwarma Paper', 20, 1030, 20600),
(56, 14, 'TW-500ml', 5, 7, 8250),
(57, 14, 'AM-40 200ml lid', 1, 1, 1500),
(58, 14, 'LP-(6-OZ)', 8, 2, 12800),
(59, 14, 'AM-10 200ml Bowl', 2, 2, 4500),
(60, 14, 'AM-48 200ml Lid', 1, 1, 3000),
(61, 14, 'SR-(6-OZ) Crystal', 4, 1, 4560);

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `id` int(11) NOT NULL,
  `totalamount` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`id`, `totalamount`, `created_at`, `updated_at`) VALUES
(1, 3550, '2017-11-11 13:34:40', '2017-11-11 13:34:40'),
(2, 600, '2017-11-11 13:46:27', '2017-11-11 13:46:27'),
(3, 900, '2017-11-11 14:07:33', '2017-11-11 14:07:33'),
(4, 30000, '2017-11-11 14:30:08', '2017-11-11 14:30:08'),
(5, 1440, '2017-11-11 14:48:46', '2017-11-11 14:48:46'),
(6, 88000, '2017-11-11 19:56:03', '2017-11-11 19:56:03'),
(7, 26260, '2017-11-11 20:13:26', '2017-11-11 20:13:26'),
(8, 4320, '2017-11-11 20:19:59', '2017-11-11 20:19:59'),
(9, 4000, '2017-11-11 20:30:45', '2017-11-11 20:30:45'),
(10, 64084, '2017-11-12 14:36:54', '2017-11-12 14:36:54'),
(11, 42420, '2017-11-12 22:10:54', '2017-11-12 22:10:54'),
(12, 42420, '2017-11-12 22:11:14', '2017-11-12 22:11:14'),
(13, 64284, '2017-11-13 21:01:51', '2017-11-13 21:01:51'),
(14, 74384, '2017-11-13 21:48:35', '2017-11-13 21:48:35');

-- --------------------------------------------------------

--
-- Table structure for table `salesoncash`
--

CREATE TABLE `salesoncash` (
  `id` int(10) UNSIGNED NOT NULL,
  `salesid` int(11) NOT NULL,
  `customername` varchar(45) NOT NULL,
  `phone` varchar(15) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `salesoncash`
--

INSERT INTO `salesoncash` (`id`, `salesid`, `customername`, `phone`) VALUES
(1, 1, 'Umer Siddique', '0315 7733114'),
(2, 1, 'ZUBAIR', '0315 7733114'),
(3, 3, 'umer', '0315 7733114'),
(4, 5, 'Shan', '0323 5821598'),
(5, 6, 'new pak palastic jhang', '0321 8437042'),
(6, 7, 'USMAN', '0321 8437042'),
(7, 8, 'ADNAN', '0321 8437042'),
(8, 9, 'ADNAN', '0321 8437042'),
(9, 11, 'Farhan', '0321 8437042'),
(10, 12, 'umer', '0315 7733114');

-- --------------------------------------------------------

--
-- Table structure for table `salesoncredit`
--

CREATE TABLE `salesoncredit` (
  `id` int(10) UNSIGNED NOT NULL,
  `invoiceid` int(11) NOT NULL,
  `customerid` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `salesoncredit`
--

INSERT INTO `salesoncredit` (`id`, `invoiceid`, `customerid`) VALUES
(1, 2, 11),
(2, 4, 12),
(3, 10, 13),
(4, 13, 13),
(5, 14, 13);

-- --------------------------------------------------------

--
-- Table structure for table `self`
--

CREATE TABLE `self` (
  `id` tinyint(4) NOT NULL,
  `name` varchar(200) NOT NULL,
  `ptclno` varchar(15) NOT NULL,
  `mobileno` varchar(15) NOT NULL,
  `address` varchar(40) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `self`
--

INSERT INTO `self` (`id`, `name`, `ptclno`, `mobileno`, `address`) VALUES
(1, 'Hafiz Plastic Centre', '000 00000000', '0000 0000000', 'new Address');

-- --------------------------------------------------------

--
-- Table structure for table `stockin`
--

CREATE TABLE `stockin` (
  `id` int(11) NOT NULL,
  `date` varchar(100) NOT NULL,
  `vehicleno` varchar(45) NOT NULL,
  `gatepass` varchar(45) NOT NULL,
  `drivername` varchar(45) NOT NULL,
  `closed` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `stockin`
--

INSERT INTO `stockin` (`id`, `date`, `vehicleno`, `gatepass`, `drivername`, `closed`, `created_at`, `updated_at`) VALUES
(10, '11 November, 2017', '2634', '555', 'adnan', 1, '2017-11-11 20:40:01', '2017-11-11 22:47:50'),
(11, '11 November, 2017', 'LEE-4525', '90908712', 'Numan', 1, '2017-11-11 22:49:14', '2017-11-11 23:00:58'),
(12, '1 November, 2017', 'LEE-4525', '90908712-9', 'Umer', 1, '2017-11-12 09:40:42', '2017-11-12 09:42:16'),
(13, '3 November, 2017', 'LEE-4525', '90908712-9o', 'Umer', 1, '2017-11-12 13:01:13', '2017-11-12 13:41:42'),
(14, '2 November, 2017', 'LeE-4', '456', 'ooeme', 1, '2017-11-12 21:58:19', '2017-11-12 21:58:56');

-- --------------------------------------------------------

--
-- Table structure for table `stockindetails`
--

CREATE TABLE `stockindetails` (
  `id` int(10) UNSIGNED NOT NULL,
  `stockinid` int(11) NOT NULL,
  `productcode` varchar(50) NOT NULL,
  `quantity` mediumint(8) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `stockindetails`
--

INSERT INTO `stockindetails` (`id`, `stockinid`, `productcode`, `quantity`) VALUES
(3, 10, 'LP-Medium Spoon', 500),
(10, 11, 'A-Pak-1 (6-OZ)', 500),
(5, 10, 'LP-(22-OZ)', 1000),
(13, 11, 'LP-Small Spoon', 500),
(12, 11, 'A-Pak-3 (9-OZ)', 500),
(11, 11, 'A-Pak-2 (8-OZ)', 500),
(14, 11, 'LP-(6-OZ)', 500),
(16, 11, 'LP-(8-OZ)', 500),
(17, 12, 'AM-200ml Bowl', 500),
(18, 12, 'AM-200ml Lid', 500),
(19, 13, 'Local-Shwarma Paper', 500),
(20, 13, 'Local-(16-OZ) Paper Cup', 500),
(21, 13, 'Local-(16-OZ) Paper Cup Lid', 500),
(22, 13, 'SR-(5-OZ) Crystal', 500),
(23, 13, 'SR-(5-OZ) Milky', 500),
(24, 13, 'SR-(6-OZ) Crystal', 500),
(25, 13, 'SR-(6-OZ) Milky', 500),
(26, 13, 'AM-8 200ml Bowl', 500),
(27, 13, 'AM-10 200ml Bowl', 500),
(28, 13, 'AM-40 200ml lid', 500),
(29, 13, 'AM-48 200ml Lid', 500),
(30, 14, 'SB-14 (Pine Apple)', 500);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` smallint(6) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(45) NOT NULL,
  `password` varchar(100) NOT NULL,
  `role` varchar(45) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `address` varchar(200) DEFAULT NULL,
  `lastlogin` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `registeredby` smallint(6) DEFAULT NULL,
  `remember_token` varchar(200) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `phone`, `address`, `lastlogin`, `created_at`, `updated_at`, `registeredby`, `remember_token`) VALUES
(2, 'Ameer Hamza', '13014198-023@uog.edu.pk', '$2y$12$YvaJLw.XxU2LqAQZWnvqVeSMXfIA60OPT2CsrL/YjhDSdpsFjJkAa', 'admin', '0123 2132332', 'Sohdra Mor', '2017-11-10 23:07:52', '2017-10-08 15:08:59', '2017-11-10 23:07:52', NULL, 'HDqlkBVkAJIJm17xOwYWMB7sQH87OyiOJUdnlvZtz8kbxMvHP4FBYzDXV3Hv'),
(8, 'Frhan', 'admin@hpc.com', '$2y$12$/AlRb6XGnUCrtlPEwfUQK.tUZ81HsDxKIPvdO3xXqugcf.fnixW4W', 'admin', '0321 0000000', 'Gujranwala', '2017-11-12 22:32:33', '2017-11-06 14:48:10', '2017-11-12 22:34:11', NULL, 'DosGaSCJ3qCvgaylLLCsF65xkwjrCrEA94PT6XOxl0UrFse2aUbnJuJafWRL'),
(9, 'Frhan', 'cashier@hpc.com', '$2y$12$sHuHjMHAA2lGE6Lz9mk0dO4stSBjoKHg243ioCFTMRP7RWnoduD6C', 'cashier', '0321 0000001', 'Gujranwala', '2017-11-14 13:16:41', '2017-11-06 14:49:05', '2017-11-14 13:16:41', NULL, 'ugvZHL14WPeq91zBWfZyJcCj1bxNJSvDfUokGOhxDxJU6emA2a9q2vlzg6ms');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `biltihistory`
--
ALTER TABLE `biltihistory`
  ADD PRIMARY KEY (`number`),
  ADD KEY `fk_invoiceid_biltihistory_idx` (`invoiceid`);

--
-- Indexes for table `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `abbreviation` (`abbreviation`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `phone_UNIQUE` (`phone`),
  ADD KEY `fk_registeredby_customers_idx` (`registeredby`),
  ADD KEY `fk_updatedby_customers_idx` (`updatedby`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_customerid_payments_idx` (`customerid`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`code`),
  ADD KEY `fk_companyid_products_idx` (`companyid`),
  ADD KEY `fk_repositoryno_products_idx` (`repositoryno`);

--
-- Indexes for table `repositories`
--
ALTER TABLE `repositories`
  ADD PRIMARY KEY (`number`);

--
-- Indexes for table `saledetails`
--
ALTER TABLE `saledetails`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_saleid_saledetails_idx` (`saleid`),
  ADD KEY `fk_productcode_saledetails_idx` (`productcode`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `salesoncash`
--
ALTER TABLE `salesoncash`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_salesid_salesoncash_idx` (`salesid`);

--
-- Indexes for table `salesoncredit`
--
ALTER TABLE `salesoncredit`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_invoiceid_salesoncredit_idx` (`invoiceid`),
  ADD KEY `fk_customerid_salesoncredit_idx` (`customerid`);

--
-- Indexes for table `self`
--
ALTER TABLE `self`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stockin`
--
ALTER TABLE `stockin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stockindetails`
--
ALTER TABLE `stockindetails`
  ADD PRIMARY KEY (`stockinid`,`productcode`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `fk_productcode_stockindetails_idx` (`productcode`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `phone` (`phone`),
  ADD KEY `fk_registeredby_users_idx` (`registeredby`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `companies`
--
ALTER TABLE `companies`
  MODIFY `id` tinyint(4) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=99;

--
-- AUTO_INCREMENT for table `saledetails`
--
ALTER TABLE `saledetails`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `salesoncash`
--
ALTER TABLE `salesoncash`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `salesoncredit`
--
ALTER TABLE `salesoncredit`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `self`
--
ALTER TABLE `self`
  MODIFY `id` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `stockin`
--
ALTER TABLE `stockin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `stockindetails`
--
ALTER TABLE `stockindetails`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

