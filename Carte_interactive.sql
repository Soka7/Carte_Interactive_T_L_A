-- phpMyAdmin SQL Dump
-- version 6.0.0-dev+20260103.a60f0f3566
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 19, 2026 at 06:02 PM
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

--
-- Dumping data for table `cameras`
--

INSERT INTO `cameras` (`id_camera`, `coordonnees`, `lien_photo`, `origin_user`, `verifie`) VALUES
(1, 'g', 'TO DO !', 1, 0),
(2, 'gh', 'TO DO !', 1, 0),
(3, 'gh', 'TO DO !', 1, 0),
(4, 'o', 'TO DO !', 1, 0);

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
(1, '19/01/2026 10:26:13', 'Création de compte', 1),
(2, '19/01/2026 10:29:10', 'Connexion', 1),
(3, '19/01/2026 10:29:33', 'Création de compte', 2),
(4, '19/01/2026 10:29:45', 'Connexion', 2),
(5, '19/01/2026 10:30:10', 'Connexion', 1),
(6, '19/01/2026 05:50:31', 'Ajout Caméra', 1),
(7, '19/01/2026 05:50:37', 'Ajout Caméra', 1);

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
(1, '$2y$10$4GOH47dqnUERdxM4SXcAzuc6Qds4H7pr6XGgjjdU1jHU2gSBx82a.', 'leobodinleo@gmail.com', 1),
(2, '$2y$10$i8T6oUKgaof0F0RV.WvNnuwjupQ8JdUNMbvYRYnMmmSzoWaBsyGcO', 'DeleteGriffith', 0);

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
