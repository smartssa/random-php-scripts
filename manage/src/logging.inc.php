<?php
/*
	The magical Userbase, Management tools.
	For both the users and administrators.

	Hopefully it all works out nice.

	Started: April 19, 2005

	Requirements: php4, mysql, apache

	:: dclarke@FlatlineSystems.net

	logging.inc.php 
		simple event logging.
*/

function log_insert($string) {
	// insert string into the logging table.
	// if logging is enabled.
	debug_append("Logging $string");
	if (LOGGING) {
		$query = "INSERT INTO tbl_logging (fld_client_id, fld_domain_id, fld_log_string, fld_ip, fld_date)
					VALUES (" . $_SESSION['client_id'] . "," . 
					$_SESSION['domain_id'] . ",'" .
					$string . "', '" . 
					$_SERVER['REMOTE_ADDR'] . "',NOW());";
		db_query($query);
		
		return true;	
	}
	
	return false;
}
?>