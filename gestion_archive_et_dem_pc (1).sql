-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mer. 06 sep. 2023 à 19:29
-- Version du serveur : 10.4.27-MariaDB
-- Version de PHP : 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `gestion_archive_et_dem_pc`
--

-- --------------------------------------------------------

--
-- Structure de la table `archive`
--

CREATE TABLE `archive` (
  `id` int(11) NOT NULL,
  `n_permis_archive` varchar(255) NOT NULL,
  `date_delivrance_archive` date NOT NULL,
  `nom_demande_permis_archive` varchar(255) NOT NULL,
  `nom_demande_alignement_archive` varchar(255) NOT NULL,
  `nom_autre_dossier_archive` varchar(255) NOT NULL,
  `date_descente` datetime NOT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `archive`
--

INSERT INTO `archive` (`id`, `n_permis_archive`, `date_delivrance_archive`, `nom_demande_permis_archive`, `nom_demande_alignement_archive`, `nom_autre_dossier_archive`, `date_descente`, `user_id`) VALUES
(1, '001/2023', '2023-09-11', 'Architecture-64d8953ed1ddc.pdf', 'Architecture-64d8953ed313b.pdf', 'Architecture-64d8953ed4464.pdf', '2023-09-03 00:00:00', 4),
(2, '002/2023', '2023-09-15', 'Architecture-64d8deae9e071.pdf', 'Architecture-64d8deae9edeb.pdf', 'Architecture-64d8deae9fdd4.pdf', '2023-06-14 00:00:00', 3),
(3, '003/2023', '2023-11-17', 'Architecture-64ec8b4a9f690.pdf', 'Architecture-64ec8b4aa0776.pdf', 'Architecture-64ec8b4aa1860.pdf', '2020-08-16 00:00:00', 4),
(4, '004/2023', '2023-10-18', '3-UML-64f0e5af724df.pdf', '3-UML-64f0e5af7354a.pdf', '3-UML-64f0e5af74724.pdf', '2023-10-14 00:00:00', 4),
(5, '005/2023', '2023-11-18', 'Architecture-64ec8ca823e53.pdf', 'Architecture-64ec8ca824e5c.pdf', 'Architecture-64ec8ca825e6e.pdf', '2020-09-17 00:00:00', 4),
(6, '006/2023', '2021-09-18', 'Architecture-64ec8ec00692e.pdf', 'Architecture-64ec8ec007ae9.pdf', 'Architecture-64ec8ec008b2d.pdf', '2025-10-19 00:00:00', 3),
(7, '007/2021', '2021-07-15', 'Architecture-64ec8ec00692e.pdf', 'Architecture-64ec8ec007ae9.pdf', 'Architecture-64ec8ec008b2d.pdf', '2025-10-19 00:00:00', 3),
(8, '008/2021', '2021-10-17', 'Architecture-64ec968175d30.pdf', 'Architecture-64ec968176e81.pdf', 'Architecture-64ec968178493.pdf', '2021-10-16 00:00:00', 3),
(9, '009/2021', '2021-10-15', 'electionNumerique-en-C-64f4364b4d0ea.pdf', 'pandas-64f4364b4de6a.pdf', 'electionNumerique-en-C-64f4364b509b9.pdf', '2022-10-19 00:00:00', 4),
(10, '010/2023', '2023-09-15', '3-UML-64f43669716a6.pdf', '3-UML-64f436697275c.pdf', '3-UML-64f4366973597.pdf', '2024-10-15 00:00:00', 4);

-- --------------------------------------------------------

--
-- Structure de la table `contenance`
--

CREATE TABLE `contenance` (
  `id` int(11) NOT NULL,
  `terrain_titre_id` int(11) DEFAULT NULL,
  `terrain_cf_id` int(11) DEFAULT NULL,
  `parcelle_id` int(11) DEFAULT NULL,
  `usage_batiment_contenance` varchar(50) DEFAULT NULL,
  `surface_occupe_contenance` varchar(255) DEFAULT NULL,
  `nb_contenance` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `contenance`
--

INSERT INTO `contenance` (`id`, `terrain_titre_id`, `terrain_cf_id`, `parcelle_id`, `usage_batiment_contenance`, `surface_occupe_contenance`, `nb_contenance`) VALUES
(33, 30, NULL, NULL, 'Habitation', '60 m²', NULL),
(34, 30, NULL, NULL, 'Habitation', '37 m²', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `demande_envoye`
--

CREATE TABLE `demande_envoye` (
  `id` int(11) NOT NULL,
  `nom_demande_pc` varchar(255) NOT NULL,
  `nom_demande_alignement` varchar(255) NOT NULL,
  `nom_autre_dossier` varchar(255) NOT NULL,
  `date_envoie` date NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `rejete` tinyint(1) NOT NULL,
  `valide` tinyint(1) NOT NULL,
  `descente_termine` tinyint(1) NOT NULL,
  `date_descente` date DEFAULT NULL,
  `date_prise_version_physique_pc` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `demande_envoye`
--

INSERT INTO `demande_envoye` (`id`, `nom_demande_pc`, `nom_demande_alignement`, `nom_autre_dossier`, `date_envoie`, `user_id`, `rejete`, `valide`, `descente_termine`, `date_descente`, `date_prise_version_physique_pc`) VALUES
(7, 'Architecture-64ec8ca823e53.pdf', 'Architecture-64ec8ca824e5c.pdf', 'Architecture-64ec8ca825e6e.pdf', '2023-08-28', 4, 0, 1, 1, '2020-09-17', '2023-11-18'),
(9, 'Architecture-64ec8ec00692e.pdf', 'Architecture-64ec8ec007ae9.pdf', 'Architecture-64ec8ec008b2d.pdf', '2023-08-28', 3, 0, 1, 1, '2025-10-19', '2021-07-15'),
(11, '3-UML-64f0e5af724df.pdf', '3-UML-64f0e5af7354a.pdf', '3-UML-64f0e5af74724.pdf', '2023-08-31', 4, 0, 1, 1, '2023-10-14', '2023-10-18'),
(13, '3-UML-64f43669716a6.pdf', '3-UML-64f436697275c.pdf', '3-UML-64f4366973597.pdf', '2023-09-03', 4, 0, 1, 1, '2024-10-15', '2023-09-15'),
(15, 'Architecture-64f43e3a8d96e.pdf', 'Architecture-64f43e3a8e4cd.pdf', 'Architecture-64f43e3a8efdf.pdf', '2023-09-03', 4, 0, 1, 0, '2021-02-14', NULL),
(16, 'Architecture-64f43e4c3faac.pdf', 'Architecture-64f43e4c405b8.pdf', 'Architecture-64f43e4c41428.pdf', '2023-09-03', 4, 0, 0, 0, NULL, NULL),
(17, 'Architecture-64f43e72acc9c.pdf', 'Architecture-64f43e72b31ec.pdf', 'Architecture-64f43e72b3d42.pdf', '2023-09-03', 4, 0, 0, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20230727092339', '2023-07-27 11:24:04', 1791),
('DoctrineMigrations\\Version20230727094646', '2023-07-27 11:47:13', 3136),
('DoctrineMigrations\\Version20230727125607', '2023-07-27 14:56:16', 7103),
('DoctrineMigrations\\Version20230727131043', '2023-07-27 15:12:03', 785),
('DoctrineMigrations\\Version20230727133652', '2023-07-27 15:37:09', 270),
('DoctrineMigrations\\Version20230727134256', '2023-07-27 15:43:10', 3081),
('DoctrineMigrations\\Version20230730063045', '2023-07-30 08:31:11', 5509),
('DoctrineMigrations\\Version20230730063323', '2023-07-30 08:33:27', 790),
('DoctrineMigrations\\Version20230730070217', '2023-07-30 09:02:26', 4526),
('DoctrineMigrations\\Version20230730073736', '2023-07-30 09:37:56', 1329),
('DoctrineMigrations\\Version20230730073835', '2023-07-30 09:38:39', 3898),
('DoctrineMigrations\\Version20230730094702', '2023-07-30 11:47:47', 5218),
('DoctrineMigrations\\Version20230806112210', '2023-08-08 11:21:38', 24030),
('DoctrineMigrations\\Version20230814055246', '2023-08-14 07:53:21', 8145),
('DoctrineMigrations\\Version20230819121513', '2023-08-19 14:16:29', 2311),
('DoctrineMigrations\\Version20230820182015', '2023-08-20 20:20:59', 2870),
('DoctrineMigrations\\Version20230821122545', '2023-08-21 14:26:19', 2088),
('DoctrineMigrations\\Version20230822104126', '2023-08-22 12:41:51', 2797),
('DoctrineMigrations\\Version20230823044931', '2023-08-23 06:49:57', 1209),
('DoctrineMigrations\\Version20230823055132', '2023-08-23 07:51:38', 773),
('DoctrineMigrations\\Version20230823133600', '2023-08-23 15:36:23', 2771),
('DoctrineMigrations\\Version20230823142126', '2023-08-23 16:21:48', 1181),
('DoctrineMigrations\\Version20230823143854', '2023-08-23 16:38:59', 1019);

-- --------------------------------------------------------

--
-- Structure de la table `message`
--

CREATE TABLE `message` (
  `id` int(11) NOT NULL,
  `contenu_message` longtext NOT NULL,
  `type_message` varchar(100) NOT NULL,
  `message_checked` tinyint(1) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `date_envoie` datetime NOT NULL,
  `date_descente` datetime DEFAULT NULL,
  `date_prise_version_physique_pc` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `message`
--

INSERT INTO `message` (`id`, `contenu_message`, `type_message`, `message_checked`, `user_id`, `date_envoie`, `date_descente`, `date_prise_version_physique_pc`) VALUES
(14, 'rhyzsehedhg', 'Demande rejeté', 0, 3, '2023-08-28 14:09:47', NULL, NULL),
(15, 'sdhsedhedhs', 'Demande validé', 0, 3, '2023-08-28 14:11:14', '2025-10-19 17:17:00', NULL),
(17, 'Votre demande a été validé, veuillez nous contacter quand la date de descente sur terrain arrive, contacte: 0322909822', 'Demande validé', 0, 4, '2023-08-31 21:20:17', '2023-10-14 00:00:00', NULL),
(19, 'La descente sur terrain est terminée, veillez prendre la version physique de votre Permis de Construire quand la date prise version physique PC est arrivée, contacter nous 0338411689', 'Descente terminée', 0, 4, '2023-09-03 09:08:27', NULL, '2023-11-18 17:17:00'),
(20, 't\'tyé\"\'t\"gz\'gy', 'Descente terminée', 0, 3, '2023-09-03 09:15:11', NULL, '2021-09-18 16:15:00'),
(21, 'gzegzegze', 'Descente terminée', 0, 3, '2023-09-03 09:18:15', NULL, '2021-07-15 13:14:00'),
(22, 'fvaevazefva', 'Demande validé', 0, 3, '2023-09-03 09:19:50', '2021-10-16 16:16:00', NULL),
(23, 'sdfzegvez', 'Descente terminée', 0, 3, '2023-09-03 09:20:05', NULL, '2021-10-17 18:15:00'),
(28, 'Votre projet ne suis pas les règles d\'urbanisme en vigueur', 'Demande rejeté', 0, 4, '2023-09-03 10:08:23', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `messenger_messages`
--

CREATE TABLE `messenger_messages` (
  `id` bigint(20) NOT NULL,
  `body` longtext NOT NULL,
  `headers` longtext NOT NULL,
  `queue_name` varchar(190) NOT NULL,
  `created_at` datetime NOT NULL,
  `available_at` datetime NOT NULL,
  `delivered_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `parcelle`
--

CREATE TABLE `parcelle` (
  `id` int(11) NOT NULL,
  `terrain_cadastre_id` int(11) DEFAULT NULL,
  `proprietaire_parcelle_id` int(11) DEFAULT NULL,
  `n_parcelle` varchar(255) NOT NULL,
  `superficie_parcelle` varchar(255) NOT NULL,
  `image_parcelle` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `parcelle`
--

INSERT INTO `parcelle` (`id`, `terrain_cadastre_id`, `proprietaire_parcelle_id`, `n_parcelle`, `superficie_parcelle`, `image_parcelle`) VALUES
(1, 1, 1, '1', '50m²', 'emilio-garcia-AWdCgDDedH0-unsplash-1-64d210fa79620.jpg'),
(2, NULL, 2, '012MB', '400m²', 'ihliholihoih'),
(3, 1, 2, '121P', '400m²', 'zfaz'),
(4, 1, 2, '114H', '20m²', 'hkhikhu'),
(7, 1, 3, '2', '50m²', 'emilio-garcia-AWdCgDDedH0-unsplash-1-64d641e303729.jpg'),
(8, 4, 4, '1', '119,90 m²', 'LOVASOA-MANANA-1-64f450e81fecf.png');

-- --------------------------------------------------------

--
-- Structure de la table `proprietaire_parcelle`
--

CREATE TABLE `proprietaire_parcelle` (
  `id` int(11) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `date_naissance` date NOT NULL,
  `telephone` varchar(20) NOT NULL,
  `adresse` varchar(50) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `cin` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `proprietaire_parcelle`
--

INSERT INTO `proprietaire_parcelle` (`id`, `nom`, `prenom`, `date_naissance`, `telephone`, `adresse`, `email`, `cin`) VALUES
(1, 'Rafiaro', 'Erc', '2023-08-08', '0338411070', 'Ampatana', 'firao@gmail.com', '108034555020'),
(2, 'Iorenantsoa', 'Cédric kely', '2023-06-27', '0342034768', 'Apatana', 'antsamalalacedriciorenantsoa@gmail.com', '108031011202'),
(3, 'Fanomezantsoa', 'Ismael', '2013-08-07', '0322210154', 'Bemasoandro', 'ismael@gmail.com', '108031011191'),
(4, 'RANAIVOLANJA', 'Mioty Lova', '1990-06-10', '0322201114', 'Mahafaly', 'mioty@gmail.com', '108077144025');

-- --------------------------------------------------------

--
-- Structure de la table `proprietaire_terrain_cf`
--

CREATE TABLE `proprietaire_terrain_cf` (
  `id` int(11) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `date_naissance` date NOT NULL,
  `telephone` varchar(20) NOT NULL,
  `adresse` varchar(50) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `cin` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `proprietaire_terrain_cf`
--

INSERT INTO `proprietaire_terrain_cf` (`id`, `nom`, `prenom`, `date_naissance`, `telephone`, `adresse`, `email`, `cin`) VALUES
(8, 'Iorenantsoa', 'Cédric Kely', '2023-06-27', '0342034768', 'Apatana', 'antsamalalacedriciorenantsoa@gmail.com', '108031011202'),
(9, 'RANJA', 'Mialy Niony', '1976-02-12', '0345879152', '023-A-12', 'niony@gmail.com', '108598447111'),
(10, 'NARINDRA', 'Rajo Mahefa', '1984-03-07', '0342034786', '0397DS457 Ambohimiandrisoa', 'narindra@gmail.com', '101489756241');

-- --------------------------------------------------------

--
-- Structure de la table `proprietaire_terrain_titre`
--

CREATE TABLE `proprietaire_terrain_titre` (
  `id` int(11) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `date_naissance` date NOT NULL,
  `telephone` varchar(20) NOT NULL,
  `adresse` varchar(50) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `cin` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `proprietaire_terrain_titre`
--

INSERT INTO `proprietaire_terrain_titre` (`id`, `nom`, `prenom`, `date_naissance`, `telephone`, `adresse`, `email`, `cin`) VALUES
(9, 'Iorenantsoa', 'Cédric kely', '2023-06-27', '0342034768', 'Apatana', 'antsamalalacedriciorenantsoa@gmail.com', '108031011202'),
(11, 'Fiaro', 'Erc', '2023-07-31', '0346476541', 'Androvakely', 'fiaro@gmail.com', '108987456321'),
(12, 'LINJANIRINA', 'Herivola', '1995-01-01', '0332101000', 'Verezambola', 'herivola@gmail.com', '108031020110'),
(13, 'HERIMILANTO', 'Michaella', '2000-12-20', '0330101101', 'Verezambola', 'michaella@gamil.com', '108014200030'),
(14, 'RIJALALINA', 'Ny Havana', '1980-12-23', '0331120000', 'Verezambola', 'havana@gamil.com', '108500060123');

-- --------------------------------------------------------

--
-- Structure de la table `terrain_cadastre`
--

CREATE TABLE `terrain_cadastre` (
  `id` int(11) NOT NULL,
  `n_titre` varchar(255) NOT NULL,
  `fkt` varchar(50) NOT NULL,
  `zone_pudi` varchar(20) NOT NULL,
  `superficie` varchar(255) NOT NULL,
  `nom_cadastre` varchar(50) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `nb_parcelle` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `terrain_cadastre`
--

INSERT INTO `terrain_cadastre` (`id`, `n_titre`, `fkt`, `zone_pudi`, `superficie`, `nom_cadastre`, `image`, `nb_parcelle`) VALUES
(1, '1455-P', 'Ampatana', 'constructible', '400m²', 'Fanorenana', 'Evaluer-les-eleves-a-distance-64d20e5931c5c.jpg', 3),
(4, '13548-P', 'Mahafaly', 'constructible', '839,51 m²', 'Lovasoa Manana', 'Cadastre-64f4503d38737.png', 7);

-- --------------------------------------------------------

--
-- Structure de la table `terrain_cf`
--

CREATE TABLE `terrain_cf` (
  `id` int(11) NOT NULL,
  `n_certificat` varchar(255) NOT NULL,
  `fkt` varchar(50) NOT NULL,
  `zone_pudi` varchar(20) NOT NULL,
  `superficie` varchar(255) NOT NULL,
  `nom_terrain_cf` varchar(100) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `proprietaire_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `terrain_cf`
--

INSERT INTO `terrain_cf` (`id`, `n_certificat`, `fkt`, `zone_pudi`, `superficie`, `nom_terrain_cf`, `image`, `proprietaire_id`) VALUES
(8, '10245-P', 'Mahafaly', 'Constructible', '141,10 m²', 'BARISOA', 'BARISOA-64ec9d9512856.png', 9),
(9, '4597-P', 'Mahafaly', 'Constructible', '163.38m²', 'Mahandry', 'MAHANDRY-64eca058b2fb0.png', 10);

-- --------------------------------------------------------

--
-- Structure de la table `terrain_titre`
--

CREATE TABLE `terrain_titre` (
  `id` int(11) NOT NULL,
  `n_titre` varchar(255) NOT NULL,
  `fkt` varchar(50) NOT NULL,
  `zone_pudi` varchar(20) NOT NULL,
  `superficie` varchar(255) NOT NULL,
  `nom_terrain_titre` varchar(100) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `proprietaire_terrain_titre_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `terrain_titre`
--

INSERT INTO `terrain_titre` (`id`, `n_titre`, `fkt`, `zone_pudi`, `superficie`, `nom_terrain_titre`, `image`, `proprietaire_terrain_titre_id`) VALUES
(23, '14563P', 'Apatana', 'constructible', '785m²', 'Fananana', 'FB-IMG-16586823312443759-64c89de193684.jpg', 11),
(24, '88856P', 'Ambalavato', 'constructible', '900m²', 'tsarasoa', 'Carte-SOFIA-64c8b62a61eab.png', 11),
(25, '88856P', 'Ambalavato', 'constructible', '800m²', 'Lova', NULL, 9),
(28, '13562-P', 'Verezambola', 'Inconstructible', '256,96 m²', 'Niry', 'NIRY-64f44a15eba0d.png', 12),
(29, '15644-P', 'Verezambola', 'Inconstructible', '2602,67 m²', 'Miova', 'MIOVA-64f44b3201795.png', 13),
(30, '22156-P', 'Verezambola', 'constructible', '280 m²', 'Lala', 'LALA-64f44c274c88a.png', 14);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `cin` varchar(180) NOT NULL,
  `roles` longtext NOT NULL COMMENT '(DC2Type:json)',
  `password` varchar(255) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `adresse` varchar(100) NOT NULL,
  `date_naissance` date NOT NULL,
  `telephone` varchar(20) NOT NULL,
  `email` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `cin`, `roles`, `password`, `nom`, `prenom`, `adresse`, `date_naissance`, `telephone`, `email`) VALUES
(1, '108031011190', '[\"ROLE_ADMIN\"]', '$2y$13$KCJlJlVDvuWzUCGD30bbyO9blJlkPPAAt17EIRO55Yj44GGuDALTq', 'Admin', 'Admin', 'a', '2023-07-30', '0342034768', 'admin@gmail.com'),
(2, '101981109495', '[\"ROLE_USER\"]', '$2y$13$UUfxkJxPtZHe9pyzwu8nAON8fpaUu.HMnstnUTOOQ9sp/WTxnwZw.', 'Iorenantsoa', 'Cédric Antsamalala', 'a', '2023-07-30', '0342034768', 'antsamalalacedriciorenantsoa@gmail.com'),
(3, '108031011202', '[\"ROLE_USER\"]', '$2y$13$hegQHvriiMZ58N1RarU0LOD8pOUHgoJz0MSCFW01BrT2jihWXHx7m', 'Iorenantsoa', 'Cédric kely', 'Apatana', '2023-06-27', '0342034768', 'antsamalalacedriciorenantsoa@gmail.com'),
(4, '108031011191', '[\"ROLE_USER\"]', '$2y$13$XsJCXo8qBKpT3cakT0hOaujN9CG7KnOF84zzCHDnELRB6pYmeGgQe', 'Fanomezantsoa', 'Ismael', 'Bemasoandro', '2013-08-07', '0322210154', 'ismael@gmail.com'),
(5, '108500060123', '[\"ROLE_USER\"]', '$2y$13$.QAU2yELtysjYHHjVq1xEeXzwnqDRR.j9ebbKUWp/9Igrtq1VrOva', 'RIJALALINA', 'Ny Havana', 'Verezambola', '1980-12-23', '0331120000', 'havana@gamil.com');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `archive`
--
ALTER TABLE `archive`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_D5FC5D9CA76ED395` (`user_id`);

--
-- Index pour la table `contenance`
--
ALTER TABLE `contenance`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_4B2653FBD3AB20D` (`terrain_titre_id`),
  ADD KEY `IDX_4B2653FB6A08EF92` (`terrain_cf_id`),
  ADD KEY `IDX_4B2653FB4433ED66` (`parcelle_id`);

--
-- Index pour la table `demande_envoye`
--
ALTER TABLE `demande_envoye`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_434794BCA76ED395` (`user_id`);

--
-- Index pour la table `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Index pour la table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_B6BD307FA76ED395` (`user_id`);

--
-- Index pour la table `messenger_messages`
--
ALTER TABLE `messenger_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  ADD KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  ADD KEY `IDX_75EA56E016BA31DB` (`delivered_at`);

--
-- Index pour la table `parcelle`
--
ALTER TABLE `parcelle`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_C56E2CF672613B14` (`terrain_cadastre_id`),
  ADD KEY `IDX_C56E2CF6274081C8` (`proprietaire_parcelle_id`);

--
-- Index pour la table `proprietaire_parcelle`
--
ALTER TABLE `proprietaire_parcelle`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `proprietaire_terrain_cf`
--
ALTER TABLE `proprietaire_terrain_cf`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `proprietaire_terrain_titre`
--
ALTER TABLE `proprietaire_terrain_titre`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `terrain_cadastre`
--
ALTER TABLE `terrain_cadastre`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `terrain_cf`
--
ALTER TABLE `terrain_cf`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_9ECC02E776C50E4A` (`proprietaire_id`);

--
-- Index pour la table `terrain_titre`
--
ALTER TABLE `terrain_titre`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_A82E65BABBA352C` (`proprietaire_terrain_titre_id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_8D93D649ABE530DA` (`cin`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `archive`
--
ALTER TABLE `archive`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `contenance`
--
ALTER TABLE `contenance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT pour la table `demande_envoye`
--
ALTER TABLE `demande_envoye`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT pour la table `message`
--
ALTER TABLE `message`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT pour la table `messenger_messages`
--
ALTER TABLE `messenger_messages`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `parcelle`
--
ALTER TABLE `parcelle`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `proprietaire_parcelle`
--
ALTER TABLE `proprietaire_parcelle`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `proprietaire_terrain_cf`
--
ALTER TABLE `proprietaire_terrain_cf`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `proprietaire_terrain_titre`
--
ALTER TABLE `proprietaire_terrain_titre`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT pour la table `terrain_cadastre`
--
ALTER TABLE `terrain_cadastre`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `terrain_cf`
--
ALTER TABLE `terrain_cf`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `terrain_titre`
--
ALTER TABLE `terrain_titre`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `archive`
--
ALTER TABLE `archive`
  ADD CONSTRAINT `FK_D5FC5D9CA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `contenance`
--
ALTER TABLE `contenance`
  ADD CONSTRAINT `FK_4B2653FB4433ED66` FOREIGN KEY (`parcelle_id`) REFERENCES `parcelle` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_4B2653FB6A08EF92` FOREIGN KEY (`terrain_cf_id`) REFERENCES `terrain_cf` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_4B2653FBD3AB20D` FOREIGN KEY (`terrain_titre_id`) REFERENCES `terrain_titre` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `demande_envoye`
--
ALTER TABLE `demande_envoye`
  ADD CONSTRAINT `FK_434794BCA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON UPDATE CASCADE;

--
-- Contraintes pour la table `message`
--
ALTER TABLE `message`
  ADD CONSTRAINT `FK_B6BD307FA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `parcelle`
--
ALTER TABLE `parcelle`
  ADD CONSTRAINT `FK_C56E2CF6274081C8` FOREIGN KEY (`proprietaire_parcelle_id`) REFERENCES `proprietaire_parcelle` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_C56E2CF672613B14` FOREIGN KEY (`terrain_cadastre_id`) REFERENCES `terrain_cadastre` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `terrain_cf`
--
ALTER TABLE `terrain_cf`
  ADD CONSTRAINT `FK_9ECC02E776C50E4A` FOREIGN KEY (`proprietaire_id`) REFERENCES `proprietaire_terrain_cf` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `terrain_titre`
--
ALTER TABLE `terrain_titre`
  ADD CONSTRAINT `FK_A82E65BABBA352C` FOREIGN KEY (`proprietaire_terrain_titre_id`) REFERENCES `proprietaire_terrain_titre` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
