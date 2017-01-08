<?php
/**
* Elgg event  custom form
*
* @package Event
*/

elgg_load_library('elgg:event');
$eventid = get_input('eventid');
$table = elgg_get_config('dbprefix')."events_customforms"; 

if($eventid) {
	$label = get_input('label');
	$type = get_input('type');
	$values = get_input('values');
	$required = get_input('required');
	$forms['event_guid'] = $eventid;	 
	for($i = 0; $i < count($label);$i++) {
		if($label[$i]){
			$isrequired = 1; 
			if($required[$i] == 1) {
				$isrequired = 0; 
			} 
			$forms['title'] = $label[$i];
			$forms['type'] = $type[$i];
			$forms['default_values'] = $values[$i];
			$forms['required'] = $isrequired;
			$forms['item_order'] = 0;
			$form_guid = saveArray($table,$forms,0); 
		}
	}
	system_message(elgg_echo('event:save:success'));
	forward("event/registration/".$eventid);
} else {
	system_message(elgg_echo('event:save:failed'));
	forward("event/registration/".$eventid);	 
}