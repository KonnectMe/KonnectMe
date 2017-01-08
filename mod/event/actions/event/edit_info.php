<?php
gatekeeper();
elgg_load_library('elgg:event');
$eventid = get_input('eventid');
$purchase_guid = get_input('purchase_guid');
$sponser_guid = (int) get_input('sponser_1');
$fields = get_input('fields');
$guids = get_input('guids');
$count = 1;
$user = elgg_get_logged_in_user_entity();
$event = get_entity($eventid);
$formValues = array();
$entityguid = array();	

if(!$eventid && $purchase_guid){
	forward(REFERER);
}
$table_purchase_info = elgg_get_config('dbprefix')."events_purchase_info";
$table_purchase_userinfo = elgg_get_config('dbprefix')."events_purchase_userinfo";
$info['group_guid'] = $sponser_guid;
$purchase_guid = saveArray($table_purchase_info,$info,$purchase_guid,false);
$userinfo['purchase_guid'] = $purchase_guid;
$delete = delete_data("delete from $table_purchase_userinfo where purchase_guid=".$purchase_guid);
	

$index = 0;
$n = 0;
$data = array();
for($i = 0; $i<count($fields); $i++){
	$field1 = $fields[$i];
	$guid_id = $guids[$i];
	$formvalue = get_input($field1.'_'.$n);	
	$value = implode(",", $formvalue);
	if($value){
		$formvalue = $value;
	}
	$userinfo['form_guid'] = $guid_id;
	$userinfo['value'] = $formvalue;
	saveArray($table_purchase_userinfo,$userinfo,0);
}

system_message(elgg_echo("event:save:success"));
forward("event/purchaseinfo/{$eventid}/".elgg_get_friendly_title($event->title));
exit;
?>