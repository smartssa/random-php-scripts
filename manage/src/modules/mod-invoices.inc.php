<?php
/*
	The magical Userbase, Management tools.
	For both the users and administrators.

	Started: April 19, 2005

	Requirements: php4, mysql, apache

	:: dclarke@FlatlineSystems.net

	mod-invoices.inc.php
		invoice managment module

*/

// setup the modules, register it in the menu
register_actions('invoice', 'Invoice Managment', 'invoice_module');

// this is the sub-menu array.
$options = array("View" => "view/", 
						"Add" => "add/",
						"Help" => "help/");

// register the menu stuff here;
register_menu("invoice", "Invoices", "Invoice Managment", "/invoice/", $options);

														
// TODO

function invoice_module() {
	global $actions, $db_last_id;
	debug_append("Entered Invoice Module attempting method: " . $_GET['method'] );

	// show some admin menu, or something.

	$action = $_GET['action'];
	$method = $_GET['method'];
	$value = $_GET['value'];
	
	body("<h1>Invoice Managment</p>");
	if ($_SESSION['domain_name'])
		body(" :: " . $_SESSION['domain_name']);

	body("</h1>");	

	if ($method != "add") {	
	body ("<div id=\"domainlist\">");
	domain_list();
	body ("</div>");
	
	// things to do in this module:
	// show user invoices
//	if (! $_GET['value']) {
	body ("<div id=\"detailbox\">");
	list_invoices();
	body ("</div>");
	
	} if ($method == "add" && ! $_POST['frm_submit']) {
		// magical invoice adder
		body ("<div id=\"full\">");
		body ("<h6>New Invoice</h6>");
		
		// invoice form.
		body ("<form name=\"invoice\" method=\"post\">");
		
		body (get_client_list_form());
		body (get_domain_list_form());

		body ("<br />");
		body ("Due: " . get_terms_list_form() . "<br />");
		body ("Details:<br />");
		for ($i = 1; $i <= 10; $i++) {
		body ("<input size=\"50\" name=\"frm_invoice_details[$i][detail]\" />");
		body ("<input size=\"10\" name=\"frm_invoice_details[$i][value]\" /><br />\n");
		}
		body ("Comments/Notes:<br />");
		for ($i = 1; $i <= 10; $i++) {
			body ("<input size=\"50\" name=\"frm_invoice_comment[$i]\" /><br />");
		}		
		body ("<input type=\"submit\" name=\"frm_submit\" value=\"Create Invoice\">");
		body ("</form>");
		body ("</div>");
	} if ($method == "add" && $_POST['frm_submit']) {
		// Inject!
		$query = "INSERT INTO tbl_invoices (fld_client_id, fld_domains_id, fld_date, fld_date_due)
					VALUES(" . $_POST['frm_client_id'] .",". $_POST['frm_domain_id'] . ", NOW(), DATE_ADD(NOW(), INTERVAL " . $_POST['frm_invoice_terms'] . " DAY))";
					
		$result = db_query($query);
		$invoice_id = $db_last_id;
		$comments = $_POST['frm_invoice_comment'];
		foreach ($comments as $key => $comment) {
			// inject comments.
			if ($comment != "") {
			$query = "INSERT INTO tbl_invoices_comments (fld_invoices_id, fld_comment)
							VALUES('" . $invoice_id . "','" . $comment . "')";
			$result = db_query($query);
			}	
		}
		
		$details = $_POST['frm_invoice_details'];
		foreach ($details as $key => $detail) {
			// inject details.
			if ($detail['detail'] != "") { // let null values fly... && $detail['value'] != "") {
				$query = "INSERT INTO tbl_invoices_detail (fld_invoices_id, fld_detail, fld_amount, fld_date)
							VALUES ('" . $invoice_id . "','" . $detail['detail'] . "','" . $detail['value'] . "',NOW())";
				$result = db_query($query);
				$total = $total + $detail['value'];
			}
		}
		// GST?
		if (do_gst($_POST['frm_client_id'])) {
			$gst = $total * GST_VALUE;
			$query = "INSERT INTO tbl_invoices_gst (fld_invoices_id, fld_gst_value) 
						VALUES('" . $invoice_id . "','" . $gst . "')";
						
			$result = db_query($query);
			$total = $total + $gst;
		}
		// update the lusers balance.
		$query = "UPDATE tbl_client SET fld_balance = fld_balance + " .$total . " WHERE fld_id = " . $_POST['frm_client_id'];
		$result = db_query($query);
		$query = "UPDATE tbl_invoices SET fld_amount = " . $total . " WHERE fld_id = " . $invoice_id;
		$result = db_query($query);
	}

	if ($method == "view" && $value > 0) {
		// show the invoice.
		$inv = show_invoice();
		if ($inv) {
			body ("<div id=\"bigdetailbox\">");
			body ("<pre>" . $inv . "</pre>");
			$dest_email = get_invoice_owner($value);
			body ("<p><a href=\"/invoice/email/". $value . "/\">Email This to " . $dest_email ."</a></p>");
			body ("</div>");
		}
	}
	if ($method == "email" && $value > 0){
		$inv = show_invoice();
		$signed = gpg_sign($inv);
		// send email
		// redirect last
		if (mail(get_invoice_owner($value). "," . MAIL_TO_CC,
					MAIL_SUBJECT . get_invoice_domain($value). "/WEB" . 
					str_pad($value, 7, 0, STR_PAD_LEFT),
					$signed, "From: " . MAIL_FROM . "\r\n")) {
			warning_append("Email sent.");
			log_insert("Email sent, Invoice " . $value);
		}	else {
			error_append("Email failed");
			log_insert("Email failed, Invoice " . $value);
		}
		redirect_last();
	}
	
	// allow admin to add new invoices
		// stuff like that.
		
}

function list_invoices() {
	
		$query = "SELECT fld_id, fld_amount, fld_date, fld_sent from
					tbl_invoices WHERE fld_domains_id = " . $_SESSION['domain_id']; /* .
					" AND fld_client_id = " . $_SESSION['client_id'];*/
					
		$result = db_query($query);
		body ("<ul>");
		while ($row = mysql_fetch_assoc($result)) {
			// cycle and spew.
			body ("<li><a href=\"/invoice/view/" . $row['fld_id'] ."/\">". $row['fld_date'] . 
				" $" . number_format($row['fld_amount'],2) . "</a></li>");
		}
		body ("</ul>");
}

function show_invoice() {
		global $db_num_rows;
		
		$id = $_GET['value'];
		// time for a big super duper invoice query...
		$query = "SELECT tbl_client.fld_company_name, 
					tbl_client_billing.*, 
					tbl_invoices.*, 
					tbl_invoices_detail.*,
					tbl_prov.fld_prov_iso,
					tbl_country.fld_country_name
					FROM `tbl_invoices` 
					LEFT JOIN tbl_client ON tbl_invoices.fld_client_id = tbl_client.fld_id
					LEFT JOIN tbl_client_billing ON tbl_invoices.fld_client_id = tbl_client_billing.fld_client_id
					LEFT JOIN tbl_invoices_detail ON tbl_invoices.fld_id = tbl_invoices_detail.fld_invoices_id
					LEFT JOIN tbl_prov ON tbl_client_billing.fld_prov_id = tbl_prov.fld_id
					LEFt JOIN tbl_country ON tbl_client_billing.fld_country_id = tbl_country.fld_id
					WHERE tbl_invoices.fld_id = " . $id . " AND tbl_invoices.fld_domains_id = " . $_SESSION['domain_id'];
		$result = db_query($query);
		
		while ($row = mysql_fetch_assoc($result)) {
			// cycle and spew! That's what I say.
			// assign variables for the invoice template.
			$i = 1;
			if ($row['fld_company_name'] != $row['fld_contact_name']) {
				$inv_address[$i++] = $row['fld_company_name'];
				$inv_address[$i++] = $row['fld_contact_name'];
			}
			else {
				$inv_address[$i++] = $row['fld_contact_name'];
			}
			$inv_address[$i++] = $row['fld_address1'];
			if ($row['fld_address2'] != "") {
				$inv_address[$i++] = $row['fld_address2'];
			}
			$inv_address[$i++] = $row['fld_city'] . " " .$row['fld_prov_iso'] . " " . $row['fld_postal'];
			$inv_address[$i++] = $row['fld_country_name'];
			
			$r++;
			$inv_items[$r] = array( "desc" => $row['fld_detail'],
											"amount" => $row['fld_amount']);
											
			$inv_subtotal += $row['fld_amount'];
			$inv_date = date("Y/m/d", mysql_to_epoch($row['fld_date']));
			if ($row['fld_date_due'] > 0) {
				$inv_due = date("Y/m/d", mysql_to_epoch($row['fld_date_due']));
			} else {
				$inv_due = "Now";
			}
			if ($row['fld_ponum']) {
				$inv_ponum = $row['fld_ponum'];
			} else {
				$inv_ponum = "N/A";
			}
			$country_id = $row['fld_country_id'];
		}
		if ($db_num_rows) {
			// can't show an invoice if data doesn't exist!
			// get the GST value(if applicable)
			if ($country_id = 38) {
				$query = "SELECT fld_gst_value FROM tbl_invoices_gst
							WHERE fld_invoices_id = " . $id;
				$result = db_query($query);
				if ($db_num_rows) {
					$row = mysql_fetch_assoc($result);
					$inv_gst = $row['fld_gst_value'];
				}	
				//GST in canada only!
			} else {
				$inv_gst = "";
			}
			// get comments for the invoice.
			$query = "SELECT fld_id, fld_comment FROM tbl_invoices_comments
						WHERE fld_invoices_id = " . $id;
			$result = db_query($query);
			while ($row = mysql_fetch_assoc($result)) {
				// assign to inv_comment
				$rowid = $row['fld_id'];
				$inv_comment[$rowid] = $row['fld_comment'];
			}

			// some basic mathemetical stuff...
			$inv_balance = $inv_subtotal + $inv_previous - $inv_payments + $inv_gst;
			$inv_number = "WEB" . str_pad($id, 7, 0, STR_PAD_LEFT);
			// get the lovin' from the template (it assigns to $inv)
			require_once "tools/invoice-output.php";
		}
		return $inv;
}

function gpg_sign($plain_text) {
	$descriptorspec = array(
	   0 => array("pipe", "r"), // stdin
	   1 => array("pipe", "w"), // stdout
	   2 => array("pipe", "w")  // stderr ?? instead of a file
	  );
  $process = proc_open("gpg --homedir /var/www/flatlinesystems/.gpg --default-key info@FlatlineSystems.net --clearsign", 
	  		$descriptorspec, $pipes);
  if (is_resource($process)) {
   fwrite($pipes[0], $plain_text);
   fclose($pipes[0]);
   while($s= fgets($pipes[1], 1024)) {
         // read from the pipe
         $signed_text .= $s;
   }
   fclose($pipes[1]);
   // optional:
   while($s= fgets($pipes[2], 1024)) {
     error_append("$s");
   }
   fclose($pipes[2]);
  }
  return $signed_text;
}
?>
