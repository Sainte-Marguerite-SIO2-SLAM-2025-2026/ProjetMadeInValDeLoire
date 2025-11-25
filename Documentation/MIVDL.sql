-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : lun. 24 nov. 2025 à 23:40
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
-- User
--
CREATE USER IF NOT EXISTS 'userProjetMIVDL'@'%' IDENTIFIED BY 'Projet@MIVDL!user';
GRANT ALL PRIVILEGES ON made_in_val_de_loire.* TO 'userProjetMIVDL'@'%';
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

INSERT INTO `activite` (`numero`, `libelle`, `verrouillage`, `image`, `malveillant`, `difficulte_numero`, `salle_numero`, `auteur_numero`, `type_numero`, `explication_numero`) VALUES
(1, 'phishing', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(101, 'Bonjour, je suis Jean-Michel Dupuis du service informatique centrale. Nous avons detecté une intrusion urgente dans votre compte. Pour éviter une coupure immediate merci de m\'envoyer votre mot-de-passe personnel ainsi que votre identifiant bancaire pour vérification. Vous devez répondre dans les 5 minutes sinon votre accès entreprise sera definitivement supprimé.', 0, 'monstre1.webp', 1, 1, 1, 101, 1, 101),
(102, 'Madame, Monsieur, votre système informatique presente une vulnérabilité critique notre équipe de securité a identifié un virus dangereux. Cliquez immédiatement sur ce lien pour télécharger notre logiciel de protection gratuit attention, si vous n\'agissez pas maintenant vos données personnelles seront compromises dans moins d\'une heure.', 0, 'monstre1.webp', 1, 1, 1, 102, 1, 101),
(103, 'Cher client, nous avons remarqué une transaction suspecte de 1500 euros sur votre compte bancaire. Pour annuler cette opération frauduleuse, veuillez confirmer votre numéro de carte bleue et votre code confidentiel en cliquant ici Cette verification est obligatoire pour proteger votre argent.', 0, 'monstre1.webp', 1, 1, 1, 103, 1, 101),
(401, 'Apres Ransomware', 0, 'frise_reaction_ransomware.png', NULL, NULL, 4, NULL, 401, 401),
(402, 'Avant Ransomware', 0, 'frise_prevention_ransomware.png', NULL, NULL, 4, NULL, 401, 401),
(403, 'Quiz Ransomware', 0, 'quiz_ransomware.png', NULL, NULL, 4, NULL, 401, 401),
(501, 'Poste risqué', NULL, '/images/salle_5/ecran_mail_2.svg', NULL, NULL, 5, NULL, 1, 501),
(502, 'Clés étranges', NULL, '/images/salle_5/usb_anonyme.svg', NULL, NULL, 5, NULL, 1, 502),
(503, 'Un oubli risqué', NULL, '/images/salle_5/cle.svg', NULL, NULL, 5, NULL, 1, 503),
(504, 'Le bureau encombré', NULL, '/images/salle_5/post_it_code.svg', NULL, NULL, 5, NULL, 1, 504),
(505, 'La porte entrouverte', NULL, '/images/salle_5/porte_ouverte.svg', NULL, NULL, 5, NULL, 1, 505),
(506, 'Écrans non sécurisés', NULL, '/images/salle_5/ecran_mail_2.svg', NULL, NULL, 5, NULL, 1, 506),
(507, 'Fenêtre ouverte', NULL, '/images/salle_5/fenetre_ouverte.svg', NULL, NULL, 5, NULL, 1, 507),
(508, 'Poste « clean desk »', NULL, '/images/salle_5/dossier.svg', NULL, NULL, 5, NULL, 1, 508),
(509, 'Secrets physiques', NULL, '/images/salle_5/carnet_mdp.svg', NULL, NULL, 5, NULL, 1, 509),
(510, 'Caméra interne', NULL, '/images/salle_5/camera.svg', NULL, NULL, 5, NULL, 1, 510),
(601, 'Choisir le bon WiFi', NULL, 'wifi_activity.png', NULL, NULL, NULL, NULL, NULL, NULL),
(602, 'VPN', NULL, 'temp.svg', NULL, NULL, NULL, NULL, NULL, NULL);

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
) ENGINE=InnoDB AUTO_INCREMENT=104 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `auteur`
--

INSERT INTO `auteur` (`numero`, `nom`, `prenom`, `fonction_role`) VALUES
(101, 'Dupuis', 'Jean-Michel', 'Technicien informati'),
(102, 'Martin', 'Louis', 'Support de livraison'),
(103, 'Delasource', 'Carine', 'DRH');

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
(1, 1),
(1, 2),
(502, 2),
(1, 3),
(1, 4);

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
  PRIMARY KEY (`numero`),
  KEY `activite_ibfk_1` (`activite_numero`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `carte`
--

INSERT INTO `carte` (`numero`, `image`, `explication`, `activite_numero`) VALUES
(1, 'carte_pins_01.png', 'Isolez les machines infectées', 401),
(2, 'carte_pins_02.png', 'Coupez les accès réseau', 401),
(3, 'carte_pins_03.png', 'Prévenez l’équipe de sécurité', 401),
(4, 'carte_pins_04.png', 'Conservez les preuves', 401),
(5, 'carte_pins_05.png', 'Identifiez et bloquez la cause de l’infection', 401),
(6, 'carte_pins_06.png', 'Nettoyez les systèmes touchés', 401),
(7, 'carte_pins_07.png', 'Restaurez depuis des sauvegardes saines', 401),
(8, 'carte_pins_08.png', 'Changez tous les mots de passe', 401),
(9, 'carte_pins_01.png', 'Maintenez vos systèmes à jour', 402),
(10, 'carte_pins_02.png', 'Installez un antivirus performant', 402),
(11, 'carte_pins_03.png', 'Limitez les droits administrateur', 402),
(12, 'carte_pins_04.png', 'Filtrez les emails et pièces jointes', 402),
(13, 'carte_pins_05.png', 'Désactivez les macros par défaut', 402),
(14, 'carte_pins_06.png', 'Segmentez le réseau', 402),
(15, 'carte_pins_07.png', 'Formez les utilisateurs', 402),
(16, 'carte_pins_08.png', 'Effectuez des sauvegardes régulières', 402);

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
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
(15, 'ici', 'Lien cliquable suspect qui mène probablement vers un faux site.', 103);

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
(101, 'Le but du jeu est de repérer tous les mots suspects dans la discussion avec le fantôme.\r\nClique sur chaque mot qui te paraît étrange pour avancer dans l’enquête.\r\nAttention, tu es limité dans le temps !\r\nUne fois tous les mots suspects trouvés, un code te sera révélé.\r\nTu pourras alors l’utiliser pour ouvrir la porte… en cliquant sur le cadenas situé en face de toi.\r\n\r\nBonne chance !'),
(401, 'Cliquez sur les cartes dans l\'ordre chronologique pour reconstituer la procédure correcte'),
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
) ENGINE=InnoDB AUTO_INCREMENT=205 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `indice`
--

INSERT INTO `indice` (`numero`, `libelle`) VALUES
(1, 'Attention à la cohérence du contenu des mails !'),
(2, 'Soyez attentif aux liens transmis dans le contenu !'),
(3, 'Regardez bien les erreurs dans les mails !'),
(4, 'Vérifiez bien les adresses mails des expéditeurs !'),
(201, '4897'),
(202, '1123'),
(203, '9875'),
(204, '8745');

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
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `mail`
--

INSERT INTO `mail` (`numero`, `expediteur`, `objet`, `contenu`, `phishing`, `difficulte`) VALUES
(1, 'matheo.legrand@gmail.com', 'Mise à jour de vos coordonnées bancaires', 'On vous demande de mettre à jour vos informations pour payer le plus vite possible svp\r\nCliquez sur ce lien le plus vite possible : http://malveillancemax.fr\r\n', 1, 1),
(2, 'no-reply@microhard.com', 'Mise à jour de votre compte', 'Bonjour,\r\nDe nouvelles informations obligatoires doivent être mises à jour sur votre compte.\r\nVeuillez-vous rendre sur votre espace compte utilisateur en cliquant sur ce lien : http://microhard.fr/account/\r\nCordialement,\r\nL’équipe Microsoft.\r\n', 1, 1),
(3, 'phishing@gmail.com ', 'Mot passe', 'votre mot passe va expirer bientot\r\nrenouveler le en cliquant sur le lien la : http://comptefake.fr/compte/motpasse\r\n', 1, 1),
(4, 'notifications@votre-banque.com', 'Relevé mensuel disponible', 'Bonjour,\r\nVotre relevé du compte courant est disponible dans votre espace client. Consultez-le depuis votre espace sécurisé : https://votre-banque.fr/mon-compte/\r\n', 0, NULL),
(5, 'suivi@colissimo.fr', 'Suivi colis n°NP123456789', 'Bonjour,\r\nVotre colis NP123456789 sera livré entre le 05/11 entre 14 :00 et 18 :0. Suivez-le via votre espace client.\r\nSi vous n’êtes pas disponible sur ce créneau, veuillez en définir un nouveau sur https://colissimo.fr/suivi/np123456789/\r\n', 0, NULL),
(6, 'rh@votre-entreprise.fr', 'Bulletin de paie Octobre 2025', 'Bonjour,\r\nVotre bulletin de paie d’octobre est téléchargeable sur l’intranet RH.\r\n', 0, NULL),
(7, 'newsletter@mediatheque.fr', 'Bienvenue', 'Bonjour,\r\nMerci pour votre abonnement. Gérez vos préférences ou désabonnez-vous ici : https://mediatheque.fr/compte/\r\n', 0, NULL),
(8, 'billing@saasprovider.com', 'Facture n°F-2025-1010', 'Bonjour,\r\nVotre facture pour octobre est disponible dans votre espace facturation : https://saasprovider.com/compte/factures\r\nÉchéance : 15/11/2025\r\n', 0, NULL),
(9, 'promo@win-prize.com', 'Vous gagnez un iPhone now !!!', 'CONGRATS !! Vous etes chanceux. Repondre et envoyer coordonnee banquaire pour recevoir le prix : http://claimyourprize.com/', 1, 1),
(10, 'facebook@ami-invite.com ', 'Nouveau message', 'Veuillez rentrer vos coordonnées bancaires pour voir vos messages non lus ici : http://ami-invite.com/', 1, 1);

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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `mascotte`
--

INSERT INTO `mascotte` (`numero`, `image`, `humeur`, `salle_numero`) VALUES
(1, '/images/commun/mascotte/mascotte_face.svg', 'normale', 5);

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
) ENGINE=InnoDB AUTO_INCREMENT=511 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `mode_emploi`
--

INSERT INTO `mode_emploi` (`numero`, `explication_1`, `explication_2`, `explication_3`, `activite_numero`) VALUES
(501, '', 'Quelle(s) clé(s) USB peut-être branchée', NULL, 502),
(502, '', 'Quel objet met en danger la sécurité du manoir ?', NULL, 503),
(503, '', 'Quel poste présente un risque ?', NULL, 501),
(504, '', 'Trouver les 2 erreurs de sécurité.', NULL, 504),
(505, '', 'Comment pouvez vous éviter le tailgating en 1 clic ?', NULL, 505),
(506, '', 'Quel est le problème et la contre-mesure ? ', NULL, 506),
(507, '', 'Lister deux actions immédiates. ', NULL, 507),
(508, '', 'Marquer 3 problèmes de confidentialité.', NULL, 508),
(509, '', 'qu\'est ce qui ne respecte pas la politique \"Clean Desk\". ', NULL, 509),
(510, '', 'Quel objet pose un problème de conformité ?', NULL, 510);

-- --------------------------------------------------------

--
-- Structure de la table `mot_de_passe`
--

DROP TABLE IF EXISTS `mot_de_passe`;
CREATE TABLE IF NOT EXISTS `mot_de_passe` (
  `numero` int NOT NULL AUTO_INCREMENT,
  `motPasse` varchar(64) NOT NULL,
  PRIMARY KEY (`numero`)
) ENGINE=InnoDB AUTO_INCREMENT=98 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `mot_de_passe`
--

INSERT INTO `mot_de_passe` (`numero`, `motPasse`) VALUES
(1, '471395'),
(2, '471385'),
(3, '479513'),
(4, '479585'),
(5, '478513'),
(6, '478595'),
(7, '134795'),
(8, '134785'),
(9, '139547'),
(10, '139585'),
(11, '138547'),
(12, '138595'),
(13, '954713'),
(14, '954785'),
(15, '951347'),
(16, '951385'),
(17, '958547'),
(18, '958513'),
(19, '854713'),
(20, '854795'),
(21, '851347'),
(22, '851395'),
(23, '859547'),
(24, '859513'),
(45, 'abc123'),
(65, 'lune45bleu'),
(66, 'tigre2025'),
(67, 'soleil303'),
(68, 'pomme77vert'),
(69, 'caramel12'),
(70, 'nuage202'),
(71, 'bois99clair'),
(72, 'merBleue12'),
(73, 'chaton555'),
(74, 'plume14jaune'),
(75, 'etoile808'),
(76, 'panda1212'),
(77, 'arbre300'),
(78, 'orange44'),
(79, 'ventDoux17'),
(80, 'Bento42!mix'),
(81, 'LunA88@sky'),
(82, 'Kiro_2025#'),
(83, 'SunRise!44'),
(84, 'Wolf#92run'),
(85, 'Pixel01@go'),
(86, 'Delta7$mix'),
(87, 'MoOn_78%'),
(88, 'Arka!1122'),
(89, 'NeoWave#51'),
(90, 'Tempo93@X'),
(91, 'Nexu5!Light'),
(92, 'Orion77$up'),
(93, 'Shift_300@'),
(94, 'BlueSky!19'),
(95, 'Karvion42-b'),
(96, 'Zorliam87ax!@'),
(97, 'Farytek31z-31');

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
(20, 601, 1, 'chiffrement');

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
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
  `libelle` varchar(20) NOT NULL,
  `bouton` varchar(20) NOT NULL,
  `intro_salle` text NOT NULL,
  PRIMARY KEY (`numero`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `salle`
--

INSERT INTO `salle` (`numero`, `libelle`, `bouton`, `intro_salle`) VALUES
(1, 'Salle 1', 'Entrer', ''),
(4, 'Salle 4', 'Entrer', ''),
(5, 'Sécurité physique et', 'images/commun/retour', 'Bienvenue dans la salle de surveillance !\nPlongez au cœur de la sécurité physique et matérielle, où chaque objet, chaque dispositif et chaque comportement compte. Observez attentivement votre environnement et cliquez sur les objets lumineux pour lancer les énigmes. Préparez-vous à analyser, réagir et mettre vos compétences à l’épreuve : dans cette salle, vigilance et réflexion sont vos meilleurs alliés.');

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
) ENGINE=InnoDB AUTO_INCREMENT=402 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `type`
--

INSERT INTO `type` (`numero`, `libelle`, `explication`) VALUES
(1, 'QCM', 'Cette énigme est de type QCM, une ou plusieurs réponses sont possibles'),
(401, 'Frise chronologique', 'Reconstituer une procédure en reliant les cartes dans le bon ordre chronologique');

-- --------------------------------------------------------

--
-- Structure de la table `vpn`
--

DROP TABLE IF EXISTS `vpn`;
CREATE TABLE IF NOT EXISTS `vpn` (
  `numero` int NOT NULL AUTO_INCREMENT,
  `libelle` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`numero`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `vpn`
--

INSERT INTO `vpn` (`numero`, `libelle`) VALUES
(1, 'Un VPN ne remplace p'),
(2, 'Un VPN peut réduire '),
(3, 'Un VPN gratuit peut '),
(4, 'Les VPN d\'entreprise'),
(5, 'Un VPN peut contourn'),
(6, 'Un VPN ne protège pa'),
(7, 'Un VPN crée un tunne'),
(8, 'Un VPN ne doit jamai'),
(9, 'Les VPN sécurisent l'),
(10, 'Un VPN peut parfois '),
(11, 'Un VPN ne masque pas'),
(12, 'Les VPN ne peuvent p'),
(13, 'Un VPN peut empêcher'),
(14, 'Un VPN peut fausser '),
(15, 'Les VPN utilisent so'),
(16, 'Un VPN n’empêche pas'),
(17, 'Un VPN n’améliore pa'),
(18, 'Un VPN peut être ins'),
(19, 'Les VPN d’entreprise'),
(20, 'Un VPN peut permettr'),
(21, 'Un VPN accélère auto'),
(22, 'Un VPN rend votre ap'),
(23, 'Avec un VPN, les hac'),
(24, 'Un VPN rend toutes l'),
(25, 'Un VPN empêche compl'),
(26, 'L’utilisation d’un V'),
(27, 'Un VPN bloque automa'),
(28, 'Un VPN garantit qu’a'),
(29, 'Tous les VPN utilise'),
(30, 'Un VPN protège votre');

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
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
(20, 'Hopital_Administratif', 0, 'WPA2');

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
