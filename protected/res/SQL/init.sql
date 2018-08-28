-- Inital database structure
SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';
CREATE TABLE `admin_users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL COMMENT 'Visible name of user',
  `email` varchar(128) NOT NULL COMMENT 'Used for login, restore password and security notifications',
  `pswd` varchar(128) NOT NULL COMMENT 'sha512 password hash',
  `role_id` int(2) unsigned NOT NULL DEFAULT '1' COMMENT 'Admin roles: 1 - for admin, 2 - for moderator',
  `is_active` int(1) unsigned NOT NULL DEFAULT '1' COMMENT '1 - enable, 0 - disable',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `name` (`name`),
  KEY `pswd` (`pswd`),
  KEY `is_active` (`is_active`),
  KEY `role_id` (`role_id`),
  CONSTRAINT `admin_users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `dictionary_admin_roles` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Admins & moderators';
CREATE TABLE `dictionary_admin_roles` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(32) NOT NULL COMMENT 'Title of admin user role',
  PRIMARY KEY (`id`),
  UNIQUE KEY `title` (`title`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='List of admin users roles';
INSERT INTO `dictionary_admin_roles` (`id`, `title`) VALUES
(1,	'admin'),
(2,	'moderator');
CREATE TABLE `dictionary_media_types` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(64) NOT NULL COMMENT 'Title of type',
  `file_extention` varchar(8) DEFAULT NULL COMMENT 'File extention, or NULL if it is not file',
  PRIMARY KEY (`id`),
  UNIQUE KEY `title` (`title`),
  KEY `file_extention` (`file_extention`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='List of avilable type of post media ';
INSERT INTO `dictionary_media_types` (`id`, `title`, `file_extention`) VALUES
(1,	'Empty',	NULL),
(2,	'Image (jpeg)',	'jpg'),
(3,	'Image (png)',	'png'),
(4,	'Image (gif)',	'gif'),
(5,	'Video (Youtube)',	NULL);
CREATE TABLE `dictionary_section_statuses` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(64) NOT NULL COMMENT 'Title of section type (for admin template)',
  PRIMARY KEY (`id`),
  UNIQUE KEY `title` (`title`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='List of statuses of section';
INSERT INTO `dictionary_section_statuses` (`id`, `title`) VALUES
(1,	'active'),
(3,	'closed'),
(2,	'hidden');
CREATE TABLE `dictionary_share_types` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(32) NOT NULL COMMENT 'Title of social network or method sharing',
  PRIMARY KEY (`id`),
  UNIQUE KEY `title` (`title`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='List of social networks and ways for sharing posts';
INSERT INTO `dictionary_share_types` (`id`, `title`) VALUES
(3,	'push'),
(2,	'telegram'),
(1,	'twitter');
CREATE TABLE `geoip` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ip` varchar(40) NOT NULL COMMENT 'IP, You can use hash instead, but in this way You must extent field size',
  `country` varchar(3) NOT NULL COMMENT 'Country code, 3 or 2 letters',
  PRIMARY KEY (`id`),
  UNIQUE KEY `ip` (`ip`),
  KEY `country` (`country`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Geoip data';
CREATE TABLE `mod2section` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `mod_id` int(11) unsigned NOT NULL COMMENT 'User ID of moderator',
  `section_id` int(11) unsigned NOT NULL COMMENT 'ID of section, that moderator can manage',
  PRIMARY KEY (`id`),
  KEY `mod_id` (`mod_id`),
  KEY `section_id` (`section_id`),
  CONSTRAINT `mod2section_ibfk_3` FOREIGN KEY (`section_id`) REFERENCES `sections` (`id`),
  CONSTRAINT `mod2section_ibfk_2` FOREIGN KEY (`mod_id`) REFERENCES `admin_users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Available sections for manage by moderators';
CREATE TABLE `posts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `relative_id` int(11) unsigned NOT NULL COMMENT 'ID post in section',
  `section_id` int(11) unsigned NOT NULL COMMENT 'ID of section',
  `parent_id` int(11) unsigned DEFAULT NULL COMMENT 'ID thread, NULL - if post is thread',
  `title` varchar(255) DEFAULT NULL COMMENT 'Title of post',
  `text` text COMMENT 'Text content of post',
  `media_path` varchar(128) DEFAULT NULL COMMENT 'Relative path of file, NULL - if file not set',
  `media_name` varchar(128) DEFAULT NULL COMMENT 'Name of file, NULL - if file not set',
  `media_type_id` int(11) unsigned NOT NULL DEFAULT '1' COMMENT 'Type of file, or ther media (like Youtube player) of post',
  `pswd` varchar(128) DEFAULT NULL COMMENT 'sha512 hash of users password',
  `username` varchar(128) NOT NULL DEFAULT 'Anonymous' COMMENT 'User name',
  `tripcode` varchar(128) DEFAULT NULL COMMENT 'Trip code (unique id of user password)',
  `created` int(11) unsigned NOT NULL COMMENT 'Time creation post',
  `upd` int(11) unsigned NOT NULL COMMENT 'Time of update (for threads)',
  `ip` varchar(40) NOT NULL COMMENT 'IP, You can use hash instead, but in this way You must extent field size',
  `is_active` int(1) unsigned NOT NULL DEFAULT '1' COMMENT '1 - post visible, 0 - post hidden for all',
  PRIMARY KEY (`id`),
  KEY `relative_id` (`relative_id`),
  KEY `section_id` (`section_id`),
  KEY `parent_id` (`parent_id`),
  KEY `title` (`title`),
  KEY `media_path` (`media_path`),
  KEY `media_name` (`media_name`),
  KEY `media_type_id` (`media_type_id`),
  KEY `pswd` (`pswd`),
  KEY `username` (`username`),
  KEY `tripcode` (`tripcode`),
  KEY `created` (`created`),
  KEY `upd` (`upd`),
  KEY `ip` (`ip`),
  KEY `is_active` (`is_active`),
  CONSTRAINT `posts_ibfk_2` FOREIGN KEY (`section_id`) REFERENCES `sections` (`id`),
  CONSTRAINT `posts_ibfk_3` FOREIGN KEY (`relative_id`) REFERENCES `posts` (`id`),
  CONSTRAINT `posts_ibfk_4` FOREIGN KEY (`media_type_id`) REFERENCES `dictionary_media_types` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Posts';
CREATE TABLE `post_citation` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `post_from_id` int(11) unsigned NOT NULL COMMENT 'ID post that have link to other post',
  `post_to_id` int(11) unsigned NOT NULL COMMENT 'ID post is referred to',
  PRIMARY KEY (`id`),
  KEY `post_from_id` (`post_from_id`),
  KEY `post_to_id` (`post_to_id`),
  CONSTRAINT `post_citation_ibfk_2` FOREIGN KEY (`post_to_id`) REFERENCES `posts` (`id`),
  CONSTRAINT `post_citation_ibfk_1` FOREIGN KEY (`post_from_id`) REFERENCES `posts` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Citation of post in other post';
CREATE TABLE `post_share` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `post_id` int(11) unsigned NOT NULL COMMENT 'ID post (thread)',
  `post_share_type_id` int(11) unsigned NOT NULL COMMENT 'ID of social network or sharing way',
  `date` int(11) unsigned NOT NULL COMMENT 'Time of sharing',
  PRIMARY KEY (`id`),
  KEY `post_id` (`post_id`),
  KEY `post_share_type_id` (`post_share_type_id`),
  KEY `date` (`date`),
  CONSTRAINT `post_share_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`),
  CONSTRAINT `post_share_ibfk_2` FOREIGN KEY (`post_share_type_id`) REFERENCES `dictionary_share_types` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Sharing posts';
CREATE TABLE `post_views` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `post_id` int(11) unsigned NOT NULL COMMENT 'ID post (thread)',
  `count` int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'Count of views by users',
  PRIMARY KEY (`id`),
  UNIQUE KEY `post_id` (`post_id`),
  KEY `count` (`count`),
  CONSTRAINT `post_views_ibfk_2` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Post views by users';
CREATE TABLE `sections` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(8) NOT NULL COMMENT 'Name section, part of URL',
  `title` varchar(128) NOT NULL COMMENT 'Title of section',
  `desription` varchar(256) NOT NULL COMMENT 'Short description of section',
  `age_restriction` int(2) unsigned NOT NULL DEFAULT '0' COMMENT 'Age restriction for users. 0 value - disable',
  `status_id` int(2) unsigned NOT NULL DEFAULT '1' COMMENT 'ID of section status',
  `sort` int(4) unsigned NOT NULL DEFAULT '0' COMMENT 'Sort value',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  UNIQUE KEY `title` (`title`),
  KEY `desription` (`desription`(255)),
  KEY `age_restriction` (`age_restriction`),
  KEY `status_id` (`status_id`),
  KEY `sort` (`sort`),
  CONSTRAINT `sections_ibfk_1` FOREIGN KEY (`status_id`) REFERENCES `dictionary_section_statuses` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Sections of site';
CREATE TABLE `sessions` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `hash` varchar(255) NOT NULL COMMENT 'Unique hash of section',
  `is_human` int(1) unsigned NOT NULL DEFAULT '1' COMMENT '1 - human, 0 - must validate humanity',
  `is_ban` int(1) unsigned NOT NULL DEFAULT '0' COMMENT '1 - banned for posting, 0 - all good',
  `created` int(11) unsigned NOT NULL COMMENT 'Time of creation session (first view site)',
  `upd` int(11) unsigned NOT NULL COMMENT 'Time of update session (last view site)',
  PRIMARY KEY (`id`),
  UNIQUE KEY `hash` (`hash`),
  KEY `is_human` (`is_human`),
  KEY `is_ban` (`is_ban`),
  KEY `created` (`created`),
  KEY `upd` (`upd`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='User sessions';
CREATE TABLE `session_ban` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `session_id` int(11) unsigned NOT NULL COMMENT 'ID user sesssion',
  `admin_id` int(11) unsigned DEFAULT NULL COMMENT 'ID admin who banned, user. NULL - for nobody',
  `mod_id` int(11) unsigned DEFAULT NULL COMMENT 'ID moderator who banned, user. NULL - for nobody',
  `message` varchar(255) NOT NULL COMMENT 'Reason of ban or message for user',
  `expire` int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'Time of end ban, 0 - for infinity ban',
  PRIMARY KEY (`id`),
  UNIQUE KEY `session_id` (`session_id`),
  KEY `admin_id` (`admin_id`),
  KEY `mod_id` (`mod_id`),
  KEY `message` (`message`),
  KEY `expire` (`expire`),
  CONSTRAINT `session_ban_ibfk_3` FOREIGN KEY (`mod_id`) REFERENCES `admin_users` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  CONSTRAINT `session_ban_ibfk_1` FOREIGN KEY (`session_id`) REFERENCES `sessions` (`id`),
  CONSTRAINT `session_ban_ibfk_2` FOREIGN KEY (`admin_id`) REFERENCES `admin_users` (`id`) ON DELETE SET NULL ON UPDATE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Ban users';
CREATE TABLE `session_ip` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `session_id` int(11) unsigned NOT NULL COMMENT 'ID user session',
  `ip` varchar(40) NOT NULL COMMENT 'IP, You can use hash instead, but in this way You must extent field size',
  PRIMARY KEY (`id`),
  UNIQUE KEY `ip` (`ip`),
  KEY `session_id` (`session_id`),
  CONSTRAINT `session_ip_ibfk_1` FOREIGN KEY (`session_id`) REFERENCES `sessions` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='User IP list';
DROP TABLE IF EXISTS `mod_users`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `mod_users` AS SELECT `admin_users`.`id` AS `id`,`admin_users`.`name` AS `name`,`admin_users`.`email` AS `email`,`admin_users`.`pswd` AS `pswd`,`fajno_new`.`admin_users`.`role_id` AS `role_id`,`fajno_new`.`admin_users`.`is_active` AS `is_active` FROM `admin_users` WHERE (`fajno_new`.`admin_users`.`role_id` = 2);
DROP TABLE IF EXISTS `threads`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `threads` AS SELECT `posts`.`id` AS `id`,`posts`.`relative_id` AS `relative_id`,`posts`.`section_id` AS `section_id`,`posts`.`parent_id` AS `parent_id`,`posts`.`title` AS `title`,`posts`.`text` AS `text`,`posts`.`media_path` AS `media_path`,`posts`.`media_name` AS `media_name`,`posts`.`media_type_id` AS `media_type_id`,`posts`.`pswd` AS `pswd`,`posts`.`username` AS `username`,`posts`.`tripcode` AS `tripcode`,`posts`.`created` AS `created`,`posts`.`upd` AS `upd`,`posts`.`ip` AS `ip`,`posts`.`is_active` AS `is_active` FROM `posts` WHERE (`posts`.`parent_id` = 0);