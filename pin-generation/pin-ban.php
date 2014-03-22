<?php

// TODO: Write Code to uniquify per ban.
function pinToBan($bans, $pins) {
	$bancount = array();
	// $bans = array();

	foreach($bans as $key=>$value) {

		if ($value == $oldvalue) {
			// same ban	
			$pins[$key] = $pins[$oldkey];
		}
		$oldvalue = $value;
		$oldkey = $key;
	}

	print "<pre>";
	foreach ($pins as $key => $value) {
		// print keys
		print "\n$value";
	}
print "</pre>";
}
?>
