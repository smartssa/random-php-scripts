<?php
/*
	Hit a simple query and spew out an
	XML result for use in my AJAX app.
*/
require_once("database.inc.php");

// 1/ parse pathinfo to get the required action

$args = explode("/", $PATH_INFO);

// chunk off the first argument
// the first is null due to the first /
$junk = array_shift($args);
$action = array_shift($args);

// blank return value;
$return_value = "";

// simple backend with a breakup of actions.
// any action must return a valid XML output in '$return_value'

switch ($action) {
	case "List":
		// Gimme a list!
		require_once "ajax-backend-listing.inc.php";
		break;
	case "GetRecord":
		// Gimme a single record!
		require_once "ajax-backend-getrecord.inc.php";	
		break;
	case "Config":
		// Gimme some config data for the JS
		require_once "ajax-backend-config.inc.php";
		break;
	default:
		// Nothing! Throw an error.
		require_once "ajax-backend-error.inc.php";
		break;
}

// 2/ return xml data

header("Content-type: text/xml");
print $return_value;

?>
