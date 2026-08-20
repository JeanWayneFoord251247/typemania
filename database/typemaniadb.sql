-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 20, 2026 at 01:43 PM
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
-- Database: `typemaniadb`
--

-- --------------------------------------------------------

--
-- Table structure for table `game_modes`
--

CREATE TABLE `game_modes` (
  `mode_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `game_modes`
--

INSERT INTO `game_modes` (`mode_id`, `name`) VALUES
(2, 'chase'),
(3, 'race'),
(1, 'rush');

-- --------------------------------------------------------

--
-- Table structure for table `game_scores`
--

CREATE TABLE `game_scores` (
  `score_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `mode_id` int(10) UNSIGNED NOT NULL,
  `opponent_user_id` int(10) UNSIGNED DEFAULT NULL,
  `difficulty` enum('easy','medium','hard') NOT NULL DEFAULT 'medium',
  `wpm` int(10) UNSIGNED NOT NULL,
  `accuracy` decimal(5,2) NOT NULL,
  `points` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `duration_seconds` decimal(6,2) NOT NULL,
  `words_typed` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `mistakes` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `distance_meters` int(10) UNSIGNED DEFAULT NULL,
  `fastest_paragraph_time` decimal(6,2) DEFAULT NULL,
  `race_result` enum('win','loss','draw') DEFAULT NULL,
  `played_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `game_scores`
--

INSERT INTO `game_scores` (`score_id`, `user_id`, `mode_id`, `opponent_user_id`, `difficulty`, `wpm`, `accuracy`, `points`, `duration_seconds`, `words_typed`, `mistakes`, `distance_meters`, `fastest_paragraph_time`, `race_result`, `played_at`) VALUES
(1, 3, 2, NULL, 'easy', 35, 91.00, 50, 17.00, 11, 5, NULL, NULL, NULL, '2026-08-19 11:18:14'),
(2, 3, 1, NULL, 'medium', 41, 91.00, 75, 15.00, 11, 5, NULL, NULL, NULL, '2026-08-19 11:19:30'),
(3, 3, 2, NULL, 'easy', 40, 94.00, 530, 16.00, 11, 3, NULL, NULL, NULL, '2026-08-19 11:25:32'),
(4, 3, 2, NULL, 'easy', 40, 94.00, 530, 17.00, 11, 3, NULL, NULL, NULL, '2026-08-19 11:25:32'),
(5, 3, 2, NULL, 'easy', 40, 94.00, 530, 17.00, 11, 3, NULL, NULL, NULL, '2026-08-19 11:25:33'),
(6, 3, 2, NULL, 'easy', 40, 94.00, 530, 17.00, 11, 3, NULL, NULL, NULL, '2026-08-19 11:25:33'),
(7, 3, 2, NULL, 'easy', 40, 94.00, 530, 18.00, 11, 3, NULL, NULL, NULL, '2026-08-19 11:25:34'),
(8, 3, 2, NULL, 'easy', 40, 94.00, 530, 18.00, 11, 3, NULL, NULL, NULL, '2026-08-19 11:25:34'),
(9, 3, 2, NULL, 'easy', 40, 94.00, 530, 19.00, 11, 3, NULL, NULL, NULL, '2026-08-19 11:25:34'),
(10, 3, 2, NULL, 'easy', 40, 94.00, 530, 19.00, 11, 3, NULL, NULL, NULL, '2026-08-19 11:25:35'),
(11, 3, 2, NULL, 'easy', 40, 94.00, 530, 19.00, 11, 3, NULL, NULL, NULL, '2026-08-19 11:25:35'),
(12, 3, 2, NULL, 'easy', 40, 94.00, 530, 20.00, 11, 3, NULL, NULL, NULL, '2026-08-19 11:25:36'),
(13, 3, 2, NULL, 'easy', 40, 94.00, 530, 20.00, 11, 3, NULL, NULL, NULL, '2026-08-19 11:25:36'),
(14, 3, 2, NULL, 'easy', 40, 94.00, 530, 21.00, 11, 3, NULL, NULL, NULL, '2026-08-19 11:25:36'),
(15, 3, 2, NULL, 'easy', 40, 94.00, 530, 21.00, 11, 3, NULL, NULL, NULL, '2026-08-19 11:25:37'),
(16, 3, 2, NULL, 'easy', 40, 94.00, 530, 21.00, 11, 3, NULL, NULL, NULL, '2026-08-19 11:25:37'),
(17, 3, 2, NULL, 'easy', 40, 94.00, 530, 22.00, 11, 3, NULL, NULL, NULL, '2026-08-19 11:25:38'),
(18, 3, 2, NULL, 'easy', 47, 100.00, 1250, 8.00, 3, 0, NULL, NULL, NULL, '2026-08-19 11:25:50'),
(19, 3, 2, NULL, 'easy', 47, 100.00, 1250, 8.00, 3, 0, NULL, NULL, NULL, '2026-08-19 11:25:51'),
(20, 3, 2, NULL, 'easy', 47, 100.00, 1250, 9.00, 3, 0, NULL, NULL, NULL, '2026-08-19 11:25:51'),
(21, 3, 2, NULL, 'easy', 47, 100.00, 1250, 9.00, 3, 0, NULL, NULL, NULL, '2026-08-19 11:25:52'),
(22, 3, 2, NULL, 'easy', 47, 100.00, 1250, 10.00, 3, 0, NULL, NULL, NULL, '2026-08-19 11:25:52'),
(23, 3, 2, NULL, 'easy', 47, 100.00, 1250, 10.00, 3, 0, NULL, NULL, NULL, '2026-08-19 11:25:53'),
(24, 3, 2, NULL, 'easy', 47, 100.00, 1250, 10.00, 3, 0, NULL, NULL, NULL, '2026-08-19 11:25:53'),
(25, 3, 2, NULL, 'easy', 47, 100.00, 1250, 11.00, 3, 0, NULL, NULL, NULL, '2026-08-19 11:25:53'),
(26, 3, 2, NULL, 'easy', 47, 100.00, 1250, 11.00, 3, 0, NULL, NULL, NULL, '2026-08-19 11:25:54'),
(27, 3, 2, NULL, 'easy', 47, 100.00, 1250, 12.00, 3, 0, NULL, NULL, NULL, '2026-08-19 11:25:54'),
(28, 3, 2, NULL, 'easy', 47, 100.00, 1250, 12.00, 3, 0, NULL, NULL, NULL, '2026-08-19 11:25:55'),
(29, 3, 2, NULL, 'easy', 47, 100.00, 1250, 13.00, 3, 0, NULL, NULL, NULL, '2026-08-19 11:25:55'),
(30, 3, 2, NULL, 'easy', 47, 100.00, 1250, 13.00, 3, 0, NULL, NULL, NULL, '2026-08-19 11:25:55'),
(31, 3, 2, NULL, 'easy', 33, 84.00, 0, 6.00, 4, 3, NULL, NULL, NULL, '2026-08-19 11:35:22'),
(32, 3, 2, NULL, 'easy', 33, 84.00, 0, 7.00, 4, 3, NULL, NULL, NULL, '2026-08-19 11:35:22'),
(33, 3, 2, NULL, 'easy', 33, 84.00, 0, 7.00, 4, 3, NULL, NULL, NULL, '2026-08-19 11:35:23'),
(34, 3, 2, NULL, 'easy', 33, 84.00, 0, 8.00, 4, 3, NULL, NULL, NULL, '2026-08-19 11:35:23'),
(35, 3, 2, NULL, 'easy', 33, 84.00, 0, 8.00, 4, 3, NULL, NULL, NULL, '2026-08-19 11:35:24'),
(36, 3, 2, NULL, 'easy', 33, 84.00, 0, 8.00, 4, 3, NULL, NULL, NULL, '2026-08-19 11:35:24'),
(37, 3, 2, NULL, 'easy', 33, 84.00, 0, 9.00, 4, 3, NULL, NULL, NULL, '2026-08-19 11:35:24'),
(38, 3, 2, NULL, 'easy', 33, 84.00, 0, 9.00, 4, 3, NULL, NULL, NULL, '2026-08-19 11:35:25'),
(39, 3, 2, NULL, 'easy', 33, 84.00, 0, 10.00, 4, 3, NULL, NULL, NULL, '2026-08-19 11:35:25'),
(40, 3, 2, NULL, 'easy', 33, 84.00, 0, 10.00, 4, 3, NULL, NULL, NULL, '2026-08-19 11:35:26'),
(41, 3, 2, NULL, 'easy', 33, 84.00, 0, 11.00, 4, 3, NULL, NULL, NULL, '2026-08-19 11:35:26'),
(42, 3, 2, NULL, 'easy', 33, 84.00, 0, 11.00, 4, 3, NULL, NULL, NULL, '2026-08-19 11:35:26'),
(43, 3, 2, NULL, 'easy', 33, 84.00, 0, 11.00, 4, 3, NULL, NULL, NULL, '2026-08-19 11:35:27'),
(44, 3, 2, NULL, 'easy', 33, 84.00, 0, 12.00, 4, 3, NULL, NULL, NULL, '2026-08-19 11:35:27'),
(45, 3, 2, NULL, 'easy', 33, 84.00, 0, 12.00, 4, 3, NULL, NULL, NULL, '2026-08-19 11:35:28'),
(46, 3, 2, NULL, 'easy', 33, 84.00, 0, 13.00, 4, 3, NULL, NULL, NULL, '2026-08-19 11:35:28'),
(47, 3, 2, NULL, 'easy', 33, 84.00, 0, 13.00, 4, 3, NULL, NULL, NULL, '2026-08-19 11:35:28'),
(48, 3, 2, NULL, 'easy', 33, 84.00, 0, 13.00, 4, 3, NULL, NULL, NULL, '2026-08-19 11:35:29'),
(49, 3, 2, NULL, 'easy', 34, 81.00, 0, 7.00, 4, 4, NULL, NULL, NULL, '2026-08-19 11:37:26'),
(50, 3, 2, NULL, 'easy', 34, 81.00, 0, 7.00, 4, 4, NULL, NULL, NULL, '2026-08-19 11:37:27'),
(51, 3, 2, NULL, 'easy', 34, 81.00, 0, 7.00, 4, 4, NULL, NULL, NULL, '2026-08-19 11:37:27'),
(52, 3, 2, NULL, 'easy', 34, 81.00, 0, 8.00, 4, 4, NULL, NULL, NULL, '2026-08-19 11:37:28'),
(53, 3, 2, NULL, 'easy', 34, 81.00, 0, 8.00, 4, 4, NULL, NULL, NULL, '2026-08-19 11:37:28'),
(54, 3, 2, NULL, 'easy', 34, 81.00, 0, 9.00, 4, 4, NULL, NULL, NULL, '2026-08-19 11:37:28'),
(55, 3, 2, NULL, 'easy', 34, 81.00, 0, 9.00, 4, 4, NULL, NULL, NULL, '2026-08-19 11:37:29'),
(56, 3, 2, NULL, 'easy', 34, 81.00, 0, 9.00, 4, 4, NULL, NULL, NULL, '2026-08-19 11:37:29'),
(57, 3, 1, NULL, 'medium', 29, 90.00, 33, 19.00, 10, 5, NULL, NULL, NULL, '2026-08-19 11:40:13'),
(58, 3, 2, NULL, 'easy', 0, 100.00, 0, 0.00, 0, 0, NULL, NULL, NULL, '2026-08-19 11:55:04'),
(59, 3, 2, NULL, 'easy', 0, 100.00, 0, 0.00, 0, 0, NULL, NULL, NULL, '2026-08-19 11:55:13'),
(60, 3, 2, NULL, 'easy', 31, 79.00, 300, 12.00, 8, 8, NULL, NULL, NULL, '2026-08-19 11:56:55'),
(61, 3, 2, NULL, 'easy', 34, 89.00, 248, 12.00, 5, 3, NULL, NULL, NULL, '2026-08-19 11:57:16'),
(62, 3, 2, NULL, 'easy', 0, 100.00, 0, 0.00, 0, 0, NULL, NULL, NULL, '2026-08-19 11:57:26'),
(63, 3, 1, NULL, 'easy', 40, 89.00, 398, 12.00, 9, 5, NULL, NULL, NULL, '2026-08-19 11:58:06'),
(64, 3, 1, NULL, 'medium', 3, 17.00, 15, 4.00, 1, 5, NULL, NULL, NULL, '2026-08-19 12:02:32'),
(65, 3, 1, NULL, 'medium', 38, 93.00, 968, 20.00, 14, 5, NULL, NULL, NULL, '2026-08-19 12:02:59'),
(66, 3, 2, NULL, 'easy', 35, 87.00, 468, 16.00, 9, 7, NULL, NULL, NULL, '2026-08-19 12:07:48'),
(67, 4, 1, NULL, 'medium', 34, 96.00, 1812, 41.00, 23, 5, NULL, NULL, NULL, '2026-08-19 13:10:10'),
(68, 4, 2, NULL, 'easy', 38, 92.00, 1076, 31.00, 20, 9, NULL, NULL, NULL, '2026-08-19 13:11:21'),
(69, 5, 2, NULL, 'easy', 37, 92.00, 583, 18.00, 11, 5, NULL, NULL, NULL, '2026-08-20 08:16:49'),
(70, 6, 2, NULL, 'medium', 46, 86.00, 380, 7.00, 5, 4, NULL, NULL, NULL, '2026-08-20 08:26:51'),
(71, 6, 1, NULL, 'easy', 39, 96.00, 1448, 41.00, 27, 5, NULL, NULL, NULL, '2026-08-20 08:32:36'),
(72, 6, 1, NULL, 'easy', 38, 94.00, 932, 26.00, 16, 5, NULL, NULL, NULL, '2026-08-20 08:33:11'),
(73, 6, 1, NULL, 'easy', 39, 93.00, 752, 22.00, 14, 5, NULL, NULL, NULL, '2026-08-20 08:33:44'),
(74, 2, 2, NULL, 'medium', 51, 92.00, 533, 9.00, 7, 3, NULL, NULL, NULL, '2026-08-20 08:35:08'),
(75, 1, 2, NULL, 'easy', 37, 99.00, 5019, 126.00, 78, 4, NULL, NULL, NULL, '2026-08-20 08:38:15'),
(76, 7, 2, NULL, 'medium', 0, 100.00, 0, 0.00, 0, 0, NULL, NULL, NULL, '2026-08-20 09:04:49'),
(77, 2, 2, NULL, 'easy', 41, 93.00, 278, 12.00, 5, 2, NULL, NULL, NULL, '2026-08-20 10:19:04'),
(78, 8, 1, NULL, 'easy', 31, 94.00, 902, 32.00, 17, 5, NULL, NULL, NULL, '2026-08-20 11:04:42'),
(79, 8, 2, NULL, 'easy', 35, 89.00, 685, 23.00, 13, 8, NULL, NULL, NULL, '2026-08-20 11:05:30'),
(80, 9, 1, NULL, 'easy', 32, 86.00, 322, 12.00, 6, 5, NULL, NULL, NULL, '2026-08-20 11:13:14'),
(81, 9, 2, NULL, 'easy', 42, 95.00, 714, 23.00, 14, 4, NULL, NULL, NULL, '2026-08-20 11:13:59'),
(82, 10, 1, NULL, 'easy', 32, 94.00, 810, 29.00, 15, 5, NULL, NULL, NULL, '2026-08-20 11:18:29'),
(83, 10, 2, NULL, 'easy', 35, 91.00, 1276, 40.00, 23, 12, NULL, NULL, NULL, '2026-08-20 11:19:27'),
(84, 11, 1, NULL, 'easy', 33, 89.00, 459, 16.00, 8, 5, NULL, NULL, NULL, '2026-08-20 11:32:15'),
(85, 11, 2, NULL, 'easy', 29, 81.00, 308, 14.00, 6, 7, NULL, NULL, NULL, '2026-08-20 11:32:51');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `username` varchar(16) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `circle_color` varchar(7) DEFAULT '#00D4FF',
  `letter_color` varchar(7) DEFAULT '#00D4FF',
  `role` enum('user','admin') NOT NULL DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password_hash`, `circle_color`, `letter_color`, `role`, `created_at`, `updated_at`) VALUES
(1, 'Jaco', '$2y$10$fVf73Bpypp3Jn5boUlkymuYKFIiHX2C0JxgwYCrRVLqSqLEhaVdLO', '#00D4FF', '#00D4FF', 'user', '2026-08-18 15:22:27', '2026-08-18 15:22:27'),
(2, 'Peanut', '$2y$10$MlguiAABvrcDLMXAQLNENOB8XXlbTO6PNKG7iCbo0wTc2XZMZTbbG', '#00D4FF', '#00D4FF', 'user', '2026-08-19 08:40:03', '2026-08-19 08:40:03'),
(3, 'Jean-Wayne', '$2y$10$cRRDtlmTevWU15p9.f53muUKjBECMtkdcTyFAvE6brjM0dmCR/VGS', '#00D4FF', '#00D4FF', 'user', '2026-08-19 11:11:52', '2026-08-19 11:11:52'),
(4, 'Alijandro', '$2y$10$RVYoRFf3Gon1H9FAwQKtM.Z5ZoDaJpOGk3QviFwuBts.WsYAqWxs.', '#A855F7', '#FFFFFF', 'user', '2026-08-19 13:08:25', '2026-08-19 13:09:08'),
(5, 'Caden', '$2y$10$YL5JeSQn93VXzGPVKDAHP.EkTevcWnXo5JAa1Eff0.hRsMUMxrL/.', '#00D4FF', '#00D4FF', 'user', '2026-08-20 08:16:15', '2026-08-20 08:16:15'),
(6, 'Delmarie', '$2y$10$ipegssKMI1LeHXBAFVsEkuZyuj5rtbrtLR8RziAVf.9kZ3KnxC3E6', '#00D4FF', '#00D4FF', 'user', '2026-08-20 08:26:21', '2026-08-20 08:26:21'),
(7, 'Wayne', '$2y$10$STTf0.YbJzLcw37.x3UiCeIwLVewy4rF8.cjw8qqpWm3tfyZ.kl.m', '#FFF700', '#FFFFFF', 'user', '2026-08-20 09:01:06', '2026-08-20 09:23:37'),
(8, 'Bruce', '$2y$10$HwOo4Aj76pSEoTfOYFMMMOdGJ/mKK13uk859LX0AGkN1VAAIMmYKG', '#A855F7', '#FFFFFF', 'user', '2026-08-20 11:03:00', '2026-08-20 11:06:32'),
(9, 'Uncle', '$2y$10$zwq7DTGCnGLI/4408fIu5uHkjONSv6AkdNXh2R8EgF.dUxEpcJ19.', '#A855F7', '#FFFFFF', 'user', '2026-08-20 11:11:58', '2026-08-20 11:12:44'),
(10, 'Granny', '$2y$10$Uf6BDQVUNjW0ilkRCMTJouRPrK..ZrgEGjPwf98vcEnGt0uvbVG82', '#A855F7', '#FFFFFF', 'user', '2026-08-20 11:16:54', '2026-08-20 11:17:32'),
(11, 'Mom', '$2y$10$RrauzjOKwMqMdWAb79vjrex5DSZCO6enC6t5bho39X3SN3RoATfRK', '#00D4FF', '#00D4FF', 'user', '2026-08-20 11:30:43', '2026-08-20 11:30:43');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `game_modes`
--
ALTER TABLE `game_modes`
  ADD PRIMARY KEY (`mode_id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `game_scores`
--
ALTER TABLE `game_scores`
  ADD PRIMARY KEY (`score_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `opponent_user_id` (`opponent_user_id`),
  ADD KEY `mode_id` (`mode_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `game_modes`
--
ALTER TABLE `game_modes`
  MODIFY `mode_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `game_scores`
--
ALTER TABLE `game_scores`
  MODIFY `score_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `game_scores`
--
ALTER TABLE `game_scores`
  ADD CONSTRAINT `game_scores_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `game_scores_ibfk_2` FOREIGN KEY (`opponent_user_id`) REFERENCES `users` (`user_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `game_scores_ibfk_3` FOREIGN KEY (`mode_id`) REFERENCES `game_modes` (`mode_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
