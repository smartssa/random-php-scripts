<?php
/*
	The magical Userbase, Management tools.
	For both the users and administrators.

	Started: April 19, 2005

	Requirements: php4, mysql, apache

	:: dclarke@FlatlineSystems.net

	mod-email.inc.php
		email managment module

*/

// setup the modules, register it in the menu
register_actions('email', 'Mail Administration', 'email_module');

// this is the sub-menu array.
$options = array("View" => "view/", 
		"New" => "new/",
		"Edit" => "edit/",
		"Delete" => "delete/",
		"Help" => "help/");

// register the menu stuff here;
register_menu("email", "Mail", "Mail Administration", "/email/", $options);
						
// TODO

function email_module() {
	global $actions;
	debug_append("Entered email Module attempting method: " . $_GET['method'] );


	$action = $_GET['action'];
	$method = $_GET['method'];
	body("<h1>Email Administration");
	if ($_SESSION['domain_name'])
		body(" :: " . $_SESSION['domain_name']);

	body("</h1>");
	
	// things to do in this module:
	body ("<div id=\"domainlist\">");
	domain_list();
	body ("</div>");
	// view aliases, forwards, mailboxes
	// add aliases, forwards, mailboxes
	// delete aliases, forwards, mailboxes
	// mailing list stuff? (FUTURE: TODO)	
	
	// view mode
	body ("<div id=\"detailbox\">");
	list_accounts();
	body ("</div>");
		
	// view details...
	
	// edit details...
	
	// new account/alias/whatever
	
	// delete confirmation...
	
}

function list_accounts() {
	// list all the accounts for this thing.
	body ("<h6>Mailboxes</h6>");
	
	body ("<h6>Aliases</h6>");
	
	body ("<h6>Forwards</h6>");
}
?>
