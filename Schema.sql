CREATE DATABASE  IF NOT EXISTS `cake` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `cake`;
-- MySQL dump 10.13  Distrib 5.6.13, for osx10.6 (i386)
--
-- Host: 127.0.0.1    Database: cake
-- ------------------------------------------------------
-- Server version	5.6.21

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
-- Table structure for table `channels`
--

DROP TABLE IF EXISTS `channels`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `channels` (
  `id` int(11) NOT NULL,
  `name` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `channels`
--

LOCK TABLES `channels` WRITE;
/*!40000 ALTER TABLE `channels` DISABLE KEYS */;
INSERT INTO `channels` VALUES (0,'Manual User Inventory Update'),(1,'Shopify'),(2,'Vend');
/*!40000 ALTER TABLE `channels` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `softInventoryEvent`
--

DROP TABLE IF EXISTS `softInventoryEvent`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `softInventoryEvent` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_channel_id` int(11) DEFAULT NULL,
  `occurred` datetime DEFAULT NULL,
  `increase` int(11) DEFAULT '0',
  `note` varchar(45) DEFAULT NULL,
  `SKU` varchar(15) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `unique_identifier` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniqueness` (`unique_identifier`),
  KEY `Channel_idx` (`user_channel_id`),
  KEY `User_idx` (`user_id`),
  KEY `index2` (`user_channel_id`,`id`),
  CONSTRAINT `Channel` FOREIGN KEY (`user_channel_id`) REFERENCES `channels` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `User` FOREIGN KEY (`user_id`) REFERENCES `stitchCustomers` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `softInventoryEvent`
--

LOCK TABLES `softInventoryEvent` WRITE;
/*!40000 ALTER TABLE `softInventoryEvent` DISABLE KEYS */;
INSERT INTO `softInventoryEvent` VALUES (1,1,'2014-02-03 00:00:00',3,'Fake stock increase','kittens',1,'shopify:fake00'),(14,1,'2008-01-10 11:00:00',-1,NULL,'IPOD2008GREEN',1,'Shopify:450789469.466157049'),(15,1,'2008-01-10 11:00:00',-1,NULL,'IPOD2008RED',1,'Shopify:450789469.518995019'),(16,1,'2008-01-10 11:00:00',-1,NULL,'IPOD2008BLACK',1,'Shopify:450789469.703073504');
/*!40000 ALTER TABLE `softInventoryEvent` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `stitchCustomers`
--

DROP TABLE IF EXISTS `stitchCustomers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `stitchCustomers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(45) DEFAULT NULL,
  `phone` varchar(45) DEFAULT NULL,
  `first_name` varchar(25) DEFAULT NULL,
  `last_name` varchar(35) DEFAULT NULL,
  `salted_hash` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `Email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `stitchCustomers`
--

LOCK TABLES `stitchCustomers` WRITE;
/*!40000 ALTER TABLE `stitchCustomers` DISABLE KEYS */;
INSERT INTO `stitchCustomers` VALUES (1,'alexander.c.rohde@gmail.com','+15406871103','Alex','Rohde','This part isn\'t made yet');
/*!40000 ALTER TABLE `stitchCustomers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `userChannels`
--

DROP TABLE IF EXISTS `userChannels`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `userChannels` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `channel_id` int(11) DEFAULT NULL,
  `shop_name` varchar(45) DEFAULT NULL,
  `shop_channel_identifier` varchar(45) DEFAULT NULL,
  `shop_api_key` varchar(45) DEFAULT NULL,
  `shop_api_password` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `userChannels`
--

LOCK TABLES `userChannels` WRITE;
/*!40000 ALTER TABLE `userChannels` DISABLE KEYS */;
INSERT INTO `userChannels` VALUES (1,1,1,'Fun Times!','stitchdemo','724d989f74ea002f72439fadcf214c78','94faffaca435ebc44939d080fe73dd83'),(2,1,2,'Fun vend Times','vendDemo',NULL,NULL);
/*!40000 ALTER TABLE `userChannels` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-10-04 17:04:45
