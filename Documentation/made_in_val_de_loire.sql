-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : lun. 03 nov. 2025 à 07:53
-- Version du serveur : 8.0.31
-- Version de PHP : 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `made_in_val_de_loire`
--
CREATE DATABASE IF NOT EXISTS `made_in_val_de_loire` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `made_in_val_de_loire`;

-- --------------------------------------------------------

--
-- Structure de la table `activite`
--

DROP TABLE IF EXISTS `activite`;
CREATE TABLE IF NOT EXISTS `activite` (
  `numero` int NOT NULL AUTO_INCREMENT,
  `libelle` varchar(20) NOT NULL,
  `verrouillage` tinyint DEFAULT NULL,
  `image` varchar(50) NOT NULL,
  `malveillant` tinyint DEFAULT NULL,
  `difficulte_numero` int DEFAULT NULL,
  `salle_numero` int DEFAULT NULL,
  `auteur_numero` int DEFAULT NULL,
  `type_numero` int DEFAULT NULL,
  `explication_numero` int DEFAULT NULL,
  PRIMARY KEY (`numero`),
  KEY `auteur_ibfk_1` (`auteur_numero`),
  KEY `difficulte_ibfk_1` (`difficulte_numero`),
  KEY `explication_ibfk_1` (`explication_numero`),
  KEY `salle_ibfk_2` (`salle_numero`),
  KEY `type_ibfk_1` (`type_numero`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `auteur`
--

DROP TABLE IF EXISTS `auteur`;
CREATE TABLE IF NOT EXISTS `auteur` (
  `numero` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `prenom` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `fonction_role` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`numero`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `avoir_indice`
--

DROP TABLE IF EXISTS `avoir_indice`;
CREATE TABLE IF NOT EXISTS `avoir_indice` (
  `activite_numero` int NOT NULL,
  `indice_numero` int NOT NULL,
  PRIMARY KEY (`activite_numero`,`indice_numero`),
  KEY `indice_ibfk_1` (`indice_numero`),
  KEY `activite_numero` (`activite_numero`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `avoir_zone`
--

DROP TABLE IF EXISTS `avoir_zone`;
CREATE TABLE IF NOT EXISTS `avoir_zone` (
  `zone_numero` int NOT NULL,
  `activite_numero` int NOT NULL,
  PRIMARY KEY (`zone_numero`,`activite_numero`),
  KEY `activite_ibfk_7` (`activite_numero`),
  KEY `zone_numero` (`zone_numero`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `carte`
--

DROP TABLE IF EXISTS `carte`;
CREATE TABLE IF NOT EXISTS `carte` (
  `numero` int NOT NULL AUTO_INCREMENT,
  `image` varchar(50) NOT NULL,
  `explication` text NOT NULL,
  `activite_numero` int DEFAULT NULL,
  PRIMARY KEY (`numero`),
  KEY `activite_ibfk_1` (`activite_numero`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `difficulte`
--

DROP TABLE IF EXISTS `difficulte`;
CREATE TABLE IF NOT EXISTS `difficulte` (
  `numero` int NOT NULL AUTO_INCREMENT,
  `libelle` varchar(10) NOT NULL,
  PRIMARY KEY (`numero`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `erreur`
--

DROP TABLE IF EXISTS `erreur`;
CREATE TABLE IF NOT EXISTS `erreur` (
  `numero` int NOT NULL AUTO_INCREMENT,
  `mot_incorrect` varchar(50) NOT NULL,
  `explication` text NOT NULL,
  `activite_numero` int DEFAULT NULL,
  PRIMARY KEY (`numero`),
  KEY `activite_ibfk_3` (`activite_numero`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `explication`
--

DROP TABLE IF EXISTS `explication`;
CREATE TABLE IF NOT EXISTS `explication` (
  `numero` int NOT NULL AUTO_INCREMENT,
  `libelle` text NOT NULL,
  PRIMARY KEY (`numero`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `indice`
--

DROP TABLE IF EXISTS `indice`;
CREATE TABLE IF NOT EXISTS `indice` (
  `numero` int NOT NULL AUTO_INCREMENT,
  `libelle` text NOT NULL,
  PRIMARY KEY (`numero`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `mascotte`
--

DROP TABLE IF EXISTS `mascotte`;
CREATE TABLE IF NOT EXISTS `mascotte` (
  `numero` int NOT NULL AUTO_INCREMENT,
  `image` varchar(50) NOT NULL,
  `humeur` varchar(20) NOT NULL,
  `salle_numero` int DEFAULT NULL,
  PRIMARY KEY (`numero`),
  KEY `salle_ibfk_3` (`salle_numero`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `mode_emploi`
--

DROP TABLE IF EXISTS `mode_emploi`;
CREATE TABLE IF NOT EXISTS `mode_emploi` (
  `numero` int NOT NULL AUTO_INCREMENT,
  `explication_1` text NOT NULL,
  `explication_2` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `explication_3` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `activite_numero` int DEFAULT NULL,
  PRIMARY KEY (`numero`),
  KEY `activite_ibfk_2` (`activite_numero`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `proposer_vpn`
--

DROP TABLE IF EXISTS `proposer_vpn`;
CREATE TABLE IF NOT EXISTS `proposer_vpn` (
  `vpn_numero` int NOT NULL,
  `activite_numero` int NOT NULL,
  `bonne_reponse` tinyint NOT NULL COMMENT '1 = true et 0 = false',
  PRIMARY KEY (`vpn_numero`,`activite_numero`),
  KEY `activite_ibfk_4` (`activite_numero`),
  KEY `vpn_numero` (`vpn_numero`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `proposer_wifiModel`
--

DROP TABLE IF EXISTS `proposer_wifi`;
CREATE TABLE IF NOT EXISTS `proposer_wifi` (
  `wifi_numero` int NOT NULL,
  `activite_numero` int NOT NULL,
  `bonne_reponse` tinyint NOT NULL,
  `zone_clique` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`wifi_numero`,`activite_numero`),
  KEY `activite_ibfk_5` (`activite_numero`),
  KEY `wifi_numero` (`wifi_numero`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `salle`
--

DROP TABLE IF EXISTS `salle`;
CREATE TABLE IF NOT EXISTS `salle` (
  `numero` int NOT NULL AUTO_INCREMENT,
  `libelle` varchar(20) NOT NULL,
  `bouton` varchar(20) NOT NULL,
  PRIMARY KEY (`numero`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `type`
--

DROP TABLE IF EXISTS `type`;
CREATE TABLE IF NOT EXISTS `type` (
  `numero` int NOT NULL AUTO_INCREMENT,
  `libelle` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `explication` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`numero`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `vpn`
--

DROP TABLE IF EXISTS `vpn`;
CREATE TABLE IF NOT EXISTS `vpn` (
  `numero` int NOT NULL AUTO_INCREMENT,
  `libelle` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`numero`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `wifi`
--

DROP TABLE IF EXISTS `wifi`;
CREATE TABLE IF NOT EXISTS `wifi` (
  `numero` int NOT NULL AUTO_INCREMENT,
  `public` tinyint NOT NULL,
  `chiffrement` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`numero`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `zone`
--

DROP TABLE IF EXISTS `zone`;
CREATE TABLE IF NOT EXISTS `zone` (
  `numero` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `coordonnees` varchar(50) NOT NULL,
  `bonne_reponse` tinyint NOT NULL,
  PRIMARY KEY (`numero`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `activite`
--
ALTER TABLE `activite`
  ADD CONSTRAINT `auteur_ibfk_1` FOREIGN KEY (`auteur_numero`) REFERENCES `auteur` (`numero`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `difficulte_ibfk_1` FOREIGN KEY (`difficulte_numero`) REFERENCES `difficulte` (`numero`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `explication_ibfk_1` FOREIGN KEY (`explication_numero`) REFERENCES `explication` (`numero`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `salle_ibfk_2` FOREIGN KEY (`salle_numero`) REFERENCES `salle` (`numero`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `type_ibfk_1` FOREIGN KEY (`type_numero`) REFERENCES `type` (`numero`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Contraintes pour la table `avoir_indice`
--
ALTER TABLE `avoir_indice`
  ADD CONSTRAINT `activite_ibfk_6` FOREIGN KEY (`activite_numero`) REFERENCES `activite` (`numero`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `indice_ibfk_1` FOREIGN KEY (`indice_numero`) REFERENCES `indice` (`numero`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Contraintes pour la table `avoir_zone`
--
ALTER TABLE `avoir_zone`
  ADD CONSTRAINT `activite_ibfk_7` FOREIGN KEY (`activite_numero`) REFERENCES `activite` (`numero`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `zone_ibfk_1` FOREIGN KEY (`zone_numero`) REFERENCES `zone` (`numero`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Contraintes pour la table `carte`
--
ALTER TABLE `carte`
  ADD CONSTRAINT `activite_ibfk_1` FOREIGN KEY (`activite_numero`) REFERENCES `activite` (`numero`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Contraintes pour la table `erreur`
--
ALTER TABLE `erreur`
  ADD CONSTRAINT `activite_ibfk_3` FOREIGN KEY (`activite_numero`) REFERENCES `activite` (`numero`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Contraintes pour la table `mascotte`
--
ALTER TABLE `mascotte`
  ADD CONSTRAINT `salle_ibfk_3` FOREIGN KEY (`salle_numero`) REFERENCES `salle` (`numero`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Contraintes pour la table `mode_emploi`
--
ALTER TABLE `mode_emploi`
  ADD CONSTRAINT `activite_ibfk_2` FOREIGN KEY (`activite_numero`) REFERENCES `activite` (`numero`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Contraintes pour la table `proposer_vpn`
--
ALTER TABLE `proposer_vpn`
  ADD CONSTRAINT `activite_ibfk_4` FOREIGN KEY (`activite_numero`) REFERENCES `activite` (`numero`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `vpn_ibfk_1` FOREIGN KEY (`vpn_numero`) REFERENCES `vpn` (`numero`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Contraintes pour la table `proposer_wifiModel`
--
ALTER TABLE `proposer_wifi`
  ADD CONSTRAINT `activite_ibfk_5` FOREIGN KEY (`activite_numero`) REFERENCES `activite` (`numero`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `wifi_ibfk_1` FOREIGN KEY (`wifi_numero`) REFERENCES `wifi` (`numero`) ON DELETE RESTRICT ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
