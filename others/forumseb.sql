-- --------------------------------------------------------
-- Hôte :                        127.0.0.1
-- Version du serveur:           5.7.24 - MySQL Community Server (GPL)
-- SE du serveur:                Win64
-- HeidiSQL Version:             10.2.0.5599
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Listage de la structure de la base pour forumseb
CREATE DATABASE IF NOT EXISTS `forumseb` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_bin */;
USE `forumseb`;

-- Listage de la structure de la table forumseb. category
CREATE TABLE IF NOT EXISTS `category` (
  `id_category` int(11) NOT NULL AUTO_INCREMENT,
  `categoryName` varchar(50) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id_category`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- Listage des données de la table forumseb.category : ~4 rows (environ)
/*!40000 ALTER TABLE `category` DISABLE KEYS */;
INSERT INTO `category` (`id_category`, `categoryName`) VALUES
	(1, 'Jeu-vidéo'),
	(2, 'Musique'),
	(3, 'Informatique'),
	(4, 'Nature');
/*!40000 ALTER TABLE `category` ENABLE KEYS */;

-- Listage de la structure de la table forumseb. post
CREATE TABLE IF NOT EXISTS `post` (
  `id_post` int(11) NOT NULL AUTO_INCREMENT,
  `postDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `topic_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `text` varchar(1000) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id_post`),
  KEY `FK_post_topic` (`topic_id`),
  KEY `FK_post_user` (`user_id`),
  CONSTRAINT `FK_post_topic` FOREIGN KEY (`topic_id`) REFERENCES `topic` (`id_topic`),
  CONSTRAINT `FK_post_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- Listage des données de la table forumseb.post : ~16 rows (environ)
/*!40000 ALTER TABLE `post` DISABLE KEYS */;
INSERT INTO `post` (`id_post`, `postDate`, `topic_id`, `user_id`, `text`) VALUES
	(4, '2023-03-29 09:51:02', 14, 6, 'ff'),
	(5, '2023-03-29 09:51:14', 15, 6, 'olol\r\n'),
	(6, '2023-03-29 09:51:28', 16, 6, 'Oui oui'),
	(7, '2023-03-29 09:54:10', 16, 6, 'yuytu'),
	(8, '2023-03-29 09:54:13', 16, 6, 'tyutu'),
	(9, '2023-03-29 10:04:16', 17, 6, 'zz'),
	(10, '2023-03-29 10:04:28', 18, 5, 'zz'),
	(11, '2023-03-29 10:04:45', 18, 5, 'tryty'),
	(13, '2023-03-29 13:38:19', 19, 7, 'ololo'),
	(14, '2023-03-29 15:20:12', 20, 6, 'aze'),
	(15, '2023-03-29 15:20:14', 21, 6, 'aezr'),
	(18, '2023-03-29 15:20:24', 24, 6, 'aeazesdf'),
	(20, '2023-03-29 15:20:33', 26, 6, 'azeafdffd'),
	(21, '2023-03-29 15:20:55', 27, 6, 'zaezaeazdf'),
	(22, '2023-03-29 15:20:59', 28, 6, 'dfdfds'),
	(23, '2023-03-29 15:21:04', 29, 6, 'dfsfdf');
/*!40000 ALTER TABLE `post` ENABLE KEYS */;

-- Listage de la structure de la table forumseb. topic
CREATE TABLE IF NOT EXISTS `topic` (
  `locked` tinyint(4) NOT NULL DEFAULT '0',
  `id_topic` int(11) NOT NULL AUTO_INCREMENT,
  `topicName` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `topicDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_topic`) USING BTREE,
  KEY `user_id` (`user_id`),
  KEY `category_id` (`category_id`),
  CONSTRAINT `category_id` FOREIGN KEY (`category_id`) REFERENCES `category` (`id_category`),
  CONSTRAINT `user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- Listage des données de la table forumseb.topic : ~13 rows (environ)
/*!40000 ALTER TABLE `topic` DISABLE KEYS */;
INSERT INTO `topic` (`locked`, `id_topic`, `topicName`, `topicDate`, `user_id`, `category_id`) VALUES
	(1, 14, 'et toa a koa tu jouei', '2023-03-29 09:51:02', 6, 1),
	(0, 15, 'la musik', '2023-03-29 09:51:14', 6, 2),
	(1, 16, 'j&#039;m bien les claviers', '2023-03-29 09:51:28', 6, 3),
	(0, 17, 'ez', '2023-03-29 10:04:16', 6, 3),
	(0, 18, 'j&#039;m bien les claviers', '2023-03-29 10:04:28', 5, 3),
	(0, 19, 'mon topic informatik', '2023-03-29 13:38:19', 7, 3),
	(0, 20, 'aeza', '2023-03-29 15:20:12', 6, 3),
	(0, 21, 'qdfdsf', '2023-03-29 15:20:14', 6, 3),
	(0, 24, 'azeazsdfq', '2023-03-29 15:20:24', 6, 3),
	(1, 26, 'azeazsdf', '2023-03-29 15:20:33', 6, 3),
	(1, 27, 'eazeaze', '2023-03-29 15:20:55', 6, 3),
	(0, 28, 'aaze', '2023-03-29 15:20:59', 6, 3),
	(0, 29, 'eazreara', '2023-03-29 15:21:04', 6, 3);
/*!40000 ALTER TABLE `topic` ENABLE KEYS */;

-- Listage de la structure de la table forumseb. user
CREATE TABLE IF NOT EXISTS `user` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `nickname` varchar(15) COLLATE utf8_bin NOT NULL,
  `email` varchar(100) COLLATE utf8_bin NOT NULL,
  `password` varchar(255) COLLATE utf8_bin NOT NULL,
  `registrationDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `role` varchar(50) COLLATE utf8_bin NOT NULL DEFAULT 'normal',
  `ban` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- Listage des données de la table forumseb.user : ~4 rows (environ)
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` (`id_user`, `nickname`, `email`, `password`, `registrationDate`, `role`, `ban`) VALUES
	(5, 'ChrisHaffey', 'chrishaffey@gmail.com', '$2y$10$Dl2lx9HV87Jih6MRRjpg8uZnF1gJ317TwtXxQheWOgNj/7AMaziMC', '2023-03-29 09:04:23', 'moderator', 0),
	(6, 'Edouard_Cislak', 'edouardcislak@gmail.com', '$2y$10$GG9CHtOoGRdhl/KTKy/Bb.7CMLoAV.K4hx0fktCHpTCNNRAfnKSrG', '2023-03-29 09:04:44', 'admin', 0),
	(7, 'JeanEudeDu12', 'jeaneudedu12@gmail.com', '$2y$10$gtHyLDL0KwiEmAF.9B1HdexzWMMQVjbEQ2d3BclZsqStGF2r0Snm2', '2023-03-29 09:05:01', 'normal', 1),
	(8, 'PseudOsef', 'pseudosef@gmail.com', '$2y$10$0hz4fZsDvl57OFCtVX5zJOe9N53bXamKmZMKKuJi67WAMO8iXaa4C', '2023-03-29 09:05:18', 'normal', 0);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
