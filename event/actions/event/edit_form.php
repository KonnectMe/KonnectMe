<?php
/**
* Edit event registration form
*
* @package Event
*/

gatekeeper();
elgg_load_library('elgg:event');
$eventid = get_input('eventid');
$guid = get_input('guid');
$label = get_input('label');
$type = get_input('type');
$values = get_input('values');
$required = get_input('required');
$event = get_entity($eventid);
$table = elgg_get_config('dbprefix')."events_customforms"; 
if ($event->canEdit() && $guid) {
	$forms['title'] = $label;
	$forms['type'] = $type;
	$forms['default_values'] = $values;
	$forms['required'] = $required;
	$form_guid = saveArray($table,$forms,$guid, false); 
	system_message(elgg_echo('event:save:success'));
	forward("event/registration/".$eventid);
}else{
	system_message(elgg_echo('event:save:failed'));
	forward(REFERRER);
} 