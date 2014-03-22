<?php

/*
	The magical Userbase, Management tools.
	For both the users and administrators.

	Hopefully it all works out nice.

	Started: April 19, 2005

	Requirements: php4, mysql, apache

	:: dclarke@FlatlineSystems.net

	sessions.inc.php
		base session details and startup shizzle
		session data contained in the sql database
*/

function sess_open($sess_path, $sess_name) {
	// just return true, we don't open any sess files.
	return true;
}

function sess_close() {
	// just return true, we don't close any sess files.
	return true;
}

function sess_read($sess_id) {
	debug_append("Attempting to read $sess_id from DB");
	global $db_num_rows;
	// read the session from the database.
	$query = "SELECT fld_data FROM tbl_sessions WHERE fld_session_id = '".$sess_id."'";
	debug_append("Executing Read Query...");
	$result = db_query($query);
	$now = time();
	if (! $db_num_rows)
	{
		debug_append("No rows found, inserting");
		// insert a new one, cuz it doesn't exist in the db
		db_query("INSERT INTO tbl_sessions (fld_session_id, fld_timestamp)
					VALUES ('" . $sess_id . "', NOW())");
		return '';
	} else {
		debug_append("Row Found, reading...");
		// update the last visted time, so it doesn't get destroyed.
		extract(mysql_fetch_array($result), EXTR_PREFIX_ALL, 'sess');
		db_query("UPDATE tbl_sessions SET fld_timestamp = NOW() WHERE
					fld_session_id = '" . $sess_id . "'");
		return $sess_fld_data;			
	}
	debug_append("Read Failed.");
	return '';
}

function sess_write($sess_id, $data) {
	// simple update
	db_query("UPDATE tbl_sessions SET fld_data = '" . $data . "',
				fld_timestamp = NOW() WHERE fld_session_id = '" . $sess_id . "';");
				
	return true;
}

function sess_destroy($sess_id) {
	$query = "DELETE FROM tbl_sessions WHERE fld_session_id = '" . $sess_id . "'";
	debug_append("Session Destroyed: $sess_id");
	db_query($query);
	return true;
}

function sess_gc($sess_maxlifetime) {
	// Garbage Collection
	// delete any old stuff beyond the maxlifetime.
	$now = time();
	db_query("DELETE FROM tbl_sessions WHERE fld_timestamp + " . $sess_maxlifetime . " < NOW();");
	return true;
}

session_set_save_handler("sess_open", "sess_close", "sess_read", "sess_write", "sess_destroy", "sess_gc");
session_start();

// go to town!
 
?>