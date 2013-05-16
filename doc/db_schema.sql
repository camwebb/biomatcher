-- phpMyAdmin SQL Dump
-- version 2.11.9.4
-- http://www.phpmyadmin.net
--
-- Host: mysql.biomatcher.org
-- Generation Time: May 15, 2013 at 08:23 PM
-- Server version: 5.1.53
-- PHP Version: 5.2.17

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `biomatcher`
--

-- --------------------------------------------------------

--
-- Table structure for table `image`
--

CREATE TABLE IF NOT EXISTS `image` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `projectID` int(11) NOT NULL,
  `nameOri` varchar(200) NOT NULL,
  `md5sum` varchar(100) NOT NULL,
  `label` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `md5sum` (`projectID`,`md5sum`),
  UNIQUE KEY `nameOri` (`projectID`,`nameOri`),
  UNIQUE KEY `label` (`projectID`,`label`),
  KEY `projectID` (`projectID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=22 ;

-- --------------------------------------------------------

--
-- Table structure for table `match`
--

CREATE TABLE IF NOT EXISTS `match` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `imageA` int(11) NOT NULL,
  `imageB` int(11) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `matcher` int(11) NOT NULL,
  `same` enum('no','yes') NOT NULL,
  PRIMARY KEY (`id`),
  KEY `imageA` (`imageA`),
  KEY `imageB` (`imageB`),
  KEY `matcher` (`matcher`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `project`
--

CREATE TABLE IF NOT EXISTS `project` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userID` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `qcSet` enum('no','yes') NOT NULL DEFAULT 'no',
  PRIMARY KEY (`id`),
  KEY `userID` (`userID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(16) NOT NULL,
  `password` varchar(32) NOT NULL,
  `type` enum('supplier','consumer') NOT NULL,
  `email` varchar(100) NOT NULL,
  `name` varchar(200) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `image`
--
ALTER TABLE `image`
  ADD CONSTRAINT `image_ibfk_1` FOREIGN KEY (`projectID`) REFERENCES `project` (`id`);

--
-- Constraints for table `match`
--
ALTER TABLE `match`
  ADD CONSTRAINT `match_ibfk_1` FOREIGN KEY (`imageA`) REFERENCES `image` (`id`),
  ADD CONSTRAINT `match_ibfk_2` FOREIGN KEY (`imageB`) REFERENCES `image` (`id`),
  ADD CONSTRAINT `match_ibfk_3` FOREIGN KEY (`matcher`) REFERENCES `user` (`id`);

--
-- Constraints for table `project`
--
ALTER TABLE `project`
  ADD CONSTRAINT `project_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `user` (`id`);
