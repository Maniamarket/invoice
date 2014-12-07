-- MySQL dump 10.13  Distrib 5.5.40, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: invoice
-- ------------------------------------------------------
-- Server version	5.5.40-0ubuntu0.14.04.1

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
-- Table structure for table `auth_assignment`
--

DROP TABLE IF EXISTS `auth_assignment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auth_assignment` (
  `item_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`item_name`,`user_id`),
  CONSTRAINT `auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auth_assignment`
--

LOCK TABLES `auth_assignment` WRITE;
/*!40000 ALTER TABLE `auth_assignment` DISABLE KEYS */;
INSERT INTO `auth_assignment` VALUES ('admin','3',1418052545),('manager','2',1418052545),('superadmin','4',1418052545),('user','1',1418052545);
/*!40000 ALTER TABLE `auth_assignment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `auth_item`
--

DROP TABLE IF EXISTS `auth_item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auth_item` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `type` int(11) NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `rule_name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `data` text COLLATE utf8_unicode_ci,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`),
  KEY `rule_name` (`rule_name`),
  KEY `idx-auth_item-type` (`type`),
  CONSTRAINT `auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auth_item`
--

LOCK TABLES `auth_item` WRITE;
/*!40000 ALTER TABLE `auth_item` DISABLE KEYS */;
INSERT INTO `auth_item` VALUES ('admin',1,'Admin','group',NULL,1418052545,1418052545),('manager',1,'Manager','group',NULL,1418052545,1418052545),('superadmin',1,'Superadmin','group',NULL,1418052545,1418052545),('user',1,'User','group',NULL,1418052545,1418052545);
/*!40000 ALTER TABLE `auth_item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `auth_item_child`
--

DROP TABLE IF EXISTS `auth_item_child`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auth_item_child` (
  `parent` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `child` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`),
  CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auth_item_child`
--

LOCK TABLES `auth_item_child` WRITE;
/*!40000 ALTER TABLE `auth_item_child` DISABLE KEYS */;
INSERT INTO `auth_item_child` VALUES ('superadmin','admin'),('admin','manager'),('manager','user');
/*!40000 ALTER TABLE `auth_item_child` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `auth_rule`
--

DROP TABLE IF EXISTS `auth_rule`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auth_rule` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `data` text COLLATE utf8_unicode_ci,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auth_rule`
--

LOCK TABLES `auth_rule` WRITE;
/*!40000 ALTER TABLE `auth_rule` DISABLE KEYS */;
INSERT INTO `auth_rule` VALUES ('group','O:29:\"app\\components\\rbac\\GroupRule\":3:{s:4:\"name\";s:5:\"group\";s:9:\"createdAt\";i:1418052545;s:9:\"updatedAt\";i:1418052545;}',1418052545,1418052545);
/*!40000 ALTER TABLE `auth_rule` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `client`
--

DROP TABLE IF EXISTS `client`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `client` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `email_confirm_token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `auth_key` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `def_lang_id` int(11) NOT NULL DEFAULT '1',
  `country` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `city` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `street` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `post_index` int(11) DEFAULT NULL,
  `phone` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_client_user_id` (`user_id`),
  KEY `idx_client_email` (`email`),
  KEY `idx_client_def_lang_id` (`def_lang_id`),
  KEY `idx_company_email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `client`
--

LOCK TABLES `client` WRITE;
/*!40000 ALTER TABLE `client` DISABLE KEYS */;
INSERT INTO `client` VALUES (1,'Fedorov',4,'1@mu.ru','','$2y$13$iLuCWhxjnNoQ7E9bm4zlRe5g6okYUaSCfm8hJj11Iyv3gIL2qDTVS','','LeKPQcSJPBrU9EsnTRg9rI8922OS7q6q',1418052545,1418052545,1,'Russia','Moscwa','',2222,'','Ys7C'),(2,'Alex',4,'2@mu.ru','','$2y$13$8TnqmIT1jhnfjZiRdj8TFubVn8pC2KQNNgJoD80fhjPHCWWKYZ5Z2','','1RDxdreA4EvNZBvfPb2Ad1Rc0h8WhMru',1418052545,1418052545,1,'','','',NULL,'','N6t'),(3,'Belikov',4,'3@mu.ru','','$2y$13$X.G4KFKIgbkWqFcDDXQGq.sn6xnanKNaDsuZ5kjEP3GW15HI1vAKO','','BJCNW1HZeCltZ7LrDHoAooDxbj0UBywf',1418052545,1418052545,1,'','','',NULL,'','iud');
/*!40000 ALTER TABLE `client` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `clients`
--

DROP TABLE IF EXISTS `clients`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `clients` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `inn` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `clients`
--

LOCK TABLES `clients` WRITE;
/*!40000 ALTER TABLE `clients` DISABLE KEYS */;
/*!40000 ALTER TABLE `clients` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `company`
--

DROP TABLE IF EXISTS `company`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `company` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `logo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `country` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `street` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `post_index` int(11) DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `web_site` int(11) DEFAULT NULL,
  `mail` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `vat_number` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `activity` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `resp_person` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `company`
--

LOCK TABLES `company` WRITE;
/*!40000 ALTER TABLE `company` DISABLE KEYS */;
INSERT INTO `company` VALUES (1,'google','cat1.jpg','Russia','Moscow','Lenina 1',60000,'22222222',22,'22','22','22','22'),(2,'microsoft','',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(3,'gregsys','',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(4,'bmw','',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `company` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `currency`
--

DROP TABLE IF EXISTS `currency`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `currency` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `short_name` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `currency`
--

LOCK TABLES `currency` WRITE;
/*!40000 ALTER TABLE `currency` DISABLE KEYS */;
/*!40000 ALTER TABLE `currency` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `goods`
--

DROP TABLE IF EXISTS `goods`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `goods` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `invoice_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `measure_id` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `excise` decimal(10,2) DEFAULT NULL,
  `tax` decimal(4,2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `goods`
--

LOCK TABLES `goods` WRITE;
/*!40000 ALTER TABLE `goods` DISABLE KEYS */;
INSERT INTO `goods` VALUES (1,1,'Косоролики',1,1,10.00,NULL,18.00),(2,1,'Кособобики',1,1,11.30,NULL,18.00);
/*!40000 ALTER TABLE `goods` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `income`
--

DROP TABLE IF EXISTS `income`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `income` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `from` int(11) NOT NULL,
  `to` int(11) NOT NULL,
  `manager` float NOT NULL,
  `admin` float NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `income`
--

LOCK TABLES `income` WRITE;
/*!40000 ALTER TABLE `income` DISABLE KEYS */;
INSERT INTO `income` VALUES (1,1000,10000,1.5,1),(2,10000,100000,1.8,1.1),(3,100000,1000000,2,1.2),(4,1000000,10000000,2.5,1.5);
/*!40000 ALTER TABLE `income` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `invoice`
--

DROP TABLE IF EXISTS `invoice`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `invoice` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `company_id` int(11) NOT NULL DEFAULT '0',
  `service_id` int(11) NOT NULL DEFAULT '0',
  `price_service` decimal(10,2) NOT NULL DEFAULT '0.00',
  `count` int(11) NOT NULL,
  `vat` decimal(5,2) NOT NULL DEFAULT '0.00',
  `tax` decimal(5,2) NOT NULL DEFAULT '0.00',
  `discount` decimal(5,2) NOT NULL,
  `price` int(11) NOT NULL,
  `is_pay` tinyint(1) NOT NULL DEFAULT '0',
  `type` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_invoice_user` (`user_id`),
  KEY `idx_invoice_client` (`client_id`),
  KEY `idx_invoice_company` (`company_id`),
  KEY `idx_invoice_service` (`service_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `invoice`
--

LOCK TABLES `invoice` WRITE;
/*!40000 ALTER TABLE `invoice` DISABLE KEYS */;
INSERT INTO `invoice` VALUES (1,1,1,'2014-12-05','1',1,1,200.00,1,1.00,15.00,4.00,7,0,'1'),(2,1,1,'2014-12-05','1',1,1,500.00,1,1.00,40.00,10.00,10,1,'1'),(3,4,1,'2014-12-08','фактура1',1,1,0.00,1,1.00,1.00,1.00,0,0,NULL),(4,4,2,'2014-12-08','фактура2',1,1,0.00,1,1.00,1.00,1.00,0,1,NULL);
/*!40000 ALTER TABLE `invoice` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lang`
--

DROP TABLE IF EXISTS `lang`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lang` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lang`
--

LOCK TABLES `lang` WRITE;
/*!40000 ALTER TABLE `lang` DISABLE KEYS */;
INSERT INTO `lang` VALUES (1,'Russia'),(2,'English');
/*!40000 ALTER TABLE `lang` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `measures`
--

DROP TABLE IF EXISTS `measures`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `measures` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(3) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Код единицы измерения',
  `name` varchar(32) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Единица измерения',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `measures`
--

LOCK TABLES `measures` WRITE;
/*!40000 ALTER TABLE `measures` DISABLE KEYS */;
INSERT INTO `measures` VALUES (1,'796','шт'),(2,'166','кг');
/*!40000 ALTER TABLE `measures` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migration`
--

DROP TABLE IF EXISTS `migration`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migration`
--

LOCK TABLES `migration` WRITE;
/*!40000 ALTER TABLE `migration` DISABLE KEYS */;
INSERT INTO `migration` VALUES ('m000000_000000_base',1418052534),('m140506_102106_rbac_init',1418052545),('m141207_115424_init_bd',1418052545);
/*!40000 ALTER TABLE `migration` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payment`
--

DROP TABLE IF EXISTS `payment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `payment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payment`
--

LOCK TABLES `payment` WRITE;
/*!40000 ALTER TABLE `payment` DISABLE KEYS */;
INSERT INTO `payment` VALUES (1,'Bank card'),(2,'PayPal'),(3,'Банковский перевод');
/*!40000 ALTER TABLE `payment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payment_history`
--

DROP TABLE IF EXISTS `payment_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `payment_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `amount` float NOT NULL,
  `currency` char(3) DEFAULT 'EUR',
  `curs` float DEFAULT NULL,
  `equivalent` float DEFAULT NULL,
  `description` varchar(128) DEFAULT NULL,
  `date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `payment_system_id` int(11) NOT NULL,
  `complete` tinyint(1) DEFAULT '0',
  `type` int(4) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `pay_sys_id` (`payment_system_id`),
  KEY `balance` (`user_id`,`complete`),
  KEY `type` (`type`),
  CONSTRAINT `fk_psid_rt1` FOREIGN KEY (`payment_system_id`) REFERENCES `payment_system` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_uid_rt0` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payment_history`
--

LOCK TABLES `payment_history` WRITE;
/*!40000 ALTER TABLE `payment_history` DISABLE KEYS */;
/*!40000 ALTER TABLE `payment_history` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payment_old`
--

DROP TABLE IF EXISTS `payment_old`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `payment_old` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(40) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payment_old`
--

LOCK TABLES `payment_old` WRITE;
/*!40000 ALTER TABLE `payment_old` DISABLE KEYS */;
/*!40000 ALTER TABLE `payment_old` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payment_system`
--

DROP TABLE IF EXISTS `payment_system`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `payment_system` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `model` varchar(128) DEFAULT NULL,
  `active` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payment_system`
--

LOCK TABLES `payment_system` WRITE;
/*!40000 ALTER TABLE `payment_system` DISABLE KEYS */;
/*!40000 ALTER TABLE `payment_system` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sellers`
--

DROP TABLE IF EXISTS `sellers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sellers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Наименование продавца',
  `address` varchar(128) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Адрес продавца',
  `inn` varchar(12) COLLATE utf8_unicode_ci NOT NULL COMMENT 'ИНН продавца',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sellers`
--

LOCK TABLES `sellers` WRITE;
/*!40000 ALTER TABLE `sellers` DISABLE KEYS */;
INSERT INTO `sellers` VALUES (1,'ЗАО \"Все продам\"','г. Неизвестный ул. Без имени д.112','786534652985'),(2,'ООО \"Рога и копыта\"','г. Приморск ул. Ленина д.2','754642308479');
/*!40000 ALTER TABLE `sellers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `service`
--

DROP TABLE IF EXISTS `service`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `service` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `service`
--

LOCK TABLES `service` WRITE;
/*!40000 ALTER TABLE `service` DISABLE KEYS */;
INSERT INTO `service` VALUES (1,'service1'),(2,'service2'),(3,'Сервис3');
/*!40000 ALTER TABLE `service` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `setting`
--

DROP TABLE IF EXISTS `setting`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `setting` (
  `user_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no',
  `credit` decimal(12,3) NOT NULL DEFAULT '0.000',
  `def_vat_id` int(11) NOT NULL DEFAULT '0',
  `def_company_id` int(11) NOT NULL DEFAULT '0',
  `def_lang_id` int(11) NOT NULL DEFAULT '0',
  `bank_code` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no',
  `account_number` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `last_login` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `is_on` tinyint(1) NOT NULL DEFAULT '1',
  `country` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `city` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `street` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `post_index` int(11) DEFAULT NULL,
  `phone` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `web_site` tinyint(1) DEFAULT NULL,
  `surtax` decimal(5,2) DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  KEY `idx_setting_def_vat_id` (`def_vat_id`),
  KEY `idx_setting_def_company_id` (`def_company_id`),
  KEY `idx_setting_def_lang_id` (`def_lang_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `setting`
--

LOCK TABLES `setting` WRITE;
/*!40000 ALTER TABLE `setting` DISABLE KEYS */;
INSERT INTO `setting` VALUES (1,'no',0.000,3,2,2,'1111111111','1111111111','2014-12-01 00:00:00',1,'yyyy','yyy','yyy',999999,'67895909',0,5.00),(2,'no',0.000,1,1,1,'no','no','2014-12-04 12:39:39',1,'qq','qq','qq',11,'qq',0,5.00),(3,'aaaaa',0.000,1,1,1,'no','no','2014-12-04 09:21:05',1,'qq','qq','qq',11111,'qq',0,5.00),(4,'aaaaa',0.000,1,1,1,'no','no','2014-12-04 09:21:05',1,'qq','qq','qq',11111,'qq',0,5.00),(6,'',0.000,0,0,0,'no','no','2014-12-07 11:39:47',1,'','','',NULL,'',NULL,5.00),(7,'',0.000,1,1,1,'no','no','2014-12-07 15:05:00',1,'','','',NULL,'',NULL,5.00),(8,'',0.000,0,0,0,'no','no','2014-12-07 16:20:27',1,'','','',NULL,'',NULL,5.00),(9,'',0.000,0,0,0,'no','no','2014-12-07 16:31:05',1,'','','',NULL,'',NULL,5.00);
/*!40000 ALTER TABLE `setting` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `surtax`
--

DROP TABLE IF EXISTS `surtax`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `surtax` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `percent` decimal(5,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `surtax`
--

LOCK TABLES `surtax` WRITE;
/*!40000 ALTER TABLE `surtax` DISABLE KEYS */;
INSERT INTO `surtax` VALUES (1,20.00);
/*!40000 ALTER TABLE `surtax` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `translit`
--

DROP TABLE IF EXISTS `translit`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `translit` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ид транслитерации',
  `from_lang_id` int(11) NOT NULL COMMENT 'ид языка оригинала',
  `to_lang_id` int(11) NOT NULL COMMENT 'ид языка на который переводим',
  `from_symbol` varchar(8) NOT NULL COMMENT 'символ оригинал',
  `to_symbol` varchar(8) NOT NULL COMMENT 'символ результата',
  PRIMARY KEY (`id`),
  KEY `flang` (`from_lang_id`),
  KEY `tlang` (`to_lang_id`)
) ENGINE=InnoDB AUTO_INCREMENT=67 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `translit`
--

LOCK TABLES `translit` WRITE;
/*!40000 ALTER TABLE `translit` DISABLE KEYS */;
INSERT INTO `translit` VALUES (1,1,2,'а','a'),(2,1,2,'б','b'),(3,1,2,'в','v'),(4,1,2,'г','g'),(5,1,2,'д','d'),(6,1,2,'е','e'),(7,1,2,'ё','e'),(8,1,2,'ж','zh'),(9,1,2,'з','z'),(10,1,2,'и','i'),(11,1,2,'й','y'),(12,1,2,'к','k'),(13,1,2,'л','l'),(14,1,2,'м','m'),(15,1,2,'н','n'),(16,1,2,'о','o'),(17,1,2,'п','p'),(18,1,2,'р','r'),(19,1,2,'с','s'),(20,1,2,'т','t'),(21,1,2,'у','u'),(22,1,2,'ф','f'),(23,1,2,'х','h'),(24,1,2,'ц','c'),(25,1,2,'ч','ch'),(26,1,2,'ш','sh'),(27,1,2,'щ','sch'),(28,1,2,'ь','\''),(29,1,2,'ы','y'),(30,1,2,'ъ','\''),(31,1,2,'э','e'),(32,1,2,'ю','yu'),(33,1,2,'я','ya'),(34,1,2,'А','A'),(35,1,2,'Б','B'),(36,1,2,'В','V'),(37,1,2,'Г','G'),(38,1,2,'Д','D'),(39,1,2,'Е','E'),(40,1,2,'Ё','E'),(41,1,2,'Ж','Zh'),(42,1,2,'З','Z'),(43,1,2,'И','I'),(44,1,2,'Й','Y'),(45,1,2,'К','K'),(46,1,2,'Л','L'),(47,1,2,'М','M'),(48,1,2,'Н','N'),(49,1,2,'О','O'),(50,1,2,'П','P'),(51,1,2,'Р','R'),(52,1,2,'С','S'),(53,1,2,'Т','T'),(54,1,2,'У','U'),(55,1,2,'Ф','F'),(56,1,2,'Х','H'),(57,1,2,'Ц','C'),(58,1,2,'Ч','Ch'),(59,1,2,'Ш','Sh'),(60,1,2,'Щ','Sch'),(61,1,2,'Ь','\''),(62,1,2,'Ы','Y'),(63,1,2,'Ъ','\''),(64,1,2,'Э','E'),(65,1,2,'Ю','Yu'),(66,1,2,'Я','Ya');
/*!40000 ALTER TABLE `translit` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email_confirm_token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `auth_key` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_user_username` (`username`),
  KEY `idx_user_email` (`email`),
  KEY `idx_user_role` (`role`),
  KEY `idx_user_status` (`status`),
  KEY `idx_user_parent_id` (`parent_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'test','','$2y$13$B4DPxXs0/GKHt4Z81yiRM.DHwgr5tk4HNyorp1g8VmzWdDtEbMWJW','','test@mail.ru','','OSgDej5fe8zJdRy_N2AshqP3P2e5gTUL','user',10,1418052545,1418052545,0),(2,'manager','','$2y$13$Ir6j3GVK.Fdh0l7cM8fsGO2QHCKxTNoKKnCZGlqm25KFXwXdR5kTK','','manager@mail.ru','','0pIFtMFMleZ_CmZdK240ti2bNyJBH98L','manager',10,1418052545,1418052545,0),(3,'admin','','$2y$13$9dqaQK3viYvdoAAI0Oy0XuUqfiSJ0saJXM2qYQ2A0TzA1QFV56Q6.','','admin@mail.ru','','pI8Z6XtcXeUKQKEJoPYBazoP5-qo3zmv','admin',10,1418052545,1418052545,0),(4,'superadmin','','$2y$13$Kqo/vATU4BSO9XT.Xm.jNOz.kIaUBBhCsHm.WHfauI5ZGkDkrXMvK','','superadmin@mail.ru','','MqtOr8ySQ7k2QFMEN3KhX3QBOEw9fDVD','superadmin',10,1418052545,1418052545,0);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vat`
--

DROP TABLE IF EXISTS `vat`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `percent` int(3) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vat`
--

LOCK TABLES `vat` WRITE;
/*!40000 ALTER TABLE `vat` DISABLE KEYS */;
INSERT INTO `vat` VALUES (1,25),(2,26),(3,10),(4,15);
/*!40000 ALTER TABLE `vat` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-12-08 13:32:15
