CREATE DATABASE  IF NOT EXISTS `haraku` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `haraku`;
-- MySQL dump 10.13  Distrib 5.6.13, for Win32 (x86)
--
-- Host: localhost    Database: haraku
-- ------------------------------------------------------
-- Server version	5.5.33

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
-- Table structure for table `image`
--

DROP TABLE IF EXISTS `image`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `image` (
  `ID` int(11) NOT NULL,
  `IMAGE` varchar(100) DEFAULT NULL,
  `STATUS` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `image`
--

LOCK TABLES `image` WRITE;
/*!40000 ALTER TABLE `image` DISABLE KEYS */;
INSERT INTO `image` VALUES (1,'/uploads/1420795751.jpg',0),(2,'/uploads/1420710321.jpg',1),(3,'/uploads/1420710328.jpg',1),(4,'/uploads/1420710335.jpg',1);
/*!40000 ALTER TABLE `image` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `news`
--

DROP TABLE IF EXISTS `news`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `news` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `NEWS_TYPE_ID` int(11) DEFAULT NULL,
  `TITLE` varchar(200) DEFAULT NULL,
  `SMALL_IMAGE` varchar(200) DEFAULT NULL,
  `SUMMARY` text,
  `CONTENT` text,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `news`
--

LOCK TABLES `news` WRITE;
/*!40000 ALTER TABLE `news` DISABLE KEYS */;
INSERT INTO `news` VALUES (1,1,'abc','/uploads/1420711926.jpg','123gggggggggggggggggggggggggggg','<p>fassssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssss</p>'),(2,3,'ccccccccccccccccccccccccccccccccccccccccccccccc','<br />\r\n<b>Notice</b>:  Undefined property: Application_Model_News::$image in <b>D:\\Web\\domains\\haraku\\public_html\\application\\models\\News.php</b> on line <b>37</b><br />\r\n','1112222222222222222222','<p>hhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhh<span class=\"f-img-wrap\"><img alt=\"Image title\" src=\"/uploads/5a4fc1a11b73b6fc10b36b72384bed7d17b72afa.jpg\" width=\"300\" style=\"min-width: 16px; min-height: 16px; margin-bottom: 10px; margin-left: auto; margin-right: auto; margin-top: 10px\"></span></p>'),(3,2,'rrrrrrrrrrrrrrr','/uploads/1420712605.jpg','aaaaaaaaaaaaaaaaaa','<p>ddddddddddddddddddddddrrrrrrrrrrrrrrrrrrrrgggggggggggggggggfffffffffffffff</p>'),(4,2,'b','/uploads/1420713248.jpg','b','<p>b<span class=\"f-img-wrap\"><img alt=\"Image title\" src=\"/uploads/6944cc15cefe338f8cb14311011e3dcd53855f57.jpg\" width=\"300\" style=\"min-width: 16px; min-height: 16px; margin: 10px 0px;\"></span></p>'),(5,1,'cc','/uploads/1420713273.jpg','ccvv','<p>vvvv<span class=\"f-img-wrap\"><img alt=\"Image title\" src=\"/uploads/d1a570f480cc92d2b844e23a8ecb3f151b3918dd.jpg\" width=\"300\" style=\"min-width: 16px; min-height: 16px; margin-bottom: 10px; margin-left: auto; margin-right: auto; margin-top: 10px\"></span></p>');
/*!40000 ALTER TABLE `news` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `news_type`
--

DROP TABLE IF EXISTS `news_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `news_type` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `NAME` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `news_type`
--

LOCK TABLES `news_type` WRITE;
/*!40000 ALTER TABLE `news_type` DISABLE KEYS */;
INSERT INTO `news_type` VALUES (1,'A'),(2,'B'),(3,'C');
/*!40000 ALTER TABLE `news_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order`
--

DROP TABLE IF EXISTS `order`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `NAME` varchar(45) DEFAULT NULL,
  `PHONE` varchar(20) DEFAULT NULL,
  `EMAIL` varchar(45) DEFAULT NULL,
  `PROVINCE` varchar(45) DEFAULT NULL,
  `ADDRESS` text,
  `IS_SHIP` tinyint(1) DEFAULT '0',
  `SHIP_CODE` varchar(20) DEFAULT NULL,
  `STATUS` tinyint(11) DEFAULT NULL,
  `NOTE` text,
  `CREATE_DATE` datetime DEFAULT NULL,
  `UPDATE_DATE` datetime DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order`
--

LOCK TABLES `order` WRITE;
/*!40000 ALTER TABLE `order` DISABLE KEYS */;
INSERT INTO `order` VALUES (10,'chinh','0949201088','chinh.vu@samsung.com','Hà Nội','		zzzzzzzzzzzz			',1,'123',6,'	AAA				','2015-01-07 09:34:29','2015-01-08 14:41:02'),(11,'chinh','0949201088','chinhbk88@gmail.com','Hà Nội','aaa',0,NULL,5,'		aaaa			','2015-01-07 09:36:08','2015-01-08 11:23:07'),(12,'Dong Lam','1021281820','zz@gg.com','TP Hồ Chí Minh','ZZZZZZZZZZZZZDDDDDDDDDDDDDD					',1,'121xssssx',6,'	zzzzzzzzzzzzzzzzzcccc				','2015-01-08 11:26:15','2015-01-08 11:35:12'),(13,'rrr','0301983913','rrrrrr','Hà Nội','	rrrrrrrrrrrrrrrrrrrrrrrrr				',1,NULL,0,'	ttdgg				','2015-01-09 11:09:15','2015-01-09 11:09:15');
/*!40000 ALTER TABLE `order` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_detail`
--

DROP TABLE IF EXISTS `order_detail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order_detail` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `ORDER_ID` int(11) DEFAULT NULL,
  `PRODUCT_ID` int(11) DEFAULT NULL,
  `QUANTITY` int(11) DEFAULT NULL,
  `PRICE` int(11) DEFAULT NULL,
  `DISCOUNT_PRICE` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_detail`
--

LOCK TABLES `order_detail` WRITE;
/*!40000 ALTER TABLE `order_detail` DISABLE KEYS */;
INSERT INTO `order_detail` VALUES (9,10,2,3,200000,190000),(10,10,3,3,190000,190000),(11,11,2,1,200000,190000),(12,11,3,2,190000,190000),(13,12,2,5,200000,190000),(14,12,3,7,190000,190000),(15,13,4,2,100000,NULL),(16,13,3,3,190000,190000);
/*!40000 ALTER TABLE `order_detail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product`
--

DROP TABLE IF EXISTS `product`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `PRODUCT_TYPE_ID` int(11) DEFAULT NULL,
  `SUB_PRODUCT_TYPE_ID` int(11) DEFAULT NULL,
  `CODE` varchar(100) DEFAULT NULL,
  `NAME` varchar(200) DEFAULT NULL,
  `PRICE` int(11) DEFAULT NULL,
  `DISCOUNT_PRICE` int(11) DEFAULT NULL,
  `IMAGE_MAIN` text,
  `IMAGE_SECOND` text,
  `IMAGE_THIRD` text,
  `PROMOTION` text,
  `SHORT_DESC` text,
  `DETAILS` text,
  `IS_TYPE_PRIORITY` tinyint(1) DEFAULT '0',
  `IS_SUBTYPE_PRIORITY` tinyint(1) DEFAULT '0',
  `IS_HOT` tinyint(1) DEFAULT '0',
  `COLOR` varchar(10) DEFAULT NULL,
  `MATERIAL` varchar(10) DEFAULT NULL,
  `ORIGIN` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product`
--

LOCK TABLES `product` WRITE;
/*!40000 ALTER TABLE `product` DISABLE KEYS */;
INSERT INTO `product` VALUES (2,1,NULL,'code12222','name',200000,190000,'/uploads/1420514601.jpg','/uploads/1420527441.jpg','/uploads/1420532218.jpg','kkmkmmkk','aaaaa','<p>bbb</p>',1,1,1,'nau','da','Trung Quoc'),(3,2,14,'11111','abc',190000,190000,'/uploads/1420611238.jpg',NULL,NULL,NULL,'','<p><br></p>',1,1,1,'','',''),(4,2,14,'123','ccccdddddddd',100000,NULL,'/uploads/1420775236.jpg',NULL,NULL,'','','<p><br></p>',1,1,1,'','','');
/*!40000 ALTER TABLE `product` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_type`
--

DROP TABLE IF EXISTS `product_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product_type` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `NAME` varchar(45) DEFAULT NULL,
  `PARENT_ID` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_type`
--

LOCK TABLES `product_type` WRITE;
/*!40000 ALTER TABLE `product_type` DISABLE KEYS */;
INSERT INTO `product_type` VALUES (1,'Giày',NULL),(2,'Ví da',NULL),(3,'Thắt lưng',NULL),(4,'Áo da',NULL),(5,'Cặp da',NULL),(6,'Phụ kiện',NULL),(7,'Dịch vụ đồ da',NULL),(8,'Giày lười',1),(9,'Giày buộc dây',1),(10,'Giày thể thao',1),(11,'Sandal',1),(12,'Ví ngang',2),(13,'Ví đứng',2),(14,'Ví danh thiếp',2),(15,'Ví hộ chiếu',2),(16,'Cặp đeo chéo',5),(17,'Cặp xách tay',5);
/*!40000 ALTER TABLE `product_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `session`
--

DROP TABLE IF EXISTS `session`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `session` (
  `ID` char(32) NOT NULL,
  `NAME` char(32) DEFAULT NULL,
  `MODIFIED` int(11) DEFAULT NULL,
  `LIFETIME` int(11) DEFAULT NULL,
  `DATA` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `session`
--

LOCK TABLES `session` WRITE;
/*!40000 ALTER TABLE `session` DISABLE KEYS */;
INSERT INTO `session` VALUES ('6s532rqa9eud7vv7u7isrilvl0',NULL,1420452634,864000,'Zend_Auth|a:1:{s:7:\"storage\";O:8:\"stdClass\":5:{s:2:\"ID\";s:1:\"1\";s:4:\"NAME\";N;s:9:\"USER_NAME\";s:5:\"admin\";s:8:\"PASSWORD\";s:5:\"admin\";s:4:\"ROLE\";s:1:\"0\";}}'),('44p1uk6ohtnis65kgqss8url10',NULL,1420624875,864000,'Zend_Auth|a:1:{s:7:\"storage\";O:8:\"stdClass\":5:{s:2:\"ID\";s:1:\"1\";s:4:\"NAME\";N;s:9:\"USER_NAME\";s:5:\"admin\";s:8:\"PASSWORD\";s:5:\"admin\";s:4:\"ROLE\";s:1:\"0\";}}'),('rge1lv4qbfoq3fmpb598e4mri4',NULL,1420611355,864000,'userCartSession|a:0:{}'),('f2h8fbi9nc39q3ok58ohgt8na6',NULL,1420714172,864000,'Zend_Auth|a:1:{s:7:\"storage\";O:8:\"stdClass\":5:{s:2:\"ID\";s:1:\"1\";s:4:\"NAME\";N;s:9:\"USER_NAME\";s:5:\"admin\";s:8:\"PASSWORD\";s:5:\"admin\";s:4:\"ROLE\";s:1:\"0\";}}userCartSession|a:1:{i:2;a:4:{s:4:\"name\";s:4:\"name\";s:8:\"quantity\";i:1;s:5:\"price\";s:6:\"200000\";s:14:\"discount_price\";s:6:\"190000\";}}'),('56u0pl7g5liv9c0skmqpgp20m0',NULL,1420714608,864000,''),('rfpovi1givmovkjkj2vuglhm67',NULL,1420795763,864000,'Zend_Auth|a:1:{s:7:\"storage\";O:8:\"stdClass\":5:{s:2:\"ID\";s:1:\"1\";s:4:\"NAME\";N;s:9:\"USER_NAME\";s:5:\"admin\";s:8:\"PASSWORD\";s:5:\"admin\";s:4:\"ROLE\";s:1:\"0\";}}'),('1n361g22n0iu0huhth7uu1jhi1',NULL,1420855637,864000,''),('fnsulor512v9leqhokperkiu76',NULL,1420855963,864000,''),('mkf70nu43q0lucidka1jrlh6g0',NULL,1420855785,864000,''),('2c77ol7cv2qcipugp0os9u9n57',NULL,1420855985,300,''),('rgkhtc1i3asakuh2ogcut12dr6',NULL,1421920655,300,'Zend_Auth|a:1:{s:7:\"storage\";O:8:\"stdClass\":5:{s:2:\"ID\";s:1:\"1\";s:4:\"NAME\";N;s:9:\"USER_NAME\";s:5:\"admin\";s:8:\"PASSWORD\";s:5:\"admin\";s:4:\"ROLE\";s:1:\"0\";}}'),('eq97a5ih1hjcg3130vpm5vcf67',NULL,1421920633,300,'');
/*!40000 ALTER TABLE `session` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `NAME` varchar(45) DEFAULT NULL,
  `USER_NAME` varchar(20) NOT NULL,
  `PASSWORD` varchar(45) NOT NULL,
  `ROLE` tinyint(11) DEFAULT '0',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,NULL,'admin','admin',0),(2,NULL,'admin_product','678',1),(3,NULL,'admin_order','admin_order',2),(4,NULL,'admin_news','admin_news',3);
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

-- Dump completed on 2015-01-22 17:01:27
