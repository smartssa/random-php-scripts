<?php

require_once "csv-tools.php";

// List CSV Files for process
$csvfiles = getFiles();

// fields in responder table
/* -- */
$destination = array(
  'pin',
  'company',
  'contact',
  'address1',
  'address2',
  'address3',
  'city',
  'postalCode',
  'province',
  'language'
);

$destination_map = array(
  'PIN' => 'pin',
  'ACCTNAME' => 'company',
  'CNTCT_FIRST_NAME' => 'contact',
  'ADDR_LINE_1' => 'address1',
  'ADDR_LINE_2' => 'address2',
  'ADDR_LINE_3' => 'address3',
  'ADDR_CITY' => 'city',
  'ADDR_POSTAL_ZIP' => 'postalCode',
  'ADDR_PROV_STATE_CD' => 'province',
  'ACCT_LANG_CD' => 'language'
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
    $newfp = fopen ($inputfile."-responder.sql", "w+");
    print "<br />Input: " . $inputfile;

    // Get The Header for pretty Array Structures
    $columns = getHeaderRow($fp);
    
	$rows = getRows($fp, $columns);
	$fields = "";
	$values = "";
	foreach ($rows as $row) {
		// cycle through rows.
		$pin = $row['PIN'];
		$ban = $row['BAN'];
		$fields = "";
		$values = "";
		$query = "";
		if ($oldban != $ban) {
			foreach ($destination_map as $key => $destiny) {
				// each row has field mapping.
				if ($destiny) {
					$fields .= $destination_map[$key] . ',';
					if ($key != "CNTCT_FIRST_NAME" && $key != "CNTCT_LAST_NAME" && $key != "BellID")
						$values .= "\"". addslashes($row[$key]) . "\",";
					elseif ($key == "CNTCT_FIRST_NAME")
						$values .= "\"". $row['CNTCT_NAME_TITLE'] ." ". $row['CNTCT_FIRST_NM'] . " " . $row['CNTCT_LAST_NM'] ."\",";
				}
			}
			//$values .= "'S'";
			//$fields .= "CompanySegment";

		}
		$values = substr($values,0,strrpos($values,","));
		$fields = substr($fields,0,strrpos($fields,","));
		
		if ($fields)
			fputs($newfp,$query = "INSERT INTO Responder (".$fields.") VALUES (" . $values . ");\n");
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
