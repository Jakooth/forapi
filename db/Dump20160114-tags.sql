CREATE DATABASE  IF NOT EXISTS `forplay` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `forplay`;
-- MySQL dump 10.13  Distrib 5.6.24, for Win64 (x86_64)
--
-- Host: localhost    Database: forplay
-- ------------------------------------------------------
-- Server version	5.6.26-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `for_articles`
--

DROP TABLE IF EXISTS `for_articles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `for_articles` (
  `article_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(16) NOT NULL,
  `subtype` varchar(16) NOT NULL,
  `title` varchar(128) NOT NULL,
  `subtitle` varchar(128) DEFAULT NULL,
  `shot_img` varchar(128) NOT NULL,
  `wide_img` varchar(128) DEFAULT NULL,
  `caret_img` varchar(128) DEFAULT NULL,
  `site` varchar(16) NOT NULL,
  `url` varchar(128) NOT NULL,
  `date` datetime NOT NULL,
  `priority` varchar(16) DEFAULT NULL,
  `preview` blob,
  `video_tech` varchar(16) DEFAULT NULL,
  `video_url` varchar(128) DEFAULT NULL,
  `audio_tech` varchar(16) DEFAULT NULL,
  `audio_url` blob,
  `audio_frame` blob,
  `cover_img` varchar(128) DEFAULT NULL,
  `cover_align` varchar(16) DEFAULT NULL,
  `cover_valign` varchar(16) DEFAULT NULL,
  `theme` varchar(16) DEFAULT NULL,
  `subtheme` varchar(16) DEFAULT NULL,
  `hype` tinyint(4) unsigned DEFAULT NULL,
  `platform` tinyint(4) unsigned DEFAULT NULL,
  `better` mediumint(9) DEFAULT NULL,
  `worse` mediumint(9) DEFAULT NULL,
  `equal` mediumint(9) DEFAULT NULL,
  `better_text` varchar(128) DEFAULT NULL,
  `worse_text` varchar(128) DEFAULT NULL,
  `equal_text` varchar(128) DEFAULT NULL,
  PRIMARY KEY (`article_id`),
  UNIQUE KEY `url_UNIQUE` (`url`,`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `for_articles`
--

LOCK TABLES `for_articles` WRITE;
/*!40000 ALTER TABLE `for_articles` DISABLE KEYS */;
/*!40000 ALTER TABLE `for_articles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `for_authors`
--

DROP TABLE IF EXISTS `for_authors`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `for_authors` (
  `author_id` tinyint(4) unsigned NOT NULL AUTO_INCREMENT,
  `en_name` varchar(128) NOT NULL,
  `bg_name` varchar(128) DEFAULT NULL,
  `tag` varchar(128) NOT NULL,
  PRIMARY KEY (`author_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `for_authors`
--

LOCK TABLES `for_authors` WRITE;
/*!40000 ALTER TABLE `for_authors` DISABLE KEYS */;
INSERT INTO `for_authors` VALUES (1,'Koralsky','','koralsky'),(2,'Snake','','snake'),(3,'doomy','','doomy'),(4,'Major Mistake','','major-mistake'),(5,'Tosh','','tosh'),(6,'Ralitsa','','ralitsa'),(7,'Nifredil','','nifredil'),(8,'Forplay','','forplay'),(9,'Jakooth','','jakooth');
/*!40000 ALTER TABLE `for_authors` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `for_countries`
--

DROP TABLE IF EXISTS `for_countries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `for_countries` (
  `country_id` tinyint(4) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) DEFAULT NULL,
  `tag` varchar(32) NOT NULL,
  PRIMARY KEY (`country_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `for_countries`
--

LOCK TABLES `for_countries` WRITE;
/*!40000 ALTER TABLE `for_countries` DISABLE KEYS */;
INSERT INTO `for_countries` VALUES (1,'Германия','de'),(2,'САЩ','us'),(3,'България','bg'),(4,'Франция','fr');
/*!40000 ALTER TABLE `for_countries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `for_events`
--

DROP TABLE IF EXISTS `for_events`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `for_events` (
  `event_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `tag_id` mediumint(9) unsigned NOT NULL,
  `end_date` date DEFAULT NULL,
  `city` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`event_id`),
  UNIQUE KEY `tag_id_UNIQUE` (`tag_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `for_events`
--

LOCK TABLES `for_events` WRITE;
/*!40000 ALTER TABLE `for_events` DISABLE KEYS */;
INSERT INTO `for_events` VALUES (1,298,NULL,NULL);
/*!40000 ALTER TABLE `for_events` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `for_games`
--

DROP TABLE IF EXISTS `for_games`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `for_games` (
  `game_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `tag_id` mediumint(9) unsigned NOT NULL,
  `us_date` date DEFAULT NULL,
  PRIMARY KEY (`game_id`),
  UNIQUE KEY `tag_id_UNIQUE` (`tag_id`)
) ENGINE=InnoDB AUTO_INCREMENT=84 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `for_games`
--

LOCK TABLES `for_games` WRITE;
/*!40000 ALTER TABLE `for_games` DISABLE KEYS */;
INSERT INTO `for_games` VALUES (1,138,NULL),(2,139,NULL),(3,140,NULL),(4,141,NULL),(5,143,NULL),(6,142,NULL),(7,144,NULL),(8,145,NULL),(9,146,NULL),(10,147,NULL),(11,148,NULL),(12,150,NULL),(13,151,NULL),(14,149,NULL),(15,152,NULL),(16,153,NULL),(17,154,NULL),(18,155,NULL),(19,156,NULL),(20,157,NULL),(21,159,NULL),(22,158,NULL),(23,160,NULL),(24,161,NULL),(25,162,NULL),(26,163,NULL),(27,167,NULL),(28,168,NULL),(29,169,NULL),(30,170,NULL),(31,171,NULL),(32,172,NULL),(33,174,NULL),(34,173,NULL),(35,176,NULL),(36,175,NULL),(37,177,NULL),(38,178,NULL),(39,179,NULL),(40,180,NULL),(41,181,NULL),(42,182,NULL),(43,183,NULL),(44,184,NULL),(45,185,NULL),(46,186,NULL),(47,187,NULL),(48,188,NULL),(49,189,NULL),(50,191,NULL),(51,190,NULL),(52,192,NULL),(53,193,NULL),(54,194,NULL),(55,195,NULL),(56,196,NULL),(57,197,NULL),(58,198,NULL),(59,199,NULL),(60,200,NULL),(61,201,NULL),(62,202,NULL),(63,203,NULL),(64,204,NULL),(65,205,NULL),(66,206,NULL),(67,208,NULL),(68,207,NULL),(69,209,NULL),(70,210,NULL),(71,213,NULL),(72,211,NULL),(73,212,NULL),(74,214,NULL),(75,215,NULL),(76,216,NULL),(77,218,NULL),(78,217,NULL),(79,219,NULL),(80,220,NULL),(81,221,NULL),(82,222,NULL),(83,223,NULL);
/*!40000 ALTER TABLE `for_games` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `for_genres`
--

DROP TABLE IF EXISTS `for_genres`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `for_genres` (
  `genre_id` tinyint(4) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `tag` varchar(128) NOT NULL,
  `type` varchar(16) NOT NULL,
  PRIMARY KEY (`genre_id`)
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `for_genres`
--

LOCK TABLES `for_genres` WRITE;
/*!40000 ALTER TABLE `for_genres` DISABLE KEYS */;
INSERT INTO `for_genres` VALUES (1,'Шуутър от първо/трето лице','fps','games'),(2,'Екшън от първо/трето лице','tps','games'),(3,'Рейл шуутър','rail','games'),(4,'Стелт','stealth','games'),(5,'Хорър','horror','games'),(6,'Сървайвъл хорър','survival','games'),(7,'Платформър','platformer','games'),(8,'Екшън-адвенчър','action-adventure','games'),(9,'Куест','adventure','games'),(10,'Аркадна игра','arcade','games'),(11,'ММО','mmo','games'),(12,'MOBA','moba','games'),(13,'Ролева','rpg','games'),(14,'Рейсър','racing','games'),(15,'Спортна','sport','games'),(16,'Симулатор','simulation','games'),(17,'Стратегия в реално време','rts','games'),(18,'Походова стратегия','tbs','games'),(19,'Кежуъл/парти/музикална','casual','games'),(20,'Инди','indie','games'),(21,'Биографична','biogrpahy','books'),(22,'Роман','novel','books'),(23,'Драма','drama','movies'),(24,'Екшън','action','movies'),(25,'Комедия','comedy','movies'),(26,'Приключенски','adventure','movies'),(27,'Анимация','animation','movies'),(28,'Документален','documentary','movies'),(29,'Семеен','family','movies'),(30,'Ноар','noir','movies'),(31,'Хорър','horror','movies'),(32,'Мюзикъл','musical','movies'),(33,'Романтика','romance','movies'),(34,'Фентъзи','fantasy','movies'),(35,'Фантастика','sci-fi','movies'),(36,'Трилър','thriller','movies'),(37,'Уестърн','western','movies'),(38,'Черно-бял ултра хардбойл мачо ноар с изобилие от насилие, кръв и цици','black-and-white-ultra-hard-boiled-macho-noir-with-lot-of-violence-blood-and-boobs','movies'),(39,'Черна комедия','dark-comedy','movies'),(40,'Романтичнa драма','romance-drama','movies'),(41,'Ню метъл','nu-metal','music'),(42,'Алтърнатив','alternative','music'),(43,'Кросоувър','crossover','music'),(44,'Рапкор','rapcore','music'),(45,'Блус рок','blues-rock','music'),(46,'Инди рок','indie-rock','music'),(47,'Дрийм поп','dream-pop','music'),(48,'За всеки по нещо, стига да не си фен предимно на Веско','something-for-everyone-but-hardcore-vesko-fans','music');
/*!40000 ALTER TABLE `for_genres` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `for_issues`
--

DROP TABLE IF EXISTS `for_issues`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `for_issues` (
  `issue_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `tag` smallint(5) NOT NULL,
  PRIMARY KEY (`issue_id`),
  UNIQUE KEY `name_UNIQUE` (`name`),
  UNIQUE KEY `tag_UNIQUE` (`tag`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `for_issues`
--

LOCK TABLES `for_issues` WRITE;
/*!40000 ALTER TABLE `for_issues` DISABLE KEYS */;
INSERT INTO `for_issues` VALUES (1,'Демо',0),(2,'Презареждане',1);
/*!40000 ALTER TABLE `for_issues` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `for_layouts`
--

DROP TABLE IF EXISTS `for_layouts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `for_layouts` (
  `layout_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `article_id` int(11) unsigned NOT NULL,
  `type` varchar(16) NOT NULL,
  `subtype` varchar(16) DEFAULT NULL,
  `center` blob,
  `left` varchar(128) DEFAULT NULL,
  `left_valign` varchar(16) DEFAULT NULL,
  `left_object` varchar(16) DEFAULT NULL,
  `right` varchar(128) DEFAULT NULL,
  `right_valign` varchar(16) DEFAULT NULL,
  `right_object` varchar(16) DEFAULT NULL,
  `ratio` varchar(8) NOT NULL,
  `order` tinyint(2) unsigned NOT NULL,
  PRIMARY KEY (`layout_id`),
  UNIQUE KEY `layout_id_UNIQUE` (`layout_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `for_layouts`
--

LOCK TABLES `for_layouts` WRITE;
/*!40000 ALTER TABLE `for_layouts` DISABLE KEYS */;
/*!40000 ALTER TABLE `for_layouts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `for_log`
--

DROP TABLE IF EXISTS `for_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `for_log` (
  `log_id` mediumint(9) unsigned NOT NULL AUTO_INCREMENT,
  `event` varchar(16) DEFAULT NULL,
  `table` varchar(32) DEFAULT NULL,
  `tag` varchar(128) DEFAULT NULL,
  `object` varchar(16) DEFAULT NULL,
  `user` tinyint(4) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `acknowledged` datetime DEFAULT NULL,
  PRIMARY KEY (`log_id`)
) ENGINE=InnoDB AUTO_INCREMENT=546 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `for_log`
--

LOCK TABLES `for_log` WRITE;
/*!40000 ALTER TABLE `for_log` DISABLE KEYS */;
INSERT INTO `for_log` VALUES (1,'insert','for_genres','fps','genre',0,'2016-01-11 21:43:02',NULL),(2,'insert','for_genres','tps','genre',0,'2016-01-11 21:53:23',NULL),(3,'insert','for_genres','rail','genre',0,'2016-01-11 21:55:16',NULL),(4,'insert','for_genres','stealth','genre',0,'2016-01-11 21:57:32',NULL),(5,'insert','for_genres','horror','genre',0,'2016-01-11 21:58:36',NULL),(6,'insert','for_genres','survival','genre',0,'2016-01-11 21:59:00',NULL),(7,'insert','for_genres','platformer','genre',0,'2016-01-11 21:59:18',NULL),(8,'insert','for_genres','action-adventure','genre',0,'2016-01-11 21:59:37',NULL),(9,'insert','for_genres','adventure','genre',0,'2016-01-11 21:59:58',NULL),(10,'insert','for_genres','arcade','genre',0,'2016-01-11 22:00:13',NULL),(11,'insert','for_genres','mmo','genre',0,'2016-01-11 22:00:25',NULL),(12,'insert','for_genres','moba','genre',0,'2016-01-11 22:00:38',NULL),(13,'insert','for_genres','rpg','genre',0,'2016-01-11 22:00:51',NULL),(14,'insert','for_genres','racing','genre',0,'2016-01-11 22:01:05',NULL),(15,'insert','for_genres','sport','genre',0,'2016-01-11 22:01:17',NULL),(16,'insert','for_genres','simulation','genre',0,'2016-01-11 22:01:32',NULL),(17,'insert','for_genres','rts','genre',0,'2016-01-11 22:01:43',NULL),(18,'insert','for_genres','tbs','genre',0,'2016-01-11 22:01:59',NULL),(19,'insert','for_genres','casual','genre',0,'2016-01-11 22:02:12',NULL),(20,'insert','for_genres','indie','genre',0,'2016-01-11 22:02:23',NULL),(21,'insert','for_genres','biogrpahy','genre',0,'2016-01-12 09:29:08',NULL),(22,'insert','for_genres','novel','genre',0,'2016-01-12 09:29:44',NULL),(23,'insert','for_genres','drama','genre',0,'2016-01-12 09:31:20',NULL),(24,'insert','for_genres','action','genre',0,'2016-01-12 09:31:58',NULL),(25,'insert','for_genres','comedy','genre',0,'2016-01-12 09:32:50',NULL),(26,'insert','for_genres','adventure','genre',0,'2016-01-12 09:33:11',NULL),(27,'insert','for_genres','animation','genre',0,'2016-01-12 09:33:27',NULL),(28,'insert','for_genres','documentary','genre',0,'2016-01-12 09:33:44',NULL),(29,'insert','for_genres','family','genre',0,'2016-01-12 09:34:00',NULL),(30,'insert','for_genres','noir','genre',0,'2016-01-12 09:34:14',NULL),(31,'insert','for_genres','horror','genre',0,'2016-01-12 09:34:29',NULL),(32,'insert','for_genres','musical','genre',0,'2016-01-12 09:34:44',NULL),(33,'insert','for_genres','romance','genre',0,'2016-01-12 09:35:00',NULL),(34,'insert','for_genres','fantasy','genre',0,'2016-01-12 09:35:17',NULL),(35,'insert','for_genres','sci-fi','genre',0,'2016-01-12 09:35:33',NULL),(36,'insert','for_genres','thriller','genre',0,'2016-01-12 09:35:46',NULL),(37,'insert','for_genres','western','genre',0,'2016-01-12 09:36:00',NULL),(38,'insert','for_genres','black-and-white-ultra-hard-boiled-macho-noir-with-lot-of-violence-blood-and-boobs','genre',0,'2016-01-12 09:38:15',NULL),(39,'insert','for_genres','dark-comedy','genre',0,'2016-01-12 09:39:50',NULL),(40,'insert','for_genres','romance-drama','genre',0,'2016-01-12 09:40:11',NULL),(41,'insert','for_genres','nu-metal','genre',0,'2016-01-12 09:41:33',NULL),(42,'insert','for_genres','alternative','genre',0,'2016-01-12 09:41:50',NULL),(43,'insert','for_genres','crossover','genre',0,'2016-01-12 09:42:06',NULL),(44,'insert','for_genres','rapcore','genre',0,'2016-01-12 09:42:27',NULL),(45,'insert','for_genres','blues-rock','genre',0,'2016-01-12 09:42:43',NULL),(46,'insert','for_genres','indie-rock','genre',0,'2016-01-12 09:43:03',NULL),(47,'insert','for_genres','dream-pop','genre',0,'2016-01-12 09:43:24',NULL),(48,'insert','for_genres','something-for-everyone-but-hardcore-vesko-fans','genre',0,'2016-01-12 09:44:02',NULL),(49,'update','for_genres','blues-rock','genre',0,'2016-01-12 09:45:38',NULL),(50,'insert','for_platforms','win','platform',0,'2016-01-12 10:09:08',NULL),(51,'insert','for_platforms','mac','platform',0,'2016-01-12 10:10:27',NULL),(52,'insert','for_platforms','360','platform',0,'2016-01-12 10:10:43',NULL),(53,'insert','for_platforms','one','platform',0,'2016-01-12 10:11:03',NULL),(54,'insert','for_platforms','ps3','platform',0,'2016-01-12 10:11:21',NULL),(55,'insert','for_platforms','ps4','platform',0,'2016-01-12 10:11:33',NULL),(56,'insert','for_platforms','vita','platform',0,'2016-01-12 10:11:50',NULL),(57,'insert','for_platforms','wii','platform',0,'2016-01-12 10:12:05',NULL),(58,'insert','for_platforms','3ds','platform',0,'2016-01-12 10:12:19',NULL),(59,'insert','for_platforms','ios','platform',0,'2016-01-12 10:12:32',NULL),(60,'insert','for_platforms','android','platform',0,'2016-01-12 10:12:43',NULL),(61,'insert','for_authors','koralsky','author',0,'2016-01-12 23:46:55',NULL),(62,'insert','for_authors','snake','author',0,'2016-01-12 23:48:20',NULL),(63,'insert','for_authors','doomy','author',0,'2016-01-12 23:48:32',NULL),(64,'insert','for_authors','major-mistake','author',0,'2016-01-12 23:48:44',NULL),(65,'insert','for_authors','tosh','author',0,'2016-01-12 23:48:57',NULL),(66,'insert','for_authors','ralitsa','author',0,'2016-01-12 23:49:08',NULL),(67,'insert','for_authors','nifredil','author',0,'2016-01-12 23:49:28',NULL),(68,'insert','for_authors','forplay','author',0,'2016-01-12 23:49:57',NULL),(69,'insert','for_authors','jakooth','author',0,'2016-01-12 23:50:07',NULL),(70,'insert','for_issues','0','issue',0,'2016-01-12 23:54:03',NULL),(71,'insert','for_issues','1','issue',0,'2016-01-12 23:56:18',NULL),(72,'insert','for_stickers','ghost','sticker',0,'2016-01-13 00:30:41',NULL),(73,'insert','for_stickers','broadsword','sticker',0,'2016-01-13 00:33:36',NULL),(74,'insert','for_stickers','diablo-skull','sticker',0,'2016-01-13 00:34:00',NULL),(75,'insert','for_stickers','angel-outfit','sticker',0,'2016-01-13 00:34:31',NULL),(76,'insert','for_stickers','high-shot','sticker',0,'2016-01-13 00:35:45',NULL),(77,'insert','for_stickers','snake','sticker',0,'2016-01-13 00:36:09',NULL),(78,'insert','for_stickers','dripping-knife','sticker',0,'2016-01-13 00:36:30',NULL),(79,'insert','for_stickers','voodoo-doll','sticker',0,'2016-01-13 00:37:06',NULL),(80,'insert','for_stickers','soccer-ball','sticker',0,'2016-01-13 00:39:28',NULL),(81,'insert','for_stickers','basketball-ball','sticker',0,'2016-01-13 00:39:53',NULL),(82,'insert','for_stickers','basketball-basket','sticker',0,'2016-01-13 00:40:29',NULL),(83,'insert','for_stickers','soccer-field','sticker',0,'2016-01-13 00:40:49',NULL),(84,'insert','for_stickers','burning-meteor','sticker',0,'2016-01-13 00:41:12',NULL),(85,'insert','for_stickers','minotaur','sticker',0,'2016-01-13 00:41:26',NULL),(86,'insert','for_stickers','brutal-helm','sticker',0,'2016-01-13 00:41:46',NULL),(87,'insert','for_stickers','black-hand-shield','sticker',0,'2016-01-13 00:42:30',NULL),(88,'insert','for_stickers','crowned-skull','sticker',0,'2016-01-13 00:42:57',NULL),(89,'insert','for_stickers','revolver','sticker',0,'2016-01-13 00:43:27',NULL),(90,'insert','for_stickers','temptation','sticker',0,'2016-01-13 00:43:58',NULL),(91,'insert','for_stickers','bleeding-wound','sticker',0,'2016-01-13 00:44:16',NULL),(92,'insert','for_stickers','jigsaw-piece','sticker',0,'2016-01-13 00:44:32',NULL),(93,'insert','for_stickers','tear-tracks','sticker',0,'2016-01-13 00:44:52',NULL),(94,'insert','for_stickers','monkey','sticker',0,'2016-01-13 00:45:06',NULL),(95,'insert','for_stickers','mp5','sticker',0,'2016-01-13 00:45:27',NULL),(96,'insert','for_stickers','phone','sticker',0,'2016-01-13 00:45:39',NULL),(97,'insert','for_stickers','laser-blast','sticker',0,'2016-01-13 00:45:52',NULL),(98,'insert','for_stickers','forward-field','sticker',0,'2016-01-13 00:46:24',NULL),(99,'insert','for_stickers','alien-skull','sticker',0,'2016-01-13 00:46:36',NULL),(100,'insert','for_stickers','beer-stein','sticker',0,'2016-01-13 00:46:50',NULL),(101,'insert','for_stickers','guitar','sticker',0,'2016-01-13 00:47:05',NULL),(102,'insert','for_stickers','sonic-shout','sticker',0,'2016-01-13 00:47:20',NULL),(103,'insert','for_stickers','curled-tentacle','sticker',0,'2016-01-13 00:47:33',NULL),(104,'insert','for_stickers','pointing','sticker',0,'2016-01-13 00:47:47',NULL),(105,'insert','for_stickers','palette','sticker',0,'2016-01-13 00:47:59',NULL),(106,'insert','for_stickers','full-motorcycle-helmet','sticker',0,'2016-01-13 00:48:15',NULL),(107,'insert','for_stickers','circuitry','sticker',0,'2016-01-13 00:48:25',NULL),(108,'insert','for_stickers','car-key','sticker',0,'2016-01-13 00:48:37',NULL),(109,'insert','for_stickers','pistol-gun','sticker',0,'2016-01-13 00:48:53',NULL),(110,'insert','for_stickers','lips','sticker',0,'2016-01-13 00:49:04',NULL),(111,'insert','for_stickers','sunglasses','sticker',0,'2016-01-13 00:49:14',NULL),(112,'insert','for_stickers','relic-blade','sticker',0,'2016-01-13 00:49:27',NULL),(113,'insert','for_stickers','bright-explosion','sticker',0,'2016-01-13 00:49:38',NULL),(114,'insert','for_stickers','gooey-daemon','sticker',0,'2016-01-13 00:49:52',NULL),(115,'insert','for_stickers','magnifying-glass','sticker',0,'2016-01-13 00:50:05',NULL),(116,'insert','for_stickers','forest','sticker',0,'2016-01-13 00:50:20',NULL),(117,'insert','for_stickers','bullets','sticker',0,'2016-01-13 00:50:31',NULL),(118,'insert','for_stickers','crosshair','sticker',0,'2016-01-13 00:50:41',NULL),(119,'insert','for_stickers','front-teeth','sticker',0,'2016-01-13 00:50:55',NULL),(120,'insert','for_stickers','steering-wheel','sticker',0,'2016-01-13 00:51:08',NULL),(121,'insert','for_stickers','checkered-flag','sticker',0,'2016-01-13 00:51:19',NULL),(122,'insert','for_stickers','heart-beats','sticker',0,'2016-01-13 00:51:33',NULL),(123,'insert','for_stickers','finger-print','sticker',0,'2016-01-13 00:51:51',NULL),(124,'insert','for_stickers','overlord-helm','sticker',0,'2016-01-13 00:52:04',NULL),(125,'insert','for_stickers','trophy','sticker',0,'2016-01-13 00:52:15',NULL),(126,'insert','for_stickers','minigun','sticker',0,'2016-01-13 00:52:25',NULL),(127,'insert','for_stickers','envelope','sticker',0,'2016-01-13 00:52:36',NULL),(128,'insert','for_stickers','transfuse','sticker',0,'2016-01-13 00:52:52',NULL),(129,'insert','for_stickers','life-in-the-balance','sticker',0,'2016-01-13 00:53:05',NULL),(130,'insert','for_stickers','ninja-mask','sticker',0,'2016-01-13 00:53:17',NULL),(131,'insert','for_stickers','binoculars','sticker',0,'2016-01-13 00:53:27',NULL),(132,'insert','for_stickers','dragon-head','sticker',0,'2016-01-13 00:53:47',NULL),(133,'insert','for_stickers','woman-elf-face','sticker',0,'2016-01-13 00:54:26',NULL),(134,'insert','for_stickers','dwarf-face','sticker',0,'2016-01-13 00:54:40',NULL),(135,'insert','for_stickers','missile-mech','sticker',0,'2016-01-13 00:54:56',NULL),(136,'insert','for_stickers','tank','sticker',0,'2016-01-13 00:55:08',NULL),(137,'insert','for_stickers','ringed-planet','sticker',0,'2016-01-13 00:55:23',NULL),(138,'insert','for_countries','de','country',0,'2016-01-13 01:01:54',NULL),(139,'insert','for_countries','us','country',0,'2016-01-13 01:02:15',NULL),(140,'insert','for_countries','bg','country',0,'2016-01-13 01:02:28',NULL),(141,'insert','for_countries','fr','country',0,'2016-01-13 01:02:42',NULL),(142,'insert','for_tags','gary-dauberman','person',0,'2016-01-13 12:22:58',NULL),(143,'insert','for_tags','alfre-woodard','person',0,'2016-01-13 12:22:58',NULL),(144,'insert','for_tags','tony-amendola','person',0,'2016-01-13 12:22:58',NULL),(145,'insert','for_tags','john-leonetti','person',0,'2016-01-13 12:22:58',NULL),(146,'insert','for_tags','annabelle-wallis','person',0,'2016-01-13 12:22:58',NULL),(147,'insert','for_tags','ward-horton','person',0,'2016-01-13 12:22:58',NULL),(148,'insert','for_tags','joseph-bishara','person',0,'2016-01-13 12:22:58',NULL),(149,'insert','for_tags','james-kniest','person',0,'2016-01-13 12:22:58',NULL),(150,'insert','for_tags','frank-miller','person',0,'2016-01-13 12:22:58',NULL),(151,'insert','for_tags','robert-rodriguez','person',0,'2016-01-13 12:22:58',NULL),(152,'insert','for_tags','james-wan','person',0,'2016-01-13 12:22:58',NULL),(153,'insert','for_tags','mickey-rourke','person',0,'2016-01-13 12:22:58',NULL),(154,'insert','for_tags','jessica-alba','person',0,'2016-01-13 12:22:58',NULL),(155,'insert','for_tags','joseph-gordon-levitt','person',0,'2016-01-13 12:22:58',NULL),(156,'insert','for_tags','rosario-dawson','person',0,'2016-01-13 12:22:58',NULL),(157,'insert','for_tags','josh-brolin','person',0,'2016-01-13 12:22:58',NULL),(158,'insert','for_tags','bruce-willis','person',0,'2016-01-13 12:22:58',NULL),(159,'insert','for_tags','eva-green','person',0,'2016-01-13 12:22:58',NULL),(160,'insert','for_tags','christopher-lloyd','person',0,'2016-01-13 12:22:58',NULL),(161,'insert','for_tags','powers-boothe','person',0,'2016-01-13 12:22:58',NULL),(162,'insert','for_tags','jaime-king','person',0,'2016-01-13 12:22:58',NULL),(163,'insert','for_tags','ray-liotta','person',0,'2016-01-13 12:22:58',NULL),(164,'insert','for_tags','juno-temple','person',0,'2016-01-13 12:22:58',NULL),(165,'insert','for_tags','carl-thiel','person',0,'2016-01-13 12:22:58',NULL),(166,'insert','for_tags','lady-gaga','person',0,'2016-01-13 12:22:58',NULL),(167,'insert','for_tags','matt-reeves','person',0,'2016-01-13 12:22:58',NULL),(168,'insert','for_tags','mark-bomback','person',0,'2016-01-13 12:22:58',NULL),(169,'insert','for_tags','rick-jaffa','person',0,'2016-01-13 12:22:58',NULL),(170,'insert','for_tags','andy-serkis','person',0,'2016-01-13 12:22:58',NULL),(171,'insert','for_tags','jason-clarke','person',0,'2016-01-13 12:22:58',NULL),(172,'insert','for_tags','amanda-silver','person',0,'2016-01-13 12:22:58',NULL),(173,'insert','for_tags','gary-oldman','person',0,'2016-01-13 12:22:58',NULL),(174,'insert','for_tags','keri-russell','person',0,'2016-01-13 12:22:58',NULL),(175,'insert','for_tags','kodi-smit-mcphee','person',0,'2016-01-13 12:22:58',NULL),(176,'insert','for_tags','kirk-acevedo','person',0,'2016-01-13 12:22:58',NULL),(177,'insert','for_tags','michael-giacchino','person',0,'2016-01-13 12:22:58',NULL),(178,'insert','for_tags','michael-seresin','person',0,'2016-01-13 12:22:58',NULL),(179,'insert','for_tags','steven-knight','person',0,'2016-01-13 12:22:58',NULL),(180,'insert','for_tags','haris-zambarloukos','person',0,'2016-01-13 12:22:58',NULL),(181,'insert','for_tags','tom-hardy','person',0,'2016-01-13 12:22:58',NULL),(182,'insert','for_tags','dickon-hinchliffe','person',0,'2016-01-13 12:22:58',NULL),(183,'insert','for_tags','james-gunn','person',0,'2016-01-13 12:22:58',NULL),(184,'insert','for_tags','chris-mccoy','person',0,'2016-01-13 12:22:58',NULL),(185,'insert','for_tags','nicole-perlman','person',0,'2016-01-13 12:22:58',NULL),(186,'insert','for_tags','chris-pratt','person',0,'2016-01-13 12:22:58',NULL),(187,'insert','for_tags','dave-bautista','person',0,'2016-01-13 12:22:58',NULL),(188,'insert','for_tags','zoe-saldana','person',0,'2016-01-13 12:22:58',NULL),(189,'insert','for_tags','bradley-cooper','person',0,'2016-01-13 12:22:58',NULL),(190,'insert','for_tags','glenn-close','person',0,'2016-01-13 12:22:58',NULL),(191,'insert','for_tags','vin-diesel','person',0,'2016-01-13 12:22:58',NULL),(192,'insert','for_tags','michael-rooker','person',0,'2016-01-13 12:22:58',NULL),(193,'insert','for_tags','benicio-del-toro','person',0,'2016-01-13 12:22:58',NULL),(194,'insert','for_tags','djimon-hounsou','person',0,'2016-01-13 12:22:58',NULL),(195,'insert','for_tags','lee-pace','person',0,'2016-01-13 12:22:58',NULL),(196,'insert','for_tags','ben-davis','person',0,'2016-01-13 12:22:58',NULL),(197,'insert','for_tags','john-c-reilly','person',0,'2016-01-13 12:22:58',NULL),(198,'insert','for_tags','alexandre-aja','person',0,'2016-01-13 12:22:58',NULL),(199,'insert','for_tags','joe-hill','person',0,'2016-01-13 12:22:58',NULL),(200,'insert','for_tags','tyler-bates','person',0,'2016-01-13 12:22:59',NULL),(201,'insert','for_tags','keith-bunin','person',0,'2016-01-13 12:22:59',NULL),(202,'insert','for_tags','daniel-radcliffe','person',0,'2016-01-13 12:22:59',NULL),(203,'insert','for_tags','joe-anderson','person',0,'2016-01-13 12:22:59',NULL),(204,'insert','for_tags','max-minghella','person',0,'2016-01-13 12:22:59',NULL),(205,'insert','for_tags','kathleen-quinlan','person',0,'2016-01-13 12:22:59',NULL),(206,'insert','for_tags','heather-graham','person',0,'2016-01-13 12:22:59',NULL),(207,'insert','for_tags','james-remar','person',0,'2016-01-13 12:22:59',NULL),(208,'insert','for_tags','frederick-elmes','person',0,'2016-01-13 12:22:59',NULL),(209,'insert','for_tags','david-morse','person',0,'2016-01-13 12:22:59',NULL),(210,'insert','for_tags','robin-coudert','person',0,'2016-01-13 12:22:59',NULL),(211,'insert','for_tags','lina-plioplyte','person',0,'2016-01-13 12:22:59',NULL),(212,'insert','for_tags','ari-cohen','person',0,'2016-01-13 12:22:59',NULL),(213,'insert','for_tags','debra-rapoportt','person',0,'2016-01-13 12:22:59',NULL),(214,'insert','for_tags','lynn-dell','person',0,'2016-01-13 12:22:59',NULL),(215,'insert','for_tags','joyce-carpati','person',0,'2016-01-13 12:22:59',NULL),(216,'insert','for_tags','ilona-smithkin','person',0,'2016-01-13 12:22:59',NULL),(217,'insert','for_tags','ziporah-salamon','person',0,'2016-01-13 12:22:59',NULL),(218,'insert','for_tags','zelda-kaplan','person',0,'2016-01-13 12:22:59',NULL),(219,'insert','for_tags','jacquie-murdock','person',0,'2016-01-13 12:22:59',NULL),(220,'insert','for_tags','patrick-modiano','person',0,'2016-01-13 12:22:59',NULL),(221,'insert','for_tags','kelli-scarr','person',0,'2016-01-13 12:22:59',NULL),(222,'insert','for_tags','jake-gyllenhaal','person',0,'2016-01-13 12:22:59',NULL),(223,'insert','for_tags','riz-ahmed','person',0,'2016-01-13 12:22:59',NULL),(224,'insert','for_tags','rene-russo','person',0,'2016-01-13 12:22:59',NULL),(225,'insert','for_tags','dan-gilroy','person',0,'2016-01-13 12:22:59',NULL),(226,'insert','for_tags','bill-paxton','person',0,'2016-01-13 12:22:59',NULL),(227,'insert','for_tags','robert-elswit','person',0,'2016-01-13 12:22:59',NULL),(228,'insert','for_tags','james-newton-howard','person',0,'2016-01-13 12:22:59',NULL),(229,'insert','for_tags','david-fincher','person',0,'2016-01-13 12:22:59',NULL),(230,'insert','for_tags','gillian-flynn','person',0,'2016-01-13 12:22:59',NULL),(231,'insert','for_tags','massimo-guarini','person',0,'2016-01-13 12:22:59',NULL),(232,'insert','for_tags','ben-affleck','person',0,'2016-01-13 12:22:59',NULL),(233,'insert','for_tags','rosamund-pike','person',0,'2016-01-13 12:22:59',NULL),(234,'insert','for_tags','tyler-perry','person',0,'2016-01-13 12:22:59',NULL),(235,'insert','for_tags','neil-patrick-harris','person',0,'2016-01-13 12:22:59',NULL),(236,'insert','for_tags','carrie-coon','person',0,'2016-01-13 12:22:59',NULL),(237,'insert','for_tags','jeff-cronenweth','person',0,'2016-01-13 12:22:59',NULL),(238,'insert','for_tags','kim-dickens','person',0,'2016-01-13 12:22:59',NULL),(239,'insert','for_tags','trent-reznor','person',0,'2016-01-13 12:22:59',NULL),(240,'insert','for_tags','hideo-kojima','person',0,'2016-01-13 12:22:59',NULL),(241,'insert','for_tags','arnold-schwarzenegger','person',0,'2016-01-13 12:22:59',NULL),(242,'insert','for_tags','peter-jackson','person',0,'2016-01-13 12:22:59',NULL),(243,'insert','for_tags','fran-walsh','person',0,'2016-01-13 12:22:59',NULL),(244,'insert','for_tags','atticus-ross','person',0,'2016-01-13 12:22:59',NULL),(245,'insert','for_tags','philippa-boyens','person',0,'2016-01-13 12:22:59',NULL),(246,'insert','for_tags','ian-mckellen','person',0,'2016-01-13 12:22:59',NULL),(247,'insert','for_tags','guillermo-del-toro','person',0,'2016-01-13 12:22:59',NULL),(248,'insert','for_tags','martin-freeman','person',0,'2016-01-13 12:22:59',NULL),(249,'insert','for_tags','hugo-weaving','person',0,'2016-01-13 12:22:59',NULL),(250,'insert','for_tags','luke-evans','person',0,'2016-01-13 12:22:59',NULL),(251,'insert','for_tags','orlando-bloom','person',0,'2016-01-13 12:22:59',NULL),(252,'insert','for_tags','aidan-turner','person',0,'2016-01-13 12:22:59',NULL),(253,'insert','for_tags','christopher-lee','person',0,'2016-01-13 12:22:59',NULL),(254,'insert','for_tags','richard-armitage','person',0,'2016-01-13 12:22:59',NULL),(255,'insert','for_tags','billy-connolly','person',0,'2016-01-13 12:22:59',NULL),(256,'insert','for_tags','james-nesbitt','person',0,'2016-01-13 12:22:59',NULL),(257,'insert','for_tags','cate-blanchett','person',0,'2016-01-13 12:22:59',NULL),(258,'insert','for_tags','stephen-hunter','person',0,'2016-01-13 12:22:59',NULL),(259,'insert','for_tags','ken-stott','person',0,'2016-01-13 12:22:59',NULL),(260,'insert','for_tags','evangeline-lilly','person',0,'2016-01-13 12:22:59',NULL),(261,'insert','for_tags','andrew-lesnie','person',0,'2016-01-13 12:22:59',NULL),(262,'insert','for_tags','howard-shore','person',0,'2016-01-13 12:22:59',NULL),(263,'insert','for_tags','benedict-cumberbatch','person',0,'2016-01-13 12:22:59',NULL),(264,'insert','for_tags','diane-von-furstenberg','person',0,'2016-01-13 12:22:59',NULL),(265,'insert','for_tags','channing-tatum','person',0,'2016-01-13 12:22:59',NULL),(266,'insert','for_tags','andy-wachowski','person',0,'2016-01-13 12:22:59',NULL),(267,'insert','for_tags','mila-kunis','person',0,'2016-01-13 12:22:59',NULL),(268,'insert','for_tags','jrr-tolkien','person',0,'2016-01-13 12:22:59',NULL),(269,'insert','for_tags','lana-wachowski','person',0,'2016-01-13 12:22:59',NULL),(270,'insert','for_tags','sean-bean','person',0,'2016-01-13 12:22:59',NULL),(271,'insert','for_tags','douglas-booth','person',0,'2016-01-13 12:22:59',NULL),(272,'insert','for_tags','eddie-redmayne','person',0,'2016-01-13 12:22:59',NULL),(273,'insert','for_tags','john-toll','person',0,'2016-01-13 12:22:59',NULL),(274,'insert','for_tags','daniel-craig','person',0,'2016-01-13 12:22:59',NULL),(275,'insert','for_tags','leonardo-dicaprio','person',0,'2016-01-13 12:22:59',NULL),(276,'insert','for_tags','christoph-waltz','person',0,'2016-01-13 12:22:59',NULL),(277,'insert','for_tags','anna-ewers','person',0,'2016-01-13 12:22:59',NULL),(278,'insert','for_tags','alejandro-gonzález-iñárritu','person',0,'2016-01-13 12:22:59',NULL),(279,'update','for_tags','leonardo-dicaprio','person',0,'2016-01-13 12:28:03',NULL),(280,'update','for_tags','j-r-r-tolkien','person',0,'2016-01-13 12:30:46',NULL),(281,'update','for_tags','diane-von-furstenberg','person',0,'2016-01-13 12:31:33',NULL),(282,'update','for_tags','guillermo-del-toro','person',0,'2016-01-13 12:32:50',NULL),(283,'update','for_tags','john-c-reilly','person',0,'2016-01-13 12:34:42',NULL),(284,'update','for_tags','benicio-del-toro','person',0,'2016-01-13 12:42:21',NULL),(285,'update','for_tags','joseph-gordon-levitt','person',0,'2016-01-13 12:43:25',NULL),(286,'update','for_tags','kodi-smit-mcphee','person',0,'2016-01-13 12:44:07',NULL),(287,'insert','for_tags','heavy-rain','game',0,'2016-01-13 13:46:57',NULL),(288,'insert','for_tags','murdered-soul-suspect','game',0,'2016-01-13 13:46:57',NULL),(289,'insert','for_tags','fahrenheit','game',0,'2016-01-13 13:46:57',NULL),(290,'insert','for_tags','la-noire','game',0,'2016-01-13 13:46:57',NULL),(291,'insert','for_tags','the-wolf-among-us','game',0,'2016-01-13 13:46:57',NULL),(292,'insert','for_tags','csi-miami','game',0,'2016-01-13 13:46:57',NULL),(293,'insert','for_tags','game-of-thrones','game',0,'2016-01-13 13:46:57',NULL),(294,'insert','for_tags','the-witcherw-2-assassin-of-kings','game',0,'2016-01-13 13:46:57',NULL),(295,'insert','for_tags','dragon-age-2','game',0,'2016-01-13 13:46:57',NULL),(296,'insert','for_tags','bound-by-flame','game',0,'2016-01-13 13:46:57',NULL),(297,'insert','for_tags','hohokum','game',0,'2016-01-13 13:46:57',NULL),(298,'insert','for_tags','kingdoms-of-amalur-reckoning','game',0,'2016-01-13 13:46:57',NULL),(299,'insert','for_tags','fifa-14','game',0,'2016-01-13 13:46:57',NULL),(300,'insert','for_tags','snake','game',0,'2016-01-13 13:46:57',NULL),(301,'insert','for_tags','dark-souls','game',0,'2016-01-13 13:46:57',NULL),(302,'insert','for_tags','fifa-15','game',0,'2016-01-13 13:46:57',NULL),(303,'insert','for_tags','divinity-original-sin','game',0,'2016-01-13 13:46:57',NULL),(304,'insert','for_tags','winning-eleven-7','game',0,'2016-01-13 13:46:57',NULL),(305,'insert','for_tags','pes-15','game',0,'2016-01-13 13:46:57',NULL),(306,'insert','for_tags','fallout','game',0,'2016-01-13 13:46:57',NULL),(307,'insert','for_tags','neverwinter-nights-2','game',0,'2016-01-13 13:46:57',NULL),(308,'insert','for_tags','fallout-2','game',0,'2016-01-13 13:46:57',NULL),(309,'insert','for_tags','beyond-divinity','game',0,'2016-01-13 13:46:57',NULL),(310,'insert','for_tags','dragon-age-inquisition','game',0,'2016-01-13 13:46:57',NULL),(311,'insert','for_tags','valiant-hearts','game',0,'2016-01-13 13:46:57',NULL),(312,'insert','for_tags','dark-souls-2','game',0,'2016-01-13 13:46:57',NULL),(313,'insert','for_tags','crown-of-the-sunken-king','dlc',0,'2016-01-13 13:46:57',NULL),(314,'insert','for_tags','crown-of-the-ivory-king','dlc',0,'2016-01-13 13:46:57',NULL),(315,'insert','for_tags','crown-of-the-old-iron-king','dlc',0,'2016-01-13 13:46:57',NULL),(316,'insert','for_tags','call-of-duty-black-ops-2','game',0,'2016-01-13 13:46:57',NULL),(317,'insert','for_tags','child-of-Light','game',0,'2016-01-13 13:46:57',NULL),(318,'insert','for_tags','brothers-a-tale-of-two-sons','game',0,'2016-01-13 13:46:57',NULL),(319,'insert','for_tags','limbo','game',0,'2016-01-13 13:46:57',NULL),(320,'insert','for_tags','journey','game',0,'2016-01-13 13:46:57',NULL),(321,'insert','for_tags','risen-3','game',0,'2016-01-13 13:46:57',NULL),(322,'insert','for_tags','two-worlds-2','game',0,'2016-01-13 13:46:57',NULL),(323,'insert','for_tags','gothic-2','game',0,'2016-01-13 13:46:57',NULL),(324,'insert','for_tags','risen','game',0,'2016-01-13 13:46:57',NULL),(325,'insert','for_tags','murasaki-baby','game',0,'2016-01-13 13:46:57',NULL),(326,'insert','for_tags','gta-5','game',0,'2016-01-13 13:46:57',NULL),(327,'insert','for_tags','saints-row-3','game',0,'2016-01-13 13:46:57',NULL),(328,'insert','for_tags','watch-dogs','game',0,'2016-01-13 13:46:57',NULL),(329,'insert','for_tags','i-cloud','game',0,'2016-01-13 13:46:57',NULL),(330,'insert','for_tags','sleeping-dogs','game',0,'2016-01-13 13:46:57',NULL),(331,'insert','for_tags','final-fantasy-12','game',0,'2016-01-13 13:46:58',NULL),(332,'insert','for_tags','dear-easter','game',0,'2016-01-13 13:46:58',NULL),(333,'insert','for_tags','shin-megami-tensei','game',0,'2016-01-13 13:46:58',NULL),(334,'insert','for_tags','ni-no-kuni','game',0,'2016-01-13 13:46:58',NULL),(335,'insert','for_tags','final-fantasy-10-hd-remaster','game',0,'2016-01-13 13:46:58',NULL),(336,'insert','for_tags','gone-home','game',0,'2016-01-13 13:46:58',NULL),(337,'insert','for_tags','destiny','game',0,'2016-01-13 13:46:58',NULL),(338,'insert','for_tags','the-vanishing-of-ethan-carter','game',0,'2016-01-13 13:46:58',NULL),(339,'insert','for_tags','borderlands','game',0,'2016-01-13 13:46:58',NULL),(340,'insert','for_tags','driveclub','game',0,'2016-01-13 13:46:58',NULL),(341,'insert','for_tags','outlast','game',0,'2016-01-13 13:46:58',NULL),(342,'insert','for_tags','nba-2k15','game',0,'2016-01-13 13:46:58',NULL),(343,'insert','for_tags','alien-isolation','game',0,'2016-01-13 13:46:58',NULL),(344,'insert','for_tags','need-for-speed-hot-pursuit','game',0,'2016-01-13 13:46:58',NULL),(345,'insert','for_tags','need-for-speed-rivals','game',0,'2016-01-13 13:46:58',NULL),(346,'insert','for_tags','nba-live-15','game',0,'2016-01-13 13:46:58',NULL),(347,'insert','for_tags','bioshock-infinite','game',0,'2016-01-13 13:46:58',NULL),(348,'insert','for_tags','wolfenstein-the-new-order','game',0,'2016-01-13 13:46:58',NULL),(349,'insert','for_tags','call-of-duty-4','game',0,'2016-01-13 13:46:58',NULL),(350,'insert','for_tags','metal-gear-solid-5','game',0,'2016-01-13 13:46:58',NULL),(351,'insert','for_tags','gta-4','game',0,'2016-01-13 13:46:58',NULL),(352,'insert','for_tags','metal-gear-solid','game',0,'2016-01-13 13:46:58',NULL),(353,'insert','for_tags','splinter-cell-black-list','game',0,'2016-01-13 13:46:58',NULL),(354,'insert','for_tags','the-witcher-3','game',0,'2016-01-13 13:46:58',NULL),(355,'insert','for_tags','call-of-duty-advanced-warfare','game',0,'2016-01-13 13:46:58',NULL),(356,'insert','for_tags','far-cry-4','game',0,'2016-01-13 13:46:58',NULL),(357,'insert','for_tags','red-dead-redemption','game',0,'2016-01-13 13:46:58',NULL),(358,'insert','for_tags','uncharted-4','game',0,'2016-01-13 13:46:58',NULL),(359,'insert','for_tags','littlebigplanet-2','game',0,'2016-01-13 13:46:58',NULL),(360,'insert','for_tags','littlebigplanet-3','game',0,'2016-01-13 13:46:58',NULL),(361,'insert','for_tags','littlebigplanet-psp','game',0,'2016-01-13 13:46:58',NULL),(362,'insert','for_tags','call-of-duty-ghosts','game',0,'2016-01-13 13:46:58',NULL),(363,'insert','for_tags','gta-6','game',0,'2016-01-13 13:46:58',NULL),(364,'insert','for_tags','littlebigplanet','game',0,'2016-01-13 13:46:58',NULL),(365,'insert','for_tags','super-mario-maker','game',0,'2016-01-13 13:46:58',NULL),(366,'insert','for_tags','tearway','game',0,'2016-01-13 13:46:58',NULL),(367,'insert','for_tags','wwe-2k16','game',0,'2016-01-13 13:46:58',NULL),(368,'update','for_tags','metal-gear-solid-5-ground-zeroes','game',0,'2016-01-13 13:57:40',NULL),(369,'update','for_tags','call-of-duty-4-modern-warfare','game',0,'2016-01-13 14:00:32',NULL),(370,'update','for_tags','child-of-light','game',0,'2016-01-13 14:06:41',NULL),(371,'insert','for_tags','risen-2','game',0,'2016-01-13 14:13:34',NULL),(372,'update','for_tags','baldurs-gate','game',0,'2016-01-13 14:16:15',NULL),(373,'insert','for_tags','baldurs-gate-2','game',0,'2016-01-13 14:26:08',NULL),(374,'insert','for_tags','demons-souls','game',0,'2016-01-13 14:26:35',NULL),(375,'insert','for_tags','assassins-creed-unity','game',0,'2016-01-13 14:27:00',NULL),(376,'insert','for_tags','assassins-creed-rogue','game',0,'2016-01-13 14:27:18',NULL),(377,'update','for_tags','crown-of-the-sunken-king','dlc',0,'2016-01-13 14:29:10',NULL),(378,'update','for_tags','crown-of-the-ivory-king','dlc',0,'2016-01-13 14:30:02',NULL),(379,'update','for_tags','crown-of-the-old-iron-king','dlc',0,'2016-01-13 14:30:15',NULL),(380,'insert','for_tags','the-conjuring','movie',0,'2016-01-13 15:57:01',NULL),(381,'insert','for_tags','insidious-chapter-2','movie',0,'2016-01-13 15:57:01',NULL),(382,'insert','for_tags','sin-city-2','movie',0,'2016-01-13 15:57:01',NULL),(383,'insert','for_tags','insidious','movie',0,'2016-01-13 15:57:01',NULL),(384,'insert','for_tags','mama','movie',0,'2016-01-13 15:57:01',NULL),(385,'insert','for_tags','annabelle','movie',0,'2016-01-13 15:57:01',NULL),(386,'insert','for_tags','dawn-of-the-planet-of-the-apes','movie',0,'2016-01-13 15:57:01',NULL),(387,'insert','for_tags','sin-city','movie',0,'2016-01-13 15:57:01',NULL),(388,'insert','for_tags','the-spirit','movie',0,'2016-01-13 15:57:01',NULL),(389,'insert','for_tags','planet-of-the-apes-2001','movie',0,'2016-01-13 15:57:01',NULL),(390,'insert','for_tags','avatar','movie',0,'2016-01-13 15:57:01',NULL),(391,'insert','for_tags','locke','movie',0,'2016-01-13 15:57:01',NULL),(392,'insert','for_tags','rise-of-the-planet-of-the-apes','movie',0,'2016-01-13 15:57:01',NULL),(393,'insert','for_tags','the-affair','movie',0,'2016-01-13 15:57:01',NULL),(394,'insert','for_tags','the-guitar','movie',0,'2016-01-13 15:57:01',NULL),(395,'insert','for_tags','all-is-lost','movie',0,'2016-01-13 15:57:01',NULL),(396,'insert','for_tags','phone-booth','movie',0,'2016-01-13 15:57:02',NULL),(397,'insert','for_tags','127-hours','movie',0,'2016-01-13 15:57:02',NULL),(398,'insert','for_tags','buried','movie',0,'2016-01-13 15:57:02',NULL),(399,'insert','for_tags','star-wars-episode-1','movie',0,'2016-01-13 15:57:02',NULL),(400,'insert','for_tags','star-wars-episode-2','movie',0,'2016-01-13 15:57:02',NULL),(401,'insert','for_tags','guardians-of-the-galaxy','movie',0,'2016-01-13 15:57:02',NULL),(402,'insert','for_tags','star-wars-episode-4','movie',0,'2016-01-13 15:57:02',NULL),(403,'insert','for_tags','star-wars-episode-3','movie',0,'2016-01-13 15:57:02',NULL),(404,'insert','for_tags','star-wars-episode-5','movie',0,'2016-01-13 15:57:02',NULL),(405,'insert','for_tags','raiders-of-the-lost-ark','movie',0,'2016-01-13 15:57:02',NULL),(406,'insert','for_tags','star-wars-episode-6','movie',0,'2016-01-13 15:57:02',NULL),(407,'insert','for_tags','indiana-jones-and-the-temple-of-doom','movie',0,'2016-01-13 15:57:02',NULL),(408,'insert','for_tags','maleficent','movie',0,'2016-01-13 15:57:02',NULL),(409,'insert','for_tags','horns','movie',0,'2016-01-13 15:57:02',NULL),(410,'insert','for_tags','stand-by-me','movie',0,'2016-01-13 15:57:02',NULL),(411,'insert','for_tags','indiana-jones-and-the-last-crusade','movie',0,'2016-01-13 15:57:02',NULL),(412,'insert','for_tags','frankenweenie','movie',0,'2016-01-13 15:57:02',NULL),(413,'insert','for_tags','advanced-style','movie',0,'2016-01-13 15:57:02',NULL),(414,'insert','for_tags','alien','movie',0,'2016-01-13 15:57:02',NULL),(415,'insert','for_tags','bulgarian-national-football-team','band',0,'2016-01-13 15:57:02',NULL),(416,'insert','for_tags','taxi-driver','movie',0,'2016-01-13 15:57:02',NULL),(417,'insert','for_tags','nightcrawler','movie',0,'2016-01-13 15:57:02',NULL),(418,'insert','for_tags','space-jam','movie',0,'2016-01-13 15:57:02',NULL),(419,'insert','for_tags','seven','movie',0,'2016-01-13 15:57:02',NULL),(420,'insert','for_tags','gone-girl','movie',0,'2016-01-13 15:57:02',NULL),(421,'insert','for_tags','gone-baby-gone','movie',0,'2016-01-13 15:57:02',NULL),(422,'insert','for_tags','wild-things','movie',0,'2016-01-13 15:57:02',NULL),(423,'insert','for_tags','harry-potter-and-the-deathly-hallows','movie',0,'2016-01-13 15:57:02',NULL),(424,'insert','for_tags','harry-potter-and-the-deathly-hallows-2','movie',0,'2016-01-13 15:57:02',NULL),(425,'insert','for_tags','the-lord-of-the-rings-the-fellowship-of-the-ring','movie',0,'2016-01-13 15:57:02',NULL),(426,'insert','for_tags','terminator-genisys','movie',0,'2016-01-13 15:57:02',NULL),(427,'insert','for_tags','prisoners','movie',0,'2016-01-13 15:57:02',NULL),(428,'insert','for_tags','the-lord-of-the-rings-the-two-towers','movie',0,'2016-01-13 15:57:02',NULL),(429,'insert','for_tags','the-hobbit-an-unexpected-journey','movie',0,'2016-01-13 15:57:02',NULL),(430,'insert','for_tags','the-lord-of-the-rings-the-return-of-the-king','movie',0,'2016-01-13 15:57:02',NULL),(431,'insert','for_tags','the-hobbit-the-desolation-of-smaug','movie',0,'2016-01-13 15:57:02',NULL),(432,'insert','for_tags','elysium','movie',0,'2016-01-13 15:57:02',NULL),(433,'insert','for_tags','the-hobbit-the-battle-of-the-five-armies','movie',0,'2016-01-13 15:57:02',NULL),(434,'insert','for_tags','jupiter-ascending','movie',0,'2016-01-13 15:57:02',NULL),(435,'insert','for_tags','spectre','movie',0,'2016-01-13 15:57:02',NULL),(436,'insert','for_tags','the-revenant','movie',0,'2016-01-13 15:57:02',NULL),(437,'insert','for_tags','ouch-thats-big','movie',0,'2016-01-13 15:57:02',NULL),(438,'insert','for_tags','emil-bulls','band',0,'2016-01-13 16:23:11',NULL),(439,'insert','for_tags','marilyn-manson','band',0,'2016-01-13 16:23:11',NULL),(440,'insert','for_tags','sacrifice-to-venus','album',0,'2016-01-13 16:23:11',NULL),(441,'insert','for_tags','korn','band',0,'2016-01-13 16:23:11',NULL),(442,'insert','for_tags','slipknot','band',0,'2016-01-13 16:23:11',NULL),(443,'insert','for_tags','coal-chamber','band',0,'2016-01-13 16:23:11',NULL),(444,'insert','for_tags','body-count','band',0,'2016-01-13 16:23:11',NULL),(445,'insert','for_tags','manslaughter','album',0,'2016-01-13 16:23:11',NULL),(446,'insert','for_tags','public-enemy','band',0,'2016-01-13 16:23:11',NULL),(447,'insert','for_tags','system-of-a-down','band',0,'2016-01-13 16:23:11',NULL),(448,'insert','for_tags','hed-pe','band',0,'2016-01-13 16:23:11',NULL),(449,'insert','for_tags','beastie-boys','band',0,'2016-01-13 16:23:11',NULL),(450,'insert','for_tags','suicidal-tendencies','band',0,'2016-01-13 16:23:11',NULL),(451,'insert','for_tags','ice-t','person',0,'2016-01-13 16:23:12',NULL),(452,'insert','for_tags','lana-del-rey','person',0,'2016-01-13 16:23:12',NULL),(453,'insert','for_tags','ultraviolence','album',0,'2016-01-13 16:23:12',NULL),(454,'insert','for_tags','ossy','band',0,'2016-01-13 16:23:12',NULL),(455,'insert','for_tags','sofia-rocks-2014','event',0,'2016-01-13 16:23:12',NULL),(456,'insert','for_tags','skillet','band',0,'2016-01-13 16:23:12',NULL),(457,'insert','for_tags','alcest','band',0,'2016-01-13 16:23:12',NULL),(458,'insert','for_tags','mando-diao','band',0,'2016-01-13 16:23:12',NULL),(459,'insert','for_tags','the-offspring','band',0,'2016-01-13 16:23:12',NULL),(460,'insert','for_tags','pharrell-williams','person',0,'2016-01-13 16:23:12',NULL),(461,'insert','for_tags','thirty-seconds-to-mars','band',0,'2016-01-13 16:23:12',NULL),(462,'insert','for_tags','square-enix','company',0,'2016-01-13 19:11:54',NULL),(463,'insert','for_tags','forplay','company',0,'2016-01-13 19:11:54',NULL),(464,'insert','for_tags','airtight-games','company',0,'2016-01-13 19:11:54',NULL),(465,'insert','for_tags','honeyslug','company',0,'2016-01-13 19:11:54',NULL),(466,'insert','for_tags','sony-computer-entertainment','company',0,'2016-01-13 19:11:54',NULL),(467,'insert','for_tags','focus-home-interactive','company',0,'2016-01-13 19:11:54',NULL),(468,'insert','for_tags','ea-canada','company',0,'2016-01-13 19:11:54',NULL),(469,'insert','for_tags','namco-bandai','company',0,'2016-01-13 19:11:54',NULL),(470,'insert','for_tags','ea-sports','company',0,'2016-01-13 19:11:54',NULL),(471,'insert','for_tags','from-software','company',0,'2016-01-13 19:11:54',NULL),(472,'insert','for_tags','ikaron','company',0,'2016-01-13 19:11:54',NULL),(473,'insert','for_tags','larian-studios','company',0,'2016-01-13 19:11:54',NULL),(474,'insert','for_tags','ubisoft','company',0,'2016-01-13 19:11:54',NULL),(475,'insert','for_tags','polydor-records','company',0,'2016-01-13 19:11:54',NULL),(476,'insert','for_tags','interscope-records','company',0,'2016-01-13 19:11:54',NULL),(477,'insert','for_tags','ubisoft-montpelier','company',0,'2016-01-13 19:11:54',NULL),(478,'insert','for_tags','deep-silver','company',0,'2016-01-13 19:11:54',NULL),(479,'insert','for_tags','ovosonico','company',0,'2016-01-13 19:11:54',NULL),(480,'insert','for_tags','piranha-bites','company',0,'2016-01-13 19:11:54',NULL),(481,'insert','for_tags','ubisoft-montreal','company',0,'2016-01-13 19:11:55',NULL),(482,'insert','for_tags','virtuos','company',0,'2016-01-13 19:11:55',NULL),(483,'insert','for_tags','bungie','company',0,'2016-01-13 19:11:55',NULL),(484,'insert','for_tags','the-astronauts ','company',0,'2016-01-13 19:11:55',NULL),(485,'insert','for_tags','evolution-studios','company',0,'2016-01-13 19:11:55',NULL),(486,'insert','for_tags','activision','company',0,'2016-01-13 19:11:55',NULL),(487,'insert','for_tags','sega','company',0,'2016-01-13 19:11:55',NULL),(488,'insert','for_tags','2k-sports','company',0,'2016-01-13 19:11:55',NULL),(489,'insert','for_tags','creative-assembly','company',0,'2016-01-13 19:11:55',NULL),(490,'insert','for_tags','bethesda-softworks','company',0,'2016-01-13 19:11:55',NULL),(491,'insert','for_tags','visual-concepts','company',0,'2016-01-13 19:11:55',NULL),(492,'insert','for_tags','machinegames','company',0,'2016-01-13 19:11:55',NULL),(493,'insert','for_tags','konami','company',0,'2016-01-13 19:11:55',NULL),(494,'insert','for_tags','kojima-productions','company',0,'2016-01-13 19:11:55',NULL),(495,'insert','for_tags','take-two','company',0,'2016-01-13 19:11:55',NULL),(496,'insert','for_tags','sledgehammer-games','company',0,'2016-01-13 19:11:55',NULL),(497,'insert','for_tags','sumo-digital','company',0,'2016-01-13 19:11:55',NULL),(498,'insert','for_tags','rockstar','company',0,'2016-01-13 19:11:55',NULL),(499,'insert','for_tags','electronic-arts','company',0,'2016-01-13 19:11:55',NULL),(500,'insert','for_tags','bioware','company',0,'2016-01-13 19:11:55',NULL),(501,'insert','for_tags','castle-design','company',0,'2016-01-13 19:11:55',NULL),(502,'insert','for_tags','diablo','serie',0,'2016-01-13 19:17:06',NULL),(503,'insert','for_tags','halo','serie',0,'2016-01-13 19:17:06',NULL),(504,'insert','for_tags','star-wars','serie',0,'2016-01-13 19:17:06',NULL),(505,'insert','for_tags','gta','serie',0,'2016-01-13 19:17:06',NULL),(506,'insert','for_tags','batman','serie',0,'2016-01-13 19:17:06',NULL),(507,'insert','for_tags','fifa','serie',0,'2016-01-13 19:17:06',NULL),(508,'insert','for_tags','baldurs-gate','serie',0,'2016-01-13 19:17:06',NULL),(509,'insert','for_tags','fallout','serie',0,'2016-01-13 19:17:06',NULL),(510,'insert','for_tags','true-blood','serie',0,'2016-01-13 19:17:06',NULL),(511,'insert','for_tags','neverwinter-nights','serie',0,'2016-01-13 19:17:06',NULL),(512,'insert','for_tags','dragon-age','serie',0,'2016-01-13 19:17:06',NULL),(513,'insert','for_tags','souls','serie',0,'2016-01-13 19:17:06',NULL),(514,'insert','for_tags','sin-city','serie',0,'2016-01-13 19:17:06',NULL),(515,'insert','for_tags','lego','serie',0,'2016-01-13 19:17:06',NULL),(516,'insert','for_tags','risen','serie',0,'2016-01-13 19:17:06',NULL),(517,'insert','for_tags','indiana-jones','serie',0,'2016-01-13 19:17:06',NULL),(518,'insert','for_tags','planet-of-the-apes','serie',0,'2016-01-13 19:17:06',NULL),(519,'insert','for_tags','saints-row','serie',0,'2016-01-13 19:17:06',NULL),(520,'insert','for_tags','assassins-creed','serie',0,'2016-01-13 19:17:06',NULL),(521,'insert','for_tags','forplay-podcast','serie',0,'2016-01-13 19:17:06',NULL),(522,'insert','for_tags','final-fantasy','serie',0,'2016-01-13 19:17:06',NULL),(523,'insert','for_tags','alien','serie',0,'2016-01-13 19:17:06',NULL),(524,'insert','for_tags','need-for-speed','serie',0,'2016-01-13 19:17:06',NULL),(525,'insert','for_tags','nba','serie',0,'2016-01-13 19:17:06',NULL),(526,'insert','for_tags','wolfenstein','serie',0,'2016-01-13 19:17:07',NULL),(527,'insert','for_tags','metal-gear','serie',0,'2016-01-13 19:17:07',NULL),(528,'insert','for_tags','pes','serie',0,'2016-01-13 19:17:07',NULL),(529,'insert','for_tags','splinter-cell','serie',0,'2016-01-13 19:17:07',NULL),(530,'insert','for_tags','harry-potter','serie',0,'2016-01-13 19:17:07',NULL),(531,'insert','for_tags','the-lord-of-the-rings','serie',0,'2016-01-13 19:17:07',NULL),(532,'insert','for_tags','call-of-duty','serie',0,'2016-01-13 19:17:07',NULL),(533,'insert','for_tags','the-hobbit','serie',0,'2016-01-13 19:17:07',NULL),(534,'insert','for_tags','far-cry','serie',0,'2016-01-13 19:17:07',NULL),(535,'insert','for_tags','littlebigplanet','serie',0,'2016-01-13 19:17:07',NULL),(536,'insert','for_tags','terminator','serie',0,'2016-01-13 19:17:07',NULL),(537,'insert','for_tags','villa-triste','book',0,'2016-01-13 19:19:36',NULL),(538,'insert','for_tags','the-woman-i-wanted-to-be','book',0,'2016-01-13 19:24:04',NULL),(539,'insert','for_tags','vulcan','character',0,'2016-01-13 20:55:08',NULL),(540,'insert','for_tags','mason','character',0,'2016-01-13 21:01:49',NULL),(541,'insert','for_tags','tombstone','character',0,'2016-01-13 21:03:04',NULL),(542,'insert','for_tags','b-j-blazkowicz','character',0,'2016-01-13 21:04:25',NULL),(543,'insert','for_tags','michael','character',0,'2016-01-13 21:06:18',NULL),(544,'insert','for_tags','trevor','character',0,'2016-01-13 21:07:27',NULL),(545,'insert','for_tags','super-mario','character',0,'2016-01-13 21:08:38',NULL);
/*!40000 ALTER TABLE `for_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `for_movies`
--

DROP TABLE IF EXISTS `for_movies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `for_movies` (
  `movie_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `tag_id` mediumint(9) unsigned NOT NULL,
  `world_date` date DEFAULT NULL,
  `time` smallint(5) DEFAULT NULL,
  PRIMARY KEY (`movie_id`),
  UNIQUE KEY `tag_id_UNIQUE` (`tag_id`)
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `for_movies`
--

LOCK TABLES `for_movies` WRITE;
/*!40000 ALTER TABLE `for_movies` DISABLE KEYS */;
INSERT INTO `for_movies` VALUES (1,224,NULL,NULL),(2,225,NULL,NULL),(3,226,NULL,NULL),(4,227,NULL,NULL),(5,228,NULL,NULL),(6,229,NULL,NULL),(7,230,NULL,NULL),(8,231,NULL,NULL),(9,232,NULL,NULL),(10,233,NULL,NULL),(11,234,NULL,NULL),(12,235,NULL,NULL),(13,236,NULL,NULL),(14,237,NULL,NULL),(15,238,NULL,NULL),(16,239,NULL,NULL),(17,240,NULL,NULL),(18,242,NULL,NULL),(19,243,NULL,NULL),(20,241,NULL,NULL),(21,244,NULL,NULL),(22,245,NULL,NULL),(23,246,NULL,NULL),(24,247,NULL,NULL),(25,248,NULL,NULL),(26,249,NULL,NULL),(27,250,NULL,NULL),(28,251,NULL,NULL),(29,252,NULL,NULL),(30,253,NULL,NULL),(31,256,NULL,NULL),(32,254,NULL,NULL),(33,255,NULL,NULL),(34,257,NULL,NULL),(35,259,NULL,NULL),(36,258,NULL,NULL),(37,263,NULL,NULL),(38,260,NULL,NULL),(39,262,NULL,NULL),(40,264,NULL,NULL),(41,265,NULL,NULL),(42,261,NULL,NULL),(43,266,NULL,NULL),(44,267,NULL,NULL),(45,268,NULL,NULL),(46,269,NULL,NULL),(47,270,NULL,NULL),(48,271,NULL,NULL),(49,272,NULL,NULL),(50,273,NULL,NULL),(51,274,NULL,NULL),(52,275,NULL,NULL),(53,276,NULL,NULL),(54,277,NULL,NULL),(55,278,NULL,NULL),(56,279,NULL,NULL),(57,280,NULL,NULL),(58,281,NULL,NULL);
/*!40000 ALTER TABLE `for_movies` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `for_platforms`
--

DROP TABLE IF EXISTS `for_platforms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `for_platforms` (
  `platform_id` tinyint(4) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `tag` varchar(32) NOT NULL,
  PRIMARY KEY (`platform_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `for_platforms`
--

LOCK TABLES `for_platforms` WRITE;
/*!40000 ALTER TABLE `for_platforms` DISABLE KEYS */;
INSERT INTO `for_platforms` VALUES (1,'Windows','win'),(2,'Mac OS','mac'),(3,'Xbox 360','360'),(4,'Xbox One','one'),(5,'PlayStation 3','ps3'),(6,'PlayStation 4','ps4'),(7,'PlayStation Vita','vita'),(8,'Nintendo Wii','wii'),(9,'Nintendo 3DS','3ds'),(10,'iOS','ios'),(11,'Android','android');
/*!40000 ALTER TABLE `for_platforms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `for_rel_authors`
--

DROP TABLE IF EXISTS `for_rel_authors`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `for_rel_authors` (
  `article_id` int(11) unsigned NOT NULL,
  `author_id` tinyint(4) unsigned NOT NULL,
  UNIQUE KEY `article_id_UNIQUE` (`article_id`,`author_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `for_rel_authors`
--

LOCK TABLES `for_rel_authors` WRITE;
/*!40000 ALTER TABLE `for_rel_authors` DISABLE KEYS */;
/*!40000 ALTER TABLE `for_rel_authors` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `for_rel_imgs`
--

DROP TABLE IF EXISTS `for_rel_imgs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `for_rel_imgs` (
  `article_id` int(11) unsigned NOT NULL,
  `layout_id` int(11) NOT NULL,
  `alt` blob NOT NULL,
  `pointer` varchar(16) NOT NULL,
  `tag` varchar(128) DEFAULT NULL,
  `index` varchar(16) DEFAULT NULL,
  `center` blob,
  `author` varchar(128) DEFAULT NULL,
  `tracklist` mediumint(9) unsigned DEFAULT NULL,
  `align` varchar(16) DEFAULT NULL,
  `valign` varchar(16) DEFAULT NULL,
  `video` varchar(128) DEFAULT NULL,
  `ratio` varchar(8) NOT NULL,
  `order` tinyint(2) unsigned NOT NULL,
  UNIQUE KEY `layout_id_UNIQUE` (`layout_id`,`tag`,`index`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `for_rel_imgs`
--

LOCK TABLES `for_rel_imgs` WRITE;
/*!40000 ALTER TABLE `for_rel_imgs` DISABLE KEYS */;
/*!40000 ALTER TABLE `for_rel_imgs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `for_rel_issues`
--

DROP TABLE IF EXISTS `for_rel_issues`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `for_rel_issues` (
  `article_id` int(11) unsigned NOT NULL,
  `issue_id` tinyint(4) unsigned NOT NULL,
  UNIQUE KEY `article_id_UNIQUE` (`article_id`,`issue_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `for_rel_issues`
--

LOCK TABLES `for_rel_issues` WRITE;
/*!40000 ALTER TABLE `for_rel_issues` DISABLE KEYS */;
/*!40000 ALTER TABLE `for_rel_issues` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `for_rel_relative`
--

DROP TABLE IF EXISTS `for_rel_relative`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `for_rel_relative` (
  `tag_id` mediumint(9) unsigned NOT NULL,
  `related_tag_id` int(11) NOT NULL,
  `related_subtype` varchar(16) DEFAULT NULL,
  UNIQUE KEY `tag_id` (`tag_id`,`related_tag_id`,`related_subtype`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `for_rel_relative`
--

LOCK TABLES `for_rel_relative` WRITE;
/*!40000 ALTER TABLE `for_rel_relative` DISABLE KEYS */;
INSERT INTO `for_rel_relative` VALUES (164,163,'relation'),(165,163,'relation'),(166,163,'relation'),(381,3,'country'),(382,3,'country'),(383,147,'relation'),(384,147,'relation'),(385,154,'relation'),(387,177,'relation'),(388,177,'relation');
/*!40000 ALTER TABLE `for_rel_relative` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `for_rel_tags`
--

DROP TABLE IF EXISTS `for_rel_tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `for_rel_tags` (
  `tag_id` mediumint(9) unsigned NOT NULL,
  `article_id` int(11) unsigned NOT NULL,
  `prime` tinyint(1) unsigned NOT NULL,
  UNIQUE KEY `tag_id_UNIQUE` (`tag_id`,`article_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `for_rel_tags`
--

LOCK TABLES `for_rel_tags` WRITE;
/*!40000 ALTER TABLE `for_rel_tags` DISABLE KEYS */;
/*!40000 ALTER TABLE `for_rel_tags` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `for_stickers`
--

DROP TABLE IF EXISTS `for_stickers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `for_stickers` (
  `sticker_id` tinyint(4) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `tag` varchar(32) NOT NULL,
  `lib` varchar(32) NOT NULL,
  `subtype` varchar(32) NOT NULL,
  PRIMARY KEY (`sticker_id`),
  UNIQUE KEY `tag_UNIQUE` (`tag`,`lib`,`subtype`)
) ENGINE=InnoDB AUTO_INCREMENT=67 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `for_stickers`
--

LOCK TABLES `for_stickers` WRITE;
/*!40000 ALTER TABLE `for_stickers` DISABLE KEYS */;
INSERT INTO `for_stickers` VALUES (1,'Ghost','ghost','lorc','originals'),(2,'Broadsword','broadsword','lorc','originals'),(3,'Diablo skull','diablo-skull','lorc','originals'),(4,'Angel outfit','angel-outfit','lorc','originals'),(5,'High shot','high-shot','lorc','originals'),(6,'Snake','snake','lorc','originals'),(7,'Dripping knife','dripping-knife','lorc','originals'),(8,'Voodoo doll','voodoo-doll','lorc','originals'),(9,'Soccer ball','soccer-ball','delapouite','sports'),(10,'Basketball ball','basketball-ball','delapouite','sports'),(11,'Basketball basket','basketball-basket','delapouite','sports'),(12,'Soccer field','soccer-field','delapouite','sports'),(13,'Burning meteor','burning-meteor','lorc','originals'),(14,'Minotaur','minotaur','lorc','originals'),(15,'Brutal helm','brutal-helm','carl-olsen','originals'),(16,'Black hand shield','black-hand-shield','lorc','originals'),(17,'Crowned skull','crowned-skull','lorc','originals'),(18,'Revolver','revolver','delapouite','originals'),(19,'Temptation','temptation','lorc','originals'),(20,'Bleeding wound','bleeding-wound','lorc','originals'),(21,'Jigsaw piece','jigsaw-piece','lorc','originals'),(22,'Tear tracks','tear-tracks','lorc','originals'),(23,'Monkey','monkey','lorc','originals'),(24,'MP5','mp5','delapouite','originals'),(25,'Phone','phone','delapouite','gui'),(26,'Laser blast','laser-blast','lorc','originals'),(27,'Forward field','forward-field','lorc','originals'),(28,'Alien skull','alien-skull','lorc','originals'),(29,'Beer stein','beer-stein','lorc','originals'),(30,'Guitar','guitar','lorc','originals'),(31,'Sonic shout','sonic-shout','lorc','originals'),(32,'Curled tentacle','curled-tentacle','lorc','originals'),(33,'Pointing','pointing','lorc','originals'),(34,'Palette','palette','delapouite','originals'),(35,'Full motorcycle helmet','full-motorcycle-helmet','delapouite','originals'),(36,'Circuitry','circuitry','lorc','originals'),(37,'Car key','car-key','delapouite','originals'),(38,'Pistol gun','pistol-gun','john-colburn','originals'),(39,'Lips','lips','lorc','originals'),(40,'Sunglasses','sunglasses','delapouite','originals'),(41,'Relic blade','relic-blade','lorc','originals'),(42,'Bright explosion','bright-explosion','lorc','originals'),(43,'Gooey daemon','gooey-daemon','lorc','originals'),(44,'Magnifying glass','magnifying-glass','lorc','originals'),(45,'Forest','forest','delapouite','originals'),(46,'Bullets','bullets','lorc','originals'),(47,'Crosshair','crosshair','delapouite','originals'),(48,'Front teeth','front-teeth','lorc','originals'),(49,'Steering wheel','steering-wheel','delapouite','originals'),(50,'Checkered flag','checkered-flag','delapouite','originals'),(51,'Heart beats','heart-beats','delapouite','originals'),(52,'Finger print','finger-print','delapouite','originals'),(53,'Overlord helm','overlord-helm','delapouite','originals'),(54,'Trophy','trophy','lorc','originals'),(55,'Minigun','minigun','lorc','originals'),(56,'Envelope','envelope','lorc','originals'),(57,'Transfuse','transfuse','lorc','originals'),(58,'Life in the balance','life-in-the-balance','lorc','originals'),(59,'Ninja mask','ninja-mask','lorc','originals'),(60,'Binoculars','binoculars','delapouite','originals'),(61,'Dragon head','dragon-head','lorc','originals'),(62,'Female elf face','woman-elf-face','delapouite','originals'),(63,'Dwarf face','dwarf-face','delapouite','originals'),(64,'Missile mech','missile-mech','lorc','originals'),(65,'Tank','tank','lorc','originals'),(66,'Ringed planet','ringed-planet','lorc','originals');
/*!40000 ALTER TABLE `for_stickers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `for_tags`
--

DROP TABLE IF EXISTS `for_tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `for_tags` (
  `tag_id` mediumint(9) unsigned NOT NULL AUTO_INCREMENT,
  `bg_name` varchar(128) DEFAULT NULL,
  `en_name` varchar(128) DEFAULT NULL,
  `tag` varchar(128) NOT NULL,
  `date` date DEFAULT NULL,
  `type` varchar(16) NOT NULL,
  `subtype` varchar(16) DEFAULT NULL,
  `object` varchar(16) NOT NULL,
  PRIMARY KEY (`tag_id`),
  UNIQUE KEY `tag_UNIQUE` (`tag`,`object`)
) ENGINE=InnoDB AUTO_INCREMENT=390 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `for_tags`
--

LOCK TABLES `for_tags` WRITE;
/*!40000 ALTER TABLE `for_tags` DISABLE KEYS */;
INSERT INTO `for_tags` VALUES (1,'Гари Дауберман','Gary Dauberman','gary-dauberman',NULL,'movies',NULL,'person'),(2,'Алфри Уудард','Alfre Woodard','alfre-woodard',NULL,'movies',NULL,'person'),(3,'Тони Амендола','Tony Amendola','tony-amendola',NULL,'movies',NULL,'person'),(4,'Джон Лионети','John Leonetti','john-leonetti',NULL,'movies',NULL,'person'),(5,'Анабел Уолис','Annabelle Wallis','annabelle-wallis',NULL,'movies',NULL,'person'),(6,'Уард Хортън','Ward Horton','ward-horton',NULL,'movies',NULL,'person'),(7,'Джоузеф Бишара','Joseph Bishara','joseph-bishara',NULL,'movies',NULL,'person'),(8,'Джеймс Книст','James Kniest','james-kniest',NULL,'movies',NULL,'person'),(9,'Франк Милър','Frank Miller','frank-miller',NULL,'movies',NULL,'person'),(10,'Робърт Родригес','Robert Rodriguez','robert-rodriguez',NULL,'movies',NULL,'person'),(11,'Джеймс Ван','James Wan','james-wan',NULL,'movies',NULL,'person'),(12,'Мики Рурк','Mickey Rourke','mickey-rourke',NULL,'movies',NULL,'person'),(13,'Джесика Алба','Jessica Alba','jessica-alba',NULL,'movies',NULL,'person'),(14,'Джоузеф Гордън-Левит','Joseph Gordon-Levitt','joseph-gordon-levitt',NULL,'movies',NULL,'person'),(15,'Розарио Доусън','Rosario Dawson','rosario-dawson',NULL,'movies',NULL,'person'),(16,'Джош Бролин','Josh Brolin','josh-brolin',NULL,'movies',NULL,'person'),(17,'Брус Уилис','Bruce Willis','bruce-willis',NULL,'movies',NULL,'person'),(18,'Ева Грийн','Eva Green','eva-green',NULL,'movies',NULL,'person'),(19,'Пауърс Буут','Powers Boothe','powers-boothe',NULL,'movies',NULL,'person'),(20,'Джейми Кинг','Jaime King','jaime-king',NULL,'movies',NULL,'person'),(21,'Кристъфър Лойд','Christopher Lloyd','christopher-lloyd',NULL,'movies',NULL,'person'),(22,'Рей Лиота','Ray Liotta','ray-liotta',NULL,'movies',NULL,'person'),(23,'Джуно Темпъл','Juno Temple','juno-temple',NULL,'movies',NULL,'person'),(24,'Карл Тиел','Carl Thiel','carl-thiel',NULL,'movies',NULL,'person'),(25,'Лейди Гага','Lady Gaga','lady-gaga',NULL,'movies',NULL,'person'),(26,'Мат Рийвс','Matt Reeves','matt-reeves',NULL,'movies',NULL,'person'),(27,'Марк Бомбак','Mark Bomback','mark-bomback',NULL,'movies',NULL,'person'),(28,'Рик Джафа','Rick Jaffa','rick-jaffa',NULL,'movies',NULL,'person'),(29,'Анди Съркиз','Andy Serkis','andy-serkis',NULL,'movies',NULL,'person'),(30,'Джейсън Кларк','Jason Clarke','jason-clarke',NULL,'movies',NULL,'person'),(31,'Аманда Силвър','Amanda Silver','amanda-silver',NULL,'movies',NULL,'person'),(32,'Гари Олдман','Gary Oldman','gary-oldman',NULL,'movies',NULL,'person'),(33,'Кери Ръсел','Keri Russell','keri-russell',NULL,'movies',NULL,'person'),(34,'Кърк Асеведо','Kirk Acevedo','kirk-acevedo',NULL,'movies',NULL,'person'),(35,'Коди Смит-МакФий','Kodi Smit-Mcphee','kodi-smit-mcphee',NULL,'movies',NULL,'person'),(36,'Майкъл Джиакино','Michael Giacchino','michael-giacchino',NULL,'movies',NULL,'person'),(37,'Майкъл Сересин','Michael Seresin','michael-seresin',NULL,'movies',NULL,'person'),(38,'Стивън Найт','Steven Knight','steven-knight',NULL,'movies',NULL,'person'),(39,'Харис Замбарукос','Haris Zambarloukos','haris-zambarloukos',NULL,'movies',NULL,'person'),(40,'Том Харди','Tom Hardy','tom-hardy',NULL,'movies',NULL,'person'),(41,'Дикън Хинчлиф','Dickon Hinchliffe','dickon-hinchliffe',NULL,'movies',NULL,'person'),(42,'Джеймс Гън','James Gunn','james-gunn',NULL,'movies',NULL,'person'),(43,'Крис Маккой','Chris Mccoy','chris-mccoy',NULL,'movies',NULL,'person'),(44,'Никол Пърлман','Nicole Perlman','nicole-perlman',NULL,'movies',NULL,'person'),(45,'Крис Прат','Chris Pratt','chris-pratt',NULL,'movies',NULL,'person'),(46,'Дейв Батиста','Dave Bautista','dave-bautista',NULL,'movies',NULL,'person'),(47,'Зоуи Салдана','Zoe Saldana','zoe-saldana',NULL,'movies',NULL,'person'),(48,'Брадли Куупър','Bradley Cooper','bradley-cooper',NULL,'movies',NULL,'person'),(49,'Глен Клоуз','Glenn Close','glenn-close',NULL,'movies',NULL,'person'),(50,'Майкъл Рукър','Michael Rooker','michael-rooker',NULL,'movies',NULL,'person'),(51,'Вин Дизел','Vin Diesel','vin-diesel',NULL,'movies',NULL,'person'),(52,'Джимон Хонсу','Djimon Hounsou','djimon-hounsou',NULL,'movies',NULL,'person'),(53,'Бенисио дел Торо','Benicio del Toro','benicio-del-toro',NULL,'movies',NULL,'person'),(54,'Лий Пейс','Lee Pace','lee-pace',NULL,'movies',NULL,'person'),(55,'Бен Дейвис','Ben Davis','ben-davis',NULL,'movies',NULL,'person'),(56,'Джон С. Райли','John C. Reilly','john-c-reilly',NULL,'movies',NULL,'person'),(57,'Александър Ажа','Alexandre Aja','alexandre-aja',NULL,'movies',NULL,'person'),(58,'Джо Хил','Joe Hill','joe-hill',NULL,'books',NULL,'person'),(59,'Тайлър Бейтс','Tyler Bates','tyler-bates',NULL,'movies',NULL,'person'),(60,'Кийт Бънин','Keith Bunin','keith-bunin',NULL,'movies',NULL,'person'),(61,'Даниел Радклиф','Daniel Radcliffe','daniel-radcliffe',NULL,'movies',NULL,'person'),(62,'Джо Андерсън','Joe Anderson','joe-anderson',NULL,'movies',NULL,'person'),(63,'Макс Мингела','Max Minghella','max-minghella',NULL,'movies',NULL,'person'),(64,'Катлийн Куинлан','Kathleen Quinlan','kathleen-quinlan',NULL,'movies',NULL,'person'),(65,'Хедър Греъм','Heather Graham','heather-graham',NULL,'movies',NULL,'person'),(66,'Джеймс Ремар','James Remar','james-remar',NULL,'movies',NULL,'person'),(67,'Фредерик Елмс','Frederick Elmes','frederick-elmes',NULL,'movies',NULL,'person'),(68,'Дейвид Морз','David Morse','david-morse',NULL,'movies',NULL,'person'),(69,'Робин Куде','Robin Coudert','robin-coudert',NULL,'movies',NULL,'person'),(70,'Лина Плиоплайт','Lina Plioplyte','lina-plioplyte',NULL,'movies',NULL,'person'),(71,'Ари Коен','Ari Cohen','ari-cohen',NULL,'movies',NULL,'person'),(72,'Дебра Рапорт','Debra Rapoportt','debra-rapoportt',NULL,'movies',NULL,'person'),(73,'Лин Дел','Lynn Dell','lynn-dell',NULL,'movies',NULL,'person'),(74,'Джойс Карпейша','Joyce Carpati','joyce-carpati',NULL,'movies',NULL,'person'),(75,'Илона Смиткин','Ilona Smithkin','ilona-smithkin',NULL,'movies',NULL,'person'),(76,'Зипора Саломон','Ziporah Salamon','ziporah-salamon',NULL,'movies',NULL,'person'),(77,'Зелда Каплин','Zelda Kaplan','zelda-kaplan',NULL,'movies',NULL,'person'),(78,'Джаки Мърдок','Jacquie Murdock','jacquie-murdock',NULL,'movies',NULL,'person'),(79,'Патрик Модиано','Patrick Modiano','patrick-modiano',NULL,'books',NULL,'person'),(80,'Кели Скар','Kelli Scarr','kelli-scarr',NULL,'movies',NULL,'person'),(81,'Джейк Джиленхол','Jake Gyllenhaal','jake-gyllenhaal',NULL,'movies',NULL,'person'),(82,'Риз Ахмед','Riz Ahmed','riz-ahmed',NULL,'movies',NULL,'person'),(83,'Рене Русо','Rene Russo','rene-russo',NULL,'movies',NULL,'person'),(84,'Дан Гилрой','Dan Gilroy','dan-gilroy',NULL,'movies',NULL,'person'),(85,'Бил Пакстън','Bill Paxton','bill-paxton',NULL,'movies',NULL,'person'),(86,'Робърт Елсуит','Robert Elswit','robert-elswit',NULL,'movies',NULL,'person'),(87,'Джеймс Нютън Хауърд','James Newton Howard','james-newton-howard',NULL,'movies',NULL,'person'),(88,'Дейвид Финчър','David Fincher','david-fincher',NULL,'movies',NULL,'person'),(89,'Джилиън Флин','Gillian Flynn','gillian-flynn',NULL,'movies',NULL,'person'),(90,'Масимо Гуарини','Massimo Guarini','massimo-guarini',NULL,'games',NULL,'person'),(91,'Бен Афлек','Ben Affleck','ben-affleck',NULL,'movies',NULL,'person'),(92,'Розамунд Пайк','Rosamund Pike','rosamund-pike',NULL,'movies',NULL,'person'),(93,'Тайлър Пери','Tyler Perry','tyler-perry',NULL,'movies',NULL,'person'),(94,'Нийл Патрик Харис','Neil Patrick Harris','neil-patrick-harris',NULL,'movies',NULL,'person'),(95,'Кери Куун','Carrie Coon','carrie-coon',NULL,'movies',NULL,'person'),(96,'Джеф Кроненует','Jeff Cronenweth','jeff-cronenweth',NULL,'movies',NULL,'person'),(97,'Ким Дикенс','Kim Dickens','kim-dickens',NULL,'movies',NULL,'person'),(98,'Трент Резнър','Trent Reznor','trent-reznor',NULL,'movies',NULL,'person'),(99,'Hideo Kojima','Hideo Kojima','hideo-kojima',NULL,'games',NULL,'person'),(100,'Арнолд Шварценегер','Arnold Schwarzenegger','arnold-schwarzenegger',NULL,'movies',NULL,'person'),(101,'Питър Джаксън','Peter Jackson','peter-jackson',NULL,'movies',NULL,'person'),(102,'Фран Уолш','Fran Walsh','fran-walsh',NULL,'movies',NULL,'person'),(103,'Атикъс Рос','Atticus Ross','atticus-ross',NULL,'movies',NULL,'person'),(104,'Филипа Бойенс','Philippa Boyens','philippa-boyens',NULL,'movies',NULL,'person'),(105,'Иън Маккелън','Ian Mckellen','ian-mckellen',NULL,'movies',NULL,'person'),(106,'Гилермо дел Торо','Guillermo del Toro','guillermo-del-toro',NULL,'movies',NULL,'person'),(107,'Мартин Фрийман','Martin Freeman','martin-freeman',NULL,'movies',NULL,'person'),(108,'Хюго Уийвинг','Hugo Weaving','hugo-weaving',NULL,'movies',NULL,'person'),(109,'Люк Евънс','Luke Evans','luke-evans',NULL,'movies',NULL,'person'),(110,'Орландо Блум','Orlando Bloom','orlando-bloom',NULL,'movies',NULL,'person'),(111,'Ейдън Търнър','Aidan Turner','aidan-turner',NULL,'movies',NULL,'person'),(112,'Кристофър Лий','Christopher Lee','christopher-lee',NULL,'movies',NULL,'person'),(113,'Ричард Армитаж','Richard Armitage','richard-armitage',NULL,'movies',NULL,'person'),(114,'Били Конъли','Billy Connolly','billy-connolly',NULL,'movies',NULL,'person'),(115,'Джеймс Несбит','James Nesbitt','james-nesbitt',NULL,'movies',NULL,'person'),(116,'Кейт Бланшет','Cate Blanchett','cate-blanchett',NULL,'movies',NULL,'person'),(117,'Стивън Хънтър','Stephen Hunter','stephen-hunter',NULL,'movies',NULL,'person'),(118,'Кен Скот','Ken Stott','ken-stott',NULL,'movies',NULL,'person'),(119,'Еванджелин Лили','Evangeline Lilly','evangeline-lilly',NULL,'movies',NULL,'person'),(120,'Андрю Лесни','Andrew Lesnie','andrew-lesnie',NULL,'movies',NULL,'person'),(121,'Хауърд Шор','Howard Shore','howard-shore',NULL,'movies',NULL,'person'),(122,'Бенедикт Къмбърбач','Benedict Cumberbatch','benedict-cumberbatch',NULL,'movies',NULL,'person'),(123,'Даян фон Фюрстенберг','Diane von Furstenberg','diane-von-furstenberg',NULL,'books',NULL,'person'),(124,'Чанинг Тейтъм','Channing Tatum','channing-tatum',NULL,'movies',NULL,'person'),(125,'Анди Уашовски','Andy Wachowski','andy-wachowski',NULL,'movies',NULL,'person'),(126,'Мила Кунис','Mila Kunis','mila-kunis',NULL,'movies',NULL,'person'),(127,'Дж. Р. Р. Толкин','J. R. R. Tolkien','j-r-r-tolkien',NULL,'books',NULL,'person'),(128,'Лана Уашовски','Lana Wachowski','lana-wachowski',NULL,'movies',NULL,'person'),(129,'Шон Бийн','Sean Bean','sean-bean',NULL,'movies',NULL,'person'),(130,'Дъглас Буут','Douglas Booth','douglas-booth',NULL,'movies',NULL,'person'),(131,'Еди Редмейн','Eddie Redmayne','eddie-redmayne',NULL,'movies',NULL,'person'),(132,'Джон Тол','John Toll','john-toll',NULL,'movies',NULL,'person'),(133,'Даниел Крейг','Daniel Craig','daniel-craig',NULL,'movies',NULL,'person'),(134,'Кристоф Валц','Christoph Waltz','christoph-waltz',NULL,'movies',NULL,'person'),(135,'Леонардо ди Каприо','Leonardo DiCaprio','leonardo-dicaprio',NULL,'movies',NULL,'person'),(136,'Ана Юърс','Anna Ewers','anna-ewers',NULL,'movies',NULL,'person'),(137,'Алехандро Гонсалес Иняриту','Alejandro González Iñárritu','alejandro-gonzález-iñárritu',NULL,'movies',NULL,'person'),(138,NULL,'Heavy Rain','heavy-rain',NULL,'games',NULL,'game'),(139,NULL,'Murdered: Soul Suspect','murdered-soul-suspect',NULL,'games',NULL,'game'),(140,NULL,'Fahrenheit','fahrenheit',NULL,'games',NULL,'game'),(141,NULL,'L.A. Noire','la-noire',NULL,'games',NULL,'game'),(142,NULL,'The Wolf Among Us','the-wolf-among-us',NULL,'games',NULL,'game'),(143,NULL,'CSI: Miami','csi-miami',NULL,'games',NULL,'game'),(144,NULL,'Game of Thrones','game-of-thrones',NULL,'games',NULL,'game'),(145,NULL,'The Witcher 2: Assassin of Kings','the-witcherw-2-assassin-of-kings',NULL,'games',NULL,'game'),(146,NULL,'Dragon Age 2','dragon-age-2',NULL,'games',NULL,'game'),(147,NULL,'Bound by Flame','bound-by-flame',NULL,'games',NULL,'game'),(148,NULL,'Hohokum','hohokum',NULL,'games',NULL,'game'),(149,NULL,'Snake','snake',NULL,'games',NULL,'game'),(150,NULL,'Kingdoms of Amalur: Reckoning','kingdoms-of-amalur-reckoning',NULL,'games',NULL,'game'),(151,NULL,'FIFA 14','fifa-14',NULL,'games',NULL,'game'),(152,NULL,'Dark Souls','dark-souls',NULL,'games',NULL,'game'),(153,NULL,'FIFA 15','fifa-15',NULL,'games',NULL,'game'),(154,NULL,'Divinity: Original Sin','divinity-original-sin',NULL,'games',NULL,'game'),(155,NULL,'Winning Eleven 7','winning-eleven-7',NULL,'games',NULL,'game'),(156,NULL,'PES 15','pes-15',NULL,'games',NULL,'game'),(157,NULL,'Fallout','fallout',NULL,'games',NULL,'game'),(158,NULL,'Neverwinter Nights 2','neverwinter-nights-2',NULL,'games',NULL,'game'),(159,NULL,'Fallout 2','fallout-2',NULL,'games',NULL,'game'),(160,NULL,'Beyond Divinity','beyond-divinity',NULL,'games',NULL,'game'),(161,NULL,'Dragon Age: Inquisition','dragon-age-inquisition',NULL,'games',NULL,'game'),(162,NULL,'Valiant Hearts','valiant-hearts',NULL,'games',NULL,'game'),(163,NULL,'Dark Souls 2','dark-souls-2',NULL,'games',NULL,'game'),(164,NULL,'Crown of the Sunken King','crown-of-the-sunken-king',NULL,'games',NULL,'dlc'),(165,NULL,'Crown of the Ivory King','crown-of-the-ivory-king',NULL,'games',NULL,'dlc'),(166,NULL,'Crown of the Old Iron King','crown-of-the-old-iron-king',NULL,'games',NULL,'dlc'),(167,NULL,'Call of Duty: Black Ops 2','call-of-duty-black-ops-2',NULL,'games',NULL,'game'),(168,NULL,'Child of Light','child-of-light',NULL,'games',NULL,'game'),(169,NULL,'Brothers: A Tale of Two Sons','brothers-a-tale-of-two-sons',NULL,'games',NULL,'game'),(170,NULL,'Limbo','limbo',NULL,'games',NULL,'game'),(171,NULL,'Journey','journey',NULL,'games',NULL,'game'),(172,NULL,'Risen 3: Titan Lords','risen-3',NULL,'games',NULL,'game'),(173,NULL,'Two Worlds 2','two-worlds-2',NULL,'games',NULL,'game'),(174,NULL,'Gothic 2','gothic-2',NULL,'games',NULL,'game'),(175,NULL,'Risen','risen',NULL,'games',NULL,'game'),(176,NULL,'Murasaki Baby','murasaki-baby',NULL,'games',NULL,'game'),(177,NULL,'Grand Theft Auto 5','gta-5',NULL,'games',NULL,'game'),(178,NULL,'Saints Row: The Third','saints-row-3',NULL,'games',NULL,'game'),(179,NULL,'Watch Dogs','watch-dogs',NULL,'games',NULL,'game'),(180,NULL,'iCloud','i-cloud',NULL,'games',NULL,'game'),(181,NULL,'Sleeping Dogs','sleeping-dogs',NULL,'games',NULL,'game'),(182,NULL,'Final Fantasy XII','final-fantasy-12',NULL,'games',NULL,'game'),(183,NULL,'Dear Easter','dear-easter',NULL,'games',NULL,'game'),(184,NULL,'Shin Megami Tensei','shin-megami-tensei',NULL,'games',NULL,'game'),(185,NULL,'Ni No Kuni','ni-no-kuni',NULL,'games',NULL,'game'),(186,NULL,'Final Fantasy X/X-2 HD Remaster','final-fantasy-10-hd-remaster',NULL,'games',NULL,'game'),(187,NULL,'Gone Home','gone-home',NULL,'games',NULL,'game'),(188,NULL,'Destiny','destiny',NULL,'games',NULL,'game'),(189,NULL,'The Vanishing of Ethan Carter','the-vanishing-of-ethan-carter',NULL,'games',NULL,'game'),(190,NULL,'Borderlands','borderlands',NULL,'games',NULL,'game'),(191,NULL,'Driveclub','driveclub',NULL,'games',NULL,'game'),(192,NULL,'Outlast','outlast',NULL,'games',NULL,'game'),(193,NULL,'NBA 2K15','nba-2k15',NULL,'games',NULL,'game'),(194,NULL,'Alien: Isolation','alien-isolation',NULL,'games',NULL,'game'),(195,NULL,'Need for Speed: Hot Pursuit','need-for-speed-hot-pursuit',NULL,'games',NULL,'game'),(196,NULL,'Need for Speed: Rivals','need-for-speed-rivals',NULL,'games',NULL,'game'),(197,NULL,'NBA Live 15','nba-live-15',NULL,'games',NULL,'game'),(198,NULL,'Bioshock: Infinite','bioshock-infinite',NULL,'games',NULL,'game'),(199,NULL,'Wolfenstein: The New Order','wolfenstein-the-new-order',NULL,'games',NULL,'game'),(200,NULL,'Call of Duty 4: Modern Warfare','call-of-duty-4-modern-warfare',NULL,'games',NULL,'game'),(201,NULL,'Metal Gear Solid 5: Ground Zeroes','metal-gear-solid-5-ground-zeroes',NULL,'games',NULL,'game'),(202,NULL,'Grand Theft Auto 4','gta-4',NULL,'games',NULL,'game'),(203,NULL,'Metal Gear Solid','metal-gear-solid',NULL,'games',NULL,'game'),(204,NULL,'Splinter Cell: Black List','splinter-cell-black-list',NULL,'games',NULL,'game'),(205,NULL,'The Witcher 3','the-witcher-3',NULL,'games',NULL,'game'),(206,NULL,'Call of Duty: Advanced Warfare','call-of-duty-advanced-warfare',NULL,'games',NULL,'game'),(207,NULL,'Red Dead Redemption','red-dead-redemption',NULL,'games',NULL,'game'),(208,NULL,'Far Cry 4','far-cry-4',NULL,'games',NULL,'game'),(209,NULL,'Uncharted 4','uncharted-4',NULL,'games',NULL,'game'),(210,NULL,'LittleBigPlanet 2','littlebigplanet-2',NULL,'games',NULL,'game'),(211,NULL,'LittleBigPlanet 3','littlebigplanet-3',NULL,'games',NULL,'game'),(212,NULL,'Call of Duty: Ghosts','call-of-duty-ghosts',NULL,'games',NULL,'game'),(213,NULL,'LittleBigPlanet PSP','littlebigplanet-psp',NULL,'games',NULL,'game'),(214,NULL,'Grand Theft Auto 6','gta-6',NULL,'games',NULL,'game'),(215,NULL,'LittleBigPlanet','littlebigplanet',NULL,'games',NULL,'game'),(216,NULL,'Super Mario Maker','super-mario-maker',NULL,'games',NULL,'game'),(217,NULL,'Tearway','tearway',NULL,'games',NULL,'game'),(218,NULL,'WWE 2K16','wwe-2k16',NULL,'games',NULL,'game'),(219,NULL,'Baldur&#x27;s Gate','baldurs-gate',NULL,'games',NULL,'game'),(220,NULL,'Baldur&#x27;s Gate 2','baldurs-gate-2',NULL,'games',NULL,'game'),(221,NULL,'Demon&#x27;s Souls','demons-souls',NULL,'games',NULL,'game'),(222,NULL,'Assassin&#x27;s Creed Unity','assassins-creed-unity',NULL,'games',NULL,'game'),(223,NULL,'Assassin&#x27;s Creed Rogue','assassins-creed-rogue',NULL,'games',NULL,'game'),(224,NULL,'The Conjuring','the-conjuring',NULL,'movies',NULL,'movie'),(225,NULL,'Insidious Chapter 2','insidious-chapter-2',NULL,'movies',NULL,'movie'),(226,NULL,'Sin City: A Dame to Kill For','sin-city-2',NULL,'movies',NULL,'movie'),(227,NULL,'Insidious','insidious',NULL,'movies',NULL,'movie'),(228,NULL,'Mama','mama',NULL,'movies',NULL,'movie'),(229,NULL,'Annabelle','annabelle',NULL,'movies',NULL,'movie'),(230,NULL,'Dawn of the Planet of the Apes','dawn-of-the-planet-of-the-apes',NULL,'movies',NULL,'movie'),(231,NULL,'Sin City','sin-city',NULL,'movies',NULL,'movie'),(232,NULL,'The Spirit','the-spirit',NULL,'movies',NULL,'movie'),(233,NULL,'Planet of the Apes (2001)','planet-of-the-apes-2001',NULL,'movies',NULL,'movie'),(234,NULL,'Avatar','avatar',NULL,'movies',NULL,'movie'),(235,NULL,'Locke','locke',NULL,'movies',NULL,'movie'),(236,NULL,'Rise of the Planet of the Apes','rise-of-the-planet-of-the-apes',NULL,'movies',NULL,'movie'),(237,NULL,'The Affair','the-affair',NULL,'movies',NULL,'movie'),(238,NULL,'The Guitar','the-guitar',NULL,'movies',NULL,'movie'),(239,NULL,'All is Lost','all-is-lost',NULL,'movies',NULL,'movie'),(240,NULL,'Phone Booth','phone-booth',NULL,'movies',NULL,'movie'),(241,NULL,'127 Hours','127-hours',NULL,'movies',NULL,'movie'),(242,NULL,'Buried','buried',NULL,'movies',NULL,'movie'),(243,NULL,'Star Wars Episode 1','star-wars-episode-1',NULL,'movies',NULL,'movie'),(244,NULL,'Star Wars Episode 2','star-wars-episode-2',NULL,'movies',NULL,'movie'),(245,NULL,'Guardians of the Galaxy','guardians-of-the-galaxy',NULL,'movies',NULL,'movie'),(246,NULL,'Star Wars Episode 4','star-wars-episode-4',NULL,'movies',NULL,'movie'),(247,NULL,'Star Wars Episode 3','star-wars-episode-3',NULL,'movies',NULL,'movie'),(248,NULL,'Star Wars Episode 5','star-wars-episode-5',NULL,'movies',NULL,'movie'),(249,NULL,'Raiders of the Lost Ark','raiders-of-the-lost-ark',NULL,'movies',NULL,'movie'),(250,NULL,'Star Wars Episode 6','star-wars-episode-6',NULL,'movies',NULL,'movie'),(251,NULL,'Indiana Jones and the Temple of Doom','indiana-jones-and-the-temple-of-doom',NULL,'movies',NULL,'movie'),(252,NULL,'Maleficent','maleficent',NULL,'movies',NULL,'movie'),(253,NULL,'Horns','horns',NULL,'movies',NULL,'movie'),(254,NULL,'Indiana Jones and the Last Crusade','indiana-jones-and-the-last-crusade',NULL,'movies',NULL,'movie'),(255,NULL,'Frankenweenie','frankenweenie',NULL,'movies',NULL,'movie'),(256,NULL,'Stand by Me','stand-by-me',NULL,'movies',NULL,'movie'),(257,NULL,'Advanced Style','advanced-style',NULL,'movies',NULL,'movie'),(258,NULL,'Alien','alien',NULL,'movies',NULL,'movie'),(259,'Български национален отбор по футбол','Bulgarian national football team','bulgarian-national-football-team',NULL,'music',NULL,'band'),(260,NULL,'Taxi Driver','taxi-driver',NULL,'movies',NULL,'movie'),(261,NULL,'Nightcrawler','nightcrawler',NULL,'movies',NULL,'movie'),(262,NULL,'Space Jam','space-jam',NULL,'movies',NULL,'movie'),(263,NULL,'Se7en','seven',NULL,'movies',NULL,'movie'),(264,NULL,'Gone Girl','gone-girl',NULL,'movies',NULL,'movie'),(265,NULL,'Gone Baby Gone','gone-baby-gone',NULL,'movies',NULL,'movie'),(266,NULL,'Wild Things','wild-things',NULL,'movies',NULL,'movie'),(267,NULL,'Harry Potter and the Deathly Hallows: Part 1','harry-potter-and-the-deathly-hallows',NULL,'movies',NULL,'movie'),(268,NULL,'Harry Potter and the Deathly Hallows: Part 2','harry-potter-and-the-deathly-hallows-2',NULL,'movies',NULL,'movie'),(269,NULL,'The Lord of the Rings: The Fellowship of the Ring','the-lord-of-the-rings-the-fellowship-of-the-ring',NULL,'movies',NULL,'movie'),(270,NULL,'Terminator: Genisys','terminator-genisys',NULL,'movies',NULL,'movie'),(271,NULL,'Prisoners','prisoners',NULL,'movies',NULL,'movie'),(272,NULL,'The Lord of the Rings: The Two Towers','the-lord-of-the-rings-the-two-towers',NULL,'movies',NULL,'movie'),(273,NULL,'The Hobbit: An Unexpected Journey','the-hobbit-an-unexpected-journey',NULL,'movies',NULL,'movie'),(274,NULL,'The Lord of the Rings: The Return of the King','the-lord-of-the-rings-the-return-of-the-king',NULL,'movies',NULL,'movie'),(275,NULL,'The Hobbit: The Desolation of Smaug','the-hobbit-the-desolation-of-smaug',NULL,'movies',NULL,'movie'),(276,NULL,'Elysium','elysium',NULL,'movies',NULL,'movie'),(277,NULL,'The Hobbit: The Battle of the Five Armies','the-hobbit-the-battle-of-the-five-armies',NULL,'movies',NULL,'movie'),(278,NULL,'Jupiter Ascending','jupiter-ascending',NULL,'movies',NULL,'movie'),(279,NULL,'Spectre','spectre',NULL,'movies',NULL,'movie'),(280,NULL,'The Revenant','the-revenant',NULL,'movies',NULL,'movie'),(281,NULL,'Ouch! That&#x27;s Big','ouch-thats-big',NULL,'movies',NULL,'movie'),(282,NULL,'Emil Bulls','emil-bulls',NULL,'music',NULL,'band'),(283,NULL,'Marilyn Manson','marilyn-manson',NULL,'music',NULL,'band'),(284,NULL,'Sacrifice To Venus','sacrifice-to-venus',NULL,'music',NULL,'album'),(285,NULL,'Korn','korn',NULL,'music',NULL,'band'),(286,NULL,'Slipknot','slipknot',NULL,'music',NULL,'band'),(287,NULL,'Coal Chamber','coal-chamber',NULL,'music',NULL,'band'),(288,NULL,'Body Count','body-count',NULL,'music',NULL,'band'),(289,NULL,'Manslaughter','manslaughter',NULL,'music',NULL,'album'),(290,NULL,'Public Enemy','public-enemy',NULL,'music',NULL,'band'),(291,NULL,'System of a Down','system-of-a-down',NULL,'music',NULL,'band'),(292,NULL,'(hed) p.e.','hed-pe',NULL,'music',NULL,'band'),(293,NULL,'Beastie Boys','beastie-boys',NULL,'music',NULL,'band'),(294,NULL,'Suicidal Tendencies','suicidal-tendencies',NULL,'music',NULL,'band'),(295,'Ice-T','Ice T','ice-t',NULL,'music',NULL,'person'),(296,'Лана Дел Рей','Lana Del Rey','lana-del-rey',NULL,'music',NULL,'person'),(297,NULL,'Ultraviolence','ultraviolence',NULL,'music',NULL,'album'),(298,NULL,'Sofia Rocks 2014','sofia-rocks-2014',NULL,'music',NULL,'event'),(299,NULL,'Osssy','ossy',NULL,'music',NULL,'band'),(300,NULL,'Alcest','alcest',NULL,'music',NULL,'band'),(301,NULL,'Skillet','skillet',NULL,'music',NULL,'band'),(302,NULL,'Mando Diao','mando-diao',NULL,'music',NULL,'band'),(303,NULL,'The Offspring','the-offspring',NULL,'music',NULL,'band'),(304,'Фарел Уилямс','Pharrell Williams','pharrell-williams',NULL,'music',NULL,'person'),(305,NULL,'Thirty Seconds to Mars','thirty-seconds-to-mars',NULL,'music',NULL,'band'),(306,NULL,'Square Enix','square-enix',NULL,'games',NULL,'company'),(307,NULL,'Forplay','forplay',NULL,'games',NULL,'company'),(308,NULL,'Airtight Games','airtight-games',NULL,'games',NULL,'company'),(309,NULL,'Honeyslug','honeyslug',NULL,'games',NULL,'company'),(310,NULL,'Sony Computer Entertainment','sony-computer-entertainment',NULL,'games',NULL,'company'),(311,NULL,'Focus Home Interactive','focus-home-interactive',NULL,'games',NULL,'company'),(312,NULL,'EA Canada','ea-canada',NULL,'games',NULL,'company'),(313,NULL,'Namco Bandai','namco-bandai',NULL,'games',NULL,'company'),(314,NULL,'EA Sports','ea-sports',NULL,'games',NULL,'company'),(315,NULL,'From Software','from-software',NULL,'games',NULL,'company'),(316,NULL,'Larian Studios','larian-studios',NULL,'games',NULL,'company'),(317,NULL,'Ikaron','ikaron',NULL,'games',NULL,'company'),(318,NULL,'Ubisoft','ubisoft',NULL,'games',NULL,'company'),(319,NULL,'Polydor Records','polydor-records',NULL,'music',NULL,'company'),(320,NULL,'Interscope Records','interscope-records',NULL,'music',NULL,'company'),(321,NULL,'Ubisoft Montpelier','ubisoft-montpelier',NULL,'games',NULL,'company'),(322,NULL,'Deep Silver','deep-silver',NULL,'games',NULL,'company'),(323,NULL,'Ovosonico','ovosonico',NULL,'games',NULL,'company'),(324,NULL,'Piranha Bites','piranha-bites',NULL,'games',NULL,'company'),(325,NULL,'Ubisoft Montreal','ubisoft-montreal',NULL,'games',NULL,'company'),(326,NULL,'Virtuos','virtuos',NULL,'games',NULL,'company'),(327,NULL,'Bungie','bungie',NULL,'games',NULL,'company'),(328,NULL,'The Astronauts','the-astronauts ',NULL,'games',NULL,'company'),(329,NULL,'Evolution Studios','evolution-studios',NULL,'games',NULL,'company'),(330,NULL,'Activision','activision',NULL,'games',NULL,'company'),(331,NULL,'SEGA','sega',NULL,'games',NULL,'company'),(332,NULL,'2K Sports','2k-sports',NULL,'games',NULL,'company'),(333,NULL,'Creative Assembly','creative-assembly',NULL,'games',NULL,'company'),(334,NULL,'Bethesda Softworks','bethesda-softworks',NULL,'games',NULL,'company'),(335,NULL,'Visual Concepts','visual-concepts',NULL,'games',NULL,'company'),(336,NULL,'MachineGames','machinegames',NULL,'games',NULL,'company'),(337,NULL,'Konami','konami',NULL,'games',NULL,'company'),(338,NULL,'Kojima Productions','kojima-productions',NULL,'games',NULL,'company'),(339,NULL,'Take Two','take-two',NULL,'games',NULL,'company'),(340,NULL,'Sledgehammer Games','sledgehammer-games',NULL,'games',NULL,'company'),(341,NULL,'Sumo Digital','sumo-digital',NULL,'games',NULL,'company'),(342,NULL,'Rockstar','rockstar',NULL,'games',NULL,'company'),(343,NULL,'Electronic Arts','electronic-arts',NULL,'games',NULL,'company'),(344,NULL,'BioWare','bioware',NULL,'games',NULL,'company'),(345,NULL,'Castle Design','castle-design',NULL,'games',NULL,'company'),(346,NULL,'Diablo','diablo',NULL,'games',NULL,'serie'),(347,NULL,'Halo','halo',NULL,'games',NULL,'serie'),(348,NULL,'Star Wars','star-wars',NULL,'movies',NULL,'serie'),(349,NULL,'Grand Theft Auto','gta',NULL,'games',NULL,'serie'),(350,NULL,'Batman','batman',NULL,'movies',NULL,'serie'),(351,NULL,'FIFA','fifa',NULL,'games',NULL,'serie'),(352,NULL,'Baldur&#x27;s Gate','baldurs-gate',NULL,'games',NULL,'serie'),(353,NULL,'Fallout','fallout',NULL,'games',NULL,'serie'),(354,NULL,'True Blood','true-blood',NULL,'movies',NULL,'serie'),(355,NULL,'Neverwinter Nights','neverwinter-nights',NULL,'games',NULL,'serie'),(356,NULL,'Dragon Age','dragon-age',NULL,'games',NULL,'serie'),(357,NULL,'Souls','souls',NULL,'games',NULL,'serie'),(358,NULL,'Sin City','sin-city',NULL,'movies',NULL,'serie'),(359,NULL,'LEGO','lego',NULL,'games',NULL,'serie'),(360,NULL,'Risen','risen',NULL,'games',NULL,'serie'),(361,NULL,'Indiana Jones','indiana-jones',NULL,'movies',NULL,'serie'),(362,NULL,'Planet of the Apes','planet-of-the-apes',NULL,'movies',NULL,'serie'),(363,NULL,'Saints Row','saints-row',NULL,'games',NULL,'serie'),(364,NULL,'Assassin&#x27;s Creed','assassins-creed',NULL,'games',NULL,'serie'),(365,NULL,'Форплей Подкаст','forplay-podcast',NULL,'games',NULL,'serie'),(366,NULL,'Final Fantasy','final-fantasy',NULL,'games',NULL,'serie'),(367,NULL,'Alien','alien',NULL,'movies',NULL,'serie'),(368,NULL,'Need for Speed','need-for-speed',NULL,'games',NULL,'serie'),(369,NULL,'NBA','nba',NULL,'games',NULL,'serie'),(370,NULL,'Wolfenstein','wolfenstein',NULL,'games',NULL,'serie'),(371,NULL,'Metal Gear','metal-gear',NULL,'games',NULL,'serie'),(372,NULL,'Pro Evolution Soccer','pes',NULL,'games',NULL,'serie'),(373,NULL,'Splinter Cell','splinter-cell',NULL,'games',NULL,'serie'),(374,NULL,'Harry Potter','harry-potter',NULL,'movies',NULL,'serie'),(375,NULL,'Call of Duty','call-of-duty',NULL,'games',NULL,'serie'),(376,NULL,'The Lord of the Rings','the-lord-of-the-rings',NULL,'movies',NULL,'serie'),(377,NULL,'The Hobbit','the-hobbit',NULL,'movies',NULL,'serie'),(378,NULL,'Far Cry','far-cry',NULL,'games',NULL,'serie'),(379,NULL,'LittleBigPlanet','littlebigplanet',NULL,'games',NULL,'serie'),(380,NULL,'Terminator','terminator',NULL,'movies',NULL,'serie'),(381,'Вила Тъга','Villa Triste','villa-triste',NULL,'books',NULL,'book'),(382,NULL,'The Woman I Wanted to Be','the-woman-i-wanted-to-be',NULL,'books',NULL,'book'),(383,'Вулкан','Vulcan','vulcan',NULL,'games',NULL,'character'),(384,'Мейсън','Mason','mason',NULL,'games',NULL,'character'),(385,'Надгробен камък','Tombstone','tombstone',NULL,'games',NULL,'character'),(386,'Би Джей Бласковиц','B. J. Blazkowicz','b-j-blazkowicz',NULL,'games',NULL,'character'),(387,'Майкъл','Michael','michael',NULL,'games',NULL,'character'),(388,'Тревор','Trevor','trevor',NULL,'games',NULL,'character'),(389,'Супер Марио','Super Mario','super-mario',NULL,'games',NULL,'character');
/*!40000 ALTER TABLE `for_tags` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `for_tracks`
--

DROP TABLE IF EXISTS `for_tracks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `for_tracks` (
  `track_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `tag_id` mediumint(9) unsigned NOT NULL,
  `order` tinyint(4) unsigned DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `video` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`track_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `for_tracks`
--

LOCK TABLES `for_tracks` WRITE;
/*!40000 ALTER TABLE `for_tracks` DISABLE KEYS */;
/*!40000 ALTER TABLE `for_tracks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database 'forplay'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-01-14  9:54:26
