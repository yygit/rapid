/*
MySQL Backup
Source Server Version: 5.5.25
Source Database: rapid
Date: 11.03.2014 14:16:53
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
  KEY `auth_assignment_ibfk_2` (`userid`) USING BTREE,
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
  KEY `child` (`child`) USING BTREE,
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
--  Table structure for `game`
-- ----------------------------
DROP TABLE IF EXISTS `game`;
CREATE TABLE `game` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `target` varchar(80) NOT NULL DEFAULT '',
  `guessed` varchar(26) NOT NULL DEFAULT '',
  `book_id` int(10) unsigned DEFAULT NULL,
  `author_id` int(10) unsigned DEFAULT NULL,
  `book_decoy1_id` int(10) unsigned DEFAULT NULL,
  `book_decoy2_id` int(10) unsigned DEFAULT NULL,
  `book_decoy3_id` int(10) unsigned DEFAULT NULL,
  `fails` tinyint(3) unsigned DEFAULT '0',
  `token` varchar(64) NOT NULL,
  `game_type_id` int(10) unsigned NOT NULL,
  `win` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `token` (`token`),
  KEY `game_type_id` (`game_type_id`),
  KEY `book_id` (`book_id`),
  KEY `author_id` (`author_id`),
  KEY `book_decoy1_id` (`book_decoy1_id`),
  KEY `book_decoy2_id` (`book_decoy2_id`),
  KEY `book_decoy3_id` (`book_decoy3_id`),
  CONSTRAINT `game_ibfk_1` FOREIGN KEY (`game_type_id`) REFERENCES `game_type` (`id`),
  CONSTRAINT `game_ibfk_2` FOREIGN KEY (`book_id`) REFERENCES `book` (`id`),
  CONSTRAINT `game_ibfk_3` FOREIGN KEY (`author_id`) REFERENCES `person` (`id`),
  CONSTRAINT `game_ibfk_4` FOREIGN KEY (`book_decoy1_id`) REFERENCES `book` (`id`),
  CONSTRAINT `game_ibfk_5` FOREIGN KEY (`book_decoy2_id`) REFERENCES `book` (`id`),
  CONSTRAINT `game_ibfk_6` FOREIGN KEY (`book_decoy3_id`) REFERENCES `book` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `game_type`
-- ----------------------------
DROP TABLE IF EXISTS `game_type`;
CREATE TABLE `game_type` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `devname` varchar(20) DEFAULT NULL,
  `name` varchar(40) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

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
--  Table structure for `job`
-- ----------------------------
DROP TABLE IF EXISTS `job`;
CREATE TABLE `job` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL,
  `action` varchar(64) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `job_scheduled`
-- ----------------------------
DROP TABLE IF EXISTS `job_scheduled`;
CREATE TABLE `job_scheduled` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `params` text,
  `output` text,
  `job_id` int(10) unsigned NOT NULL,
  `scheduled_time` datetime DEFAULT NULL,
  `started` datetime DEFAULT NULL,
  `completed` datetime DEFAULT NULL,
  `active` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `job_id` (`job_id`),
  CONSTRAINT `job_scheduled_ibfk_1` FOREIGN KEY (`job_id`) REFERENCES `job` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB AUTO_INCREMENT=342 DEFAULT CHARSET=utf8;

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
INSERT INTO `auth_assignment` VALUES ('admin','5',NULL,'N;'), ('Authority','5','','s:0:\"\";'), ('borrower','6','','s:0:\"\";'), ('viewer','7',NULL,'N;'), ('wishlistAccess','7',NULL,'N;');
INSERT INTO `auth_item` VALUES ('admin','2','',NULL,'N;'), ('auditTrail@AdminAdmin','0',NULL,NULL,'N;'), ('auditTrail@AdminAdministrating','1',NULL,NULL,'N;'), ('auditTrail@AdminViewing','1',NULL,NULL,'N;'), ('auditTrail@DefaultIndex','0','','','s:0:\"\";'), ('Authority','2','srbac role','','s:0:\"\";'), ('BookAdmin','0','admin access to books',NULL,'N;'), ('BookCreate','0','create a book',NULL,'N;'), ('BookCreateAuthor','0','create an author for a book',NULL,'N;'), ('BookDelete','0','delete a book',NULL,'N;'), ('BookIndex','0','index of books',NULL,'N;'), ('BookRemoveAuthor','0','remove an author from a book',NULL,'N;'), ('BookTitlelist','0',NULL,NULL,'N;'), ('BookUpdate','0','update a book',NULL,'N;'), ('BookView','0','read a book',NULL,'N;'), ('borrower','2','',NULL,'N;'), ('CvAdministrating','1',NULL,NULL,'N;'), ('CvIndex','0',NULL,NULL,'N;'), ('CvIssues','0',NULL,NULL,'N;'), ('CvSearch','0',NULL,NULL,'N;'), ('CvViewing','1',NULL,NULL,'N;'), ('GpfAdministrating','1',NULL,NULL,'N;'), ('GpfIndex','0',NULL,NULL,'N;'), ('GpfViewing','1',NULL,NULL,'N;'), ('HangmanAdministrating','1',NULL,NULL,'N;'), ('HangmanCreate','0',NULL,NULL,'N;'), ('HangmanPlay','0',NULL,NULL,'N;'), ('HangmanTest','0',NULL,NULL,'N;'), ('HangmanToken','0',NULL,NULL,'N;'), ('HangmanViewing','1',NULL,NULL,'N;'), ('jobQueue@JobCreate','0',NULL,NULL,'N;'), ('jobQueue@JobDelete','0',NULL,NULL,'N;'), ('jobQueue@JobIndex','0',NULL,NULL,'N;'), ('jobQueue@JobScheduledCreate','0',NULL,NULL,'N;'), ('jobQueue@JobScheduledDelete','0',NULL,NULL,'N;'), ('jobQueue@JobScheduledIndex','0',NULL,NULL,'N;'), ('jobQueue@JobScheduledUpdate','0',NULL,NULL,'N;'), ('jobQueue@JobScheduledView','0',NULL,NULL,'N;'), ('jobQueue@JobUpdate','0',NULL,NULL,'N;'), ('jobQueue@JobView','0',NULL,NULL,'N;'), ('jobsAndReports','1','','','s:0:\"\";'), ('LibraryIndex','0','index of library',NULL,'N;'), ('LibraryLend','0','lend item from library, and remove request',NULL,'N;'), ('LibraryRequest','0','request item from library',NULL,'N;'), ('LibraryReturn','0','return book',NULL,'N;'), ('manageBook','1','manage book entries',NULL,'N;'), ('managePerson','1',NULL,NULL,'N;'), ('managePublisher','1','manage publisher entries',NULL,'N;'), ('manageUser','1','manage user entries',NULL,'N;'), ('manageWish','1','manage wish entries',NULL,'N;'), ('PersonAdmin','0',NULL,NULL,'N;'), ('PersonCreate','0',NULL,NULL,'N;'), ('PersonDelete','0',NULL,NULL,'N;'), ('PersonIndex','0',NULL,NULL,'N;'), ('PersonUpdate','0',NULL,NULL,'N;'), ('PersonView','0',NULL,NULL,'N;'), ('PublisherAdmin','0','admin access to publishers',NULL,'N;'), ('PublisherCreate','0','create a publisher',NULL,'N;'), ('PublisherDelete','0','delete a publisher',NULL,'N;'), ('PublisherIndex','0','index of publishers',NULL,'N;'), ('PublisherUpdate','0','update a publisher',NULL,'N;'), ('PublisherView','0','read a publisher',NULL,'N;'), ('ReportIndex','0','','','s:0:\"\";'), ('UpdateOwnUser','1','update own user entry','return (Yii::app()->user->id==Yii::app()->getRequest()->getQuery(\'id\') || Yii::app()->user->id == $params[\'id\']);','N;'), ('UserAclist','0','autocomplete list for user',NULL,'N;'), ('UserAssignRole','0','','','s:0:\"\";'), ('UserCreate','0','create a user',NULL,'N;'), ('UserDelete','0','delete a user',NULL,'N;'), ('UserIndex','0','index of users',NULL,'N;'), ('UserReloadRoles','0','','','s:0:\"\";'), ('UserRevokeRole','0','','','s:0:\"\";'), ('UserUpdate','0','update a user',NULL,'N;'), ('UserView','0','read a user',NULL,'N;'), ('viewer','2','',NULL,'N;'), ('WishAdmin','0','admin access to wishes',NULL,'N;'), ('WishClaim','0','claim a wish',NULL,'N;'), ('WishCreate','0','create a wish',NULL,'N;'), ('WishCreateAuthor','0','create an author for a wish',NULL,'N;'), ('WishDelete','0','delete a wish',NULL,'N;'), ('WishIndex','0','index of wishes',NULL,'N;'), ('wishlistAccess','2','',NULL,'N;'), ('WishRemoveAuthor','0','remove an author from a wish',NULL,'N;'), ('WishUpdate','0','update a wish',NULL,'N;'), ('WishView','0','read a wish',NULL,'N;'), ('WroteitAdministrating','1',NULL,NULL,'N;'), ('WroteitCreate','0',NULL,NULL,'N;'), ('WroteitPlay','0',NULL,NULL,'N;'), ('WroteitToken','0',NULL,NULL,'N;'), ('WroteitViewing','1',NULL,NULL,'N;');
INSERT INTO `auth_item_child` VALUES ('auditTrail@AdminAdministrating','auditTrail@AdminAdmin'), ('admin','auditTrail@AdminAdministrating'), ('admin','auditTrail@AdminViewing'), ('auditTrail@AdminViewing','auditTrail@DefaultIndex'), ('manageBook','BookAdmin'), ('manageBook','BookCreate'), ('manageBook','BookCreateAuthor'), ('manageBook','BookDelete'), ('viewer','BookIndex'), ('manageBook','BookRemoveAuthor'), ('HangmanAdministrating','BookTitlelist'), ('HangmanViewing','BookTitlelist'), ('manageBook','BookUpdate'), ('viewer','BookView'), ('admin','borrower'), ('admin','CvAdministrating'), ('CvAdministrating','CvIndex'), ('CvViewing','CvIndex'), ('CvAdministrating','CvIssues'), ('CvViewing','CvIssues'), ('CvAdministrating','CvSearch'), ('CvViewing','CvSearch'), ('viewer','CvViewing'), ('admin','GpfAdministrating'), ('GpfAdministrating','GpfIndex'), ('GpfViewing','GpfIndex'), ('viewer','GpfViewing'), ('admin','HangmanAdministrating'), ('HangmanAdministrating','HangmanCreate'), ('HangmanAdministrating','HangmanPlay'), ('HangmanViewing','HangmanPlay'), ('HangmanAdministrating','HangmanTest'), ('HangmanViewing','HangmanTest'), ('HangmanAdministrating','HangmanToken'), ('HangmanViewing','HangmanToken'), ('viewer','HangmanViewing'), ('jobsAndReports','jobQueue@JobCreate'), ('jobsAndReports','jobQueue@JobDelete'), ('jobsAndReports','jobQueue@JobIndex'), ('jobsAndReports','jobQueue@JobScheduledCreate'), ('jobsAndReports','jobQueue@JobScheduledDelete'), ('jobsAndReports','jobQueue@JobScheduledIndex'), ('jobsAndReports','jobQueue@JobScheduledUpdate'), ('jobsAndReports','jobQueue@JobScheduledView'), ('jobsAndReports','jobQueue@JobUpdate'), ('jobsAndReports','jobQueue@JobView'), ('Authority','jobsAndReports'), ('borrower','LibraryIndex'), ('admin','LibraryLend'), ('borrower','LibraryRequest'), ('admin','LibraryReturn'), ('admin','manageBook'), ('admin','managePerson'), ('admin','managePublisher'), ('admin','manageUser'), ('admin','manageWish'), ('managePerson','PersonAdmin'), ('managePerson','PersonCreate'), ('managePerson','PersonDelete'), ('managePerson','PersonIndex'), ('managePerson','PersonUpdate'), ('managePerson','PersonView'), ('managePublisher','PublisherAdmin'), ('managePublisher','PublisherCreate'), ('managePublisher','PublisherDelete'), ('managePublisher','PublisherIndex'), ('managePublisher','PublisherUpdate'), ('managePublisher','PublisherView'), ('jobsAndReports','ReportIndex'), ('wishlistAccess','UpdateOwnUser'), ('manageUser','UserAclist'), ('manageUser','UserAssignRole'), ('manageUser','UserCreate'), ('manageUser','UserDelete'), ('manageUser','UserIndex'), ('manageUser','UserReloadRoles'), ('manageUser','UserRevokeRole'), ('manageUser','UserUpdate'), ('UpdateOwnUser','UserUpdate'), ('manageUser','UserView'), ('UpdateOwnUser','UserView'), ('borrower','viewer'), ('manageWish','WishAdmin'), ('wishlistAccess','WishClaim'), ('manageWish','WishCreate'), ('manageWish','WishCreateAuthor'), ('manageWish','WishDelete'), ('wishlistAccess','WishIndex'), ('viewer','wishlistAccess'), ('manageWish','WishRemoveAuthor'), ('manageWish','WishUpdate'), ('wishlistAccess','WishView'), ('admin','WroteitAdministrating'), ('WroteitAdministrating','WroteitCreate'), ('WroteitAdministrating','WroteitPlay'), ('WroteitViewing','WroteitPlay'), ('WroteitAdministrating','WroteitToken'), ('WroteitViewing','WroteitToken'), ('viewer','WroteitViewing');
INSERT INTO `book` VALUES ('1','Batman','','2','2012-05-08','50.00','3.00','','1','1','1','5','1'), ('2','The Amazing Spider Man','','1','2012-02-13','10.00','3.00','This book is awesome. ','1','1','1','5','1'), ('3','X-Men','','3','0000-00-00','5.00','1.00','Awesome','1','6','0',NULL,'0'), ('4','Sandman',NULL,'2','2012-05-17','8.00','3.00','','0','2','0','5','1'), ('5','Green Lantern','','3','2012-05-01','3.00','3.00','','0','1','0',NULL,'0'), ('6','Witchblade',NULL,'3','2000-03-01','15.00','2.00','','0','1','1','6','1'), ('7','300',NULL,'2','2002-10-01','15.00','3.00','','0','6','0','5','1'), ('8','Wolverine','','3','1982-05-01','67.00','1.00','','1','1','1',NULL,'0'), ('9','Stardust',NULL,'1','0000-00-00','0.00','0.00','','0','1','0',NULL,'1'), ('10','The Phantom Programmer',NULL,'3','2012-05-08','1.00','1.00','','1','4','1','6','1');
INSERT INTO `bookauthor` VALUES ('3','1'), ('10','1'), ('1','2'), ('2','3'), ('4','15');
INSERT INTO `bookillustrator` VALUES ('10','2'), ('10','3');
INSERT INTO `bookpublisher` VALUES ('10','1'), ('10','2');
INSERT INTO `game` VALUES ('4','WOLVERINE','ELOSUW',NULL,NULL,NULL,NULL,NULL,'2','c0f91c40fea97fa12d1a2b6b2dbf2c1f','1','0'), ('21','','','10','1','1','7','5',NULL,'b7dd383b687aabe38cab53c573073662','2',NULL), ('22','WOLVERINE','EFLOWYЙЩЪЮ',NULL,NULL,NULL,NULL,NULL,'6','b940261e5c4062b98f8bd88a2e60ab66','1','0');
INSERT INTO `game_type` VALUES ('1','hangman','Hangman'), ('2','wroteit','Wrote It');
INSERT INTO `grade` VALUES ('1','mint'), ('2','near mint'), ('3','very fine'), ('4','fine'), ('5','very good'), ('6','good'), ('7','fair'), ('8','poor');
INSERT INTO `job` VALUES ('1','Send Bday Wishlist Email','SendWishlist'), ('2','Generate a Report','RunReport'), ('3','Send Game Winning Certificate','SendCert');
INSERT INTO `job_scheduled` VALUES ('1','','null','1','2012-08-12 16:52:47','2014-03-07 14:08:56','2014-03-07 14:08:56','1'), ('2','','{\"data\":[{\"label\":\"Comic Books by Grade\",\"data\":[[\"1\",\"6\"],[\"2\",\"1\"],[\"4\",\"1\"],[\"6\",\"2\"]],\"bars\":{\"show\":true,\"align\":\"center\"}}],\"options\":{\"legend\":{\"show\":false},\"xaxis\":{\"ticks\":[[\"1\",\"mint\"],[\"2\",\"near mint\"],[\"4\",\"fine\"],[\"6\",\"good\"]]}},\"htmlOptions\":{\"style\":\"width:200px;height:200px;\"}}','2','2012-08-12 02:00:00','2014-03-07 14:08:56','2014-03-07 14:08:56','1'), ('3','',NULL,'3','2012-08-12 07:00:00',NULL,NULL,'0'), ('4','',NULL,'1','2014-02-25 16:28:50',NULL,NULL,'0');
INSERT INTO `person` VALUES ('11','admin','admin'), ('1','Comic','Author'), ('12','demo','demo'), ('15','guest','guest'), ('2','Illus','Trator'), ('226','Jean','Giraud'), ('227','John','Smith'), ('3','Manga','Maniac');
INSERT INTO `publisher` VALUES ('1','Pub Co'), ('2','Bup Co');
INSERT INTO `request` VALUES ('6','5');
INSERT INTO `tbl_audit_trail` VALUES ('1','','','CREATE','User','N/A','2014-01-24 15:25:12','5','8'), ('2','','kjgh','SET','User','username','2014-01-24 15:25:12','5','8'), ('3','','228','SET','User','person_id','2014-01-24 15:25:12','5','8'), ('4','','$1$o6..RV5.$cJMBNGGupYQSUIKXnkQhZ.','SET','User','pwd_hash','2014-01-24 15:25:12','5','8'), ('5','','8','SET','User','id','2014-01-24 15:25:12','5','8'), ('6','','','DELETE','User','N/A','2014-01-24 15:26:21','5','8'), ('7','','','CREATE','User','N/A','2014-01-24 15:28:40','5','9'), ('8','','kjgh','SET','User','username','2014-01-24 15:28:40','5','9'), ('9','','229','SET','User','person_id','2014-01-24 15:28:40','5','9'), ('10','','$1$RC2.G.3.$6M/OGMDglq2r2akumVyD4.','SET','User','pwd_hash','2014-01-24 15:28:40','5','9'), ('11','','9','SET','User','id','2014-01-24 15:28:40','5','9'), ('12','','','DELETE','User','N/A','2014-01-24 15:39:48','5','9'), ('13','$1$JG1.ea5.$7wNAEuNYfyo9MDua18nEt1','$1$/A4.aK0.$GrOSCNZo/FMd.ApBblZXA/','CHANGE','User','pwd_hash','2014-01-24 15:41:26','5','6'), ('14','demo','demo1','CHANGE','User','username','2014-01-24 15:43:19','5','6'), ('15','demo1','demo','CHANGE','User','username','2014-01-24 15:45:12','5','6'), ('16','$1$/A4.aK0.$GrOSCNZo/FMd.ApBblZXA/','$1$bj2.IC4.$hFVA8YMxX8kohdgRspjin1','CHANGE','User','pwd_hash','2014-01-24 15:45:12','5','6'), ('17','demo','demo2','CHANGE','User','username','2014-01-24 16:29:50','5','6'), ('18','demo2','demo','CHANGE','User','username','2014-01-24 16:30:08','5','6'), ('19','demo','demo1','CHANGE','Person','fname','2014-01-24 16:32:29','5','12'), ('20','demo','demo2','CHANGE','Person','lname','2014-01-24 16:32:29','5','12'), ('21',NULL,'5','CHANGE','Book','borrower_id','2014-01-24 16:38:19','5','4'), ('22','0','1','CHANGE','Book','signed','2014-01-24 16:56:48','5','1'), ('23','6','5','CHANGE','Book','borrower_id','2014-01-24 17:01:14','5','2'), ('24','','','CREATE','Request','N/A','2014-01-24 17:03:19','5','array'), ('25','','7','SET','Request','book_id','2014-01-24 17:03:19','5','array'), ('26','','5','SET','Request','requester_id','2014-01-24 17:03:19','5','array'), ('27','','','DELETE','Request','N/A','2014-01-24 17:06:34','5','Array\n(\n    [book_id] => 7\n    [requester_id] => 5\n)\n'), ('28',NULL,'5','CHANGE','Book','borrower_id','2014-01-24 17:06:34','5','7'), ('29','demo1','demo','CHANGE','Person','fname','2014-01-26 18:41:52','5','12'), ('30','demo2','demo','CHANGE','Person','lname','2014-01-26 18:41:52','5','12'), ('31','','','CREATE','Game','N/A','2014-02-12 19:31:54','5','1'), ('32','','WOLVERINE','SET','Game','target','2014-02-12 19:31:54','5','1'), ('33','','','SET','Game','guessed','2014-02-12 19:31:54','5','1'), ('34','','0','SET','Game','fails','2014-02-12 19:31:54','5','1'), ('35','','9df73f1a0b8fc9202f9931439c64c3d3','SET','Game','token','2014-02-12 19:31:54','5','1'), ('36','','1','SET','Game','game_type_id','2014-02-12 19:31:54','5','1'), ('37','','1','SET','Game','id','2014-02-12 19:31:54','5','1'), ('38','','','CREATE','Game','N/A','2014-02-12 19:35:53','5','2'), ('39','','GREEN LANTERN','SET','Game','target','2014-02-12 19:35:53','5','2'), ('40','','','SET','Game','guessed','2014-02-12 19:35:53','5','2'), ('41','','0','SET','Game','fails','2014-02-12 19:35:53','5','2'), ('42','','499ad68599f878529df80144e88f5fef','SET','Game','token','2014-02-12 19:35:53','5','2'), ('43','','1','SET','Game','game_type_id','2014-02-12 19:35:53','5','2'), ('44','','2','SET','Game','id','2014-02-12 19:35:53','5','2'), ('45','','','CREATE','Game','N/A','2014-02-12 19:36:08','5','3'), ('46','','THE PHANTOM PROGRAMMER','SET','Game','target','2014-02-12 19:36:08','5','3'), ('47','','','SET','Game','guessed','2014-02-12 19:36:08','5','3'), ('48','','0','SET','Game','fails','2014-02-12 19:36:08','5','3'), ('49','','4b1a267e0795200c283d697af4791cc8','SET','Game','token','2014-02-12 19:36:08','5','3'), ('50','','1','SET','Game','game_type_id','2014-02-12 19:36:08','5','3'), ('51','','3','SET','Game','id','2014-02-12 19:36:08','5','3'), ('52','','','CREATE','Game','N/A','2014-02-12 19:38:20','5','4'), ('53','','WOLVERINE','SET','Game','target','2014-02-12 19:38:20','5','4'), ('54','','','SET','Game','guessed','2014-02-12 19:38:20','5','4'), ('55','','0','SET','Game','fails','2014-02-12 19:38:20','5','4'), ('56','','c0f91c40fea97fa12d1a2b6b2dbf2c1f','SET','Game','token','2014-02-12 19:38:20','5','4'), ('57','','1','SET','Game','game_type_id','2014-02-12 19:38:20','5','4'), ('58','','4','SET','Game','id','2014-02-12 19:38:20','5','4'), ('59','','W','CHANGE','Game','guessed','2014-02-12 19:47:00','5','4'), ('60','W','OW','CHANGE','Game','guessed','2014-02-12 19:47:10','5','4'), ('61','OW','LOW','CHANGE','Game','guessed','2014-02-12 19:47:12','5','4'), ('62','LOW','LOVW','CHANGE','Game','guessed','2014-02-12 19:47:16','5','4'), ('63','LOVW','ELOVW','CHANGE','Game','guessed','2014-02-12 19:47:18','5','4'), ('64','ELOVW','ELORVW','CHANGE','Game','guessed','2014-02-12 19:47:20','5','4'), ('65','ELORVW','EILORVW','CHANGE','Game','guessed','2014-02-12 19:47:23','5','4'), ('66','EILORVW','EILNORVW','CHANGE','Game','guessed','2014-02-12 19:47:25','5','4'), ('67','','','CREATE','Game','N/A','2014-02-12 19:53:01','5','5'), ('68','','THE PHANTOM PROGRAMMER','SET','Game','target','2014-02-12 19:53:01','5','5'), ('69','','','SET','Game','guessed','2014-02-12 19:53:01','5','5'), ('70','','0','SET','Game','fails','2014-02-12 19:53:01','5','5'), ('71','','1ad739523d00a4e88c34e66371e75aec','SET','Game','token','2014-02-12 19:53:01','5','5'), ('72','','1','SET','Game','game_type_id','2014-02-12 19:53:01','5','5'), ('73','','5','SET','Game','id','2014-02-12 19:53:01','5','5'), ('74','','','CREATE','Game','N/A','2014-02-12 19:53:48','5','6'), ('75','','STARDUST','SET','Game','target','2014-02-12 19:53:48','5','6'), ('76','','','SET','Game','guessed','2014-02-12 19:53:49','5','6'), ('77','','0','SET','Game','fails','2014-02-12 19:53:49','5','6'), ('78','','c56398c5d8fd523317341cfffcc8f889','SET','Game','token','2014-02-12 19:53:49','5','6'), ('79','','1','SET','Game','game_type_id','2014-02-12 19:53:49','5','6'), ('80','','6','SET','Game','id','2014-02-12 19:53:49','5','6'), ('81','','S','CHANGE','Game','guessed','2014-02-12 19:53:52','5','6'), ('82','S','ST','CHANGE','Game','guessed','2014-02-12 19:59:02','5','6'), ('83','ST','AST','CHANGE','Game','guessed','2014-02-12 20:01:30','5','6'), ('84','AST','ARST','CHANGE','Game','guessed','2014-02-12 20:01:32','5','6'), ('85','ARST','ADRST','CHANGE','Game','guessed','2014-02-12 20:01:33','5','6'), ('86','ADRST','ADRSTU','CHANGE','Game','guessed','2014-02-12 20:01:36','5','6'), ('87','','W','CHANGE','Game','guessed','2014-02-12 20:10:09','5','4'), ('88','W','MW','CHANGE','Game','guessed','2014-02-12 20:10:12','5','4'), ('89',NULL,'1','CHANGE','Game','fails','2014-02-12 20:10:12','5','4'), ('90','MW','GMW','CHANGE','Game','guessed','2014-02-12 20:11:59','5','4'), ('91','1','2','CHANGE','Game','fails','2014-02-12 20:11:59','5','4'), ('92','GMW','GMWП','CHANGE','Game','guessed','2014-02-12 20:12:03','5','4'), ('93','2','3','CHANGE','Game','fails','2014-02-12 20:12:03','5','4'), ('94','GMWП','GMOWП','CHANGE','Game','guessed','2014-02-12 20:12:05','5','4'), ('95','GMOWП','GLMOWП','CHANGE','Game','guessed','2014-02-12 20:12:07','5','4'), ('96','GLMOWП','GLMOVWП','CHANGE','Game','guessed','2014-02-13 10:17:43','5','4'), ('97','GLMOVWП','EGLMOVWП','CHANGE','Game','guessed','2014-02-13 10:17:54','5','4'), ('98','EGLMOVWП','EGLMOVWПФ','CHANGE','Game','guessed','2014-02-13 10:18:01','5','4'), ('99','3','4','CHANGE','Game','fails','2014-02-13 10:18:01','5','4'), ('100','EGLMOVWПФ','EGLMORVWПФ','CHANGE','Game','guessed','2014-02-13 12:10:22','6','4');
INSERT INTO `tbl_audit_trail` VALUES ('101','EGLMORVWПФ','EGILMORVWПФ','CHANGE','Game','guessed','2014-02-13 12:10:35','6','4'), ('102','EGILMORVWПФ','EGILMNORVWПФ','CHANGE','Game','guessed','2014-02-13 12:10:37','6','4'), ('103',NULL,'1','CHANGE','Game','win','2014-02-17 19:42:45','5','18'), ('104',NULL,'1','CHANGE','Game','win','2014-02-18 08:37:19','6','18'), ('105',NULL,'1','CHANGE','Game','win','2014-02-18 08:37:38','6','18'), ('106',NULL,'1','CHANGE','Game','fails','2014-02-18 08:37:58','6','18'), ('107',NULL,'1','CHANGE','Game','fails','2014-02-18 08:38:51','6','18'), ('108',NULL,'1','CHANGE','Game','fails','2014-02-18 08:40:03','6','18'), ('109',NULL,'1','CHANGE','Game','win','2014-02-18 08:43:56','6','18'), ('110','','','CREATE','Game','N/A','2014-02-18 08:45:13','5','19'), ('111','','','SET','Game','target','2014-02-18 08:45:13','5','19'), ('112','','','SET','Game','guessed','2014-02-18 08:45:13','5','19'), ('113','','0','SET','Game','fails','2014-02-18 08:45:13','5','19'), ('114','','0','SET','Game','win','2014-02-18 08:45:13','5','19'), ('115','','ac525733495a264a9da2d1ba1ab51a42','SET','Game','token','2014-02-18 08:45:13','5','19'), ('116','','2','SET','Game','game_type_id','2014-02-18 08:45:13','5','19'), ('117','','1','SET','Game','book_id','2014-02-18 08:45:13','5','19'), ('118','','2','SET','Game','author_id','2014-02-18 08:45:13','5','19'), ('119','','6','SET','Game','book_decoy1_id','2014-02-18 08:45:13','5','19'), ('120','','4','SET','Game','book_decoy2_id','2014-02-18 08:45:13','5','19'), ('121','','8','SET','Game','book_decoy3_id','2014-02-18 08:45:13','5','19'), ('122','','19','SET','Game','id','2014-02-18 08:45:13','5','19'), ('123','','','CREATE','Game','N/A','2014-02-18 08:45:24','5','20'), ('124','','','SET','Game','target','2014-02-18 08:45:24','5','20'), ('125','','','SET','Game','guessed','2014-02-18 08:45:24','5','20'), ('126','','0','SET','Game','fails','2014-02-18 08:45:24','5','20'), ('127','','0','SET','Game','win','2014-02-18 08:45:24','5','20'), ('128','','f59b604645a39cdcf0964ccb5bcc97d8','SET','Game','token','2014-02-18 08:45:24','5','20'), ('129','','2','SET','Game','game_type_id','2014-02-18 08:45:24','5','20'), ('130','','4','SET','Game','book_id','2014-02-18 08:45:24','5','20'), ('131','','15','SET','Game','author_id','2014-02-18 08:45:24','5','20'), ('132','','8','SET','Game','book_decoy1_id','2014-02-18 08:45:24','5','20'), ('133','','6','SET','Game','book_decoy2_id','2014-02-18 08:45:24','5','20'), ('134','','2','SET','Game','book_decoy3_id','2014-02-18 08:45:24','5','20'), ('135','','20','SET','Game','id','2014-02-18 08:45:24','5','20'), ('136','0','1','CHANGE','Game','fails','2014-02-18 08:46:09','5','20'), ('137',NULL,'1','CHANGE','Game','win','2014-02-18 08:49:00','5','18'), ('138',NULL,'1','CHANGE','Game','fails','2014-02-18 08:49:19','5','18'), ('139',NULL,'1','CHANGE','Game','win','2014-02-18 08:54:18','5','18'), ('140',NULL,'1','CHANGE','Game','fails','2014-02-18 08:54:58','5','18'), ('141',NULL,'1','CHANGE','Game','fails','2014-02-18 08:55:59','5','18'), ('142',NULL,'1','CHANGE','Game','win','2014-02-18 09:04:17','5','18'), ('143',NULL,'1','CHANGE','Game','win','2014-02-18 09:04:26','5','18'), ('144',NULL,'1','CHANGE','Game','fails','2014-02-18 09:04:41','5','18'), ('145',NULL,'1','CHANGE','Game','fails','2014-02-18 09:05:59','5','18'), ('146','','','CREATE','Game','N/A','2014-02-18 09:16:22','5','21'), ('147','','','SET','Game','target','2014-02-18 09:16:22','5','21'), ('148','','','SET','Game','guessed','2014-02-18 09:16:22','5','21'), ('149','','0','SET','Game','fails','2014-02-18 09:16:22','5','21'), ('150','','0','SET','Game','win','2014-02-18 09:16:22','5','21'), ('151','','b7dd383b687aabe38cab53c573073662','SET','Game','token','2014-02-18 09:16:22','5','21'), ('152','','2','SET','Game','game_type_id','2014-02-18 09:16:22','5','21'), ('153','','10','SET','Game','book_id','2014-02-18 09:16:22','5','21'), ('154','','1','SET','Game','author_id','2014-02-18 09:16:22','5','21'), ('155','','1','SET','Game','book_decoy1_id','2014-02-18 09:16:22','5','21'), ('156','','7','SET','Game','book_decoy2_id','2014-02-18 09:16:22','5','21'), ('157','','5','SET','Game','book_decoy3_id','2014-02-18 09:16:22','5','21'), ('158','','21','SET','Game','id','2014-02-18 09:16:22','5','21'), ('159','0','1','CHANGE','Game','win','2014-02-18 09:16:32','5','21'), ('160','0','1','CHANGE','Game','fails','2014-02-18 09:16:59','5','21'), ('161','','W','CHANGE','Game','guessed','2014-02-18 09:20:46','6','4'), ('162','W','UW','CHANGE','Game','guessed','2014-02-18 09:20:50','6','4'), ('163',NULL,'1','CHANGE','Game','fails','2014-02-18 09:20:50','6','4'), ('164','UW','SUW','CHANGE','Game','guessed','2014-02-18 09:20:55','6','4'), ('165','1','2','CHANGE','Game','fails','2014-02-18 09:20:55','6','4'), ('166','SUW','OSUW','CHANGE','Game','guessed','2014-02-18 09:20:59','6','4'), ('167','OSUW','EOSUW','CHANGE','Game','guessed','2014-02-18 09:21:06','6','4'), ('168','EOSUW','ELOSUW','CHANGE','Game','guessed','2014-02-18 09:21:21','6','4'), ('169',NULL,'1','CHANGE','Game','win','2014-02-18 09:21:57','6','21'), ('170','','','CREATE','Job','N/A','2014-02-19 14:56:34','5','4'), ('171','','dfasdfadf','SET','Job','name','2014-02-19 14:56:34','5','4'), ('172','','dddddddfff','SET','Job','action','2014-02-19 14:56:34','5','4'), ('173','','4','SET','Job','id','2014-02-19 14:56:34','5','4'), ('174','','','DELETE','Job','N/A','2014-02-19 15:00:10','5','4'), ('175','','','CREATE','Job','N/A','2014-02-19 18:20:49','5','5'), ('176','','sdfasdf','SET','Job','name','2014-02-19 18:20:49','5','5'), ('177','','dfasdfadf','SET','Job','action','2014-02-19 18:20:49','5','5'), ('178','','5','SET','Job','id','2014-02-19 18:20:49','5','5'), ('179','','','DELETE','Job','N/A','2014-02-19 18:21:16','5','5'), ('180','','','CREATE','Job','N/A','2014-02-19 20:22:50','5','6'), ('181','','sssss','SET','Job','name','2014-02-19 20:22:50','5','6'), ('182','','ddddd','SET','Job','action','2014-02-19 20:22:50','5','6'), ('183','','6','SET','Job','id','2014-02-19 20:22:50','5','6'), ('184','','','DELETE','Job','N/A','2014-02-19 20:22:58','5','6'), ('185','','','CREATE','Job','N/A','2014-02-19 20:23:17','5','7'), ('186','','ddddd','SET','Job','name','2014-02-19 20:23:17','5','7'), ('187','','fffff','SET','Job','action','2014-02-19 20:23:17','5','7'), ('188','','7','SET','Job','id','2014-02-19 20:23:17','5','7'), ('189','fffff','fffff44444','CHANGE','Job','action','2014-02-19 20:23:33','5','7'), ('190','fffff44444','fffff444445','CHANGE','Job','action','2014-02-19 20:26:43','5','7'), ('191','','','DELETE','Job','N/A','2014-02-19 20:29:24','5','7'), ('192','','','CREATE','Job','N/A','2014-02-19 20:44:45','5','8'), ('193','','asdfadsfas','SET','Job','name','2014-02-19 20:44:45','5','8'), ('194','','asdasdasd','SET','Job','action','2014-02-19 20:44:45','5','8'), ('195','','8','SET','Job','id','2014-02-19 20:44:45','5','8'), ('196','','','DELETE','Job','N/A','2014-02-19 20:45:11','5','8'), ('197','','','CREATE','Job','N/A','2014-02-19 20:45:18','5','9'), ('198','','ddddddddd','SET','Job','name','2014-02-19 20:45:18','5','9'), ('199','','sssssssss','SET','Job','action','2014-02-19 20:45:18','5','9'), ('200','','9','SET','Job','id','2014-02-19 20:45:18','5','9');
INSERT INTO `tbl_audit_trail` VALUES ('201','','','DELETE','Job','N/A','2014-02-19 20:45:33','5','9'), ('202','','','CREATE','Job','N/A','2014-02-19 20:45:41','5','10'), ('203','','assssssssss','SET','Job','name','2014-02-19 20:45:42','5','10'), ('204','','ddddddddd','SET','Job','action','2014-02-19 20:45:42','5','10'), ('205','','10','SET','Job','id','2014-02-19 20:45:42','5','10'), ('206','','','DELETE','Job','N/A','2014-02-19 20:45:52','5','10'), ('207','','','CREATE','Game','N/A','2014-02-24 12:39:08','5','22'), ('208','','WOLVERINE','SET','Game','target','2014-02-24 12:39:08','5','22'), ('209','','','SET','Game','guessed','2014-02-24 12:39:08','5','22'), ('210','','0','SET','Game','fails','2014-02-24 12:39:08','5','22'), ('211','','0','SET','Game','win','2014-02-24 12:39:08','5','22'), ('212','','b940261e5c4062b98f8bd88a2e60ab66','SET','Game','token','2014-02-24 12:39:08','5','22'), ('213','','1','SET','Game','game_type_id','2014-02-24 12:39:08','5','22'), ('214','','22','SET','Game','id','2014-02-24 12:39:08','5','22'), ('215','',NULL,'SET','Game','book_id','2014-02-24 12:39:08','5','22'), ('216','',NULL,'SET','Game','author_id','2014-02-24 12:39:08','5','22'), ('217','',NULL,'SET','Game','book_decoy1_id','2014-02-24 12:39:08','5','22'), ('218','',NULL,'SET','Game','book_decoy2_id','2014-02-24 12:39:08','5','22'), ('219','',NULL,'SET','Game','book_decoy3_id','2014-02-24 12:39:08','5','22'), ('220','','F','CHANGE','Game','guessed','2014-02-24 12:39:17','5','22'), ('221','0','1','CHANGE','Game','fails','2014-02-24 12:39:17','5','22'), ('222','F','FW','CHANGE','Game','guessed','2014-02-24 12:39:20','5','22'), ('223','FW','FLW','CHANGE','Game','guessed','2014-02-24 12:39:23','5','22'), ('224','FLW','EFLW','CHANGE','Game','guessed','2014-02-24 12:39:26','5','22'), ('225','EFLW','EFLWY','CHANGE','Game','guessed','2014-02-24 12:39:30','5','22'), ('226','1','2','CHANGE','Game','fails','2014-02-24 12:39:30','5','22'), ('227','EFLWY','EFLWYЩ','CHANGE','Game','guessed','2014-02-24 12:39:38','5','22'), ('228','2','3','CHANGE','Game','fails','2014-02-24 12:39:38','5','22'), ('229','EFLWYЩ','EFLWYЩЮ','CHANGE','Game','guessed','2014-02-24 12:39:42','5','22'), ('230','3','4','CHANGE','Game','fails','2014-02-24 12:39:42','5','22'), ('231','EFLWYЩЮ','EFLOWYЩЮ','CHANGE','Game','guessed','2014-02-24 12:39:46','5','22'), ('232','EFLOWYЩЮ','EFLOWYЙЩЮ','CHANGE','Game','guessed','2014-02-24 12:39:51','5','22'), ('233','4','5','CHANGE','Game','fails','2014-02-24 12:39:51','5','22'), ('234','EFLOWYЙЩЮ','EFLOWYЙЩЪЮ','CHANGE','Game','guessed','2014-02-24 12:39:57','5','22'), ('235','5','6','CHANGE','Game','fails','2014-02-24 12:39:57','5','22'), ('236','','','CREATE','JobScheduled','N/A','2014-02-25 15:28:29','5','4'), ('237','','0','SET','JobScheduled','active','2014-02-25 15:28:29','5','4'), ('238','','1','SET','JobScheduled','job_id','2014-02-25 15:28:29','5','4'), ('239','','','SET','JobScheduled','params','2014-02-25 15:28:29','5','4'), ('240','','2014-02-25 16:29:03','SET','JobScheduled','scheduled_time','2014-02-25 15:28:29','5','4'), ('241','','4','SET','JobScheduled','id','2014-02-25 15:28:29','5','4'), ('242','',NULL,'SET','JobScheduled','output','2014-02-25 15:28:29','5','4'), ('243','',NULL,'SET','JobScheduled','started','2014-02-25 15:28:29','5','4'), ('244','',NULL,'SET','JobScheduled','completed','2014-02-25 15:28:29','5','4'), ('245','2014-02-25 16:29:03','2014-02-25 16:28:50','CHANGE','JobScheduled','scheduled_time','2014-02-25 15:28:53','5','4'), ('246','0','1','CHANGE','JobScheduled','active','2014-02-25 15:29:01','5','4'), ('247','','','CREATE','JobScheduled','N/A','2014-02-25 16:01:18','5','5'), ('248','','1','SET','JobScheduled','active','2014-02-25 16:01:18','5','5'), ('249','','1','SET','JobScheduled','job_id','2014-02-25 16:01:19','5','5'), ('250','','','SET','JobScheduled','params','2014-02-25 16:01:19','5','5'), ('251','','','SET','JobScheduled','scheduled_time','2014-02-25 16:01:19','5','5'), ('252','','5','SET','JobScheduled','id','2014-02-25 16:01:19','5','5'), ('253','',NULL,'SET','JobScheduled','output','2014-02-25 16:01:19','5','5'), ('254','',NULL,'SET','JobScheduled','started','2014-02-25 16:01:19','5','5'), ('255','',NULL,'SET','JobScheduled','completed','2014-02-25 16:01:19','5','5'), ('256','','','DELETE','JobScheduled','N/A','2014-02-25 16:01:30','5','5'), ('257','1','0','CHANGE','JobScheduled','active','2014-02-25 17:11:45','5','4'), ('258',NULL,'2014-02-27 19:23:46','CHANGE','JobScheduled','started','2014-02-27 18:23:46',NULL,'1'), ('259',NULL,'null','CHANGE','JobScheduled','output','2014-02-27 18:23:48',NULL,'1'), ('260',NULL,'2014-02-27 19:23:48','CHANGE','JobScheduled','started','2014-02-27 18:23:48',NULL,'1'), ('261',NULL,'2014-02-27 19:23:48','CHANGE','JobScheduled','completed','2014-02-27 18:23:48',NULL,'1'), ('262','2014-02-27 19:23:48','2014-02-28 12:56:56','CHANGE','JobScheduled','started','2014-02-28 11:56:56',NULL,'1'), ('263','2014-02-28 12:56:56','2014-02-28 12:58:21','CHANGE','JobScheduled','started','2014-02-28 11:58:21',NULL,'1'), ('264','2014-02-28 12:56:56','2014-02-28 12:58:31','CHANGE','JobScheduled','started','2014-02-28 11:58:31',NULL,'1'), ('265',NULL,'2014-02-28 12:58:31','CHANGE','JobScheduled','completed','2014-02-28 11:58:31',NULL,'1'), ('266',NULL,'2014-02-28 13:01:25','CHANGE','JobScheduled','started','2014-02-28 12:01:25',NULL,'1'), ('267',NULL,'null','CHANGE','JobScheduled','output','2014-02-28 12:01:32',NULL,'1'), ('268',NULL,'2014-02-28 13:01:32','CHANGE','JobScheduled','started','2014-02-28 12:01:32',NULL,'1'), ('269',NULL,'2014-02-28 13:01:32','CHANGE','JobScheduled','completed','2014-02-28 12:01:32',NULL,'1'), ('270',NULL,'2014-02-28 13:02:21','CHANGE','JobScheduled','started','2014-02-28 12:02:21',NULL,'1'), ('271',NULL,'2014-02-28 13:02:30','CHANGE','JobScheduled','started','2014-02-28 12:02:30',NULL,'1'), ('272',NULL,'2014-02-28 13:02:31','CHANGE','JobScheduled','completed','2014-02-28 12:02:31',NULL,'1'), ('273',NULL,'2014-02-28 13:35:00','CHANGE','JobScheduled','started','2014-02-28 12:35:00',NULL,'1'), ('274',NULL,'2014-02-28 13:35:05','CHANGE','JobScheduled','started','2014-02-28 12:35:05',NULL,'1'), ('275',NULL,'2014-02-28 13:35:05','CHANGE','JobScheduled','completed','2014-02-28 12:35:05',NULL,'1'), ('276',NULL,'2014-02-28 13:37:21','CHANGE','JobScheduled','started','2014-02-28 12:37:21',NULL,'1'), ('277',NULL,'2014-02-28 13:37:26','CHANGE','JobScheduled','started','2014-02-28 12:37:26',NULL,'1'), ('278',NULL,'2014-02-28 13:37:26','CHANGE','JobScheduled','completed','2014-02-28 12:37:26',NULL,'1'), ('279','2014-02-28 13:37:26','2014-02-28 18:05:24','CHANGE','JobScheduled','started','2014-02-28 17:05:24',NULL,'1'), ('280','null','\"done\"','CHANGE','JobScheduled','output','2014-02-28 17:05:30',NULL,'1'), ('281','2014-02-28 13:37:26','2014-02-28 18:05:30','CHANGE','JobScheduled','started','2014-02-28 17:05:30',NULL,'1'), ('282',NULL,'2014-02-28 18:05:30','CHANGE','JobScheduled','completed','2014-02-28 17:05:30',NULL,'1'), ('283',NULL,'2014-03-03 17:51:07','CHANGE','JobScheduled','started','2014-03-03 16:51:07',NULL,'1'), ('284',NULL,'\"done\"','CHANGE','JobScheduled','output','2014-03-03 16:51:13',NULL,'1'), ('285',NULL,'2014-03-03 17:51:13','CHANGE','JobScheduled','started','2014-03-03 16:51:13',NULL,'1'), ('286',NULL,'2014-03-03 17:51:13','CHANGE','JobScheduled','completed','2014-03-03 16:51:13',NULL,'1'), ('287',NULL,'2014-03-05 00:05:51','CHANGE','JobScheduled','started','2014-03-04 23:05:51',NULL,'1'), ('288',NULL,'\"done\"','CHANGE','JobScheduled','output','2014-03-04 23:05:59',NULL,'1'), ('289',NULL,'2014-03-05 00:05:59','CHANGE','JobScheduled','started','2014-03-04 23:05:59',NULL,'1'), ('290',NULL,'2014-03-05 00:05:59','CHANGE','JobScheduled','completed','2014-03-04 23:05:59',NULL,'1'), ('291','1','0','CHANGE','JobScheduled','active','2014-03-05 11:17:04','5','1'), ('292','0','1','CHANGE','JobScheduled','active','2014-03-05 11:17:27','5','1'), ('293',NULL,'2014-03-07 12:24:00','CHANGE','JobScheduled','started','2014-03-07 11:24:00',NULL,'2'), ('294',NULL,'{\"data\":[{\"label\":\"Comic Books by Grade\",\"data\":[[\"1\",\"6\"],[\"2\",\"1\"],[\"4\",\"1\"],[\"6\",\"2\"]],\"bars\":{\"show\":true,\"align\":\"center\"}}],\"options\":{\"legend\":{\"show\":false},\"xaxis\":{\"ticks\":[[\"1\",\"mint\"],[\"2\",\"near mint\"],[\"4\",\"fine\"],[\"6\",\"good\"]]}},\"htmlOptions\":{\"style\":\"width:200px;height:200px;\"}}','CHANGE','JobScheduled','output','2014-03-07 11:24:00',NULL,'2'), ('295',NULL,'2014-03-07 12:24:00','CHANGE','JobScheduled','started','2014-03-07 11:24:00',NULL,'2'), ('296',NULL,'2014-03-07 12:24:00','CHANGE','JobScheduled','completed','2014-03-07 11:24:00',NULL,'2'), ('297','2014-03-05 00:05:59','2014-03-07 13:15:18','CHANGE','JobScheduled','started','2014-03-07 12:15:18',NULL,'1'), ('298','\"done\"','\"\\\"done\\\"\"','CHANGE','JobScheduled','output','2014-03-07 12:15:24',NULL,'1'), ('299','2014-03-05 00:05:59','2014-03-07 13:15:24','CHANGE','JobScheduled','started','2014-03-07 12:15:24',NULL,'1'), ('300',NULL,'2014-03-07 13:15:24','CHANGE','JobScheduled','completed','2014-03-07 12:15:24',NULL,'1');
INSERT INTO `tbl_audit_trail` VALUES ('301','2014-03-07 13:15:24','2014-03-07 13:18:55','CHANGE','JobScheduled','started','2014-03-07 12:18:55',NULL,'1'), ('302','\"\\\"done\\\"\"','\"[\\\"done\\\"]\"','CHANGE','JobScheduled','output','2014-03-07 12:19:00',NULL,'1'), ('303','2014-03-07 13:15:24','2014-03-07 13:19:00','CHANGE','JobScheduled','started','2014-03-07 12:19:00',NULL,'1'), ('304',NULL,'2014-03-07 13:19:00','CHANGE','JobScheduled','completed','2014-03-07 12:19:00',NULL,'1'), ('305','2014-03-07 13:19:00','2014-03-07 13:25:30','CHANGE','JobScheduled','started','2014-03-07 12:25:30',NULL,'1'), ('306','\"[\\\"done\\\"]\"','null','CHANGE','JobScheduled','output','2014-03-07 12:25:37',NULL,'1'), ('307','2014-03-07 13:19:00','2014-03-07 13:25:37','CHANGE','JobScheduled','started','2014-03-07 12:25:37',NULL,'1'), ('308',NULL,'2014-03-07 13:25:37','CHANGE','JobScheduled','completed','2014-03-07 12:25:37',NULL,'1'), ('309',NULL,'2014-03-07 13:27:21','CHANGE','JobScheduled','started','2014-03-07 12:27:21',NULL,'1'), ('310',NULL,'null','CHANGE','JobScheduled','output','2014-03-07 12:27:26',NULL,'1'), ('311',NULL,'2014-03-07 13:27:26','CHANGE','JobScheduled','started','2014-03-07 12:27:26',NULL,'1'), ('312',NULL,'2014-03-07 13:27:26','CHANGE','JobScheduled','completed','2014-03-07 12:27:26',NULL,'1'), ('313','2014-03-07 13:27:26','2014-03-07 14:08:49','CHANGE','JobScheduled','started','2014-03-07 13:08:49',NULL,'1'), ('314','2014-03-07 13:27:26','2014-03-07 14:08:56','CHANGE','JobScheduled','started','2014-03-07 13:08:56',NULL,'1'), ('315',NULL,'2014-03-07 14:08:56','CHANGE','JobScheduled','completed','2014-03-07 13:08:56',NULL,'1'), ('316','2014-03-07 12:24:00','2014-03-07 14:08:56','CHANGE','JobScheduled','started','2014-03-07 13:08:56',NULL,'2'), ('317','2014-03-07 12:24:00','2014-03-07 14:08:56','CHANGE','JobScheduled','started','2014-03-07 13:08:56',NULL,'2'), ('318',NULL,'2014-03-07 14:08:56','CHANGE','JobScheduled','completed','2014-03-07 13:08:56',NULL,'2'), ('319','','','CREATE','JobScheduled','N/A','2014-03-11 11:02:49','5','5'), ('320','','1','SET','JobScheduled','active','2014-03-11 11:02:49','5','5'), ('321','','2','SET','JobScheduled','job_id','2014-03-11 11:02:49','5','5'), ('322','','','SET','JobScheduled','params','2014-03-11 11:02:49','5','5'), ('323','','2014-03-12 00:00:00','SET','JobScheduled','scheduled_time','2014-03-11 11:02:49','5','5'), ('324','','5','SET','JobScheduled','id','2014-03-11 11:02:49','5','5'), ('325','',NULL,'SET','JobScheduled','output','2014-03-11 11:02:49','5','5'), ('326','',NULL,'SET','JobScheduled','started','2014-03-11 11:02:49','5','5'), ('327','',NULL,'SET','JobScheduled','completed','2014-03-11 11:02:49','5','5'), ('328','1','0','CHANGE','JobScheduled','active','2014-03-11 11:03:05','5','5'), ('329','','','DELETE','JobScheduled','N/A','2014-03-11 11:03:15','5','5'), ('330','','','CREATE','Job','N/A','2014-03-11 12:32:29','5','4'), ('331','','dddd','SET','Job','name','2014-03-11 12:32:29','5','4'), ('332','','dddd','SET','Job','action','2014-03-11 12:32:29','5','4'), ('333','','4','SET','Job','id','2014-03-11 12:32:29','5','4'), ('334','','','DELETE','Job','N/A','2014-03-11 12:32:34','5','4'), ('335','','','CREATE','Job','N/A','2014-03-11 12:43:37','5','5'), ('336','','sdf','SET','Job','name','2014-03-11 12:43:37','5','5'), ('337','','sdf','SET','Job','action','2014-03-11 12:43:37','5','5'), ('338','','5','SET','Job','id','2014-03-11 12:43:37','5','5'), ('339','sdf','sdf11','CHANGE','Job','action','2014-03-11 12:43:57','5','5'), ('340','','','DELETE','Job','N/A','2014-03-11 12:44:01','5','5'), ('341','2012-08-12 21:52:47','2012-08-12 16:52:47','CHANGE','JobScheduled','scheduled_time','2014-03-11 12:44:36','5','1');
INSERT INTO `tbl_migration` VALUES ('m000000_000000_base','1390572445'), ('m110517_155003_create_tables_audit_trail','1390572448');
INSERT INTO `type` VALUES ('1','trade'), ('2','graphic novel'), ('3','issue');
INSERT INTO `user` VALUES ('5','admin','$1$uO..fZ1.$VYs5QxodY1nK.hu7zq4uq0','11'), ('6','demo','$1$bj2.IC4.$hFVA8YMxX8kohdgRspjin1','12'), ('7','guest','$1$lt..KF2.$4dBGyMO.Jvv9jBCuO8jC0/','15');
INSERT INTO `wish` VALUES ('1','Moebius\' Airtight Garage Vol.1','1','1','0000-00-00','http://www.amazon.com/Moebius-Airtight-Garage-Vol-1-No/dp/B00178YGFE/ref=sr_1_3?s=books&ie=UTF8&qid=1339476850&sr=1-3','','6'), ('2','The Squiddy Avenger','1','1','2012-06-21','http://www.amazon.com','','5'), ('3','another great title','','1','2012-06-21','','','6'), ('8','test wish','1','2','2014-01-08','','dsfasdf asdfgasdfg ','7'), ('9','another one','','1','2014-01-09','','ddddddd1',NULL);
INSERT INTO `wishauthor` VALUES ('8','1'), ('9','3'), ('8','12'), ('9','12'), ('1','226'), ('2','227');
