<?php
include ("./jpgraph/src/jpgraph.php");
include ("./jpgraph/src/jpgraph_bar.php");
include ("./jpgraph/src/jpgraph_line.php");

// a stacked line graph with hits based on status code
// from apache logs in mysql

function yLabelFormat($aLabel) {
	return ($aLabel / 1000);
}
if ($_GET['domain']) {
	$and = " AND virtualhost = '".$_GET['domain'] . "' ";
	$domain = $_GET['domain'];
} else {
	$and = "";
	$domain = "All Domains";
}

// Query bytes by Hour
$Query = "
SELECT 
MINUTE( datetime ) \"Minute\", 
COUNT( fld_id ) \"Hits\",
MINUTE( NOW() ) \"M\",
COUNT(IF(statusafterredir LIKE \"2%\", statusafterredir, NULL)) AS Status200,
COUNT(IF(statusafterredir LIKE \"3%\", statusafterredir, NULL)) AS Status300,
COUNT(IF(statusafterredir LIKE \"4%\", statusafterredir, NULL)) AS Status400,
COUNT(IF(statusafterredir LIKE \"5%\", statusafterredir, NULL)) AS Status500
FROM tbl_access_log
WHERE DATE_SUB(NOW(), INTERVAL 60 MINUTE) < datetime
$and
GROUP BY MINUTE( datetime ) 
ORDER BY datetime
";

mysql_connect('techno','apache','dCJRZ7n2q:U5S7s,');
$db = mysql_select_db('apachelogs');
$result = mysql_query($Query);
if ($result) {
	while ($row = mysql_fetch_assoc($result)) {
		$minute = $row['Minute'];
		$data1y[$minute] = $row['Status200'];
		$data2y[$minute] = $row['Status300'];
		$data3y[$minute] = $row['Status400'];
		$data4y[$minute] = $row['Status500'];
		$minutes[$minute] = $row['Minute'];
		$now = $row['M'];
	}
}

for ($i = 0; $i < 60; $i++) {
	// 60 minute filler
	if ($minutes[$i] != $i || $minutes[$i] < "0") {
		$data1y[$i] = "0";
		$data2y[$i] = "0";
		$data3y[$i] = "0";
		$data4y[$i] = "0";
		$minutes[$i] = $i;
	}
}
ksort($data1y);
ksort($data2y);
ksort($data3y);
ksort($data4y);
ksort($minutes);

for ($i = 0; $i <= $now; $i++) {
	$data1y[] = array_shift($data1y);
	$data2y[] = array_shift($data2y);
	$data3y[] = array_shift($data3y);
	$data4y[] = array_shift($data4y);
	$minutes[] = array_shift($minutes);
}
// Setup the basic parameters for the graph
$graph = new Graph(600,300);
//$graph->SetAngle(90);
$graph->SetScale("textlin");
$graph->SetColor('black');

// The negative margins are necessary since we
// have rotated the image 90 degress and shifted the 
// meaning of width, and height. This means that the 
// left and right margins now becomes top and bottom
// calculated with the image width and not the height.
//$graph->img->SetMargin(-80,-80,210,210);

$graph->SetMarginColor('black');
//$graph->img->SetAntiAliasing();
// Setup title for graph
$graph->title->Set("Hits in the last 60 Minutes for $domain");
$graph->title->SetColor('white');
$graph->title->SetFont(FF_VERDANA,FS_BOLD);
$graph->legend->SetPos(0.01,0.02,'right','top');
$graph->legend->SetColor('white','white');
$graph->legend->SetFillColor('black');
$graph->ygrid->SetFill(true,'#EFEFEF@0.85','blue@0.85');

// Setup X-axis.
$graph->xaxis->SetTitle("Rolling Minutes",'center');
$graph->xaxis->title->SetFont(FF_VERDANA,FS_BOLD, 8);
$graph->xaxis->title->SetMargin(15);
$graph->xaxis->title->SetColor('white');
//$graph->xaxis->title->SetAngle(90);
$graph->xaxis->SetTickLabels($minutes);
$graph->xaxis->SetFont(FF_VERDANA,FS_BOLD, 8);
$graph->xaxis->SetColor('white');
//$graph->xaxis->SetTitleMargin(30);
$graph->xaxis->SetLabelMargin(15);
$graph->xaxis->SetLabelAngle(90);
$graph->xaxis->SetLabelAlign('center','center');

// Setup Y-axis

// First we want it at the bottom, i.e. the 'max' value of the
// x-axis
// $graph->yaxis->SetPos('max');

// Arrange the title
$graph->yaxis->SetTitle("Total",'low');
$graph->yaxis->SetTitleSide(SIDE_LEFT);
$graph->yaxis->title->SetFont(FF_VERDANA,FS_BOLD,8);
$graph->yaxis->title->SetMargin(10);
$graph->yaxis->title->SetAngle(90);
$graph->yaxis->title->SetColor('white');
$graph->yaxis->title->Align('center','top');
$graph->yaxis->SetFont(FF_VERDANA,FS_BOLD,8);
//$graph->yaxis->SetLabelFormatCallback('yLabelFormat');
//$graph->yaxis->SetTitleMargin(30);

// Arrange the labels
// $graph->yaxis->SetLabelSide(SIDE_RIGHT);
$graph->yaxis->SetLabelAlign('right','center');
$graph->yaxis->SetColor('white');

// Create the bar plots with image maps
$b1plot = new LinePlot($data1y);
$b1plot->SetLegend("Success");
$b1plot->SetFillColor("#11aa11");
$b1plot->SetColor("green");

$b2plot = new LinePlot($data2y);
$b2plot->SetLegend("Redirect");
$b2plot->SetFillColor("yellow");
$b2plot->SetColor("gold");

$b3plot = new LinePlot($data3y);
$b3plot->SetLegend("Failures");
$b3plot->SetFillColor("#aa1111");
$b3plot->SetColor("red");

$b4plot = new LinePlot($data4y);
$b4plot->SetLegend("Errors");
$b4plot->SetFillColor("white");
$b4plot->SetColor("gray");

//$b1plot->SetFillGradient("red","gray", 100);
//$b2plot = new BarPlot($data2y);
//$b2plot->setLegend("Out");
//$b2plot->SetFillGradient("black","blue", GRAD_LEFT_REFLECTION);

// Create the accumulated bar plot
$abplot = new AccLinePlot(array($b4plot,$b3plot,$b2plot,$b1plot));
//$abplot->SetWidth(1);
//$abplot->SetShadow();
//$abplot->value->SetValuePos('center');
// We want to display the value of each bar at the top
// $abplot->value->SetFont(FF_VERDANA,FS_BOLD, 8);
// $abplot->value->SetAlign('center','low');
// $abplot->value->SetColor("gray","darkred");
// $abplot->value->SetFormat('%.0f KB');
// $abplot->value->SetAngle(90);
// $abplot->value->Show();

// ...and add it to the graph
$graph->Add($abplot);

// Send back the HTML page which will call this script again
// to retrieve the image.
$graph->Stroke();

?>
