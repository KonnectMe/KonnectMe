<?php
$eventid = (int) get_input('eventid');
$event_metadata = get_events("guid=$eventid");
$event = get_entity($eventid);
elgg_set_page_owner_guid($event->owner_guid);
if (!elgg_instanceof($event, 'object', 'event')) {
	register_error(elgg_echo('event:unknown_event'));
	forward(REFERRER);
}
if($eventid){
	$event = get_entity($eventid);
	elgg_push_breadcrumb($event->title,'event/view/'.$event->guid.'/'.elgg_get_friendly_title($event->title));
	event_sidebar_navigation($event);
	$sponsers = event_get_sponsers($event->guid, false, false, 0, 0);
	$content = elgg_view('event/dashboard', array('sponsers' => $sponsers));
}else{
	$content = elgg_echo('event:noevent');
}

$title = elgg_echo('event:dashboard:title', array($event->title));
elgg_push_breadcrumb($title);
$sidebar = elgg_view('event/sidebar/sidebar', array('entity' => $event,'event_metadata'=>$event_metadata));

$body = elgg_view_layout('content', array(
	'filter' => '',
	'filter_context' => 'all',
	'sidebar' => $sidebar,
	'content' => $content,
	'title' => $title,
));

echo elgg_view_page($title, $body);