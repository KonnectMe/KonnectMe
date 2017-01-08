<?php
/**
 * Elgg messageboard widget view
 *
 */
elgg_load_library('elgg:event');
$owner = elgg_get_page_owner_entity();
$ownerguid = $owner->guid;
$num = $vars['entity']->num_display;

$events = event_partcipating_list($ownerguid, array('pagination' => false, 'limit' => $num));
if($events){
	echo $events;
} else {
	echo elgg_echo('event:noevent');
}	