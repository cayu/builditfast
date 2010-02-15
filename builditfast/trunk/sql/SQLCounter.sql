# phpMyAdmin MySQL-Dump
# version 2.5.0
# http://www.phpmyadmin.net/ (download page)
#
# Host: localhost
# Generation Time: Nov 27, 2003 at 07:12 PM
# Server version: 4.0.11
# PHP Version: 4.3.1
# Database : `lunix`
# --------------------------------------------------------

#
# Table structure for table `mycounter`
#
# Creation: Nov 27, 2003 at 05:11 PM
# Last update: Nov 27, 2003 at 06:40 PM
#

DROP TABLE IF EXISTS `mycounter`;
CREATE TABLE `mycounter` (
  `name` varchar(30) NOT NULL default '',
  `count` int(14) NOT NULL default '0',
  PRIMARY KEY  (`name`)
) TYPE=MyISAM;

