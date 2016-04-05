-- MySQL dump 10.13  Distrib 5.5.16, for Win32 (x86)
--
-- Host: localhost    Database: bookaroom
-- ------------------------------------------------------
-- Server version	5.5.28-log

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
-- Table structure for table `bookings`
--

DROP TABLE IF EXISTS `bookings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bookings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `roomid` int(11) NOT NULL,
  `bookingtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `lastupdate` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `starttime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `endtime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `purpose` text,
  `repetition` char(15) NOT NULL DEFAULT 'None',
  PRIMARY KEY (`id`),
  KEY `userid` (`userid`),
  KEY `roomid` (`roomid`),
  CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`roomid`) REFERENCES `rooms` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bookings`
--

LOCK TABLES `bookings` WRITE;
/*!40000 ALTER TABLE `bookings` DISABLE KEYS */;
INSERT INTO `bookings` VALUES (2,2,1,'2013-04-10 18:57:37','2013-04-10 18:57:37','2013-04-20 10:30:00','2013-04-20 12:00:00','Important work','Daily'),(5,3,2,'2013-04-13 18:15:48','2013-04-13 18:15:48','2013-04-13 04:00:00','2013-04-13 04:30:00','timepass','None'),(6,4,2,'2013-04-15 14:22:32','2013-04-15 14:22:32','2013-04-15 03:00:00','2013-04-15 04:30:00','Urgent class','None'),(7,8,6,'2013-04-16 21:14:12','2013-04-16 21:14:12','2013-04-17 03:00:00','2013-04-17 04:30:00','','None'),(9,2,2,'2013-04-18 16:33:47','2013-04-18 16:33:47','2013-04-17 16:45:00','2013-04-17 17:00:00','test','None'),(10,2,3,'2013-04-18 17:43:52','2013-04-20 09:11:45','2013-04-22 03:00:00','2013-04-22 07:00:00','Some class','Weekdays'),(11,2,8,'2013-04-20 11:25:35','2013-04-20 11:31:06','2013-04-22 05:00:00','2013-04-22 06:30:00','class','Weekly');
/*!40000 ALTER TABLE `bookings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rooms`
--

DROP TABLE IF EXISTS `rooms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rooms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` char(10) DEFAULT NULL,
  `capacity` smallint(5) unsigned DEFAULT NULL,
  `projector` tinyint(1) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rooms`
--

LOCK TABLES `rooms` WRITE;
/*!40000 ALTER TABLE `rooms` DISABLE KEYS */;
INSERT INTO `rooms` VALUES (1,'LH-3',250,1),(2,'LH-2',100,1),(3,'205',50,1),(4,'LH-1',70,1),(5,'123',40,1),(6,'222',80,0),(7,'116',45,1),(8,'CS Lab-1',30,0),(9,'CS Lab-2',30,0),(10,'121',40,1),(11,'CS Lab-3',50,1),(12,'204',50,1),(13,'125',70,1);
/*!40000 ALTER TABLE `rooms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` char(30) DEFAULT NULL,
  `password` text,
  `phone` char(20) DEFAULT NULL,
  `email` char(30) DEFAULT NULL,
  `level` char(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Agam Agarwal','*A154C52565E9E7F94BFC08A1FE702624ED8EFFDA','+919505008963','cs12b1003@iith.ac.in','student'),(2,' Mr Sachin Jaiswal','*2886E72461989D7DD64B990EB1AA5A4D855C047E','+919505031523','cs12b1033@iith.ac.in','student'),(3,'Abdul Aziz','*0D3CED9BEC10A777AEC23CCC353A8C08A633045E','9283597239','cs12b1001@iith.ac.in','student'),(4,'Administrator','*4ACFE3202A5FF5CF467898FC58AAB1D615029441','9876543211','admin@iith.ac.in','admin'),(5,'Akshay Dabherao','*23AE809DDACAF96AF0FD78ED04B6A265E05AA257','9652902287','cs12b1005@iith.ac.in','student'),(6,'Rakshit','*23AE809DDACAF96AF0FD78ED04B6A265E05AA257','9505011015','cs12b1029@iith.ac.in','admin'),(7,'Chunmun','*EA82C44AAA4915A738285FC579F2CEA69EF5FE5D','9786453120','chunnu@iith.ac.in','student'),(8,'Aaditya Sapkal','*0959D3C75AF317FB542F3CEBB84D13ABEBC0F5E3','9640995844','es12b1016@iith.ac.in','student'),(9,'Rahul Budhrani','*B798AF2F88B316D4BBE8D86F09CE08D138C65400','8985104800','ee12b1027@iith.ac.in','student');
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

-- Dump completed on 2013-04-26 14:25:44
