SET FOREIGN_KEY_CHECKS=0;
 
DROP TABLE IF EXISTS `wish`;  
CREATE TABLE `wish` (
`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
`title` varchar(256) NOT NULL,
`issue_number` varchar(10) DEFAULT NULL,
`type_id` int(10) unsigned DEFAULT NULL,
`publication_date` date DEFAULT NULL,
`store_link` varchar(255) DEFAULT NULL,
`notes` text DEFAULT NULL,
`got_it` int(10) unsigned DEFAULT NULL,
PRIMARY KEY (`id`),
KEY `type_id` (`type_id`),
KEY `got_it` (`got_it`),
CONSTRAINT `wish_ibfk_1` FOREIGN KEY (`type_id`) REFERENCES `type` (`id`),
CONSTRAINT `wish_ibfk_2` FOREIGN KEY (`got_it`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `wishauthor`;  
CREATE TABLE `wishauthor` (
`wish_id` int(10) unsigned NOT NULL,
`author_id` int(10) unsigned NOT NULL,
PRIMARY KEY (`wish_id`,`author_id`),
KEY `author_id` (`author_id`),
CONSTRAINT `wishauthor_ibfk_1` FOREIGN KEY (`wish_id`) REFERENCES `wish` (`id`) ON DELETE CASCADE,
CONSTRAINT `wishauthor_ibfk_2` FOREIGN KEY(`author_id`) REFERENCES `person` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `wishillustrator`;  
CREATE TABLE `wishillustrator` (
`wish_id` int(10) unsigned NOT NULL,
`illustrator_id` int(10) unsigned NOT NULL,
PRIMARY KEY (`wish_id`,`illustrator_id`),
KEY `illustrator_id` (`illustrator_id`),
CONSTRAINT `wishillustrator_ibfk_1` FOREIGN KEY (`wish_id`) REFERENCES `wish` (`id`) ON DELETE CASCADE,
CONSTRAINT `wishillustrator_ibfk_2` FOREIGN KEY (`illustrator_id`) REFERENCES `person` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `wishpublisher`;  
CREATE TABLE `wishpublisher` (
`wish_id` int(10) unsigned NOT NULL,
`publisher_id` int(10) unsigned NOT NULL,
PRIMARY KEY (`wish_id`,`publisher_id`),
KEY `publisher_id` (`publisher_id`),
CONSTRAINT `wishpublisher_ibfk_1` FOREIGN KEY (`wish_id`) REFERENCES `wish` (`id`) ON DELETE CASCADE,
CONSTRAINT `wishpublisher_ibfk_2` FOREIGN KEY (`publisher_id`) REFERENCES `publisher` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;