# Host: localhost  (Version: 5.5.53)
# Date: 2019-10-18 13:18:04
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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

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
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
