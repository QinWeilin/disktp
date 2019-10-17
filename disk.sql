# Host: localhost  (Version: 5.5.53)
# Date: 2019-10-11 15:36:36
# Generator: MySQL-Front 5.3  (Build 4.234)

/*!40101 SET NAMES utf8 */;

#
# Structure for table "files"
#

DROP TABLE IF EXISTS `files`;
CREATE TABLE `files` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ofuser` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL COMMENT '文件原名',
  `path` varchar(255) DEFAULT NULL COMMENT '文件路径',
  `size` varchar(255) DEFAULT NULL COMMENT '文件大小',
  `create_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '上传时间',
  `share` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

#
# Data for table "files"
#

INSERT INTO `files` VALUES (14,'test','Navdata.exe','../application/index/uploads/test/2019,10,11/1570778972.Navdata.exe','138107','2019-10-11 15:29:32','1');

#
# Structure for table "user"
#

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL DEFAULT '',
  `password` char(32) DEFAULT NULL,
  `email` varchar(200) DEFAULT NULL,
  `login_count` int(4) DEFAULT NULL,
  `last_login` int(11) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

#
# Data for table "user"
#

/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'test','098f6bcd4621d373cade4e832627b4f6',NULL,26,1570779343),(2,'hello','hello','666@126.com',NULL,NULL),(3,'1','2','333',NULL,NULL),(4,'12','4297f44b13955235245b2497399d7a93','1231',NULL,NULL),(5,'666','fae0b27c451c728867a567e8c1bb4e53','666',1,1570717514),(6,'123456','5775f3eaccbaa66732e805cb621bbf3d','23131',NULL,NULL),(7,'123','202cb962ac59075b964b07152d234b70','123',8,1570779257);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
