<?php
/*
	The magical Userbase, Management tools.
	For both the users and administrators.

	Hopefully it all works out nice.

	Started: April 19, 2005

	Requirements: php4, mysql, apache

	:: dclarke@FlatlineSystems.net

	information.inc.php
		basic functions to return specific information from
		whatever table they need to come from.

*/

function get_invoice_owner($inv_id) {
	// return the email address of the owner of invoice id
	$query = "SELECT tbl_client.fld_contact_email 
				FROM tbl_invoices
				LEFT JOIN tbl_client ON tbl_invoices.fld_client_id = tbl_client.fld_id
				WHERE tbl_invoices.fld_id = " . $inv_id;
	$result = db_query($query);
	$row = @mysql_fetch_assoc($result);
	
	return $row['fld_contact_email'];
	
}

function get_invoice_domain($inv_id) {
	// return the domain name associated with invoice id.
	$query = "SELECT tbl_domains.fld_domain_name
				FROM tbl_invoices
				LEFT JOIn tbl_domains ON tbl_invoices.fld_domains_id = tbl_domains.fld_id
				WHERE tbl_invoices.fld_id = " . $inv_id;
	$result = db_query($query);
	$row = @mysql_fetch_assoc($result);
	
	return $row['fld_domain_name'];
}

function get_client_list_form() {
	// return a form element <select> containing all clients</select>
	
	$query = "SELECT fld_id, fld_company_name FROM tbl_client";
	
	$result = db_query($query);
	
	$form = "<select name=\"frm_client_id\">\n";
	while ($row = mysql_fetch_assoc($result)) {
		// here we go!
		$form .= "<option value=\"" . $row['fld_id'] . "\">";
		$form .= $row['fld_company_name'];
		$form .= "</option>\n";
	}
	$form .= "</select>\n";

	return $form;
}

function get_country_list_form() {
	// return a form element containgin all countries
	
	$query = "SELECT * FROM tbl_country ORDER BY fld_country_name";
	
	$result = db_query($query);
	$form = "<select name=\"frm_country_id\">\n";
	while ($row = mysql_fetch_assoc($result)) {
		// here we go!
		$form .= "<option value=\"" . $row['fld_id'] ."\">";
		$form .= $row['fld_country_name'] . " (" . $row['fld_country_iso'] . ")";
		$form .= "</option>\n";
	}
	$form .= "</select>";
	
	return $form;
}

function get_province_list_form() {
	// return a form element containgin all countries
	
	$query = "SELECT * FROM tbl_prov";
	
	$result = db_query($query);
	$form = "<select name=\"frm_province_id\">\n";
	while ($row = mysql_fetch_assoc($result)) {
		// here we go!
		$form .= "<option value=\"" . $row['fld_id'] ."\">";
		$form .= $row['fld_prov_name'] . " (" . $row['fld_prov_iso'] . ")";
		$form .= "</option>\n";
	}
	$form .= "</select>";
	
	return $form;
}

function get_domain_list_form() {
	// return a form element containgin all countries
	// $id == client id.
	
	$query = "SELECT fld_id, fld_domain_name FROM tbl_domains ORDER BY fld_domain_name";
	
	$result = db_query($query);
	$form = "<select name=\"frm_domain_id\">\n";
	while ($row = mysql_fetch_assoc($result)) {
		// here we go!
		$form .= "<option value=\"" . $row['fld_id'] ."\">";
		$form .= $row['fld_domain_name'];
		$form .= "</option>\n";
	}
	$form .= "</select>";
	
	return $form;
}

function get_terms_list_form() {
	// return a list for the terms of payment (net 30, etc.)
	
	$form = "<select name=\"frm_invoice_terms\">";
	$form .= "<option value=\"0\">Now</option>";
	$form .= "<option value=\"15\">Net 15</option>";
	$form .= "<option value=\"30\">Net 30</option>";
	$form .= "<option value=\"45\">Net 45</option>";
	$form .= "<option value=\"60\">Net 60</option>";
	$form .= "</select>\n";
	return $form;
}

function do_gst($client_id) {
	// do gst if the customer is canukistan.
	$query = "SELECT fld_country_id FROM tbl_client_billing WHERE fld_client_id = ". $client_id ." LIMIT 1";
	$result = db_query($query);
	$row = @mysql_fetch_assoc($result);
	if ($row['fld_country_id'] == 38)
		return true;
	else
		return false;
}
?>