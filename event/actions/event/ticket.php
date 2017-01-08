<?php
/**
* Save event ticket
*
* @package Event
*/
elgg_load_library('elgg:event');
$eventid = get_input('eventid');
$have_ticket =0; //register with or without ticket if yes free, else no
$table = elgg_get_config('dbprefix')."events_tickets"; 
if($eventid) {
 	
		 $ticket_type = get_input('ticket_type');
		 $description = get_input('description');
		 $price = get_input('price');
		 $number = get_input('number');
	 
		 $tickets['event_guid'] = $eventid;	 
		 for($i = 0; $i < count($ticket_type); $i++) {
			 if($ticket_type[$i]) {
				 $tickets['title'] = $ticket_type[$i];
				 $tickets['description'] = $description[$i];
				 $tickets['price'] = $price[$i];
				 $tickets['seats'] = $number[$i];
				 $ticket_guid = saveArray($table,$tickets,0);
			}
		 }
	
	system_message(elgg_echo('event:save:success'));
	forward("event/ticket/".$eventid);
 }else {
	register_error(elgg_echo('event:save:failed'));
	forward("event/ticket/".$eventid);	 
 }