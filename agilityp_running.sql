-- MySQL dump 10.9
--
-- Host: localhost    Database: agilityp_running
-- ------------------------------------------------------
-- Server version	4.1.22-standard

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `chat`
--

DROP TABLE IF EXISTS `chat`;
CREATE TABLE `chat` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `from` varchar(255) NOT NULL default '',
  `to` varchar(255) NOT NULL default '',
  `message` text NOT NULL,
  `sent` datetime NOT NULL default '0000-00-00 00:00:00',
  `recd` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `chat`
--

LOCK TABLES `chat` WRITE;
/*!40000 ALTER TABLE `chat` DISABLE KEYS */;
INSERT INTO `chat` (`id`, `from`, `to`, `message`, `sent`, `recd`) VALUES (9,'96','shila','addasdsad','2010-03-16 15:07:00',0);
/*!40000 ALTER TABLE `chat` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cometchat`
--

DROP TABLE IF EXISTS `cometchat`;
CREATE TABLE `cometchat` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `from` varchar(255) NOT NULL default '',
  `to` varchar(255) NOT NULL default '',
  `message` text NOT NULL,
  `sent` int(10) unsigned NOT NULL default '0',
  `read` int(10) unsigned NOT NULL default '0',
  `direction` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `to` (`to`),
  KEY `from` (`from`),
  KEY `direction` (`direction`),
  KEY `read` (`read`),
  KEY `sent` (`sent`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cometchat`
--

LOCK TABLES `cometchat` WRITE;
/*!40000 ALTER TABLE `cometchat` DISABLE KEYS */;
/*!40000 ALTER TABLE `cometchat` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cometchat_chatroommessages`
--

DROP TABLE IF EXISTS `cometchat_chatroommessages`;
CREATE TABLE `cometchat_chatroommessages` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `userid` int(10) unsigned NOT NULL default '0',
  `chatroomid` int(10) unsigned NOT NULL default '0',
  `message` text NOT NULL,
  `sent` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `userid` (`userid`),
  KEY `chatroomid` (`chatroomid`),
  KEY `sent` (`sent`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cometchat_chatroommessages`
--

LOCK TABLES `cometchat_chatroommessages` WRITE;
/*!40000 ALTER TABLE `cometchat_chatroommessages` DISABLE KEYS */;
/*!40000 ALTER TABLE `cometchat_chatroommessages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cometchat_chatrooms`
--

DROP TABLE IF EXISTS `cometchat_chatrooms`;
CREATE TABLE `cometchat_chatrooms` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `lastactivity` int(10) unsigned NOT NULL default '0',
  `createdby` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `lastactivity` (`lastactivity`),
  KEY `createdby` (`createdby`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cometchat_chatrooms`
--

LOCK TABLES `cometchat_chatrooms` WRITE;
/*!40000 ALTER TABLE `cometchat_chatrooms` DISABLE KEYS */;
/*!40000 ALTER TABLE `cometchat_chatrooms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cometchat_chatrooms_users`
--

DROP TABLE IF EXISTS `cometchat_chatrooms_users`;
CREATE TABLE `cometchat_chatrooms_users` (
  `userid` int(10) unsigned NOT NULL default '0',
  `chatroomid` int(10) unsigned NOT NULL default '0',
  `lastactivity` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`userid`),
  KEY `chatroomid` (`chatroomid`),
  KEY `lastactivity` (`lastactivity`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cometchat_chatrooms_users`
--

LOCK TABLES `cometchat_chatrooms_users` WRITE;
/*!40000 ALTER TABLE `cometchat_chatrooms_users` DISABLE KEYS */;
/*!40000 ALTER TABLE `cometchat_chatrooms_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cometchat_old`
--

DROP TABLE IF EXISTS `cometchat_old`;
CREATE TABLE `cometchat_old` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `from` varchar(255) NOT NULL default '',
  `to` varchar(255) NOT NULL default '',
  `message` text NOT NULL,
  `sent` int(10) unsigned NOT NULL default '0',
  `read` int(10) unsigned NOT NULL default '0',
  `direction` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `to` (`to`),
  KEY `from` (`from`),
  KEY `direction` (`direction`),
  KEY `read` (`read`),
  KEY `sent` (`sent`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cometchat_old`
--

LOCK TABLES `cometchat_old` WRITE;
/*!40000 ALTER TABLE `cometchat_old` DISABLE KEYS */;
/*!40000 ALTER TABLE `cometchat_old` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cometchat_status`
--

DROP TABLE IF EXISTS `cometchat_status`;
CREATE TABLE `cometchat_status` (
  `userid` int(10) unsigned NOT NULL default '0',
  `message` text,
  `status` varchar(10) default NULL,
  PRIMARY KEY  (`userid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cometchat_status`
--

LOCK TABLES `cometchat_status` WRITE;
/*!40000 ALTER TABLE `cometchat_status` DISABLE KEYS */;
/*!40000 ALTER TABLE `cometchat_status` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cometchat_status_old`
--

DROP TABLE IF EXISTS `cometchat_status_old`;
CREATE TABLE `cometchat_status_old` (
  `userid` int(10) unsigned NOT NULL default '0',
  `message` text,
  `status` varchar(10) default NULL,
  PRIMARY KEY  (`userid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cometchat_status_old`
--

LOCK TABLES `cometchat_status_old` WRITE;
/*!40000 ALTER TABLE `cometchat_status_old` DISABLE KEYS */;
/*!40000 ALTER TABLE `cometchat_status_old` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `friendships`
--

DROP TABLE IF EXISTS `friendships`;
CREATE TABLE `friendships` (
  `id` int(11) NOT NULL auto_increment,
  `user_id` int(11) default NULL,
  `friend_id` int(11) default NULL,
  `status` varchar(255) default NULL,
  `created_at` datetime default NULL,
  `accepted_at` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `friendships`
--

LOCK TABLES `friendships` WRITE;
/*!40000 ALTER TABLE `friendships` DISABLE KEYS */;
INSERT INTO `friendships` (`id`, `user_id`, `friend_id`, `status`, `created_at`, `accepted_at`) VALUES (7,96,97,'pending','0000-00-00 00:00:00','0000-00-00 00:00:00');
/*!40000 ALTER TABLE `friendships` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `markers`
--

DROP TABLE IF EXISTS `markers`;
CREATE TABLE `markers` (
  `id` int(11) NOT NULL auto_increment,
  `lat` float(10,6) NOT NULL default '0.000000',
  `lng` float(10,6) NOT NULL default '0.000000',
  `datetime` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `markers`
--

LOCK TABLES `markers` WRITE;
/*!40000 ALTER TABLE `markers` DISABLE KEYS */;
INSERT INTO `markers` (`id`, `lat`, `lng`, `datetime`) VALUES (11,14.709831,121.055420,'0000-00-00 00:00:00');
/*!40000 ALTER TABLE `markers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `message_feed_comments`
--

DROP TABLE IF EXISTS `message_feed_comments`;
CREATE TABLE `message_feed_comments` (
  `id` int(11) NOT NULL auto_increment,
  `post_id` int(11) default NULL,
  `user_id` int(11) default NULL,
  `message` text,
  `created_at` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=76 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `message_feed_comments`
--

LOCK TABLES `message_feed_comments` WRITE;
/*!40000 ALTER TABLE `message_feed_comments` DISABLE KEYS */;
/*!40000 ALTER TABLE `message_feed_comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `message_feeds`
--

DROP TABLE IF EXISTS `message_feeds`;
CREATE TABLE `message_feeds` (
  `id` int(11) NOT NULL auto_increment,
  `user_id` int(11) default NULL,
  `message` text,
  `created_at` timestamp NULL default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=213 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `message_feeds`
--

LOCK TABLES `message_feeds` WRITE;
/*!40000 ALTER TABLE `message_feeds` DISABLE KEYS */;
/*!40000 ALTER TABLE `message_feeds` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `message_feeds_like`
--

DROP TABLE IF EXISTS `message_feeds_like`;
CREATE TABLE `message_feeds_like` (
  `post_id` int(11) default NULL,
  `user_id` int(11) default NULL,
  `like_id` int(11) NOT NULL default '0',
  PRIMARY KEY  (`like_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `message_feeds_like`
--

LOCK TABLES `message_feeds_like` WRITE;
/*!40000 ALTER TABLE `message_feeds_like` DISABLE KEYS */;
/*!40000 ALTER TABLE `message_feeds_like` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `photos`
--

DROP TABLE IF EXISTS `photos`;
CREATE TABLE `photos` (
  `id` int(11) NOT NULL auto_increment,
  `user_id` int(11) default NULL,
  `filename` varchar(255) default NULL,
  `type` varchar(255) default NULL,
  `thumbnail` varchar(255) default NULL,
  `caption` text,
  `created_at` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `photos`
--

LOCK TABLES `photos` WRITE;
/*!40000 ALTER TABLE `photos` DISABLE KEYS */;
/*!40000 ALTER TABLE `photos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `runners`
--

DROP TABLE IF EXISTS `runners`;
CREATE TABLE `runners` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `last_name` varchar(45) default NULL,
  `first_name` varchar(45) default NULL,
  `middle_name` varchar(45) default NULL,
  `gender` varchar(45) default NULL,
  `birthdate` varchar(45) default NULL,
  `age` int(10) unsigned default NULL,
  `nationality` varchar(45) default NULL,
  `contactno` varchar(45) default NULL,
  `email` varchar(45) default NULL,
  `incase` varchar(100) default NULL,
  `singlet_size` varchar(45) default NULL,
  `type_of_race` varchar(45) default NULL,
  `created_at` datetime default NULL,
  `address` varchar(200) default NULL,
  `race_kits_claim` varchar(255) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `runners`
--

LOCK TABLES `runners` WRITE;
/*!40000 ALTER TABLE `runners` DISABLE KEYS */;
INSERT INTO `runners` (`id`, `last_name`, `first_name`, `middle_name`, `gender`, `birthdate`, `age`, `nationality`, `contactno`, `email`, `incase`, `singlet_size`, `type_of_race`, `created_at`, `address`, `race_kits_claim`) VALUES (4,'AMAHIT','MYLENE','DELGADO','Female','2010-07-75',34,'FILIPINO','5276852','maiamahit@yahoo.com','AROLAS AMAHIT JR.','M','5K','2010-04-12 13:51:33','61A,NARRA ST. CAMELLA v PULANGLUPA DOS LAS PINAS CITY',NULL),(5,'Reyes','Julie','Zacarias','Female','July 13, 1965',44,'Filipino','09189086560','juliereyes@philstar.com.ph','5276665','S','10K','2010-04-12 13:51:42','Philippine STAR, roberto S. Oca cor 13Th Streets, Port Area, Manila',NULL),(6,'Mendoza','Aloysius','Delloson','Male','12/12/1976',33,'Filipino','09178871276','aloys.mendoza@gmail.com','Jun Mendoza 09087387387','L','10K','2010-04-13 12:36:43','5 May St. Cong Vill Proj 8 Q.C.',NULL),(9,'Celis','Rhodora','Arellano','Female','1975-11-10',34,'Filipino','0928-5247140','dodiecelis@yahoo.com','Vincent Celis 0922-8610220','L','5K','2010-04-14 14:58:11','#100 C. Raymundo Ave., Maybunga, Pasig City','CHRIS SPORTS SM MEGAMALL Bldg. B Lower Ground Floor'),(10,'Celis','Vincent','Escalante','Male','1971-01-22',39,'Filipino','0922-8610220','dodiecelis@yahoo.com','Rhodora Celis 0928-5247140','L','5K','2010-04-14 15:00:11','#100 C. Raymundo Ave., Maybunga, Pasig City','CHRIS SPORTS SM MEGAMALL Bldg. B Lower Ground Floor'),(11,'CARANTO','JESUS JR','FRIAS','Male','1966-08-06',43,'FILIPINO','09173295243','jfcaranto@yahoo.com','Jane Caranto 09274874054','XL','10K','2010-04-14 16:13:21','#23 V. Ilustre Street  , Brgy. Don Manuel Quezon City','Boni High Street, Global City'),(12,'Beley Jr.','Mario','Medina','Male','01/18/1952',58,'Filipino','+639194551547','francissferrer@gmail.com','Lourdes Z. Cruz/University Registrar','XL','10K','2010-04-14 16:27:38','c/o University of Pangasinan - PHINMA, Arellano Street, Dagupan City','CHRIS SPORTS SM MEGAMALL Bldg. B Lower Ground Floor'),(14,'Alindada','Anthony Mark','Sacanle','Male','1979-05-01',30,'Filipino','639228864983','bongalindada@gmail.com','09202884860','L','5K','2010-04-15 14:03:53','8 King Christopher St., Bagbag, Novaliches, Quezon City','CHRIS SPORTS SM NORTH EDSA F-104 Ground Floor, Quezon City'),(15,'Binas','Arnold','Ongyot','Male','11,25,1973',36,'filipino','09216390421','none','narcisa Vnas 71244146','L','5K','2010-04-16 21:56:21','61 banawe St. Q.C','CHRIS SPORTS SM NORTH EDSA F-104 Ground Floor, Quezon City'),(16,'Carlos','Bettinna','Pineda','Female','1987-12-25',22,'Filipino','09178914109','bitecarlos@gmail.com','Irene Pineda 09178987412','M','3K','2010-04-17 14:10:08','#41 Sgt. Esguerra El Jardin del Presidente Condos. Q.C.','R.O.X. Recreational Outdoor Exchange'),(17,'Salise','Joan','Gonzales','Female','1983-08-24',26,'Filipino','09178130824','joansalise@gmail.com','Bogs Arnaldo- 09175940861','M','5K','2010-04-19 09:02:05','Unit 424, GA Tower 1, EDSA cor Boni Ave., Mandaluyong City','7'),(18,'Aguilar','Walter','Juanir','Male','1975-10-07',34,'Filipino','0906-5740042','wowie0775@yahoo.com  or  aguilarw54@yahoo.com','Romeo C. Aguilar/0906-4628069','M','3K','2010-04-19 10:07:47','Blk. 22 Lot 2 Brgy.Victoria Dasmarinas City, Cavite, Philippines','CHRIS SPORTS MALL OF ASIA Main mall 2nd Floor Bay Blvd \r\nManila'),(19,'Boquiron','Nonon','Arines','Male','1970-10-16',39,'Filipino','+63927-751-9127','nonon_boquiron@sil.org','EJ Boquiron 0927-918-2112','S','10K','2010-04-19 13:33:37','12 Big Horseshoe Drive, Horseshoe Village, QC','R.O.X. Recreational Outdoor Exchange');
/*!40000 ALTER TABLE `runners` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `firstname` varchar(255) default NULL,
  `lastname` varchar(255) default NULL,
  `email` varchar(255) default NULL,
  `password` varchar(255) default NULL,
  `activation_code` varchar(255) default NULL,
  `created_at` datetime default NULL,
  `ip` int(11) default NULL,
  `dt` timestamp NULL default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `ip` (`ip`)
) ENGINE=MyISAM AUTO_INCREMENT=98 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

