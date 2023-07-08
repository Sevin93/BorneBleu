-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:8889
-- Généré le : ven. 05 mai 2023 à 08:02
-- Version du serveur :  5.7.34
-- Version de PHP : 7.4.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `bornebleu`
--

-- --------------------------------------------------------

--
-- Structure de la table `bornes`
--

CREATE TABLE `bornes` (
  `id` int(11) NOT NULL,
  `numero_borne` int(11) NOT NULL,
  `nb_heure` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `bornes`
--

INSERT INTO `bornes` (`id`, `numero_borne`, `nb_heure`) VALUES
(1, 1, 0),
(2, 2, 0),
(3, 3, 0),
(4, 4, 0),
(5, 5, 0);

-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20230228162338', '2023-03-23 10:14:46', 26),
('DoctrineMigrations\\Version20230228162443', '2023-03-23 10:14:46', 13),
('DoctrineMigrations\\Version20230303092805', '2023-03-23 10:14:46', 67),
('DoctrineMigrations\\Version20230303124229', '2023-03-23 10:14:46', 9),
('DoctrineMigrations\\Version20230303124311', '2023-03-23 10:14:46', 9),
('DoctrineMigrations\\Version20230303124913', '2023-03-23 10:14:46', 36),
('DoctrineMigrations\\Version20230303125131', '2023-03-23 10:14:46', 28),
('DoctrineMigrations\\Version20230303131027', '2023-03-23 10:14:46', 11),
('DoctrineMigrations\\Version20230322174927', '2023-03-23 10:14:46', 23),
('DoctrineMigrations\\Version20230322181533', '2023-03-23 10:14:46', 40);

-- --------------------------------------------------------

--
-- Structure de la table `planning`
--

CREATE TABLE `planning` (
  `id` int(11) NOT NULL,
  `borne_id_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `date` date NOT NULL,
  `etat` tinyint(1) NOT NULL,
  `heure_debut` datetime NOT NULL,
  `heure_fin` datetime NOT NULL,
  `nb_heure` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `planning`
--

INSERT INTO `planning` (`id`, `borne_id_id`, `user_id`, `date`, `etat`, `heure_debut`, `heure_fin`, `nb_heure`) VALUES
(1, 1, 1, '2018-01-01', 0, '2018-01-01 09:00:00', '2018-01-01 12:00:00', 3),
(2, 2, 2, '2018-01-01', 0, '2018-01-01 13:00:00', '2018-01-01 17:00:00', 4),
(4, 1, 2, '2018-01-01', 0, '2018-01-01 00:00:00', '2018-01-01 00:00:00', 0),
(5, 2, 1, '2018-01-01', 0, '2018-01-01 00:00:00', '2018-01-01 00:00:00', 0);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` json NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `civilite` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `email`, `roles`, `password`, `civilite`, `nom`, `prenom`) VALUES
(1, 'sevinmigfer@gmail.com', '[\"ROLE_USER\"]', '$2y$13$4hN.KwQuJc6/sRtAHOEpxuapdYlmQEWUSXHtILarHXNt9UuDcLzS.', 'mme', 'sevin', 'sevin'),
(2, 'murat@gmail.com', '[\"ROLE_ADMIN\"]', '$2y$13$BwxU7ZihsNZzYtI6zC./jOb7JBsRHAVVloswJKU37Yr6WkZi3TTSK', 'mr', 'murat', 'murat'),
(3, 'sabri@gmail.com', '[]', '$2y$13$XiYngjK0wKyVWcK0EBFU3enOvEOE.P2l6JfYw0apRIOloGBXrooVa', 'Mr', 'migfer', 'sabri'),
(4, 'emilie@gmail.com', '[]', '$2y$13$b6GSP0La7hmRum2gYEu7n.0HqAfcZw.RgE//q7WUm.I40DJv1h2pm', 'mme', 'yang', 'mili');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `bornes`
--
ALTER TABLE `bornes`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Index pour la table `planning`
--
ALTER TABLE `planning`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_D499BFF6C5D72818` (`borne_id_id`),
  ADD KEY `IDX_D499BFF6A76ED395` (`user_id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `bornes`
--
ALTER TABLE `bornes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `planning`
--
ALTER TABLE `planning`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `planning`
--
ALTER TABLE `planning`
  ADD CONSTRAINT `FK_D499BFF6A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FK_D499BFF6C5D72818` FOREIGN KEY (`borne_id_id`) REFERENCES `bornes` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
