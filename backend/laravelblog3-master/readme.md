Test blog project on Laravel.
"# laravelblog2"

127.0.0.1:3306
username: root
password: 
Таблицы:


CREATE TABLE `articles` (
 `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
 `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
 `text` varchar(10000) COLLATE utf8_unicode_ci NOT NULL,
 `desc` text COLLATE utf8_unicode_ci NOT NULL,
 `alias` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
 `updated_at` text COLLATE utf8_unicode_ci NOT NULL COMMENT 'хз зачем',
 `created_at` text COLLATE utf8_unicode_ci NOT NULL COMMENT 'gf',
 `image_file` text COLLATE utf8_unicode_ci,
 `tag` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
 PRIMARY KEY (`id`),
 UNIQUE KEY `articles_alias_unique` (`alias`)
) ENGINE=InnoDB AUTO_INCREMENT=66 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci


CREATE TABLE `comments` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `author` varchar(50) NOT NULL,
 `text` text NOT NULL,
 `post_id` int(11) NOT NULL,
 `date` datetime NOT NULL,
 `updated_at` date NOT NULL,
 `created_at` date NOT NULL,
 PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT


CREATE TABLE `files` (
 `id` int(10) NOT NULL AUTO_INCREMENT,
 `title` varchar(30) DEFAULT NULL,
 `name` varchar(30) DEFAULT NULL,
 `size` int(11) DEFAULT NULL,
 `type` varchar(11) DEFAULT NULL,
 `created_at` timestamp NULL DEFAULT NULL,
 `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
 PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8

REATE TABLE `tags` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `tagname` varchar(20) NOT NULL,
 `updated_at` text NOT NULL,
 `created_at` text NOT NULL,
 PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8
