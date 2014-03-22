<?php
/*
	The magical Userbase, Management tools.
	For both the users and administrators.

	Hopefully it all works out nice.

	Started: April 19, 2005

	Requirements: php4, mysql, apache

	:: dclarke@FlatlineSystems.net

	messages.inc.php
		data buliding system.
		for template variables, and stuff.
		
*/
function error_append($string) {
	// simple function to append to error mesages;
	global $error_message;	
	$error_message .= $string;

	// add to debugging too.
	debug_append($string);

	return true;	
}

function warning_append($string) {
	// simple function to append to warning messages;
	global $warning_message;
	$warning_message .= $string;
	
	return true;
}
function body ($string) {
	// simple function to append to the output body.
	
	global $body;
	$body .= $string;
	
	return true;
}
?>