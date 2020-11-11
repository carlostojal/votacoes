-- MySQL dump 10.13  Distrib 8.0.21, for Linux (x86_64)
--
-- Host: localhost    Database: votacoes
-- ------------------------------------------------------
-- Server version	8.0.21-0ubuntu0.20.04.4

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
-- Table structure for table `Boletim`
--

DROP TABLE IF EXISTS `Boletim`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Boletim` (
  `cod` int NOT NULL AUTO_INCREMENT,
  `email` varchar(100) NOT NULL,
  `usado` tinyint(1) NOT NULL DEFAULT '0',
  `endereco_ip` varchar(100) DEFAULT NULL,
  `cod_confirmacao` int NOT NULL,
  PRIMARY KEY (`cod`,`email`)
) ENGINE=InnoDB AUTO_INCREMENT=620 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Boletim`
--

LOCK TABLES `Boletim` WRITE;
/*!40000 ALTER TABLE `Boletim` DISABLE KEYS */;
INSERT INTO `Boletim` VALUES (619,'d98b25fd1cbca5c64d7314d7800fe69e',1,NULL,525);
/*!40000 ALTER TABLE `Boletim` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Lista`
--

DROP TABLE IF EXISTS `Lista`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Lista` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(30) NOT NULL,
  `descricao` text,
  `imagem` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `Lista_UN` (`nome`)
) ENGINE=InnoDB AUTO_INCREMENT=60 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Lista`
--

LOCK TABLES `Lista` WRITE;
/*!40000 ALTER TABLE `Lista` DISABLE KEYS */;
INSERT INTO `Lista` VALUES (59,'Lista A','Esta é a lista A',NULL);
/*!40000 ALTER TABLE `Lista` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Utilizador`
--

DROP TABLE IF EXISTS `Utilizador`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Utilizador` (
  `username` varchar(30) NOT NULL,
  `password` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Utilizador`
--

LOCK TABLES `Utilizador` WRITE;
/*!40000 ALTER TABLE `Utilizador` DISABLE KEYS */;
INSERT INTO `Utilizador` VALUES ('carlostojal','482c811da5d5b4bc6d497ffa98491e38'),('comissao2020','cfa39f80629e254a6938459753cce46b');
/*!40000 ALTER TABLE `Utilizador` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Voto`
--

DROP TABLE IF EXISTS `Voto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Voto` (
  `id` int NOT NULL AUTO_INCREMENT,
  `lista` int DEFAULT NULL,
  `data_hora` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `Voto_FK` (`lista`),
  CONSTRAINT `Voto_FK` FOREIGN KEY (`lista`) REFERENCES `Lista` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Voto`
--

LOCK TABLES `Voto` WRITE;
/*!40000 ALTER TABLE `Voto` DISABLE KEYS */;
INSERT INTO `Voto` VALUES (9,NULL,'2020-11-11 18:41:51'),(10,59,'2020-11-11 18:42:26'),(11,59,'2020-11-11 18:43:10'),(12,NULL,'2020-11-11 18:43:17'),(13,59,'2020-11-11 18:43:22'),(14,59,'2020-11-11 19:55:40'),(15,59,'2020-11-11 19:55:42'),(16,59,'2020-11-11 20:55:43'),(17,59,'2020-11-11 21:55:44');
/*!40000 ALTER TABLE `Voto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'votacoes'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-11-11 19:33:12
