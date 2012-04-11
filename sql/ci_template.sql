-- phpMyAdmin SQL Dump
-- version 3.3.9.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 26, 2011 at 05:58 PM
-- Server version: 5.5.9
-- PHP Version: 5.3.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- --------------------------------------------------------
DROP TABLE IF EXISTS `groups`;

#
# Table structure for table 'groups'
#

CREATE TABLE `groups` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `description` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
);

#
# Dumping data for table 'groups'
#

INSERT INTO `groups` (`id`, `name`, `description`) VALUES
  (1,'admin','Administrator'),
  (2,'members','General User');



DROP TABLE IF EXISTS `users`;

#
# Table structure for table 'users'
#

CREATE TABLE `users` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` int(10) unsigned NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(40) NOT NULL,
  `salt` varchar(40) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `activation_code` varchar(40) DEFAULT NULL,
  `forgotten_password_code` varchar(40) DEFAULT NULL,
  `remember_code` varchar(40) DEFAULT NULL,
  `created_on` int(11) unsigned NOT NULL,
  `last_login` int(11) unsigned DEFAULT NULL,
  `active` tinyint(1) unsigned DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `company` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
);


#
# Dumping data for table 'users'
#

INSERT INTO `users` (`id`, `ip_address`, `username`, `password`, `salt`, `email`, `activation_code`, `forgotten_password_code`, `created_on`, `last_login`, `active`, `first_name`, `last_name`, `company`, `phone`) VALUES
  ('1',INET_ATON('127.0.0.1'),'administrator','59beecdf7fc966e2f17fd8f65a4a9aeb09d4a3d4','9462e8eee0','admin@admin.com','',NULL,'1268889823','1268889823','1', 'Admin','istrator','ADMIN','0');


DROP TABLE IF EXISTS `users_groups`;

#
# Table structure for table 'users_groups'
#

CREATE TABLE `users_groups` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` mediumint(8) unsigned NOT NULL,
  `group_id` mediumint(8) unsigned NOT NULL,
  PRIMARY KEY (`id`)
);

INSERT INTO `users_groups` (`id`, `user_id`, `group_id`) VALUES
  (1,1,1),
  (2,1,2);


-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

DROP TABLE IF EXISTS `pages`;
CREATE TABLE `pages` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) DEFAULT NULL,
  `controller` varchar(50) DEFAULT NULL,
  `view` varchar(50) DEFAULT '',
  `url` varchar(50) DEFAULT NULL,
  `menu` varchar(50) DEFAULT NULL,
  `order` int(2) unsigned DEFAULT NULL,
  `require_login` int(1) unsigned DEFAULT '0',
  `group_id` int(10) unsigned DEFAULT '0',
  `parent_id` int(10) unsigned DEFAULT NULL,
  `active` int(1) unsigned DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` VALUES(1, 'Home', 'welcome', '', NULL, 'main', 1, 0, 0, NULL, 1);
INSERT INTO `pages` VALUES(16, 'Admin Control Panel', 'auth', '', NULL, NULL, NULL, 0, 1, NULL, 1);
INSERT INTO `pages` VALUES(9, 'Home', 'welcome', '', NULL, 'bottom', 0, 1, 0, NULL, 1);

-- --------------------------------------------------------