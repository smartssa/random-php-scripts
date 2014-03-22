<?php
/*
	The magical Userbase, Management tools.
	For both the users and administrators.

	Started: April 19, 2005

	Requirements: php4, mysql, apache

	:: dclarke@FlatlineSystems.net

	mod-dns.inc.php
		dns managment module

*/

// setup the modules, register it in the menu
register_actions('dns', 'DNS Administration', 'dns_module');

// this is the sub-menu array.
$options = array("View" => "view/", 
						"Edit" => "edit/",
						"Delete" => "delete/",
						"Help" => "help/");

// register the menu stuff here;
register_menu("dns", "DNS", "DNS Administration", "/dns/", $options);

														
// TODO

function dns_module() {
	global $actions;
	debug_append("Entered DNS Module attempting method: " . $_GET['method'] );


	$action = $_GET['action'];
	$method = $_GET['method'];
	body("<h1>DNS Administration</p>");
	if ($_SESSION['domain_name'])
		body(" :: " . $_SESSION['domain_name']);

	body("</h1>");	
	
	body ("<div id=\"domainlist\">");
	domain_list();
	body ("</div>");
	
	
	// things to do in this module:
	// edit dns records
	//		a, a6, aaaa, cname -- only?
	
	// view current dns record
	
	// delete some stuff
	
	// notice that certain things can't be changed
	// due to hosting...
	
}
?>