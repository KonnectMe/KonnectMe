<?php
/**
* Export
*
* @package Event
*/
elgg_load_library('elgg:event');
$eventid = get_input('guid');

if($eventid) {
	system_message(elgg_echo('event:export:success'));
}else {
	register_error(elgg_echo('event:export:failed'));
}
forward(REFERER);