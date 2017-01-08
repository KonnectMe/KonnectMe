<?php

elgg_register_event_handler('init', 'system', 'eventupdate_init');

function eventupdate_init() {
	
	elgg_register_page_handler('eventupdate', 'eventupdate_page_handler');
	
	$path = elgg_get_plugins_path();
	elgg_register_action("eventupdate/add", $path . "eventupdate/actions/eventupdate/add.php");
}

function eventupdate_page_handler($page){
	$pages = dirname(__FILE__) . '/pages/eventupdate';
	switch ($page[0]) {
		case "all":
			set_input('guid', $page[1]);
			include "$pages/all.php";
			break;
	}
	return true;	
}


