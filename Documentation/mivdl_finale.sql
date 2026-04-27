-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : lun. 22 déc. 2025 à 02:29
-- Version du serveur : 9.1.0
-- Version de PHP : 8.2.26

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

--
-- Création des users
--

-- Admin

CREATE USER IF NOT EXISTS 'adminProjetMIVDL'@'localhost' IDENTIFIED WITH caching_sha2_password BY 'Projet@MIVDL!admin';
GRANT USAGE ON *.* TO 'adminProjetMIVDL'@'localhost';
ALTER USER 'adminProjetMIVDL'@'localhost' REQUIRE NONE WITH MAX_QUERIES_PER_HOUR 0 MAX_CONNECTIONS_PER_HOUR 0 MAX_UPDATES_PER_HOUR 0 MAX_USER_CONNECTIONS 0;
GRANT SELECT, INSERT, UPDATE, DELETE ON `made\_in\_val\_de\_loire`.* TO `adminProjetMIVDL`@`localhost`;

-- Quiz

CREATE USER IF NOT EXISTS 'slam_2026_VDL'@'localhost' IDENTIFIED WITH caching_sha2_password BY 'slam_2026_VDL';
GRANT USAGE ON *.* TO 'slam_2026_VDL'@'localhost';
ALTER USER 'slam_2026_VDL'@'localhost' REQUIRE NONE WITH MAX_QUERIES_PER_HOUR 0 MAX_CONNECTIONS_PER_HOUR 0 MAX_UPDATES_PER_HOUR 0 MAX_USER_CONNECTIONS 0;
GRANT SELECT ON `made\_in\_val\_de\_loire`.* TO 'slam_2026_VDL'@'localhost';


-- --------------------------------------------------------

--
-- Structure de la table `activite`
--

DROP TABLE IF EXISTS `activite`;
CREATE TABLE IF NOT EXISTS `activite` (
  `numero` int NOT NULL AUTO_INCREMENT,
  `libelle` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `verrouillage` tinyint DEFAULT NULL,
  `image` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `malveillant` tinyint DEFAULT NULL,
  `difficulte_numero` int DEFAULT NULL,
  `salle_numero` int DEFAULT NULL,
  `auteur_numero` int DEFAULT NULL,
  `type_numero` int DEFAULT NULL,
  `explication_numero` int DEFAULT NULL,
  `width_img` int DEFAULT NULL,
  `height_img` int DEFAULT NULL,
  PRIMARY KEY (`numero`),
  KEY `auteur_ibfk_1` (`auteur_numero`),
  KEY `difficulte_ibfk_1` (`difficulte_numero`),
  KEY `explication_ibfk_1` (`explication_numero`),
  KEY `salle_ibfk_2` (`salle_numero`),
  KEY `type_ibfk_1` (`type_numero`)
) ENGINE=InnoDB AUTO_INCREMENT=603 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `activite`
--

INSERT INTO `activite` (`numero`, `libelle`, `verrouillage`, `image`, `malveillant`, `difficulte_numero`, `salle_numero`, `auteur_numero`, `type_numero`, `explication_numero`, `width_img`, `height_img`) VALUES
(101, 'Bonjour, je suis Jean-Michel Dupuis du service informatique centrale. Nous avons detecté une intrusion urgente dans votre compte. Pour éviter une coupure immediate merci de m\'envoyer votre mot-de-passe personnel ainsi que votre identifiant bancaire pour vérification. Vous devez répondre dans les 5 minutes sinon votre accès entreprise sera definitivement supprimé.', 0, 'monstre1.webp', 1, 1, 1, 101, NULL, 101, NULL, NULL),
(102, 'Madame, Monsieur, votre système informatique presente une vulnérabilité critique notre équipe de securité a identifié un virus dangereux. Cliquez immédiatement sur ce lien pour télécharger notre logiciel de protection gratuit attention, si vous n\'agissez pas maintenant vos données personnelles seront compromises dans moins d\'une heure.', 0, 'monstre1.webp', 1, 1, 1, 102, NULL, 101, NULL, NULL),
(103, 'Cher client, nous avons remarqué une transaction suspecte de 1500 euros sur votre compte bancaire. Pour annuler cette opération frauduleuse, veuillez confirmer votre numéro de carte bleue et votre code confidentiel en cliquant ici Cette verification est obligatoire pour proteger votre argent.', 0, 'monstre1.webp', 1, 1, 1, 103, NULL, 101, NULL, NULL),
(104, 'Bonjour, je suis Marc Dubois du service informatique. Nous avons détecté une activité suspecte sur votre compte professionnel. Pour des raisons de sécurité, vous devez impérativement nous communiquer votre mot-de-passe dans les 30min . Cliquez immédiatement sur ce lien pour vérifier votre identité sinon votre accès sera définitivement bloqué et vos fichiers seront supprimés', 0, 'monstre1.webp', 1, 1, 1, 104, NULL, 101, NULL, NULL),
(105, 'Cher client, nous avons remarqué une transaction inhabituelle de 1500 euros sur votre compte. Pour votre sécurité, nous avons temporairement bloqué votre carte bancaire. Merci de confirmer rapidement vos informations personnelles incluant votre numéro de carte complète, votre code-secret et votre date de naissance en cliquant sur le lien ci-joint  Cette vérification est obligatoire pour débloquer votre compte avant ce soir.', 0, 'monstre1.webp', 1, 1, 1, 105, NULL, 101, NULL, NULL),
(106, 'Votre colis est actuellement bloqué dans notre centre de distribution. Pour éviter son retour à l\'expéditeur, vous devez régler des frais de douane de 2,99$ immédiatement Cliquez sur ce lien sécurisé pour payer en ligne avec votre carte-bancaire Sans action de votre part sous 48h votre commande sera automatiquement annulée et perdue définitivement', 0, 'monstre1.webp', 1, 1, 1, 108, NULL, 101, NULL, NULL),
(107, 'Service des impôts : Vous avez un remboursement de 327,50$ en attente. Suite à une erreur de calcul dans votre dernière déclaration, notre système a généré automatiquement un crédit d\'impôt en votre faveur. Pour recevoir ce montant rapidement sur votre compte, veuillez confirmer vos coordonnées bancaires complètes en cliquant ici. Ce remboursement expire dans 7 jours.', 0, 'monstre1.webp', 1, 1, 1, 111, NULL, 101, NULL, NULL),
(108, 'Amazon Service Client : Une activité inhabituelle a été détectée sur votre compte Prime. Quelqu\'un a tenté de passer une commande de 899$ depuis un appareil inconnu Par mesure de précaution, votre compte a été suspendu Cliquez ici pour vérifier cette transaction et réactiver immédiatement votre accès en confirmant votre mot-de-passe et vos informations de paiement', 0, 'monstre1.webp', 1, 1, 1, 108, NULL, 101, NULL, NULL),
(109, 'Alerte de sécurité Apple : Votre identifiant Apple a été utilisé pour se connecter sur un iPhone inconnu en Chine. Si ce n\'était pas vous, votre compte iCloud risque d\'être piraté et toutes vos photos personnelles pourraient être publiées publiquement. Sécurisez immédiatement votre compte en cliquant ici pour changer votre mot de passe Apple et vos questions secrètes de sécurité.', 0, 'monstre1.webp', 1, 1, 1, 113, NULL, 101, NULL, NULL),
(110, 'Caisse d\'Allocations Familiales : Vous êtes éligible à une aide exceptionnelle de 400$ suite à la nouvelle réforme sociale. Votre dossier a été présélectionné automatiquement par nos services. Pour bénéficier de ce versement urgent, complétez votre demande en ligne en fournissant votre numéro de sécurité-sociale votre situation familiale détaillée et votre relevé d\'identité bancaire. Attention, les fonds seront redistribués dans 5 jours aux premiers inscrits.', 0, 'monstre2.webp', 1, 1, 1, 111, NULL, 101, NULL, NULL),
(301, 'phishing', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 301, NULL, NULL),
(400, 'Entree dans la chambre', 0, NULL, NULL, NULL, 4, NULL, NULL, 400, NULL, NULL),
(401, 'Apres Ransomware', 0, 'frise_reaction_ransomware.png', NULL, NULL, 4, NULL, NULL, 401, NULL, NULL),
(402, 'Avant Ransomware', 0, 'frise_prevention_ransomware.png', NULL, NULL, 4, NULL, NULL, 401, NULL, NULL),
(403, 'Quiz Ransomware', 0, 'quiz_ransomware.png', NULL, NULL, 4, NULL, NULL, 401, NULL, NULL),
(501, 'Poste risqué', NULL, '../images/salle_5/salle_bureau_compil.svg', NULL, NULL, 5, NULL, NULL, 501, 1920, 1080),
(502, 'Clés étranges', NULL, '../images/salle_5/bureau.svg', NULL, NULL, 5, NULL, NULL, 502, 1375, 917),
(503, 'Un oubli risqué', NULL, '../images/salle_5/bureau.svg', NULL, NULL, 5, NULL, NULL, 503, 1375, 917),
(504, 'Le bureau encombré', NULL, '../images/salle_5/bureau.svg', NULL, NULL, 5, NULL, NULL, 504, 1375, 917),
(505, 'La porte entrouverte', NULL, '../images/salle_5/salle_bureau_compil.svg', NULL, NULL, 5, NULL, NULL, 505, 1920, 1080),
(506, 'Écrans non sécurisés', NULL, '../images/salle_5/salle_bureau_compil.svg', NULL, NULL, 5, NULL, 402, 506, 1920, 1080),
(507, 'Fenêtre ouverte', NULL, '../images/salle_5/salle_bureau_compil.svg', NULL, NULL, 5, NULL, 1, 507, 1920, 1080),
(508, 'Poste « clean desk »', NULL, '../images/salle_5/bureau.svg', NULL, NULL, 5, NULL, NULL, 508, 1375, 917),
(509, 'Secrets physiques', NULL, '../images/salle_5/bureau.svg', NULL, NULL, 5, NULL, 1, 509, 1375, 917),
(510, 'Caméra interne', NULL, '../images/salle_5/salle_bureau_compil.svg', NULL, NULL, 5, NULL, NULL, 510, 1920, 1080),
(601, 'Choisir le bon WiFi', NULL, 'wifi_activity.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(602, 'VPN', NULL, 'temp.svg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `activite_message`
--

DROP TABLE IF EXISTS `activite_message`;
CREATE TABLE IF NOT EXISTS `activite_message` (
  `id` int NOT NULL AUTO_INCREMENT,
  `activite_numero` int NOT NULL,
  `type_message` enum('succes','echec') NOT NULL,
  `message` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `activite_numero` (`activite_numero`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `activite_message`
--

INSERT INTO `activite_message` (`id`, `activite_numero`, `type_message`, `message`) VALUES
(1, 501, 'succes', 'Excellent ! Laisser un poste ouvert permet l\'accès aux données sensibles. Toujours verrouiller (Win+L) !'),
(2, 501, 'echec', 'Échec ! Ce n\'était pas le bon écran à risque, cet écran est vérouillé'),
(3, 502, 'succes', 'Bravo ! Une clé USB inconnue peut contenir un malware (attaque BadUSB).'),
(4, 502, 'echec', 'Raté ! Vous ne pouvez pas être sûr que cette clé USB est sûre. Elle peut contenir un malware !'),
(5, 503, 'succes', 'Parfait ! Un badge d\'entreprise ne doit jamais être laissé sans surveillance.'),
(6, 503, 'echec', 'Incorrect ! Cet objet ne compromet pas directement la sécurité physique.'),
(7, 505, 'succes', 'Excellent ! Les portes doivent être fermées pour éviter les intrusions (tailgating).'),
(8, 505, 'echec', 'Mauvaise réponse ! La porte entrouverte permet le tailgating. Une porte doit toujours être fermée !'),
(9, 506, 'succes', 'Bravo ! Le shoulder-surfing est un risque physique simple à exploiter.'),
(10, 506, 'echec', 'Échec ! Ce n\'est pas la bonne protection contre l\'épaule-surfing. Un filtre de confidentialité est nécessaire !'),
(11, 507, 'succes', 'Parfait ! La sécurité physique inclut aussi les ouvrants (risque de vol).'),
(12, 507, 'echec', 'Raté ! Cette action n\'est pas une contre-mesure efficace.'),
(13, 509, 'succes', 'Super ! Les secrets physiques ne doivent jamais être affichés et les MDP doivent être forts.\n'),
(14, 509, 'echec', 'Incorrect ! Vous n\'avez pas identifié les bonnes erreurs.'),
(15, 510, 'succes', 'Bien vu ! Sûreté ≠ espionnage interne ; respecter le principe de proportionnalité.'),
(16, 510, 'echec', 'Mauvaise réponse ! Une caméra de surveillance interne peut poser des problèmes de conformité RGPD. Sûreté ≠ espionnage ; respectez la proportionnalité !'),
(17, 504, 'succes', 'Bien vu ! Les informations confidentielles ne doivent jamais être visibles.'),
(18, 504, 'echec', 'Dommage ! Cette zone ne présente pas d\'informations confidentielles visible. Cherchez des post-it ou documents sensibles !'),
(19, 508, 'succes', 'Ce terme désigne une approche systématique visant à garantir la sécurité des données sensibles et la confidentialité des informations critiques pour l\'entreprise.\n'),
(20, 508, 'echec', 'Incorrect ! Ce n\'est pas une violation de la politique \"clean desk\". Un bureau propre ne doit avoir AUCUN document, carnet de mots de passe ou clé USB visible.');

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
) ENGINE=InnoDB AUTO_INCREMENT=114 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `auteur`
--

INSERT INTO `auteur` (`numero`, `nom`, `prenom`, `fonction_role`) VALUES
(101, 'Dupuis', 'Jean-Michel', 'Technicien informati'),
(102, 'Martin', 'Louis', 'Support de livraison'),
(103, 'Delasource', 'Carine', 'DRH'),
(104, 'Dubois', 'Marc', 'Service Informatique'),
(105, 'Martin', 'Sophie', 'Directrice des Resso'),
(106, 'Lefebvre', 'Jean', 'Conseiller Bancaire'),
(107, 'Bernard', 'Claire', 'Support Technique Mi'),
(108, 'Petit', 'Thomas', 'Service Client Amazo'),
(109, 'Robert', 'Marie', 'Sécurité Informatiqu'),
(110, 'Richard', 'Paul', 'Service de Livraison'),
(111, 'Durand', 'Julie', 'Administration Fisca'),
(112, 'Moreau', 'Lucas', 'Service Recrutement'),
(113, 'Laurent', 'Emma', 'Support Technique Ap');

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

--
-- Déchargement des données de la table `avoir_indice`
--

INSERT INTO `avoir_indice` (`activite_numero`, `indice_numero`) VALUES
(301, 301),
(301, 302),
(502, 302),
(301, 303),
(301, 304),
(400, 400);

-- --------------------------------------------------------

--
-- Structure de la table `avoir_rep`
--

DROP TABLE IF EXISTS `avoir_rep`;
CREATE TABLE IF NOT EXISTS `avoir_rep` (
  `objet_id` int NOT NULL,
  `activite_numero` int NOT NULL,
  PRIMARY KEY (`objet_id`,`activite_numero`),
  KEY `activite_ibfk_7` (`activite_numero`),
  KEY `objets_ibfk_7` (`objet_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `avoir_rep`
--

INSERT INTO `avoir_rep` (`objet_id`, `activite_numero`) VALUES
(26, 501),
(9, 502),
(12, 503),
(14, 504),
(15, 504),
(28, 505),
(40, 506),
(31, 507),
(34, 507),
(15, 508),
(18, 508),
(19, 508),
(22, 509),
(24, 509),
(25, 509),
(35, 510);

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

--
-- Déchargement des données de la table `avoir_zone`
--

INSERT INTO `avoir_zone` (`zone_numero`, `activite_numero`) VALUES
(15, 501),
(45, 502),
(57, 503),
(61, 504),
(63, 504),
(19, 505),
(35, 506),
(37, 507),
(43, 507),
(49, 508),
(59, 508),
(63, 508),
(67, 509),
(71, 509),
(73, 509),
(1, 510);

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
  `explication_piege` text,
  `type_carte` varchar(20) DEFAULT 'bonne_pratique',
  PRIMARY KEY (`numero`),
  KEY `activite_ibfk_1` (`activite_numero`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `carte`
--

INSERT INTO `carte` (`numero`, `image`, `explication`, `activite_numero`, `explication_piege`, `type_carte`) VALUES
(1, 'carte_pins_01.png', 'Isolez immédiatement les machines infectéess', 401, NULL, 'bonne_pratique'),
(2, 'carte_pins_02.png', 'Prévenez l\'équipe de sécurité', 401, NULL, 'bonne_pratique'),
(3, 'carte_pins_03.png', 'Identifiez l\'étendue de l\'attaque', 401, NULL, 'bonne_pratique'),
(4, 'carte_pins_04.png', 'Nettoyez les systèmes', 401, NULL, 'bonne_pratique'),
(5, 'carte_pins_05.png', 'Restaurez depuis des sauvegardes', 401, NULL, 'bonne_pratique'),
(6, 'carte_pins_07.png', 'Changez tous les mots de passe', 401, NULL, 'bonne_pratique'),
(9, 'carte_pins_01.png', 'Installez un antivirus performant', 402, NULL, 'bonne_pratique'),
(10, 'carte_pins_02.png', 'Maintenez vos systèmes à jour', 402, NULL, 'bonne_pratique'),
(11, 'carte_pins_03.png', 'Effectuez des sauvegardes régulières', 402, NULL, 'bonne_pratique'),
(12, 'carte_pins_04.png', 'Formez les utilisateurs aux menaces', 402, NULL, 'bonne_pratique'),
(13, 'carte_pins_05.png', 'Filtrez les emails et pièces jointes', 402, NULL, 'bonne_pratique'),
(14, 'carte_pins_06.png', 'Limitez les droits administrateur', 402, NULL, 'bonne_pratique'),
(15, 'carte_pins_07.png', 'Configurez des mots de passe complexes de 25 caractères', 402, 'Trop complexe : les utilisateurs vont les noter sur papier ou les oublier', 'piege'),
(16, 'carte_pins_08.png', 'Bloquez toutes les pièces jointes emails', 402, 'Trop restrictif : empêche le travail collaboratif normal', 'piege'),
(17, 'carte_pins_01.png', 'Changez les mots de passe chaque semaine', 402, 'Trop fréquent : favorise les mots de passe faibles et prévisibles', 'piege'),
(18, 'carte_pins_02.png', 'Installez 3 antivirus différents', 402, 'Conflits entre logiciels : ralentit le système et crée des faux positifs', 'piege'),
(19, 'carte_pins_03.png', 'Scannez manuellement chaque fichier avant ouverture', 402, 'Irréaliste au quotidien : les utilisateurs vont contourner cette contrainte', 'piege'),
(20, 'carte_pins_04.png', 'Interdisez l\'accès à Internet', 402, 'Trop radical : empêche le travail et les mises à jour de sécurité', 'piege'),
(21, 'carte_pins_08.png', 'Sauvegardez uniquement sur disques durs externes', 402, 'Risque de perte/vol : pas de rotation, pas de tests de restauration', 'piege'),
(22, 'carte_pins_02.png', 'Désactivez les mises à jour automatiques', 402, 'Crée des failles : les correctifs de sécurité ne sont pas appliqués', 'piege'),
(23, 'carte_pins_07.png', 'Cryptez tous les fichiers systèmes', 402, 'Risque de blocage : peut empêcher le démarrage du système', 'piege'),
(24, 'carte_pins_08.png', 'Formez uniquement les cadres dirigeants', 402, 'Protection incomplète : les autres employés restent vulnérables au phishing', 'piege');

-- --------------------------------------------------------

--
-- Structure de la table `difficulte`
--

DROP TABLE IF EXISTS `difficulte`;
CREATE TABLE IF NOT EXISTS `difficulte` (
  `numero` int NOT NULL AUTO_INCREMENT,
  `libelle` varchar(10) NOT NULL,
  PRIMARY KEY (`numero`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `difficulte`
--

INSERT INTO `difficulte` (`numero`, `libelle`) VALUES
(1, 'Facile');

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
) ENGINE=InnoDB AUTO_INCREMENT=72 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `erreur`
--

INSERT INTO `erreur` (`numero`, `mot_incorrect`, `explication`, `activite_numero`) VALUES
(1, 'urgente', 'L\'utilisation de l\'urgence est une technique de manipulation pour vous faire agir sans réfléchir.', 101),
(2, 'immediate', 'Les vrais services informatiques ne demandent jamais d\'action immédiate par email.', 101),
(3, 'mot-de-passe', 'JAMAIS un service légitime ne vous demandera votre mot de passe par email !', 101),
(4, 'bancaire', 'Le service informatique n\'a aucune raison de vous demander des informations bancaires.', 101),
(5, 'definitivement', 'La menace de suppression définitive est utilisée pour créer la panique.', 101),
(6, 'critique', 'Créer un sentiment d\'urgence critique pour vous pousser à agir rapidement.', 102),
(7, 'immédiatement', 'Les vraies alertes de sécurité ne demandent jamais d\'action immédiate non vérifiée.', 102),
(8, 'gratuit', 'Méfiez-vous des logiciels \"gratuits\" proposés dans des emails non sollicités.', 102),
(9, 'maintenant', 'Pression temporelle pour éviter que vous ne vérifiiez la légitimité du message.', 102),
(10, 'compromises', 'Menace vague pour créer la peur sans donner de détails précis.', 102),
(11, 'suspecte', 'Les vraies banques vous appellent ou utilisent leur application sécurisée.', 103),
(12, 'carte', 'Aucune banque ne demande votre numéro de carte complet par email.', 103),
(13, 'code', 'Le code confidentiel ne doit JAMAIS être communiqué à quiconque.', 103),
(14, 'obligatoire', 'Fausse obligation pour vous forcer à agir.', 103),
(15, 'ici', 'Lien cliquable suspect qui mène probablement vers un faux site.', 103),
(16, 'suspecte', 'Créer un sentiment de danger pour vous faire agir rapidement sans réfléchir.', 104),
(17, 'impérativement', 'L\'urgence extrême est une technique classique de manipulation pour court-circuiter votre jugement.', 104),
(18, 'mot-de-passe', 'JAMAIS une entreprise légitime ne vous demandera votre mot de passe par email ou message.', 104),
(19, '30min', 'La pression temporelle précise vise à vous paniquer et vous empêcher de vérifier la légitimité du message.', 104),
(20, 'immédiatement', 'Ce mot renforce l\'urgence artificielle pour vous pousser à cliquer sans réfléchir.', 104),
(21, 'définitivement', 'Les menaces de conséquences irréversibles sont utilisées pour créer la peur et forcer une action rapide.', 104),
(22, 'supprimés', 'Menace de perte de données pour amplifier la panique et vous forcer à agir impulsivement.', 104),
(23, 'inhabituelle', 'Créer un doute sur une activité normale pour justifier une demande suspecte.', 105),
(24, 'temporairement', 'Annonce un blocage fictif pour créer l\'urgence et justifier les demandes qui suivent.', 105),
(25, 'rapidement', 'Pression temporelle pour vous empêcher de contacter votre vraie banque et vérifier.', 105),
(26, 'carte', 'Une banque ne demande JAMAIS le numéro complet de votre carte par email ou message.', 105),
(27, 'code-secret', 'AUCUNE institution financière ne demande votre code PIN - c\'est la règle d\'or de la sécurité bancaire.', 105),
(28, 'naissance', 'Demande d\'informations personnelles sensibles utilisables pour l\'usurpation d\'identité.', 105),
(29, 'ci-joint', 'Lien suspect qui mène probablement vers un faux site imitant celui de votre banque.', 105),
(30, 'obligatoire', 'Fausse obligation pour vous forcer à agir sans vérifier la légitimité de la demande.', 105),
(31, 'bloqué', 'Situation de blocage inventée pour justifier une demande d\'argent urgente.', 106),
(32, 'retour', 'Menace de perdre le colis pour créer l\'urgence et justifier le paiement immédiat.', 106),
(33, '2,99$', 'Petite somme pour sembler légitime mais c\'est surtout vos données bancaires qui sont visées.', 106),
(34, 'immédiatement', 'Urgence pour vous empêcher de vérifier auprès du vrai service de livraison.', 106),
(35, 'sécurisé', 'Fausse garantie de sécurité pour vous rassurer alors que le lien est frauduleux.', 106),
(36, 'carte-bancaire', 'Demande de paiement par lien suspect - les vrais transporteurs utilisent d\'autres moyens.', 106),
(37, '48h', 'Délai court pour vous presser et vous empêcher de contacter le vrai service.', 106),
(38, 'définitivement', 'Menace de perte irréversible pour amplifier la peur et forcer l\'action immédiate.', 106),
(39, 'remboursement', 'Appât financier pour vous attirer - les vrais remboursements sont notifiés officiellement par courrier.', 107),
(40, '327,50$', 'Montant précis pour donner une fausse crédibilité - un vrai remboursement serait notifié différemment.', 107),
(41, 'erreur', 'Prétexte inventé pour justifier un remboursement surprise et non sollicité.', 107),
(42, 'automatiquement', 'Excuse pour l\'envoi non sollicité - les impôts ne fonctionnent pas ainsi par email.', 107),
(43, 'rapidement', 'Promesse de vitesse pour vous inciter à agir vite sans vérifier.', 107),
(44, 'bancaires', 'Les impôts ont déjà votre RIB - ils ne le redemandent JAMAIS par email.', 107),
(45, 'expire', 'Fausse date limite pour créer l\'urgence - un vrai remboursement ne \"expire\" pas ainsi.', 107),
(46, 'inhabituelle', 'Alerte fictive pour créer le doute et justifier les demandes suspectes qui suivent.', 108),
(47, 'détectée', 'Fausse détection technique pour donner une crédibilité au message frauduleux.', 108),
(48, 'tenté', 'Scénario d\'attaque inventé pour vous faire paniquer et agir rapidement.', 108),
(49, '899$', 'Montant élevé pour maximiser la peur d\'une fraude sur votre compte.', 108),
(50, 'inconnu', 'Détail technique pour renforcer la crédibilité de la fausse alerte de sécurité.', 108),
(51, 'suspendu', 'Blocage fictif de compte pour créer l\'urgence et justifier la demande d\'informations.', 108),
(52, 'vérifier', 'Prétexte pour vous faire cliquer sur un lien malveillant déguisé en outil de vérification.', 108),
(53, 'mot-de-passe', 'Amazon ne demande JAMAIS de confirmer votre mot de passe par email ou lien.', 108),
(54, 'paiement', 'Demande de données bancaires - Amazon les a déjà et ne les redemande jamais ainsi.', 108),
(55, 'inconnu', 'Appareil fictif pour créer le doute et justifier l\'alerte de sécurité frauduleuse.', 109),
(56, 'Chine', 'Localisation étrangère pour amplifier le sentiment de menace et de piratage.', 109),
(57, 'piraté', 'Terme alarmiste pour créer la panique maximale et vous faire agir sans réfléchir.', 109),
(58, 'personnelles', 'Menace sur votre vie privée pour toucher vos émotions et créer la peur.', 109),
(59, 'publiées', 'Conséquence dramatique inventée pour maximiser votre panique et urgence d\'agir.', 109),
(60, 'publiquement', 'Amplification de la menace sur votre réputation pour forcer une action immédiate.', 109),
(61, 'immédiatement', 'Urgence extrême pour court-circuiter votre réflexion et vous faire cliquer.', 109),
(62, 'secrètes', 'Apple ne demande JAMAIS de changer vos questions de sécurité via un lien email.', 109),
(63, 'éligible', 'Vous faire croire que vous avez droit à quelque chose pour vous inciter à donner vos informations.', 110),
(64, 'exceptionnelle', 'Aide \"spéciale\" inventée pour rendre l\'offre unique et urgente.', 110),
(65, '400$', 'Montant attractif mais réaliste pour sembler crédible - les vraies aides sont notifiées officiellement.', 110),
(66, 'présélectionné', 'Flatterie pour vous faire sentir privilégié et baisser votre vigilance.', 110),
(67, 'automatiquement', 'Prétexte pour l\'envoi non sollicité - la CAF ne fonctionne pas ainsi.', 110),
(68, 'urgent', 'Création d\'urgence artificielle pour vous presser et éviter que vous vérifiiez.', 110),
(69, 'sécurité-sociale', 'Information ultra-sensible - la CAF l\'a déjà et ne la redemande JAMAIS par email.', 110),
(70, 'détaillée', 'Demande excessive d\'informations personnelles pour usurpation d\'identité potentielle.', 110),
(71, 'premiers', 'Fausse rareté pour créer la compétition et vous pousser à agir vite sans réfléchir.', 110);

-- --------------------------------------------------------

--
-- Structure de la table `explication`
--

DROP TABLE IF EXISTS `explication`;
CREATE TABLE IF NOT EXISTS `explication` (
  `numero` int NOT NULL AUTO_INCREMENT,
  `libelle` text NOT NULL,
  PRIMARY KEY (`numero`)
) ENGINE=InnoDB AUTO_INCREMENT=605 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `explication`
--

INSERT INTO `explication` (`numero`, `libelle`) VALUES
(1, 'Il y a <strong> des étapes </strong> : le but est de trouver les mots de passe à travers des <strong>indices cachés</strong>'),
(2, 'Étape : Ouvrir la porte à l’aide du code fourni par le détective Fox afin d’entrer dans la salle.'),
(4, 'Étape : Essaie d\'ouvrir ce coffre avec un code à 6 chiffres. Attention, sois attentif aux éléments dans la pièce !\n'),
(5, 'Récupère cette mallette qui était dans le coffre. Attention, elle pourrait être ouverte.\r\n'),
(6, 'Étape : Crée un code Sécurisé pour la malette. Elle te donnera des informations précieuses !\n'),
(7, 'Étape : Trouve le mot de passe du téléphone pour permettre de trouver des informations cruciales !\n'),
(8, 'Étape : Classe les mots de passe sur la feuille (valides) et dans la poubelle (invalides), puis valide.'),
(9, '      Bienvenue dans la salle des mots de passe…<br></br>\n\n            Les mots de passe doivent obligatoirement être complexes !'),
(11, 'Bienvenue dans la salle des mots de passe…<br></br>\n\n            Sauras-tu trouver les mots de passe dans les différentes étapes ?'),
(12, 'Il y a <strong> des étapes </strong> : le but est de trouver les mots de passe à travers des <strong>indices cachés</strong> <br></br>\n\n<strong> Imaginez </strong> qu’un mot de passe se <strong> trouve </strong> sur cette page !<br></br>\n\n D7ns le m8noir pl9ngé dans le <strong>mystère</strong>, un m5t de p4sse se c6che parmi les <strong>ombres</strong>\n'),
(13, 'Il y a <strong> des étapes </strong> : le but est de trouver les mots de passe à travers des <strong>indices cachés</strong> <br></br>\n\n<strong> Imaginez </strong> qu’un mot de passe se <strong> trouve </strong> sur cette page !<br></br>\n\n D3ans ce m2noir rem1pli de <strong>mystères</strong>, un p4ssage secr5t renferme un m6t de passe oublié. »\n'),
(14, 'Il y a <strong> des étapes </strong> : le but est de trouver les mots de passe à travers des <strong>indices cachés</strong> <br></br>\n\n<strong> Imaginez </strong> qu’un mot de passe se <strong> trouve </strong> sur cette page !<br></br>\n\n D9ns le m1noir où s2 cachent d3s <strong> secrets</strong>, un p6rtail obsc4r révèle un mystérieux mot de passe. \n'),
(101, 'Le but du jeu est de repérer tous les mots suspects dans la discussion avec le fantôme.\r\nClique sur chaque mot qui te paraît étrange pour avancer dans l’enquête.\r\nAttention, tu es limité dans le temps !\r\nUne fois tous les mots suspects trouvés, un code te sera révélé.\r\nTu pourras alors l’utiliser pour ouvrir la porte… en cliquant sur le cadenas situé en face de toi.\r\n\r\nBonne chance !'),
(301, 'Cliquez sur les enveloppes et étudiez les pour déterminer s\'il s\'agit d\'un mail frauduleux ou légitime.'),
(400, 'Accueil Ransomware'),
(401, 'Ton système a subi une attaque par ransomware et tes fichiers sont chiffrés.\r\nClique sur les cartes dans le bon ordre pour reconstituer la procédure et reprendre le contrôle du système.'),
(402, 'Prépare-toi à faire face aux attaques par ransomware.\nParmi les cartes proposées, identifie et sélectionne les bonnes pratiques de sécurité afin de protéger efficacement ton système.\n'),
(501, 'Laisser un poste ouvert permet à n’importe qui d’accéder à des données sensibles → toujours verrouiller sa session (Win+L / Ctrl+L). '),
(502, 'Une clé USB trouvée peut contenir un malware (attaque \"BadUSB\"). Toujours utiliser du matériel fourni par l’entreprise.'),
(503, 'Un badge d’entreprise est nominatif et doit toujours rester sur soi. Un intrus peut l’utiliser pour pénétrer dans les locaux. '),
(504, 'Rien ne doit être écrit en clair ni laissé visible.'),
(505, 'Les entrées/sorties doivent être surveillées pour éviter l’intrusion d’inconnus (tailgating). '),
(506, 'Comment je peux contrer le shoulder surfing ?'),
(507, 'La sécurité physique, ce sont aussi les ouvrants : opportunité de vol rapide. '),
(508, 'La politique clean desk réduit le risque de perte/vol d’infos. '),
(509, 'Les secrets physiques (codes, badges) ne doivent jamais être affichés. '),
(510, 'Sûreté ≠ espionnage interne ; principe de proportionnalité. '),
(601, 'Hey! C\'est ta première fois dans cette salle ? Si oui clique sur moi pour en savoir plus !!!'),
(602, 'Vous maîtrisez maintenant les concepts de sécurité WiFi et VPN. Vous savez comment identifier les réseaux dangereux et protéger vos données en ligne ! Test\r\n'),
(603, 'Te voila dans le grenier, clique sur le train pour commencer les énigmes. bla bla bla ....'),
(604, 'Dommage, tu n’as pas réussi à valider cette salle… cette fois-ci !\r\nMais ne baisse pas les bras : chaque échec t’aide à mieux comprendre les mécanismes de sécurité et à renforcer tes compétences.\r\nReviens quand tu veux pour retenter l’expérience : la salle t’attend, et je suis sûr que tu finiras par la résoudre !');

-- --------------------------------------------------------

--
-- Structure de la table `indice`
--

DROP TABLE IF EXISTS `indice`;
CREATE TABLE IF NOT EXISTS `indice` (
  `numero` int NOT NULL AUTO_INCREMENT,
  `libelle` text NOT NULL,
  PRIMARY KEY (`numero`)
) ENGINE=InnoDB AUTO_INCREMENT=511 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `indice`
--

INSERT INTO `indice` (`numero`, `libelle`) VALUES
(10, 'Cliquez sur le digicode à côté de la porte pour commencer ! Si vous avez besoin de revoir le code cliquez sur le livre !'),
(11, 'Des chiffres se promènent dans les salles principales. Cherche-les pour trouver le mot de passe ! Attention, ils sont dans l’ordre. '),
(12, 'Regarde, le premier et le dernier chiffre de chaque post-it sont dans le code !\r\n'),
(13, 'Créez un mot de passe sûr en utilisant au moins 12 caractères, incluant des lettres, des chiffres et des symboles spéciaux pour une sécurité maximale !\r\n'),
(14, 'Générez un mot de passe complexe qui dispose de Majuscule , Minuscule , caractère spéciaux !\r\n'),
(15, 'Trie les mots de passe. Il y a 5 mots de passe valides et 6 mots de passe invalides. Attention, certains pourraient sembler valides mais ne le sont pas du tout !\r\n'),
(16, '4897'),
(17, '1123'),
(18, '9875'),
(19, '8745'),
(301, 'Attention à la cohérence du contenu des mails !'),
(302, 'Soyez attentif aux liens transmis dans le contenu !'),
(303, 'Regardez bien les erreurs dans les mails !'),
(304, 'Vérifiez bien les adresses mails des expéditeurs !'),
(400, '<p>\n                    <strong>Zone 1 - Tableau chronologique :</strong> Un tableau est accrochée au-dessus du lit.\n                    Il permet de reproduire la procédure à suivre en cas d\'attaque ou bien de prévention d\'attaque.\n                    Analysez-le pour comprendre comment réagir ou anticiper au mieux.\n                </p>\n                <p>\n                    <strong>Zone 2 - Dossier d\'expertise :</strong> Un dossier de test gît par terre, près du bureau.\n                    Il contient des questions pour évaluer vos connaissances en cybersécurité.\n                    Répondez correctement pour progresser dans l\'enquête.\n                </p>\n                <p>\n                    <strong>Recommandation :</strong> Examinez d\'abord la chronologie pour comprendre l\'attaque,\n                    puis testez vos connaissances avec le dossier d\'expertise.\n                </p>'),
(401, '<ul>\n                            <li>D\'abord, il faut limiter la propagation.</li>\n                            <li>Avant d\'aller plus loin, il faut mettre les spécialistes au courant</li>\n                            <li>Puis analyser les problèmes rencontrés à cause de l\'attaque</li>\n                            <li>Le reste, je vous laisse voir par vous-mêmes !</li>\n                        </ul>'),
(402, 'Questions de logique, vous n\'avez pas besoin d\'indices !'),
(403, '<p>Répondez à 6 questions vrai/faux sur les ransomwares en cliquant sur les cartes.\nChaque carte révèle une question à laquelle vous ne pouvez répondre qu’une seule fois. </p>\n\n<p>Vos réponses sont enregistrées automatiquement et votre score s’affiche en temps réel.\nIl faut au moins 4 bonnes réponses pour valider la salle.\nAucune aide n’est fournie : réfléchissez bien avant de répondre.</p>\n'),
(500, 'Cliquez sur les objets lumineux pour lancer une énigme'),
(501, 'Trop facile, pas besoin d\'indice'),
(502, 'Survolez les clés USB pour avoir plus d\'informations'),
(503, 'Trop facile, pas besoin d\'indice'),
(504, 'Trop facile, pas besoin d\'indice'),
(505, 'Tailgating = entrer sans permissions'),
(506, 'Shoulder surfing = espionner un écran '),
(507, 'Trop facile, pas besoin d\'indice'),
(508, 'Trop facile, pas besoin d\'indice'),
(509, 'Trop facile, pas besoin d\'indice'),
(510, 'Trop facile, pas besoin d\'indice');

-- --------------------------------------------------------

--
-- Structure de la table `mail`
--

DROP TABLE IF EXISTS `mail`;
CREATE TABLE IF NOT EXISTS `mail` (
  `numero` int NOT NULL AUTO_INCREMENT,
  `expediteur` varchar(50) NOT NULL,
  `objet` varchar(100) NOT NULL,
  `contenu` text NOT NULL,
  `phishing` tinyint NOT NULL,
  `difficulte` int DEFAULT NULL,
  PRIMARY KEY (`numero`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `mail`
--

INSERT INTO `mail` (`numero`, `expediteur`, `objet`, `contenu`, `phishing`, `difficulte`) VALUES
(11, 'service.client.apple@gmail.com', 'Échec du paiement', 'Votre paiement d’un montant de 49.99€ a échoué.\r\nVeuillez mettre à jour vos informations de paiement en cliquant sur ce lien : http://achatapple.fr\r\n', 1, 1),
(12, 'sumsung.reward@gmail.com', 'Vous êtes le grand gagnant !', 'Vous êtes le grand gagnant de notre concours pour gagner notre tout dernier iPhone !\r\nPour récupérer votre gain, veuillez nous transmettre vos coordonnées en cliquant sur ce lien : http://collectedonnees.fr/\r\n', 1, 1),
(13, 'admin-it@gmail.com', 'Réinissialisation administrative (action requise)', 'Nous réinissialisons votre compte. veuillez conffirmer en cliquant ici : http://adminphishing.fr/', 1, 1),
(14, 'googueule@newsletters.com', 'Offre spéciale', 'Félicitations ! Vous avez le droit à un coupon. Activez ici : http://googueule.com/coupon', 1, 1),
(15, 'peter.pain@gmail.com', 'Message important', 'vous avez un message important qui vous attend : http://peter.pain.fr/message', 1, 1),
(16, 'linkedout@gmail.com', 'Nouveaux offres postes disponibles', 'nous avont trouver un potentiel nouveau poste de caissier pour toi\r\ndécouvrer le http://linkedout.com/offre/\r\n', 1, 1),
(17, 'macdonalds-france@gmail.com', 'phishing', 'Bonjour,\r\nNous avons récemment constaté une vague de phishing concernant la plupart de nos utilisateurs.\r\nNous vous conseillons de vous sécuriser au plus vite en cliquant sur ce lien : http://phishing.com/\r\n', 1, 1),
(18, 'refunds@marketplace.com', 'Remboursement en attente', 'Bonjour,\r\nUn remboursement vous est dû. Pour le percevoir, indiquez vos coordonnées : http://morketplace.com/\r\nLe Service Remboursement.\r\n', 1, 1),
(19, 'netflix@gmail.com', 'Suspension de votre compte', 'Votre abonnement est temporairement suspendu. Restaurez l’accès en vérifiant vos informations ici : http://netfliix.com/\r\nL’équipe Netflix.\r\n', 1, 1),
(20, 'shipping@colilissimo.fr', 'Problème de livraison', 'Bonjour, \r\nLa livraison de votre colis a échoué. Confirmez vos coordonnées bancaires ici : http://colilissimo.fr/\r\nL’équipe Colissimo.\r\n', 1, 1),
(21, 'no-reply@secure-bank.com', 'Activité inhabituelle détectée', 'Bonjour,\r\nNous avons detecté une connection inhabituelle sur votre compte. Veuillez vérifier immédaitement via : http://secure-bank.com ou votre compte sera bloqué.\r\nMerci,\r\nSécurité SecureBank\r\n', 1, 1),
(22, 'billing@pay-services.com', 'Paiement refusé', 'Bonjour Mme/M.,\r\nVotre dernier paiement a été refusé. Mettez à jour vos informations bancaires via http://pay-services.com/ pour réactiver votre service.\r\nCordialement, Service paiement.\r\n', 1, 1),
(23, 'paypal-service@secure-payments.com', 'Paeiment refusé !', 'Bonjour, votre carte a ete refusee. Si vous ne mettez pas a jour maintenant, votre compte sera supprime. \r\nCliquez : http://paypale.com/\r\n', 1, 1),
(24, 'admin@yourbank-security.net', 'VERIFICATION OBLIGATOIRE (48H)', 'CHER CLIENT,\r\nPOUR VOTRE SECURITE NOUS VERIFIONS VOS DONNEES. REPONDEZ SUR : http://yourbank.com/\r\nMERCI.\r\n', 1, 1),
(25, 'ecole@admin-school.com', 'Convocation examen', 'Vous êtes convoque. Le sujet en pièce jointe : [PIÈCE_JOINTE : sujet.pdf.exe]', 1, 1),
(26, 'contact@assurance-vie.fr', 'Attestation d’assurance ', 'Bonjour,\r\nVotre attestation d’assurance a été générée. Vous pouvez la télécharger depuis votre espace client : https://assurance-maladie.fr/mon-espace/\r\n', 0, NULL),
(27, 'support@free.fr', 'Confirmation de changement d’offre', 'Bonjour,\r\nVotre demande de migration vers l’offre Fibre+ a été prise en compte. Détails et date d’activation dans votre espace client : https://free.fr/mon-espace/\r\n', 0, NULL),
(28, 'contact@mairie-tours.fr', 'Réunion de quartier - Grammont', 'Bonjour,\r\nNous organisons une réunion de quartier à Grammont le 18/11 à 19 :00 à la salle des fêtes. Si vous souhaitez y participer, veuillez nous l’indiquer sur https://maire-tours.fr/reunion-quartier/\r\n', 0, NULL),
(29, 'noreply@indeed.com', 'Nouveau poste disponible – Offre #4521', 'Bonjour,\r\nUne nouvelle offre de poste est disponible et pourrait vous intéresser. Si vous souhaitez en savoir plus, rendez-vous sur https://indeed.com/offres/\r\n', 0, NULL),
(30, 'no-reply@spotify.com', 'Recommandations de concerts à côté de chez vous', 'Bonjour,\r\nDivers évènements d’artistes que vous écoutez sont à venir dans votre région.\r\nPour en savoir plus rendez-vous sur votre espace : https://spotify.com/events/\r\n', 0, NULL),
(31, 'contact@info-news.mcdonalds.fr', 'Mise à jour de la politique d’utilisation', 'Bonjour,\r\nNous mettons à jour la politique d’utilisation du programme de fidélité. Cette mise à jour s’applique sans action de votre part. Si vous souhaitez en savoir plus, vous pouvez les consulter sur https://mcdonalds.fr/politiques/\r\n', 0, NULL),
(32, 'info@autohero.com', 'Nouveaux véhicules disponibles', 'Bonjour,\r\nDe nouveaux véhicules correspondants à votre recherche sont disponibles. Rendez-vous sur https://autohero.com/fr/search/ pour les consulter.\r\n', 0, NULL),
(33, 'no-reply@accounts.google.com', 'Alerte de sécurité', 'Bonjour,\r\nNous avons détecté une nouvelle connexion à votre compte Google. S’il s’agit de vous, aucune action n’est requise. Dans le cas contraire, nous pouvons vous aider à le sécuriser sur https://google.com/accounts/security/\r\n', 0, NULL),
(34, 'paiement@aeroport-orly.fr', 'Paiement refusé – Vol #6893', 'Bonjour,\r\nVous avez récemment tenté d’acheter un billet pour le vol #6893 Orly-Budapest mais votre paiement a été refusé. Si vous souhaitez reprendre un billet, rendez-vous sur https://aeroport-orly.fr/vol6893/.\r\nSi le problème persiste, vous pouvez contacter un assistant sur https://aeroport-orly.fr/support/\r\n', 0, NULL);

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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `mascotte`
--

INSERT INTO `mascotte` (`numero`, `image`, `humeur`, `salle_numero`) VALUES
(1, '/images/commun/mascotte/mascotte_face.svg', 'normale', NULL),
(2, '/images/commun/mascotte/mascotte_face.svg', 'face', NULL),
(3, '/images/commun/mascotte/mascotte_choquee.svg', 'choquee', NULL),
(4, '/images/commun/mascotte/mascotte_exclamee.svg', 'exclamee', NULL),
(5, '/images/commun/mascotte/mascotte_interrogee.svg', 'interrogee', NULL),
(6, '/images/commun/mascotte/mascotte_profil.svg', 'profil', NULL),
(7, '/images/commun/mascotte/mascotte_saoulee.svg', 'saoulee', NULL);

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
) ENGINE=InnoDB AUTO_INCREMENT=5022 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `mode_emploi`
--

INSERT INTO `mode_emploi` (`numero`, `explication_1`, `explication_2`, `explication_3`, `activite_numero`) VALUES
(501, '', 'Quelle clé USB peut-être branchée ?', NULL, 502),
(502, '', 'Quel objet met en danger la sécurité du manoir ?', NULL, 503),
(503, '', 'Quel poste présente un risque ?', NULL, 501),
(504, '', 'Trouver les 2 erreurs de sécurité.', NULL, 504),
(505, '', 'Comment pouvez vous éviter le tailgating en 1 clic ?', NULL, 505),
(506, '', 'Comment empêcher le shoulder surfing', NULL, 506),
(507, '', 'Lister deux actions immédiates. ', NULL, 507),
(508, '', 'Qu\'est ce qui ne respecte pas la politique \"Clean Desk\". \n', NULL, 508),
(509, '', 'Marquer 3 problèmes de confidentialité.', NULL, 509),
(510, '', 'Quel objet pose un problème de conformité ?', NULL, 510);

-- --------------------------------------------------------

--
-- Structure de la table `mot_de_passe`
--

DROP TABLE IF EXISTS `mot_de_passe`;
CREATE TABLE IF NOT EXISTS `mot_de_passe` (
  `numero` int NOT NULL AUTO_INCREMENT,
  `motPasse` varchar(64) NOT NULL,
  `valeur` varchar(30) NOT NULL,
  PRIMARY KEY (`numero`)
) ENGINE=InnoDB AUTO_INCREMENT=101 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `mot_de_passe`
--

INSERT INTO `mot_de_passe` (`numero`, `motPasse`, `valeur`) VALUES
(1, '471395', 'Etape2'),
(2, '471385', 'Etape2'),
(3, '479513', 'Etape2'),
(4, '479585', 'Etape2'),
(5, '478513', 'Etape2'),
(6, '478595', 'Etape2'),
(7, '134795', 'Etape2'),
(8, '134785', 'Etape2'),
(9, '139547', 'Etape2'),
(10, '139585', 'Etape2'),
(11, '138547', 'Etape2'),
(12, '138595', 'Etape2'),
(13, '954713', 'Etape2'),
(14, '954785', 'Etape2'),
(15, '951347', 'Etape2'),
(16, '951385', 'Etape2'),
(17, '958547', 'Etape2'),
(18, '958513', 'Etape2'),
(19, '854713', 'Etape2'),
(20, '854795', 'Etape2'),
(21, '851347', 'Etape2'),
(22, '851395', 'Etape2'),
(23, '859547', 'Etape2'),
(24, '859513', 'Etape2'),
(25, '4897', 'Etape2-Introduction'),
(26, '1123', 'Etape2-Introduction'),
(27, '9875', 'Etape2-Introduction'),
(28, '8745', 'Etape2-Introduction'),
(45, 'abc123', 'Etape4'),
(78, 'orange44', 'Etape4'),
(90, 'Arc25', 'Etape4'),
(91, 'Elect@oni-que226', 'Etape4-Accept'),
(92, 'password', 'Etape4'),
(96, 'Zorliam87ax!@', 'Etape4-Accept'),
(97, 'Farytek31z-31', 'Etape4-Accept'),
(98, '789546', 'Etape1a'),
(99, '321456', 'Etape1a'),
(100, '912364', 'Etape1a');

-- --------------------------------------------------------

--
-- Structure de la table `objet`
--

DROP TABLE IF EXISTS `objets`;
CREATE TABLE IF NOT EXISTS `objets` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) NOT NULL,
  `x` float DEFAULT NULL,
  `y` float DEFAULT NULL,
  `width` float DEFAULT NULL,
  `height` float DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `reponse` varchar(255) DEFAULT NULL,
  `zone_path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `texte` varchar(150) DEFAULT NULL,
  `texte_x` float DEFAULT NULL,
  `texte_y` float DEFAULT NULL,
  `rotate` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `drag` varchar(3) DEFAULT NULL,
  `hover` varchar(150) DEFAULT NULL,
  `cliquable` varchar(3) DEFAULT NULL,
  `ratio` varchar(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `objet`
--

INSERT INTO `objets` (`id`, `nom`, `x`, `y`, `width`, `height`, `image`, `reponse`, `zone_path`, `texte`, `texte_x`, `texte_y`, `rotate`, `drag`, `hover`, `cliquable`, `ratio`) VALUES
(1, 'ciseaux', 350.22, -18.651, 129, 224.38, 'images/salle_5/ciseau.svg', '.', NULL, NULL, NULL, NULL, 'rotate(90, 414.72, 93.539)', NULL, NULL, NULL, NULL),
(2, 'pic', 322.25, 445.55, 115.01, 54.916, 'images/salle_5/pic_2.svg', '.', NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL),
(3, 'puce', 823.75, 51.808, 133.66, 49.736, 'images/salle_5/puce_1.svg', '.', NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL),
(4, 'stylo', 321.21, 758.47, 295.31, 119.16, 'images/salle_5/stylo.svg', '.', NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL),
(5, 'tel', 808.2, 662.11, 157, 175, 'images/salle_5/telephone.svg', '.', NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL),
(6, 'trombone', 761.58, 437.26, 84.965, 66.314, 'images/salle_5/trombone.svg', '.', NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL),
(7, 'carnet', -169.72, 281.21, 447.7, 251.17, 'images/salle_5/carnet.svg', 'A', NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL),
(9, 'usb_bottom', 104, 756, 123, 84, 'images/salle_5/usb_anonyme.svg', 'cle1', NULL, NULL, NULL, NULL, 'rotate(12, 165, 798)', NULL, 'Une clé USB remise en main propre par le service comptabilité', NULL, NULL),
(10, 'usb_right', 1097, 292, 155, 78, 'images/salle_5/usb_rh.svg', 'cle_usb_droite', NULL, NULL, NULL, NULL, 'rotate(20, 1174, 331)', NULL, 'Une clé USB qui a été trouvé par terre', NULL, NULL),
(11, 'cle', 850, 703.12, 170.83, 73.958, 'images/salle_5/cle.svg', 'cle', NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL),
(12, 'carte_pass', 106.25, 332.29, 152.08, 110.42, 'images/salle_5/badge.svg', 'carte_pass', NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL),
(13, 'carte_bancaire', 1167.7, 230.21, 182.29, 114.58, 'images/salle_5/cb.svg', 'carte_bancaire', NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL),
(14, 'post_it', 1145.8, 143.75, 146.87, 142.71, 'images/salle_5/post_it_confidentiel.svg', 'post_it_conf_2', NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL),
(15, 'dossier', 940.62, 410.42, 288.54, 387.5, 'images/salle_5/dossier.svg', 'dossier_conf', NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL),
(16, 'carnet', -169.72, 281.21, 447.7, 251.17, 'images/salle_5/carnet.svg', 'carnet', NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL),
(17, 'dossier', 940.62, 410.42, 288.54, 387.5, 'images/salle_5/dossier.svg', 'dossier_conf', NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL),
(18, 'carnet_mdp', -169.72, 281.21, 447.7, 251.17, 'images/salle_5/carnet_mdp.svg', 'carnet_mdp_2', NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL),
(19, 'usb_right', 1097, 292, 155, 78, 'images/salle_5/usb_rh.svg', 'cle3', NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL),
(20, 'carte_pass', 106.25, 332.29, 152.08, 110.42, 'images/salle_5/badge.svg', 'B', NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL),
(22, 'choix_1', 987, 143, 533, 72, 'images/salle_5/reponse.svg', 'choix_1', NULL, 'Le bureau est mal rangé', 1253, 188, '', NULL, NULL, NULL, NULL),
(23, 'choix_2', 987, 263, 533, 72, 'images/salle_5/reponse.svg', 'choix_2', NULL, 'Le code est trop simple', 1253, 308, '', NULL, NULL, NULL, NULL),
(24, 'choix_3', 987, 383, 533, 72, 'images/salle_5/reponse.svg', 'choix_3', NULL, 'Badge non porté/abandonné', 1253, 428, '', NULL, NULL, NULL, NULL),
(25, 'choix_4', 987, 503, 533, 72, 'images/salle_5/reponse.svg', 'choix_4', NULL, 'Code d\'accès écrit et visible', 1253, 548, '', NULL, NULL, NULL, NULL),
(26, 'ecran_mail', 724.84, 521.63, 250, 134, 'images/salle_5/ecran_mail_2.svg', 'ecran_milieu_gauche', 'm724.2 521.63 243.77-0.21573 7.9819 133.97-250.89-0.43145z', NULL, NULL, NULL, '', NULL, NULL, NULL, NULL),
(27, 'ecran_data', 1018.8, 523.13, 234.28, 132.24, 'images/salle_5/ecran_login_2_v2.webp', 'ecran_data', 'm1018.8 523.13h233.84l0.4386 132.24-233.84-3.1168z', NULL, NULL, NULL, '', NULL, NULL, NULL, 'none'),
(28, 'porte', 1592.5, 237.97, 257.49, 838.37, 'images/salle_5/porte_ouverte.svg', 'porte', NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, 'none'),
(29, 'ecran_milieu_gauche', 724.84, 521.63, 250, 134, 'images/salle_5/ecran_data_2.svg', 'ecran', 'm724.2 521.63 243.77-0.21573 7.9819 133.97-250.89-0.43145z', NULL, NULL, NULL, '', NULL, NULL, NULL, 'none'),
(30, 'fenetre_ouverte', 64, 182, 218, 458, 'images/salle_5/fenetre_ouverte.svg', '.', NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, 'none'),
(31, 'choix_1', 1270, 308, 594, 105, 'images/salle_5/reponse.svg', 'choix1', NULL, 'Fermer/Sécuriser la fenêtre', 1567, 370, '', NULL, NULL, NULL, NULL),
(32, 'choix_2', 1270, 428, 594, 105, 'images/salle_5/reponse.svg', 'autocollant', NULL, 'Poser un autocollant \"Ne pas toucher\"', 1567, 490, '', NULL, NULL, NULL, NULL),
(33, 'choix_3', 1270, 548, 594, 105, 'images/salle_5/reponse.svg', 'cacher_tapis', NULL, 'Cacher le matériel sous un tapis', 1567, 610, '', NULL, NULL, NULL, NULL),
(34, 'choix_4', 1270, 668, 594, 105, 'images/salle_5/reponse.svg', 'choix4', NULL, 'Éloigner/Verrouiller le matériel proche', 1567, 730, '', NULL, NULL, NULL, NULL),
(35, 'camera', 1577.1, 89.952, 232.99, 113.9, 'images/salle_5/camera.svg', 'camera', NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL),
(36, 'ecran_bas_gauche', 450, 511.71, 230, 198, 'images/salle_5/ecran_veille_1.svg', '.', NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL),
(37, 'ecran_bas_mid_gauche', 723, 517.31, 255, 189, 'images/salle_5/ecran_veille_2.svg', '.', NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL),
(38, 'ecran_bas_mid_droit', 1013, 514.29, 245, 193, 'images/salle_5/ecran_veille_2_1.svg', '.', NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL),
(39, 'ecran_geant', 426.28, 195, 1115, 293, 'images/salle_5/ecran_surveillance.svg', '.', NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL),
(40, 'filtre', NULL, NULL, NULL, NULL, 'images/salle_5/filtre_ecran.svg', 'filtre', NULL, NULL, NULL, NULL, '', 'oui', NULL, NULL, NULL),
(41, 'cb', NULL, NULL, NULL, NULL, 'images/salle_5/cb.svg', 'cb', NULL, NULL, NULL, NULL, '', 'oui', NULL, NULL, NULL),
(42, 'cle', NULL, NULL, NULL, NULL, 'images/salle_5/cle.svg', 'cle', NULL, NULL, NULL, NULL, '', 'oui', NULL, NULL, NULL),
(43, 'post-it', NULL, NULL, NULL, NULL, 'images/salle_5/post_it_confidentiel.svg', 'post-it', NULL, NULL, NULL, NULL, '', 'oui', NULL, NULL, NULL),
(44, 'usb', NULL, NULL, NULL, NULL, 'images/salle_5/usb_rh.svg', 'usb', NULL, NULL, NULL, NULL, '', 'oui', NULL, NULL, NULL),
(45, 'ciseaux', 350.22, -18.651, 129, 224.38, 'images/salle_5/ciseau.svg', '.', NULL, NULL, NULL, NULL, 'rotate(90, 414.72, 93.539)', NULL, NULL, 'non', NULL),
(46, 'pic', 322.25, 445.55, 115.01, 54.916, 'images/salle_5/pic_2.svg', '.', NULL, NULL, NULL, NULL, '', NULL, NULL, 'non', NULL),
(47, 'puce', 823.75, 51.808, 133.66, 49.736, 'images/salle_5/puce_1.svg', '.', NULL, NULL, NULL, NULL, '', NULL, NULL, 'non', NULL),
(48, 'stylo', 321.21, 758.47, 295.31, 119.16, 'images/salle_5/stylo.svg', '.', NULL, NULL, NULL, NULL, '', NULL, NULL, 'non', NULL),
(49, 'tel', 808.2, 662.11, 157, 175, 'images/salle_5/telephone.svg', '.', NULL, NULL, NULL, NULL, '', NULL, NULL, 'non', NULL),
(50, 'trombone', 761.58, 437.26, 84.965, 66.314, 'images/salle_5/trombone.svg', '.', NULL, NULL, NULL, NULL, '', NULL, NULL, 'non', NULL),
(51, 'carnet', -169.72, 281.21, 447.7, 251.17, 'images/salle_5/carnet.svg', 'A', NULL, NULL, NULL, NULL, '', NULL, NULL, 'non', NULL),
(52, 'post_it_code', 103.12, 418.75, 120.83, 117.71, 'images/salle_5/post_it_code.svg', 'A', NULL, NULL, NULL, NULL, '', NULL, NULL, 'non', NULL),
(53, 'fenetre_ouverte', 64, 182, 218, 458, 'images/salle_5/fenetre_ouverte.svg', '.', NULL, NULL, NULL, NULL, '', NULL, NULL, 'non', 'none'),
(55, 'carte_pass', 106.25, 332.29, 152.08, 110.42, 'images/salle_5/badge.svg', 'carte_pass', NULL, NULL, NULL, NULL, '', NULL, NULL, 'non', NULL),
(58, 'usb_left', 133, 282, 128, 83, 'images/salle_5/usb_finance.svg', 'cle_usb_gauche', NULL, NULL, NULL, NULL, 'rotate(-15, 197, 323)', NULL, 'Une clé USB qui circule dans l\'entreprise', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `objets_activite`
--

DROP TABLE IF EXISTS `objets_activite`;
CREATE TABLE IF NOT EXISTS `objets_activite` (
  `numero_activite` int NOT NULL,
  `objet_id` int NOT NULL,
  PRIMARY KEY (`numero_activite`,`objet_id`),
  KEY `objet_ibfk` (`objet_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `objets_activite`
--

INSERT INTO `objets_activite` (`numero_activite`, `objet_id`) VALUES
(503, 1),
(504, 1),
(508, 1),
(503, 2),
(504, 2),
(508, 2),
(503, 3),
(504, 3),
(508, 3),
(503, 4),
(504, 4),
(508, 4),
(503, 5),
(504, 5),
(508, 5),
(503, 6),
(504, 6),
(508, 6),
(503, 7),
(504, 7),
(502, 9),
(502, 10),
(503, 11),
(503, 12),
(503, 13),
(504, 14),
(504, 15),
(508, 17),
(508, 18),
(508, 19),
(509, 22),
(509, 23),
(509, 24),
(509, 25),
(501, 26),
(501, 27),
(505, 28),
(506, 29),
(507, 31),
(507, 32),
(507, 33),
(507, 34),
(510, 35),
(505, 36),
(510, 36),
(505, 37),
(510, 37),
(505, 38),
(510, 38),
(505, 39),
(510, 39),
(506, 40),
(506, 41),
(506, 42),
(506, 43),
(506, 44),
(502, 45),
(509, 45),
(502, 46),
(509, 46),
(502, 47),
(509, 47),
(502, 48),
(509, 48),
(502, 49),
(509, 49),
(502, 50),
(509, 50),
(502, 51),
(509, 51),
(509, 52),
(507, 53),
(509, 55),
(502, 58);

-- --------------------------------------------------------

--
-- Structure de la table `objet_declencheur_enigme`
--

DROP TABLE IF EXISTS `objet_declencheur_enigme`;
CREATE TABLE IF NOT EXISTS `objet_declencheur_enigme` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `x` float NOT NULL,
  `y` float NOT NULL,
  `width` float NOT NULL,
  `height` float NOT NULL,
  `zone_path` text,
  `clip_path_name` varchar(255) DEFAULT NULL,
  `visible_si_selectionnee` tinyint(1) DEFAULT '1',
  `visible_si_non_reussie` tinyint(1) DEFAULT '1',
  `numero_activite` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `objet_declencheur_enigme`
--

INSERT INTO `objet_declencheur_enigme` (`id`, `nom`, `image_path`, `x`, `y`, `width`, `height`, `zone_path`, `clip_path_name`, `visible_si_selectionnee`, `visible_si_non_reussie`, `numero_activite`) VALUES
(1, 'ecran_milieu_droit', 'images/salle_5/ecran_login_2_v2.webp', 1018.8, 523.13, 234.28, 132.24, 'm1018.8 523.13h233.84l0.4386 132.24-233.84-3.1168z', 'clip_ecran_milieu_droit', 1, 1, 501),
(2, 'ecran_milieu_gauche', 'images/salle_5/ecran_data_2.svg', 724.84, 521.63, 250, 134, 'm724.2 521.63 243.77-0.21573 7.9819 133.97-250.89-0.43145z', 'clip_ecran_milieu_gauche', 1, 1, 506),
(3, 'porte', 'images/salle_5/porte_ouverte.svg', 1592.5, 237.97, 257.49, 838.37, NULL, 'clip_porte', 1, 1, 505),
(4, 'fenetre', 'images/salle_5/fenetre_ouverte.svg', 64, 182, 218, 458, 'm68.949 182.44 213.56 48.814-2.4407 340.47-216 68.949h0.61017z', 'clip_fenetre', 1, 1, 507),
(5, 'camera', 'images/salle_5/camera.svg', 1577.1, 89.952, 232.99, 113.9, NULL, 'clip_camera', 1, 1, 510),
(6, 'post_it_conf', 'images/salle_5/post_it_confidentiel.svg', 1400, 518.82, 73.347, 84.566, NULL, 'clip_post_it_conf', 1, 1, 509),
(7, 'cle_usb', 'images/salle_5/usb_anonyme.svg', 1228.4, 701.76, 63.855, 21.573, NULL, 'clip_cle_usb', 1, 1, 502),
(8, 'cle', 'images/salle_5/cle.svg', 1507.2, 702.62, 69.895, 23.299, NULL, 'clip_cle', 1, 1, 503),
(9, 'dossier', 'images/salle_5/dossier.svg', 620.95, 610.29, 68.17, 95.783, NULL, 'clip_dossier', 1, 1, 508),
(10, 'carnet_mdp', 'images/salle_5/carnet_mdp.svg', 328.13, 825.2, 115.93, 106.17, NULL, 'clip_carnet_mdp', 1, 1, 504);

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

--
-- Déchargement des données de la table `proposer_vpn`
--

INSERT INTO `proposer_vpn` (`vpn_numero`, `activite_numero`, `bonne_reponse`) VALUES
(1, 602, 1),
(2, 602, 1),
(3, 602, 1),
(4, 602, 1),
(5, 602, 1),
(6, 602, 1),
(7, 602, 1),
(8, 602, 0),
(9, 602, 1),
(10, 602, 1),
(11, 602, 1),
(12, 602, 1),
(13, 602, 1),
(14, 602, 1),
(15, 602, 1),
(16, 602, 1),
(17, 602, 1),
(18, 602, 1),
(19, 602, 1),
(20, 602, 1),
(21, 602, 0),
(22, 602, 0),
(23, 602, 0),
(24, 602, 0),
(25, 602, 0),
(26, 602, 0),
(27, 602, 0),
(28, 602, 0),
(29, 602, 0),
(30, 602, 0);

-- --------------------------------------------------------

--
-- Structure de la table `proposer_wifi`
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

--
-- Déchargement des données de la table `proposer_wifi`
--

INSERT INTO `proposer_wifi` (`wifi_numero`, `activite_numero`, `bonne_reponse`, `zone_clique`) VALUES
(1, 601, 0, 'chiffrement'),
(2, 601, 0, 'chiffrement'),
(3, 601, 1, 'chiffrement'),
(4, 601, 1, 'chiffrement'),
(5, 601, 0, 'public_prive'),
(6, 601, 1, 'chiffrement'),
(7, 601, 0, 'chiffrement'),
(8, 601, 1, 'public_prive'),
(9, 601, 1, 'chiffrement'),
(10, 601, 0, 'public_prive'),
(11, 601, 1, 'chiffrement'),
(12, 601, 1, 'chiffrement'),
(13, 601, 0, 'chiffrement'),
(14, 601, 1, 'chiffrement'),
(15, 601, 0, 'public_prive'),
(16, 601, 1, 'nom'),
(17, 601, 0, 'public_prive'),
(18, 601, 1, 'chiffrement'),
(19, 601, 0, 'chiffrement'),
(20, 601, 1, 'chiffrement'),
(21, 601, 0, 'public_prive'),
(22, 601, 0, 'public_prive'),
(23, 601, 1, 'public_prive'),
(24, 601, 1, 'public_prive'),
(25, 601, 0, 'public_prive'),
(26, 601, 0, 'public_prive'),
(27, 601, 1, 'public_prive'),
(28, 601, 0, 'public_prive'),
(29, 601, 1, 'public_prive'),
(30, 601, 0, 'public_prive'),
(31, 601, 0, 'public_prive'),
(32, 601, 1, 'public_prive'),
(33, 601, 0, 'public_prive'),
(34, 601, 1, 'public_prive'),
(35, 601, 0, 'public_prive'),
(36, 601, 1, 'public_prive'),
(37, 601, 0, 'public_prive'),
(38, 601, 1, 'public_prive'),
(39, 601, 1, 'public_prive'),
(40, 601, 0, 'nom'),
(41, 601, 1, 'nom'),
(42, 601, 1, 'nom'),
(43, 601, 1, 'nom'),
(44, 601, 0, 'nom'),
(45, 601, 0, 'nom'),
(46, 601, 1, 'nom'),
(47, 601, 1, 'nom'),
(48, 601, 0, 'nom'),
(49, 601, 0, 'nom'),
(50, 601, 1, 'nom'),
(51, 601, 1, 'nom'),
(52, 601, 0, 'nom'),
(53, 601, 1, 'nom'),
(54, 601, 0, 'nom'),
(55, 601, 1, 'nom'),
(56, 601, 0, 'nom'),
(57, 601, 1, 'nom'),
(58, 601, 1, 'nom'),
(59, 601, 0, 'nom');

-- --------------------------------------------------------

--
-- Structure de la table `question`
--

DROP TABLE IF EXISTS `question`;
CREATE TABLE IF NOT EXISTS `question` (
  `numero` int NOT NULL AUTO_INCREMENT,
  `libelle` text NOT NULL,
  `reponse` int NOT NULL,
  `activite_numero` int NOT NULL,
  PRIMARY KEY (`numero`),
  KEY `activite_ibfk_8` (`activite_numero`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `question`
--

INSERT INTO `question` (`numero`, `libelle`, `reponse`, `activite_numero`) VALUES
(1, 'Un ransomware peut se propager via une pièce jointe email malveillante', 1, 403),
(2, 'Payer la rançon garantit toujours la récupération de vos données', 0, 403),
(3, 'Les sauvegardes hors ligne protègent contre les ransomwares', 1, 403),
(4, 'Un antivirus à jour suffit à bloquer tous les ransomwares', 0, 403),
(5, 'Il faut déconnecter immédiatement le réseau en cas d\'infection', 1, 403),
(6, 'Les ransomwares peuvent chiffrer les fichiers sur les serveurs réseau', 1, 403),
(7, 'Seuls les grands groupes sont ciblés par les ransomwares', 0, 403),
(8, 'La formation des utilisateurs réduit le risque d\'infection', 1, 403),
(9, 'Il est inutile de signaler une attaque ransomware aux autorités', 0, 403),
(10, 'Les mises à jour système peuvent corriger des failles exploitées par les ransomwares', 1, 403),
(11, 'Un ransomware peut se cacher dans un fichier PDF', 1, 403),
(12, 'Il est sûr d\'ouvrir une pièce jointe d\'un expéditeur connu', 0, 403),
(13, 'Les macros dans les documents Office peuvent contenir des ransomwares', 1, 403),
(14, 'Après une attaque, il faut éteindre immédiatement l\'ordinateur', 0, 403);

-- --------------------------------------------------------

--
-- Structure de la table `salle`
--

DROP TABLE IF EXISTS `salle`;
CREATE TABLE IF NOT EXISTS `salle` (
  `numero` int NOT NULL AUTO_INCREMENT,
  `libelle` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `bouton` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `intro_salle` text NOT NULL,
  PRIMARY KEY (`numero`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `salle`
--

INSERT INTO `salle` (`numero`, `libelle`, `bouton`, `intro_salle`) VALUES
(1, 'Bienvenue dans la salle de l\'ingénierie sociale !', 'images/commun/btn_retour/home_icone_2.webp', 'Le but du jeu est de repérer tous les mots suspects dans la discussion avec le fantôme. Clique sur chaque mot qui te paraît étrange pour avancer dans l’enquête. Attention, tu es limité dans le temps ! Une fois tous les mots suspects trouvés, un code te sera révélé. Tu pourras alors l’utiliser pour ouvrir la porte… en cliquant sur le cadenas situé en face de toi.  Bonne chance !'),
(2, 'Salle des Mots de Passe', 'images/commun/btn_retour/home_icone_7.webp', 'Bienvenue dans la salle des mots de passe…Sauras-tu trouver les mots de passe dans les différentes étapes ?'),
(3, 'Bienvenue dans la salle du phishing !', 'images/commun/btn_retour/home_icone_6.webp', 'Les lourdes portes de la bibliothèque s’ouvrent… bienvenue dans une pièce où chaque détail pourrait être un indice.\n\nSaurez-vous les trouver ?'),
(4, 'Comprendre et contrer les ransomwares', 'images/commun/btn_retour/home_icone_3.webp', '                        <h2>\n                            Bienvenue dans la salle des ransomwares !\n                            Découvrez comment ces logiciels malveillants parviennent à bloquer l’accès aux données et ce qu’il faut mettre en place pour s’en protéger.\n                        </h2>\n                        <h3>Mission</h3>\n                        <p>\n                            Explorez les éléments autour de vous, analysez les bonnes pratiques et apprenez à sécuriser un système avant qu’il ne soit trop tard.\n                            Ici, l’anticipation et la prévention font toute la différence.\n                        </p>'),
(5, 'Sécurité physique et matérielle', 'images/commun/btn_retour/home_icone_5.webp', 'Bienvenue dans la salle de surveillance ! Plongez au cœur de la sécurité physique et matérielle, où chaque objet, chaque dispositif et chaque comportement compte. Soyez vigilants et surtout bonne chance !'),
(6, 'Quelle sécurité à l\'extérieur ?', 'images/commun/btn_retour/home_icone_6.webp', 'Te voilà dans le grenier…\r\nDevant toi, un vieux train miniature t’attend. Chaque wagon renferme une énigme qui te fera progresser dans ta mission et t’aidera à mieux comprendre les bons réflexes à adopter en situation réelle.\r\n\r\nPour démarrer l’aventure et accéder au premier wagon, clique sur le train.\r\n\r\nBonne chance… et reste vigilant');

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
) ENGINE=InnoDB AUTO_INCREMENT=403 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `type`
--

INSERT INTO `type` (`numero`, `libelle`, `explication`) VALUES
(1, 'QCM', 'Cette énigme est de type QCM, une ou plusieurs réponses sont possibles'),
(401, 'Frise chronologique', 'Reconstituer une procédure en reliant les cartes dans le bon ordre chronologique'),
(402, 'drag_drop', 'glisser/déposer');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `numero` int NOT NULL AUTO_INCREMENT,
  `login` varchar(50) NOT NULL,
  `mdp` varchar(100) NOT NULL,
  PRIMARY KEY (`numero`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`numero`, `login`, `mdp`) VALUES
(1, 'AdminMIVDL', '$2y$10$T.8NjoeOd61dsrQDwPzF8up71iy3xurteaz.smn8VWJPLBbrQu4wC');

-- --------------------------------------------------------

--
-- Structure de la table `vpn`
--

DROP TABLE IF EXISTS `vpn`;
CREATE TABLE IF NOT EXISTS `vpn` (
  `numero` int NOT NULL AUTO_INCREMENT,
  `libelle` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`numero`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `vpn`
--

INSERT INTO `vpn` (`numero`, `libelle`) VALUES
(1, 'Un VPN ne remplace pas un antivirus'),
(2, 'Un VPN peut réduire légèrement la vitesse selon le serveur utilisé'),
(3, 'Un VPN gratuit peut collecter et revendre vos données'),
(4, 'Les VPN d\'entreprise permettent d\'accéder au réseau interne à distance'),
(5, 'Un VPN peut contourner certaines censures gouvernementales'),
(6, 'Un VPN ne protège pas contre le phishing'),
(7, 'Un VPN crée un tunnel chiffré entre l’utilisateur et le serveur'),
(8, 'Un VPN ne doit jamais être utilisé sur un réseau public'),
(9, 'Les VPN sécurisent l’utilisation des hotspots WiFi publics'),
(10, 'Un VPN peut parfois bloquer l’accès à certains services bancaires'),
(11, 'Un VPN ne masque pas votre identité sur les réseaux sociaux'),
(12, 'Les VPN ne peuvent pas empêcher les malwares de s’installer'),
(13, 'Un VPN peut empêcher votre FAI de suivre votre historique'),
(14, 'Un VPN peut fausser la localisation utilisée par les sites web'),
(15, 'Les VPN utilisent souvent un chiffrement AES 256 bits'),
(16, 'Un VPN n’empêche pas les sites web de vous tracker via cookies'),
(17, 'Un VPN n’améliore pas la sécurité d’un mot de passe faible'),
(18, 'Un VPN peut être installé sur un routeur WiFi'),
(19, 'Les VPN d’entreprise utilisent parfois IPsec au lieu d’OpenVPN'),
(20, 'Un VPN peut permettre d’accéder aux fichiers internes d’une entreprise'),
(21, 'Un VPN accélère automatiquement votre connexion internet même si le serveur est éloigné'),
(22, 'Un VPN rend votre appareil totalement anonyme, même pour les sites web'),
(23, 'Avec un VPN, les hackers ne peuvent plus du tout infecter votre appareil'),
(24, 'Un VPN rend toutes les connexions web gratuites, même les services payants'),
(25, 'Un VPN empêche complètement les publicités de s’afficher'),
(26, 'L’utilisation d’un VPN rend inutile la mise à jour du système d’exploitation'),
(27, 'Un VPN bloque automatiquement toutes les tentatives de phishing'),
(28, 'Un VPN garantit qu’aucun site web ne peut installer de cookies sur votre navigateur'),
(29, 'Tous les VPN utilisent exactement les mêmes protocoles et le même chiffrement'),
(30, 'Un VPN protège votre compte en ligne même si votre mot de passe est déjà volé');

-- --------------------------------------------------------

--
-- Structure de la table `wifi`
--

DROP TABLE IF EXISTS `wifi`;
CREATE TABLE IF NOT EXISTS `wifi` (
  `numero` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(30) NOT NULL,
  `public` tinyint NOT NULL,
  `chiffrement` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`numero`)
) ENGINE=InnoDB AUTO_INCREMENT=60 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `wifi`
--

INSERT INTO `wifi` (`numero`, `nom`, `public`, `chiffrement`) VALUES
(1, 'CaféDuCentre_FreeWiFi', 1, 'WEP'),
(2, 'HotelBelleVue_Guest', 1, 'WPA'),
(3, 'Bureau_RH_Secure', 0, 'WPA3'),
(4, 'Ypia_SmartOffice', 0, 'WPA2'),
(5, 'FreeWifi_Public', 1, 'OPEN'),
(6, 'MaisonJean_5Ghz', 0, 'WPA3'),
(7, 'McDonalds_WiFi', 1, 'WPA'),
(8, 'Campus_Guest', 1, 'WPA2'),
(9, 'Campus_Admin', 0, 'WPA3'),
(10, 'SNCF_TGV_WiFi', 1, 'OPEN'),
(11, 'Bibliotheque_Ville', 1, 'WPA2'),
(12, 'Immeuble_Orange_Fibre', 0, 'WPA2'),
(13, 'Restaurant_LeQuai', 1, 'WEP'),
(14, 'Entreprise_Prod_Serveur', 0, 'WPA3'),
(15, 'CoWorking_OpenSpace', 1, 'WPA'),
(16, 'MaisonDuVPN_Private', 0, 'WPA3'),
(17, 'BarLeCactus_FreeHotspot', 1, 'OPEN'),
(18, 'EcoleElementaire_SalleInfo', 0, 'WPA2'),
(19, 'Hopital_Visiteurs', 1, 'WPA'),
(20, 'Hopital_Administratif', 0, 'WPA2'),
(21, 'CafeDuCoin_Free', 1, 'OPEN'),
(22, 'HotelLuxe_Guest', 1, 'WPA2'),
(23, 'Entreprise_Reseau_Interne', 0, 'WPA3'),
(24, 'MaisonPaul_Fibre', 0, 'WPA3'),
(25, 'Airport_WiFi_Free', 1, 'OPEN'),
(26, 'SuperU_WiFiClient', 1, 'WPA'),
(27, 'Private_Residence_54', 0, 'WPA2'),
(28, 'Hopital_Visiteurs', 1, 'WPA'),
(29, 'Hopital_Administratif', 0, 'WPA3'),
(30, 'Bar_Tapas_FreeHotspot', 1, 'OPEN'),
(31, 'Bibliotheque_Officiel', 1, 'WPA2'),
(32, 'Immeuble_Orange_Fibre_4', 0, 'WPA2'),
(33, 'FastFood_WiFiZone', 1, 'OPEN'),
(34, 'Entreprise_Compta_Secure', 0, 'WPA3'),
(35, 'CoWorking_Open', 1, 'OPEN'),
(36, 'MaisonEmma_5G', 0, 'WPA3'),
(37, 'Campus_Guest_Zone', 1, 'WPA2'),
(38, 'Campus_Administratif', 0, 'WPA3'),
(39, 'Hotel_Suite_Private', 0, 'WPA2'),
(40, 'FreeWifi_Secure', 1, 'OPEN'),
(41, 'Hotel_BelleVue_Premium', 1, 'WPA2'),
(42, 'Entreprise_Reseau_Pro', 0, 'WPA3'),
(43, 'Maison_Durant_5G', 0, 'WPA3'),
(44, 'Airport_WiFi_FreeAccess', 1, 'OPEN'),
(45, 'PublicWifi_Gratuit', 1, 'OPEN'),
(46, 'Residence_Privative_12', 0, 'WPA2'),
(47, 'Hopital_WiFi_StaffOnly', 0, 'WPA3'),
(48, 'Hopital_Visiteurs_Free', 1, 'WPA'),
(49, 'Bar_Tapas_FreeWifi', 1, 'OPEN'),
(50, 'Bibliotheque_Centrale_Officiel', 1, 'WPA2'),
(51, 'Immeuble_Fibre_Orange_5', 0, 'WPA2'),
(52, 'FastFood_FreeZone', 1, 'OPEN'),
(53, 'Entreprise_Compta_Internal', 0, 'WPA3'),
(54, 'CoWorking_FreeDesk', 1, 'OPEN'),
(55, 'Maison_Emma_Private', 0, 'WPA3'),
(56, 'Campus_Guest_WiFi', 1, 'WPA2'),
(57, 'Campus_Admin_Only', 0, 'WPA3'),
(58, 'Hotel_Suite_PrivateAccess', 0, 'WPA2'),
(59, 'Restaurant_WiFi_Public', 1, 'WPA');

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
) ENGINE=InnoDB AUTO_INCREMENT=75 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `zone`
--

INSERT INTO `zone` (`numero`, `nom`, `coordonnees`, `bonne_reponse`) VALUES
(1, 'camera', 'x=1577.1 y=89.952 width=232.99 height=113.9', 1),
(2, 'camera', 'x=1577.1 y=89.952 width=232.99 height=113.9', 0),
(3, 'ecran_mid_droit', 'x=\"1018.8\" y=\"523.13\" width=\"234.28\" height=\"132.2', 1),
(4, 'ecran_mid_droit', 'x=\"1018.8\" y=\"523.13\" width=\"234.28\" height=\"132.2', 0),
(5, 'post_it_conf', 'x=1144.7 y=518.82 width=73.347 height=84.566', 1),
(6, 'post_it_conf', 'x=1144.7 y=518.82 width=73.347 height=84.566', 0),
(7, 'cle_usb', 'x=1228.4 y=701.76 width=63.855 height=21.573', 1),
(8, 'cle_usb', 'x=1228.4 y=701.76 width=63.855 height=21.573', 0),
(9, 'cle', 'x=1507.2 y=702.62 width=69.895 height=23.299', 1),
(10, 'cle', 'x=1507.2 y=702.62 width=69.895 height=23.299', 0),
(11, 'dossier', 'x=620.95 y=610.29 width=68.17 height=95.783', 1),
(12, 'dossier', 'x=620.95 y=610.29 width=68.17 height=95.783', 0),
(13, 'carnet_mdp', 'x=328.13 y=825.2 width=115.93 height=106.17', 1),
(14, 'carnet_mdp', 'x=328.13 y=825.2 width=115.93 height=106.17', 0),
(15, 'ecran_milieu_gauche', 'x=\"724.84\" y=\"521.63\" width=\"250\" height=\"134\"', 1),
(16, 'ecran_milieu_gauche', 'x=\"724.84\" y=\"521.63\" width=\"250\" height=\"134\"', 0),
(17, 'fenetre', 'x=\"64\" y=\"182\" width=\"218\" height=\"458\"', 1),
(18, 'fenetre', 'x=\"64\" y=\"182\" width=\"218\" height=\"458\"', 0),
(19, 'porte', 'x=1592.5 y=237.97 width=257.49 height=838.37', 1),
(20, 'porte', 'x=1592.5 y=237.97 width=257.49 height=838.37', 0),
(21, 'question', 'x=327.91 y=41.42 width=1270.2 height=129.44', 1),
(22, 'question', 'x=327.91 y=41.42 width=1270.2 height=129.44', 0),
(23, 'home', 'x=15.532 y=27.613 width=277.86 height=93.194', 1),
(24, 'home', 'x=15.532 y=27.613 width=277.86 height=93.194', 0),
(25, 'dragdrop', 'x=27.613 y=260.6 width=517.75 height=491.86', 1),
(26, 'dragdrop', 'x=27.613 y=260.6 width=517.75 height=491.86', 0),
(27, 'cb', 'x=56.952 y=289.94 width=195.02 height=93.194', 1),
(28, 'cb', 'x=56.952 y=289.94 width=195.02 height=93.194', 0),
(29, 'cle_2', 'x=317.55 y=281.31 width=210.55 height=124.26', 1),
(30, 'cle_2', 'x=317.55 y=281.31 width=210.55 height=124.26', 0),
(31, 'usb', 'x=317.55 y=453.89 width=207.1 height=107', 1),
(32, 'usb', 'x=317.55 y=453.89 width=207.1 height=107', 0),
(33, 'postit', 'x=86.291 y=455.62 width=165.68 height=120.81', 1),
(34, 'postit', 'x=86.291 y=455.62 width=165.68 height=120.81', 0),
(35, 'filtre', 'x=141.52 y=562.62 width=264.05 height=132.89', 1),
(36, 'filtre', 'x=141.52 y=562.62 width=264.05 height=132.89', 0),
(37, 'choix1', 'x=1270 y=388 width=594 height=105', 1),
(38, 'choix1', 'x=1270 y=388 width=594 height=105', 0),
(39, 'choix2', 'x=1270 y=508 width=594 height=105', 1),
(40, 'choix2', 'x=1270 y=508 width=594 height=105', 0),
(41, 'choix3', 'x=1270 y=628 width=594 height=105', 1),
(42, 'choix3', 'x=1270 y=628 width=594 height=105', 0),
(43, 'choix4', 'x=1270 y=748 width=594 height=105', 1),
(44, 'choix4', 'x=1270 y=748 width=594 height=105', 0),
(45, 'cle1', 'x=\"104\" y=\"756\" width=\"123\" height=\"84\"', 1),
(46, 'cle1', 'x=\"104\" y=\"756\" width=\"123\" height=\"84\"', 0),
(47, 'cle2', 'x=\"133\" y=\"282\" width=\"128\" height=\"83\"', 1),
(48, 'cle2', 'x=\"133\" y=\"282\" width=\"128\" height=\"83\"', 0),
(49, 'cle3', 'x=\"1097\" y=\"292\" width=\"155\" height=\"78\"', 1),
(50, 'cle3', 'x=\"1097\" y=\"292\" width=\"155\" height=\"78\"', 0),
(51, 'carnet', 'x=963.54 y=519.79 width=345.83 height=277.08', 1),
(52, 'carnet', 'x=963.54 y=519.79 width=345.83 height=277.08', 0),
(53, 'cle_3', 'x=850 y=703.12 width=170.83 height=73.958', 1),
(54, 'cle_3', 'x=850 y=703.12 width=170.83 height=73.958', 0),
(55, 'carte_bancaire', 'x=1167.7 y=230.21 width=182.29 height=114.58', 1),
(56, 'carte_bancaire', 'x=1167.7 y=230.21 width=182.29 height=114.58', 0),
(57, 'carte_pass', 'x=106.25 y=332.29 width=152.08 height=110.42', 1),
(58, 'carte_pass', 'x=106.25 y=332.29 width=152.08 height=110.42', 0),
(59, 'carnet_mdp_2', 'x=40.625 y=271.88 width=408.33 height=275', 1),
(60, 'carnet_mdp_2', 'x=40.625 y=271.88 width=408.33 height=275', 0),
(61, 'post_it_conf_2', 'x=1145.8 y=143.75 width=146.87 height=142.71', 1),
(62, 'post_it_conf_2', 'x=1145.8 y=143.75 width=146.87 height=142.71', 0),
(63, 'dossier_conf', 'x=940.62 y=410.42 width=288.54 height=387.5', 1),
(64, 'dossier_conf', 'x=940.62 y=410.42 width=288.54 height=387.5', 0),
(65, 'post_it_code', 'x=103.12 y=418.75 width=120.83 height=117.71', 1),
(66, 'post_it_code', 'x=103.12 y=418.75 width=120.83 height=117.71', 0),
(67, 'choix_1', 'x=\"987\" y=\"143\" width=\"533\" height=\"72\"', 1),
(68, 'choix_1', 'x=\"987\" y=\"143\" width=\"533\" height=\"72\"', 0),
(69, 'choix_2', 'x=\"987\" y=\"263\" width=\"533\" height=\"72\"', 1),
(70, 'choix_2', 'x=\"987\" y=\"263\" width=\"533\" height=\"72\"', 0),
(71, 'choix_3', 'x=\"987\" y=\"383\" width=\"533\" height=\"72\"', 1),
(72, 'choix_3', 'x=\"987\" y=\"383\" width=\"533\" height=\"72\"', 0),
(73, 'choix_4', 'x=\"987\" y=\"503\" width=\"533\" height=\"72\"', 1),
(74, 'choix_4', 'x=\"987\" y=\"503\" width=\"533\" height=\"72\"', 0);

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
-- Contraintes pour la table `activite_message`
--
ALTER TABLE `activite_message`
  ADD CONSTRAINT `activite_message_ibfk_1` FOREIGN KEY (`activite_numero`) REFERENCES `activite` (`numero`);

--
-- Contraintes pour la table `avoir_indice`
--
ALTER TABLE `avoir_indice`
  ADD CONSTRAINT `activite_ibfk_6` FOREIGN KEY (`activite_numero`) REFERENCES `activite` (`numero`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `indice_ibfk_1` FOREIGN KEY (`indice_numero`) REFERENCES `indice` (`numero`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Contraintes pour la table `avoir_rep`
--
ALTER TABLE `avoir_rep`
  ADD CONSTRAINT `activite_ibfk_10` FOREIGN KEY (`activite_numero`) REFERENCES `activite` (`numero`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `objet_ibfk_7` FOREIGN KEY (`objet_id`) REFERENCES `objets` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

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
-- Contraintes pour la table `objets_activite`
--
ALTER TABLE `objets_activite`
  ADD CONSTRAINT `activite_ibfk` FOREIGN KEY (`numero_activite`) REFERENCES `activite` (`numero`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `objet_ibfk` FOREIGN KEY (`objet_id`) REFERENCES `objets` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Contraintes pour la table `proposer_vpn`
--
ALTER TABLE `proposer_vpn`
  ADD CONSTRAINT `activite_ibfk_4` FOREIGN KEY (`activite_numero`) REFERENCES `activite` (`numero`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `vpn_ibfk_1` FOREIGN KEY (`vpn_numero`) REFERENCES `vpn` (`numero`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Contraintes pour la table `proposer_wifi`
--
ALTER TABLE `proposer_wifi`
  ADD CONSTRAINT `activite_ibfk_5` FOREIGN KEY (`activite_numero`) REFERENCES `activite` (`numero`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `wifi_ibfk_1` FOREIGN KEY (`wifi_numero`) REFERENCES `wifi` (`numero`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Contraintes pour la table `question`
--
ALTER TABLE `question`
  ADD CONSTRAINT `activite_ibfk_8` FOREIGN KEY (`activite_numero`) REFERENCES `activite` (`numero`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
