<?php
$pagetitle = "Ajax Sample";

$body = "<p>Here's a sample AJAX App.  It'll let you browse my DVD collection without reloading the page.</p>";

$body .= <<<EOT
<div id="movie">
<ul>
	<li>Name: <span id="name"></span></il>
	<li>Year: <span id="year"></span></li>
	<li>Notice: <span id="notice"></span></li>
</ul>
</div>
<script language="javascript"  type="text/javascript">
var url = "ajax-backend.php"; // The server-side script
var dvdid = 0;
var previd = 1;
var nextid = 1;
function handleGetRecordResponse() {
  if (http.readyState == 4) {
    if (http.responseText.indexOf('invalid') == -1) {
		// Use the XML DOM to unpack the movie info
		var xmlDocument = http.responseXML; 
		var name = xmlDocument.getElementsByTagName('name').item(0).firstChild.data; 
		var year = xmlDocument.getElementsByTagName('year').item(0).firstChild.data;
		var notice = xmlDocument.getElementsByTagName('notice').item(0).firstChild.data;
		dvdid = xmlDocument.getElementsByTagName('id').item(0).firstChild.data;
		previd = xmlDocument.getElementsByTagName('previd').item(0).firstChild.data;
		nextid = xmlDocument.getElementsByTagName('nextid').item(0).firstChild.data;
		document.getElementById('name').innerHTML = name; 
		document.getElementById('year').innerHTML = year;
		document.getElementById('notice').innerHTML = notice;

      isWorking = false;
    }
  }
}
var isWorking = false;
function nextDVD() {
  if (!isWorking && http) {
    http.open("GET", url +escape('/GetRecord/')+ escape(nextid)+escape('/Next/'), true);
    http.onreadystatechange = handleGetRecordResponse;
    isWorking = true;
    http.send(null);
  }
}
function prevDVD() {
  if (!isWorking && http) {
    http.open("GET", url +escape('/GetRecord/')+ escape(previd)+escape('/Previous/'), true);
    http.onreadystatechange = handleGetRecordResponse;
    isWorking = true;
    http.send(null);
  }
}
function lastDVD() {
  if (!isWorking && http) {
    http.open("GET", url +escape('/GetRecord/')+ escape(dvdid)+escape('/Last/'), true);
    http.onreadystatechange = handleGetRecordResponse;
    isWorking = true;
    http.send(null);
  }
}
function firstDVD() {
  if (!isWorking && http) {
    http.open("GET", url +escape('/GetRecord/')+ escape(dvdid)+escape('/First/'), true);
    http.onreadystatechange = handleGetRecordResponse;
    isWorking = true;
    http.send(null);
  }
}

</script>
<script language="javascript" src="ajax-httpobject.js" />
<p>
<a href="#" onClick="javascript:firstDVD();">First</a> :: 
<a href="#" onClick="javascript:prevDVD();">Previous Movie</a> :: 
<a href="#" onClick="javascript:nextDVD();">Next Movie</a> :: 
<a href="#" onClick="javascript:lastDVD();">Last</a>
</p>
EOT;

require_once "templates.inc.php";

?>

