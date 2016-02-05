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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `for_authors`
--

LOCK TABLES `for_authors` WRITE;
/*!40000 ALTER TABLE `for_authors` DISABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `for_countries`
--

LOCK TABLES `for_countries` WRITE;
/*!40000 ALTER TABLE `for_countries` DISABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `for_events`
--

LOCK TABLES `for_events` WRITE;
/*!40000 ALTER TABLE `for_events` DISABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `for_games`
--

LOCK TABLES `for_games` WRITE;
/*!40000 ALTER TABLE `for_games` DISABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `for_genres`
--

LOCK TABLES `for_genres` WRITE;
/*!40000 ALTER TABLE `for_genres` DISABLE KEYS */;
/*!40000 ALTER TABLE `for_genres` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `for_issues`
--

DROP TABLE IF EXISTS `for_issues`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `for_issues` (
  `issue_id` tinyint(4) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `tag` smallint(5) unsigned NOT NULL,
  PRIMARY KEY (`issue_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `for_issues`
--

LOCK TABLES `for_issues` WRITE;
/*!40000 ALTER TABLE `for_issues` DISABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `for_log`
--

LOCK TABLES `for_log` WRITE;
/*!40000 ALTER TABLE `for_log` DISABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `for_movies`
--

LOCK TABLES `for_movies` WRITE;
/*!40000 ALTER TABLE `for_movies` DISABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `for_platforms`
--

LOCK TABLES `for_platforms` WRITE;
/*!40000 ALTER TABLE `for_platforms` DISABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `for_stickers`
--

LOCK TABLES `for_stickers` WRITE;
/*!40000 ALTER TABLE `for_stickers` DISABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `for_tags`
--

LOCK TABLES `for_tags` WRITE;
/*!40000 ALTER TABLE `for_tags` DISABLE KEYS */;
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

-- Dump completed on 2016-01-11 21:38:30
