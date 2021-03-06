# ************************************************************
# Sequel Pro SQL dump
# Version 4096
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Host: 127.0.0.1 (MySQL 5.6.19-1~exp1ubuntu2)
# Database: homestead
# Generation Time: 2015-05-19 11:59:00 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table departments
# ------------------------------------------------------------

DROP TABLE IF EXISTS `departments`;

CREATE TABLE `departments` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `lead_id` int(11) NOT NULL,
  `location_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `departments` WRITE;
/*!40000 ALTER TABLE `departments` DISABLE KEYS */;

INSERT INTO `departments` (`id`, `name`, `slug`, `lead_id`, `location_id`, `created_at`, `updated_at`)
VALUES
	(1, 'Engineering', 'engineering', 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(2, 'Marketing', 'marketing', 4, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(3, 'Investments', 'investments', 13, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(4, 'Product', 'product', 14, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(5, 'Completions', 'completions', 7, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(6, 'Finance', 'finance', 7, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(7, 'Legal', 'legal', 11, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(8, 'Bonds', 'bonds', 12, 2, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(9, 'Business Development', 'business-development', 9, 2, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(10, 'Gateway', 'gateway', 13, 3, '0000-00-00 00:00:00', '0000-00-00 00:00:00');


/*!40000 ALTER TABLE `departments` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table holiday_requests
# ------------------------------------------------------------

DROP TABLE IF EXISTS `holiday_requests`;

CREATE TABLE `holiday_requests` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `start_date` date COLLATE utf8_unicode_ci NOT NULL,
  `end_date` date COLLATE utf8_unicode_ci NOT NULL,
  `status_id` int(11) NOT NULL DEFAULT '1',
  `approved_by` int(11) DEFAULT NULL,
  `declined_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `holiday_requests_user_id_index` (`user_id`),
  KEY `holiday_requests_status_id_index` (`status_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


# Dump of table locations
# ------------------------------------------------------------

DROP TABLE IF EXISTS `locations`;

CREATE TABLE `locations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `lat` float NOT NULL,
  `lon` float NOT NULL,
  `telephone` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `locations` WRITE;
/*!40000 ALTER TABLE `locations` DISABLE KEYS */;

INSERT INTO `locations` (`id`, `name`, `slug`, `address`, `lat`, `lon`, `telephone`, `created_at`, `updated_at`)
VALUES
	(1, 'Exeter', 'exeter', 'Innovation Centre, Rennes Drive, Exeter, EX4 4RN', 50.7381, -3.53062, '01392 241319', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(2, 'London', 'london', '62 Dean Street, London, W1D 4QF', 51.513, -0.132277, '0181 1234567', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(3, 'Edinburgh', 'edinburgh', 'Silicon Walk, 25 Greenside Ln, Edinburgh, EH1 3AA', 55.9571, -3.18488, '0111 1234567', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(4, 'Manchester', 'manchester', 'Coronation Street, Manchester, MN12 123', 53.4617, -2.27171, '0122 1234567', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(5, 'Barcelona', 'barcelona', 'c/ Roselló 216, Planta 11, 08008, Barcelona, España', 40.4407, -3.67004, '+34 93 348 7322', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

/*!40000 ALTER TABLE `locations` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table migrations
# ------------------------------------------------------------

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;

INSERT INTO `migrations` (`migration`, `batch`)
VALUES
	('2014_10_12_100000_create_password_resets_table',1),
	('2015_03_25_040005_create_locations_table',1),
	('2015_03_25_040010_create_departments_table',1),
	('2015_03_25_040020_create_users_table',1),
	('2015_03_26_043315_create_holiday_requests_table',1),
	('2015_03_26_044144_create_status_table',1);

/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table password_resets
# ------------------------------------------------------------

DROP TABLE IF EXISTS `password_resets`;

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  KEY `password_resets_email_index` (`email`),
  KEY `password_resets_token_index` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table statuses
# ------------------------------------------------------------

DROP TABLE IF EXISTS `statuses`;

CREATE TABLE `statuses` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `statuses` WRITE;
/*!40000 ALTER TABLE `statuses` DISABLE KEYS */;

INSERT INTO `statuses` (`id`, `title`, `created_at`, `updated_at`)
VALUES
	(1,'Pending','2015-03-25 21:44:12','2015-03-25 21:44:12'),
	(2,'Approved','2015-03-25 21:44:13','2015-03-25 21:44:13'),
	(3,'Declined','2015-03-25 21:44:14','2015-03-25 21:44:14'),
	(4,'Active','2015-03-25 21:44:15','2015-03-25 21:44:15'),
	(5,'Cancelled','2015-03-25 20:54:12','2015-03-25 20:54:12'),
	(6,'Completed','2015-03-26 21:56:42','2015-03-26 21:56:42');

/*!40000 ALTER TABLE `statuses` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `telephone` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `extension` int(8) COLLATE utf8_unicode_ci DEFAULT NULL,
  `skype_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `department_id` int(11) NOT NULL,
  `location_id` int(11) NOT NULL,
  `lead` tinyint(1) NOT NULL DEFAULT '0',
  `super_user` tinyint(1) NOT NULL DEFAULT '0',
  `annual_holiday_allowance` int(11) NOT NULL DEFAULT '25',
  `confirmed` tinyint(1) NOT NULL DEFAULT '0',
  `confirmation_token` varchar(32),
  `remember_token` varchar(255) COLLATE utf8_unicode_ci,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_department_id_index` (`department_id`),
  KEY `users_location_id_index` (`location_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;

INSERT INTO `users` (`id`, `first_name`, `last_name`, `slug`, `role`, `email`, `password`, `telephone`, `extension`, `skype_name`, `department_id`, `location_id`, `super_user`, `annual_holiday_allowance`, `confirmed`, `confirmation_token`, `remember_token`, `created_at`, `updated_at`)
VALUES
	(1, 'David', 'Ives', 'david-ives', 'Head of Technology', 'david@crowdcube.com', '$2y$10$oDQvYOdt5TysJtI2ylTU.uBo8FAnAUiP2SyfbPOGn52YlH0K78lIu', '01392 348473', 118, 'david.crowdcube', 1, 1, 0, 25, 1, NULL, 'NEyvgHptR2vgkgmX0bQw1AyuTBuCZsEE5rLXfb8ZfrSau5JrdoyrSkkhPDax', '0000-00-00 00:00:00', '2015-06-22 21:58:48'),
	(2, 'Rob', 'Crowe', 'rob-crowe', 'Lead Engineer', 'rob@crowdcube.com', '$2y$10$0Yprz9gmvfb6vqvVsUF14eqC007zvFXG2.zDpgyfwJPRONogVXsxK', NULL, NULL, NULL, 1, 1, 0, 25, 1, NULL, '', '0000-00-00 00:00:00', '2015-05-19 15:40:57'),
	(3, 'Ben', 'Christine', 'ben-christine', 'Design Lead', 'ben@crowdcube.com', '$2y$10$W/bIKNrkJuHKRH6bgJyH1.sngcbNVkI5CFe9KW2QLxUO6mcEEYN3G', NULL, NULL, 'crowdcubeben', 1, 1, 0, 25, 1, NULL, '', '0000-00-00 00:00:00', '2015-05-19 15:40:57'),
	(4, 'Luke', 'Lang', 'luke-lang', 'CMO', 'luke@crowdcube.com', '$2y$10$gezO.vwZCCDH2s1FLrbzN.DXJxw.mlUpyo5fHzmV5ymu7JjJ8U1Hm', '01392 348461', 107, 'luke-lang', 2, 1, 0, 25, 1, NULL, '', '0000-00-00 00:00:00', '2015-05-19 15:40:58'),
	(5, 'James', 'Roberts', 'james-roberts', 'Head of Communication', 'james.roberts@crowdcube.com', '$2y$10$nAS.YDHvQyQTbGKGrrRQM.9tHwgW8mPoz/R3D5hnF47SvtCAb.sL.', '01392 348456', 108, 'crowdcubejames', 2, 1, 0, 25, 1, NULL, '', '0000-00-00 00:00:00', '2015-05-19 15:40:58'),
	(6, 'Becca', 'Lewis', 'becca-lewis', 'Communications & PR Manager', 'becca.lewis@crowdcube.com', '$2y$10$AEUKDpCMgunhIcsoCoTps.iPz5ofBEt4v3aCCxDjG4/SzGY4m8/G6', '01392 348471', 124, 'crowdcube.becca', 2, 1, 0, 25, 1, NULL, '', '0000-00-00 00:00:00', '2015-05-19 15:40:58'),
	(7, 'Bill', 'Simmons', 'bill-simmons', 'CFO', 'bill@crowdcube.com', '$2y$10$CiNHXJhYBbs2qI4fZCgpYuLHpIlyQnrEj0LWJPdJcxrpX94Xf/NjC', '01392 348468', NULL, 'crowdcube.bill', 6, 1, 0, 25, 1, NULL, '', '0000-00-00 00:00:00', '2015-05-19 15:40:58'),
	(8, 'Rebecca', 'Hand', 'rebecca-hand', 'Financial Controller', 'rebecca@crowdcube.com', '$2y$10$H3TSI2y/cD/DhROeWjThUuWtvevpHzuYvric6LEVCXb.IluplFGke', '01392 348451', 102, 'crowdcube.rebecca', 6, 1, 0, 25, 1, NULL, '', '0000-00-00 00:00:00', '2015-05-19 15:40:58'),
	(9, 'Matt', 'Cooper', 'matt-cooper', 'Commercial Director', 'matt.cooper@crowdcube.com', '$2y$10$oRYBaxVfSX3njMDAaPaeAu3F5VIOPKvUhHa/1aYqWrz/CddSBhjxO', '07545 203534', NULL, NULL, 9, 2, 0, 25, 1, NULL, '', '0000-00-00 00:00:00', '2015-05-19 15:40:58'),
	(10, 'Tom', 'Leigh', 'tom-leigh', 'Business Development Manager', 'tom.leigh@crowdcube.com', '$2y$10$gP4yJqu.S3KO8Lj41Apdb.RLjAuzdMLiTrQVGgD8QFTo721VdSG3u', '07834 757780', NULL, NULL, 9, 2, 0, 25, 1, NULL, '', '0000-00-00 00:00:00', '2015-05-19 15:40:58'),
	(11, 'Paul', 'Massey', 'paul-massey', 'General Counsel', 'paul.massey@crowdcube.com', '$2y$10$YxxqC4deBUt73HhCT0Xka.YuAOcDNno//yt/ZEk9h3JpybG/s3hNe', '01392 123456', NULL, 'paul-massey', 7, 1, 0, 25, 1, NULL, '', '0000-00-00 00:00:00', '2015-05-19 15:40:58'),
	(12, 'Dean', 'Mayer', 'dean-mayer', 'Head of Debt', 'dean.mayer@crowdcube.com', '$2y$10$ATJ.Ob4l6U1l973mDo5hYOZ10NxUrREDrRwS9MPct9O0VoDfhFLyq', '07931 382807', NULL, NULL, 8, 2, 0, 25, 1, NULL, '', '0000-00-00 00:00:00', '2015-05-19 15:40:58'),
	(13, 'Michael', 'Wilkinson', 'michael-wilkinson', 'Head of Equity Investment', 'michael.wilkinson@crowdcube.com', '$2y$10$4pdIrHsq36NydegDkC8sBOyTbPkT9NLPYAFZuvNOZpL.ge2Lt4tAa', '01392 348453', 105, 'micwilkinson1', 3, 1, 0, 25, 1, NULL, '', '0000-00-00 00:00:00', '2015-05-19 15:40:58'),
	(14, 'Thor', 'Mitchell', 'thor-mitchell', 'Head of Product', 'thor.mitchell@crowdcube.com', '$2y$10$IaaKpAKBIfpZc.jPVZNTge/3ZTIuA4JBEBXnd/chEJ2f3jEtB7UdW', NULL, NULL, NULL, 4, 1, 0, 25, 1, NULL, '', '0000-00-00 00:00:00', '2015-05-19 15:40:58'),
	(15, 'Darren', 'Westlake', 'darren-westlake', 'CEO', 'darren.westlake@crowdcube.com', '$2y$10$9mx5MivxlRfGkrGdo2NFrO/tZEwKjduqm8bY8h2NlivDzTLjhEBTa', '01392 348450 ', 101, 'dazwest', 4, 1, 1, 25, 1, NULL, '', '0000-00-00 00:00:00', '2015-05-19 15:40:58');


/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
