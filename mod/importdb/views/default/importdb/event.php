<?php
echo "Processing...........";

$event_table = elgg_get_config('dbprefix')."event";
$event_form_table = elgg_get_config('dbprefix')."events_customforms";
$event_ticket_table = elgg_get_config('dbprefix')."events_tickets";
//print_r($vars);
$counter = $vars['counter'];
$offset = $counter*10;
$limit = 10;
$param = array(
			'type' => 'object',
			'subtype' => 'event',
			'limit' => $limit,
			'offset' => $offset,
			);
$events = elgg_get_entities($param);
if(!$events){
	echo "Over";
	return;
}
foreach($events as $event){
	$event_array['isfree'] = $event->free;
	$event_array['paypal'] = $event->paypal;
	$event_array['category'] = $event->category;
	$event_array['title'] = $event->title;
	$event_array['description'] = $event->description;
	$event_array['brief_description'] = $event->brief_description;
	$event_array['start_date'] = (int)strtotime($event->period_from);
	$event_array['end_date'] = (int)strtotime($event->period_to);
	$event_array['access_id'] = (int)$event->access_id;
	$event_array['venue'] = $event->venue;
	$event_array['location'] = $event->location;
	$event_array['related_event_guid'] = (int)$event->pastevent;
	$event_array['fundraising'] = (int)$event->createcause;
	$event_array['blocked'] = (int)$event->eventclosed ;
	$event_array['icon_time'] = $event->icontime ;
	$event_array['time_created'] = $event->time_created ;
	$event_array['owner_guid'] = $event->owner_guid ;
	$event_array['guid'] = $event->guid ;
	//save event
	$data = get_data("select guid from $event_table where guid=".$event->guid);
	if(!$data){
		$event_id = saveArray($event_table,$event_array,0);
	}
	//print_r($event_array);
	
	//Custom forms
	$event_forms = elgg_get_entities_from_metadata(
			array("type" => "object",
			"subtype" => "eventform",
			'limit' => 0,
			'order_by_metadata' => array('name' => 'eventorder', 'as' => 'integer'),
			'metadata_name_value_pairs' => array('eventid' => $event->guid)));
	$custom_form['event_guid'] = $event->guid;	
	foreach($event_forms as $form){
		$custom_form['title'] = $form->fieldname;
		$custom_form['type'] = $form->fieldtype;
		$custom_form['default_values'] = $form->fieldvalues;
		$custom_form['required'] = $form->required;
		$custom_form['item_order'] = $form->eventorder;
		$formt_id = saveArray($event_form_table,$custom_form,0);
	}
	
	//ticket
	$event_tickets = elgg_get_entities_from_metadata(
			array("type" => "object",
			"subtype" => "ticket",
			'limit' => 0,
			'container_guid' => $event->guid,
			
			));
	$ticket['event_guid'] = $event->guid;	
	foreach($event_tickets as $tickets){
		$ticket['title'] = $tickets->ticket_type;
		$ticket['description'] = $tickets->description;
		$ticket['price'] = $tickets->price;
		$ticket['seats'] = $tickets->number;
		$ticket['sold'] = $tickets->sold;
		$tickets_id = saveArray($event_ticket_table,$ticket,0);
	}


}

$next = $counter+1;
?>
<meta http-equiv="refresh" content="0;url=?counter=<?php echo $next; ?>&type=1" />
