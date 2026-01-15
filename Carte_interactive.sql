-- phpMyAdmin SQL Dump
-- version 6.0.0-dev+20260103.a60f0f3566
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 15, 2026 at 07:40 PM
-- Server version: 8.4.3
-- PHP Version: 8.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `carte_interactive`
--

-- --------------------------------------------------------

--
-- Table structure for table `cameras`
--

CREATE TABLE `cameras` (
  `id_camera` int NOT NULL,
  `coordonnees` text,
  `lien_photo` text,
  `origin_user` int DEFAULT NULL,
  `verifie` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `log`
--

CREATE TABLE `log` (
  `id_log` int NOT NULL,
  `temps` text,
  `type` text,
  `id_user` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `log`
--

INSERT INTO `log` (`id_log`, `temps`, `type`, `id_user`) VALUES
(1, '19:20:55', 'Création de compte', 1),
(2, '19:22:50', 'Connexion', 1),
(3, '19:37:55', 'Connexion', 1),
(4, '19:38:00', 'Connexion', 1),
(5, '19:38:04', 'Connexion', 1),
(6, '19:38:07', 'Connexion', 1),
(7, '19:38:11', 'Connexion', 1),
(8, '19:38:16', 'Connexion', 1),
(9, '19:38:21', 'Connexion', 1),
(10, '19:38:25', 'Connexion', 1),
(11, '19:38:53', 'Connexion', 1),
(12, '19:38:57', 'Connexion', 1),
(13, '19:39:01', 'Connexion', 1),
(14, '19:39:04', 'Connexion', 1),
(15, '19:39:09', 'Connexion', 1),
(16, '19:39:15', 'Connexion', 1),
(17, '19:39:19', 'Connexion', 1),
(18, '19:39:22', 'Connexion', 1),
(19, '19:39:25', 'Connexion', 1),
(20, '19:39:28', 'Connexion', 1),
(21, '19:39:32', 'Connexion', 1),
(22, '19:39:35', 'Connexion', 1),
(23, '19:39:38', 'Connexion', 1),
(24, '19:39:42', 'Connexion', 1),
(25, '19:39:46', 'Connexion', 1),
(26, '19:40:01', 'Connexion', 1),
(27, '19:40:05', 'Connexion', 1),
(28, '19:40:10', 'Connexion', 1),
(29, '19:40:13', 'Connexion', 1),
(30, '19:40:16', 'Connexion', 1),
(31, '19:40:21', 'Connexion', 1),
(32, '19:40:24', 'Connexion', 1);

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `id_user` int NOT NULL,
  `mdp` text,
  `email` text,
  `admin` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`id_user`, `mdp`, `email`, `admin`) VALUES
(1, '$2y$10$ziqUMBGCucJXt2FUT1uo8OWkbiXHdkdcCrRvuXQhogUOagKRS8vfa', 'leobodinleo@gmail.com', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cameras`
--
ALTER TABLE `cameras`
  ADD PRIMARY KEY (`id_camera`);

--
-- Indexes for table `log`
--
ALTER TABLE `log`
  ADD PRIMARY KEY (`id_log`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`id_user`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `log`
--
ALTER TABLE `log`
  ADD CONSTRAINT `Log_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `login` (`id_user`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
