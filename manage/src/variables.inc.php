<?php
/*
	The magical Userbase, Management tools.
	For both the users and administrators.

	Hopefully it all works out nice.

	Started: April 19, 2005

	Requirements: php4, mysql, apache

	:: dclarke@FlatlineSystems.net

	variables.inc.php 
		base variable settings and initializations.
*/

define ("DEBUG", TRUE);

// logging
define ("LOGGING", TRUE);

define ("PAGETITLE", "Flatline Systems Managment");

// Encrption Stuff
define ("CRYPT_SALT", "\$1\$AoD#r%.A0165\$");

// Database
define ("DBSERV", "random server");
define ("DBUSER", "random user");
define ("DBPASS", "random password");
define ("DBNAME", "random db name");

// global database tracking stuff

$db_last_id = ""; // last inserted id
$db_num_rows = ""; // number of rows from a query
$db_affected = ""; // number of affected rows in an update/delete

// Module stuff
$action_number = 0;

// clear some strings
$body = "";
$error_message = "";
$warning_message = "";

// start with a null menu; it's built up by modules.
$menu_structure = array();

// invoice stuff
define ("INV_HEAD"," FLATLINE SYSTEMS -- INVOICE ");
define ("INV_HEAD_ADD","INVOICE ADDRESS");
define ("INV_FOOTER_1", "Payments accepted by Cheque, www.paypal.com, or");
define ("INV_FOOTER_2", "www.certapay.com - Please send any online payments");
define ("INV_FOOTER_3", "to payments@FlatlineSystems.net - Please include");
define ("INV_FOOTER_4", "your invoice # with all payments.");
define ("GST_VALUE", 0.07);

// email stuff 
define ("MAIL_TO_CC", "Flatline Systems Information <info@FlatlineSystems.net>");
define ("MAIL_FROM", "Flatline Systems Information <info@FlatlineSystems.net>");
// subject prefix:
define ("MAIL_SUBJECT", "[fls-invoice] ");

?>
