<?php
gatekeeper();
elgg_load_library('elgg:event');
$data = $_POST;
$eventid = get_input('eventid');
$event_metadata = get_events("guid=$eventid");
$skip = (int) $event_metadata[0]->skip;

$fields = get_input('fields');
$guids = get_input('guids');
$count = get_input('count');

$free = get_input('free');
$user = elgg_get_logged_in_user_entity();
$event = get_entity($eventid);
$formValues = array();
$ticketArray = array();	
$sponserArray = array();	
$entityguid = array();	
$status = 1;

$table_purchase_info = elgg_get_config('dbprefix')."events_purchase_info";
$table_purchase_userinfo = elgg_get_config('dbprefix')."events_purchase_userinfo";
if(!$eventid){
	forward(REFERER);
}

$index = 0;
for($n=0; $n<$count; $n++){
	$data = array();
	$current_index = $n;
	if($skip){
		$current_index = 0;
	}
	if(get_input('ticket_'.$current_index) || get_input('entityguid_'.$n)){
		$ticketArray[$index] = (int) get_input('ticket_'.$current_index);
		$sponserArray[$index] = (int) get_input('sponser_'.$current_index);
		$entityguid[$index] = (int) get_input('entityguid_'.$n);
		for($i = 0; $i<count($fields); $i++){
			$field1 = $fields[$i];
			$guid_id = $guids[$i];
			$value = get_input($field1.'_'.$current_index);	
			$formValues[$index][$i] = $value;
		}
		$index++;		
	}	
}

$info['user_guid'] = $user->guid;
$info['time_created'] = time();
$info['event_guid'] = $eventid;

for($n=0; $n<count($ticketArray);$n++){
	$entity_guid = $entityguid[$n];
	$info['ticket_guid'] = $ticketArray[$n]; // table id -VIP, BALCONY  etc
	if($skip && $entity_guid){
		unset($info['ticket_guid']);
	}
	$info['group_guid'] = $sponserArray[$n];
	$data = $formValues[$n];	
	$purchase_guid = saveArray($table_purchase_info,$info,$entity_guid,false);
	$userinfo['purchase_guid'] = $purchase_guid;
	$delete = delete_data("delete from $table_purchase_userinfo where purchase_guid=".$purchase_guid);
	for($i=0; $i<count($data); $i++){
		$guid_id = $guids[$i];
		$formvalue = $data[$i];	
		$value = implode("," ,$formvalue);
			if($value){
				$formvalue = $value;
			}
		$userinfo['form_guid'] = $guid_id;
		$userinfo['value'] = $formvalue;
		saveArray($table_purchase_userinfo,$userinfo,0);
	}

	
}

system_message(elgg_echo("event:join:save"));
if(!$free){
	forward("event/payment/".$event->getGUID()."/".elgg_get_friendly_title($event->title));
	exit();
}else{
	event_create_user_relationship($eventid, $user->guid);
	forward($event->getURL());
}

?>