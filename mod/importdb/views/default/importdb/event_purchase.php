<?php
$default = ini_get('max_execution_time');
set_time_limit(100000000);
elgg_load_library('elgg:event');
$eventguid = (int) get_input('eventid');
$counter = $vars['counter'];
//$event = get_entity($eventguid);
echo "Processing page-------".$counter;
$filed_name = array();
$filed_array = array();
$filed_guid = array();

$event_table = elgg_get_config('dbprefix')."event";
$event_form_table = elgg_get_config('dbprefix')."events_customforms";
$event_ticket_table = elgg_get_config('dbprefix')."events_tickets";
$event_purchase_table = elgg_get_config('dbprefix')."events_purchase_info";
$event_purchase_userinfo_table = elgg_get_config('dbprefix')."events_purchase_userinfo";

$custom_form = get_data("select id,title from $event_form_table where event_guid=$eventguid order by item_order");
$form_array = array();
foreach($custom_form as $form){
	$id = $form->id;
	$form_array[$id] = trim($form->title);
}

$custom_ticket = get_data("select id,title from $event_ticket_table where event_guid=$eventguid ");
$ticket_array = array();
foreach($custom_ticket as $ticket){
	$id = $ticket->id;
	$ticket_array[$id] = trim($ticket->title);
}

$field_name = elgg_get_entities_from_metadata(array(
				"type" => "object",
				"subtype" => "eventform",
				'order_by_metadata' => array('name' => 'eventorder', 'as' => 'integer'),
				'metadata_name_value_pairs' => array('eventid' => $eventguid)
			));

										
foreach($field_name as $form){
	$column = $form->fieldname;	
	$fieldname = event_replace_string($column);
	$filed_name[$form->guid] = $column;
	$filed_array[$form->guid] = ucwords($fieldname);
	$filed_guid[] = $form->guid;	
}	
									
function custom_key($name, $array){
	$key = array_keys($array,trim($name));
	return (int)$key[0];
}

$form_guids = array();
foreach($filed_name as $fieldid=>$fname){
	$form_guids[$fieldid] =  custom_key($fname,$form_array);
}


$limit = 100;
$offset = $vars['counter']*$limit;
$were['status'] = 1;
$param = array(
			"type" => "object",
			"subtype" => "event_join",
			'limit' => $limit,
			'offset' => $offset,
			'container_guid' => $eventguid,
			'metadata_name_value_pairs' => $were,
			);
$members = elgg_get_entities_from_metadata($param);	

if(!$members){
	echo "Over";
	return;
}
foreach($members as $member){
	$guid = $member->guid;
	$info['user_guid'] = (int)$member->owner_guid;
	$info['event_guid'] = (int)$eventguid;
	$info['status'] = 1;
	$info['time_created'] = $member->time_created;
	$relationship_sponser = 'event_join_sponser_'.$eventguid;
	$info['group_guid'] = (int)event_get_relationship_export($guid,	$relationship_sponser, 'guid');
	$relationship_ticket = 'event_purchase_ticket_'.$eventguid;
	$ticket = event_get_relationship_export($guid, $relationship_ticket, 'ticket_type');
	$info['ticket_guid'] = custom_key($ticket,$ticket_array);
	
	$purchase_guid = saveArray($event_purchase_table,$info,0);

	$user = get_entity($guid);
	$values = array();
	$userguid = $member->guid;
	$user_info['purchase_guid'] = $purchase_guid;
	foreach($form_guids as $guid=>$custom_id){	
		$user_info['form_guid'] = $custom_id;
		$user_info['value'] = $user->$guid;
		$purchase_guid = saveArray($event_purchase_userinfo_table,$user_info,0);
	}
	
}
$next = $counter+1;

?>
<meta http-equiv="refresh" content="0;url=<?php echo elgg_get_site_url() ?>importdb/event_purchase/<?php echo $eventguid ?>?counter=<?php echo $next ?>" />