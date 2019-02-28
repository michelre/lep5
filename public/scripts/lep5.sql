-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  jeu. 28 fév. 2019 à 17:26
-- Version du serveur :  5.7.23
-- Version de PHP :  7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `lep5`
--

-- --------------------------------------------------------

--
-- Structure de la table `articles`
--

DROP TABLE IF EXISTS `articles`;
CREATE TABLE IF NOT EXISTS `articles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `legend` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `creation_date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=170 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `articles`
--

INSERT INTO `articles` (`id`, `title`, `content`, `legend`, `image`, `creation_date`) VALUES
(167, 'test1', '<p>test1</p>', 'test1', '/public/uploads/5c77efbb94d3b.jpg', '2019-02-28'),
(168, 'test2', '<p>test2</p>', 'test2', '/public/uploads/5c77f00371993.jpg', '2019-02-28');

-- --------------------------------------------------------

--
-- Structure de la table `comments`
--

DROP TABLE IF EXISTS `comments`;
CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `article_id` int(11) NOT NULL,
  `author` varchar(255) NOT NULL,
  `comment` text NOT NULL,
  `comment_date` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `comments_ibfk_1` (`article_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `events`
--

DROP TABLE IF EXISTS `events`;
CREATE TABLE IF NOT EXISTS `events` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `states` text NOT NULL,
  `legend` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `event_date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `events`
--

INSERT INTO `events` (`id`, `title`, `states`, `legend`, `image`, `event_date`) VALUES
(50, 'test', '<p>test</p>', 'test', '/public/uploads/5c77f4ad9a576', '2019-02-28'),
(51, 'test2', '<p>test2</p>', 'test2', '/public/uploads/5c77fa11606dd', '2019-02-28'),
(52, 'test2', '<p>test2</p>', 'test2', '/public/uploads/5c77fa810643e', '2019-02-28'),
(53, 'test2', '<p>test2</p>', 'test2', '/public/uploads/5c77fd5e7de0c', '2019-02-28');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `pass` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `name`, `pass`) VALUES
(1, 'zarco', '$2y$10$RPOo3/8wTLsa4Qzmx/Flee.Q1ZhoPkb/qwchpu3qTFreuxxOYTMHW');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`article_id`) REFERENCES `articles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
