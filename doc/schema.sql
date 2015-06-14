-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 14 Jun 2015 pada 17.38
-- Versi Server: 5.6.20
-- PHP Version: 5.5.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `project_biomatcher`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `activate_tokens`
--

CREATE TABLE IF NOT EXISTS `activate_tokens` (
`activate_token_id` int(10) unsigned NOT NULL,
  `activate_token_user_id` int(10) unsigned NOT NULL,
  `activate_token_site_id` int(11) NOT NULL,
  `activate_token_hash` char(64) NOT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `image`
--

CREATE TABLE IF NOT EXISTS `image` (
`id` int(11) NOT NULL,
  `projectID` int(11) NOT NULL,
  `nameOri` varchar(200) NOT NULL,
  `md5sum` varchar(100) NOT NULL,
  `label` varchar(100) DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=65 ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `match`
--

CREATE TABLE IF NOT EXISTS `match` (
`id` int(11) NOT NULL,
  `imageA` int(11) NOT NULL,
  `imageB` int(11) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `matcher` int(11) NOT NULL,
  `same` enum('no','yes') NOT NULL,
  `siteID` int(11) DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=117 ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `project`
--

CREATE TABLE IF NOT EXISTS `project` (
`id` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `qcSet` enum('no','yes') NOT NULL DEFAULT 'no'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `site`
--

CREATE TABLE IF NOT EXISTS `site` (
`id` int(11) NOT NULL,
  `url` varchar(100) CHARACTER SET utf8 NOT NULL,
  `userID` int(11) NOT NULL,
  `url_activated` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'will be activated when user ask to get embedded captcha code'
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE IF NOT EXISTS `user` (
`id` int(11) NOT NULL,
  `username` varchar(16) NOT NULL,
  `password` varchar(32) NOT NULL,
  `type` enum('admin','supplier','consumer') NOT NULL,
  `email` varchar(100) NOT NULL,
  `name` varchar(200) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activate_tokens`
--
ALTER TABLE `activate_tokens`
 ADD PRIMARY KEY (`activate_token_id`), ADD UNIQUE KEY `activate_token_site_id` (`activate_token_site_id`);

--
-- Indexes for table `image`
--
ALTER TABLE `image`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `md5sum` (`projectID`,`md5sum`), ADD UNIQUE KEY `nameOri` (`projectID`,`nameOri`), ADD KEY `projectID` (`projectID`);

--
-- Indexes for table `match`
--
ALTER TABLE `match`
 ADD PRIMARY KEY (`id`), ADD KEY `imageA` (`imageA`), ADD KEY `imageB` (`imageB`), ADD KEY `matcher` (`matcher`);

--
-- Indexes for table `project`
--
ALTER TABLE `project`
 ADD PRIMARY KEY (`id`), ADD KEY `userID` (`userID`);

--
-- Indexes for table `site`
--
ALTER TABLE `site`
 ADD PRIMARY KEY (`id`), ADD KEY `userID` (`userID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activate_tokens`
--
ALTER TABLE `activate_tokens`
MODIFY `activate_token_id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `image`
--
ALTER TABLE `image`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=65;
--
-- AUTO_INCREMENT for table `match`
--
ALTER TABLE `match`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=117;
--
-- AUTO_INCREMENT for table `project`
--
ALTER TABLE `project`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `site`
--
ALTER TABLE `site`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `image`
--
ALTER TABLE `image`
ADD CONSTRAINT `image_ibfk_1` FOREIGN KEY (`projectID`) REFERENCES `project` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `match`
--
ALTER TABLE `match`
ADD CONSTRAINT `match_ibfk_1` FOREIGN KEY (`imageA`) REFERENCES `image` (`id`) ON DELETE CASCADE,
ADD CONSTRAINT `match_ibfk_2` FOREIGN KEY (`imageB`) REFERENCES `image` (`id`) ON DELETE CASCADE,
ADD CONSTRAINT `match_ibfk_3` FOREIGN KEY (`matcher`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `project`
--
ALTER TABLE `project`
ADD CONSTRAINT `project_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `user` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
