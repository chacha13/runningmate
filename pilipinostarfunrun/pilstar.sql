-- phpMyAdmin SQL Dump
-- version 2.7.0-pl2
-- http://www.phpmyadmin.net
-- 
-- Host: localhost
-- Generation Time: Apr 06, 2010 at 09:35 AM
-- Server version: 5.0.18
-- PHP Version: 5.1.2
-- 
-- Database: `pilstar`
-- 

-- --------------------------------------------------------

-- 
-- Table structure for table `runners`
-- 

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
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `runners`
-- 

