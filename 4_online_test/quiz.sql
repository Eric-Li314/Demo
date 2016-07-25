-- phpMyAdmin SQL Dump
-- version 3.2.0.1
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2015 年 04 月 04 日 13:49
-- 服务器版本: 5.5.8
-- PHP 版本: 5.3.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `lrfbeyond_demo`
--

-- --------------------------------------------------------

--
-- 表的结构 `quiz`
--

CREATE TABLE IF NOT EXISTS `quiz` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question` varchar(100) NOT NULL,
  `answer` varchar(500) NOT NULL,
  `correct` tinyint(2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- 转存表中的数据 `quiz`
--

INSERT INTO `quiz` (`id`, `question`, `answer`, `correct`) VALUES
(1, '罗马帝国曾一度辉煌，令人神往，故有“条条大陆通罗马”一说。那么，今天你是怎样理解这一谚语的准确含义的？', 'A．入乡随俗 ###B．四通八达 ###C．殊途同归 ###D．流连忘返', 3),
(2, '找出不同类的一项：', 'A.斑马 ###B.军马 ###C.赛马 ###D.骏马 ###E.驸马', 5),
(3, ' 蜡烛在空气中燃烧，蜡烛质量逐渐变小。这说明', 'A.物质可以自生自灭###B.发生的不是化学变化###C.不遵守质量守恒定律###D.生成物为气体，散发到空气中了', 4),
(4, '以下哪位歌手没有获得过《我是歌手》总冠军？', 'A.羽泉###B.韩磊###C.邓紫棋###D.韩红', 3),
(5, '下列哪个标签不是HTML5中的新标签？', 'A.&lt;article&gt;###B.&lt;canvas&gt;###C.&lt;section&gt;###D.&lt;sub&gt;', 4);
