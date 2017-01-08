<?php
elgg_load_library('elgg:event');


$offset = (int) get_input('offset');
$limit =  10;
$eventid = (int) get_input('eventid');
$event = get_entity($eventid);
$event_metadata = get_events("guid=$eventid");
elgg_set_page_owner_guid($event->owner_guid);	
if($event){
	elgg_push_breadcrumb($event->title,'event/view/'.$event->guid.'/'.elgg_get_friendly_title($event->title));
	elgg_push_breadcrumb(elgg_echo('event:sponser'));
	$count = event_count_relation($event->guid, 'event_sponser');
	$sponsers = event_get_sponsers($event->guid, false, false, $offset, $limit);
	$content = elgg_view('event/sponser', array('sponsers' => $sponsers, 'offset' => $offset, 'limit' => $limit, 'count' => $count));
}else{
	$content = elgg_echo('event:noevent');
}

$title = elgg_echo('event:nppartners');

$sidebar = elgg_view('event/sidebar/sidebar', array('entity' => $event,'event_metadata'=>$event_metadata));

$body = elgg_view_layout('content', array(
	'filter_override' => false,
	'filter_context' => 'all',
	'sidebar' => $sidebar,
	'content' => $content,
	'title' => $title,
));

echo elgg_view_page($title, $body);
?>
