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
  `platform` varchar(32) DEFAULT NULL,
  `better` varchar(128) DEFAULT NULL,
  `worse` varchar(128) DEFAULT NULL,
  `equal` varchar(128) DEFAULT NULL,
  `better_text` varchar(128) DEFAULT NULL,
  `worse_text` varchar(128) DEFAULT NULL,
  `equal_text` varchar(128) DEFAULT NULL,
  PRIMARY KEY (`article_id`),
  UNIQUE KEY `url_UNIQUE` (`url`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `for_articles`
--

LOCK TABLES `for_articles` WRITE;
/*!40000 ALTER TABLE `for_articles` DISABLE KEYS */;
INSERT INTO `for_articles` VALUES (1,'games','aside','GTA 5',NULL,'Planet.bmp',NULL,NULL,'forplay','gta-5','2015-10-18 12:11:00',NULL,'Натиснете тук, за да редактирате текста, използвайки само един параграф, болд , италик и връзки . Този едитор поддържа и стандартни функции, като копи, пейст, ънду и реду. За да редактирата съдържанието директно в HTML използвайте бутона Source .',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(2,'games','aside','GTA 6',NULL,'Planet.bmp',NULL,NULL,'forplay','gta-6','2015-10-18 13:39:00',NULL,'Натиснете тук, за да редактирате текста, използвайки само един параграф, болд , италик и връзки . Този едитор поддържа и стандартни функции, като копи, пейст, ънду и реду. За да редактирата съдържанието директно в HTML използвайте бутона Source .',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(3,'games','aside','GTA 7',NULL,'Planet.bmp',NULL,NULL,'forplay','gta-7','2015-10-18 13:39:00',NULL,'Натиснете тук, за да редактирате текста, използвайки само един параграф, болд , италик и връзки . Този едитор поддържа и стандартни функции, като копи, пейст, ънду и реду. За да редактирата съдържанието директно в HTML използвайте бутона Source .',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(4,'boards','aside','Hello Kitty','Кур за лефски!','C:fakepathspain.png',NULL,NULL,'forlife','hello-kitty','2015-10-20 16:48:00','aside','Натиснете тук, за да редактирате текста, използвайки само един параграф, болд , италик и връзки . Този едитор поддържа и стандартни функции, като копи, пейст, ънду и реду. За да редактирата съдържанието директно в HTML използвайте бутона Source .',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(12,'games','review','Gta','Хелоу кити!','alien-isolation-38.jpg','alien-isolation-36.jpg','alien-isolation-34.jpg','forplay','grand-theft-auto-4','2015-10-29 16:53:00','cover','Натиснете тук, за да редактирате текста, използвайки само параграфи, болд, италик и връзки. Този едитор поддържа и стандартни функции, като копи, пейст, ънду и реду. За да редактирата съдържанието директно в HTML използвайте бутона Source.',NULL,NULL,NULL,NULL,NULL,'alien-isolation-37.jpg','center','top','673AB7','FFFFFF',65,'ps4','sin-city-2','the-spirit','dawn-of-the-planet-of-the-apes','Test',NULL,NULL),(20,'games','review','Gta','Хелоу кити!','alien-isolation-38.jpg','alien-isolation-36.jpg','alien-isolation-34.jpg','forplay','diablo-2','2015-10-29 16:53:00','cover','Натиснете тук, за да редактирате текста, използвайки само параграфи, болд, италик и връзки. Този едитор поддържа и стандартни функции, като копи, пейст, ънду и реду. За да редактирата съдържанието директно в HTML използвайте бутона Source.',NULL,NULL,NULL,NULL,NULL,'alien-isolation-37.jpg','center','top','673AB7','FFFFFF',65,'ps4','sin-city-2','the-spirit','dawn-of-the-planet-of-the-apes','Test',NULL,NULL),(21,'games','','Аз съм каре',NULL,'alien-isolation-03.jpg',NULL,NULL,'forplay','аз-съм-каре','2015-10-29 16:53:00',NULL,'Натиснете тук, за да редактирате текста, използвайки само един параграф, болд , италик и връзки . Този едитор поддържа и стандартни функции, като копи, пейст, ънду и реду. За да редактирата съдържанието директно в HTML използвайте бутона Source .',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(22,'games','','Blah  blah',NULL,'alien-isolation-26.jpg',NULL,NULL,'forplay','blah--blah','2015-10-29 18:57:00',NULL,'Натиснете тук, за да редактирате текста, използвайки само един параграф, болд , италик и връзки . Този едитор поддържа и стандартни функции, като копи, пейст, ънду и реду. За да редактирата съдържанието директно в HTML използвайте бутона Source .',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(23,'games','review','GTA',NULL,'alien-isolation-16.jpg',NULL,NULL,'forplay','van-van','2015-10-29 20:40:00',NULL,'Натиснете тук, за да редактирате текста, използвайки само параграфи, болд, италик и връзки. Този едитор поддържа и стандартни функции, като копи, пейст, ънду и реду. За да редактирата съдържанието директно в HTML използвайте бутона Source.',NULL,NULL,NULL,NULL,NULL,NULL,'center','top',NULL,'FFFFFF',10,'360','diablo','batman-4','diablo-7',NULL,NULL,'Test'),(31,'games','news','Kur',NULL,'alien-isolation-28.jpg',NULL,NULL,'forplay','kur','2015-10-30 14:04:00',NULL,'Натиснете тук, за да редактирате текста, използвайки само параграфи, болд, италик и връзки. Този едитор поддържа и стандартни функции, като копи, пейст, ънду и реду. За да редактирата съдържанието директно в HTML използвайте бутона Source.',NULL,NULL,NULL,NULL,NULL,NULL,'center','top',NULL,'FFFFFF',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `for_authors`
--

LOCK TABLES `for_authors` WRITE;
/*!40000 ALTER TABLE `for_authors` DISABLE KEYS */;
INSERT INTO `for_authors` VALUES (1,'Snake',NULL,'snake'),(2,'Koralsky',NULL,'koralsky');
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
  `endDate` date DEFAULT NULL,
  `city` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`event_id`)
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
  PRIMARY KEY (`game_id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `for_games`
--

LOCK TABLES `for_games` WRITE;
/*!40000 ALTER TABLE `for_games` DISABLE KEYS */;
INSERT INTO `for_games` VALUES (4,88,'2015-09-02'),(5,89,NULL),(7,98,NULL),(8,99,NULL),(9,100,NULL),(10,101,NULL),(11,102,NULL),(12,103,NULL),(13,104,NULL),(14,105,NULL),(15,106,NULL),(16,107,NULL),(19,110,NULL);
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
  `name` varchar(32) NOT NULL,
  `tag` varchar(32) NOT NULL,
  `type` varchar(16) NOT NULL,
  PRIMARY KEY (`genre_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `for_genres`
--

LOCK TABLES `for_genres` WRITE;
/*!40000 ALTER TABLE `for_genres` DISABLE KEYS */;
INSERT INTO `for_genres` VALUES (1,'Ужаси','horror','games');
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
  `tag` varchar(128) NOT NULL,
  PRIMARY KEY (`issue_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `for_issues`
--

LOCK TABLES `for_issues` WRITE;
/*!40000 ALTER TABLE `for_issues` DISABLE KEYS */;
INSERT INTO `for_issues` VALUES (1,'Демо','issue-0-demo'),(2,'Презареждане','issue-1-reboot'),(3,'Bloodborne','issue-2-blоodborne');
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
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `for_layouts`
--

LOCK TABLES `for_layouts` WRITE;
/*!40000 ALTER TABLE `for_layouts` DISABLE KEYS */;
INSERT INTO `for_layouts` VALUES (7,12,'text','text','<p>Натиснете тук, за да редактирате текста, използвайки само параграфи, <strong>болд</strong>, <em>италик</em> и <a href=\"#\" target=\"_blank\">връзки</a>. Този едитор поддържа и стандартни функции, като копи, пейст, ънду и реду.</p><blockquote><p>За да оградите параграф, като цитат, използвайте бутона с кавичките.</p></blockquote><h3>Може да използвате и хединг 3</h3><p>За да редактирата съдържанието директно в HTML използвайте бутона <em>Source</em>.</p>',NULL,NULL,NULL,NULL,NULL,NULL,'16-9',0),(8,12,'img','a1',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'16-10',0),(9,12,'text','text','<p>Натиснете тук, за да редактирате текста, използвайки само параграфи, <strong>болд</strong>, <em>италик</em> и <a href=\"#\" target=\"_blank\">връзки</a>. Този едитор поддържа и стандартни функции, като копи, пейст, ънду и реду.</p><blockquote><p>За да оградите параграф, като цитат, използвайте бутона с кавичките.</p></blockquote><h3>Може да използвате и хединг 3</h3><p>За да редактирата съдържанието директно в HTML използвайте бутона <em>Source</em>.</p>',NULL,NULL,NULL,NULL,NULL,NULL,'16-9',0),(24,20,'text','text','<p>Натиснете тук, за да редактирате текста, използвайки само параграфи, <strong>болд</strong>, <em>италик</em> и <a href=\"#\" target=\"_blank\">връзки</a>. Този едитор поддържа и стандартни функции, като копи, пейст, ънду и реду.</p><blockquote><p>За да оградите параграф, като цитат, използвайте бутона с кавичките.</p></blockquote><h3>Може да използвате и хединг 3</h3><p>За да редактирата съдържанието директно в HTML използвайте бутона <em>Source</em>.</p>',NULL,NULL,NULL,NULL,NULL,NULL,'16-9',0),(25,20,'img','a1',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'16-10',0),(26,20,'text','text','<p>Натиснете тук, за да редактирате текста, използвайки само параграфи, <strong>болд</strong>, <em>италик</em> и <a href=\"#\" target=\"_blank\">връзки</a>. Този едитор поддържа и стандартни функции, като копи, пейст, ънду и реду.</p><blockquote><p>За да оградите параграф, като цитат, използвайте бутона с кавичките.</p></blockquote><h3>Може да използвате и хединг 3</h3><p>За да редактирата съдържанието директно в HTML използвайте бутона <em>Source</em>.</p>',NULL,NULL,NULL,NULL,NULL,NULL,'16-9',0),(27,21,'<',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'<',0),(28,22,'text','t','<p>Натиснете тук, за да редактирате текста, използвайки само един параграф, <strong>болд</strong> , <em>италик</em> и <a href=\"#\" target=\"_blank\">връзки</a> . Този едитор поддържа и стандартни функции, като копи, пейст, ънду и реду. За да редактирата съдържанието директно в HTML използвайте бутона <em>Source</em> .</p>',NULL,NULL,NULL,NULL,NULL,NULL,'16-9',0),(29,23,'text','t','<p>Натиснете тук, за да редактирате текста, използвайки само параграфи, <strong>болд</strong>, <em>италик</em> и <a href=\"#\" target=\"_blank\">връзки</a>. Този едитор поддържа и стандартни функции, като копи, пейст, ънду и реду.</p><blockquote><p>За да оградите параграф, като цитат, използвайте бутона с кавичките.</p></blockquote><h3>Може да използвате и хединг 3</h3><p>За да редактирата съдържанието директно в HTML използвайте бутона <em>Source</em>.</p>',NULL,NULL,NULL,NULL,NULL,NULL,'16-9',0),(30,23,'text','t','<p>Натиснете тук, за да редактирате текста, използвайки само параграфи, <strong>болд</strong>, <em>италик</em> и <a href=\"#\" target=\"_blank\">връзки</a>. Този едитор поддържа и стандартни функции, като копи, пейст, ънду и реду.</p><blockquote><p>За да оградите параграф, като цитат, използвайте бутона с кавичките.</p></blockquote><h3>Може да използвате и хединг 3</h3><p>За да редактирата съдържанието директно в HTML използвайте бутона <em>Source</em>.</p>',NULL,NULL,NULL,NULL,NULL,NULL,'16-9',0),(31,31,'text','t','&lt;p&gt;Натиснете тук, за да редактирате текста, използвайки само параграфи, &lt;strong&gt;болд&lt;/strong&gt;, &lt;em&gt;италик&lt;/em&gt; и &lt;a href=&quot;#&quot; target=&quot;_blank&quot;&gt;връзки&lt;/a&gt;. Този едитор поддържа и стандартни функции, като копи, пейст, ънду и реду.&lt;/p&gt;&lt;blockquote&gt;&lt;p&gt;За да оградите параграф, като цитат, използвайте бутона с кавичките.&lt;/p&gt;&lt;/blockquote&gt;&lt;h3&gt;Може да използвате и хединг 3&lt;/h3&gt;&lt;p&gt;За да редактирата съдържанието директно в HTML използвайте бутона &lt;em&gt;Source&lt;/em&gt;.&lt;/p&gt;',NULL,NULL,NULL,NULL,NULL,NULL,'16-9',0),(32,31,'img','a1',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'16-9',1),(33,31,'text','t','&lt;p&gt;Натиснете тук, за да редактирате текста, използвайки само параграфи, &lt;strong&gt;болд&lt;/strong&gt;, &lt;em&gt;италик&lt;/em&gt; и &lt;a href=&quot;#&quot; target=&quot;_blank&quot;&gt;връзки&lt;/a&gt;. Този едитор поддържа и стандартни функции, като копи, пейст, ънду и реду.&lt;/p&gt;&lt;blockquote&gt;&lt;p&gt;За да оградите параграф, като цитат, използвайте бутона с кавичките.&lt;/p&gt;&lt;/blockquote&gt;&lt;h3&gt;Може да използвате и хединг 3&lt;/h3&gt;&lt;p&gt;За да редактирата съдържанието директно в HTML използвайте бутона &lt;em&gt;Source&lt;/em&gt;.&lt;/p&gt;',NULL,NULL,NULL,NULL,NULL,NULL,'16-9',2);
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
) ENGINE=InnoDB AUTO_INCREMENT=153 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `for_log`
--

LOCK TABLES `for_log` WRITE;
/*!40000 ALTER TABLE `for_log` DISABLE KEYS */;
INSERT INTO `for_log` VALUES (1,'insert','for_tags','diablo-3','game',0,'2015-08-24 22:53:04',NULL),(2,'insert','for_tags','diablo-8','company',0,'2015-08-27 02:00:49',NULL),(3,'insert','for_tags','diablo-9','company',0,'2015-08-27 02:01:46',NULL),(4,'insert','for_tags','diablo-10','company',0,'2015-08-27 02:02:42',NULL),(5,'insert','for_tags','diablo-5','company',0,'2015-08-27 17:58:16',NULL),(6,'insert','for_tags','chuck-norris-2','person',0,'2015-08-31 12:07:36',NULL),(7,'insert','for_tags','chuck-norris-3','person',0,'2015-08-31 12:08:29',NULL),(8,'insert','for_tags','chuck-norris-5','person',0,'2015-08-31 12:12:54',NULL),(13,'insert','for_tags','diablo-2','company',0,'2015-09-01 23:13:44',NULL),(15,'insert','for_tags','batman-10','company',0,'2015-09-01 23:20:40',NULL),(22,'insert','for_tags','batman-11','person',0,'2015-09-01 23:27:31',NULL),(28,'insert','for_tags','batman-12','person',0,'2015-09-01 23:28:32',NULL),(29,'insert','for_tags','sonic','character',0,'2015-09-04 00:07:18',NULL),(30,'insert','for_tags','sonic-2','character',0,'2015-09-04 00:09:40',NULL),(32,'insert','for_tags','sonic-3','character',0,'2015-09-04 00:10:34',NULL),(35,'insert','for_tags','from-ashes','dlc',0,'2015-09-04 00:32:58',NULL),(36,'insert','for_tags','gta','serie',0,'2015-09-04 00:34:00',NULL),(37,'insert','for_tags','halo','serie',0,'2015-09-04 23:07:22',NULL),(39,'insert','for_tags','hodor','character',0,'2015-09-04 23:10:11',NULL),(40,'insert','for_tags','minsc','character',0,'2015-09-04 23:12:11',NULL),(41,'insert','for_tags','boo','character',0,'2015-09-04 23:14:09',NULL),(42,'insert','for_tags','boo-2','character',0,'2015-09-04 23:14:33',NULL),(43,'insert','for_tags','boo-3','character',0,'2015-09-04 23:15:08',NULL),(44,'insert','for_tags','boo-4','character',0,'2015-09-04 23:15:28',NULL),(45,'insert','for_tags','boo-5','character',0,'2015-09-04 23:15:55',NULL),(46,'insert','for_tags','boo-6','character',0,'2015-09-04 23:19:25',NULL),(47,'insert','for_tags','boo-7','character',0,'2015-09-04 23:19:37',NULL),(48,'insert','for_tags','boo-8','character',0,'2015-09-04 23:20:01',NULL),(49,'insert','for_tags','','',0,'2015-09-04 23:55:27',NULL),(50,'insert','for_tags','batman','character',0,'2015-09-04 23:57:35',NULL),(51,'insert','for_tags','batman-2','character',0,'2015-09-05 00:01:36',NULL),(52,'insert','for_tags','batman-3','character',0,'2015-09-05 00:02:16',NULL),(53,'insert','for_tags','mass-effect','game',0,'2015-09-14 23:40:19',NULL),(54,'insert','for_tags','mass-effect-2','game',0,'2015-09-15 00:12:56',NULL),(60,'insert','for_tags','mass-effect-3','game',0,'2015-09-15 00:16:04',NULL),(70,'insert','for_tags','mass-effect-4','game',0,'2015-09-15 00:40:39',NULL),(71,'insert','for_tags','mass-effect-5','game',0,'2015-09-15 00:41:14',NULL),(73,'insert','for_tags','batman','movie',0,'2015-09-17 23:46:50',NULL),(76,'insert','for_tags','batman-2','movie',0,'2015-09-17 23:51:58',NULL),(77,'insert','for_tags','batman','company',0,'2015-09-22 22:45:10',NULL),(78,'insert','for_tags','360','platform',0,'2015-09-22 22:58:28',NULL),(79,'insert','for_platforms','360','platform',0,'2015-09-22 23:01:23',NULL),(80,'insert','for_platforms','ps4','platform',0,'2015-09-22 23:02:30',NULL),(81,'insert','for_platforms','one','platform',0,'2015-09-22 23:16:34',NULL),(82,'insert','for_platforms','comedy','genre',0,'2015-09-22 23:18:40',NULL),(83,'insert','for_genres','horror','genre',0,'2015-09-22 23:27:39',NULL),(85,'insert','for_tags','dig-dug','game',0,'2015-09-26 16:07:32',NULL),(86,'insert','for_tags','dig--dug','game',0,'2015-09-26 16:10:52',NULL),(87,'insert','for_tags','zig-zag','game',0,'2015-09-26 16:15:37',NULL),(88,'insert','for_tags','diablo-2','game',0,'2015-09-26 16:24:29',NULL),(89,'insert','for_tags','bam-bam','game',0,'2015-09-26 16:37:37',NULL),(90,'insert','for_tags','van-van','game',0,'2015-09-26 16:43:05',NULL),(91,'insert','for_tags','mass-effect-2','game',0,'2015-09-26 16:45:00',NULL),(92,'insert','for_tags','mass-effect-3','game',0,'2015-09-26 17:28:12',NULL),(93,'insert','for_tags','mass-effect-4','game',0,'2015-09-26 17:40:06',NULL),(94,'insert','for_tags','zig-zag-2','game',0,'2015-09-26 17:41:42',NULL),(95,'insert','for_tags','grand-theft-auto-4','game',0,'2015-09-26 17:44:56',NULL),(96,'insert','for_stickers','ace','sticker',0,'2015-10-01 23:43:18',NULL),(97,'insert','for_articles','gta-5','aside',0,'2015-11-18 12:33:33',NULL),(98,'insert','for_articles','gta-5','aside',0,'2015-11-18 13:46:22',NULL),(99,'insert','for_articles','gta-5','aside',0,'2015-11-18 13:52:48',NULL),(100,'insert','for_articles','grand-theft-auto-4','aside',0,'2015-11-20 16:49:03',NULL),(108,'insert','for_articles','grand-theft-auto-4','aside',0,'2015-11-29 17:53:37',NULL),(116,'insert','for_articles','diablo-2','aside',0,'2015-11-29 18:19:57',NULL),(117,'insert','for_articles','diablo-2','aside',0,'2015-11-29 18:28:07',NULL),(118,'insert','for_articles','gta','aside',0,'2015-11-29 19:00:50',NULL),(119,'insert','for_articles','van-van','aside',0,'2015-11-29 20:41:48',NULL),(127,'insert','for_articles','gta','aside',0,'2015-11-30 14:13:19',NULL),(128,'insert','for_tags','hbo','company',0,'2015-12-01 21:13:13',NULL),(129,'insert','for_tags','hbo2','company',0,'2015-12-01 21:23:06',NULL),(130,'insert','for_tags','hbo3','company',0,'2015-12-01 21:25:40',NULL),(131,'insert','for_tags','hbo4','company',0,'2015-12-01 21:59:16',NULL),(132,'insert','for_tags','hbo5','company',0,'2015-12-01 22:01:16',NULL),(133,'insert','for_tags','hbo6','company',0,'2015-12-01 22:11:47',NULL),(134,'update','for_tags','hbo6','company',0,'2015-12-01 23:16:12',NULL),(135,'update','for_tags','hbo6','company',0,'2015-12-01 23:17:22',NULL),(136,'update','for_tags','hbo6','company',0,'2015-12-01 23:18:55',NULL),(137,'update','for_tags','hbo6-update1','company',0,'2015-12-01 23:20:42',NULL),(138,'insert','for_tags','hbo7','company',0,'2015-12-01 23:21:33',NULL),(139,'update','for_tags','hbo7','company',0,'2015-12-01 23:22:00',NULL),(140,'update','for_tags','hbo7','company',0,'2015-12-01 23:22:19',NULL),(141,'insert','for_tags','hbo8','company',0,'2015-12-01 23:52:59',NULL),(142,'update','for_tags','hbo8','company',0,'2015-12-01 23:53:33',NULL),(143,'insert','for_tags','hbo9','company',0,'2015-12-01 23:54:12',NULL),(144,'insert','for_tags','sonic','person',0,'2015-12-02 11:41:13',NULL),(145,'update','for_tags','sonic','person',0,'2015-12-02 11:47:16',NULL),(146,'insert','for_tags','kur','person',0,'2015-12-03 09:05:10',NULL),(147,'update','for_tags','kur','person',0,'2015-12-03 09:23:58',NULL),(148,'update','for_tags','kur','person',0,'2015-12-03 10:41:03',NULL),(149,'insert','for_tags','kur2','person',0,'2015-12-03 10:50:48',NULL),(150,'insert','for_tags','kur-3','person',0,'2015-12-03 10:52:10',NULL),(151,'update','for_tags','kur-3','person',0,'2015-12-03 10:52:44',NULL),(152,'update','for_tags','kur-3','person',0,'2015-12-03 10:55:35',NULL);
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
  PRIMARY KEY (`movie_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `for_movies`
--

LOCK TABLES `for_movies` WRITE;
/*!40000 ALTER TABLE `for_movies` DISABLE KEYS */;
INSERT INTO `for_movies` VALUES (1,91,NULL,NULL),(4,94,NULL,81);
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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `for_platforms`
--

LOCK TABLES `for_platforms` WRITE;
/*!40000 ALTER TABLE `for_platforms` DISABLE KEYS */;
INSERT INTO `for_platforms` VALUES (1,'Xbox 360','360'),(2,'PlayStation 4','ps4'),(3,'Xbox One','one'),(4,'PlayStation 3','ps3');
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
  `author_id` tinyint(4) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `for_rel_authors`
--

LOCK TABLES `for_rel_authors` WRITE;
/*!40000 ALTER TABLE `for_rel_authors` DISABLE KEYS */;
INSERT INTO `for_rel_authors` VALUES (3,2),(3,1),(4,1),(4,2),(12,1),(12,2),(20,1),(20,2),(21,1),(22,1),(23,2),(31,1);
/*!40000 ALTER TABLE `for_rel_authors` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `for_rel_countries`
--

DROP TABLE IF EXISTS `for_rel_countries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `for_rel_countries` (
  `tag_id` mediumint(9) unsigned NOT NULL,
  `country_id` tinyint(4) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `for_rel_countries`
--

LOCK TABLES `for_rel_countries` WRITE;
/*!40000 ALTER TABLE `for_rel_countries` DISABLE KEYS */;
/*!40000 ALTER TABLE `for_rel_countries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `for_rel_genres`
--

DROP TABLE IF EXISTS `for_rel_genres`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `for_rel_genres` (
  `tag_id` mediumint(9) unsigned NOT NULL,
  `genre_id` tinyint(4) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `for_rel_genres`
--

LOCK TABLES `for_rel_genres` WRITE;
/*!40000 ALTER TABLE `for_rel_genres` DISABLE KEYS */;
/*!40000 ALTER TABLE `for_rel_genres` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `for_rel_imgs`
--

DROP TABLE IF EXISTS `for_rel_imgs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `for_rel_imgs` (
  `img_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `layout_id` int(11) unsigned NOT NULL,
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
  PRIMARY KEY (`img_id`),
  UNIQUE KEY `img_id_UNIQUE` (`img_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `for_rel_imgs`
--

LOCK TABLES `for_rel_imgs` WRITE;
/*!40000 ALTER TABLE `for_rel_imgs` DISABLE KEYS */;
INSERT INTO `for_rel_imgs` VALUES (1,25,'Натиснете\n                            тук, за да редактирате коментара.','Горе','alien-isolation','40.jpg',NULL,NULL,NULL,NULL,NULL,'http://www.yahoo.com','16-10'),(2,25,'Натиснете\n                            тук, за да редактирате коментара.','Дясно','alien-isolation','37.jpg',NULL,NULL,NULL,NULL,NULL,'','16-10'),(3,25,'Натиснете\n                            тук, за да редактирате коментара.','Ляво','alien-isolation','11.jpg',NULL,NULL,NULL,NULL,NULL,'','16-10'),(4,32,'Натиснете\n                            тук, за да редактирате коментара.','Горе','','',NULL,NULL,NULL,NULL,NULL,'','16-9'),(5,32,'Натиснете\n                            тук, за да редактирате коментара.','Дясно','','',NULL,NULL,NULL,NULL,NULL,'','16-9'),(6,32,'Натиснете\n                            тук, за да редактирате коментара.','Ляво','','',NULL,NULL,NULL,NULL,NULL,'','16-9');
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
  `issue_id` tinyint(4) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `for_rel_issues`
--

LOCK TABLES `for_rel_issues` WRITE;
/*!40000 ALTER TABLE `for_rel_issues` DISABLE KEYS */;
INSERT INTO `for_rel_issues` VALUES (2,2),(3,2),(4,1),(12,1),(20,1),(21,1),(22,1),(23,3);
/*!40000 ALTER TABLE `for_rel_issues` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `for_rel_platforms`
--

DROP TABLE IF EXISTS `for_rel_platforms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `for_rel_platforms` (
  `tag_id` mediumint(9) unsigned NOT NULL,
  `platform_id` tinyint(4) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `for_rel_platforms`
--

LOCK TABLES `for_rel_platforms` WRITE;
/*!40000 ALTER TABLE `for_rel_platforms` DISABLE KEYS */;
/*!40000 ALTER TABLE `for_rel_platforms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `for_rel_relative`
--

DROP TABLE IF EXISTS `for_rel_relative`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `for_rel_relative` (
  `tag_id` mediumint(9) unsigned NOT NULL,
  `related_tag_id` mediumint(9) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `for_rel_relative`
--

LOCK TABLES `for_rel_relative` WRITE;
/*!40000 ALTER TABLE `for_rel_relative` DISABLE KEYS */;
INSERT INTO `for_rel_relative` VALUES (120,47),(120,49),(120,1),(120,47),(120,49),(120,1),(121,1),(121,19),(121,21),(121,1),(121,1),(121,33),(121,35),(121,34),(121,21),(121,98),(122,1),(123,1);
/*!40000 ALTER TABLE `for_rel_relative` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `for_rel_stickers`
--

DROP TABLE IF EXISTS `for_rel_stickers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `for_rel_stickers` (
  `tag_id` mediumint(9) unsigned NOT NULL,
  `sticker_id` tinyint(4) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `for_rel_stickers`
--

LOCK TABLES `for_rel_stickers` WRITE;
/*!40000 ALTER TABLE `for_rel_stickers` DISABLE KEYS */;
/*!40000 ALTER TABLE `for_rel_stickers` ENABLE KEYS */;
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
  `prime` tinyint(1) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `for_rel_tags`
--

LOCK TABLES `for_rel_tags` WRITE;
/*!40000 ALTER TABLE `for_rel_tags` DISABLE KEYS */;
INSERT INTO `for_rel_tags` VALUES (70,1,1),(53,1,1),(70,2,1),(53,2,0),(70,3,1),(53,3,0),(110,4,1),(47,4,0),(49,4,0),(110,12,1),(19,12,0),(19,20,1),(110,20,0),(19,21,1),(110,21,0),(53,22,1),(103,23,1),(53,31,1);
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
  PRIMARY KEY (`sticker_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `for_stickers`
--

LOCK TABLES `for_stickers` WRITE;
/*!40000 ALTER TABLE `for_stickers` DISABLE KEYS */;
INSERT INTO `for_stickers` VALUES (1,'Ace','ace','lorc','originals');
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
) ENGINE=InnoDB AUTO_INCREMENT=124 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `for_tags`
--

LOCK TABLES `for_tags` WRITE;
/*!40000 ALTER TABLE `for_tags` DISABLE KEYS */;
INSERT INTO `for_tags` VALUES (1,'Диабло','Diablo','diablo',NULL,'games',NULL,'game'),(3,'Диабло','Diablo','diablo',NULL,'games',NULL,'serie'),(19,'Диабло 2','Diablo 2','diablo-2',NULL,'games',NULL,'company'),(20,'Диабло 6','Diablo 6','diablo-6',NULL,'games',NULL,'company'),(21,'Диабло 7','Diablo 7','diablo-7',NULL,'games',NULL,'company'),(22,'Диабло 8','Diablo 8','diablo-8',NULL,'games',NULL,'company'),(23,'','Diablo 9','diablo-9',NULL,'games',NULL,'company'),(24,'','Diablo 10','diablo-10',NULL,'games',NULL,'company'),(25,'','Diablo 5','diablo-5',NULL,'games',NULL,'company'),(26,'Чък Норис','','chuck-norris',NULL,'movies',NULL,'person'),(27,'Чък Норис 2','','chuck-norris-2',NULL,'movies',NULL,'person'),(28,'Чък Норис 3','','chuck-norris-3',NULL,'movies',NULL,'person'),(29,'Чък Норис 4','','chuck-norris-4',NULL,'movies',NULL,'person'),(30,'Чък Норис 5','','chuck-norris-5',NULL,'movies',NULL,'person'),(31,'Бат Бойко','','batman',NULL,'movies',NULL,'person'),(32,'Бат Бойко 2','','batman-2',NULL,'movies',NULL,'person'),(33,'','Batman 3','batman-3',NULL,'movies',NULL,'person'),(34,'','Batman 4','batman-4',NULL,'movies',NULL,'person'),(35,'','Batman 5','batman-5',NULL,'movies',NULL,'person'),(36,'','Batman 6','batman-6',NULL,'movies',NULL,'person'),(37,'','Batman 7','batman-7',NULL,'movies',NULL,'person'),(38,'','Batman 8','batman-8',NULL,'movies',NULL,'person'),(39,'','Batman 9','batman-9',NULL,'movies',NULL,'person'),(40,'','Batman 10','batman-10',NULL,'movies',NULL,'person'),(41,'','Batman 10','batman-10',NULL,'games',NULL,'company'),(43,'','Batman-11','batman-11',NULL,'games',NULL,'person'),(44,'','Batman-12','batman-12',NULL,'games',NULL,'person'),(46,'Таралежко','Sonic','sonic',NULL,'games',NULL,'character'),(47,'Таралежко','Sonic 2','sonic-2',NULL,'games',NULL,'character'),(49,'Таралежко','Sonic 3','sonic-3',NULL,'games',NULL,'character'),(52,'','From Ashes','from-ashes',NULL,'games',NULL,'dlc'),(53,'','GTA','gta',NULL,'games',NULL,'serie'),(54,'','Halo','halo',NULL,'games',NULL,'serie'),(56,'','Hodor','hodor',NULL,'movies',NULL,'character'),(57,'','Minsc','minsc',NULL,'games',NULL,'character'),(58,'','Boo','boo',NULL,'games',NULL,'character'),(59,'','Boo 2','boo-2',NULL,'games',NULL,'character'),(60,'','Boo 3','boo-3',NULL,'games',NULL,'character'),(61,'','Boo 4','boo-4',NULL,'games',NULL,'character'),(62,'','Boo 5','boo-5',NULL,'games',NULL,'character'),(63,'','Boo 6','boo-6',NULL,'games',NULL,'character'),(64,'','Boo 7','boo-7',NULL,'games',NULL,'character'),(65,'','Boo 8','boo-8',NULL,'games',NULL,'character'),(66,'','','',NULL,'',NULL,''),(67,'','Batman','batman',NULL,'games',NULL,'character'),(68,'','Batman 2','batman-2',NULL,'games',NULL,'character'),(69,'','Batman 3','batman-3',NULL,'games',NULL,'character'),(70,'','GTA 5','gta-5','2015-09-26','games',NULL,'game'),(71,'','Mass Effect','mass-effect','2015-09-17','games',NULL,'game'),(91,NULL,'Batman','batman',NULL,'',NULL,'movie'),(94,NULL,'Batman 2','batman-2',NULL,'',NULL,'movie'),(95,NULL,'Batman','batman',NULL,'games',NULL,'company'),(96,NULL,NULL,'360',NULL,'',NULL,'platform'),(98,NULL,'Dig Dug','dig-dug',NULL,'games',NULL,'game'),(100,NULL,'Zig Zag','zig-zag',NULL,'games',NULL,'game'),(101,NULL,'Diablo 2','diablo-2',NULL,'games',NULL,'game'),(102,NULL,'Bam Bam','bam-bam',NULL,'games',NULL,'game'),(103,NULL,'Van Van','van-van',NULL,'games',NULL,'game'),(104,NULL,'Mass Effect 2','mass-effect-2',NULL,'games',NULL,'game'),(105,NULL,'Mass Effect 3','mass-effect-3',NULL,'games',NULL,'game'),(106,NULL,'Mass Effect 4','mass-effect-4',NULL,'games',NULL,'game'),(107,NULL,'Zig Zag 2','zig-zag-2',NULL,'games',NULL,'game'),(110,NULL,'Grand Theft Auto 4','grand-theft-auto-4',NULL,'games',NULL,'game'),(111,'BG','HBO','hbo',NULL,'games','developer','company'),(112,NULL,'HBO2','hbo2',NULL,'movies',NULL,'company'),(113,NULL,'HBO3','hbo3',NULL,'movies',NULL,'company'),(114,NULL,'HBO4','hbo4',NULL,'games',NULL,'company'),(115,NULL,'HBO5','hbo5',NULL,'games',NULL,'company'),(116,NULL,'HBO6 Update1','hbo6-update1',NULL,'games',NULL,'company'),(117,NULL,'HBO7 Update1','hbo7',NULL,'movies','publisher','company'),(118,NULL,'HBO8','hbo8',NULL,'games',NULL,'company'),(119,NULL,'HBO9','hbo9',NULL,'games',NULL,'company'),(120,'Sonic','Sonic','sonic',NULL,'games',NULL,'person'),(121,NULL,'Kur','kur',NULL,'games',NULL,'person'),(122,NULL,'Kur2','kur2',NULL,'games',NULL,'person'),(123,NULL,'Kur 3','kur-3',NULL,'games',NULL,'person');
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

--
-- Dumping routines for database 'forplay'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-12-05 18:29:16
