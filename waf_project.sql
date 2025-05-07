-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 01, 2025 at 09:01 PM
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
-- Database: `waf_project`
--

-- --------------------------------------------------------

--
-- Table structure for table `ai_model`
--

CREATE TABLE `ai_model` (
  `model_id` int(11) NOT NULL,
  `model_type` varchar(50) NOT NULL,
  `model_path` varchar(255) NOT NULL,
  `training_data` text DEFAULT NULL,
  `accuracy` decimal(5,2) DEFAULT 0.00,
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `blogs`
--

CREATE TABLE `blogs` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `blog_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `comment_text` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE `logs` (
  `log_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `activity` varchar(255) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `log_time` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `logs`
--

INSERT INTO `logs` (`log_id`, `user_id`, `activity`, `ip_address`, `log_time`) VALUES
(30, 5, 'User logged in', '::1', '2025-04-16 15:38:15'),
(31, 5, 'Updated profile information', '::1', '2025-04-16 15:38:38'),
(32, 5, 'User logged in', '::1', '2025-04-16 15:39:06'),
(33, 5, 'Updated user ID 4 profile', '::1', '2025-04-16 15:40:28'),
(34, 5, 'User logged in', '::1', '2025-04-17 12:27:10'),
(35, 5, 'Updated profile information', '::1', '2025-04-17 12:27:59'),
(36, 5, 'User logged in', '::1', '2025-04-17 13:41:19'),
(37, 5, 'User logged in', '::1', '2025-04-17 13:51:30'),
(38, 5, 'Updated user ID 5 profile', '::1', '2025-04-17 13:54:55'),
(39, 5, 'Updated user ID 5 profile', '::1', '2025-04-17 13:55:32'),
(40, 11, 'User logged in', '::1', '2025-04-17 15:04:48'),
(41, 5, 'User logged in', '::1', '2025-04-17 15:16:41'),
(42, 6, 'User logged in', '::1', '2025-04-26 17:32:26'),
(43, 6, 'Updated profile information', '::1', '2025-04-26 18:35:26'),
(44, 6, 'Updated profile information', '::1', '2025-04-26 18:38:25'),
(45, 5, 'User logged in', '::1', '2025-04-26 22:43:53'),
(46, 5, 'Updated profile information', '::1', '2025-04-26 22:44:17'),
(47, 5, 'User logged in', '::1', '2025-04-26 22:45:11'),
(48, 5, 'Blocked user with ID 5', '::1', '2025-04-26 22:46:54'),
(49, 5, 'Blocked user with ID 5', '::1', '2025-04-26 22:47:11'),
(50, 5, 'Blocked user with ID 6', '::1', '2025-04-26 22:47:21'),
(51, 6, 'User logged in', '::1', '2025-04-26 22:48:05'),
(52, 5, 'User logged in', '::1', '2025-04-26 22:56:20'),
(53, 5, 'Unblocked user with ID 5', '::1', '2025-04-26 22:57:26'),
(54, 5, 'Unblocked user with ID 6', '::1', '2025-04-26 22:57:32'),
(55, 8, 'User logged in', '::1', '2025-04-26 23:15:37'),
(56, 5, 'User logged in', '::1', '2025-04-29 22:20:28'),
(57, 5, 'User logged in', '::1', '2025-04-29 22:24:18'),
(58, 12, 'User logged in', '::1', '2025-04-29 22:25:41'),
(59, 12, 'Updated profile information', '::1', '2025-04-29 22:26:19'),
(60, 5, 'User logged in', '::1', '2025-04-29 22:29:34'),
(61, 5, 'Blocked user with ID 7', '::1', '2025-04-29 23:27:01'),
(62, 5, 'Unblocked user with ID 7', '::1', '2025-04-29 23:27:19'),
(63, 5, 'Blocked user with ID 8', '::1', '2025-04-29 23:27:28'),
(64, 13, 'User logged in', '::1', '2025-04-29 23:36:45'),
(65, 13, 'Updated profile information', '::1', '2025-04-29 23:52:34'),
(66, 13, 'User logged in', '::1', '2025-04-30 00:04:28'),
(67, 5, 'User logged in', '::1', '2025-04-30 00:05:23'),
(68, 13, 'User logged in', '::1', '2025-04-30 00:14:47'),
(69, 7, 'User logged in', '::1', '2025-05-01 04:11:48'),
(70, 7, 'Updated profile information', '::1', '2025-05-01 04:14:59'),
(71, 7, 'Updated profile information', '::1', '2025-05-01 04:15:14'),
(72, 7, 'Updated profile information', '::1', '2025-05-01 04:17:04'),
(73, 7, 'Updated profile information', '::1', '2025-05-01 04:17:10'),
(74, 7, 'Updated profile information', '::1', '2025-05-01 04:19:44'),
(75, 7, 'Updated profile information', '::1', '2025-05-01 04:23:01'),
(76, 7, 'Updated profile information', '::1', '2025-05-01 04:23:59');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `notification_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `type` enum('alert','info','warning') NOT NULL,
  `content` text NOT NULL,
  `timestamp` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `setting_id` int(11) NOT NULL,
  `config_key` varchar(100) NOT NULL,
  `config_value` varchar(255) NOT NULL,
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `Age` int(11) NOT NULL,
  `role` enum('admin','soc','doc','user') NOT NULL DEFAULT 'user',
  `status` enum('active','blocked') NOT NULL DEFAULT 'active',
  `last_login` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `Age`, `role`, `status`, `last_login`) VALUES
(5, 'lo', 'admin@g.c', '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4', 23, 'admin', 'active', '2025-04-26 22:57:26'),
(6, 'jcdasjndfa', 'A@G.C', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', 15, 'user', 'active', '2025-04-26 22:57:32'),
(7, 'w', 'w@g.c', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', 23, 'user', 'active', '2025-05-01 04:19:44'),
(8, 'esed', 'we@g.c', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', 123, 'user', 'blocked', '2025-04-29 23:27:28'),
(9, 'qwed', 'as@g.c', 'b1556dea32e9d0cdbfed038fd7787275775ea40939c146a64e205bcb349ad02f', 1332, 'user', 'active', '2025-04-17 13:50:57'),
(10, 'Zeyad', 'zeyad@g.c', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', 23, 'user', 'active', '2025-04-17 15:04:19'),
(11, 'user', 'user@g.c', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', 23, 'user', 'active', '2025-04-17 15:04:40'),
(12, 'loai', 'l@g.c', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', 24, 'soc', 'active', '2025-04-29 22:26:19'),
(13, 'kimo', 'k@g.c', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', 24, 'user', 'active', '2025-04-29 23:52:34');

-- --------------------------------------------------------

--
-- Table structure for table `waf_rules`
--

CREATE TABLE `waf_rules` (
  `rule_id` int(11) NOT NULL,
  `rule_name` varchar(100) NOT NULL,
  `pattern` text NOT NULL,
  `action` enum('block','allow','log') NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ai_model`
--
ALTER TABLE `ai_model`
  ADD PRIMARY KEY (`model_id`);

--
-- Indexes for table `blogs`
--
ALTER TABLE `blogs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `blog_id` (`blog_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`log_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`notification_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`setting_id`),
  ADD UNIQUE KEY `config_key` (`config_key`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `waf_rules`
--
ALTER TABLE `waf_rules`
  ADD PRIMARY KEY (`rule_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ai_model`
--
ALTER TABLE `ai_model`
  MODIFY `model_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `blogs`
--
ALTER TABLE `blogs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `notification_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `setting_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `waf_rules`
--
ALTER TABLE `waf_rules`
  MODIFY `rule_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`blog_id`) REFERENCES `blogs` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `logs`
--
ALTER TABLE `logs`
  ADD CONSTRAINT `logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
