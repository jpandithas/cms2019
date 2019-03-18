-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Mar 18, 2019 at 06:53 PM
-- Server version: 5.7.21
-- PHP Version: 7.0.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cms2019`
--

-- --------------------------------------------------------

--
-- Table structure for table `routes`
--

DROP TABLE IF EXISTS `routes`;
CREATE TABLE IF NOT EXISTS `routes` (
  `routeid` int(11) NOT NULL AUTO_INCREMENT,
  `action` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `id` tinyint(1) DEFAULT NULL,
  `mod_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `mod_desc` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL,
  `system` tinyint(1) NOT NULL,
  `userlevel` int(11) NOT NULL,
  PRIMARY KEY (`routeid`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `routes`
--

INSERT INTO `routes` (`routeid`, `action`, `type`, `id`, `mod_name`, `mod_desc`, `status`, `system`, `userlevel`) VALUES
(1, 'add', 'user', 0, 'add_user', 'add users ', 1, 1, 0),
(2, 'login', NULL, 0, 'login', 'The login module of the CMS', 1, 1, 0),
(3, 'display', 'not_found', 0, 'not_found', 'Page Not found Module', 1, 1, 0),
(4, 'home', NULL, 0, 'home', 'This is the home module for the CMS', 1, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `testtable`
--

DROP TABLE IF EXISTS `testtable`;
CREATE TABLE IF NOT EXISTS `testtable` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `text1` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `num1` int(11) DEFAULT NULL,
  `txt` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `testtable`
--

INSERT INTO `testtable` (`id`, `text1`, `num1`, `txt`) VALUES
(1, 'this is varchar', 12343, 'jsdg djf df\r\ndkkhf djf hd\r\n\r\ndkfh dkfdjfh d'),
(2, 'text 2 for varchar', 21344333, 'd,mfhd jf hdf\r\ndkhf dkfff f\r\n\r\ndfdlkjf dfjkd kfjd');

-- --------------------------------------------------------

--
-- Table structure for table `theme_registry`
--

DROP TABLE IF EXISTS `theme_registry`;
CREATE TABLE IF NOT EXISTS `theme_registry` (
  `themeid` int(11) NOT NULL AUTO_INCREMENT,
  `theme_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `theme_display_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `theme_desc` text COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`themeid`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `theme_registry`
--

INSERT INTO `theme_registry` (`themeid`, `theme_name`, `theme_display_name`, `theme_desc`, `status`) VALUES
(1, 'default', 'The Default Theme', 'This is the default theme, with standard functionality and structure. \r\nDO NOT REMOVE THIS THEME', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `userlevel` tinyint(4) NOT NULL,
  PRIMARY KEY (`uid`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`uid`, `username`, `password`, `userlevel`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 0);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
