<?php
elgg_load_library('elgg:event');
$eventid = get_input('eventid');
$fields = get_input('fields');
$guids = get_input('guids');
$count = get_input('count');
$free = get_input('free');
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
	if(get_input('ticket_'.$n) || get_input('entityguid_'.$n)){
		$ticketArray[$index] = (int) get_input('ticket_'.$n);
		$sponserArray[$index] = (int) get_input('sponser_'.$n);
		$entityguid[$index] = (int) get_input('entityguid_'.$n);
		for($i = 0; $i<count($fields); $i++){
			$field1 = $fields[$i];
			$guid_id = $guids[$i];
			$value = get_input($field1.'_'.$n);	
			$formValues[$index][$i] = $value;
		}
		$index++;		
	}	
}

$time = time();
$guidArray = array();
$info['user_guid'] = 0;
$info['time_created'] = $time;
$info['event_guid'] = $eventid;
for($n=0; $n<count($ticketArray);$n++){
	$info['ticket_guid'] = $ticketArray[$n]; // table id -VIP, BALCONY  etc
	$info['group_guid'] = $sponserArray[$n];
	$entity_guid = $entityguid[$n];
	$data = $formValues[$n];	
	$purchase_guid = saveArray($table_purchase_info,$info,$entity_guid,false);
	$guidArray[] = $purchase_guid;
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
$_SESSION['guest_join'] = $time;
$_SESSION['join_guid'] = implode(",",$guidArray);
if($guidArray){
	forward("event/pay/".$event->getGUID()."/".elgg_get_friendly_title($event->title).'?guid='.$time);
	exit();
}else{
	forward(REFERER);
}

?>