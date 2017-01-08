<?php
 /**
 * Elgg event
 */
elgg_register_event_handler('init', 'system', 'importdb_init');

function importdb_init() {
	$root = dirname(__FILE__);
	$user = elgg_get_logged_in_user_entity();
	
	elgg_register_menu_item('topbar', array(
			'name' => 'importdb',
			'text' => elgg_echo('Import'),
			'href' => 'importdb/import'
		));
						
	elgg_register_page_handler('importdb', 'importdb_page_handler');		
}

function importdb_page_handler($page){
	//elgg_push_breadcrumb(elgg_echo('event:event'), 'event/all');
	$pages = dirname(__FILE__) . '/pages/importdb';
	switch ($page[0]) {
		case "import":
			gatekeeper();	
			//event_set_page_owner($page[1]);
			include "$pages/import.php";
			break;	
		case "event_purchase":
			gatekeeper();	
			set_input('eventid',$page[1]);
			include "$pages/event_purchase.php";
			break;		
			
		default:
			return false;
	}
	return true;	
}


