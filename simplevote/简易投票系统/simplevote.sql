/*
MySQL Data Transfer
Source Host: localhost
Source Database: simplevote
Target Host: localhost
Target Database: simplevote
Date: 2015/1/8 18:17:21
*/

SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for sysconfig
-- ----------------------------
CREATE TABLE `sysconfig` (
  `cid` int(11) NOT NULL auto_increment,
  `vote_name` varchar(45) NOT NULL,
  `dietime` date NOT NULL,
  `method` int(11) NOT NULL default '1',
  `description` varchar(800) NOT NULL default '',
  PRIMARY KEY  (`cid`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for users
-- ----------------------------
CREATE TABLE `users` (
  `cid` int(11) NOT NULL auto_increment,
  `username` varchar(40) NOT NULL,
  `passwd` varchar(45) NOT NULL,
  `admin` int(11) NOT NULL default '0',
  `isvote` int(11) NOT NULL default '0',
  PRIMARY KEY  (`cid`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for voteips
-- ----------------------------
CREATE TABLE `voteips` (
  `cid` int(11) NOT NULL auto_increment,
  `ip` varchar(60) NOT NULL,
  PRIMARY KEY  (`cid`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for votename
-- ----------------------------
CREATE TABLE `votename` (
  `cid` int(11) NOT NULL auto_increment,
  `question_name` varchar(200) NOT NULL,
  `votetype` int(11) NOT NULL default '0' COMMENT '0为单选\n1为多选',
  `sumvotenum` int(11) NOT NULL default '1',
  PRIMARY KEY  (`cid`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for voteoption
-- ----------------------------
CREATE TABLE `voteoption` (
  `cid` int(11) NOT NULL auto_increment,
  `optionname` varchar(100) NOT NULL default '',
  `votenum` int(11) NOT NULL default '0',
  `upid` int(11) NOT NULL,
  PRIMARY KEY  (`cid`,`upid`),
  KEY `fk_voteoption_votename_idx` (`upid`)
) ENGINE=MyISAM AUTO_INCREMENT=50 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records 
-- ----------------------------
INSERT INTO `sysconfig` VALUES ('1', 'æŠ•ç¥¨æµ‹è¯•', '2015-01-31', '1', 'æŠ•ç¥¨æµ‹è¯•1æŠ•ç¥¨æµ‹è¯•1æŠ•ç¥¨æµ‹è¯•1æŠ•ç¥¨æµ‹è¯•1æŠ•ç¥¨æµ‹è¯•1æŠ•ç¥¨æµ‹è¯•1æŠ•ç¥¨æµ‹è¯•1æŠ•ç¥¨æµ‹è¯•1æŠ•ç¥¨æµ‹è¯•1æŠ•ç¥¨æµ‹è¯•1æŠ•ç¥¨æµ‹è¯•1æŠ•ç¥¨æµ‹è¯•1');
INSERT INTO `users` VALUES ('1', 'admin', '123', '1', '1');
INSERT INTO `users` VALUES ('2', 'user1', '123', '0', '0');

