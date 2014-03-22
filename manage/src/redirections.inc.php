<?php

function preserve_warnings() {

	// save warnings for next time 
		// since we're redirected it won't show up this time!
	global $error_message, $warning_message;
	if ($error_message) 
		$_SESSION['error'] = $error_message;
	
	if ($warning_message)
		$_SESSION['warning'] = $warning_message;
		

}
function redirect_root() {
	// preserve error or warning messages
	preserve_warnings();
	
	// simple redirect to the root of the site.
	header("Location: /\n\n");
	exit();
	
}

function redirect_last() {
	// preserve error or warning messages
	preserve_warnings();
	// simple redirect to the last 'good' page
	// exclude login, logout, stuff like that.
	// any url that uses a POST cannot be redirected to.
	header("Location: " . $_SERVER['HTTP_REFERER'] . "\n\n");
	exit();
	
}

function redirect_url($url) {
	// preserve error or warning messages
	preserve_warnings();
	// redirect to the specified url.
	if ($url) {	
		header ("Location: ". $url ."\n\n");
		exit();
	}	
}	

?>