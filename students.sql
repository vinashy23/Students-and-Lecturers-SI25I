-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 06, 2026 at 06:58 AM
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
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` bigint(20) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `major` varchar(100) DEFAULT NULL,
  `class` varchar(50) DEFAULT NULL,
  `hobby` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `name`, `major`, `class`, `hobby`) VALUES
(20250050039, 'Bagas Raditia Mukti', 'Information Systems', 'SI25I', 'Gaming'),
(20250050040, 'Pida Sopiatul Hasanah', 'Information Systems', 'SI25I', 'Baking'),
(20250050041, 'Rosi Amelia Rachman', 'Information Systems', 'SI25I', 'Photography '),
(20250050042, 'Fatimah Azzahra', 'Information Systems', 'SI25I', 'Make Up'),
(20250050043, 'Tira Dwi Raharjo', 'Information Systems', 'SI25I', 'Reading'),
(20250050049, 'Ruaida', 'Information Systems', 'SI25I', 'Dancing'),
(20250050050, 'Nurisma Aulani', 'Information Systems', 'SI25I', 'Writing'),
(20250050054, 'Raihani Putrina Hendri', 'Information Systems', 'SI25I', 'Healing'),
(20250050060, 'Tisa Eka Raharjo', 'Information Systems', 'SI25I', 'Listening Music'),
(20250050062, 'Diaz Abyansyah Ramdhani', 'Information Systems', 'SI25I', 'Web Analyst'),
(20250050063, 'Mochammad Tri Yasir Rizqi', 'Information Systems', 'SI25I', 'Cycling'),
(20250050067, 'Vina Sri Haryuni ', 'Information Systems', 'SI25I', 'Cinematography and Editing'),
(20250050068, 'Siti Hawa', 'Information Systems', 'SI25I', 'Cooking'),
(20250050069, 'Shalwa Maulidha Husein', 'Information Systems', 'SI25I', 'Watching K-Pop'),
(20250050078, 'Salwa Haulia', 'Information Systems', 'SI25I', 'Singing'),
(20250050084, 'Edel Fergus Priyatama Harefa', 'Information Systems', 'SI25I', 'Gaming'),
(20250050087, 'Rieffa Dwi Syaharani', 'Information Systems', 'SI25I', 'Watching Movies'),
(20250050098, 'Nathanael Deng Grant', 'Information Systems', 'SI25I', 'Sleeping and Hunting'),
(20250050099, 'Nathasya Imanuella Putricya Tanu', 'Information Systems', 'SI25I', 'Watching Movies'),
(20250050100, 'Kenneth Gavin Kawita', 'Information Systems', 'SI25I', 'Sleeping'),
(20250050101, 'Xena Levina Edriana Br. Regar', 'Information Systems', 'SI25I', 'Singing'),
(20250050103, 'Chindy Huraitul Jannah', 'Information Systems', 'SI25I', 'Cooking'),
(20250050116, 'Myat Noe Wai', 'Information Systems', 'SI25I', 'Singing'),
(20250050121, 'Elijah Bior Atem Bior', 'Information Systems', 'SI25I', 'Footbal'),
(20250050123, 'Hsu Pyae Nandar', 'Information Systems', 'SI25I', 'Cooking'),
(20250050124, 'Uzochukwu Somtochukwu Peter', 'Information Systems', 'SI25I', 'Chess'),
(20250050125, 'Epiphanie Uwayarakizwa', 'Information Systems', 'SI25I', 'Traveling');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
