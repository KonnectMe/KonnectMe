<?php
/**
* Edit event ticket
*
* @package Event
*/
gatekeeper();
elgg_load_library('elgg:event');
$eventid = get_input('eventid');
$guid = get_input('guid');

$ticket_type = get_input('ticket_type');
$description = get_input('description');
$price = get_input('price');
$number = get_input('number');
$event = get_entity($eventid);
$table = elgg_get_config('dbprefix')."events_tickets";
if ($event->canEdit() && $guid) {
	$tickets['title'] = $ticket_type;
	$tickets['description'] = $description;
	$tickets['price'] = $price;
	$tickets['seats'] = $number;
	$ticket_guid = saveArray($table,$tickets,$guid,false);
	system_message(elgg_echo('event:save:success'));
	forward("event/ticket/".$eventid);
}else{
	system_message(elgg_echo('event:save:failed'));
	forward(REFERRER);
} 