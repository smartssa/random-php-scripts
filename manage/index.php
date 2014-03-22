#!/usr/bin/php5-cgi
<?php
/*
	The magical Userbase, Management tools.
	For both the users and administrators.
	Hopefully it all works out nice.
	Started: April 19, 2005
	Requirements: php4, mysql, apache
	:: dclarke@FlatlineSystems.net
	edit variables.inc.php to turn debugging on or off.
*/

// Initialize
// Where to find the include files;
ini_set("include_path", ".:/var/www/flatlinesystems/src/");
ini_set("session.name", "flsmanage");

require_once "startup.inc.php";

// If it says they're logged in, verify the login and action
if ($_SESSION['logged_in'] || ($_GET['action'] && $_GET['action'] != "login")) {
	// verify logged in user.
	if ( ! verify_password()) {
		// we're bad! clear that logged in flag and redirect
		error_append("You need to be logged in.");
		$_SESSION['logged_in'] = FALSE;
		redirect_root();
	}
}
// do the requested action
// action comes from apache's mod_rewrite of the friendly urls.
// see: .htaccess for details.
if ($_GET['action'])
{
	// parse the action, and execute the function assosiated
	// with it... it's kinda magic.
	if ($actions[$_GET['action']]) {
		debug_append("Attempting " . $_GET['action']);
		$pagetitle = $actions[$_GET['action']]['pagetitle'];
		$func = $actions[$_GET['action']]['function'];
		// call the registered function based on the URI
		$func();
	}
	else {
		// function not enabled or bogus action request.
		debug_append("No Function Found for " . $_GET['action'] . "");
		// redirect to root
		redirect_root();
	}
	
} // no action?
else {
	debug_append("No Action Matched");
	// no action requested, we must be at the root.
	if ($_SESSION['logged_in']) {
		// we're logged in...
		// do something? 
		// Since there's no action requested, some sort of default
		// news-type thing?
		body ("<h1>Welcome</h1><p>news goes here</p>");
		// TODO: System News
	} else {
		// spew the form.
		login_form();
	}
}

// Templating (final output)
require_once "templates.inc.php";

// Fin.
debug_append("END!");
exit();
?>
