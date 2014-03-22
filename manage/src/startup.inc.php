<?php
/*
	The magical Userbase, Management tools.
	For both the users and administrators.

	Hopefully it all works out nice.

	Started: April 19, 2005

	Requirements: php4, mysql, apache

	:: dclarke@FlatlineSystems.net

	startup.inc.php
		base startup shizzle, make sure
			everything's in place.
*/

// Variable Initialization
require_once "variables.inc.php";

// require additional code base
require_once "information.inc.php";
require_once "debug.inc.php";
require_once "logging.inc.php";
require_once "messages.inc.php";
require_once "redirections.inc.php";
require_once "menu.inc.php";
require_once "domains.inc.php";
require_once "crypto.inc.php";

// database stuff
require_once "database.inc.php";

// Sessions Setup
require_once "sessions.inc.php";


// Login Module
// * Verify logged in user, or request login
require_once "login.inc.php";

// load all module files and register with the menu class
// -- controls user access.

// Menu order is determined by their include order!
require_once "modules/mod-email.inc.php";
require_once "modules/mod-dns.inc.php";
require_once "modules/mod-invoices.inc.php";
require_once "modules/mod-logging.inc.php";

// extra menu items that won't be modules...
if ($_SESSION['logged_in']) {
	register_menu("logout", "Logout", "Logout of the System", "/logout/");
}
// how to handle logouts
register_actions("logout", "Logout", "logout");

// how to handle login requests!
register_actions("login", "login", "login");

// 'active domain' switcher handler thing...
register_actions("setdomain","setdomain","setdomain");
 
// Help is going to be a module.
// register_menu("help", "Help", "Help System and FAQ", "/help/");

// insert the warning or error message on the previous page...
// if it was redirected instead of actually outputted...

if ($_SESSION['warning']) {
	warning_append($_SESSION['warning']);
	$_SESSION['warning'] = "";
}

if ($_SESSION['error']) {
	error_append($_SESSION['error']);
	$_SESSION['error'] = "";
}
?>
