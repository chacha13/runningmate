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

