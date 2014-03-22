<?php
/*
	The magical Userbase, Management tools.
	For both the users and administrators.

	Hopefully it all works out nice.

	Started: April 19, 2005

	Requirements: php4, mysql, apache

	:: dclarke@FlatlineSystems.net

	templates.inc.php 
		naked templating system
*/

// header
if ($pagetitle == "")
	$pagetitle = "Welcome";
	
$pagetitle = $pagetitle . " :: " . PAGETITLE;

if ($_SESSION['logged_in']) {
	$header = "<h1><a href=\"/\">" . $pagetitle . "</a></h1>";
	$header .= "<h6> Logged in as " . $_SESSION['company_name']  . "</h6>";
} else {
	$header = "<h1><a href=\"/\">" . PAGETITLE . "</a></h1>";
}
print <<< EOT
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
<title>{$pagetitle}</title>
<style type="text/css" title="Colours" media="all">
	@import "/master.css";
</style>
</head>
<body>
<div id="header">
	{$header}
</div>
EOT;

// menu 
$menu = build_menu();
print <<< EOT
<div id="menu">
	{$menu}
</div>
EOT;

// errors (before body)
if ($error_message) {
	print <<< EOT
	<div id="errorbox">
		{$error_message}
	</div>
EOT;
}
// warnings (after errors)
if ($warning_message) {
	print <<< EOT
	<div id="warningbox">
		{$warning_message}
	</div>
EOT;
}

// body
print <<< EOT
<div id="body">
	{$body}
</div>
EOT;

// footer
$footer = date("l, F jS @ g:i a T");
print <<< EOT
<div id="footer">
	{$footer}
</div>
</body></html>
EOT;

?>