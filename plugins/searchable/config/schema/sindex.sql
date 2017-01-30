CREATE TABLE `sindexes` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `model` varchar(250) DEFAULT NULL,
  `fk` varchar(36) DEFAULT NULL,
  `content` text NOT NULL,
  PRIMARY KEY (`id`),
  FULLTEXT KEY `content` (`content`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;