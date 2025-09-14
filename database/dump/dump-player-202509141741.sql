-- MySQL dump 10.13  Distrib 8.0.19, for Win64 (x86_64)
--
-- Host: localhost    Database: player
-- ------------------------------------------------------
-- Server version	5.6.51

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `player`
--

DROP TABLE IF EXISTS `player`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `player` (
  `account_id` int(11) DEFAULT NULL,
  `job` int(11) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `level` varchar(100) DEFAULT NULL,
  `exp` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `player`
--

LOCK TABLES `player` WRITE;
/*!40000 ALTER TABLE `player` DISABLE KEYS */;
INSERT INTO `player` VALUES (1,0,'Yander','92','5210'),(2,4,'Kael','38','5210'),(3,1,'Lyra','70','8231'),(4,7,'Doran','12','390'),(5,0,'Selene','99','9997'),(6,2,'Thorne','54','7890'),(7,6,'Nyla','28','4103'),(8,3,'Jarek','85','9201'),(9,1,'Mira','47','6123'),(10,5,'Orin','31','2731'),(11,4,'Vera','19','1420'),(12,0,'Ezren','63','8507'),(13,2,'Luna','90','9971'),(14,6,'Draven','44','4500'),(15,1,'Myra','76','8412'),(16,3,'Kaia','35','3620'),(17,7,'Talon','58','7392'),(18,0,'Zara','22','1980'),(19,5,'Riven','66','8023'),(20,2,'Sylas','11','321'),(21,4,'Nova','29','5781'),(22,0,'[ADM]Mood','98','9998');
/*!40000 ALTER TABLE `player` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `player_index`
--

DROP TABLE IF EXISTS `player_index`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `player_index` (
  `id` int(11) DEFAULT NULL,
  `empire` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `player_index`
--

LOCK TABLES `player_index` WRITE;
/*!40000 ALTER TABLE `player_index` DISABLE KEYS */;
INSERT INTO `player_index` VALUES (1,1),(2,1),(3,2),(4,3),(5,1),(6,2),(7,3),(8,1),(9,2),(10,3),(11,1),(12,2),(13,3),(14,1),(15,2),(16,3),(17,1),(18,2),(19,3),(20,1),(21,2),(22,1);
/*!40000 ALTER TABLE `player_index` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'player'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-09-14 17:41:40
