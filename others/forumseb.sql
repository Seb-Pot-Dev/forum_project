-- --------------------------------------------------------
-- Hôte:                         127.0.0.1
-- Version du serveur:           5.7.33 - MySQL Community Server (GPL)
-- SE du serveur:                Win64
-- HeidiSQL Version:             11.2.0.6213
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Listage de la structure de la base pour forumseb
CREATE DATABASE IF NOT EXISTS `forumseb` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_bin */;
USE `forumseb`;

-- Listage de la structure de la table forumseb. category
CREATE TABLE IF NOT EXISTS `category` (
  `id_category` int(11) NOT NULL AUTO_INCREMENT,
  `categoryName` varchar(50) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id_category`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- Listage des données de la table forumseb.category : ~0 rows (environ)
/*!40000 ALTER TABLE `category` DISABLE KEYS */;
/*!40000 ALTER TABLE `category` ENABLE KEYS */;

-- Listage de la structure de la table forumseb. post
CREATE TABLE IF NOT EXISTS `post` (
  `id_post` int(11) NOT NULL AUTO_INCREMENT,
  `postDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `topic_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id_post`),
  KEY `FK_post_topic` (`topic_id`),
  KEY `FK_post_user` (`user_id`),
  CONSTRAINT `FK_post_topic` FOREIGN KEY (`topic_id`) REFERENCES `topic` (`id_topic`),
  CONSTRAINT `FK_post_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- Listage des données de la table forumseb.post : ~0 rows (environ)
/*!40000 ALTER TABLE `post` DISABLE KEYS */;
/*!40000 ALTER TABLE `post` ENABLE KEYS */;

-- Listage de la structure de la table forumseb. topic
CREATE TABLE IF NOT EXISTS `topic` (
  `locked` bit(1) NOT NULL DEFAULT b'0',
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- Listage des données de la table forumseb.topic : ~0 rows (environ)
/*!40000 ALTER TABLE `topic` DISABLE KEYS */;
/*!40000 ALTER TABLE `topic` ENABLE KEYS */;

-- Listage de la structure de la table forumseb. user
CREATE TABLE IF NOT EXISTS `user` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `nickname` varchar(15) COLLATE utf8_bin NOT NULL DEFAULT '0',
  `email` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `password` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `registrationDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- Listage des données de la table forumseb.user : ~0 rows (environ)
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
/*!40000 ALTER TABLE `user` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
