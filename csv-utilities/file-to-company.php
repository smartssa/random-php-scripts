<?php

/*
* A little set of tools to convert CSV file(s) into SQL insert statements.
* written some time in 2005-2006, before I knew I could implode arrays.
*/

require_once "csv-tools.php";

// List CSV Files for process
$csvfiles = getFiles();

// fields in responder table
/* list of all the available columns in the destination table */
$destination = array(
  'Company',
  'NameFirst',
  'NameLast',
  'Address1',
  'Address2',
  'Address3',
  'City',
  'PostalCode',
  'Province',
);

/* map the csv columns to table columns */
$destination_map = array(
  'ACCTNAME' => 'Company',
  'CNTCT_FIRST_NAME' => 'NameFirst',
  'CNTCT_LAST_NAME' => 'NameLast',
  'ADDR_LINE_1' => 'Address1',
  'ADDR_LINE_2' => 'Address2',
  'ADDR_LINE_3' => 'Address3',
  'ADDR_CITY' => 'City',
  'ADDR_POSTAL_ZIP' => 'PostalCode',
  'ADDR_PROV_STATE_CD' => 'Province',
);
/* eventually use the session to setup dynamic mappnig, but for now... manual. */
session_start();

echo "<ul>";
foreach ($csvfiles as $file) {
    echo "<li><a href=\"?csvfile=" . $file . "\">" . $file . "</a></li>";
}
echo "</ul>";

// Process CSV File from $_GET['csvfile']

$inputfile = $_GET['csvfile'];

if (file_exists($inputfile)) {
		
    // it's there, we can process it.
    $fp = fopen($inputfile, "r");
    $newfp = fopen ($inputfile.".sql", "w+");
    print "<br />Input: " . $inputfile;

    // Get The Header for pretty Array Structures
    $columns = getHeaderRow($fp);
    
	$rows = getRows($fp, $columns);
	$fields = "";
	$values = "";
	foreach ($rows as $row) {
		// cycle through rows.

		// process as necessary
		foreach ($destination_map as $key => $destiny) {
			// each row has field mapping.
			if ($destiny) {
				$fields .= $destination_map[$key] . ',';
				if ($key != "CNTCT_FIRST_NAME" && $key != "CNTCT_LAST_NAME" && $key != "BellID")
					$values .= "\"". addslashes($row[$key]) . "\",";
				elseif ($key == "CNTCT_FIRST_NAME")
					$values .= "\"". $row['CNTCT_NAME_TITLE'] ." ". $row['CNTCT_FIRST_NM'] . "\",";
				elseif ($key == "CNTCT_LAST_NAME")
					$values .= "\"" . $row['CNTCT_MIDDLE_NM'] . " " . $row['CNTCT_LAST_NM'] . "\",";
				elseif ($key == "BellID")
					$values .= "\"" . $row['BAN'] . "\",";
			}
		}
		$values .= "'S'";
		$fields .= "CompanySegment";
		//$values = substr($values,0,strrpos($values,","));
		//$fields = substr($fields,0,strrpos($fields,","));
		
		if ($fields)
			fputs($newfp,$query = "INSERT INTO Company (".$fields.") VALUES (" . $values . ");\n");
		$oldpin = $pin;
		$oldban = $ban;
		print $query;
		print "<br>";
	}
	// do what you want.

} else {
    // it's not. It's either bogus or wasn't passed.
    // do nothing for now.
}
?>
