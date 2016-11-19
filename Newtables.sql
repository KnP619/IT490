-- MySQL dump 10.13  Distrib 5.7.16, for Linux (x86_64)
--
-- Host: localhost    Database: Versions
-- ------------------------------------------------------
-- Server version	5.7.16-0ubuntu0.16.04.1

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
-- Current Database: `Versions`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `Versions` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `Versions`;

--
-- Table structure for table `AllTasks`
--

DROP TABLE IF EXISTS `AllTasks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `AllTasks` (
  `Taskname` varchar(200) NOT NULL,
  `tarname` varchar(200) NOT NULL,
  `CurrentVersion` int(100) NOT NULL,
  `timestamp` int(100) NOT NULL,
  PRIMARY KEY (`Taskname`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `AllTasks`
--

LOCK TABLES `AllTasks` WRITE;
/*!40000 ALTER TABLE `AllTasks` DISABLE KEYS */;
INSERT INTO `AllTasks` VALUES ('LeagueTask','LeagueTask3.tar.gz',3,1479513247),('LoginTask','LoginTask4.tar.gz',4,1479513012),('RegTask','RegTask3.tar.gz',3,1479513174),('RPCTask','RPCTask20.tar.gz',20,1479525756),('SubsTask','SubsTask3.tar.gz',3,1479513105);
/*!40000 ALTER TABLE `AllTasks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Backend`
--

DROP TABLE IF EXISTS `Backend`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Backend` (
  `Filename` varchar(200) NOT NULL,
  `CurrentVersion` int(100) NOT NULL,
  `timestamp` int(100) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Backend`
--

LOCK TABLES `Backend` WRITE;
/*!40000 ALTER TABLE `Backend` DISABLE KEYS */;
INSERT INTO `Backend` VALUES ('RPC_GETDATA_SCORERS_BE.php',1,1479395936,1),('LOGIN_RPCServer_BE.php',1,1479395936,2),('submit_res_BE.php',1,1479395936,3),('REGISTRATION_RPCServer_BE.php',1,1479395936,4),('subscription_BE.php',1,1479395936,5),('RPC_GETDATA_FIXTURES_BE.php',1,1479395936,6),('RPC_GETDATA_PRIMIERE_BE.php',1,1479395936,7),('RPC_GETDATA_SCORERS_BE.php',2,1479399094,22),('LOGIN_RPCServer_BE.php',2,1479399094,23),('submit_res_BE.php',2,1479399094,24),('REGISTRATION_RPCServer_BE.php',2,1479399094,25),('subscription_BE.php',2,1479399094,26),('RPC_GETDATA_FIXTURES_BE.php',2,1479399094,27),('RPC_GETDATA_PRIMIERE_BE.php',2,1479399094,28),('RPC_GETDATA_SCORERS_BE.php',3,1479400196,29),('LOGIN_RPCServer_BE.php',3,1479400196,30),('submit_res_BE.php',3,1479400196,31),('REGISTRATION_RPCServer_BE.php',3,1479400196,32),('subscription_BE.php',3,1479400196,33),('RPC_GETDATA_FIXTURES_BE.php',3,1479400196,34),('RPC_GETDATA_PRIMIERE_BE.php',3,1479400196,35),('RPC_GETDATA_SCORERS_BE.php',4,1479402668,36),('LOGIN_RPCServer_BE.php',4,1479402668,37),('submit_res_BE.php',4,1479402668,38),('REGISTRATION_RPCServer_BE.php',4,1479402668,39),('subscription_BE.php',4,1479402668,40),('RPC_GETDATA_FIXTURES_BE.php',4,1479402668,41),('RPC_GETDATA_PRIMIERE_BE.php',4,1479402668,42),('RPC_GETDATA_SCORERS_BE.php',5,1479404002,43),('LOGIN_RPCServer_BE.php',5,1479404002,44),('submit_res_BE.php',5,1479404002,45),('REGISTRATION_RPCServer_BE.php',5,1479404002,46),('subscription_BE.php',5,1479404002,47),('RPC_GETDATA_FIXTURES_BE.php',5,1479404002,48),('RPC_GETDATA_PRIMIERE_BE.php',5,1479404002,49);
/*!40000 ALTER TABLE `Backend` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `InstallHistory`
--

DROP TABLE IF EXISTS `InstallHistory`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `InstallHistory` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `User` varchar(200) NOT NULL,
  `TaskInstall` varchar(200) NOT NULL,
  `TaskVersion` int(100) NOT NULL,
  `DateTime` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `InstallHistory`
--

LOCK TABLES `InstallHistory` WRITE;
/*!40000 ALTER TABLE `InstallHistory` DISABLE KEYS */;
INSERT INTO `InstallHistory` VALUES (1,'kp','RPCTask',11,'2016-11-18 18:22:43'),(2,'kp','LoginTask',3,'2016-11-18 18:50:12'),(3,'kp','SubsTask',2,'2016-11-18 18:51:45'),(4,'kp','RegTask',2,'2016-11-18 18:52:54'),(5,'kp','LeagueTask',2,'2016-11-18 18:54:07'),(6,'kp','RPCTask',12,'2016-11-18 18:55:17'),(7,'kp','RPCTask',13,'2016-11-18 19:09:57'),(8,'kp','RPCTask',14,'2016-11-18 20:58:37'),(9,'kp','RPCTask',15,'2016-11-18 21:02:32'),(10,'kp','RPCTask',16,'2016-11-18 21:05:57'),(11,'kp','RPCTask',20,'2016-11-18 22:25:04'),(12,'kp','SubsTask',3,'2016-11-18 22:29:56'),(13,'kp','LoginTask',4,'2016-11-18 22:30:11'),(14,'kp','RegTask',3,'2016-11-18 22:30:21'),(15,'kp','LeagueTask',3,'2016-11-18 22:30:30');
/*!40000 ALTER TABLE `InstallHistory` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `LeagueTask`
--

DROP TABLE IF EXISTS `LeagueTask`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `LeagueTask` (
  `Filename` varchar(200) NOT NULL,
  `CurrentVersion` int(100) NOT NULL,
  `timestamp` int(100) NOT NULL,
  `id` int(100) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `LeagueTask`
--

LOCK TABLES `LeagueTask` WRITE;
/*!40000 ALTER TABLE `LeagueTask` DISABLE KEYS */;
INSERT INTO `LeagueTask` VALUES ('submit_res_BE.php',1,1479328797,1),('submit_res_BE.php',2,1479509071,2),('submit_res_BE.php',3,1479513247,3);
/*!40000 ALTER TABLE `LeagueTask` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `LoginTask`
--

DROP TABLE IF EXISTS `LoginTask`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `LoginTask` (
  `Filename` varchar(200) NOT NULL,
  `CurrentVersion` int(100) NOT NULL,
  `timestamp` int(100) NOT NULL,
  `id` int(100) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `LoginTask`
--

LOCK TABLES `LoginTask` WRITE;
/*!40000 ALTER TABLE `LoginTask` DISABLE KEYS */;
INSERT INTO `LoginTask` VALUES ('LOGIN_RPCServer_BE.php',1,1479328797,1),('LOGIN_RPCServer_BE.php',2,1479424222,2),('LOGIN_RPCServer_BE.php',3,1479509071,3),('LOGIN_RPCServer_BE.php',4,1479513012,4);
/*!40000 ALTER TABLE `LoginTask` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `RPCTask`
--

DROP TABLE IF EXISTS `RPCTask`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `RPCTask` (
  `Filename` varchar(200) NOT NULL,
  `CurrentVersion` int(100) NOT NULL,
  `timestamp` int(100) NOT NULL,
  `id` int(100) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=64 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `RPCTask`
--

LOCK TABLES `RPCTask` WRITE;
/*!40000 ALTER TABLE `RPCTask` DISABLE KEYS */;
INSERT INTO `RPCTask` VALUES ('RPC_GETDATA_SCORERS_BE.php',1,1479395936,1),('RPC_GETDATA_FIXTURES_BE.php',1,1479395936,2),('RPC_GETDATA_PRIMIERE_BE.php',1,1479395936,3),('RPC_GETDATA_SCORERS_BE.php',2,1479425936,4),('RPC_GETDATA_FIXTURES_BE.php',2,1479425936,5),('RPC_GETDATA_PRIMIERE_BE.php',2,1479425936,6),('RPC_GETDATA_SCORERS_BE.php',3,1479426999,7),('RPC_GETDATA_FIXTURES_BE.php',3,1479426999,8),('RPC_GETDATA_PRIMIERE_BE.php',3,1479426999,9),('RPC_GETDATA_SCORERS_BE.php',4,1479502745,10),('RPC_GETDATA_FIXTURES_BE.php',4,1479502745,11),('RPC_GETDATA_PRIMIERE_BE.php',4,1479502745,12),('RPC_GETDATA_SCORERS_BE.php',5,1479506120,13),('RPC_GETDATA_FIXTURES_BE.php',5,1479506120,14),('RPC_GETDATA_PRIMIERE_BE.php',5,1479506120,15),('RPC_GETDATA_SCORERS_BE.php',6,1479507321,16),('RPC_GETDATA_FIXTURES_BE.php',6,1479507321,17),('RPC_GETDATA_PRIMIERE_BE.php',6,1479507321,18),('RPC_GETDATA_SCORERS_BE.php',7,1479508405,19),('RPC_GETDATA_FIXTURES_BE.php',7,1479508405,20),('RPC_GETDATA_PRIMIERE_BE.php',7,1479508405,21),('RPC_GETDATA_PRIMIERE_BE.php',7,1479508405,22),('RPC_GETDATA_SCORERS_BE.php',8,1479508775,23),('RPC_GETDATA_FIXTURES_BE.php',8,1479508775,24),('RPC_GETDATA_PRIMIERE_BE.php',8,1479508775,25),('RPC_GETDATA_PRIMIERE_BE.php',8,1479508775,26),('RPC_GETDATA_SCORERS_BE.php',9,1479508939,27),('RPC_GETDATA_FIXTURES_BE.php',9,1479508939,28),('RPC_GETDATA_PRIMIERE_BE.php',9,1479508939,29),('RPC_GETDATA_PRIMIERE_BE.php',9,1479508939,30),('RPC_GETDATA_SCORERS_BE.php',10,1479509071,31),('RPC_GETDATA_FIXTURES_BE.php',10,1479509071,32),('RPC_GETDATA_PRIMIERE_BE.php',10,1479509071,33),('RPC_GETDATA_SCORERS_BE.php',11,1479511279,34),('RPC_GETDATA_FIXTURES_BE.php',11,1479511279,35),('RPC_GETDATA_PRIMIERE_BE.php',11,1479511279,36),('RPC_GETDATA_SCORERS_BE.php',12,1479511363,37),('RPC_GETDATA_FIXTURES_BE.php',12,1479511363,38),('RPC_GETDATA_PRIMIERE_BE.php',12,1479511363,39),('RPC_GETDATA_SCORERS_BE.php',13,1479514172,40),('RPC_GETDATA_FIXTURES_BE.php',13,1479514172,41),('RPC_GETDATA_PRIMIERE_BE.php',13,1479514172,42),('RPC_GETDATA_SCORERS_BE.php',14,1479514197,43),('RPC_GETDATA_FIXTURES_BE.php',14,1479514197,44),('RPC_GETDATA_PRIMIERE_BE.php',14,1479514197,45),('RPC_GETDATA_SCORERS_BE.php',15,1479520717,46),('RPC_GETDATA_FIXTURES_BE.php',15,1479520717,47),('RPC_GETDATA_PRIMIERE_BE.php',15,1479520717,48),('RPC_GETDATA_SCORERS_BE.php',16,1479520952,49),('RPC_GETDATA_FIXTURES_BE.php',16,1479520952,50),('RPC_GETDATA_PRIMIERE_BE.php',16,1479520952,51),('RPC_GETDATA_SCORERS_BE.php',17,1479521157,52),('RPC_GETDATA_FIXTURES_BE.php',17,1479521157,53),('RPC_GETDATA_PRIMIERE_BE.php',17,1479521157,54),('RPC_GETDATA_SCORERS_BE.php',18,1479523457,55),('RPC_GETDATA_FIXTURES_BE.php',18,1479523457,56),('RPC_GETDATA_PRIMIERE_BE.php',18,1479523457,57),('RPC_GETDATA_SCORERS_BE.php',19,1479523518,58),('RPC_GETDATA_FIXTURES_BE.php',19,1479523518,59),('RPC_GETDATA_PRIMIERE_BE.php',19,1479523518,60),('RPC_GETDATA_SCORERS_BE.php',20,1479525756,61),('RPC_GETDATA_FIXTURES_BE.php',20,1479525756,62),('RPC_GETDATA_PRIMIERE_BE.php',20,1479525756,63);
/*!40000 ALTER TABLE `RPCTask` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `RegTask`
--

DROP TABLE IF EXISTS `RegTask`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `RegTask` (
  `Filename` varchar(200) NOT NULL,
  `CurrentVersion` int(100) NOT NULL,
  `timestamp` int(100) NOT NULL,
  `id` int(100) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `RegTask`
--

LOCK TABLES `RegTask` WRITE;
/*!40000 ALTER TABLE `RegTask` DISABLE KEYS */;
INSERT INTO `RegTask` VALUES ('REGISTRATION_RPCServer_BE.php',1,1479328797,1),('REGISTRATION_RPCServer_BE.php',2,1479509071,2),('REGISTRATION_RPCServer_BE.php',3,1479513174,3);
/*!40000 ALTER TABLE `RegTask` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `SubsTask`
--

DROP TABLE IF EXISTS `SubsTask`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `SubsTask` (
  `Filename` varchar(200) NOT NULL,
  `CurrentVersion` int(100) NOT NULL,
  `timestamp` int(100) NOT NULL,
  `id` int(100) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `SubsTask`
--

LOCK TABLES `SubsTask` WRITE;
/*!40000 ALTER TABLE `SubsTask` DISABLE KEYS */;
INSERT INTO `SubsTask` VALUES ('subscription_BE.php',1,1479328797,1),('subscription_BE.php',2,1479509071,2),('subscription_BE.php',3,1479513105,3);
/*!40000 ALTER TABLE `SubsTask` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-11-18 22:57:16
