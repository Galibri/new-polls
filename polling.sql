-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 16, 2020 at 07:27 PM
-- Server version: 8.0.20-0ubuntu0.20.04.1
-- PHP Version: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `polling`
--

-- --------------------------------------------------------

--
-- Table structure for table `answers`
--

CREATE TABLE `answers` (
  `id` int NOT NULL,
  `question_id` int NOT NULL,
  `answer` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `answers`
--

INSERT INTO `answers` (`id`, `question_id`, `answer`) VALUES
(3, 5, '5-12'),
(4, 5, '13-22'),
(5, 5, '23-41'),
(6, 5, '42-92'),
(7, 6, 'Bangladesh'),
(8, 6, 'India'),
(9, 6, 'Pakistan'),
(10, 6, 'UK'),
(13, 8, 'Male'),
(14, 8, 'Female'),
(15, 8, 'Commons'),
(16, 9, 'Parot'),
(17, 9, 'Cat'),
(18, 9, 'Dog'),
(19, 9, 'Moneky'),
(20, 9, 'Bird'),
(23, 10, 'Yess'),
(24, 10, 'No');

-- --------------------------------------------------------

--
-- Table structure for table `questionnaires`
--

CREATE TABLE `questionnaires` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `question_ids` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `questionnaires`
--

INSERT INTO `questionnaires` (`id`, `name`, `question_ids`) VALUES
(2, 'Customer Response', '10, 9, 8, 5'),
(3, 'Chat feedback', '10, 8, 1'),
(4, 'Hosting feedback', '6, 5, 1');

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `question` text,
  `type` int NOT NULL,
  `is_global` tinyint(1) NOT NULL DEFAULT '1',
  `number_of_ans` int DEFAULT NULL,
  `added_on` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`id`, `user_id`, `question`, `type`, `is_global`, `number_of_ans`, `added_on`) VALUES
(1, 1, 'What is your name?', 3, 1, 1, '2020-07-15 01:42:10'),
(3, 1, 'Send me your bio', 3, 1, 1, '2020-07-15 03:01:45'),
(5, 1, 'How old are you?', 1, 1, 4, '2020-07-15 03:40:45'),
(6, 1, 'Where are you from?', 1, 0, 4, '2020-07-15 03:42:33'),
(8, 1, 'What  is your gender?', 2, 1, 3, '2020-07-15 03:57:38'),
(9, 1, 'Which pets do you have? (Choose as many as you have)', 2, 1, 5, '2020-07-15 13:41:21'),
(10, 1, 'Are you married?', 1, 1, 2, '2020-07-15 14:49:00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT '0',
  `added_on` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `phone`, `is_admin`, `added_on`) VALUES
(1, 'Galib', 'admin@admin.com', '5f4dcc3b5aa765d61d8327deb882cf99', '84723948', 1, '2020-07-14 20:41:19');

-- --------------------------------------------------------

--
-- Table structure for table `user_answers`
--

CREATE TABLE `user_answers` (
  `id` int NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `question_id` int NOT NULL,
  `answer_id` int DEFAULT NULL,
  `free_answer` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user_answers`
--

INSERT INTO `user_answers` (`id`, `user_email`, `question_id`, `answer_id`, `free_answer`) VALUES
(2, 'user@user.com', 3, NULL, 'Graduate in CSE'),
(3, 'user@user.com', 10, 23, NULL),
(4, 'user@user.com', 5, 5, NULL),
(5, 'user@user.com', 9, 17, NULL),
(6, 'user@user.com', 9, 20, NULL),
(7, 'user@user.com', 8, 13, NULL),
(8, 'someone@website.com', 1, NULL, 'Someone'),
(9, 'someone@website.com', 10, 23, NULL),
(10, 'someone@website.com', 5, 5, NULL),
(11, 'someone@website.com', 9, 17, NULL),
(12, 'someone@website.com', 9, 18, NULL),
(13, 'someone@website.com', 8, 13, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_q_answers`
--

CREATE TABLE `user_q_answers` (
  `id` int NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `questionnaire_id` int NOT NULL,
  `question_id` int NOT NULL,
  `answer_id` int DEFAULT NULL,
  `free_answer` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user_q_answers`
--

INSERT INTO `user_q_answers` (`id`, `user_email`, `questionnaire_id`, `question_id`, `answer_id`, `free_answer`) VALUES
(1, 'user@user.com', 2, 10, 24, NULL),
(2, 'user@user.com', 2, 5, 4, NULL),
(3, 'user@user.com', 2, 9, 18, NULL),
(4, 'user@user.com', 2, 9, 19, NULL),
(5, 'user@user.com', 2, 8, 14, NULL),
(6, 'user@user.com', 3, 10, 24, NULL),
(7, 'user@user.com', 3, 8, 14, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `answers`
--
ALTER TABLE `answers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `questionnaires`
--
ALTER TABLE `questionnaires`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_answers`
--
ALTER TABLE `user_answers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_q_answers`
--
ALTER TABLE `user_q_answers`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `answers`
--
ALTER TABLE `answers`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `questionnaires`
--
ALTER TABLE `questionnaires`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user_answers`
--
ALTER TABLE `user_answers`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `user_q_answers`
--
ALTER TABLE `user_q_answers`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
