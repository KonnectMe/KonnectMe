<?php
error_reporting(0);
$default = ini_get('max_execution_time');
set_time_limit(100000000);
elgg_load_library('elgg:event');
global $CONFIG;
$guid_one = (int)get_input('event_one');
$guid_two = (int)get_input('event_two');
if($guid_one == $guid_two){
	forward(REFERER);
	return;
}
function event_compare($guid_one, $guid_two){
	$table = elgg_get_config('dbprefix').'events_purchase_info';
	$sql= "SELECT distinct user_guid from $table WHERE event_guid=$guid_one and user_guid not in (select  user_guid from $table where event_guid=$guid_two )";
	$data = get_data($sql);
	return $data;
	
}
$users = event_compare($guid_one, $guid_two);

$form_table = elgg_get_config('dbprefix')."events_customforms";
$event_form = get_data("select *from $form_table where event_guid=$guid_one and type!=10 order by item_order");
foreach($event_form as $form){
	$column = $form->title;	
	$fieldname = event_replace_string($column);
	$filed_name[$form->id] = $column;
}	

$purchase_table = elgg_get_config('dbprefix')."events_purchase_info";
$groups_table = elgg_get_config('dbprefix')."groups_entity";
$ticket_table = elgg_get_config('dbprefix')."events_tickets";
$userinfo_table = elgg_get_config('dbprefix')."events_purchase_userinfo";
$user_data = array();

$html='';
$contents = implode(" \t " ,$filed_name)." \t ticket \t sponser  \n ";

foreach($users as $user){
	$user_guid = (int)$user->user_guid;
	$purchased = get_data("select p.*,g.name,t.title as ticket_name from $purchase_table p, $groups_table g, $ticket_table t 
where g.guid=p.group_guid and t.id=p.ticket_guid and p.event_guid=$guid_one and p.user_guid = $user_guid  and p.status = 1 order by time_created limit 1");

	$purchased_id = (int)$purchased[0]->id;
	$userinfo = get_data("select *from $userinfo_table where purchase_guid=$purchased_id");
	foreach($userinfo as $info){
		$user_data[$info->form_guid] = $info->value;
	}
	$values = array();
	foreach($filed_name as $key=>$value){
		$values[] = $user_data[$key];
	}
						
	$sopnser = $purchased[0]->name;
	$ticket = $purchased[0]->ticket_name;
	$contents .= implode(" \t " ,$values)." \t ".$ticket." \t ".$sopnser."  \n ";
}

$filename = "event_diff_report.xls";
header('Content-type: application/ms-excel');
header('Content-Disposition: attachment; filename='.$filename);
echo $contents;

?>


