<?php
echo "Processing...........";

$cause_table = elgg_get_config('dbprefix')."causes";
$cause_amount_table = elgg_get_config('dbprefix')."causes_amount_structure";

//print_r($vars);
$counter = $vars['counter'];
$offset = $counter*10;
$limit = 10;
$param = array(
			'type' => 'object',
			'subtype' => 'causes',
			'limit' => $limit,
			'offset' => $offset,
			);
$causes = elgg_get_entities($param);
if(!$causes){
	echo "Over";
	return;
}
foreach($causes as $cause){
	$guid = $cause->guid;
	$cause_array['category'] = $cause->category;
	$cause_array['title'] = $cause->title;
	
	$relationship = 'causes_event_supported';
	$events = elgg_get_entities_from_relationship(array(
			'relationship' => $relationship,
			'relationship_guid' => $guid,
			'inverse_relationship' => false,
			'limit' => 0,
		));
	$event_guid = (int)$events[0]->guid;
	
	$relationship = 'causes_supported';
	$groups = elgg_get_entities_from_relationship(array(
			'relationship' => $relationship,
			'relationship_guid' => $guid,
			'inverse_relationship' => false,
			'limit' => 0,
		));
	$group_guid = (int)$groups[0]->guid;
	$cause_array['group_guid'] = $group_guid;
	$cause_array['event_guid'] = $event_guid;
	$cause_array['description'] = $cause->description;
	$cause_array['brief_description'] = $cause->brief_description;
	$cause_array['campaign_end_date'] = (int)strtotime($cause->enddate);
	$cause_array['access_id'] = (int)$cause->access_id;
	$cause_array['location'] = $cause->location;
	$cause_array['goal'] = (int)$cause->target;
	$cause_array['icon_time'] = (int)$cause->icontime ;
	$cause_array['time_created'] = $cause->time_created ;
	$cause_array['owner_guid'] = $cause->owner_guid ;
	$cause_array['guid'] = $cause->guid ;
	//save event
	$data = get_data("select guid from $cause_table where guid=".$cause->guid);
	if(!$data){
		$cause_id = saveArray($cause_table,$cause_array,0);
	}
	//print_r($cause_array);
	//echo $cause->amount;
	$amount = explode("|",$cause->amount);
	//print_r($amount);
	$amount_description = explode("|",$cause->amount_description);
	$amount_array['cause_guid'] = $guid;
	for($i=0;$i<count($amount);$i++){
		$amount_array['amount'] = (int)$amount[$i];
		$amount_array['description'] = $amount_description[$i];
		if($amount_array['amount']){
			$causes_id = saveArray($cause_amount_table,$amount_array,0);	
		}
	}

	
	

}

$next = $counter+1;
?>
<meta http-equiv="refresh" content="0;url=?counter=<?php echo $next; ?>&type=2" />
