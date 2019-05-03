-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: May 03, 2019 at 08:32 AM
-- Server version: 5.7.24
-- PHP Version: 7.2.14

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
-- Table structure for table `languages`
--

DROP TABLE IF EXISTS `languages`;
CREATE TABLE IF NOT EXISTS `languages` (
  `langid` int(11) NOT NULL AUTO_INCREMENT,
  `lang_descriptor` varchar(255) NOT NULL,
  `lang_display_name` varchar(255) NOT NULL,
  `lang_native_name` varchar(255) NOT NULL,
  `lang_status` tinyint(1) NOT NULL,
  `lang_default` tinyint(1) NOT NULL,
  PRIMARY KEY (`langid`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`langid`, `lang_descriptor`, `lang_display_name`, `lang_native_name`, `lang_status`, `lang_default`) VALUES
(1, 'en', 'English', 'English', 1, 1),
(2, 'el', 'Greek', 'Ελληνικά', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `module_translations`
--

DROP TABLE IF EXISTS `module_translations`;
CREATE TABLE IF NOT EXISTS `module_translations` (
  `trid` int(11) NOT NULL AUTO_INCREMENT,
  `routeid` int(11) NOT NULL,
  `mod_display_name` varchar(255) NOT NULL,
  `mod_desc` varchar(255) NOT NULL,
  `lang` varchar(255) NOT NULL,
  PRIMARY KEY (`trid`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `module_translations`
--

INSERT INTO `module_translations` (`trid`, `routeid`, `mod_display_name`, `mod_desc`, `lang`) VALUES
(1, 1, 'Προσθήκη Χρήστη', 'Προσθήκη Χρήστη στο Σύστημα', 'el'),
(2, 2, 'Εισοδος', 'Είσοδος στο Σύτημα', 'el'),
(3, 4, 'Αρχική', 'Αρχική Σελίδα', 'el'),
(4, 5, 'Έξοδος', 'Έξοδος από το σύστημα', 'el'),
(5, 7, 'Διαχείρηση Προνομίων', 'Διαχείριση Προωομίωω των Κατηγοριών των χρηστών', 'el'),
(6, 8, 'Επεξεργασία Χρήστη', 'Επεξεργασία Χρηστών', 'el'),
(7, 3, '404', 'Η σελίδα δεν βρέθηκε', 'el'),
(8, 6, 'Απαγόρευση Πρόσβασης', 'Δεν Επιιτρέπεται', 'el');

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
CREATE TABLE IF NOT EXISTS `permissions` (
  `permid` int(11) NOT NULL AUTO_INCREMENT,
  `roleid` int(11) NOT NULL,
  `routeid` int(11) NOT NULL,
  `allowed` tinyint(1) NOT NULL,
  PRIMARY KEY (`permid`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=utf8 COMMENT='This is the permissions table';

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`permid`, `roleid`, `routeid`, `allowed`) VALUES
(1, 2, 1, 1),
(2, 2, 2, 1),
(3, 2, 3, 1),
(4, 2, 4, 1),
(5, 2, 5, 1),
(6, 1, 2, 1),
(7, 1, 3, 1),
(8, 1, 4, 1),
(9, 1, 5, 1),
(10, 3, 2, 1),
(11, 3, 3, 1),
(12, 3, 4, 1),
(13, 3, 5, 1),
(14, 3, 1, 0),
(15, 1, 1, 0),
(16, 1, 6, 1),
(17, 2, 6, 1),
(18, 3, 6, 1),
(19, 1, 7, 0),
(20, 2, 7, 1),
(21, 3, 7, 0),
(22, 1, 8, 0),
(23, 2, 8, 1),
(24, 3, 8, 1);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `roleid` int(11) NOT NULL AUTO_INCREMENT,
  `role_name` varchar(255) NOT NULL,
  `role_display_name` varchar(255) NOT NULL,
  `role_description` text,
  PRIMARY KEY (`roleid`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`roleid`, `role_name`, `role_display_name`, `role_description`) VALUES
(1, 'anonymous', 'Anonymous User', 'The anonymous user is the one that has not yet logged in. This is auto assigned when no login is detected. '),
(2, 'admin', 'Site Administrator', 'This role usually is fully capable of using all modules'),
(3, 'standard_user', 'Standard User', 'Restricted from Admin Functionalities');

-- --------------------------------------------------------

--
-- Table structure for table `routes`
--

DROP TABLE IF EXISTS `routes`;
CREATE TABLE IF NOT EXISTS `routes` (
  `routeid` int(11) NOT NULL AUTO_INCREMENT,
  `action` varchar(255) NOT NULL,
  `type` varchar(255) DEFAULT NULL,
  `id` tinyint(1) DEFAULT NULL,
  `mod_name` varchar(255) NOT NULL,
  `mod_display_name` varchar(255) NOT NULL,
  `mod_desc` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `system` tinyint(1) NOT NULL,
  `visible` tinyint(1) NOT NULL,
  PRIMARY KEY (`routeid`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `routes`
--

INSERT INTO `routes` (`routeid`, `action`, `type`, `id`, `mod_name`, `mod_display_name`, `mod_desc`, `status`, `system`, `visible`) VALUES
(1, 'add', 'user', 0, 'add_user', 'Add User', 'add users ', 1, 1, 1),
(2, 'login', NULL, 0, 'login', 'Login', 'The login module of the CMS', 1, 1, 1),
(3, 'not_found', NULL, 0, 'not_found', '404', 'Page Not found Module', 1, 1, 0),
(4, 'home', NULL, 0, 'home', 'Home', 'This is the home module for the CMS', 1, 1, 1),
(5, 'logout', NULL, 0, 'logout', 'Logout', 'Logout from the CMS', 1, 1, 1),
(6, 'denied', NULL, NULL, 'denied', 'Access Denied', 'Access Denied Page', 1, 1, 0),
(7, 'manage', 'permissions', NULL, 'manage_permissions', 'Manage Permissions', 'This is the permissions manage Module', 1, 1, 1),
(8, 'edit', 'user', NULL, 'edit_user', 'Edit User', 'Edit Users', 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `theme_registry`
--

DROP TABLE IF EXISTS `theme_registry`;
CREATE TABLE IF NOT EXISTS `theme_registry` (
  `themeid` int(11) NOT NULL AUTO_INCREMENT,
  `theme_name` varchar(255) NOT NULL,
  `theme_display_name` varchar(255) NOT NULL,
  `theme_desc` text NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`themeid`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `theme_registry`
--

INSERT INTO `theme_registry` (`themeid`, `theme_name`, `theme_display_name`, `theme_desc`, `status`) VALUES
(1, 'default', 'The Default Theme', 'This is the default theme, with standard functionality and structure. \r\nDO NOT REMOVE THIS THEME', 1);

-- --------------------------------------------------------

--
-- Table structure for table `topnav`
--

DROP TABLE IF EXISTS `topnav`;
CREATE TABLE IF NOT EXISTS `topnav` (
  `linkid` int(11) NOT NULL AUTO_INCREMENT,
  `link_text` varchar(255) NOT NULL,
  `link_path` varchar(255) NOT NULL,
  `weight` int(11) NOT NULL,
  PRIMARY KEY (`linkid`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `topnav`
--

INSERT INTO `topnav` (`linkid`, `link_text`, `link_path`, `weight`) VALUES
(1, 'Home', 'home', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` tinyint(4) NOT NULL,
  PRIMARY KEY (`uid`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`uid`, `username`, `password`, `role`) VALUES
(1, 'admin', '16d7a4fca7442dda3ad93c9a726597e4', 2),
(2, 'user1', '24c9e15e52afc47c225b757e7bee1f9d', 3),
(5, 'user2', 'c06db68e819be6ec3d26c6038d8e8d1f', 3);

-- --------------------------------------------------------

--
-- Table structure for table `variables`
--

DROP TABLE IF EXISTS `variables`;
CREATE TABLE IF NOT EXISTS `variables` (
  `vid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`vid`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `variables`
--

INSERT INTO `variables` (`vid`, `name`, `value`) VALUES
(1, 'site_name', 'Project Plastelline 2019');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
