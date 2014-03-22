<?php

// We want 2 parameters for this
/*
	current ID, and direction to go.
	id/dir/anything-else-is-junk/
	$args contains the remaining chunks of what-to-do from 
	the previous explode.
*/

$id = array_shift($args);
$direction = array_shift($args);

switch ($direction) {
	case "Next":
		$query = "SELECT fld_name, fld_year, fld_id, fld_id + 1 AS fld_next_id, fld_id - 1 AS fld_prev_id 
			FROM tbl_dvd WHERE fld_id >= '" . 
			mysql_escape_string($id) . "' LIMIT 1";
		break;
	case "Previous":
		$query = "SELECT fld_name, fld_year, fld_id, fld_id + 1 AS fld_next_id, fld_id - 1 AS fld_prev_id 
			FROM tbl_dvd WHERE fld_id <= '" . 
			mysql_escape_string($id) . "' ORDER BY fld_id DESC LIMIT 1";
		break;
	case "Last":
		$query = "SELECT fld_name, fld_year, fld_id, fld_id + 1 AS fld_next_id, fld_id - 1 AS fld_prev_id 
			FROM tbl_dvd ORDER BY fld_id DESC LIMIT 1";
		break;
		
	case "First":
		$query = "SELECT fld_name, fld_year, fld_id, fld_id + 1 AS fld_next_id, fld_id - 1 AS fld_prev_id 
			FROM tbl_dvd ORDER BY fld_id ASC LIMIT 1";	
		break;
}

$result = db_query($query);
if ($db_rows > 0) {
	$row = mysql_fetch_assoc($result);
	$name = $row['fld_name'];	
	$year = $row['fld_year'];
	$id = $row['fld_id'];
	$notice = "Got ID (" . $id . ")";
	$nextid = $row['fld_next_id'];
	$previd = $row['fld_prev_id'];
}
else {
	$name = "No Name";
	$year = "1900";
	$notice = "Couldn't get that ID. (" . $id . ")";
	$nextid = $id;
	$previd = $id - 1;
}

if ($previd <= 0) $previd = 1;

// need htmlentities on text or the xml parser will blow up.
$name = htmlentities($name);

$return_value = <<<EOT
<?xml version="1.0" standalone="yes"?>
<movie>
	<id>{$id}</id>
	<nextid>{$nextid}</nextid>
	<previd>{$previd}</previd>
	<name>{$name}</name>
	<year>{$year}</year>
	<notice>{$notice}</notice>
</movie>
EOT;

?>
