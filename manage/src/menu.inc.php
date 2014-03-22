<?php
/*
	The magical Userbase, Management tools.
	For both the users and administrators.

	Hopefully it all works out nice.

	Started: April 19, 2005

	Requirements: php4, mysql, apache

	:: dclarke@FlatlineSystems.net

	menu.inc.php
		menu system.
		
*/
function register_actions($action, $pagetitle, $func) {
	// register the actions array to verify the availability of a function.
	global $actions;
	
	$actions[$action]['pagetitle'] = $pagetitle;
	$actions[$action]['function'] = $func;
	
	// das goot.
	
}
function register_menu($action, $short_title, $long_title, $url, $options = array()) {
	// a quick and dirty function to add shit to the menu.
	// Options is for the submenu, thus it's 'optional'.
	global $menu_structure, $action_number;
	$action_number++;
	$menu_structure[$action]['short_title'] = $short_title;
	$menu_structure[$action]['long_title'] = $long_title;
	$menu_structure[$action]['url'] = $url;
	$menu_structure[$action]['options'] = $options;
	
	// das goot.
}

function build_menu() {
	global $menu_structure;
	
	// build the menu in unordered lists <ul>
	// to be used with CSS Goodness.
	// main menu list;
	$action = $_GET['action'];

	$menu = "<div id=\"menu-main\"><ul>";
	foreach ($menu_structure as $key => $item) {
		if ($action == $key)
			$highlight = " class=\"active\"";
		else
			$highlight = "";
			
		$menu .= "<li" . $highlight . "><a href=\"" . 
				$menu_structure[$key]['url'] . "\" title=\"" .
				$menu_structure[$key]['long_title'] . "\">" . 
				$menu_structure[$key]['short_title'] . "</a></li>";
	}
	$menu .= "</ul></div>";
	
	// submenu (based on $_GET['action']!)
	$menu .= "<div id=\"menu-sub\"><ul>";
	if ($action) {
		// spew out the options for $menu_structure[action][options]
		// it's an array! if it's not, the module is busted.

		foreach ($menu_structure[$action][options] as $key => $item) {
			$menu .= "<li><a href=\"/" .
					$action . "/" . $item . "\" title=\"" . $key . "\">" . 
					$key . "</a></li>";
		}
	}
	else {
		$menu .= "<li>Please select an action.</li>";	
	}
	$menu .= "</ul></div>";

	return $menu;
}
?>