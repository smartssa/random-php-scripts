<?php
/*
	The magical Userbase, Management tools.
	For both the users and administrators.

	Hopefully it all works out nice.

	Started: April 19, 2005

	Requirements: php4, mysql, apache

	:: dclarke@FlatlineSystems.net

	domains.inc.php
		handy utilities for dealing with domains
		
*/

function setdomain() {
	
	// set the active domain
	$query = "SELECT fld_domain_name FROM tbl_domains
				 WHERE " /*fld_client_id = " . $_SESSION['client_id'] .
				 " AND */ . "fld_id = " . $_GET['method'] . ";";
	
	// verify the domain belongs to client_id
	$result = db_query($query);	
	// set the session variables
	$row = mysql_fetch_assoc($result);
	if ($row['fld_domain_name'] != "") {
		$_SESSION['domain_id'] = $_GET['method'];
		$_SESSION['domain_name'] = $row['fld_domain_name'];	
	} else {
		error_append("Error: That's not your domain.");
		log_insert("Error: Attempted to switch to domain " . $_GET['method']);
	}
	redirect_last();
}

function domain_list() {
	// return the list of domains for the client_id
	
	// only ones they own.
	$query = "SELECT fld_domain_name, fld_id FROM tbl_domains";
			/*	 WHERE fld_client_id = " . $_SESSION['client_id'] . ";";*/
				 
	$result = db_query($query);
	
	body("<ul class=\"domainlist\">");
	while ($domains = mysql_fetch_assoc($result)) {
	
		// set the highlight based on $_SESSION['domain_id']
		if ($domains['fld_id'] == $_SESSION['domain_id'])
			$highlight = " class=\"listactive\"";
		else
			$highlight = "";
			
		// cycle and spew, you know the routine.
		body ("<li" . $highlight . "><a href=\"/setdomain/" . 
				$domains['fld_id'] . "/\" title=\"Select " . 
				$domains['fld_domain_name'] . "\">" .
				$domains['fld_domain_name'] . 
				"</a></li>");
	}
	body ("</ul>");
}
?>