/*
MySQL Backup
Source Server Version: 5.5.25
Source Database: rapid
Date: 09.01.2014 14:21:45
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
--  Table structure for `book`
-- ----------------------------
DROP TABLE IF EXISTS `book`;
CREATE TABLE `book` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(256) NOT NULL,
  `issue_number` varchar(10) DEFAULT NULL,
  `type_id` int(10) unsigned DEFAULT NULL,
  `publication_date` date DEFAULT NULL,
  `value` decimal(10,2) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `notes` text,
  `signed` tinyint(1) DEFAULT NULL,
  `grade_id` int(10) unsigned DEFAULT NULL,
  `bagged` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `type_id` (`type_id`),
  KEY `grade_id` (`grade_id`),
  CONSTRAINT `book_ibfk_1` FOREIGN KEY (`type_id`) REFERENCES `type` (`id`),
  CONSTRAINT `book_ibfk_2` FOREIGN KEY (`grade_id`) REFERENCES `grade` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `bookauthor`
-- ----------------------------
DROP TABLE IF EXISTS `bookauthor`;
CREATE TABLE `bookauthor` (
  `book_id` int(10) unsigned NOT NULL,
  `author_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`book_id`,`author_id`),
  KEY `author_id` (`author_id`),
  CONSTRAINT `bookauthor_ibfk_1` FOREIGN KEY (`book_id`) REFERENCES `book` (`id`) ON DELETE CASCADE,
  CONSTRAINT `bookauthor_ibfk_2` FOREIGN KEY (`author_id`) REFERENCES `person` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `bookillustrator`
-- ----------------------------
DROP TABLE IF EXISTS `bookillustrator`;
CREATE TABLE `bookillustrator` (
  `book_id` int(10) unsigned NOT NULL,
  `illustrator_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`book_id`,`illustrator_id`),
  KEY `illustrator_id` (`illustrator_id`),
  CONSTRAINT `bookillustrator_ibfk_1` FOREIGN KEY (`book_id`) REFERENCES `book` (`id`) ON DELETE CASCADE,
  CONSTRAINT `bookillustrator_ibfk_2` FOREIGN KEY (`illustrator_id`) REFERENCES `person` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `bookpublisher`
-- ----------------------------
DROP TABLE IF EXISTS `bookpublisher`;
CREATE TABLE `bookpublisher` (
  `book_id` int(10) unsigned NOT NULL,
  `publisher_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`book_id`,`publisher_id`),
  KEY `publisher_id` (`publisher_id`),
  CONSTRAINT `bookpublisher_ibfk_1` FOREIGN KEY (`book_id`) REFERENCES `book` (`id`) ON DELETE CASCADE,
  CONSTRAINT `bookpublisher_ibfk_2` FOREIGN KEY (`publisher_id`) REFERENCES `publisher` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `booktag`
-- ----------------------------
DROP TABLE IF EXISTS `booktag`;
CREATE TABLE `booktag` (
  `book_id` int(10) unsigned NOT NULL,
  `tag_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`book_id`,`tag_id`),
  KEY `tag_id` (`tag_id`),
  CONSTRAINT `booktag_ibfk_1` FOREIGN KEY (`book_id`) REFERENCES `book` (`id`) ON DELETE CASCADE,
  CONSTRAINT `booktag_ibfk_2` FOREIGN KEY (`tag_id`) REFERENCES `tag` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `grade`
-- ----------------------------
DROP TABLE IF EXISTS `grade`;
CREATE TABLE `grade` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(256) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `person`
-- ----------------------------
DROP TABLE IF EXISTS `person`;
CREATE TABLE `person` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `fname` varchar(64) NOT NULL,
  `lname` varchar(64) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `names_unique` (`fname`,`lname`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=228 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `publisher`
-- ----------------------------
DROP TABLE IF EXISTS `publisher`;
CREATE TABLE `publisher` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `tag`
-- ----------------------------
DROP TABLE IF EXISTS `tag`;
CREATE TABLE `tag` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `value` varchar(64) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `type`
-- ----------------------------
DROP TABLE IF EXISTS `type`;
CREATE TABLE `type` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(256) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `user`
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `pwd_hash` char(34) NOT NULL,
  `person_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  KEY `userperson_ibfk_2` (`person_id`),
  CONSTRAINT `userperson_ibfk_2` FOREIGN KEY (`person_id`) REFERENCES `person` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `wish`
-- ----------------------------
DROP TABLE IF EXISTS `wish`;
CREATE TABLE `wish` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(256) NOT NULL,
  `issue_number` varchar(10) DEFAULT NULL,
  `type_id` int(10) unsigned DEFAULT NULL,
  `publication_date` date DEFAULT NULL,
  `store_link` varchar(255) DEFAULT NULL,
  `notes` text,
  `got_it` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `type_id` (`type_id`),
  KEY `got_it` (`got_it`),
  CONSTRAINT `wish_ibfk_1` FOREIGN KEY (`type_id`) REFERENCES `type` (`id`),
  CONSTRAINT `wish_ibfk_2` FOREIGN KEY (`got_it`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `wishauthor`
-- ----------------------------
DROP TABLE IF EXISTS `wishauthor`;
CREATE TABLE `wishauthor` (
  `wish_id` int(10) unsigned NOT NULL,
  `author_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`wish_id`,`author_id`),
  KEY `author_id` (`author_id`),
  CONSTRAINT `wishauthor_ibfk_1` FOREIGN KEY (`wish_id`) REFERENCES `wish` (`id`) ON DELETE CASCADE,
  CONSTRAINT `wishauthor_ibfk_2` FOREIGN KEY (`author_id`) REFERENCES `person` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `wishillustrator`
-- ----------------------------
DROP TABLE IF EXISTS `wishillustrator`;
CREATE TABLE `wishillustrator` (
  `wish_id` int(10) unsigned NOT NULL,
  `illustrator_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`wish_id`,`illustrator_id`),
  KEY `illustrator_id` (`illustrator_id`),
  CONSTRAINT `wishillustrator_ibfk_1` FOREIGN KEY (`wish_id`) REFERENCES `wish` (`id`) ON DELETE CASCADE,
  CONSTRAINT `wishillustrator_ibfk_2` FOREIGN KEY (`illustrator_id`) REFERENCES `person` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `wishpublisher`
-- ----------------------------
DROP TABLE IF EXISTS `wishpublisher`;
CREATE TABLE `wishpublisher` (
  `wish_id` int(10) unsigned NOT NULL,
  `publisher_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`wish_id`,`publisher_id`),
  KEY `publisher_id` (`publisher_id`),
  CONSTRAINT `wishpublisher_ibfk_1` FOREIGN KEY (`wish_id`) REFERENCES `wish` (`id`) ON DELETE CASCADE,
  CONSTRAINT `wishpublisher_ibfk_2` FOREIGN KEY (`publisher_id`) REFERENCES `publisher` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records 
-- ----------------------------
INSERT INTO `book` VALUES ('1','Batman',NULL,'2','2012-05-08','50.00','3.00','','0','1','1'), ('2','The Amazing Spider Man',NULL,'1','2012-02-13','10.00','3.00','This book is awesome. ','1','1','1'), ('3','X-Men',NULL,'3','0000-00-00','5.00','1.00','Awesome','1','6','0'), ('4','Sandman',NULL,'2','2012-05-17','8.00','3.00','','0','2','0'), ('5','Green Lantern',NULL,'3','2012-05-01','3.00','3.00','','0','1','0'), ('6','Witchblade',NULL,'3','2000-03-01','15.00','2.00','','0','1','1'), ('7','300',NULL,'2','2002-10-01','15.00','3.00','','0','6','0'), ('8','Wolverine',NULL,'3','1982-05-01','67.00','1.00','','1','1','1'), ('9','Stardust',NULL,'1','0000-00-00','0.00','0.00','','0','1','0'), ('10','The Phantom Programmer',NULL,'3','2012-05-08','1.00','1.00','','1','4','1');
INSERT INTO `bookauthor` VALUES ('10','1');
INSERT INTO `bookillustrator` VALUES ('10','2'), ('10','3');
INSERT INTO `bookpublisher` VALUES ('10','1');
INSERT INTO `grade` VALUES ('1','mint'), ('2','near mint'), ('3','very fine'), ('4','fine'), ('5','very good'), ('6','good'), ('7','fair'), ('8','poor');
INSERT INTO `person` VALUES ('11','admin','admin'), ('1','Comic','Author'), ('12','demo','demo'), ('15','guest','guest'), ('2','Illus','Trator'), ('226','Jean','Giraud'), ('227','John','Smith'), ('3','Manga','Maniac');
INSERT INTO `publisher` VALUES ('1','Pub Co');
INSERT INTO `type` VALUES ('1','trade'), ('2','graphic novel'), ('3','issue');
INSERT INTO `user` VALUES ('5','admin','$1$uO..fZ1.$VYs5QxodY1nK.hu7zq4uq0','11'), ('6','demo','$1$JG1.ea5.$7wNAEuNYfyo9MDua18nEt1','12'), ('7','guest','$1$lt..KF2.$4dBGyMO.Jvv9jBCuO8jC0/','15');
INSERT INTO `wish` VALUES ('1','Moebius\' Airtight Garage Vol.1','1','1','0000-00-00','http://www.amazon.com/Moebius-Airtight-Garage-Vol-1-No/dp/B00178YGFE/ref=sr_1_3?s=books&ie=UTF8&qid=1339476850&sr=1-3','',NULL), ('2','The Squiddy Avenger','1','1','2012-06-21','www.amazon.com','',NULL), ('3','another great title','','1','2012-06-21','','',NULL), ('8','test wish','1','2','2014-01-08','','dsfasdf asdfgasdfg ',NULL), ('9','another one','','1','2014-01-09','','ddddddd1',NULL);
INSERT INTO `wishauthor` VALUES ('8','1'), ('9','3'), ('8','12'), ('9','12'), ('1','226'), ('2','227');
