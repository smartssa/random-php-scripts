<?php
/*
	The magical Userbase, Management tools.
	For both the users and administrators.

	Hopefully it all works out nice.

	Started: April 19, 2005

	Requirements: php4, mysql, apache

	:: dclarke@FlatlineSystems.net

	crypto.inc.php 
		encrypt/decrypt functions for passwords.
*/

function crypto($string) {
	// crypto magic
	// returns a crypto string, that's it.
	// get the salt from the existing pw string

	if ($_SESSION['username']) {
		$query = "SELECT fld_password FROM tbl_client WHERE fld_contact_email = '" . $_SESSION['username'] . "';";
		$result = db_query($query);

		$pass = mysql_fetch_assoc($result);
		if (strstr($pass['fld_password'], "\$1\$")) {
			$salt = substr($pass['fld_password'], 0, 12);
			debug_append("CRYPT: Got Salt: $salt == " .$pass['fld_password']);
		}
		else {
			debug_append("CRYPT: Failed Salt Finding == " . $pass['fld_password']);
		}
	}

	// phear the crazy salt.
	if ($salt)
		return crypt($string, $salt);
	else
		return crypt($string);

}

?>
