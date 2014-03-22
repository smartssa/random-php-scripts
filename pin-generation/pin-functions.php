<?

require_once "database.inc.php";

function getUniquePin($pins = array()) {
	// $pins is an array of already generated pins.
	$pin = getPin();
	while (uniquePin($pin) != 0 && ! in_array($pin, $pins)) {
		$pin = getPin();
	}
	return $pin;
}

function getPin() {
	
	// gimme a pin!
	$pinLength = 9;
	$pinChars = 'ABCDFGHJKMNPRSTUVWXY23456789';
	srand();
	for ($i = 0; $i< $pinLength;$i++) {
		$rand .= substr($pinChars, rand(0,strlen($pinChars)-1), 1);
	}
	return $rand;
}

function uniquePin($pin) {
	$Query = "SELECT * FROM Company80026 WHERE pin = '".$pin."'";
	$Result = db_query($Query);

	if ($db_rows == 0) {
		$Query = "SELECT * FROM Company80028 WHERE pin = '".$pin."'";
		$Result = db_query($Query);
	}

	if ($db_rows == 0) {
		$Query = "SELECT * FROM Company80030 WHERE PIN = '".$pin."'";
		$Result = db_query($Query);
	}
	
	if ($db_rows == 0) {
		$Query = "SELECT * FROM Responder WHERE pin = '".$pin."'";
		$Result = db_query($Query);
	}
	return $db_rows;
}

function pinProcess($PinCount) {
	$pins = array();
	$_SESSION['percent'] = 0;
	for ($i = 0; $i < $PinCount; $i++) {
		session_start();
		set_time_limit(10);
		if ( $i == 0 )
			$_SESSION['notices'] = "\n<span style=\"color: green;\">Starting... $PinCount</span>";
		// 1 generate pin
		$pin = getPin();
		// 2 check database(s) for uniqueness
		$db_rows = uniquePin($pin);
		// if it's unique save it
		if ($db_rows == 0) {// unique!
			//print "\nGood Pin : $i : $pin ";
			if (! in_array($pin, $pins)) {
				$pins[] = $pin;
				//$_SESSION['notices'] .= "\n<span style=\"color: green;\">Clean : $i : $pin</span>";
			} else {
				$_SESSION['notices'] .= "\n<span style=\"color: red;\">Already Generated this one... Duplicate Retrying : $i</span>";
				$i--;
			}
		} else { // if it's not, try again.
			$_SESSION['notices'] .= "\n<span style=\"color: red;\">Duplicate in DB Retrying : $i</span>";
			$i--;
		}
		$percent = round(($i/$PinCount*100),0);
		$_SESSION['percent'] = $percent;
		session_write_close();
	}
	session_start();
	$_SESSION['percent'] = 100;
	$_SESSION['notices'] .= "\n<span style=\"color: green;\">Done</span>";
	session_write_close();
}

// TODO: Write Code to uniquify per ban.
function pinToBan($bans) {
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
