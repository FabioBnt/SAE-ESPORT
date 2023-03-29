-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mer. 29 mars 2023 à 13:51
-- Version du serveur : 10.6.10-MariaDB-cll-lve
-- Version de PHP : 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `u563109936_esporters`
--

-- --------------------------------------------------------

--
-- Structure de la table `Concourir`
--

CREATE TABLE `Concourir` (
  `IdEquipe` int(11) NOT NULL,
  `IdPoule` int(11) NOT NULL,
  `Numero` int(11) NOT NULL,
  `Score` smallint(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `Concourir`
--

INSERT INTO `Concourir` (`IdEquipe`, `IdPoule`, `Numero`, `Score`) VALUES
(2, 1, 1, 1),
(2, 1, 2, 2),
(2, 1, 3, 3),
(6, 2, 1, 2),
(6, 2, 2, 0),
(6, 2, 3, 4),
(11, 3, 1, 2),
(11, 3, 2, 0),
(11, 3, 3, 3),
(19, 4, 1, 4),
(19, 4, 2, 1),
(19, 4, 3, 2),
(20, 1, 1, 2),
(20, 1, 4, 3),
(20, 1, 5, 2),
(24, 2, 1, 0),
(24, 2, 4, 0),
(24, 2, 5, 3),
(30, 3, 1, 0),
(30, 3, 4, 0),
(30, 3, 5, 5),
(33, 4, 1, 2),
(33, 4, 4, 0),
(33, 4, 5, 3),
(35, 1, 2, 3),
(35, 1, 4, 1),
(35, 1, 6, 2),
(37, 2, 2, 3),
(37, 2, 4, 5),
(37, 2, 6, 0),
(39, 3, 2, 3),
(39, 3, 4, 4),
(39, 3, 6, 0),
(41, 4, 2, 3),
(41, 4, 4, 3),
(41, 4, 6, 1),
(45, 1, 3, 2),
(45, 1, 5, 4),
(45, 1, 6, 3),
(47, 2, 3, 0),
(47, 2, 5, 0),
(47, 2, 6, 2),
(49, 3, 3, 0),
(49, 3, 5, 0),
(49, 3, 6, 2),
(51, 4, 3, 0),
(51, 4, 5, 0),
(51, 4, 6, 0);

-- --------------------------------------------------------

--
-- Structure de la table `Contenir`
--

CREATE TABLE `Contenir` (
  `IdJeu` int(11) NOT NULL,
  `IdTournoi` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `Contenir`
--

INSERT INTO `Contenir` (`IdJeu`, `IdTournoi`) VALUES
(1, 1),
(1, 2),
(1, 4),
(1, 7),
(1, 11),
(2, 3),
(2, 9),
(2, 11),
(3, 3),
(3, 12),
(6, 8),
(6, 12),
(6, 15),
(7, 7),
(7, 10),
(8, 5),
(9, 4),
(9, 7),
(9, 8),
(9, 12),
(10, 4),
(10, 6);

-- --------------------------------------------------------

--
-- Structure de la table `Ecurie`
--

CREATE TABLE `Ecurie` (
  `IDEcurie` int(11) NOT NULL,
  `Designation` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `TypeE` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `NomCompte` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `MDPCompte` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `Ecurie`
--

INSERT INTO `Ecurie` (`IDEcurie`, `Designation`, `TypeE`, `NomCompte`, `MDPCompte`) VALUES
(1, 'Vitality', 'Professionnelle', 'VitalityEcurie', 'motdepassevitality'),
(2, 'KCorp', 'Professionnelle', 'KCorpEcurie', 'motdepassekcorp'),
(3, 'TurcoinTeam', 'Professionnelle', 'TurcoinTEcurie', 'motdepasseturcointeam'),
(4, 'MenwizzTeam', 'Associative', 'MenwizzTEcurie', 'motdepassemenwizzteam'),
(5, 'ChalumeauTeam', 'Associative', 'ChalumeauTEcurie', 'motdepassechalumeauteam'),
(6, 'LesJoueursFou', 'Associative', 'LJFEcurie', 'motdepasseljf'),
(7, 'Aventura', 'Professionnelle', 'AventuraEcurie', 'motdepasseaventura'),
(8, 'Haccun', 'Professionnelle', 'HaccunEcurie', 'motdepassehaccun'),
(9, 'LouNil', 'Associative', 'LNEcurie', 'motdepasseLN'),
(10, 'Viatal', 'Associative', 'ViatalEcurie', 'motdepasseviatal'),
(11, 'TechnoBlade', 'Associative', 'TechnoBladeEcurie', 'motdepassetechnoblade'),
(12, 'Silksp', 'Professionnelle', 'SilkspEcurie', 'motdepassesilksp'),
(13, 'PardTeat', 'Associative', 'PardTeatEcurie', 'motdepassepardteat'),
(14, 'Orial', 'Professionnelle', 'OrialEcurie', 'motdepasseorial'),
(15, 'Joloao', 'Associative', 'JoloaoEcurie', 'motdepassejoloao'),
(16, 'VAO', 'Associative', 'VAOEcurie', 'motdepassevao'),
(17, 'Fantinat', 'Professionnelle', 'FantinatEcurie', 'motdepassefantinat'),
(18, 'MarioVac', 'Professionnelle', 'MarioVacEcurie', 'motdepassemariovac'),
(19, 'Kopadl', 'Associative', 'KopadlEcurie', 'motdepassekopadl'),
(20, 'Odoo', 'Professionnelle', 'OdooEcurie', 'motdepasseodoo'),
(21, 'MVC', 'Professionnelle', 'MVCEcurie', 'motdepassemvc'),
(22, 'ParkBaby', 'Associative', 'ParkBabyEcurie', 'motdepasseparkbaby'),
(26, 'test', 'Associative', 'test', 'test'),
(27, 'test', 'Associative', 'test', 'test'),
(28, 'test', 'Associative', 'test', 'test'),
(29, 'test', 'Associative', 'test', 'test'),
(30, 'test', 'Associative', 'test', 'test'),
(31, 'test', 'Associative', 'test', 'test');

-- --------------------------------------------------------

--
-- Structure de la table `Equipe`
--

CREATE TABLE `Equipe` (
  `IdEquipe` int(11) NOT NULL,
  `NomE` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `NomCompte` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `MDPCompte` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `NbPointsE` int(11) DEFAULT NULL,
  `IdJeu` int(11) NOT NULL,
  `IDEcurie` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `Equipe`
--

INSERT INTO `Equipe` (`IdEquipe`, `NomE`, `NomCompte`, `MDPCompte`, `NbPointsE`, `IdJeu`, `IDEcurie`) VALUES
(1, 'VitalityOver', 'VitalityOverEquipe', 'mdpvitalityover', NULL, 1, 1),
(2, 'VitalityFortnite', 'VitalityFortniteEqui', 'mdpvitalityfortnite', NULL, 2, 1),
(3, 'VitalityCSGO', 'VitalityCSGOEquipe', 'mdpvitalitycsgo', NULL, 4, 1),
(4, 'VitalityRealmRoyale', 'VitalityRREquipe', 'mdpvitalityrr', NULL, 8, 1),
(5, 'TurcoinTOver', 'TurcoinTOverEquipe', 'mdpturcointover', NULL, 1, 3),
(6, 'TurcoinTFortnite', 'TurcoinTFortniteEqui', 'mdpturcointfortnite', NULL, 2, 3),
(7, 'TurcoinTValorant', 'TurcoinTValorantEqui', 'mdpturcointvalorant', NULL, 9, 3),
(8, 'TurcoinTFifa', 'TurcoinTFifaEquipe', 'mdpturcointfifa', NULL, 7, 3),
(9, 'MenwizzTeamOver', 'MenwizzTOverEquipe', 'mdpmenwizztover', NULL, 1, 4),
(10, 'KcorpOW', 'KcorpOWEquipe', 'KcorpOWmdp', NULL, 1, 2),
(11, 'KcorpFN', 'KcorpFNEquipe', 'KcorpFNmdp', NULL, 2, 2),
(12, 'MenwizzTeamFN', 'MenwizzTFNEquipe', 'mdpmenwizztfn', NULL, 2, 4),
(13, 'KcorpFifa', 'KcorpFifaEquipe', 'KcorpFifamdp', NULL, 7, 2),
(14, 'MenwizzTeamRL', 'MenwizzTRLEquipe', 'mdpmenwizztrl', NULL, 6, 4),
(15, 'KcorpAL', 'KcorpALEquipe', 'KcorpALmdp', NULL, 3, 2),
(16, 'MenwizzTeamLOL', 'MenwizzTLOLEquipe', 'mdpmenwizztlol', NULL, 10, 4),
(17, 'ChalumeauOW', 'ChalumeauOWEquipe', 'ChalumeauOWmdp', NULL, 1, 5),
(18, 'LJFOver', 'LJFOverEquipe', 'mdpljfover', NULL, 1, 6),
(19, 'ChalumeauFN', 'ChalumeauFNEquipe', 'ChalumeauFNmdp', NULL, 2, 5),
(20, 'LJFFN', 'LJFFNEquipe', 'mdpljffn', NULL, 2, 6),
(21, 'LJFSC', 'LJFSCEquipe', 'mdpljfsc', NULL, 5, 6),
(22, 'AventuraOW', 'AventuraOWEquipe', 'AventuraOWmdp', NULL, 1, 7),
(23, 'LJFValo', 'LJFValoEquipe', 'mdpljfvalo', NULL, 9, 6),
(24, 'AventuraFN', 'AventuraFNEquipe', 'AventuraFNmdp', NULL, 2, 7),
(25, 'AventuraLOL', 'AventuraLOLEquipe', 'AventuraLOLmdp', NULL, 10, 7),
(26, 'HaccunOver', 'HaccunOverEquipe', 'mdphaccunover', NULL, 1, 8),
(27, 'HaccunFN', 'HaccunFNEquipe', 'mdphaccunfn', NULL, 2, 8),
(28, 'HaccunLOL', 'HaccunLOLEquipe', 'mdphaccunlol', NULL, 10, 8),
(29, 'LouNilOW', 'LouNilOWEquipe', 'LouNilOWmdp', NULL, 1, 9),
(30, 'LouNilFN', 'LouNilFNEquipe', 'LouNilFNmdp', NULL, 2, 9),
(31, 'LouNilRL', 'LouNilRLEquipe', 'LouNilRLmdp', NULL, 6, 9),
(32, 'ViatalOW', 'ViatalOWEquipe', 'ViatalOWmdp', NULL, 1, 10),
(33, 'ViatalFN', 'ViatalFNEquipe', 'ViatalFNmdp', NULL, 2, 10),
(34, 'TechnoBladeOW', 'TechnoBladeOWEquipe', 'TechnoBladeOWmdp', NULL, 1, 11),
(35, 'TechnoBladeFN', 'TechnoBladeFNEquipe', 'TechnoBladeFNmdp', NULL, 2, 11),
(36, 'SilkspOW', 'SilkspOWEquipe', 'SilkspOWmdp', NULL, 1, 12),
(37, 'SilkspFN', 'SilkspFNEquipe', 'SilkspFNmdp', NULL, 2, 12),
(38, 'PardTeatOW', 'PardTeatOWEquipe', 'PardTeatOWmdp', NULL, 1, 13),
(39, 'PardTeatFN', 'PardTeatFNEquipe', 'PardTeatFNmdp', NULL, 2, 13),
(40, 'OrialOW', 'OrialOWEquipe', 'OrialOWmdp', NULL, 1, 14),
(41, 'OrialFN', 'OrialFNEquipe', 'OrialFNmdp', NULL, 2, 14),
(42, 'JoloaoOW', 'JoloaoOWEquipe', 'JoloaoOWmdp', NULL, 1, 15),
(43, 'JoloaoFN', 'JoloaoFNEquipe', 'JoloaoFNmdp', NULL, 2, 15),
(44, 'VAOOW', 'VAOOWEquipe', 'VAOOWmdp', NULL, 1, 16),
(45, 'VAOFN', 'VAOFNEquipe', 'VAOFNmdp', NULL, 2, 16),
(46, 'FantinatOW', 'FantinatOWEquipe', 'FantinatOWmdp', NULL, 1, 17),
(47, 'FantinatFN', 'FantinatFNEquipe', 'FantinatFNmdp', NULL, 2, 17),
(48, 'MarioVacOW', 'MarioVacOWEquipe', 'MarioVacOWmdp', NULL, 1, 18),
(49, 'MarioVacFN', 'MarioVacFNEquipe', 'MarioVacFNmdp', NULL, 2, 18),
(50, 'KopadlOW', 'KopadlOWEquipe', 'KopadlOWmdp', NULL, 1, 19),
(51, 'KopadlFN', 'KopadlFNEquipe', 'KopadlFNmdp', NULL, 2, 19),
(52, 'OdooOW', 'OdooOWEquipe', 'OdooOWmdp', NULL, 1, 20),
(53, 'VitalitySC', 'VitalitySCEquipe', 'mdpvitalitysc', NULL, 5, 1),
(54, 'ParkBabyRL', 'ParkBabyRLEquipe', 'mdpparkbabyrl', NULL, 6, 22);

-- --------------------------------------------------------

--
-- Structure de la table `Faire_partie`
--

CREATE TABLE `Faire_partie` (
  `IdPoule` int(11) NOT NULL,
  `IdEquipe` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `Faire_partie`
--

INSERT INTO `Faire_partie` (`IdPoule`, `IdEquipe`) VALUES
(1, 2),
(1, 20),
(1, 35),
(1, 37),
(1, 39),
(1, 41),
(1, 45),
(2, 6),
(2, 24),
(2, 37),
(2, 47),
(3, 11),
(3, 30),
(3, 39),
(3, 49),
(4, 19),
(4, 33),
(4, 41),
(4, 51),
(22, 37),
(22, 39),
(22, 41),
(22, 45);

-- --------------------------------------------------------

--
-- Structure de la table `Jeu`
--

CREATE TABLE `Jeu` (
  `IdJeu` int(11) NOT NULL,
  `NomJeu` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `TypeJeu` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `TempsDeJeu` smallint(6) DEFAULT NULL,
  `DateLimiteInscription` smallint(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `Jeu`
--

INSERT INTO `Jeu` (`IdJeu`, `NomJeu`, `TypeJeu`, `TempsDeJeu`, `DateLimiteInscription`) VALUES
(1, 'Overwatch', 'FPS', 20, 25),
(2, 'Fortnite', 'BattleRoyale', 40, 27),
(3, 'ApexLegends', 'FPS', 35, 25),
(4, 'CSGO', 'FPS', 20, 38),
(5, 'StarCraft', 'RTS', 30, 32),
(6, 'RocketLeague', 'Sport', 25, 27),
(7, 'Fifa', 'Sport', 30, 32),
(8, 'RealmRoyale', 'BattleRoyale', 15, 20),
(9, 'Valorant', 'FPS', 40, 23),
(10, 'League Of Legends', 'MOBA', 20, 29);

-- --------------------------------------------------------

--
-- Structure de la table `Joueur`
--

CREATE TABLE `Joueur` (
  `IdJoueur` int(11) NOT NULL,
  `Pseudo` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Nationalite` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `IdEquipe` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `Joueur`
--

INSERT INTO `Joueur` (`IdJoueur`, `Pseudo`, `Nationalite`, `IdEquipe`) VALUES
(1, 'SunBear', 'EN', 1),
(2, 'PacificSandlance', 'DE', 1),
(3, 'Chartreux', 'FR', 2),
(4, 'SpectacledBear', 'FR', 2),
(5, 'TurkishVan', 'EN', 2),
(6, 'WhitetailedEagle', 'DE', 2),
(7, 'IridescentShark', 'FR', 3),
(8, 'MandarinFish', 'FR', 3),
(9, 'BrownBear', 'FR', 3),
(10, 'TransvaalLion', 'EN', 5),
(11, 'RedDiamond', 'EN', 5),
(12, 'CapeLion', 'DE', 5),
(13, 'BurgosPointer', 'DE', 7),
(14, 'Californian', 'FR', 7),
(15, 'BrownCarpathian', 'FR', 7),
(16, 'WestAfricanLion', 'EN', 8),
(17, 'YakutianHorse', 'EN', 8),
(18, 'CaveSwallow', 'EN', 8),
(19, 'DiabèteSteel', 'FR', 8),
(20, 'IronPepito', 'FR', 9),
(21, 'TheToto', 'FR', 9),
(22, 'NarutoQuaso', 'JP', 10),
(23, 'Dr.Skill', 'EN', 10),
(24, 'SushiUranium', 'RU', 10),
(25, 'MonsieurBlade', 'EN', 12),
(26, 'WarSun', 'FR', 12),
(27, 'RussianBurger', 'RU', 12),
(28, 'FrenchLotus', 'FR', 12),
(29, 'BannanaGalactic', 'RU', 13),
(30, 'MissDeath', 'FR', 13),
(31, 'GhostChocolatine', 'FR', 13),
(32, 'EpicBadboy', 'EN', 13),
(33, 'FantasyShoqapik', 'DE', 14),
(34, 'PredatorV', 'US', 14),
(35, 'BoyBeta', 'EN', 14),
(36, 'FrenchMaster', 'FR', 14),
(37, 'XHyper', 'EN', 17),
(38, 'NinjaPotato', 'EN', 18),
(39, 'ChickenBœuf', 'EN', 18),
(40, 'GhostBolt', 'EN', 18),
(41, 'SteelPotato', 'US', 19),
(42, 'DiabèteOne', 'US', 19),
(43, 'CheatGoku', 'US', 19),
(44, 'RubisWarrior', 'US', 19),
(45, 'ColossusPrincess', 'FR', 20),
(46, 'BetaRaptor', 'FR', 20),
(47, 'StoneDino', 'US', 20),
(48, 'SynnGood', 'DE', 20),
(49, 'PâleChicken', 'FR', 21),
(50, 'RedLava', 'EN', 21),
(51, 'DeathBlue', 'FR', 23),
(52, 'RexSword', 'EN', 23),
(53, 'SteelRonin', 'EN', 23),
(54, 'RussianTroll', 'DE', 24),
(55, 'ShoqapikStorm', 'PO', 24),
(56, 'NoobReality', 'US', 24),
(57, 'CovidGeek', 'DE', 25),
(58, 'MasterBurger', 'KR', 25),
(59, 'Jean', 'FR', 31),
(60, 'Patrik', 'DE', 31),
(61, 'Dimitry', 'RU', 31),
(62, 'Leon', 'CR', 31),
(63, 'tutu', 'FR', 53),
(64, 'toto', 'KR', 53);

-- --------------------------------------------------------

--
-- Structure de la table `MatchJ`
--

CREATE TABLE `MatchJ` (
  `IdPoule` int(11) NOT NULL,
  `Numero` int(11) NOT NULL,
  `dateM` date DEFAULT NULL,
  `HeureM` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `MatchJ`
--

INSERT INTO `MatchJ` (`IdPoule`, `Numero`, `dateM`, `HeureM`) VALUES
(1, 1, '2012-08-23', '02:08:00'),
(1, 2, '2012-08-23', '03:08:00'),
(1, 3, '2012-08-23', '05:08:00'),
(1, 4, '2012-08-23', '08:08:00'),
(1, 5, '2013-08-23', '12:08:00'),
(1, 6, '2013-08-23', '05:08:00'),
(2, 1, '2012-08-23', '02:08:00'),
(2, 2, '2012-08-23', '03:08:00'),
(2, 3, '2012-08-23', '05:08:00'),
(2, 4, '2012-08-23', '08:08:00'),
(2, 5, '2013-08-23', '12:08:00'),
(2, 6, '2013-08-23', '05:08:00'),
(3, 1, '2012-08-23', '02:08:00'),
(3, 2, '2012-08-23', '03:08:00'),
(3, 3, '2012-08-23', '05:08:00'),
(3, 4, '2012-08-23', '08:08:00'),
(3, 5, '2013-08-23', '12:08:00'),
(3, 6, '2013-08-23', '05:08:00'),
(4, 1, '2012-08-23', '02:08:00'),
(4, 2, '2012-08-23', '03:08:00'),
(4, 3, '2012-08-23', '05:08:00'),
(4, 4, '2012-08-23', '08:08:00'),
(4, 5, '2013-08-23', '12:08:00'),
(4, 6, '2013-08-23', '05:08:00');

--
-- Déclencheurs `MatchJ`
--
DELIMITER $$
CREATE TRIGGER `T_B_I_POULE` AFTER INSERT ON `MatchJ` FOR EACH ROW IF (SELECT COUNT(IdPoule) FROM MatchJ WHERE MatchJ.IdPoule = NEW.IdPoule) > 6 then
SIGNAL SQLSTATE '45000'
SET MESSAGE_TEXT = 'Le nombre max de poules a ete atteint';
END IF
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `Participer`
--

CREATE TABLE `Participer` (
  `IdTournoi` int(11) NOT NULL,
  `IdEquipe` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `Participer`
--

INSERT INTO `Participer` (`IdTournoi`, `IdEquipe`) VALUES
(3, 2),
(3, 6),
(3, 11),
(3, 15),
(3, 19),
(3, 20),
(3, 24),
(3, 30),
(3, 33),
(3, 35),
(3, 37),
(3, 39),
(3, 41),
(3, 45),
(3, 47),
(3, 49),
(3, 51);

-- --------------------------------------------------------

--
-- Structure de la table `Poule`
--

CREATE TABLE `Poule` (
  `IdPoule` int(11) NOT NULL,
  `NumeroPoule` smallint(6) DEFAULT NULL,
  `EstPouleFinale` tinyint(1) DEFAULT NULL,
  `IdJeu` int(11) NOT NULL,
  `IdTournoi` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `Poule`
--

INSERT INTO `Poule` (`IdPoule`, `NumeroPoule`, `EstPouleFinale`, `IdJeu`, `IdTournoi`) VALUES
(1, 1, 0, 2, 3),
(2, 2, 0, 2, 3),
(3, 3, 0, 2, 3),
(4, 4, 0, 2, 3),
(22, 5, 1, 2, 3);

-- --------------------------------------------------------

--
-- Structure de la table `Tournois`
--

CREATE TABLE `Tournois` (
  `IdTournoi` int(11) NOT NULL,
  `NomTournoi` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `CashPrize` int(11) DEFAULT NULL,
  `Notoriete` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Lieu` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `DateHeureTournois` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `Tournois`
--

INSERT INTO `Tournois` (`IdTournoi`, `NomTournoi`, `CashPrize`, `Notoriete`, `Lieu`, `DateHeureTournois`) VALUES
(12, 'Anonim Tournament', 1000000, 'International', 'Ohio', '2023-07-19 14:00:00'),
(10, 'BalounTournament', 15000, 'Regional', 'Sydney', '2023-07-08 12:00:00'),
(11, 'FabioTourney', 450, 'Local', 'Toulouse', '2023-03-30 17:00:00'),
(7, 'GrandTowerParty', 785400, 'Regional', 'Montpellier', '2023-06-13 16:15:00'),
(14, 'IsmaTourney', 15000, 'Regional', 'Ohio', '2023-03-20 13:00:00'),
(9, 'JarGames', 1400, 'Local', 'Jablines', '2023-05-06 16:15:00'),
(6, 'LolParty', 4785556, 'International', 'Londre', '2023-03-17 13:00:00'),
(15, 'MKTOUR', 14280, 'Regional', 'Paris', '2023-05-27 19:35:00'),
(13, 'MVCTourney', 1700, 'Regional', 'Paris', '2023-03-31 11:00:00'),
(5, 'NoobMasterGames', 1200, 'Local', 'Turcoin', '2023-05-13 08:10:00'),
(1, 'OcciTourney', 5000, 'International', 'Toulouse', '2023-02-28 15:00:00'),
(4, 'ParisGames', 458200, 'Regional', 'Paris', '2023-04-14 12:20:00'),
(3, 'TournamentFA', 150000, 'International', 'Los Angeles', '2023-08-12 14:00:00'),
(2, 'TournoiOverwatchEntreAmis', 1000, 'Local', 'Toulouse', '2023-05-19 15:00:00'),
(8, 'TreeLimeTournament', 86544, 'Local', 'Troyes', '2023-04-15 13:45:00');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `Concourir`
--
ALTER TABLE `Concourir`
  ADD PRIMARY KEY (`IdEquipe`,`IdPoule`,`Numero`),
  ADD KEY `IdPoule` (`IdPoule`,`Numero`);

--
-- Index pour la table `Contenir`
--
ALTER TABLE `Contenir`
  ADD PRIMARY KEY (`IdJeu`,`IdTournoi`),
  ADD KEY `IdTournoi` (`IdTournoi`);

--
-- Index pour la table `Ecurie`
--
ALTER TABLE `Ecurie`
  ADD PRIMARY KEY (`IDEcurie`);

--
-- Index pour la table `Equipe`
--
ALTER TABLE `Equipe`
  ADD PRIMARY KEY (`IdEquipe`),
  ADD KEY `IdJeu` (`IdJeu`),
  ADD KEY `IDEcurie` (`IDEcurie`);

--
-- Index pour la table `Faire_partie`
--
ALTER TABLE `Faire_partie`
  ADD PRIMARY KEY (`IdPoule`,`IdEquipe`),
  ADD KEY `IdEquipe` (`IdEquipe`);

--
-- Index pour la table `Jeu`
--
ALTER TABLE `Jeu`
  ADD PRIMARY KEY (`IdJeu`);

--
-- Index pour la table `Joueur`
--
ALTER TABLE `Joueur`
  ADD PRIMARY KEY (`IdJoueur`),
  ADD KEY `IdEquipe` (`IdEquipe`);

--
-- Index pour la table `MatchJ`
--
ALTER TABLE `MatchJ`
  ADD PRIMARY KEY (`IdPoule`,`Numero`);

--
-- Index pour la table `Participer`
--
ALTER TABLE `Participer`
  ADD PRIMARY KEY (`IdTournoi`,`IdEquipe`),
  ADD KEY `IdEquipe` (`IdEquipe`);

--
-- Index pour la table `Poule`
--
ALTER TABLE `Poule`
  ADD PRIMARY KEY (`IdPoule`),
  ADD KEY `IdJeu` (`IdJeu`,`IdTournoi`);

--
-- Index pour la table `Tournois`
--
ALTER TABLE `Tournois`
  ADD PRIMARY KEY (`IdTournoi`),
  ADD KEY `Tournois_index_all` (`NomTournoi`,`CashPrize`,`Notoriete`,`Lieu`,`DateHeureTournois`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `Ecurie`
--
ALTER TABLE `Ecurie`
  MODIFY `IDEcurie` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT pour la table `Equipe`
--
ALTER TABLE `Equipe`
  MODIFY `IdEquipe` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT pour la table `Jeu`
--
ALTER TABLE `Jeu`
  MODIFY `IdJeu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `Joueur`
--
ALTER TABLE `Joueur`
  MODIFY `IdJoueur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT pour la table `Poule`
--
ALTER TABLE `Poule`
  MODIFY `IdPoule` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT pour la table `Tournois`
--
ALTER TABLE `Tournois`
  MODIFY `IdTournoi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `Concourir`
--
ALTER TABLE `Concourir`
  ADD CONSTRAINT `Concourir_ibfk_1` FOREIGN KEY (`IdEquipe`) REFERENCES `Equipe` (`IdEquipe`),
  ADD CONSTRAINT `Concourir_ibfk_2` FOREIGN KEY (`IdPoule`,`Numero`) REFERENCES `MatchJ` (`IdPoule`, `Numero`);

--
-- Contraintes pour la table `Contenir`
--
ALTER TABLE `Contenir`
  ADD CONSTRAINT `Contenir_ibfk_1` FOREIGN KEY (`IdJeu`) REFERENCES `Jeu` (`IdJeu`),
  ADD CONSTRAINT `Contenir_ibfk_2` FOREIGN KEY (`IdTournoi`) REFERENCES `Tournois` (`IdTournoi`);

--
-- Contraintes pour la table `Equipe`
--
ALTER TABLE `Equipe`
  ADD CONSTRAINT `Equipe_ibfk_1` FOREIGN KEY (`IdJeu`) REFERENCES `Jeu` (`IdJeu`),
  ADD CONSTRAINT `Equipe_ibfk_2` FOREIGN KEY (`IDEcurie`) REFERENCES `Ecurie` (`IDEcurie`);

--
-- Contraintes pour la table `Faire_partie`
--
ALTER TABLE `Faire_partie`
  ADD CONSTRAINT `Faire_partie_ibfk_1` FOREIGN KEY (`IdPoule`) REFERENCES `Poule` (`IdPoule`),
  ADD CONSTRAINT `Faire_partie_ibfk_2` FOREIGN KEY (`IdEquipe`) REFERENCES `Equipe` (`IdEquipe`);

--
-- Contraintes pour la table `Joueur`
--
ALTER TABLE `Joueur`
  ADD CONSTRAINT `Joueur_ibfk_1` FOREIGN KEY (`IdEquipe`) REFERENCES `Equipe` (`IdEquipe`);

--
-- Contraintes pour la table `MatchJ`
--
ALTER TABLE `MatchJ`
  ADD CONSTRAINT `MatchJ_ibfk_1` FOREIGN KEY (`IdPoule`) REFERENCES `Poule` (`IdPoule`);

--
-- Contraintes pour la table `Participer`
--
ALTER TABLE `Participer`
  ADD CONSTRAINT `Participer_ibfk_1` FOREIGN KEY (`IdTournoi`) REFERENCES `Tournois` (`IdTournoi`),
  ADD CONSTRAINT `Participer_ibfk_2` FOREIGN KEY (`IdEquipe`) REFERENCES `Equipe` (`IdEquipe`);

--
-- Contraintes pour la table `Poule`
--
ALTER TABLE `Poule`
  ADD CONSTRAINT `Poule_ibfk_1` FOREIGN KEY (`IdJeu`,`IdTournoi`) REFERENCES `Contenir` (`IdJeu`, `IdTournoi`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
