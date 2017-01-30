# ************************************************************
# Sequel Pro SQL dump
# Versión 4096
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Host: 172.16.0.2 (MySQL 5.0.92-log)
# Base de datos: mh13
# Tiempo de Generación: 2014-03-21 16:58:30 +0100
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Volcado de tabla items
# ------------------------------------------------------------

DROP TABLE IF EXISTS `items`;

CREATE TABLE `items` (
  `id` varchar(36) NOT NULL,
  `parent_id` varchar(36) default NULL,
  `lft` int(11) default NULL,
  `rght` int(11) default NULL,
  `image` varchar(255) default NULL,
  `enclosure_id` varchar(36) default NULL,
  `pubDate` datetime default NULL,
  `expiration` datetime default NULL,
  `created` datetime default NULL,
  `modified` datetime default NULL,
  `status` int(2) NOT NULL default '0',
  `license_id` varchar(36) default NULL,
  `channel_id` varchar(36) default NULL,
  `featured` tinyint(1) NOT NULL default '0',
  `remarks` text,
  `live` tinyint(1) NOT NULL default '0',
  `allow_comments` int(2) NOT NULL default '0',
  `search_if_expired` tinyint(1) NOT NULL default '0',
  `readings` int(11) default '0',
  `stick` tinyint(1) NOT NULL default '0',
  `home` tinyint(1) default NULL,
  `level_id` int(11) unsigned NOT NULL default '0',
  `subject_id` int(11) default NULL,
  `gallery` varchar(75) default 'bx',
  `guest` varchar(200) default NULL,
  `guestpwd` varchar(200) default NULL,
  PRIMARY KEY  (`id`),
  KEY `channel_id` (`channel_id`),
  KEY `level_id` (`level_id`),
  KEY `subject_id` (`subject_id`),
  KEY `pubDate` (`pubDate`),
  KEY `expiration` (`expiration`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;




/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
