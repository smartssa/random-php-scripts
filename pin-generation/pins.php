<?php

require_once "database.inc.php";
session_start();
$_SESSION['notices'] = '';
$_SESSION['percent'] = '';
// number of pins to generate:
$PinCount = $_POST['pincount'];
$pins = array();

print "<html><head><title>Pin Generator</title>
	<script type=\"text/javascript\" src=\"http://x.bjca.net/prototype.js\"></script>
	<script type=\"text/javascript\" src=\"pinscript.js\"></script>
	</head><body>";
print "<form id=\"pinform\" method=\"POST\">
	<fieldset>
		<label for=\"pincount\" accesskey=\"p\">Number of Pins to Generate: </label>
		<input name=\"pincount\" id=\"pincount\" size=\"20\" value=\"".$_POST['pincount']."\"/>
		<input type=\"submit\" value=\"Go!\" onClick=\"Form.disable('pinform'); doPins(); return false;\" name=\"submit\"/>
		</fieldset>
	</form>";
print "<div id=\"progressbar\" style=\"width: 90%; margin: 5%; border: 1px solid black;\"></div>";
print "<h2 id=\"notices\">Notices</h2><div style=\"overflow: auto; width: 50%; height: 50%;\" id=\"pinnotices\"></div>";
print "<div style=\"border: 1px solid black; width: 50%;\" id=\"pinoutput\"></div>";
print "</body></html>";
?>
