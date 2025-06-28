-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 24, 2025 at 01:33 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `xem`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `isActive` int(11) NOT NULL,
  `create_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `email`, `password`, `isActive`, `create_date`) VALUES
(1, 'tamer', 'taamir.mm@gmail.com', '$2y$10$y0BssltjFWebeTwg9Z68sucGYR.UWFaYTgheXNV08XB8CpvPBHIHW', 1, '2025-06-19 10:21:35'),
(2, 'tamer1', 'taamir1.mm@gmail.com', '$2y$10$DzkE3AosPj85LFseDM4hceQ10k1mF43FZtnOVJPkjH4L8G3Un6NRW', 1, '2025-06-19 10:33:35');

-- --------------------------------------------------------

--
-- Table structure for table `batches`
--

CREATE TABLE `batches` (
  `id` int(11) NOT NULL,
  `batchName` varchar(255) NOT NULL,
  `batchStartDate` varchar(255) NOT NULL,
  `batchStatus` enum('Complete','Ongoing') NOT NULL,
  `create_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `batches`
--

INSERT INTO `batches` (`id`, `batchName`, `batchStartDate`, `batchStatus`, `create_date`) VALUES
(1, 'Batch One', '17/6/2025', 'Ongoing', '2025-06-17 22:05:26'),
(2, 'Batch Two', '20/6/2025', 'Ongoing', '2025-06-17 17:02:55'),
(3, 'Batch Three', '2025-06-18', 'Complete', '2025-06-17 21:49:42');

-- --------------------------------------------------------

--
-- Table structure for table `exercises`
--

CREATE TABLE `exercises` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `note` text DEFAULT NULL,
  `type` enum('file','github_repo') NOT NULL,
  `file_paths` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`file_paths`)),
  `github_repo_link` varchar(255) DEFAULT NULL,
  `status` enum('pending','approved','rejected') DEFAULT 'pending',
  `uploaded_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `mentor_feedback` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `id` int(11) NOT NULL,
  `groupName` varchar(255) NOT NULL,
  `groupMentor` int(11) NOT NULL,
  `create_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `groupName`, `groupMentor`, `create_date`) VALUES
(2, 'Group One', 1, '2025-06-18 01:42:19'),
(3, 'Group Two', 3, '2025-06-18 11:59:13');

-- --------------------------------------------------------

--
-- Table structure for table `mentors`
--

CREATE TABLE `mentors` (
  `id` int(11) NOT NULL,
  `mentorName` varchar(255) NOT NULL,
  `mentorEmail` varchar(255) NOT NULL,
  `mentorPassword` varchar(255) NOT NULL,
  `isActive` varchar(255) NOT NULL DEFAULT 'true',
  `create_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mentors`
--

INSERT INTO `mentors` (`id`, `mentorName`, `mentorEmail`, `mentorPassword`, `isActive`, `create_date`) VALUES
(1, 'Abuubakar', 'taamir.mm@gmail.com', '', '1', '2025-06-17 22:25:54'),
(3, 'Abdirahmaan Osmaan ', 'abdirahmaanosman@gmail.com', '', '0', '2025-06-18 08:58:42');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `studentName` varchar(255) NOT NULL,
  `studentEmail` varchar(255) NOT NULL,
  `studentBatch` int(11) NOT NULL,
  `studentGroup` int(11) NOT NULL,
  `studentPassword` varchar(255) NOT NULL,
  `isActive` varchar(255) NOT NULL DEFAULT '1',
  `create_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `studentName`, `studentEmail`, `studentBatch`, `studentGroup`, `studentPassword`, `isActive`, `create_date`) VALUES
(3, 'Abdirahmaan Hilowle', 'aknamhilowle@gmail.com', 2, 2, '', '0', '2025-06-19 10:48:09'),
(4, 'Ibraahim C.laahi Subeyr', 'inasubeyr@gmail.com', 1, 3, '123', '1', '2025-06-19 10:09:59');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `batches`
--
ALTER TABLE `batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `exercises`
--
ALTER TABLE `exercises`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`),
  ADD KEY `groupMentor` (`groupMentor`);

--
-- Indexes for table `mentors`
--
ALTER TABLE `mentors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD KEY `studentBatch` (`studentBatch`),
  ADD KEY `studentGroup` (`studentGroup`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `batches`
--
ALTER TABLE `batches`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `exercises`
--
ALTER TABLE `exercises`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `mentors`
--
ALTER TABLE `mentors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `exercises`
--
ALTER TABLE `exercises`
  ADD CONSTRAINT `exercises_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `groups`
--
ALTER TABLE `groups`
  ADD CONSTRAINT `groups_ibfk_1` FOREIGN KEY (`groupMentor`) REFERENCES `mentors` (`id`);

--
-- Constraints for table `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `students_ibfk_1` FOREIGN KEY (`studentBatch`) REFERENCES `batches` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `students_ibfk_2` FOREIGN KEY (`studentGroup`) REFERENCES `groups` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
