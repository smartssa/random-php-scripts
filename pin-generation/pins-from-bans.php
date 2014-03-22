<?php
require_once "pin-functions.php";
$bans = file($_GET['filename']) or die ("file not found");

print "<pre>";

foreach ($bans as $key => $value) {
	$ban = $value;
	if ($ban != $oldban) {
		$pin = getUniquePin($pins);
		$pins[$key] = $pin;
	} else {
		$pins[$key] = $pin;
	}
	$oldban = $ban;
	print $pin . "\n";
}
print "</pre>";
?>
