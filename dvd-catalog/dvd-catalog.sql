# ************************************************************
# Sequel Pro SQL dump
# Version 3408
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Host: 127.0.0.1 (MySQL 5.5.31-0ubuntu0.12.04.1)
# Database: dclarke
# Generation Time: 2014-03-22 16:09:08 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table tbl_dvd
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tbl_dvd`;

CREATE TABLE `tbl_dvd` (
  `fld_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `fld_name` varchar(100) NOT NULL DEFAULT '',
  `fld_discs` tinyint(4) NOT NULL DEFAULT '1',
  `fld_year` int(11) NOT NULL DEFAULT '2004',
  `fld_added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `fld_format` tinyint(4) unsigned NOT NULL DEFAULT '1',
  `fld_burned` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`fld_id`),
  UNIQUE KEY `fld_name` (`fld_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

LOCK TABLES `tbl_dvd` WRITE;
/*!40000 ALTER TABLE `tbl_dvd` DISABLE KEYS */;

INSERT INTO `tbl_dvd` (`fld_id`, `fld_name`, `fld_discs`, `fld_year`, `fld_added`, `fld_format`, `fld_burned`)
VALUES
	(1,'American Wedding',1,2003,'2004-05-22 05:09:40',1,0),
	(2,'American Beauty (The Awards Edition)',1,2000,'2004-05-22 05:10:37',1,0),
	(3,'28 Days Later',1,2003,'2004-05-22 05:58:56',1,0),
	(4,'A Beautiful Mind (Awards Edition)',2,2002,'2004-05-22 05:59:37',1,0),
	(5,'Almost Famous',1,2001,'2004-05-22 06:00:06',1,0),
	(6,'Amelie',2,2001,'2004-05-22 06:00:24',1,0),
	(7,'American Pie (Collectors Edition)',1,1999,'2004-05-22 06:00:59',1,0),
	(8,'American Pie 2 (Unrated Version)',1,2002,'2004-05-22 06:01:26',1,0),
	(9,'Animatrix, The (inc. CD Soundtrack)',1,2003,'2004-05-22 06:02:36',1,0),
	(10,'Austin Powers: International Man of Mystery',1,1997,'2004-05-22 06:05:46',1,0),
	(11,'Austin Powers: The Spy Who Shagged Me',1,1999,'2004-05-22 06:06:11',1,0),
	(12,'Austin Powers: Goldmember',1,2002,'2004-05-22 06:06:43',1,0),
	(13,'Avengers, The',1,1998,'2004-05-22 06:07:16',1,0),
	(14,'Basic Instinct (Unrated w/ Ice Pick)',1,1992,'2004-05-22 06:08:48',1,0),
	(15,'Bend it like Beckham',1,2003,'2004-05-22 06:09:20',1,0),
	(16,'Big Daddy',1,1999,'2004-05-22 06:09:51',1,0),
	(17,'Blair Witch Project, The (Special Edition)',1,1999,'2004-05-22 06:10:39',0,0),
	(18,'Blue Streak (Special Edition)',1,1999,'2004-05-22 06:12:01',1,0),
	(19,'Bone Collector, The',1,2000,'2004-05-22 06:12:39',1,0),
	(20,'Braveheart',1,1995,'2004-05-22 06:13:07',1,0),
	(21,'Can\'t Hardly Wait',1,1998,'2004-05-22 06:13:30',1,0),
	(22,'Charlies Angels (Special Edition)',1,2000,'2004-05-22 06:13:55',1,0),
	(23,'Chasing Amy (The Criterion Collection)',1,1997,'2004-05-22 06:14:54',1,0),
	(24,'Contact (Special Edition)',1,1997,'2004-05-22 06:15:23',1,0),
	(25,'Count of Monte Cristo, The',1,2002,'2004-05-22 06:17:08',1,0),
	(26,'Crouching Tiger, Hidden Dragon',1,2000,'2004-05-22 06:17:54',1,0),
	(27,'Cruel Intentions (Collectors Edition)',1,1999,'2004-05-22 06:18:50',1,0),
	(28,'Dead Man Walking',1,1999,'2004-05-22 06:19:17',1,0),
	(29,'Eight Millimeter (8mm)',1,1999,'2004-05-22 06:19:56',1,0),
	(30,'Enemy of the State',1,1998,'2004-05-22 06:21:02',1,0),
	(31,'Entrapment',1,1999,'2004-05-22 06:21:30',1,0),
	(32,'Flatliners',1,1990,'2004-05-22 06:22:23',1,0),
	(33,'Gangs of New York',2,2003,'2004-05-22 06:22:52',1,0),
	(34,'Ferris Buellers Day Off',1,1986,'2004-05-22 06:23:27',1,0),
	(35,'Gone in 60 Seconds',1,2000,'2004-05-22 06:24:21',1,0),
	(36,'Good Morning Vietnam',1,1987,'2004-05-22 06:25:07',1,0),
	(37,'Green Mile, The',1,1999,'2004-05-22 06:25:48',1,0),
	(38,'Hackers',1,1995,'2004-05-22 06:26:16',1,0),
	(39,'How to Lose a Guy in 10 Days',1,2003,'2004-05-22 06:27:34',1,0),
	(40,'Indiana Jones and the Raiders of the Lost Ark',1,1981,'2004-05-22 06:29:17',1,0),
	(41,'Indiana Jones and the Temple of Doom',1,1984,'2004-05-22 06:29:32',1,0),
	(42,'Indiana Jones and the Last Crusade (Plus Bonus Material)',2,1989,'2004-05-22 06:29:58',1,0),
	(43,'Instinct',1,1999,'2004-05-22 06:30:40',1,0),
	(44,'Kiss The Girls',1,1997,'2004-05-22 06:30:56',1,0),
	(45,'Lara Croft: Tomb Raider',1,2001,'2004-05-22 06:31:31',1,0),
	(46,'Lethal Weapon',1,1987,'2004-05-22 06:34:20',1,0),
	(47,'Lethal Weapon 2',1,1989,'2004-05-22 06:34:34',1,0),
	(48,'Lethal Weapon 3',1,1992,'2004-05-22 06:34:54',1,0),
	(49,'Lethal Weapon 4',1,1998,'2004-05-22 06:35:07',1,0),
	(50,'Lock Stock and Two Smoking Barrels',1,1998,'2004-05-22 06:35:44',1,0),
	(51,'Matrix',1,1999,'2004-05-22 06:35:58',1,0),
	(52,'Matrix Revolutions',2,2003,'2004-05-22 06:36:31',1,0),
	(53,'Matrix Reloaded',2,2003,'2004-05-22 06:36:54',1,0),
	(54,'Maverick',1,1994,'2004-05-22 06:37:41',1,0),
	(55,'Monsters Inc.',2,2001,'2004-05-22 06:38:23',1,0),
	(56,'Night Shift',1,1982,'2004-05-22 06:39:15',1,0),
	(57,'Pi (Faith in Chaos)',1,1997,'2004-05-22 06:39:53',1,0),
	(58,'Princess Bride, The',1,1987,'2004-05-22 06:40:08',1,0),
	(59,'Pump Up The Volume',1,1990,'2004-05-22 06:40:56',1,0),
	(60,'Reservoir Dogs',1,1992,'2004-05-22 06:41:54',1,0),
	(61,'Rock, The',1,1996,'2004-05-22 06:42:31',1,0),
	(62,'Ronin',1,1998,'2004-05-22 06:42:48',1,0),
	(63,'Shining, The',1,1980,'2004-05-22 06:43:57',0,0),
	(64,'Shrek',1,2001,'2004-05-22 06:44:39',0,0),
	(65,'Sixth Sense, The',1,1999,'2004-05-22 06:45:14',1,0),
	(66,'Snatch (Special Edition)',2,2000,'2004-05-22 06:45:55',1,0),
	(67,'Spaceballs',1,1987,'2004-05-22 06:46:10',1,0),
	(68,'Spawn (Directors Cut)',1,1997,'2004-05-22 06:47:02',1,0),
	(69,'Spiderman (Special Edition)',2,2002,'2004-05-22 06:47:32',1,0),
	(70,'Sleepy Hollow',1,1999,'2004-05-22 06:47:50',1,0),
	(71,'There\'s Something About Mary (Special Edition)',1,1999,'2004-05-22 06:49:15',1,0),
	(72,'Transformers: The Movie (Special Collectors Edition)',1,1986,'2004-05-22 06:50:37',0,0),
	(73,'Unbreakable',2,2000,'2004-05-22 06:52:10',1,0),
	(74,'Underworld (Special Edition)',1,2004,'2004-05-22 06:52:42',1,0),
	(75,'National Lampoons: Van Wilder (Unrated Version)',2,2002,'2004-05-22 06:53:36',1,0),
	(76,'Virgin Suicides, The',1,2000,'2004-05-22 06:54:22',1,0),
	(77,'Waterboy, The',1,1998,'2004-05-22 06:54:58',1,0),
	(78,'Way of the Gun, The',1,2000,'2004-05-22 06:55:51',1,0),
	(84,'X-Men',2,2000,'2004-05-22 07:00:58',1,0),
	(80,'Whipped',1,2000,'2004-05-22 06:57:23',0,0),
	(81,'XXX (Special Edition)',1,2002,'2004-05-22 06:58:36',0,0),
	(82,'Lord of the Rings: The Fellowship of the Ring',2,2001,'2004-05-22 06:59:45',1,0),
	(83,'Lord of the Rings: The Two Towers',2,2002,'2004-05-22 06:59:59',1,0),
	(85,'X-Men 2: X-Men United',2,2003,'2004-05-22 07:01:06',1,0),
	(87,'Lord of the Rings: Return of the King',2,2003,'2004-05-26 12:29:22',1,0),
	(88,'Whole Nine Yards, The',1,2000,'2004-06-21 18:46:46',1,0),
	(89,'Lara Croft: Tomb Raider: The Cradle of Life',1,2003,'2004-06-21 18:48:55',1,0),
	(90,'Italian Job, The',1,2003,'2004-06-22 08:39:39',1,0),
	(91,'About a Boy',1,2002,'2004-06-22 08:40:27',1,0),
	(92,'Monsoon Wedding',1,2002,'2004-06-22 08:42:21',1,0),
	(93,'12 Monkeys',1,1998,'2004-06-22 08:43:27',1,0),
	(94,'Kill Bill: Volume 1',1,2004,'2004-07-16 14:41:44',1,0),
	(95,'Grosse Pointe Blank',1,1997,'2004-07-16 14:44:33',1,0),
	(96,'High Fidelity',1,2000,'2004-07-16 14:45:53',1,0),
	(97,'Shrek 2',1,2004,'2004-12-26 08:59:57',0,0),
	(98,'Shrek 3D',1,2004,'2004-12-26 09:00:06',1,0),
	(99,'Hero',1,2004,'2004-12-26 09:03:06',1,0),
	(100,'Spiderman 2',2,2004,'2004-12-26 09:03:14',1,0),
	(101,'Kill Bill Volume 2',1,2004,'2005-01-30 20:37:35',1,0),
	(102,'Signs',1,2002,'2005-01-30 20:38:55',1,0),
	(103,'Mask of Zorro, The',2,1998,'2005-01-30 20:39:26',1,0),
	(104,'Harold & Kumar go to White Castle',1,2004,'2005-01-30 20:40:16',1,0),
	(105,'Dawn of the Dead',1,2004,'2005-02-15 03:49:32',1,0),
	(106,'School of Rock',1,2003,'2005-02-15 03:49:56',1,0),
	(107,'Shaun of the Dead',1,2004,'2005-02-15 03:50:39',1,0),
	(108,'Back to the Future Trilogy',3,1985,'2005-02-15 03:52:02',1,0),
	(109,'Family Guy Volume I (Season 1 and 2)',4,2003,'2005-02-15 03:52:27',0,0),
	(111,'Incredibles, The',2,2005,'2005-03-28 21:34:08',1,0),
	(112,'Family Guy Volume II (Season 3)',3,2005,'2005-04-29 07:39:52',0,0),
	(113,'Hitch',1,2005,'2005-07-05 17:30:57',1,0),
	(114,'Minority Report',2,2002,'2005-08-06 11:52:49',1,0),
	(115,'Collateral',2,2004,'2005-08-06 11:53:00',1,0),
	(116,'Bourne Supremacy, The',1,2004,'2005-08-06 11:53:27',1,0),
	(117,'Bourne Identity, The',1,2002,'2005-08-06 11:54:20',1,0),
	(118,'Napoleon Dynamite',1,2004,'2005-08-06 11:54:49',1,0),
	(119,'Girl Next Door, The',1,2004,'2005-08-06 11:55:06',1,0),
	(120,'Dodgeball',1,2004,'2005-08-06 11:55:22',1,0),
	(121,'Office Space',1,1999,'2005-08-06 11:55:54',1,0),
	(122,'Sanglish',1,2004,'2005-09-17 17:40:20',1,0),
	(123,'Saint, The',1,1998,'2005-09-17 17:40:37',1,0),
	(124,'Clue',1,1985,'2005-09-17 17:40:49',1,0),
	(125,'Tron',2,1982,'2006-10-08 19:13:49',1,0),
	(126,'Monty Python and the Holy Grail',2,1975,'2006-10-08 19:14:31',1,0);

/*!40000 ALTER TABLE `tbl_dvd` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
