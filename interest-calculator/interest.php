<html>
<head>
<title>Interest Calculator Thing</title>
</head>
<body>
<form method="post" action="interest.php">
<fieldset>
	<legend>Values</legend>
	<label for="pinciple">Principle:</label><input value="<?= $principle; ?>" name="principle" /><br />
	<label for="percent">Percent:</label><input value="<?= $percent; ?>" name="percent" /><br />
	<label for="compound">Compound:</label>
	<select name="compound">
		<option value="12">Monthly</option>
		<option value="365">Daily</option>
		<option value="1">Yearly</option>
	</select><br />
	<label for="term">Years:</label><input value="<?= $term;?>" name="term" /><br />
	<label for="submit">&nbsp;</label><input name="submit" type="submit" />
</fieldset>
<?php
if ($principle > 0 && $percent > 0 && $term > 0) {

	$value = $principle;
	for ($i = 1; $i <= $term; $i++) {
		// go through the terms
		$cumint = 0;
		for ($m = 1; $m <= $compound; $m++) {
			// each month of the term
			$int = $value * ($percent / 100 / $compound);
			$cumint = $cumint + $int;
			$value = $value + $int;
		}
		print "<br />Year " . $i . " :: " . $value . " :: " . $cumint . "";

	}

}
?>
</body>
</html>
