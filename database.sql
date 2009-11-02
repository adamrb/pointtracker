-- phpMyAdmin SQL Dump
-- version 3.0.0
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 02, 2009 at 04:03 PM
-- Server version: 5.0.51
-- PHP Version: 5.2.4-2ubuntu5.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `Tracker`
--

-- --------------------------------------------------------

--
-- Table structure for table `Daily_Food`
--

CREATE TABLE IF NOT EXISTS `Daily_Food` (
  `ID` int(11) NOT NULL auto_increment,
  `NAME` text NOT NULL,
  `Calories` decimal(10,0) NOT NULL,
  `Fat` decimal(10,0) NOT NULL,
  `Fiber` decimal(10,0) NOT NULL,
  `Servings` int(11) NOT NULL default '1',
  `Points` int(11) NOT NULL,
  `Date_Entered` date default NULL,
  `Timestamp` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `User` text NOT NULL,
  `Type` text NOT NULL,
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=448 ;

-- --------------------------------------------------------

--
-- Table structure for table `Profile`
--

CREATE TABLE IF NOT EXISTS `Profile` (
  `Sex` int(11) NOT NULL,
  `Age` int(11) NOT NULL,
  `Height` int(11) NOT NULL,
  `Weight` int(11) NOT NULL,
  `TRWeight` int(11) NOT NULL,
  `Activity` int(11) NOT NULL,
  `Weekly` int(11) NOT NULL,
  `Modifier` int(11) NOT NULL,
  `Goal` int(11) NOT NULL,
  `User` text NOT NULL,
  `Startday` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Saved_Food`
--

CREATE TABLE IF NOT EXISTS `Saved_Food` (
  `ID` int(11) NOT NULL auto_increment,
  `NAME` text NOT NULL,
  `Calories` decimal(10,0) NOT NULL,
  `Fat` decimal(10,0) NOT NULL,
  `Fiber` decimal(10,0) NOT NULL,
  `Points` decimal(10,0) NOT NULL,
  `User` text NOT NULL,
  `Type` text NOT NULL,
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=220 ;

-- --------------------------------------------------------

--
-- Table structure for table `Snack_Types`
--

CREATE TABLE IF NOT EXISTS `Snack_Types` (
  `ID` int(11) NOT NULL auto_increment,
  `Name` text NOT NULL,
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10000 ;

-- --------------------------------------------------------

--
-- Table structure for table `Twitter`
--

CREATE TABLE IF NOT EXISTS `Twitter` (
  `User` text NOT NULL,
  `TWUsername` text NOT NULL,
  `TWPass` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `First_Name` text,
  `Last_Name` text,
  `username` varchar(20) NOT NULL,
  `password` varchar(32) NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=24 ;

-- --------------------------------------------------------

--
-- Table structure for table `Weight`
--

CREATE TABLE IF NOT EXISTS `Weight` (
  `User` text NOT NULL,
  `Weight` varchar(11) NOT NULL,
  `Date` date NOT NULL,
  FULLTEXT KEY `User` (`User`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `Withings`
--

CREATE TABLE IF NOT EXISTS `Withings` (
  `User` text NOT NULL,
  `Wuserid` text NOT NULL,
  `Wpubkey` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
