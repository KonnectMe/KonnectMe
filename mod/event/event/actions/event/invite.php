<?php
/**
* Elgg event  save invitation
*
* @package Event
*/
elgg_load_library('elgg:event');
$groupguid = get_input('group');

$fee = get_input('fee');
$revenue = get_input('revenue');
$eventguid = get_input('eventid');
$event = get_entity($eventguid);
if($fee){
	$event->invite_fee = $fee;
	$event->save();
}
$invited = false;
if($eventguid && $groupguid){
	for($i=0; $i<count($groupguid); $i++){
		//Creates a relatiionship called "event_invite" between event and group
		if(event_invite($groupguid[$i], $eventguid,  $revenue)){		
			$invited = true;
		}		
	}
	if($invited){
		system_message(elgg_echo('event:invite:success'));
	}else{
		register_error(elgg_echo('event:invite:failed'));
	}
	forward("event/invite/".$eventguid);
} else {
	register_error(elgg_echo('event:invite:failed'));
	forward(REFERER);	
}
?>