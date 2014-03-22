# ************************************************************
# Sequel Pro SQL dump
# Version 3408
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Host: 127.0.0.1 (MySQL 5.5.31-0ubuntu0.12.04.1)
# Database: fls_manage
# Generation Time: 2014-03-22 16:18:45 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table tbl_client
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tbl_client`;

CREATE TABLE `tbl_client` (
  `fld_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `fld_code` varchar(10) NOT NULL DEFAULT '',
  `fld_contact_email` varchar(40) NOT NULL DEFAULT '',
  `fld_password` varchar(38) NOT NULL DEFAULT '',
  `fld_authcode` varchar(32) NOT NULL DEFAULT '',
  `fld_last_billed` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `fld_company_name` varchar(100) NOT NULL DEFAULT '',
  `fld_balance` float NOT NULL DEFAULT '0',
  PRIMARY KEY (`fld_id`),
  UNIQUE KEY `fld_code` (`fld_code`)
) ENGINE=MyISAM AUTO_INCREMENT=32 DEFAULT CHARSET=latin1;



# Dump of table tbl_client_address
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tbl_client_address`;

CREATE TABLE `tbl_client_address` (
  `fld_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `fld_client_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `fld_contact_name` varchar(60) NOT NULL DEFAULT '',
  `fld_address1` varchar(64) NOT NULL DEFAULT '',
  `fld_address2` varchar(64) NOT NULL DEFAULT '',
  `fld_postal` varchar(11) NOT NULL DEFAULT '',
  `fld_city` varchar(60) NOT NULL DEFAULT '',
  `fld_country_id` int(11) NOT NULL DEFAULT '0',
  `fld_prov_id` int(11) NOT NULL DEFAULT '0',
  `fld_phone` varchar(15) NOT NULL DEFAULT '',
  `fld_fax` varchar(15) NOT NULL DEFAULT '',
  `fld_alternate_email` varchar(30) NOT NULL DEFAULT '',
  PRIMARY KEY (`fld_id`),
  UNIQUE KEY `fld_client_id` (`fld_client_id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;



# Dump of table tbl_client_billing
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tbl_client_billing`;

CREATE TABLE `tbl_client_billing` (
  `fld_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `fld_client_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `fld_contact_name` varchar(60) NOT NULL DEFAULT '',
  `fld_address1` varchar(64) NOT NULL DEFAULT '',
  `fld_address2` varchar(64) NOT NULL DEFAULT '',
  `fld_postal` varchar(11) NOT NULL DEFAULT '',
  `fld_city` varchar(60) NOT NULL DEFAULT '',
  `fld_country_id` int(11) NOT NULL DEFAULT '0',
  `fld_prov_id` int(11) NOT NULL DEFAULT '0',
  `fld_phone` varchar(15) NOT NULL DEFAULT '',
  `fld_fax` varchar(15) NOT NULL DEFAULT '',
  `fld_alternate_email` varchar(30) NOT NULL DEFAULT '',
  PRIMARY KEY (`fld_id`),
  UNIQUE KEY `fld_client_id` (`fld_client_id`)
) ENGINE=MyISAM AUTO_INCREMENT=35 DEFAULT CHARSET=latin1;



# Dump of table tbl_country
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tbl_country`;

CREATE TABLE `tbl_country` (
  `fld_id` int(11) NOT NULL AUTO_INCREMENT,
  `fld_country_iso` char(2) DEFAULT NULL,
  `fld_country_name` varchar(40) DEFAULT NULL,
  PRIMARY KEY (`fld_id`)
) ENGINE=MyISAM AUTO_INCREMENT=239 DEFAULT CHARSET=latin1 PACK_KEYS=1;



# Dump of table tbl_dns_domains
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tbl_dns_domains`;

CREATE TABLE `tbl_dns_domains` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `master` varchar(20) NOT NULL DEFAULT '205.150.58.140',
  `last_check` int(11) DEFAULT NULL,
  `type` varchar(6) NOT NULL DEFAULT 'SLAVE',
  `notified_serial` int(11) DEFAULT NULL,
  `account` varchar(40) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name_index` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=latin1;



# Dump of table tbl_dns_records
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tbl_dns_records`;

CREATE TABLE `tbl_dns_records` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `domain_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `type` varchar(6) DEFAULT NULL,
  `content` varchar(255) DEFAULT NULL,
  `ttl` int(11) DEFAULT NULL,
  `prio` int(11) DEFAULT NULL,
  `change_date` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `rec_name_index` (`name`),
  KEY `nametype_index` (`name`,`type`),
  KEY `domain_id` (`domain_id`),
  CONSTRAINT `tbl_dns_records_ibfk_1` FOREIGN KEY (`domain_id`) REFERENCES `tbl_dns_domains` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=485 DEFAULT CHARSET=latin1;



# Dump of table tbl_dns_supermasters
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tbl_dns_supermasters`;

CREATE TABLE `tbl_dns_supermasters` (
  `ip` varchar(25) NOT NULL DEFAULT '',
  `nameserver` varchar(255) NOT NULL DEFAULT '',
  `account` varchar(40) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table tbl_domains
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tbl_domains`;

CREATE TABLE `tbl_domains` (
  `fld_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `fld_client_id` bigint(20) NOT NULL DEFAULT '0',
  `fld_domain_name` varchar(130) NOT NULL DEFAULT '',
  `fld_expire_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `fld_we_are_registrar` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `fld_disabled` tinyint(1) NOT NULL,
  PRIMARY KEY (`fld_id`),
  UNIQUE KEY `fld_domain_name` (`fld_domain_name`)
) ENGINE=MyISAM AUTO_INCREMENT=47 DEFAULT CHARSET=latin1;



# Dump of table tbl_domains_limits
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tbl_domains_limits`;

CREATE TABLE `tbl_domains_limits` (
  `fld_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `fld_domains_id` bigint(20) NOT NULL DEFAULT '0',
  `fld_ftp_logins` int(11) NOT NULL DEFAULT '0',
  `fld_email_accounts` int(11) NOT NULL DEFAULT '0',
  `fld_email_lists` int(11) NOT NULL DEFAULT '0',
  `fld_email_aliases` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`fld_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table tbl_domains_services
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tbl_domains_services`;

CREATE TABLE `tbl_domains_services` (
  `fld_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `fld_domains_id` bigint(20) NOT NULL DEFAULT '0',
  `fld_description` text NOT NULL,
  `fld_value` float NOT NULL DEFAULT '0',
  PRIMARY KEY (`fld_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;



# Dump of table tbl_ftp_group
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tbl_ftp_group`;

CREATE TABLE `tbl_ftp_group` (
  `groupname` varchar(16) NOT NULL DEFAULT '',
  `gid` smallint(6) NOT NULL DEFAULT '5500',
  `members` varchar(16) NOT NULL DEFAULT '',
  KEY `groupname` (`groupname`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='ProFTP group table';



# Dump of table tbl_ftp_quota_limits
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tbl_ftp_quota_limits`;

CREATE TABLE `tbl_ftp_quota_limits` (
  `name` varchar(30) DEFAULT NULL,
  `quota_type` enum('user','group','class','all') NOT NULL DEFAULT 'user',
  `per_session` enum('false','true') NOT NULL DEFAULT 'false',
  `limit_type` enum('soft','hard') NOT NULL DEFAULT 'soft',
  `bytes_in_avail` float NOT NULL DEFAULT '0',
  `bytes_out_avail` float NOT NULL DEFAULT '0',
  `bytes_xfer_avail` float NOT NULL DEFAULT '0',
  `files_in_avail` int(10) unsigned NOT NULL DEFAULT '0',
  `files_out_avail` int(10) unsigned NOT NULL DEFAULT '0',
  `files_xfer_avail` int(10) unsigned NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table tbl_ftp_quota_tallies
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tbl_ftp_quota_tallies`;

CREATE TABLE `tbl_ftp_quota_tallies` (
  `name` varchar(30) NOT NULL DEFAULT '',
  `quota_type` enum('user','group','class','all') NOT NULL DEFAULT 'user',
  `bytes_in_used` float NOT NULL DEFAULT '0',
  `bytes_out_used` float NOT NULL DEFAULT '0',
  `bytes_xfer_used` float NOT NULL DEFAULT '0',
  `files_in_used` int(10) unsigned NOT NULL DEFAULT '0',
  `files_out_used` int(10) unsigned NOT NULL DEFAULT '0',
  `files_xfer_used` int(10) unsigned NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table tbl_ftp_users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tbl_ftp_users`;

CREATE TABLE `tbl_ftp_users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userid` varchar(32) NOT NULL DEFAULT '',
  `passwd` varchar(32) NOT NULL DEFAULT '',
  `uid` smallint(6) NOT NULL DEFAULT '500',
  `gid` smallint(6) NOT NULL DEFAULT '500',
  `homedir` varchar(255) NOT NULL DEFAULT '',
  `shell` varchar(16) NOT NULL DEFAULT '/sbin/nologin',
  `count` int(11) NOT NULL DEFAULT '0',
  `accessed` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `fld_domains_id` bigint(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 COMMENT='ProFTP user table';



# Dump of table tbl_invoices
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tbl_invoices`;

CREATE TABLE `tbl_invoices` (
  `fld_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `fld_client_id` bigint(20) NOT NULL DEFAULT '0',
  `fld_domains_id` bigint(20) NOT NULL DEFAULT '0',
  `fld_amount` float NOT NULL DEFAULT '0',
  `fld_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `fld_date_due` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `fld_sent` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`fld_id`)
) ENGINE=InnoDB AUTO_INCREMENT=80 DEFAULT CHARSET=latin1;



# Dump of table tbl_invoices_comments
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tbl_invoices_comments`;

CREATE TABLE `tbl_invoices_comments` (
  `fld_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `fld_invoices_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `fld_comment` varchar(50) NOT NULL DEFAULT '',
  KEY `fld_id` (`fld_id`),
  KEY `fld_invoices_id` (`fld_invoices_id`),
  CONSTRAINT `tbl_invoices_comments_ibfk_1` FOREIGN KEY (`fld_invoices_id`) REFERENCES `tbl_invoices` (`fld_id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=354 DEFAULT CHARSET=latin1;



# Dump of table tbl_invoices_detail
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tbl_invoices_detail`;

CREATE TABLE `tbl_invoices_detail` (
  `fld_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `fld_invoices_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `fld_detail` text NOT NULL,
  `fld_amount` float NOT NULL DEFAULT '0',
  `fld_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`fld_id`),
  KEY `fld_invoices_id` (`fld_invoices_id`),
  CONSTRAINT `tbl_invoices_detail_ibfk_1` FOREIGN KEY (`fld_invoices_id`) REFERENCES `tbl_invoices` (`fld_id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=241 DEFAULT CHARSET=latin1;



# Dump of table tbl_invoices_gst
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tbl_invoices_gst`;

CREATE TABLE `tbl_invoices_gst` (
  `fld_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `fld_invoices_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `fld_gst_value` float NOT NULL DEFAULT '0',
  PRIMARY KEY (`fld_id`),
  UNIQUE KEY `fld_invoices_id` (`fld_invoices_id`),
  CONSTRAINT `tbl_invoices_gst_ibfk_1` FOREIGN KEY (`fld_invoices_id`) REFERENCES `tbl_invoices` (`fld_id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=76 DEFAULT CHARSET=latin1;



# Dump of table tbl_logging
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tbl_logging`;

CREATE TABLE `tbl_logging` (
  `fld_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `fld_client_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `fld_domain_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `fld_log_string` text NOT NULL,
  `fld_ip` varchar(15) NOT NULL DEFAULT '',
  `fld_date` datetime DEFAULT NULL,
  PRIMARY KEY (`fld_id`),
  KEY `fld_client_id` (`fld_client_id`),
  KEY `fld_domain_id` (`fld_domain_id`)
) ENGINE=MyISAM AUTO_INCREMENT=193 DEFAULT CHARSET=latin1;



# Dump of table tbl_payments
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tbl_payments`;

CREATE TABLE `tbl_payments` (
  `fld_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `fld_client_id` bigint(20) NOT NULL DEFAULT '0',
  `fld_amount` float NOT NULL DEFAULT '0',
  `fld_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `fld_reference` varchar(128) NOT NULL DEFAULT '',
  PRIMARY KEY (`fld_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table tbl_prov
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tbl_prov`;

CREATE TABLE `tbl_prov` (
  `fld_id` int(11) NOT NULL AUTO_INCREMENT,
  `fld_prov_iso` char(2) DEFAULT NULL,
  `fld_prov_name` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`fld_id`)
) ENGINE=MyISAM AUTO_INCREMENT=100 DEFAULT CHARSET=latin1 PACK_KEYS=1;



# Dump of table tbl_sessions
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tbl_sessions`;

CREATE TABLE `tbl_sessions` (
  `fld_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `fld_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fld_data` text NOT NULL,
  `fld_session_id` varchar(32) NOT NULL DEFAULT '',
  PRIMARY KEY (`fld_id`)
) ENGINE=MyISAM AUTO_INCREMENT=911 DEFAULT CHARSET=latin1;



# Dump of table view_CustomerList
# ------------------------------------------------------------

DROP VIEW IF EXISTS `view_CustomerList`;

CREATE TABLE `view_CustomerList` (
   `fld_company_name` VARCHAR(100) NOT NULL DEFAULT '',
   `fld_id` BIGINT(20) UNSIGNED DEFAULT '0',
   `fld_client_id` BIGINT(20) UNSIGNED DEFAULT '0',
   `fld_contact_name` VARCHAR(60) DEFAULT '',
   `fld_address1` VARCHAR(64) DEFAULT '',
   `fld_address2` VARCHAR(64) DEFAULT '',
   `fld_postal` VARCHAR(11) DEFAULT '',
   `fld_city` VARCHAR(60) DEFAULT '',
   `fld_country_id` INT(11) DEFAULT '0',
   `fld_prov_id` INT(11) DEFAULT '0',
   `fld_phone` VARCHAR(15) DEFAULT '',
   `fld_fax` VARCHAR(15) DEFAULT '',
   `fld_alternate_email` VARCHAR(30) DEFAULT ''
) ENGINE=MyISAM;



# Dump of table view_GST_Values
# ------------------------------------------------------------

DROP VIEW IF EXISTS `view_GST_Values`;

CREATE TABLE `view_GST_Values` (
   `fld_year` VARCHAR(4) DEFAULT NULL,
   `Amount` DOUBLE(19) DEFAULT NULL
) ENGINE=MyISAM;





# Replace placeholder table for view_GST_Values with correct view syntax
# ------------------------------------------------------------

DROP TABLE `view_GST_Values`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_GST_Values`
AS select
   date_format(`I`.`fld_date`,_utf8'%Y') AS `fld_year`,round(sum(`IG`.`fld_gst_value`),2) AS `Amount`
from (`tbl_invoices_gst` `IG` left join `tbl_invoices` `I` on((`IG`.`fld_invoices_id` = `I`.`fld_id`))) group by date_format(`I`.`fld_date`,_utf8'%Y');


# Replace placeholder table for view_CustomerList with correct view syntax
# ------------------------------------------------------------

DROP TABLE `view_CustomerList`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_CustomerList`
AS select
   `C`.`fld_company_name` AS `fld_company_name`,
   `CB`.`fld_id` AS `fld_id`,
   `CB`.`fld_client_id` AS `fld_client_id`,
   `CB`.`fld_contact_name` AS `fld_contact_name`,
   `CB`.`fld_address1` AS `fld_address1`,
   `CB`.`fld_address2` AS `fld_address2`,
   `CB`.`fld_postal` AS `fld_postal`,
   `CB`.`fld_city` AS `fld_city`,
   `CB`.`fld_country_id` AS `fld_country_id`,
   `CB`.`fld_prov_id` AS `fld_prov_id`,
   `CB`.`fld_phone` AS `fld_phone`,
   `CB`.`fld_fax` AS `fld_fax`,
   `CB`.`fld_alternate_email` AS `fld_alternate_email`
from (`tbl_client` `C` left join `tbl_client_billing` `CB` on((`C`.`fld_id` = `CB`.`fld_client_id`)));

/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
