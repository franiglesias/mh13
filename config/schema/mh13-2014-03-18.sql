# ************************************************************
# Sequel Pro SQL dump
# Versión 4096
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Host: 172.16.0.2 (MySQL 5.0.92-log)
# Base de datos: mh13
# Tiempo de Generación: 2014-03-18 13:12:33 +0100
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Volcado de tabla applications
# ------------------------------------------------------------

DROP TABLE IF EXISTS `applications`;

CREATE TABLE `applications` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `last_name` varchar(250) default NULL,
  `first_name` varchar(200) default NULL,
  `current` varchar(50) default NULL,
  `level` int(5) default NULL,
  `group` int(5) default NULL,
  `phone` varchar(12) default NULL,
  `email` varchar(250) default NULL,
  `idcard` varchar(9) default NULL,
  `father_idcard` varchar(9) default NULL,
  `mother_idcard` varchar(9) default NULL,
  `created` date default NULL,
  `modified` date default NULL,
  `interview` datetime default NULL,
  `status` int(5) default NULL,
  `resolution` int(5) default NULL,
  `type` tinyint(1) default NULL,
  `score` int(10) default NULL,
  `position` int(10) default NULL,
  `elective1` int(11) default NULL,
  `elective2` int(11) default NULL,
  `elective3` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Volcado de tabla batches
# ------------------------------------------------------------

DROP TABLE IF EXISTS `batches`;

CREATE TABLE `batches` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `title` varchar(200) default NULL,
  `description` text,
  `user_id` varchar(36) default NULL,
  `subject_id` int(11) unsigned default NULL,
  `level_id` int(11) unsigned default NULL,
  PRIMARY KEY  (`id`),
  KEY `user_id` (`user_id`),
  KEY `subject_id` (`subject_id`),
  KEY `level_id` (`level_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Volcado de tabla cantine_attendances
# ------------------------------------------------------------

DROP TABLE IF EXISTS `cantine_attendances`;

CREATE TABLE `cantine_attendances` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `student_id` int(11) unsigned default NULL,
  `cantine_turn_id` int(11) unsigned default NULL,
  `date` date default NULL,
  PRIMARY KEY  (`id`),
  KEY `student_id` (`student_id`),
  KEY `cantine_turn_id` (`cantine_turn_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Volcado de tabla cantine_date_remarks
# ------------------------------------------------------------

DROP TABLE IF EXISTS `cantine_date_remarks`;

CREATE TABLE `cantine_date_remarks` (
  `id` int(11) NOT NULL auto_increment,
  `date` date default NULL,
  `remark` text,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Volcado de tabla cantine_day_menus
# ------------------------------------------------------------

DROP TABLE IF EXISTS `cantine_day_menus`;

CREATE TABLE `cantine_day_menus` (
  `id` int(11) NOT NULL auto_increment,
  `cantine_week_menu_id` int(11) default NULL,
  `menu` text,
  `weekday` int(2) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Volcado de tabla cantine_groups
# ------------------------------------------------------------

DROP TABLE IF EXISTS `cantine_groups`;

CREATE TABLE `cantine_groups` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `title` varchar(200) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Volcado de tabla cantine_incidences
# ------------------------------------------------------------

DROP TABLE IF EXISTS `cantine_incidences`;

CREATE TABLE `cantine_incidences` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `student_id` int(11) default NULL,
  `date` date default NULL,
  `remark` text,
  PRIMARY KEY  (`id`),
  KEY `student_id` (`student_id`,`date`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Volcado de tabla cantine_menu_dates
# ------------------------------------------------------------

DROP TABLE IF EXISTS `cantine_menu_dates`;

CREATE TABLE `cantine_menu_dates` (
  `id` int(11) NOT NULL auto_increment,
  `cantine_week_menu_id` int(11) default NULL,
  `start` date default NULL,
  PRIMARY KEY  (`id`),
  KEY `start` (`start`),
  KEY `cantine_week_menu_id` (`cantine_week_menu_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Volcado de tabla cantine_regulars
# ------------------------------------------------------------

DROP TABLE IF EXISTS `cantine_regulars`;

CREATE TABLE `cantine_regulars` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `student_id` int(11) default NULL,
  `days_of_week` int(11) default NULL,
  `month` int(11) default NULL,
  PRIMARY KEY  (`id`),
  KEY `student_id` (`student_id`),
  KEY `days_of_week` (`days_of_week`),
  KEY `month` (`month`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Volcado de tabla cantine_rules
# ------------------------------------------------------------

DROP TABLE IF EXISTS `cantine_rules`;

CREATE TABLE `cantine_rules` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `cantine_turn_id` int(11) default NULL,
  `cantine_group_id` int(10) unsigned default NULL,
  `day_of_week` int(11) default NULL,
  `section_id` int(11) default NULL,
  `extra1` tinyint(2) default NULL,
  `extra2` tinyint(2) default NULL,
  PRIMARY KEY  (`id`),
  KEY `cantine_group_id` (`cantine_group_id`),
  KEY `cantine_turn_id` (`cantine_turn_id`),
  KEY `day_of_week` (`day_of_week`),
  KEY `section_id` (`section_id`),
  KEY `extra1` (`extra1`),
  KEY `extra2` (`extra2`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Volcado de tabla cantine_tickets
# ------------------------------------------------------------

DROP TABLE IF EXISTS `cantine_tickets`;

CREATE TABLE `cantine_tickets` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `student_id` int(11) unsigned default NULL,
  `date` date default NULL,
  PRIMARY KEY  (`id`),
  KEY `student_id` (`student_id`),
  KEY `date` (`date`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Volcado de tabla cantine_turns
# ------------------------------------------------------------

DROP TABLE IF EXISTS `cantine_turns`;

CREATE TABLE `cantine_turns` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `slot` int(11) default NULL,
  `title` varchar(50) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Volcado de tabla cantine_week_menus
# ------------------------------------------------------------

DROP TABLE IF EXISTS `cantine_week_menus`;

CREATE TABLE `cantine_week_menus` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(50) default NULL,
  `calories` float default NULL,
  `glucides` float default NULL,
  `lipids` float default NULL,
  `proteines` float default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Volcado de tabla channels
# ------------------------------------------------------------

DROP TABLE IF EXISTS `channels`;

CREATE TABLE `channels` (
  `id` varchar(36) NOT NULL,
  `license_id` varchar(36) default NULL,
  `pubDate` datetime default NULL,
  `type` varchar(50) default NULL,
  `icon` varchar(255) default NULL,
  `image` varchar(255) default NULL,
  `theme_id` varchar(36) default NULL,
  `active` tinyint(1) default NULL,
  `default_comments` int(2) default NULL,
  `twitter_account` varchar(255) default NULL,
  `twitter_password` varchar(255) default NULL,
  `menu_id` int(11) default NULL,
  `theme` varchar(200) default NULL,
  `layout` varchar(200) default NULL,
  `item_layout` varchar(200) default NULL,
  `item_template` varchar(200) default NULL,
  `guest` varchar(200) default NULL,
  `guestpwd` varchar(200) default NULL,
  `home` tinyint(1) default NULL,
  `order` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Volcado de tabla channels_users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `channels_users`;

CREATE TABLE `channels_users` (
  `id` int(11) NOT NULL auto_increment,
  `channel_id` varchar(36) default NULL,
  `user_id` varchar(36) default NULL,
  `role` varchar(60) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Volcado de tabla circular_boxes
# ------------------------------------------------------------

DROP TABLE IF EXISTS `circular_boxes`;

CREATE TABLE `circular_boxes` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `title` varchar(250) default NULL,
  `template` varchar(250) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Volcado de tabla circular_i18ns
# ------------------------------------------------------------

DROP TABLE IF EXISTS `circular_i18ns`;

CREATE TABLE `circular_i18ns` (
  `id` int(10) NOT NULL auto_increment,
  `locale` varchar(6) NOT NULL,
  `model` varchar(255) NOT NULL,
  `foreign_key` varchar(36) NOT NULL,
  `field` varchar(255) NOT NULL,
  `content` text,
  PRIMARY KEY  (`id`),
  KEY `locale` (`locale`),
  KEY `model` (`model`),
  KEY `row_id` (`foreign_key`),
  KEY `field` (`field`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Volcado de tabla circular_types
# ------------------------------------------------------------

DROP TABLE IF EXISTS `circular_types`;

CREATE TABLE `circular_types` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `title` varchar(250) default NULL,
  `template` varchar(250) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Volcado de tabla circulars
# ------------------------------------------------------------

DROP TABLE IF EXISTS `circulars`;

CREATE TABLE `circulars` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `status` int(3) unsigned NOT NULL default '0',
  `circular_type_id` int(11) unsigned default NULL,
  `circular_box_id` int(11) unsigned default NULL,
  `pubDate` date default NULL,
  `creator_id` varchar(36) default NULL,
  `publisher_id` varchar(36) default NULL,
  `created` timestamp NULL default NULL,
  `modified` timestamp NULL default NULL,
  `web` tinyint(1) NOT NULL default '1',
  PRIMARY KEY  (`id`),
  KEY `status` (`status`),
  KEY `circular_type_id` (`circular_type_id`),
  KEY `circular_box_id` (`circular_box_id`),
  KEY `creator_id` (`creator_id`),
  KEY `publisher_id` (`publisher_id`),
  KEY `pubDate` (`pubDate`),
  KEY `web` (`web`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Volcado de tabla comments
# ------------------------------------------------------------

DROP TABLE IF EXISTS `comments`;

CREATE TABLE `comments` (
  `id` char(36) NOT NULL default '',
  `comment` text,
  `parent_id` char(36) default NULL,
  `object_model` varchar(200) default NULL,
  `object_fk` char(36) default NULL,
  `rght` int(10) default NULL,
  `lft` int(10) default NULL,
  `user_id` char(36) default NULL,
  `name` varchar(200) default NULL,
  `email` varchar(200) default NULL,
  `url` varchar(200) default NULL,
  `approved` tinyint(2) NOT NULL default '0',
  `created` datetime default NULL,
  `modified` datetime default NULL,
  PRIMARY KEY  (`id`),
  KEY `object_model` (`object_model`,`object_fk`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Volcado de tabla cycles
# ------------------------------------------------------------

DROP TABLE IF EXISTS `cycles`;

CREATE TABLE `cycles` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `title` varchar(255) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Volcado de tabla device_types
# ------------------------------------------------------------

DROP TABLE IF EXISTS `device_types`;

CREATE TABLE `device_types` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `title` varchar(250) default NULL,
  `counter` int(8) default NULL,
  `abbr` varchar(5) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Volcado de tabla devices
# ------------------------------------------------------------

DROP TABLE IF EXISTS `devices`;

CREATE TABLE `devices` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `title` varchar(250) default NULL,
  `device_type_id` int(11) unsigned default NULL,
  `identifier` varchar(250) default NULL,
  `vendor` varchar(250) default NULL,
  `model` varchar(250) default NULL,
  `serial` varchar(250) default NULL,
  `location` varchar(250) default NULL,
  `image` varchar(255) default NULL,
  `remarks` text,
  `status` smallint(5) default NULL,
  `mac` varchar(18) default NULL,
  `status_remark` text,
  PRIMARY KEY  (`id`),
  KEY `device_type_id` (`device_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Volcado de tabla entries
# ------------------------------------------------------------

DROP TABLE IF EXISTS `entries`;

CREATE TABLE `entries` (
  `id` varchar(36) NOT NULL,
  `feed_id` varchar(36) default NULL,
  `title` varchar(255) default NULL,
  `content` text,
  `pubDate` timestamp NULL default NULL,
  `url` varchar(255) default NULL,
  `guid` varchar(255) default NULL,
  `author` varchar(255) default NULL,
  `email` varchar(255) default NULL,
  `md5` varchar(36) default NULL,
  `status` varchar(15) default NULL,
  PRIMARY KEY  (`id`),
  KEY `feed_id` (`feed_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Volcado de tabla event_i18ns
# ------------------------------------------------------------

DROP TABLE IF EXISTS `event_i18ns`;

CREATE TABLE `event_i18ns` (
  `id` int(10) NOT NULL auto_increment,
  `locale` varchar(6) character set utf8 collate utf8_bin NOT NULL default '',
  `model` varchar(255) character set utf8 collate utf8_bin NOT NULL default '',
  `foreign_key` varchar(36) NOT NULL default '',
  `field` varchar(255) character set utf8 collate utf8_bin NOT NULL default '',
  `content` text,
  PRIMARY KEY  (`id`),
  KEY `locale` (`locale`),
  KEY `model` (`model`),
  KEY `row_id` (`foreign_key`),
  KEY `field` (`field`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Volcado de tabla events
# ------------------------------------------------------------

DROP TABLE IF EXISTS `events`;

CREATE TABLE `events` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `startDate` date default NULL,
  `endDate` date default NULL,
  `startTime` time default NULL,
  `endTime` time default NULL,
  `circular_id` int(11) unsigned default NULL,
  `continuous` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `startDate` (`startDate`),
  KEY `startTime` (`startTime`),
  KEY `circular_id` (`circular_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Volcado de tabla feeds
# ------------------------------------------------------------

DROP TABLE IF EXISTS `feeds`;

CREATE TABLE `feeds` (
  `id` varchar(36) NOT NULL,
  `title` varchar(255) default NULL,
  `url` varchar(255) default NULL,
  `description` text,
  `language` varchar(5) default NULL,
  `copyright` varchar(255) default NULL,
  `updated` timestamp NULL default NULL,
  `feed` varchar(255) default NULL,
  `planet_id` varchar(36) default NULL,
  `slug` varchar(200) default NULL,
  `approved` tinyint(1) default NULL,
  `error` tinyint(1) default NULL,
  PRIMARY KEY  (`id`),
  KEY `slug` (`slug`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Volcado de tabla groups
# ------------------------------------------------------------

DROP TABLE IF EXISTS `groups`;

CREATE TABLE `groups` (
  `id` varchar(36) NOT NULL,
  `name` varchar(255) default NULL,
  `parent_id` varchar(36) default NULL,
  `lft` int(11) default NULL,
  `rght` int(11) default NULL,
  `description` text,
  `default` tinyint(1) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Volcado de tabla groups_users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `groups_users`;

CREATE TABLE `groups_users` (
  `user_id` varchar(36) default NULL,
  `group_id` varchar(36) default NULL,
  `id` int(11) NOT NULL auto_increment,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Volcado de tabla i18n
# ------------------------------------------------------------

DROP TABLE IF EXISTS `i18n`;

CREATE TABLE `i18n` (
  `id` int(10) NOT NULL auto_increment,
  `locale` varchar(6) NOT NULL,
  `model` varchar(255) NOT NULL,
  `foreign_key` varchar(36) NOT NULL,
  `field` varchar(255) NOT NULL,
  `content` text,
  PRIMARY KEY  (`id`),
  KEY `locale` (`locale`),
  KEY `model` (`model`),
  KEY `row_id` (`foreign_key`),
  KEY `field` (`field`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Volcado de tabla image_collections
# ------------------------------------------------------------

DROP TABLE IF EXISTS `image_collections`;

CREATE TABLE `image_collections` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `title` varchar(150) default NULL,
  `description` text,
  `type` varchar(15) default NULL,
  `slug` varchar(150) default NULL,
  PRIMARY KEY  (`id`),
  KEY `slug` (`slug`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Volcado de tabla item_i18ns
# ------------------------------------------------------------

DROP TABLE IF EXISTS `item_i18ns`;

CREATE TABLE `item_i18ns` (
  `id` int(10) NOT NULL auto_increment,
  `locale` varchar(6) NOT NULL,
  `model` varchar(255) NOT NULL,
  `foreign_key` varchar(36) NOT NULL,
  `field` varchar(255) NOT NULL,
  `content` text,
  PRIMARY KEY  (`id`),
  KEY `locale` (`locale`),
  KEY `model` (`model`),
  KEY `row_id` (`foreign_key`),
  KEY `field` (`field`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



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
  `guest` varchar(200) default NULL,
  `guestpwd` varchar(200) default NULL,
  `home` tinyint(1) default NULL,
  `level_id` int(11) unsigned NOT NULL default '0',
  `subject_id` int(11) default NULL,
  `gallery` varchar(75) default 'bx',
  PRIMARY KEY  (`id`),
  KEY `channel_id` (`channel_id`),
  KEY `level_id` (`level_id`),
  KEY `subject_id` (`subject_id`),
  KEY `pubDate` (`pubDate`),
  KEY `expiration` (`expiration`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Volcado de tabla items_users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `items_users`;

CREATE TABLE `items_users` (
  `id` int(11) NOT NULL auto_increment,
  `item_id` varchar(36) default NULL,
  `user_id` varchar(36) default NULL,
  `role` varchar(50) default NULL,
  PRIMARY KEY  (`id`),
  KEY `item_id` (`item_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Volcado de tabla levels
# ------------------------------------------------------------

DROP TABLE IF EXISTS `levels`;

CREATE TABLE `levels` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `title` varchar(200) default NULL,
  `private` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Volcado de tabla licenses
# ------------------------------------------------------------

DROP TABLE IF EXISTS `licenses`;

CREATE TABLE `licenses` (
  `id` varchar(36) NOT NULL,
  `license` varchar(255) default NULL,
  `type` varchar(255) default NULL,
  `code` text,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Volcado de tabla maintenance_types
# ------------------------------------------------------------

DROP TABLE IF EXISTS `maintenance_types`;

CREATE TABLE `maintenance_types` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `title` varchar(150) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Volcado de tabla maintenances
# ------------------------------------------------------------

DROP TABLE IF EXISTS `maintenances`;

CREATE TABLE `maintenances` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `device_id` int(11) unsigned default NULL,
  `created` datetime default NULL,
  `modified` datetime default NULL,
  `description` text,
  `action` text,
  `resolution` text,
  `resolved` date default NULL,
  `status` int(5) unsigned default NULL,
  `remarks` text,
  `technician_id` int(11) unsigned default NULL,
  `maintenance_type_id` int(11) unsigned default NULL,
  `requested` date default NULL,
  `detected` date default NULL,
  PRIMARY KEY  (`id`),
  KEY `device_id` (`device_id`),
  KEY `technician_id` (`technician_id`),
  KEY `maintenance_type_id` (`maintenance_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Volcado de tabla menu_items
# ------------------------------------------------------------

DROP TABLE IF EXISTS `menu_items`;

CREATE TABLE `menu_items` (
  `id` int(11) NOT NULL auto_increment,
  `menu_id` int(11) default NULL,
  `label` varchar(255) default NULL,
  `url` varchar(255) default NULL,
  `order` int(11) default NULL,
  `access` tinyint(2) default '0',
  `help` varchar(255) default NULL,
  `icon` varchar(255) default NULL,
  `class` varchar(255) default NULL,
  PRIMARY KEY  (`id`),
  KEY `menu_id` (`menu_id`),
  KEY `url` (`url`),
  KEY `access` (`access`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Volcado de tabla menus
# ------------------------------------------------------------

DROP TABLE IF EXISTS `menus`;

CREATE TABLE `menus` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(200) default NULL,
  `help` varchar(255) default NULL,
  `icon` varchar(255) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Volcado de tabla merit_types
# ------------------------------------------------------------

DROP TABLE IF EXISTS `merit_types`;

CREATE TABLE `merit_types` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `title` varchar(120) default NULL,
  `help` text,
  `alias` varchar(120) default NULL,
  `ignore_dates` tinyint(1) unsigned default NULL,
  `title_label` varchar(120) default NULL,
  `remarks_label` varchar(120) default NULL,
  `start_date_label` varchar(120) default NULL,
  `end_date_label` varchar(120) default NULL,
  `use_dates` int(3) default NULL,
  `allow_url` tinyint(1) NOT NULL default '1',
  `allow_file` tinyint(1) NOT NULL default '1',
  `file_label` varchar(120) default NULL,
  `url_label` varchar(120) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Volcado de tabla merits
# ------------------------------------------------------------

DROP TABLE IF EXISTS `merits`;

CREATE TABLE `merits` (
  `id` char(36) NOT NULL default '',
  `merit_type_id` int(11) default NULL,
  `title` varchar(255) default NULL,
  `remarks` text,
  `start` int(4) default NULL,
  `end` int(4) default NULL,
  `resume_id` char(36) default NULL,
  `url` varchar(255) default NULL,
  `file` varchar(255) default NULL,
  PRIMARY KEY  (`id`),
  FULLTEXT KEY `title` (`title`,`remarks`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Volcado de tabla ownerships
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ownerships`;

CREATE TABLE `ownerships` (
  `id` int(11) NOT NULL auto_increment,
  `owner_model` varchar(200) default NULL,
  `owner_id` varchar(36) default NULL,
  `object_model` varchar(200) default NULL,
  `object_id` varchar(36) default NULL,
  `access` int(8) default NULL,
  PRIMARY KEY  (`id`),
  KEY `object_model` (`object_model`,`object_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Volcado de tabla permissions
# ------------------------------------------------------------

DROP TABLE IF EXISTS `permissions`;

CREATE TABLE `permissions` (
  `id` varchar(36) NOT NULL,
  `description` varchar(255) default NULL,
  `role_id` varchar(36) default NULL,
  `url_pattern` varchar(255) default NULL,
  `scope` int(8) default '0',
  `model` varchar(255) default NULL,
  `conditions` text,
  `access` int(2) default NULL,
  PRIMARY KEY  (`id`),
  KEY `role_id` (`role_id`),
  KEY `url_pattern` (`url_pattern`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Volcado de tabla planets
# ------------------------------------------------------------

DROP TABLE IF EXISTS `planets`;

CREATE TABLE `planets` (
  `id` varchar(36) NOT NULL,
  `title` varchar(255) default NULL,
  `description` text,
  `slug` varchar(255) default NULL,
  `private` tinyint(1) default '0',
  PRIMARY KEY  (`id`),
  KEY `slug` (`slug`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Volcado de tabla positions
# ------------------------------------------------------------

DROP TABLE IF EXISTS `positions`;

CREATE TABLE `positions` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `title` varchar(120) default NULL,
  `description` text,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Volcado de tabla prizes
# ------------------------------------------------------------

DROP TABLE IF EXISTS `prizes`;

CREATE TABLE `prizes` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `number` int(11) default NULL,
  `title` varchar(250) default NULL,
  `sponsor` varchar(250) default NULL,
  `special` tinyint(1) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Volcado de tabla resources
# ------------------------------------------------------------

DROP TABLE IF EXISTS `resources`;

CREATE TABLE `resources` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `title` varchar(200) default NULL,
  `description` text,
  `created` timestamp NULL default NULL,
  `modified` timestamp NULL default NULL,
  `user_id` varchar(36) default NULL,
  `batch_id` int(11) unsigned default NULL,
  `subject_id` int(11) unsigned default NULL,
  `level_id` int(11) unsigned default NULL,
  PRIMARY KEY  (`id`),
  KEY `user_id` (`user_id`),
  KEY `batch_id` (`batch_id`),
  KEY `title` (`title`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Volcado de tabla resources_uploads
# ------------------------------------------------------------

DROP TABLE IF EXISTS `resources_uploads`;

CREATE TABLE `resources_uploads` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `resource_id` int(11) unsigned default NULL,
  `upload_id` varchar(36) default NULL,
  `version` int(11) default NULL,
  `comment` text,
  `created` timestamp NULL default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Volcado de tabla resumes
# ------------------------------------------------------------

DROP TABLE IF EXISTS `resumes`;

CREATE TABLE `resumes` (
  `id` char(36) NOT NULL default '',
  `email` varchar(255) default NULL,
  `password` varchar(50) default NULL,
  `firstname` varchar(250) default NULL,
  `lastname` varchar(250) default NULL,
  `phone` varchar(11) default NULL,
  `mobile` varchar(11) default NULL,
  `photo` varchar(255) default NULL,
  `introduction` text,
  `address` varchar(255) default NULL,
  `address2` varchar(255) default NULL,
  `cp` varchar(5) default NULL,
  `city` varchar(150) default NULL,
  `province` varchar(60) default NULL,
  `created` datetime default NULL,
  `modified` datetime default NULL,
  `employee` tinyint(1) default NULL,
  `position_id` int(11) unsigned default NULL,
  `current_position` varchar(250) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Volcado de tabla roles
# ------------------------------------------------------------

DROP TABLE IF EXISTS `roles`;

CREATE TABLE `roles` (
  `id` varchar(36) NOT NULL,
  `role` varchar(200) default NULL,
  `description` varchar(255) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Volcado de tabla roles_users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `roles_users`;

CREATE TABLE `roles_users` (
  `id` int(11) NOT NULL auto_increment,
  `user_id` varchar(36) default NULL,
  `role_id` varchar(36) default NULL,
  PRIMARY KEY  (`id`),
  KEY `user_id` (`user_id`,`role_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Volcado de tabla sections
# ------------------------------------------------------------

DROP TABLE IF EXISTS `sections`;

CREATE TABLE `sections` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `title` varchar(50) default NULL,
  `cantine_group_id` int(11) unsigned default NULL,
  `level_id` int(11) unsigned default NULL,
  `cycle_id` int(11) unsigned default NULL,
  `stage_id` int(11) unsigned default NULL,
  `next` int(11) unsigned default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Volcado de tabla sindices
# ------------------------------------------------------------

DROP TABLE IF EXISTS `sindices`;

CREATE TABLE `sindices` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `model` varchar(250) default NULL,
  `fk` varchar(36) default NULL,
  `content` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `model` (`model`,`fk`),
  FULLTEXT KEY `content` (`content`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Volcado de tabla sites
# ------------------------------------------------------------

DROP TABLE IF EXISTS `sites`;

CREATE TABLE `sites` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `theme_id` varchar(36) default NULL,
  `key` varchar(255) default NULL,
  `theme` varchar(200) default NULL,
  `layout` varchar(200) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Volcado de tabla stages
# ------------------------------------------------------------

DROP TABLE IF EXISTS `stages`;

CREATE TABLE `stages` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `title` varchar(200) default NULL,
  `abbr` varchar(5) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Volcado de tabla static_i18ns
# ------------------------------------------------------------

DROP TABLE IF EXISTS `static_i18ns`;

CREATE TABLE `static_i18ns` (
  `id` int(10) NOT NULL auto_increment,
  `locale` varchar(6) NOT NULL,
  `model` varchar(255) NOT NULL,
  `foreign_key` varchar(36) NOT NULL,
  `field` varchar(255) NOT NULL,
  `content` text,
  PRIMARY KEY  (`id`),
  KEY `locale` (`locale`),
  KEY `model` (`model`),
  KEY `row_id` (`foreign_key`),
  KEY `field` (`field`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Volcado de tabla static_pages
# ------------------------------------------------------------

DROP TABLE IF EXISTS `static_pages`;

CREATE TABLE `static_pages` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `parent_id` int(11) unsigned default NULL,
  `modified` datetime default NULL,
  `readings` int(11) default NULL,
  `image` varchar(255) default NULL,
  `order` int(11) default NULL,
  `lft` int(11) default NULL,
  `rght` int(11) default NULL,
  `project_key` varchar(200) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Volcado de tabla students
# ------------------------------------------------------------

DROP TABLE IF EXISTS `students`;

CREATE TABLE `students` (
  `id` int(11) NOT NULL auto_increment,
  `firstname` varchar(200) default NULL,
  `lastname1` varchar(200) default NULL,
  `lastname2` varchar(200) default NULL,
  `extra1` smallint(3) NOT NULL default '0',
  `extra2` tinyint(1) NOT NULL default '0',
  `section_id` int(11) default NULL,
  `remarks` text,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Volcado de tabla students_copy
# ------------------------------------------------------------

DROP TABLE IF EXISTS `students_copy`;

CREATE TABLE `students_copy` (
  `id` int(11) NOT NULL auto_increment,
  `firstname` varchar(200) default NULL,
  `lastname1` varchar(200) default NULL,
  `lastname2` varchar(200) default NULL,
  `extra1` smallint(3) NOT NULL default '0',
  `extra2` tinyint(1) NOT NULL default '0',
  `section_id` int(11) default NULL,
  `remarks` text,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Volcado de tabla subjects
# ------------------------------------------------------------

DROP TABLE IF EXISTS `subjects`;

CREATE TABLE `subjects` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `title` varchar(250) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Volcado de tabla tagged
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tagged`;

CREATE TABLE `tagged` (
  `id` varchar(36) NOT NULL,
  `foreign_key` varchar(36) NOT NULL,
  `tag_id` varchar(36) NOT NULL,
  `model` varchar(255) NOT NULL,
  `language` varchar(6) default NULL,
  `created` datetime default NULL,
  `modified` datetime default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `UNIQUE_TAGGING` (`model`,`foreign_key`,`tag_id`,`language`),
  KEY `INDEX_TAGGED` (`model`),
  KEY `INDEX_LANGUAGE` (`language`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Volcado de tabla tags
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tags`;

CREATE TABLE `tags` (
  `id` varchar(36) NOT NULL,
  `identifier` varchar(30) default NULL,
  `name` varchar(30) NOT NULL,
  `keyname` varchar(30) NOT NULL,
  `weight` int(2) NOT NULL default '0',
  `created` datetime default NULL,
  `modified` datetime default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `UNIQUE_TAG` (`identifier`,`keyname`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Volcado de tabla technicians
# ------------------------------------------------------------

DROP TABLE IF EXISTS `technicians`;

CREATE TABLE `technicians` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `title` varchar(200) default NULL,
  `email` varchar(250) default NULL,
  `phone` varchar(15) default NULL,
  `remarks` text,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Volcado de tabla themes
# ------------------------------------------------------------

DROP TABLE IF EXISTS `themes`;

CREATE TABLE `themes` (
  `id` varchar(36) NOT NULL,
  `theme` varchar(255) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Volcado de tabla tickets
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tickets`;

CREATE TABLE `tickets` (
  `id` varchar(36) NOT NULL,
  `created` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `expiration` timestamp NOT NULL default '0000-00-00 00:00:00',
  `action` varchar(255) default NULL,
  `model` varchar(255) default NULL,
  `foreign_key` varchar(36) default NULL,
  `used` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Volcado de tabla uploads
# ------------------------------------------------------------

DROP TABLE IF EXISTS `uploads`;

CREATE TABLE `uploads` (
  `id` varchar(36) NOT NULL,
  `name` varchar(255) default NULL,
  `size` int(11) default NULL,
  `type` varchar(255) character set utf8 collate utf8_bin default NULL,
  `path` varchar(255) default NULL,
  `fullpath` varchar(255) default NULL,
  `description` text,
  `model` varchar(255) default NULL,
  `foreign_key` varchar(36) default NULL,
  `author` varchar(255) default NULL,
  `width` int(11) default NULL,
  `height` int(11) default NULL,
  `playtime` int(15) default NULL,
  `enclosure` tinyint(1) default NULL,
  `order` int(11) unsigned default NULL,
  `created` datetime default NULL,
  PRIMARY KEY  (`id`),
  KEY `model` (`model`,`foreign_key`),
  KEY `type` (`type`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Volcado de tabla users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` varchar(36) NOT NULL,
  `username` varchar(255) default NULL,
  `password` varchar(255) default NULL,
  `realname` varchar(255) default NULL,
  `email` varchar(255) default NULL,
  `active` int(11) default NULL,
  `connected` datetime default NULL,
  `last_login` datetime default NULL,
  `photo` varchar(255) default NULL,
  `bio` text,
  PRIMARY KEY  (`id`),
  KEY `name` (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;




/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
