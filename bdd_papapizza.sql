-- MySQL dump 10.13  Distrib 5.7.29, for Linux (x86_64)
--
-- Host: localhost    Database: papaizza
-- ------------------------------------------------------
-- Server version	5.7.29

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES UTF8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `ingredient`
--

DROP TABLE IF EXISTS `ingredient`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ingredient` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `is_allergic` tinyint(1) NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ingredient`
--

LOCK TABLES `ingredient` WRITE;
/*!40000 ALTER TABLE `ingredient` DISABLE KEYS */;
INSERT INTO `ingredient` VALUES (1,'tomate','base',0,1),(2,'crème fraiche','base',1,1),(3,'mozzarella','fromage',0,1),(4,'emmental','fromage',0,1),(5,'chèvre','fromage',0,1),(6,'roquefort','fromage',1,1),(7,'parmesan','fromage',0,1),(8,'jambon','viande',0,1),(9,'lardons','viande',0,1),(10,'poulet','viande',0,1),(11,'merguez','viande',0,1),(12,'chorizo','viande',0,1),(13,'saucisse','viande',0,1),(14,'thon','poisson',0,1),(15,'saumon','poisson',0,1),(16,'anchois','poisson',1,1),(17,'olives','légume',0,1),(18,'champignons','légume',0,1),(19,'oignons','légume',0,1),(20,'poivrons','légume',0,1),(21,'artichauts','légume',0,1),(22,'aubergines','légume',0,1),(23,'courgettes','légume',0,1),(24,'pommes de terre','légume',0,1),(25,'oeuf','viande',0,1),(26,'câpres','autre',0,1),(27,'miel','autre',0,1),(28,'persil','autre',0,1),(29,'basilic','autre',0,1),(30,'origan','autre',0,1),(31,'piment','autre',0,1),(32,'huile piquante','autre',0,1);
/*!40000 ALTER TABLE `ingredient` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order`
--

DROP TABLE IF EXISTS `order`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_number` varchar(255) NOT NULL,
  `date_order` datetime NOT NULL,
  `date_delivered` datetime DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'En cours',
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `order_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order`
--

LOCK TABLES `order` WRITE;
/*!40000 ALTER TABLE `order` DISABLE KEYS */;
/*!40000 ALTER TABLE `order` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_row`
--

DROP TABLE IF EXISTS `order_row`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order_row` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `quantity` int(11) NOT NULL,
  `price` float NOT NULL,
  `order_id` int(11) NOT NULL,
  `pizza_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`),
  KEY `pizza_id` (`pizza_id`),
  CONSTRAINT `order_row_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `order` (`id`),
  CONSTRAINT `order_row_ibfk_2` FOREIGN KEY (`pizza_id`) REFERENCES `pizza` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_row`
--

LOCK TABLES `order_row` WRITE;
/*!40000 ALTER TABLE `order_row` DISABLE KEYS */;
/*!40000 ALTER TABLE `order_row` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pizza`
--

DROP TABLE IF EXISTS `pizza`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pizza` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `pizza_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pizza`
--

LOCK TABLES `pizza` WRITE;
/*!40000 ALTER TABLE `pizza` DISABLE KEYS */;
INSERT INTO `pizza` VALUES (1,'Margarita','margarita.jpg',1,1),(2,'4 fromages','4fromages.jpg',1,1),(3,'Reine','reine.jpg',1,1),(4,'Royale','royale.jpg',1,1),(5,'Calzone','calzone.jpg',1,1),(6,'Hawaienne','hawaienne.jpg',1,1),(7,'Chorizo','chorizo.jpg',1,1),(8,'Poulet','poulet.jpg',1,1),(9,'Saumon','saumon.jpg',1,1),(10,'Végétarienne','vegetarienne.jpg',1,1),(11,'Paysanne','paysanne.jpg',1,1),(12,'Orientale','orientale.jpg',1,1),(13,'Océane','oceane.jpg',1,1),(14,'Pizzaiolo','pizzaiolo.jpg',1,1),(15,'La pizzapapaye','65797457e4e07_Cerise.png',0,1),(16,'La pizzapapaye','6579748a39ca1_Cerise.png',0,1),(17,'La pizzapapaye','657974a04182a_Cerise.png',0,1),(18,'La pizzapapaye','6579762c407fd_Cerise.png',0,1),(19,'La pizzapapaye','65797b7219ae4_Cerise.png',0,1),(20,'La pizzapapaye','65797b809fb9f_Cerise.png',0,1);
/*!40000 ALTER TABLE `pizza` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pizza_ingredient`
--

DROP TABLE IF EXISTS `pizza_ingredient`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pizza_ingredient` (
  `pizza_id` int(11) NOT NULL,
  `ingredient_id` int(11) NOT NULL,
  `unit_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  KEY `pizza_id` (`pizza_id`),
  KEY `ingredient_id` (`ingredient_id`),
  KEY `unit_id` (`unit_id`),
  CONSTRAINT `pizza_ingredient_ibfk_1` FOREIGN KEY (`pizza_id`) REFERENCES `pizza` (`id`),
  CONSTRAINT `pizza_ingredient_ibfk_2` FOREIGN KEY (`ingredient_id`) REFERENCES `ingredient` (`id`),
  CONSTRAINT `pizza_ingredient_ibfk_3` FOREIGN KEY (`unit_id`) REFERENCES `unit` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pizza_ingredient`
--

LOCK TABLES `pizza_ingredient` WRITE;
/*!40000 ALTER TABLE `pizza_ingredient` DISABLE KEYS */;
INSERT INTO `pizza_ingredient` VALUES (1,1,5,1),(1,3,5,1),(1,4,5,1),(2,1,5,1),(2,3,5,1),(2,4,5,1),(2,5,5,1),(3,1,5,1),(3,3,5,1),(3,4,5,1),(3,7,5,1),(4,1,5,1),(4,3,5,1),(4,4,5,1),(4,8,5,1),(5,1,5,1),(5,3,5,1),(5,4,5,1),(5,9,5,1),(6,1,5,1),(6,3,5,1),(6,4,5,1),(6,10,5,1),(6,11,5,1),(7,1,5,1),(7,3,5,1),(7,4,5,1),(7,12,5,1),(7,13,5,1),(8,1,5,1),(8,3,5,1),(8,4,5,1),(8,14,5,1),(8,15,5,1),(9,1,5,1),(9,3,5,1),(9,4,5,1),(9,16,5,1),(9,17,5,1),(10,1,5,1),(10,3,5,1),(10,4,5,1),(10,18,5,1),(10,19,5,1),(11,1,5,1),(11,3,5,1),(11,4,5,1),(11,20,5,1),(11,21,5,1),(12,1,5,1),(12,3,5,1),(12,4,5,1),(12,22,5,1),(12,23,5,1),(13,1,5,1),(13,3,5,1),(13,4,5,1),(13,24,5,1),(13,25,5,1),(14,1,5,1),(14,3,5,1),(14,4,5,1),(14,26,5,1),(14,27,5,1),(15,1,5,1),(15,2,5,1),(15,19,5,1),(15,22,5,1),(16,1,5,1),(16,2,5,1),(16,19,5,1),(16,22,5,1),(17,1,5,1),(17,2,5,1),(17,19,5,1),(17,22,5,1),(18,20,5,1),(19,20,5,1),(20,4,5,1),(20,11,5,1);
/*!40000 ALTER TABLE `pizza_ingredient` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `price`
--

DROP TABLE IF EXISTS `price`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `price` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `price` float NOT NULL,
  `size_id` int(11) NOT NULL,
  `pizza_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `size_id` (`size_id`),
  KEY `pizza_id` (`pizza_id`),
  CONSTRAINT `price_ibfk_1` FOREIGN KEY (`size_id`) REFERENCES `size` (`id`),
  CONSTRAINT `price_ibfk_2` FOREIGN KEY (`pizza_id`) REFERENCES `pizza` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=58 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `price`
--

LOCK TABLES `price` WRITE;
/*!40000 ALTER TABLE `price` DISABLE KEYS */;
INSERT INTO `price` VALUES (1,5.5,1,1),(2,7.5,2,1),(3,9.5,3,1),(4,6.5,1,2),(5,8.5,2,2),(6,10.5,3,2),(7,7.5,1,3),(8,9.5,2,3),(9,11.5,3,3),(10,8.5,1,4),(11,10.5,2,4),(12,12.5,3,4),(13,8.5,1,5),(14,10.5,2,5),(15,12.5,3,5),(16,9.5,1,6),(17,11.5,2,6),(18,13.5,3,6),(19,9.5,1,7),(20,11.5,2,7),(21,13.5,3,7),(22,9.5,1,8),(23,11.5,2,8),(24,13.5,3,8),(25,9.5,1,9),(26,11.5,2,9),(27,13.5,3,9),(28,9.5,1,10),(29,11.5,2,10),(30,13.5,3,10),(31,9.5,1,11),(32,11.5,2,11),(33,13.5,3,11),(34,9.5,1,12),(35,11.5,2,12),(36,13.5,3,12),(37,9.5,1,13),(38,11.5,2,13),(39,13.5,3,13),(40,9.5,1,14),(41,11.5,2,14),(42,13.5,3,14),(43,10,1,15),(44,0,2,15),(45,0,3,15),(46,10,1,17),(47,0,2,17),(48,0,3,17),(49,10.5,1,18),(50,0,2,18),(51,0,3,18),(52,10.5,1,19),(53,12,2,19),(54,13.5,3,19),(55,10,1,20),(56,12.5,2,20),(57,13,3,20);
/*!40000 ALTER TABLE `price` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `size`
--

DROP TABLE IF EXISTS `size`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `size` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `size`
--

LOCK TABLES `size` WRITE;
/*!40000 ALTER TABLE `size` DISABLE KEYS */;
INSERT INTO `size` VALUES (1,'small (24cm)'),(2,'medium (32cm)'),(3,'large (40cm)');
/*!40000 ALTER TABLE `size` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `unit`
--

DROP TABLE IF EXISTS `unit`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `unit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `unit`
--

LOCK TABLES `unit` WRITE;
/*!40000 ALTER TABLE `unit` DISABLE KEYS */;
INSERT INTO `unit` VALUES (1,'g'),(2,'ml'),(3,'cl'),(4,'l'),(5,'unité'),(6,'pincée');
/*!40000 ALTER TABLE `unit` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `zip_code` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `phone` varchar(255) NOT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'admin@admin.com','$2y$10$0qa4oevS9HPUopr0sL2LuORo7h2DUMzMiB8lCW.WJMBZ3tzKp6/Za','Yolo','Pizza','3 rue de la pizza','66000','Perpignan','France','0601020304',1,0),(2,'doe@doe.com','$2y$10$0qa4oevS9HPUopr0sL2LuORo7h2DUMzMiB8lCW.WJMBZ3tzKp6/Za','toto','toto',NULL,NULL,NULL,NULL,'7846563',0,1),(3,'toto@toto.com','$2y$10$kTqjy99FKmOCMDpy6qmNROg0NhVvEEn8OxKdioOs0ZMdPf03InYuO','toto','toto',NULL,NULL,NULL,NULL,'123456',0,1),(4,'touto@toto.com','$2y$10$XX1lRMpqFxBYodi/zboMLeUkxtTfTDeCUkJ6wfpVZx3aqOxCV1/eq','toto','toto',NULL,NULL,NULL,NULL,'123456',0,1),(5,'tututu@tutu.com','$2y$10$9iidHjv.g/Ppe5mJIGnG3Ojlh32GNJYpzG0Z3mj4EaFt3r.eMShHC','tutu','toto',NULL,NULL,NULL,NULL,'1534865',1,0),(6,'tuif@toto.com','$2y$10$mf7a3silnXI83597J34WY.eqZRv2DbALDFRIf9gVgLzPS/fXyOxvy','toto','toto',NULL,NULL,NULL,NULL,'45646',1,1),(7,'team@team.com','$2y$10$z5wOgK4kAZFuQh9075vvje6lZ7IpMpr8gZxD41KY7ykrghqUFz0EO','toto','ami',NULL,NULL,NULL,NULL,'546459163',1,1),(8,'tutu@toto.com','$2y$10$hD9lPcmgEG7qFDc7QX5uieeDX.vASYjO6QvT0wZ8K69tcYYr/TY9m','tutu','toto',NULL,NULL,NULL,NULL,'41654163',0,1);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-12-15 15:32:49
