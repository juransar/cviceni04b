-- Adminer 4.2.5 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

CREATE DATABASE `cviceni03b` /*!40100 DEFAULT CHARACTER SET utf16 COLLATE utf16_czech_ci */;
USE `cviceni03b`;

DROP TABLE IF EXISTS `pid`;
CREATE TABLE `pid` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `pid` (`id`, `name`) VALUES
(1,	'7603164353'),
(2,	'7659191432'),
(4,	'123456789');


DROP TABLE IF EXISTS `employer`;
CREATE TABLE `employer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `surname` text COLLATE utf16_czech_ci NOT NULL,
  `firstname` text COLLATE utf16_czech_ci NOT NULL,
  `salary` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `pid_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `company_id` (`company_id`),
  CONSTRAINT `company_ibfk_1` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`),
  CONSTRAINT `company_ibfk_2` FOREIGN KEY (`pid_id`) REFERENCES `pid` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_czech_ci;

INSERT INTO `employer` (`id`, `surname`,  `firstname`, `salary`, `company_id`, `pid_id`) VALUES
(1,	'Gogo','Nafachcenko', 30000,	1, 2);
INSERT INTO `employer` (`id`, `surname`,  `firstname`, `salary`, `company_id`, `pid_id`) VALUES
(2,	'Karel','Breburda', 10000,	1, 1);




DROP TABLE IF EXISTS `company`;
CREATE TABLE `company` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text COLLATE utf16_czech_ci NOT NULL,
  `phone` text COLLATE utf16_czech_ci NOT NULL,
  `registered` datetime NOT NULL,
  `is_dph` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_czech_ci;

INSERT INTO `company` (`id`, `name`, `phone`, `registered`, `is_dph`) VALUES
(1,	'Mrkvosoft',	'+42 123 243 242',	'2017-03-16 19:39:01',	1);
