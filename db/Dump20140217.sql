CREATE DATABASE  IF NOT EXISTS `cyberjawara` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `cyberjawara`;
-- MySQL dump 10.13  Distrib 5.6.13, for Win32 (x86)
--
-- Host: 127.0.0.1    Database: cyberjawara
-- ------------------------------------------------------
-- Server version	5.6.12-log

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
-- Table structure for table `answers`
--

DROP TABLE IF EXISTS `answers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `answers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lomba_id` int(11) NOT NULL,
  `team_id` int(11) NOT NULL,
  `subject` varchar(100) NOT NULL,
  `message` text,
  `attachment` varchar(255) NOT NULL,
  `client_name` varchar(255) NOT NULL,
  `raw_name` varchar(100) NOT NULL,
  `timestamp` datetime NOT NULL,
  `sender` enum('client','admin') NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_lomba_id_idx` (`lomba_id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `answers`
--

LOCK TABLES `answers` WRITE;
/*!40000 ALTER TABLE `answers` DISABLE KEYS */;
INSERT INTO `answers` VALUES (2,1,1,'10','akung','','','','2014-02-17 00:54:19','client'),(3,1,1,'1','soekarno','','','','2014-02-17 01:04:24','client'),(12,3,2,'Clearing Tracks','dsfsaf','/var/www/uploads/026d4768ab43b5b3402d8088ecbfbfd4.docx','Tambahan lagi.docx','026d4768ab43b5b3402d8088ecbfbfd4','2014-02-17 09:50:41','client'),(13,3,2,'Scanning','dsfsdf','/var/www/uploads/94468330bc7a2c0ac24cda7590eb2e65.docx','Perubahan dan tambahan backend pengguna daerah.docx','94468330bc7a2c0ac24cda7590eb2e65','2014-02-17 09:51:08','client'),(19,4,2,'8','dsfdf','','','','2014-02-17 10:38:33','client'),(21,1,2,'Kecoak Forensic','Psan','','','','2014-02-17 11:00:26','admin'),(22,2,2,'kecoak lagi pentest','dfd','','','','2014-02-17 11:28:19','admin'),(23,4,2,'apa ini','apah ini?','','','','2014-02-17 11:28:57','admin'),(26,1,1,'cx','dfs','D:/www/uploads/2e3d705d988d1f201457ec6b02143ef2.pdf','Instalasi Monitoring Lomba.pdf','2e3d705d988d1f201457ec6b02143ef2','2014-02-17 12:09:20','admin'),(27,2,1,'dfdf','dfd','D:/www/uploads/21c91fea67055190b73befc629067986.pdf','Instalasi Monitoring Lomba.pdf','21c91fea67055190b73befc629067986','2014-02-17 12:10:07','admin'),(28,2,1,'ddddddddddddd','gggggggggggg','D:/www/uploads/8f8b0085cda2cba1560f26091b01b10f.doc','Monitoring Lomba.doc','8f8b0085cda2cba1560f26091b01b10f','2014-02-17 12:15:12','admin');
/*!40000 ALTER TABLE `answers` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `deletezero` AFTER INSERT ON `answers` FOR EACH ROW
BEGIN
	IF NEW.lomba_id = 0 AND NEW.team_id = 0 AND NEW.subject = 0 AND NEW.message = 0 then
		DELETE FROM answers
		WHERE id = NEW.id;
	end if;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `article`
--

DROP TABLE IF EXISTS `article`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `article` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `content` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug_UNIQUE` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `article`
--

LOCK TABLES `article` WRITE;
/*!40000 ALTER TABLE `article` DISABLE KEYS */;
INSERT INTO `article` VALUES (1,'aturan','aturan','');
/*!40000 ALTER TABLE `article` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `configuration`
--

DROP TABLE IF EXISTS `configuration`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `configuration` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `key` varchar(100) NOT NULL,
  `value` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `key_UNIQUE` (`key`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `configuration`
--

LOCK TABLES `configuration` WRITE;
/*!40000 ALTER TABLE `configuration` DISABLE KEYS */;
INSERT INTO `configuration` VALUES (1,'score_up','100'),(2,'score_down','-100'),(3,'cron_execute','php /var/www/monitor-lomba/index.php monitor cronCekServer');
/*!40000 ALTER TABLE `configuration` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `credential`
--

DROP TABLE IF EXISTS `credential`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `credential` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `password` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `level` enum('admin','juri') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `credential`
--

LOCK TABLES `credential` WRITE;
/*!40000 ALTER TABLE `credential` DISABLE KEYS */;
INSERT INTO `credential` VALUES (5,'Fathur Rohman','756e42f97923073bfd76e4bc62d152a9783f68f8','fathur','admin'),(6,'akung','5322148725aeb14ffde161698a643320a252371a','akung','juri'),(7,'Administrator','d033e22ae348aeb5660fc2140aec35850c4da997','admin','admin');
/*!40000 ALTER TABLE `credential` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hosts`
--

DROP TABLE IF EXISTS `hosts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hosts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `team_id` int(11) NOT NULL,
  `hostname` varchar(100) NOT NULL,
  `ipaddr` char(15) NOT NULL,
  `totalscore` int(11) DEFAULT NULL,
  `community` varchar(100) DEFAULT NULL COMMENT 'Community SNMP',
  PRIMARY KEY (`id`),
  UNIQUE KEY `ipaddr_UNIQUE` (`ipaddr`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hosts`
--

LOCK TABLES `hosts` WRITE;
/*!40000 ALTER TABLE `hosts` DISABLE KEYS */;
INSERT INTO `hosts` VALUES (43,1,'Localhost','127.0.0.1',NULL,'public');
/*!40000 ALTER TABLE `hosts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hosts_port`
--

DROP TABLE IF EXISTS `hosts_port`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hosts_port` (
  `hosts_id` int(11) NOT NULL,
  `port_id` int(11) NOT NULL,
  `port_number` int(11) NOT NULL,
  `status` enum('on','off') NOT NULL,
  PRIMARY KEY (`hosts_id`,`port_id`),
  KEY `fk_hosts_has_port_port1` (`port_id`),
  KEY `fk_hosts_has_port_hosts` (`hosts_id`),
  CONSTRAINT `fk_hosts_has_port_hosts` FOREIGN KEY (`hosts_id`) REFERENCES `hosts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_hosts_has_port_port1` FOREIGN KEY (`port_id`) REFERENCES `port` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hosts_port`
--

LOCK TABLES `hosts_port` WRITE;
/*!40000 ALTER TABLE `hosts_port` DISABLE KEYS */;
INSERT INTO `hosts_port` VALUES (43,1,80,'off'),(43,2,3306,'off'),(43,5,21,'off');
/*!40000 ALTER TABLE `hosts_port` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lomba`
--

DROP TABLE IF EXISTS `lomba`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lomba` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(45) NOT NULL,
  `start` datetime NOT NULL,
  `end` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `lomba_nama_UNIQUE` (`nama`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lomba`
--

LOCK TABLES `lomba` WRITE;
/*!40000 ALTER TABLE `lomba` DISABLE KEYS */;
INSERT INTO `lomba` VALUES (1,'forensic','2014-02-25 09:00:00','2014-02-25 13:00:00'),(2,'pentest','2014-02-25 14:00:00','2014-02-25 18:00:00'),(3,'CND','2014-02-26 08:00:00','2014-02-26 12:00:00'),(4,'ctf','2014-02-06 13:00:00','2014-02-26 17:00:00');
/*!40000 ALTER TABLE `lomba` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `port`
--

DROP TABLE IF EXISTS `port`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `port` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `port_default` int(11) NOT NULL,
  `status` enum('on','off') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `port`
--

LOCK TABLES `port` WRITE;
/*!40000 ALTER TABLE `port` DISABLE KEYS */;
INSERT INTO `port` VALUES (1,'apache2',80,'on'),(2,'mysqld',3306,'on'),(5,'vsftpd',21,'on'),(6,'sshd',22,'on');
/*!40000 ALTER TABLE `port` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `score`
--

DROP TABLE IF EXISTS `score`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `score` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `team_id` int(11) NOT NULL,
  `timestamp` datetime NOT NULL,
  `score` int(11) NOT NULL,
  `messages` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=543 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `score`
--

LOCK TABLES `score` WRITE;
/*!40000 ALTER TABLE `score` DISABLE KEYS */;
INSERT INTO `score` VALUES (539,2,'2014-02-17 09:27:40',12,'Jawaban soal 2 benar'),(540,2,'2014-02-17 10:51:21',12,'Jawaban soal 3 benar'),(541,2,'2014-02-17 10:38:33',12,'Jawaban soal 3 benar'),(542,2,'2014-02-17 11:30:05',98,'Bonus THR');
/*!40000 ALTER TABLE `score` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `soal`
--

DROP TABLE IF EXISTS `soal`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `soal` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lomba_id` int(11) NOT NULL,
  `soal` varchar(100) NOT NULL,
  `jawaban` varchar(255) NOT NULL,
  `order` int(11) NOT NULL,
  `nilai` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_lomba_id_idx` (`lomba_id`),
  CONSTRAINT `fk_lomba_id` FOREIGN KEY (`lomba_id`) REFERENCES `lomba` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `soal`
--

LOCK TABLES `soal` WRITE;
/*!40000 ALTER TABLE `soal` DISABLE KEYS */;
INSERT INTO `soal` VALUES (1,1,'peresden pertama ri','soekarno',1,123),(8,4,'dfsf','dsfdf',3,12),(9,2,'apakah itu?','lima',1,100),(10,1,'namaku siapa','akung',2,100),(11,3,'Reconnaissance','',1,0),(12,3,'Scanning','',2,0),(13,3,'Gaining Access','',3,0),(14,3,'Maintaining Access','',4,0),(15,3,'Clearing Tracks','',5,0);
/*!40000 ALTER TABLE `soal` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `team`
--

DROP TABLE IF EXISTS `team`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `team` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `team_name` varchar(100) NOT NULL,
  `team_username` varchar(100) NOT NULL,
  `team_password` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `team_name_UNIQUE` (`team_name`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `team`
--

LOCK TABLES `team` WRITE;
/*!40000 ALTER TABLE `team` DISABLE KEYS */;
INSERT INTO `team` VALUES (1,'IDSIRTII','idsirtii','1d3d3fe750b65ce03215c3479ad5279c6f85dacc'),(2,'Kecoak','kecoak','6f7fa94a4689b56f40f0839531d17d953dd4473c');
/*!40000 ALTER TABLE `team` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-02-17 19:23:40
