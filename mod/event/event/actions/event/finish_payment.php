<?php
gatekeeper();
elgg_load_library('elgg:event');
$paypalvalues = explode("/",get_input('paypalvalues')); // Format is PURCHASED_USER_GUID/ EVENT_GUID / PURCHASED_TICKETS_GUID
$user_guid = (int) $paypalvalues[0];
$user = get_user($user_guid);
$event_guid = (int) $paypalvalues[1];
$event = get_entity($event_guid);
$purchased_ticketArray = split(",", $paypalvalues[2]);
$table_purchase_info = elgg_get_config('dbprefix')."events_purchase_info";
$table_ticket = elgg_get_config('dbprefix')."events_tickets";

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
add_to_river('river/object/event/ticket','create', $user_guid, $event_guid);
event_create_user_relationship($event_guid, $user_guid);
system_message(elgg_echo("event:join:success"));
forward("event/purchaseinfo/".$event->getGUID()."/".elgg_get_friendly_title($event->title));
exit;
?>