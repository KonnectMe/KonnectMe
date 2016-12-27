<?php
elgg_load_library('elgg:event');
$bc = base64_decode(get_input('tc'));
$event_guid = get_input('eg');
$event = get_entity($event_guid);
$table_purchase_info = elgg_get_config('dbprefix')."events_purchase_info";
$table_ticket = elgg_get_config('dbprefix')."events_tickets";

if($event->canEdit()){
	$user = elgg_get_logged_in_user_entity();
	$user_guid = $user->guid;
	$purchased_ticketArray = explode(",",$bc);
	
	if($user && $event && $purchased_ticketArray){
		$index = 0;
		foreach($purchased_ticketArray as $ticket){
			$data = get_data("select *from $table_purchase_info where id=$ticket");
			$ticket_guid = $data[0]->ticket_guid;
			$purchase_info['status'] = 1;
			saveArray($table_purchase_info,$purchase_info,$ticket,false);
			
			//update ticket 
			$tickets = get_data("select *from $table_ticket where id=$ticket_guid");
			$ticket_array['sold'] = $tickets[0]->sold+1;
			saveArray($table_ticket,$ticket_array,$ticket_guid,false);
		
		}
				
	}
			//create new river
			event_create_user_relationship($event_guid, $user_guid);
			system_message(elgg_echo("All tickets approved"));
			//------------ end our api

}
forward($event->getURL());
?>