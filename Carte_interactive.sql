-- phpMyAdmin SQL Dump
-- version 5.2.2deb2
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : dim. 11 jan. 2026 à 13:21
-- Version du serveur : 8.4.7-0ubuntu0.25.10.3
-- Version de PHP : 8.4.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `Carte_interactive`
--

-- --------------------------------------------------------

--
-- Structure de la table `Cameras`
--

CREATE TABLE `Cameras` (
  `id_camera` int NOT NULL,
  `coordonnees` text,
  `lien_photo` text,
  `origin_user` int DEFAULT NULL,
  `verifie` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `Log`
--

CREATE TABLE `Log` (
  `id_log` int NOT NULL,
  `temps` text,
  `type` text,
  `id_user` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `Login`
--

CREATE TABLE `Login` (
  `id_user` int NOT NULL,
  `pseudo` text,
  `mdp` text,
  `email` text,
  `admin` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `Cameras`
--
ALTER TABLE `Cameras`
  ADD PRIMARY KEY (`id_camera`);

--
-- Index pour la table `Log`
--
ALTER TABLE `Log`
  ADD PRIMARY KEY (`id_log`),
  ADD KEY `id_user` (`id_user`);

--
-- Index pour la table `Login`
--
ALTER TABLE `Login`
  ADD PRIMARY KEY (`id_user`);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `Log`
--
ALTER TABLE `Log`
  ADD CONSTRAINT `Log_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `Login` (`id_user`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
