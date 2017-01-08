<?php
$default = ini_get('max_execution_time');
set_time_limit(100000000);

elgg_load_library('elgg:event');
$eventguid = (int) get_input('eventid');
$groupguid = (int) get_input('groupid');
$event = get_entity($eventguid);
$filed_name = array();
$filed_array = array();
$filed_guid = array();
$excelname = $event->title;

$form_table = elgg_get_config('dbprefix')."events_customforms";
$event_form = get_data("select *from $form_table where event_guid=$eventguid and type!=10 order by item_order");
foreach($event_form as $form){
	$column = $form->title;	
	$fieldname = event_replace_string($column);
	$filed_name[$form->id] = $column;
}	

										

$html='';
$contents .= implode(" \t " ,$filed_name)." \t ticket \t sponser \t date \n ";

$were = "";
if($groupguid){
	$were = " and p.group_guid=$groupguid ";
}

$purchase_table = elgg_get_config('dbprefix')."events_purchase_info";
$groups_table = elgg_get_config('dbprefix')."groups_entity";
$ticket_table = elgg_get_config('dbprefix')."events_tickets";

$purchased_tickets = get_data("select p.*,g.name,t.title as ticket_name from $purchase_table p, $groups_table g, $ticket_table t 
where g.guid=p.group_guid and t.id=p.ticket_guid and p.event_guid=$eventguid and p.status = 1 $were order by time_created");

$userinfo_table = elgg_get_config('dbprefix')."events_purchase_userinfo";
$user_data = array();
	
foreach($purchased_tickets as $purchased_ticket){
	$purchased_id = (int) $purchased_ticket->id;
	$userinfo = get_data("select *from $userinfo_table where purchase_guid=$purchased_id");
	foreach($userinfo as $info){
		$user_data[$info->form_guid] = $info->value;
	}
	$values = array();
	foreach($filed_name as $key=>$value){
		$values[] = $user_data[$key];
	}
	$sopnser = $purchased_ticket->name;
	$ticket = $purchased_ticket->ticket_name;
	$date = date('d-m-Y',$purchased_ticket->time_created);
	$contents .= implode(" \t " ,$values)." \t ".$ticket." \t ".$sopnser." \t ".$date."  \n ";
}
$filename = $excelname.".xls";
header('Content-type: application/ms-excel');
header('Content-Disposition: attachment; filename='.$filename);
echo $contents;