<?php
/*
	The magical Userbase, Management tools.
	For both the users and administrators.

	Hopefully it all works out nice.

	Started: April 19, 2005

	Requirements: php4, mysql, apache

	:: dclarke@FlatlineSystems.net

	debug.inc.php 
		simple debugging shit
*/

function debug_append($string) {
	// append to debugging file
	
	// lots of debugging means lots of lines appended! 
	
	// use with caution
	if (DEBUG) {
		$string = date("r") . " " . $string . " [" . $_SERVER['REMOTE_ADDR'] . "] " . $_SERVER['REQUEST_URI'] . "\n";
		$fp = fopen("debug.log", "a");
		fputs($fp, $string);
		fclose($fp);
	}
	// else do nothing.
}
?>