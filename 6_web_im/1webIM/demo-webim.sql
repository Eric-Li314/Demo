/*
SQLyog Enterprise v12.08 (32 bit)
MySQL - 5.6.17 : Database - demo
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`demo` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `demo`;

/*Table structure for table `webim` */

DROP TABLE IF EXISTS `webim`;

CREATE TABLE `webim` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nickname` varchar(20) NOT NULL,
  `time` int(11) NOT NULL COMMENT '发送内容时间',
  `content` varchar(100) NOT NULL,
  `type` varchar(50) NOT NULL COMMENT '发言内容和提示信息',
  `offline` int(11) NOT NULL COMMENT '下线时间，时间戳格式',
  `online` tinyint(4) NOT NULL COMMENT '1在线，0下线',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=713 DEFAULT CHARSET=utf8;

/*Data for the table `webim` */

insert  into `webim`(`id`,`nickname`,`time`,`content`,`type`,`offline`,`online`) values (681,'111',1474878988,'joined the chat room!','提示',1474880538,1),(682,'222',1474878991,'joined the chat room!','提示',1474880531,1),(683,'333',1474878996,'joined the chat room!','提示',1474879836,0),(684,'111',1474879003,'日你咩','内容',1474880538,1),(685,'王二狗',1474879026,'joined the chat room!','提示',1474879136,0),(686,'王二狗',1474879031,'大家好','内容',1474879136,0),(687,'张几把',1474879076,'joined the chat room!','提示',1474879136,0),(688,'王二狗',1474879088,'你个狗东西啊\n','内容',1474879136,0),(689,'王二狗',1474879138,' 下线了！ ','提示',1474879078,0),(690,'张几把',1474879138,' 下线了！ ','提示',1474879078,0),(691,'问你个热狗',1474879356,'joined the chat room!','提示',1474879466,0),(692,'gggggzzz',1474879365,'joined the chat room!','提示',1474879465,0),(693,'屁眼虫',1474879379,'joined the chat room!','提示',1474879459,0),(694,'问你个热狗',1474879398,'大家好 我让你啊','内容',1474879466,0),(695,'屁眼虫',30,' 下线了！ ','提示',1474879401,0),(696,'gggggzzz',30,' 下线了！ ','提示',1474879406,0),(697,'问你个热狗',30,' 下线了！ ','提示',1474879408,0),(698,'bbbbb',1474879665,'joined the chat room!','提示',1474879775,0),(699,'nnnnnnnnn',1474879673,'joined the chat room!','提示',1474879763,0),(700,'lllllllllll',1474879720,'joined the chat room!','提示',1474879760,0),(701,'bbbbb',1474879725,'fdsf ds','内容',1474879775,0),(702,'nnnnnnnnn',1474879728,'gdfgfdgf','内容',1474879763,0),(703,'lllllllllll',1474879761,' 下线了！ ','提示',1474879701,0),(704,'nnnnnnnnn',1474879766,' 下线了！ ','提示',1474879706,0),(705,'bbbbb',1474879776,' 下线了！ ','提示',1474879716,0),(706,'444',1474879809,'joined the chat room!','提示',1474879839,0),(707,'222',1474879821,'55555','内容',1474880531,1),(708,'333',1474879838,' 下线了！ ','提示',1474879778,0),(709,'444',1474879841,' 下线了！ ','提示',1474879781,0),(710,'用和你',1474879887,'joined the chat room!','提示',1474879927,0),(711,'用和你',1474879896,'66666666666666','内容',1474879927,0),(712,'用和你',1474879928,' 下线了！ ','提示',1474879868,0);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
