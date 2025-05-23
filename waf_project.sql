-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 14, 2025 at 11:10 AM
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
-- Table structure for table `alerts`
--

CREATE TABLE `alerts` (
  `id` int(11) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `alert_type` varchar(100) NOT NULL,
  `status` enum('unresolved','resolved') DEFAULT 'unresolved',
  `timestamp` datetime DEFAULT current_timestamp()
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

--
-- Dumping data for table `blogs`
--

INSERT INTO `blogs` (`id`, `title`, `content`, `created_at`) VALUES
(4, '🔒 What is a Web Application Firewall (WAF)?', 'Hello Readers,\nA Web Application Firewall (WAF) protects web applications by filtering and monitoring HTTP traffic between a web application and the Internet.\nIt helps prevent attacks such as SQL injection, cross-site scripting (XSS), and other vulnerabilities.\nWAFs are essential for ensuring the security of any online service or website', '2025-05-13 04:10:37'),
(6, '🛡️ Best Practices for Web Application Security', 'Besides using a WAF, it\'s crucial to perform regular security updates, patch known\r\n                        vulnerabilities, conduct security audits, and follow secure coding practices.\r\n                    Layered security measures provide stronger protection for web applications and help maintain the\r\n                        trust of users and clients.', '2025-05-13 04:12:25'),
(7, '⚡ Why WAFs are Crucial in 2025', 'With the increasing sophistication of cyber threats, having a WAF is no longer optional.\r\n                    It acts as the first line of defense against many types of attacks targeting application\r\n                        vulnerabilities.\r\n                    The role of WAFs is critical especially as more businesses shift their operations online,\r\n                        making\r\n                        them prime targets for attackers.', '2025-05-13 04:18:43');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `blog_id` int(11) NOT NULL,
  `comment_text` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `user_id`, `blog_id`, `comment_text`, `created_at`) VALUES
(32, 5, 6, 'hi am who ', '2025-05-14 07:23:59'),
(34, 16, 6, 'how you did that', '2025-05-14 07:25:04');

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
(45, 5, 'User logged in', '::1', '2025-04-26 22:43:53'),
(46, 5, 'Updated profile information', '::1', '2025-04-26 22:44:17'),
(47, 5, 'User logged in', '::1', '2025-04-26 22:45:11'),
(48, 5, 'Blocked user with ID 5', '::1', '2025-04-26 22:46:54'),
(49, 5, 'Blocked user with ID 5', '::1', '2025-04-26 22:47:11'),
(50, 5, 'Blocked user with ID 6', '::1', '2025-04-26 22:47:21'),
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
(67, 5, 'User logged in', '::1', '2025-04-30 00:05:23'),
(78, 5, 'User logged in', '::1', '2025-05-02 14:46:46'),
(80, 5, 'User logged in', '::1', '2025-05-02 14:56:01'),
(82, 5, 'User logged in', '::1', '2025-05-02 16:02:58'),
(84, 5, 'User logged in', '::1', '2025-05-12 18:22:36'),
(88, 12, 'User logged in', '::1', '2025-05-13 01:31:00'),
(90, 12, 'User logged in', '::1', '2025-05-13 01:48:06'),
(91, 12, 'User logged in', '::1', '2025-05-13 02:36:53'),
(92, 12, 'Updated profile information', '::1', '2025-05-13 02:46:54'),
(93, 12, 'Updated profile information', '::1', '2025-05-13 02:47:19'),
(94, 12, 'Updated profile information', '::1', '2025-05-13 02:54:49'),
(95, 5, 'Posted a comment', '::1', '2025-05-14 00:53:32'),
(96, 5, 'Posted a comment', '::1', '2025-05-14 00:53:37'),
(97, 5, 'Posted a comment', '::1', '2025-05-14 00:53:40'),
(98, 5, 'Posted a comment', '::1', '2025-05-14 00:53:43'),
(99, 5, 'Posted a comment', '::1', '2025-05-14 00:53:48'),
(100, 5, 'Posted a comment', '::1', '2025-05-14 00:54:38'),
(140, 5, 'Posted a comment', '::1', '2025-05-14 10:23:59'),
(141, 16, 'Posted a comment', '::1', '2025-05-14 10:24:48'),
(142, 16, 'Deleted comment ID 33', '::1', '2025-05-14 10:24:53'),
(143, 16, 'Posted a comment', '::1', '2025-05-14 10:25:04');

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
  `role` enum('admin','soc_analyst','user') NOT NULL DEFAULT 'user',
  `status` enum('active','blocked') NOT NULL DEFAULT 'active',
  `last_login` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `profile_pic` varchar(255) DEFAULT 'default.jpg'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `Age`, `role`, `status`, `last_login`, `profile_pic`) VALUES
(5, 'loai admin', 'admin@g.c', '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4', 23, 'admin', 'active', '2025-05-14 03:59:46', 'uploads/1747184037_images2.png'),
(8, 'Jason-test', 'we@g.c', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', 187, 'user', 'active', '2025-05-14 02:51:25', 'uploads/1747128942_1747100710_IMG_20210506_011839_648.jpeg'),
(11, 'user', 'user@g.c', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', 23, 'user', 'active', '2025-04-17 15:04:40', 'default.jpg'),
(12, 'loai Esam ', 'l@g.c', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', 27678, 'user', 'active', '2025-05-14 02:21:35', 'uploads/1747113530_IMG_20210511_122911_468.jpeg'),
(15, 'soc ana', 'soc@g.c', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', 12, 'soc_analyst', 'active', '2025-05-14 10:21:49', 'default.jpg'),
(16, 'walid mohsen', 'w@g.c', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', 23, 'user', 'active', '2025-05-14 10:22:19', 'default.jpg');

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
-- Indexes for table `alerts`
--
ALTER TABLE `alerts`
  ADD PRIMARY KEY (`id`);

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
  ADD KEY `comments_ibfk_1` (`user_id`);

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
-- AUTO_INCREMENT for table `alerts`
--
ALTER TABLE `alerts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `blogs`
--
ALTER TABLE `blogs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=144;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

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
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`blog_id`) REFERENCES `blogs` (`id`);

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
