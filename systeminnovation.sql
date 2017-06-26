-- MySQL dump 10.13  Distrib 5.7.17, for Linux (x86_64)
--
-- Host: localhost    Database: system_innovation
-- ------------------------------------------------------
-- Server version	5.7.17-0ubuntu0.16.04.1

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
-- Table structure for table `markers`
--

DROP TABLE IF EXISTS `markers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `markers` (
  `si_id` int(11) NOT NULL AUTO_INCREMENT,
  `si_m_id` int(11) DEFAULT NULL,
  `si_lat` double DEFAULT NULL,
  `si_lon` double DEFAULT NULL,
  PRIMARY KEY (`si_id`),
  KEY `si_m_id` (`si_m_id`),
  CONSTRAINT `markers_ibfk_1` FOREIGN KEY (`si_m_id`) REFERENCES `mechanics` (`si_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `markers`
--

LOCK TABLES `markers` WRITE;
/*!40000 ALTER TABLE `markers` DISABLE KEYS */;
INSERT INTO `markers` VALUES (1,1,19.8430842,-98.976166),(2,2,19.8431372,-98.9775118),(3,10,19.8426931,-98.9775829),(4,11,19.665678347,-98.43213456),(7,14,19.6991426,-98.9799419),(13,22,19.7025718,-98.9804059);
/*!40000 ALTER TABLE `markers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mechanics`
--

DROP TABLE IF EXISTS `mechanics`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mechanics` (
  `si_id` int(11) NOT NULL AUTO_INCREMENT,
  `si_m_name` varchar(50) NOT NULL,
  `si_m_lastname` varchar(50) NOT NULL,
  `si_phone` varchar(15) NOT NULL,
  `image` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`si_id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mechanics`
--

LOCK TABLES `mechanics` WRITE;
/*!40000 ALTER TABLE `mechanics` DISABLE KEYS */;
INSERT INTO `mechanics` VALUES (1,'Pancho','Perez Jolote','4455667798','playbutton.png'),(2,'Alan','Legaria','2200994403','fuente.png'),(10,'Miguel','Dominguez','5566432789','iconsong.png'),(11,'El nuevo','nuevo','3254434565','kaido2.png'),(14,'Jose Luis','Garcia Jimenez','4455678890','back.png'),(22,'Pedro','Fernandez','5566789044','log.jpg');
/*!40000 ALTER TABLE `mechanics` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reports`
--

DROP TABLE IF EXISTS `reports`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reports` (
  `si_id` int(11) NOT NULL AUTO_INCREMENT,
  `si_m_id` int(11) NOT NULL,
  `si_service` int(11) NOT NULL,
  `si_one_star` int(11) NOT NULL,
  `si_two_star` int(11) NOT NULL,
  `si_three_star` int(11) NOT NULL,
  `si_four_star` int(11) NOT NULL,
  `si_five_star` int(11) NOT NULL,
  `fec_last_solicited` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`si_id`),
  KEY `si_m_id` (`si_m_id`),
  KEY `si_service` (`si_service`),
  CONSTRAINT `reports_ibfk_1` FOREIGN KEY (`si_m_id`) REFERENCES `mechanics` (`si_id`),
  CONSTRAINT `reports_ibfk_2` FOREIGN KEY (`si_service`) REFERENCES `services` (`si_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reports`
--

LOCK TABLES `reports` WRITE;
/*!40000 ALTER TABLE `reports` DISABLE KEYS */;
INSERT INTO `reports` VALUES (1,1,1,5,0,0,0,8,'2017-02-04 20:27:06'),(2,2,7,4,0,0,6,0,'2017-02-05 23:22:44'),(4,10,12,4,0,0,8,0,'2017-02-05 23:18:00'),(5,1,3,0,0,0,0,9,'2017-02-12 17:22:23');
/*!40000 ALTER TABLE `reports` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `service_mechanic`
--

DROP TABLE IF EXISTS `service_mechanic`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `service_mechanic` (
  `si_id` int(11) NOT NULL AUTO_INCREMENT,
  `service_id` int(11) NOT NULL,
  `mechanic_id` int(11) NOT NULL,
  PRIMARY KEY (`si_id`),
  KEY `service_id` (`service_id`),
  KEY `mechanic_id` (`mechanic_id`),
  CONSTRAINT `service_mechanic_ibfk_1` FOREIGN KEY (`service_id`) REFERENCES `services` (`si_id`),
  CONSTRAINT `service_mechanic_ibfk_2` FOREIGN KEY (`mechanic_id`) REFERENCES `mechanics` (`si_id`)
) ENGINE=InnoDB AUTO_INCREMENT=157 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `service_mechanic`
--

LOCK TABLES `service_mechanic` WRITE;
/*!40000 ALTER TABLE `service_mechanic` DISABLE KEYS */;
INSERT INTO `service_mechanic` VALUES (105,1,1),(106,2,1),(107,3,1),(108,4,1),(109,5,1),(110,6,1),(111,7,1),(112,3,2),(113,6,2),(114,9,2),(115,12,2),(116,8,10),(117,9,10),(118,10,10),(119,11,10),(120,12,10),(121,6,11),(122,7,11),(123,8,11),(124,9,11),(135,3,14),(136,4,14),(137,5,14),(138,6,14),(139,7,14),(140,8,14),(141,9,14),(142,10,14),(143,11,14),(144,12,14),(145,1,22),(146,2,22),(147,3,22),(148,4,22),(149,5,22),(150,6,22),(151,7,22),(152,8,22),(153,9,22),(154,10,22),(155,11,22),(156,12,22);
/*!40000 ALTER TABLE `service_mechanic` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `services`
--

DROP TABLE IF EXISTS `services`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `services` (
  `si_id` int(11) NOT NULL AUTO_INCREMENT,
  `si_service` varchar(150) NOT NULL,
  PRIMARY KEY (`si_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `services`
--

LOCK TABLES `services` WRITE;
/*!40000 ALTER TABLE `services` DISABLE KEYS */;
INSERT INTO `services` VALUES (1,'Cambio de llantas'),(2,'Cambio de aceite y filtros'),(3,'Reparaci√≥n y rectificaci√≥n de motores'),(4,'Cambio de correas de distribuci√≥n'),(5,'Reparaci√≥n y carga de aire acondicionado'),(6,'Suspensi√≥n, alineaci√≥n y balanceo'),(7,'Limpiado y calibraci√≥n de inyectores electr√≥nicos'),(8,'Frenos'),(9,'Carburaci√≥n'),(10,'Reparaci√≥n de alternadores'),(11,'Afinaci√≥n completa'),(12,'Cambio de buj√≠as');
/*!40000 ALTER TABLE `services` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tips`
--

DROP TABLE IF EXISTS `tips`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tips` (
  `si_folio` int(11) NOT NULL AUTO_INCREMENT,
  `si_t_name` varchar(100) NOT NULL,
  `si_description` text NOT NULL,
  PRIMARY KEY (`si_folio`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tips`
--

LOCK TABLES `tips` WRITE;
/*!40000 ALTER TABLE `tips` DISABLE KEYS */;
INSERT INTO `tips` VALUES (1,'Cambio de llantas','Paso 1: Hacer esto.\nPaso 2: Hacer aquello.\nPaso 3: Hacer esto otro.\nPaso 4: Finalmente haz esto.'),(3,'Cambio de aceite','Paso 1: Abra el cofre.\r\nPaso 2: Visualice.\r\nPaso 3: Cambie aceite.'),(4,'otro tip','paso 1: aqui\npaso 2: asi\npaso 3:aca');
/*!40000 ALTER TABLE `tips` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `si_id` int(11) NOT NULL AUTO_INCREMENT,
  `si_username` varchar(30) NOT NULL,
  `si_password` blob NOT NULL,
  `si_firstname` varchar(50) NOT NULL,
  `si_lastname` varchar(50) NOT NULL,
  PRIMARY KEY (`si_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'admin','ªy†∂©À¨f\Ï\–\”)\0\⁄','Administrador','del Sistema');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-03-12 17:19:44
