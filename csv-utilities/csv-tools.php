<?php
/** written sometime in 2005-2006 **/

// List CSV Files for process
function getFiles($ext = ".csv") {
$dir = "./";
$files = array();
if (is_dir($dir)) { // directory verification and file handling.
    if ($dir_handle = opendir($dir)) {
        while($file = readdir($dir_handle)) {
            // only show text files (php css etc.)
            if (strstr(@mime_content_type($file), "text") &&
                filetype($file) == "file") {
                if (strstr($file, $ext)) {
                    // return the filenames
                    $i++;
                    $files[$i] = $file;
                }
            }
        }
        closedir($dir_handle);
    }
}
return $files;
}

function getHeaderRow($fp) {
    // needs $fp to be a valid filepointer.
    // must be called first!
    $columns = explode("\t",fgets($fp,4096));

    // get rid of "'s
    foreach ($columns as $key => $title) {
        $title = str_replace("\n", "", $title);
        $title = str_replace("\r", "", $title);
        $columns[$key] = str_replace("\"", "", $title);
    }
    return $columns;
}

function getRows($fp, $columns, $inputfile = "oversized.csv") {
    // get rows in a nice array with columns as the key names.
    // needs $fp filepointer, and $columns (for pretty array), input file
    
    print "<br/>Fields: " . count($columns);
    print "<pre>";
    while (!feof($fp)) {
        $filedata = fgets($fp, 4096);
        if ($filedata != "") { // this takes care of blank lines (like the end of file, but not the eof)
            $i++;
            $rowtemp = explode("\t", $filedata);
            foreach ($rowtemp as $key => $value) {
                $col = $columns[$key];
                $value = str_replace("\n", "", $value);
                $value = str_replace("\r", "", $value);
                $value = str_replace("\"", "", $value);
                $row[$i][$col] = stripslashes(trim($value));
            }
        }
    }
    return $row;
}
