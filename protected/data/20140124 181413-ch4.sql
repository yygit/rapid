/*
MySQL Backup
Source Server Version: 5.5.25
Source Database: rapid
Date: 24.01.2014 18:14:13
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
--  Table structure for `auth_assignment`
-- ----------------------------
DROP TABLE IF EXISTS `auth_assignment`;
CREATE TABLE `auth_assignment` (
  `itemname` varchar(64) NOT NULL,
  `userid` int(10) unsigned NOT NULL,
  `bizrule` text,
  `data` text,
  PRIMARY KEY (`itemname`,`userid`),
  KEY `auth_assignment_ibfk_2` (`userid`),
  CONSTRAINT `auth_assignment_ibfk_1` FOREIGN KEY (`itemname`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `auth_assignment_ibfk_2` FOREIGN KEY (`userid`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `auth_item`
-- ----------------------------
DROP TABLE IF EXISTS `auth_item`;
CREATE TABLE `auth_item` (
  `name` varchar(64) NOT NULL,
  `type` int(11) NOT NULL,
  `description` text,
  `bizrule` text,
  `data` text,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `auth_item_child`
-- ----------------------------
DROP TABLE IF EXISTS `auth_item_child`;
CREATE TABLE `auth_item_child` (
  `parent` varchar(64) NOT NULL,
  `child` varchar(64) NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`),
  CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
  `borrower_id` int(10) unsigned DEFAULT NULL,
  `lendable` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `type_id` (`type_id`),
  KEY `grade_id` (`grade_id`),
  KEY `borrower_id` (`borrower_id`),
  CONSTRAINT `book_ibfk_1` FOREIGN KEY (`type_id`) REFERENCES `type` (`id`),
  CONSTRAINT `book_ibfk_2` FOREIGN KEY (`grade_id`) REFERENCES `grade` (`id`),
  CONSTRAINT `book_ibfk_3` FOREIGN KEY (`borrower_id`) REFERENCES `user` (`id`)
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
) ENGINE=InnoDB AUTO_INCREMENT=230 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `publisher`
-- ----------------------------
DROP TABLE IF EXISTS `publisher`;
CREATE TABLE `publisher` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `request`
-- ----------------------------
DROP TABLE IF EXISTS `request`;
CREATE TABLE `request` (
  `book_id` int(10) unsigned NOT NULL,
  `requester_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`book_id`,`requester_id`),
  KEY `requester_id` (`requester_id`),
  KEY `book_id` (`book_id`),
  CONSTRAINT `request_ibfk_1` FOREIGN KEY (`book_id`) REFERENCES `book` (`id`),
  CONSTRAINT `request_ibfk_2` FOREIGN KEY (`requester_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
--  Table structure for `tbl_audit_trail`
-- ----------------------------
DROP TABLE IF EXISTS `tbl_audit_trail`;
CREATE TABLE `tbl_audit_trail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `old_value` text,
  `new_value` text,
  `action` varchar(255) NOT NULL,
  `model` varchar(255) NOT NULL,
  `field` varchar(255) NOT NULL,
  `stamp` datetime NOT NULL,
  `user_id` varchar(255) DEFAULT NULL,
  `model_id` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_audit_trail_user_id` (`user_id`),
  KEY `idx_audit_trail_model_id` (`model_id`),
  KEY `idx_audit_trail_model` (`model`),
  KEY `idx_audit_trail_field` (`field`),
  KEY `idx_audit_trail_action` (`action`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `tbl_migration`
-- ----------------------------
DROP TABLE IF EXISTS `tbl_migration`;
CREATE TABLE `tbl_migration` (
  `version` varchar(255) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
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
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

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
INSERT INTO `auth_assignment` VALUES ('admin','5',NULL,'N;'), ('Authority','5','','s:0:\"\";'), ('borrower','6','','s:0:\"\";'), ('viewer','7',NULL,'N;'), ('wishlistAccess','7',NULL,'N;');
INSERT INTO `auth_item` VALUES ('admin','2','',NULL,'N;'), ('auditTrail@AdminAdmin','0',NULL,NULL,'N;'), ('auditTrail@AdminAdministrating','1',NULL,NULL,'N;'), ('auditTrail@AdminViewing','1',NULL,NULL,'N;'), ('auditTrail@DefaultIndex','0','','','s:0:\"\";'), ('Authority','2','srbac role','','s:0:\"\";'), ('BookAdmin','0','admin access to books',NULL,'N;'), ('BookCreate','0','create a book',NULL,'N;'), ('BookCreateAuthor','0','create an author for a book',NULL,'N;'), ('BookDelete','0','delete a book',NULL,'N;'), ('BookIndex','0','index of books',NULL,'N;'), ('BookRemoveAuthor','0','remove an author from a book',NULL,'N;'), ('BookUpdate','0','update a book',NULL,'N;'), ('BookView','0','read a book',NULL,'N;'), ('borrower','2','',NULL,'N;'), ('LibraryIndex','0','index of library',NULL,'N;'), ('LibraryLend','0','lend item from library, and remove request',NULL,'N;'), ('LibraryRequest','0','request item from library',NULL,'N;'), ('LibraryReturn','0','return book',NULL,'N;'), ('manageBook','1','manage book entries',NULL,'N;'), ('managePerson','1',NULL,NULL,'N;'), ('managePublisher','1','manage publisher entries',NULL,'N;'), ('manageUser','1','manage user entries',NULL,'N;'), ('manageWish','1','manage wish entries',NULL,'N;'), ('PersonAdmin','0',NULL,NULL,'N;'), ('PersonCreate','0',NULL,NULL,'N;'), ('PersonDelete','0',NULL,NULL,'N;'), ('PersonIndex','0',NULL,NULL,'N;'), ('PersonUpdate','0',NULL,NULL,'N;'), ('PersonView','0',NULL,NULL,'N;'), ('PublisherAdmin','0','admin access to publishers',NULL,'N;'), ('PublisherCreate','0','create a publisher',NULL,'N;'), ('PublisherDelete','0','delete a publisher',NULL,'N;'), ('PublisherIndex','0','index of publishers',NULL,'N;'), ('PublisherUpdate','0','update a publisher',NULL,'N;'), ('PublisherView','0','read a publisher',NULL,'N;'), ('UpdateOwnUser','1','update own user entry','return (Yii::app()->user->id==Yii::app()->getRequest()->getQuery(\'id\') || Yii::app()->user->id == $params[\'id\']);','N;'), ('UserAclist','0','autocomplete list for user',NULL,'N;'), ('UserAssignRole','0','','','s:0:\"\";'), ('UserCreate','0','create a user',NULL,'N;'), ('UserDelete','0','delete a user',NULL,'N;'), ('UserIndex','0','index of users',NULL,'N;'), ('UserReloadRoles','0','','','s:0:\"\";'), ('UserRevokeRole','0','','','s:0:\"\";'), ('UserUpdate','0','update a user',NULL,'N;'), ('UserView','0','read a user',NULL,'N;'), ('viewer','2','',NULL,'N;'), ('WishAdmin','0','admin access to wishes',NULL,'N;'), ('WishClaim','0','claim a wish',NULL,'N;'), ('WishCreate','0','create a wish',NULL,'N;'), ('WishCreateAuthor','0','create an author for a wish',NULL,'N;'), ('WishDelete','0','delete a wish',NULL,'N;'), ('WishIndex','0','index of wishes',NULL,'N;'), ('wishlistAccess','2','',NULL,'N;'), ('WishRemoveAuthor','0','remove an author from a wish',NULL,'N;'), ('WishUpdate','0','update a wish',NULL,'N;'), ('WishView','0','read a wish',NULL,'N;');
INSERT INTO `auth_item_child` VALUES ('auditTrail@AdminAdministrating','auditTrail@AdminAdmin'), ('admin','auditTrail@AdminAdministrating'), ('admin','auditTrail@AdminViewing'), ('auditTrail@AdminViewing','auditTrail@DefaultIndex'), ('manageBook','BookAdmin'), ('manageBook','BookCreate'), ('manageBook','BookCreateAuthor'), ('manageBook','BookDelete'), ('viewer','BookIndex'), ('manageBook','BookRemoveAuthor'), ('manageBook','BookUpdate'), ('viewer','BookView'), ('admin','borrower'), ('borrower','LibraryIndex'), ('admin','LibraryLend'), ('borrower','LibraryRequest'), ('admin','LibraryReturn'), ('admin','manageBook'), ('admin','managePerson'), ('admin','managePublisher'), ('admin','manageUser'), ('admin','manageWish'), ('managePerson','PersonAdmin'), ('managePerson','PersonCreate'), ('managePerson','PersonDelete'), ('managePerson','PersonIndex'), ('managePerson','PersonUpdate'), ('managePerson','PersonView'), ('managePublisher','PublisherAdmin'), ('managePublisher','PublisherCreate'), ('managePublisher','PublisherDelete'), ('managePublisher','PublisherIndex'), ('managePublisher','PublisherUpdate'), ('managePublisher','PublisherView'), ('wishlistAccess','UpdateOwnUser'), ('manageUser','UserAclist'), ('manageUser','UserAssignRole'), ('manageUser','UserCreate'), ('manageUser','UserDelete'), ('manageUser','UserIndex'), ('manageUser','UserReloadRoles'), ('manageUser','UserRevokeRole'), ('manageUser','UserUpdate'), ('UpdateOwnUser','UserUpdate'), ('manageUser','UserView'), ('UpdateOwnUser','UserView'), ('borrower','viewer'), ('manageWish','WishAdmin'), ('wishlistAccess','WishClaim'), ('manageWish','WishCreate'), ('manageWish','WishCreateAuthor'), ('manageWish','WishDelete'), ('wishlistAccess','WishIndex'), ('viewer','wishlistAccess'), ('manageWish','WishRemoveAuthor'), ('manageWish','WishUpdate'), ('wishlistAccess','WishView');
INSERT INTO `book` VALUES ('1','Batman','','2','2012-05-08','50.00','3.00','','1','1','1','5','1'), ('2','The Amazing Spider Man','','1','2012-02-13','10.00','3.00','This book is awesome. ','1','1','1','5','1'), ('3','X-Men','','3','0000-00-00','5.00','1.00','Awesome','1','6','0',NULL,'0'), ('4','Sandman',NULL,'2','2012-05-17','8.00','3.00','','0','2','0','5','1'), ('5','Green Lantern','','3','2012-05-01','3.00','3.00','','0','1','0',NULL,'0'), ('6','Witchblade',NULL,'3','2000-03-01','15.00','2.00','','0','1','1','6','1'), ('7','300',NULL,'2','2002-10-01','15.00','3.00','','0','6','0','5','1'), ('8','Wolverine','','3','1982-05-01','67.00','1.00','','1','1','1',NULL,'0'), ('9','Stardust',NULL,'1','0000-00-00','0.00','0.00','','0','1','0',NULL,'1'), ('10','The Phantom Programmer',NULL,'3','2012-05-08','1.00','1.00','','1','4','1','6','1');
INSERT INTO `bookauthor` VALUES ('10','1');
INSERT INTO `bookillustrator` VALUES ('10','2'), ('10','3');
INSERT INTO `bookpublisher` VALUES ('10','1'), ('10','2');
INSERT INTO `grade` VALUES ('1','mint'), ('2','near mint'), ('3','very fine'), ('4','fine'), ('5','very good'), ('6','good'), ('7','fair'), ('8','poor');
INSERT INTO `person` VALUES ('11','admin','admin'), ('1','Comic','Author'), ('12','demo1','demo2'), ('15','guest','guest'), ('2','Illus','Trator'), ('226','Jean','Giraud'), ('227','John','Smith'), ('3','Manga','Maniac');
INSERT INTO `publisher` VALUES ('1','Pub Co'), ('2','Bup Co');
INSERT INTO `request` VALUES ('6','5');
INSERT INTO `tbl_audit_trail` VALUES ('1','','','CREATE','User','N/A','2014-01-24 15:25:12','5','8'), ('2','','kjgh','SET','User','username','2014-01-24 15:25:12','5','8'), ('3','','228','SET','User','person_id','2014-01-24 15:25:12','5','8'), ('4','','$1$o6..RV5.$cJMBNGGupYQSUIKXnkQhZ.','SET','User','pwd_hash','2014-01-24 15:25:12','5','8'), ('5','','8','SET','User','id','2014-01-24 15:25:12','5','8'), ('6','','','DELETE','User','N/A','2014-01-24 15:26:21','5','8'), ('7','','','CREATE','User','N/A','2014-01-24 15:28:40','5','9'), ('8','','kjgh','SET','User','username','2014-01-24 15:28:40','5','9'), ('9','','229','SET','User','person_id','2014-01-24 15:28:40','5','9'), ('10','','$1$RC2.G.3.$6M/OGMDglq2r2akumVyD4.','SET','User','pwd_hash','2014-01-24 15:28:40','5','9'), ('11','','9','SET','User','id','2014-01-24 15:28:40','5','9'), ('12','','','DELETE','User','N/A','2014-01-24 15:39:48','5','9'), ('13','$1$JG1.ea5.$7wNAEuNYfyo9MDua18nEt1','$1$/A4.aK0.$GrOSCNZo/FMd.ApBblZXA/','CHANGE','User','pwd_hash','2014-01-24 15:41:26','5','6'), ('14','demo','demo1','CHANGE','User','username','2014-01-24 15:43:19','5','6'), ('15','demo1','demo','CHANGE','User','username','2014-01-24 15:45:12','5','6'), ('16','$1$/A4.aK0.$GrOSCNZo/FMd.ApBblZXA/','$1$bj2.IC4.$hFVA8YMxX8kohdgRspjin1','CHANGE','User','pwd_hash','2014-01-24 15:45:12','5','6'), ('17','demo','demo2','CHANGE','User','username','2014-01-24 16:29:50','5','6'), ('18','demo2','demo','CHANGE','User','username','2014-01-24 16:30:08','5','6'), ('19','demo','demo1','CHANGE','Person','fname','2014-01-24 16:32:29','5','12'), ('20','demo','demo2','CHANGE','Person','lname','2014-01-24 16:32:29','5','12'), ('21',NULL,'5','CHANGE','Book','borrower_id','2014-01-24 16:38:19','5','4'), ('22','0','1','CHANGE','Book','signed','2014-01-24 16:56:48','5','1'), ('23','6','5','CHANGE','Book','borrower_id','2014-01-24 17:01:14','5','2'), ('24','','','CREATE','Request','N/A','2014-01-24 17:03:19','5','array'), ('25','','7','SET','Request','book_id','2014-01-24 17:03:19','5','array'), ('26','','5','SET','Request','requester_id','2014-01-24 17:03:19','5','array'), ('27','','','DELETE','Request','N/A','2014-01-24 17:06:34','5','Array\n(\n    [book_id] => 7\n    [requester_id] => 5\n)\n'), ('28',NULL,'5','CHANGE','Book','borrower_id','2014-01-24 17:06:34','5','7');
INSERT INTO `tbl_migration` VALUES ('m000000_000000_base','1390572445'), ('m110517_155003_create_tables_audit_trail','1390572448');
INSERT INTO `type` VALUES ('1','trade'), ('2','graphic novel'), ('3','issue');
INSERT INTO `user` VALUES ('5','admin','$1$uO..fZ1.$VYs5QxodY1nK.hu7zq4uq0','11'), ('6','demo','$1$bj2.IC4.$hFVA8YMxX8kohdgRspjin1','12'), ('7','guest','$1$lt..KF2.$4dBGyMO.Jvv9jBCuO8jC0/','15');
INSERT INTO `wish` VALUES ('1','Moebius\' Airtight Garage Vol.1','1','1','0000-00-00','http://www.amazon.com/Moebius-Airtight-Garage-Vol-1-No/dp/B00178YGFE/ref=sr_1_3?s=books&ie=UTF8&qid=1339476850&sr=1-3','','6'), ('2','The Squiddy Avenger','1','1','2012-06-21','http://www.amazon.com','','5'), ('3','another great title','','1','2012-06-21','','','6'), ('8','test wish','1','2','2014-01-08','','dsfasdf asdfgasdfg ','7'), ('9','another one','','1','2014-01-09','','ddddddd1',NULL);
INSERT INTO `wishauthor` VALUES ('8','1'), ('9','3'), ('8','12'), ('9','12'), ('1','226'), ('2','227');
