-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 06, 2026 at 06:57 AM
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
-- Database: `campus`
--

-- --------------------------------------------------------

--
-- Table structure for table `lecturer`
--

CREATE TABLE `lecturer` (
  `NIDN` varchar(20) NOT NULL,
  `Name` varchar(100) DEFAULT NULL,
  `Major` varchar(100) DEFAULT NULL,
  `Course` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lecturer`
--

INSERT INTO `lecturer` (`NIDN`, `Name`, `Major`, `Course`) VALUES
('012018001', 'Dr. Jasmansyah, M.Pd.', 'Information Systems', 'Civic Education'),
('0120200030', 'M. Anton Permana, M.Kom.', 'Information Systems', 'Database'),
('0120210026', 'Chitrash Bisht, D.El.Ed., B.Tech., M.Hist.', 'Information Systems', 'Professional English'),
('0120250011', 'Wahyu Tri Budianto, S.Mat., M.Sc.', 'Information Systems', 'Statistics and Probability'),
('0120250013', 'Mustar Aman, M.Kom.', 'Information Systems', 'Management Information Systems'),
('408029102', 'Falentino Sembiring, M.Kom.', 'Information Systems', 'PBO SI25I'),
('424089206', 'Arny Lattu, S.Pd.Kom., M.Kom.', 'Information Systems', 'Digital Transformation');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `lecturer`
--
ALTER TABLE `lecturer`
  ADD PRIMARY KEY (`NIDN`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
