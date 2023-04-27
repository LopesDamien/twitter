-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : mer. 05 avr. 2023 à 17:10
-- Version du serveur : 10.5.18-MariaDB-0+deb11u1
-- Version de PHP : 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `connexion`
--

-- --------------------------------------------------------

--
-- Structure de la table `likes`
--

CREATE TABLE `likes` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `message_id` int(10) UNSIGNED NOT NULL,
  `countLikes` int(1) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `likes`
--

INSERT INTO `likes` (`id`, `user_id`, `message_id`, `countLikes`) VALUES
(60, 97, 468, 1),
(61, 88, 468, 1),
(62, 89, 468, 1);

-- --------------------------------------------------------

--
-- Structure de la table `messages`
--

CREATE TABLE `messages` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `message` text NOT NULL,
  `Date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `messages`
--

INSERT INTO `messages` (`id`, `user_id`, `avatar`, `message`, `Date`) VALUES
(468, 97, NULL, 'aaa', '2023-04-05 16:27:46'),
(469, 97, NULL, 'bbb', '2023-04-05 16:27:48'),
(470, 97, NULL, 'ccc', '2023-04-05 16:27:50');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `logname` varchar(50) NOT NULL,
  `logpass` varchar(50) NOT NULL,
  `logemail` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `logname`, `logpass`, `logemail`) VALUES
(1, 'root', 'roote', 'BelleGosse@gmail.com'),
(88, 'damienlps', 'dada', 'damso@gmail.Com'),
(89, 'dadadadada', 'adadadad', 'dadadada@gmail.com'),
(93, 'dlv', 'dada', 'damienlopes80@gmail.com'),
(95, 'test', 'test', 'test@gmail.com'),
(96, 'jesuite', 'jesuite', 'jesuite@gmail.com'),
(97, 'jean', 'jean', 'jean@gmail.com'),
(99, 'jcvdd', 'jcvdd', 'jcvdd@gmail.com'),
(100, 'tibo', 'tibo', 'tibo@gmail.com'),
(101, 'blunaax', 'root', 'tomlefevre60@gmail.com'),
(102, 'lucasfilm', '123456789', 'lucasburguet22020@gmail.com'),
(104, 'Anonymous', '1234', 'anonymous@gmail.com'),
(105, 'faustinou', 'fofo', 'faustinou@gmail.com');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_like` (`user_id`,`message_id`),
  ADD UNIQUE KEY `user_id` (`user_id`,`message_id`),
  ADD KEY `fk_user_id` (`user_id`),
  ADD KEY `fk_message_id` (`message_id`);

--
-- Index pour la table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `logname` (`logname`),
  ADD UNIQUE KEY `logemail` (`logemail`),
  ADD UNIQUE KEY `logname_2` (`logname`),
  ADD KEY `logname_3` (`logname`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `likes`
--
ALTER TABLE `likes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT pour la table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=471;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=111;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `likes`
--
ALTER TABLE `likes`
  ADD CONSTRAINT `fk_likes_message_id` FOREIGN KEY (`message_id`) REFERENCES `messages` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
