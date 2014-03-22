<?php
/*
	The magical Userbase, Management tools.
	For both the users and administrators.

	Hopefully it all works out nice.

	Started: April 19, 2005

	Requirements: php4, mysql, apache

	:: dclarke@FlatlineSystems.net

	database.inc.php 
		database stuff, query's, connects, etc.
*/

function db_connect() {
	// general connection
	// NON persistant.
	$db = mysql_connect(DBSERV, DBUSER, DBPASS)
		or error_append("Failed to connect to the database. A whole bunch of errors will follow this.");

	@mysql_select_db (DBNAME, $db);
	
	return $db;	
}

function db_query($query) {
	global $db_last_id, $db_num_rows, $db_affected;
	// general query
	debug_append("Excuting: $query");
	$db = db_connect();
	
	$result = mysql_query($query, $db)
		or error_append("Failed to execute query: " . $query . " : " . mysql_error());
	
	$db_last_id = mysql_insert_id();
	$db_num_rows = @mysql_num_rows($result);
	$db_affected = mysql_affected_rows();
	
	debug_append("Exiting Query function");
	return $result;
	
}

function db_pager($query, $limit = 25) {
	// paging function for data
	// default limit of 25 items.
	// TODO: paging.	
}

function mysql_to_epoch($datestr) {
	// convert a mysql-formatted date string to unix 
	// epoch for use in the date() function.
	list($year,$month,$day,$hour,$minute,$second) = split("([^0-9])",$datestr);
	return date("U",mktime($hour,$minute,$second,$month,$day,$year));
}
?>