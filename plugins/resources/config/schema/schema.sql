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

CREATE TABLE `resources_uploads` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `resource_id` int(11) unsigned DEFAULT NULL,
  `upload_id` varchar(36) DEFAULT NULL,
  `version` int(11) DEFAULT NULL,
  `comment` text,
  `created` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;