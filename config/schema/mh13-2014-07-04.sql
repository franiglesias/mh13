# ************************************************************
# Sequel Pro SQL dump
# Versión 4096
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Host: 127.0.0.1 (MySQL 5.1.37)
# Base de datos: mh13
# Tiempo de Generación: 2014-07-04 14:01:05 +0200
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

CREATE TABLE `applications` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `last_name` varchar(250) DEFAULT NULL,
  `first_name` varchar(200) DEFAULT NULL,
  `current` varchar(50) DEFAULT NULL,
  `level_id` int(5) DEFAULT NULL,
  `group` int(5) DEFAULT NULL,
  `phone` varchar(12) DEFAULT NULL,
  `email` varchar(250) DEFAULT NULL,
  `idcard` varchar(9) DEFAULT NULL,
  `father_idcard` varchar(9) DEFAULT NULL,
  `mother_idcard` varchar(9) DEFAULT NULL,
  `created` date DEFAULT NULL,
  `modified` date DEFAULT NULL,
  `interview` datetime DEFAULT NULL,
  `status` int(5) DEFAULT NULL,
  `resolution` int(5) DEFAULT NULL,
  `type` tinyint(1) DEFAULT NULL,
  `score` int(10) DEFAULT NULL,
  `position` int(10) DEFAULT NULL,
  `elective1` int(11) DEFAULT NULL,
  `elective2` int(11) DEFAULT NULL,
  `elective3` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Volcado de tabla bars
# ------------------------------------------------------------

CREATE TABLE `bars` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(100) DEFAULT NULL,
  `label` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Volcado de tabla batches
# ------------------------------------------------------------

CREATE TABLE `batches` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(200) DEFAULT NULL,
  `description` text,
  `user_id` varchar(36) DEFAULT NULL,
  `subject_id` int(11) unsigned DEFAULT NULL,
  `level_id` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Volcado de tabla cantine_attendances
# ------------------------------------------------------------

CREATE TABLE `cantine_attendances` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `student_id` int(11) unsigned DEFAULT NULL,
  `cantine_turn_id` int(11) unsigned DEFAULT NULL,
  `date` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cantine_turn_id` (`cantine_turn_id`),
  KEY `student_id` (`student_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Volcado de tabla cantine_date_remarks
# ------------------------------------------------------------

CREATE TABLE `cantine_date_remarks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` date DEFAULT NULL,
  `remark` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Volcado de tabla cantine_day_menus
# ------------------------------------------------------------

CREATE TABLE `cantine_day_menus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cantine_week_menu_id` int(11) DEFAULT NULL,
  `menu` text,
  `weekday` int(2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Volcado de tabla cantine_groups
# ------------------------------------------------------------

CREATE TABLE `cantine_groups` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Volcado de tabla cantine_incidences
# ------------------------------------------------------------

CREATE TABLE `cantine_incidences` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `student_id` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `remark` text,
  PRIMARY KEY (`id`),
  KEY `student_id` (`student_id`,`date`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Volcado de tabla cantine_menu_dates
# ------------------------------------------------------------

CREATE TABLE `cantine_menu_dates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cantine_week_menu_id` int(11) DEFAULT NULL,
  `start` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Volcado de tabla cantine_regulars
# ------------------------------------------------------------

CREATE TABLE `cantine_regulars` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `student_id` int(11) DEFAULT NULL,
  `days_of_week` int(11) DEFAULT NULL,
  `month` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `student_id` (`student_id`),
  KEY `days_of_week` (`days_of_week`),
  KEY `month` (`month`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Volcado de tabla cantine_rules
# ------------------------------------------------------------

CREATE TABLE `cantine_rules` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `cantine_turn_id` int(11) DEFAULT NULL,
  `cantine_group_id` int(10) unsigned DEFAULT NULL,
  `day_of_week` int(11) DEFAULT NULL,
  `section_id` int(11) DEFAULT NULL,
  `extra1` tinyint(2) DEFAULT NULL,
  `extra2` tinyint(2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cantine_group_id` (`cantine_group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Volcado de tabla cantine_tickets
# ------------------------------------------------------------

CREATE TABLE `cantine_tickets` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `student_id` int(11) unsigned DEFAULT NULL,
  `date` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `student_id` (`student_id`),
  KEY `date` (`date`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Volcado de tabla cantine_turns
# ------------------------------------------------------------

CREATE TABLE `cantine_turns` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `slot` int(11) DEFAULT NULL,
  `title` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Volcado de tabla cantine_week_menus
# ------------------------------------------------------------

CREATE TABLE `cantine_week_menus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) DEFAULT NULL,
  `calories` float DEFAULT NULL,
  `glucides` float DEFAULT NULL,
  `lipids` float DEFAULT NULL,
  `proteines` float DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Volcado de tabla channels
# ------------------------------------------------------------

CREATE TABLE `channels` (
  `id` varchar(36) NOT NULL,
  `license_id` varchar(36) DEFAULT NULL,
  `pubDate` datetime DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `theme` varchar(200) DEFAULT NULL,
  `active` tinyint(1) DEFAULT NULL,
  `default_comments` int(2) DEFAULT NULL,
  `twitter_account` varchar(255) DEFAULT NULL,
  `twitter_password` varchar(255) DEFAULT NULL,
  `menu_id` int(11) DEFAULT NULL,
  `layout` varchar(200) DEFAULT NULL,
  `item_layout` varchar(200) DEFAULT NULL,
  `item_template` varchar(200) DEFAULT NULL,
  `guest` varchar(200) DEFAULT NULL,
  `guestpwd` varchar(200) DEFAULT NULL,
  `home` tinyint(1) DEFAULT NULL,
  `order` int(11) NOT NULL DEFAULT '0',
  `private` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Volcado de tabla channels_users
# ------------------------------------------------------------

CREATE TABLE `channels_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `channel_id` varchar(36) DEFAULT NULL,
  `user_id` varchar(36) DEFAULT NULL,
  `role` varchar(60) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Volcado de tabla circular_boxes
# ------------------------------------------------------------

CREATE TABLE `circular_boxes` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(250) DEFAULT NULL,
  `template` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Volcado de tabla circular_i18ns
# ------------------------------------------------------------

CREATE TABLE `circular_i18ns` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `locale` varchar(6) NOT NULL,
  `model` varchar(255) NOT NULL,
  `foreign_key` varchar(36) NOT NULL,
  `field` varchar(255) NOT NULL,
  `content` text,
  PRIMARY KEY (`id`),
  KEY `locale` (`locale`),
  KEY `model` (`model`),
  KEY `row_id` (`foreign_key`),
  KEY `field` (`field`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Volcado de tabla circular_types
# ------------------------------------------------------------

CREATE TABLE `circular_types` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(250) DEFAULT NULL,
  `template` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Volcado de tabla circulars
# ------------------------------------------------------------

CREATE TABLE `circulars` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `status` int(3) unsigned NOT NULL DEFAULT '0',
  `circular_type_id` int(11) unsigned DEFAULT NULL,
  `circular_box_id` int(11) unsigned DEFAULT NULL,
  `pubDate` date DEFAULT NULL,
  `creator_id` varchar(36) DEFAULT NULL,
  `publisher_id` varchar(36) DEFAULT NULL,
  `created` timestamp NULL DEFAULT NULL,
  `modified` timestamp NULL DEFAULT NULL,
  `web` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `creator_id` (`creator_id`),
  KEY `circular_type_id` (`circular_type_id`),
  KEY `circular_box_id` (`circular_box_id`),
  KEY `publisher_id` (`publisher_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Volcado de tabla comments
# ------------------------------------------------------------

CREATE TABLE `comments` (
  `id` char(36) NOT NULL DEFAULT '',
  `comment` text,
  `parent_id` char(36) DEFAULT NULL,
  `object_model` varchar(200) DEFAULT NULL,
  `object_fk` char(36) DEFAULT NULL,
  `rght` int(10) DEFAULT NULL,
  `lft` int(10) DEFAULT NULL,
  `user_id` char(36) DEFAULT NULL,
  `name` varchar(200) DEFAULT NULL,
  `email` varchar(200) DEFAULT NULL,
  `url` varchar(200) DEFAULT NULL,
  `approved` tinyint(2) NOT NULL DEFAULT '0',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Volcado de tabla cycles
# ------------------------------------------------------------

CREATE TABLE `cycles` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Volcado de tabla device_types
# ------------------------------------------------------------

CREATE TABLE `device_types` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(250) DEFAULT NULL,
  `counter` int(8) DEFAULT NULL,
  `abbr` varchar(5) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Volcado de tabla devices
# ------------------------------------------------------------

CREATE TABLE `devices` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(250) DEFAULT NULL,
  `device_type_id` int(11) unsigned DEFAULT NULL,
  `identifier` varchar(250) DEFAULT NULL,
  `vendor` varchar(250) DEFAULT NULL,
  `model` varchar(250) DEFAULT NULL,
  `serial` varchar(250) DEFAULT NULL,
  `location` varchar(250) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `remarks` text,
  `status` smallint(5) DEFAULT NULL,
  `mac` varchar(18) DEFAULT NULL,
  `status_remark` text,
  PRIMARY KEY (`id`),
  KEY `device_type_id` (`device_type_id`),
  KEY `title` (`title`),
  KEY `status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Volcado de tabla entries
# ------------------------------------------------------------

CREATE TABLE `entries` (
  `id` varchar(36) NOT NULL,
  `feed_id` varchar(36) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `content` text,
  `pubDate` timestamp NULL DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `guid` varchar(255) DEFAULT NULL,
  `author` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `md5` varchar(36) DEFAULT NULL,
  `status` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Volcado de tabla event_i18ns
# ------------------------------------------------------------

CREATE TABLE `event_i18ns` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `locale` varchar(6) NOT NULL,
  `model` varchar(255) NOT NULL,
  `foreign_key` varchar(36) NOT NULL,
  `field` varchar(255) NOT NULL,
  `content` text,
  PRIMARY KEY (`id`),
  KEY `locale` (`locale`),
  KEY `model` (`model`),
  KEY `row_id` (`foreign_key`),
  KEY `field` (`field`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Volcado de tabla events
# ------------------------------------------------------------

CREATE TABLE `events` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `startDate` date DEFAULT NULL,
  `endDate` date DEFAULT NULL,
  `startTime` time DEFAULT NULL,
  `endTime` time DEFAULT NULL,
  `circular_id` int(11) unsigned DEFAULT NULL,
  `continuous` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `circular_id` (`circular_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Volcado de tabla fakes
# ------------------------------------------------------------

CREATE TABLE `fakes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fake` varchar(50) DEFAULT NULL,
  `fk` varchar(36) DEFAULT NULL,
  `file` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Volcado de tabla feeds
# ------------------------------------------------------------

CREATE TABLE `feeds` (
  `id` varchar(36) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `description` text,
  `language` varchar(5) DEFAULT NULL,
  `copyright` varchar(255) DEFAULT NULL,
  `updated` timestamp NULL DEFAULT NULL,
  `feed` varchar(255) DEFAULT NULL,
  `planet_id` varchar(36) DEFAULT NULL,
  `slug` varchar(200) DEFAULT NULL,
  `approved` tinyint(1) DEFAULT NULL,
  `error` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `slug` (`slug`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Volcado de tabla groups
# ------------------------------------------------------------

CREATE TABLE `groups` (
  `id` varchar(36) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `parent_id` varchar(36) DEFAULT NULL,
  `lft` int(11) DEFAULT NULL,
  `rght` int(11) DEFAULT NULL,
  `description` text,
  `default` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Volcado de tabla groups_users
# ------------------------------------------------------------

CREATE TABLE `groups_users` (
  `user_id` varchar(36) DEFAULT NULL,
  `group_id` varchar(36) DEFAULT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Volcado de tabla i18n
# ------------------------------------------------------------

CREATE TABLE `i18n` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `locale` varchar(6) NOT NULL,
  `model` varchar(255) NOT NULL,
  `foreign_key` varchar(36) NOT NULL,
  `field` varchar(255) NOT NULL,
  `content` text,
  PRIMARY KEY (`id`),
  KEY `locale` (`locale`),
  KEY `model` (`model`),
  KEY `row_id` (`foreign_key`),
  KEY `field` (`field`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Volcado de tabla image_collections
# ------------------------------------------------------------

CREATE TABLE `image_collections` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(150) DEFAULT NULL,
  `description` text,
  `type` varchar(15) DEFAULT NULL,
  `slug` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Volcado de tabla item_i18ns
# ------------------------------------------------------------

CREATE TABLE `item_i18ns` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `locale` varchar(6) NOT NULL,
  `model` varchar(255) NOT NULL,
  `foreign_key` varchar(36) NOT NULL,
  `field` varchar(255) NOT NULL,
  `content` text,
  PRIMARY KEY (`id`),
  KEY `locale` (`locale`),
  KEY `model` (`model`),
  KEY `row_id` (`foreign_key`),
  KEY `field` (`field`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Volcado de tabla items
# ------------------------------------------------------------

CREATE TABLE `items` (
  `id` varchar(36) NOT NULL,
  `parent_id` varchar(36) DEFAULT NULL,
  `lft` int(11) DEFAULT NULL,
  `rght` int(11) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `enclosure_id` varchar(36) DEFAULT NULL,
  `pubDate` datetime DEFAULT NULL,
  `expiration` datetime DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `status` int(2) NOT NULL DEFAULT '0',
  `license_id` varchar(36) DEFAULT NULL,
  `channel_id` varchar(36) DEFAULT NULL,
  `featured` tinyint(1) NOT NULL DEFAULT '0',
  `stick` tinyint(1) NOT NULL DEFAULT '0',
  `remarks` text,
  `live` tinyint(1) NOT NULL DEFAULT '0',
  `allow_comments` int(2) NOT NULL DEFAULT '0',
  `search_if_expired` tinyint(1) NOT NULL DEFAULT '0',
  `readings` int(11) DEFAULT '0',
  `guest` varchar(200) DEFAULT NULL,
  `guestpwd` varchar(200) DEFAULT NULL,
  `home` tinyint(1) DEFAULT NULL,
  `level_id` int(11) unsigned NOT NULL DEFAULT '0',
  `subject_id` int(11) unsigned DEFAULT NULL,
  `gallery` varchar(75) DEFAULT 'bx',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Volcado de tabla items_users
# ------------------------------------------------------------

CREATE TABLE `items_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` varchar(36) DEFAULT NULL,
  `user_id` varchar(36) DEFAULT NULL,
  `role` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Volcado de tabla legacies
# ------------------------------------------------------------

CREATE TABLE `legacies` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Volcado de tabla levels
# ------------------------------------------------------------

CREATE TABLE `levels` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(200) DEFAULT NULL,
  `private` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Volcado de tabla licenses
# ------------------------------------------------------------

CREATE TABLE `licenses` (
  `id` varchar(36) NOT NULL,
  `license` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `code` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Volcado de tabla maintenance_types
# ------------------------------------------------------------

CREATE TABLE `maintenance_types` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Volcado de tabla maintenances
# ------------------------------------------------------------

CREATE TABLE `maintenances` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `device_id` int(11) unsigned DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `description` text,
  `action` text,
  `resolved` date DEFAULT NULL,
  `status` int(5) unsigned DEFAULT NULL,
  `remarks` text,
  `technician_id` int(11) unsigned DEFAULT NULL,
  `maintenance_type_id` int(11) unsigned DEFAULT NULL,
  `requested` date DEFAULT NULL,
  `detected` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Volcado de tabla menu_items
# ------------------------------------------------------------

CREATE TABLE `menu_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `menu_id` int(11) DEFAULT NULL,
  `label` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `order` int(11) DEFAULT NULL,
  `access` tinyint(2) NOT NULL DEFAULT '0',
  `help` varchar(250) DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `class` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `menu_id` (`menu_id`),
  KEY `url` (`url`),
  KEY `access` (`access`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Volcado de tabla menus
# ------------------------------------------------------------

CREATE TABLE `menus` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(200) DEFAULT NULL,
  `label` varchar(200) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `bar_id` int(11) unsigned DEFAULT NULL,
  `order` int(11) unsigned DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `help` varchar(250) DEFAULT NULL,
  `access` tinyint(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Volcado de tabla merit_types
# ------------------------------------------------------------

CREATE TABLE `merit_types` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(120) DEFAULT NULL,
  `help` text,
  `alias` varchar(120) DEFAULT NULL,
  `ignore_dates` tinyint(1) unsigned DEFAULT NULL,
  `title_label` varchar(120) DEFAULT NULL,
  `remarks_label` varchar(120) DEFAULT NULL,
  `start_date_label` varchar(120) DEFAULT NULL,
  `end_date_label` varchar(120) DEFAULT NULL,
  `use_dates` int(3) DEFAULT NULL,
  `allow_url` tinyint(1) NOT NULL DEFAULT '1',
  `allow_file` tinyint(1) NOT NULL DEFAULT '1',
  `url_label` varchar(120) DEFAULT NULL,
  `file_label` varchar(120) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Volcado de tabla merits
# ------------------------------------------------------------

CREATE TABLE `merits` (
  `id` char(36) NOT NULL DEFAULT '',
  `merit_type_id` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `remarks` text,
  `start` int(4) DEFAULT NULL,
  `end` int(4) DEFAULT NULL,
  `resume_id` char(36) DEFAULT NULL,
  `url` varchar(250) DEFAULT NULL,
  `file` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`id`),
  FULLTEXT KEY `title` (`title`,`remarks`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Volcado de tabla ownerships
# ------------------------------------------------------------

CREATE TABLE `ownerships` (
  `id` int(36) NOT NULL AUTO_INCREMENT,
  `owner_model` varchar(200) DEFAULT NULL,
  `owner_id` varchar(36) DEFAULT NULL,
  `object_model` varchar(200) DEFAULT NULL,
  `object_id` varchar(36) DEFAULT NULL,
  `access` int(8) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `object_model` (`object_model`,`object_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Volcado de tabla permissions
# ------------------------------------------------------------

CREATE TABLE `permissions` (
  `id` varchar(36) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `role_id` varchar(36) DEFAULT NULL,
  `url_pattern` varchar(255) DEFAULT NULL,
  `scope` int(8) DEFAULT '0',
  `model` varchar(255) DEFAULT NULL,
  `conditions` text,
  `access` int(2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `role_id` (`role_id`),
  KEY `url_pattern` (`url_pattern`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Volcado de tabla planets
# ------------------------------------------------------------

CREATE TABLE `planets` (
  `id` varchar(36) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text,
  `slug` varchar(255) DEFAULT NULL,
  `private` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `slug` (`slug`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Volcado de tabla positions
# ------------------------------------------------------------

CREATE TABLE `positions` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(120) DEFAULT NULL,
  `description` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Volcado de tabla prizes
# ------------------------------------------------------------

CREATE TABLE `prizes` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `number` int(11) DEFAULT NULL,
  `title` varchar(250) DEFAULT NULL,
  `sponsor` varchar(250) DEFAULT NULL,
  `special` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Volcado de tabla resources
# ------------------------------------------------------------

CREATE TABLE `resources` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(200) DEFAULT NULL,
  `description` text,
  `created` timestamp NULL DEFAULT NULL,
  `modified` timestamp NULL DEFAULT NULL,
  `user_id` varchar(36) DEFAULT NULL,
  `batch_id` int(11) unsigned DEFAULT NULL,
  `subject_id` int(11) unsigned DEFAULT NULL,
  `level_id` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `batch_id` (`batch_id`),
  KEY `title` (`title`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Volcado de tabla resources_uploads
# ------------------------------------------------------------

CREATE TABLE `resources_uploads` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `resource_id` int(11) unsigned DEFAULT NULL,
  `upload_id` varchar(36) DEFAULT NULL,
  `version` int(11) DEFAULT NULL,
  `comment` text,
  `created` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `resource_id` (`resource_id`),
  KEY `upload_id` (`upload_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Volcado de tabla resumes
# ------------------------------------------------------------

CREATE TABLE `resumes` (
  `id` char(36) NOT NULL DEFAULT '',
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `firstname` varchar(250) DEFAULT NULL,
  `lastname` varchar(250) DEFAULT NULL,
  `phone` varchar(11) DEFAULT NULL,
  `mobile` varchar(11) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `introduction` text,
  `address` varchar(255) DEFAULT NULL,
  `address2` varchar(255) DEFAULT NULL,
  `cp` varchar(5) DEFAULT NULL,
  `city` varchar(150) DEFAULT NULL,
  `province` varchar(60) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `employee` tinyint(1) NOT NULL DEFAULT '0',
  `position_id` int(11) unsigned DEFAULT NULL,
  `current_position` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Volcado de tabla roles
# ------------------------------------------------------------

CREATE TABLE `roles` (
  `id` varchar(36) NOT NULL,
  `role` varchar(200) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Volcado de tabla roles_users
# ------------------------------------------------------------

CREATE TABLE `roles_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(36) DEFAULT NULL,
  `role_id` varchar(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`,`role_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Volcado de tabla sections
# ------------------------------------------------------------

CREATE TABLE `sections` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(50) DEFAULT NULL,
  `cantine_group_id` int(11) unsigned DEFAULT NULL,
  `level_id` int(11) unsigned DEFAULT NULL,
  `cycle_id` int(11) unsigned DEFAULT NULL,
  `stage_id` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Volcado de tabla sindices
# ------------------------------------------------------------

CREATE TABLE `sindices` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `model` varchar(250) DEFAULT NULL,
  `fk` varchar(36) DEFAULT NULL,
  `content` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `model` (`model`,`fk`),
  KEY `model_2` (`model`,`fk`),
  KEY `fk` (`fk`),
  FULLTEXT KEY `content` (`content`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Volcado de tabla sites
# ------------------------------------------------------------

CREATE TABLE `sites` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `theme_id` varchar(36) DEFAULT NULL,
  `key` varchar(255) DEFAULT NULL,
  `layout` varchar(200) DEFAULT NULL,
  `theme` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Volcado de tabla stages
# ------------------------------------------------------------

CREATE TABLE `stages` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(200) DEFAULT NULL,
  `abbr` varchar(5) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Volcado de tabla static_i18ns
# ------------------------------------------------------------

CREATE TABLE `static_i18ns` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `locale` varchar(6) NOT NULL,
  `model` varchar(255) NOT NULL,
  `foreign_key` varchar(36) NOT NULL,
  `field` varchar(255) NOT NULL,
  `content` text,
  PRIMARY KEY (`id`),
  KEY `locale` (`locale`),
  KEY `model` (`model`),
  KEY `row_id` (`foreign_key`),
  KEY `field` (`field`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Volcado de tabla static_pages
# ------------------------------------------------------------

CREATE TABLE `static_pages` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) unsigned DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `readings` int(11) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `order` int(11) DEFAULT NULL,
  `lft` int(11) DEFAULT NULL,
  `rght` int(11) DEFAULT NULL,
  `project_key` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Volcado de tabla students
# ------------------------------------------------------------

CREATE TABLE `students` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(200) DEFAULT NULL,
  `lastname1` varchar(200) DEFAULT NULL,
  `lastname2` varchar(200) DEFAULT NULL,
  `extra1` smallint(3) NOT NULL DEFAULT '0',
  `extra2` tinyint(1) NOT NULL DEFAULT '0',
  `remarks` text,
  `section_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `section_id` (`section_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Volcado de tabla students_copy
# ------------------------------------------------------------

CREATE TABLE `students_copy` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(200) DEFAULT NULL,
  `lastname1` varchar(200) DEFAULT NULL,
  `lastname2` varchar(200) DEFAULT NULL,
  `extra1` smallint(3) NOT NULL DEFAULT '0',
  `extra2` tinyint(1) NOT NULL DEFAULT '0',
  `remarks` text,
  `section_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Volcado de tabla subjects
# ------------------------------------------------------------

CREATE TABLE `subjects` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Volcado de tabla tagged
# ------------------------------------------------------------

CREATE TABLE `tagged` (
  `id` varchar(36) NOT NULL,
  `foreign_key` varchar(36) NOT NULL,
  `tag_id` varchar(36) NOT NULL,
  `model` varchar(255) NOT NULL,
  `language` varchar(6) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQUE_TAGGING` (`model`,`foreign_key`,`tag_id`,`language`),
  KEY `INDEX_TAGGED` (`model`),
  KEY `INDEX_LANGUAGE` (`language`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Volcado de tabla tags
# ------------------------------------------------------------

CREATE TABLE `tags` (
  `id` varchar(36) NOT NULL,
  `identifier` varchar(30) DEFAULT NULL,
  `name` varchar(30) NOT NULL,
  `keyname` varchar(30) NOT NULL,
  `weight` int(2) NOT NULL DEFAULT '0',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQUE_TAG` (`identifier`,`keyname`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Volcado de tabla technicians
# ------------------------------------------------------------

CREATE TABLE `technicians` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(200) DEFAULT NULL,
  `email` varchar(250) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `remarks` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Volcado de tabla themes
# ------------------------------------------------------------

CREATE TABLE `themes` (
  `id` varchar(36) NOT NULL,
  `theme` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Volcado de tabla tickets
# ------------------------------------------------------------

CREATE TABLE `tickets` (
  `id` varchar(36) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `expiration` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `action` varchar(255) DEFAULT NULL,
  `model` varchar(255) DEFAULT NULL,
  `foreign_key` varchar(36) DEFAULT NULL,
  `used` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Volcado de tabla triggers
# ------------------------------------------------------------

CREATE TABLE `triggers` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `url_pattern` varchar(255) DEFAULT NULL,
  `on_date` date DEFAULT NULL,
  `off_date` date DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Volcado de tabla uploads
# ------------------------------------------------------------

CREATE TABLE `uploads` (
  `id` varchar(36) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `size` int(11) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `path` varchar(255) DEFAULT NULL,
  `fullpath` varchar(255) DEFAULT NULL,
  `description` text,
  `model` varchar(255) DEFAULT NULL,
  `foreign_key` varchar(36) DEFAULT NULL,
  `author` varchar(255) DEFAULT NULL,
  `width` int(11) DEFAULT NULL,
  `height` int(11) DEFAULT NULL,
  `playtime` int(15) DEFAULT NULL,
  `enclosure` tinyint(1) DEFAULT NULL,
  `order` int(11) unsigned DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `model` (`model`,`foreign_key`),
  KEY `model_2` (`model`),
  KEY `foreign_key` (`foreign_key`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Volcado de tabla users
# ------------------------------------------------------------

CREATE TABLE `users` (
  `id` varchar(36) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `realname` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `active` int(11) NOT NULL DEFAULT '0',
  `connected` datetime DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `bio` text,
  PRIMARY KEY (`id`),
  KEY `name` (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;




/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
