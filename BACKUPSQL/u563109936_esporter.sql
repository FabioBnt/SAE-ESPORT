-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : ven. 27 jan. 2023 à 22:54
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
-- Base de données : `u563109936_esporter`
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
(8, 964, 1, 4),
(8, 964, 2, 4),
(8, 964, 3, 4),
(8, 1038, 1, 5),
(8, 1038, 2, 4),
(8, 1038, 3, 2),
(9, 965, 1, 1),
(9, 965, 2, 1),
(9, 965, 3, 1),
(10, 3, 1, 3),
(10, 3, 2, 3),
(10, 3, 3, 3),
(11, 3, 1, 2),
(11, 3, 4, 2),
(11, 3, 5, 2),
(12, 3, 2, 3),
(12, 3, 4, 3),
(12, 3, 6, 3),
(13, 3, 3, 3),
(13, 3, 5, 4),
(13, 3, 6, 6),
(13, 7, 1, 3),
(13, 7, 2, 0),
(13, 7, 3, 2),
(14, 4, 1, 2),
(14, 4, 2, 1),
(14, 4, 3, 0),
(15, 4, 1, 3),
(15, 4, 4, 2),
(15, 4, 5, 2),
(16, 4, 2, 4),
(16, 4, 4, 1),
(16, 4, 6, 1),
(17, 4, 3, 4),
(17, 4, 5, 4),
(17, 4, 6, 3),
(17, 7, 1, 2),
(17, 7, 4, 2),
(17, 7, 5, 2),
(18, 5, 1, 0),
(18, 5, 2, 2),
(18, 5, 3, 2),
(19, 5, 1, 3),
(19, 5, 4, 3),
(19, 5, 5, 3),
(20, 5, 2, 4),
(20, 5, 4, 4),
(20, 5, 6, 4),
(20, 7, 2, 3),
(20, 7, 4, 2),
(20, 7, 6, 0),
(21, 5, 3, 2),
(21, 5, 5, 1),
(21, 5, 6, 2),
(22, 6, 1, 1),
(22, 6, 2, 1),
(22, 6, 3, 2),
(23, 6, 1, 1),
(23, 6, 4, 1),
(23, 6, 5, 0),
(24, 6, 2, 6),
(24, 6, 4, 4),
(24, 6, 6, 7),
(24, 7, 3, 4),
(24, 7, 5, 4),
(24, 7, 6, 4),
(25, 6, 3, 0),
(25, 6, 5, 1),
(25, 6, 6, 3),
(31, 966, 1, 1),
(31, 966, 2, 1),
(31, 966, 3, 1),
(36, 967, 1, 1),
(36, 967, 2, 1),
(36, 967, 3, 1),
(37, 964, 1, 2),
(37, 964, 4, 2),
(37, 964, 5, 2),
(38, 965, 1, 2),
(38, 965, 4, 2),
(38, 965, 5, 2),
(39, 966, 1, 2),
(39, 966, 4, 2),
(39, 966, 5, 2),
(41, 967, 1, 1),
(41, 967, 4, 1),
(41, 967, 5, 1),
(43, 964, 2, 2),
(43, 964, 4, 2),
(43, 964, 6, 2),
(44, 965, 2, 3),
(44, 965, 4, 3),
(44, 965, 6, 3),
(44, 1038, 1, 2),
(44, 1038, 4, 2),
(44, 1038, 5, 2),
(45, 966, 2, 4),
(45, 966, 4, 4),
(45, 966, 6, 4),
(45, 1038, 2, 2),
(45, 1038, 4, 2),
(45, 1038, 6, 3),
(46, 967, 2, 5),
(46, 967, 4, 5),
(46, 967, 6, 5),
(46, 1038, 3, 4),
(46, 1038, 5, 5),
(46, 1038, 6, 3),
(47, 964, 3, 2),
(47, 964, 5, 2),
(47, 964, 6, 2),
(48, 965, 3, 1),
(48, 965, 5, 1),
(48, 965, 6, 1),
(50, 966, 3, 1),
(50, 966, 5, 1),
(50, 966, 6, 1),
(51, 967, 3, 2),
(51, 967, 5, 2),
(51, 967, 6, 2);

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
(2, 2),
(2, 393),
(3, 3),
(3, 11),
(4, 176),
(5, 4),
(5, 8),
(6, 7),
(6, 9),
(6, 287),
(7, 176),
(7, 287),
(8, 11),
(9, 5),
(9, 14),
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
(1, 'KCorp', 'Professionnelle', 'KCorpAdmin', 'mdpKCorp'),
(2, 'ParisGaming', 'Professionnelle', 'PGAdmin', 'mdpPG'),
(3, 'TurcoingGames', 'Associative', 'TGamesAdmin', 'mdpTG'),
(4, 'Vitality', 'Professionnelle', 'VitAdmin', 'mdpVita'),
(5, 'OlympeGaming', 'Associative', 'OgAdmin', 'mdpOG'),
(6, 'BlueDiamond', 'Professionnelle', 'BDiamondAdmin', 'mdpBDiamond'),
(7, 'Mindset', 'Associative', 'MSAdmin', 'mdpMind'),
(8, 'Cloud9', 'Professionnelle', 'C9Admin', 'mdpc9'),
(9, 'Fnatic', 'Professionnelle', 'FnatAdmin', 'mdpfnat'),
(10, 'TorontoDefiant', 'Professionnelle', 'TDAdmin', 'mdpTD'),
(11, 'SparklingRose', 'Associative', 'SRAdmin', 'mdpSR'),
(12, 'LargeBlackRooster', 'Associative', 'LBRAdmin', 'mdpLBR'),
(13, 'JoyfulBird', 'Associative', 'JBAdmin', 'mdpJB'),
(14, 'DependentChicks', 'Professionnelle', 'DependentAdmin', 'mdpDependentC'),
(15, 'SmartBeaver', 'Professionnelle', 'SmartAdmin', 'mdpSmartB'),
(16, 'HornedOwl', 'Associative', 'HOAdmin', 'mdpHOwl'),
(17, 'EnragedBackhoeGaming', 'Associative', 'EnrBackAdmin', 'mdpEnrBackhoe'),
(18, 'PavingFloor', 'Associative', 'PFAdmin', 'mdpPF'),
(19, 'ThunderWaves', 'Professionnelle', 'TWAdmin', 'mdpTW'),
(20, 'YatoGaming', 'Associative', 'yatoAdmin', 'mdpYato'),
(21, 'Logi', 'Associative', 'LogiAdmin', 'mdpLogi'),
(22, 'PokeFighting', 'Associative', 'PokeAdmin', 'mdpPF'),
(207, 'TOTAgaming', 'Associative', 'TOTAgamingAdmin', 'mdpTOTAgaming'),
(208, 'EnjoyM', 'Professionnelle', 'EnjoyMAdmin', 'mdpEnjoyM'),
(239, 'SmashTeam', 'Associative', 'SMASHTAdmin', 'mdpSMASHTEAM'),
(285, 'HALO', 'Professionnelle', 'HALOCompte', 'mdpHALO');

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
(1, 'KCorpLoL', 'KCorpLoLCompte', 'PasswordKcorplol', NULL, 1, 1),
(2, 'KCorpFifa', 'KCorpFifaCompte', 'PasswordKCorpFifa', NULL, 9, 1),
(3, 'VitalityFifa', 'VitalityFifaCompte', 'PasswordVitalityFifa', NULL, 9, 4),
(4, 'LargeBlackRoosterFifa', 'LBRCom', 'PasswordLBR', NULL, 9, 12),
(5, 'JoyfulBirdDota2', 'JoyfulBirdCompte', 'PasswordJoyfulBird', NULL, 4, 13),
(6, 'HornedOwlOverwatch', 'HornedOwlCompte', 'PasswordHO', NULL, 5, 16),
(7, 'TorontoDefiantOverwatch', 'TorontoDefiantCompte', 'PasswordTorontoDefiant', NULL, 5, 10),
(8, 'Cloud9Fortnite', 'Cloud9FortniteCompte', 'PasswordCloud9Fortnite', 130, 2, 8),
(9, 'SmartBeaverFortnite', 'SBFCompte', 'PasswordSBF', NULL, 2, 15),
(10, 'KCorpValorant', 'KCVCompte', 'PasswordKVC', NULL, 8, 1),
(11, 'ParisGamingValorant', 'PGVCompte', 'PasswordPGV', NULL, 8, 2),
(12, 'TurcoingGamesValorant', 'TGVCompte', 'PasswordTGV', NULL, 8, 3),
(13, 'VitalityValorant', 'VVCompte', 'PasswordVV', 185, 8, 4),
(14, 'OlympeGamingValorant', 'OGVCompte', 'PasswordOGV', NULL, 8, 5),
(15, 'BlueDiamondValorant', 'BDVCompte', 'PasswordBDV', NULL, 8, 6),
(16, 'MindsetValorant', 'MVCompte', 'PasswordMV', NULL, 8, 7),
(17, 'Cloud9Valorant', 'C9VCompte', 'PasswordC9V', 35, 8, 8),
(18, 'FnaticValorant', 'FVCompte', 'PasswordFV', NULL, 8, 9),
(19, 'TorontoDefiantValorant', 'TDVCompte', 'PasswordTDV', NULL, 8, 10),
(20, 'SparklingRoseValorant', 'SRVCompte', 'PasswordSRV', 95, 8, 11),
(21, 'LargeBlackRoosterValorant', 'LBRVCompte', 'PasswordLBRV', NULL, 8, 12),
(22, 'JoyfulBirdValorant', 'JBVCompte', 'PasswordJBV', NULL, 8, 13),
(23, 'DependentChicksValorant', 'DCVCompte', 'PasswordDCV', NULL, 8, 14),
(24, 'SmartBeaverValorant', 'SBVCompte', 'PasswordSBV', 315, 8, 15),
(25, 'HornedOwlValorant', 'HOVCompte', 'PasswordHOV', NULL, 8, 16),
(26, 'EBGValorant', 'EBGCompte', 'PasswordEBG', NULL, 8, 17),
(27, 'PavingFloorApexLegends', 'PFALCompte', 'PasswordPFAL', NULL, 3, 18),
(28, 'TorontoDefiantCSGO', 'TDCSCompte', 'PasswordTDCS', NULL, 6, 10),
(29, 'VitalityStarCraft', 'VSCCompte', 'PasswordVSC', NULL, 7, 4),
(30, 'HornedOwlRocketLeague', 'HORLCompte', 'PasswordHORL', NULL, 10, 16),
(31, 'KCorpFortnite', 'KCorpFortniteCompte', 'PasswordKCorpFortnite', NULL, 2, 1),
(32, 'FnaticApex', 'FACompte', 'PasswordFA', NULL, 3, 9),
(33, 'FnaticCSGO', 'FCSGOCompte', 'PasswordFCSGO', NULL, 6, 9),
(34, 'FnaticDota', 'FDCompte', 'PasswordFD', NULL, 4, 9),
(35, 'FnaticOverwatch', 'FOCompte', 'PasswordFO', NULL, 5, 9),
(36, 'MindsetFortnite', 'MindsetFortniteCompt', 'PasswordMindsetFortnite', NULL, 2, 7),
(37, 'PavingFloorFortnite', 'PFFCompte', 'PasswordPFF', NULL, 2, 18),
(38, 'ThunderWavesFortnite', 'TWFCompte', 'PasswordTWF', NULL, 2, 19),
(39, 'LogiFortnite', 'LogiFortniteCompte', 'PasswordLogiFortnite', NULL, 2, 21),
(41, 'JoyfulBirdFortnite', 'JBFCompte', 'PasswordJBFortnite', NULL, 2, 13),
(42, 'SmashTeamValorant', 'SmashTeamCompte', 'PasswordSmashTeam', NULL, 8, 239),
(43, 'TorontoDefiantFortnite', 'TDFCompte', 'PasswordTDF', NULL, 2, 10),
(44, 'OlympeGamingFortnite', 'OGFCompte', 'PasswordOGF', 20, 2, 5),
(45, 'DependentChicksFortnite', 'DCFCompte', 'PasswordDCF', 60, 2, 14),
(46, 'YatoGamingFortnite', 'YGFCompte', 'PasswordYGF', 210, 2, 20),
(47, 'EBGFortnite', 'EBGFCompte', 'PasswordEBG', NULL, 2, 17),
(48, 'FnaticFortnite', 'FnaticFCompte', 'PasswordFnaticF', NULL, 2, 9),
(49, 'PokeFightingFortnite', 'PFFCompte', 'PasswordPFF', NULL, 2, 22),
(50, 'TurcoingGamesFortnite', 'TGFCompte', 'PasswordTGF', NULL, 2, 3),
(51, 'EnjoyMFortnite', 'EnjoyMFCompte', 'PasswordEnjoyMF', NULL, 2, 208),
(52, 'ParisGamingFortnite', 'PGFCompte', 'PasswordParisGF', NULL, 2, 2);

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
(3, 10),
(3, 11),
(3, 12),
(3, 13),
(4, 14),
(4, 15),
(4, 16),
(4, 17),
(5, 18),
(5, 19),
(5, 20),
(5, 21),
(6, 22),
(6, 23),
(6, 24),
(6, 25),
(7, 13),
(7, 17),
(7, 20),
(7, 24),
(964, 8),
(964, 37),
(964, 43),
(964, 47),
(965, 9),
(965, 38),
(965, 44),
(965, 48),
(966, 31),
(966, 39),
(966, 45),
(966, 50),
(967, 36),
(967, 41),
(967, 46),
(967, 51),
(1038, 8),
(1038, 44),
(1038, 45),
(1038, 46);

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
(1, 'League Of Legends', 'MOBA', 30, 40),
(2, 'Fortnite', 'BattleRoyale', 40, 35),
(3, 'ApexLegends', 'BattleRoyale', 25, 27),
(4, 'Dota2', 'MOBA', 30, 38),
(5, 'Overwatch', 'FPS', 15, 25),
(6, 'CSGO', 'FPS', 35, 32),
(7, 'StarCraft', 'RTS', 20, 25),
(8, 'Valorant', 'FPS', 35, 29),
(9, 'Fifa', 'Sport', 12, 25),
(10, 'RocketLeague', 'Sport', 20, 15);

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
(1, 'Chalumeau', 'FR', 12),
(2, 'Menwizz', 'FR', 12),
(3, 'El_Fabio', 'FR', 12),
(4, 'Tyg', 'FR', 12),
(5, 'Jean', 'FR', 11),
(6, 'Poko', 'FR', 15),
(7, 'nero', 'US', 15),
(8, 'Marvel', 'KR', 15),
(9, 'Fits', 'KR', 15),
(10, 'BEBE', 'KR', 8),
(11, 'Flora', 'KR', 8),
(12, 'LIGE', 'CN', 8),
(13, 'GAGA', 'CN', 8),
(14, 'MCD', 'IT', 17),
(15, 'LeeJaeGon', 'KR', 17),
(16, 'Someone', 'DE', 17),
(17, 'OPENER', 'IR', 17),
(18, 'Profit', 'JP', 1),
(19, 'Architect', 'MX', 1),
(20, 'Soon', 'FR', 10),
(21, 'FEARLESS', 'US', 1),
(22, 'Happy', 'CA', 1),
(23, 'shu', 'KR', 2),
(24, 'Faith', 'US', 2),
(25, 'Valentine', 'ES', 2),
(26, 'MuZe', 'KR', 2),
(27, 'Xzi', 'PT', 3),
(28, 'PELICAN', 'KR', 3),
(29, 'kevster', 'SE', 3),
(30, 'Creative', 'US', 3),
(31, 'Doha', 'RU', 4),
(32, 'Lastro', 'KR', 4),
(33, 'Becky', 'KR', 4),
(34, 'Danteh', 'US', 4),
(35, 'Guxue', 'CN', 5),
(36, 'Masaa', 'FI', 5),
(37, 'Coluge', 'US', 5),
(38, 'Shax', 'DK', 5),
(39, 'Gator', 'US', 6),
(40, 'Checkmate', 'KR', 6),
(41, 'Hanbin', 'JP', 6),
(42, 'Assassin', 'FR', 6),
(43, 'Nisha', 'CN', 9),
(44, 'SirMajed', 'SA', 9),
(45, 'Fate', 'KR', 9),
(46, 'Fleta', 'KR', 9),
(47, 'Violet', 'KR', 13),
(48, 'SASIN', 'CN', 13),
(49, 'MAG', 'CA', 13),
(50, 'Ojee', 'US', 13),
(51, 'Yaki', 'KR', 16),
(52, 'BERNAR', 'KR', 16),
(53, 'Farway1987', 'CN', 16),
(54, 'SP9RK1E', 'KR', 16),
(55, 'WhoRu', 'KR', 18),
(56, 'Heesu', 'KR', 19),
(57, 'CHORONG', 'KR', 19),
(58, 'ZEST', 'US', 20),
(59, 'Venom', 'GB', 22),
(60, 'MN3', 'MX', 22),
(61, 'Kalios', 'KR', 22),
(62, 'Krillin', 'VE', 22),
(63, 'Lengsa', 'CN', 23),
(64, 'ChoiSehwan', 'KR', 23),
(65, 'Piggy', 'KR', 23),
(66, 'Aspire', 'US', 25),
(67, 'shy', 'SN', 25),
(68, 'Hadi', 'DE', 25),
(69, 'Hawk', 'US', 25),
(70, 'Jimmy', 'CN', 28),
(71, 'guriyo', 'KR', 28),
(72, 'Backbone', 'GB', 28),
(73, 'STRIKER', 'KR', 29),
(74, 'Void', 'KR', 30),
(75, 'FunnyAstro', 'GB', 30),
(76, 'Although', 'KR', 30),
(77, 'Kaan', 'DE', 30),
(78, 'Antoine', 'FR', 32),
(79, 'Etienne', 'JA', 32),
(80, 'LEO', 'EN', 32),
(81, 'Juli1', 'ES', 32),
(86, 'Michel', 'DE', 35),
(87, 'Victor', 'FR', 35),
(88, 'Teo', 'FR', 42);

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
(3, 1, '2023-01-05', '15:00:00'),
(3, 2, '2023-01-05', '16:00:00'),
(3, 3, '2023-01-05', '17:00:00'),
(3, 4, '2023-01-05', '18:00:00'),
(3, 5, '2023-01-05', '19:00:00'),
(3, 6, '2023-01-05', '20:00:00'),
(4, 1, '2023-01-06', '14:00:00'),
(4, 2, '2023-01-06', '15:00:00'),
(4, 3, '2023-01-06', '16:00:00'),
(4, 4, '2023-01-06', '17:00:00'),
(4, 5, '2023-01-06', '18:00:00'),
(4, 6, '2023-01-06', '19:00:00'),
(5, 1, '2023-01-07', '15:00:00'),
(5, 2, '2023-01-07', '16:00:00'),
(5, 3, '2023-01-07', '17:00:00'),
(5, 4, '2023-01-07', '18:00:00'),
(5, 5, '2023-01-07', '19:00:00'),
(5, 6, '2023-01-07', '20:00:00'),
(6, 1, '2023-01-08', '15:00:00'),
(6, 2, '2023-01-08', '16:00:00'),
(6, 3, '2023-01-08', '17:00:00'),
(6, 4, '2023-01-08', '18:00:00'),
(6, 5, '2023-01-08', '19:00:00'),
(6, 6, '2023-01-08', '20:00:00'),
(7, 1, '2023-01-10', '15:00:00'),
(7, 2, '2023-01-10', '16:00:00'),
(7, 3, '2023-01-10', '17:00:00'),
(7, 4, '2023-01-10', '18:00:00'),
(7, 5, '2023-01-10', '19:00:00'),
(7, 6, '2023-01-10', '20:00:00'),
(964, 1, '2021-01-23', '03:01:00'),
(964, 2, '2021-01-23', '04:01:00'),
(964, 3, '2021-01-23', '06:01:00'),
(964, 4, '2021-01-23', '09:01:00'),
(964, 5, '2022-01-23', '01:01:00'),
(964, 6, '2022-01-23', '06:01:00'),
(965, 1, '2021-01-23', '03:01:00'),
(965, 2, '2021-01-23', '04:01:00'),
(965, 3, '2021-01-23', '06:01:00'),
(965, 4, '2021-01-23', '09:01:00'),
(965, 5, '2022-01-23', '01:01:00'),
(965, 6, '2022-01-23', '06:01:00'),
(966, 1, '2021-01-23', '03:01:00'),
(966, 2, '2021-01-23', '04:01:00'),
(966, 3, '2021-01-23', '06:01:00'),
(966, 4, '2021-01-23', '09:01:00'),
(966, 5, '2022-01-23', '01:01:00'),
(966, 6, '2022-01-23', '06:01:00'),
(967, 1, '2021-01-23', '03:01:00'),
(967, 2, '2021-01-23', '04:01:00'),
(967, 3, '2021-01-23', '06:01:00'),
(967, 4, '2021-01-23', '09:01:00'),
(967, 5, '2022-01-23', '01:01:00'),
(967, 6, '2022-01-23', '06:01:00'),
(1038, 1, '2019-01-23', '12:01:00'),
(1038, 2, '2019-01-23', '01:01:00'),
(1038, 3, '2019-01-23', '03:01:00'),
(1038, 4, '2019-01-23', '06:01:00'),
(1038, 5, '2019-01-23', '10:01:00'),
(1038, 6, '2019-01-23', '03:01:00');

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
(1, 1),
(11, 10),
(11, 11),
(11, 12),
(11, 13),
(11, 14),
(11, 15),
(11, 16),
(11, 17),
(11, 18),
(11, 19),
(11, 20),
(11, 21),
(11, 22),
(11, 23),
(11, 24),
(11, 25),
(393, 8),
(393, 9),
(393, 31),
(393, 36),
(393, 37),
(393, 38),
(393, 39),
(393, 41),
(393, 43),
(393, 44),
(393, 45),
(393, 46),
(393, 47),
(393, 48),
(393, 50),
(393, 51);

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
(3, 1, 0, 8, 11),
(4, 2, 0, 8, 11),
(5, 3, 0, 8, 11),
(6, 4, 0, 8, 11),
(7, 5, 1, 8, 11),
(964, 1, 0, 2, 393),
(965, 2, 0, 2, 393),
(966, 3, 0, 2, 393),
(967, 4, 0, 2, 393),
(1038, 5, 1, 2, 393);

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
(3, 'ANWC', 150000, 'International', 'Lyon', '2023-07-11 13:00:00'),
(7, 'CSGOT', 5000, 'Local', 'Toulouse', '2023-06-20 12:00:00'),
(5, 'FifaCup', 8500, 'Local', 'Paris', '2023-04-26 13:00:00'),
(2, 'FortniteLan', 1000, 'Local', 'EnLigne', '2023-05-19 15:41:32'),
(176, 'HorousGames', 3000, 'Regional', 'Amsterdam', '2023-06-20 16:00:00'),
(14, 'KalypsoTour', 5000, 'Local', 'Paris', '2023-06-24 16:00:00'),
(1, 'LEC', 1000000, 'International', 'Paris', '2023-01-05 14:00:00'),
(9, 'OcciTourney', 4000, 'Local', 'Toulouse', '2023-02-08 15:00:00'),
(4, 'OverwatchLeague', 45070, 'International', 'ArisonaCity', '2023-04-18 14:00:00'),
(8, 'OverwatchVOD', 25500, 'Local', 'Tokyo', '2023-02-17 12:00:00'),
(6, 'PistonCup', 458200, 'International', 'Dallas', '2023-05-23 12:00:00'),
(287, 'ToulouseGShow', 18500, 'Local', 'Toulouse', '2023-03-14 09:00:00'),
(393, 'TournoiTest', 15000, 'Regional', 'Toulouse', '2023-01-21 15:00:00'),
(11, 'VCS', 154000, 'International', 'Los Angeles', '2023-02-24 15:00:00');

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
  MODIFY `IDEcurie` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=287;

--
-- AUTO_INCREMENT pour la table `Equipe`
--
ALTER TABLE `Equipe`
  MODIFY `IdEquipe` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT pour la table `Jeu`
--
ALTER TABLE `Jeu`
  MODIFY `IdJeu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `Joueur`
--
ALTER TABLE `Joueur`
  MODIFY `IdJoueur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;

--
-- AUTO_INCREMENT pour la table `Poule`
--
ALTER TABLE `Poule`
  MODIFY `IdPoule` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1334;

--
-- AUTO_INCREMENT pour la table `Tournois`
--
ALTER TABLE `Tournois`
  MODIFY `IdTournoi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=530;

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
