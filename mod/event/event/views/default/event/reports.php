<?php
/**
 * package event
 */

$eventid = (int) get_input('eventid');
if(!$eventid){
	return;
}
$event = get_entity($eventid);
$user_guid = $event->owner_guid;
echo elgg_view_module('info','Report for this event', elgg_view('output/url',array('text'=>'Generate report','href'=> elgg_get_site_url() . "event/export/{$eventid}")));
$events = elgg_get_entities(array(
	'type' => 'object',
	'subtype' => 'event',
	'limit' => 0,
	"owner_guid"=>$user->guid,
));
if($events){
	$eventArray = array();
	foreach($events as $e){
		$eventArray[$e->guid] = $e->title;
	}
	echo elgg_view_module('info','Event difference report', elgg_view_form('event/event_diff',array('action'=>elgg_get_site_url() . "event/event_diff"), array('events'=>$eventArray)));
	
	echo elgg_view_module('info','Event common report', elgg_view_form('event/event_common',array('action'=>elgg_get_site_url() . "event/event_common"), array('events'=>$eventArray)));
}
?>