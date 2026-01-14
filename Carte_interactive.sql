-- phpMyAdmin SQL Dump
-- version 5.2.1deb3
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : mer. 14 jan. 2026 à 11:14
-- Version du serveur : 8.0.44-0ubuntu0.24.04.2
-- Version de PHP : 8.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `carte_interactive`
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

--
-- Déchargement des données de la table `Log`
--

INSERT INTO `Log` (`id_log`, `temps`, `type`, `id_user`) VALUES
(1, '10:31:09', 'Account Creation', 1),
(2, '10:32:06', 'Login', 1),
(3, '10:33:52', 'Login', 1);

-- --------------------------------------------------------

--
-- Structure de la table `Login`
--

CREATE TABLE `Login` (
  `id_user` int NOT NULL,
  `mdp` text,
  `email` text,
  `admin` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `Login`
--

INSERT INTO `Login` (`id_user`, `mdp`, `email`, `admin`) VALUES
(1, '$2y$10$syBxd9QVxwTX3l0koNzIWudKi/dQ5t6V7XgdBg.Y9e9wlmyDnIt/u', 'leobodinleo@gmail.com', 1);

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
