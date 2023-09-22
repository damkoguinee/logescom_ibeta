-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  ven. 22 sep. 2023 à 11:32
-- Version du serveur :  5.7.26
-- Version de PHP :  7.3.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `electronique`
--

-- --------------------------------------------------------

--
-- Structure de la table `achat`
--

DROP TABLE IF EXISTS `achat`;
CREATE TABLE IF NOT EXISTS `achat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_produitfac` int(50) DEFAULT NULL,
  `codebarre` varchar(50) DEFAULT NULL,
  `numcmd` varchar(15) NOT NULL,
  `numfact` varchar(50) DEFAULT NULL,
  `fournisseur` varchar(60) DEFAULT NULL,
  `designation` varchar(60) NOT NULL,
  `quantite` float NOT NULL,
  `quantiteliv` int(11) NOT NULL DEFAULT '0',
  `taux` float NOT NULL DEFAULT '1',
  `pachat` double NOT NULL,
  `previent` double DEFAULT NULL,
  `pvente` double DEFAULT NULL,
  `etat` varchar(15) NOT NULL,
  `idstockliv` int(11) NOT NULL,
  `datefact` date DEFAULT NULL,
  `datecmd` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `achat`
--

INSERT INTO `achat` (`id`, `id_produitfac`, `codebarre`, `numcmd`, `numfact`, `fournisseur`, `designation`, `quantite`, `quantiteliv`, `taux`, `pachat`, `previent`, `pvente`, `etat`, `idstockliv`, `datefact`, `datecmd`) VALUES
(1, 1144, NULL, 'bl0001', 'bl0001', '93', '05a', 10, 0, 1, 0, 0, 0, 'livre', 1, '2023-09-04', '2023-09-05 08:44:54'),
(2, 592, NULL, 'bl0001', 'bl0001', '93', '123c', 2, 0, 1, 0, 125731.53768844, 0, 'livre', 1, '2023-09-04', '2023-09-05 08:50:32'),
(3, 1144, NULL, 'bl0001', 'bl0001', '93', '05a', 10, 0, 1, 0, 0, 0, 'livre', 1, '2023-09-04', '2023-09-08 12:54:06'),
(4, 874, NULL, 'editf19', 'dffsd', '6', 'Hp 0033-i7 Ref', 20, 0, 1, 2000000, 0, 0, 'livre', 1, '2023-09-21', '2023-09-21 11:39:47'),
(5, 1141, NULL, 'editf19', 'QFE', '6', 'Hp 107a', 2, 0, 1, 1000000, 399840, 0, 'livre', 1, '2023-09-21', '2023-09-21 13:48:07'),
(6, 181, NULL, 'editf19', 'QFE', '6', 'Bag Hp', 2, 0, 1, 200000, 71001, 0, 'livre', 1, '2023-09-21', '2023-09-21 13:57:48');

-- --------------------------------------------------------

--
-- Structure de la table `achat_fournisseur`
--

DROP TABLE IF EXISTS `achat_fournisseur`;
CREATE TABLE IF NOT EXISTS `achat_fournisseur` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `numedit` varchar(150) DEFAULT NULL,
  `id_client` int(10) DEFAULT NULL,
  `libelle` varchar(150) DEFAULT NULL,
  `bl` varchar(150) DEFAULT NULL,
  `nature` varchar(150) DEFAULT NULL,
  `etat_achatf` varchar(15) NOT NULL DEFAULT 'non paye',
  `montant` double DEFAULT NULL,
  `devise` varchar(10) DEFAULT NULL,
  `lieuvente` int(2) DEFAULT NULL,
  `dateop` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `achat_fournisseur`
--

INSERT INTO `achat_fournisseur` (`id`, `numedit`, `id_client`, `libelle`, `bl`, `nature`, `etat_achatf`, `montant`, `devise`, `lieuvente`, `dateop`) VALUES
(17, 'editf1', 93, 'achat ordinateur', 'bl0001', 'achat', 'non paye', 20000000, 'gnf', 1, '2023-09-04 16:14:59'),
(18, 'editf18', 6, 'achat hp', 'dffsd', 'achat', 'non paye', 200000, 'gnf', 1, '2023-09-21 11:37:43'),
(19, 'editf19', 6, 'achat ordi', 'QFE', 'achat', 'non paye', 10000000, 'gnf', 1, '2023-09-21 13:12:19');

-- --------------------------------------------------------

--
-- Structure de la table `adresse`
--

DROP TABLE IF EXISTS `adresse`;
CREATE TABLE IF NOT EXISTS `adresse` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom_mag` varchar(255) NOT NULL,
  `type_mag` varchar(255) NOT NULL,
  `adresse` varchar(500) NOT NULL,
  `initial` varchar(5) DEFAULT NULL,
  `lieuvente` int(11) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `adresse`
--

INSERT INTO `adresse` (`id`, `nom_mag`, `type_mag`, `adresse`, `initial`, `lieuvente`) VALUES
(2, 'IBETAMULTISERVICES', 'Magasin Electronique', 'Rep Guinée/Conakry', 'ibe', 1);

-- --------------------------------------------------------

--
-- Structure de la table `banque`
--

DROP TABLE IF EXISTS `banque`;
CREATE TABLE IF NOT EXISTS `banque` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `clientbanque` varchar(11) DEFAULT '1',
  `id_banque` varchar(20) NOT NULL,
  `numero` varchar(15) NOT NULL,
  `typeent` varchar(50) DEFAULT NULL,
  `origine` varchar(50) DEFAULT NULL,
  `libelles` varchar(150) NOT NULL,
  `montant` float DEFAULT NULL,
  `devise` varchar(50) NOT NULL DEFAULT 'gnf',
  `typep` varchar(50) NOT NULL DEFAULT 'especes',
  `numeropaie` varchar(50) DEFAULT NULL,
  `banqcheque` varchar(50) DEFAULT NULL,
  `lieuvente` varchar(10) DEFAULT NULL,
  `date_versement` datetime NOT NULL,
  `datesaisie` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=192 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `banque`
--

INSERT INTO `banque` (`id`, `clientbanque`, `id_banque`, `numero`, `typeent`, `origine`, `libelles`, `montant`, `devise`, `typep`, `numeropaie`, `banqcheque`, `lieuvente`, `date_versement`, `datesaisie`) VALUES
(1, '1', '1', 'venteibe230080', 'vente', 'vente credit', 'vente n°ibe230080', NULL, 'gnf', 'especes', '', '', '1', '2023-07-27 10:11:00', '2023-07-27 12:11:04'),
(2, '1', '1', 'venteibe230080', 'vente', 'vente credit', 'vente n°ibe230080', NULL, 'eu', 'especes', '', '', '1', '2023-07-27 10:11:00', '2023-07-27 12:11:04'),
(3, '1', '1', 'venteibe230080', 'vente', 'vente credit', 'vente n°ibe230080', NULL, 'us', 'especes', '', '', '1', '2023-07-27 10:11:00', '2023-07-27 12:11:04'),
(4, '1', '1', 'venteibe230080', 'vente', 'vente credit', 'vente n°ibe230080', NULL, 'cfa', 'especes', '', '', '1', '2023-07-27 10:11:00', '2023-07-27 12:11:04'),
(5, '1', '1', 'venteibe230081', 'vente', 'vente credit', 'vente n°ibe230081', 100000, 'gnf', 'especes', '', '', '1', '2023-07-27 10:11:00', '2023-07-27 12:11:42'),
(6, '1', '1', 'venteibe230081', 'vente', 'vente credit', 'vente n°ibe230081', 0, 'eu', 'especes', '', '', '1', '2023-07-27 10:11:00', '2023-07-27 12:11:42'),
(7, '1', '1', 'venteibe230081', 'vente', 'vente credit', 'vente n°ibe230081', 0, 'us', 'especes', '', '', '1', '2023-07-27 10:11:00', '2023-07-27 12:11:42'),
(8, '1', '1', 'venteibe230081', 'vente', 'vente credit', 'vente n°ibe230081', 0, 'cfa', 'especes', '', '', '1', '2023-07-27 10:11:00', '2023-07-27 12:11:42'),
(9, '1', '1', 'venteibe230082', 'vente', 'vente cash', 'vente n°ibe230082', 200000, 'gnf', 'especes', '', '', '1', '2023-07-27 10:12:00', '2023-07-27 12:12:26'),
(10, '1', '1', 'venteibe230082', 'vente', 'vente cash', 'vente n°ibe230082', 0, 'eu', 'especes', '', '', '1', '2023-07-27 10:12:00', '2023-07-27 12:12:26'),
(11, '1', '1', 'venteibe230082', 'vente', 'vente cash', 'vente n°ibe230082', 0, 'us', 'especes', '', '', '1', '2023-07-27 10:12:00', '2023-07-27 12:12:26'),
(12, '1', '1', 'venteibe230082', 'vente', 'vente cash', 'vente n°ibe230082', 0, 'cfa', 'especes', '', '', '1', '2023-07-27 10:12:00', '2023-07-27 12:12:26'),
(13, '26', '1', 'venteibe230083', 'vente', 'vente cash', 'vente n°ibe230083', 200000, 'gnf', 'especes', '', '', '1', '2023-07-27 10:48:00', '2023-07-27 12:48:53'),
(14, '26', '1', 'venteibe230083', 'vente', 'vente cash', 'vente n°ibe230083', 0, 'eu', 'especes', '', '', '1', '2023-07-27 10:48:00', '2023-07-27 12:48:53'),
(15, '26', '1', 'venteibe230083', 'vente', 'vente cash', 'vente n°ibe230083', 0, 'us', 'especes', '', '', '1', '2023-07-27 10:48:00', '2023-07-27 12:48:53'),
(16, '26', '1', 'venteibe230083', 'vente', 'vente cash', 'vente n°ibe230083', 0, 'cfa', 'especes', '', '', '1', '2023-07-27 10:48:00', '2023-07-27 12:48:53'),
(17, '102', '1', 'venteibe230084', 'vente', 'vente credit', 'vente n°ibe230084', NULL, 'gnf', 'especes', '', '', '1', '2023-07-27 10:49:00', '2023-07-27 12:49:14'),
(18, '102', '1', 'venteibe230084', 'vente', 'vente credit', 'vente n°ibe230084', NULL, 'eu', 'especes', '', '', '1', '2023-07-27 10:49:00', '2023-07-27 12:49:14'),
(19, '102', '1', 'venteibe230084', 'vente', 'vente credit', 'vente n°ibe230084', NULL, 'us', 'especes', '', '', '1', '2023-07-27 10:49:00', '2023-07-27 12:49:14'),
(20, '102', '1', 'venteibe230084', 'vente', 'vente credit', 'vente n°ibe230084', NULL, 'cfa', 'especes', '', '', '1', '2023-07-27 10:49:00', '2023-07-27 12:49:14'),
(21, NULL, '1', 'venteibe230085', 'vente', 'vente cash', 'vente n°ibe230085', 200000, 'gnf', 'especes', '', '', '1', '2023-07-27 11:08:00', '2023-07-27 13:08:50'),
(22, NULL, '1', 'venteibe230085', 'vente', 'vente cash', 'vente n°ibe230085', 0, 'eu', 'especes', '', '', '1', '2023-07-27 11:08:00', '2023-07-27 13:08:50'),
(23, NULL, '1', 'venteibe230085', 'vente', 'vente cash', 'vente n°ibe230085', 0, 'us', 'especes', '', '', '1', '2023-07-27 11:08:00', '2023-07-27 13:08:50'),
(24, NULL, '1', 'venteibe230085', 'vente', 'vente cash', 'vente n°ibe230085', 0, 'cfa', 'especes', '', '', '1', '2023-07-27 11:08:00', '2023-07-27 13:08:50'),
(44, '1', '1', 'retd3', 'depense', 'depense', 'transport repas', -100000, 'gnf', 'especes', NULL, NULL, '1', '2023-08-10 00:00:00', '2023-08-20 09:55:32'),
(43, 'pers2', '1', 'bonp2', 'bon', 'personnel', 'pret ismael', -10000000, 'gnf', 'especes', NULL, NULL, '1', '2023-08-20 07:50:00', '2023-08-20 09:50:54'),
(42, 'pers55', '1', 'rembp1', 'remboursbon', 'personnel', 'remboursement', 100000, 'gnf', 'especes', NULL, NULL, '1', '2023-08-20 07:42:00', '2023-08-20 09:42:03'),
(30, '6', '1', 'dep18', 'depot', 'client', 'emprunt', 2000, 'eu', 'espèces', '', '', '1', '2023-08-07 12:58:39', '2023-08-07 12:58:39'),
(41, 'pers3', '1', 'retd2', 'salaire', 'personnel', 'paiement personnel', -1000000, 'gnf', 'especes', NULL, NULL, '1', '2023-08-20 07:16:00', '2023-08-20 09:16:41'),
(31, '6', '1', 'dep19', 'depot', 'client', 'paiement', 50000000, 'gnf', 'espèces', '', '', '1', '2023-08-07 13:02:33', '2023-08-07 13:02:33'),
(32, '1', '1', 'devisea3', 'echange', 'echange', 'amadou', 200, 'eu', 'especes', NULL, NULL, '1', '2023-08-07 11:02:00', '2023-08-07 13:02:38'),
(33, '1', '1', 'devisea3', 'echange', 'echange', 'Amadou', -2000000, 'gnf', 'especes', NULL, NULL, '1', '2023-08-07 11:02:00', '2023-08-07 13:02:38'),
(34, '7', '1', 'dep20', 'depot', 'client', 'paiement facture', 20000000, 'gnf', 'espèces', '', '', '1', '2023-08-08 15:12:04', '2023-08-08 15:12:04'),
(35, '7', '1', 'dep21', 'depot', 'client', 'paiement facture remis par nnn', 50000000, 'gnf', 'espèces', '', '', '1', '2023-08-08 15:24:06', '2023-08-08 15:24:06'),
(37, '6', '1', 'dep22', 'depot', 'client', 'paiementv facture par devise', 500, 'eu', 'espèces', '', '', '1', '2023-08-08 15:38:57', '2023-08-08 15:38:57'),
(38, '15', '193', 'dep24', 'depot', 'client', 'paiement facture', 10000000, 'gnf', 'virement', '', '', '1', '2023-08-19 16:43:42', '2023-08-19 16:43:42'),
(39, 'pers55', '1', 'bonp1', 'bon', 'personnel', 'pret mouctar', -100000, 'gnf', 'especes', NULL, NULL, '1', '2023-08-19 16:22:00', '2023-08-19 18:22:30'),
(40, 'pers2', '1', 'retd1', 'salaire', 'personnel', 'paiement personnel', -10000000, 'gnf', 'especes', NULL, NULL, '1', '2023-08-20 07:07:00', '2023-08-20 09:07:16'),
(45, '1', '1', 'retd4', 'depense', 'depense', 'carburant personnel', -250000, 'gnf', 'especes', NULL, NULL, '1', '2023-08-20 09:56:01', '2023-08-20 09:56:01'),
(46, '1', '1', 'venteibe230086', 'vente', 'vente cash', 'vente n°ibe230086', 4300000, 'gnf', 'especes', '', '', '1', '2023-08-20 08:19:00', '2023-08-20 10:19:41'),
(47, '1', '1', 'venteibe230086', 'vente', 'vente cash', 'vente n°ibe230086', 0, 'eu', 'especes', '', '', '1', '2023-08-20 08:19:00', '2023-08-20 10:19:41'),
(48, '1', '1', 'venteibe230086', 'vente', 'vente cash', 'vente n°ibe230086', 0, 'us', 'especes', '', '', '1', '2023-08-20 08:19:00', '2023-08-20 10:19:41'),
(49, '1', '1', 'venteibe230086', 'vente', 'vente cash', 'vente n°ibe230086', 0, 'cfa', 'especes', '', '', '1', '2023-08-20 08:19:00', '2023-08-20 10:19:41'),
(50, '17', '1', 'dep25', 'depot', 'client', 'paiement', 20000000, 'gnf', 'espèces', '', '', '1', '2023-08-20 10:46:10', '2023-08-20 10:46:10'),
(51, '6', '1', 'ret1', 'retrait', 'client', 'pr&ecirc;t ', -5000000, 'gnf', 'especes', '', '', '1', '2023-08-27 09:48:00', '2023-08-27 11:48:28'),
(52, '6', '1', 'ret2', 'retrait', 'client', 'PRET ', -1000000, 'gnf', 'especes', '', '', '1', '2023-08-27 09:50:00', '2023-08-27 11:50:28'),
(53, '7', '193', 'ret3', 'retrait', 'client', 'pret', -10000000, 'gnf', 'especes', '', '', '1', '2023-08-27 09:57:00', '2023-08-27 11:57:35'),
(54, '7', '1', 'ret4', 'retrait', 'client', 'pret', -100000, 'gnf', 'especes', '', '', '1', '2023-08-27 09:59:00', '2023-08-27 11:59:38'),
(55, '6', '1', 'dep26', 'depot', 'client', 'paiement facture', 20000000, 'gnf', 'espèces', '', '', '1', '2023-08-27 10:28:00', '2023-08-27 12:28:12'),
(56, '6', '1', 'dep27', 'depot', 'client', 'PAIEMENT RESTE ', 1000000, 'gnf', 'espèces', '', '', '1', '2023-08-27 10:29:00', '2023-08-27 12:29:15'),
(57, '', '1', 'depr1', 'recette', 'recette', 'recette camion', 200000, 'gnf', 'especes', NULL, NULL, '1', '2023-08-27 11:11:00', '2023-08-27 13:11:08'),
(58, '', '1', '58', 'transfert', 'transfert', 'retrait(transfert des fonds)', -200000, 'gnf', 'especes', NULL, NULL, '1', '2023-08-27 15:26:00', '2023-08-27 17:26:40'),
(59, '', '193', '58', 'transfert', 'transfert', 'depot(transfert des fonds)', 200000, 'gnf', 'especes', NULL, NULL, '1', '2023-08-27 15:26:00', '2023-08-27 17:26:40'),
(60, '7', '1', 'dep28', 'depot', 'client', 'PAIEMENT FACTURE', 20000, 'us', 'espèces', '', '', '1', '2023-08-27 15:30:00', '2023-08-27 17:30:58'),
(61, '', '1', 'ta1', 'transfert argent', 'pre-cmd', 'cmd1', -5000, 'us', 'virement', 'bor20002', '', '1', '2023-08-27 17:36:48', '2023-08-27 17:36:48'),
(62, '1', '1', 'venteibe230087', 'vente', 'vente cash', 'vente n°ibe230087', 200000, 'gnf', 'especes', '', '', '1', '2023-08-27 04:01:00', '2023-08-27 18:01:17'),
(63, '1', '1', 'venteibe230087', 'vente', 'vente cash', 'vente n°ibe230087', 0, 'eu', 'especes', '', '', '1', '2023-08-27 04:01:00', '2023-08-27 18:01:17'),
(64, '1', '1', 'venteibe230087', 'vente', 'vente cash', 'vente n°ibe230087', 0, 'us', 'especes', '', '', '1', '2023-08-27 04:01:00', '2023-08-27 18:01:17'),
(65, '1', '1', 'venteibe230087', 'vente', 'vente cash', 'vente n°ibe230087', 0, 'cfa', 'especes', '', '', '1', '2023-08-27 04:01:00', '2023-08-27 18:01:17'),
(66, '1', '1', 'venteibe230088', 'vente', 'vente cash', 'vente n°ibe230088', 200000, 'gnf', 'especes', '', '', '1', '2023-08-27 04:03:00', '2023-08-27 18:03:56'),
(67, '1', '1', 'venteibe230088', 'vente', 'vente cash', 'vente n°ibe230088', 0, 'eu', 'especes', '', '', '1', '2023-08-27 04:03:00', '2023-08-27 18:03:56'),
(68, '1', '1', 'venteibe230088', 'vente', 'vente cash', 'vente n°ibe230088', 0, 'us', 'especes', '', '', '1', '2023-08-27 04:03:00', '2023-08-27 18:03:56'),
(69, '1', '1', 'venteibe230088', 'vente', 'vente cash', 'vente n°ibe230088', 0, 'cfa', 'especes', '', '', '1', '2023-08-27 04:03:00', '2023-08-27 18:03:56'),
(70, '1', '1', 'venteibe230089', 'vente', 'vente cash', 'vente n°ibe230089', 800000, 'gnf', 'especes', '', '', '1', '2023-09-02 09:11:00', '2023-09-02 11:11:36'),
(71, '1', '1', 'venteibe230089', 'vente', 'vente cash', 'vente n°ibe230089', 0, 'eu', 'especes', '', '', '1', '2023-09-02 09:11:00', '2023-09-02 11:11:36'),
(72, '1', '1', 'venteibe230089', 'vente', 'vente cash', 'vente n°ibe230089', 0, 'us', 'especes', '', '', '1', '2023-09-02 09:11:00', '2023-09-02 11:11:36'),
(73, '1', '1', 'venteibe230089', 'vente', 'vente cash', 'vente n°ibe230089', 0, 'cfa', 'especes', '', '', '1', '2023-09-02 09:11:00', '2023-09-02 11:11:36'),
(83, '1', '1', 'venteibe230091', 'vente', 'vente cash', 'retour vente cash ibe230091', -200000, 'gnf', 'especes', NULL, NULL, '1', '2023-09-02 13:14:29', '2023-09-02 13:14:29'),
(82, '1', '1', 'venteibe230091', 'vente', 'vente cash', 'vente n°ibe230091', 0, 'cfa', 'especes', '', '', '1', '2023-09-02 11:12:00', '2023-09-02 13:12:12'),
(81, '1', '1', 'venteibe230091', 'vente', 'vente cash', 'vente n°ibe230091', 0, 'us', 'especes', '', '', '1', '2023-09-02 11:12:00', '2023-09-02 13:12:12'),
(80, '1', '1', 'venteibe230091', 'vente', 'vente cash', 'vente n°ibe230091', 0, 'eu', 'especes', '', '', '1', '2023-09-02 11:12:00', '2023-09-02 13:12:12'),
(79, '1', '1', 'venteibe230091', 'vente', 'vente cash', 'vente n°ibe230091', 10600000, 'gnf', 'especes', '', '', '1', '2023-09-02 11:12:00', '2023-09-02 13:12:12'),
(84, '1', '1', 'venteibe230091', 'vente', 'vente cash', 'retour vente cash ibe230091', -5000000, 'gnf', 'especes', NULL, NULL, '1', '2023-09-02 13:19:14', '2023-09-02 13:19:14'),
(85, '1', '1', 'venteibe230091', 'vente', 'vente cash', 'retour vente cash ibe230091', -200000, 'gnf', 'especes', NULL, NULL, '1', '2023-09-02 13:20:47', '2023-09-02 13:20:47'),
(97, '1', '1', 'venteibe230093', 'vente', 'vente cash', 'retour vente cash ibe230093', -190000, 'gnf', 'especes', NULL, NULL, '1', '2023-09-02 13:43:08', '2023-09-02 13:43:08'),
(96, '1', '1', 'venteibe230093', 'vente', 'vente cash', 'vente n°ibe230093', 0, 'cfa', 'especes', '', '', '1', '2023-09-02 11:42:00', '2023-09-02 13:42:35'),
(95, '1', '1', 'venteibe230093', 'vente', 'vente cash', 'vente n°ibe230093', 0, 'us', 'especes', '', '', '1', '2023-09-02 11:42:00', '2023-09-02 13:42:35'),
(94, '1', '1', 'venteibe230093', 'vente', 'vente cash', 'vente n°ibe230093', 0, 'eu', 'especes', '', '', '1', '2023-09-02 11:42:00', '2023-09-02 13:42:35'),
(93, '1', '1', 'venteibe230093', 'vente', 'vente cash', 'vente n°ibe230093', 6070000, 'gnf', 'especes', '', '', '1', '2023-09-02 11:42:00', '2023-09-02 13:42:35'),
(92, '1', '1', 'venteibe230089', 'vente', 'vente cash', 'retour vente cash ibe230089', -200000, 'gnf', 'especes', NULL, NULL, '1', '2023-09-02 13:31:03', '2023-09-02 13:31:03'),
(98, '1', '1', 'venteibe230093', 'vente', 'vente cash', 'retour vente cash ibe230093', -190000, 'gnf', 'especes', NULL, NULL, '1', '2023-09-02 13:43:50', '2023-09-02 13:43:50'),
(99, '1', '1', 'venteibe230094', 'vente', 'vente cash', 'vente n°ibe230094', 1190000, 'gnf', 'especes', '', '', '1', '2023-09-02 11:48:00', '2023-09-02 13:48:33'),
(100, '1', '1', 'venteibe230094', 'vente', 'vente cash', 'vente n°ibe230094', 0, 'eu', 'especes', '', '', '1', '2023-09-02 11:48:00', '2023-09-02 13:48:33'),
(101, '1', '1', 'venteibe230094', 'vente', 'vente cash', 'vente n°ibe230094', 0, 'us', 'especes', '', '', '1', '2023-09-02 11:48:00', '2023-09-02 13:48:33'),
(102, '1', '1', 'venteibe230094', 'vente', 'vente cash', 'vente n°ibe230094', 0, 'cfa', 'especes', '', '', '1', '2023-09-02 11:48:00', '2023-09-02 13:48:33'),
(103, '1', '1', 'venteibe230094', 'vente', 'vente cash', 'retour vente cash ibe230094', -200000, 'gnf', 'especes', NULL, NULL, '1', '2023-09-02 13:48:44', '2023-09-02 13:48:44'),
(104, '1', '1', 'venteibe230094', 'vente', 'vente cash', 'retour vente cash ibe230094', -400000, 'gnf', 'especes', NULL, NULL, '1', '2023-09-02 13:50:38', '2023-09-02 13:50:38'),
(105, '1', '1', 'venteibe230095', 'vente', 'vente cash', 'vente n°ibe230095', 200000, 'gnf', 'especes', '', '', '1', '2023-09-02 11:52:00', '2023-09-02 13:52:14'),
(106, '1', '1', 'venteibe230095', 'vente', 'vente cash', 'vente n°ibe230095', 0, 'eu', 'especes', '', '', '1', '2023-09-02 11:52:00', '2023-09-02 13:52:14'),
(107, '1', '1', 'venteibe230095', 'vente', 'vente cash', 'vente n°ibe230095', 0, 'us', 'especes', '', '', '1', '2023-09-02 11:52:00', '2023-09-02 13:52:14'),
(108, '1', '1', 'venteibe230095', 'vente', 'vente cash', 'vente n°ibe230095', 0, 'cfa', 'especes', '', '', '1', '2023-09-02 11:52:00', '2023-09-02 13:52:14'),
(109, '1', '1', 'venteibe230094', 'vente', 'vente cash', 'retour vente cash ibe230094', -800000, 'gnf', 'especes', NULL, NULL, '1', '2023-09-02 13:52:31', '2023-09-02 13:52:31'),
(110, '1', '1', 'venteibe230094', 'vente', 'vente cash', 'retour vente cash ibe230094', -190000, 'gnf', 'especes', NULL, NULL, '1', '2023-09-02 13:54:08', '2023-09-02 13:54:08'),
(111, '1', '1', 'venteibe230096', 'vente', 'vente cash', 'vente n°ibe230096', 800000, 'gnf', 'especes', '', '', '1', '2023-09-02 11:55:00', '2023-09-02 13:55:09'),
(112, '1', '1', 'venteibe230096', 'vente', 'vente cash', 'vente n°ibe230096', 0, 'eu', 'especes', '', '', '1', '2023-09-02 11:55:00', '2023-09-02 13:55:09'),
(113, '1', '1', 'venteibe230096', 'vente', 'vente cash', 'vente n°ibe230096', 0, 'us', 'especes', '', '', '1', '2023-09-02 11:55:00', '2023-09-02 13:55:09'),
(114, '1', '1', 'venteibe230096', 'vente', 'vente cash', 'vente n°ibe230096', 0, 'cfa', 'especes', '', '', '1', '2023-09-02 11:55:00', '2023-09-02 13:55:09'),
(115, '1', '1', 'venteibe230096', 'vente', 'vente cash', 'retour vente cash ibe230096', -200000, 'gnf', 'especes', NULL, NULL, '1', '2023-09-02 13:55:37', '2023-09-02 13:55:37'),
(116, '1', '1', 'venteibe230096', 'vente', 'vente cash', 'retour vente cash ibe230096', -400000, 'gnf', 'especes', NULL, NULL, '1', '2023-09-02 13:55:52', '2023-09-02 13:55:52'),
(117, '1', '1', 'venteibe230097', 'vente', 'vente cash', 'vente n°ibe230097', 800000, 'gnf', 'especes', '', '', '1', '2023-09-02 11:57:00', '2023-09-02 13:57:20'),
(118, '1', '1', 'venteibe230097', 'vente', 'vente cash', 'vente n°ibe230097', 0, 'eu', 'especes', '', '', '1', '2023-09-02 11:57:00', '2023-09-02 13:57:20'),
(119, '1', '1', 'venteibe230097', 'vente', 'vente cash', 'vente n°ibe230097', 0, 'us', 'especes', '', '', '1', '2023-09-02 11:57:00', '2023-09-02 13:57:20'),
(120, '1', '1', 'venteibe230097', 'vente', 'vente cash', 'vente n°ibe230097', 0, 'cfa', 'especes', '', '', '1', '2023-09-02 11:57:00', '2023-09-02 13:57:20'),
(121, '1', '1', 'venteibe230097', 'vente', 'vente cash', 'retour vente cash ibe230097', -200000, 'gnf', 'especes', NULL, NULL, '1', '2023-09-02 13:57:41', '2023-09-02 13:57:41'),
(122, '1', '1', 'venteibe230097', 'vente', 'vente cash', 'retour vente cash ibe230097', -400000, 'gnf', 'especes', NULL, NULL, '1', '2023-09-02 13:58:03', '2023-09-02 13:58:03'),
(123, '1', '1', 'venteibe230098', 'vente', 'vente cash', 'vente n°ibe230098', 800000, 'gnf', 'especes', '', '', '1', '2023-09-02 12:03:00', '2023-09-02 14:03:28'),
(124, '1', '1', 'venteibe230098', 'vente', 'vente cash', 'vente n°ibe230098', 0, 'eu', 'especes', '', '', '1', '2023-09-02 12:03:00', '2023-09-02 14:03:28'),
(125, '1', '1', 'venteibe230098', 'vente', 'vente cash', 'vente n°ibe230098', 0, 'us', 'especes', '', '', '1', '2023-09-02 12:03:00', '2023-09-02 14:03:28'),
(126, '1', '1', 'venteibe230098', 'vente', 'vente cash', 'vente n°ibe230098', 0, 'cfa', 'especes', '', '', '1', '2023-09-02 12:03:00', '2023-09-02 14:03:28'),
(127, '1', '1', 'venteibe230098', 'vente', 'vente cash', 'retour vente cash ibe230098', -200000, 'gnf', 'especes', NULL, NULL, '1', '2023-09-02 14:03:44', '2023-09-02 14:03:44'),
(128, '1', '1', 'venteibe230098', 'vente', 'vente cash', 'retour vente cash ibe230098', -200000, 'gnf', 'especes', NULL, NULL, '1', '2023-09-02 14:03:57', '2023-09-02 14:03:57'),
(129, '1', '1', 'venteibe230099', 'vente', 'vente cash', 'vente n°ibe230099', 150000, 'gnf', 'especes', '', '', '1', '2023-09-02 12:06:00', '2023-09-02 14:06:26'),
(130, '1', '1', 'venteibe230099', 'vente', 'vente cash', 'vente n°ibe230099', 0, 'eu', 'especes', '', '', '1', '2023-09-02 12:06:00', '2023-09-02 14:06:26'),
(131, '1', '1', 'venteibe230099', 'vente', 'vente cash', 'vente n°ibe230099', 0, 'us', 'especes', '', '', '1', '2023-09-02 12:06:00', '2023-09-02 14:06:26'),
(132, '1', '1', 'venteibe230099', 'vente', 'vente cash', 'vente n°ibe230099', 0, 'cfa', 'especes', '', '', '1', '2023-09-02 12:06:00', '2023-09-02 14:06:26'),
(133, '93', '1', 'venteibe230100', 'vente', 'vente credit', 'vente n°ibe230100', NULL, 'gnf', 'especes', '', '', '1', '2023-09-04 09:07:00', '2023-09-04 11:07:54'),
(134, '93', '1', 'venteibe230100', 'vente', 'vente credit', 'vente n°ibe230100', NULL, 'eu', 'especes', '', '', '1', '2023-09-04 09:07:00', '2023-09-04 11:07:54'),
(135, '93', '1', 'venteibe230100', 'vente', 'vente credit', 'vente n°ibe230100', NULL, 'us', 'especes', '', '', '1', '2023-09-04 09:07:00', '2023-09-04 11:07:54'),
(136, '93', '1', 'venteibe230100', 'vente', 'vente credit', 'vente n°ibe230100', NULL, 'cfa', 'especes', '', '', '1', '2023-09-04 09:07:00', '2023-09-04 11:07:54'),
(137, '93', '1', 'venteibe230101', 'vente', 'vente credit', 'vente n°ibe230101', 80000, 'gnf', 'especes', '', '', '1', '2023-09-04 10:26:00', '2023-09-04 12:26:43'),
(138, '93', '1', 'venteibe230101', 'vente', 'vente credit', 'vente n°ibe230101', 0, 'eu', 'especes', '', '', '1', '2023-09-04 10:26:00', '2023-09-04 12:26:43'),
(139, '93', '1', 'venteibe230101', 'vente', 'vente credit', 'vente n°ibe230101', 0, 'us', 'especes', '', '', '1', '2023-09-04 10:26:00', '2023-09-04 12:26:43'),
(140, '93', '1', 'venteibe230101', 'vente', 'vente credit', 'vente n°ibe230101', 0, 'cfa', 'especes', '', '', '1', '2023-09-04 10:26:00', '2023-09-04 12:26:43'),
(141, '93', '1', 'dep29', 'depot', 'client', 'payement facture', 10000000, 'gnf', 'especes', '', '', '1', '2023-09-04 10:28:00', '2023-09-04 12:28:27'),
(143, '93', '1', 'venteibe230102', 'vente', 'vente credit', 'vente n°ibe230102', NULL, 'gnf', 'especes', '', '', '1', '2023-09-11 10:31:00', '2023-09-11 12:31:22'),
(144, '93', '1', 'venteibe230102', 'vente', 'vente credit', 'vente n°ibe230102', NULL, 'eu', 'especes', '', '', '1', '2023-09-11 10:31:00', '2023-09-11 12:31:22'),
(145, '93', '1', 'venteibe230102', 'vente', 'vente credit', 'vente n°ibe230102', NULL, 'us', 'especes', '', '', '1', '2023-09-11 10:31:00', '2023-09-11 12:31:22'),
(146, '93', '1', 'venteibe230102', 'vente', 'vente credit', 'vente n°ibe230102', NULL, 'cfa', 'especes', '', '', '1', '2023-09-11 10:31:00', '2023-09-11 12:31:22'),
(147, '6', '1', 'venteibe230103', 'vente', 'vente credit', 'vente n°ibe230103', NULL, 'gnf', 'especes', '', '', '1', '2023-09-11 11:21:00', '2023-09-11 13:21:17'),
(148, '6', '1', 'venteibe230103', 'vente', 'vente credit', 'vente n°ibe230103', NULL, 'eu', 'especes', '', '', '1', '2023-09-11 11:21:00', '2023-09-11 13:21:17'),
(149, '6', '1', 'venteibe230103', 'vente', 'vente credit', 'vente n°ibe230103', NULL, 'us', 'especes', '', '', '1', '2023-09-11 11:21:00', '2023-09-11 13:21:17'),
(150, '6', '1', 'venteibe230103', 'vente', 'vente credit', 'vente n°ibe230103', NULL, 'cfa', 'especes', '', '', '1', '2023-09-11 11:21:00', '2023-09-11 13:21:17'),
(151, '6', '1', 'venteibe230104', 'vente', 'vente credit', 'vente n°ibe230104', NULL, 'gnf', 'especes', '', '', '1', '2023-09-11 11:22:00', '2023-09-11 13:22:17'),
(152, '6', '1', 'venteibe230104', 'vente', 'vente credit', 'vente n°ibe230104', NULL, 'eu', 'especes', '', '', '1', '2023-09-11 11:22:00', '2023-09-11 13:22:17'),
(153, '6', '1', 'venteibe230104', 'vente', 'vente credit', 'vente n°ibe230104', NULL, 'us', 'especes', '', '', '1', '2023-09-11 11:22:00', '2023-09-11 13:22:17'),
(154, '6', '1', 'venteibe230104', 'vente', 'vente credit', 'vente n°ibe230104', NULL, 'cfa', 'especes', '', '', '1', '2023-09-11 11:22:00', '2023-09-11 13:22:17'),
(155, '183', '1', 'venteibe230105', 'vente', 'vente credit', 'vente n°ibe230105', NULL, 'gnf', 'especes', '', '', '1', '2023-09-11 11:25:00', '2023-09-11 13:25:05'),
(156, '183', '1', 'venteibe230105', 'vente', 'vente credit', 'vente n°ibe230105', NULL, 'eu', 'especes', '', '', '1', '2023-09-11 11:25:00', '2023-09-11 13:25:05'),
(157, '183', '1', 'venteibe230105', 'vente', 'vente credit', 'vente n°ibe230105', NULL, 'us', 'especes', '', '', '1', '2023-09-11 11:25:00', '2023-09-11 13:25:05'),
(158, '183', '1', 'venteibe230105', 'vente', 'vente credit', 'vente n°ibe230105', NULL, 'cfa', 'especes', '', '', '1', '2023-09-11 11:25:00', '2023-09-11 13:25:05'),
(159, '1', '1', 'venteibe230106', 'vente', 'vente cash', 'vente n°ibe230106', 2000000, 'gnf', 'especes', '', '', '1', '2023-09-12 06:43:00', '2023-09-12 20:43:35'),
(160, '1', '1', 'venteibe230106', 'vente', 'vente cash', 'vente n°ibe230106', 0, 'eu', 'especes', '', '', '1', '2023-09-12 06:43:00', '2023-09-12 20:43:35'),
(161, '1', '1', 'venteibe230106', 'vente', 'vente cash', 'vente n°ibe230106', 0, 'us', 'especes', '', '', '1', '2023-09-12 06:43:00', '2023-09-12 20:43:35'),
(162, '1', '1', 'venteibe230106', 'vente', 'vente cash', 'vente n°ibe230106', 0, 'cfa', 'especes', '', '', '1', '2023-09-12 06:43:00', '2023-09-12 20:43:35'),
(163, '1', '1', 'venteibe230107', 'vente', 'vente cash', 'vente n°ibe230107', 200000, 'gnf', 'especes', '', '', '1', '2023-09-12 06:45:00', '2023-09-12 20:45:17'),
(164, '1', '1', 'venteibe230107', 'vente', 'vente cash', 'vente n°ibe230107', 0, 'eu', 'especes', '', '', '1', '2023-09-12 06:45:00', '2023-09-12 20:45:17'),
(165, '1', '1', 'venteibe230107', 'vente', 'vente cash', 'vente n°ibe230107', 0, 'us', 'especes', '', '', '1', '2023-09-12 06:45:00', '2023-09-12 20:45:17'),
(166, '1', '1', 'venteibe230107', 'vente', 'vente cash', 'vente n°ibe230107', 0, 'cfa', 'especes', '', '', '1', '2023-09-12 06:45:00', '2023-09-12 20:45:17'),
(167, '6', '1', 'dep30', 'depot', 'client', 'PAIZEMRNT', 9000000, 'gnf', 'especes', '', '', '1', '2023-09-12 18:51:00', '2023-09-12 20:51:57'),
(168, '6', '1', 'ret5', 'retrait', 'client', 'EMPRUNT', -8000000, 'gnf', 'especes', '', '', '1', '2023-09-12 18:55:00', '2023-09-12 20:55:04'),
(169, '93', '1', 'venteibe230108', 'vente', 'vente credit', 'vente n°ibe230108', NULL, 'gnf', 'especes', '', '', '1', '2023-09-12 07:11:00', '2023-09-12 21:11:26'),
(170, '93', '1', 'venteibe230108', 'vente', 'vente credit', 'vente n°ibe230108', NULL, 'eu', 'especes', '', '', '1', '2023-09-12 07:11:00', '2023-09-12 21:11:26'),
(171, '93', '1', 'venteibe230108', 'vente', 'vente credit', 'vente n°ibe230108', NULL, 'us', 'especes', '', '', '1', '2023-09-12 07:11:00', '2023-09-12 21:11:26'),
(172, '93', '1', 'venteibe230108', 'vente', 'vente credit', 'vente n°ibe230108', NULL, 'cfa', 'especes', '', '', '1', '2023-09-12 07:11:00', '2023-09-12 21:11:26'),
(173, '6', '1', 'venteibe230109', 'vente', 'vente credit', 'vente n°ibe230109', NULL, 'gnf', 'especes', '', '', '1', '2023-09-21 09:46:00', '2023-09-21 11:46:07'),
(174, '6', '1', 'venteibe230109', 'vente', 'vente credit', 'vente n°ibe230109', NULL, 'eu', 'especes', '', '', '1', '2023-09-21 09:46:00', '2023-09-21 11:46:07'),
(175, '6', '1', 'venteibe230109', 'vente', 'vente credit', 'vente n°ibe230109', NULL, 'us', 'especes', '', '', '1', '2023-09-21 09:46:00', '2023-09-21 11:46:07'),
(176, '6', '1', 'venteibe230109', 'vente', 'vente credit', 'vente n°ibe230109', NULL, 'cfa', 'especes', '', '', '1', '2023-09-21 09:46:00', '2023-09-21 11:46:07'),
(177, '6', '1', 'venteibe230110', 'vente', 'vente credit', 'vente n°ibe230110', NULL, 'gnf', 'especes', '', '', '1', '2023-09-21 10:19:00', '2023-09-21 12:19:07'),
(178, '6', '1', 'venteibe230110', 'vente', 'vente credit', 'vente n°ibe230110', NULL, 'eu', 'especes', '', '', '1', '2023-09-21 10:19:00', '2023-09-21 12:19:07'),
(179, '6', '1', 'venteibe230110', 'vente', 'vente credit', 'vente n°ibe230110', NULL, 'us', 'especes', '', '', '1', '2023-09-21 10:19:00', '2023-09-21 12:19:07'),
(180, '6', '1', 'venteibe230110', 'vente', 'vente credit', 'vente n°ibe230110', NULL, 'cfa', 'especes', '', '', '1', '2023-09-21 10:19:00', '2023-09-21 12:19:07'),
(181, '6', '1', 'venteibe230111', 'vente', 'vente credit', 'vente n°ibe230111', NULL, 'gnf', 'especes', '', '', '1', '2023-09-21 11:10:00', '2023-09-21 13:10:50'),
(182, '6', '1', 'venteibe230111', 'vente', 'vente credit', 'vente n°ibe230111', NULL, 'eu', 'especes', '', '', '1', '2023-09-21 11:10:00', '2023-09-21 13:10:50'),
(183, '6', '1', 'venteibe230111', 'vente', 'vente credit', 'vente n°ibe230111', NULL, 'us', 'especes', '', '', '1', '2023-09-21 11:10:00', '2023-09-21 13:10:50'),
(184, '6', '1', 'venteibe230111', 'vente', 'vente credit', 'vente n°ibe230111', NULL, 'cfa', 'especes', '', '', '1', '2023-09-21 11:10:00', '2023-09-21 13:10:50'),
(185, '6', '1', 'venteibe230112', 'vente', 'vente credit', 'vente n°ibe230112', NULL, 'gnf', 'especes', '', '', '1', '2023-09-21 02:18:00', '2023-09-21 16:18:56'),
(186, '6', '1', 'venteibe230112', 'vente', 'vente credit', 'vente n°ibe230112', NULL, 'eu', 'especes', '', '', '1', '2023-09-21 02:18:00', '2023-09-21 16:18:56'),
(187, '6', '1', 'venteibe230112', 'vente', 'vente credit', 'vente n°ibe230112', NULL, 'us', 'especes', '', '', '1', '2023-09-21 02:18:00', '2023-09-21 16:18:56'),
(188, '6', '1', 'venteibe230112', 'vente', 'vente credit', 'vente n°ibe230112', NULL, 'cfa', 'especes', '', '', '1', '2023-09-21 02:18:00', '2023-09-21 16:18:56'),
(189, '1', '1', 'retd5', 'depense', 'depense', 'TRANSPORT DUBREKA', -20000, 'gnf', 'especes', NULL, NULL, '1', '2023-09-22 13:18:02', '2023-09-22 13:18:02'),
(190, '1', '1', 'devisea4', 'echange', 'echange', 'DSDFD', 30, 'eu', 'especes', NULL, NULL, '1', '2023-09-22 11:19:00', '2023-09-22 13:19:52'),
(191, '1', '1', 'devisea4', 'echange', 'echange', 'DSDFD', -300000, 'gnf', 'especes', NULL, NULL, '1', '2023-09-22 11:19:00', '2023-09-22 13:19:52');

-- --------------------------------------------------------

--
-- Structure de la table `banquecmd`
--

DROP TABLE IF EXISTS `banquecmd`;
CREATE TABLE IF NOT EXISTS `banquecmd` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `numdec` varchar(50) NOT NULL,
  `idf` int(11) NOT NULL,
  `cmd` varchar(50) NOT NULL,
  `montant` double NOT NULL,
  `devise` text NOT NULL,
  `taux` int(11) NOT NULL DEFAULT '0',
  `payement` varchar(50) NOT NULL DEFAULT 'especes',
  `dateop` datetime NOT NULL,
  `lieuvente` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `banquecmd`
--

INSERT INTO `banquecmd` (`id`, `numdec`, `idf`, `cmd`, `montant`, `devise`, `taux`, `payement`, `dateop`, `lieuvente`) VALUES
(1, 'commande1', 57, 'cmd1', 0, 'gnf', 1, 'esp&egrave;ces', '2023-07-23 10:11:00', 1);

-- --------------------------------------------------------

--
-- Structure de la table `bulletin`
--

DROP TABLE IF EXISTS `bulletin`;
CREATE TABLE IF NOT EXISTS `bulletin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `origine_bull` varchar(50) DEFAULT NULL,
  `nom_client` varchar(50) DEFAULT NULL,
  `type` varchar(50) NOT NULL DEFAULT 'client',
  `libelles` varchar(150) DEFAULT NULL,
  `numero` varchar(50) DEFAULT NULL,
  `montant` double DEFAULT NULL,
  `devise` varchar(20) DEFAULT NULL,
  `taux` float NOT NULL DEFAULT '1',
  `caissebul` int(2) DEFAULT NULL,
  `lieuvente` int(11) DEFAULT NULL,
  `date_versement` datetime DEFAULT CURRENT_TIMESTAMP,
  `datesaisie` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=80 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `bulletin`
--

INSERT INTO `bulletin` (`id`, `origine_bull`, `nom_client`, `type`, `libelles`, `numero`, `montant`, `devise`, `taux`, `caissebul`, `lieuvente`, `date_versement`, `datesaisie`) VALUES
(1, 'vente facture', '26', 'client', 'reste à payer', 'ibe230080', -200000, 'gnf', 1, 1, 1, '2023-07-27 10:11:00', '2023-07-27 12:11:04'),
(2, 'vente facture', '102', 'client', 'reste à payer', 'ibe230081', -100000, 'gnf', 1, 1, 1, '2023-07-27 10:11:00', '2023-07-27 12:11:42'),
(3, 'vente facture', '26', 'client', 'reste à payer', 'ibe230082', 0, 'gnf', 1, 1, 1, '2023-07-27 10:12:00', '2023-07-27 12:12:26'),
(4, 'vente facture', '26', 'client', 'reste à payer', 'ibe230083', 0, 'gnf', 1, 1, 1, '2023-07-27 10:48:00', '2023-07-27 12:48:53'),
(5, 'vente facture', '102', 'client', 'reste à payer', 'ibe230084', -200000, 'gnf', 1, 1, 1, '2023-07-27 10:49:00', '2023-07-27 12:49:14'),
(7, NULL, '6', 'client', 'emprunt', 'dep18', 2000, 'eu', 1, 1, 1, '2023-08-07 12:58:39', '2023-08-07 12:58:39'),
(8, NULL, '6', 'client', 'paiement', 'dep19', 50000000, 'gnf', 1, 1, 1, '2023-08-07 13:02:33', '2023-08-07 13:02:33'),
(9, NULL, '7', 'client', 'paiement facture', 'dep20', 20000000, 'gnf', 1, 1, 1, '2023-08-08 15:12:04', '2023-08-08 15:12:04'),
(10, NULL, '7', 'client', 'paiement facture remis par nnn', 'dep21', 50000000, 'gnf', 1, 1, 1, '2023-08-08 15:24:06', '2023-08-08 15:24:06'),
(12, NULL, '6', 'client', 'paiementv facture par devise', 'dep22', 5000000, 'gnf', 10000, 1, 1, '2023-08-08 15:38:57', '2023-08-08 15:38:57'),
(13, NULL, '15', 'client', 'paiement facture', 'dep24', 10000000, 'gnf', 1, 193, 1, '2023-08-19 16:43:42', '2023-08-19 16:43:42'),
(14, NULL, 'pers55', 'personnel', 'bon', 'bonp1', -100000, 'gnf', 1, 1, 1, '2023-08-19 16:22:00', '2023-08-19 18:22:30'),
(15, NULL, 'pers55', 'personnel', 'remboursement', 'rembp1', 100000, 'gnf', 1, 1, 1, '2023-08-20 07:42:00', '2023-08-20 09:42:03'),
(16, NULL, 'pers2', 'personnel', 'bon', 'bonp2', -10000000, 'gnf', 1, 1, 1, '2023-08-20 07:50:00', '2023-08-20 09:50:54'),
(17, 'vente facture', '1', 'client', 'reste à payer', 'ibe230086', 0, 'gnf', 1, 1, 1, '2023-08-20 08:19:00', '2023-08-20 10:19:41'),
(18, NULL, '17', 'client', 'paiement', 'dep25', 20000000, 'gnf', 1, 1, 1, '2023-08-20 10:46:10', '2023-08-20 10:46:10'),
(19, NULL, '6', 'client', 'Retrait (pr&ecirc;t )', 'ret1', -5000000, 'gnf', 1, 1, 1, '2023-08-27 09:48:00', '2023-08-27 11:48:28'),
(20, NULL, '6', 'client', 'Retrait (PRET )', 'ret2', -1000000, 'gnf', 1, 1, 1, '2023-08-27 09:50:00', '2023-08-27 11:50:28'),
(21, NULL, '7', 'client', 'Retrait (pret)', 'ret3', -10000000, 'gnf', 1, 193, 1, '2023-08-27 09:57:00', '2023-08-27 11:57:35'),
(22, NULL, '7', 'client', 'Retrait (pret)', 'ret4', -100000, 'gnf', 1, 1, 1, '2023-08-27 09:59:00', '2023-08-27 11:59:38'),
(23, NULL, '6', 'client', 'paiement facture', 'dep26', 20000000, 'gnf', 1, 1, 1, '2023-08-27 10:28:00', '2023-08-27 12:28:12'),
(24, NULL, '6', 'client', 'PAIEMENT RESTE ', 'dep27', 1000000, 'gnf', 1, 1, 1, '2023-08-27 10:29:00', '2023-08-27 12:29:15'),
(25, NULL, '7', 'client', 'PAIEMENT FACTURE', 'dep28', 20000, 'us', 1, 1, 1, '2023-08-27 15:30:00', '2023-08-27 17:30:58'),
(26, 'vente facture', '1', 'client', 'reste à payer', 'ibe230087', 0, 'gnf', 1, 1, 1, '2023-08-27 04:01:00', '2023-08-27 18:01:17'),
(27, 'vente facture', '1', 'client', 'reste à payer', 'ibe230088', 0, 'gnf', 1, 1, 1, '2023-08-27 04:03:00', '2023-08-27 18:03:56'),
(28, 'vente facture', '1', 'client', 'reste à payer', 'ibe230089', 0, 'gnf', 1, 1, 1, '2023-09-02 09:11:00', '2023-09-02 11:11:36'),
(30, 'vente facture', '1', 'client', 'reste à payer', 'ibe230091', 0, 'gnf', 1, 1, 1, '2023-09-02 11:12:00', '2023-09-02 13:12:12'),
(32, 'vente facture', '1', 'client', 'reste à payer', 'ibe230093', 0, 'gnf', 1, 1, 1, '2023-09-02 11:42:00', '2023-09-02 13:42:35'),
(33, 'vente facture', '1', 'client', 'reste à payer', 'ibe230094', 0, 'gnf', 1, 1, 1, '2023-09-02 11:48:00', '2023-09-02 13:48:33'),
(34, 'vente facture', '1', 'client', 'reste à payer', 'ibe230095', 0, 'gnf', 1, 1, 1, '2023-09-02 11:52:00', '2023-09-02 13:52:14'),
(35, 'vente facture', '1', 'client', 'reste à payer', 'ibe230096', 0, 'gnf', 1, 1, 1, '2023-09-02 11:55:00', '2023-09-02 13:55:09'),
(36, 'vente facture', '1', 'client', 'reste à payer', 'ibe230097', 0, 'gnf', 1, 1, 1, '2023-09-02 11:57:00', '2023-09-02 13:57:20'),
(37, 'vente facture', '1', 'client', 'reste à payer', 'ibe230098', 0, 'gnf', 1, 1, 1, '2023-09-02 12:03:00', '2023-09-02 14:03:28'),
(38, 'vente facture', '1', 'client', 'reste à payer', 'ibe230099', 0, 'gnf', 1, 1, 1, '2023-09-02 12:06:00', '2023-09-02 14:06:26'),
(39, 'vente facture', '93', 'client', 'reste à payer', 'ibe230100', -1600000, 'gnf', 1, 1, 1, '2023-09-04 09:07:00', '2023-09-04 11:07:54'),
(40, 'vente facture', '93', 'client', 'reste à payer', 'ibe230101', -100000, 'gnf', 1, 1, 1, '2023-09-04 10:26:00', '2023-09-04 12:26:43'),
(41, NULL, '93', 'client', 'payement facture', 'dep29', 10000000, 'gnf', 1, 1, 1, '2023-09-04 10:28:00', '2023-09-04 12:28:27'),
(59, 'achatfi', '93', 'client', 'achat ordinateur', 'editf1', 20000000, 'gnf', 1, 1, 1, '2023-09-04 16:14:59', '2023-09-04 16:14:59'),
(60, 'vente facture', '93', 'client', 'reste à payer', 'ibe230102', -5000000, 'gnf', 1, 1, 1, '2023-09-11 10:31:00', '2023-09-11 12:31:22'),
(61, 'commission', '93', 'client', 'commission18', 'ibe230102', 50000, 'gnf', 1, 1, 1, '2023-09-11 12:58:53', '2023-09-11 12:58:53'),
(62, 'vente facture', '6', 'client', 'reste à payer', 'ibe230103', -190000, 'gnf', 1, 1, 1, '2023-09-11 11:21:00', '2023-09-11 13:21:17'),
(63, 'vente facture', '6', 'client', 'reste à payer', 'ibe230104', -400000, 'gnf', 1, 1, 1, '2023-09-11 11:22:00', '2023-09-11 13:22:17'),
(64, 'vente facture', '183', 'client', 'reste à payer', 'ibe230105', -600000, 'gnf', 1, 1, 1, '2023-09-11 11:25:00', '2023-09-11 13:25:05'),
(65, 'commission', '6', 'client', 'commission19', 'ibe230104', 10000, 'gnf', 1, 1, 1, '2023-09-12 12:08:44', '2023-09-12 12:08:44'),
(66, 'vente facture', '1', 'client', 'reste à payer', 'ibe230106', 0, 'gnf', 1, 1, 1, '2023-09-12 06:43:00', '2023-09-12 20:43:35'),
(67, 'vente facture', '1', 'client', 'reste à payer', 'ibe230107', 0, 'gnf', 1, 1, 1, '2023-09-12 06:45:00', '2023-09-12 20:45:17'),
(68, NULL, '6', 'client', 'PAIZEMRNT', 'dep30', 9000000, 'gnf', 1, 1, 1, '2023-09-12 18:51:00', '2023-09-12 20:51:57'),
(69, NULL, '6', 'client', 'Retrait (EMPRUNT)', 'ret5', -8000000, 'gnf', 1, 1, 1, '2023-09-12 18:55:00', '2023-09-12 20:55:04'),
(70, 'vente facture', '93', 'client', 'reste à payer', 'ibe230108', -200000, 'gnf', 1, 1, 1, '2023-09-12 07:11:00', '2023-09-12 21:11:26'),
(71, 'achatfi', '6', 'client', 'achat hp', 'editf18', 200000, 'gnf', 1, 1, 1, '2023-09-21 11:37:43', '2023-09-21 11:37:43'),
(72, 'vente facture', '6', 'client', 'reste à payer', 'ibe230109', -200000, 'gnf', 1, 1, 1, '2023-09-21 09:46:00', '2023-09-21 11:46:07'),
(73, 'vente facture', '6', 'client', 'reste à payer', 'ibe230110', -35200000, 'gnf', 1, 1, 1, '2023-09-21 10:19:00', '2023-09-21 12:19:07'),
(74, 'vente facture', '6', 'client', 'reste à payer', 'ibe230111', -11100000, 'gnf', 1, 1, 1, '2023-09-21 11:10:00', '2023-09-21 13:10:50'),
(75, 'commission', '6', 'client', 'commission20', 'ibe230111', 10000, 'gnf', 1, 1, 1, '2023-09-21 13:11:34', '2023-09-21 13:11:34'),
(76, 'achatfi', '6', 'client', 'achat ordi', 'editf19', 10000000, 'gnf', 1, 1, 1, '2023-09-21 13:12:19', '2023-09-21 13:12:19'),
(77, 'retour produit', '6', 'client', 'retour produit', 'ibe230111', -5500000, 'gnf', 1, 1, 1, '2023-09-21 14:18:44', '2023-09-21 14:18:44'),
(78, 'vente facture', '6', 'client', 'reste à payer', 'ibe230112', -1630000, 'gnf', 1, 1, 1, '2023-09-21 02:18:00', '2023-09-21 16:18:56'),
(79, 'retour produit', '6', 'client', 'retour produit', 'ibe230112', -150000, 'gnf', 1, 1, 1, '2023-09-21 16:20:04', '2023-09-21 16:20:04');

-- --------------------------------------------------------

--
-- Structure de la table `caissecloture`
--

DROP TABLE IF EXISTS `caissecloture`;
CREATE TABLE IF NOT EXISTS `caissecloture` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_banque` int(2) NOT NULL,
  `devise` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `montantsaisie` double DEFAULT '0',
  `montantreel` double DEFAULT '0',
  `difference` double DEFAULT '0',
  `idpers` int(2) DEFAULT NULL,
  `dateop` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

DROP TABLE IF EXISTS `categorie`;
CREATE TABLE IF NOT EXISTS `categorie` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(150) NOT NULL,
  `nbrevente` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `categorie`
--

INSERT INTO `categorie` (`id`, `nom`, `nbrevente`) VALUES
(1, 'USB', NULL),
(2, 'Acc', NULL),
(3, 'Antivirus', NULL),
(4, 'Clavier', NULL),
(5, 'Destop', NULL),
(6, 'Disq dur', NULL),
(7, 'Imprimante', NULL),
(8, 'INK', NULL),
(9, 'Laptop', NULL),
(10, 'Onduleur', NULL),
(11, 'Premax', NULL),
(12, 'Projecteur', NULL),
(13, 'Rallonge', NULL),
(14, 'Ram', NULL),
(15, 'routeur', NULL),
(16, 'Souris', NULL),
(17, 'Stabilisateur', NULL),
(18, 'TONER', NULL),
(19, 'Autres', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `categoriedep`
--

DROP TABLE IF EXISTS `categoriedep`;
CREATE TABLE IF NOT EXISTS `categoriedep` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `categoriedep`
--

INSERT INTO `categoriedep` (`id`, `nom`) VALUES
(2, 'transport'),
(3, 'embarquement'),
(4, 'Salaires'),
(5, 'Carburant'),
(6, 'repas'),
(7, 'autres'),
(8, 'Logistique'),
(9, 'LOCATION'),
(10, 'Manutention'),
(11, 'Agios bancaires ');

-- --------------------------------------------------------

--
-- Structure de la table `categorieperte`
--

DROP TABLE IF EXISTS `categorieperte`;
CREATE TABLE IF NOT EXISTS `categorieperte` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `categorieperte`
--

INSERT INTO `categorieperte` (`id`, `nom`) VALUES
(9, 'surplus');

-- --------------------------------------------------------

--
-- Structure de la table `categorierecette`
--

DROP TABLE IF EXISTS `categorierecette`;
CREATE TABLE IF NOT EXISTS `categorierecette` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `categorierecette`
--

INSERT INTO `categorierecette` (`id`, `nom`) VALUES
(1, 'CAMIONS ');

-- --------------------------------------------------------

--
-- Structure de la table `chequedepasse`
--

DROP TABLE IF EXISTS `chequedepasse`;
CREATE TABLE IF NOT EXISTS `chequedepasse` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `numcheque` varchar(50) NOT NULL,
  `montant` double NOT NULL,
  `dateencaissement` datetime NOT NULL,
  `id_banque` int(11) NOT NULL,
  `lieuvente` varchar(50) DEFAULT NULL,
  `dateop` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `chequedepasse`
--

INSERT INTO `chequedepasse` (`id`, `numcheque`, `montant`, `dateencaissement`, `id_banque`, `lieuvente`, `dateop`) VALUES
(8, '08013127', 28230000, '2023-07-11 00:00:00', 1, '1', '2023-07-13 12:57:14'),
(7, '04553736', 8700000, '2023-07-11 00:00:00', 1, '1', '2023-07-13 12:57:06'),
(6, '08249752', 1500000, '2023-07-11 00:00:00', 1, '1', '2023-07-13 12:56:28');

-- --------------------------------------------------------

--
-- Structure de la table `client`
--

DROP TABLE IF EXISTS `client`;
CREATE TABLE IF NOT EXISTS `client` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom_client` varchar(150) DEFAULT NULL,
  `telephone` varchar(20) DEFAULT NULL,
  `mail` varchar(100) DEFAULT NULL,
  `adresse` varchar(150) DEFAULT NULL,
  `positionc` int(2) DEFAULT NULL,
  `typeclient` varchar(50) DEFAULT NULL,
  `restriction` varchar(50) NOT NULL DEFAULT 'ok',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=195 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `client`
--

INSERT INTO `client` (`id`, `nom_client`, `telephone`, `mail`, `adresse`, `positionc`, `typeclient`, `restriction`) VALUES
(1, 'client cash', '', '', '', 1, 'client', 'ok'),
(2, 'DS CORPORATION', '622553939', '', '', 1, 'client', 'ok'),
(3, 'NPG', '628258126', '', '', 1, 'client', 'ok'),
(4, 'NETSEN GROUPE', '628860775', '', '', 1, 'client', 'ok'),
(5, 'cnss', '628364068', '', '', 1, 'client', 'ok'),
(6, 'K-ABDOULAYE', '621182966', '', '', 1, 'clientf', 'ok'),
(7, 'EL MARELA', '622602485', '', '', 1, 'client', 'ok'),
(8, 'razak', '622276011', '', '', 1, 'client', 'ok'),
(9, 'POUNGOULY', '628746583', '', '', 1, 'client', 'ok'),
(10, 'IDY THIERNO', '622256992', '', '', 1, 'client', 'ok'),
(11, 'RACHID', '623345495', '', '', 1, 'client', 'ok'),
(12, 'DIOP PMG', '621576493', '', '', 1, 'client', 'ok'),
(13, 'SIDY', '622319346', '', '', 1, 'client', 'ok'),
(14, 'YAYA SYSTÈME', '624790000', '', '', 1, 'client', 'ok'),
(15, 'MR KEITA', '628245723', '', '', 1, 'client', 'ok'),
(16, 'CONNECTIS', '622652707', '', '', 1, 'client', 'ok'),
(17, 'BARRY WHITE', '621471607', '', '', 1, 'client', 'ok'),
(18, 'GROUPE WALY', '620026985', '', '', 1, 'client', 'ok'),
(19, 'TID', '620057915', '', '', 1, 'client', 'ok'),
(20, 'djoulde vox', '621345850', '', '', 1, 'client', 'ok'),
(21, 'DIOP MAREGA', '620090465', '', '', 1, 'client', 'ok'),
(22, 'DIOP MANQUEPA', '622779696', '', '', 1, 'client', 'ok'),
(23, 'KABA', '621869105', '', '', 1, 'client', 'ok'),
(24, 'CONTINENTALE GROUPE', '624121053', '', '', 1, 'client', 'ok'),
(25, 'BOUDARER', '622265190', '', '', 1, 'client', 'ok'),
(26, '2hk', '622200707', '', '', 1, 'client', 'ok'),
(27, 'MADIOU', '626392015', '', '', 1, 'client', 'ok'),
(28, 'HAFIA INFO', '628000819', '', '', 1, 'client', 'ok'),
(29, 'G-MACI', '628769999', '', '', 1, 'client', 'ok'),
(30, 'KOTO GALO', '628541490', '', '', 1, 'client', 'ok'),
(31, 'koto alassana madina', '622491594', '', '', 1, 'client', 'ok'),
(32, 'MR DIALLO ATI', '622195086', '', '', 1, 'client', 'ok'),
(33, 'BACHIR', '628757339', '', '', 1, 'client', 'ok'),
(34, 'lamarana', '622556800', '', '', 1, 'client', 'ok'),
(35, 'AMADJAN KEBALY', '621258335', '', '', 1, 'client', 'ok'),
(36, 'el alpha mab', '664283167', '', '', 1, 'client', 'ok'),
(37, 'KOTO MOUCTAR', '625298403', '', '', 1, 'client', 'ok'),
(38, 'DJOULDE ALMAR', '623004242', '', '', 1, 'client', 'ok'),
(39, 'DJALAL', '628475212', '', '', 1, 'client', 'ok'),
(40, 'ETS BOUBACAR DIALLO', '622333330', '', '', 1, 'client', 'ok'),
(41, 'MAOUDHO', '628243099', '', '', 1, 'client', 'ok'),
(42, 'mr sow', '624080608', '', '', 1, 'client', 'ok'),
(43, 'MAREGA', '628776350', '', '', 1, 'client', 'ok'),
(44, 'MOUSSA GOLODY', '620242119', '', '', 1, 'client', 'ok'),
(45, 'SEKOU', '625480462', '', '', 1, 'client', 'ok'),
(46, 'ALIOU DS', '622771777', '', '', 1, 'client', 'ok'),
(47, 'SAIKOU', '621248477', '', '', 1, 'client', 'ok'),
(48, 'BILLO VOX', '626044883', '', '', 1, 'client', 'ok'),
(49, 'HASMIOU IMMEUBLE SALL', '623257616', '', '', 1, 'client', 'ok'),
(50, 'MR ALIX', '666421034', '', '', 1, 'client', 'ok'),
(51, 'elhadj kebaly', '628431943', '', '', 1, 'client', 'ok'),
(52, 'BOBO', '623991783', '', '', 1, 'client', 'ok'),
(53, 'BIG', '622205601', '', '', 1, 'client', 'ok'),
(54, 'SYLLA', '628484706', '', '', 1, 'client', 'ok'),
(55, 'TANTI AISSATOU', '622333333', '', '', 1, 'client', 'ok'),
(56, 'IBOU ALMAMYA', '', '', '', 1, 'client', 'ok'),
(57, 'TELLY', '622997081', '', '', 1, 'client', 'ok'),
(58, 'SOULEYMANE NPG', '', '', '', 1, 'client', 'ok'),
(59, 'IB', '620512380', '', '', 1, 'client', 'ok'),
(60, 'MADAME MARA', '623988798', '', '', 1, 'client', 'ok'),
(61, 'CELLOU', '628489590', '', '', 1, 'client', 'ok'),
(62, 'AMADOU BARRY', '628165871', '', '', 1, 'client', 'ok'),
(63, 'MALICKY', '620413718', '', '', 1, 'client', 'ok'),
(64, 'K ALIOU', '628553605', '', '', 1, 'client', 'ok'),
(65, 'GALERIE NS', '622321214', '', '', 1, 'client', 'ok'),
(66, 'HASMIOU', '622993058', '', '', 1, 'client', 'ok'),
(67, 'BOUBA ASHARAMI', '628507601', '', '', 1, 'client', 'ok'),
(68, 'YAYA KALATEC', '623227145', '', '', 1, 'client', 'ok'),
(69, 'TECH 224', '624500082', '', '', 1, 'client', 'ok'),
(70, 'TH MAMOUDOU', '622535901', '', '', 1, 'client', 'ok'),
(71, 'mouloukou', '621526814', '', '', 1, 'client', 'ok'),
(72, 'bouba-hp', '622241682', '', '', 1, 'client', 'ok'),
(73, 'ETS BAH ET FRERE', '622313432', '', '', 1, 'client', 'ok'),
(74, 'DOUMBOUYAH', '623296990', '', '', 1, 'client', 'ok'),
(75, 'RASSY', '620865907', '', '', 1, 'client', 'ok'),
(76, 'EL SOULEYMANE', '624484848', '', '', 1, 'client', 'ok'),
(77, 'HAMIDOU', '628242347', '', '', 1, 'client', 'ok'),
(78, 'K MOUSSA', '622244411', '', '', 1, 'client', 'ok'),
(79, 'THIERNO AMADOU', '622278900', '', '', 1, 'client', 'ok'),
(80, 'HADY', '626763636', '', '', 1, 'client', 'ok'),
(81, 'ahmed act-op solution', '625250325', '', '', 1, 'client', 'ok'),
(82, 'SADIALIOU', '622221742', '', '', 1, 'client', 'ok'),
(83, 'GDJ', '624441516', '', '', 1, 'client', 'ok'),
(84, 'K IBRAHIMA MODOU', '622568460', '', '', 1, 'client', 'ok'),
(85, 'MODOU', '622442144', '', '', 1, 'client', 'ok'),
(86, 'PAPETERIE DIOP', '622272273', '', '', 1, 'client', 'ok'),
(87, 'FNT', '623242323', '', '', 1, 'client', 'ok'),
(88, 'BAKAYOKO PMG', '621529304', '', '', 1, 'client', 'ok'),
(89, 'FELO', '624292227', '', '', 1, 'client', 'ok'),
(90, 'ISMAEL', '622999913', '', '', 1, 'client', 'ok'),
(91, 'BOUBACAR', '620029893', '', '', 1, 'client', 'ok'),
(92, 'K MD BAILO', '622549594', '', '', 1, 'client', 'ok'),
(93, 'ABDOULAYE KEITA', '621323334', '', '', 1, 'clientf', 'ok'),
(94, 'ALPHA MODOU', '622322434', '', '', 1, 'client', 'ok'),
(95, 'DIARAYE KEBALY', '622044019', '', '', 1, 'client', 'ok'),
(96, 'HOPITAL NATIONAL DONKA', '666892180', '', '', 1, 'client', 'ok'),
(97, 'GMD', '622426738', '', '', 1, 'client', 'ok'),
(98, 'CIRE UMEBLE SALL', '622201322', '', '', 1, 'client', 'ok'),
(99, 'ets bah mahamoud', '620719439', '', '', 1, 'client', 'ok'),
(100, 'MAMADOU SIRE SODI SHOP', '621861299', '', '', 1, 'client', 'ok'),
(101, 'el oury', '623494343', '', '', 1, 'client', 'ok'),
(102, 'AAI', '624935723', '', '', 1, 'fournisseur', 'ok'),
(103, 'elhadj VOX', '620891615', '', '', 1, 'client', 'ok'),
(104, 'COMMUNAUTE DIO', '664341890', '', '', 1, 'client', 'ok'),
(105, 'GRAND DJIBI', '622174348', '', '', 1, 'client', 'ok'),
(106, 'LALIA', '622294476', '', '', 1, 'client', 'ok'),
(107, 'G HASSAN', '657640103', '', '', 1, 'client', 'ok'),
(108, 'ISSA DIREC AID AMA', '611111115', '', '', 1, 'client', 'ok'),
(109, 'DIREC AID AMA', '622087135', '', '', 1, 'client', 'ok'),
(110, 'fauna et flora international', '622647124', '', '', 1, 'client', 'ok'),
(111, 'OCPH', '622166372', '', '', 1, 'client', 'ok'),
(112, 'MOUCTAR-VOX', '628363635', '', '', 1, 'client', 'ok'),
(113, 'CHERIF', '622317104', '', '', 1, 'client', 'ok'),
(114, 'AFRICA GERMANY', '622983780', '', '', 1, 'client', 'ok'),
(115, 'ALSENY POSTE', '622414388', '', '', 1, 'client', 'ok'),
(116, 'rasta', '620725909', '', '', 1, 'client', 'ok'),
(117, 'THUITO', '628825648', '', '', 1, 'client', 'ok'),
(118, 'DIOGO', '622014937', '', '', 1, 'client', 'ok'),
(119, 'LEFA', '660939444', '', '', 1, 'client', 'ok'),
(120, 'I-MARELA', '628293583', '', '', 1, 'client', 'ok'),
(121, 'universite lambagni', '625606109', '', '', 1, 'client', 'ok'),
(122, 'lonagui', '624205781', '', '', 1, 'client', 'ok'),
(123, 'DREAM', '623753916', '', '', 1, 'client', 'ok'),
(124, 'oustage', '620491810', '', '', 1, 'client', 'ok'),
(125, 'PIEGM', '622656188', '', '', 1, 'client', 'ok'),
(126, 'AYOUBA', '622372357', '', '', 1, 'client', 'ok'),
(127, 'agnagna', '620628715', '', '', 1, 'client', 'ok'),
(128, 'SOW', '628053202', '', '', 1, 'client', 'ok'),
(129, 'WANN', '622423006', '', '', 1, 'client', 'ok'),
(130, 'AISSATOU SALL DS', '622284689', '', '', 1, 'client', 'ok'),
(131, 'EL OUMAR', '624882140', '', '', 1, 'client', 'ok'),
(132, 'ABDOURAHMANE', '625595354', '', '', 1, 'client', 'ok'),
(133, 'ALEKSEY', '628547769', '', '', 1, 'client', 'ok'),
(134, 'alhassane diallo', '628019573', '', '', 1, 'client', 'ok'),
(135, 'amadou oury diallo npg', '622217408', '', '', 1, 'client', 'ok'),
(136, 'AMBASSADE GRANDE BRETAGNE', '628355329', '', '', 1, 'client', 'ok'),
(137, 'ASHAPURA', '629007447', '', '', 1, 'client', 'ok'),
(138, 'babalah', '628553549', '', '', 1, 'client', 'ok'),
(139, 'boussouriou', '622149658', '', '', 1, 'client', 'ok'),
(140, 'CEC', '622935323', '', '', 1, 'client', 'ok'),
(141, 'DGENPPC', '628927376', '', '', 1, 'client', 'ok'),
(142, 'Eco-betape sa', '622960794', '', '', 1, 'client', 'ok'),
(143, 'el alpha vox', '628331508', '', '', 1, 'client', 'ok'),
(144, 'el bachir malien', '620151041', '', '', 1, 'client', 'ok'),
(145, 'EL DJOULDE', '664709133', '', '', 1, 'client', 'ok'),
(146, 'ETS MAMADOU DJALAL DIALLO', '662765776', '', '', 1, 'client', 'ok'),
(147, 'FOROMO LAMAH', '620242662', '', '', 1, 'client', 'ok'),
(148, 'GALO ABDOULAYE', '628928525', '', '', 1, 'client', 'ok'),
(149, 'GASSIMOU', '623151570', '', '', 1, 'client', 'ok'),
(150, 'GRAND OUMAR VOX', '622168244', '', '', 1, 'client', 'ok'),
(151, 'HOPITAL KOUNDARA', '628217708', '', '', 1, 'client', 'ok'),
(152, 'ibrahima vox', '622505753', '', '', 1, 'client', 'ok'),
(153, 'idy ibrahima sory', '625563879', '', '', 1, 'client', 'ok'),
(154, 'KELEFA SANGARE', '627362118', '', '', 1, 'client', 'ok'),
(155, 'lamine MPD', '628906003', '', '', 1, 'client', 'ok'),
(156, 'moussa diallo', '622700288', '', '', 1, 'client', 'ok'),
(157, 'MR ABDOULAYE AMBASSADE GRANDE BRETAGNE', '626963254', '', '', 1, 'client', 'ok'),
(158, 'MR CAMARA CNSS', '621354444', '', '', 1, 'client', 'ok'),
(159, 'MR FOFANA OUSMANE', '621710627', '', '', 1, 'client', 'ok'),
(160, 'mr haba', '628169940', '', '', 1, 'client', 'ok'),
(161, 'msb transport', '622125857', '', '', 1, 'client', 'ok'),
(162, 'pathe', '622660832', '', '', 1, 'client', 'ok'),
(163, 'SACKO INGENERIE', '624881651', '', '', 1, 'client', 'ok'),
(164, 'sage maferinyah', '622242273', '', '', 1, 'client', 'ok'),
(165, 'SBDT', '624363252', '', '', 1, 'client', 'ok'),
(166, 'SIG SARL', '627285788', '', '', 1, 'client', 'ok'),
(167, 'SIRADJO DIALLO VOX', '629700707', '', '', 1, 'client', 'ok'),
(168, 'SOSAG', '629005244', '', '', 1, 'client', 'ok'),
(169, 'THIERNO AMADOU CHEZ EL SOULEYMANE VOX', '622904251', '', '', 1, 'client', 'ok'),
(170, 'thierno oury marche niger', '628345201', '', '', 1, 'client', 'ok'),
(171, 'WANADIS TECHNOLOGIE', '662710248', '', '', 1, 'client', 'ok'),
(172, 'MR FEDERIC LOUA', '621096253', '', '', 1, 'client', 'ok'),
(173, 'el habib', '664214693', '', '', 1, 'client', 'ok'),
(174, 'CLIENTS', '622335251', '', '', 1, 'client', 'ok'),
(175, 'mr bangoura mik securite', '655260003', '', '', 1, 'client', 'ok'),
(176, 'ALL ONE GROUP', '628520099', '', '', 1, 'client', 'ok'),
(177, 'ANGELINE FFI', '664451004', '', '', 1, 'client', 'ok'),
(178, 'MIK SECURITE', '626733704', '', '', 1, 'client', 'ok'),
(179, 'oustage telly', '626060813', '', '', 1, 'client', 'ok'),
(180, 'IBETA PERSONNEL', '', '', '', 1, 'client', 'ok'),
(181, 'IBETA PLANTATION', '', '', '', 1, 'client', 'ok'),
(182, 'MME DIALLO DS', '', '', '', 1, 'client', 'ok'),
(183, 'ABDALAH CONTINENTALE GROUPE', '628878868', '', '', 1, 'client', 'ok'),
(184, 'ADAMA DONKA', '621024578', '', '', 1, 'client', 'ok'),
(185, 'GROUP DJEKS PLUS', '622320450', '', '', 1, 'client', 'ok'),
(186, 'ets yahham', '627046859', '', '', 1, 'client', 'ok'),
(187, 'th souleymane', '622284788', '', '', 1, 'client', 'ok'),
(188, 'madjou', '622805588', '', '', 1, 'client', 'ok'),
(189, 'PAPEN', '623812644', '', '', 1, 'client', 'ok'),
(190, 'KEBALY INFO', '622979843', '', '', 1, 'client', 'ok'),
(191, 'IBRAHIMA WANINDARA', '622894033', '', '', 1, 'client', 'ok'),
(192, 'MOUCTAR', '628214151', '', '', 1, 'client', 'ok'),
(193, 'BANQUE ISLAMIQUE', '000000000000001', '', 'KALOUM', 1, 'Banque', 'ok'),
(194, 'bci', '777777', '', 'conakry', 1, 'Banque', 'ok');

-- --------------------------------------------------------

--
-- Structure de la table `clientrelance`
--

DROP TABLE IF EXISTS `clientrelance`;
CREATE TABLE IF NOT EXISTS `clientrelance` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idclient` int(10) NOT NULL,
  `idpers` int(10) NOT NULL,
  `message` varchar(500) NOT NULL,
  `rappel` int(11) NOT NULL DEFAULT '0',
  `daterelance` date DEFAULT NULL,
  `dateop` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `cloture`
--

DROP TABLE IF EXISTS `cloture`;
CREATE TABLE IF NOT EXISTS `cloture` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date_cloture` date NOT NULL,
  `nbre_cmd` int(15) NOT NULL,
  `tot_cmd` float NOT NULL,
  `benefice` float NOT NULL,
  `tot_caisse` float NOT NULL,
  `tot_saisie` float NOT NULL,
  `difference` float NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `commande`
--

DROP TABLE IF EXISTS `commande`;
CREATE TABLE IF NOT EXISTS `commande` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_produit` int(11) DEFAULT NULL,
  `prix_vente` double NOT NULL,
  `prix_achat` double DEFAULT '0',
  `prix_revient` double DEFAULT '0',
  `quantity` int(11) NOT NULL,
  `qtiteliv` int(11) DEFAULT '0',
  `etatlivcmd` varchar(10) DEFAULT 'nonlivre',
  `num_cmd` varchar(50) NOT NULL,
  `id_client` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=76 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `commande`
--

INSERT INTO `commande` (`id`, `id_produit`, `prix_vente`, `prix_achat`, `prix_revient`, `quantity`, `qtiteliv`, `etatlivcmd`, `num_cmd`, `id_client`) VALUES
(1, 202, 200000, 0, 189189, 1, 0, 'nonlivre', 'ibe230073', 26),
(2, 205, 190000, 0, 156114, 1, 0, 'nonlivre', 'ibe230074', 102),
(3, 220, 200000, 0, 116424, 1, 1, 'livre', 'ibe230075', 1),
(4, 202, 200000, 0, 189189, 1, 0, 'nonlivre', 'ibe230076', 102),
(5, 202, 200000, 0, 189189, 1, 0, 'nonlivre', 'ibe230077', 183),
(6, 202, 200000, 0, 189189, 1, 1, 'livre', 'ibe230078', 1),
(7, 202, 200000, 0, 189189, 1, 0, 'nonlivre', 'ibe230079', 102),
(8, 202, 200000, 0, 189189, 1, 0, 'nonlivre', 'ibe230080', 26),
(9, 202, 200000, 0, 189189, 1, 0, 'nonlivre', 'ibe230081', 102),
(10, 202, 200000, 0, 189189, 1, 1, 'livre', 'ibe230082', 26),
(11, 202, 200000, 0, 189189, 1, 1, 'livre', 'ibe230083', 26),
(12, 220, 200000, 0, 116424, 1, 0, 'nonlivre', 'ibe230084', 102),
(13, 202, 200000, 0, 189189, 1, 1, 'livre', 'ibe230085', NULL),
(14, 229, 4300000, 0, 4159510, 1, 1, 'livre', 'ibe230086', 1),
(17, 220, 200000, 0, 116424, 0, 0, 'livre', 'ibe230089', 1),
(16, 202, 200000, 0, 189189, 1, 1, 'livre', 'ibe230088', 1),
(25, 205, 190000, 0, 156114, 3, 3, 'livre', 'ibe230093', 1),
(18, 349, 600000, 0, 470988, 1, 1, 'livre', 'ibe230089', 1),
(27, 205, 190000, 0, 156114, -1, -1, 'livre', 'ibe230093', 1),
(22, 253, 5000000, 0, 3704400, 1, 1, 'livre', 'ibe230091', 1),
(21, 220, 200000, 0, 116424, 1, 1, 'livre', 'ibe230091', 1),
(26, 421, 5500000, 0, 4855410, 1, 1, 'livre', 'ibe230093', 1),
(28, 205, 190000, 0, 156114, -1, -1, 'livre', 'ibe230093', 1),
(29, 205, 190000, 0, 156114, 1, 1, 'livre', 'ibe230094', 1),
(30, 220, 200000, 0, 116424, 5, 5, 'livre', 'ibe230094', 1),
(31, 220, 200000, 0, 116424, -1, -1, 'livre', 'ibe230094', 1),
(32, 220, 200000, 0, 116424, -2, -2, 'livre', 'ibe230094', 1),
(33, 220, 200000, 0, 116424, 1, 1, 'livre', 'ibe230095', 1),
(34, 220, 200000, 0, 116424, -4, -4, 'livre', 'ibe230094', 1),
(35, 205, 190000, 0, 156114, -1, -1, 'livre', 'ibe230094', 1),
(36, 220, 200000, 0, 116424, 4, 4, 'livre', 'ibe230096', 1),
(37, 220, 200000, 0, 116424, -1, -1, 'livre', 'ibe230096', 1),
(38, 220, 200000, 0, 116424, -2, -2, 'livre', 'ibe230096', 1),
(39, 220, 200000, 0, 116424, 4, 4, 'livre', 'ibe230097', 1),
(40, 220, 200000, 0, 116424, -1, -1, 'livre', 'ibe230097', 1),
(41, 220, 200000, 0, 116424, -2, -2, 'livre', 'ibe230097', 1),
(42, 220, 200000, 0, 116424, 4, 4, 'livre', 'ibe230098', 1),
(43, 220, 200000, 0, 116424, -1, -1, 'livre', 'ibe230098', 1),
(44, 220, 200000, 0, 116424, -1, -1, 'livre', 'ibe230098', 1),
(45, 217, 150000, 0, 79380, 1, 1, 'livre', 'ibe230099', 1),
(46, 220, 200000, 0, 116424, 1, 0, 'nonlivre', 'ibe230100', 93),
(47, 364, 1000000, 0, 629748, 1, 0, 'nonlivre', 'ibe230100', 93),
(48, 202, 200000, 0, 189189, 2, 0, 'nonlivre', 'ibe230100', 93),
(49, 223, 180000, 0, 137592, 1, 0, 'nonlivre', 'ibe230101', 93),
(50, 202, 200000, 0, 189189, -1, -1, 'nonlivre', 'ibe230100', 93),
(51, 202, 200000, 0, 189189, 1, 0, 'nonlivre', 'ibe230102', 93),
(52, 349, 600000, 0, 470988, 8, 2, 'encoursliv', 'ibe230102', 93),
(54, 349, 600000, 0, 470988, -1, 0, 'nonlivre', 'ibe230102', 93),
(56, 349, 600000, 0, 470988, -1, -1, 'nonlivre', 'ibe230102', 93),
(57, 349, 600000, 0, 470988, -1, -1, 'nonlivre', 'ibe230102', 93),
(58, 349, 600000, 0, 470988, -1, -1, 'nonlivre', 'ibe230102', 93),
(59, 205, 190000, 0, 156114, 1, 0, 'nonlivre', 'ibe230103', 6),
(60, 220, 200000, 0, 116424, 2, 0, 'nonlivre', 'ibe230104', 6),
(61, 349, 600000, 0, 470988, 1, 0, 'nonlivre', 'ibe230105', 183),
(62, 364, 1000000, 0, 629748, 2, 2, 'livre', 'ibe230106', 1),
(63, 202, 200000, 0, 189189, 1, 1, 'livre', 'ibe230107', 1),
(64, 220, 200000, 0, 116424, 1, 0, 'nonlivre', 'ibe230108', 93),
(65, 202, 200000, 0, 189189, -1, 0, 'nonlivre', 'ibe230100', 93),
(66, 220, 200000, 0, 116424, 1, 0, 'nonlivre', 'ibe230109', 6),
(67, 220, 200000, 0, 116424, 1, 0, 'nonlivre', 'ibe230110', 6),
(68, 364, 1000000, 0, 629748, 10, 0, 'nonlivre', 'ibe230110', 6),
(69, 418, 5000000, 0, 4273290, 5, 0, 'nonlivre', 'ibe230110', 6),
(70, 214, 100000, 0, 79380, 1, 0, 'nonlivre', 'ibe230111', 6),
(71, 421, 5500000, 0, 4855410, 2, 0, 'nonlivre', 'ibe230111', 6),
(72, 421, 5500000, 0, 4855410, -1, 0, 'nonlivre', 'ibe230111', 6),
(73, 217, 150000, 0, 79380, 10, 0, 'nonlivre', 'ibe230112', 6),
(74, 580, 130000, 0, 113778, 1, 0, 'nonlivre', 'ibe230112', 6),
(75, 217, 150000, 0, 79380, -1, 0, 'nonlivre', 'ibe230112', 6);

-- --------------------------------------------------------

--
-- Structure de la table `decaissement`
--

DROP TABLE IF EXISTS `decaissement`;
CREATE TABLE IF NOT EXISTS `decaissement` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `numdec` varchar(50) DEFAULT NULL,
  `montant` double NOT NULL,
  `devisedec` varchar(20) NOT NULL,
  `payement` varchar(30) NOT NULL,
  `numcheque` varchar(50) DEFAULT NULL,
  `banquecheque` varchar(50) DEFAULT NULL,
  `cprelever` varchar(50) DEFAULT NULL,
  `coment` varchar(150) DEFAULT NULL,
  `client` varchar(155) DEFAULT NULL,
  `lieuvente` varchar(10) DEFAULT NULL,
  `idpers` int(11) DEFAULT NULL,
  `date_payement` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `decaissement`
--

INSERT INTO `decaissement` (`id`, `numdec`, `montant`, `devisedec`, `payement`, `numcheque`, `banquecheque`, `cprelever`, `coment`, `client`, `lieuvente`, `idpers`, `date_payement`) VALUES
(1, 'ret1', 5000000, 'gnf', 'espèces', '', '', '1', 'pr&ecirc;t ', '6', '1', NULL, '2023-08-27 09:48:00'),
(2, 'ret2', 1000000, 'gnf', 'espèces', '', '', '1', 'PRET ', '6', '1', NULL, '2023-08-27 09:50:00'),
(3, 'ret3', 10000000, 'gnf', 'espèces', '', '', '193', 'pret', '7', '1', NULL, '2023-08-27 09:57:00'),
(4, 'ret4', 100000, 'gnf', 'espèces', '', '', '1', 'pret', '7', '1', NULL, '2023-08-27 09:59:00'),
(5, 'ret5', 8000000, 'gnf', 'especes', '', '', '1', 'EMPRUNT', '6', '1', NULL, '2023-09-12 18:55:00');

-- --------------------------------------------------------

--
-- Structure de la table `decdepense`
--

DROP TABLE IF EXISTS `decdepense`;
CREATE TABLE IF NOT EXISTS `decdepense` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `numdec` varchar(50) DEFAULT 'retd26',
  `categorie` varchar(100) DEFAULT 'autres',
  `montant` double NOT NULL,
  `devisedep` varchar(20) NOT NULL,
  `payement` varchar(30) NOT NULL,
  `cprelever` varchar(50) DEFAULT 'caisse',
  `coment` varchar(150) DEFAULT NULL,
  `client` varchar(155) DEFAULT NULL,
  `lieuvente` varchar(10) DEFAULT NULL,
  `date_payement` datetime NOT NULL,
  `montantav` double DEFAULT NULL,
  `montantpr` double DEFAULT NULL,
  `montantcot` double DEFAULT NULL,
  `periodep` date DEFAULT NULL,
  `datesaisie` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `decdepense`
--

INSERT INTO `decdepense` (`id`, `numdec`, `categorie`, `montant`, `devisedep`, `payement`, `cprelever`, `coment`, `client`, `lieuvente`, `date_payement`, `montantav`, `montantpr`, `montantcot`, `periodep`, `datesaisie`) VALUES
(1, 'retd1', '4', 10000000, 'gnf', 'espèces', '1', 'paiement personnel', '2', '1', '2023-08-20 07:07:00', 0, 0, 0, '2023-07-31', '2023-08-20 09:07:16'),
(2, 'retd2', '4', 1000000, 'gnf', 'espèces', '1', 'paiement personnel', '3', '1', '2023-08-20 07:16:00', 0, 0, 0, '2023-07-31', '2023-08-20 09:16:41'),
(3, 'retd3', '2', 100000, 'gnf', 'espèces', '1', 'transport repas', NULL, '1', '2023-08-10 00:00:00', NULL, NULL, NULL, NULL, '2023-08-20 09:55:32'),
(4, 'retd4', '5', 250000, 'gnf', 'espèces', '1', 'carburant personnel', NULL, '1', '2023-08-20 09:56:01', NULL, NULL, NULL, NULL, '2023-08-20 09:56:01'),
(5, 'retd5', '2', 20000, 'gnf', 'especes', '1', 'TRANSPORT DUBREKA', NULL, '1', '2023-09-22 13:18:02', NULL, NULL, NULL, NULL, '2023-09-22 13:18:02');

-- --------------------------------------------------------

--
-- Structure de la table `decloyer`
--

DROP TABLE IF EXISTS `decloyer`;
CREATE TABLE IF NOT EXISTS `decloyer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `numdec` varchar(50) DEFAULT NULL,
  `montant` double NOT NULL,
  `payement` varchar(30) NOT NULL,
  `cprelever` varchar(50) NOT NULL,
  `coment` varchar(150) DEFAULT NULL,
  `client` varchar(155) DEFAULT NULL,
  `date_payement` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `decpersonnel`
--

DROP TABLE IF EXISTS `decpersonnel`;
CREATE TABLE IF NOT EXISTS `decpersonnel` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `numdec` varchar(50) DEFAULT NULL,
  `montant` double NOT NULL,
  `devise` varchar(50) NOT NULL DEFAULT 'gnf',
  `payement` varchar(30) NOT NULL,
  `cprelever` varchar(50) NOT NULL,
  `coment` varchar(150) DEFAULT NULL,
  `client` varchar(155) DEFAULT NULL,
  `date_payement` datetime NOT NULL,
  `lieuvente` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `decpersonnel`
--

INSERT INTO `decpersonnel` (`id`, `numdec`, `montant`, `devise`, `payement`, `cprelever`, `coment`, `client`, `date_payement`, `lieuvente`) VALUES
(1, 'bonp1', 100000, 'gnf', 'espèces', '1', 'pret mouctar', 'pers55', '2023-08-19 16:22:00', 1),
(2, 'bonp2', 10000000, 'gnf', 'espèces', '1', 'pret ismael', 'pers2', '2023-08-20 07:50:00', 1);

-- --------------------------------------------------------

--
-- Structure de la table `devise`
--

DROP TABLE IF EXISTS `devise`;
CREATE TABLE IF NOT EXISTS `devise` (
  `iddevise` int(11) NOT NULL AUTO_INCREMENT,
  `nomdevise` varchar(10) NOT NULL,
  `montantdevise` float NOT NULL,
  `idvente` varchar(50) NOT NULL,
  PRIMARY KEY (`iddevise`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `devisevente`
--

DROP TABLE IF EXISTS `devisevente`;
CREATE TABLE IF NOT EXISTS `devisevente` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `numcmd` varchar(10) DEFAULT NULL,
  `client` varchar(155) NOT NULL,
  `montant` double NOT NULL,
  `devise` varchar(20) NOT NULL,
  `taux` float NOT NULL DEFAULT '1',
  `motif` varchar(150) DEFAULT NULL,
  `typep` varchar(15) NOT NULL,
  `compte` varchar(50) DEFAULT NULL,
  `lieuvente` varchar(10) DEFAULT NULL,
  `dateop` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `devisevente`
--

INSERT INTO `devisevente` (`id`, `numcmd`, `client`, `montant`, `devise`, `taux`, `motif`, `typep`, `compte`, `lieuvente`, `dateop`) VALUES
(1, 'devisea1', 'oumane', 100, 'us', 8900, 'achat devise', 'espèces', '1', '1', '2023-07-23 10:01:11'),
(2, 'devisea2', 'Algassimou', 3000, 'aed', 2340, 'achat devise', 'espèces', '1', '1', '2023-07-23 10:04:23'),
(3, 'devisea3', 'Amadou', 200, 'eu', 10000, 'achat devise', 'espèces', '1', '1', '2023-08-07 11:02:00'),
(4, 'devisea4', 'DSDFD', 30, 'eu', 10000, 'achat devise', 'especes', '1', '1', '2023-09-22 11:19:00');

-- --------------------------------------------------------

--
-- Structure de la table `editionfacture`
--

DROP TABLE IF EXISTS `editionfacture`;
CREATE TABLE IF NOT EXISTS `editionfacture` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `numedit` varchar(150) DEFAULT NULL,
  `id_client` int(10) DEFAULT NULL,
  `libelle` varchar(150) DEFAULT NULL,
  `bl` varchar(150) DEFAULT NULL,
  `nature` varchar(150) DEFAULT NULL,
  `montant` double DEFAULT NULL,
  `devise` varchar(10) DEFAULT NULL,
  `lieuvente` int(2) DEFAULT NULL,
  `dateop` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `editionfournisseur`
--

DROP TABLE IF EXISTS `editionfournisseur`;
CREATE TABLE IF NOT EXISTS `editionfournisseur` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `numedit` varchar(150) DEFAULT NULL,
  `id_client` int(10) DEFAULT NULL,
  `libelle` varchar(150) DEFAULT NULL,
  `bl` varchar(150) DEFAULT NULL,
  `nature` varchar(150) DEFAULT NULL,
  `montant` double DEFAULT NULL,
  `montantcmd` double DEFAULT '0',
  `devise` varchar(10) DEFAULT NULL,
  `lieuvente` int(2) DEFAULT NULL,
  `dateop` datetime DEFAULT NULL,
  `etat` varchar(10) DEFAULT 'non paye',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `editionfournisseur`
--

INSERT INTO `editionfournisseur` (`id`, `numedit`, `id_client`, `libelle`, `bl`, `nature`, `montant`, `montantcmd`, `devise`, `lieuvente`, `dateop`, `etat`) VALUES
(1, 'commande1', 57, 'achat', 'cmd1', 'achat', 0, 0, 'gnf', 1, '2023-07-23 10:11:00', 'non paye');

-- --------------------------------------------------------

--
-- Structure de la table `facture`
--

DROP TABLE IF EXISTS `facture`;
CREATE TABLE IF NOT EXISTS `facture` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `numfact` varchar(50) NOT NULL,
  `numcmd` varchar(50) NOT NULL,
  `datefact` date NOT NULL,
  `fournisseur` varchar(60) NOT NULL,
  `taux` float NOT NULL DEFAULT '1',
  `montantht` double NOT NULL,
  `montantva` double DEFAULT NULL,
  `montantpaye` double DEFAULT NULL,
  `frais` double DEFAULT NULL,
  `fraistrans` double DEFAULT '0',
  `modep` varchar(50) NOT NULL DEFAULT 'gnf',
  `lieuvente` int(11) NOT NULL,
  `datepaye` datetime DEFAULT NULL,
  `datecmd` datetime NOT NULL,
  `etatcf` varchar(50) DEFAULT NULL,
  `payement` varchar(15) DEFAULT 'especes',
  `type` varchar(50) DEFAULT 'fournisseur',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `fraisup`
--

DROP TABLE IF EXISTS `fraisup`;
CREATE TABLE IF NOT EXISTS `fraisup` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `numcmd` varchar(50) DEFAULT NULL,
  `montant` double NOT NULL,
  `modep` varchar(50) NOT NULL DEFAULT 'gnf',
  `typep` varchar(50) NOT NULL DEFAULT 'espèces',
  `motif` varchar(500) NOT NULL,
  `client` varchar(155) DEFAULT NULL,
  `lieuvente` varchar(10) DEFAULT NULL,
  `date_payement` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `gaindevise`
--

DROP TABLE IF EXISTS `gaindevise`;
CREATE TABLE IF NOT EXISTS `gaindevise` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `montant` double NOT NULL,
  `coment` varchar(150) NOT NULL,
  `lieuvente` int(11) NOT NULL,
  `dateop` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `gestionachatfournisseur`
--

DROP TABLE IF EXISTS `gestionachatfournisseur`;
CREATE TABLE IF NOT EXISTS `gestionachatfournisseur` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idprod` int(11) NOT NULL,
  `pv` double NOT NULL,
  `qtite` double NOT NULL,
  `livre` double NOT NULL DEFAULT '0',
  `devise` varchar(50) NOT NULL,
  `taux` double NOT NULL,
  `tauxgnf` float NOT NULL DEFAULT '1',
  `fournisseur` int(11) NOT NULL,
  `cmd` varchar(50) NOT NULL,
  `dateop` datetime NOT NULL,
  `etatrecep` varchar(50) DEFAULT 'en-cours',
  `statut` varchar(10) NOT NULL DEFAULT 'nok',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `gestionachathist`
--

DROP TABLE IF EXISTS `gestionachathist`;
CREATE TABLE IF NOT EXISTS `gestionachathist` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idprod` int(11) NOT NULL,
  `qtite` double NOT NULL,
  `lieu` int(11) NOT NULL,
  `cmd` varchar(50) NOT NULL,
  `dateop` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `gestionchoixfournisseur`
--

DROP TABLE IF EXISTS `gestionchoixfournisseur`;
CREATE TABLE IF NOT EXISTS `gestionchoixfournisseur` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idprod` int(11) NOT NULL,
  `pv` double NOT NULL,
  `fournisseur` int(11) NOT NULL,
  `cmd` varchar(50) NOT NULL,
  `dateop` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `gestionchoixfournisseur`
--

INSERT INTO `gestionchoixfournisseur` (`id`, `idprod`, `pv`, `fournisseur`, `cmd`, `dateop`) VALUES
(1, 1144, 100000, 102, 'cmd1', '2023-09-05 11:46:53');

-- --------------------------------------------------------

--
-- Structure de la table `gestionpaiefournisseur`
--

DROP TABLE IF EXISTS `gestionpaiefournisseur`;
CREATE TABLE IF NOT EXISTS `gestionpaiefournisseur` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idprod` int(11) NOT NULL,
  `qtite` double NOT NULL,
  `pa` double NOT NULL DEFAULT '0',
  `client` int(11) NOT NULL,
  `cmd` varchar(50) NOT NULL,
  `taux` float NOT NULL DEFAULT '1',
  `tauxgnf` float NOT NULL DEFAULT '1',
  `dateop` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `gestionreception`
--

DROP TABLE IF EXISTS `gestionreception`;
CREATE TABLE IF NOT EXISTS `gestionreception` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idprod` int(11) NOT NULL,
  `qtite` double NOT NULL,
  `pv` double NOT NULL DEFAULT '0',
  `taux` float NOT NULL DEFAULT '1',
  `tauxgnf` float NOT NULL DEFAULT '1',
  `livre` double NOT NULL DEFAULT '0',
  `client` int(11) NOT NULL,
  `cmd` varchar(50) NOT NULL,
  `dateop` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `gestionselection`
--

DROP TABLE IF EXISTS `gestionselection`;
CREATE TABLE IF NOT EXISTS `gestionselection` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idprod` int(11) NOT NULL,
  `quantite` float NOT NULL DEFAULT '0',
  `pr` double DEFAULT '0',
  `categorie` varchar(50) DEFAULT NULL,
  `cmd` varchar(50) NOT NULL,
  `dateop` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `gestionselection`
--

INSERT INTO `gestionselection` (`id`, `idprod`, `quantite`, `pr`, `categorie`, `cmd`, `dateop`) VALUES
(1, 1144, 10, 100000, 'Q1', 'cmd1', '2023-09-05 11:42:36');

-- --------------------------------------------------------

--
-- Structure de la table `gestiontransporteur`
--

DROP TABLE IF EXISTS `gestiontransporteur`;
CREATE TABLE IF NOT EXISTS `gestiontransporteur` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idprod` int(11) NOT NULL,
  `qtite` double NOT NULL,
  `pv` double NOT NULL DEFAULT '0',
  `taux` float NOT NULL DEFAULT '1',
  `tauxgnf` float NOT NULL DEFAULT '1',
  `livre` double NOT NULL DEFAULT '0',
  `client` int(11) NOT NULL,
  `cmd` varchar(50) NOT NULL,
  `dateop` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `historique`
--

DROP TABLE IF EXISTS `historique`;
CREATE TABLE IF NOT EXISTS `historique` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `num_cmd` varchar(15) NOT NULL,
  `montant` double NOT NULL,
  `payement` varchar(155) NOT NULL,
  `nom_client` varchar(155) DEFAULT NULL,
  `date_cmd` datetime NOT NULL,
  `date_regul` datetime DEFAULT NULL,
  `remboursement` varchar(155) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `histpaiefrais`
--

DROP TABLE IF EXISTS `histpaiefrais`;
CREATE TABLE IF NOT EXISTS `histpaiefrais` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `num_cmd` varchar(15) NOT NULL,
  `montant` double DEFAULT NULL,
  `payement` varchar(155) NOT NULL,
  `devise` varchar(20) NOT NULL DEFAULT 'gnf',
  `nom_client` varchar(155) DEFAULT NULL,
  `lieuvente` int(11) NOT NULL,
  `date_cmd` datetime NOT NULL,
  `date_regul` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `intertopproduit`
--

DROP TABLE IF EXISTS `intertopproduit`;
CREATE TABLE IF NOT EXISTS `intertopproduit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idprod` int(11) NOT NULL,
  `quantite` int(11) NOT NULL,
  `benefice` double NOT NULL DEFAULT '0',
  `pseudo` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=138 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `inventaire`
--

DROP TABLE IF EXISTS `inventaire`;
CREATE TABLE IF NOT EXISTS `inventaire` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dettegnf` double DEFAULT '0',
  `creancegnf` double DEFAULT '0',
  `comptegnf` double DEFAULT '0',
  `stock` double DEFAULT '0',
  `pertes` double DEFAULT '0',
  `gain` double DEFAULT '0',
  `solde` double DEFAULT '0',
  `depenses` double DEFAULT '0',
  `lieuvente` int(2) DEFAULT '1',
  `anneeinv` int(4) DEFAULT '0',
  `dateop` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `inventaire`
--

INSERT INTO `inventaire` (`id`, `dettegnf`, `creancegnf`, `comptegnf`, `stock`, `pertes`, `gain`, `solde`, `depenses`, `lieuvente`, `anneeinv`, `dateop`) VALUES
(2, 70240000, 1170405000, 0, 3650808343, NULL, NULL, 4750973343, NULL, 1, 2023, '2023-07-11');

-- --------------------------------------------------------

--
-- Structure de la table `licence`
--

DROP TABLE IF EXISTS `licence`;
CREATE TABLE IF NOT EXISTS `licence` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `num_licence` varchar(155) NOT NULL,
  `nom_societe` varchar(255) NOT NULL,
  `date_souscription` date NOT NULL,
  `date_fin` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `licence`
--

INSERT INTO `licence` (`id`, `num_licence`, `nom_societe`, `date_souscription`, `date_fin`) VALUES
(1, 'L000049', 'damko', '2023-07-11', '2024-07-11');

-- --------------------------------------------------------

--
-- Structure de la table `limitecredit`
--

DROP TABLE IF EXISTS `limitecredit`;
CREATE TABLE IF NOT EXISTS `limitecredit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `montant` double NOT NULL DEFAULT '1000000000000',
  `idclient` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=197 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `limitecredit`
--

INSERT INTO `limitecredit` (`id`, `montant`, `idclient`) VALUES
(1, 1000000000, 26),
(2, 1000000000, 102),
(3, 1000000000, 183),
(4, 1000000000, 93),
(5, 1000000000, 132),
(6, 1000000000, 184),
(7, 1000000000, 114),
(8, 1000000000, 127),
(9, 1000000000, 81),
(10, 1000000000, 130),
(11, 1000000000, 133),
(12, 1000000000, 134),
(13, 1000000000, 46),
(14, 1000000000, 176),
(15, 1000000000, 94),
(16, 1000000000, 115),
(17, 1000000000, 35),
(18, 1000000000, 62),
(19, 1000000000, 135),
(20, 1000000000, 136),
(21, 1000000000, 177),
(22, 1000000000, 137),
(23, 1000000000, 126),
(24, 1000000000, 138),
(25, 1000000000, 33),
(26, 1000000000, 88),
(27, 1000000000, 17),
(28, 1000000000, 53),
(29, 1000000000, 48),
(30, 1000000000, 52),
(31, 1000000000, 67),
(32, 1000000000, 72),
(33, 1000000000, 91),
(34, 1000000000, 25),
(35, 1000000000, 139),
(36, 1000000000, 140),
(37, 1000000000, 61),
(38, 1000000000, 113),
(39, 1000000000, 98),
(40, 1000000000, 1),
(41, 1000000000, 174),
(42, 1000000000, 5),
(43, 1000000000, 104),
(44, 1000000000, 16),
(45, 1000000000, 24),
(46, 1000000000, 141),
(47, 1000000000, 95),
(48, 1000000000, 118),
(49, 1000000000, 22),
(50, 1000000000, 21),
(51, 1000000000, 12),
(52, 1000000000, 109),
(53, 1000000000, 39),
(54, 1000000000, 38),
(55, 1000000000, 20),
(56, 1000000000, 74),
(57, 1000000000, 123),
(58, 1000000000, 2),
(59, 1000000000, 142),
(60, 1000000000, 36),
(61, 1000000000, 143),
(62, 1000000000, 144),
(63, 1000000000, 145),
(64, 1000000000, 173),
(65, 1000000000, 7),
(66, 1000000000, 131),
(67, 1000000000, 101),
(68, 1000000000, 76),
(69, 1000000000, 51),
(70, 1000000000, 103),
(71, 1000000000, 73),
(72, 1000000000, 99),
(73, 1000000000, 40),
(74, 1000000000, 146),
(75, 1000000000, 186),
(76, 1000000000, 110),
(77, 1000000000, 89),
(78, 1000000000, 87),
(79, 1000000000, 147),
(80, 1000000000, 107),
(81, 1000000000, 29),
(82, 1000000000, 65),
(83, 1000000000, 148),
(84, 1000000000, 149),
(85, 1000000000, 83),
(86, 1000000000, 97),
(87, 1000000000, 105),
(88, 1000000000, 150),
(89, 1000000000, 185),
(90, 1000000000, 18),
(91, 1000000000, 80),
(92, 1000000000, 28),
(93, 1000000000, 77),
(94, 1000000000, 66),
(95, 1000000000, 49),
(96, 1000000000, 151),
(97, 1000000000, 96),
(98, 1000000000, 120),
(99, 1000000000, 59),
(100, 1000000000, 180),
(101, 1000000000, 181),
(102, 1000000000, 56),
(103, 1000000000, 152),
(104, 1000000000, 191),
(105, 1000000000, 153),
(106, 1000000000, 10),
(107, 1000000000, 90),
(108, 1000000000, 108),
(109, 1000000000, 64),
(110, 1000000000, 84),
(111, 1000000000, 92),
(112, 1000000000, 78),
(113, 1000000000, 6),
(114, 1000000000, 23),
(115, 1000000000, 190),
(116, 1000000000, 154),
(117, 1000000000, 31),
(118, 1000000000, 30),
(119, 1000000000, 37),
(120, 1000000000, 106),
(121, 1000000000, 34),
(122, 1000000000, 155),
(123, 1000000000, 119),
(124, 1000000000, 122),
(125, 1000000000, 60),
(126, 1000000000, 27),
(127, 1000000000, 188),
(128, 1000000000, 63),
(129, 1000000000, 100),
(130, 1000000000, 41),
(131, 1000000000, 43),
(132, 1000000000, 178),
(133, 1000000000, 182),
(134, 1000000000, 85),
(135, 1000000000, 192),
(136, 1000000000, 112),
(137, 1000000000, 71),
(138, 1000000000, 156),
(139, 1000000000, 44),
(140, 1000000000, 157),
(141, 1000000000, 50),
(142, 1000000000, 175),
(143, 1000000000, 158),
(144, 1000000000, 32),
(145, 1000000000, 172),
(146, 1000000000, 159),
(147, 1000000000, 160),
(148, 1000000000, 15),
(149, 1000000000, 42),
(150, 1000000000, 161),
(151, 1000000000, 4),
(152, 1000000000, 3),
(153, 1000000000, 111),
(154, 1000000000, 124),
(155, 1000000000, 179),
(156, 1000000000, 189),
(157, 1000000000, 86),
(158, 1000000000, 162),
(159, 1000000000, 125),
(160, 1000000000, 9),
(161, 1000000000, 11),
(162, 1000000000, 75),
(163, 1000000000, 116),
(164, 1000000000, 8),
(165, 1000000000, 163),
(166, 1000000000, 82),
(167, 1000000000, 164),
(168, 1000000000, 47),
(169, 1000000000, 165),
(170, 1000000000, 45),
(171, 1000000000, 13),
(172, 1000000000, 166),
(173, 1000000000, 167),
(174, 1000000000, 168),
(175, 1000000000, 58),
(176, 1000000000, 128),
(177, 1000000000, 54),
(178, 1000000000, 55),
(179, 1000000000, 69),
(180, 1000000000, 57),
(181, 1000000000, 70),
(182, 1000000000, 187),
(183, 1000000000, 79),
(184, 1000000000, 169),
(185, 1000000000, 170),
(186, 1000000000, 117),
(187, 1000000000, 19),
(188, 1000000000, 121),
(189, 1000000000, 171),
(190, 1000000000, 129),
(191, 1000000000, 68),
(192, 1000000000, 14),
(193, 1000000000, NULL),
(194, 1000000000, NULL),
(195, 1000000000, NULL),
(196, 1000000000, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `livraison`
--

DROP TABLE IF EXISTS `livraison`;
CREATE TABLE IF NOT EXISTS `livraison` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idcmd` int(11) DEFAULT NULL,
  `id_produitliv` int(11) DEFAULT NULL,
  `quantiteliv` int(11) DEFAULT '0',
  `numcmdliv` varchar(50) NOT NULL,
  `id_clientliv` int(10) DEFAULT NULL,
  `livreur` varchar(50) NOT NULL,
  `idstockliv` int(11) DEFAULT NULL,
  `dateliv` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=117 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `livraison`
--

INSERT INTO `livraison` (`id`, `idcmd`, `id_produitliv`, `quantiteliv`, `numcmdliv`, `id_clientliv`, `livreur`, `idstockliv`, `dateliv`) VALUES
(1, 1, 340, 1, 'ibe230001', 1, '50', 1, '2023-07-12 12:52:51'),
(2, 2, 31, 1, 'ibe230002', 1, '50', 1, '2023-07-12 12:54:25'),
(3, 3, 793, 1, 'ibe230003', 1, '50', 1, '2023-07-12 12:59:47'),
(45, 45, 370, 1, 'ibe230029', 63, '50', 1, '2023-07-12 14:13:46'),
(5, 5, 811, 1, 'ibe230005', 10, '50', 1, '2023-07-12 13:02:11'),
(6, 6, 793, 1, 'ibe230006', 1, '50', 1, '2023-07-12 13:02:46'),
(7, 7, 703, 1, 'ibe230007', 1, '50', 1, '2023-07-12 13:03:22'),
(8, 8, 355, 1, 'ibe230008', 1, '50', 1, '2023-07-12 13:03:46'),
(11, 11, 208, 1, 'ibe230009', 29, '50', 1, '2023-07-11 00:00:00'),
(10, 10, 580, 1, 'ibe230010', 1, '50', 1, '2023-07-12 13:04:50'),
(18, 18, 13, 2, 'ibe230011', 97, '50', 1, '2023-07-11 00:00:00'),
(17, 17, 16, 2, 'ibe230011', 97, '50', 1, '2023-07-11 00:00:00'),
(16, 16, 19, 2, 'ibe230011', 97, '50', 1, '2023-07-11 00:00:00'),
(19, 19, 832, 1, 'ibe230012', 25, '50', 1, '2023-07-11 00:00:00'),
(20, 20, 688, 7, 'ibe230013', 187, '50', 1, '2023-07-12 13:43:25'),
(21, 21, 637, 21, 'ibe230013', 187, '50', 1, '2023-07-12 13:43:25'),
(47, 47, 946, 2, 'ibe230031', 1, '50', 1, '2023-07-12 14:15:41'),
(23, 23, 205, 1, 'ibe230015', 28, '50', 1, '2023-07-12 13:47:03'),
(24, 24, 811, 1, 'ibe230016', 78, '50', 1, '2023-07-12 13:48:04'),
(25, 25, 1339, 3, 'ibe230017', 89, '50', 1, '2023-07-12 13:49:54'),
(26, 26, 703, 4, 'ibe230018', 11, '50', 1, '2023-07-12 13:53:07'),
(27, 27, 52, 1, 'ibe230018', 11, '50', 1, '2023-07-12 13:53:07'),
(28, 28, 130, 1, 'ibe230018', 11, '50', 1, '2023-07-12 13:53:07'),
(29, 29, 343, 1, 'ibe230018', 11, '50', 1, '2023-07-12 13:53:07'),
(30, 30, 793, 1, 'ibe230019', 26, '50', 1, '2023-07-12 13:54:00'),
(31, 31, 913, 1, 'ibe230020', 29, '50', 1, '2023-07-12 13:55:38'),
(32, 32, 1150, 1, 'ibe230020', 29, '50', 1, '2023-07-12 13:55:38'),
(33, 33, 466, 1, 'ibe230020', 29, '50', 1, '2023-07-12 13:55:38'),
(34, 34, 355, 1, 'ibe230020', 29, '50', 1, '2023-07-12 13:55:38'),
(35, 35, 913, 1, 'ibe230021', 8, '50', 1, '2023-07-12 13:56:24'),
(36, 36, 682, 3, 'ibe230022', 22, '50', 1, '2023-07-12 13:57:37'),
(37, 37, 685, 1, 'ibe230022', 22, '50', 1, '2023-07-12 13:57:37'),
(38, 38, 910, 1, 'ibe230023', 184, '50', 1, '2023-07-12 13:58:26'),
(46, 46, 205, 1, 'ibe230030', 14, '50', 1, '2023-07-12 14:14:53'),
(40, 40, 1105, 3, 'ibe230025', 96, '50', 1, '2023-07-12 14:00:12'),
(41, 41, 271, 1, 'ibe230026', 10, '50', 1, '2023-07-12 14:01:42'),
(42, 42, 289, 1, 'ibe230026', 10, '50', 1, '2023-07-12 14:01:42'),
(43, 43, 1243, 1, 'ibe230027', 20, '50', 1, '2023-07-12 14:02:36'),
(44, 44, 811, 1, 'ibe230028', 2, '50', 1, '2023-07-12 14:03:20'),
(48, 48, 181, 4, 'ibe230032', 1, '50', 1, '2023-07-12 14:16:29'),
(49, 49, 1108, 1, 'ibe230033', 1, '50', 1, '2023-07-12 14:16:57'),
(50, 50, 946, 1, 'ibe230034', 29, '50', 1, '2023-07-12 14:17:43'),
(51, 51, 1300, 1, 'ibe230035', 6, '53', 1, '2023-07-12 15:13:36'),
(59, 59, 1234, 1, 'ibe230036', 98, '53', 1, '2023-07-12 15:47:55'),
(58, 58, 1228, 1, 'ibe230036', 98, '53', 1, '2023-07-12 15:47:55'),
(57, 57, 1225, 1, 'ibe230036', 98, '53', 1, '2023-07-12 15:47:55'),
(56, 56, 1231, 1, 'ibe230036', 98, '53', 1, '2023-07-12 15:47:55'),
(60, 60, 376, 1, 'ibe230037', 45, '53', 1, '2023-07-12 17:27:57'),
(61, 61, 202, 1, 'ibe230038', NULL, '1', 1, '2023-07-13 12:32:17'),
(62, 62, 220, 1, 'ibe230039', NULL, '1', 1, '2023-07-13 12:39:22'),
(63, 63, 214, 1, 'ibe230039', NULL, '1', 1, '2023-07-13 12:39:22'),
(64, 83, 217, 2, 'ibe230048', 1, '1', 1, '2023-07-14 13:25:21'),
(65, 84, 220, 2, 'ibe230049', 1, '1', 1, '2023-07-14 13:26:13'),
(66, 85, 364, 1, 'ibe230050', 1, '1', 1, '2023-07-14 13:26:44'),
(67, 86, 349, 3, 'ibe230051', 1, '1', 1, '2023-07-17 11:01:30'),
(68, 87, 220, 2, 'ibe230052', NULL, '1', 1, '2023-07-17 11:14:24'),
(69, 88, 220, 1, 'ibe230053', 6, '1', 1, '2023-07-17 11:29:54'),
(70, 90, 202, 1, 'ibe230055', 1, '1', 1, '2023-07-27 09:26:17'),
(71, 91, 202, 1, 'ibe230056', 1, '1', 1, '2023-07-27 09:30:24'),
(72, 92, 229, 1, 'ibe230057', 1, '1', 1, '2023-07-27 09:31:51'),
(73, 93, 202, 1, 'ibe230058', 1, '1', 1, '2023-07-27 09:33:03'),
(74, 94, 202, 1, 'ibe230059', 1, '1', 1, '2023-07-27 09:35:25'),
(75, 95, 202, 1, 'ibe230060', 1, '1', 1, '2023-07-27 09:36:25'),
(76, 96, 202, 1, 'ibe230061', 1, '1', 1, '2023-07-27 09:36:52'),
(77, 97, 202, 1, 'ibe230062', 1, '1', 1, '2023-07-27 09:37:39'),
(78, 98, 202, 1, 'ibe230063', 1, '1', 1, '2023-07-27 09:37:53'),
(79, 99, 202, 1, 'ibe230064', 1, '1', 1, '2023-07-27 10:15:25'),
(80, 100, 202, 1, 'ibe230065', 1, '1', 1, '2023-07-27 11:02:53'),
(81, 101, 202, 1, 'ibe230066', 1, '1', 1, '2023-07-27 11:03:59'),
(82, 102, 202, 1, 'ibe230067', 1, '1', 1, '2023-07-27 11:24:01'),
(83, 103, 202, 1, 'ibe230068', 1, '1', 1, '2023-07-27 11:28:02'),
(84, 104, 202, 2, 'ibe230069', 1, '1', 1, '2023-07-27 11:29:19'),
(85, 107, 202, 2, 'ibe230072', 183, '1', 1, '2023-07-27 11:52:11'),
(86, 3, 220, 1, 'ibe230075', 1, '1', 1, '2023-07-27 11:58:26'),
(87, 6, 202, 1, 'ibe230078', 1, '1', 1, '2023-07-27 12:04:01'),
(88, 10, 202, 1, 'ibe230082', 26, '1', 1, '2023-07-27 12:12:26'),
(89, 11, 202, 1, 'ibe230083', 26, '1', 1, '2023-07-27 12:48:53'),
(90, 13, 202, 1, 'ibe230085', NULL, '1', 1, '2023-07-27 13:08:50'),
(91, 14, 229, 1, 'ibe230086', 1, '1', 1, '2023-08-20 10:19:41'),
(92, 15, 202, 1, 'ibe230087', 1, '1', 1, '2023-08-27 18:01:17'),
(93, 16, 202, 1, 'ibe230088', 1, '1', 1, '2023-08-27 18:03:56'),
(94, 17, 220, 1, 'ibe230089', 1, '1', 1, '2023-09-02 11:11:36'),
(95, 18, 349, 1, 'ibe230089', 1, '1', 1, '2023-09-02 11:11:36'),
(99, 22, 253, 2, 'ibe230091', 1, '1', 1, '2023-09-02 13:12:12'),
(98, 21, 220, 3, 'ibe230091', 1, '1', 1, '2023-09-02 13:12:12'),
(103, 26, 421, 1, 'ibe230093', 1, '1', 1, '2023-09-02 13:42:35'),
(102, 25, 205, 3, 'ibe230093', 1, '1', 1, '2023-09-02 13:42:35'),
(104, 29, 205, 1, 'ibe230094', 1, '1', 1, '2023-09-02 13:48:33'),
(105, 30, 220, 5, 'ibe230094', 1, '1', 1, '2023-09-02 13:48:33'),
(106, 33, 220, 1, 'ibe230095', 1, '1', 1, '2023-09-02 13:52:14'),
(107, 36, 220, 4, 'ibe230096', 1, '1', 1, '2023-09-02 13:55:09'),
(108, 39, 220, 4, 'ibe230097', 1, '1', 1, '2023-09-02 13:57:20'),
(109, 42, 220, 4, 'ibe230098', 1, '1', 1, '2023-09-02 14:03:28'),
(110, 45, 217, 1, 'ibe230099', 1, '1', 1, '2023-09-02 14:06:26'),
(111, 52, 349, 2, 'ibe230102', 93, '1', 1, '2023-09-11 12:44:45'),
(112, 52, 349, 1, 'ibe230102', 93, '1', 1, '2023-09-11 12:50:50'),
(113, 52, 349, -1, 'ibe230102', 93, '1', 1, '2023-09-11 12:55:54'),
(114, 52, 349, -1, 'ibe230102', 93, '1', 1, '2023-09-11 12:56:16'),
(115, 62, 364, 2, 'ibe230106', 1, '1', 1, '2023-09-12 20:43:35'),
(116, 63, 202, 1, 'ibe230107', 1, '1', 1, '2023-09-12 20:45:17');

-- --------------------------------------------------------

--
-- Structure de la table `livraisondelete`
--

DROP TABLE IF EXISTS `livraisondelete`;
CREATE TABLE IF NOT EXISTS `livraisondelete` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_produitliv` int(11) DEFAULT NULL,
  `quantiteliv` int(11) DEFAULT '0',
  `numcmdliv` varchar(50) NOT NULL,
  `id_clientliv` int(10) DEFAULT NULL,
  `idpersonnel` varchar(50) NOT NULL,
  `idstockliv` int(11) DEFAULT NULL,
  `datedelete` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `livraisondelete`
--

INSERT INTO `livraisondelete` (`id`, `id_produitliv`, `quantiteliv`, `numcmdliv`, `id_clientliv`, `idpersonnel`, `idstockliv`, `datedelete`) VALUES
(1, 355, 1, 'ibe230014', 51, '50', 1, '2023-07-12 14:04:39'),
(2, 94, 1, 'ibe230024', 73, '50', 1, '2023-07-12 14:04:58'),
(3, 793, 1, 'ibe230004', 86, '50', 1, '2023-07-12 14:12:24'),
(4, 220, 3, 'ibe230090', 1, '1', 1, '2023-09-02 13:11:40'),
(5, 253, 2, 'ibe230090', 1, '1', 1, '2023-09-02 13:11:40'),
(6, 205, 1, 'ibe230092', 1, '1', 1, '2023-09-02 13:30:26'),
(7, 253, 3, 'ibe230092', 1, '1', 1, '2023-09-02 13:30:26');

-- --------------------------------------------------------

--
-- Structure de la table `login`
--

DROP TABLE IF EXISTS `login`;
CREATE TABLE IF NOT EXISTS `login` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `identifiant` varchar(50) DEFAULT NULL,
  `nom` varchar(100) NOT NULL,
  `telephone` varchar(15) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `pseudo` varchar(15) NOT NULL,
  `mdp` text NOT NULL,
  `level` int(10) NOT NULL,
  `statut` varchar(100) NOT NULL,
  `lieuvente` int(11) NOT NULL,
  `type` varchar(50) DEFAULT 'personnel',
  `dateenreg` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=56 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `login`
--

INSERT INTO `login` (`id`, `identifiant`, `nom`, `telephone`, `email`, `pseudo`, `mdp`, `level`, `statut`, `lieuvente`, `type`, `dateenreg`) VALUES
(1, '1', 'admin', '628196628', 'd.amadoumouctar@yahoo.fr', 'damkoguinee@', '$2y$10$SEjMzpjmCN0wJqBIfTC4WOzzooTYsEx6IM7/1/fq4mEbN80eF9J26', 7, 'admin', 1, 'admin', '2022-03-25 13:57:28'),
(2, 'pers2', 'Ismael Barry', '622553939', '', 'ibeta85', '$2y$10$6XSO46mUQENTE0UQjWoPdO/YkjWXtzf0F7XWpLegnQiy87SfjFPu2', 7, 'responsable', 1, 'personnel', '2022-03-25 13:57:28'),
(51, NULL, 'BETA', '664335251', '', '664335251', '$2y$10$WJYnCLXbrO9O47lEOfzzGuJtY8JJnj.U.SKfIMlpXD.l/dERB6LPK', 1, 'fournisseur', 1, 'fournisseur', '2023-07-11 12:42:47'),
(52, NULL, 'BANQUE ISLAMIQUE', '000000000000001', '', '000000000000001', '$2y$10$Oq4MQ.P2n3gr2luTpXkkQemL7ALTE6h1nE.KrQcGcCdj5kPGjbSqm', 1, 'Banque', 1, 'Banque', '2023-07-12 13:14:29'),
(3, 'pers3', 'KONE HAWA', '610681323', '', 'KONE23', '$2y$10$7ZAYwAStS9FR.zV4rm5BweZO8P1jPTKp44oCpQ7ywc0EvMvg63Xti', 6, 'vendeur', 1, 'personnel', '2023-07-12 14:37:43'),
(54, NULL, 'bci', '777777', '', '777777', '$2y$10$uZj2ggT5R7yDPdgKK4toi.4SOHcStk3pbdaG1bz/2NZ2lej5K5EjC', 1, 'Banque', 1, 'Banque', '2023-07-22 22:35:11'),
(55, 'pers55', 'Mouctar diallo', '628196628', '', 'vendeur', '$2y$10$9GowNm2R5mVIoHUtxIUzkuBma94B3BG2InEi3Y0fWVqT/uhJitGHu', 7, 'responsable', 1, 'personnel', '2023-08-19 17:21:01');

-- --------------------------------------------------------

--
-- Structure de la table `logo`
--

DROP TABLE IF EXISTS `logo`;
CREATE TABLE IF NOT EXISTS `logo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(155) NOT NULL,
  `nbrevente` float DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `modep`
--

DROP TABLE IF EXISTS `modep`;
CREATE TABLE IF NOT EXISTS `modep` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `numpaiep` varchar(50) NOT NULL,
  `caisse` varchar(20) DEFAULT NULL,
  `client` int(11) DEFAULT NULL,
  `montant` double DEFAULT NULL,
  `modep` varchar(20) NOT NULL,
  `taux` float DEFAULT NULL,
  `numerocheque` varchar(50) DEFAULT NULL,
  `banquecheque` varchar(100) DEFAULT NULL,
  `etatcheque` varchar(50) DEFAULT 'non traite',
  `datefact` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=35 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `modep`
--

INSERT INTO `modep` (`id`, `numpaiep`, `caisse`, `client`, `montant`, `modep`, `taux`, `numerocheque`, `banquecheque`, `etatcheque`, `datefact`) VALUES
(1, 'ibe230081', '1', 102, 100000, 'gnf', 1, '', '', '', '2023-07-27 10:11:00'),
(2, 'ibe230082', '1', 26, 200000, 'gnf', 1, '', '', '', '2023-07-27 10:12:00'),
(3, 'ibe230083', '1', 26, 200000, 'gnf', 1, '', '', '', '2023-07-27 10:48:00'),
(4, 'ibe230085', '1', NULL, 200000, 'gnf', 1, '', '', '', '2023-07-27 11:08:00'),
(5, 'dep18', '1', 6, 2000, 'espèces', 1, '', '', 'non traite', '2023-08-07 12:58:39'),
(6, 'dep19', '1', 6, 50000000, 'espèces', 1, '', '', 'non traite', '2023-08-07 13:02:33'),
(7, 'dep20', '1', 7, 20000000, 'espèces', 1, '', '', 'non traite', '2023-08-08 15:12:04'),
(8, 'dep21', '1', 7, 50000000, 'espèces', 1, '', '', 'non traite', '2023-08-08 15:24:06'),
(10, 'dep22', '1', 6, 500, 'espèces', 10000, '', '', 'non traite', '2023-08-08 15:38:57'),
(11, 'dep24', '193', 15, 10000000, 'virement', 1, '', '', 'non traite', '2023-08-19 16:43:42'),
(12, 'ibe230086', '1', 1, 4300000, 'gnf', 1, '', '', '', '2023-08-20 08:19:00'),
(13, 'dep25', '1', 17, 20000000, 'espèces', 1, '', '', 'non traite', '2023-08-20 10:46:10'),
(14, 'dep26', '1', 6, 20000000, 'espèces', 1, '', '', 'non traite', '2023-08-27 10:28:00'),
(15, 'dep27', '1', 6, 1000000, 'espèces', 1, '', '', 'non traite', '2023-08-27 10:29:00'),
(16, 'dep28', '1', 7, 20000, 'espèces', 1, '', '', 'non traite', '2023-08-27 15:30:00'),
(17, 'ibe230087', '1', 1, 200000, 'gnf', 1, '', '', '', '2023-08-27 04:01:00'),
(18, 'ibe230088', '1', 1, 200000, 'gnf', 1, '', '', '', '2023-08-27 04:03:00'),
(19, 'ibe230089', '1', 1, 600000, 'gnf', 1, '', '', '', '2023-09-02 09:11:00'),
(21, 'ibe230091', '1', 1, 5200000, 'gnf', 1, '', '', '', '2023-09-02 11:12:00'),
(23, 'ibe230093', '1', 1, 5690000, 'gnf', 1, '', '', '', '2023-09-02 11:42:00'),
(24, 'ibe230094', '1', 1, -400000, 'gnf', 1, '', '', '', '2023-09-02 11:48:00'),
(25, 'ibe230095', '1', 1, 200000, 'gnf', 1, '', '', '', '2023-09-02 11:52:00'),
(26, 'ibe230096', '1', 1, 200000, 'gnf', 1, '', '', '', '2023-09-02 11:55:00'),
(27, 'ibe230097', '1', 1, 200000, 'gnf', 1, '', '', '', '2023-09-02 11:57:00'),
(28, 'ibe230098', '1', 1, 400000, 'gnf', 1, '', '', '', '2023-09-02 12:03:00'),
(29, 'ibe230099', '1', 1, 150000, 'gnf', 1, '', '', '', '2023-09-02 12:06:00'),
(30, 'ibe230101', '1', 93, 80000, 'gnf', 1, '', '', '', '2023-09-04 10:26:00'),
(31, 'dep29', '1', 93, 10000000, 'espèces', 1, '', '', 'non traite', '2023-09-04 10:28:00'),
(32, 'ibe230106', '1', 1, 2000000, 'gnf', 1, '', '', '', '2023-09-12 06:43:00'),
(33, 'ibe230107', '1', 1, 200000, 'gnf', 1, '', '', '', '2023-09-12 06:45:00'),
(34, 'dep30', '1', 6, 9000000, 'especes', 1, '', '', 'non traite', '2023-09-12 18:51:00');

-- --------------------------------------------------------

--
-- Structure de la table `modifcommande`
--

DROP TABLE IF EXISTS `modifcommande`;
CREATE TABLE IF NOT EXISTS `modifcommande` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `num_cmd` varchar(50) NOT NULL,
  `exec` int(11) NOT NULL,
  `dateop` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `modifcommande`
--

INSERT INTO `modifcommande` (`id`, `num_cmd`, `exec`, `dateop`) VALUES
(1, 'ibe230009', 50, '2023-07-12 13:29:49'),
(2, 'ibe230011', 50, '2023-07-12 13:40:50'),
(3, 'ibe230012', 50, '2023-07-12 13:41:06'),
(4, 'ibe230036', 53, '2023-07-12 15:53:10'),
(5, 'ibe230047', 1, '2023-07-14 13:12:12'),
(6, 'ibe230047', 1, '2023-07-14 13:14:27'),
(7, 'ibe230047', 1, '2023-07-14 13:15:25'),
(8, 'ibe230047', 1, '2023-07-14 13:15:44'),
(9, 'ibe230047', 1, '2023-07-14 13:17:51'),
(10, 'ibe230045', 1, '2023-07-14 13:18:31'),
(11, 'ibe230047', 1, '2023-07-14 13:19:24');

-- --------------------------------------------------------

--
-- Structure de la table `modifpayement`
--

DROP TABLE IF EXISTS `modifpayement`;
CREATE TABLE IF NOT EXISTS `modifpayement` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `num_cmd` varchar(50) NOT NULL,
  `Total` double NOT NULL,
  `fraisup` double DEFAULT '0',
  `montantpaye` double DEFAULT '0',
  `remise` double DEFAULT '0',
  `reste` double NOT NULL,
  `etat` varchar(155) NOT NULL,
  `etatliv` varchar(20) NOT NULL DEFAULT 'nonlivre',
  `vendeur` varchar(155) DEFAULT NULL,
  `num_client` int(10) DEFAULT NULL,
  `nomclient` varchar(150) DEFAULT NULL,
  `caisse` int(11) NOT NULL,
  `lieuvente` varchar(10) DEFAULT NULL,
  `date_cmd` datetime NOT NULL,
  `date_regul` datetime DEFAULT NULL,
  `datealerte` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `modifpayement`
--

INSERT INTO `modifpayement` (`id`, `num_cmd`, `Total`, `fraisup`, `montantpaye`, `remise`, `reste`, `etat`, `etatliv`, `vendeur`, `num_client`, `nomclient`, `caisse`, `lieuvente`, `date_cmd`, `date_regul`, `datealerte`) VALUES
(1, 'ibe230009', 250000, 0, 250000, 0, 0, 'totalite', 'nonlivre', '50', 29, NULL, 1, '1', '2023-07-12 13:04:25', NULL, NULL),
(2, 'ibe230011', 640000, 0, 0, 0, 640000, 'credit', 'nonlivre', '50', 97, NULL, 1, '1', '2023-07-12 13:39:07', NULL, NULL),
(3, 'ibe230012', 6000000, 0, 0, 0, 6000000, 'credit', 'nonlivre', '50', 25, NULL, 1, '1', '2023-07-12 13:40:24', NULL, NULL),
(4, 'ibe230036', 2200000, 0, 2200000, 0, 0, 'totalite', 'nonlivre', '53', 98, NULL, 1, '1', '2023-07-12 15:47:55', NULL, NULL),
(5, 'ibe230047', 5000000, 0, 0, 0, 5000000, 'credit', 'nonlivre', '1', 183, NULL, 1, '1', '2023-07-14 12:56:29', NULL, NULL),
(6, 'ibe230047', 5000000, 0, 0, 0, 5000000, 'credit', 'nonlivre', '1', 183, NULL, 1, '1', '2023-07-14 12:56:29', NULL, NULL),
(7, 'ibe230047', 5000000, 0, 0, 0, 5000000, 'credit', 'nonlivre', '1', 183, NULL, 1, '1', '2023-07-14 12:56:29', NULL, NULL),
(8, 'ibe230047', 10000000, 0, 0, 0, 10000000, 'credit', 'nonlivre', '1', 183, NULL, 1, '1', '2023-07-14 12:56:29', NULL, NULL),
(9, 'ibe230047', 10000000, 0, 0, 0, 10000000, 'credit', 'nonlivre', '1', 183, NULL, 1, '1', '2023-07-13 00:00:00', NULL, NULL),
(10, 'ibe230045', 200000, 0, 0, 0, 200000, 'credit', 'nonlivre', '1', 183, NULL, 1, '1', '2023-07-14 12:49:25', NULL, NULL),
(11, 'ibe230047', 10000000, 0, 0, 0, 10000000, 'credit', 'nonlivre', '1', 183, NULL, 1, '1', '2023-07-13 00:00:00', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `modifpayementprod`
--

DROP TABLE IF EXISTS `modifpayementprod`;
CREATE TABLE IF NOT EXISTS `modifpayementprod` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_produit` int(11) DEFAULT NULL,
  `prix_vente` double DEFAULT NULL,
  `prix_achat` double DEFAULT '0',
  `prix_revient` double DEFAULT '0',
  `quantity` int(11) NOT NULL,
  `qtiteliv` int(11) DEFAULT '0',
  `etatlivcmd` varchar(10) DEFAULT 'nonlivre',
  `num_cmd` varchar(50) NOT NULL,
  `id_client` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `modifpayementprod`
--

INSERT INTO `modifpayementprod` (`id`, `id_produit`, `prix_vente`, `prix_achat`, `prix_revient`, `quantity`, `qtiteliv`, `etatlivcmd`, `num_cmd`, `id_client`) VALUES
(1, 208, 250000, 0, 209034, 1, 0, 'nonlivre', 'ibe230009', 29),
(2, 19, 150000, 0, 108486, 2, 0, 'nonlivre', 'ibe230011', 97),
(3, 16, 100000, 0, 63504, 2, 0, 'nonlivre', 'ibe230011', 97),
(4, 13, 70000, 0, 41013, 2, 0, 'nonlivre', 'ibe230011', 97),
(5, 832, 6000000, 0, 5212620, 1, 0, 'nonlivre', 'ibe230012', 25),
(6, 1255, 550000, 0, 402192, 1, 0, 'nonlivre', 'ibe230036', 98),
(7, 1252, 550000, 0, 428652, 1, 0, 'nonlivre', 'ibe230036', 98),
(8, 1249, 550000, 0, 428652, 1, 0, 'nonlivre', 'ibe230036', 98),
(9, 1258, 550000, 0, 428652, 1, 0, 'nonlivre', 'ibe230036', 98),
(10, 253, 5000000, 0, 3704400, 1, 0, 'nonlivre', 'ibe230047', 183),
(11, 253, 5000000, 0, 3704400, 1, 0, 'nonlivre', 'ibe230047', 183),
(12, 253, 5000000, 0, 3704400, 1, 0, 'nonlivre', 'ibe230047', 183),
(13, 253, 5000000, 0, 3704400, 2, 0, 'nonlivre', 'ibe230047', 183),
(14, 253, 5000000, 0, 3704400, 2, 0, 'nonlivre', 'ibe230047', 183),
(15, 202, 200000, 0, 189189, 1, 0, 'nonlivre', 'ibe230045', 183),
(16, 253, 5000000, 0, 3704400, 2, 0, 'nonlivre', 'ibe230047', 183);

-- --------------------------------------------------------

--
-- Structure de la table `modifprix`
--

DROP TABLE IF EXISTS `modifprix`;
CREATE TABLE IF NOT EXISTS `modifprix` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_produit` int(10) NOT NULL,
  `prix_vente` double NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `nombanque`
--

DROP TABLE IF EXISTS `nombanque`;
CREATE TABLE IF NOT EXISTS `nombanque` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nomb` varchar(50) NOT NULL,
  `numero` varchar(100) DEFAULT NULL,
  `type` varchar(100) NOT NULL DEFAULT 'banque',
  `lieuvente` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=195 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `nombanque`
--

INSERT INTO `nombanque` (`id`, `nomb`, `numero`, `type`, `lieuvente`) VALUES
(1, 'caisse boutique 1', '00001', 'caisse', 1),
(2, 'caisse boutique 2', '00002', 'caisse', 2),
(193, 'BANQUE ISLAMIQUE', '193', 'banque', 1),
(194, 'Bci', '194', 'banque', 1);

-- --------------------------------------------------------

--
-- Structure de la table `numerocommande`
--

DROP TABLE IF EXISTS `numerocommande`;
CREATE TABLE IF NOT EXISTS `numerocommande` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `numero` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=113 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `numerocommande`
--

INSERT INTO `numerocommande` (`id`, `numero`) VALUES
(1, 'ibe230001'),
(2, 'ibe230002'),
(3, 'ibe230003'),
(4, 'ibe230004'),
(5, 'ibe230005'),
(6, 'ibe230006'),
(7, 'ibe230007'),
(8, 'ibe230008'),
(9, 'ibe230009'),
(10, 'ibe230010'),
(11, 'ibe230011'),
(12, 'ibe230012'),
(13, 'ibe230013'),
(14, 'ibe230014'),
(15, 'ibe230015'),
(16, 'ibe230016'),
(17, 'ibe230017'),
(18, 'ibe230018'),
(19, 'ibe230019'),
(20, 'ibe230020'),
(21, 'ibe230021'),
(22, 'ibe230022'),
(23, 'ibe230023'),
(24, 'ibe230024'),
(25, 'ibe230025'),
(26, 'ibe230026'),
(27, 'ibe230027'),
(28, 'ibe230028'),
(29, 'ibe230029'),
(30, 'ibe230030'),
(31, 'ibe230031'),
(32, 'ibe230032'),
(33, 'ibe230033'),
(34, 'ibe230034'),
(35, 'ibe230035'),
(36, 'ibe230036'),
(37, 'ibe230037'),
(38, 'ibe230038'),
(39, 'ibe230039'),
(40, 'ibe230040'),
(41, 'ibe230041'),
(42, 'ibe230042'),
(43, 'ibe230043'),
(44, 'ibe230044'),
(45, 'ibe230045'),
(46, 'ibe230046'),
(47, 'ibe230047'),
(48, 'ibe230048'),
(49, 'ibe230049'),
(50, 'ibe230050'),
(51, 'ibe230051'),
(52, 'ibe230052'),
(53, 'ibe230053'),
(54, 'ibe230054'),
(55, 'ibe230055'),
(56, 'ibe230056'),
(57, 'ibe230057'),
(58, 'ibe230058'),
(59, 'ibe230059'),
(60, 'ibe230060'),
(61, 'ibe230061'),
(62, 'ibe230062'),
(63, 'ibe230063'),
(64, 'ibe230064'),
(65, 'ibe230065'),
(66, 'ibe230066'),
(67, 'ibe230067'),
(68, 'ibe230068'),
(69, 'ibe230069'),
(70, 'ibe230070'),
(71, 'ibe230071'),
(72, 'ibe230072'),
(73, 'ibe230073'),
(74, 'ibe230074'),
(75, 'ibe230075'),
(76, 'ibe230076'),
(77, 'ibe230077'),
(78, 'ibe230078'),
(79, 'ibe230079'),
(80, 'ibe230080'),
(81, 'ibe230081'),
(82, 'ibe230082'),
(83, 'ibe230083'),
(84, 'ibe230084'),
(85, 'ibe230085'),
(86, 'ibe230086'),
(87, 'ibe230087'),
(88, 'ibe230088'),
(89, 'ibe230089'),
(90, 'ibe230090'),
(91, 'ibe230091'),
(92, 'ibe230092'),
(93, 'ibe230093'),
(94, 'ibe230094'),
(95, 'ibe230095'),
(96, 'ibe230096'),
(97, 'ibe230097'),
(98, 'ibe230098'),
(99, 'ibe230099'),
(100, 'ibe230100'),
(101, 'ibe230101'),
(102, 'ibe230102'),
(103, 'ibe230103'),
(104, 'ibe230104'),
(105, 'ibe230105'),
(106, 'ibe230106'),
(107, 'ibe230107'),
(108, 'ibe230108'),
(109, 'ibe230109'),
(110, 'ibe230110'),
(111, 'ibe230111'),
(112, 'ibe230112');

-- --------------------------------------------------------

--
-- Structure de la table `paiecred`
--

DROP TABLE IF EXISTS `paiecred`;
CREATE TABLE IF NOT EXISTS `paiecred` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `numero` varchar(50) NOT NULL,
  `montant` double NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `paiecredcmd`
--

DROP TABLE IF EXISTS `paiecredcmd`;
CREATE TABLE IF NOT EXISTS `paiecredcmd` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `numero` varchar(50) NOT NULL,
  `montant` double NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `paiemode`
--

DROP TABLE IF EXISTS `paiemode`;
CREATE TABLE IF NOT EXISTS `paiemode` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `money` varchar(50) DEFAULT 'guinee',
  `code` varchar(50) DEFAULT 'gnf',
  `etat` varchar(50) DEFAULT 'ok',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `paiemode`
--

INSERT INTO `paiemode` (`id`, `money`, `code`, `etat`) VALUES
(1, 'guinee', 'gnf', 'ok'),
(2, 'dollar', 'us', 'ok'),
(3, 'dirham', 'aed', 'nok'),
(4, 'euro', 'eu', 'ok');

-- --------------------------------------------------------

--
-- Structure de la table `payement`
--

DROP TABLE IF EXISTS `payement`;
CREATE TABLE IF NOT EXISTS `payement` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type_vente` varchar(50) NOT NULL DEFAULT 'vente credit',
  `num_cmd` varchar(50) NOT NULL,
  `Total` double NOT NULL,
  `fraisup` double DEFAULT '0',
  `montantpaye` double DEFAULT '0',
  `remise` double DEFAULT '0',
  `reste` double NOT NULL,
  `etat` varchar(155) NOT NULL,
  `etatliv` varchar(20) NOT NULL DEFAULT 'nonlivre',
  `vendeur` varchar(155) DEFAULT NULL,
  `num_client` int(10) DEFAULT NULL,
  `nomclient` varchar(150) DEFAULT NULL,
  `caisse` int(11) NOT NULL,
  `lieuvente` varchar(10) DEFAULT NULL,
  `date_cmd` datetime NOT NULL,
  `date_regul` datetime DEFAULT NULL,
  `datealerte` date DEFAULT NULL,
  `datesaisie` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `signe` date DEFAULT NULL,
  `solde_facture` float NOT NULL DEFAULT '0',
  `date_solde` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=33 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `payement`
--

INSERT INTO `payement` (`id`, `type_vente`, `num_cmd`, `Total`, `fraisup`, `montantpaye`, `remise`, `reste`, `etat`, `etatliv`, `vendeur`, `num_client`, `nomclient`, `caisse`, `lieuvente`, `date_cmd`, `date_regul`, `datealerte`, `datesaisie`, `signe`, `solde_facture`, `date_solde`) VALUES
(1, 'vente credit', 'ibe230080', 200000, 0, 0, 0, 200000, 'credit', 'nonlivre', '1', 26, '', 1, '1', '2023-07-27 10:11:00', NULL, NULL, '2023-07-27 12:11:04', NULL, 0, NULL),
(2, 'vente credit', 'ibe230081', 200000, 0, 100000, 0, 100000, 'credit', 'nonlivre', '1', 102, '', 1, '1', '2023-07-27 10:11:00', NULL, NULL, '2023-07-27 12:11:42', NULL, 0, NULL),
(3, 'vente cash', 'ibe230082', 200000, 0, 200000, 0, 0, 'totalite', 'livre', '1', 26, '', 1, '1', '2023-07-27 10:12:00', NULL, NULL, '2023-07-27 12:12:26', NULL, 0, NULL),
(4, 'vente cash', 'ibe230083', 200000, 0, 200000, 0, 0, 'totalite', 'livre', '1', 26, '', 1, '1', '2023-07-27 10:48:00', NULL, NULL, '2023-07-27 12:48:53', NULL, 0, NULL),
(5, 'vente credit', 'ibe230084', 200000, 0, 0, 0, 200000, 'credit', 'nonlivre', '1', 102, '', 1, '1', '2023-07-27 10:49:00', NULL, NULL, '2023-07-27 12:49:14', NULL, 0, NULL),
(6, 'vente cash', 'ibe230085', 200000, 0, 200000, 0, 0, 'totalite', 'livre', '1', NULL, 'MOUCTAR', 1, '1', '2023-07-27 11:08:00', NULL, NULL, '2023-07-27 13:08:50', NULL, 0, NULL),
(7, 'vente cash', 'ibe230086', 4300000, 0, 4300000, 0, 0, 'totalite', 'livre', '1', 1, '', 1, '1', '2023-08-20 08:19:00', NULL, NULL, '2023-08-20 10:19:41', NULL, 0, NULL),
(8, 'vente cash', 'ibe230088', 200000, 0, 200000, 0, 0, 'totalite', 'livre', '1', 1, '', 1, '1', '2023-08-27 04:03:00', NULL, NULL, '2023-08-27 18:03:56', NULL, 0, NULL),
(9, 'vente cash', 'ibe230089', 600000, 0, 600000, 0, 0, 'totalite', 'livre', '1', 1, '', 1, '1', '2023-09-02 09:11:00', NULL, NULL, '2023-09-02 11:11:36', NULL, 0, NULL),
(11, 'vente cash', 'ibe230091', 5200000, 0, 5200000, 0, 0, 'totalite', 'livre', '1', 1, '', 1, '1', '2023-09-02 11:12:00', NULL, NULL, '2023-09-02 13:12:12', NULL, 0, NULL),
(13, 'vente cash', 'ibe230093', 5690000, 0, 5690000, 0, 0, 'totalite', 'livre', '1', 1, '', 1, '1', '2023-09-02 11:42:00', NULL, NULL, '2023-09-02 13:42:35', NULL, 0, NULL),
(14, 'vente cash', 'ibe230094', -400000, 0, -400000, 0, 0, 'totalite', 'livre', '1', 1, '', 1, '1', '2023-09-02 11:48:00', NULL, NULL, '2023-09-02 13:48:33', NULL, 0, NULL),
(15, 'vente cash', 'ibe230095', 200000, 0, 200000, 0, 0, 'totalite', 'livre', '1', 1, '', 1, '1', '2023-09-02 11:52:00', NULL, NULL, '2023-09-02 13:52:14', NULL, 0, NULL),
(16, 'vente cash', 'ibe230096', 200000, 0, 200000, 0, 0, 'totalite', 'livre', '1', 1, '', 1, '1', '2023-09-02 11:55:00', NULL, NULL, '2023-09-02 13:55:09', NULL, 0, NULL),
(17, 'vente cash', 'ibe230097', 200000, 0, 200000, 0, 0, 'totalite', 'livre', '1', 1, '', 1, '1', '2023-09-02 11:57:00', NULL, NULL, '2023-09-02 13:57:20', NULL, 0, NULL),
(18, 'vente cash', 'ibe230098', 400000, 0, 400000, 0, 0, 'totalite', 'livre', '1', 1, '', 1, '1', '2023-09-02 12:03:00', NULL, NULL, '2023-09-02 14:03:28', NULL, 0, NULL),
(19, 'vente cash', 'ibe230099', 150000, 0, 150000, 0, 0, 'totalite', 'livre', '1', 1, '', 1, '1', '2023-09-02 12:06:00', NULL, NULL, '2023-09-02 14:06:26', NULL, 0, NULL),
(20, 'vente credit', 'ibe230100', 1200000, 0, 0, 0, 1600000, 'retour fact', 'nonlivre', '1', 93, '', 1, '1', '2023-09-04 09:07:00', NULL, NULL, '2023-09-04 11:07:54', NULL, 0, NULL),
(21, 'vente credit', 'ibe230101', 180000, 0, 80000, 0, 100000, 'credit', 'nonlivre', '1', 93, '', 1, '1', '2023-09-04 10:26:00', NULL, NULL, '2023-09-04 12:26:43', NULL, 0, NULL),
(22, 'vente credit', 'ibe230102', 2600000, 0, 0, 0, 3800000, 'credit', 'encoursliv', '1', 93, '', 1, '1', '2023-09-11 10:31:00', NULL, NULL, '2023-09-11 12:31:22', NULL, 0, NULL),
(23, 'vente credit', 'ibe230103', 190000, 0, 0, 0, 190000, 'credit', 'nonlivre', '1', 6, '', 1, '1', '2023-09-11 11:21:00', NULL, NULL, '2023-09-11 13:21:17', NULL, 0, NULL),
(24, 'vente credit', 'ibe230104', 400000, 0, 0, 0, 400000, 'credit', 'nonlivre', '1', 6, '', 1, '1', '2023-09-11 11:22:00', NULL, NULL, '2023-09-11 13:22:17', '2023-09-22', 400000, '2023-09-22'),
(25, 'vente credit', 'ibe230105', 600000, 0, 0, 0, 600000, 'credit', 'nonlivre', '1', 183, '', 1, '1', '2023-09-11 11:25:00', NULL, NULL, '2023-09-11 13:25:05', NULL, 0, NULL),
(26, 'vente cash', 'ibe230106', 2000000, 0, 2000000, 0, 0, 'totalite', 'livre', '1', 1, '', 1, '1', '2023-09-12 06:43:00', NULL, NULL, '2023-09-12 20:43:35', NULL, 0, NULL),
(27, 'vente cash', 'ibe230107', 200000, 0, 200000, 0, 0, 'totalite', 'livre', '1', 1, '', 1, '1', '2023-09-12 06:45:00', NULL, NULL, '2023-09-12 20:45:17', NULL, 0, NULL),
(28, 'vente credit', 'ibe230108', 200000, 0, 0, 0, 200000, 'credit', 'nonlivre', '1', 93, '', 1, '1', '2023-09-12 07:11:00', NULL, NULL, '2023-09-12 21:11:26', NULL, 0, NULL),
(29, 'vente credit', 'ibe230109', 200000, 0, 0, 0, 200000, 'credit', 'nonlivre', '1', 6, '', 1, '1', '2023-09-21 09:46:00', NULL, NULL, '2023-09-21 11:46:07', '2023-09-22', 200000, '2023-09-22'),
(30, 'vente credit', 'ibe230110', 35200000, 0, 0, 0, 35200000, 'credit', 'nonlivre', '1', 6, '', 1, '1', '2023-09-21 10:19:00', NULL, NULL, '2023-09-21 12:19:07', '2023-09-22', 0, NULL),
(31, 'vente credit', 'ibe230111', 5600000, 0, 0, 0, 11100000, 'credit', 'nonlivre', '1', 6, '', 1, '1', '2023-09-21 11:10:00', NULL, NULL, '2023-09-21 13:10:50', '2023-09-22', 5600000, '2023-09-22'),
(32, 'vente credit', 'ibe230112', 1480000, 0, 0, 0, 1630000, 'credit', 'nonlivre', '1', 6, '', 1, '1', '2023-09-21 02:18:00', NULL, NULL, '2023-09-21 16:18:56', '2023-09-22', 1480000, '2023-09-22');

-- --------------------------------------------------------

--
-- Structure de la table `personnel`
--

DROP TABLE IF EXISTS `personnel`;
CREATE TABLE IF NOT EXISTS `personnel` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `identifiant` varchar(50) DEFAULT NULL,
  `nom` varchar(100) NOT NULL,
  `salaires` float DEFAULT NULL,
  `telephone` varchar(15) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `lieuvente` int(11) NOT NULL,
  `dateenreg` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `personnel`
--

INSERT INTO `personnel` (`id`, `identifiant`, `nom`, `salaires`, `telephone`, `email`, `lieuvente`, `dateenreg`) VALUES
(2, 'pers2', 'Ismael Barry', 5000000, '620000000', '', 1, '2022-03-25 13:57:28'),
(21, 'pers3', 'Hawa Kone', 1000000, '62822222', '', 1, '2022-03-25 13:57:28'),
(20, 'pers55', 'Mouctar', 1000000, '628196628', '', 1, '2023-08-19 17:21:01');

-- --------------------------------------------------------

--
-- Structure de la table `persremboursement`
--

DROP TABLE IF EXISTS `persremboursement`;
CREATE TABLE IF NOT EXISTS `persremboursement` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `numdep` varchar(50) DEFAULT NULL,
  `montant` double NOT NULL,
  `devise` varchar(50) NOT NULL DEFAULT 'gnf',
  `payement` varchar(30) NOT NULL,
  `cdepot` varchar(50) NOT NULL,
  `coment` varchar(150) DEFAULT NULL,
  `client` varchar(155) DEFAULT NULL,
  `date_payement` datetime NOT NULL,
  `lieuvente` int(11) DEFAULT NULL,
  `exect` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `persremboursement`
--

INSERT INTO `persremboursement` (`id`, `numdep`, `montant`, `devise`, `payement`, `cdepot`, `coment`, `client`, `date_payement`, `lieuvente`, `exect`) VALUES
(1, 'rembp1', 100000, 'gnf', 'espèces', '1', 'remboursement', 'pers55', '2023-08-20 07:42:00', 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `pertes`
--

DROP TABLE IF EXISTS `pertes`;
CREATE TABLE IF NOT EXISTS `pertes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idpertes` int(11) NOT NULL,
  `idnomstockp` int(11) NOT NULL,
  `prix_achat` double DEFAULT NULL,
  `prix_revient` double DEFAULT NULL,
  `prix_vente` double DEFAULT NULL,
  `quantite` float DEFAULT NULL,
  `motifperte` varchar(150) DEFAULT NULL,
  `datepertes` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `productslist`
--

DROP TABLE IF EXISTS `productslist`;
CREATE TABLE IF NOT EXISTS `productslist` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `codeb` varchar(100) DEFAULT NULL,
  `Marque` varchar(155) NOT NULL,
  `designation` varchar(155) NOT NULL,
  `pventel` double DEFAULT '0',
  `qtiteintp` float DEFAULT '0',
  `qtiteint` float DEFAULT '0',
  `codecat` int(11) DEFAULT NULL,
  `type` varchar(15) DEFAULT NULL,
  `nbrevente` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1410 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `productslist`
--

INSERT INTO `productslist` (`id`, `codeb`, `Marque`, `designation`, `pventel`, `qtiteintp`, `qtiteint`, `codecat`, `type`, `nbrevente`) VALUES
(1, '', 'USB 4GO', 'USB 4GO', 0, 1, 1, 1, 'en_gros', 0),
(4, '', 'USB 8GO', 'USB 8GO', 0, 1, 1, 1, 'en_gros', 0),
(7, '', 'USB 16GO', 'Canon 2206', 0, 1, 1, 1, 'en_gros', 0),
(10, '', 'USB 32GO', 'USB 32 GO', 0, 1, 1, 1, 'en_gros', 0),
(13, '', 'hp usb 32go', 'Hp usb 32go', 0, 1, 1, 1, 'en_gros', 0),
(16, '', 'hp usb 64go', 'hp usb 64go', 0, 1, 1, 1, 'en_gros', 0),
(19, '', 'usb 128 3,0', 'usb 128 3,0', 0, 1, 1, 1, 'en_gros', 0),
(22, '', 'usb 32 3,0', 'usb 32 3,0', 0, 1, 1, 1, 'en_gros', 0),
(25, '', 'usb 64 3,0', 'usb 64 3,0', 0, 1, 1, 1, 'en_gros', 0),
(28, '', 'usb 64go', 'usb 64go', 0, 1, 1, 1, 'en_gros', 0),
(31, '', 'Usb Type C 128go', 'Usb Type C 128go', 0, 1, 1, 1, 'en_gros', 0),
(34, '', 'usb type c 32go', 'usb type c 32go', 0, 1, 1, 1, 'en_gros', 0),
(37, '', 'usb type c 64go', 'usb type c 64go', 0, 1, 1, 1, 'en_gros', 0),
(40, '', 'Bafle', 'Bafle', 0, 1, 1, 2, 'en_gros', 0),
(43, '', 'Armoir', 'Armoir', 0, 1, 1, 2, 'en_gros', 0),
(46, '', 'Bureau conference', 'Bureau conference', 0, 1, 1, 2, 'en_gros', 0),
(49, '', 'Cable RJ 45', 'Cable RJ 45', 0, 1, 1, 2, 'en_gros', 0),
(52, '', 'Cable', 'Cable', 0, 1, 1, 2, 'en_gros', 0),
(55, '', 'Cleu Wifi', 'Cleu Wifi', 0, 1, 1, 2, 'en_gros', 0),
(58, '', 'Casque BLT', 'Casque BLT', 0, 1, 1, 2, 'en_gros', 0),
(61, '', 'Caisse A Outil', 'Caisse A Outil', 0, 1, 1, 2, 'en_gros', 0),
(64, '', 'Lecteur Ex', 'Lecteur Ex', 0, 1, 1, 2, 'en_gros', 0),
(67, '', 'Chaise Bureau', 'Chaise Bureau', 0, 1, 1, 2, 'en_gros', 0),
(70, '', 'Chaise Visiteur', 'Chaise Visiteur', 0, 1, 1, 2, 'en_gros', 0),
(73, '', 'Connecteur rj 45', 'Connecteur rj 45', 0, 1, 1, 2, 'en_gros', 0),
(76, '', 'Lecteur RJ 45', 'Lecteur RJ 45', 0, 1, 1, 2, 'en_gros', 0),
(79, '', 'Pince', 'Pince', 0, 1, 1, 2, 'en_gros', 0),
(82, '', 'CLEU INT', 'CLEU INT', 0, 1, 1, 2, 'en_gros', 0),
(85, '', 'Racle', 'Racle', 0, 1, 1, 2, 'en_gros', 0),
(88, '', 'Roulau rj 45', 'Roulau rj 45', 0, 1, 1, 2, 'en_gros', 0),
(91, '', 'Office', 'Office', 0, 1, 1, 2, 'en_gros', 0),
(94, '', 'HDMI', 'HDMI', 0, 1, 1, 2, 'en_gros', 0),
(97, '', 'Port usb', 'Port usb', 0, 1, 1, 2, 'en_gros', 0),
(100, '', 'Sac Hp', 'Sac Hp', 0, 1, 1, 2, 'en_gros', 0),
(103, '', 'CCTV 4C 5MP', 'CCTV 4C 5MP', 0, 1, 1, 2, 'en_gros', 0),
(106, '', 'CCTV 8C 1,3MP', 'CCTV 8C 1,3MP', 0, 1, 1, 2, 'en_gros', 0),
(109, '', 'CCTV 8C 2MP', 'CCTV 8C 2MP', 0, 1, 1, 2, 'en_gros', 0),
(112, '', 'CCTV 8C 5MP', 'CCTV 8C 5MP', 0, 1, 1, 2, 'en_gros', 0),
(115, '', 'Switch 24P', 'Switch 24P', 0, 1, 1, 2, 'en_gros', 0),
(118, '', 'Switch 5P', 'Switch 5P', 0, 1, 1, 2, 'en_gros', 0),
(121, '', 'Switch 8P', 'Switch 8P', 0, 1, 1, 2, 'en_gros', 0),
(124, '', 'Tablet bebe', 'Tablet bebe', 0, 1, 1, 2, 'en_gros', 0),
(127, '', 'Clavier Laptop', 'Clavier Laptop', 0, 1, 1, 2, 'en_gros', 0),
(130, '', 'DP HDMI', 'DP HDMI', 0, 1, 1, 2, 'en_gros', 0),
(133, '', 'Papier Ram', 'Papier Ram', 0, 1, 1, 2, 'en_gros', 0),
(136, '', 'Pointer', 'Pointer', 0, 1, 1, 2, 'en_gros', 0),
(139, '', 'PR BLT', 'PR BLT', 0, 1, 1, 2, 'en_gros', 0),
(142, '', 'Port rj45', 'Port rj45', 0, 1, 1, 2, 'en_gros', 0),
(145, '', 'Sac', 'Sac', 0, 1, 1, 2, 'en_gros', 0),
(148, '', 'Port usb 3.0', 'Port usb 3.0', 0, 1, 1, 2, 'en_gros', 0),
(151, '', 'Sac 14', 'Sac 14', 0, 1, 1, 2, 'en_gros', 0),
(154, '', 'Casque', 'Casque', 0, 1, 1, 2, 'en_gros', 0),
(157, '', 'Casque Usb', 'Casque Usb', 0, 1, 1, 2, 'en_gros', 0),
(160, '', 'Casque WR', 'Casque WR', 0, 1, 1, 2, 'en_gros', 0),
(163, '', 'WIN-10', 'WIN-10', 0, 1, 1, 2, 'en_gros', 0),
(166, '', 'Tapi Souri', 'Tapi Souri', 0, 1, 1, 2, 'en_gros', 0),
(169, '', 'VGA HDMI', 'VGA HDMI', 0, 1, 1, 2, 'en_gros', 0),
(172, '', 'W 10', 'W 10', 0, 1, 1, 2, 'en_gros', 0),
(175, '', 'A-11', 'A-11', 0, 1, 1, 2, 'en_gros', 0),
(178, '', 'TAB-A', 'TAB-A', 0, 1, 1, 2, 'en_gros', 0),
(181, '', 'BAG HP', 'BAG HP', 0, 1, 1, 2, 'en_gros', 0),
(184, '', 'Norton', 'Norton', 0, 1, 1, 3, 'en_gros', 0),
(187, '', 'Mk 270', 'Logitec souri mk 270', 0, 1, 1, 4, 'en_gros', 0),
(190, '', 'HP AIO I5 22', 'HP AIO I5 22', 0, 1, 1, 5, 'en_gros', 0),
(193, '', 'DD SSD 500GO', 'DD SSD 500GO', 0, 1, 1, 6, 'en_gros', 0),
(196, '', 'Scaner 2600', 'Scaner 2600', 0, 1, 1, 7, 'en_gros', 0),
(199, '', 'KAV 1PTS', 'Kav 1pts', 0, 1, 1, 3, 'en_gros', 0),
(202, '', 'KAV 3PTS', 'Kav 3pts', 0, 1, 1, 3, 'en_gros', 0),
(205, '', 'KIS 1PTS', 'KIS 1PTS', 0, 1, 1, 3, 'en_gros', 0),
(208, '', 'KIS 3PTS', 'KIS 3PTS', 0, 1, 1, 3, 'en_gros', 0),
(211, '', 'Clavier', 'Clavier', 0, 1, 1, 4, 'en_gros', 0),
(214, '', 'clavier BLT', 'Clavier Blt', 0, 1, 1, 4, 'en_gros', 0),
(217, '', 'Clavier hp', 'Clavier hp', 0, 1, 1, 4, 'en_gros', 0),
(220, '', 'clavier hp blt', 'clavier  hp blt', 0, 1, 1, 4, 'en_gros', 0),
(223, '', 'Mk 220', 'Logitec mk 220', 0, 1, 1, 4, 'en_gros', 0),
(226, '', 'Dell 3080-I7', 'Dell 3080-I7', 0, 1, 1, 5, 'en_gros', 0),
(229, '', 'Dell 3080-I3', 'Dell 3080-I3', 0, 1, 1, 5, 'en_gros', 0),
(232, '', 'Dell 3470-i5', 'Dell 3470-i5', 0, 1, 1, 5, 'en_gros', 0),
(235, '', 'dell 9020-i5', 'dell 9020-i5', 0, 1, 1, 5, 'en_gros', 0),
(238, '', 'dell 9020-i7', 'dell 9020-i7', 0, 1, 1, 5, 'en_gros', 0),
(241, '', 'dell e24', 'dell Ecran 24', 0, 1, 1, 5, 'en_gros', 0),
(244, '', 'B lenovo i3', 'B lenovo i3', 0, 1, 1, 5, 'en_gros', 0),
(247, '', 'dell e19', 'Dell ecran 19', 0, 1, 1, 5, 'en_gros', 0),
(250, '', 'hp 290-i7', 'hp 290-i7', 0, 1, 1, 5, 'en_gros', 0),
(253, '', 'dell 3080-i5', 'dell 3080-i5', 0, 1, 1, 5, 'en_gros', 0),
(256, '', 'hp 400-i3', 'hp 400-i3', 0, 1, 1, 5, 'en_gros', 0),
(259, '', 'hp 400-i5', 'hp 400-i5', 0, 1, 1, 5, 'en_gros', 0),
(262, '', 'hp 400-i7', 'hp 400-i7', 0, 1, 1, 5, 'en_gros', 0),
(265, '', 'Dell Aio i5', 'Dell Aio i5', 0, 1, 1, 5, 'en_gros', 0),
(268, '', 'hp 600-i7', 'hp 600-i7', 0, 1, 1, 5, 'en_gros', 0),
(271, '', 'hp 290-i3', 'hp 290-i3', 0, 1, 1, 5, 'en_gros', 0),
(274, '', 'dell e27', 'dell ecran 27', 0, 1, 1, 5, 'en_gros', 0),
(277, '', 'hp aio i3 24', 'hp aio i3 24', 0, 1, 1, 5, 'en_gros', 0),
(280, '', 'hp aio i5', 'hp aio i5', 0, 1, 1, 5, 'en_gros', 0),
(283, '', 'hp 400-dc', 'hp 400-dc', 0, 1, 1, 5, 'en_gros', 0),
(286, '', 'hp e24', 'hp ecran 24', 0, 1, 1, 5, 'en_gros', 0),
(289, '', 'hp e19', 'hp ecran 19', 0, 1, 1, 5, 'en_gros', 0),
(292, '', 'hp e24f', 'hp e24f', 0, 1, 1, 5, 'en_gros', 0),
(295, '', 'hp 600-i5', 'hp 600-i5', 0, 1, 1, 5, 'en_gros', 0),
(298, '', 'hp aio i3', 'hp aio i3', 0, 1, 1, 5, 'en_gros', 0),
(301, '', 'hp aio dc', 'hp aio dc', 0, 1, 1, 5, 'en_gros', 0),
(304, '', 'hp e27f', 'hp e27f', 0, 1, 1, 5, 'en_gros', 0),
(307, '', 'hp aio i7', 'hp aio i7', 0, 1, 1, 5, 'en_gros', 0),
(310, '', 'HP AIO I7 27\"', 'hp aio i7 27\"', 0, 1, 1, 5, 'en_gros', 0),
(313, '', 'lenovo aio dc', 'lenovo aio dc', 0, 1, 1, 5, 'en_gros', 0),
(316, '', 'hp e21', 'hp ecran 21', 0, 1, 1, 5, 'en_gros', 0),
(319, '', 'hp e27', 'hp ecran 27', 0, 1, 1, 5, 'en_gros', 0),
(322, '', 'hp aio i7 24', 'hp aio i7 24', 0, 1, 1, 5, 'en_gros', 0),
(325, '', 'hp aio i5 23', 'hp aio i5 23', 0, 1, 1, 5, 'en_gros', 0),
(328, '', 'dell 9020-dc', 'dell 9020-dc', 0, 1, 1, 5, 'en_gros', 0),
(331, '', 'dell 9020-i3', 'dell 9020-i3', 0, 1, 1, 5, 'en_gros', 0),
(334, '', 'hp 290-i5', 'hp 290-i5', 0, 1, 1, 5, 'en_gros', 0),
(337, '', 'Case 2,5', 'Case 2,5', 0, 1, 1, 6, 'en_gros', 0),
(340, '', 'case 3,0', 'case 3,0', 0, 1, 1, 6, 'en_gros', 0),
(343, '', 'Case 3,5', 'Case 3,5', 0, 1, 1, 6, 'en_gros', 0),
(346, '', 'B HDD 1TR', 'B HDD 1TR', 0, 1, 1, 6, 'en_gros', 0),
(349, '', 'B HDD 2TR', 'B HDD 2TR', 0, 1, 1, 6, 'en_gros', 0),
(352, '', 'B HDD 500GO', 'B HDD 500GO', 0, 1, 1, 6, 'en_gros', 0),
(355, '', 'DD 500GO', 'DD 500GO', 0, 1, 1, 6, 'en_gros', 0),
(358, '', 'HDD 1TR', 'HDD 1TR', 0, 1, 1, 6, 'en_gros', 0),
(361, '', 'B HDD 3TR', 'B HDD 3TR', 0, 1, 1, 6, 'en_gros', 0),
(364, '', 'B HDD 4TR', 'B HDD 4TR', 0, 1, 1, 6, 'en_gros', 0),
(367, '', 'DD 4TR', 'DD 4TR', 0, 1, 1, 6, 'en_gros', 0),
(370, '', 'DD 1TR', 'DD 1TR', 0, 1, 1, 6, 'en_gros', 0),
(373, '', 'DD 2TR', 'DD 2TR', 0, 1, 1, 6, 'en_gros', 0),
(376, '', 'HDD 2TR', 'HDD 2TR', 0, 1, 1, 6, 'en_gros', 0),
(379, '', 'HDD 500GO', 'HDD 500GO', 0, 1, 1, 6, 'en_gros', 0),
(382, '', 'Sata ssd 1tb', 'Sata ssd 1tb', 0, 1, 1, 6, 'en_gros', 0),
(385, '', 'sata ssd 512', 'sata ssd 512', 0, 1, 1, 6, 'en_gros', 0),
(388, '', 'SSD 1TB', 'SSD 1TB', 0, 1, 1, 6, 'en_gros', 0),
(391, '', 'Sata ssd 256', 'Sata ssd 256', 0, 1, 1, 6, 'en_gros', 0),
(394, '', 'SSD 500GO', 'SSD 500GO', 0, 1, 1, 6, 'en_gros', 0),
(397, '', 'b hdd 8tr', 'b hdd 8tr', 0, 1, 1, 6, 'en_gros', 0),
(400, '', 'Case ssd', 'Case ssd', 0, 1, 1, 6, 'en_gros', 0),
(403, '', 'ssd 256go', 'ssd 256go', 0, 1, 1, 6, 'en_gros', 0),
(406, '', 'DD SSD 1TB', 'DD SSD 1TB', 0, 1, 1, 6, 'en_gros', 0),
(409, '', 'Canon 443', 'Canon 443', 0, 1, 1, 7, 'en_gros', 0),
(412, '', 'Canon 223', 'Canon 223', 0, 1, 1, 7, 'en_gros', 0),
(415, '', 'Canon 2425', 'Canon 2425', 0, 1, 1, 7, 'en_gros', 0),
(418, '', 'Canon 2206', 'Canon 2206', 0, 1, 1, 7, 'en_gros', 0),
(421, '', 'Canon 2206N', 'Canon 2206N', 0, 1, 1, 7, 'en_gros', 0),
(424, '', 'Canon 623', 'Canon 623', 0, 1, 1, 7, 'en_gros', 0),
(427, '', 'E L3110', 'E L3110', 0, 1, 1, 7, 'en_gros', 0),
(430, '', 'Canon 237W', 'Canon 237W', 0, 1, 1, 7, 'en_gros', 0),
(433, '', 'E L3150', 'E L3150', 0, 1, 1, 7, 'en_gros', 0),
(436, '', 'E M2170', 'E M2170', 0, 1, 1, 7, 'en_gros', 0),
(439, '', 'Ch 2206N', 'Ch 2206N', 0, 1, 1, 7, 'en_gros', 0),
(442, '', 'E printer', 'E printer', 0, 1, 1, 7, 'en_gros', 0),
(445, '', 'E L6170', 'E L6170', 0, 1, 1, 7, 'en_gros', 0),
(448, '', 'E L5190', 'E L5190', 0, 1, 1, 7, 'en_gros', 0),
(451, '', 'Hp 1200w', 'Hp 1200w', 0, 1, 1, 7, 'en_gros', 0),
(454, '', 'Hp 2320', 'Hp 2320', 0, 1, 1, 7, 'en_gros', 0),
(457, '', 'Hp 2710', 'Hp 2710', 0, 1, 1, 7, 'en_gros', 0),
(460, '', 'Hp 7720', 'Hp 7720', 0, 1, 1, 7, 'en_gros', 0),
(463, '', 'Hp 2130', 'Hp 2130', 0, 1, 1, 7, 'en_gros', 0),
(466, '', 'Hp 7740', 'Hp 7740', 0, 1, 1, 7, 'en_gros', 0),
(469, '', 'Hp 9013', 'Hp 9013', 0, 1, 1, 7, 'en_gros', 0),
(472, '', 'Hp 135A', 'Hp 135A', 0, 1, 1, 7, 'en_gros', 0),
(475, '', 'M 135W', 'M 135W', 0, 1, 1, 7, 'en_gros', 0),
(478, '', 'Hp 8720', 'Hp 8720', 0, 1, 1, 7, 'en_gros', 0),
(481, '', 'Lide 300', 'Lide 300', 0, 1, 1, 7, 'en_gros', 0),
(484, '', 'Lide 220', 'Lide 220', 0, 1, 1, 7, 'en_gros', 0),
(487, '', 'M 179FNW', 'M 179FNW', 0, 1, 1, 7, 'en_gros', 0),
(490, '', 'M 102A', 'M 102A', 0, 1, 1, 7, 'en_gros', 0),
(493, '', 'M 102W', 'M 102W', 0, 1, 1, 7, 'en_gros', 0),
(496, '', 'M 125A', 'M 125A', 0, 1, 1, 7, 'en_gros', 0),
(499, '', 'M 130A', 'M 130A', 0, 1, 1, 7, 'en_gros', 0),
(502, '', 'M 130FW', 'M 130FW', 0, 1, 1, 7, 'en_gros', 0),
(505, '', 'm 182n', 'm 182n', 0, 1, 1, 7, 'en_gros', 0),
(508, '', 'M 479fDN', 'M 479fDN', 0, 1, 1, 7, 'en_gros', 0),
(511, '', 'M 479FNW', 'M 479FNW', 0, 1, 1, 7, 'en_gros', 0),
(514, '', 'M 179nw', 'M 179nw', 0, 1, 1, 7, 'en_gros', 0),
(517, '', 'm 181fdw', 'm 181fdw', 0, 1, 1, 7, 'en_gros', 0),
(520, '', 'M 283FDN', 'M 283FDN', 0, 1, 1, 7, 'en_gros', 0),
(523, '', 'M 183FW', 'M 183FW', 0, 1, 1, 7, 'en_gros', 0),
(526, '', 'M 283FDW', 'M 283FDW', 0, 1, 1, 7, 'en_gros', 0),
(529, '', 'PR PRINTER', 'PR PRINTER', 0, 1, 1, 7, 'en_gros', 0),
(532, '', 'M 177FW', 'M 177FW', 0, 1, 1, 7, 'en_gros', 0),
(535, '', 'M 281FDN', 'M 281FDN', 0, 1, 1, 7, 'en_gros', 0),
(538, '', 'M 281FDW', 'M 281FDW', 0, 1, 1, 7, 'en_gros', 0),
(541, '', 'Canon 2425i', 'Canon 2425i', 0, 1, 1, 7, 'en_gros', 0),
(544, '', 'E L1300', 'E L1300', 0, 1, 1, 7, 'en_gros', 0),
(547, '', 'M 426FDW', 'M 426FDW', 0, 1, 1, 7, 'en_gros', 0),
(550, '', 'M 477FDW', 'M 477FDW', 0, 1, 1, 7, 'en_gros', 0),
(553, '', 'E L805', 'E L805', 0, 1, 1, 7, 'en_gros', 0),
(556, '', 'Scaner 2500', 'Scaner 2500', 0, 1, 1, 7, 'en_gros', 0),
(559, '', 'M428FDN', 'hp M428FDN', 0, 1, 1, 7, 'en_gros', 0),
(562, '', 'M428FDW', 'hp M428FDW', 0, 1, 1, 7, 'en_gros', 0),
(565, '', 'Canon 453', 'Canon 453', 0, 1, 1, 7, 'en_gros', 0),
(568, '', 'Canon 752', 'Canon 752', 0, 1, 1, 7, 'en_gros', 0),
(571, '', 'M 107A', 'M 107A', 0, 1, 1, 7, 'en_gros', 0),
(574, '', 'M 107W', 'M 107W', 0, 1, 1, 7, 'en_gros', 0),
(577, '', '122C', '122C', 0, 1, 1, 8, 'en_gros', 0),
(580, '', '122N', '122N', 0, 1, 1, 8, 'en_gros', 0),
(583, '', '123N', '123N', 0, 1, 1, 8, 'en_gros', 0),
(586, '', '121C', '121C', 0, 1, 1, 8, 'en_gros', 0),
(589, '', '121N', '121N', 0, 1, 1, 8, 'en_gros', 0),
(592, '', '123C', '123C', 0, 1, 1, 8, 'en_gros', 0),
(595, '', '61C', '61C', 0, 1, 1, 8, 'en_gros', 0),
(598, '', '61N', '61N', 0, 1, 1, 8, 'en_gros', 0),
(601, '', '63C', '63C', 0, 1, 1, 8, 'en_gros', 0),
(604, '', '304C', '304C', 0, 1, 1, 8, 'en_gros', 0),
(607, '', '304N', '304N', 0, 1, 1, 8, 'en_gros', 0),
(610, '', '305C', '305C', 0, 1, 1, 8, 'en_gros', 0),
(613, '', '305N', '305N', 0, 1, 1, 8, 'en_gros', 0),
(616, '', '63N', '63N', 0, 1, 1, 8, 'en_gros', 0),
(619, '', '61COMBO', '61COMBO', 0, 1, 1, 8, 'en_gros', 0),
(622, '', '650C', '650C', 0, 1, 1, 8, 'en_gros', 0),
(625, '', '650N', '650N', 0, 1, 1, 8, 'en_gros', 0),
(628, '', '652C', '652C', 0, 1, 1, 8, 'en_gros', 0),
(631, '', '652N', '652N', 0, 1, 1, 8, 'en_gros', 0),
(634, '', '935C', '935C', 0, 1, 1, 8, 'en_gros', 0),
(637, '', '953C', '953C', 0, 1, 1, 8, 'en_gros', 0),
(640, '', '953C XL', '953C XL', 0, 1, 1, 8, 'en_gros', 0),
(643, '', '901C', '901C', 0, 1, 1, 8, 'en_gros', 0),
(646, '', '901N', '901N', 0, 1, 1, 8, 'en_gros', 0),
(649, '', '920C', '920C', 0, 1, 1, 8, 'en_gros', 0),
(652, '', '920N', '920N', 0, 1, 1, 8, 'en_gros', 0),
(655, '', '932N', '932N', 0, 1, 1, 8, 'en_gros', 0),
(658, '', '932N XL', '932N XL', 0, 1, 1, 8, 'en_gros', 0),
(661, '', '933C', '933C', 0, 1, 1, 8, 'en_gros', 0),
(664, '', '934N', '934N', 0, 1, 1, 8, 'en_gros', 0),
(667, '', '953N XL', '953N XL', 0, 1, 1, 8, 'en_gros', 0),
(670, '', '950N', '950N', 0, 1, 1, 8, 'en_gros', 0),
(673, '', '951C', '951C', 0, 1, 1, 8, 'en_gros', 0),
(676, '', '952C', '952C', 0, 1, 1, 8, 'en_gros', 0),
(679, '', '952N', '952N', 0, 1, 1, 8, 'en_gros', 0),
(682, '', '963C', '963C', 0, 1, 1, 8, 'en_gros', 0),
(685, '', '963N', '963N', 0, 1, 1, 8, 'en_gros', 0),
(688, '', '953N', '953N', 0, 1, 1, 8, 'en_gros', 0),
(691, '', 'E 101N', 'E 101N', 0, 1, 1, 8, 'en_gros', 0),
(694, '', 'E 664', 'E 664', 0, 1, 1, 8, 'en_gros', 0),
(697, '', 'Hp 21', 'Hp 21', 0, 1, 1, 8, 'en_gros', 0),
(700, '', 'Hp 22', 'Hp 22', 0, 1, 1, 8, 'en_gros', 0),
(703, '', 'L 103N', 'L 103N', 0, 1, 1, 8, 'en_gros', 0),
(706, '', 'L 103C', 'L 103C', 0, 1, 1, 8, 'en_gros', 0),
(709, '', 'Canon  490', 'Canon  490', 0, 1, 1, 8, 'en_gros', 0),
(712, '', 'E 103N', 'E 103N', 0, 1, 1, 8, 'en_gros', 0),
(715, '', 'Dell i7', 'Dell i7', 0, 1, 1, 9, 'en_gros', 0),
(718, '', 'E14 i7', 'Lenovo think PAD E14 i7', 0, 1, 1, 9, 'en_gros', 0),
(721, '', 'Hp 0033-i7', 'Hp 0033-i7', 0, 1, 1, 9, 'en_gros', 0),
(724, '', 'Cs3055-i5', 'Cs3055-i5', 0, 1, 1, 9, 'en_gros', 0),
(727, '', 'Hp i5 14&quot; PRO', 'Hp i5 14&quot; PRO', 0, 1, 1, 9, 'en_gros', 0),
(730, '', 'Hp i5 PRO', 'Hp i5 PRO', 0, 1, 1, 9, 'en_gros', 0),
(733, '', 'Dell Dc', 'Dell Dc', 0, 1, 1, 9, 'en_gros', 0),
(736, '', 'Dell i3', 'Dell i3', 0, 1, 1, 9, 'en_gros', 0),
(739, '', 'Dell i3 14&quot;', 'Dell i3 14&quot;', 0, 1, 1, 9, 'en_gros', 0),
(742, '', 'Dell i5', 'Dell i5', 0, 1, 1, 9, 'en_gros', 0),
(745, '', 'Dell i5 14&quot;', 'Dell i5 14&quot;', 0, 1, 1, 9, 'en_gros', 0),
(748, '', 'E14 I5', 'E14 I5', 0, 1, 1, 9, 'en_gros', 0),
(751, '', 'Dell i7 14&quot;', 'Dell i7 14&quot;', 0, 1, 1, 9, 'en_gros', 0),
(754, '', 'Dell i7 NVIDIA', 'Dell i7 NVIDIA', 0, 1, 1, 9, 'en_gros', 0),
(757, '', 'DH2051-I5', 'DH2051-I5', 0, 1, 1, 9, 'en_gros', 0),
(760, '', 'Dq 1088-i5', 'Dq 1088-i5', 0, 1, 1, 9, 'en_gros', 0),
(763, '', 'Mini', 'Mini', 0, 1, 1, 9, 'en_gros', 0),
(766, '', 'Dq2089-i3', 'Dq2089-i3', 0, 1, 1, 9, 'en_gros', 0),
(769, '', 'Dw2057-i5', 'Hp Dw2057-i5', 0, 1, 1, 9, 'en_gros', 0),
(772, '', 'dy1013-i7', 'Hp dy1013-i7', 0, 1, 1, 9, 'en_gros', 0),
(775, '', 'dy1013-i5', 'Hp dy1013-i5', 0, 1, 1, 9, 'en_gros', 0),
(778, '', 'dy1023-i5', 'Hp dy1023-i5', 0, 1, 1, 9, 'en_gros', 0),
(781, '', 'dy1031-i3', 'Hp dy1031-i3', 0, 1, 1, 9, 'en_gros', 0),
(784, '', 'dy2031-i3', 'Hp dy2031-i3', 0, 1, 1, 9, 'en_gros', 0),
(787, '', 'Hp 250-i5', 'Hp 250-i5', 0, 1, 1, 9, 'en_gros', 0),
(790, '', 'Hp 250-i7', 'Hp 250-i7', 0, 1, 1, 9, 'en_gros', 0),
(793, '', 'Hp DC', 'Hp DC', 0, 1, 1, 9, 'en_gros', 0),
(796, '', 'HP 0063-i5', 'HP 0063-i5', 0, 1, 1, 9, 'en_gros', 0),
(799, '', 'Hp 15-EGO354-I7', 'hp  HP 15-EG0354-i7 8go ram 1tb ssd 4go nvidia', 0, 1, 1, 9, 'en_gros', 0),
(802, '', 'Hp Dc 14&quot;', 'Hp Dc 14&quot;', 0, 1, 1, 9, 'en_gros', 0),
(805, '', 'Hp i3', 'Hp i3', 0, 1, 1, 9, 'en_gros', 0),
(808, '', 'HP i3 14\"', 'Hp i3 14\"', 0, 1, 1, 9, 'en_gros', 0),
(811, '', 'Hp i5', 'Hp i5', 0, 1, 1, 9, 'en_gros', 0),
(814, '', 'Hp envy i5 x360', 'Hp envy i5 x360', 0, 1, 1, 9, 'en_gros', 0),
(817, '', 'HP i5 14\"', 'Hp i5 14\"', 0, 1, 1, 9, 'en_gros', 0),
(820, '', 'Hp i7', 'Hp i7', 0, 1, 1, 9, 'en_gros', 0),
(823, '', 'Hp i3 pro', 'Hp i3 pro', 0, 1, 1, 9, 'en_gros', 0),
(826, '', 'Hp i7 14\"', 'Hp i7 14\"', 0, 1, 1, 9, 'en_gros', 0),
(829, '', 'Hp i7 NV', 'Hp i7 NV', 0, 1, 1, 9, 'en_gros', 0),
(832, '', 'Hp x360-i5', 'Hp x360-i5', 0, 1, 1, 9, 'en_gros', 0),
(835, '', 'Lenovo Dc 14&quot;', 'Lenovo Dc 14&quot;', 0, 1, 1, 9, 'en_gros', 0),
(838, '', 'Hp i7 envy', 'Hp i7 envy', 0, 1, 1, 9, 'en_gros', 0),
(841, '', 'Hp x360-i7', 'Hp x360-i7', 0, 1, 1, 9, 'en_gros', 0),
(844, '', 'Hp i7 Pro', 'Hp i7 ProBook', 0, 1, 1, 9, 'en_gros', 0),
(847, '', 'Hp x360 i3', 'Hp x360 i3', 0, 1, 1, 9, 'en_gros', 0),
(850, '', 'Lenovo i3', 'Lenovo i3', 0, 1, 1, 9, 'en_gros', 0),
(853, '', 'Lenovo i5', 'Lenovo i5', 0, 1, 1, 9, 'en_gros', 0),
(856, '', 'Lenovo dc', 'Lenovo dc', 0, 1, 1, 9, 'en_gros', 0),
(859, '', 'Mini Dell', 'Mini Dell', 0, 1, 1, 9, 'en_gros', 0),
(862, '', 'Mini Hp', 'Mini Hp', 0, 1, 1, 9, 'en_gros', 0),
(865, '', 'Mini Lenovo', 'Mini Lenovo', 0, 1, 1, 9, 'en_gros', 0),
(868, '', 'Lenovo i5 14&quot;', 'Lenovo i5 14&quot;', 0, 1, 1, 9, 'en_gros', 0),
(871, '', 'Lenovo i7', 'Lenovo i7', 0, 1, 1, 9, 'en_gros', 0),
(874, '', 'Hp 0033-i7 ref', 'Hp 0033-i7 ref', 0, 1, 1, 9, 'en_gros', 0),
(877, '', 'Hp eb 640 i5', 'Hp eb 640 i5', 0, 1, 1, 9, 'en_gros', 0),
(880, '', 'HP EB 640 I7', 'HP EB 640 I7', 0, 1, 1, 9, 'en_gros', 0),
(883, '', 'HP 15-EG2011-I7', 'HP 15-EG2011-I7', 0, 1, 1, 9, 'en_gros', 0),
(886, '', 'Op dell i5', 'Op dell i5', 0, 1, 1, 9, 'en_gros', 0),
(889, '', 'Op Hp i5', 'Op Hp i5', 0, 1, 1, 10, 'en_gros', 0),
(892, '', 'Op Hp i7', 'Op Hp i7', 0, 1, 1, 10, 'en_gros', 0),
(895, '', 'Mer 1000VA', 'Mer 1000VA', 0, 1, 1, 10, 'en_gros', 0),
(898, '', 'B 12V 7AM', 'B 12V 7AM', 0, 1, 1, 10, 'en_gros', 0),
(901, '', 'MER 1200VA', 'MER 1200VA', 0, 1, 1, 10, 'en_gros', 0),
(904, '', 'APC 700', 'APC 700', 0, 1, 1, 10, 'en_gros', 0),
(907, '', 'B 12V 9AM', 'B 12V 9AM', 0, 1, 1, 10, 'en_gros', 0),
(910, '', 'MER 2000VA', 'MER 2000VA', 0, 1, 1, 10, 'en_gros', 0),
(913, '', 'MER 1500VA', 'MER 1500VA', 0, 1, 1, 10, 'en_gros', 0),
(916, '', 'MER 3000VA', 'MER 3000VA', 0, 1, 1, 10, 'en_gros', 0),
(919, '', 'MER 650VA', 'MER 650VA', 0, 1, 1, 10, 'en_gros', 0),
(922, '', 'MER 750VA', 'MER 750VA', 0, 1, 1, 10, 'en_gros', 0),
(925, '', 'MER 850VA', 'MER 850VA', 0, 1, 1, 10, 'en_gros', 0),
(928, '', 'PR 1200VA', 'PR 1200VA', 0, 1, 1, 10, 'en_gros', 0),
(931, '', 'PR 3000VA', 'PR 3000VA', 0, 1, 1, 10, 'en_gros', 0),
(934, '', 'PR 900VA', 'PR 900VA', 0, 1, 1, 10, 'en_gros', 0),
(937, '', 'PR 05A', 'PR 05A', 0, 1, 1, 11, 'en_gros', 0),
(940, '', 'PR 130C', 'PR 130C', 0, 1, 1, 11, 'en_gros', 0),
(943, '', 'Pr 130n', 'Pr 130n', 0, 1, 1, 11, 'en_gros', 0),
(946, '', 'PR 17A', 'PR 17A', 0, 1, 1, 11, 'en_gros', 0),
(949, '', 'PR 203N', 'PR 203N', 0, 1, 1, 11, 'en_gros', 0),
(952, '', 'PR 205C', 'PR 205C', 0, 1, 1, 11, 'en_gros', 0),
(955, '', 'PR 205N', 'PR 205N', 0, 1, 1, 11, 'en_gros', 0),
(958, '', 'PR 207N', 'PR 207N', 0, 1, 1, 11, 'en_gros', 0),
(961, '', 'PR 207C', 'PR 207C', 0, 1, 1, 11, 'en_gros', 0),
(964, '', 'PR 26A', 'PR 26A', 0, 1, 1, 11, 'en_gros', 0),
(967, '', 'PR 410N', 'PR 410N', 0, 1, 1, 11, 'en_gros', 0),
(970, '', 'PR 415C', 'PR 415C', 0, 1, 1, 11, 'en_gros', 0),
(973, '', 'PR 30A', 'PR 30A', 0, 1, 1, 11, 'en_gros', 0),
(976, 'PR 410C', 'PR 410C', 'PR 410C', 0, 1, 1, 11, 'en_gros', 0),
(979, '', 'PR 415N', 'PR 415N', 0, 1, 1, 11, 'en_gros', 0),
(982, '', 'PR 83A', 'PR 83A', 0, 1, 1, 11, 'en_gros', 0),
(985, '', 'PR 201C', 'PR 201C', 0, 1, 1, 11, 'en_gros', 0),
(988, '', 'PR 201N', 'PR 201N', 0, 1, 1, 11, 'en_gros', 0),
(991, '', 'PR 85A', 'PR 85A', 0, 1, 1, 11, 'en_gros', 0),
(994, '', 'PR C-EXV40', 'PR C-EXV40', 0, 1, 1, 11, 'en_gros', 0),
(997, '', 'PR 79A', 'PR 79A', 0, 1, 1, 11, 'en_gros', 0),
(1000, '', 'PR 203C', 'PR 203C', 0, 1, 1, 11, 'en_gros', 0),
(1003, '', 'EB-X06', 'Epson Projector EB-X06', 0, 1, 1, 12, 'en_gros', 0),
(1006, '', 'Philips Projector', 'Philips Projector', 0, 1, 1, 12, 'en_gros', 0),
(1009, '', 'Tripod 180', 'Tripod 180', 0, 1, 1, 12, 'en_gros', 0),
(1012, '', 'Acer projector', 'Acer projector', 0, 1, 1, 12, 'en_gros', 0),
(1015, '', 'EB-01', 'Epson projector EB-01', 0, 1, 1, 12, 'en_gros', 0),
(1018, '', 'LG mini projector', 'LG mini projector', 0, 1, 1, 12, 'en_gros', 0),
(1021, '', 'Mini Projector', 'Mini Projector', 0, 1, 1, 12, 'en_gros', 0),
(1024, '', 'Tripod 200', 'Tripod 200', 0, 1, 1, 12, 'en_gros', 0),
(1027, '', 'Sony Projector', 'Sony Projector', 0, 1, 1, 12, 'en_gros', 0),
(1030, '', 'Tripod 240', 'Tripod 240', 0, 1, 1, 12, 'en_gros', 0),
(1033, '', 'w01', 'w01', 0, 1, 1, 12, 'en_gros', 0),
(1036, '', 'TRIPP LITE', 'Tripp Lite Rallonge', 0, 1, 1, 13, 'en_gros', 0),
(1039, '', 'Kadris 6T', 'Kadris 6T', 0, 1, 1, 13, 'en_gros', 0),
(1042, '', 'Premax Rallonge', 'Premax Rallonge', 0, 1, 1, 13, 'en_gros', 0),
(1045, '', 'B PC3 4GO', 'Destop B PC3 4GO', 0, 1, 1, 14, 'en_gros', 0),
(1048, '', 'B PC3 8GO', 'Destop B PC3 8GO', 0, 1, 1, 14, 'en_gros', 0),
(1051, '', 'B PC4 16GO', 'Destop B PC4 16GO', 0, 1, 1, 14, 'en_gros', 0),
(1054, '', 'B PC4 4GO', 'Destop B PC4 4GO', 0, 1, 1, 14, 'en_gros', 0),
(1057, '', 'B pc4 8GO', 'Destop B PC4 8GO', 0, 1, 1, 14, 'en_gros', 0),
(1060, '', 'PC4 4GO', 'Laptop PC4 4GO', 0, 1, 1, 14, 'en_gros', 0),
(1063, '', 'pc4 8GO', 'Laptop pc4 8GO', 0, 1, 1, 14, 'en_gros', 0),
(1066, '', 'PC3 4GO', 'Laptop PC3 4GO', 0, 1, 1, 14, 'en_gros', 0),
(1069, '', 'PC3 8GO', 'Laptop PC3 8GO', 0, 1, 1, 14, 'en_gros', 0),
(1072, '', 'PC4 16GO', 'Laptop PC4 16GO', 0, 1, 1, 14, 'en_gros', 0),
(1075, '', 'M7200', 'Tp link M7200', 0, 1, 1, 15, 'en_gros', 0),
(1078, '', 'M960', 'D link M960', 0, 1, 1, 15, 'en_gros', 0),
(1081, '', 'N300', 'D link N300', 0, 1, 1, 15, 'en_gros', 0),
(1084, '', 'Hawei', 'Routeur Hawei', 0, 1, 1, 15, 'en_gros', 0),
(1087, '', 'R Mobile Wifi', 'R Mobile Wifi', 0, 1, 1, 15, 'en_gros', 0),
(1090, '', 'D link DWR 932', 'D link DWR 932', 0, 1, 1, 15, 'en_gros', 0),
(1093, '', 'Dell Souri Wr', 'Dell Souri Wr', 0, 1, 1, 16, 'en_gros', 0),
(1096, '', 'Hp Souri Wr', 'Hp Souri Wr BLT', 0, 1, 1, 16, 'en_gros', 0),
(1099, '', 'Hp Souri', 'Hp Souri', 0, 1, 1, 16, 'en_gros', 0),
(1102, '', 'Dell Souri', 'Dell Souri', 0, 1, 1, 16, 'en_gros', 0),
(1105, '', 'M171', 'Logitec souri M171', 0, 1, 1, 16, 'en_gros', 0),
(1108, '', 'Souri BLT', 'Souri BLT', 0, 1, 1, 16, 'en_gros', 0),
(1111, '', 'Souri', 'Souri', 0, 1, 1, 16, 'en_gros', 0),
(1114, '', 'Souri LOG', 'Souri LOG', 0, 1, 1, 16, 'en_gros', 0),
(1117, '', 'ST 1000VA', 'ST 1000VA', 0, 1, 1, 17, 'en_gros', 0),
(1120, '', 'ST 1500VA', 'ST 1500VA', 0, 1, 1, 17, 'en_gros', 0),
(1123, '', 'ST 2000VA', 'ST 2000VA', 0, 1, 1, 17, 'en_gros', 0),
(1126, '', 'ST 3000VA', 'ST 3000VA', 0, 1, 1, 17, 'en_gros', 0),
(1129, '', 'ST 5000VA', 'ST 5000VA', 0, 1, 1, 17, 'en_gros', 0),
(1132, '', '88A', 'HP 88A', 0, 1, 1, 18, 'en_gros', 0),
(1135, '', '103A', 'Hp 103A', 0, 1, 1, 18, 'en_gros', 0),
(1138, '', '106A', 'Hp 106A', 0, 1, 1, 18, 'en_gros', 0),
(1141, '', '107A', 'HP 107A', 0, 1, 1, 18, 'en_gros', 0),
(1144, '', '05A', '05a', 0, 1, 1, 18, 'en_gros', 0),
(1147, '', '117 BLEU', 'HP 117 BLEU', 0, 1, 1, 18, 'en_gros', 0),
(1150, '', '117 Jaune', 'Hp 117 Jaune', 0, 1, 1, 18, 'en_gros', 0),
(1153, '', '117 Noir', 'Hp 117 Noir', 0, 1, 1, 18, 'en_gros', 0),
(1156, '', '117 Rouge', 'Hp 117 Rouge', 0, 1, 1, 18, 'en_gros', 0),
(1159, '', '126A', 'Hp 126A', 0, 1, 1, 18, 'en_gros', 0),
(1162, '', '130 Bleu', 'Hp 130 Bleu', 0, 1, 1, 18, 'en_gros', 0),
(1165, '', '130 Jaune', 'Hp 130 Jaune', 0, 1, 1, 18, 'en_gros', 0),
(1168, '', '130 Noir', 'Hp 130 Noir', 0, 1, 1, 18, 'en_gros', 0),
(1171, '', '12A', 'Hp 12A', 0, 1, 1, 18, 'en_gros', 0),
(1174, '', '130 Rouge', 'Hp 130 Rouge', 0, 1, 1, 18, 'en_gros', 0),
(1177, '', '130A-L', 'Hp 130A-L', 0, 1, 1, 18, 'en_gros', 0),
(1180, '', '131 ROUGE', 'Hp 131 ROUGE', 0, 1, 1, 18, 'en_gros', 0),
(1183, '', '17A', 'Hp 17A', 0, 1, 1, 18, 'en_gros', 0),
(1186, '', '19A', 'Hp 19A', 0, 1, 1, 18, 'en_gros', 0),
(1189, '', '131 Bleu', 'Hp 131 Bleu', 0, 1, 1, 18, 'en_gros', 0),
(1192, '', '131 Jaune', 'Hp 131 Jaune', 0, 1, 1, 18, 'en_gros', 0),
(1195, '', '131 Noir', 'Hp 131 Noir', 0, 1, 1, 18, 'en_gros', 0),
(1198, '', '201 Bleu', 'Hp 201 Bleu', 0, 1, 1, 18, 'en_gros', 0),
(1201, '', '201 Jaune', 'Hp 201 Jaune', 0, 1, 1, 18, 'en_gros', 0),
(1204, '', '17a-L', 'Hp 17a-L', 0, 1, 1, 18, 'en_gros', 0),
(1207, '', '201 Noir', 'Hp 201 Noir', 0, 1, 1, 18, 'en_gros', 0),
(1210, '', '201 Rouge', 'Hp 201 Rouge', 0, 1, 1, 18, 'en_gros', 0),
(1213, '', '203 Jaune', 'Hp 203 Jaune', 0, 1, 1, 18, 'en_gros', 0),
(1216, '', '203 Noir', 'Hp 203 Noir', 0, 1, 1, 18, 'en_gros', 0),
(1219, '', '203 Rouge', 'Hp 203 Rouge', 0, 1, 1, 18, 'en_gros', 0),
(1222, '', '203 Bleu', 'Hp 203 Bleu', 0, 1, 1, 18, 'en_gros', 0),
(1225, '', '205 Bleu', 'Hp 205 Bleu', 0, 1, 1, 18, 'en_gros', 0),
(1228, '', '205 Jaune', 'Hp 205 Jaune', 0, 1, 1, 18, 'en_gros', 0),
(1231, '', '205 Noir', 'Hp 205 Noir', 0, 1, 1, 18, 'en_gros', 0),
(1234, '', '205 Rouge', 'Hp 205 Rouge', 0, 1, 1, 18, 'en_gros', 0),
(1237, '', '207 Bleu', 'Hp 207 Bleu', 0, 1, 1, 18, 'en_gros', 0),
(1240, '', '207 Jaune', 'Hp 207 Jaune', 0, 1, 1, 18, 'en_gros', 0),
(1243, '', '207 Noir', 'Hp 207 Noir', 0, 1, 1, 18, 'en_gros', 0),
(1246, '', '207 Rouge', 'Hp 207 Rouge', 0, 1, 1, 18, 'en_gros', 0),
(1249, '', '216 Bleu', 'Hp 216 Bleu', 0, 1, 1, 18, 'en_gros', 0),
(1252, '', '216 Jaune', 'Hp 216 Jaune', 0, 1, 1, 18, 'en_gros', 0),
(1255, '', '216 Noir', 'Hp 216 Noir', 0, 1, 1, 18, 'en_gros', 0),
(1258, '', '216 Rouge', 'Hp 216 Rouge', 0, 1, 1, 18, 'en_gros', 0),
(1261, '', '30A', 'Hp 30A', 0, 1, 1, 18, 'en_gros', 0),
(1264, '', '410 Bleu', 'Hp 410 Bleu', 0, 1, 1, 18, 'en_gros', 0),
(1267, '', '410 Jaune', 'Hp 410 Jaune', 0, 1, 1, 18, 'en_gros', 0),
(1270, '', '410 Noir', 'Hp 410 Noir', 0, 1, 1, 18, 'en_gros', 0),
(1273, '', '30A-L', 'Hp 30A-L', 0, 1, 1, 18, 'en_gros', 0),
(1276, '', '32A', 'Hp 32A', 0, 1, 1, 18, 'en_gros', 0),
(1279, '', '35A', 'Hp 35A', 0, 1, 1, 18, 'en_gros', 0),
(1282, '', '410 Rouge', 'Hp 410 Rouge', 0, 1, 1, 18, 'en_gros', 0),
(1285, '', '415 Bleu', 'Hp 415 Bleu', 0, 1, 1, 18, 'en_gros', 0),
(1288, '', '415 Jaune', 'Hp 415 Jaune', 0, 1, 1, 18, 'en_gros', 0),
(1291, '', '415 Noir', 'Hp 415 Noir', 0, 1, 1, 18, 'en_gros', 0),
(1294, '', '415 Rouge', 'Hp 415 Rouge', 0, 1, 1, 18, 'en_gros', 0),
(1297, '', '44A', 'Hp 44A', 0, 1, 1, 18, 'en_gros', 0),
(1300, '', '59A', 'Hp 59A', 0, 1, 1, 18, 'en_gros', 0),
(1303, '', 'C EXV42', 'Hp C EXV42', 0, 1, 1, 18, 'en_gros', 0),
(1306, '', 'C EXV60', 'Hp C EXV60', 0, 1, 1, 18, 'en_gros', 0),
(1309, '', '55A', 'Hp 55A', 0, 1, 1, 18, 'en_gros', 0),
(1312, '', 'Canon 045C', 'Canon 045C', 0, 1, 1, 18, 'en_gros', 0),
(1315, '', '78A', 'Hp 78A', 0, 1, 1, 18, 'en_gros', 0),
(1318, '', '81A', 'Hp 81A', 0, 1, 1, 18, 'en_gros', 0),
(1321, '', '83A', 'Hp 83A', 0, 1, 1, 18, 'en_gros', 0),
(1324, '', '85A', 'Hp 85A', 0, 1, 1, 18, 'en_gros', 0),
(1327, '', 'Canon 045N', 'Canon 045N', 0, 1, 1, 18, 'en_gros', 0),
(1330, '', 'Canon 052', 'Canon 052', 0, 1, 1, 18, 'en_gros', 0),
(1333, '', 'Canon 054C', 'Canon 054C', 0, 1, 1, 18, 'en_gros', 0),
(1336, '', 'Canon 054N', 'Canon 054N', 0, 1, 1, 18, 'en_gros', 0),
(1339, '', 'Canon 719', 'Canon 719', 0, 1, 1, 18, 'en_gros', 0),
(1342, '', 'Canon 057', 'Canon 057', 0, 1, 1, 18, 'en_gros', 0),
(1345, '', 'C-exv33', 'C-exv33', 0, 1, 1, 18, 'en_gros', 0),
(1348, '', 'C-exv40', 'C-exv40', 0, 1, 1, 18, 'en_gros', 0),
(1351, '', '80A', '80A', 0, 1, 1, 18, 'en_gros', 0),
(1354, '', '416 Noir', '416 Noir', 0, 1, 1, 18, 'en_gros', 0),
(1357, '', '416 Rouge', '416 Rouge', 0, 1, 1, 18, 'en_gros', 0),
(1360, '', '416 Jaune', '416 Jaune', 0, 1, 1, 18, 'en_gros', 0),
(1363, '', '416 Bleu', '416 Bleu', 0, 1, 1, 18, 'en_gros', 0),
(1366, '', 'Batterie Laptop', 'Batterie Laptop', 0, 1, 1, 19, 'en_gros', 0),
(1369, '', 'Chargeur Laptop', 'Chargeur Laptop', 0, 1, 1, 19, 'en_gros', 0),
(1372, '', 'Ecran Laptop', 'Ecran Laptop', 0, 1, 1, 19, 'en_gros', 0),
(1375, '', 'Display to HDMI', 'Display to HDMI', 0, 1, 1, 19, 'en_gros', 0),
(1378, '', 'HDMI 1.5', 'HDMI 1.5', 0, 1, 1, 19, 'en_gros', 0),
(1381, '', 'HDMI 3m', 'HDMI 3m', 0, 1, 1, 19, 'en_gros', 0),
(1384, '', 'HDMI 5m', 'HDMI 5m', 0, 1, 1, 19, 'en_gros', 0),
(1409, '', 'HP 290-DC', 'HP 290-DC', 0, 1, 1, 5, 'en_gros', 0),
(1387, '', 'Hdmi 10m', 'Hdmi 10m', 0, 1, 1, 19, 'en_gros', 0),
(1390, '', 'Hdmi 15m', 'Hdmi 15m', 0, 1, 1, 19, 'en_gros', 0),
(1408, '', 'M283FDW', 'HP M 283 FDW', 0, 1, 1, 7, 'en_gros', 0),
(1407, '', 'M283FDN', 'M283FDN', 0, 1, 1, 7, 'en_gros', 0),
(1393, '', 'VGA', 'VGA', 0, 1, 1, 19, 'en_gros', 0),
(1406, '', 'e 103', 'e 103', 0, 1, 1, 8, 'en_gros', 0),
(1396, '', 'Power cable', 'Power cable', 0, 1, 1, 19, 'en_gros', 0),
(1405, '', 'e 101', 'e 101', 0, 1, 1, 8, 'en_gros', 0),
(1404, '', 'M 135A', 'M 135A', 0, 1, 1, 7, 'en_gros', 0),
(1399, '', 'Hdmi 20m', 'Hdmi 20m', 0, 1, 1, 19, 'en_gros', 0),
(1403, '', 'E 101C', 'E 101C', 0, 1, 1, 8, 'en_gros', 0);

-- --------------------------------------------------------

--
-- Structure de la table `proformat`
--

DROP TABLE IF EXISTS `proformat`;
CREATE TABLE IF NOT EXISTS `proformat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_produit` int(11) DEFAULT NULL,
  `num_pro` varchar(50) NOT NULL,
  `prix_vente` double NOT NULL,
  `quantity` int(11) NOT NULL,
  `vendeur` varchar(100) NOT NULL,
  `id_client` int(10) DEFAULT NULL,
  `nomclient` varchar(150) DEFAULT NULL,
  `lieuvente` varchar(10) DEFAULT NULL,
  `datepro` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `proformat`
--

INSERT INTO `proformat` (`id`, `id_produit`, `num_pro`, `prix_vente`, `quantity`, `vendeur`, `id_client`, `nomclient`, `lieuvente`, `datepro`) VALUES
(2, 202, 'ibep230001', 200000, 15, '1', 2, NULL, '1', '2023-07-14 12:04:30'),
(3, 1144, 'ibep230001', 0, 1, '1', 2, NULL, '1', '2023-07-14 12:04:30'),
(4, 202, 'ibep230004', 200000, 15, '1', 2, NULL, '1', '2023-07-14 12:04:49'),
(5, 1144, 'ibep230004', 0, 1, '1', 2, NULL, '1', '2023-07-14 12:04:49'),
(6, 349, 'ibep230006', 600000, 1, '1', 26, NULL, '1', '2023-07-14 12:16:14'),
(7, 214, 'ibep230006', 100000, 1, '1', 26, NULL, '1', '2023-07-14 12:16:14'),
(8, 220, 'ibep230008', 200000, 1, '1', 93, NULL, '1', '2023-07-17 13:01:51'),
(9, 220, 'ibep230009', 200000, 1, '1', 102, NULL, '1', '2023-07-17 13:02:40');

-- --------------------------------------------------------

--
-- Structure de la table `promotion`
--

DROP TABLE IF EXISTS `promotion`;
CREATE TABLE IF NOT EXISTS `promotion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idprod` int(11) NOT NULL,
  `achatmin` int(11) NOT NULL,
  `achatmax` int(11) NOT NULL,
  `qtite` float NOT NULL,
  `dated` date NOT NULL,
  `datef` date NOT NULL,
  `idnomstock` int(11) DEFAULT NULL,
  `dateop` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `recette`
--

DROP TABLE IF EXISTS `recette`;
CREATE TABLE IF NOT EXISTS `recette` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `numdec` varchar(50) DEFAULT 'retd26',
  `categorie` varchar(100) DEFAULT 'autres',
  `montant` double NOT NULL,
  `devisedep` varchar(20) NOT NULL,
  `payement` varchar(30) NOT NULL,
  `cprelever` varchar(50) DEFAULT 'caisse',
  `coment` varchar(150) DEFAULT NULL,
  `client` varchar(155) DEFAULT NULL,
  `lieuvente` varchar(10) DEFAULT NULL,
  `date_payement` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `recette`
--

INSERT INTO `recette` (`id`, `numdec`, `categorie`, `montant`, `devisedep`, `payement`, `cprelever`, `coment`, `client`, `lieuvente`, `date_payement`) VALUES
(1, 'depr1', '1', 200000, 'gnf', 'espèces', '1', 'recette camion', NULL, '1', '2023-08-27 11:11:00');

-- --------------------------------------------------------

--
-- Structure de la table `retourlist`
--

DROP TABLE IF EXISTS `retourlist`;
CREATE TABLE IF NOT EXISTS `retourlist` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `numero` varchar(50) NOT NULL,
  `idprod` int(11) NOT NULL,
  `stockret` int(11) NOT NULL,
  `quantiteret` float NOT NULL,
  `pa` int(11) NOT NULL,
  `client` int(11) NOT NULL,
  `exect` int(11) NOT NULL,
  `dateop` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `retourlistclient`
--

DROP TABLE IF EXISTS `retourlistclient`;
CREATE TABLE IF NOT EXISTS `retourlistclient` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `numero` varchar(50) NOT NULL,
  `idprod` int(11) NOT NULL,
  `stockret` int(11) NOT NULL,
  `quantiteret` float NOT NULL,
  `pa` int(11) NOT NULL,
  `client` int(11) NOT NULL,
  `exect` int(11) NOT NULL,
  `dateop` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `statproduit`
--

DROP TABLE IF EXISTS `statproduit`;
CREATE TABLE IF NOT EXISTS `statproduit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idprod` int(11) NOT NULL,
  `qtitevendus` float DEFAULT NULL,
  `qtiteachat` float DEFAULT NULL,
  `montantvendus` double DEFAULT NULL,
  `montantachat` double DEFAULT NULL,
  `prvente` double DEFAULT NULL,
  `prachat` double DEFAULT NULL,
  `pseudo` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `stock`
--

DROP TABLE IF EXISTS `stock`;
CREATE TABLE IF NOT EXISTS `stock` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nomstock` varchar(150) NOT NULL,
  `nombdd` varchar(150) NOT NULL,
  `coderesp` int(11) NOT NULL,
  `position` varchar(150) NOT NULL,
  `surface` float DEFAULT NULL,
  `nbrepiece` int(2) DEFAULT NULL,
  `adresse` varchar(200) NOT NULL,
  `lieuvente` int(11) DEFAULT '1',
  `type` varchar(50) NOT NULL DEFAULT 'vente',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `stock`
--

INSERT INTO `stock` (`id`, `nomstock`, `nombdd`, `coderesp`, `position`, `surface`, `nbrepiece`, `adresse`, `lieuvente`, `type`) VALUES
(1, 'boutique 1', 'stock1', 2, 'kaloum', 1500, 1, 'kaloum', 1, 'vente'),
(2, 'boutique 2', 'stock2', 2, 'kaloum', 1500, 1, 'kaloum', 2, 'vente');

-- --------------------------------------------------------

--
-- Structure de la table `stock1`
--

DROP TABLE IF EXISTS `stock1`;
CREATE TABLE IF NOT EXISTS `stock1` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `codeb` varchar(100) DEFAULT NULL,
  `idprod` int(10) NOT NULL,
  `prix_achat` double DEFAULT '0',
  `prix_revient` double DEFAULT '0',
  `prix_vente` double DEFAULT '0',
  `type` varchar(20) DEFAULT NULL,
  `quantite` float DEFAULT '0',
  `qtiteintd` int(11) DEFAULT '0',
  `qtiteintp` int(11) DEFAULT '0',
  `nbrevente` float DEFAULT '0',
  `dateperemtion` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=475 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `stock1`
--

INSERT INTO `stock1` (`id`, `codeb`, `idprod`, `prix_achat`, `prix_revient`, `prix_vente`, `type`, `quantite`, `qtiteintd`, `qtiteintp`, `nbrevente`, `dateperemtion`) VALUES
(1, '', 1144, 0, 0, 10, 'en_gros', 20, 1, 1, 0, NULL),
(2, '', 586, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(3, '', 589, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(4, '', 577, 0, 138915, 150000, 'en_gros', 72, 1, 1, 0, NULL),
(5, '', 580, 0, 113778, 130000, 'en_gros', 105, 1, 1, 0, NULL),
(6, '', 592, 0, 125731.53768844, 400000, 'en_gros', 199, 1, 1, 0, NULL),
(7, '', 583, 0, 103194, 120000, 'en_gros', 189, 1, 1, 0, NULL),
(8, '', 604, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(9, '', 607, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(10, '', 610, 0, 89964, 120000, 'en_gros', 138, 1, 1, 0, NULL),
(11, '', 613, 0, 89964, 120000, 'en_gros', 216, 1, 1, 0, NULL),
(12, '', 1363, 0, 1045170, 1200000, 'en_gros', 8, 1, 1, 0, NULL),
(13, '', 1360, 0, 1045170, 1200000, 'en_gros', 8, 1, 1, 0, NULL),
(14, '', 1354, 0, 820260, 1000000, 'en_gros', 13, 1, 1, 0, NULL),
(15, '', 1357, 0, 1045170, 1200000, 'en_gros', 8, 1, 1, 0, NULL),
(16, '', 595, 0, 185220, 230000, 'en_gros', 62, 1, 1, 0, NULL),
(17, '', 619, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(18, '', 598, 0, 211680, 250000, 'en_gros', 79, 1, 1, 0, NULL),
(19, '', 601, 0, 185220, 230000, 'en_gros', 2, 1, 1, 0, NULL),
(20, '', 616, 0, 211680, 250000, 'en_gros', 1, 1, 1, 0, NULL),
(21, '', 622, 0, 97902, 120000, 'en_gros', 71, 1, 1, 0, NULL),
(22, '', 625, 0, 111132, 120000, 'en_gros', 117, 1, 1, 0, NULL),
(23, '', 628, 0, 108486, 120000, 'en_gros', 56, 1, 1, 0, NULL),
(24, '', 631, 0, 124362, 140000, 'en_gros', 49, 1, 1, 0, NULL),
(25, '', 1351, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(26, '', 643, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(27, '', 646, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(28, '', 649, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(29, '', 652, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(30, '', 655, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(31, '', 658, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(32, '', 661, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(33, '', 664, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(34, '', 634, 0, 111132, 150000, 'en_gros', 1, 1, 1, 0, NULL),
(35, '', 670, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(36, '', 673, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(37, '', 676, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(38, '', 679, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(39, '', 637, 0, 187866, 230000, 'en_gros', 71, 1, 1, 0, NULL),
(40, '', 640, 0, 297675, 350000, 'en_gros', 45, 1, 1, 0, NULL),
(41, '', 688, 0, 267246, 300000, 'en_gros', 31, 1, 1, 0, NULL),
(42, '', 667, 0, 404838, 450000, 'en_gros', 27, 1, 1, 0, NULL),
(43, '', 682, 0, 174636, 230000, 'en_gros', 41, 1, 1, 0, NULL),
(44, '', 685, 0, 232848, 270000, 'en_gros', 46, 1, 1, 0, NULL),
(45, '', 175, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(46, '', 1012, 0, 3307500, 3800000, 'en_gros', 3, 1, 1, 0, NULL),
(47, '', 904, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(48, '', 43, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(49, '', 898, 0, 79380, 120000, 'en_gros', 10, 1, 1, 0, NULL),
(50, '', 907, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(51, '', 346, 0, 261954, 400000, 'en_gros', 1, 1, 1, 0, NULL),
(52, '', 349, 0, 470988, 600000, 'en_gros', 28, 1, 1, 0, NULL),
(53, '', 361, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(54, '', 364, 0, 629748, 1000000, 'en_gros', 38, 1, 1, 0, NULL),
(55, '', 352, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(56, '', 397, 0, 1547910, 2000000, 'en_gros', 10, 1, 1, 0, NULL),
(57, '', 244, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(58, '', 40, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(59, '', 181, 0, 71001, 300000, 'en_gros', 48, 1, 1, 0, NULL),
(60, '', 1366, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(61, '', 46, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(62, '', 1345, 0, 330750, 500000, 'en_gros', 5, 1, 1, 0, NULL),
(63, '', 1348, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(64, '', 52, 0, 0, 0, 'en_gros', -1, 1, 1, 0, NULL),
(65, '', 49, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(66, '', 61, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(67, '', 709, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(68, '', 1312, 0, 489510, 600000, 'en_gros', 50, 1, 1, 0, NULL),
(69, '', 1327, 0, 476280, 600000, 'en_gros', 12, 1, 1, 0, NULL),
(70, '', 1330, 0, 833490, 1000000, 'en_gros', 5, 1, 1, 0, NULL),
(71, '', 1333, 0, 463050, 600000, 'en_gros', 13, 1, 1, 0, NULL),
(72, '', 1336, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(73, '', 1342, 0, 621810, 900000, 'en_gros', 18, 1, 1, 0, NULL),
(74, '', 7, 0, 22756, 40000, 'en_gros', 42, 1, 1, 0, NULL),
(75, '', 418, 0, 4273290, 5000000, 'en_gros', 2, 1, 1, 0, NULL),
(76, '', 421, 0, 4855410, 5500000, 'en_gros', 6, 1, 1, 0, NULL),
(77, '', 412, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(78, '', 430, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(79, '', 415, 0, 6509160, 7500000, 'en_gros', 4, 1, 1, 0, NULL),
(80, '', 541, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(81, '', 409, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(82, '', 565, 0, 3757320, 4300000, 'en_gros', 3, 1, 1, 0, NULL),
(83, '', 424, 0, 2063880, 2500000, 'en_gros', 2, 1, 1, 0, NULL),
(84, '', 1339, 0, 470988, 650000, 'en_gros', 9, 1, 1, 0, NULL),
(85, '', 568, 0, 5556600, 6300000, 'en_gros', 5, 1, 1, 0, NULL),
(86, '', 337, 0, 19845, 40000, 'en_gros', 104, 1, 1, 0, NULL),
(87, '', 340, 0, 35721, 50000, 'en_gros', 51, 1, 1, 0, NULL),
(88, '', 343, 0, 76734, 100000, 'en_gros', 13, 1, 1, 0, NULL),
(89, '', 400, 0, 150822, 200000, 'en_gros', 11, 1, 1, 0, NULL),
(90, '', 154, 0, 84672, 100000, 'en_gros', 46, 1, 1, 0, NULL),
(91, '', 58, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(92, '', 157, 0, 124362, 200000, 'en_gros', 40, 1, 1, 0, NULL),
(93, '', 160, 0, 58212, 150000, 'en_gros', 10, 1, 1, 0, NULL),
(94, '', 103, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(95, '', 106, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(96, '', 109, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(97, '', 112, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(98, '', 439, 0, 4445280, 5000000, 'en_gros', 4, 1, 1, 0, NULL),
(99, '', 67, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(100, '', 70, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(101, '', 1369, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(102, '', 211, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(103, '', 220, 0, 116424, 200000, 'en_gros', 46, 1, 1, 0, NULL),
(104, '', 214, 0, 79380, 100000, 'en_gros', 10, 1, 1, 0, NULL),
(105, '', 217, 0, 79380, 150000, 'en_gros', 76, 1, 1, 0, NULL),
(106, '', 127, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(107, '', 82, 0, 132300, 150000, 'en_gros', 5, 1, 1, 0, NULL),
(108, '', 55, 0, 43659, 80000, 'en_gros', 21, 1, 1, 0, NULL),
(109, '', 73, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(110, '', 724, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(111, '', 1090, 0, 291060, 400000, 'en_gros', 9, 1, 1, 0, NULL),
(112, '', 1078, 0, 410130, 600000, 'en_gros', 36, 1, 1, 0, NULL),
(113, '', 1081, 0, 317520, 400000, 'en_gros', 5, 1, 1, 0, NULL),
(114, '', 370, 0, 354564, 500000, 'en_gros', 65, 1, 1, 0, NULL),
(115, '', 373, 0, 494802, 600000, 'en_gros', 4, 1, 1, 0, NULL),
(116, '', 367, 0, 727650, 1000000, 'en_gros', 6, 1, 1, 0, NULL),
(117, '', 355, 0, 304290, 400000, 'en_gros', 2, 1, 1, 0, NULL),
(118, '', 406, 0, 891702, 1000000, 'en_gros', 12, 1, 1, 0, NULL),
(119, '', 193, 0, 762048, 800000, 'en_gros', 18, 1, 1, 0, NULL),
(120, '', 229, 0, 4159510, 4300000, 'en_gros', 1, 1, 1, 0, NULL),
(121, '', 253, 0, 3704400, 5000000, 'en_gros', 5, 1, 1, 0, NULL),
(122, '', 226, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(123, '', 232, 0, 3969000, 4000000, 'en_gros', 1, 1, 1, 0, NULL),
(124, '', 328, 0, 846720, 2300000, 'en_gros', 20, 1, 1, 0, NULL),
(125, '', 331, 0, 1111320, 2800000, 'en_gros', 11, 1, 1, 0, NULL),
(126, '', 235, 0, 1614060, 3500000, 'en_gros', 37, 1, 1, 0, NULL),
(127, '', 238, 0, 2275560, 4000000, 'en_gros', 14, 1, 1, 0, NULL),
(128, '', 265, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(129, '', 733, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(130, '', 247, 0, 873180, 1000000, 'en_gros', 73, 1, 1, 0, NULL),
(131, '', 241, 0, 1426190, 1600000, 'en_gros', 10, 1, 1, 0, NULL),
(132, '', 274, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(133, '', 736, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(134, '', 739, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(135, '', 742, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(136, '', 745, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(137, '', 715, 0, 5463990, 6000000, 'en_gros', 1, 1, 1, 0, NULL),
(138, '', 751, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(139, '', 754, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(140, '', 1102, 0, 29106, 50000, 'en_gros', 3, 1, 1, 0, NULL),
(141, '', 1093, 0, 82026, 100000, 'en_gros', 16, 1, 1, 0, NULL),
(142, '', 1045, 0, 161406, 200000, 'en_gros', 14, 1, 1, 0, NULL),
(143, '', 1048, 0, 206388, 350000, 'en_gros', 49, 1, 1, 0, NULL),
(144, '', 1051, 0, 526554, 600000, 'en_gros', 5, 1, 1, 0, NULL),
(145, '', 1054, 0, 119070, 200000, 'en_gros', 24, 1, 1, 0, NULL),
(146, '', 1057, 0, 301644, 350000, 'en_gros', 16, 1, 1, 0, NULL),
(147, '', 757, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(148, '', 1375, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(149, '', 130, 0, 21168, 0, 'en_gros', 43, 1, 1, 0, NULL),
(150, '', 760, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(151, '', 766, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(152, '', 1405, 0, 129654, 140000, 'en_gros', 85, 1, 1, 0, NULL),
(153, '', 1403, 0, 70119, 90000, 'en_gros', 90, 1, 1, 0, NULL),
(154, '', 691, 0, 127008, 140000, 'en_gros', 60, 1, 1, 0, NULL),
(155, '', 1406, 0, 76734, 100000, 'en_gros', 86, 1, 1, 0, NULL),
(156, '', 712, 0, 76734, 100000, 'en_gros', 90, 1, 1, 0, NULL),
(157, '', 694, 0, 47628, 80000, 'en_gros', 207, 1, 1, 0, NULL),
(158, '', 544, 0, 4220370, 5000000, 'en_gros', 4, 1, 1, 0, NULL),
(159, '', 427, 0, 1238330, 1700000, 'en_gros', 55, 1, 1, 0, NULL),
(160, '', 433, 0, 1264790, 1800000, 'en_gros', 31, 1, 1, 0, NULL),
(161, '', 448, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(162, '', 445, 0, 3114340, 3800000, 'en_gros', 10, 1, 1, 0, NULL),
(163, '', 553, 0, 2725380, 3200000, 'en_gros', 5, 1, 1, 0, NULL),
(164, '', 436, 0, 2249100, 2500000, 'en_gros', 3, 1, 1, 0, NULL),
(165, '', 442, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(166, '', 748, 0, 6429780, 7300000, 'en_gros', 8, 1, 1, 0, NULL),
(167, '', 1372, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(168, '', 1015, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(169, '', 1003, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(170, '', 358, 0, 248724, 400000, 'en_gros', 42, 1, 1, 0, NULL),
(171, '', 376, 0, 582120, 600000, 'en_gros', 3, 1, 1, 0, NULL),
(172, '', 379, 0, 127008, 300000, 'en_gros', 30, 1, 1, 0, NULL),
(173, '', 94, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(174, '', 1378, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(175, '', 1387, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(176, '', 1390, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(177, '', 1399, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(178, '', 1381, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(179, '', 1384, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(180, '', 799, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(181, '', 721, 0, 7514640, 8300000, 'en_gros', 1, 1, 1, 0, NULL),
(182, '', 874, 0, 0, 2000000, 'en_gros', 20, 1, 1, 0, NULL),
(183, '', 796, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(184, '', 1135, 0, 92610, 200000, 'en_gros', 7, 1, 1, 0, NULL),
(185, '', 1138, 0, 388962, 550000, 'en_gros', 15, 1, 1, 0, NULL),
(186, '', 1141, 0, 399840, 100000, 'en_gros', 18, 1, 1, 0, NULL),
(187, '', 1147, 0, 391608, 550000, 'en_gros', 22, 1, 1, 0, NULL),
(188, '', 1150, 0, 391608, 550000, 'en_gros', 14, 1, 1, 0, NULL),
(189, '', 1153, 0, 365148, 550000, 'en_gros', 17, 1, 1, 0, NULL),
(190, '', 1156, 0, 391608, 550000, 'en_gros', 21, 1, 1, 0, NULL),
(191, '', 451, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(192, '', 1159, 0, 754110, 900000, 'en_gros', 4, 1, 1, 0, NULL),
(193, '', 1171, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(194, '', 1162, 0, 399546, 550000, 'en_gros', 15, 1, 1, 0, NULL),
(195, '', 1165, 0, 399546, 550000, 'en_gros', 5, 1, 1, 0, NULL),
(196, '', 1168, 0, 359856, 550000, 'en_gros', 5, 1, 1, 0, NULL),
(197, '', 1174, 0, 399546, 550000, 'en_gros', 11, 1, 1, 0, NULL),
(198, '', 1177, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(199, '', 1189, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(200, '', 1192, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(201, '', 1195, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(202, '', 1180, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(203, '', 472, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(204, '', 883, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(205, '', 1183, 0, 410130, 600000, 'en_gros', 36, 1, 1, 0, NULL),
(206, '', 1204, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(207, '', 1186, 0, 449820, 600000, 'en_gros', 8, 1, 1, 0, NULL),
(208, '', 1198, 0, 542430, 650000, 'en_gros', 22, 1, 1, 0, NULL),
(209, '', 1201, 0, 542430, 650000, 'en_gros', 19, 1, 1, 0, NULL),
(210, '', 1207, 0, 476280, 650000, 'en_gros', 20, 1, 1, 0, NULL),
(211, '', 1210, 0, 542430, 650000, 'en_gros', 23, 1, 1, 0, NULL),
(212, '', 1222, 0, 595350, 650000, 'en_gros', 17, 1, 1, 0, NULL),
(213, '', 1213, 0, 595350, 650000, 'en_gros', 16, 1, 1, 0, NULL),
(214, '', 1216, 0, 523908, 650000, 'en_gros', 26, 1, 1, 0, NULL),
(215, '', 1219, 0, 595350, 650000, 'en_gros', 28, 1, 1, 0, NULL),
(216, '', 1225, 0, 431298, 550000, 'en_gros', 23, 1, 1, 0, NULL),
(217, '', 1228, 0, 431298, 550000, 'en_gros', 27, 1, 1, 0, NULL),
(218, '', 1231, 0, 404838, 550000, 'en_gros', 19, 1, 1, 0, NULL),
(219, '', 1234, 0, 431298, 550000, 'en_gros', 27, 1, 1, 0, NULL),
(220, '', 1237, 0, 592704, 650000, 'en_gros', 8, 1, 1, 0, NULL),
(221, '', 1240, 0, 592704, 650000, 'en_gros', 12, 1, 1, 0, NULL),
(222, '', 1243, 0, 518616, 650000, 'en_gros', 16, 1, 1, 0, NULL),
(223, '', 1246, 0, 592704, 650000, 'en_gros', 14, 1, 1, 0, NULL),
(224, '', 697, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(225, '', 463, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(226, '', 1249, 0, 428652, 550000, 'en_gros', 26, 1, 1, -1, NULL),
(227, '', 1252, 0, 428652, 550000, 'en_gros', 28, 1, 1, -1, NULL),
(228, '', 1255, 0, 402192, 550000, 'en_gros', 47, 1, 1, -1, NULL),
(229, '', 1258, 0, 428652, 550000, 'en_gros', 28, 1, 1, -1, NULL),
(230, '', 700, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(231, '', 454, 0, 351918, 500000, 'en_gros', 26, 1, 1, 0, NULL),
(232, '', 787, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(233, '', 790, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(234, '', 457, 0, 420714, 600000, 'en_gros', 20, 1, 1, 0, NULL),
(235, '', 1409, 0, 3069360, 3500000, 'en_gros', 4, 1, 1, 0, NULL),
(236, '', 271, 0, 3704400, 4000000, 'en_gros', 14, 1, 1, 0, NULL),
(237, '', 334, 0, 3876390, 4800000, 'en_gros', 21, 1, 1, 0, NULL),
(238, '', 250, 0, 3598560, 6000000, 'en_gros', 1, 1, 1, 0, NULL),
(239, '', 1261, 0, 444528, 600000, 'en_gros', 16, 1, 1, 0, NULL),
(240, '', 1273, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(241, '', 1276, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(242, '', 1279, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(243, '', 283, 0, 926100, 2300000, 'en_gros', 16, 1, 1, 0, NULL),
(244, '', 256, 0, 1243620, 2800000, 'en_gros', 27, 1, 1, 0, NULL),
(245, '', 259, 0, 1494990, 3500000, 'en_gros', 40, 1, 1, 0, NULL),
(246, '', 262, 0, 2500470, 4000000, 'en_gros', 27, 1, 1, 0, NULL),
(247, '', 1264, 0, 661500, 800000, 'en_gros', 26, 1, 1, 0, NULL),
(248, '', 1267, 0, 661500, 800000, 'en_gros', 28, 1, 1, 0, NULL),
(249, '', 1270, 0, 529200, 800000, 'en_gros', 23, 1, 1, 0, NULL),
(250, '', 1282, 0, 661500, 800000, 'en_gros', 37, 1, 1, 0, NULL),
(251, '', 1285, 0, 883764, 1000000, 'en_gros', 27, 1, 1, 0, NULL),
(252, '', 1288, 0, 883764, 1000000, 'en_gros', 19, 1, 1, 0, NULL),
(253, '', 1291, 0, 682668, 800000, 'en_gros', 34, 1, 1, 0, NULL),
(254, '', 1294, 0, 883764, 1000000, 'en_gros', 27, 1, 1, 0, NULL),
(255, '', 1297, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(256, '', 1309, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(257, '', 1300, 0, 701190, 900000, 'en_gros', 19, 1, 1, 0, NULL),
(258, '', 295, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(259, '', 268, 0, 2804760, 4000000, 'en_gros', 1, 1, 1, 0, NULL),
(260, '', 460, 0, 1582310, 2300000, 'en_gros', 10, 1, 1, 0, NULL),
(261, '', 466, 0, 2169720, 3000000, 'en_gros', 6, 1, 1, 0, NULL),
(262, '', 1315, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(263, '', 1318, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(264, '', 1321, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(265, '', 1324, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(266, '', 478, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(267, '', 1132, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(268, '', 469, 0, 1971270, 2500000, 'en_gros', 8, 1, 1, 0, NULL),
(269, '', 301, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(270, '', 298, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(271, '', 277, 0, 4299750, 5000000, 'en_gros', 10, 1, 1, 0, NULL),
(272, '', 280, 0, 5715360, 7000000, 'en_gros', 29, 1, 1, 0, NULL),
(273, '', 190, 0, 4709880, 6000000, 'en_gros', 3, 1, 1, 0, NULL),
(274, '', 325, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(275, '', 307, 0, 8665650, 0, 'en_gros', 10, 1, 1, 0, NULL),
(276, '', 322, 0, 9525600, 10500000, 'en_gros', 5, 1, 1, 0, NULL),
(277, '', 310, 0, 9049320, 10500000, 'en_gros', 3, 1, 1, 0, NULL),
(278, '', 1303, 0, 259308, 300000, 'en_gros', 16, 1, 1, 0, NULL),
(279, '', 1306, 0, 259308, 300000, 'en_gros', 1, 1, 1, 0, NULL),
(280, '', 793, 0, 1746360, 2200000, 'en_gros', 18, 1, 1, 0, NULL),
(281, '', 802, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(282, '', 769, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(283, '', 775, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(284, '', 772, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(285, '', 778, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(286, '', 781, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(287, '', 784, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(288, '', 292, 0, 1172180, 1700000, 'en_gros', 5, 1, 1, 0, NULL),
(289, '', 304, 0, 1394440, 1900000, 'en_gros', 12, 1, 1, 0, NULL),
(290, '', 877, 0, 6562080, 7500000, 'en_gros', 2, 1, 1, 0, NULL),
(291, '', 880, 0, 7567560, 8500000, 'en_gros', 3, 1, 1, 0, NULL),
(292, '', 289, 0, 621810, 1000000, 'en_gros', 140, 1, 1, 0, NULL),
(293, '', 316, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(294, '', 286, 0, 1336230, 1600000, 'en_gros', 3, 1, 1, 0, NULL),
(295, '', 319, 0, 1574370, 1700000, 'en_gros', 4, 1, 1, 0, NULL),
(296, '', 814, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(297, '', 805, 0, 3042900, 3200000, 'en_gros', 7, 1, 1, 0, NULL),
(298, '', 808, 0, 3281040, 3600000, 'en_gros', 4, 1, 1, 0, NULL),
(299, '', 823, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(300, '', 811, 0, 4312980, 4600000, 'en_gros', 5, 1, 1, 0, NULL),
(301, '', 817, 0, 4736340, 5300000, 'en_gros', 6, 1, 1, 0, NULL),
(302, '', 727, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(303, '', 730, 0, 5490450, 6500000, 'en_gros', 1, 1, 1, 0, NULL),
(304, '', 820, 0, 5318460, 6000000, 'en_gros', 6, 1, 1, 0, NULL),
(305, '', 826, 0, 5715360, 6500000, 'en_gros', 4, 1, 1, 0, NULL),
(306, '', 838, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(307, '', 829, 0, 6720840, 0, 'en_gros', 2, 1, 1, 0, NULL),
(308, '', 844, 0, 6615000, 7500000, 'en_gros', 3, 1, 1, 0, NULL),
(309, '', 1408, 0, 4704590, 5400000, 'en_gros', 7, 1, 1, 0, NULL),
(310, '', 559, 0, 3942540, 4500000, 'en_gros', 2, 1, 1, 0, NULL),
(311, '', 562, 0, 4167450, 4700000, 'en_gros', 3, 1, 1, 0, NULL),
(312, '', 1099, 0, 30429, 50000, 'en_gros', 52, 1, 1, 0, NULL),
(313, '', 1096, 0, 55566, 80000, 'en_gros', 41, 1, 1, 0, NULL),
(314, '', 13, 0, 41013, 70000, 'en_gros', 27, 1, 1, -2, NULL),
(315, '', 16, 0, 63504, 100000, 'en_gros', 26, 1, 1, -2, NULL),
(316, '', 847, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(317, '', 832, 0, 5212620, 6000000, 'en_gros', 2, 1, 1, -1, NULL),
(318, '', 841, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(319, '', 1039, 0, 66150, 90000, 'en_gros', 56, 1, 1, 0, NULL),
(320, '', 199, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(321, '', 202, 0, 189189, 200000, 'en_gros', 2, 1, 1, 0, NULL),
(322, '', 205, 0, 156114, 190000, 'en_gros', 74, 1, 1, 0, NULL),
(323, '', 208, 0, 209034, 250000, 'en_gros', 65, 1, 1, -1, NULL),
(324, '', 706, 0, 22491, 50000, 'en_gros', 87, 1, 1, 0, NULL),
(325, '', 703, 0, 21168, 50000, 'en_gros', 33, 1, 1, 0, NULL),
(326, '', 1066, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(327, '', 1069, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(328, '', 1072, 0, 296352, 600000, 'en_gros', 11, 1, 1, 0, NULL),
(329, '', 1060, 0, 179928, 200000, 'en_gros', 24, 1, 1, 0, NULL),
(330, '', 1063, 0, 158760, 350000, 'en_gros', 20, 1, 1, 0, NULL),
(331, '', 64, 0, 158760, 200000, 'en_gros', 8, 1, 1, 0, NULL),
(332, '', 76, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(333, '', 313, 0, 2143260, 2800000, 'en_gros', 4, 1, 1, 0, NULL),
(334, '', 856, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(335, '', 835, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(336, '', 850, 0, 2407860, 3000000, 'en_gros', 1, 1, 1, 0, NULL),
(337, '', 853, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(338, '', 868, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(339, '', 871, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(340, '', 718, 0, 7726320, 8500000, 'en_gros', 8, 1, 1, 0, NULL),
(341, '', 1018, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(342, '', 484, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(343, '', 481, 0, 674730, 1100000, 'en_gros', 20, 1, 1, 0, NULL),
(344, '', 223, 0, 137592, 180000, 'en_gros', 70, 1, 1, 0, NULL),
(345, '', 1105, 0, 66150, 100000, 'en_gros', 55, 1, 1, 0, NULL),
(346, '', 187, 0, 174636, 200000, 'en_gros', 8, 1, 1, 0, NULL),
(347, '', 490, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(348, '', 493, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(349, '', 571, 0, 1058400, 1350000, 'en_gros', 20, 1, 1, 0, NULL),
(350, '', 574, 0, 1164240, 1450000, 'en_gros', 5, 1, 1, 0, NULL),
(351, '', 496, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(352, '', 499, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(353, '', 502, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(354, '', 1404, 0, 1357400, 1700000, 'en_gros', 4, 1, 1, 0, NULL),
(355, '', 475, 0, 1447360, 1800000, 'en_gros', 5, 1, 1, 0, NULL),
(356, '', 532, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(357, '', 487, 0, 3863160, 4500000, 'en_gros', 22, 1, 1, 0, NULL),
(358, '', 514, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(359, '', 517, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(360, '', 505, 0, 3955770, 4200000, 'en_gros', 2, 1, 1, 0, NULL),
(361, '', 523, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(362, '', 535, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(363, '', 538, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(364, '', 520, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(365, '', 526, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(366, '', 547, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(367, '', 550, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(368, '', 508, 0, 6903410, 7500000, 'en_gros', 2, 1, 1, 0, NULL),
(369, '', 511, 0, 6509160, 7500000, 'en_gros', 5, 1, 1, 0, NULL),
(370, '', 1407, 0, 4551120, 5200000, 'en_gros', 12, 1, 1, 0, NULL),
(371, '', 895, 0, 341334, 450000, 'en_gros', 45, 1, 1, 0, NULL),
(372, '', 901, 0, 508032, 650000, 'en_gros', 1, 1, 1, 0, NULL),
(373, '', 913, 0, 605934, 750000, 'en_gros', 37, 1, 1, 0, NULL),
(374, '', 910, 0, 846720, 1000000, 'en_gros', 7, 1, 1, 0, NULL),
(375, '', 916, 0, 1508220, 1800000, 'en_gros', 16, 1, 1, 0, NULL),
(376, '', 919, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(377, '', 922, 0, 243432, 350000, 'en_gros', 40, 1, 1, 0, NULL),
(378, '', 925, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(379, '', 763, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(380, '', 859, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(381, '', 862, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(382, '', 865, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(383, '', 1021, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(384, '', 184, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(385, '', 91, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(386, '', 886, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(387, '', 889, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(388, '', 892, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(389, '', 133, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(390, '', 1006, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(391, '', 79, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(392, '', 136, 0, 119070, 200000, 'en_gros', 30, 1, 1, 0, NULL),
(393, '', 142, 0, 0, 0, 'en_gros', -4, 1, 1, 0, NULL),
(394, '', 97, 0, 13230, 30000, 'en_gros', 91, 1, 1, 0, NULL),
(395, '', 148, 0, 21168, 50000, 'en_gros', 39, 1, 1, 0, NULL),
(396, '', 1396, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(397, '', 937, 0, 60858, 90000, 'en_gros', 16, 1, 1, 0, NULL),
(398, '', 928, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(399, '', 940, 0, 66150, 0, 'en_gros', 26, 1, 1, 0, NULL),
(400, '', 943, 0, 58212, 0, 'en_gros', 21, 1, 1, 0, NULL),
(401, '', 946, 0, 58212, 130000, 'en_gros', 73, 1, 1, 0, NULL),
(402, '', 985, 0, 66150, 200000, 'en_gros', 53, 1, 1, 0, NULL),
(403, '', 988, 0, 66150, 200000, 'en_gros', 15, 1, 1, 0, NULL),
(404, '', 1000, 0, 145530, 200000, 'en_gros', 54, 1, 1, 0, NULL),
(405, '', 949, 0, 158760, 0, 'en_gros', 1, 1, 1, 0, NULL),
(406, '', 952, 0, 105840, 0, 'en_gros', 19, 1, 1, 0, NULL),
(407, '', 955, 0, 105840, 0, 'en_gros', 9, 1, 1, 0, NULL),
(408, '', 961, 0, 232848, 300000, 'en_gros', 27, 1, 1, 0, NULL),
(409, '', 958, 0, 232848, 300000, 'en_gros', 12, 1, 1, 0, NULL),
(410, '', 964, 0, 68796, 130000, 'en_gros', 20, 1, 1, 0, NULL),
(411, '', 931, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(412, '', 973, 0, 74088, 130000, 'en_gros', 39, 1, 1, 0, NULL),
(413, 'PR 410C', 976, 0, 66150, 200000, 'en_gros', 75, 1, 1, 0, NULL),
(414, '', 967, 0, 66150, 200000, 'en_gros', 6, 1, 1, 0, NULL),
(415, '', 970, 0, 298998, 400000, 'en_gros', 49, 1, 1, 0, NULL),
(416, '', 979, 0, 298998, 400000, 'en_gros', 12, 1, 1, 0, NULL),
(417, '', 997, 0, 52920, 130000, 'en_gros', 10, 1, 1, 0, NULL),
(418, '', 982, 0, 44982, 80000, 'en_gros', 21, 1, 1, 0, NULL),
(419, '', 991, 0, 44982, 80000, 'en_gros', 67, 1, 1, 0, NULL),
(420, '', 934, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(421, '', 139, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(422, '', 994, 0, 71442, 200000, 'en_gros', 15, 1, 1, 0, NULL),
(423, '', 529, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(424, '', 1042, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(425, '', 1087, 0, 185220, 250000, 'en_gros', 12, 1, 1, 0, NULL),
(426, '', 85, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(427, '', 88, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(428, '', 1084, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(429, '', 145, 0, 26460, 50000, 'en_gros', -2, 1, 1, 0, NULL),
(430, '', 151, 0, 87318, 150000, 'en_gros', 23, 1, 1, 0, NULL),
(431, '', 100, 0, 58212, 100000, 'en_gros', 66, 1, 1, 0, NULL),
(432, '', 382, 0, 584766, 800000, 'en_gros', 29, 1, 1, 0, NULL),
(433, '', 391, 0, 174636, 250000, 'en_gros', 17, 1, 1, 0, NULL),
(434, '', 385, 0, 280476, 500000, 'en_gros', 2, 1, 1, 0, NULL),
(435, '', 556, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(436, '', 196, 0, 2130030, 2700000, 'en_gros', 5, 1, 1, 0, NULL),
(437, '', 1027, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(438, '', 1111, 0, 11907, 30000, 'en_gros', 62, 1, 1, 0, NULL),
(439, '', 1108, 0, 31752, 50000, 'en_gros', 50, 1, 1, 0, NULL),
(440, '', 1114, 0, 87318, 50000, 'en_gros', 15, 1, 1, 0, NULL),
(441, '', 388, 0, 579474, 800000, 'en_gros', 25, 1, 1, 0, NULL),
(442, '', 403, 0, 206388, 250000, 'en_gros', 23, 1, 1, 0, NULL),
(443, '', 394, 0, 320166, 450000, 'en_gros', 19, 1, 1, 0, NULL),
(444, '', 1117, 0, 182574, 230000, 'en_gros', 17, 1, 1, 0, NULL),
(445, '', 1120, 0, 248724, 300000, 'en_gros', 15, 1, 1, 0, NULL),
(446, '', 1123, 0, 346626, 400000, 'en_gros', 20, 1, 1, 0, NULL),
(447, '', 1126, 0, 457758, 600000, 'en_gros', 10, 1, 1, 0, NULL),
(448, '', 1129, 0, 590058, 800000, 'en_gros', 10, 1, 1, 0, NULL),
(449, '', 115, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(450, '', 118, 0, 51597, 80000, 'en_gros', 38, 1, 1, 0, NULL),
(451, '', 121, 0, 60858, 100000, 'en_gros', 55, 1, 1, 0, NULL),
(452, '', 178, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(453, '', 124, 0, 312228, 400000, 'en_gros', 34, 1, 1, 0, NULL),
(454, '', 166, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(455, '', 1075, 0, 322812, 400000, 'en_gros', 17, 1, 1, 0, NULL),
(456, '', 1009, 0, 314874, 600000, 'en_gros', 2, 1, 1, 0, NULL),
(457, '', 1024, 0, 428652, 700000, 'en_gros', 4, 1, 1, 0, NULL),
(458, '', 1030, 0, 595350, 1000000, 'en_gros', 10, 1, 1, 0, NULL),
(459, '', 1036, 0, 166698, 190000, 'en_gros', 100, 1, 1, 0, NULL),
(460, '', 19, 0, 108486, 150000, 'en_gros', 11, 1, 1, -2, NULL),
(461, '', 22, 0, 41013, 80000, 'en_gros', 14, 1, 1, 0, NULL),
(462, '', 10, 0, 24872, 50000, 'en_gros', 66, 1, 1, 0, NULL),
(463, '', 1, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(464, '', 25, 0, 63504, 100000, 'en_gros', 28, 1, 1, 0, NULL),
(465, '', 28, 0, 34663, 80000, 'en_gros', 85, 1, 1, 0, NULL),
(466, '', 4, 0, 18522, 30000, 'en_gros', 61, 1, 1, 0, NULL),
(467, '', 31, 0, 97902, 150000, 'en_gros', 28, 1, 1, 0, NULL),
(468, '', 34, 0, 51597, 100000, 'en_gros', 27, 1, 1, 0, NULL),
(469, '', 37, 0, 62181, 120000, 'en_gros', 29, 1, 1, 0, NULL),
(470, '', 1393, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(471, '', 169, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(472, '', 172, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(473, '', 1033, 0, 3156680, 4000000, 'en_gros', 11, 1, 1, 0, NULL),
(474, '', 163, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `stock2`
--

DROP TABLE IF EXISTS `stock2`;
CREATE TABLE IF NOT EXISTS `stock2` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `codeb` varchar(100) DEFAULT NULL,
  `idprod` int(10) NOT NULL,
  `prix_achat` double DEFAULT '0',
  `prix_revient` double DEFAULT '0',
  `prix_vente` double DEFAULT '0',
  `type` varchar(20) DEFAULT NULL,
  `quantite` float DEFAULT '0',
  `qtiteintd` int(11) DEFAULT '0',
  `qtiteintp` int(11) DEFAULT '0',
  `nbrevente` float DEFAULT '0',
  `dateperemtion` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=468 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `stock2`
--

INSERT INTO `stock2` (`id`, `codeb`, `idprod`, `prix_achat`, `prix_revient`, `prix_vente`, `type`, `quantite`, `qtiteintd`, `qtiteintp`, `nbrevente`, `dateperemtion`) VALUES
(1, '', 1144, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(2, '', 586, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(3, '', 589, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(4, '', 577, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(5, '', 580, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(6, '', 592, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(7, '', 583, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(8, '', 604, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(9, '', 607, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(10, '', 610, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(11, '', 613, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(12, '', 1363, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(13, '', 1360, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(14, '', 1354, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(15, '', 1357, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(16, '', 595, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(17, '', 619, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(18, '', 598, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(19, '', 601, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(20, '', 616, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(21, '', 622, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(22, '', 625, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(23, '', 628, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(24, '', 631, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(25, '', 1351, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(26, '', 643, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(27, '', 646, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(28, '', 649, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(29, '', 652, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(30, '', 655, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(31, '', 658, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(32, '', 661, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(33, '', 664, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(34, '', 634, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(35, '', 670, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(36, '', 673, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(37, '', 676, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(38, '', 679, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(39, '', 637, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(40, '', 640, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(41, '', 688, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(42, '', 667, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(43, '', 682, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(44, '', 685, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(45, '', 175, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(46, '', 1012, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(47, '', 904, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(48, '', 43, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(49, '', 898, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(50, '', 907, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(51, '', 346, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(52, '', 349, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(53, '', 361, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(54, '', 364, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(55, '', 352, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(56, '', 397, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(57, '', 244, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(58, '', 40, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(59, '', 181, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(60, '', 1366, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(61, '', 46, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(62, '', 1345, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(63, '', 1348, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(64, '', 52, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(65, '', 49, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(66, '', 61, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(67, '', 709, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(68, '', 1312, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(69, '', 1327, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(70, '', 1330, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(71, '', 1333, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(72, '', 1336, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(73, '', 1342, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(74, '', 418, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(75, '', 421, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(76, '', 412, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(77, '', 430, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(78, '', 415, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(79, '', 541, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(80, '', 409, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(81, '', 565, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(82, '', 424, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(83, '', 1339, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(84, '', 568, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(85, '', 337, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(86, '', 340, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(87, '', 343, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(88, '', 400, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(89, '', 154, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(90, '', 58, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(91, '', 157, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(92, '', 160, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(93, '', 103, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(94, '', 106, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(95, '', 109, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(96, '', 112, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(97, '', 439, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(98, '', 67, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(99, '', 70, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(100, '', 1369, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(101, '', 211, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(102, '', 220, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(103, '', 214, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(104, '', 217, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(105, '', 127, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(106, '', 82, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(107, '', 55, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(108, '', 73, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(109, '', 724, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(110, '', 1090, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(111, '', 1078, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(112, '', 1081, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(113, '', 370, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(114, '', 373, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(115, '', 367, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(116, '', 355, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(117, '', 406, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(118, '', 193, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(119, '', 229, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(120, '', 253, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(121, '', 226, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(122, '', 232, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(123, '', 328, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(124, '', 331, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(125, '', 235, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(126, '', 238, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(127, '', 265, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(128, '', 733, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(129, '', 247, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(130, '', 241, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(131, '', 274, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(132, '', 736, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(133, '', 739, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(134, '', 742, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(135, '', 745, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(136, '', 715, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(137, '', 751, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(138, '', 754, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(139, '', 1102, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(140, '', 1093, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(141, '', 1045, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(142, '', 1048, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(143, '', 1051, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(144, '', 1054, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(145, '', 1057, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(146, '', 757, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(147, '', 1375, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(148, '', 130, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(149, '', 760, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(150, '', 766, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(151, '', 691, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(152, '', 712, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(153, '', 694, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(154, '', 544, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(155, '', 427, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(156, '', 433, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(157, '', 448, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(158, '', 445, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(159, '', 553, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(160, '', 436, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(161, '', 442, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(162, '', 748, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(163, '', 1372, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(164, '', 1015, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(165, '', 1003, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(166, '', 358, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(167, '', 376, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(168, '', 379, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(169, '', 94, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(170, '', 1378, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(171, '', 1387, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(172, '', 1390, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(173, '', 1399, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(174, '', 1381, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(175, '', 1384, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(176, '', 799, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(177, '', 721, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(178, '', 874, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(179, '', 796, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(180, '', 1135, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(181, '', 1138, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(182, '', 1141, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(183, '', 1147, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(184, '', 1150, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(185, '', 1153, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(186, '', 1156, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(187, '', 451, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(188, '', 1159, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(189, '', 1171, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(190, '', 1162, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(191, '', 1165, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(192, '', 1168, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(193, '', 1174, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(194, '', 1177, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(195, '', 1189, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(196, '', 1192, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(197, '', 1195, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(198, '', 1180, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(199, '', 472, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(200, '', 883, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(201, '', 1183, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(202, '', 1204, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(203, '', 1186, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(204, '', 1198, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(205, '', 1201, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(206, '', 1207, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(207, '', 1210, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(208, '', 1222, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(209, '', 1213, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(210, '', 1216, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(211, '', 1219, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(212, '', 1225, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(213, '', 1228, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(214, '', 1231, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(215, '', 1234, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(216, '', 1237, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(217, '', 1240, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(218, '', 1243, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(219, '', 1246, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(220, '', 697, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(221, '', 463, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(222, '', 1249, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(223, '', 1252, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(224, '', 1255, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(225, '', 1258, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(226, '', 700, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(227, '', 454, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(228, '', 787, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(229, '', 790, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(230, '', 457, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(231, '', 271, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(232, '', 334, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(233, '', 250, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(234, '', 1261, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(235, '', 1273, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(236, '', 1276, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(237, '', 1279, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(238, '', 283, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(239, '', 256, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(240, '', 259, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(241, '', 262, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(242, '', 1264, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(243, '', 1267, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(244, '', 1270, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(245, '', 1282, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(246, '', 1285, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(247, '', 1288, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(248, '', 1291, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(249, '', 1294, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(250, '', 1297, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(251, '', 1309, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(252, '', 1300, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(253, '', 295, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(254, '', 268, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(255, '', 460, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(256, '', 466, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(257, '', 1315, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(258, '', 1318, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(259, '', 1321, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(260, '', 1324, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(261, '', 478, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(262, '', 1132, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(263, '', 469, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(264, '', 301, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(265, '', 298, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(266, '', 277, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(267, '', 280, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(268, '', 190, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(269, '', 325, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(270, '', 307, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(271, '', 322, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(272, '', 310, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(273, '', 1303, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(274, '', 1306, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(275, '', 793, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(276, '', 802, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(277, '', 769, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(278, '', 775, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(279, '', 772, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(280, '', 778, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(281, '', 781, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(282, '', 784, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(283, '', 292, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(284, '', 304, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(285, '', 877, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(286, '', 880, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(287, '', 289, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(288, '', 316, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(289, '', 286, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(290, '', 319, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(291, '', 814, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(292, '', 805, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(293, '', 808, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(294, '', 823, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(295, '', 811, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(296, '', 817, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(297, '', 727, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(298, '', 730, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(299, '', 820, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(300, '', 826, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(301, '', 838, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(302, '', 829, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(303, '', 844, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(304, '', 1099, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(305, '', 1096, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(306, '', 13, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(307, '', 16, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(308, '', 847, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(309, '', 832, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(310, '', 841, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(311, '', 1039, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(312, '', 199, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(313, '', 202, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(314, '', 205, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(315, '', 208, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(316, '', 706, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(317, '', 703, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(318, '', 1066, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(319, '', 1069, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(320, '', 1072, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(321, '', 1060, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(322, '', 1063, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(323, '', 64, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(324, '', 76, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(325, '', 313, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(326, '', 856, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(327, '', 835, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(328, '', 850, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(329, '', 853, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(330, '', 868, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(331, '', 871, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(332, '', 718, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(333, '', 1018, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(334, '', 484, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(335, '', 481, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(336, '', 223, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(337, '', 1105, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(338, '', 187, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(339, '', 490, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(340, '', 493, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(341, '', 571, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(342, '', 574, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(343, '', 496, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(344, '', 499, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(345, '', 502, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(346, '', 475, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(347, '', 532, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(348, '', 487, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(349, '', 514, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(350, '', 517, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(351, '', 505, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(352, '', 523, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(353, '', 535, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(354, '', 538, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(355, '', 520, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(356, '', 526, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(357, '', 547, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(358, '', 559, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(359, '', 562, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(360, '', 550, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(361, '', 508, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(362, '', 511, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(363, '', 895, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(364, '', 901, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(365, '', 913, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(366, '', 910, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(367, '', 916, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(368, '', 919, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(369, '', 922, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(370, '', 925, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(371, '', 763, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(372, '', 859, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(373, '', 862, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(374, '', 865, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(375, '', 1021, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(376, '', 184, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(377, '', 91, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(378, '', 886, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(379, '', 889, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(380, '', 892, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(381, '', 133, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(382, '', 1006, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(383, '', 79, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(384, '', 136, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(385, '', 142, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(386, '', 97, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(387, '', 148, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(388, '', 1396, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(389, '', 937, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(390, '', 928, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(391, '', 940, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(392, '', 943, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(393, '', 946, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(394, '', 985, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(395, '', 988, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(396, '', 1000, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(397, '', 949, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(398, '', 952, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(399, '', 955, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(400, '', 961, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(401, '', 958, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(402, '', 964, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(403, '', 931, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(404, '', 973, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(405, 'PR 410C', 976, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(406, '', 967, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(407, '', 970, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(408, '', 979, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(409, '', 997, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(410, '', 982, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(411, '', 991, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(412, '', 934, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(413, '', 139, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(414, '', 994, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(415, '', 529, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(416, '', 1042, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(417, '', 1087, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(418, '', 85, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(419, '', 88, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(420, '', 1084, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(421, '', 145, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(422, '', 151, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(423, '', 100, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(424, '', 382, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(425, '', 391, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(426, '', 385, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(427, '', 556, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(428, '', 196, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(429, '', 1027, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(430, '', 1111, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(431, '', 1108, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(432, '', 1114, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(433, '', 388, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(434, '', 403, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(435, '', 394, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(436, '', 1117, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(437, '', 1120, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(438, '', 1123, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(439, '', 1126, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(440, '', 1129, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(441, '', 115, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(442, '', 118, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(443, '', 121, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(444, '', 178, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(445, '', 124, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(446, '', 166, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(447, '', 1075, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(448, '', 1009, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(449, '', 1024, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(450, '', 1030, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(451, '', 1036, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(452, '', 19, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(453, '', 7, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(454, '', 22, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(455, '', 10, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(456, '', 1, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(457, '', 25, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(458, '', 28, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(459, '', 4, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(460, '', 31, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(461, '', 34, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(462, '', 37, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(463, '', 1393, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(464, '', 169, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(465, '', 172, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(466, '', 1033, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL),
(467, '', 163, 0, 0, 0, 'en_gros', 0, 1, 1, 0, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `stockmouv`
--

DROP TABLE IF EXISTS `stockmouv`;
CREATE TABLE IF NOT EXISTS `stockmouv` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idstock` int(11) NOT NULL,
  `numeromouv` varchar(100) DEFAULT NULL,
  `libelle` varchar(150) NOT NULL,
  `quantitemouv` float NOT NULL,
  `idnomstock` int(11) NOT NULL,
  `dateop` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `coment` varchar(50) DEFAULT NULL,
  `idpers` int(11) DEFAULT '2',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=534 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `stockmouv`
--

INSERT INTO `stockmouv` (`id`, `idstock`, `numeromouv`, `libelle`, `quantitemouv`, `idnomstock`, `dateop`, `coment`, `idpers`) VALUES
(1, 202, 'livibe230082', 'sortie', -1, 1, '2023-07-27 12:12:26', NULL, 2),
(2, 202, 'livibe230083', 'sortie', -1, 1, '2023-07-27 12:48:53', NULL, 2),
(3, 202, 'livibe230085', 'sortie', -1, 1, '2023-07-27 13:08:50', NULL, 2),
(4, 229, 'livibe230086', 'sortie', -1, 1, '2023-08-20 10:19:41', NULL, 2),
(5, 202, 'livibe230087', 'sortie', -1, 1, '2023-08-27 18:01:17', NULL, 2),
(6, 202, 'livibe230088', 'sortie', -1, 1, '2023-08-27 18:03:56', NULL, 2),
(7, 220, 'livibe230089', 'sortie', -1, 1, '2023-09-02 11:11:36', NULL, 2),
(8, 349, 'livibe230089', 'sortie', -1, 1, '2023-09-02 11:11:36', NULL, 2),
(9, 220, 'livibe230090', 'sortie', 0, 1, '2023-09-02 13:01:31', NULL, 2),
(10, 253, 'livibe230090', 'sortie', 0, 1, '2023-09-02 13:01:31', NULL, 2),
(11, 1144, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(12, 586, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(13, 589, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(14, 577, 'ajust', 'ajustement', 72, 1, '2023-09-02 13:11:25', NULL, 2),
(15, 580, 'ajust', 'ajustement', 105, 1, '2023-09-02 13:11:25', NULL, 2),
(16, 592, 'ajust', 'ajustement', 197, 1, '2023-09-02 13:11:25', NULL, 2),
(17, 583, 'ajust', 'ajustement', 189, 1, '2023-09-02 13:11:25', NULL, 2),
(18, 604, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(19, 607, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(20, 610, 'ajust', 'ajustement', 138, 1, '2023-09-02 13:11:25', NULL, 2),
(21, 613, 'ajust', 'ajustement', 216, 1, '2023-09-02 13:11:25', NULL, 2),
(22, 1363, 'ajust', 'ajustement', 8, 1, '2023-09-02 13:11:25', NULL, 2),
(23, 1360, 'ajust', 'ajustement', 8, 1, '2023-09-02 13:11:25', NULL, 2),
(24, 1354, 'ajust', 'ajustement', 13, 1, '2023-09-02 13:11:25', NULL, 2),
(25, 1357, 'ajust', 'ajustement', 8, 1, '2023-09-02 13:11:25', NULL, 2),
(26, 595, 'ajust', 'ajustement', 62, 1, '2023-09-02 13:11:25', NULL, 2),
(27, 619, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(28, 598, 'ajust', 'ajustement', 79, 1, '2023-09-02 13:11:25', NULL, 2),
(29, 601, 'ajust', 'ajustement', 2, 1, '2023-09-02 13:11:25', NULL, 2),
(30, 616, 'ajust', 'ajustement', 1, 1, '2023-09-02 13:11:25', NULL, 2),
(31, 622, 'ajust', 'ajustement', 71, 1, '2023-09-02 13:11:25', NULL, 2),
(32, 625, 'ajust', 'ajustement', 117, 1, '2023-09-02 13:11:25', NULL, 2),
(33, 628, 'ajust', 'ajustement', 56, 1, '2023-09-02 13:11:25', NULL, 2),
(34, 631, 'ajust', 'ajustement', 49, 1, '2023-09-02 13:11:25', NULL, 2),
(35, 1351, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(36, 643, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(37, 646, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(38, 649, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(39, 652, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(40, 655, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(41, 658, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(42, 661, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(43, 664, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(44, 634, 'ajust', 'ajustement', 1, 1, '2023-09-02 13:11:25', NULL, 2),
(45, 670, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(46, 673, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(47, 676, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(48, 679, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(49, 637, 'ajust', 'ajustement', 71, 1, '2023-09-02 13:11:25', NULL, 2),
(50, 640, 'ajust', 'ajustement', 45, 1, '2023-09-02 13:11:25', NULL, 2),
(51, 688, 'ajust', 'ajustement', 31, 1, '2023-09-02 13:11:25', NULL, 2),
(52, 667, 'ajust', 'ajustement', 27, 1, '2023-09-02 13:11:25', NULL, 2),
(53, 682, 'ajust', 'ajustement', 41, 1, '2023-09-02 13:11:25', NULL, 2),
(54, 685, 'ajust', 'ajustement', 46, 1, '2023-09-02 13:11:25', NULL, 2),
(55, 175, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(56, 1012, 'ajust', 'ajustement', 3, 1, '2023-09-02 13:11:25', NULL, 2),
(57, 904, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(58, 43, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(59, 898, 'ajust', 'ajustement', 10, 1, '2023-09-02 13:11:25', NULL, 2),
(60, 907, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(61, 346, 'ajust', 'ajustement', 1, 1, '2023-09-02 13:11:25', NULL, 2),
(62, 349, 'ajust', 'ajustement', 19, 1, '2023-09-02 13:11:25', NULL, 2),
(63, 361, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(64, 364, 'ajust', 'ajustement', 40, 1, '2023-09-02 13:11:25', NULL, 2),
(65, 352, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(66, 397, 'ajust', 'ajustement', 10, 1, '2023-09-02 13:11:25', NULL, 2),
(67, 244, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(68, 40, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(69, 181, 'ajust', 'ajustement', 46, 1, '2023-09-02 13:11:25', NULL, 2),
(70, 1366, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(71, 46, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(72, 1345, 'ajust', 'ajustement', 5, 1, '2023-09-02 13:11:25', NULL, 2),
(73, 1348, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(74, 52, 'ajust', 'ajustement', -1, 1, '2023-09-02 13:11:25', NULL, 2),
(75, 49, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(76, 61, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(77, 709, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(78, 1312, 'ajust', 'ajustement', 50, 1, '2023-09-02 13:11:25', NULL, 2),
(79, 1327, 'ajust', 'ajustement', 12, 1, '2023-09-02 13:11:25', NULL, 2),
(80, 1330, 'ajust', 'ajustement', 5, 1, '2023-09-02 13:11:25', NULL, 2),
(81, 1333, 'ajust', 'ajustement', 13, 1, '2023-09-02 13:11:25', NULL, 2),
(82, 1336, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(83, 1342, 'ajust', 'ajustement', 18, 1, '2023-09-02 13:11:25', NULL, 2),
(84, 7, 'ajust', 'ajustement', 42, 1, '2023-09-02 13:11:25', NULL, 2),
(85, 418, 'ajust', 'ajustement', 2, 1, '2023-09-02 13:11:25', NULL, 2),
(86, 421, 'ajust', 'ajustement', 7, 1, '2023-09-02 13:11:25', NULL, 2),
(87, 412, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(88, 430, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(89, 415, 'ajust', 'ajustement', 4, 1, '2023-09-02 13:11:25', NULL, 2),
(90, 541, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(91, 409, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(92, 565, 'ajust', 'ajustement', 3, 1, '2023-09-02 13:11:25', NULL, 2),
(93, 424, 'ajust', 'ajustement', 2, 1, '2023-09-02 13:11:25', NULL, 2),
(94, 1339, 'ajust', 'ajustement', 9, 1, '2023-09-02 13:11:25', NULL, 2),
(95, 568, 'ajust', 'ajustement', 5, 1, '2023-09-02 13:11:25', NULL, 2),
(96, 337, 'ajust', 'ajustement', 104, 1, '2023-09-02 13:11:25', NULL, 2),
(97, 340, 'ajust', 'ajustement', 51, 1, '2023-09-02 13:11:25', NULL, 2),
(98, 343, 'ajust', 'ajustement', 13, 1, '2023-09-02 13:11:25', NULL, 2),
(99, 400, 'ajust', 'ajustement', 11, 1, '2023-09-02 13:11:25', NULL, 2),
(100, 154, 'ajust', 'ajustement', 46, 1, '2023-09-02 13:11:25', NULL, 2),
(101, 58, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(102, 157, 'ajust', 'ajustement', 40, 1, '2023-09-02 13:11:25', NULL, 2),
(103, 160, 'ajust', 'ajustement', 10, 1, '2023-09-02 13:11:25', NULL, 2),
(104, 103, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(105, 106, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(106, 109, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(107, 112, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(108, 439, 'ajust', 'ajustement', 4, 1, '2023-09-02 13:11:25', NULL, 2),
(109, 67, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(110, 70, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(111, 1369, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(112, 211, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(113, 220, 'ajust', 'ajustement', 54, 1, '2023-09-02 13:11:25', NULL, 2),
(114, 214, 'ajust', 'ajustement', 10, 1, '2023-09-02 13:11:25', NULL, 2),
(115, 217, 'ajust', 'ajustement', 77, 1, '2023-09-02 13:11:25', NULL, 2),
(116, 127, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(117, 82, 'ajust', 'ajustement', 5, 1, '2023-09-02 13:11:25', NULL, 2),
(118, 55, 'ajust', 'ajustement', 21, 1, '2023-09-02 13:11:25', NULL, 2),
(119, 73, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(120, 724, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(121, 1090, 'ajust', 'ajustement', 9, 1, '2023-09-02 13:11:25', NULL, 2),
(122, 1078, 'ajust', 'ajustement', 36, 1, '2023-09-02 13:11:25', NULL, 2),
(123, 1081, 'ajust', 'ajustement', 5, 1, '2023-09-02 13:11:25', NULL, 2),
(124, 370, 'ajust', 'ajustement', 65, 1, '2023-09-02 13:11:25', NULL, 2),
(125, 373, 'ajust', 'ajustement', 4, 1, '2023-09-02 13:11:25', NULL, 2),
(126, 367, 'ajust', 'ajustement', 6, 1, '2023-09-02 13:11:25', NULL, 2),
(127, 355, 'ajust', 'ajustement', 2, 1, '2023-09-02 13:11:25', NULL, 2),
(128, 406, 'ajust', 'ajustement', 12, 1, '2023-09-02 13:11:25', NULL, 2),
(129, 193, 'ajust', 'ajustement', 18, 1, '2023-09-02 13:11:25', NULL, 2),
(130, 229, 'ajust', 'ajustement', 2, 1, '2023-09-02 13:11:25', NULL, 2),
(131, 253, 'ajust', 'ajustement', 8, 1, '2023-09-02 13:11:25', NULL, 2),
(132, 226, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(133, 232, 'ajust', 'ajustement', 1, 1, '2023-09-02 13:11:25', NULL, 2),
(134, 328, 'ajust', 'ajustement', 20, 1, '2023-09-02 13:11:25', NULL, 2),
(135, 331, 'ajust', 'ajustement', 11, 1, '2023-09-02 13:11:25', NULL, 2),
(136, 235, 'ajust', 'ajustement', 37, 1, '2023-09-02 13:11:25', NULL, 2),
(137, 238, 'ajust', 'ajustement', 14, 1, '2023-09-02 13:11:25', NULL, 2),
(138, 265, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(139, 733, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(140, 247, 'ajust', 'ajustement', 73, 1, '2023-09-02 13:11:25', NULL, 2),
(141, 241, 'ajust', 'ajustement', 10, 1, '2023-09-02 13:11:25', NULL, 2),
(142, 274, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(143, 736, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(144, 739, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(145, 742, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(146, 745, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(147, 715, 'ajust', 'ajustement', 1, 1, '2023-09-02 13:11:25', NULL, 2),
(148, 751, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(149, 754, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(150, 1102, 'ajust', 'ajustement', 3, 1, '2023-09-02 13:11:25', NULL, 2),
(151, 1093, 'ajust', 'ajustement', 16, 1, '2023-09-02 13:11:25', NULL, 2),
(152, 1045, 'ajust', 'ajustement', 14, 1, '2023-09-02 13:11:25', NULL, 2),
(153, 1048, 'ajust', 'ajustement', 49, 1, '2023-09-02 13:11:25', NULL, 2),
(154, 1051, 'ajust', 'ajustement', 5, 1, '2023-09-02 13:11:25', NULL, 2),
(155, 1054, 'ajust', 'ajustement', 24, 1, '2023-09-02 13:11:25', NULL, 2),
(156, 1057, 'ajust', 'ajustement', 16, 1, '2023-09-02 13:11:25', NULL, 2),
(157, 757, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(158, 1375, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(159, 130, 'ajust', 'ajustement', 43, 1, '2023-09-02 13:11:25', NULL, 2),
(160, 760, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(161, 766, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(162, 1405, 'ajust', 'ajustement', 85, 1, '2023-09-02 13:11:25', NULL, 2),
(163, 1403, 'ajust', 'ajustement', 90, 1, '2023-09-02 13:11:25', NULL, 2),
(164, 691, 'ajust', 'ajustement', 60, 1, '2023-09-02 13:11:25', NULL, 2),
(165, 1406, 'ajust', 'ajustement', 86, 1, '2023-09-02 13:11:25', NULL, 2),
(166, 712, 'ajust', 'ajustement', 90, 1, '2023-09-02 13:11:25', NULL, 2),
(167, 694, 'ajust', 'ajustement', 207, 1, '2023-09-02 13:11:25', NULL, 2),
(168, 544, 'ajust', 'ajustement', 4, 1, '2023-09-02 13:11:25', NULL, 2),
(169, 427, 'ajust', 'ajustement', 55, 1, '2023-09-02 13:11:25', NULL, 2),
(170, 433, 'ajust', 'ajustement', 31, 1, '2023-09-02 13:11:25', NULL, 2),
(171, 448, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(172, 445, 'ajust', 'ajustement', 10, 1, '2023-09-02 13:11:25', NULL, 2),
(173, 553, 'ajust', 'ajustement', 5, 1, '2023-09-02 13:11:25', NULL, 2),
(174, 436, 'ajust', 'ajustement', 3, 1, '2023-09-02 13:11:25', NULL, 2),
(175, 442, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(176, 748, 'ajust', 'ajustement', 8, 1, '2023-09-02 13:11:25', NULL, 2),
(177, 1372, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(178, 1015, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(179, 1003, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(180, 358, 'ajust', 'ajustement', 42, 1, '2023-09-02 13:11:25', NULL, 2),
(181, 376, 'ajust', 'ajustement', 3, 1, '2023-09-02 13:11:25', NULL, 2),
(182, 379, 'ajust', 'ajustement', 30, 1, '2023-09-02 13:11:25', NULL, 2),
(183, 94, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(184, 1378, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(185, 1387, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(186, 1390, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(187, 1399, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(188, 1381, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(189, 1384, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(190, 799, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(191, 721, 'ajust', 'ajustement', 1, 1, '2023-09-02 13:11:25', NULL, 2),
(192, 874, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(193, 796, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(194, 1135, 'ajust', 'ajustement', 7, 1, '2023-09-02 13:11:25', NULL, 2),
(195, 1138, 'ajust', 'ajustement', 15, 1, '2023-09-02 13:11:25', NULL, 2),
(196, 1141, 'ajust', 'ajustement', 16, 1, '2023-09-02 13:11:25', NULL, 2),
(197, 1147, 'ajust', 'ajustement', 22, 1, '2023-09-02 13:11:25', NULL, 2),
(198, 1150, 'ajust', 'ajustement', 14, 1, '2023-09-02 13:11:25', NULL, 2),
(199, 1153, 'ajust', 'ajustement', 17, 1, '2023-09-02 13:11:25', NULL, 2),
(200, 1156, 'ajust', 'ajustement', 21, 1, '2023-09-02 13:11:25', NULL, 2),
(201, 451, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(202, 1159, 'ajust', 'ajustement', 4, 1, '2023-09-02 13:11:25', NULL, 2),
(203, 1171, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(204, 1162, 'ajust', 'ajustement', 15, 1, '2023-09-02 13:11:25', NULL, 2),
(205, 1165, 'ajust', 'ajustement', 5, 1, '2023-09-02 13:11:25', NULL, 2),
(206, 1168, 'ajust', 'ajustement', 5, 1, '2023-09-02 13:11:25', NULL, 2),
(207, 1174, 'ajust', 'ajustement', 11, 1, '2023-09-02 13:11:25', NULL, 2),
(208, 1177, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(209, 1189, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(210, 1192, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(211, 1195, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(212, 1180, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(213, 472, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(214, 883, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(215, 1183, 'ajust', 'ajustement', 36, 1, '2023-09-02 13:11:25', NULL, 2),
(216, 1204, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(217, 1186, 'ajust', 'ajustement', 8, 1, '2023-09-02 13:11:25', NULL, 2),
(218, 1198, 'ajust', 'ajustement', 22, 1, '2023-09-02 13:11:25', NULL, 2),
(219, 1201, 'ajust', 'ajustement', 19, 1, '2023-09-02 13:11:25', NULL, 2),
(220, 1207, 'ajust', 'ajustement', 20, 1, '2023-09-02 13:11:25', NULL, 2),
(221, 1210, 'ajust', 'ajustement', 23, 1, '2023-09-02 13:11:25', NULL, 2),
(222, 1222, 'ajust', 'ajustement', 17, 1, '2023-09-02 13:11:25', NULL, 2),
(223, 1213, 'ajust', 'ajustement', 16, 1, '2023-09-02 13:11:25', NULL, 2),
(224, 1216, 'ajust', 'ajustement', 26, 1, '2023-09-02 13:11:25', NULL, 2),
(225, 1219, 'ajust', 'ajustement', 28, 1, '2023-09-02 13:11:25', NULL, 2),
(226, 1225, 'ajust', 'ajustement', 23, 1, '2023-09-02 13:11:25', NULL, 2),
(227, 1228, 'ajust', 'ajustement', 27, 1, '2023-09-02 13:11:25', NULL, 2),
(228, 1231, 'ajust', 'ajustement', 19, 1, '2023-09-02 13:11:25', NULL, 2),
(229, 1234, 'ajust', 'ajustement', 27, 1, '2023-09-02 13:11:25', NULL, 2),
(230, 1237, 'ajust', 'ajustement', 8, 1, '2023-09-02 13:11:25', NULL, 2),
(231, 1240, 'ajust', 'ajustement', 12, 1, '2023-09-02 13:11:25', NULL, 2),
(232, 1243, 'ajust', 'ajustement', 16, 1, '2023-09-02 13:11:25', NULL, 2),
(233, 1246, 'ajust', 'ajustement', 14, 1, '2023-09-02 13:11:25', NULL, 2),
(234, 697, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(235, 463, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(236, 1249, 'ajust', 'ajustement', 26, 1, '2023-09-02 13:11:25', NULL, 2),
(237, 1252, 'ajust', 'ajustement', 28, 1, '2023-09-02 13:11:25', NULL, 2),
(238, 1255, 'ajust', 'ajustement', 47, 1, '2023-09-02 13:11:25', NULL, 2),
(239, 1258, 'ajust', 'ajustement', 28, 1, '2023-09-02 13:11:25', NULL, 2),
(240, 700, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(241, 454, 'ajust', 'ajustement', 26, 1, '2023-09-02 13:11:25', NULL, 2),
(242, 787, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(243, 790, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(244, 457, 'ajust', 'ajustement', 20, 1, '2023-09-02 13:11:25', NULL, 2),
(245, 1409, 'ajust', 'ajustement', 4, 1, '2023-09-02 13:11:25', NULL, 2),
(246, 271, 'ajust', 'ajustement', 14, 1, '2023-09-02 13:11:25', NULL, 2),
(247, 334, 'ajust', 'ajustement', 21, 1, '2023-09-02 13:11:25', NULL, 2),
(248, 250, 'ajust', 'ajustement', 1, 1, '2023-09-02 13:11:25', NULL, 2),
(249, 1261, 'ajust', 'ajustement', 16, 1, '2023-09-02 13:11:25', NULL, 2),
(250, 1273, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(251, 1276, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(252, 1279, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(253, 283, 'ajust', 'ajustement', 16, 1, '2023-09-02 13:11:25', NULL, 2),
(254, 256, 'ajust', 'ajustement', 27, 1, '2023-09-02 13:11:25', NULL, 2),
(255, 259, 'ajust', 'ajustement', 40, 1, '2023-09-02 13:11:25', NULL, 2),
(256, 262, 'ajust', 'ajustement', 27, 1, '2023-09-02 13:11:25', NULL, 2),
(257, 1264, 'ajust', 'ajustement', 26, 1, '2023-09-02 13:11:25', NULL, 2),
(258, 1267, 'ajust', 'ajustement', 28, 1, '2023-09-02 13:11:25', NULL, 2),
(259, 1270, 'ajust', 'ajustement', 23, 1, '2023-09-02 13:11:25', NULL, 2),
(260, 1282, 'ajust', 'ajustement', 37, 1, '2023-09-02 13:11:25', NULL, 2),
(261, 1285, 'ajust', 'ajustement', 27, 1, '2023-09-02 13:11:25', NULL, 2),
(262, 1288, 'ajust', 'ajustement', 19, 1, '2023-09-02 13:11:25', NULL, 2),
(263, 1291, 'ajust', 'ajustement', 34, 1, '2023-09-02 13:11:25', NULL, 2),
(264, 1294, 'ajust', 'ajustement', 27, 1, '2023-09-02 13:11:25', NULL, 2),
(265, 1297, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(266, 1309, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(267, 1300, 'ajust', 'ajustement', 19, 1, '2023-09-02 13:11:25', NULL, 2),
(268, 295, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(269, 268, 'ajust', 'ajustement', 1, 1, '2023-09-02 13:11:25', NULL, 2),
(270, 460, 'ajust', 'ajustement', 10, 1, '2023-09-02 13:11:25', NULL, 2),
(271, 466, 'ajust', 'ajustement', 6, 1, '2023-09-02 13:11:25', NULL, 2),
(272, 1315, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(273, 1318, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(274, 1321, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(275, 1324, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(276, 478, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(277, 1132, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(278, 469, 'ajust', 'ajustement', 8, 1, '2023-09-02 13:11:25', NULL, 2),
(279, 301, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(280, 298, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(281, 277, 'ajust', 'ajustement', 10, 1, '2023-09-02 13:11:25', NULL, 2),
(282, 280, 'ajust', 'ajustement', 29, 1, '2023-09-02 13:11:25', NULL, 2),
(283, 190, 'ajust', 'ajustement', 3, 1, '2023-09-02 13:11:25', NULL, 2),
(284, 325, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(285, 307, 'ajust', 'ajustement', 10, 1, '2023-09-02 13:11:25', NULL, 2),
(286, 322, 'ajust', 'ajustement', 5, 1, '2023-09-02 13:11:25', NULL, 2),
(287, 310, 'ajust', 'ajustement', 3, 1, '2023-09-02 13:11:25', NULL, 2),
(288, 1303, 'ajust', 'ajustement', 16, 1, '2023-09-02 13:11:25', NULL, 2),
(289, 1306, 'ajust', 'ajustement', 1, 1, '2023-09-02 13:11:25', NULL, 2),
(290, 793, 'ajust', 'ajustement', 18, 1, '2023-09-02 13:11:25', NULL, 2),
(291, 802, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(292, 769, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(293, 775, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(294, 772, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(295, 778, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(296, 781, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(297, 784, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(298, 292, 'ajust', 'ajustement', 5, 1, '2023-09-02 13:11:25', NULL, 2),
(299, 304, 'ajust', 'ajustement', 12, 1, '2023-09-02 13:11:25', NULL, 2),
(300, 877, 'ajust', 'ajustement', 2, 1, '2023-09-02 13:11:25', NULL, 2),
(301, 880, 'ajust', 'ajustement', 3, 1, '2023-09-02 13:11:25', NULL, 2),
(302, 289, 'ajust', 'ajustement', 140, 1, '2023-09-02 13:11:25', NULL, 2),
(303, 316, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(304, 286, 'ajust', 'ajustement', 3, 1, '2023-09-02 13:11:25', NULL, 2),
(305, 319, 'ajust', 'ajustement', 4, 1, '2023-09-02 13:11:25', NULL, 2),
(306, 814, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(307, 805, 'ajust', 'ajustement', 7, 1, '2023-09-02 13:11:25', NULL, 2),
(308, 808, 'ajust', 'ajustement', 4, 1, '2023-09-02 13:11:25', NULL, 2),
(309, 823, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(310, 811, 'ajust', 'ajustement', 5, 1, '2023-09-02 13:11:25', NULL, 2),
(311, 817, 'ajust', 'ajustement', 6, 1, '2023-09-02 13:11:25', NULL, 2),
(312, 727, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(313, 730, 'ajust', 'ajustement', 1, 1, '2023-09-02 13:11:25', NULL, 2),
(314, 820, 'ajust', 'ajustement', 6, 1, '2023-09-02 13:11:25', NULL, 2),
(315, 826, 'ajust', 'ajustement', 4, 1, '2023-09-02 13:11:25', NULL, 2),
(316, 838, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(317, 829, 'ajust', 'ajustement', 2, 1, '2023-09-02 13:11:25', NULL, 2),
(318, 844, 'ajust', 'ajustement', 3, 1, '2023-09-02 13:11:25', NULL, 2),
(319, 1408, 'ajust', 'ajustement', 7, 1, '2023-09-02 13:11:25', NULL, 2),
(320, 559, 'ajust', 'ajustement', 2, 1, '2023-09-02 13:11:25', NULL, 2),
(321, 562, 'ajust', 'ajustement', 3, 1, '2023-09-02 13:11:25', NULL, 2),
(322, 1099, 'ajust', 'ajustement', 52, 1, '2023-09-02 13:11:25', NULL, 2),
(323, 1096, 'ajust', 'ajustement', 41, 1, '2023-09-02 13:11:25', NULL, 2),
(324, 13, 'ajust', 'ajustement', 27, 1, '2023-09-02 13:11:25', NULL, 2),
(325, 16, 'ajust', 'ajustement', 26, 1, '2023-09-02 13:11:25', NULL, 2),
(326, 847, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(327, 832, 'ajust', 'ajustement', 2, 1, '2023-09-02 13:11:25', NULL, 2),
(328, 841, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(329, 1039, 'ajust', 'ajustement', 56, 1, '2023-09-02 13:11:25', NULL, 2),
(330, 199, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(331, 202, 'ajust', 'ajustement', 7, 1, '2023-09-02 13:11:25', NULL, 2),
(332, 205, 'ajust', 'ajustement', 75, 1, '2023-09-02 13:11:25', NULL, 2),
(333, 208, 'ajust', 'ajustement', 65, 1, '2023-09-02 13:11:25', NULL, 2),
(334, 706, 'ajust', 'ajustement', 87, 1, '2023-09-02 13:11:25', NULL, 2),
(335, 703, 'ajust', 'ajustement', 33, 1, '2023-09-02 13:11:25', NULL, 2),
(336, 1066, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(337, 1069, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(338, 1072, 'ajust', 'ajustement', 11, 1, '2023-09-02 13:11:25', NULL, 2),
(339, 1060, 'ajust', 'ajustement', 24, 1, '2023-09-02 13:11:25', NULL, 2),
(340, 1063, 'ajust', 'ajustement', 20, 1, '2023-09-02 13:11:25', NULL, 2),
(341, 64, 'ajust', 'ajustement', 8, 1, '2023-09-02 13:11:25', NULL, 2),
(342, 76, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(343, 313, 'ajust', 'ajustement', 4, 1, '2023-09-02 13:11:25', NULL, 2),
(344, 856, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(345, 835, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(346, 850, 'ajust', 'ajustement', 1, 1, '2023-09-02 13:11:25', NULL, 2),
(347, 853, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(348, 868, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(349, 871, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(350, 718, 'ajust', 'ajustement', 8, 1, '2023-09-02 13:11:25', NULL, 2),
(351, 1018, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(352, 484, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(353, 481, 'ajust', 'ajustement', 20, 1, '2023-09-02 13:11:25', NULL, 2),
(354, 223, 'ajust', 'ajustement', 70, 1, '2023-09-02 13:11:25', NULL, 2),
(355, 1105, 'ajust', 'ajustement', 55, 1, '2023-09-02 13:11:25', NULL, 2),
(356, 187, 'ajust', 'ajustement', 8, 1, '2023-09-02 13:11:25', NULL, 2),
(357, 490, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(358, 493, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(359, 571, 'ajust', 'ajustement', 20, 1, '2023-09-02 13:11:25', NULL, 2),
(360, 574, 'ajust', 'ajustement', 5, 1, '2023-09-02 13:11:25', NULL, 2),
(361, 496, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(362, 499, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(363, 502, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(364, 1404, 'ajust', 'ajustement', 4, 1, '2023-09-02 13:11:25', NULL, 2),
(365, 475, 'ajust', 'ajustement', 5, 1, '2023-09-02 13:11:25', NULL, 2),
(366, 532, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(367, 487, 'ajust', 'ajustement', 22, 1, '2023-09-02 13:11:25', NULL, 2),
(368, 514, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(369, 517, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(370, 505, 'ajust', 'ajustement', 2, 1, '2023-09-02 13:11:25', NULL, 2),
(371, 523, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(372, 535, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(373, 538, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(374, 520, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(375, 526, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(376, 547, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(377, 550, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(378, 508, 'ajust', 'ajustement', 2, 1, '2023-09-02 13:11:25', NULL, 2),
(379, 511, 'ajust', 'ajustement', 5, 1, '2023-09-02 13:11:25', NULL, 2),
(380, 1407, 'ajust', 'ajustement', 12, 1, '2023-09-02 13:11:25', NULL, 2),
(381, 895, 'ajust', 'ajustement', 45, 1, '2023-09-02 13:11:25', NULL, 2),
(382, 901, 'ajust', 'ajustement', 1, 1, '2023-09-02 13:11:25', NULL, 2),
(383, 913, 'ajust', 'ajustement', 37, 1, '2023-09-02 13:11:25', NULL, 2),
(384, 910, 'ajust', 'ajustement', 7, 1, '2023-09-02 13:11:25', NULL, 2),
(385, 916, 'ajust', 'ajustement', 16, 1, '2023-09-02 13:11:25', NULL, 2),
(386, 919, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(387, 922, 'ajust', 'ajustement', 40, 1, '2023-09-02 13:11:25', NULL, 2),
(388, 925, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(389, 763, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(390, 859, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(391, 862, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(392, 865, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(393, 1021, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(394, 184, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(395, 91, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(396, 886, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(397, 889, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(398, 892, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(399, 133, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(400, 1006, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(401, 79, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(402, 136, 'ajust', 'ajustement', 30, 1, '2023-09-02 13:11:25', NULL, 2),
(403, 142, 'ajust', 'ajustement', -4, 1, '2023-09-02 13:11:25', NULL, 2),
(404, 97, 'ajust', 'ajustement', 91, 1, '2023-09-02 13:11:25', NULL, 2),
(405, 148, 'ajust', 'ajustement', 39, 1, '2023-09-02 13:11:25', NULL, 2),
(406, 1396, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(407, 937, 'ajust', 'ajustement', 16, 1, '2023-09-02 13:11:25', NULL, 2),
(408, 928, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(409, 940, 'ajust', 'ajustement', 26, 1, '2023-09-02 13:11:25', NULL, 2),
(410, 943, 'ajust', 'ajustement', 21, 1, '2023-09-02 13:11:25', NULL, 2),
(411, 946, 'ajust', 'ajustement', 73, 1, '2023-09-02 13:11:25', NULL, 2),
(412, 985, 'ajust', 'ajustement', 53, 1, '2023-09-02 13:11:25', NULL, 2),
(413, 988, 'ajust', 'ajustement', 15, 1, '2023-09-02 13:11:25', NULL, 2),
(414, 1000, 'ajust', 'ajustement', 54, 1, '2023-09-02 13:11:25', NULL, 2),
(415, 949, 'ajust', 'ajustement', 1, 1, '2023-09-02 13:11:25', NULL, 2),
(416, 952, 'ajust', 'ajustement', 19, 1, '2023-09-02 13:11:25', NULL, 2),
(417, 955, 'ajust', 'ajustement', 9, 1, '2023-09-02 13:11:25', NULL, 2),
(418, 961, 'ajust', 'ajustement', 27, 1, '2023-09-02 13:11:25', NULL, 2),
(419, 958, 'ajust', 'ajustement', 12, 1, '2023-09-02 13:11:25', NULL, 2),
(420, 964, 'ajust', 'ajustement', 20, 1, '2023-09-02 13:11:25', NULL, 2),
(421, 931, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(422, 973, 'ajust', 'ajustement', 39, 1, '2023-09-02 13:11:25', NULL, 2),
(423, 976, 'ajust', 'ajustement', 75, 1, '2023-09-02 13:11:25', NULL, 2),
(424, 967, 'ajust', 'ajustement', 6, 1, '2023-09-02 13:11:25', NULL, 2),
(425, 970, 'ajust', 'ajustement', 49, 1, '2023-09-02 13:11:25', NULL, 2),
(426, 979, 'ajust', 'ajustement', 12, 1, '2023-09-02 13:11:25', NULL, 2),
(427, 997, 'ajust', 'ajustement', 10, 1, '2023-09-02 13:11:25', NULL, 2),
(428, 982, 'ajust', 'ajustement', 21, 1, '2023-09-02 13:11:25', NULL, 2),
(429, 991, 'ajust', 'ajustement', 67, 1, '2023-09-02 13:11:25', NULL, 2),
(430, 934, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(431, 139, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(432, 994, 'ajust', 'ajustement', 15, 1, '2023-09-02 13:11:25', NULL, 2),
(433, 529, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(434, 1042, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(435, 1087, 'ajust', 'ajustement', 12, 1, '2023-09-02 13:11:25', NULL, 2),
(436, 85, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(437, 88, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(438, 1084, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(439, 145, 'ajust', 'ajustement', -2, 1, '2023-09-02 13:11:25', NULL, 2),
(440, 151, 'ajust', 'ajustement', 23, 1, '2023-09-02 13:11:25', NULL, 2),
(441, 100, 'ajust', 'ajustement', 66, 1, '2023-09-02 13:11:25', NULL, 2),
(442, 382, 'ajust', 'ajustement', 29, 1, '2023-09-02 13:11:25', NULL, 2),
(443, 391, 'ajust', 'ajustement', 17, 1, '2023-09-02 13:11:25', NULL, 2),
(444, 385, 'ajust', 'ajustement', 2, 1, '2023-09-02 13:11:25', NULL, 2),
(445, 556, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(446, 196, 'ajust', 'ajustement', 5, 1, '2023-09-02 13:11:25', NULL, 2),
(447, 1027, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(448, 1111, 'ajust', 'ajustement', 62, 1, '2023-09-02 13:11:25', NULL, 2),
(449, 1108, 'ajust', 'ajustement', 50, 1, '2023-09-02 13:11:25', NULL, 2),
(450, 1114, 'ajust', 'ajustement', 15, 1, '2023-09-02 13:11:25', NULL, 2),
(451, 388, 'ajust', 'ajustement', 25, 1, '2023-09-02 13:11:25', NULL, 2),
(452, 403, 'ajust', 'ajustement', 23, 1, '2023-09-02 13:11:25', NULL, 2),
(453, 394, 'ajust', 'ajustement', 19, 1, '2023-09-02 13:11:25', NULL, 2),
(454, 1117, 'ajust', 'ajustement', 17, 1, '2023-09-02 13:11:25', NULL, 2),
(455, 1120, 'ajust', 'ajustement', 15, 1, '2023-09-02 13:11:25', NULL, 2),
(456, 1123, 'ajust', 'ajustement', 20, 1, '2023-09-02 13:11:25', NULL, 2),
(457, 1126, 'ajust', 'ajustement', 10, 1, '2023-09-02 13:11:25', NULL, 2),
(458, 1129, 'ajust', 'ajustement', 10, 1, '2023-09-02 13:11:25', NULL, 2),
(459, 115, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(460, 118, 'ajust', 'ajustement', 38, 1, '2023-09-02 13:11:25', NULL, 2),
(461, 121, 'ajust', 'ajustement', 55, 1, '2023-09-02 13:11:25', NULL, 2),
(462, 178, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(463, 124, 'ajust', 'ajustement', 34, 1, '2023-09-02 13:11:25', NULL, 2),
(464, 166, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(465, 1075, 'ajust', 'ajustement', 17, 1, '2023-09-02 13:11:25', NULL, 2),
(466, 1009, 'ajust', 'ajustement', 2, 1, '2023-09-02 13:11:25', NULL, 2),
(467, 1024, 'ajust', 'ajustement', 4, 1, '2023-09-02 13:11:25', NULL, 2),
(468, 1030, 'ajust', 'ajustement', 10, 1, '2023-09-02 13:11:25', NULL, 2),
(469, 1036, 'ajust', 'ajustement', 100, 1, '2023-09-02 13:11:25', NULL, 2),
(470, 19, 'ajust', 'ajustement', 11, 1, '2023-09-02 13:11:25', NULL, 2),
(471, 22, 'ajust', 'ajustement', 14, 1, '2023-09-02 13:11:25', NULL, 2),
(472, 10, 'ajust', 'ajustement', 66, 1, '2023-09-02 13:11:25', NULL, 2),
(473, 1, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(474, 25, 'ajust', 'ajustement', 28, 1, '2023-09-02 13:11:25', NULL, 2),
(475, 28, 'ajust', 'ajustement', 85, 1, '2023-09-02 13:11:25', NULL, 2),
(476, 4, 'ajust', 'ajustement', 61, 1, '2023-09-02 13:11:25', NULL, 2),
(477, 31, 'ajust', 'ajustement', 28, 1, '2023-09-02 13:11:25', NULL, 2),
(478, 34, 'ajust', 'ajustement', 27, 1, '2023-09-02 13:11:25', NULL, 2),
(479, 37, 'ajust', 'ajustement', 29, 1, '2023-09-02 13:11:25', NULL, 2),
(480, 1393, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(481, 169, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(482, 172, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(483, 1033, 'ajust', 'ajustement', 11, 1, '2023-09-02 13:11:25', NULL, 2),
(484, 163, 'ajust', 'ajustement', 0, 1, '2023-09-02 13:11:25', NULL, 2),
(485, 220, 'livibe230091', 'sortie', -3, 1, '2023-09-02 13:12:12', NULL, 2),
(486, 253, 'livibe230091', 'sortie', -2, 1, '2023-09-02 13:12:12', NULL, 2),
(487, 220, 'ajust', 'ajustement', -1, 1, '2023-09-02 13:18:53', NULL, 2),
(488, 253, 'ajust', 'ajustement', -1, 1, '2023-09-02 13:20:31', NULL, 2),
(489, 220, 'ajust', 'ajustement', -1, 1, '2023-09-02 13:23:21', NULL, 2),
(490, 205, 'livibe230092', 'sortie', 0, 1, '2023-09-02 13:23:38', NULL, 2),
(491, 253, 'livibe230092', 'sortie', 0, 1, '2023-09-02 13:23:38', NULL, 2),
(492, 253, 'livibe230092', 'entree', 0, 1, '2023-09-02 13:25:06', NULL, 1),
(493, 253, 'ajust', 'ajustement', -2, 1, '2023-09-02 13:25:43', NULL, 2),
(494, 253, 'livibe230092', 'entree', 0, 1, '2023-09-02 13:25:59', NULL, 1),
(495, 220, 'livibe230089', 'entree', 1, 1, '2023-09-02 13:31:03', NULL, 1),
(496, 205, 'livibe230093', 'sortie', -3, 1, '2023-09-02 13:42:35', NULL, 2),
(497, 421, 'livibe230093', 'sortie', -1, 1, '2023-09-02 13:42:35', NULL, 2),
(498, 205, 'livibe230093', 'entree', 1, 1, '2023-09-02 13:43:08', NULL, 1),
(499, 205, 'livibe230093', 'entree', 1, 1, '2023-09-02 13:43:50', NULL, 1),
(500, 253, 'ajust', 'ajustement', 2, 1, '2023-09-02 13:45:11', NULL, 2),
(501, 205, 'livibe230094', 'sortie', -1, 1, '2023-09-02 13:48:33', NULL, 2),
(502, 220, 'livibe230094', 'sortie', -5, 1, '2023-09-02 13:48:33', NULL, 2),
(503, 220, 'livibe230094', 'entree', 1, 1, '2023-09-02 13:48:44', NULL, 1),
(504, 220, 'livibe230094', 'entree', 2, 1, '2023-09-02 13:50:38', NULL, 1),
(505, 220, 'livibe230095', 'sortie', -1, 1, '2023-09-02 13:52:14', NULL, 2),
(506, 220, 'livibe230094', 'entree', 4, 1, '2023-09-02 13:52:31', NULL, 1),
(507, 205, 'livibe230094', 'entree', 1, 1, '2023-09-02 13:54:08', NULL, 1),
(508, 220, 'livibe230096', 'sortie', -4, 1, '2023-09-02 13:55:09', NULL, 2),
(509, 220, 'livibe230096', 'entree', 1, 1, '2023-09-02 13:55:37', NULL, 1),
(510, 220, 'livibe230096', 'entree', 2, 1, '2023-09-02 13:55:52', NULL, 1),
(511, 220, 'livibe230097', 'sortie', -4, 1, '2023-09-02 13:57:20', NULL, 2),
(512, 220, 'livibe230097', 'entree', 1, 1, '2023-09-02 13:57:41', NULL, 1),
(513, 220, 'livibe230097', 'entree', 2, 1, '2023-09-02 13:58:03', NULL, 1),
(514, 220, 'livibe230098', 'sortie', -4, 1, '2023-09-02 14:03:28', NULL, 2),
(515, 220, 'livibe230098', 'entree', 1, 1, '2023-09-02 14:03:44', NULL, 1),
(516, 220, 'livibe230098', 'entree', 1, 1, '2023-09-02 14:03:57', NULL, 1),
(517, 217, 'livibe230099', 'sortie', -1, 1, '2023-09-02 14:06:26', NULL, 2),
(518, 1144, 'recepf', 'entree', 10, 1, '2023-09-05 08:44:54', 'bl0001', 2),
(519, 592, 'recepf', 'entree', 2, 1, '2023-09-05 08:50:32', 'bl0001', 2),
(520, 1144, 'recepf', 'entree', 10, 1, '2023-09-08 12:54:06', 'bl0001', 2),
(521, 202, 'livibe230100', 'entree', 1, 1, '2023-09-11 00:15:23', NULL, 1),
(522, 349, 'livibe230102', 'entree', 7, 1, '2023-09-11 12:32:58', NULL, 1),
(523, 349, 'livibe230102', 'entree', 1, 1, '2023-09-11 12:37:39', NULL, 1),
(524, 349, 'livibe230102', 'sortie', -2, 1, '2023-09-11 12:44:45', NULL, 2),
(525, 349, 'livibe230102', 'entree', 1, 1, '2023-09-11 12:45:29', NULL, 1),
(526, 349, 'livibe230102', 'entree', 1, 1, '2023-09-11 12:50:50', NULL, 1),
(527, 349, 'livibe230102', 'entree', 1, 1, '2023-09-11 12:55:54', NULL, 1),
(528, 349, 'livibe230102', 'entree', 1, 1, '2023-09-11 12:56:16', NULL, 1),
(529, 364, 'livibe230106', 'sortie', -2, 1, '2023-09-12 20:43:35', NULL, 2),
(530, 202, 'livibe230107', 'sortie', -1, 1, '2023-09-12 20:45:17', NULL, 2),
(531, 874, 'recepf', 'entree', 20, 1, '2023-09-21 11:39:47', 'dffsd', 2),
(532, 1141, 'recepf', 'entree', 2, 1, '2023-09-21 13:48:07', 'QFE', 2),
(533, 181, 'recepf', 'entree', 2, 1, '2023-09-21 13:57:48', 'QFE', 2);

-- --------------------------------------------------------

--
-- Structure de la table `topclient`
--

DROP TABLE IF EXISTS `topclient`;
CREATE TABLE IF NOT EXISTS `topclient` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_client` int(11) NOT NULL,
  `montant` double DEFAULT NULL,
  `benefice` float NOT NULL,
  `pseudo` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=107 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `transferfond`
--

DROP TABLE IF EXISTS `transferfond`;
CREATE TABLE IF NOT EXISTS `transferfond` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `numero` int(11) DEFAULT NULL,
  `caissedep` varchar(11) NOT NULL,
  `montant` float NOT NULL,
  `caisseret` varchar(11) NOT NULL,
  `devise` varchar(10) DEFAULT NULL,
  `lieuvente` int(10) DEFAULT NULL,
  `exect` int(11) NOT NULL,
  `coment` text,
  `dateop` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `transferfond`
--

INSERT INTO `transferfond` (`id`, `numero`, `caissedep`, `montant`, `caisseret`, `devise`, `lieuvente`, `exect`, `coment`, `dateop`) VALUES
(1, 58, '193', 200000, '1', 'gnf', 1, 1, 'transfert des fonds', '2023-08-27 15:26:00');

-- --------------------------------------------------------

--
-- Structure de la table `transferprod`
--

DROP TABLE IF EXISTS `transferprod`;
CREATE TABLE IF NOT EXISTS `transferprod` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idprod` int(11) NOT NULL,
  `stockdep` int(11) NOT NULL,
  `quantitemouv` float NOT NULL,
  `stockrecep` int(11) NOT NULL,
  `dateop` datetime NOT NULL,
  `exect` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `transfertargent`
--

DROP TABLE IF EXISTS `transfertargent`;
CREATE TABLE IF NOT EXISTS `transfertargent` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `numenv` varchar(150) DEFAULT NULL,
  `cmd` varchar(50) DEFAULT NULL,
  `idpers` int(10) DEFAULT NULL,
  `libelle` varchar(150) DEFAULT NULL,
  `bl` varchar(150) DEFAULT NULL,
  `montant` double DEFAULT NULL,
  `taux` double DEFAULT NULL,
  `devise` varchar(10) DEFAULT NULL,
  `devisenv` varchar(10) DEFAULT NULL,
  `lieuvente` int(2) DEFAULT NULL,
  `dateop` datetime DEFAULT NULL,
  `statut` varchar(50) NOT NULL DEFAULT 'nok',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `transfertargent`
--

INSERT INTO `transfertargent` (`id`, `numenv`, `cmd`, `idpers`, `libelle`, `bl`, `montant`, `taux`, `devise`, `devisenv`, `lieuvente`, `dateop`, `statut`) VALUES
(1, 'ta1', 'cmd1', 2, 'pour pre-cmd1', 'bor20002', 5000, 1, 'us', 'us', 1, '2023-08-27 03:36:00', 'ok');

-- --------------------------------------------------------

--
-- Structure de la table `validcomande`
--

DROP TABLE IF EXISTS `validcomande`;
CREATE TABLE IF NOT EXISTS `validcomande` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_produit` int(50) DEFAULT NULL,
  `codebvc` varchar(50) DEFAULT NULL,
  `designation` varchar(60) NOT NULL,
  `quantite` float NOT NULL,
  `pachat` double NOT NULL,
  `pvente` double DEFAULT NULL,
  `previent` double DEFAULT NULL,
  `frais` double DEFAULT NULL,
  `etat` varchar(15) NOT NULL,
  `pseudo` varchar(50) DEFAULT NULL,
  `datecmd` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `validcomandefrais`
--

DROP TABLE IF EXISTS `validcomandefrais`;
CREATE TABLE IF NOT EXISTS `validcomandefrais` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_produit` int(50) DEFAULT NULL,
  `codebvc` varchar(50) DEFAULT NULL,
  `designation` varchar(60) NOT NULL,
  `quantite` float NOT NULL,
  `pachat` double NOT NULL,
  `pvente` double DEFAULT NULL,
  `previent` double DEFAULT NULL,
  `frais` double DEFAULT NULL,
  `etat` varchar(15) NOT NULL,
  `pseudo` varchar(50) DEFAULT NULL,
  `datecmd` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `validpaie`
--

DROP TABLE IF EXISTS `validpaie`;
CREATE TABLE IF NOT EXISTS `validpaie` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_produit` int(50) DEFAULT NULL,
  `codebvc` varchar(50) DEFAULT NULL,
  `quantite` float NOT NULL,
  `pvente` double DEFAULT NULL,
  `pseudov` varchar(50) DEFAULT NULL,
  `datecmd` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=181 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `validpaie`
--

INSERT INTO `validpaie` (`id`, `id_produit`, `codebvc`, `quantite`, `pvente`, `pseudov`, `datecmd`) VALUES
(50, 199, '1', 1, 150000, '50', '2023-07-12 14:32:34');

-- --------------------------------------------------------

--
-- Structure de la table `validpaiemodif`
--

DROP TABLE IF EXISTS `validpaiemodif`;
CREATE TABLE IF NOT EXISTS `validpaiemodif` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_produit` int(50) DEFAULT NULL,
  `codebvc` varchar(50) DEFAULT NULL,
  `quantite` float NOT NULL,
  `pvente` double DEFAULT NULL,
  `pseudov` varchar(50) DEFAULT NULL,
  `datecmd` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=40 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `validpaiemodif`
--

INSERT INTO `validpaiemodif` (`id`, `id_produit`, `codebvc`, `quantite`, `pvente`, `pseudov`, `datecmd`) VALUES
(39, 217, '', -1, 150000, '1', '2023-09-22 11:20:54'),
(38, 580, '', 1, 130000, '1', '2023-09-22 11:20:54'),
(37, 217, '', 10, 150000, '1', '2023-09-22 11:20:54');

-- --------------------------------------------------------

--
-- Structure de la table `validvente`
--

DROP TABLE IF EXISTS `validvente`;
CREATE TABLE IF NOT EXISTS `validvente` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `remise` double DEFAULT '0',
  `montantpgnf` double DEFAULT '0',
  `montantpeu` double DEFAULT '0',
  `montantpus` double DEFAULT '0',
  `montantpcfa` double DEFAULT '0',
  `virement` double DEFAULT '0',
  `cheque` double DEFAULT '0',
  `numcheque` varchar(50) DEFAULT NULL,
  `banqcheque` varchar(50) DEFAULT NULL,
  `pseudop` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=86 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `validvente`
--

INSERT INTO `validvente` (`id`, `remise`, `montantpgnf`, `montantpeu`, `montantpus`, `montantpcfa`, `virement`, `cheque`, `numcheque`, `banqcheque`, `pseudop`) VALUES
(20, 0, 0, 0, 0, 0, 0, 0, '0', '0', '50');

-- --------------------------------------------------------

--
-- Structure de la table `validventemodif`
--

DROP TABLE IF EXISTS `validventemodif`;
CREATE TABLE IF NOT EXISTS `validventemodif` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `remise` double DEFAULT '0',
  `montantpgnf` double DEFAULT '0',
  `montantpeu` double DEFAULT '0',
  `montantpus` double DEFAULT '0',
  `montantpcfa` double DEFAULT '0',
  `virement` double DEFAULT '0',
  `cheque` double DEFAULT '0',
  `numcheque` varchar(50) DEFAULT NULL,
  `banqcheque` varchar(50) DEFAULT NULL,
  `pseudop` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=35 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `validventemodif`
--

INSERT INTO `validventemodif` (`id`, `remise`, `montantpgnf`, `montantpeu`, `montantpus`, `montantpcfa`, `virement`, `cheque`, `numcheque`, `banqcheque`, `pseudop`) VALUES
(34, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, '1');

-- --------------------------------------------------------

--
-- Structure de la table `ventecommission`
--

DROP TABLE IF EXISTS `ventecommission`;
CREATE TABLE IF NOT EXISTS `ventecommission` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `numc` varchar(50) NOT NULL,
  `numcmd` varchar(50) NOT NULL,
  `montant` double DEFAULT NULL,
  `idclient` int(11) NOT NULL,
  `idpers` int(11) NOT NULL,
  `dateop` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `ventecommission`
--

INSERT INTO `ventecommission` (`id`, `numc`, `numcmd`, `montant`, `idclient`, `idpers`, `dateop`) VALUES
(19, 'commission19', 'ibe230104', 10000, 6, 1, '2023-09-12 12:08:44'),
(20, 'commission20', 'ibe230111', 10000, 6, 1, '2023-09-21 13:11:34'),
(18, 'commission18', 'ibe230102', 50000, 93, 1, '2023-09-11 12:58:53');

-- --------------------------------------------------------

--
-- Structure de la table `ventedelete`
--

DROP TABLE IF EXISTS `ventedelete`;
CREATE TABLE IF NOT EXISTS `ventedelete` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_produit` int(11) DEFAULT NULL,
  `prix_vente` double NOT NULL,
  `prix_revient` double DEFAULT '0',
  `quantity` int(11) NOT NULL,
  `num_cmd` varchar(50) NOT NULL,
  `id_client` int(10) DEFAULT NULL,
  `idpersonnel` int(11) NOT NULL,
  `idstock` int(11) NOT NULL,
  `datedelete` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `ventedelete`
--

INSERT INTO `ventedelete` (`id`, `id_produit`, `prix_vente`, `prix_revient`, `quantity`, `num_cmd`, `id_client`, `idpersonnel`, `idstock`, `datedelete`) VALUES
(1, 355, 400000, 304290, 1, 'ibe230014', 51, 50, 1, '2023-07-12 14:04:39'),
(2, 94, 30000, 0, 1, 'ibe230024', 73, 50, 1, '2023-07-12 14:04:58'),
(3, 793, 2300000, 1746360, 1, 'ibe230004', 86, 50, 1, '2023-07-12 14:12:24'),
(4, 364, 1000000, 629748, 1, 'ibe230046', 183, 1, 1, '2023-07-14 12:55:45'),
(5, 220, 200000, 116424, 2, 'ibe230090', 1, 1, 1, '2023-09-02 13:11:40'),
(6, 253, 5000000, 3704400, 2, 'ibe230090', 1, 1, 1, '2023-09-02 13:11:40'),
(7, 205, 190000, 156114, 1, 'ibe230092', 1, 1, 1, '2023-09-02 13:30:26'),
(8, 253, 5000000, 3704400, 1, 'ibe230092', 1, 1, 1, '2023-09-02 13:30:26');

-- --------------------------------------------------------

--
-- Structure de la table `versement`
--

DROP TABLE IF EXISTS `versement`;
CREATE TABLE IF NOT EXISTS `versement` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `numcmd` varchar(10) DEFAULT NULL,
  `nom_client` varchar(155) NOT NULL,
  `montant` double NOT NULL,
  `devisevers` varchar(20) NOT NULL,
  `taux` float NOT NULL DEFAULT '1',
  `numcheque` varchar(50) DEFAULT NULL,
  `banquecheque` varchar(100) DEFAULT NULL,
  `motif` varchar(150) DEFAULT NULL,
  `type_versement` varchar(15) NOT NULL,
  `comptedep` varchar(50) DEFAULT NULL,
  `lieuvente` varchar(10) DEFAULT NULL,
  `date_versement` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=31 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `versement`
--

INSERT INTO `versement` (`id`, `numcmd`, `nom_client`, `montant`, `devisevers`, `taux`, `numcheque`, `banquecheque`, `motif`, `type_versement`, `comptedep`, `lieuvente`, `date_versement`) VALUES
(1, 'dep1', '62', 800000, 'gnf', 1, '', '', 'PAIEMENT', 'espèces', '1', '1', '2023-07-11 00:00:00'),
(2, 'dep2', '24', 28230000, 'gnf', 1, '08013127', 'vistagui', 'PAIEMENT', 'chèque', '1', '1', '2023-07-11 00:00:00'),
(3, 'dep3', '24', 1500000, 'gnf', 1, '08249752', 'vistagui', 'PAIEMENT', 'chèque', '1', '1', '2023-07-11 00:00:00'),
(4, 'dep4', '24', 8700000, 'gnf', 1, '04553736', 'vistagui', 'PAIEMENT', 'chèque', '1', '1', '2023-07-11 00:00:00'),
(5, 'dep5', '36', 360000, 'gnf', 1, '', '', 'PAIEMENT', 'espèces', '1', '1', '2023-07-11 00:00:00'),
(6, 'dep6', '29', 4650000, 'gnf', 1, '', '', 'PAIEMENT', 'espèces', '1', '1', '2023-07-11 00:00:00'),
(7, 'dep7', '41', 800000, 'gnf', 1, '', '', 'PAIEMENT', 'espèces', '1', '1', '2023-07-11 00:00:00'),
(8, 'dep8', '11', 10000000, 'gnf', 1, '', '', 'PAIEMENT', 'espèces', '1', '1', '2023-07-12 14:18:28'),
(9, 'dep9', '82', 90000, 'gnf', 1, '', '', 'PAIEMENT', 'espèces', '1', '1', '2023-07-12 14:18:52'),
(10, 'dep10', '10', 5000000, 'gnf', 1, '', '', 'PAIEMENT', 'espèces', '1', '1', '2023-07-12 14:19:26'),
(11, 'dep11', '6', 35000000, 'gnf', 1, '', '', 'PAIEMENT', 'espèces', '1', '1', '2023-07-12 14:27:25'),
(12, 'dep12', '192', 4000000, 'gnf', 1, '', '', 'PAIEMENT', 'espèces', '1', '1', '2023-07-11 00:00:00'),
(13, 'dep13', '8', 33650000, 'gnf', 1, '', '', 'paiement', 'espèces', '1', '1', '2023-07-12 15:12:45'),
(14, 'dep14', '17', 16800000, 'gnf', 1, '', '', 'paiement', 'espèces', '1', '1', '2023-07-12 15:21:36'),
(15, 'dep15', '8', 100000000, 'gnf', 1, 'c56545', 'ecobank', 'paiement', 'chèque', '1', '1', '2023-07-22 22:11:01'),
(16, 'dep16', '7', 50000000, 'gnf', 1, '', '', 'paiement', 'espèces', '194', '1', '2023-07-22 22:35:59'),
(17, 'dep17', '8', 10000000, 'gnf', 1, '', '', 'paiement', 'espèces', '1', '1', '2023-07-24 20:20:21'),
(18, 'dep18', '6', 2000, 'eu', 1, '', '', 'emprunt', 'espèces', '1', '1', '2023-08-07 12:58:39'),
(19, 'dep19', '6', 50000000, 'gnf', 1, '', '', 'paiement', 'espèces', '1', '1', '2023-08-07 13:02:33'),
(20, 'dep20', '7', 20000000, 'gnf', 1, '', '', 'paiement facture', 'espèces', '1', '1', '2023-08-08 15:12:04'),
(21, 'dep21', '7', 50000000, 'gnf', 1, '', '', 'paiement facture remis par nnn', 'espèces', '1', '1', '2023-08-08 15:24:06'),
(23, 'dep22', '6', 500, 'eu', 1, '', '', 'paiementv facture par devise', 'espèces', '1', '1', '2023-08-08 15:38:57'),
(24, 'dep24', '15', 10000000, 'gnf', 1, '', '', 'paiement facture', 'virement', '193', '1', '2023-08-19 16:43:42'),
(25, 'dep25', '17', 20000000, 'gnf', 1, '', '', 'paiement', 'espèces', '1', '1', '2023-08-20 10:46:10'),
(26, 'dep26', '6', 20000000, 'gnf', 1, '', '', 'paiement facture', 'espèces', '1', '1', '2023-08-27 10:28:00'),
(27, 'dep27', '6', 1000000, 'gnf', 1, '', '', 'PAIEMENT RESTE ', 'espèces', '1', '1', '2023-08-27 10:29:00'),
(28, 'dep28', '7', 20000, 'us', 1, '', '', 'PAIEMENT FACTURE', 'espèces', '1', '1', '2023-08-27 15:30:00'),
(29, 'dep29', '93', 10000000, 'gnf', 1, '', '', 'payement facture', 'espèces', '1', '1', '2023-09-04 10:28:00'),
(30, 'dep30', '6', 9000000, 'gnf', 1, '', '', 'PAIZEMRNT', 'especes', '1', '1', '2023-09-12 18:51:00');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
