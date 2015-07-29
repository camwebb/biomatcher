-- phpMyAdmin SQL Dump
-- version 3.3.10.4
-- http://www.phpmyadmin.net
--
-- Host: mysql.biomatcher.org
-- Waktu pembuatan: 21. Mei 2015 jam 03:22
-- Versi Server: 5.1.56
-- Versi PHP: 5.4.37

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `biomatcher`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `activate_tokens`
--

CREATE TABLE IF NOT EXISTS `activate_tokens` (
  `activate_token_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `activate_token_user_id` int(10) unsigned NOT NULL,
  `activate_token_site_id` int(11) NOT NULL,
  `activate_token_hash` char(64) NOT NULL,
  PRIMARY KEY (`activate_token_id`),
  UNIQUE KEY `activate_token_site_id` (`activate_token_site_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `image`
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
  KEY `projectID` (`projectID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `match`
--

CREATE TABLE IF NOT EXISTS `match` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `imageA` int(11) NOT NULL,
  `imageB` int(11) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `matcher` int(11) NOT NULL,
  `same` enum('no','yes') NOT NULL,
  `siteID` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `imageA` (`imageA`),
  KEY `imageB` (`imageB`),
  KEY `matcher` (`matcher`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `project`
--

CREATE TABLE IF NOT EXISTS `project` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userID` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `qcSet` enum('no','yes') NOT NULL DEFAULT 'no',
  PRIMARY KEY (`id`),
  KEY `userID` (`userID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `site`
--

CREATE TABLE IF NOT EXISTS `site` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(100) CHARACTER SET utf8 NOT NULL,
  `userID` int(11) NOT NULL,
  `url_activated` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'will be activated when user ask to get embedded captcha code',
  PRIMARY KEY (`id`),
  KEY `userID` (`userID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(16) NOT NULL,
  `password` varchar(32) NOT NULL,
  `type` enum('admin','supplier','consumer') NOT NULL,
  `email` varchar(100) NOT NULL,
  `name` varchar(200) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `image`
--
ALTER TABLE `image`
  ADD CONSTRAINT `image_ibfk_1` FOREIGN KEY (`projectID`) REFERENCES `project` (`id`);

--
-- Ketidakleluasaan untuk tabel `match`
--
ALTER TABLE `match`
  ADD CONSTRAINT `match_ibfk_1` FOREIGN KEY (`imageA`) REFERENCES `image` (`id`),
  ADD CONSTRAINT `match_ibfk_2` FOREIGN KEY (`imageB`) REFERENCES `image` (`id`),
  ADD CONSTRAINT `match_ibfk_3` FOREIGN KEY (`matcher`) REFERENCES `user` (`id`);

--
-- Ketidakleluasaan untuk tabel `project`
--
ALTER TABLE `project`
  ADD CONSTRAINT `project_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `user` (`id`);
