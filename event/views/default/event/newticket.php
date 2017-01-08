<?php
set_input('viewtype',2);
elgg_load_library('elgg:event');	
$next = get_input('next');
$eventguid = get_input('eventid');
$event_metadata = get_events("guid=$eventguid");

$form_table = elgg_get_config('dbprefix')."events_customforms";
$event_form = get_data("select *from $form_table where event_guid=$eventguid order by item_order");
$ticket_table = elgg_get_config('dbprefix')."events_tickets";
$event_ticket = get_data("select *from $ticket_table where event_guid=$eventguid ");

$form_option = array(
		"event" => $event_metadata[0], 
		'index' => $i,
		'purchase' => NULL, 
		'forms' => $event_form,
		'tickets' => $event_ticket,
		'index' => $next,
		'count' => 1,
		'newticket' =>true,
		);
echo elgg_view('event/ticket_purchaseform',$form_option);
?>

