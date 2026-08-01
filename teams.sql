-- MySQL dump 10.13  Distrib 5.7.39, for Linux (x86_64)
--
-- Host: localhost    Database: fbpicks
-- ------------------------------------------------------
-- Server version	5.7.39-0ubuntu0.18.04.2

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
-- Table structure for table `teams`
--

DROP TABLE IF EXISTS `teams`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `teams` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abbrev` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gif` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `conference` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `division` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `teams`
--

LOCK TABLES `teams` WRITE;
/*!40000 ALTER TABLE `teams` DISABLE KEYS */;
INSERT INTO `teams` VALUES (1,'Ravens','BAL','bal.gif','Baltimore','AFC','North','2020-09-13 22:19:10','2020-09-13 22:19:10'),(2,'Bengals','CIN','cin.gif','Cincinnati','AFC','North','2020-09-13 22:19:10','2020-09-13 22:19:10'),(3,'Browns','CLE','cle.gif','Cleveland','AFC','North','2020-09-13 22:19:10','2020-09-13 22:19:10'),(4,'Steelers','PIT','pit.gif','Pittsburgh','AFC','North','2020-09-13 22:19:10','2020-09-13 22:19:10'),(5,'Texans','HOU','hou.gif','Houston','AFC','South','2020-09-13 22:19:10','2020-09-13 22:19:10'),(6,'Colts','IND','ind.gif','Indianapolis','AFC','South','2020-09-13 22:19:10','2020-09-13 22:19:10'),(7,'Jaguars','JAX','jax.gif','Jacksonville','AFC','South','2020-09-13 22:19:10','2020-09-13 22:19:10'),(8,'Titans','TEN','ten.gif','Tennessee','AFC','South','2020-09-13 22:19:10','2020-09-13 22:19:10'),(9,'Bills','BUF','buf.gif','Buffalo','AFC','East','2020-09-13 22:19:10','2020-09-13 22:19:10'),(10,'Dolphins','MIA','mia.gif','Miami','AFC','East','2020-09-13 22:19:10','2020-09-13 22:19:10'),(11,'Patriots','NE','ne.gif','New England','AFC','East','2020-09-13 22:19:10','2020-09-13 22:19:10'),(12,'Jets','NYJ','nyj.gif','New York','AFC','East','2020-09-13 22:19:10','2020-09-13 22:19:10'),(13,'Broncos','DEN','den.gif','Denver','AFC','West','2020-09-13 22:19:10','2020-09-13 22:19:10'),(14,'Chiefs','KC','kc.gif','Kansas City','AFC','West','2020-09-13 22:19:10','2020-09-13 22:19:10'),(15,'Raiders','LV','oak.gif','Las Vegas','AFC','West','2020-09-13 22:19:10','2020-09-13 22:19:10'),(16,'Chargers','LAC','sd.gif','Las Angeles','AFC','West','2020-09-13 22:19:10','2020-09-13 22:19:10'),(17,'Bears','CHI','chi.gif','Chicago','NFC','North','2020-09-13 22:19:10','2020-09-13 22:19:10'),(18,'Lions','DET','det.gif','Detroit','NFC','North','2020-09-13 22:19:10','2020-09-13 22:19:10'),(19,'Packers','GB','gb.gif','Green Bay','NFC','North','2020-09-13 22:19:10','2020-09-13 22:19:10'),(20,'Vikings','MIN','min.gif','Minnesota','NFC','North','2020-09-13 22:19:10','2020-09-13 22:19:10'),(21,'Falcons','ATL','atl.gif','Atlanta','NFC','South','2020-09-13 22:19:10','2020-09-13 22:19:10'),(22,'Panthers','CAR','car.gif','Carolina','NFC','South','2020-09-13 22:19:10','2020-09-13 22:19:10'),(23,'Saints','NO','no.gif','New Orleans','NFC','South','2020-09-13 22:19:10','2020-09-13 22:19:10'),(24,'Buccaneers','TB','tb.gif','Tampa Bay','NFC','South','2020-09-13 22:19:10','2020-09-13 22:19:10'),(25,'Cowboys','DAL','dal.gif','Dallas','NFC','East','2020-09-13 22:19:10','2020-09-13 22:19:10'),(26,'Giants','NYG','nyg.gif','New York','NFC','East','2020-09-13 22:19:10','2020-09-13 22:19:10'),(27,'Eagles','PHI','phi.gif','Philadelphia','NFC','East','2020-09-13 22:19:10','2020-09-13 22:19:10'),(28,'Commanders','WAS','was.gif','Washington','NFC','East','2020-09-13 22:19:10','2020-09-13 22:19:10'),(29,'Cardinals','ARI','arz.gif','Arizona','NFC','West','2020-09-13 22:19:10','2020-09-13 22:19:10'),(30,'Rams','LAR','stl.gif','Los Angeles','NFC','West','2020-09-13 22:19:10','2020-09-13 22:19:10'),(31,'49ers','SF','sf.gif','San Francisco','NFC','West','2020-09-13 22:19:10','2020-09-13 22:19:10'),(32,'Seahawks','SEA','sea.gif','Seattle','NFC','North','2020-09-13 22:19:10','2020-09-13 22:19:10');
/*!40000 ALTER TABLE `teams` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-09-08  2:41:55
