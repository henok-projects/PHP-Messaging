-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 31, 2023 at 02:58 AM
-- Server version: 10.4.20-MariaDB
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `skill`
--

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `sender_id` int(255) NOT NULL,
  `receiver_id` int(20) NOT NULL,
  `text` text NOT NULL,
  `creation_time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `type` enum('Manual','System') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`sender_id`, `receiver_id`, `text`, `creation_time`, `type`) VALUES
(1, 2, 'Hello, this is a test message.', '0000-00-00 00:00:00', 'System'),
(1, 2, 'Hello, this is a test message.', '0000-00-00 00:00:00', 'System'),
(3, 4, 'Hello, second test message', '0000-00-00 00:00:00', 'System'),
(3, 4, 'Hello, second test message', '0000-00-00 00:00:00', 'System'),
(3, 4, 'Hello, second test message', '0000-00-00 00:00:00', 'System'),
(3, 4, 'Hello, second test message', '0000-00-00 00:00:00', 'System'),
(3, 4, 'Hello, second test message', '0000-00-00 00:00:00', 'System'),
(8, 6, 'Hello, second test message', '0000-00-00 00:00:00', 'System'),
(8, 6, 'Hello, second test message', '0000-00-00 00:00:00', 'System'),
(8, 6, 'Hello, second test message', '0000-00-00 00:00:00', 'System'),
(3, 4, 'Hello, this is a test message.', '0000-00-00 00:00:00', 'System'),
(3, 4, 'Hello, this is a test message.', '0000-00-00 00:00:00', 'System'),
(3, 4, 'Hello, this is a test message.', '0000-00-00 00:00:00', 'System');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `profile_photo` varchar(255) NOT NULL,
  `salutation` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `profile_photo`, `salutation`) VALUES
(1, 'John', 'Doe', 'john.doe@example.com', 'teacher.jpg', 'Mr.'),
(2, 'Jane', 'Smith', 'jane.smith@example.com', 'student.jpg', 'Ms.'),
(3, 'Teacher', 'Sol', 'sole@gmail.com', 'teacher.jpg', 'Mr.'),
(4, 'Neba', 'Jo', 'kal@example.com', 'student.jpg', 'Ms.'),
(5, 'Sami', 'Tesh', 'samuelad@gmail.com', 'student.jpg', 'Ms.'),
(6, 'Kale', 'Melk', 'heni@gmail.com', 'student.jpg', 'Ms.'),
(8, 'Sami', 'Tesh', 'samuelad@gmail.com', 'student.jpg', 'Ms.'),
(11, 'Henok', 'HTU', 'henookk@gmail.com', 'teacher.jpg', 'Mr.'),
(15, 'Neba', 'Jo', 'kal@example.com', 'student.jpg', 'Ms.');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD KEY `messages_ibfk_1` (`receiver_id`),
  ADD KEY `sender_id` (`sender_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
