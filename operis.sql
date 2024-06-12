-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 12, 2024 at 09:51 AM
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
-- Database: `operis`
--

-- --------------------------------------------------------

--
-- Table structure for table `files`
--

CREATE TABLE `files` (
  `fileID` int(11) NOT NULL,
  `userID` int(11) DEFAULT NULL,
  `fileName` varchar(255) NOT NULL,
  `fileType` varchar(50) NOT NULL,
  `filePath` varchar(255) NOT NULL,
  `uploadTime` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `files`
--

INSERT INTO `files` (`fileID`, `userID`, `fileName`, `fileType`, `filePath`, `uploadTime`) VALUES
(636, 18, 'ANNs.md', '.md', 'uploads/ANNs.md', '2024-06-12 07:44:46'),
(637, 18, 'coding book.md', '.md', 'uploads/coding book.md', '2024-06-12 07:44:46'),
(638, 18, 'dgdfg.md', '.md', 'uploads/dgdfg.md', '2024-06-12 07:44:46'),
(639, 18, 'Docs.md', '.md', 'uploads/Docs.md', '2024-06-12 07:44:46'),
(640, 18, 'HCI notes.md', '.md', 'uploads/HCI notes.md', '2024-06-12 07:44:47'),
(641, 18, 'Introduction.md', '.md', 'uploads/Introduction.md', '2024-06-12 07:44:47'),
(642, 18, 'Narnia.md', '.md', 'uploads/Narnia.md', '2024-06-12 07:44:47'),
(644, 18, 'Test .md', '.md', 'uploads/Test .md', '2024-06-12 07:44:47'),
(645, 18, 'Test Book 2.md', '.md', 'uploads/Test Book 2.md', '2024-06-12 07:44:47'),
(646, 18, 'Test Book.md', '.md', 'uploads/Test Book.md', '2024-06-12 07:44:47'),
(647, 18, 'Test Notes.md', '.md', 'uploads/Test Notes.md', '2024-06-12 07:44:47'),
(648, 18, 'database.db', '.db', 'uploads/database.db', '2024-06-12 07:44:47');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userID` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(50) NOT NULL,
  `verificationToken` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `verified` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userID`, `name`, `email`, `verificationToken`, `password`, `verified`) VALUES
(18, 'Narnia', 'freotsam@gmail.com', 'ee9d8d4003541a897e0c0a006e55513f', '1b5ea7e5094d778599f523cc0a6f0c68', 1),
(19, 'Coder', 'samoeicoder@gmail.com', '114ead8dcc9bfa4ec9d681067bb27e5b', '08b40fa4ed2009a282c9a001138f5757', 1),
(20, 'Kipchirchir', 'samoeikipchirchir@students.uonbi.ac.ke', '79950d44f03449d23a19612fd11f4169', '27e20a9ae7d8a52b650ceccf6652a021', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `files`
--
ALTER TABLE `files`
  ADD PRIMARY KEY (`fileID`),
  ADD KEY `userID` (`userID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `files`
--
ALTER TABLE `files`
  MODIFY `fileID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=649;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `files`
--
ALTER TABLE `files`
  ADD CONSTRAINT `files_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `users` (`userID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
