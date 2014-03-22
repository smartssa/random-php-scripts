<?php
/*
	The magical Userbase, Management tools.
	For both the users and administrators.

	Hopefully it all works out nice.

	Started: April 19, 2005

	Requirements: php4, mysql, apache

	:: dclarke@FlatlineSystems.net

	login.inc.php 
		basic login checking and stuff
*/

// verify login, if it claims they are 'logged in'
function login_verify() {
	// check on session stuff and set the $_SESSION['logged_in'] variable to true.
	// if verify fails, it resorts to the default.
	$_SESSION['logged_in'] = FALSE;
	$_SESSION['logged_in'] = verify_password($_SESSION['username'], $_SESSION['password']);

	// redirect to root and force a login.
	if (!$_SESSION['logged_in'] && $_GET['action']) {
		warning_append("You must be logged in.");
		redirect_root();
	}
			
}
// show login form
function login_form() {

	body("<form name=\"login\" method=\"post\" action=\"/login/\">
			<fieldset>
			<legend>Login</legend>
			<label for=\"username\">Login: </label>
			<input name=\"username\" size=\"32\" /><br />
			<label for=\"password\">Password: </label>
			<input name=\"password\" type=\"password\" size=\"32\"/><br />
			<label for=\"button\">&nbsp;</label>
			<input type=\"submit\" name=\"button\" value=\"Login\" />
			</fieldset>
			</form>");

}

// process login request
function login() {
	// Just set some variables.
	$_SESSION['username'] = $_POST['username'];
	$_SESSION['password'] = crypto($_POST['password']);
	$_SESSION['remote_addr'] = $_SERVER['REMOTE_ADDR'];
	$_SESSION['domain_id'] = 0;
	
	debug_append("Setting Session for " . $_POST['username'] . ":" . $_POST['password']);
	// verify password.
	$_SESSION['logged_in'] = verify_password();
	
	if (!$_SESSION['logged_in']) {
		log_insert("Failed Login Attempt");
		error_append("Invalid Login or Password.");
	} else {
		log_insert("User Logged In");
		warning_append("You have been logged in.");
	}
	redirect_root();
}

// process logout
function logout() {
	// log it
	log_insert("User Logged Out");
	// kill session & redirect. (Can't notify! session destroyed)
	session_destroy();
	// redirect
	redirect_root();
	
}

function verify_password() {
	// check the user & pass to the db.
	//	return true or false;
	global $db_num_rows;
	
	debug_append("Verifying " . $_SESSION['username'] . "crytpo string: " . $_SESSION['password']);
	
	$query = "SELECT fld_id, fld_company_name FROM tbl_client WHERE
				fld_contact_email = '" . $_SESSION['username'] . 
				"' AND fld_password = '" . $_SESSION['password'] . "'";
	
	$result = db_query($query);
	
	if ($db_num_rows) {
		$row = mysql_fetch_assoc($result);
		debug_append("Matched Password: " . $row);
		$_SESSION['company_name'] = $row['fld_company_name'];
		$_SESSION['client_id'] = $row['fld_id'];
		return true;
	} else {
		debug_append("PASSWORD NOT MATCHED!");
		return false;
	}
}
?>