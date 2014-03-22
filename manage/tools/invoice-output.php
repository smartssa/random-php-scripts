<?php
/*
	The magical Userbase, Management tools.
	For both the users and administrators.

	Hopefully it all works out nice.

	Started: April 19, 2005
	Requirements: php4, mysql, apache
	:: dclarke@FlatlineSystems.net

	invoice-output.php 
		output for invoices.  Spit 'er Out!
		email friendly invoices
*/
/*
	Components:
		$inv_head - str - header string
		$inv_head_add - str - address string (for fls)
		$inv_address[6] - array - strings - address for client
		$inv_number - str - invoice number
		$inv_date - str - invoice date
		$inv_due - str - invoice due date
		$inv_rep - str - sales rep
		$inv_ponum - str - purchase order
		$inv_items[X][2] - array - mixed - 
			[X]['desc'] - str - description
			[X]['rate'] - float(2) - rate per each
					-- total is calculated qty * rate
			details for invoice items
		$inv_comment[x] - array - strings - comments for the invoice
		$inv_subtotal - float(2) - subtotal owing, new charges
		$inv_previous - float(2) - previous amount owing
		$inv_gst - float(2) - total for gst, if applicable
		$inv_balance - flaot(2) - total owing
*/

$breaker = str_repeat("-=", 30) . "\n\n";
// header
$inv = "";
$inv .= str_pad(INV_HEAD, 60, " ", STR_PAD_BOTH) . "\n";
$inv .= str_pad(INV_HEAD_ADD, 60, " ", STR_PAD_BOTH) . "\n";
$inv .= $breaker;
// address
// [------- address block -------][ misc info block ]
$inv .= str_pad($inv_address[1], 40) . 
	str_pad("Invoice#: ", 10, " ", STR_PAD_LEFT) . str_pad($inv_number, 10, " ") . "\n";
$inv .= str_pad($inv_address[2], 40) . 
	str_pad("Date : ", 10, " ", STR_PAD_LEFT) . str_pad($inv_date, 10, " ") . "\n";
$inv .= str_pad($inv_address[3], 40) . 
	str_pad("DUE : ", 10, " ", STR_PAD_LEFT) . str_pad($inv_due, 10, " ") . "\n";
$inv .= str_pad($inv_address[4], 40) . 
	str_pad("PO # : ", 10, " ", STR_PAD_LEFT) . str_pad($inv_ponum, 10, " ") . "\n";
$inv .= str_pad($inv_address[5], 40) . 
	str_pad("Amt Due : ", 10, " ", STR_PAD_LEFT) . str_pad(number_format($inv_balance,2), 10, " ") . "\n";
$inv .= str_pad($inv_address[6], 40) . 
	str_pad("", 10, " ", STR_PAD_LEFT) . str_pad("", 10, " ") . "\n";

$inv .= $breaker;

// body
// [ desc --------------------][cost]
// for descriptions over the alotted 50 chars, we need to split to
// multiple lines... 
foreach($inv_items as $item_num => $item_detail) {
	// each item is an array
	// TODo split long lines. (or restrict comments to 50-ish?)
	$inv .= str_pad($item_detail['desc'], 50);
	$inv .= str_pad(number_format($item_detail['amount'],2), 10, " ", STR_PAD_LEFT) . "\n";
}
$inv .= $breaker;
// comments
foreach($inv_comment as $comm_num => $comm_text) {
	$inv .= str_pad($comm_text, 60, " ", STR_PAD_BOTH) . "\n";
}

$inv .= $breaker;

// footer
// [-------------------][ SubTotal ] [ value ]
$inv .= str_pad("Sub Total : ", 50, " ", STR_PAD_LEFT) . 
	str_pad(number_format($inv_subtotal,2), 10, " ", STR_PAD_LEFT) . "\n";
// [-------------------][ PreviousBalance ] [ value ]
if ($inv_previous) {
	$inv .= str_pad("Previous Balance : ", 50, " ", STR_PAD_LEFT) . 
		str_pad(number_format($inv_previous,2), 10, " ", STR_PAD_LEFT) . "\n";
}
// [-------------------][ Payments ] [ value ]
if ($inv_payments) {
	$inv .= str_pad("Payments : ", 50, " ", STR_PAD_LEFT) . 
		str_pad(number_format($inv_payments,2), 10, " ", STR_PAD_LEFT) . "\n";
}
// [-------------------][ GST ] [ value ]
if ($inv_gst) {
$inv .= str_pad("Business Number 86509 7331 - GST (7%) : ", 50 , " ",STR_PAD_LEFT) . 
	str_pad(number_format($inv_gst,2), 10, " ", STR_PAD_LEFT) . "\n";
}
// [-------------------][ Total ] [ value ]
$inv .= str_pad("Please Pay This Amount : ", 50, " ", STR_PAD_LEFT) . 
	str_pad(number_format($inv_balance,2), 10, " ", STR_PAD_LEFT) . "\n";

$inv .= $breaker;

$inv .= str_pad(INV_FOOTER_1, 60, " ", STR_PAD_BOTH) . "\n";
$inv .= str_pad(INV_FOOTER_2, 60, " ", STR_PAD_BOTH) . "\n";
$inv .= str_pad(INV_FOOTER_3, 60, " ", STR_PAD_BOTH) . "\n";
$inv .= str_pad(INV_FOOTER_4, 60, " ", STR_PAD_BOTH) . "\n";


?>
