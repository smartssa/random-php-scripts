<?php
// Fun, exciting, graphs from apache logs in mysql.

include ("./jpgraph/src/jpgraph.php");
include ("./jpgraph/src/jpgraph_bar.php");

function yLabelFormat($aLabel) {
	return ($aLabel / 1000);
}
if ($_GET['domain']) {
	$and = " AND virtualhost = '".$_GET['domain'] . "' ";
	$domain = $_GET['domain'];
} else {
	$domain = "All Domains";
}

// Query bytes by Hour
$Query = "SELECT HOUR( datetime ) \"Hour\", COUNT( fld_id ) \"Hits\", SUM( bytesout ) \"DataOut\", SUM( 
bytesin ) \"DataIn\" FROM tbl_access_log 
WHERE DAY( datetime ) = DAY( NOW( ) ) 
{$and}
GROUP BY HOUR( datetime )
ORDER BY Hour";
mysql_connect('SERVER','DATABASE','PASSWORD');
$db = mysql_select_db('apachelogs');
$result = mysql_query($Query);
if ($result) {
	while ($row = mysql_fetch_assoc($result)) {
		$hour = $row['Hour'];
		$data1y[$hour] = $row['DataIn'] / 1024;
		$data2y[$hour] = $row['DataOut'] / 1024;
		$hours[$hour] = $row['Hour'];
	}
}

for ($i = 0; $i < 24; $i++) {
	// 24 hour filler
	if ($hours[$i] != $i || $hours[$i] < "0") {
		$data1y[$i] = "0";
		$data2y[$i] = "0";
		$hours[$i] = $i;
	}
	$hours[$i] = $i . ":00";
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

// Setup title for graph
$graph->title->Set("Traffic By the Hour for $domain");
$graph->title->SetColor('white');
$graph->title->SetFont(FF_VERDANA,FS_BOLD);
$graph->legend->SetPos(0.1,0.1,'right','top');
$graph->legend->SetColor('white','white');
$graph->legend->SetFillColor('black');
$graph->ygrid->SetFill(true,'#EFEFEF@0.85','blue@0.85');

// Setup X-axis.
$graph->xaxis->SetTitle("Hour of the Day",'center');
$graph->xaxis->title->SetFont(FF_VERDANA,FS_BOLD, 8);
$graph->xaxis->title->SetMargin(15);
$graph->xaxis->title->SetColor('white');
//$graph->xaxis->title->SetAngle(90);
$graph->xaxis->SetTickLabels($hours);
$graph->xaxis->SetFont(FF_ARIAL,FS_BOLD, 8);
$graph->xaxis->SetColor('white');
//$graph->xaxis->SetTitleMargin(30);
$graph->xaxis->SetLabelMargin(15);
$graph->xaxis->SetLabelAngle(90);
$graph->xaxis->SetLabelAlign('right','center');

// Setup Y-axis

// First we want it at the bottom, i.e. the 'max' value of the
// x-axis
// $graph->yaxis->SetPos('max');

// Arrange the title
$graph->yaxis->SetTitle("Total (x 1000) KB",'low');
$graph->yaxis->SetTitleSide(SIDE_LEFT);
$graph->yaxis->title->SetFont(FF_VERDANA,FS_BOLD,8);
$graph->yaxis->title->SetMargin(10);
$graph->yaxis->title->SetAngle(90);
$graph->yaxis->title->SetColor('white');
$graph->yaxis->title->Align('center','top');
$graph->yaxis->SetFont(FF_VERDANA,FS_BOLD,8);
$graph->yaxis->SetLabelFormatCallback('yLabelFormat');
//$graph->yaxis->SetTitleMargin(30);

// Arrange the labels
// $graph->yaxis->SetLabelSide(SIDE_RIGHT);
$graph->yaxis->SetLabelAlign('right','center');
$graph->yaxis->SetColor('white');

// Create the bar plots with image maps
$b1plot = new BarPlot($data1y);
$b1plot->SetLegend("In");
$b1plot->SetFillGradient("black","red", GRAD_LEFT_REFLECTION);

$b2plot = new BarPlot($data2y);
$b2plot->setLegend("Out");
$b2plot->SetFillGradient("black","blue", GRAD_LEFT_REFLECTION);

// Create the accumulated bar plot
$abplot = new AccBarPlot(array($b1plot,$b2plot));
$abplot->SetWidth(1);
//$abplot->SetShadow();
//$abplot->value->SetValuePos('center');
// We want to display the value of each bar at the top
$abplot->value->SetFont(FF_VERDANA,FS_BOLD, 8);
$abplot->value->SetAlign('center','low');
$abplot->value->SetColor("gray","darkred");
$abplot->value->SetFormat('%.0f KB');
$abplot->value->SetAngle(90);
// $abplot->value->Show();

// ...and add it to the graph
$graph->Add($abplot);

// Send back the HTML page which will call this script again
// to retrieve the image.
$graph->Stroke();

?>
