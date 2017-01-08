-- phpMyAdmin SQL Dump
-- version 2.10.1
-- http://www.phpmyadmin.net
-- 
-- Host: localhost
-- Generation Time: Oct 15, 2012 at 05:26 AM
-- Server version: 5.1.53
-- PHP Version: 5.2.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- 
-- Database: `elgg`
-- 

-- --------------------------------------------------------

-- 
-- Table structure for table `elgg_paypal`
-- 

DROP TABLE IF EXISTS `elgg_paypal`;
CREATE TABLE `elgg_paypal` (
  `transactionid` int(11) NOT NULL AUTO_INCREMENT,
  `causeid` int(11) DEFAULT NULL,
  `konnectorid` varchar(255) DEFAULT NULL,
  `donorid` int(11) DEFAULT NULL,
  `amount` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `anonymous` int(11) DEFAULT NULL,
  `paypal` varchar(255) DEFAULT NULL,
  `paypaltime` int(11) DEFAULT NULL,
  `card_type` varchar(255) DEFAULT NULL,
  `card_no` varchar(255) DEFAULT NULL,
  `card_expiry` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `address` tinytext,
  `status` int(11) DEFAULT '0',
  PRIMARY KEY (`transactionid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `elgg_paypal`
-- 

