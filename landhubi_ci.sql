-- MySQL dump 10.13  Distrib 5.7.34, for Linux (x86_64)
--
-- Host: localhost    Database: landhubi_ci
-- ------------------------------------------------------
-- Server version	5.7.34

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
-- Table structure for table `desk_access`
--

DROP TABLE IF EXISTS `desk_access`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `desk_access` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `token_type` varchar(100) DEFAULT NULL,
  `access_token` varchar(255) DEFAULT NULL,
  `refresh_token` text,
  `created_time` datetime DEFAULT NULL,
  `expiry_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `desk_access`
--

LOCK TABLES `desk_access` WRITE;
/*!40000 ALTER TABLE `desk_access` DISABLE KEYS */;
INSERT INTO `desk_access` VALUES (8,'desk','1000.9f61ae22f0a422fc706bc247a7e6d5aa.8d80e33ada5b4fb503601004664e63a2','1000.ab20d9433010e6238960040634d4a354.ade3b61581473e60a85caa3ce615f005','2020-12-22 01:05:45','2020-12-22 02:05:45');
/*!40000 ALTER TABLE `desk_access` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lot_uploads`
--

DROP TABLE IF EXISTS `lot_uploads`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lot_uploads` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL COMMENT 'User',
  `lot` varchar(255) NOT NULL COMMENT 'Lot Number',
  `label` varchar(500) NOT NULL,
  `document` varchar(500) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lot_uploads`
--

LOCK TABLES `lot_uploads` WRITE;
/*!40000 ALTER TABLE `lot_uploads` DISABLE KEYS */;
INSERT INTO `lot_uploads` VALUES (1,1,'12710000000604396','Landscape Plan','lionheart.jpg'),(2,1,'12710000000605250','John','3._North_East_Rail_Line_Upgrade.pdf'),(4,1,'12710000000673199','Tenancy Application Form','Ray-White-Reservoir-Tenancy-Application-Form-updated.pdf'),(5,1,'12710000000673199','Great Otway Map','Great-Otway-National-Park-Campground-Maps.pdf'),(6,1,'12710000000673199','Cathedral Range','Cathedral-Range-State-Park-visitor-guide.pdf'),(7,1,'12710000000673199','Brisbane Park','Brisbane-Ranges-National-Park-Visitor-Guide_(1).pdf'),(8,1,'12710000000673199','The Gums Kinglake Campground Map','The_Gums_Campground_Map_KinglakeNP.pdf'),(9,1,'12710000000676393','Test','file-sample_150kB.pdf'),(14,25,'12710000000675489','test','sample.pdf'),(15,1,'12710000000675146','Test File','3._North_East_Rail_Line_Upgrade1.pdf'),(16,25,'12710000000675489','Quality Check','action-blur-city-590701.jpg');
/*!40000 ALTER TABLE `lot_uploads` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_items`
--

DROP TABLE IF EXISTS `tbl_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_items` (
  `itemId` int(11) NOT NULL AUTO_INCREMENT,
  `itemHeader` varchar(512) NOT NULL COMMENT 'Heading',
  `itemSub` varchar(1021) NOT NULL COMMENT 'sub heading',
  `itemDesc` text COMMENT 'content or description',
  `itemImage` varchar(80) DEFAULT NULL,
  `isDeleted` tinyint(4) NOT NULL DEFAULT '0',
  `createdBy` int(11) NOT NULL,
  `createdDtm` datetime NOT NULL,
  `updatedDtm` datetime DEFAULT NULL,
  `updatedBy` int(11) DEFAULT NULL,
  PRIMARY KEY (`itemId`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_items`
--

LOCK TABLES `tbl_items` WRITE;
/*!40000 ALTER TABLE `tbl_items` DISABLE KEYS */;
INSERT INTO `tbl_items` VALUES (1,'jquery.validation.js','Contribution towards jquery.validation.js','jquery.validation.js is the client side javascript validation library authored by Jörn Zaefferer hosted on github for us and we are trying to contribute to it. Working on localization now','validation.png',0,1,'2015-09-02 00:00:00',NULL,NULL),(2,'CodeIgniter User Management','Demo for user management system','This the demo of User Management System (Admin Panel) using CodeIgniter PHP MVC Framework and AdminLTE bootstrap theme. You can download the code from the repository or forked it to contribute. Usage and installation instructions are provided in ReadMe.MD','cias.png',0,1,'2015-09-02 00:00:00',NULL,NULL);
/*!40000 ALTER TABLE `tbl_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_reset_password`
--

DROP TABLE IF EXISTS `tbl_reset_password`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_reset_password` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `email` varchar(128) NOT NULL,
  `activation_id` varchar(32) NOT NULL,
  `agent` varchar(512) NOT NULL,
  `client_ip` varchar(32) NOT NULL,
  `isDeleted` tinyint(4) NOT NULL DEFAULT '0',
  `createdBy` bigint(20) NOT NULL DEFAULT '1',
  `createdDtm` datetime NOT NULL,
  `updatedBy` bigint(20) DEFAULT NULL,
  `updatedDtm` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_reset_password`
--

LOCK TABLES `tbl_reset_password` WRITE;
/*!40000 ALTER TABLE `tbl_reset_password` DISABLE KEYS */;
INSERT INTO `tbl_reset_password` VALUES (1,'noel@team.humanpixel.com.au','QMUf9tBo85Tk0ni','Chrome 84.0.4147.105','172.89.111.124',0,1,'2020-07-28 23:40:16',NULL,NULL),(2,'noel@team.humanpixel.com.au','xyUaoZBKSJ6dO4F','Chrome 84.0.4147.105','172.89.111.124',0,1,'2020-08-24 02:10:59',NULL,NULL);
/*!40000 ALTER TABLE `tbl_reset_password` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_roles`
--

DROP TABLE IF EXISTS `tbl_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_roles` (
  `roleId` tinyint(4) NOT NULL AUTO_INCREMENT COMMENT 'role id',
  `role` varchar(50) NOT NULL COMMENT 'role text',
  PRIMARY KEY (`roleId`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_roles`
--

LOCK TABLES `tbl_roles` WRITE;
/*!40000 ALTER TABLE `tbl_roles` DISABLE KEYS */;
INSERT INTO `tbl_roles` VALUES (1,'System Administrator'),(2,'Client Administrator'),(3,'Builder Administrator'),(4,'Purchaser'),(5,'Contractor'),(6,'Builder');
/*!40000 ALTER TABLE `tbl_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_users`
--

DROP TABLE IF EXISTS `tbl_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_users` (
  `userId` int(11) NOT NULL AUTO_INCREMENT,
  `zoho_user_id` varchar(128) DEFAULT NULL,
  `email` varchar(128) NOT NULL COMMENT 'login email',
  `password` varchar(128) NOT NULL COMMENT 'hashed login password',
  `name` varchar(128) DEFAULT NULL COMMENT 'full name of user',
  `mobile` varchar(20) DEFAULT NULL,
  `company` varchar(250) DEFAULT NULL,
  `estate` varchar(20) NOT NULL DEFAULT '',
  `lotnumber` varchar(50) NOT NULL DEFAULT '',
  `roleId` tinyint(4) NOT NULL,
  `createdBy` int(11) NOT NULL,
  `createdDtm` datetime NOT NULL,
  `updatedBy` int(11) DEFAULT NULL,
  `updatedDtm` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`userId`)
) ENGINE=MyISAM AUTO_INCREMENT=74 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_users`
--

LOCK TABLES `tbl_users` WRITE;
/*!40000 ALTER TABLE `tbl_users` DISABLE KEYS */;
INSERT INTO `tbl_users` VALUES (1,'2002000000405534','marketing@integragroup.com.au','$2y$10$igavj3VyhOFmNOft4wZnteTa.5iDvG8ew9F7sVk6C.BNe9ub5czHa','System Admin','0412345678','124242354','','',1,0,'2015-07-01 18:56:49',1,'2020-11-27 08:54:19',NULL),(44,NULL,'builder@test.com','$2y$10$rXdUBbyfZG5y3sAIBV2.1uX07rGXWvf.tbYRyh/9uPohSopu8ExX.','Builder','0421917555','','','',6,1,'2020-11-27 10:01:18',1,'2020-12-03 14:24:29','2020-12-03 14:24:29'),(45,NULL,'contractor@test.com','$2y$10$IdznYwLVZy9LUxOryWbGJurWG.wX7QxyiUnlPh/Mwlec4hNloV/AS','Contractor','0421917556','','','',5,1,'2020-11-27 10:05:10',NULL,NULL,NULL),(46,NULL,'builderadmin@test.com','$2y$10$jIAgNc.O7tFdv7d5advsQupKfFIiU/TFiMg7D/5LQ5maBXYyPLwVO','Builder Admin','0421917556','','','',3,1,'2020-11-27 10:05:45',1,'2020-11-27 13:16:40',NULL),(47,NULL,'clientadmin@test.com','$2y$10$V3JzgVgvLTEGApHtZRR1qebnlux/Bwa8h2xXGXaOXxY8hfrgYpdFy','Client Admin','0421917556','','','',2,1,'2020-11-27 10:14:41',NULL,NULL,NULL),(71,NULL,'cecille@team.humanpixel.com.au','$2y$10$ZFbYUIHkI10ODg.pbHpRNObofn5GDeZM9orM05/D.uHMR2xbHXDF6','Test Tester','+61421917557','Human Pixel Pty Ltd','','',3,1,'2020-12-04 08:17:24',1,'2020-12-04 08:17:53','2020-12-04 08:17:53'),(50,NULL,'testtodelete@email.com','$2y$10$Ebqmg1NCBL/tmkx9DzJ4QuQs2cBRhpjUWbX./rQ0b8Lii01FXg0vK','Testtodelete','0421917553','','','',2,1,'2020-11-27 13:13:03',1,'2020-11-30 11:52:40','2020-11-30 11:52:40'),(51,NULL,'testtodelete2@email.com','$2y$10$dza/bIkqqVOY3SJR74ijUeDmaN5b2WpYB5APsf.L8ufXq3.SBeic6','Testtodelete2','0421917556','','','',3,1,'2020-11-27 13:16:18',1,'2020-11-27 13:21:45','2020-11-27 13:21:45'),(52,NULL,'testtodelete@email.com','$2y$10$IwdDn6D7RZGzJm3Dd.GJyuuxTDdjwIsUJfF9v2TH9AYajMNtxOlOe','Test','0421917555','','','',2,1,'2020-11-30 12:19:18',1,'2020-11-30 12:19:27','2020-11-30 12:19:27'),(56,NULL,'fakeemail3@projects.humanpixel.com.au','$2y$10$Ryb8X0/2y.fTJRpq.oV/Nu6BIR0X2Q8BupkjjYWLPTNLVxZeGSzYi','Landhub Test 3','1234567890','','','',1,1,'2020-12-03 18:28:46',1,'2021-07-15 11:37:14',NULL),(55,'2002000000428085','fakeemail4@projects.humanpixel.com.au','$2y$10$XUcnzz4LT95pflR4D/glz.BIaM1llw890lSa55BiOdy/2miusK9iy','Landhub Test 4','0421917555','','','',5,1,'2020-12-03 18:11:23',55,'2020-12-04 00:58:11',NULL),(70,NULL,'cecille@team.humanpixel.com.au','$2y$10$oUTvT5T.wlXMjcO4gzcDLOuBtqKxs1Asu7a.fB8GNFqvbt91Q1iTe','Test Tester','+61421917557','Human Pixel Pty Ltd','','',3,1,'2020-12-04 08:16:51',1,'2020-12-04 08:17:08','2020-12-04 08:17:08'),(61,NULL,'ruffy.c@team.humanpixel.com.au','$2y$10$Hunnnll4t4xwpSnQJvSEIu6xVWkSD5d6oMRz9BWjLYMoObVsEeY/.','Ruffy Collado','1234567890','','','',3,1,'2020-12-03 20:25:10',1,'2020-12-03 20:25:17','2020-12-03 20:25:17'),(62,NULL,'cecille@team.humanpixel.com.au','$2y$10$1vpsGtgfsiI2t15gJvZOzeQ8vPo2l6n5PuVY9m9CR3r.gy22O7TZe','Test Tester','+61421917557','Human Pixel Pty Ltd','','',3,1,'2020-12-03 20:29:09',1,'2020-12-03 20:29:15','2020-12-03 20:29:15'),(63,NULL,'cecille@team.humanpixel.com.au','$2y$10$3UwYwCNW8mpqLP/qrJaWh.AC1GDxnTqJzJFWrHQRNJCjG02IkD2fS','Cecille Pantonial','+61421917557','Human Pixel Pty Ltd','','',3,1,'2020-12-03 20:29:55',1,'2020-12-03 20:30:13','2020-12-03 20:30:13'),(64,NULL,'cecille@team.humanpixel.com.au','$2y$10$Ubmn.9zDEqOiLKUeZj8WLOyE0/MrjeZaTInHOVCHEo78.uJnM//xq','Test Tester','+61421917557','Human Pixel Pty Ltd','','',3,1,'2020-12-03 20:52:53',1,'2020-12-03 20:53:04','2020-12-03 20:53:04'),(65,NULL,'cecille@team.humanpixel.com.au','$2y$10$KMKK.x/6j2ZD6IyBwCmXpuE2QBInLySXJsJ77LKZceh9VPgCsH2YK','Test Tester','+61421917557','Human Pixel Pty Ltd','','',2,1,'2020-12-03 20:54:08',1,'2020-12-03 20:54:19','2020-12-03 20:54:19'),(66,NULL,'ashish.p@team.humanpixel.com.au','$2y$10$CThcr.OIOYSfM7.ONdZBgOtXmvGtQxSRdbQAi0Be2W29kLACvXg7K','Ashish Patil','9565336362','Human Pixel','','',2,1,'2020-12-03 22:18:55',1,'2020-12-03 22:20:20','2020-12-03 22:20:20'),(67,NULL,'ashish.p@team.humanpixel.com.au','$2y$10$OihCYc58xFsBziqEye0oBOQO7MxjQ2XGkWNYFuYCat1E8iVsY0jyK','Ashish Patil','9565336362','Human Pixel','','',2,1,'2020-12-03 22:26:05',1,'2020-12-03 22:26:27','2020-12-03 22:26:27'),(68,NULL,'ashish.p@team.humanpixel.com.au','$2y$10$kquVYTOUAMKqcz6Gtqh/n.ngPvru.kuwEQIuM1WRJmmz226COvB22','Ashish Patil','9565336362','Human Pixel','','',2,1,'2020-12-03 22:27:26',NULL,NULL,NULL),(24,NULL,'cecillemata21@gmail.com','$2y$10$..tprsPSnrBYbhJPJeUxfuT6U1S5fNyTiyMBRugLFcKq4mBXrhpzq','Cecille Mata','4123456789','','','',2,1,'2020-10-13 05:29:47',1,'2020-11-27 12:35:16','2020-11-27 12:35:16'),(25,'2002000000405558','fakeemail2@projects.humanpixel.com.au','$2y$10$igavj3VyhOFmNOft4wZnteTa.5iDvG8ew9F7sVk6C.BNe9ub5czHa','Landhub Test 2','4123456789','Human Pixel','Ballymanus','532',4,1,'2020-10-13 05:38:04',25,'2020-11-27 12:39:08',NULL),(72,NULL,'cecille@team.humanpixel.com.au','$2y$10$ug22gJrJrUckdqrmYN24De8.j6r28kAHfsO45nJxEb3V2.hi.MgR6','Cecille Pantonial','+61421917557','Human Pixel Pty Ltd','','',3,1,'2020-12-04 08:18:06',1,'2020-12-04 08:18:29','2020-12-04 08:18:29'),(73,NULL,'cecille@team.humanpixel.com.au','$2y$10$E0W..62EFWupvdqHJF7sn.m3dwaqO.Rjr8WlW5cJH05GUSZxtdWeq','Cecille Pantonial','+61421917557','Human Pixel Pty Ltd','','',3,1,'2020-12-04 08:19:02',NULL,NULL,NULL),(34,'2002000000423001','fakeemail1@projects.humanpixel.com.au','$2y$10$igavj3VyhOFmNOft4wZnteTa.5iDvG8ew9F7sVk6C.BNe9ub5czHa','Landhub Test 1','12312312332','Test','','',6,1,'2020-11-23 20:00:50',1,'2020-12-03 22:17:11',NULL),(69,NULL,'cecille@team.humanpixel.com.au','$2y$10$GEyXnTwZE6izM0KrxqXlM.Cs5aLYj6zHPXWMu6j7mQ9eYQ8ZCr8Oa','Cecille Pantonial','+61421917557','Human Pixel Pty Ltd','','',2,1,'2020-12-04 08:16:10',1,'2020-12-04 08:16:18','2020-12-04 08:16:18');
/*!40000 ALTER TABLE `tbl_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_mailbox`
--

DROP TABLE IF EXISTS `user_mailbox`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_mailbox` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sender` int(11) NOT NULL,
  `receiver` int(11) NOT NULL,
  `box` varchar(100) NOT NULL DEFAULT 'inbox',
  `content` text,
  `date_added` datetime DEFAULT NULL,
  `read_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_mailbox`
--

LOCK TABLES `user_mailbox` WRITE;
/*!40000 ALTER TABLE `user_mailbox` DISABLE KEYS */;
INSERT INTO `user_mailbox` VALUES (1,7,6,'inbox','Hello mate, I need help','2020-08-31 01:00:00',NULL,NULL),(2,6,7,'inbox','All good, brother','2020-08-31 01:02:00',NULL,NULL),(3,2,1,'inbox','What What','2020-08-31 04:39:06',NULL,NULL),(4,1,2,'inbox','Howdy','2020-08-31 04:41:46',NULL,NULL),(5,2,1,'inbox','Yow','2020-08-31 04:42:29',NULL,NULL),(6,6,5,'inbox','Hello sir, can I take your orders','2020-08-31 04:44:35',NULL,NULL),(8,6,4,'inbox','I commune with my goddess, in my time of need','2020-08-31 05:01:24',NULL,NULL),(9,6,10,'inbox','I find your lack of faith, disturbing','2020-08-31 05:02:09',NULL,NULL),(11,1,6,'inbox','hey Ruffy','2020-09-02 02:18:30',NULL,NULL),(12,1,5,'inbox','test','2020-09-22 04:05:39',NULL,NULL),(14,1,6,'inbox','tes','2020-10-12 01:47:34',NULL,NULL),(16,1,26,'inbox','test','2020-10-15 02:18:59',NULL,NULL),(17,1,25,'inbox','test','2020-10-15 02:19:11',NULL,NULL),(18,1,25,'inbox','again','2020-10-15 02:19:16',NULL,NULL),(19,19,2,'inbox','test','2020-11-18 14:04:26',NULL,NULL),(20,1,29,'inbox','test','2020-11-18 14:05:33',NULL,NULL);
/*!40000 ALTER TABLE `user_mailbox` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `zoho_access`
--

DROP TABLE IF EXISTS `zoho_access`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `zoho_access` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `token_type` varchar(100) NOT NULL,
  `access_token` varchar(255) NOT NULL,
  `refresh_token` text NOT NULL,
  `created_time` datetime NOT NULL,
  `expiry_time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `zoho_access`
--

LOCK TABLES `zoho_access` WRITE;
/*!40000 ALTER TABLE `zoho_access` DISABLE KEYS */;
INSERT INTO `zoho_access` VALUES (8,'crm','1000.ba0d1101479e6ede7b15b9395b87cfcf.acb1bf504e05795a330b81691bab2805','1000.8e8f3e2412b1d533006eb86fbd968814.37961c59d9a952f1a6e935470e0f52ad','2021-07-15 11:15:20','2021-07-15 12:15:20');
/*!40000 ALTER TABLE `zoho_access` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-07-15 16:49:09
