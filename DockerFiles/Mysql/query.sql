# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 0.0.0.0 (MySQL 5.7.21-21-log)
# Database: kilab_db
# Generation Time: 2018-10-01 11:41:39 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table employer_entity
# ------------------------------------------------------------

DROP TABLE IF EXISTS `employer_entity`;

CREATE TABLE `employer_entity` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `employer_entity` WRITE;
/*!40000 ALTER TABLE `employer_entity` DISABLE KEYS */;

INSERT INTO `employer_entity` (`id`, `username`, `email`)
VALUES
	(1,'hi','ali@ali.com');

/*!40000 ALTER TABLE `employer_entity` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table migration_versions
# ------------------------------------------------------------

DROP TABLE IF EXISTS `migration_versions`;

CREATE TABLE `migration_versions` (
  `version` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `migration_versions` WRITE;
/*!40000 ALTER TABLE `migration_versions` DISABLE KEYS */;

INSERT INTO `migration_versions` (`version`)
VALUES
	('20181001113652');

/*!40000 ALTER TABLE `migration_versions` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table time_sheet_entity
# ------------------------------------------------------------

DROP TABLE IF EXISTS `time_sheet_entity`;

CREATE TABLE `time_sheet_entity` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `employer_id` int(11) DEFAULT NULL,
  `date` datetime NOT NULL,
  `to_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_784963EEA76ED395` (`user_id`),
  KEY `IDX_784963EE41CD9E7A` (`employer_id`),
  CONSTRAINT `FK_784963EE41CD9E7A` FOREIGN KEY (`employer_id`) REFERENCES `employer_entity` (`id`),
  CONSTRAINT `FK_784963EEA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user_entity` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table user_entity
# ------------------------------------------------------------

DROP TABLE IF EXISTS `user_entity`;

CREATE TABLE `user_entity` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;




/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
