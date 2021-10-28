-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : lun. 11 oct. 2021 à 11:08
-- Version du serveur :  5.7.31
-- Version de PHP : 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `room`
--

-- --------------------------------------------------------

--
-- Structure de la table `avis`
--

DROP TABLE IF EXISTS `avis`;
CREATE TABLE IF NOT EXISTS `avis` (
  `id_avis` int(3) NOT NULL AUTO_INCREMENT,
  `id_membre` int(3) DEFAULT NULL,
  `id_salle` int(3) DEFAULT NULL,
  `commentaire` text,
  `note` int(2) DEFAULT NULL,
  `date_enregistrement` datetime DEFAULT NULL,
  PRIMARY KEY (`id_avis`),
  KEY `id_membre` (`id_membre`),
  KEY `id_salle` (`id_salle`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `avis`
--

INSERT INTO `avis` (`id_avis`, `id_membre`, `id_salle`, `commentaire`, `note`, `date_enregistrement`) VALUES
(1, 1, NULL, 'bravo', 8, '2021-10-05 11:23:41'),
(2, 1, 3, 'premier test modifié ok', 8, '2021-10-05 16:16:10'),
(4, 1, 10, 'Cette salle est Iconique', 10, '2021-10-05 21:01:21'),
(5, 1, 9, 'test', 10, '2021-10-09 03:16:52'),
(6, 1, 9, 'test', 10, '2021-10-09 03:18:05'),
(7, 1, 9, 'test', 10, '2021-10-09 03:18:29');

-- --------------------------------------------------------

--
-- Structure de la table `commande`
--

DROP TABLE IF EXISTS `commande`;
CREATE TABLE IF NOT EXISTS `commande` (
  `id_commande` int(3) NOT NULL AUTO_INCREMENT,
  `id_membre` int(3) DEFAULT NULL,
  `id_produit` int(3) DEFAULT NULL,
  `date_commande` datetime DEFAULT NULL,
  PRIMARY KEY (`id_commande`),
  KEY `id_membre` (`id_membre`),
  KEY `id_produit` (`id_produit`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `commande`
--

INSERT INTO `commande` (`id_commande`, `id_membre`, `id_produit`, `date_commande`) VALUES
(2, 1, 1, '2021-10-04 10:52:25');

-- --------------------------------------------------------

--
-- Structure de la table `membre`
--

DROP TABLE IF EXISTS `membre`;
CREATE TABLE IF NOT EXISTS `membre` (
  `id_membre` int(3) NOT NULL AUTO_INCREMENT,
  `pseudo` varchar(20) DEFAULT NULL,
  `mdp` varchar(60) DEFAULT NULL,
  `nom` varchar(20) DEFAULT NULL,
  `prenom` varchar(20) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `civilite` enum('m','f') NOT NULL,
  `statut` int(1) DEFAULT NULL,
  `date_enregistrement` datetime DEFAULT NULL,
  PRIMARY KEY (`id_membre`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `membre`
--

INSERT INTO `membre` (`id_membre`, `pseudo`, `mdp`, `nom`, `prenom`, `email`, `civilite`, `statut`, `date_enregistrement`) VALUES
(1, 'admin', '$2y$10$2EGcoEb7/4CNy06XmrEE3uGhcM.5ByEUcpwsua6BMba7aANKTXPwO', 'vasconcelos', 'vanilda', 'vanilda.vas@gmail.com', 'f', 2, '2021-09-09 16:47:50'),
(2, 'test', '$2y$10$eFELb6fSaN5huKF59rtG3.joYdf8f2HV1f9in8SFDHm.dqNkPJAd6', 'vasconcelos', 'vanilda', 'vanilda.vas@gmail.com', 'f', 1, '2021-09-09 16:50:28'),
(3, 'lolo', 'laurent', 'laurentlassallette', 'laurent', 'laurent@gmail.com', 'm', 1, '2021-09-15 16:38:40'),
(4, 'Sara', '$2y$10$BkGEs9dlu.2aq21EN7UhP.vfEhQOjVKWpBXAvRtaeskFoh/YvTAo6', 'croche', 'Sara', 'saracroche@gmail.com', 'f', 1, '2021-09-16 19:01:08'),
(5, 'math', '$2y$10$gWCAPlCX6xm5V62vErRCO.TdwFCUxI3cxZn.bDcxMdmsnKfdfkLeC', 'Random', 'Mathieu', 'math@random.fr', 'm', 1, '2021-10-08 17:01:53');

-- --------------------------------------------------------

--
-- Structure de la table `produit`
--

DROP TABLE IF EXISTS `produit`;
CREATE TABLE IF NOT EXISTS `produit` (
  `id_produit` int(3) NOT NULL AUTO_INCREMENT,
  `id_salle` int(3) DEFAULT NULL,
  `date_arrivee` datetime DEFAULT NULL,
  `date_depart` datetime DEFAULT NULL,
  `prix` int(3) DEFAULT NULL,
  `etat` enum('libre','réservation') DEFAULT NULL,
  PRIMARY KEY (`id_produit`),
  KEY `id_salle` (`id_salle`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `produit`
--

INSERT INTO `produit` (`id_produit`, `id_salle`, `date_arrivee`, `date_depart`, `prix`, `etat`) VALUES
(1, 5, '2021-12-22 09:00:00', '2021-12-28 17:00:00', 950, 'libre'),
(2, 8, '2021-12-01 00:00:00', '2021-12-07 00:00:00', 1200, 'libre'),
(3, 10, '2021-11-01 00:00:00', '2021-11-08 00:00:00', 1500, 'libre'),
(4, 4, '2021-11-08 00:00:00', '2021-11-28 00:00:00', 1500, 'libre'),
(5, 17, '2021-11-01 09:00:00', '2021-11-08 17:00:00', 1800, 'libre'),
(6, 16, '2021-12-01 09:00:00', '2021-12-08 17:00:00', 1900, 'libre'),
(7, 13, '2021-11-15 09:00:00', '2021-11-30 17:00:00', 1900, 'libre'),
(8, 11, '2021-12-15 09:00:00', '2021-12-30 17:00:00', 1900, 'libre'),
(9, 12, '2021-11-20 09:00:00', '2021-12-30 17:00:00', 2500, 'libre'),
(10, 9, '2021-11-01 09:00:00', '2021-12-30 17:00:00', 2500, 'libre'),
(11, 15, '2021-11-01 09:00:00', '2021-12-30 17:00:00', 2500, 'libre'),
(12, 3, '2021-11-01 09:00:00', '2021-12-30 17:00:00', 1250, 'libre');

-- --------------------------------------------------------

--
-- Structure de la table `salle`
--

DROP TABLE IF EXISTS `salle`;
CREATE TABLE IF NOT EXISTS `salle` (
  `id_salle` int(3) NOT NULL AUTO_INCREMENT,
  `titre` varchar(200) DEFAULT NULL,
  `description` text,
  `photo` varchar(200) DEFAULT NULL,
  `pays` varchar(20) DEFAULT NULL,
  `ville` varchar(20) DEFAULT NULL,
  `adresse` varchar(50) DEFAULT NULL,
  `cp` varchar(5) DEFAULT NULL,
  `capacite` int(3) DEFAULT NULL,
  `categorie` enum('Réunion','Bureau','Conférence','Réception') DEFAULT NULL,
  PRIMARY KEY (`id_salle`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `salle`
--

INSERT INTO `salle` (`id_salle`, `titre`, `description`, `photo`, `pays`, `ville`, `adresse`, `cp`, `capacite`, `categorie`) VALUES
(3, 'Cézane', 'La salle Cézane, lumineuse et spacieuse, elle est parfaite pour toutes vos réunions d\'entreprise, vos réunions d\'affaires. Elle est équipée, pour travailler avec vos collaborateurs où qu\'ils soient, avec les dernières technologies performantes. Située près d\'un grand parc, avec de jolie allée arborée, en plein centre ville. Idéale pour changer d\'air entre les activités.', 'cezane2.jpg', 'France', 'Paris', '12, Rue de la nuit', '75014', 10, 'Réunion'),
(4, 'Stendhal', 'La salle Stendhal peut accueillir vos équipes pour les sessions de formations. Vous pouvez également y organiser vos conférences ou tout autre meeting.\r\n\r\nDes casques ainsi que des pavés tactiles sont mis à votre services.\r\nDifférentes tailles de salle peuvent être disponible', 'Stendhal.jpg', 'France', 'Lyon', '28, Boulevard de la vérité', '69000', 15, 'Formation'),
(5, 'Picasso', 'Cette salle sera parfaite pour toutes les réunions d\'entreprises.', 'picasso.jpg', 'France', 'Paris', '1, rue de l\'as de pic', '75013', 8, 'Formation'),
(8, 'Léonard', 'Cette salle sera parfaite pour toutes les réunions d\'entreprises.', 'leonard.jpg', 'France', 'Marseille', '3, Impasse de la Victoire', '13000', 8, 'Bureau'),
(9, 'Comité', 'Le comité, pour toutes vos réunions d\'entreprise, vos réunions d\'affaires. Ce bien d\'exception est situé dans un quartier d\'affaires près de monuments incontournables. Un lieux idéal pour recevoir vos collaborateurs. Elles sont équipées, pour travailler et communiquer avec vos équipes où qu\'elles soient, avec les dernières technologies performantes.', 'comite.jpg', 'France', 'Paris', '4, rue du Poney Fringant', '75012', 80, 'Réception'),
(10, 'Liana', 'Cette salle sera parfaite pour toutes les réunions d\'entreprises.', 'liana.jpg', 'France', 'Lyon', '7, Impasse Grand Pas', '69066', 10, 'Bureau'),
(11, 'Louise', 'Cette salle sera parfaite pour toutes les réunions d\'entreprises.', 'louise.jpg', 'France', 'Lyon', '7, rue des Sept Couronnes', '69520', 15, 'Formation'),
(12, 'Louis', 'Cette salle sera parfaite pour toutes les réunions d\'entreprises.', 'Louis2.jpg', 'France', 'Marseille', '12, Rue Renée Esmée', '13250', 25, 'Réunion'),
(13, 'Pivoine', 'Cette salle sera parfaite pour toutes les réunions d\'entreprises.', 'pivoine.jpg', 'France', 'Marseille', '12, Boulevard Thorin', '13275', 8, 'Bureau'),
(15, 'Dumas', 'Cette salle sera parfaite pour toutes les réunions d\'entreprises.', 'Dumas.jpg', 'France', 'Lyon', '19, Boulevard de Winterfel', '69450', 15, 'Réunion'),
(16, 'Aria', 'Cette salle sera parfaite pour toutes les réunions d\'entreprises.', 'stark.jpg', 'France', 'Paris', '19, Impasse Nicolas', '75013', 12, 'Bureau'),
(17, 'Olympe', 'Cette salle sera parfaite pour toutes les réunions d\'entreprises.', 'olympe.jpg', 'France', 'Marseille', '33, Boulevard du Vaillant Prince', '13895', 25, 'Formation');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `avis`
--
ALTER TABLE `avis`
  ADD CONSTRAINT `avis_ibfk_1` FOREIGN KEY (`id_membre`) REFERENCES `membre` (`id_membre`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `avis_ibfk_2` FOREIGN KEY (`id_salle`) REFERENCES `salle` (`id_salle`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `commande`
--
ALTER TABLE `commande`
  ADD CONSTRAINT `commande_ibfk_1` FOREIGN KEY (`id_membre`) REFERENCES `membre` (`id_membre`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `commande_ibfk_2` FOREIGN KEY (`id_produit`) REFERENCES `produit` (`id_produit`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Contraintes pour la table `produit`
--
ALTER TABLE `produit`
  ADD CONSTRAINT `produit_ibfk_1` FOREIGN KEY (`id_salle`) REFERENCES `salle` (`id_salle`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
