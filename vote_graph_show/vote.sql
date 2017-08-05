/*
SQLyog Enterprise v12.08 (32 bit)
MySQL - 5.0.95 : Database - sq_boyyb88
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`sq_boyyb88` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `sq_boyyb88`;

/*Table structure for table `vote` */

DROP TABLE IF EXISTS `vote`;

CREATE TABLE `vote` (
  `id` int(11) default NULL,
  `name` char(60) default NULL,
  `number` int(11) default NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `vote` */

insert  into `vote`(`id`,`name`,`number`) values (1,'yang',68),(2,'wang',55),(3,'li',62),(NULL,'frd',NULL),(NULL,'frd',NULL);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
