<?php
/**
 * Event sidebar
 *
 * @package event
 *
 */
$guid =  (int)$vars['entity']->guid;
$event = get_entity($guid);
$event_metadata = $vars['event_metadata']; 
if(!$event_metadata){
	$event_metadata = get_events("guid=$guid");
}
if(!event_closed($event_metadata[0])){
	$sidebar = elgg_view('event/sidebar/ticket', $vars);
}else{
	$sidebar = elgg_view('event/sidebar/event_closed', array('entity' => $event));
}

$sidebar .= elgg_view('event/sidebar/pastevent', array('entity' => $event));
$sidebar .= elgg_view('event/sidebar/sponsers', array('entity' => $event));
$sidebar .= elgg_view('event/sidebar/members', array('entity' => $event));
$sidebar .= elgg_view('event/sidebar/update', array('entity' => $event));
echo $sidebar .= elgg_view('event/sidebar/gmap', array('entity' => $event));