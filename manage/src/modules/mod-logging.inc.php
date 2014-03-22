<?php
/*
	The magical Userbase, Management tools.
	For both the users and administrators.

	Started: April 19, 2005

	Requirements: php4, mysql, apache

	:: dclarke@FlatlineSystems.net

	mod-logging.inc.php
		user log viewing

*/

// setup the modules, register it in the menu
register_actions('logging', 'Event Logging Viewer', 'logging_module');

// this is the sub-menu array.
$options = array("There are no sub features." => "#");

// register the menu stuff here;
register_menu("logging", "Logging", "Event Logging Viewer", "/logging/", $options);

														
// TODO

function logging_module() {
	global $actions;
	debug_append("Entered Logging Module attempting method: " . $_GET['method'] );


	$action = $_GET['action'];
	$method = $_GET['method'];
	body("<h1>Activity Log for: ". $_SESSION['company_name'] ." </h1>");
	
	$query = "SELECT * FROM tbl_logging WHERE fld_client_id = " . $_SESSION['client_id'];
	
	$result = db_query($query);
	body ("<ul>");
	while ($log = mysql_fetch_assoc($result)) {
		// cycle and spit it out.
		// TODO: Pretty formatting.
		body ("<li>" . $log['fld_log_string'] . "</li>");
		body ("<ul class=\"log\">");
		body ("<li>" . $log['fld_ip'] . "</li>");
		body ("<li>" . $log['fld_date'] . "</li>");
		body ("</ul>");

	}
	body ("</ul>");
}
?>