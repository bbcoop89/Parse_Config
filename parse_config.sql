-- MySQL dump 10.13  Distrib 5.5.49, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: parse_config
-- ------------------------------------------------------
-- Server version	5.5.49-0ubuntu0.14.04.1-log

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

CREATE DATABASE IF NOT EXISTS parse_config;

USE parse_config;

--
-- Table structure for table `config`
--

DROP TABLE IF EXISTS `config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `config` (
  `config_id` int(11) NOT NULL AUTO_INCREMENT,
  `config_key` varchar(45) NOT NULL,
  `config_value` varchar(255) DEFAULT NULL,
  `config_file_id` int(11) NOT NULL,
  `config_type_id` int(11) NOT NULL,
  PRIMARY KEY (`config_id`),
  UNIQUE KEY `config_id_UNIQUE` (`config_id`),
  KEY `FK-config.config_file_id-config_file.config_file_id-1_idx` (`config_file_id`),
  KEY `fk_config_1_idx` (`config_type_id`),
  KEY `fk_config_2_idx` (`config_type_id`),
  CONSTRAINT `FK-config.config_type_id-config_type.config_type_id-1` FOREIGN KEY (`config_type_id`) REFERENCES `config_type` (`config_type_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK-config.config_file_id-config_file.config_file_id-1` FOREIGN KEY (`config_file_id`) REFERENCES `config_file` (`config_file_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `config`
--

LOCK TABLES `config` WRITE;
/*!40000 ALTER TABLE `config` DISABLE KEYS */;
/*!40000 ALTER TABLE `config` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `config_file`
--

DROP TABLE IF EXISTS `config_file`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `config_file` (
  `config_file_id` int(11) NOT NULL AUTO_INCREMENT,
  `config_file_path` varchar(100) NOT NULL,
  PRIMARY KEY (`config_file_id`),
  UNIQUE KEY `config_file_id_UNIQUE` (`config_file_id`)
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `config_file`
--

LOCK TABLES `config_file` WRITE;
/*!40000 ALTER TABLE `config_file` DISABLE KEYS */;
/*!40000 ALTER TABLE `config_file` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `config_type`
--

DROP TABLE IF EXISTS `config_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `config_type` (
  `config_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `config_type_name` varchar(45) NOT NULL,
  PRIMARY KEY (`config_type_id`),
  UNIQUE KEY `config_type_id_UNIQUE` (`config_type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `config_type`
--

LOCK TABLES `config_type` WRITE;
/*!40000 ALTER TABLE `config_type` DISABLE KEYS */;
INSERT INTO `config_type` VALUES (1,'boolean'),(2,'double'),(3,'integer'),(4,'string');
/*!40000 ALTER TABLE `config_type` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-07-04 20:51:49
